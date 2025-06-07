<?php
/**
 * Template Name: Novidades
 *
 * @package Spocky_Games
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <?php
        while ( have_posts() ) :
            the_post();
            ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <?php
                    the_content();

                    // Query for the 'novidades' custom post type
                    $args = array(
                        'post_type'      => 'novidades',
                        'posts_per_page' => -1, // Display all 'novidades' posts
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                    );

                    $novidades_query = new WP_Query( $args );

                    if ( $novidades_query->have_posts() ) {
                        echo '<div class="novidades-container">';
                        while ( $novidades_query->have_posts() ) {
                            $novidades_query->the_post();
                            ?>
                            <div class="novidade-item">
                                <a href="<?php the_permalink(); ?>">
                                    <?php if ( has_post_thumbnail() ) {
                                        the_post_thumbnail( 'medium' ); // Or any other appropriate size
                                    } ?>
                                    <h2><?php the_title(); ?></h2>
                                    <p class="novidade-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 20, '...' ); ?></p>
                                </a>
                            </div>
                            <?php
                        }
                        echo '</div>';
                        wp_reset_postdata(); // Restore original Post Data
                    } else {
                        echo '<p>' . esc_html__( 'No novidades found.', 'spocky-games' ) . '</p>';
                    }
                    ?>
                </div><!-- .entry-content -->

                <footer class="entry-footer">
                    <?php
                    edit_post_link(
                        sprintf(
                            wp_kses(
                                /* translators: %s: Name of current post. Only visible to screen readers */
                                __( 'Edit <span class="screen-reader-text">%s</span>', 'spocky-games' ),
                                array(
                                    'span' => array(
                                        'class' => array(),
                                    ),
                                )
                            ),
                            get_the_title()
                        ),
                        '<span class="edit-link">',
                        '</span>'
                    );
                    ?>
                </footer><!-- .entry-footer -->
            </article><!-- #post-<?php the_ID(); ?> -->

            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;

        endwhile; // End of the loop.
        ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php
// Adicionar a seção de newsletter no final, antes do get_footer():
?>
<section class="newsletter-section animated-section">
    <div class="animated-content2">
        <div class="newsletter-container">
            <div class="newsletter-content">
                <h2><?php esc_html_e('Receba Novidades', 'spocky-games'); ?></h2>
                <p><?php esc_html_e('Cadastre-se em nossa newsletter e seja o primeiro a saber sobre novos vídeos, lives e conteúdos exclusivos!', 'spocky-games'); ?></p>
                
                <form id="newsletterForm" class="newsletter-form" method="post">
                    <?php wp_nonce_field('spocky_newsletter_nonce', 'newsletter_nonce'); ?>
                    <input type="hidden" name="action" value="spocky_newsletter_signup">
                    <input type="email" name="newsletter_email" placeholder="<?php esc_attr_e('Seu melhor email', 'spocky-games'); ?>" required>
                    <button type="submit"><?php esc_html_e('Cadastrar', 'spocky-games'); ?></button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
get_sidebar();
get_footer();
?>
