<?php

namespace Puock\Theme\setting\options;

class OptionSeo extends BaseOptionItem{

    function get_fields(): array
    {
        return [
            'key' => 'seo',
            'label' => __('SEO 搜尋優化', PUOCK),
            'icon'=>'dashicons-google',
            'fields' => [
                [
                    'id' => 'seo_open',
                    'label' => __('開啟 SEO', PUOCK),
                    'type' => 'switch',
                    'sdt' => true,
                    'tips'=>__('若您正在使用其它的 SEO 外掛，請取消勾選', PUOCK),
                ],
                [
                    'id' => 'web_title',
                    'label' => __('網站標題', PUOCK),
                    'sdt' => '',
                    'showRefId' => 'seo_open',
                ],
                [
                    'id' => 'web_title_2',
                    'label' => __('網站副標題', PUOCK),
                    'sdt' => '',
                    'showRefId' => 'seo_open',
                ],
                [
                    'id' => 'title_conn',
                    'label' => __('標題連線符', PUOCK),
                    'sdt' => '-',
                    'showRefId' => 'seo_open',
                    'tips'=>__('Title 連線符號，例如 "-"、"|"', PUOCK),
                ],
                [
                    'id' => 'description',
                    'label' => __('網站描述', PUOCK),
                    'type' => 'textarea',
                    'sdt' => '',
                    'showRefId' => 'seo_open',
                ],
                [
                    'id' => 'keyword',
                    'label' => __('網站關鍵詞', PUOCK),
                    'type' => 'textarea',
                    'sdt' => '',
                    'showRefId' => 'seo_open',
                ],
                [
                    'id' => 'no_category',
                    'label' => __('不顯示分類連結中的<code>category</code>', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'open_baidu_submit',
                    'label' => __('發佈文章主動推送至百度', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'baidu_submit_url',
                    'label' => __('百度推送介面地址', PUOCK),
                    'sdt' => '',
                    'showRefId' => 'open_baidu_submit',
                    'tips'=>__('百度推送介面地址，如：', PUOCK)."http://data.zz.baidu.com/urls?site=https://xxx.com&token=XXXXXX"
                ],
            ],
        ];
    }
}
