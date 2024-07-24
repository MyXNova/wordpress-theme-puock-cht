<?php

include '../../../../wp-blog-header.php';
pk_set_custom_seo("連結跳轉");
$url = $_GET['to'] ?? '';
$name = $_GET['name'] ?? '';
if (!empty($name)) {
    $name = base64_decode(str_replace(' ','+',$name));
}
$error = null;
if (empty($url)) {
    $error = "目標網址為空，無法進行跳轉";
} else {
    $url = htmlentities(base64_decode($url));
    if (strpos($url, "https://") !== 0 && strpos($url, "http://") !== 0) {
        $error = "跳轉連結協議有誤";
    } else {
        if (pk_is_cur_site($url)) {
            header("Location:" . $url);
            exit();
        }
    }
}

get_header();


?>

<div id="content" class="mt20 container min-height-container">

    <?php echo pk_breadcrumbs() ?>

    <div class="text-center p-block puock-text">
        <h3 class="mt20">跳轉提示</h3>
        <?php if (!empty($error)): ?>
            <p class="mt20"><?php echo $error ?></p>
        <?php else: ?>
            <p class="mt20">
                <span>您即將離開<?php echo get_bloginfo('name') ?>跳轉至</span><?php echo empty($name) ? $url : $name; ?><span> ，確定進入嗎？</span>
            </p>
        <?php endif; ?>
        <div class="text-center mt20">
            <a rel="nofollow" href="<?php echo $url; ?>" class="btn btn-ssm btn-primary"><i
                        class="fa-regular fa-paper-plane"></i>&nbsp;立即進入</a>
            <a href="<?php echo home_url() ?>" class="btn btn-ssm btn-secondary"><i
                        class="fa fa-home"></i>&nbsp;返回首頁</a>
        </div>
    </div>
</div>


<?php get_footer() ?>
