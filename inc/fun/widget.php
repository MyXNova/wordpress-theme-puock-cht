<?php

abstract class puockWidgetBase extends WP_Widget{

    public static $puock = 'Puock 主題';

    protected $title = "標題";

    protected $pre_title = '顯示近期的';

    function __construct() {
        WP_Widget::__construct($this->get_class_name(), self::$puock." ".$this->title,
            array('description' => $this->pre_title.$this->title));
    }

    public function html_gen($instance, $title, $key, $type='input', $showLabel=true){
        $fid = $this->get_field_id($key);
        $fname = $this->get_field_name($key);
        $out = "<p>";
        if($showLabel){
            $out .= "<label for='{$fid}'>{$title}：</label>";
        }
        if($type=='input'){
            $out .= "<input class='widefat' id='{$fid}' type='text' name='{$fname}'
                   value='".(@$instance[$key])."' />";
        }
        if($type=='cats'){
            $out .= wp_dropdown_categories(array('name' => $fname,'echo'=>0,
                'show_option_all' => '全部分類', 'hide_empty'=>0, 'hierarchical'=>1, 'selected'=>@$instance[$key]));
        }
        if($type=='text'){
            $out .= '<textarea class="monospace widefat" rows="10" cols="40" id="'.($fid).'" 
                name="'.$fname.'">'.@$instance[$key].'</textarea>';
        }
        if($type=='checkbox'){
            $use = (isset($instance[$key]) && $instance[$key]=='on') ? 'checked' : '';
            $out .= "<input id='{$fid}'
                name='{$fname}' type='checkbox' ".$use."/>
                <label for='{$fid}'>&nbsp;{$title}</label>";
        }
        $out .= "</p>";
        echo $out;
    }

    public function default_value($instance){
        $args = array();
        foreach ($this->get_fields() as $val){
            if(isset($val['val']) && !empty($val['val'])){
                $args[$val['id']] = $val['val'];
            }
        }
        return wp_parse_args( (array) $instance, $args);
    }

    public function get_fields(){
        return array();
    }

    /**
     * 合併公用欄位
     * @param $array
     * @return array
     */
    public function merge_common_fields($array){
        return array_merge($array,array(
            array('id'=>'hide_title', 'val'=>0),
            array('id'=>'icon', 'val'=>'fa fa-chart-simple'),
            array('id'=>'classes', 'val'=>''),
        ));
    }

    /**
     * 合併公用 form 表單
     * @param $instance
     */
    public function merge_common_form($instance){
        $this->html_gen($instance, '隱藏標題', 'hide_title','checkbox',false);
        $this->html_gen($instance, '圖示類', 'icon');
        $this->html_gen($instance, '區塊 class 類', 'classes');
    }

    function update( $cur, $old ) {
        foreach ($this->get_fields() as $val){
            if(isset($val['strip']) && $val['strip']){
                $old[$val['id']] = strip_tags($cur[$val['id']]);
            }else{
                $old[$val['id']] = $cur[$val['id']];
            }
        }
        return $old;
    }

    //獲取類名
    abstract function get_class_name();

    //是否勾選
    public function is_checked($val){
        return 'on' === $val;
    }

    //獲取 icon
    public function get_icon($val,$default='fa fa-chart-simple'){
        if(!empty($val)){
            return $val;
        }
        return $default;
    }

    /**
     * 獲取公用區塊頂部程式碼
     * @param $instance
     */
    public function get_common_widget_header($instance){
        $show_title = !array_key_exists('hide_title',$instance) || !$this->is_checked($instance['hide_title'])
        ?>

        <div class="pk-widget p-block <?php echo $instance['classes'] ?>">
            <?php if($show_title): ?>
                <div>
                <span class="t-lg border-bottom border-primary
                puock-text pb-2"><i class="<?php echo $this->get_icon($instance['icon']) ?> mr-1"></i><?php echo $instance['title'] ?></span>
                </div>
            <?php endif; ?>
            <div class="<?php if($show_title): ?>mt20<?php endif; ?>">

        <?php
    }

    /**
     * 獲取公用區塊底部程式碼
     * @param $instance
     */
    public function get_common_widget_footer($instance){
        echo '</div></div>';
    }

