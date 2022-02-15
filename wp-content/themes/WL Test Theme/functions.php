<?php
function styles_theme_name_scripts()
{

    wp_enqueue_style('style-name', get_stylesheet_uri());
    wp_enqueue_style('app-style', get_template_directory_uri() . '/dest/app.css');
}

add_action('wp_enqueue_scripts', 'styles_theme_name_scripts');


add_theme_support('custom-logo', [
    'height' => 110,
    'width' => 242,
    'flex-width' => false,
    'flex-height' => false,
    'header-text' => '',
    'unlink-homepage-logo' => false,
]);


add_action('init', 'wpshout_register_cpts');

function wpshout_register_cpts()
{
    $args = array(
        'public' => true,
        'label' => 'Car',
        'has_archive' => true,
        'rewrite' => array('slug' => 'car'),
        'supports' => array(
            'title',
            'editor',
            'author',
            'thumbnail',
            'excerpt',
            'comments',
            'revisions',
        ),
    );
    register_post_type('car', $args);
}


add_action('init', 'wpshout_add_taxonomies_to_courses');
function wpshout_add_taxonomies_to_courses()
{
    register_taxonomy('country', ['car'], [
        'label' => __('country', 'txtdomain'),
        'hierarchical' => false,
        'rewrite' => ['slug' => 'country'],
        'show_admin_column' => true,
        'labels' => [
            'singular_name' => __('country', 'txtdomain'),
            'all_items' => __('All country', 'txtdomain'),
            'edit_item' => __('country', 'txtdomain'),
            'view_item' => __('View country', 'txtdomain'),
            'update_item' => __('Update country', 'txtdomain'),
            'add_new_item' => __('Add New country', 'txtdomain'),
            'new_item_name' => __('New country Name', 'txtdomain'),
            'search_items' => __('Search country', 'txtdomain'),
            'popular_items' => __('Popular country', 'txtdomain'),
            'separate_items_with_commas' => __('Separate country with comma', 'txtdomain'),
            'choose_from_most_used' => __('Choose from most used country', 'txtdomain'),
            'not_found' => __('No country found', 'txtdomain'),
        ]
    ]);
    register_taxonomy('mark', ['car'], [
        'label' => __('mark', 'txtdomain'),
        'hierarchical' => false,
        'rewrite' => ['slug' => 'mark'],
        'show_admin_column' => true,
        'labels' => [
            'singular_name' => __('mark', 'txtdomain'),
            'all_items' => __('All mark', 'txtdomain'),
            'edit_item' => __('mark', 'txtdomain'),
            'view_item' => __('View mark', 'txtdomain'),
            'update_item' => __('Update mark', 'txtdomain'),
            'add_new_item' => __('Add New mark', 'txtdomain'),
            'new_item_name' => __('New mark Name', 'txtdomain'),
            'search_items' => __('Search mark', 'txtdomain'),
            'popular_items' => __('Popular mark', 'txtdomain'),
            'separate_items_with_commas' => __('Separate mark with comma', 'txtdomain'),
            'choose_from_most_used' => __('Choose from most used mark', 'txtdomain'),
            'not_found' => __('No mark found', 'txtdomain'),
        ]
    ]);
    register_taxonomy_for_object_type('country', 'car');
    register_taxonomy_for_object_type('mark', 'car');
}


add_filter('pre_get_posts', 'wpshout_add_custom_post_types_to_query');
function wpshout_add_custom_post_types_to_query($query)
{
    if (
        is_archive() &&
        $query->is_main_query() &&
        empty($query->query_vars['suppress_filters'])
    ) {
        $query->set('post_type', array(
            'post',
            'car'
        ));
    }
}

add_theme_support('post-thumbnails');

add_action('add_meta_boxes', 'my_extra_fields', 1);

function my_extra_fields()
{
    add_meta_box('extra_fields', 'Extra fields', 'extra_fields_box_func', 'car', 'normal', 'high');
}


function extra_fields_box_func($post)
{
    ?>
    <p>Color
        <input type="color" name="extra[color]"
               style="width:10%;height:50px;"><?php echo get_post_meta($post->ID, 'color', 1); ?></input>
    </p>
    <p>Power<label><input type="number" name="extra[power]" value="<?php echo get_post_meta($post->ID, 'power', 1); ?>"
                          style="width:50%"/></label></p>

    <p>Price
        <input type="number" name="extra[price]"
               style="width:100%;height:50px;"><?php echo get_post_meta($post->ID, 'price', 1); ?></input>
    </p>
    <p>Fuel type<select name="extra[select]">
            <?php $sel_v = get_post_meta($post->ID, 'select', 1); ?>
            <option value="0">----</option>
            <option value="electric" <?php selected($sel_v, '1') ?> >Electric</option>
            <option value="diesel" <?php selected($sel_v, '2') ?> >Diesel fuel</option>
            <option value="petrol" <?php selected($sel_v, '3') ?> >Petrol</option>
        </select></p>

    <input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>"/>
    <?php
}


function my_extra_fields_update($post_id)
{

    if (
        empty($_POST['extra'])
        || !wp_verify_nonce($_POST['extra_fields_nonce'], __FILE__)
        || wp_is_post_autosave($post_id)
        || wp_is_post_revision($post_id)
    )
        return false;


    $_POST['extra'] = array_map('sanitize_text_field', $_POST['extra']);
    foreach ($_POST['extra'] as $key => $value) {
        if (empty($value)) {
            delete_post_meta($post_id, $key);
            continue;
        }

        update_post_meta($post_id, $key, $value);
    }

    return $post_id;
}
add_action('save_post', 'my_extra_fields_update', 0);

function mytheme_customize_register($wp_customize)
{
    $wp_customize->add_section(
        'data_site_section',
        array(
            'title' => 'Phone number',
            'capability' => 'edit_theme_options',
            'description' => "Тут можно указать данные сайта"
        )
    );

    $wp_customize->add_setting(
        'site_telephone',
        array(
            'default' => '',
            'type' => 'option'
        )
    );
    $wp_customize->add_control(
        'site_telephone_control',
        array(
            'type' => 'number',
            'label' => "Phone number",
            'section' => 'data_site_section',
            'settings' => 'site_telephone'
        )
    );
}

add_action('customize_register', 'mytheme_customize_register');


add_shortcode('homepage_posts', 'posts_view');
function posts_view()
{
    ?>

    <div class="posts">
        <?php ob_start(); ?>
    <?php $args = [
    'posts_per_page' => 10,
    'post_type'      => 'car',
    'orderby'        => 'date',
];

    $query = new WP_Query($args);
    ?>
    <?php
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post(); ?>
            <div class="post">
                <a href="<?php echo get_post_permalink(); ?>"><?php the_title(); ?></a>
            </div>
        <?php } ?>
    </div>

    <?php
    $html = ob_get_contents();
    ob_end_clean();
    return $html;
}
}

add_filter( 'my_string_filter_hook_tag_name', 'do_shortcode' );