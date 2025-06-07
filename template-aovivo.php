<?php
/**
 * Template Name: Ao Vivo
 */

get_header();
?>

<main>
    <section class="page-header animated-section">
        <div class="animated-content">
            <h1 class="glitch" data-text="<?php esc_attr_e('Ao Vivo', 'spocky-games'); ?>"><?php esc_html_e('Ao Vivo', 'spocky-games'); ?></h1>
            <p><?php esc_html_e('Acompanhe nossas transmissões ao vivo', 'spocky-games'); ?></p>
        </div>
    </section>
    
    <section class="live-highlight-section">
        <div class="custom-retro-banner-wrapper">
            <div class="custom-retro-banner-bg"></div>
            <div class="custom-retro-character" id="retroBannerCharacter">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mummy.gif" alt="Mummy" />
            </div>
            <div class="custom-retro-content" id="retroBannerContent">
                <span class="glitch" data-text="<?php esc_attr_e('Anuncie aqui', 'spocky-games'); ?>"><?php esc_html_e('Anuncie aqui', 'spocky-games'); ?></span>
            </div>
        </div>
        <div class="big-live-player-box">
            <div class="big-live-player-title" id="liveplayer-title"><?php esc_html_e('Carregando transmissão retrô...', 'spocky-games'); ?></div>
            <div class="big-live-player-video" id="liveplayer-video"></div>
            
            <div class="big-live-player-buttons" id="liveplayer-buttons" style="display: none;"></div>
            <div class="big-live-player-chat" id="liveplayer-chat"></div>
        </div>
    </section>
</main>

<script>
// Retro banner animation script
const retroBanners = [
    { type: 'text', text: '<?php esc_js_e('Anuncie aqui', 'spocky-games'); ?>', link: '<?php echo esc_url(get_permalink(get_page_by_path('contato'))); ?>' },
    { type: 'logo', img: '<?php echo get_template_directory_uri(); ?>/assets/images/partnerlogos/ecast.webp', alt: 'Ecast', link: 'https://ecast.site' }
];

const retroCharacters = [
    { name: 'Mummy', src: '<?php echo get_template_directory_uri(); ?>/assets/images/mummy.gif', width: 72, height: 72 },
    { name: 'Sonic', src: '<?php echo get_template_directory_uri(); ?>/assets/images/sonic.gif', width: 72, height: 72 },
    { name: 'DK', src: '<?php echo get_template_directory_uri(); ?>/assets/images/dk.gif', width: 72, height: 72 },
    { name: 'Mario', src: '<?php echo get_template_directory_uri(); ?>/assets/images/mario.gif', width: 72, height: 72 },
    { name: 'Wario', src: '<?php echo get_template_directory_uri(); ?>/assets/images/wario.gif', width: 72, height: 72 },
    { name: 'Luigi', src: '<?php echo get_template_directory_uri(); ?>/assets/images/luigi.gif', width: 72, height: 72 },
    { name: 'Mickey', src: '<?php echo get_template_directory_uri(); ?>/assets/images/mickey.gif', width: 72, height: 72 }
];

// Banner animation logic (same as original)
const bannerEl = document.querySelector('.custom-retro-banner-wrapper');
const contentEl = document.getElementById('retroBannerContent');
const charEl = document.getElementById('retroBannerCharacter');

let currentBanner = -1;
let currentChar = -1;
let state = 'enter';
let animStart = null;

let bannerWidth, charWidth, contentWidth, gap;
let centerPos, leftEdge, rightEdge;

const animDuration = 3400;
const waitDuration = 10000;
const charGap = 12;

function setBanner(bannerIdx, charIdx) {
    const banner = retroBanners[bannerIdx];
    const character = retroCharacters[charIdx];

    if (banner.type === 'text') {
        contentEl.innerHTML = `<a href="${banner.link}" style="color:inherit;text-decoration:none;white-space:nowrap;position:relative;left:85px;">${banner.text}</a>`;
    } else if (banner.type === 'logo') {
        contentEl.innerHTML = `<a href="${banner.link}" style="left:65px" target="_blank"><img src="${banner.img}" alt="${banner.alt}" class="rbann-logo"></a>`;
    }

    charEl.innerHTML = `<img src="${character.src}" alt="${character.name}" style="width:${character.width}px; height:${character.height}px;">`;

    setTimeout(() => {
        bannerWidth = bannerEl.offsetWidth;
        charWidth = charEl.offsetWidth || character.width;
        const contentRect = contentEl.getBoundingClientRect();
        contentWidth = contentRect.width;

        gap = charGap;

        const totalContentWidth = contentWidth + charWidth + gap;
        const startX = (bannerWidth - totalContentWidth) / 2;

        leftEdge = -totalContentWidth;
        centerPos = startX + charWidth + gap;
        rightEdge = bannerWidth + totalContentWidth;

        charEl.style.transition = 'none';
        contentEl.style.transition = 'none';

        charEl.style.left = leftEdge + 'px';
        charEl.style.transform = 'scaleX(1)';
        contentEl.style.left = (leftEdge + charWidth + gap) + 'px';

        state = 'enter';
        animStart = null;
        requestAnimationFrame(animate);
    }, 30);
}