    /**
    * 獲取數字值
    * @param $instance
    * @param $key
    * @param int $default
     * @return int
     */
    public function get_num_val($instance, $key, $default=0){
        if(isset($instance[$key]) && !empty($instance[$key]) && is_numeric($instance[$key])){
            return $instance[$key];
        }
        foreach ($this->get_fields() as $f){
            if($f['id']==$key && !empty($f[$key]) && is_numeric($f[$key])){
                return $f[$key];
            }
        }
        return $default;
    }


    /**
    * 通用文章輸出
    * @param $instance
    * @param $posts
    * @return void
    */
    public function comment_post_output($instance, $posts){
        $out = "";
        $is_simple_style = isset($instance['simple']) && $instance['simple'];
        $target = pk_link_target(false);
        foreach ($posts as $post){
            $title = get_the_title($post);
            $link = get_permalink($post);
            if($is_simple_style){
                $out .= '<div class="media-link mt20">
                    <h2 class="t-lg t-line-1" title="'.$title.'">
                        <i class="fa fa-angle-right t-sm c-sub mr-1"></i>
                        <a class="a-link t-w-400 t-md" title="'.$title.'" '.$target.'
                         href="'.$link.'">'.$title.'</a>
                    </h2>
                </div>';
            }else{
                $img = pk_get_lazy_img_info(get_post_images($post), '', 120,80);
                $out .= '<div class="mt10">
                    <div class="widget-common-media-post">
                        <a class="img ww" title="'.$title.'" '.$target.' href="'.$link.'"><img '.$img.' alt="'.$title.'"/></a>
                        <div class="info">
                        <h2 class="t-lg t-line-1"><a class="a-link t-w-400 t-md" title="'.$title.'" '.$target.'
                         href="'.$link.'">'.$title.'</a></h2>
                         <div class="description t-sm c-sub text-3line">'.get_the_excerpt($post).'</div>
                        </div>
                    </div>
                </div>';
            }
        }
        $this->get_common_widget_header($instance);
        echo $out;
        $this->get_common_widget_footer($instance);
        wp_reset_postdata();
    }

    /**
    * 公共文章列表型別欄位
    * @return array
    */
    public function common_post_list_fields($args=array()){
        return $this->merge_common_fields(array_merge(array(
            array('id'=>'title','strip'=>true, 'val'=>$this->title),
            array('id'=>'nums', 'val'=>5),
            array('id'=>'days', 'val'=>31),
            array('id'=>'simple', 'val'=>false),
            array('id'=>'categories','strip'=>true, 'val'=>''),
        ), $args));
    }

    /**
    * 公共文章列表型別表單
    * @return void
    */
    public function common_post_list_form($instance,$callback=null){
        $instance = $this->default_value($instance);
        $this->html_gen($instance, '標題', 'title');
        $this->html_gen($instance, '顯示篇數', 'nums');
        $this->html_gen($instance, '最近 N 天內', 'days');
        $this->html_gen($instance, '指定分類 ID（多個 ID 之間使用「,」進行分隔）', 'categories');
        $this->html_gen($instance, '簡潔風格', 'simple','checkbox',false);
        if($callback){
            $callback();
        }
        $this->merge_common_form($instance);
    }


}

//熱門文章
class puockHotPost extends puockWidgetBase {


    protected $title = "熱門文章";

    protected $pre_title = "根據閱讀量顯示最近的";

    function get_fields(){
        return $this->common_post_list_fields();
    }

    function form( $instance ) {
        $this->common_post_list_form($instance);
    }

    function get_class_name()
    {
        return __CLASS__;
    }

    public function update($cur,$old){
        pk_cache_delete(PKC_WIDGET_HOT_POSTS);
        return $cur;
    }

    function widget( $args, $instance ){
        $posts = pk_cache_get(PKC_WIDGET_HOT_POSTS);
        if(!$posts){
            $days = $this->get_num_val($instance, 'days');
            $nums = $this->get_num_val($instance, 'nums');
            $posts = query_posts(array(
                'post_type'=>'post',
                'post_status'=>'publish',
                'showposts'=>$nums,
                'cat'=>@$instance['categories'],
                'ignore_sticky_posts'=>1,
                'orderby' => 'meta_value_num',
                'meta_type' => 'NUMERIC',
                'meta_query'=> array(
                        'relation' => 'OR',
                        array(
                                'key'=>'views',
                                'compare' => 'EXISTS',
                        ),
                ),
                'date_query'=>array(
                    array(
                        'after'=>date('Y-m-d', strtotime("-{$days} days")),
                        'inclusive'=>true
                    )
                ),
            ));
            wp_reset_query();
            pk_cache_set(PKC_WIDGET_HOT_POSTS, $posts);
        }
        $this->comment_post_output($instance, $posts);
     }
}
add_action( 'widgets_init', function (){ register_widget('puockHotPost'); });

