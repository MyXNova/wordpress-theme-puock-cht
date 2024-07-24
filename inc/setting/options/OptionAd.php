<?php

namespace Puock\Theme\setting\options;

class OptionAd extends BaseOptionItem{

    function get_fields(): array
    {
        return [
            'key' => 'ad',
            'label' => __('廣告設定', PUOCK),
            'icon'=>'dashicons-megaphone',
            'fields' => [
                [
                    'id' => 'ad_g_top_c',
                    'label' => __('全站頂部廣告', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'ad_g_top',
                    'label' => __('全站頂部廣告內容', PUOCK),
                    'type' => 'textarea',
                    'sdt' => '',
                    'showRefId' => 'ad_g_top_c',
                ],
                [
                    'id' => 'ad_g_bottom_c',
                    'label' => __('全站底部廣告', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'ad_g_bottom',
                    'label' => __('全站底部廣告內容', PUOCK),
                    'type' => 'textarea',
                    'sdt' => '',
                    'showRefId' => 'ad_g_bottom_c',
                ],
                [
                    'id' => 'ad_page_t_c',
                    'label' => __('文章內頂部廣告', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'ad_page_t',
                    'label' => __('文章內頂部廣告內容', PUOCK),
                    'type' => 'textarea',
                    'sdt' => '',
                    'showRefId' => 'ad_page_t_c',
                    'tips'=>'顯示在麵包屑導航下'
                ],
                [
                    'id' => 'ad_page_c_b_c',
                    'label' => __('文章內容底部廣告', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'ad_page_c_b',
                    'label' => __('文章內容底部廣告內容', PUOCK),
                    'type' => 'textarea',
                    'sdt' => '',
                    'showRefId' => 'ad_page_c_b_c',
                    'tips'=>'會顯示在文章結尾處'
                ],
                [
                    'id' => 'ad_comment_t_c',
                    'label' => __('評論上方廣告', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'ad_comment_t',
                    'label' => __('評論上方廣告內容', PUOCK),
                    'type' => 'textarea',
                    'sdt' => '',
                    'showRefId' => 'ad_comment_t_c',
                ],
            ],
        ];
    }
}