function animate(ts) {
    if (!animStart) animStart = ts;
    let elapsed = ts - animStart;

    if (state === 'enter') {
        const duration = animDuration;
        let progress = Math.min(elapsed / duration, 1);

        const charStart = leftEdge;
        const contentStart = leftEdge + charWidth + gap;
        const charEnd = centerPos - charWidth - gap;
        const contentEnd = centerPos;

        const charPos = charStart + (charEnd - charStart) * progress;
        const contentPos = contentStart + (contentEnd - contentStart) * progress;

        charEl.style.left = charPos + 'px';
        contentEl.style.left = contentPos + 'px';

        if (progress < 1) {
            requestAnimationFrame(animate);
        } else {
            charEl.style.left = charEnd + 'px';
            contentEl.style.left = contentEnd + 'px';
            charEl.style.transform = 'scaleX(-1)';

            state = 'returnLeft';
            animStart = null;
            requestAnimationFrame(animate);
        }

    } else if (state === 'returnLeft') {
        const duration = animDuration * 0.6;
        let progress = Math.min(elapsed / duration, 1);

        const charStart = centerPos - charWidth - gap;
        const charEnd = leftEdge;

        const charPos = charStart + (charEnd - charStart) * progress;

        charEl.style.left = charPos + 'px';
        contentEl.style.left = centerPos + 'px';

        if (progress < 1) {
            requestAnimationFrame(animate);
        } else {
            charEl.style.left = leftEdge + 'px';
            charEl.style.transform = 'scaleX(1)';

            state = 'waitBeforeExit';
            animStart = null;

            setTimeout(() => {
                state = 'exit';
                animStart = null;
                requestAnimationFrame(animate);
            }, waitDuration);
        }

    } else if (state === 'waitBeforeExit') {
        charEl.style.left = leftEdge + 'px';
        contentEl.style.left = centerPos + 'px';

    } else if (state === 'exit') {
        const totalExitDuration = animDuration * 2;
        const halfDuration = totalExitDuration / 2;
        const charMid = centerPos - charWidth - gap;
        const contentMid = centerPos;

        if (elapsed <= halfDuration) {
            const progress = elapsed / halfDuration;

            const charPos = leftEdge + (charMid - leftEdge) * progress;
            charEl.style.left = charPos + 'px';
            charEl.style.transform = 'scaleX(1)';
            contentEl.style.left = centerPos + 'px';

            requestAnimationFrame(animate);

        } else {
            const progress = (elapsed - halfDuration) / halfDuration;

            const charEnd = rightEdge;
            const contentEnd = rightEdge + charWidth + gap;

            const charPos = charMid + (charEnd - charMid) * progress;
            const contentPos = contentMid + (contentEnd - contentMid) * progress;

            charEl.style.left = charPos + 'px';
            charEl.style.transform = 'scaleX(1)';
            contentEl.style.left = contentPos + 'px';

            if (progress < 1) {
                requestAnimationFrame(animate);
            } else {
                charEl.style.left = charEnd + 'px';
                contentEl.style.left = contentEnd + 'px';

                setTimeout(() => {
                    let nextBanner, nextChar;
                    do {
                        nextBanner = Math.floor(Math.random() * retroBanners.length);
                    } while (nextBanner === currentBanner);

                    do {
                        nextChar = Math.floor(Math.random() * retroCharacters.length);
                    } while (nextChar === currentChar);

                    currentBanner = nextBanner;
                    currentChar = nextChar;

                    setBanner(currentBanner, currentChar);
                }, 400);
            }
        }
    }
}

// Initialize
currentBanner = Math.floor(Math.random() * retroBanners.length);
currentChar = Math.floor(Math.random() * retroCharacters.length);
setBanner(currentBanner, currentChar);
</script>

<?php
get_footer();