//最新文章
class puockNewPost extends puockWidgetBase {

    protected $title = "最新文章";

    function get_class_name()
    {
        return __CLASS__;
    }

    function get_fields(){
        return $this->common_post_list_fields();
    }

    function form( $instance ) {
        $this->common_post_list_form($instance);
    }

    public function update($cur,$old){
        pk_cache_delete(PKC_WIDGET_NEW_POSTS);
        return $cur;
    }

    function widget( $args, $instance ){
        $posts = pk_cache_get(PKC_WIDGET_NEW_POSTS);
        if(!$posts){
            $days = $this->get_num_val($instance, 'days');
            $nums = $this->get_num_val($instance, 'nums');
            $posts = query_posts(array(
                'post_type'=>'post',
                'post_status'=>'publish',
                'showposts'=>$nums,
                'cat'=>@$instance['categories'],
                'ignore_sticky_posts'=>1,
                'date_query'=>array(
                    array(
                        'after'=>date('Y-m-d', strtotime("-{$days} days")),
                        'inclusive'=>true
                    )
                ),
            ));
            wp_reset_query();
            pk_cache_set(PKC_WIDGET_NEW_POSTS, $posts);
        }
        $this->comment_post_output($instance, $posts);
     }

}
add_action( 'widgets_init', function (){ register_widget('puockNewPost'); });

//熱評文章
class puockHotCommentPost extends puockWidgetBase {

    protected $title = "熱評文章";

    function get_class_name()
    {
        return __CLASS__;
    }

    function get_fields(){
        return $this->common_post_list_fields();
    }

    function form( $instance ) {
        $this->common_post_list_form($instance);
    }

    public function update($cur,$old){
        pk_cache_delete(PKC_WIDGET_HOT_COMMENTS);
        return $cur;
    }

    function widget( $args, $instance ){
        $posts = pk_cache_get(PKC_WIDGET_HOT_COMMENTS);
        if(!$posts){
            $days = $this->get_num_val($instance, 'days');
            $nums = $this->get_num_val($instance, 'nums');
            $posts = query_posts(array(
                'post_type'=>'post',
                'post_status'=>'publish',
                'showposts'=>$nums,
                'cat'=>@$instance['categories'],
                'ignore_sticky_posts'=>1,
                'orderby'=>'comment_count',
                'order' => 'DESC',
                'date_query'=>array(
                    array(
                        'after'=>date('Y-m-d', strtotime("-{$days} days")),
                        'inclusive'=>true
                    )
                ),
            ));
            wp_reset_query();
            pk_cache_set(PKC_WIDGET_HOT_COMMENTS, $posts);
        }
        $this->comment_post_output($instance, $posts);
    }
}
add_action( 'widgets_init', function (){ register_widget('puockHotCommentPost'); });

//讀者墻
class puockReadPerson extends puockWidgetBase {

    protected $title = "讀者墻";

    protected $pre_title = "展示網站的讀者形成";

    function get_class_name()
    {
        return __CLASS__;
    }

    function get_fields(){
        return $this->merge_common_fields(array(
            array('id'=>'title','strip'=>true, 'val'=>$this->title),
            array('id'=>'nums', 'val'=>10),
            array('id'=>'days', 'val'=>31),
        ));
    }

    function form( $instance ) {
        $instance = $this->default_value($instance);
        $this->html_gen($instance, '標題', 'title');
        $this->html_gen($instance, '顯示數量', 'nums');
        $this->html_gen($instance, '最近 N 天內', 'days');
        $this->merge_common_form($instance);
    }

    public function update($cur,$old){
        pk_cache_delete(PKC_WIDGET_READ_PERSONS);
        return $cur;
    }

