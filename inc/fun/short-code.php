<?php
/* 短程式碼 */
$shortCodeColors = array('primary', 'danger', 'warning', 'info', 'success', 'dark');

function pk_shortcode_register()
{
    global $shortCodeColors;
    $list = array(
        'music' => array('name' => '音樂播放', 'content' => '輸入連結地址'),
        'pre' => array('name' => '程式碼嵌入', 'content' => '輸入程式碼'),
        'reply' => array('name' => '回覆可見', 'content' => '輸入內容'),
        'login' => array('name' => '登入可見', 'content' => '輸入內容'),
        'github' => array('name' => 'Github 倉庫卡片', 'content' => 'Licoy/wordpress-theme-puock'),
        'login_email' => array('name' => '登入並驗證 E-mail 可見', 'content' => '輸入內容'),
        'video' => array('name' => '視訊播放', 'attr' => array(
            'url'=>'example.com/test.mp4',
            'autoplay' => false, 'type' => 'auto',
            'pic' => '', 'class' => ''
        )),
        'download' => array('name' => '檔案下載', 'content' => '檔案地址', 'attr' => array(
            'file' => 'xxx.zip', 'size' => '12MB'
        )),
        'password' => array('name' => '輸入密碼可見', 'content' => '輸入內容', 'attr' => array(
            'pass' => '123456', 'desc' => '輸入密碼可見',
        )),
        'collapse' => array('name' => '摺疊面板', 'content' => '輸入內容', 'attr' => array(
            'title' => 'title'
        )),
    );
    foreach ($shortCodeColors as $sc_tips) {
        $list['t-' . $sc_tips] = array(
            'name' => '提示框' . $sc_tips,
            'attr' => array(
                'icon' => ''
            ),
            'content' => '輸入內容'
        );
    }
    return $list;
}
// 解析 pre 標籤 感謝阿雲。小恐龍太好拉注。
function pk_pre($atts, $content = null) {
    $content = '<pre>' . htmlspecialchars($content) . '</pre>';
    return $content;
}
add_shortcode('pre', 'pk_pre');

//提示框部分
function sc_tips($attr, $content, $tag)
{
    $type = str_replace('t-', '', $tag);
    extract(shortcode_atts(array(
        'icon' => '',
        'outline' => false,
        'class' => ''
    ), $attr));
    $_class =  'alert alert-' . $type;
    if (!empty($icon)) {
        $content = "<i class=\"{$icon} mr-1\"></i>" . $content;
    }
    if ($outline) {
        $_class .= ' alert-outline';
    }
    if($class){
        $_class .= ' '.$class;
    }
    return "<div class=\"{$_class}\">{$content}</div>";
}

foreach ($shortCodeColors as $sc_tips) {
    add_shortcode('t-' . $sc_tips, 'sc_tips');
}
//按鈕部分
function sc_btn($attr, $content, $tag)
{
    $type = str_replace('btn-', '', $tag);
    $href = $attr['href'] ?? "javascript:void(0)";
    if (pk_is_cur_site($href)) {
        return '<a href="' . $href . '" class="btn btn-sm sc-btn btn-' . $type . '">' . $content . '</a>';
    }
    return '<a target="_blank" rel="nofollow" href="' . pk_go_link($href) . '" class="btn btn-sm sc-btn btn-' . $type . '">' . $content . '</a>';
}

foreach (array_merge($shortCodeColors, array('link')) as $sc_btn) {
    add_shortcode('btn-' . $sc_btn, 'sc_btn');
}

