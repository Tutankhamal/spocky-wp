<?php
/**
 * The template for displaying WooCommerce content
 */

get_header();
?>

<main>
    <section class="page-header animated-section">
        <div class="animated-content">
            <h1 class="glitch" data-text="<?php woocommerce_page_title(); ?>"><?php woocommerce_page_title(); ?></h1>
            <?php if (is_shop()): ?>
                <p><?php esc_html_e('Produtos exclusivos Spocky Games', 'spocky-games'); ?></p>
            <?php endif; ?>
        </div>
    </section>
    
    <section class="store-section animated-section">
        <div class="animated-content2">
            <?php woocommerce_content(); ?>
        </div>
    </section>
</main>

<?php
get_footer();
