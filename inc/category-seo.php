<?php

// 分類新增欄位
function category_seo_field()
{
    echo '<div class="form-field">  
            <label for="seo-cat-keywords">SEO 關鍵字</label>  
            <input name="seo-cat-keywords" id="seo-cat-keywords" type="text" value="" size="40">  
            <p>SEO 關鍵字，多個關鍵字之間使用「,」分隔，預設顯示該分類名稱</p>  
          </div>';
    echo '<div class="form-field">  
            <label for="seo-cat-desc">SEO 描述</label>  
            <input name="seo-cat-desc" id="seo-cat-desc" type="text" value="" size="40">  
            <p>SEO 描述，預設顯示該分類名稱</p>
          </div>';

}

add_action('category_add_form_fields', 'category_seo_field', 10, 2);

// 分類編輯欄位
function edit_category_seo_field($tag)
{
    echo '<tr class="form-field">  
            <th scope="row"><label for="seo-cat-keywords">SEO 關鍵字</label></th>  
            <td>  
                <input name="seo-cat-keywords" id="seo-cat-keywords" type="text" value="';
    echo get_option('seo-cat-keywords-' . $tag->term_id) . '" size="40"/><br>  
                <span class="seo-cat-keywords">SEO 關鍵字，多個關鍵字之間使用「,」分隔，預設顯示該分類名稱</span>  
            </td>  
        </tr>';
    echo '<tr class="form-field">  
            <th scope="row"><label for="seo-cat-desc">SEO 描述</label></th>  
            <td>  
                <input name="seo-cat-desc" id="seo-cat-desc" type="text" value="';
    echo get_option('seo-cat-desc-' . $tag->term_id) . '" size="40"/><br>  
                <span class="seo-cat-desc">SEO 描述，預設顯示該分類名稱</span>  
            </td>  
        </tr>';
}

add_action('category_edit_form_fields', 'edit_category_seo_field', 10, 2);

// 儲存數據
function cat_seo_taxonomy_save_data($term_id)
{
    if (isset($_POST['seo-cat-keywords']) && isset($_POST['seo-cat-desc'])) {
        if (!current_user_can('manage_categories')) {
            return $term_id;
        }
        update_option('seo-cat-keywords-' . $term_id, $_POST['seo-cat-keywords']);
        update_option('seo-cat-desc-' . $term_id, $_POST['seo-cat-desc']);
    }
}

add_action('created_category', 'cat_seo_taxonomy_save_data', 10, 1);
add_action('edited_category', 'cat_seo_taxonomy_save_data', 10, 1);