//視訊
function pk_sc_video($attr, $content = null)
{
    extract(shortcode_atts(array(
        'url' => '', 'href' => '',
        'autoplay' => false, 'type' => 'auto',
        'pic' => '', 'class' => '',
        'ssl'=>false,
    ), $attr));
    if (empty($url) && empty($href)) {
        return sc_tips(array('outline'=>true), '<span class="c-sub fs14">視訊警告：播放連結不能為空</span>', 't-warning');
    }
    if (empty($url)) {
        $url = $href;
    }
    if(strpos($url, 'http://') === false && strpos($url, 'https://') === false){
        $url = ($ssl ? 'https://' : 'http://') . $url;
    }
    $auto = ($autoplay === 'true') ? 'true' : 'false';
    if (pk_is_checked('dplayer')) {
        $id = mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9);
        $out = "<div id='dplayer-{$id}' class='{$class}'></div>";
        $out .= "<script>jQuery(function() {
            new DPlayer({
                container: document.getElementById('dplayer-{$id}'),
                autoplay: {$auto},
                video: {
                    url: '{$url}',
                    type: '{$type}'
                },
            });
})</script>";
        return $out;
    } else {
        $autoplay = $auto == 'true' ? 'autoplay' : '';
        return "<video $autoplay src=\"$url\" controls></video>";
    }
}
add_shortcode('video', 'pk_sc_video');
add_shortcode('videos', 'pk_sc_video');

//解析音訊連結
function pk_music($attr, $content = null)
{
    if (empty($content)) {
        return sc_tips(array('outline' => true), '<span class="c-sub fs14">音訊警告：播放連結不能為空</span>', 't-warning');
    }
    return '<div class="text-center"><audio class="mt-2" src="' . trim($content) . '" controls></audio></div>';
}

add_shortcode('music', 'pk_music');
//下載
function pk_download($attr, $content = null)
{
    $filename = isset($attr['file']) ? $attr['file'] : '';
    $size = isset($attr['size']) ? $attr['size'] : '';
    $down_tips = pk_get_option('down_tips');
    return "<div class=\"p-block p-down-box\">
        <div class='mb15'><i class='fa fa-file-zipper'></i>&nbsp;<span>檔案名稱：$filename</span></div>
        <div class='mb15'><i class='fa fa-download'></i>&nbsp;<span>檔案大小：$size</span></div>
        <div class='mb15'><i class='fa-regular fa-bell'></i>&nbsp;<span>下載聲明：$down_tips</span></div>
        <div><i class='fa fa-link'></i><span>下載地址：$content</span></div>
    </div>";
}

add_shortcode('download', 'pk_download');
add_shortcode('dltable', 'pk_download');
//回覆可見
function pk_reply_read($attr, $content = null)
{
    global $wpdb;
    $email = null;
    $user_id = (int)wp_get_current_user()->ID;
    $msg = sc_tips(array('outline' => true), "<span class='c-sub fs14'><i class='fa-regular fa-eye'></i>&nbsp;此處含有隱藏內容，請提交評論並審核通過重新整理後即可檢視！</span>", 't-primary');
    if ($user_id > 0) {
        $email = get_userdata($user_id)->user_email;
        if ($email == get_bloginfo('admin_email')) {
            return do_shortcode($content);
        }
    } else {
        if (isset($_COOKIE['comment_author_email_' . COOKIEHASH])) {
            $email = $_COOKIE['comment_author_email_' . COOKIEHASH];
        }
    }
    if (empty($email)) {
        return $msg;
    }
    $post_id = get_the_ID();
    $query = "SELECT count(comment_ID) as c FROM {$wpdb->comments} WHERE comment_post_ID={$post_id} 
                and comment_approved='1' and comment_author_email='{$email}' LIMIT 1";
    if ($wpdb->get_row($query)->c > 0) {
        return do_shortcode($content);
    }
    return $msg;
}

add_shortcode('reply', 'pk_reply_read');
//登入可見
function pk_login_read($attr, $content = null)
{
    $msg = sc_tips(array('outline' => true), "<span class='c-sub fs14'><i class='fa-regular fa-eye'></i>&nbsp;此處含有隱藏內容，登入後即可檢視！</span>", 't-primary');
    return is_user_logged_in() ? do_shortcode($content) : $msg;
}

