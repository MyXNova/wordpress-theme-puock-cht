<?php

namespace Puock\Theme\setting\options;

class OptionGlobal extends BaseOptionItem
{

    function get_fields(): array
    {
        return [
            'key' => 'global',
            'label' => __('全域性設定', PUOCK),
            'icon' => 'dashicons-admin-site',
            'fields' => [
                [
                    'id' => 'index_mode',
                    'label' => __('首頁佈局', PUOCK),
                    'type' => 'radio',
                    'sdt' => 'blog',
                    'radioType' => 'button',
                    'options' => [
                        [
                            'value' => 'blog',
                            'label' => __('部落格風格', PUOCK),
                        ],
                        [
                            'value' => 'cms',
                            'label' => __('CMS風格', PUOCK),
                        ],
                        [
                            'value' => 'company',
                            'label' => __('企業風格', PUOCK),
                        ],
                    ],
                ],
                [
                    'id' => 'post_style',
                    'label' => __('文章風格', PUOCK),
                    'type' => 'radio',
                    'sdt' => 'list',
                    'radioType' => 'button',
                    'options' => [
                        [
                            'value' => 'list',
                            'label' => __('列表風格', PUOCK),
                        ],
                        [
                            'value' => 'card',
                            'label' => __('卡片風格', PUOCK),
                        ],
                    ],
                ],
                [
                    'id' => 'theme_mode',
                    'label' => __('主題模式', PUOCK),
                    'type' => 'radio',
                    'sdt' => 'light',
                    'radioType' => 'button',
                    'options' => [
                        [
                            'value' => 'light',
                            'label' => __('日光模式', PUOCK),
                        ],
                        [
                            'value' => 'dark',
                            'label' => __('暗黑模式', PUOCK),
                        ],
                    ],
                ],
                [
                    'id' => 'theme_mode_s',
                    'label' => __('允許切換主題模式', PUOCK),
                    'type' => 'switch',
                    'sdt' => true,
                ],
                [
                    'id' => 'nav_blur',
                    'label' => __('導航欄毛玻璃效果', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'html_page_permalink',
                    'label' => __('頁面使用.html後綴', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                    'tips' => __('更改後需要重新儲存<strong>固定連結</strong>', PUOCK),
                ],
                [
                    'id' => 'chinese_format',
                    'label' => __('開啟中文格式化（文案排版）', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                    'tips' => __('參考', PUOCK) . "：<a href='https://github.com/sparanoid/chinese-copywriting-guidelines' target='_blank'>https://github.com/sparanoid/chinese-copywriting-guidelines</a>"
                ],
                [
                    'id' => 'on_txt_logo',
                    'label' => __('使用文字LOGO', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'light_logo',
                    'label' => __('日光模式LOGO', PUOCK),
                    'type' => 'img',
                    'sdt' => '',
                    'tips' => __('若不上傳則顯示文字LOGO，比例：500*125，請儘量選擇png無底色圖片', PUOCK),
                ],
                [
                    'id' => 'dark_logo',
                    'label' => __('暗黑模式LOGO', PUOCK),
                    'type' => 'img',
                    'sdt' => '',
                    'tips' => __('若不上傳則顯示文字LOGO，比例：500*125，請儘量選擇png無底色圖片', PUOCK),
                ],
                [
                    'id' => 'logo_loop_light',
                    'label' => __('LOGO掃光動畫', PUOCK),
                    'type' => 'switch',
                    'badge' => ['value' => 'New'],
                    'sdt' => false,
                ],
                [
                    'id' => 'favicon',
                    'label' => __('網站圖示', PUOCK),
                    'type' => 'img',
                    'sdt' => '',
                    'tips' => __('比例：32*32，請儘量選擇png無底色圖片', PUOCK),
                ],
                [
                    'id' => 'stop5x_editor',
                    'label' => __('禁用Gutenberg編輯器', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'use_widgets_block',
                    'label' => __('使用區塊小工具', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'upload_webp',
                    'label' => __('允許上傳webp', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'hide_post_views',
                    'label' => __('隱藏文章瀏覽量', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'close_post_comment',
                    'label' => __('關閉全站評論功能', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'hide_footer_wp_t',
                    'label' => __('隱藏底部<code>感謝使用WordPress進行創作</code>和左上角標識', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'grey',
                    'label' => __('全站變灰', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'disable_not_admin_user_profile',
                    'label' => __('禁止非管理員瀏覽使用者資料頁', PUOCK),
                    'type' => 'switch',
                    'badge' => ['value' => 'New'],
                    'sdt' => false,
                ],
                [
                    'id' => 'compress_html',
                    'label' => __('將HTML壓縮成一行', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'hide_global_sidebar',
                    'label' => __('關閉全域性側邊欄顯示', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'close_rest_api',
                    'label' => __('禁止使用', PUOCK) . ' REST API',
                    'tips' => __('開啟後將不能使用相關功能，如果使用了<b>小程式</b>等功能此選項應不要開啟，
                                另外開啟後可能導致古騰堡編輯器出現通訊異常問題，建議非必要不開啟此選項', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'close_xmlrpc',
                    'label' => __('禁止使用', PUOCK) . ' XML-RPC',
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'thumbnail_rewrite_open',
                    'label' => __('縮圖偽靜態', PUOCK),
                    'type' => 'switch',
                    'badge' => ['value' => 'New'],
                    'sdt' => false,
                    'tips' => "⚠️".__('若開啟此選項，請自行手動在Nginx配置中新增偽靜態規則', PUOCK)."：<code>rewrite ^/timthumb/w_([0-9]+)/h_([0-9]+)/q_([0-9]+)/zc_([0-9])/a_([a-z]+)/([0-9A-Za-z_\-]+)\.([0-9a-z]+)$ /wp-content/themes/" . get_template() . "/timthumb.php?w=$1&h=$2&q=$3&zc=$4&a=$5&src=$6;</code>"
                ],
                [
                    'id' => 'thumbnail_allows',
                    'label' => __('縮圖白名單', PUOCK),
                    'type' => 'textarea',
                    'sdt' => '',
                    'tips' => __("<strong>若使用了其他外鏈圖片須在此處新增外鏈域名以允許</strong>：一行一個，不要帶 <code>http://</code> 或 <code>https://</code> 協議頭，例如：<code>blog.example.com</code>", PUOCK)
                ],
            ],
        ];
    }
}
