<?php
/**
 * Template Name: Loja
 */

get_header();
?>

<main>
    <section class="page-header animated-section">
        <div class="animated-content">
            <h1 class="glitch" data-text="<?php esc_attr_e('Loja Spocky Games', 'spocky-games'); ?>"><?php esc_html_e('Loja Spocky Games', 'spocky-games'); ?></h1>
            <p><?php esc_html_e('Produtos exclusivos e colecionáveis retrô', 'spocky-games'); ?></p>
        </div>
    </section>

    <?php if (class_exists('WooCommerce')) : ?>
        <section class="store-section animated-section">
            <div class="animated-content2">
                <div class="filter-bar">
                    <div class="filter-group">
                        <label for="category-filter"><?php esc_html_e('Categoria:', 'spocky-games'); ?></label>
                        <select id="category-filter">
                            <option value=""><?php esc_html_e('Todas as categorias', 'spocky-games'); ?></option>
                            <?php
                            $product_categories = get_terms(array(
                                'taxonomy' => 'product_cat',
                                'hide_empty' => false,
                            ));
                            
                            if (!is_wp_error($product_categories)) {
                                foreach ($product_categories as $category) :
                                    if ($category->slug !== 'uncategorized') :
                            ?>
                                    <option value="<?php echo esc_attr($category->slug); ?>"><?php echo esc_html($category->name); ?></option>
                            <?php 
                                    endif;
                                endforeach;
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="price-filter"><?php esc_html_e('Preço:', 'spocky-games'); ?></label>
                        <select id="price-filter">
                            <option value=""><?php esc_html_e('Todos os preços', 'spocky-games'); ?></option>
                            <option value="0-50"><?php esc_html_e('Até R$ 50', 'spocky-games'); ?></option>
                            <option value="50-100"><?php esc_html_e('R$ 50 - R$ 100', 'spocky-games'); ?></option>
                            <option value="100-200"><?php esc_html_e('R$ 100 - R$ 200', 'spocky-games'); ?></option>
                            <option value="200+"><?php esc_html_e('Acima de R$ 200', 'spocky-games'); ?></option>
                        </select>
                    </div>
                    
                    <div class="search-bar">
                        <input type="text" id="product-search" placeholder="<?php esc_attr_e('Buscar produtos...', 'spocky-games'); ?>">
                        <button type="button" id="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <div class="products-grid" id="products-container">
                    <?php
                    // Get WooCommerce products
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 12,
                        'post_status' => 'publish',
                        'meta_query' => array(
                            array(
                                'key' => '_visibility',
                                'value' => array('catalog', 'visible'),
                                'compare' => 'IN'
                            )
                        )
                    );
                    
                    $products = new WP_Query($args);
                    
                    if ($products->have_posts()) :
                        while ($products->have_posts()) : $products->the_post();
                            global $product;
                            if (!$product || !$product->is_visible()) continue;
                            
                            $categories = wp_get_post_terms(get_the_ID(), 'product_cat', array('fields' => 'slugs'));
                            $category_string = is_array($categories) ? implode(' ', $categories) : '';
                    ?>
                        <div class="product-card" data-category="<?php echo esc_attr($category_string); ?>" data-price="<?php echo esc_attr($product->get_price()); ?>">
                            <div class="product-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('medium'); ?>
                                    <?php else : ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder-product.webp" alt="<?php the_title(); ?>">
                                    <?php endif; ?>
                                </a>
                                
                                <?php if ($product->is_on_sale()) : ?>
                                    <div class="product-tag sale"><?php esc_html_e('Promoção', 'spocky-games'); ?></div>
                                <?php elseif ($product->is_featured()) : ?>
                                    <div class="product-tag featured"><?php esc_html_e('Destaque', 'spocky-games'); ?></div>
                                <?php elseif (!$product->is_in_stock()) : ?>
                                    <div class="product-tag out-of-stock"><?php esc_html_e('Esgotado', 'spocky-games'); ?></div>
                                <?php elseif ((time() - strtotime($product->get_date_created())) < (30 * DAY_IN_SECONDS)) : ?>
                                    <div class="product-tag new"><?php esc_html_e('Novo', 'spocky-games'); ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="product-info">
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                
                                <?php if ($product->get_short_description()) : ?>
                                    <p class="product-description"><?php echo wp_kses_post($product->get_short_description()); ?></p>
                                <?php endif; ?>
                                
                                <div class="product-price">
                                    <?php if ($product->is_on_sale()) : ?>
                                        <span class="old-price"><?php echo wc_price($product->get_regular_price()); ?></span>
                                    <?php endif; ?>
                                    <?php echo wc_price($product->get_price()); ?>
                                </div>
                                
                                <?php if ($product->is_in_stock()) : ?>
                                    <a href="<?php echo esc_url($product->add_to_cart_url()); ?>" 
                                       class="neon-button add-to-cart-btn" 
                                       data-product-id="<?php echo esc_attr($product->get_id()); ?>">
                                        <?php esc_html_e('Adicionar ao Carrinho', 'spocky-games'); ?>
                                    </a>
                                <?php else : ?>
                                    <button class="neon-button" disabled><?php esc_html_e('Esgotado', 'spocky-games'); ?></button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php 
                        endwhile;
                        wp_reset_postdata();
                    else :
                        // Sample products if no WooCommerce products exist
                        $sample_products = array(
                            array(
                                'name' => 'Camiseta Pac-Man Retrô',
                                'price' => 'R$ 49,90',
                                'old_price' => 'R$ 59,90',
                                'image' => get_template_directory_uri() . '/assets/produtos/camiseta-pacman.webp',
                                'tag' => 'Promoção',
                                'description' => 'Camiseta 100% algodão com estampa retrô do Pac-Man',
                                'category' => 'roupas camisetas'
                            ),
                            array(
                                'name' => 'Caneca Super Mario Bros',
                                'price' => 'R$ 29,90',
                                'image' => get_template_directory_uri() . '/assets/produtos/caneca-mario.webp',
                                'tag' => 'Novo',
                                'description' => 'Caneca de porcelana com design clássico do Super Mario',
                                'category' => 'casa canecas'
                            ),
                            array(
                                'name' => 'Poster Sonic Classic',
                                'price' => 'R$ 19,90',
                                'image' => get_template_directory_uri() . '/assets/produtos/poster-sonic.webp',
                                'tag' => 'Destaque',
                                'description' => 'Poster de alta qualidade do Sonic clássico',
                                'category' => 'decoracao posters'
                            ),
                            array(
                                'name' => 'Mousepad Tetris',
                                'price' => 'R$ 24,90',
                                'image' => get_template_directory_uri() . '/assets/produtos/mousepad-tetris.webp',
                                'description' => 'Mousepad gamer com tema Tetris',
                                'category' => 'acessorios gaming'
                            ),
                            array(
                                'name' => 'Chaveiro Donkey Kong',
                                'price' => 'R$ 14,90',
                                'image' => get_template_directory_uri() . '/assets/produtos/chaveiro-dk.webp',
                                'description' => 'Chaveiro colecionável do Donkey Kong',
                                'category' => 'colecionaveis chaveiros'
                            ),
                            array(
                                'name' => 'Adesivos Retrô Pack',
                                'price' => 'R$ 12,90',
                                'image' => get_template_directory_uri() . '/assets/produtos/adesivos-retro.webp',
                                'description' => 'Pack com 20 adesivos de jogos retrô',
                                'category' => 'acessorios adesivos'
                            )
                        );
                        
                        foreach ($sample_products as $product) :
                            $price_numeric = floatval(str_replace(array('R$ ', ','), array('', '.'), $product['price']));
                    ?>
                        <div class="product-card" data-category="<?php echo esc_attr($product['category']); ?>" data-price="<?php echo esc_attr($price_numeric); ?>">
                            <div class="product-image">
                                <img src="<?php echo esc_url($product['image']); ?>" alt="<?php echo esc_attr($product['name']); ?>">
                                <?php if (isset($product['tag'])) : ?>
                                    <div class="product-tag"><?php echo esc_html($product['tag']); ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="product-info">
                                <h3><?php echo esc_html($product['name']); ?></h3>
                                <p class="product-description"><?php echo esc_html($product['description']); ?></p>
                                <div class="product-price">
                                    <?php if (isset($product['old_price'])) : ?>
                                        <span class="old-price"><?php echo esc_html($product['old_price']); ?></span>
                                    <?php endif; ?>
                                    <?php echo esc_html($product['price']); ?>
                                </div>
                                <button class="neon-button add-to-cart-btn"><?php esc_html_e('Adicionar ao Carrinho', 'spocky-games'); ?></button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <?php if (isset($products) && $products->max_num_pages > 1) : ?>
                <div class="pagination">
                    <?php
                    echo paginate_links(array(
                        'total' => $products->max_num_pages,
                        'prev_text' => '<i class="fas fa-chevron-left"></i>',
                        'next_text' => '<i class="fas fa-chevron-right"></i>',
                    ));
                    ?>
                </div>
                <?php endif; ?>
            </div>
        </section>
    <?php else : ?>
        <section class="store-section animated-section">
            <div class="animated-content2">
                <div class="woocommerce-info">
                    <h2><?php esc_html_e('Loja em Desenvolvimento', 'spocky-games'); ?></h2>
                    <p><?php esc_html_e('Nossa loja está sendo preparada com produtos exclusivos! Em breve você poderá adquirir camisetas, canecas, adesivos e muito mais com temática retrô.', 'spocky-games'); ?></p>
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('contato'))); ?>" class="neon-button">
                        <?php esc_html_e('Entre em Contato', 'spocky-games'); ?>
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="featured-content animated-section">
        <div class="animated-content2">
            <h2 class="section-title"><?php esc_html_e('Por que Comprar Conosco?', 'spocky-games'); ?></h2>
            <div class="featured-grid">
                <div class="featured-item">
                    <i class="fas fa-shipping-fast" style="font-size: 3rem; color: var(--primary-color); margin-bottom: 1rem;"></i>
                    <h3><?php esc_html_e('Entrega Rápida', 'spocky-games'); ?></h3>
                    <p><?php esc_html_e('Produtos enviados em até 2 dias úteis para todo o Brasil.', 'spocky-games'); ?></p>
                </div>
                
                <div class="featured-item">
                    <i class="fas fa-medal" style="font-size: 3rem; color: var(--secondary-color); margin-bottom: 1rem;"></i>
                    <h3><?php esc_html_e('Qualidade Premium', 'spocky-games'); ?></h3>
                    <p><?php esc_html_e('Produtos de alta qualidade com designs exclusivos e materiais duráveis.', 'spocky-games'); ?></p>
                </div>
                
                <div class="featured-item">
                    <i class="fas fa-heart" style="font-size: 3rem; color: var(--accent-color); margin-bottom: 1rem;"></i>
                    <h3><?php esc_html_e('Feito com Amor', 'spocky-games'); ?></h3>
                    <p><?php esc_html_e('Cada produto é pensado e criado especialmente para fãs de jogos retrô.', 'spocky-games'); ?></p>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoryFilter = document.getElementById('category-filter');
    const priceFilter = document.getElementById('price-filter');
    const searchInput = document.getElementById('product-search');
    const searchBtn = document.getElementById('search-btn');
    const productsContainer = document.getElementById('products-container');
    
    function filterProducts() {
        const selectedCategory = categoryFilter ? categoryFilter.value : '';
        const selectedPrice = priceFilter ? priceFilter.value : '';
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        const products = productsContainer ? productsContainer.querySelectorAll('.product-card') : [];
        
        products.forEach(product => {
            let showProduct = true;
            
            // Category filter
            if (selectedCategory && product.dataset.category && !product.dataset.category.includes(selectedCategory)) {
                showProduct = false;
            }
            
            // Price filter
            if (selectedPrice && product.dataset.price) {
                const price = parseFloat(product.dataset.price);
                if (selectedPrice.includes('-')) {
                    const [min, max] = selectedPrice.split('-').map(p => parseFloat(p));
                    if (price < min || price > max) showProduct = false;
                } else if (selectedPrice.includes('+')) {
                    const min = parseFloat(selectedPrice.replace('+', ''));
                    if (price < min) showProduct = false;
                }
            }
            
            // Search filter
            if (searchTerm) {
                const productName = product.querySelector('h3') ? product.querySelector('h3').textContent.toLowerCase() : '';
                const productDesc = product.querySelector('.product-description');
                const description = productDesc ? productDesc.textContent.toLowerCase() : '';
                
                if (!productName.includes(searchTerm) && !description.includes(searchTerm)) {
                    showProduct = false;
                }
            }
            
            product.style.display = showProduct ? 'block' : 'none';
        });
    }
    
    // Event listeners
    if (categoryFilter) categoryFilter.addEventListener('change', filterProducts);
    if (priceFilter) priceFilter.addEventListener('change', filterProducts);
    if (searchInput) searchInput.addEventListener('input', filterProducts);
    if (searchBtn) searchBtn.addEventListener('click', filterProducts);
    
    // Add to cart functionality
    const addToCartBtns = document.querySelectorAll('.add-to-cart-btn');
    addToCartBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const originalText = this.textContent;
            this.textContent = '<?php esc_js_e('Adicionando...', 'spocky-games'); ?>';
            this.disabled = true;
            
            // Simulate add to cart
            setTimeout(() => {
                this.textContent = '<?php esc_js_e('Adicionado!', 'spocky-games'); ?>';
                
                setTimeout(() => {
                    this.textContent = originalText;
                    this.disabled = false;
                }, 1000);
            }, 800);
        });
    });
});
</script>

<?php
get_footer();
