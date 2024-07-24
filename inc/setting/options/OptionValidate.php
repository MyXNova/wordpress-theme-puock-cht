<?php

namespace Puock\Theme\setting\options;

class OptionValidate extends BaseOptionItem
{

    function get_fields(): array
    {
        return [
            'key' => 'validate',
            'label' => __('驗證及防刷', PUOCK),
            'icon' => 'dashicons-shield',
            'fields' => [
                [
                    'id' => 'vd_type',
                    'label' => __('驗證碼型別', PUOCK),
                    'type' => 'radio',
                    'sdt' => 'img',
                    'radioType' => 'button',
                    'options' => [
                        [
                            'value' => 'img',
                            'label' => __('圖形驗證碼', PUOCK),
                        ],
                        [
                            'value' => 'gt',
                            'label' => __('極驗驗證碼', PUOCK),
                        ],
                    ],
                ],
                [
                    'id' => 'vd_comment',
                    'label' => __('啟用評論驗證', PUOCK),
                    'type' => 'switch',
                    'sdt' => false,
                ],
                [
                    'id' => '-',
                    'type' => 'panel',
                    'label' => __('極驗驗證碼', PUOCK),
                    'open' => true,
                    'children' => [
                        [
                            'id' => 'vd_gt_id',
                            'label' => __('極驗驗證ID', PUOCK),
                            'sdt' => ''
                        ],
                        [
                            'id' => 'vd_gt_key',
                            'label' => __('極驗驗證Key', PUOCK),
                            'sdt' => ''
                        ]
                    ]
                ],
                [
                    'id' => 'vd_comment_need_chinese',
                    'label' => __('評論內容中必須含有中文字元', PUOCK),
                    'type' => 'switch',
                    'tips' => __('開啟后，評論中必須含有至少1箇中文字元，否則將會被攔截', PUOCK),
                    'sdt' => false,
                ],
                [
                    'id' => 'vd_kwd_access_reject',
                    'label' => __('惡意統計關鍵字瀏覽遮蔽', PUOCK),
                    'type' => 'switch',
                    'tips' => __('開啟后，將會使含有指定關鍵字的query參數請求得到403拒絕瀏覽，防止網站統計的惡意刷量', PUOCK),
                    'sdt' => false,
                ],
                [
                    'id' => 'vd_kwd_access_reject_list',
                    'label' => __('惡意統計關鍵字瀏覽遮蔽參數', PUOCK),
                    'tips' => __('多個之間使用半形<code>,</code>進行分隔', PUOCK),
                    'sdt' => 'wd,str',
                ],
            ],
        ];
    }
}
