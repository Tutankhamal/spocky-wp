<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 */

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function spocky_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'spocky_pingback_header');

/**
 * Add custom classes to the body
 */
function spocky_body_classes($classes) {
    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    return $classes;
}
add_filter('body_class', 'spocky_body_classes');

/**
 * Create necessary pages if they don't exist
 */
function spocky_create_pages() {
    $pages = array(
        'aovivo' => array(
            'title' => 'Ao Vivo',
            'template' => 'template-aovivo.php'
        ),
        'ondemand' => array(
            'title' => 'On Demand',
            'template' => 'template-ondemand.php'
        ),
        'extras' => array(
            'title' => 'Extras',
            'template' => 'template-extras.php'
        ),
        'novidades' => array(
            'title' => 'Novidades',
            'template' => 'template-novidades.php'
        ),
        'parceiros' => array(
            'title' => 'Parceiros',
            'template' => 'template-parceiros.php'
        ),
        'contato' => array(
            'title' => 'Contato',
            'template' => 'template-contato.php'
        ),
        'loja' => array(
            'title' => 'Loja',
            'template' => 'template-loja.php'
        )
    );
    
    foreach ($pages as $slug => $page) {
        $existing_page = get_page_by_path($slug);
        if (!$existing_page) {
            $page_id = wp_insert_post(array(
                'post_title' => $page['title'],
                'post_name' => $slug,
                'post_status' => 'publish',
                'post_type' => 'page',
                'comment_status' => 'closed'
            ));
            
            if ($page_id && !is_wp_error($page_id)) {
                update_post_meta($page_id, '_wp_page_template', $page['template']);
            }
        }
    }
}
add_action('after_switch_theme', 'spocky_create_pages');

/**
 * Create sample WooCommerce products
 */
function spocky_create_sample_products() {
    if (!class_exists('WooCommerce')) {
        return;
    }
    
    // Check if products already exist
    $existing_products = get_posts(array(
        'post_type' => 'product',
        'posts_per_page' => 1,
        'post_status' => 'publish'
    ));
    
    if (!empty($existing_products)) {
        return; // Products already exist
    }
    
    $sample_products = array(
        array(
            'name' => 'Camiseta Pac-Man Retrô',
            'price' => 49.90,
            'regular_price' => 59.90,
            'description' => 'Camiseta 100% algodão com estampa retrô do Pac-Man. Disponível em várias cores e tamanhos.',
            'short_description' => 'Camiseta 100% algodão com estampa retrô do Pac-Man',
            'sku' => 'CAM-PACMAN-001',
            'featured' => true,
            'categories' => array('Roupas', 'Camisetas')
        ),
        array(
            'name' => 'Caneca Super Mario Bros',
            'price' => 29.90,
            'description' => 'Caneca de porcelana com design clássico do Super Mario Bros. Perfeita para fãs de Nintendo.',
            'short_description' => 'Caneca de porcelana com design clássico do Super Mario',
            'sku' => 'CAN-MARIO-001',
            'categories' => array('Casa', 'Canecas')
        ),
        array(
            'name' => 'Poster Sonic Classic',
            'price' => 19.90,
            'description' => 'Poster de alta qualidade do Sonic clássico. Impressão em papel fotográfico.',
            'short_description' => 'Poster de alta qualidade do Sonic clássico',
            'sku' => 'POS-SONIC-001',
            'categories' => array('Decoração', 'Posters')
        ),
        array(
            'name' => 'Mousepad Tetris',
            'price' => 24.90,
            'description' => 'Mousepad gamer com tema Tetris. Base antiderrapante e superfície lisa.',
            'short_description' => 'Mousepad gamer com tema Tetris',
            'sku' => 'MOU-TETRIS-001',
            'categories' => array('Acessórios', 'Gaming')
        ),
        array(
            'name' => 'Chaveiro Donkey Kong',
            'price' => 14.90,
            'description' => 'Chaveiro colecionável do Donkey Kong em metal com acabamento premium.',
            'short_description' => 'Chaveiro colecionável do Donkey Kong',
            'sku' => 'CHA-DK-001',
            'categories' => array('Colecionáveis', 'Chaveiros')
        ),
        array(
            'name' => 'Adesivos Retrô Pack',
            'price' => 12.90,
            'description' => 'Pack com 20 adesivos de jogos retrô. Resistentes à água e UV.',
            'short_description' => 'Pack com 20 adesivos de jogos retrô',
            'sku' => 'ADE-RETRO-001',
            'categories' => array('Acessórios', 'Adesivos')
        )
    );
    
    foreach ($sample_products as $product_data) {
        // Create product
        $product = new WC_Product_Simple();
        $product->set_name($product_data['name']);
        $product->set_status('publish');
        $product->set_catalog_visibility('visible');
        $product->set_description($product_data['description']);
        $product->set_short_description($product_data['short_description']);
        $product->set_sku($product_data['sku']);
        $product->set_price($product_data['price']);
        $product->set_regular_price($product_data['regular_price'] ?? $product_data['price']);
        if (isset($product_data['regular_price'])) {
            $product->set_sale_price($product_data['price']);
        }
        $product->set_manage_stock(false);
        $product->set_stock_status('instock');
        
        if (isset($product_data['featured']) && $product_data['featured']) {
            $product->set_featured(true);
        }
        
        $product_id = $product->save();
        
        // Set categories
        if (isset($product_data['categories'])) {
            $category_ids = array();
            foreach ($product_data['categories'] as $category_name) {
                $category = get_term_by('name', $category_name, 'product_cat');
                if (!$category) {
                    $category = wp_insert_term($category_name, 'product_cat');
                    if (!is_wp_error($category)) {
                        $category_ids[] = $category['term_id'];
                    }
                } else {
                    $category_ids[] = $category->term_id;
                }
            }
            if (!empty($category_ids)) {
                wp_set_object_terms($product_id, $category_ids, 'product_cat');
            }
        }
    }
}
add_action('after_switch_theme', 'spocky_create_sample_products');