    function widget( $args, $instance ){
        global $wpdb;
        $authors = pk_cache_get(PKC_WIDGET_READ_PERSONS);
        if(!$authors){
            $days = $this->get_num_val($instance, 'days',31);
            $nums = $this->get_num_val($instance, 'nums');
            $sql = "SELECT count(comment_ID) as num, comment_author_email as mail,comment_author as `name`,comment_author_url as url
                    FROM $wpdb->comments WHERE user_id !=1 AND TO_DAYS(now()) - TO_DAYS(comment_date) < {$days}
                     group by comment_author_email order by num desc limit 0,{$nums}";
            $authors = $wpdb->get_results($sql);
            pk_cache_set(PKC_WIDGET_READ_PERSONS, $authors);
        }
        $this->get_common_widget_header($instance); ?>
        <div class="row puock-text">
            <?php foreach ($authors as $author): ?>
             <div class="col col-12 col-lg-6 pl-0">
                 <div class="p-2 text-truncate text-nowrap">
                    <a href="<?php echo empty($author->url) ? 'javascript:void(0)':pk_go_link($author->url) ?>" class="a-link"
                        <?php echo empty($author->url) ? '':'target="_blank"' ?> rel="nofollow">
                        <img <?php echo pk_get_lazy_img_info(get_avatar_url($author->mail),'md-avatar') ?> alt="<?php echo $author->name?>">
                        <span class="t-sm"><?php echo $author->name?></span>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php  $this->get_common_widget_footer($instance);
     }
}
add_action( 'widgets_init', function (){ register_widget('puockReadPerson'); });

//最新評論
class puockNewComment extends puockWidgetBase {

    protected $title = "最新評論";

    protected $pre_title = "展示網站的";

    function get_class_name()
    {
        return __CLASS__;
    }

    function get_fields(){
        return $this->merge_common_fields(array(
            array('id'=>'title','strip'=>true, 'val'=>$this->title),
            array('id'=>'nums', 'val'=>10),
        ));
    }

    function form( $instance ) {
        $instance = $this->default_value($instance);
        $this->html_gen($instance, '標題', 'title');
        $this->html_gen($instance, '顯示數量', 'nums');
        $this->merge_common_form($instance);
    }

    public function update($cur,$old){
        pk_cache_delete(PKC_WIDGET_NEW_COMMENTS);
        return $cur;
    }

    function widget( $args, $instance ){
        global $wpdb;
        $comments = pk_cache_get(PKC_WIDGET_NEW_COMMENTS);
        if(!$comments){
            // $sql = "SELECT comment_ID as id,comment_post_ID as pid,comment_author_email as mail,comment_author as `name`,comment_author_url as url,comment_content as text
            //         FROM $wpdb->comments WHERE user_id !=1 and comment_approved=1 order by comment_date desc limit 0,{$nums}";
            $nums = $this->get_num_val($instance, 'nums');
            $args = array(
                'number' => $nums,
                'status'  => 'approve',
                'date_query' => array(
                    'before' => 'tomorrow',
                    'inclusive' => true,
                ),    
            );
            $comments = get_comments($args);
            pk_cache_set(PKC_WIDGET_NEW_COMMENTS, $comments);
        }
        $this->get_common_widget_header($instance); ?>
        <div class="min-comments t-md">
            <?php foreach ($comments as $comment): ?>
            <div class="comment t-md t-line-1">
                <img <?php echo pk_get_lazy_img_info(get_avatar_url($comment->comment_author_email),'min-avatar') ?> alt="<?php echo $comment->comment_author ?>">
                <a class="puock-link" <?php pk_link_target() ?> href="<?php echo get_permalink($comment->comment_post_ID).'#comment-'.$comment->comment_ID ?>">
                <span class="ta3 link-hover"><?php echo $comment->comment_author ?></span></a>
                <span class="c-sub t-w-400"><?php echo strip_tags(convert_smilies($comment->comment_content),['img']) ?></span>
            </div>
            <?php endforeach; ?>
        </div>
        <?php  $this->get_common_widget_footer($instance);
     }
}
add_action( 'widgets_init', function (){ register_widget('puockNewComment'); });

//增強文字
class puockStrongText extends puockWidgetBase {

    protected $title = "HTML 文字";

    protected $pre_title = "支援 HTML/JS/CSS";

    function get_class_name()
    {
        return __CLASS__;
    }

