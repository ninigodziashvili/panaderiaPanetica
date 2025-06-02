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

// javascript

function mi_tema_scripts() {
 wp_enqueue_script(
 'main-js',
 get_template_directory_uri() . '/assets/js/main.js',
 array(),
 null,
 true
 );
}
add_action('wp_enqueue_scripts', 'mi_tema_scripts');


// Remove default Storefront branding output
remove_action( 'storefront_header', 'storefront_site_branding', 20 );

// Add your custom branding with logo inside the same div
function custom_storefront_site_branding() {
    ?>
    <div class="site-branding-One">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" style="display: flex; align-items: center;">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/file.png" alt="<?php bloginfo( 'name' ); ?>" style="max-height: 130px; margin-right: 15px;" />
            <h1 class="site-title" style="margin: 0;"><?php bloginfo( 'name' ); ?></h1>
        </a>
        <?php
        $description = get_bloginfo( 'description', 'display' );
        if ( $description || is_customize_preview() ) :
            ?>
            <p class="site-description"><?php echo $description; ?></p>
        <?php endif; ?>
    </div>
    <?php
}
add_action( 'storefront_header', 'custom_storefront_site_branding', 20 );
