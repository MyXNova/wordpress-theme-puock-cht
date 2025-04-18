<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv='content-language' content='<?php echo get_locale() ?>'>
    <?php echo pk_icon_mate(); ?>
    <?php echo pk_get_seo_title(); ?>
    <?php if(pk_is_checked('seo_open',true)) get_template_part('inc/seo') ?>
    <?php wp_head(); ?>
    <?php if (!empty(pk_get_option('tj_code_header', ''))): ?>
        <?php echo pk_get_option('tj_code_header', ''); ?>
    <?php endif; ?>
</head>
<body class="puock-<?php echo pk_theme_mode();
echo current_theme_supports('custom-background') ? ' custom-background' : ''; ?>">
<div>
    <?php if (is_single()): ?>
        <div class="progress" id="page-read-progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" aria-valuenow="0" aria-valuemin="0"
                 aria-valuemax="100" role="progressbar"></div>
        </div>
    <?php endif; ?>
    <div id="header-box" class="<?php pk_open_box_animated('animated fadeInDown') ?>"></div>
    <header id="header"
            class="<?php pk_open_box_animated('animated fadeInDown') ?> <?php if (pk_is_checked('nav_blur')) {
                echo 'blur';
            } ?>">
        <div class="navbar navbar-dark shadow-sm">
            <div class="container">
                <a href="<?php echo home_url() ?>" id="logo" class="navbar-brand <?php if(pk_is_checked('logo_loop_light')) echo 'logo-loop-light'; ?>">
                    <?php if (pk_is_checked('on_txt_logo') || empty(pk_get_option('light_logo')) || empty(pk_get_option('dark_logo'))): ?>
                        <span class="puock-text txt-logo"><?php echo pk_get_web_title() ?></span>
                    <?php else: ?>
                        <img id="logo-light" alt="logo" class="w-100 <?php echo pk_theme_light() ? '' : 'd-none' ?>"
                             src="<?php echo pk_get_option('light_logo') ?>">
                        <img id="logo-dark" alt="logo" class="w-100 <?php echo pk_theme_light() ? 'd-none' : '' ?>"
                             src="<?php echo pk_get_option('dark_logo') ?>">
                    <?php endif; ?>
                </a>
                <div class="d-none d-lg-block puock-links">
                    <div id="menus" class="t-md ">
                        <?php echo pk_get_main_menu() ?>
                    </div>
                </div>
                <div class="mobile-menus d-block d-lg-none p-1 puock-text">
                    <i class="fa fa-bars t-md mr-2 mobile-menu-s"></i>
                    <?php if (pk_is_checked('theme_mode_s')): ?>
                        <i class="fa fa-<?php echo((pk_theme_mode() === 'auto' ? 'circle-half-stroke' : (pk_theme_light() ? 'sun' : 'moon'))); ?> colorMode t-md mr-2"></i>
                    <?php endif; ?>
                    <i class="search-modal-btn fa fa-search t-md position-relative" style="top:0.5px"></i>
                </div>
            </div>
        </div>
    </header>
    <div id="search" class="d-none">
        <div class="w-100 d-flex justify-content-center">
            <div id="search-main" class="container p-block">
                <form class="global-search-form" action="<?php echo home_url() ?>">
                    <div class="search-layout">
                        <div class="search-input">
                            <input required type="text" name="s" class="form-control"
                                   placeholder="<?php _e('請輸入搜尋關鍵字', PUOCK) ?>">
                        </div>
                        <div class="search-start">
                            <button type="submit" class="btn-dark btn"><i
                                        class="fa fa-search mr-1"></i><?php _e('搜尋', PUOCK) ?></button>
                        </div>
                        <div class="search-close-btn">
                            <button type="button" class="btn-danger btn ml-1 search-modal-btn"><i
                                        class="fa fa-close"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="mobile-menu" class="d-none">
        <div class="menus">
            <div class="p-block">
                <div class="text-end"><i class="fa fa-close t-xl puock-link mobile-menu-close ta3"></i></div>
                <nav>
                    <?php echo pk_get_main_menu(true) ?>
                </nav>
            </div>
        </div>
    </div>
    <div id="mobile-menu-backdrop" class="modal-backdrop d-none"></div>
    <div id="search-backdrop" class="modal-backdrop d-none"></div>
