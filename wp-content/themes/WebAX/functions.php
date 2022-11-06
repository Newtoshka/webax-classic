<?php

/** Proper way to enqueue scripts and styles */
function ax_enqueue_scripts() {
    // Versions
    $css_ver = date("m.y", filemtime(get_stylesheet_directory() .'/dist/css/app.css' ));
    $js_ver = date("m.y", filemtime( get_stylesheet_directory() . '/dist/js/app.js' ));

	wp_enqueue_style( 'main-style', get_template_directory_uri().'/dist/css/app.css', null, $css_ver );
	wp_enqueue_script( 'main-script', get_template_directory_uri() . '/dist/js/app.js', null, $js_ver, true );
}

add_action( 'wp_enqueue_scripts', 'ax_enqueue_scripts' );

// Get template part with support functions
get_template_part('/inc/functions_loader');
