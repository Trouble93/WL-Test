<?php
get_header();
global $post;

$ID = $post->id;
global $post;
$postID = $post->ID;
$mark ='';
$country = '';
$getCarCat = get_the_terms( $postID, 'mark' );
foreach ( $getCarCat as $carInfo ) {
    $mark= $carInfo->name;
}
$getCarCat = get_the_terms( $postID, 'country' );
foreach ( $getCarCat as $carInfo ) {
   $country = $carInfo->name;
}

?>
<main class="single-post" >
    <div class="post">
    <h1 class="post-title"><?php  the_title(); ?></h1>
        <div class="post-image">
            <?php echo get_the_post_thumbnail();?>
        </div>
        <p class="mark">Mark: <?php echo $mark?></p>
        <p class="country">Country: <?php echo $country?></p>
        <p class="color" style="background-color:<?php echo get_post_meta($post->ID, "color", $single = true) ?>">Color: </p>
        <p class="fuel">Fuel type: <?php echo get_post_meta($post->ID, "select", $single = true); ?></p>
        <p class="power">Power: <?php echo get_post_meta($post->ID, "power", $single = true); ?></p>
        <p class="price">Price: <?php echo get_post_meta($post->ID, "price", $single = true); ?></p>
    </div>
</main>
