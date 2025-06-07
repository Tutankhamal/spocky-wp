<?php
/**
 * Template Name: Parceiros
 */

get_header();
?>

<main>
    <section class="page-header animated-section">
        <div class="animated-content">
            <h1 class="glitch" data-text="<?php esc_attr_e('Parceiros', 'spocky-games'); ?>"><?php esc_html_e('Parceiros', 'spocky-games'); ?></h1>
            <p><?php esc_html_e('Conheça nossos parceiros e colaboradores', 'spocky-games'); ?></p>
        </div>
    </section>

    <section class="channel-carousel-section animated-section">
        <div class="animated-content">
            <h2 class="section-title"><?php esc_html_e('Canais Parceiros', 'spocky-games'); ?></h2>
            <div class="channel-carousel-container">
                <div class="channel-carousel-track">
                    <!-- Os canais serão carregados via JavaScript como no original -->
                </div>
            </div>
        </div>
    </section>

    <section class="partners-section animated-section">
        <div class="animated-content2">
            <h2 class="section-title"><?php esc_html_e('Nossos Parceiros', 'spocky-games'); ?></h2>
            <div class="partners-grid">
                <?php
                // Get partners from options or create default ones
                $partners = get_option('spocky_partners_detailed', array(
                    array(
                        'name' => 'E-Cast',
                        'category' => 'Streaming',
                        'description' => 'Plataforma de streaming especializada em conteúdo de games retrô e nostalgia.',
                        'logo' => get_template_directory_uri() . '/assets/images/partnerlogos/ecast.webp',
                        'website' => 'https://www.ecast.site',
                        'social' => array(
                            'youtube' => 'https://youtube.com/@ecast',
                            'instagram' => 'https://instagram.com/ecast'
                        )
                    ),
                    array(
                        'name' => 'Retro Gaming Store',
                        'category' => 'Loja',
                        'description' => 'Loja especializada em jogos retrô, consoles antigos e colecionáveis.',
                        'logo' => get_template_directory_uri() . '/assets/images/partnerlogos/retrogaming.webp',
                        'website' => '#',
                        'social' => array(
                            'instagram' => '#',
                            'facebook' => '#'
                        )
                    ),
                    array(
                        'name' => 'Pixel Art Studio',
                        'category' => 'Arte',
                        'description' => 'Estúdio de arte especializado em pixel art e design retrô para games.',
                        'logo' => get_template_directory_uri() . '/assets/images/partnerlogos/pixelart.webp',
                        'website' => '#',
                        'social' => array(
                            'behance' => '#',
                            'instagram' => '#'
                        )
                    )
                ));
                
                foreach ($partners as $partner) :
                ?>
                <div class="partner-card" data-partner="<?php echo esc_attr(json_encode($partner)); ?>">
                    <div class="partner-logo">
                        <img src="<?php echo esc_url($partner['logo']); ?>" alt="<?php echo esc_attr($partner['name']); ?>">
                    </div>
                    <h3><?php echo esc_html($partner['name']); ?></h3>
                    <div class="partner-category"><?php echo esc_html($partner['category']); ?></div>
                    <p class="partner-description"><?php echo esc_html($partner['description']); ?></p>
                    <button class="neon-button" onclick="openPartnerModal(this)"><?php esc_html_e('Saiba Mais', 'spocky-games'); ?></button>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="team-section animated-section">
        <div class="animated-content2">
            <h2 class="section-title"><?php esc_html_e('Nossa Equipe', 'spocky-games'); ?></h2>
            <div class="team-grid">
                <?php
                // Get team members from options or create default ones
                $team_members = get_option('spocky_team_members', array(
                    array(
                        'name' => 'Mateus Spocky',
                        'role' => 'Criador de Conteúdo',
                        'description' => 'Apaixonado por jogos retrô desde criança, compartilha sua paixão através de gameplays e reviews.',
                        'avatar' => get_template_directory_uri() . '/assets/team/spocky.webp',
                        'social' => array(
                            'youtube' => 'https://youtube.com/@SpockyGames',
                            'instagram' => 'https://instagram.com/SpockyGames',
                            'tiktok' => 'https://www.tiktok.com/@spockygames'
                        )
                    ),
                    array(
                        'name' => 'Editor Retrô',
                        'role' => 'Editor de Vídeo',
                        'description' => 'Responsável pela edição dos vídeos, criando conteúdo dinâmico e envolvente.',
                        'avatar' => get_template_directory_uri() . '/assets/team/editor.webp',
                        'social' => array(
                            'instagram' => '#',
                            'twitter' => '#'
                        )
                    ),
                    array(
                        'name' => 'Pixel Designer',
                        'role' => 'Designer Gráfico',
                        'description' => 'Cria as artes e thumbnails com estilo retrô que caracterizam o canal.',
                        'avatar' => get_template_directory_uri() . '/assets/team/designer.webp',
                        'social' => array(
                            'behance' => '#',
                            'instagram' => '#'
                        )
                    )
                ));
                
                foreach ($team_members as $member) :
                ?>
                <div class="team-card">
                    <div class="team-avatar">
                        <img src="<?php echo esc_url($member['avatar']); ?>" alt="<?php echo esc_attr($member['name']); ?>">
                    </div>
                    <div class="team-info">
                        <h3><?php echo esc_html($member['name']); ?></h3>
                        <div class="team-role"><?php echo esc_html($member['role']); ?></div>
                        <p class="team-description"><?php echo esc_html($member['description']); ?></p>
                        <div class="team-social">
                            <?php foreach ($member['social'] as $platform => $url) : ?>
                                <a href="<?php echo esc_url($url); ?>" target="_blank" class="social-icon <?php echo esc_attr($platform); ?>">
                                    <i class="fab fa-<?php echo esc_attr($platform); ?>"></i>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="become-partner animated-section">
        <div class="animated-content2">
            <div class="partner-cta">
                <h2><?php esc_html_e('Seja Nosso Parceiro!', 'spocky-games'); ?></h2>
                <p><?php esc_html_e('Interessado em fazer parceria conosco? Entre em contato e vamos conversar sobre como podemos trabalhar juntos para levar o melhor conteúdo retrô para nossa comunidade.', 'spocky-games'); ?></p>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('contato'))); ?>" class="neon-button"><?php esc_html_e('Entre em Contato', 'spocky-games'); ?></a>
            </div>
        </div>
    </section>
