<?php


/**
 * @throws Exception
 */
function pk_front_form_validate_code_check($type = '', $code = '')
{
    if (pk_get_option('vd_type', 'img') === 'img') {
        if (!pk_captcha_validate($type, $code)) {
            throw new Exception('驗證碼錯誤');
        }
    } else {
        pk_vd_gt_validate();
    }
}

function pk_front_login_exec()
{
    if (is_string($data = pk_get_req_data([
            'username' => ['name' => '使用者名稱', 'required' => true],
            'password' => ['name' => '密碼', 'required' => true],
            'vd' => ['name' => '驗證碼', 'required' => false],
            'remember' => ['name' => '記住我', 'required' => false],
        ])) === true) {
        echo pk_ajax_resp_error($data);
        wp_die();
    }
    try {
        pk_front_form_validate_code_check('login', $data['vd']);
    } catch (Exception $e) {
        echo pk_ajax_resp_error($e->getMessage());
        wp_die();
    }
    $try_open = pk_is_checked('quick_login_try_max_open');
    $try_num = $try_open ? pk_get_option('quick_login_try_max_num', 3) : 0;
    $try_ban_time = $try_open ? pk_get_option('quick_login_try_max_ban_time', 10) : 0;
    if ($try_open) {
        $ip = pk_get_client_ip();
        if (!empty(get_transient('pk_login_ban_' . $ip))) {
            echo pk_ajax_resp_error('登入失敗次數過多，請' . $try_ban_time . '分鐘後再試');
            wp_die();
        }
    }
    $user = wp_signon([
        'user_login' => $data['username'],
        'user_password' => $data['password'],
        'remember' => $data['remember'] === 'on',
    ], is_ssl());
    if ($user instanceof WP_User) {
        wp_set_auth_cookie($user->ID, true, is_ssl());
        echo pk_ajax_resp([
            'action' => 'reload',
        ], '登入成功');
    } else {
        if ($try_open) {
            $try = get_transient('pk_login_try_' . $ip) ?? 0;
            $try++;
            if ($try >= $try_num) {
                set_transient('pk_login_ban_' . $ip, 1, $try_ban_time * 60);
                echo pk_ajax_resp_error('登入失敗次數過多，請' . $try_ban_time . '分鐘後再試');
                wp_die();
            } else {
                set_transient('pk_login_try_' . $ip, $try, $try_ban_time * 60);
            }
        }
        echo pk_ajax_resp_error('帳號或密碼錯誤');
    }
    wp_die();
}


function pk_front_register_exec()
{
    if (is_string($data = pk_get_req_data([
            'username' => ['name' => '使用者名稱', 'required' => true],
            'email' => ['email' => 'E-mail', 'required' => true],
            'password' => ['name' => '密碼', 'required' => true],
            'vd' => ['name' => '驗證碼', 'required' => false],
        ])) === true) {
        echo pk_ajax_resp_error($data);
        wp_die();
    }
    if (strlen($data['username']) < 5 || strlen($data['username']) > 10) {
        echo pk_ajax_resp_error('使用者名稱不合法');
        wp_die();
    }
    if (strlen($data['password']) < 6 || strlen($data['password']) > 18) {
        echo pk_ajax_resp_error('密碼不合法');
        wp_die();
    }
    if (!is_email($data['email'])) {
        echo pk_ajax_resp_error('E-mail 不合法');
        wp_die();
    }
    try {
        pk_front_form_validate_code_check('register', $data['vd']);
    } catch (Exception $e) {
        echo pk_ajax_resp_error($e->getMessage());
        wp_die();
    }
    $user_id = wp_create_user($data['username'], $data['password'], $data['email']);
    if ($user_id instanceof WP_Error) {
        echo pk_ajax_resp_error($user_id->get_error_message());
    } else {
        wp_set_auth_cookie($user_id, true, is_ssl());
        echo pk_ajax_resp([
            'action' => 'reload',
        ], '註冊成功，已自動登入');
    }
    wp_die();
}

function pk_front_forget_password_exec()
{
    if (is_string($data = pk_get_req_data([
            'email' => ['email' => 'E-mail', 'required' => true],
            're-password' => ['email' => '重複密碼', 'required' => true],
            'password' => ['name' => '密碼', 'required' => true],
            'vd' => ['name' => '驗證碼', 'required' => false],
        ])) === true) {
        echo pk_ajax_resp_error($data);
        wp_die();
    }
    if (strlen($data['password']) < 6 || strlen($data['password']) > 18) {
        echo pk_ajax_resp_error('密碼不合法');
        wp_die();
    }
    if ($data['password'] !== $data['re-password']) {
        echo pk_ajax_resp_error('兩次密碼不一致');
        wp_die();
    }
    if (!is_email($data['email'])) {
        echo pk_ajax_resp_error('E-mail 不合法');
        wp_die();
    }
    try {
        pk_front_form_validate_code_check('forget-password', $data['vd']);
    } catch (Exception $e) {
        echo pk_ajax_resp_error($e->getMessage());
        wp_die();
    }
    $user = get_user_by('email', $data['email']);
    if (empty($user)) {
        echo pk_ajax_resp_error('不存在該 E-mail 的使用者');
        wp_die();
    }
    $code = md5($data['email'] . wp_generate_password(20, false));
    set_transient('pk_forget_password_' . $code, ['password' => $data['password'], 'email' => $data['email']], 60 * 5);
    $url = pk_ajax_url('pk_front_forget_password_reset_exec', [
        'code' => $code,
    ]);
    if (wp_mail($data['email'], '密碼重置 - ' . pk_get_web_title(), "您的密碼重置連結為：{$url}，請在 5 分鐘內點選連結重置密碼")) {
        echo pk_ajax_resp(null, '重置密碼連結已發送至 E-mail 信箱');
    } else {
        echo pk_ajax_resp_error('重置密碼連結 E-mail 發送失敗');
    }
    wp_die();
}

