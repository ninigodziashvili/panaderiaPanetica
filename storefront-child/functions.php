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


// Quitar el icono del carrito en el header de Storefront
function quitar_carrito_header_storefront() {
    remove_action( 'storefront_header', 'storefront_header_cart', 60 );
}
add_action( 'init', 'quitar_carrito_header_storefront' );

function anadir_mi_cuenta_y_carrito_header_storefront() {
    if ( function_exists( 'wc_get_page_permalink' ) && function_exists( 'WC' ) ) {
        $my_account_url = wc_get_page_permalink( 'myaccount' );
        $cart_url       = wc_get_cart_url();
        $cart_count     = WC()->cart->get_cart_contents_count();

        echo '<div class="mi-cuenta-custom" style="margin-left:auto; display:flex; gap:20px; align-items:center;">';

        // ✅ New My Account icon (modern circular profile)
        echo '<a href="' . esc_url( $my_account_url ) . '" title="Mi Cuenta" style="text-decoration:none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="white">
                <path d="M12 12c2.7 0 4.9-2.2 4.9-4.9S14.7 2.2 12 2.2 7.1 4.4 7.1 7.1 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.6h19.2v-2.6c0-3.2-6.4-4.8-9.6-4.8z"/>
            </svg>
        </a>';

        // ✅ New Cart icon (modern cart with handle and wheels)
        echo '<a href="' . esc_url( $cart_url ) . '" title="Carrito" class="header-cart-link" style="position:relative; text-decoration:none;">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="white" viewBox="0 0 24 24">
                <path d="M7 18c-1.104 0-1.99.896-1.99 2S5.896 22 7 22s2-.896 2-2-.896-2-2-2zm10 0c-1.104 0-1.99.896-1.99 2s.886 2 1.99 2 2-.896 2-2-.896-2-2-2zM7.16 14l.86-2h8.169c.74 0 1.384-.403 1.725-1.028l3.734-6.972L20.02 2H5.21l-.94-2H0v2h2l3.6 7.59-1.35 2.44C3.52 13.37 4.48 15 6 15h12v-2H7.16z"/>
              </svg>';

        // Badge if cart has items
        if ( $cart_count > 0 ) {
            echo '<span class="cart-count-badge" style="position:absolute; top:-7px; right:-15px; background:red; color:white; font-size:12px; padding:2px 6px; border-radius:50%;">' . esc_html( $cart_count ) . '</span>';
        }

        echo '</a>';
        echo '</div>';
    }
}
add_action( 'storefront_header', 'anadir_mi_cuenta_y_carrito_header_storefront', 60 );


function remove_product_from_cart_by_id( $product_id ) {
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        if ( $cart_item['product_id'] == $product_id ) {
            WC()->cart->remove_cart_item( $cart_item_key );
        }
    }
}