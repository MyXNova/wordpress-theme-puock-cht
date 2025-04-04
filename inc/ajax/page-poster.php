<?php

if (pk_is_checked('post_poster_open')) {
    pk_ajax_register('pk_poster', 'pk_poster_page_callback', true);
}
function pk_poster_page_callback()
{
    $id = $_REQUEST['id'];
    if (empty($id)) {
        wp_die('無效的文章 ID：' . $id);
    }
    $post = get_post($id);
    if (empty($post)) {
        wp_die('無效的文章 ID：' . $id);
    }
    setup_postdata($post);
    $title = get_the_title($post);
    $qrcode_url = PUOCK_ABS_URI . pk_post_qrcode(get_permalink($post));
    $el_id = 'post-poster-main-' . $post->ID;
    ?>

    <div class="post-poster">
        <div class="post-poster-main" id="<?php echo $el_id; ?>">
            <div class="cover">
                <img crossOrigin="anonymous" src="<?php echo pk_get_img_thumbnail_src(get_post_images($post),640,320) ?>" alt="poster">
            </div>
            <div class="content">
                <p class="title mt20 fs16"><?php echo $title ?></p>
                <p class="excerpt text-3line fs14 mt20 c-sub"><?php echo get_the_excerpt() ?></p>
                <div class="info mt20">
                    <img class="qrcode" src="<?php echo $qrcode_url ?>" alt="<?php echo $title ?>">
                    <?php if (!pk_is_checked('on_txt_logo') || empty(pk_get_option('light_logo'))): ?>
                        <img class="logo" src="<?php echo pk_get_option('light_logo') ?>" alt="logo">
                    <?php else: ?>
                        <p class="tip c-sub fs14">@<?php echo pk_get_web_title() ?></p>
                    <?php endif; ?>
                </div>
                <p class="tip c-sub fs12 mt20 p-flex-center"><i class="fa-solid fa-qrcode"></i>&nbsp;長按識別 QRCode 檢視文章內容</p>
            </div>
        </div>
    </div>
    <!--    <div class="mt20 d-flex justify-content-center">-->
    <!--        <div class="btn btn-primary btn-sm"><i class="fa fa-download"></i> 下載海報</div>-->
    <!--    </div>-->
    <script>
        $(function () {
            const i = window.Puock.startLoading();
            html2canvas(document.querySelector("#<?php echo $el_id; ?>"), {
                allowTaint: true,
                useCORS: true,
                backgroundColor:'#ffffff'
            }).then(canvas => {
                const el = $("#<?php echo $el_id; ?>");
                el.show();
                el.html("<img class='result' src='" + canvas.toDataURL("image/png") + "' alt='<?php echo $title ?>'>");
                window.Puock.stopLoading(i);
            }).catch(err => {
                console.error(err)
                window.Puock.toast("產生海報失敗，請到 Console 檢視錯誤資訊", TYPE_DANGER);
            });
        })
    </script>
    <?php

    wp_die();
}