    function get_fields(){
        return $this->merge_common_fields(array(
            array('id'=>'title','strip'=>true, 'val'=>$this->title),
            array('id'=>'content', 'val'=>''),
        ));
    }

    function form( $instance ) {
        $instance = $this->default_value($instance);
        $this->html_gen($instance, '標題', 'title');
        $this->html_gen($instance, '內容', 'content','text');
        $this->merge_common_form($instance);
    }

    function widget( $args, $instance ){
        $this->get_common_widget_header($instance);
        echo '<div class="puock-text t-md">'.$instance['content'].'</div>';
        $this->get_common_widget_footer($instance);
     }
}
add_action( 'widgets_init', function (){ register_widget('puockStrongText'); });

//搜尋框
class puockSearch extends puockWidgetBase {

    protected $title = "搜尋框";

    protected $pre_title = "提供便捷快速的";

    function get_class_name()
    {
        return __CLASS__;
    }

    function get_fields(){
        return array(
            array('id'=>'title','strip'=>true, 'val'=>'文章搜尋'),
            array('id'=>'pl', 'val'=>'輸入關鍵字 Enter 搜尋'),
            array('id'=>'hide_title', 'val'=>0),
        );
    }

    function form( $instance ) {
        $instance = $this->default_value($instance);
        $this->html_gen($instance, '標題', 'title');
        $this->html_gen($instance, '搜尋框預留文字', 'pl');
        $this->html_gen($instance, '隱藏標題', 'hide_title','checkbox',false);
    }

    function widget( $args, $instance ){ ?>
        <div class="p-block">
            <?php if(!$this->is_checked($instance['hide_title'])): ?>
            <div>
                <span class="t-lg border-bottom border-primary
                puock-text pb-2"><i class="fa fa-search mr-1"></i><?php echo $instance['title'] ?></span>
            </div>
            <?php endif; ?>
            <div class="<?php if(!$this->is_checked($instance['hide_title'])): ?>mt20<?php endif; ?>">
                <form class="global-search-form" action="<?php echo home_url() ?>" method="get">
                    <div class="input-group">
                        <input type="text" name="s" class="form-control t-md" placeholder="<?php echo $instance['pl'] ?>">
                    </div>
                </form>
            </div>
        </div>
   <?php }
}
add_action( 'widgets_init', function (){ register_widget('puockSearch'); });

//隨機文章
class puockRandomPost extends puockWidgetBase {

    protected $title = "隨機文章";

    protected $pre_title = "顯示指定範圍內的";

    function get_fields(){
        return $this->common_post_list_fields();
    }

    function form( $instance ) {
        $this->common_post_list_form($instance);
    }

    function get_class_name()
    {
        return __CLASS__;
    }

    function widget( $args, $instance ){
        global $wpdb;
        $days = $this->get_num_val($instance, 'days');
        $nums = $this->get_num_val($instance, 'nums');
        $sql = "SELECT * FROM $wpdb->posts WHERE post_type = 'post'
                AND post_status = 'publish' AND TO_DAYS(now()) - TO_DAYS(post_date) < {$days}
                ORDER BY rand() DESC LIMIT 0 , {$nums} ";
        $posts = $wpdb->get_results($sql);
        $this->comment_post_output($instance, $posts);
     }
}
add_action( 'widgets_init', function (){ register_widget('puockRandomPost'); });

//關於博主
class puockAboutAuthor extends puockWidgetBase {

    protected $title = "關於博主";

    protected $pre_title = "顯示部落格的主人-";

    function get_fields(){
        return $this->merge_common_fields(array(
            array('id'=>'title','strip'=>true, 'val'=>$this->title),
            array('id'=>'name', 'val'=>get_bloginfo('name')),
            array('id'=>'email', 'val'=>get_bloginfo('admin_email')),
            array('id'=>'des', 'val'=>get_bloginfo('description')),
            array('id'=>'cover', 'val'=>pk_get_static_url().'/assets/img/show/head-cover.jpg'),
            array('id'=>'show_views', 'val'=>'on'),
            array('id'=>'show_comments', 'val'=>'on'), 
            array('id'=>'show_posts', 'val'=>'on'),
            array('id'=>'show_users', 'val'=>'on'),
        ));
    }

