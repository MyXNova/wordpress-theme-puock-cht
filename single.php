<?php get_header() ?>

<?php while (have_posts()) : the_post(); ?>
    <div id="post" class="container mt20">
        <?php get_template_part('templates/box', 'global-top') ?>
        <?php echo pk_breadcrumbs() ?>
        <?php get_template_part('ad/page', 'top') ?>
        <div class="row row-cols-1 post-row">
            <div id="post-main"
                 class="col-lg-<?php pk_hide_sidebar_out('12', '8') ?> col-md-12 <?php pk_open_box_animated('animated fadeInLeft') ?> ">
                <div class="p-block">
                    <div><h1 id="post-title" class="mb-0 puock-text t-xxl"><?php the_title() ?></h1></div>
                    <div class="options p-flex-sbc mt20">
                        <div>
                            <?php if (!pk_is_checked('hide_post_views')): ?>
                                <div class="option puock-bg ta3 t-sm mr-1"><i
                                            class="fa-regular fa-eye mr-1"></i>
                                    <span id="post-views"><?php pk_get_post_views(); ?></span><span><?php _e('&nbsp;次閱讀', PUOCK) ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if (!pk_post_comment_is_closed()): ?>
                                <a href="#comments">
                                    <div class="option puock-bg ta3 t-sm mr-1"><i
                                                class="fa-regular fa-comment mr-1"></i><?php comments_number() ?></div>
                                </a>
                            <?php endif; ?>
                            <?php if (is_user_logged_in() && current_user_can('edit_post', $post->ID)): ?>
                                <a target="_blank" href="<?php echo get_edit_post_link() ?>">
                                    <div class="option puock-bg ta3 t-sm mr-1"><i
                                                class="fa-regular fa-pen-to-square mr-1"></i><?php _e('編輯', PUOCK) ?>
                                    </div>
                                </a>
                            <?php endif; ?>
                        </div>
                        <?php if (!pk_is_checked("hide_global_sidebar")): ?>
                            <div>
                                <div class="option puock-bg ta3 t-sm mr-1 d-none d-lg-inline-block post-main-size">
                                    <i class="fa fa-up-right-and-down-left-from-center"></i></div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="mt20 entry-content-box">
                        <div class="<?php get_entry_content_class() ?> content-main puock-text <?php pk_checked_out('post_content_indent', 'p-indent') ?>">
                            <?php if (pk_is_checked('post_read_time')): ?>
                                <p class="fs12 c-sub no-indent">
                                    <i class="fa-regular fa-clock"></i>
                                    <?php echo pk_read_time_tip() ?>
                                </p>
                            <?php endif; ?>
                            <?php the_content(); ?>
                            <?php do_action('pk_post_content_footer'); ?>
                        </div>
                        <?php
                        $link_pages = wp_link_pages(array(
                            'before' => '<li>',
                            'after' => '</li>',
                            'prev_text' => '&laquo;',
                            'next_text' => '&raquo;',
                            'format' => '<li>%1</li>',
                            'echo' => false
                        ));
                        if (!empty($link_pages)):
                            ?>
                            <div class="mt20 clearfix text-center">
                                <ul class="pagination">
                                    <?php echo $link_pages ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <div class="t-separator c-sub t-sm mt30"><?php _e('正文完', PUOCK) ?></div>
                        <?php if (pk_is_checked('post_foot_qrcode_open')): ?>
                            <div class="post-foot-qrcode">
                                <div class="title"><?php echo pk_get_option('post_foot_qrcode_title', '無說明') ?></div>
                                <img src="<?php echo pk_get_option('post_foot_qrcode_img', '') ?>"
                                     alt="post-qrcode">
                            </div>
                        <?php endif; ?>
                        <div class="footer-info puock-text mt20">
                            <?php echo get_post_tags('mt20 tags', 'mb10') ?>
                            <div class="p-flex-sbc mt20 t-sm">
                                <div>
                                    <span><?php _e('發表至：', PUOCK) ?></span><?php echo get_post_category_link_exec(true) ?>
                                </div>
                                <div>
                                    <span class="c-sub"><i class="fa-regular fa-clock"></i> <?php pk_get_post_date() ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php get_template_part('templates/post', 'actions') ?>
                </div>
                <?php dynamic_sidebar('post_content_author_top'); ?>
                <?php if (pk_is_checked('page_copy_right')): ?>
                    <div class="p-block p-flex-sc">
                        <div class="mr-3 p-flex-sk-0">
                            <img class="md-avatar mt-1"
                                 src="<?php echo pk_get_gravatar(get_the_author_meta('email')) ?>"
                                 alt="<?php the_author_meta('display_name') ?>"
                                 title="<?php the_author_meta('display_name') ?>">
                        </div>
                        <div class="puock-text t-md">
                            <?php $origin_author = get_post_meta(get_the_ID(), 'origin_author', true);
                            if (empty($origin_author)): ?>
                                <div>
                                    <span class="font-weight-bold"><?php _e('版權聲明：', PUOCK) ?></span><span><?php _e('本站原創文章，由', PUOCK) ?></span>
                                    <a class="a-link"
                                       href="<?php global $authordata;
                                       if ($authordata) {
                                           echo get_author_posts_url($authordata->ID,
                                               $authordata->user_nicename);
                                       } ?>"><?php the_author() ?> </a><?php _e('於&nbsp;', PUOCK) ?><?php the_date('Y-m-d') ?><?php
                                    _e('&nbsp;發表，', PUOCK) ?><?php _e('共計&nbsp;', PUOCK) ?><?php echo count_words() ?><?php _e('&nbsp;字。', PUOCK) ?>
                                </div>
                                <div class="mt-2">
                                    <span class="font-weight-bold c-sub"><?php _e('轉載說明：', PUOCK) ?></span><span
                                            class="c-sub"><?php echo pk_get_option('post_reprint_note', pk_get_option('footer_copyright')) ?></span>
                                </div>
                            <?php else: ?>
                                <div>
                                    <span class="font-weight-bold"><?php _e('版權聲明：', PUOCK) ?></span><?php _e('本文於&nbsp;', PUOCK) ?><?php the_date('Y-m-d')
                                    ?><?php _e('&nbsp;轉載自', PUOCK) ?><a target="_blank"
                                                                  href="<?php echo get_post_meta(get_the_ID(), 'origin_url', true) ?>"
                                                                  class="a-link" rel="nofollow"><?php
                                        echo $origin_author ?></a><?php _e('，共計&nbsp;', PUOCK) ?><?php echo count_words('') ?><?php _e('&nbsp;字。', PUOCK) ?>
                                </div>
                                <div class="mt-2">
                                    <span class="font-weight-bold c-sub"><?php _e('轉載提示：', PUOCK) ?></span><span
                                            class="c-sub"><?php _e('此文章非本站原創文章，若需轉載請聯繫原作者獲得轉載授權。', PUOCK) ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php dynamic_sidebar('post_content_author_bottom'); ?>
                <?php get_template_part('ad/page', 'innerb') ?>
                <?php if (pk_is_checked('page_b_recommend')): ?>
                    <?php get_template_part('templates/post', 'relevant') ?>
                <?php endif; ?>
                <?php get_template_part('templates/module', 'andb') ?>
                <?php dynamic_sidebar('post_content_comment_top'); ?>
                <?php comments_template() ?>
                <?php dynamic_sidebar('post_content_comment_bottom'); ?>
            </div>
            <?php get_sidebar() ?>
        </div>
        <?php get_template_part('templates/box', 'global-bottom') ?>
    </div>

<?php endwhile; ?>

<?php get_footer() ?>
