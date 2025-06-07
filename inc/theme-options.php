<?php
/**
 * Theme Options Page
 */

/**
 * Add theme options page
 */
function spocky_add_theme_options_page() {
    add_menu_page(
        __('Spocky Games Options', 'spocky-games'),
        __('Spocky Options', 'spocky-games'),
        'manage_options',
        'spocky-options',
        'spocky_theme_options_page',
        'dashicons-games',
        20
    );
}
add_action('admin_menu', 'spocky_add_theme_options_page');

/**
 * Register settings
 */
function spocky_register_settings() {
    // General settings
    register_setting('spocky_options_group', 'spocky_hero_subtitle');
    
    // YouTube API settings
    register_setting('spocky_options_group', 'spocky_youtube_api_key');
    register_setting('spocky_options_group', 'spocky_youtube_channel_id');
    
    // Social media settings
    register_setting('spocky_options_group', 'spocky_social_youtube');
    register_setting('spocky_options_group', 'spocky_social_instagram');
    register_setting('spocky_options_group', 'spocky_social_tiktok');
    register_setting('spocky_options_group', 'spocky_social_discord');
    register_setting('spocky_options_group', 'spocky_social_whatsapp');
    
    // About settings
    register_setting('spocky_options_group', 'spocky_mission');
    register_setting('spocky_options_group', 'spocky_vision');
    register_setting('spocky_options_group', 'spocky_values');
    
    // Channel stats
    register_setting('spocky_options_group', 'spocky_channel_creation_date');
}
add_action('admin_init', 'spocky_register_settings');

/**
 * Theme options page content
 */