</main>

<!-- Partner Modal -->
<div class="modal-overlay" id="partnerModal">
    <div class="partner-modal">
        <button class="close-modal" onclick="closePartnerModal()">&times;</button>
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-logo">
                    <img id="modalLogo" src="/placeholder.svg" alt="">
                </div>
                <div class="modal-title">
                    <h2 id="modalName"></h2>
                    <div class="modal-category" id="modalCategory"></div>
                </div>
            </div>
            <div class="modal-description">
                <h3><?php esc_html_e('Sobre', 'spocky-games'); ?></h3>
                <p id="modalDescription"></p>
            </div>
            <div class="modal-social">
                <h3><?php esc_html_e('Redes Sociais', 'spocky-games'); ?></h3>
                <div class="modal-social-icons" id="modalSocialIcons"></div>
            </div>
            <div class="modal-cta">
                <a id="modalWebsite" href="#" target="_blank" class="neon-button"><?php esc_html_e('Visitar Site', 'spocky-games'); ?></a>
            </div>
        </div>
    </div>
</div>

<script>
function openPartnerModal(button) {
    const partnerData = JSON.parse(button.closest('.partner-card').dataset.partner);
    const modal = document.getElementById('partnerModal');
    
    document.getElementById('modalLogo').src = partnerData.logo;
    document.getElementById('modalLogo').alt = partnerData.name;
    document.getElementById('modalName').textContent = partnerData.name;
    document.getElementById('modalCategory').textContent = partnerData.category;
    document.getElementById('modalDescription').textContent = partnerData.description;
    document.getElementById('modalWebsite').href = partnerData.website;
    
    // Social icons
    const socialIcons = document.getElementById('modalSocialIcons');
    socialIcons.innerHTML = '';
    
    if (partnerData.social) {
        Object.entries(partnerData.social).forEach(([platform, url]) => {
            const icon = document.createElement('a');
            icon.href = url;
            icon.target = '_blank';
            icon.className = `social-icon ${platform}`;
            icon.innerHTML = `<i class="fab fa-${platform}"></i>`;
            socialIcons.appendChild(icon);
        });
    }
    
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closePartnerModal() {
    const modal = document.getElementById('partnerModal');
    modal.classList.remove('active');
    document.body.style.overflow = '';
}

// Close modal when clicking outside
document.getElementById('partnerModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePartnerModal();
    }
});
</script>

<?php
get_footer();
