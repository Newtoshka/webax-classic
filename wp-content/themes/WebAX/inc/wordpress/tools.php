<?php

/** Register menus */
register_nav_menus([
    "header" => __("Menu header", "webax"),
    "footer" => __("Menu footer", "webax")
]);

/** Menu item image */
function custom_menu_image(array $items, stdClass $args) {
    if( $args->theme_location == 'header' ) {
        foreach( $items as &$item ) {

            if($item->type == 'custom' || $item->menu_item_parent == 0) continue;
            if($item->type == 'post_type') {
                // $product_category_id = wc_get_product_term_ids( $item->object_id, 'product_cat' )[0];
                // $product_category_img = wp_get_attachment_url( get_term_meta( $product_category_id, 'thumbnail_id', true ) );
                
                // $item->title = $item->title."<img class='menu_image' src='$product_category_img'>";
            }else{
                $cat_image = wp_get_attachment_url( get_term_meta( $item->object_id, 'thumbnail_id', true ) );

                $item->title = $item->title."<img class='menu_image' src='$cat_image' height='254' width='227'>";
            }

        }
    }
    return $items;
}

add_filter('wp_nav_menu_objects', 'custom_menu_image', 10, 2);

/** Disable auto update */
add_filter('auto_update_plugin', '__return_false');
add_filter('auto_update_theme', '__return_false');

/** Remove default post button */
//Remove side menu
add_action('admin_menu', 'remove_default_post_type');
function remove_default_post_type()
{
    remove_menu_page('edit.php');
}
// Remove +New post in top Admin Menu Bar
add_action('admin_bar_menu', 'remove_default_post_type_menu_bar', 999);
function remove_default_post_type_menu_bar($wp_admin_bar)
{
    $wp_admin_bar->remove_node('new-post');
}
// Remove Quick Draft Dashboard Widget
add_action('wp_dashboard_setup', 'remove_draft_widget', 999);

function remove_draft_widget()
{
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
}

/** Add slug body class */
function add_slug_body_class($classes)
{
    global $post;

    if (isset($post)) {
        $classes[] = $post->post_type . '-' . $post->post_name;
    }

    return $classes;
}

add_filter('body_class', 'add_slug_body_class');

/** Ajax loadmore */
function load_more_scripts()
{

    global $wp_query;

    // In most cases it is already included on the page and this line can be removed
    // wp_enqueue_script('jquery');

    // register our main script but do not enqueue it yet
    wp_register_script('loadmore', get_stylesheet_directory_uri() . '/files/assets/scripts/loadmore.js', array('jquery'));

    // now the most interesting part
    // we have to pass parameters to myloadmore.js script but we can get the parameters values only in PHP
    // you can define variables directly in your HTML but I decided that the most proper way is wp_localize_script()
    wp_localize_script('loadmore', 'loadmore_params', array(
        'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
        'posts' => json_encode($wp_query->query_vars), // everything about your loop is here
        'current_page' => get_query_var('paged') ? get_query_var('paged') : 1,
        'max_page' => $wp_query->max_num_pages
    ));
    wp_enqueue_script('loadmore');
}
/*
add_action('wp_enqueue_scripts', 'load_more_scripts');
*/
function loadmore_ajax_handler()
{

    // prepare our arguments for the query
    $args = json_decode(stripslashes($_POST['query']), true);
    $args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
    $args['post_status'] = 'publish';
    $args['orderby'] = 'date';
    $args['order'] = 'ASC';
    $args['post_type'] = is_post_type_archive('aktualnosci') ? 'aktualnosci' : (is_post_type_archive('blog') ? 'blog' : 'case-study');

    // it is always better to use WP_Query but not here
    query_posts($args);

    if (have_posts()) :

        // run the loop
        while (have_posts()) : the_post();

            get_template_part('template-parts/post_template', null, ['post_id' => get_the_ID()]);
        // for the test purposes comment the line above and uncomment the below one
        // the_title();

        endwhile;

    endif;
    die; // here we exit the script and even no wp_reset_query() required!
}
/*
add_action('wp_ajax_loadmore', 'loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_loadmore', 'loadmore_ajax_handler'); // wp_ajax_nopriv_{action}
*/
/** Numeric pagination */
function numeric_posts_nav()
{

    if (is_singular())
        return;

    global $wp_query;

    /** Stop execution if there's only 1 page */
    if ($wp_query->max_num_pages <= 1)
        return;

    $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
    $max   = intval($wp_query->max_num_pages);

    /** Add current page to the array */
    if ($paged >= 1)
        $links[] = $paged;

    /** Add the pages around the current page to the array */
    if ($paged >= 3) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if (($paged + 2) <= $max) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    echo '<div class="navigation list-reset-inside cont"><ul class="">' . "\n";

    /** Previous Post Link */
    if (get_previous_posts_link())
        // printf( '<li>%s</li>' . "\n", get_previous_posts_link() );

        /** Link to first page, plus ellipses if necessary */
        if (!in_array(1, $links)) {
            $class = 1 == $paged ? ' class="active"' : '';

            printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');

            if (!in_array(2, $links))
                echo '<li>…</li>';
        }

    /** Link to current page, plus 2 pages in either direction if necessary */
    sort($links);
    foreach ((array) $links as $link) {
        $class = $paged == $link ? ' class="active"' : '';
        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
    }

    /** Link to last page, plus ellipses if necessary */
    if (!in_array($max, $links)) {
        if (!in_array($max - 1, $links))
            echo '<li>…</li>' . "\n";

        $class = $paged == $max ? ' class="active"' : '';
        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
    }

    /** Next Post Link */
    if (get_next_posts_link())
        // printf( '<li>%s</li>' . "\n", get_next_posts_link() );

        echo '</ul></div>' . "\n";
}
