<?php
/*
Template Name: AI 助手
*/
wp_enqueue_script('puock-md', pk_get_static_url() . '/assets/libs/marked.js', ['puock-libs'], PUOCK_CUR_VER_STR, true);
wp_enqueue_script('puock-page-ai', pk_get_static_url() . '/assets/dist/js/page-ai.min.js', ['puock-md'], PUOCK_CUR_VER_STR, true);

get_header();

$gc_user_id = get_current_user_id();
if (!$gc_user_id) {
    $gc_user_id = 'null@null.com';
}
$gc_ai_avatar = pk_get_option('favicon');
$gc_ai_avatar = empty($gc_ai_avatar) ? get_avatar_url(1) : $gc_ai_avatar;
$gc_ai_chat_models = pk_get_option('ai_chat_models', []);
?>
<script>
    const aiMetaInfo = {
        userAvatar: '<?php echo get_avatar_url($gc_user_id) ?>',
        aiAvatar: '<?php echo $gc_ai_avatar ?>',
        url: '<?php echo pk_ajax_url('pk_ai_ask') ?>'
    }
</script>
<div id="page" class="container mt20">
    <div id="page-cg">
        <?php get_template_part('templates/box', 'global-top') ?>
        <?php echo pk_breadcrumbs();
        while (have_posts()):the_post(); ?>
            <div id="page-<?php the_ID() ?>" class="row row-cols-1">
                <div id="posts"
                     class="col-lg-<?php pk_hide_sidebar_out('12', '8') ?> col-md-12 <?php pk_open_box_animated('animated fadeInLeft') ?> ">
                    <?php if (!empty(get_the_content())): ?>
                        <div class="mt20 p-block puock-text <?php get_entry_content_class() ?>">
                            <?php the_content() ?>
                        </div>
                    <?php endif; ?>
                    <div class="mt20 p-block puock-text">
                        <div class="chats">
                            <?php if (!empty(pk_get_option('ai_chat_welcome'))): ?>
                                <div class="chat-item is-ai chat-template">
                                    <div class="row">
                                        <div class="col-auto">
                                            <img alt="ai_avatar" src="<?php echo $gc_ai_avatar ?>"
                                                 class="avatar md-avatar">
                                        </div>
                                        <div class="col">
                                            <div class="fs14 content-box"><?php echo pk_get_option('ai_chat_welcome') ?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mt-20 p-block puock-text">
                        <textarea class="form-control fs14 chat-input" rows="3"
                                  placeholder="請在此處描述您的問題"></textarea>
                        <div class="chat-btn-init d-flex justify-content-end mt10">
                            <div class="spinner-grow text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt10 d-none chat-btn-box">
                            <div class="d-flex align-items-center">
                                <select id="chat-model" class="form-control me-3">
                                    <?php if (is_array($gc_ai_chat_models)): foreach ($gc_ai_chat_models as $chat_val): if ($chat_val['enable']): ?>
                                        <option value="<?php echo $chat_val['name'] ?>"><?php echo $chat_val['alias'] ?? strtoupper($chat_val['name']) ?></option>
                                    <?php endif;endforeach; endif; ?>
                                </select>
                                <div class="form-check form-switch flex-shrink-0">
                                    <?php if (pk_is_checked('ai_draw_dall_e')): ?>
                                        <input class="form-check-input" name="remember" type="checkbox" role="switch"
                                               id="chat-use-img-mode">
                                        <label class="form-check-label fs14" for="chat-use-img-mode">AI 繪畫</label>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-primary btn-sm mr-2 chat-submit"><i
                                            class="fa-regular fa-paper-plane me-1"></i>立即提問
                                </button>
                                <button class="btn btn-dark btn-sm chat-clear-history"><i
                                            class="fa-solid fa-broom me-1"></i>清除畫面
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php get_sidebar() ?>
            </div>
        <?php endwhile; ?>
        <?php get_template_part('templates/box', 'global-bottom') ?>
    </div>
</div>

<?php get_footer() ?>
