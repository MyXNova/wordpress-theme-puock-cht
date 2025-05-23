<?php

add_action('after_setup_theme', 'deel_setup');
function deel_setup()
{
    //去除頭部冗餘程式碼
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'feed_links', 2, 1);
    remove_action('wp_head', 'rsd_link');//移除離線編輯器開放介面
    remove_action('wp_head', 'wlwmanifest_link');//移除離線編輯器開放介面
    remove_action('wp_head', 'index_rel_link');//本頁連結
    remove_action('wp_head', 'parent_post_rel_link');//清除前後文資訊
    remove_action('wp_head', 'start_post_rel_link');//清除前後文資訊
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
    remove_action('wp_head', 'rel_canonical');//本頁連結
    remove_action('wp_head', 'wp_generator');//移除 WordPress 版本號
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);//本頁短連結

    add_filter('embed_oembed_discover', '__return_false');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
    remove_filter('pre_oembed_result', 'wp_filter_pre_oembed_result', 10);

    // 遮蔽 REST API
    if (pk_is_checked('close_rest_api')) {
        add_filter('rest_enabled', '__return_false');
        add_filter('rest_jsonp_enabled', '__return_false');
        add_filter('rest_authentication_errors', function ($access) {
            return new WP_Error('rest_cannot_access', 'REST API 已經被關閉，請打開後再進行嘗試', array('status' => 403));
        });
    }

    if(pk_is_checked('close_xmlrpc')){
        add_filter('xmlrpc_enabled', '__return_false');
    }

    // 移除頭部 wp-json 標籤和 HTTP header 中的 link
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('template_redirect', 'rest_output_link_header', 11);

    //清除 wp_footer 帶入的 embed.min.js
    function git_deregister_embed_script()
    {
        wp_deregister_script('wp-embed');
    }

    add_action('wp_footer', 'git_deregister_embed_script');

    //禁止 s.w.org
    function git_remove_dns_prefetch($hints, $relation_type)
    {
        if ('dns-prefetch' === $relation_type) {
            return array_diff(wp_dependencies_unique_hosts(), $hints);
        }
        return $hints;
    }

    add_filter('wp_resource_hints', 'git_remove_dns_prefetch', 10, 2);

    //去除部分預設小工具
    function unregister_d_widget()
    {
        unregister_widget('WP_Widget_Search');
        unregister_widget('WP_Widget_Recent_Comments');
        unregister_widget('WP_Widget_Tag_Cloud');
        unregister_widget('WP_Nav_Menu_Widget');
    }

    add_action('widgets_init', 'unregister_d_widget');
    //分類，標籤描述新增圖片
    remove_filter('pre_term_description', 'wp_filter_kses');
    remove_filter('pre_link_description', 'wp_filter_kses');
    remove_filter('pre_link_notes', 'wp_filter_kses');
    remove_filter('term_description', 'wp_kses_data');
    //新增主題特性
    add_theme_support('post-thumbnails');//縮圖設定
    add_theme_support('post-formats', array('aside'));//增加文章形式
    add_theme_support('custom-background', array(
            'default-repeat' => 'repeat',
            'default-position-x' => 'left',
            'default-position-y' => 'top',
            'default-size' => 'auto',
            'default-attachment' => 'fixed'
        )
    );
    //遮蔽頂部工具欄
    add_filter('show_admin_bar', '__return_false');
    // 友情連結擴充套件
    add_filter('pre_option_link_manager_enabled', '__return_true');
    //評論回覆郵件通知
//    add_action('comment_post', 'comment_mail_notify');
    //自動勾選評論回覆郵件通知，不勾選則註釋掉
//    add_action('comment_form', 'deel_add_checkbox');
    //移除自動儲存和修訂版本
    add_action('wp_print_scripts', 'disable_autosave');
    function disable_autosave()
    {
        wp_deregister_script('autosave');
    }

    add_filter('wp_revisions_to_keep', 'specs_wp_revisions_to_keep', 10, 2);
    function specs_wp_revisions_to_keep($num, $post)
    {
        return 0;
    }
}

/**
 * Disable the emoji's
 */
function pk_disable_emojis()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', 'pk_disable_emojis_tinymce');
}

add_action('init', 'pk_disable_emojis');
/**
 * Filter function used to remove the tinymce emoji plugin.
 */
function pk_disable_emojis_tinymce($plugins)
{
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    } else {
        return array();
    }
}

//開啟支援
add_theme_support('custom-background');

add_action('init', array(\Puock\Theme\classes\meta\PuockAbsMeta::class, 'load'));

$pk_right_slug = 'PGRpdiBjbGFzcz0iZnMxMiBtdDEwIGMtc3ViIj4NCiAgICAgICAgICAgICAgICA8c3Bhbj4NCiAgICAgICAgICAgICAgICAgICAgPGkgY2xhc3M9ImZhLWJyYW5kcyBmYS13b3JkcHJlc3MiPjwvaT4mbmJzcDtUaGVtZSBieSA8YSB0YXJnZXQ9Il9ibGFuayIgY2xhc3M9ImMtc3ViIiB0aXRsZT0iUHVvY2sgdntQVU9DS19WRVJTSU9OfSINCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBocmVmPSJodHRwczovL2dpdGh1Yi5jb20vTGljb3kvd29yZHByZXNzLXRoZW1lLXB1b2NrIj5QdW9jazwvYT4NCiAgICAgICAgICAgICAgICA8L3NwYW4+DQogICAgICAgICAgICA8L2Rpdj4=';