function pk_front_forget_password_reset_exec()
{
    $code = $_REQUEST['code'] ?? '';
    if (empty($code)) {
        pk_ajax_result_page(false, '密碼重置失敗：密碼重置連結無效');
    }
    $info = get_transient('pk_forget_password_' . $code);
    if (empty($info)) {
        pk_ajax_result_page(false, '密碼重置失敗：密碼重置連結無效');
    }
    $user = get_user_by('email', $info['email']);
    if (empty($user)) {
        pk_ajax_result_page(false, '密碼重置失敗：使用者不存在');
    }
    delete_transient('pk_forget_password_' . $code);
    wp_set_password($info['password'], $user->ID);
    pk_ajax_result_page(true, '密碼重置成功，請返回登入');
}


if (pk_is_checked('open_quick_login')) {
    if (!pk_is_checked('only_quick_oauth')) {
        pk_ajax_register('pk_front_login_exec', 'pk_front_login_exec', true);
        if (get_option('users_can_register') == 1) {
            pk_ajax_register('pk_front_register_exec', 'pk_front_register_exec', true);
        }
        if (pk_is_checked('quick_login_forget_password')) {
            pk_ajax_register('pk_front_forget_password_exec', 'pk_front_forget_password_exec', true);
            pk_ajax_register('pk_front_forget_password_reset_exec', 'pk_front_forget_password_reset_exec', true);
        }
    }
    pk_ajax_register('pk_font_login_page', 'pk_front_login_page_callback', true);
}


