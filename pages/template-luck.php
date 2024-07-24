<?php
/*
Template Name: 試試手氣
*/
$posts = get_posts('numberposts=1&orderby=rand');
foreach($posts as $post){
    header("Location:".get_the_permalink($post));
    break;
}