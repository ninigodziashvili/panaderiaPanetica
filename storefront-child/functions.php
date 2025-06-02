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


function add_link_in_col_full_div() {
    echo '<a href="' . esc_url( home_url( '/my-account/' ) ) . '" class="menu-header-menuk">Visit My Account</a>';
}
// Replace 'your_hook_name' with the actual hook fired inside .col-full
add_action( 'your_hook_name', 'add_link_in_col_full_div' );

function add_my_account_link_next_to_cart() {
    // Only show if user is logged in
    if ( is_user_logged_in() ) {
        $account_url = wc_get_page_permalink( 'myaccount' );
        echo '<a href="' . esc_url( $account_url ) . '" class="header-my-account" style="margin-left: 15px;">My Account</a>';
    } else {
        // If guest, maybe show login link
        $login_url = wp_login_url();
        echo '<a href="' . esc_url( $login_url ) . '" class="header-login" style="margin-left: 15px;">Login</a>';
    }
}

add_action( 'wp_footer', 'add_my_account_link_next_to_cart' );

// Quitar el icono del carrito en el header de Storefront
function quitar_carrito_header_storefront() {
    remove_action( 'storefront_header', 'storefront_header_cart', 60 );
}
add_action( 'init', 'quitar_carrito_header_storefront' );


function anadir_mi_cuenta_header_storefront() {
    $my_account_url = wc_get_page_permalink( 'myaccount' );
    echo '<div class="mi-cuenta-custom" style="margin-left:15px;">
        <a href="' . esc_url( $my_account_url ) . '" title="Mi Cuenta" style="text-decoration:none; color:#fff;">
            <span class="dashicons dashicons-admin-users" style="font-size:28px; color:#fff;"></span>
            <span class="screen-reader-text">Mi Cuenta</span>
        </a>
        
    </div>';
}
add_action( 'storefront_header', 'anadir_mi_cuenta_header_storefront', 60 );

function cargar_dashicons_en_frontend() {
    wp_enqueue_style( 'dashicons' );
}
add_action( 'wp_enqueue_scripts', 'cargar_dashicons_en_frontend' );
