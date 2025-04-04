<?php
/*
Template Name: 書籍推薦
*/

$cats = get_post_meta($post->ID,'page_books_id',true);

$books = pk_get_wp_links($cats);

get_header();

?>

<div id="page" class="container mt20">
    <?php get_template_part('templates/box', 'global-top') ?>
    <?php echo pk_breadcrumbs(); while (have_posts()):the_post();?>
        <div id="page-books">
            <div id="page-<?php the_ID() ?>" class="row row-cols-1">
                <div id="posts" class="col-lg-<?php pk_hide_sidebar_out('12','8') ?> col-md-12 <?php pk_open_box_animated('animated fadeInLeft') ?> ">
                    <?php if(!empty(get_the_content())): ?>
                        <div class="mt20 p-block puock-text <?php get_entry_content_class() ?>">
                            <?php the_content() ?>
                        </div>
                    <?php endif;if($books!=null): ?>
                    <div class="puock-text no-style p-block pb-2">
                        <ul id="books-main" class="pl-3 row">
                            <?php foreach ($books as $book): ?>
                            <li class="col-6 col-sm-4 col-md-3 col-lg-auto">
                                <a class="shadow" title="<?php echo $book->link_name ?>" data-bs-toggle="tooltip" href="<?php echo pk_go_link($book->link_url) ?>" target="_blank" rel="nofollow">
                                    <img <?php echo pk_get_lazy_img_info($book->link_description,'cover') ?> alt="<?php echo $book->link_name ?>">
                                    <p class="puock-text text-nowrap text-truncate t-sm mt-1 w-100 mb-0"><?php echo $book->link_name ?></p>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif;comments_template() ?>
                </div>
                <?php get_sidebar() ?>
            </div>
        </div>
    <?php endwhile; ?>
    <?php get_template_part('templates/box', 'global-bottom') ?>
</div>

<?php get_footer() ?>
