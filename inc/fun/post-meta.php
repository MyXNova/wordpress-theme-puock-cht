<?php

use Puock\Theme\classes\meta\PuockAbsMeta;

PuockAbsMeta::newPostMeta('pk-post-seo', [
    'title' => 'SEO設定',
    'options' => [
        array(
            "id" => "seo_keywords",
            "title" => "自定義SEO關鍵詞",
            'desc' => '多個關鍵詞之間使用", "分隔，預設為設定的標籤',
            "type" => "text"
        ),
        array(
            "id" => "seo_desc",
            "title" => "自定義SEO描述",
            'desc' => '預設為文章前150個字元（推薦不超過150個字元）',
            "type" => "text"
        )
    ]
]);

PuockAbsMeta::newPostMeta('pk-post-basic', [
    'title' => '基本設定',
    'options' => [
        array(
            "id" => "hide_side",
            "title" => "隱藏側邊欄",
            "type" => "checkbox"
        ),
        array(
            "id" => "author_cat_comment",
            "title" => "評論僅對作者可見",
            "type" => "checkbox"
        ),
        array(
            "id" => "origin_author",
            "title" => "文章出處名稱",
            "desc" => "若非原創則填寫此值，包括其下一欄",
            "type" => "text"
        ),
        array(
            "id" => "origin_url",
            "title" => "文章出處連結",
            "type" => "text"
        )
    ]
]);

function pk_page_meta_basic()
{
    $link_cats = get_all_category_id_row('link_category');
    PuockAbsMeta::newPostMeta('pk-page-basic', [
        'title' => '基本設定',
        'post_type' => 'page',
        'options' => [
            array(
                "id" => "hide_side",
                "title" => "隱藏側邊欄",
                "type" => "checkbox"
            ),
            array(
                "id" => "author_cat_comment",
                "title" => "評論僅對作者可見",
                "type" => "checkbox"
            ),
            array(
                "id" => "use_theme_link_forward",
                "std" => "0",
                "title" => "內部連結使用主題連結跳轉頁",
                "type" => "checkbox"
            ),
            array(
                "id" => "page_links_id",
                "std" => "",
                "title" => "連結顯示分類目錄ID列表",
                'desc' => "（僅為<b>友情連結</b>及<b>網址導航</b>模板時有效，為空則不顯示，可多選）",
                "type" => "select",
                'multiple'=>true,
                "options" => $link_cats
            ),
            array(
                "id" => "page_books_id",
                "std" => "",
                "title" => "書籍顯示分類目錄ID列表",
                "desc" => "（僅為<b>書籍推薦</b>模板時有效，為空則不顯示，可多選）",
                "type" => "select",
                'multiple'=>true,
                "options" => $link_cats
            )
        ]
    ]);
}

pk_page_meta_basic();
