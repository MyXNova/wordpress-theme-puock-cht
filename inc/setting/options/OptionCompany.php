<?php

namespace Puock\Theme\setting\options;

class OptionCompany extends BaseOptionItem
{

    function get_fields(): array
    {
        return [
            'key' => 'company',
            'label' => __('企業佈局', PUOCK),
            'icon' => 'dashicons-building',
            'fields' => [
                [
                    'id' => 'company_product_title',
                    'label' => __('產品介紹-大標題', PUOCK),
                    'sdt' => __('產品介紹', PUOCK),
                ],
                [
                    'id' => 'company_products',
                    'label' => __('產品列表', PUOCK),
                    'type' => 'dynamic-list',
                    'sdt' => [],
                    'draggable' => true,
                    'dynamicModel' => [
                        ['id' => 'title', 'label' => __('標題', PUOCK), 'std' => ''],
                        ['id' => 'img', 'label' => __('圖片', PUOCK), 'std' => '', 'type' => 'img'],
                        ['id' => 'desc', 'label' => __('描述', PUOCK), 'std' => ''],
                        ['id' => 'link', 'label' => __('連結', PUOCK), 'std' => ''],
                    ],
                ],
                [
                    'id' => 'company_do_title',
                    'label' => __('做什麼-大標題', PUOCK),
                    'sdt' => __('做什麼', PUOCK),
                ],
                [
                    'id' => 'company_dos',
                    'label' => __('做什麼-列表', PUOCK),
                    'type' => 'dynamic-list',
                    'sdt' => [],
                    'draggable' => true,
                    'dynamicModel' => [
                        ['id' => 'title', 'label' => __('標題', PUOCK), 'std' => ''],
                        ['id' => 'icon', 'label' => __('圖示', PUOCK), 'std' => ''],
                        ['id' => 'desc', 'label' => __('描述', PUOCK), 'std' => ''],
                    ],
                ],
                [
                    'id' => 'company_do_img',
                    'label' => __('做什麼-左側展示圖', PUOCK),
                    'type' => 'img',
                    'sdt' => '',
                ],
                [
                    'id' => 'company_news_open',
                    'label' => __('顯示新聞', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'company_news_title',
                    'label' => __('新聞模組標題', PUOCK),
                    'sdt' => __('新聞動態', PUOCK),
                    'showRefId' => 'company_news_open',
                ],
                [
                    'id' => 'company_news_cid',
                    'label' => __('新聞分類目錄', PUOCK),
                    'type' => 'select',
                    'sdt' => '',
                    'multiple' => true,
                    'showRefId' => 'company_news_open',
                    'options' => self::get_category(),
                ],
                [
                    'id' => 'company_news_max_num',
                    'label' => __('新聞顯示數量', PUOCK),
                    'type' => 'number',
                    'sdt' => 4,
                    'showRefId' => 'company_news_open',
                ],
                [
                    'id' => 'company_show_2box',
                    'label' => __('企業兩欄CMS分類', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                ],
                [
                    'id' => 'company_show_2box_id',
                    'label' => __('企業兩欄CMS分類項', PUOCK),
                    'type' => 'select',
                    'sdt' => '',
                    'multiple' => true,
                    'showRefId' => 'company_show_2box',
                    'options' => self::get_category(),
                ],
                [
                    'id' => 'company_show_2box_num',
                    'label' => __('企業兩欄CMS分類每欄顯示數量', PUOCK),
                    'type' => 'number',
                    'sdt' => 6,
                    'showRefId' => 'company_show_2box',
                ],
            ],
        ];
    }
}
