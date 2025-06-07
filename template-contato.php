<?php
/**
 * Template Name: Contato
 */

get_header();
?>

<main id="primary" class="site-main">

    <section class="contact-section animated-section">
        <div class="animated-content2">
            <div class="contact-container">
                <div class="contact-info">
                    <h2><?php esc_html_e('Entre em Contato', 'spocky-games'); ?></h2>
                    <p><?php esc_html_e('Tem alguma dúvida, sugestão ou quer fazer uma parceria? Entre em contato conosco!', 'spocky-games'); ?></p>
                    
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-content">
                            <h3><?php esc_html_e('Email', 'spocky-games'); ?></h3>
                            <p>contato@spockygames.com.br</p>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="info-content">
                            <h3><?php esc_html_e('Horário de Atendimento', 'spocky-games'); ?></h3>
                            <p><?php esc_html_e('Segunda a Sexta: 9h às 18h', 'spocky-games'); ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="contact-form">
                    <h2><?php esc_html_e('Envie sua Mensagem', 'spocky-games'); ?></h2>
                    <div class="contact-form-wrapper">
                        <form id="contactForm" method="post">
                            <?php wp_nonce_field('spocky_contact_nonce', 'contact_nonce'); ?>
                            <input type="hidden" name="action" value="spocky_contact_form">
                            
                            <div class="form-group">
                                <label for="contact_name"><?php esc_html_e('Nome *', 'spocky-games'); ?></label>
                                <input type="text" id="contact_name" name="contact_name" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="contact_email"><?php esc_html_e('Email *', 'spocky-games'); ?></label>
                                <input type="email" id="contact_email" name="contact_email" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="contact_subject"><?php esc_html_e('Assunto *', 'spocky-games'); ?></label>
                                <select id="contact_subject" name="contact_subject" required>
                                    <option value=""><?php esc_html_e('Selecione um assunto', 'spocky-games'); ?></option>
                                    <option value="parceria"><?php esc_html_e('Parceria', 'spocky-games'); ?></option>
                                    <option value="publicidade"><?php esc_html_e('Publicidade', 'spocky-games'); ?></option>
                                    <option value="sugestao"><?php esc_html_e('Sugestão', 'spocky-games'); ?></option>
                                    <option value="duvida"><?php esc_html_e('Dúvida', 'spocky-games'); ?></option>
                                    <option value="outro"><?php esc_html_e('Outro', 'spocky-games'); ?></option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="contact_message"><?php esc_html_e('Mensagem *', 'spocky-games'); ?></label>
                                <textarea id="contact_message" name="contact_message" rows="6" required></textarea>
                            </div>
                            
                            <div class="form-group">
                                <div class="checkbox-container">
                                    <input type="checkbox" id="contact_privacy" name="contact_privacy" required>
                                    <label for="contact_privacy"><?php esc_html_e('Aceito os termos de privacidade', 'spocky-games'); ?></label>
                                </div>
                            </div>
                            
                            <button type="submit" class="neon-button"><?php esc_html_e('Enviar Mensagem', 'spocky-games'); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- #main -->

<?php
get_footer();
?>