/**
 * Handle contact form submission
 */
function spocky_handle_contact_form() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'spocky_nonce')) {
        wp_die('Security check failed');
    }
    
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $subject = sanitize_text_field($_POST['subject']);
    $message = sanitize_textarea_field($_POST['message']);
    
    // Send email
    $to = get_option('admin_email');
    $email_subject = 'Contato do site: ' . $subject;
    $email_message = "Nome: {$name}\nEmail: {$email}\nAssunto: {$subject}\n\nMensagem:\n{$message}";
    $headers = array('Content-Type: text/html; charset=UTF-8', "From: {$name} <{$email}>");
    
    $sent = wp_mail($to, $email_subject, nl2br($email_message), $headers);
    
    if ($sent) {
        wp_send_json_success('Mensagem enviada com sucesso!');
    } else {
        wp_send_json_error('Erro ao enviar mensagem. Tente novamente.');
    }
}
add_action('wp_ajax_spocky_contact_form', 'spocky_handle_contact_form');
add_action('wp_ajax_nopriv_spocky_contact_form', 'spocky_handle_contact_form');

/**
 * Handle newsletter subscription
 */
function spocky_handle_newsletter() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'spocky_nonce')) {
        wp_die('Security check failed');
    }
    
    $email = sanitize_email($_POST['email']);
    
    // Store in database or send to email service
    $subscribers = get_option('spocky_newsletter_subscribers', array());
    if (!in_array($email, $subscribers)) {
        $subscribers[] = $email;
        update_option('spocky_newsletter_subscribers', $subscribers);
        
        wp_send_json_success('Inscrição realizada com sucesso!');
    } else {
        wp_send_json_error('Este email já está inscrito.');
    }
}
add_action('wp_ajax_spocky_newsletter', 'spocky_handle_newsletter');
add_action('wp_ajax_nopriv_spocky_newsletter', 'spocky_handle_newsletter');
