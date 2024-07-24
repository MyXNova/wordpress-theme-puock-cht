<?php
/**
 * 文章目錄
 */
?>

<?php if(is_single()):?>
    <div id="post-menus" class="post-menus-box">
        <div id="post-menu-state" class="post-menu-toggle" title="打開或關閉文章目錄">
            <i class="puock-text ta3 fa fa-bars"></i>
        </div>
        <div id="post-menu-content" class="animated slideInRight mini-scroll">
            <div id="post-menu-head">
            </div>
            <div id="post-menu-content-items"></div>
        </div>
    </div>
<?php endif; ?>
