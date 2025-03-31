<?php
add_action('widgets_init', 'pk_widgets_init');
function pk_widgets_init()
{
    pk_common_sidebar_register('sidebar_single', '正文內容 - 側邊欄', '文章正文內容側邊欄');
    pk_common_sidebar_register('sidebar_home', '首頁 - 側邊欄', '首頁側邊欄');
    pk_common_sidebar_register('sidebar_search', '搜尋頁 - 側邊欄', '搜尋頁側邊欄');
    pk_common_sidebar_register('sidebar_cat', '分類/標籤頁 - 側邊欄', '分類/標籤頁側邊欄');
    pk_common_sidebar_register('sidebar_page', '單頁面 - 側邊欄', '單頁面側邊欄');
    pk_common_sidebar_register('sidebar_other', '其他頁面 - 側邊欄', '包括作者/ 404 等其他頁面');
    pk_common_sidebar_register('sidebar_not', '通用 - 側邊欄', '若指定頁面未配置任何欄目，則顯示此欄目下的數據');
    pk_common_sidebar_register('post_content_author_top', '正文 - 作者上方欄目', '顯示在正文作者欄上方的欄目');
    pk_common_sidebar_register('post_content_author_bottom', '正文 - 作者下方欄目', '顯示在正文作者欄下方的欄目');
    pk_common_sidebar_register('index_bottom', '首頁 - 底部欄目', '顯示在首頁內容最底部（友情連結上方的通欄項）');
    pk_common_sidebar_register('index_cms_layout_top', 'CMS 佈局 - 分類欄上方欄目', 'CMS 佈局下顯示在分類欄之上的欄目');
    pk_common_sidebar_register('index_cms_layout_bottom', 'CMS 佈局 - 分類欄下方欄目', 'CMS 佈局下顯示在分類欄之下的欄目');
    pk_common_sidebar_register('post_content_comment_top', '正文 - 評論上方欄目', '顯示在正文評論上方的欄目');
    pk_common_sidebar_register('post_content_comment_bottom', '正文 - 評論下方欄目', '顯示在正文評論下方的欄目');
    pk_common_sidebar_register('page_content_comment_top', '頁面 - 評論上方欄目', '顯示在頁面評論上方的欄目');
    pk_common_sidebar_register('page_content_comment_bottom', '頁面 - 評論下方欄目', '顯示在頁面評論下方的欄目');
}

function pk_common_sidebar_register($id, $name, $description = '')
{
    register_sidebar(array(
        'name' => __($name, PUOCK),
        'id' => $id,
        'description' => __($description, PUOCK),
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    ));
}