function spocky_theme_options_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Spocky Games Theme Options', 'spocky-games'); ?></h1>
        
        <form method="post" action="options.php">
            <?php settings_fields('spocky_options_group'); ?>
            <?php do_settings_sections('spocky_options_group'); ?>
            
            <div class="metabox-holder">
                <div class="postbox">
                    <h3 class="hndle"><span><?php esc_html_e('General Settings', 'spocky-games'); ?></span></h3>
                    <div class="inside">
                        <table class="form-table">
                            <tr>
                                <th scope="row">
                                    <label for="spocky_hero_subtitle"><?php esc_html_e('Hero Subtitle', 'spocky-games'); ?></label>
                                </th>
                                <td>
                                    <input type="text" id="spocky_hero_subtitle" name="spocky_hero_subtitle" value="<?php echo esc_attr(get_option('spocky_hero_subtitle', 'Jogos retrô com Mateus Spocky')); ?>" class="regular-text" />
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="postbox">
                    <h3 class="hndle"><span><?php esc_html_e('YouTube API Settings', 'spocky-games'); ?></span></h3>
                    <div class="inside">
                        <p><?php esc_html_e('Configure your YouTube API settings to enable video integration.', 'spocky-games'); ?></p>
                        <table class="form-table">
                            <tr>
                                <th scope="row">
                                    <label for="spocky_youtube_api_key"><?php esc_html_e('YouTube API Key', 'spocky-games'); ?></label>
                                </th>
                                <td>
                                    <input type="text" id="spocky_youtube_api_key" name="spocky_youtube_api_key" value="<?php echo esc_attr(get_option('spocky_youtube_api_key')); ?>" class="regular-text" />
                                    <p class="description"><?php esc_html_e('Enter your YouTube API key. You can get one from the Google Developer Console.', 'spocky-games'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="spocky_youtube_channel_id"><?php esc_html_e('YouTube Channel ID', 'spocky-games'); ?></label>
                                </th>
                                <td>
                                    <input type="text" id="spocky_youtube_channel_id" name="spocky_youtube_channel_id" value="<?php echo esc_attr(get_option('spocky_youtube_channel_id', 'UCSPC6X4M-tVPeK4IZMbK5aw')); ?>" class="regular-text" />
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label><?php esc_html_e('Clear Cache', 'spocky-games'); ?></label>
                                </th>
                                <td>
                                    <button type="button" id="clear-youtube-cache" class="button button-secondary"><?php esc_html_e('Clear YouTube Cache', 'spocky-games'); ?></button>
                                    <p class="description"><?php esc_html_e('Clear the cached YouTube data to fetch fresh content.', 'spocky-games'); ?></p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="postbox">
                    <h3 class="hndle"><span><?php esc_html_e('Social Media Links', 'spocky-games'); ?></span></h3>
                    <div class="inside">
                        <table class="form-table">
                            <tr>
                                <th scope="row">
                                    <label for="spocky_social_youtube"><?php esc_html_e('YouTube', 'spocky-games'); ?></label>
                                </th>
                                <td>
                                    <input type="url" id="spocky_social_youtube" name="spocky_social_youtube" value="<?php echo esc_url(get_option('spocky_social_youtube', 'https://youtube.com/@SpockyGames')); ?>" class="regular-text" />
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="spocky_social_instagram"><?php esc_html_e('Instagram', 'spocky-games'); ?></label>
                                </th>
                                <td>
                                    <input type="url" id="spocky_social_instagram" name="spocky_social_instagram" value="<?php echo esc_url(get_option('spocky_social_instagram', 'https://instagram.com/SpockyGames')); ?>" class="regular-text" />
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="spocky_social_tiktok"><?php esc_html_e('TikTok', 'spocky-games'); ?></label>
                                </th>
                                <td>
                                    <input type="url" id="spocky_social_tiktok" name="spocky_social_tiktok" value="<?php echo esc_url(get_option('spocky_social_tiktok', 'https://www.tiktok.com/@spockygames')); ?>" class="regular-text" />
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="spocky_social_discord"><?php esc_html_e('Discord', 'spocky-games'); ?></label>
                                </th>
                                <td>
                                    <input type="url" id="spocky_social_discord" name="spocky_social_discord" value="<?php echo esc_url(get_option('spocky_social_discord', 'https://discord.com/invite/5Zags8Xaz5')); ?>" class="regular-text" />
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="spocky_social_whatsapp"><?php esc_html_e('WhatsApp', 'spocky-games'); ?></label>
                                </th>
                                <td>
                                    <input type="url" id="spocky_social_whatsapp" name="spocky_social_whatsapp" value="<?php echo esc_url(get_option('spocky_social_whatsapp', 'https://chat.whatsapp.com/JkQvyyFUzZn4y2mbkuD7mv')); ?>" class="regular-text" />
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="postbox">
                    <h3 class="hndle"><span><?php esc_html_e('About Section', 'spocky-games'); ?></span></h3>
                    <div class="inside">
                        <table class="form-table">
                            <tr>
                                <th scope="row">
                                    <label for="spocky_mission"><?php esc_html_e('Mission', 'spocky-games'); ?></label>
                                </th>
                                <td>
                                    <textarea id="spocky_mission" name="spocky_mission" rows="4" class="large-text"><?php echo esc_textarea(get_option('spocky_mission', 'Preservar e compartilhar a história dos videogames, criando conteúdo de qualidade que valorize os jogos clássicos e inspire novas gerações de jogadores.')); ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="spocky_vision"><?php esc_html_e('Vision', 'spocky-games'); ?></label>
                                </th>
                                <td>
                                    <textarea id="spocky_vision" name="spocky_vision" rows="4" class="large-text"><?php echo esc_textarea(get_option('spocky_vision', 'Ser um dos principais canais de referência em jogos retrô no Brasil, construindo uma comunidade apaixonada e engajada em torno da cultura dos videogames clássicos.')); ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="spocky_values"><?php esc_html_e('Values', 'spocky-games'); ?></label>
                                </th>
                                <td>
                                    <textarea id="spocky_values" name="spocky_values" rows="4" class="large-text"><?php echo esc_textarea(get_option('spocky_values', 'Autenticidade, paixão, respeito e gratidão pela história dos games, compartilhamento de conhecimento e valorização da comunidade.')); ?></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="postbox">
                    <h3 class="hndle"><span><?php esc_html_e('Channel Stats', 'spocky-games'); ?></span></h3>
                    <div class="inside">
                        <table class="form-table">
                            <tr>
                                <th scope="row">
                                    <label for="spocky_channel_creation_date"><?php esc_html_e('Channel Creation Date', 'spocky-games'); ?></label>
                                </th>
                                <td>
                                    <input type="date" id="spocky_channel_creation_date" name="spocky_channel_creation_date" value="<?php echo esc_attr(get_option('spocky_channel_creation_date', '2022-11-15')); ?>" class="regular-text" />
                                    <p class="description"><?php esc_html_e('Used to calculate channel age.', 'spocky-games'); ?></p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            
            <?php submit_button(); ?>
        </form>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        $('#clear-youtube-cache').on('click', function() {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'spocky_clear_youtube_cache'
                },
                success: function(response) {
                    if (response.success) {
                        alert('<?php esc_html_e('YouTube cache cleared successfully!', 'spocky-games'); ?>');
                    } else {
                        alert('<?php esc_html_e('Failed to clear YouTube cache.', 'spocky-games'); ?>');
                    }
                }
            });
        });
    });
    </script>
    <?php
}

/**
 * AJAX handler to clear YouTube cache
 */
function spocky_clear_youtube_cache() {
    delete_transient('spocky_youtube_channel_data');
    delete_transient('spocky_youtube_videos');
    delete_transient('spocky_youtube_live');
    
    wp_send_json_success();
}
add_action('wp_ajax_spocky_clear_youtube_cache', 'spocky_clear_youtube_cache');
