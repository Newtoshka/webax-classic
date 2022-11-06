<?php 

/** Add a ACF option page */
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page([
        'page_title' => 'Ustawienia strony'
    ]);
}