    function form( $instance ) {
        $instance = $this->default_value($instance);
        $this->html_gen($instance, '標題', 'title');
        $this->html_gen($instance, '博主名字', 'name');
        $this->html_gen($instance, '介紹（支援 html/js）', 'des','text');
        $this->html_gen($instance, 'E-mail（用於獲取頭像）', 'email');
        $this->html_gen($instance, '頂部背景圖 url', 'cover');
        $this->html_gen($instance, '顯示使用者數', 'show_users','checkbox',false);
        $this->html_gen($instance, '顯示文章數', 'show_posts','checkbox',false);
        $this->html_gen($instance, '顯示評論數', 'show_comments','checkbox',false);
        $this->html_gen($instance, '顯示閱讀量', 'show_views','checkbox',false);
        $this->merge_common_form($instance);
    }

    function get_class_name()
    {
        return __CLASS__;
    }

    function widget( $args, $instance ){
        global $wpdb;
        $name = $instance['name'];
        $des = $instance['des'];
        $email = $instance['email'];
        $cover = $instance['cover'];
        $show_views = $instance['show_views'] ?? 'on';
        $show_comments = $instance['show_comments'] ?? 'on';
        $show_posts = $instance['show_posts'] ?? 'on';
        $show_users = $instance['show_users'] ?? 'on';

        // 獲取評論數
        $comment_num = pk_cache_get(PKC_TOTAL_COMMENTS);
        if(!$comment_num){
            $comment_num = $wpdb->get_var("SELECT COUNT(comment_ID) FROM $wpdb->comments WHERE comment_approved =1");
            pk_cache_set(PKC_TOTAL_COMMENTS, $comment_num);
        }

        // 獲取文章數
        $posts_count = wp_count_posts()->publish;

        // 獲取用戶數
        $users_count = count_users()['total_users'];

        // 計算要顯示的統計項數量
        $stats_count = 0;
        if($show_views) $stats_count++;
        if($show_comments) $stats_count++;
        if($show_posts) $stats_count++;
        if($show_users) $stats_count++;

        // 根據顯示的統計項數量計算列寬
        $col_width = 12 / ($stats_count > 0 ? $stats_count : 1);
        ?>
        <div class="widget-puock-author widget">
            <div class="header" style="background-image: url('<?php echo $cover ?>')">
                <img <?php echo pk_get_lazy_img_info(pk_get_gravatar($email,false),'avatar') ?>
                 alt="<?php echo $name ?>" title="<?php echo $name ?>">
            </div>
            <div class="content t-md puock-text">
                <div class="text-center p-2">
                    <div class="t-lg"><?php echo $name ?></div>
                    <div class="mt10 t-sm"><?php echo $des ?></div>
                </div>
                <div class="row mt10">
                    <?php if($show_users): ?>
                    <div class="col-<?php echo $col_width ?> text-center">
                        <div class="c-sub t-sm"><?php _e('用戶數', PUOCK) ?></div>
                        <div><?php echo $users_count ?></div>
                    </div>
                    <?php endif; ?>
                    <?php if($show_posts): ?>
                    <div class="col-<?php echo $col_width ?> text-center">
                        <div class="c-sub t-sm"><?php _e('文章數', PUOCK) ?></div>
                        <div><?php echo $posts_count ?></div>
                    </div>
                    <?php endif; ?>
                    <?php if($show_comments): ?>
                    <div class="col-<?php echo $col_width ?> text-center">
                        <div class="c-sub t-sm"><?php _e('評論數', PUOCK) ?></div>
                        <div><?php echo $comment_num ?></div>
                    </div>
                    <?php endif; ?>
                    <?php if($show_views): ?>
                    <div class="col-<?php echo $col_width ?> text-center">
                        <div class="c-sub t-sm"><?php _e('閱讀量', PUOCK) ?></div>
                        <div><?php echo get_total_views() ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php }
}
add_action( 'widgets_init', function (){ register_widget('puockAboutAuthor'); });


//分類目錄
class puockCategory extends puockWidgetBase {


    protected $title = "分類目錄";

    protected $pre_title = "顯示部落格的所有";

    function get_fields(){
        return $this->merge_common_fields(array(
            array('id'=>'title','strip'=>true, 'val'=>$this->title),
            array('id'=>'categories','strip'=>true, 'val'=>''),
        ));
    }

