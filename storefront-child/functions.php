<?php
// Cargar estilos del tema padre y del hijo
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('storefront-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('storefront-child-style', get_stylesheet_uri(), ['storefront-style']);
});

function my_function_admin_bar(){
    return false;
}
add_filter( 'show_admin_bar' , 'my_function_admin_bar');