function pk_front_login_page_callback()
{
    $redirect = $_GET['redirect'] ?? get_edit_profile_url();
    $forget_password_url = pk_ajax_url('pk_font_login_page', ['redirect' => $redirect]);
    $open_register = get_option('users_can_register') == 1;
    $only_quick_oauth = pk_is_checked('only_quick_oauth');
    $validate_type = pk_get_option('vd_type', 'img');
    ?>
    <div class="min-width-modal">
        <?php
        if (!$only_quick_oauth):
            ?>

            <form id="front-login-form" action="<?php echo pk_ajax_url('pk_front_login_exec'); ?>" method="post"
                  class="ajax-form" data-validate="<?php echo $validate_type; ?>">
                <div class="mb15">
                    <label for="_front_login_username" class="form-label">使用者名稱 / E-mail</label>
                    <input type="text" name="username" class="form-control form-control-sm" id="_front_login_username"
                           data-required
                           placeholder="請輸入使用者名稱或 E-mail">
                </div>
                <div class="mb15">
                    <label for="_front_login_password" class="form-label">密碼</label>
                    <input type="password" name="password" class="form-control form-control-sm" data-required
                           id="_front_login_password"
                           placeholder="請輸入密碼">
                </div>
                <?php if ($validate_type === 'img'): ?>
                    <div class="mb15">
                        <label for="_front_login_vd" class="form-label">驗證碼</label>
                        <div class="row flex-row justify-content-end">
                            <div class="col-8 col-sm-7 text-end pl15">
                                <input type="text" data-required placeholder="請輸入驗證碼" maxlength="4"
                                       class="form-control form-control-sm t-sm captcha-input" name="vd"
                                       autocomplete="off"
                                       id="_front_login_vd">
                            </div>
                            <div class="col-4 col-sm-5 pr15">
                                <img class="captcha lazy" data-src="<?php echo pk_captcha_url('login', 100, 28) ?>"
                                     alt="驗證碼">
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="mb15 form-check form-switch">
                    <input class="form-check-input" name="remember" type="checkbox" role="switch"
                           id="front-login-remember-me">
                    <label class="form-check-label" for="front-login-remember-me"> 記住我</label>
                </div>
                <div class="mb15 d-flex justify-content-center wh100">
                    <button class="btn btn-ssm btn-primary mr5" type="submit"><i class="fa fa-right-to-bracket"></i>
                        立即登入
                    </button>
                </div>
                <div class="mb15 d-flex justify-content-between align-content-center fs12">
                    <?php if ($open_register): ?>
                        <a class="c-sub t-hover-primary toggle-el-show-hide" data-target="#front-register-form"
                           data-modal-title="註冊"
                           data-self="#front-login-form" href="javascript:void(0)">還沒有帳號？立即註冊</a>
                    <?php endif; ?>
                    <?php if (pk_is_checked('quick_login_forget_password')): ?>
                        <a class="c-sub t-hover-primary toggle-el-show-hide" data-target="#front-forget-password-form"
                           data-modal-title="找回密碼"
                           data-self="#front-login-form" href="javascript:void(0)">忘記密碼？立即找回密碼</a>
                    <?php endif; ?>
                </div>
            </form>

            <?php if ($open_register): ?>
            <form id="front-register-form" action="<?php echo pk_ajax_url('pk_front_register_exec'); ?>" method="post"
                  class="d-none ajax-form" data-validate="<?php echo $validate_type; ?>">
                <div class="mb15">
                    <label for="_front_register_username" class="form-label">使用者名稱</label>
                    <input type="text" name="username" class="form-control form-control-sm" data-required
                           id="_front_register_username" placeholder="請輸入最少 5～10 位字元的使用者名稱">
                </div>
                <div class="mb15">
                    <label for="_front_register_email" class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control form-control-sm" data-required
                           id="_front_register_email" placeholder="請輸入 E-mail">
                </div>
                <div class="mb15">
                    <label for="_front_register_password" class="form-label">密碼</label>
                    <input type="password" name="password" class="form-control form-control-sm" data-required
                           id="_front_register_password" placeholder="請輸入 6～18 位字元的密碼">
                </div>
                <?php if ($validate_type === 'img'): ?>
                    <div class="mb15">
                        <label for="_front_register_vd" class="form-label">驗證碼</label>
                        <div class="row flex-row justify-content-end">
                            <div class="col-8 col-sm-7 text-end pl15">
                                <input type="text" data-required placeholder="請輸入驗證碼" maxlength="4"
                                       class="form-control form-control-sm t-sm" name="vd"
                                       autocomplete="off"
                                       id="_front_register_vd">
                            </div>
                            <div class="col-4 col-sm-5 pr15">
                                <img class="captcha lazy"
                                     data-src="<?php echo pk_captcha_url('register', 100, 28) ?>"
                                     alt="驗證碼">
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="mb15 d-flex justify-content-center wh100">
                    <button class="btn btn-ssm btn-primary mr5" type="submit"><i class="fa fa-right-to-bracket"></i>
                        立即註冊
                    </button>
                </div>
                <div class="mb15 d-flex justify-content-end fs12">
                    <a class="c-sub t-hover-primary toggle-el-show-hide" href="javascript:void(0)"
                       data-self="#front-register-form" data-target="#front-login-form"
                       data-modal-title="登入">已有帳號？立即登入</a>
                </div>
            </form>
        <?php endif; ?>
            <?php if (pk_is_checked('quick_login_forget_password')): ?>
            <form id="front-forget-password-form" action="<?php echo pk_ajax_url('pk_front_forget_password_exec'); ?>"
                  method="post" class="d-none ajax-form" data-validate="<?php echo $validate_type; ?>">
                <div class="mb15">
                    <label for="_front_forget_password_email" class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control form-control-sm" data-required
                           id="_front_forget_password_email" placeholder="請輸入 E-mail">
                </div>
                <div class="mb15">
                    <label for="_front_forget_password_password" class="form-label">新密碼</label>
                    <input type="password" name="password" class="form-control form-control-sm" data-required
                           id="_front_forget_password_password" placeholder="請輸入 6～18 位字元的新密碼">
                </div>
                <div class="mb15">
                    <label for="_front_forget_password_password_re" class="form-label">重複新密碼</label>
                    <input type="password" name="re-password" class="form-control form-control-sm" data-required
                           id="_front_forget_password_password_re" placeholder="請重複輸入 6～18 位字元的新密碼">
                </div>
                <?php if ($validate_type === 'img'): ?>
                    <div class="mb15">
                        <label for="_front_forget_password_vd" class="form-label">驗證碼</label>
                        <div class="row flex-row justify-content-end">
                            <div class="col-8 col-sm-7 text-end pl15">
                                <input type="text" data-required placeholder="請輸入驗證碼" maxlength="4"
                                       class="form-control form-control-sm t-sm" name="vd"
                                       autocomplete="off"
                                       id="_front_forget_password_vd">
                            </div>
                            <div class="col-4 col-sm-5 pr15">
                                <img class="captcha lazy"
                                     data-src="<?php echo pk_captcha_url('forget-password', 100, 28) ?>"
                                     alt="驗證碼">
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="mb15 d-flex justify-content-center wh100">
                    <button class="btn btn-ssm btn-primary mr5" type="submit"><i class="fa fa-paper-plane"></i> 發送 E-mail
                    </button>
                </div>
                <div class="mb15 d-flex justify-content-end fs12">
                    <a class="c-sub t-hover-primary toggle-el-show-hide" href="javascript:void(0)"
                       data-self="#front-forget-password-form" data-target="#front-login-form"
                       data-modal-title="登入">想起密碼？立即登入</a>
                </div>
            </form>
        <?php endif;endif; ?>

        <div class="mb15">
            <p class="c-sub text-center fs12 t-separator">第三方登入</p>
            <?php pk_oauth_quick_buttons(true, $redirect) ?>
        </div>

    </div>
    <?php

    wp_die();
}