    function form( $instance ) {
        $instance = $this->default_value($instance);
        $this->html_gen($instance, '標題', 'title');
        $this->html_gen($instance, '指定分類 ID（多個 ID 之間使用「,」進行分隔）', 'categories');
        $this->merge_common_form($instance);
    }

    function get_class_name()
    {
        return __CLASS__;
    }

    public function update($cur,$old){
        pk_cache_delete(PKC_WIDGET_CATEGORIES);
        return $cur;
    }

    function widget( $args, $instance ){
        $cat_ids= @$instance['categories'];
        $cats = pk_cache_get(PKC_WIDGET_CATEGORIES);
        if(!$cats){
            $cats = get_categories(array(
                'include'=>$cat_ids
            ));
            pk_cache_set(PKC_WIDGET_CATEGORIES, $cats);
        }
        $this->get_common_widget_header($instance);
        echo '<div class="row t-md">';
        foreach ($cats as $cat){ ?>
            <div class="col col-lg-6 text-center p-2">
            <a href="<?php echo get_category_link($cat) ?>" class="puock-bg p-2 abhl
             d-inline-block w-100" title="<?php echo $cat->name ?>"><?php echo $cat->name ?></a>
            </div>
        <?php }
        echo '</div>';
        $this->get_common_widget_footer($instance);
     }
}
add_action( 'widgets_init', function (){ register_widget('puockCategory'); });

//標籤雲
class puockTagCloud extends puockWidgetBase {


    protected $title = "標籤雲";

    protected $pre_title = "整合部落格的標籤為";

    function get_fields(){
        return $this->merge_common_fields(array(
            array('id'=>'title','strip'=>true, 'val'=>$this->title),
            array('id'=>'max_count','strip'=>true, 'val'=>0),
        ));
    }

    function form( $instance ) {
        $instance = $this->default_value($instance);
        $this->html_gen($instance, '標題', 'title');
        $this->html_gen($instance, '最大顯示數量（0 為不限制）', 'max_count');
        $this->merge_common_form($instance);
    }

    function get_class_name()
    {
        return __CLASS__;
    }

    public function update($cur,$old){
        pk_cache_delete(PKC_WIDGET_TAGS);
        return $cur;
    }

    function widget( $args, $instance ){
        $this->get_common_widget_header($instance);
        echo '<div class="widget-puock-tag-cloud">';
        $tags = pk_cache_get(PKC_WIDGET_TAGS);
        if(!$tags){
            $tags = get_tags();
            pk_cache_set(PKC_WIDGET_TAGS,$tags);
        }
        $max_count = $this->get_num_val($instance, 'max_count');
        if(count($tags) > 0){
            $count = 0;
            foreach ($tags as $tag){
                if ($max_count > 0 && $count >= $max_count){
                    break;
                }
                $link = get_tag_link($tag);
                echo "<a href='{$link}' class='badge d-none d-md-inline-block bg-".pk_get_color_tag()." ahfff'>{$tag->name}</a>";
                $count++;
            }
        }else{
            echo "<span class='c-sub fs14'>暫無標籤</span>";
        }
        echo '</div>';
        $this->get_common_widget_footer($instance);
     }
}
add_action( 'widgets_init', function (){ register_widget('puockTagCloud'); });


//一言一句話
class puockTagHitokoto extends puockWidgetBase {


    protected $title = "一言一句話";

    protected $pre_title = "隨機展示";

    function get_fields(){
        return $this->merge_common_fields(array(
            array('id'=>'title','strip'=>true, 'val'=>$this->title),
            array('id'=>'api','strip'=>true, 'val'=>''),
        ));
    }

    function form( $instance ) {
        $instance = $this->default_value($instance);
        $this->html_gen($instance, '標題', 'title');
        $this->html_gen($instance, '自定義 API', 'api');
        $this->merge_common_form($instance);
    }

    function get_class_name()
    {
        return __CLASS__;
    }

    function widget( $args, $instance ){
        $api = $instance['api'] ?? '';
        $this->get_common_widget_header($instance); ?>
        <div class="widget-puock-hitokoto" data-api="<?php echo $api; ?>">
            <div class="t puock-text">
                <?php echo pk_skeleton() ?>
            </div>
            <div class="fb d-none">-「<span class="f"></span>」</div>
        </div>
       <?php $this->get_common_widget_footer($instance);
     }
}
add_action( 'widgets_init', function (){ register_widget('puockTagHitokoto'); });
