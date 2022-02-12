<?php
/* Template Name: Homepage*/
get_header();
?>
<div class="home-page">
    <?php
    if( have_posts() ):
    while( have_posts() ): the_post();
    echo do_shortcode('[homepage_posts]');

    endwhile;
    endif;?>
</div>