<?php
/**
 * WooCommerce specific functions
 */

/**
 * WooCommerce setup function.
 */
function spocky_woocommerce_setup() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'spocky_woocommerce_setup');

/**
 * WooCommerce specific scripts & stylesheets.
 */
function spocky_woocommerce_scripts() {
    wp_enqueue_style('spocky-woocommerce-style', get_template_directory_uri() . '/assets/css/woocommerce.css', array(), _S_VERSION);
}
add_action('wp_enqueue_scripts', 'spocky_woocommerce_scripts');

/**
 * Disable the default WooCommerce stylesheet.
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Add 'woocommerce-active' class to the body tag.
 */
function spocky_woocommerce_active_body_class($classes) {
    $classes[] = 'woocommerce-active';
    return $classes;
}
add_filter('body_class', 'spocky_woocommerce_active_body_class');

/**
 * Related Products Args.
 */
function spocky_woocommerce_related_products_args($args) {
    $defaults = array(
        'posts_per_page' => 3,
        'columns'        => 3,
    );

    $args = wp_parse_args($defaults, $args);

    return $args;
}
add_filter('woocommerce_output_related_products_args', 'spocky_woocommerce_related_products_args');

/**
 * Remove default WooCommerce wrapper.
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

/**
 * Custom WooCommerce wrapper.
 */
function spocky_woocommerce_wrapper_before() {
    ?>
    <div class="woocommerce-content-wrapper">
    <?php
}
add_action('woocommerce_before_main_content', 'spocky_woocommerce_wrapper_before', 10);

function spocky_woocommerce_wrapper_after() {
    ?>
    </div>
    <?php
}
add_action('woocommerce_after_main_content', 'spocky_woocommerce_wrapper_after', 10);

/**
 * Sample implementation of the WooCommerce Mini Cart.
 */
function spocky_woocommerce_cart_link() {
    ?>
    <a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'spocky-games'); ?>">
        <i class="fas fa-shopping-cart"></i>
        <span class="count"><?php echo wp_kses_data(WC()->cart->get_cart_contents_count()); ?></span>
    </a>
    <?php
}

/**
 * Cart Fragments.
 */
function spocky_woocommerce_cart_link_fragment($fragments) {
    ob_start();
    spocky_woocommerce_cart_link();
    $fragments['a.cart-contents'] = ob_get_clean();

    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'spocky_woocommerce_cart_link_fragment');

/**
 * Customize product display
 */
function spocky_woocommerce_product_card_open() {
    echo '<div class="product-card">';
}
add_action('woocommerce_before_shop_loop_item', 'spocky_woocommerce_product_card_open', 5);

function spocky_woocommerce_product_card_close() {
    echo '</div>';
}
add_action('woocommerce_after_shop_loop_item', 'spocky_woocommerce_product_card_close', 15);

function spocky_woocommerce_product_image_wrapper_open() {
    echo '<div class="product-image">';
}
add_action('woocommerce_before_shop_loop_item_title', 'spocky_woocommerce_product_image_wrapper_open', 5);

function spocky_woocommerce_product_image_wrapper_close() {
    // Check if product is on sale
    global $product;
    if ($product->is_on_sale()) {
        echo '<div class="product-tag">' . esc_html__('Promoção', 'spocky-games') . '</div>';
    } elseif ($product->is_featured()) {
        echo '<div class="product-tag">' . esc_html__('Destaque', 'spocky-games') . '</div>';
    } elseif ($product->get_stock_status() === 'outofstock') {
        echo '<div class="product-tag">' . esc_html__('Esgotado', 'spocky-games') . '</div>';
    } elseif ((time() - strtotime($product->get_date_created())) < (30 * DAY_IN_SECONDS)) {
        echo '<div class="product-tag">' . esc_html__('Novo', 'spocky-games') . '</div>';
    }
    
    echo '</div>';
}
add_action('woocommerce_before_shop_loop_item_title', 'spocky_woocommerce_product_image_wrapper_close', 15);

function spocky_woocommerce_product_info_wrapper_open() {
    echo '<div class="product-info">';
}
add_action('woocommerce_shop_loop_item_title', 'spocky_woocommerce_product_info_wrapper_open', 5);

function spocky_woocommerce_product_info_wrapper_close() {
    echo '</div>';
}
add_action('woocommerce_after_shop_loop_item', 'spocky_woocommerce_product_info_wrapper_close', 10);

function spocky_woocommerce_product_description() {
    global $product;
    $short_description = $product->get_short_description();
    if (!empty($short_description)) {
        echo '<p class="product-description">' . wp_kses_post($short_description) . '</p>';
    }
}
add_action('woocommerce_after_shop_loop_item_title', 'spocky_woocommerce_product_description', 15);

/**
 * Change add to cart button text and style
 */
function spocky_woocommerce_custom_button_text($text) {
    return __('Adicionar ao Carrinho', 'spocky-games');
}
add_filter('woocommerce_product_add_to_cart_text', 'spocky_woocommerce_custom_button_text');
add_filter('woocommerce_product_single_add_to_cart_text', 'spocky_woocommerce_custom_button_text');

function spocky_woocommerce_loop_add_to_cart_args($args) {
    $args['class'] = str_replace('button', 'neon-button', $args['class']);
    return $args;
}
add_filter('woocommerce_loop_add_to_cart_args', 'spocky_woocommerce_loop_add_to_cart_args');
