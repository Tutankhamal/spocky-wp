<?php
/**
 * Template Name: On Demand
 */

get_header();
?>

<main>
    <section class="page-header animated-section">
        <div class="animated-content">
            <h1 class="glitch" data-text="<?php esc_attr_e('On Demand', 'spocky-games'); ?>"><?php esc_html_e('On Demand', 'spocky-games'); ?></h1>
            <p><?php esc_html_e('Assista nossos vídeos quando quiser', 'spocky-games'); ?></p>
        </div>
    </section>
    
    <section class="ondemand-section">
        <h2 class="ondemand-title"><?php esc_html_e('Conteúdos On Demand', 'spocky-games'); ?></h2>
        <div id="ondemand-grid" class="ondemand-grid"></div>
    </section>
</main>

<script>
async function fetchOnDemandVideos() {
    try {
        const response = await fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=spocky_youtube_data&youtube_action=videos&count=10');
        const data = await response.json();

        if (!data.success || !data.data) return;

        const grid = document.getElementById("ondemand-grid");
        grid.innerHTML = '';

        data.data.forEach(video => {
            const card = document.createElement("div");
            card.className = "ondemand-card";

            card.innerHTML = `
                <lite-youtube 
                    videoid="${video.id}" 
                    playlabel="${video.title.replace(/"/g, "'")}">
                </lite-youtube>
                <div class="title">${video.title}</div>
            `;

            grid.appendChild(card);
        });
    } catch (error) {
        console.error("Erro ao carregar vídeos:", error);
    }
}

document.addEventListener("DOMContentLoaded", fetchOnDemandVideos);
</script>

<?php
get_footer();