add_shortcode('login', 'pk_login_read');
//登入並驗證 E-mail 可見
function pk_login_email_read($attr, $content = null)
{
    if (is_user_logged_in()) {
        $user_id = (int)wp_get_current_user()->ID;
        if ($user_id > 0) {
            $email = get_userdata($user_id)->user_email;
            if (!empty($email) && !pk_check_email_is_sysgen($email)) {
                return do_shortcode($content);
            }
        }
    }
    return sc_tips(array('outline' => true), "<span class='c-sub fs14'><i class='fa-regular fa-eye'></i>&nbsp;此處含有隱藏內容，需要登入並驗證 E-mail 後即可檢視！</span>", 't-primary');
}

add_shortcode('login_email', 'pk_login_email_read');
//加密內容
function pk_password_read($attr, $content = null)
{
    global $wpdb;
    $email = null;
    $user_id = (int)wp_get_current_user()->ID;
    if ($user_id > 0) {
        $email = get_userdata($user_id)->user_email;
        if ($email == get_bloginfo('admin_email')) {
            return $content;
        }
    }
    extract(shortcode_atts(array(
        'pass' => null,
        'desc' => null,
    ), $attr));
    $out = '';
    $error = '';
    if (empty(trim($desc ?? ''))) {
        $desc = "此處含有隱藏內容，需要正確輸入密碼後可見！";
    }
    $info = "<p class='fs14 c-sub'><i class='fa-regular fa-eye'></i>&nbsp;{$desc}</p>";
    if (isset($_REQUEST['pass'])) {
        if ($_REQUEST['pass'] == $pass) {
            return do_shortcode($content);
        } else {
            $info .= "<p class='fs14 text-danger'><i class='fa-solid fa-triangle-exclamation'></i>&nbsp;您的密碼輸入錯誤，請核對後重新輸入</p>";
        }
    }
    $out .= "<div class='alert alert-primary alert-outline'>{$info}"
        . "$error<form action=\"" . get_permalink() . "\" method=\"post\"><div class=\"row\"><div class=\"col-8 col-md-10\">"
        . "<input type=\"password\" placeholder=\"請輸入密碼\" required class=\"form-control form-control-sm\" name=\"pass\"/>"
        . "</div><div class=\"col-4 col-md-2 pl-0\"><button class=\"btn btn-sm btn-primary w-100\">立即檢視</button></div></div></form>"
        . "</div>";
    return $out;
}

add_shortcode('password', 'pk_password_read');
//隱藏收縮
function pk_sc_collapse($attr, $content = null)
{
    $index = @$GLOBALS['collapse-' . get_the_ID()];
    if (empty($index)) {
        $index = 1;
        $GLOBALS['collapse-' . get_the_ID()] = 1;
    } else {
        $index++;
        $GLOBALS['collapse-' . get_the_ID()] += 1;
    }
    $scId = "collapse-" . get_the_ID() . '-' . $index;
    extract(shortcode_atts(array(
        'title' => null,
    ), $attr));
    $out = '<div class="pk-sc-collapse"><a class="btn btn-primary btn-sm" data-bs-toggle="collapse" href="#' . $scId . '" role="button"
        aria-expanded="false" aria-controls="' . $scId . '"><i class="fa fa-angle-up"></i>&nbsp;' . $title . '</a></div>';
    $out .= '<div class="collapse" id="' . $scId . '">' . $content . '</div>';
    return $out;
}

add_shortcode('collapse', 'pk_sc_collapse');

//github 專案展示
function pk_sc_github($attr, $content = null)
{
    return '<div class="github-card text-center" data-repo="' . $content . '"><div class="spinner-grow text-primary"></div></div>';
}

add_shortcode('github', 'pk_sc_github');


function p_wpautop($content)
{
    return wpautop($content, true);
}

//TODO 新增到後臺配置
remove_filter('the_content', 'wpautop');
add_filter('the_content', 'p_wpautop', 11);
