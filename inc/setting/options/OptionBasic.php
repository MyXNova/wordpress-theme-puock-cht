<?php

namespace Puock\Theme\setting\options;

class OptionBasic extends BaseOptionItem
{

    function get_fields(): array
    {
        return [
            'key' => 'basic',
            'label' => __('基礎設定', PUOCK),
            'icon' => 'dashicons-admin-generic',
            'fields' => [
                [
                    'id' => 'basic_img_lazy_s',
                    'label' => __('圖片懶載入', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'basic_img_lazy_z',
                    'label' => __('正文圖片懶載入', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'basic_img_lazy_a',
                    'label' => __('留言頭像懶載入', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'off_img_viewer',
                    'label' => __('禁用正文圖片燈箱預覽', PUOCK),
                    'type' => 'switch',
                    'sdt' => false,
                ],
                [
                    'id' => 'off_code_highlighting',
                    'label' => __('禁用主題程式碼高亮', PUOCK),
                    'type' => 'switch',
                    'sdt' => false,
                ],
                [
                    'id' => 'post_content_indent',
                    'label' => __('正文內容首行縮排', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'link_blank_content',
                    'label' => __('正文內容連結新標籤頁打開', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'link_go_page',
                    'label' => __('正文內容連結加跳轉', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'use_post_menu',
                    'label' => __('正文內容側邊目錄選單產生', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                    'tips' => __('勾選此項會在正文目錄顯示文章目錄', PUOCK),
                ],
                [
                    'id' => 'comment_ajax',
                    'label' => __('評論 ajax 翻頁', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'page_ajax_load',
                    'label' => __('頁面無重新整理載入', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                    'tips' => "新標籤頁打開的連結除外"
                ],
                [
                    'id' => 'async_view',
                    'label' => __('非同步瀏覽量統計', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                    'tips' => __('此選項為開啟快取後瀏覽量不自增問題解決方案', PUOCK)
                ],
                [
                    'id' => 'page_animate',
                    'label' => __('頁面模組載入動畫', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'page_link_before_icon',
                    'label' => __('頁面內容連結前顯示圖示', PUOCK),
                    'type' => 'switch',
                    'sdt' => false,
                ],
                [
                    'id' => '-',
                    'type' => 'panel',
                    'open' => pk_is_checked('post_expire_tips_open'),
                    'label' => __('文章超過時效提示', PUOCK),
                    'children'=>[
                        [
                            'id' => 'post_expire_tips_open',
                            'label' => __('啟用', PUOCK),
                            'type' => 'switch',
                            'sdt' => 'false',
                        ],
                        [
                            'id' => 'post_expire_tips_day',
                            'label' => __('大於 N 天', PUOCK),
                            'type' => 'number',
                            'sdt' => 100,
                        ],
                        [
                            'id' => 'post_expire_tips',
                            'label' => __('提示內容', PUOCK),
                            'sdt' => __('<i class="fa fa-circle-exclamation me-1"></i>提醒：本文最後更新於 {date}，文中所關聯的資訊可能已發生改變，請知悉！', PUOCK),
                            'tips' => __('{date}：文章最後更新時間', PUOCK),
                        ],
                    ]
                ],
                [
                    'id' => '-',
                    'type' => 'panel',
                    'open' => true,
                    'label' => __('評論相關', PUOCK),
                    'children' => [
                        [
                            'id' => 'comment_level',
                            'label' => __('評論等級', PUOCK),
                            'type' => 'switch',
                            'sdt' => 'false',
                        ],
                        [
                            'id' => 'comment_mail_notify',
                            'label' => __('評論回覆 E-mail 通知', PUOCK),
                            'type' => 'switch',
                            'sdt' => 'false',
                        ],
                        [
                            'id' => 'comment_has_at',
                            'label' => __('評論 @ 功能', PUOCK),
                            'type' => 'switch',
                            'sdt' => 'false',
                        ],
                        [
                            'id' => 'comment_show_ua',
                            'label' => __('評論顯示使用者 UA', PUOCK),
                            'type' => 'switch',
                            'sdt' => true,
                        ],
                        [
                            'id' => 'comment_show_ip',
                            'label' => __('評論顯示 IP 歸屬地及營運商', PUOCK),
                            'type' => 'switch',
                            'sdt' => true,
                        ],
                        [
                            'id' => 'comment_dont_show_owner_ip',
                            'label' => __('不顯示站長 IP 歸屬地及營運商', PUOCK),
                            'type' => 'switch',
                            'sdt' => false,
                        ],
                    ]
                ],
                [
                    'id' => 'post_poster_open',
                    'label' => __('文章海報產生', PUOCK),
                    'tips' => __('使用此功能如果出現圖片無法產生，請檢查圖片是否符合跨域要求', PUOCK),
                    'type' => 'switch',
                    'sdt' => false,
                ],
                [
                    'id' => 'page_copy_right',
                    'label' => __('顯示正文版權說明', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'page_b_recommend',
                    'label' => __('顯示正文底部相關推薦', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'page_b_recommend_num',
                    'label' => __('正文底部相關推薦文章數量', PUOCK),
                    'tips' => __('建議是 4 的倍數，不然會出現空缺位置', PUOCK),
                    'type' => 'number',
                    'sdt' => 4,
                ],
                [
                    'id' => 'link_page',
                    'label' => __('友情連結頁面', PUOCK),
                    'type' => 'select',
                    'options' => self::get_pages(),
                ],
                [
                    'id' => 'index_link_id',
                    'label' => __('首頁友情連結目錄 ID', PUOCK),
                    'type' => 'select',
                    'options' => self::get_link_category(),
                ],
                [
                    'id' => 'gravatar_url',
                    'label' => __('Gravatar 頭像來源', PUOCK),
                    'type' => 'radio',
                    'sdt' => 'cravatar',
                    'radioType' => 'radio',
                    'options' => [
                        [
                            'value' => 'wp',
                            'label' => __('WordPress 預設', PUOCK),
                        ],
                        [
                            'value' => 'cn',
                            'label' => __('WordPress 國內預設', PUOCK),
                        ],
                        [
                            'value' => 'cn_ssl',
                            'label' => __('WordPress 國內預設 SSL', PUOCK),
                        ],
                        [
                            'value' => 'cravatar',
                            'label' => 'Cravatar',
                        ],
                        [
                            'value' => 'v2ex',
                            'label' => 'V2EX',
                        ],
                        [
                            'value' => 'loli',
                            'label' => 'loli.net'
                        ],
                        [
                            'value' => 'custom',
                            'label' => __('自定義', PUOCK)
                        ]
                    ],
                ],
                [
                    'id'=>'gravatar_custom_url',
                    'label'=>__('自定義 Gravatar 來源', PUOCK),
                    'tips'=>__('例如：',PUOCK).'<code>gravatar.example.com</code>',
                    'showRefId'=>'func:(function(args){return args.data.gravatar_url==="custom"})(args)'
                ],
                [
                    'id' => 'post_reward',
                    'label' => __('文章讚賞', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'post_reward_alipay',
                    'label' => __('文章讚賞支付寶二維碼', PUOCK),
                    'type' => 'img',
                    'showRefId' => 'post_reward',
                    'tips' => __('請選擇寬高比例為 1:1 的圖片', PUOCK)
                ],
                [
                    'id' => 'post_reward_wx',
                    'label' => __('文章讚賞微信二維碼', PUOCK),
                    'type' => 'img',
                    'showRefId' => 'post_reward',
                    'tips' => __('請選擇寬高比例為 1:1 的圖片', PUOCK)
                ],
                [
                    'id' => 'post_foot_qrcode_open',
                    'label' => __('文章正文底部二維碼', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                    'tips' => __('請選擇寬高比例為 1:1 的圖片', PUOCK)
                ],
                [
                    'id' => 'post_foot_qrcode_title',
                    'label' => __('文章正文底部二維碼標題', PUOCK),
                    'sdt' => '',
                    'showRefId' => 'post_foot_qrcode_open',
                ],
                [
                    'id' => 'post_foot_qrcode_img',
                    'label' => __('文章正文底部二維碼', PUOCK),
                    'type' => 'img',
                    'showRefId' => 'post_foot_qrcode_open',
                ],
                [
                    'id' => 'post_reprint_note',
                    'label' => __('文章轉載說明', PUOCK),
                    'type' => 'textarea',
                    'sdt' => __('除特殊說明外本站文章皆由 CC-4.0 協議發佈，轉載請註明出處。', PUOCK),
                ],
                [
                    'id' => 'post_read_time',
                    'label' => __('文章閱讀時間', PUOCK),
                    'type' => 'switch',
                    'sdt' => false,
                ]
            ],
        ];
    }
}
