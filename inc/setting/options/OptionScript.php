<?php

namespace Puock\Theme\setting\options;

class OptionScript extends BaseOptionItem
{

    function get_fields(): array
    {
        return [
            'key' => 'script',
            'label' => __('指令碼及樣式', PUOCK),
            'icon' => 'dashicons-shortcode',
            'fields' => [
                [
                    'id' => 'style_color_primary',
                    'label' => __('站點主色調', PUOCK),
                    'type' => 'color',
                    'sdt' => '#1c60f3',
                ],
                [
                    'id' => 'block_not_tran',
                    'label' => __('全站區塊不透明度', PUOCK),
                    'type' => 'slider',
                    'sdt' => 100,
                    'step' => 1,
                    'max' => 100,
                    'tips' => "func:(function(args){
                        return args.h('div',[
                            args.h('span',null,'".__('小於100則會進行透明顯示，部分瀏覽器可能不相容', PUOCK)." '),
                            args.h(args.el.nTag,{type:'primary',size:'small',round:true},'".__("目前不透明度", PUOCK)."：'+args.data.block_not_tran+'%')
                        ])
                    })(args)"
                ],
                [
                    'id' => 'tj_code_header',
                    'label' => __('頭部流量統計程式碼', PUOCK),
                    'type' => 'textarea',
                    'sdt' => '',
                    'tips' => __("用於在頁頭新增統計程式碼（PS：若開啟無重新整理載入，請在標籤上加上<code>data-instant</code>屬性）", PUOCK)
                ],
                [
                    'id' => 'css_code_header',
                    'label' => __('頭部自定義全域性CSS樣式', PUOCK),
                    'type' => 'textarea',
                    'placeholder' => __('例如', PUOCK).'：#header{background-color:red !important}',
                    'sdt' => '',
                    'tips' => __('用於在頁頭新增統自定義CSS樣式', PUOCK)
                ],
                [
                    'id' => 'tj_code_footer',
                    'label' => __('底部流量統計程式碼', PUOCK),
                    'type' => 'textarea',
                    'sdt' => '',
                ],
                [
                    'id' => 'footer_info',
                    'label' => __('底部頁尾資訊', PUOCK),
                    'type' => 'textarea',
                    'sdt' => 'Copyright Puock',
                ],
                [
                    'id' => '-',
                    'type' => 'panel',
                    'label' => __('底部關於我們', PUOCK),
                    'open' => pk_is_checked('footer_about_me_open'),
                    'children' => [
                        [
                            'id' => 'footer_about_me_open',
                            'label' => __('啟用', PUOCK),
                            'type' => 'switch',
                            'sdt' => true,
                        ],
                        [
                            'id' => 'footer_about_me_title',
                            'label' => __('標題', PUOCK),
                            'sdt' => __('關於我們', PUOCK),
                        ],
                        [
                            'id' => 'footer_about_me',
                            'label' => __('內容', PUOCK),
                            'tips' => __('支援HTML程式碼', PUOCK),
                            'type' => 'textarea',
                            'sdt' => __('<strong>底部關於我們</strong>', PUOCK),
                        ],
                    ]
                ],
                [
                    'id' => '-',
                    'type' => 'panel',
                    'label' => __('底部版權說明', PUOCK),
                    'open' => pk_is_checked('footer_copyright_open'),
                    'children' => [
                        [
                            'id' => 'footer_copyright_open',
                            'label' => __('啟用', PUOCK),
                            'type' => 'switch',
                            'sdt' => true,
                        ],
                        [
                            'id' => 'footer_copyright_title',
                            'label' => __('標題', PUOCK),
                            'sdt' => __('版權說明', PUOCK),
                            'tips' => __('若為空則不顯示此欄目', PUOCK),
                        ],
                        [
                            'id' => 'footer_copyright',
                            'label' => __('內容', PUOCK),
                            'tips' => __('支援HTML程式碼', PUOCK),
                            'type' => 'textarea',
                            'sdt' => __('<strong>底部版權說明</strong>', PUOCK),
                        ],
                    ]
                ],
                [
                    'id' => 'down_tips',
                    'label' => __('下載說明', PUOCK),
                    'type' => 'textarea',
                    'sdt' => __('本站部分資源來自於網路收集，若侵犯了你的隱私或版權，請及時聯繫我們刪除有關資訊。', PUOCK),
                ],
            ],
        ];
    }
}