function pk_env_check()
{
    $php_version = phpversion();
    $last_version = '7.4';
    $content = [];
    if (version_compare($php_version, $last_version, '<')) {
        $content[] = '<p>您正在使用過時的 PHP 版本<code>' . $php_version . '</code>，Puock 主題需要 PHP 版本大於<code>' . $last_version . '</code>才能完整使用全部功能，請升級 PHP 版本。</p>';
    }
    $need_ext = ['gd'];
    $not_ext = [];
    foreach ($need_ext as $ext) {
        if (!extension_loaded($ext)) {
            $not_ext[] = '<code>' . $ext . '</code>';
        }
    }
    if (count($not_ext) > 0) {
        $content[] = '<p>您的 PHP 缺少擴充套件' . implode(', ', $not_ext) . '，缺少這些擴充套件可能導致部分功能無法使用，請及時安裝這些擴充套件。</p>';
    }
    if (!empty($content)) {
        echo '<div class="error">' . (join('', $content)) . '</div>';
    }
}

add_action('admin_notices', 'pk_env_check');

function pk_init_register_assets()
{
    if (is_admin()) {
        wp_enqueue_style('puock-strawberry-icon-admin', pk_get_static_url() . '/assets/libs/strawberry-icon.css', [], PUOCK_CUR_VER_STR);
        wp_enqueue_script('puock-admin', pk_get_static_url() . '/assets/dist/js/admin.min.js', [], PUOCK_CUR_VER_STR, true);
    } else {
        wp_register_script('jquery', pk_get_static_url() . '/assets/libs/jquery.min.js', [], PUOCK_CUR_VER_STR);
        wp_enqueue_script('jquery');
        wp_enqueue_style('puock-libs', pk_get_static_url() . '/assets/dist/style/libs.min.css', [], PUOCK_CUR_VER_STR);
        wp_enqueue_style('puock', pk_get_static_url() . '/assets/dist/style/style.min.css', ['puock-libs'], PUOCK_CUR_VER_STR);
        wp_enqueue_script('puock-libs', pk_get_static_url() . '/assets/dist/js/libs.min.js', [], PUOCK_CUR_VER_STR, true);
        wp_enqueue_script('puock-layer', pk_get_static_url() . '/assets/libs/layer/layer.js', [], PUOCK_CUR_VER_STR, true);
        wp_enqueue_script('puock-spark-md5', pk_get_static_url() . '/assets/libs/spark-md5.min.js', [], PUOCK_CUR_VER_STR, true);
        if (pk_is_checked('strawberry_icon')) {
            wp_enqueue_style('puock-strawberry-icon', pk_get_static_url() . '/assets/libs/strawberry-icon.css', [], PUOCK_CUR_VER_STR);
        }
        if (pk_is_checked('dplayer')) {
            wp_enqueue_style('puock-dplayer', pk_get_static_url() . '/assets/libs/dplayer/DPlayer.min.css', ['puock'], PUOCK_CUR_VER_STR);
            wp_enqueue_script('puock-dplayer', pk_get_static_url() . '/assets/libs/dplayer/DPlayer.min.js', ['puock-libs'], PUOCK_CUR_VER_STR, true);
        }
        if (pk_is_checked('post_poster_open')) {
            wp_enqueue_script('puock-html2canvas', pk_get_static_url() . '/assets/libs/html2canvas.min.js', [], PUOCK_CUR_VER_STR, true);
        }
        if (pk_get_option('vd_type') === 'gt') {
            wp_enqueue_script('puock-gt4', pk_get_static_url() . '/assets/libs/gt4.js', [], PUOCK_CUR_VER_STR, true);
        }
        wp_enqueue_script('puock', pk_get_static_url() . '/assets/dist/js/puock.min.js', array('puock-libs'), PUOCK_CUR_VER_STR, true);

        //載入全站黑白樣式
        if (pk_is_checked('grey')) {
            wp_add_inline_style('puock', 'html {
                filter: grayscale(100%);
                -webkit-filter: grayscale(100%);
                -moz-filter: grayscale(100%);
                -o-filter: grayscale(100%);
            }');
        }

        //載入自定義主題色
        if (!empty(pk_get_option('style_color_primary'))) {
            wp_add_inline_style('puock', 'body{--pk-c-primary:' . pk_get_option('style_color_primary') . '}');
        }

        //載入頭部樣式
        wp_add_inline_style('puock', pk_head_style_var());

        //載入自定義樣式
        if (!empty(pk_get_option('css_code_header', ''))) {
            wp_add_inline_style('puock', pk_get_option('css_code_header', ''));
        }
    }
}

add_action('init', 'pk_init_register_assets');

add_filter('script_loader_tag', 'pk_assets_scr_handle', 10, 3);
add_filter('style_loader_tag', 'pk_assets_href_handle', 10, 3);
function pk_assets_scr_handle($tag, $handle, $source)
{
    if (strpos($handle, 'puock') === 0 && strpos($source,'instant=true')===false)
    {
        $tag = str_replace(' src', ' data-no-instant src', $tag);
    }
    return $tag;
}

function pk_assets_href_handle($tag, $handle, $source)
{
    if (strpos($handle, 'puock') === 0 && strpos($source,'instant=true')===false) {
        $tag = str_replace(' href', ' data-no-instant href', $tag);
    }
    return $tag;
}

function pk_dequeue_jquery_migrate( $scripts ) {
    if ( ! is_admin() && ! empty( $scripts->registered['jquery'] ) ) {
        $scripts->registered['jquery']->deps = array_diff(
            $scripts->registered['jquery']->deps,
            [ 'jquery-migrate' ]
        );
    }
}
add_action( 'wp_default_scripts', 'pk_dequeue_jquery_migrate' );
