<?php
/**
 * Template Name: Extras
 */

get_header();
?>

<main>
    <section class="page-header animated-section">
        <div class="animated-content">
            <h1 class="glitch" data-text="<?php esc_attr_e('Extras', 'spocky-games'); ?>"><?php esc_html_e('Extras', 'spocky-games'); ?></h1>
            <p><?php esc_html_e('Conteúdos especiais e ferramentas interativas', 'spocky-games'); ?></p>
        </div>
    </section>

    <section class="game-section animated-section">
        <div class="animated-content2">
            <h2 class="section-title"><?php esc_html_e('Matrix Roulette', 'spocky-games'); ?></h2>
            <div class="matrix-container">
                <div class="matrix-left">
                    <textarea 
                        id="matrixInput" 
                        class="matrix-textarea" 
                        placeholder="<?php esc_attr_e('Digite suas opções, uma por linha...', 'spocky-games'); ?>"></textarea>
                    <button id="matrixStart" class="matrix-button"><?php esc_html_e('Iniciar Roleta', 'spocky-games'); ?></button>
                    <button id="matrixClear" class="matrix-button secondary"><?php esc_html_e('Limpar', 'spocky-games'); ?></button>
                </div>
                <div class="matrix-right">
                    <div id="rouletteWrapper">
                        <div id="roulette" class="matrix-roulette"><?php esc_html_e('Digite opções à esquerda', 'spocky-games'); ?></div>
                    </div>
                    <div id="matrixResult" class="matrix-result" style="display: none;"></div>
                    
                    <div class="audio-controls">
                        <div class="volume-wrapper">
                            <span class="slider-label"><?php esc_html_e('Volume', 'spocky-games'); ?></span>
                            <input type="range" id="volumeControl" min="0" max="100" value="50">
                            <span class="slider-label" id="volumeValue">50%</span>
                        </div>
                        
                        <div class="duration-wrapper">
                            <span class="slider-label"><?php esc_html_e('Duração', 'spocky-games'); ?></span>
                            <input type="range" id="durationControl" min="1000" max="10000" value="3000" step="500">
                            <span class="slider-label" id="durationValue">3.0s</span>
                        </div>
                        
                        <input type="file" id="audioUpload" accept="audio/*" style="margin-top: 10px;">
                        <small style="color: #ccc; margin-top: 5px;"><?php esc_html_e('Carregue um áudio personalizado (opcional)', 'spocky-games'); ?></small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="featured-content animated-section">
        <div class="animated-content2">
            <h2 class="section-title"><?php esc_html_e('Curiosidades dos Games', 'spocky-games'); ?></h2>
            <div id="curiosities-section" class="news-grid">
                <?php
                // Get curiosities from options or create default ones
                $curiosities = get_option('spocky_curiosities', array(
                    array(
                        'title' => 'Super Mario Bros.',
                        'excerpt' => 'O famoso encanador foi criado por Shigeru Miyamoto em 1985 e originalmente se chamava Jumpman.',
                        'image' => get_template_directory_uri() . '/assets/curiosidades/mario.webp',
                        'tag' => 'Nintendo',
                        'date' => '2024-01-15'
                    ),
                    array(
                        'title' => 'Pac-Man',
                        'excerpt' => 'O design do Pac-Man foi inspirado em uma pizza com uma fatia removida.',
                        'image' => get_template_directory_uri() . '/assets/curiosidades/pacman.webp',
                        'tag' => 'Arcade',
                        'date' => '2024-01-10'
                    ),
                    array(
                        'title' => 'Tetris',
                        'excerpt' => 'Tetris foi criado por Alexey Pajitnov em 1984 na União Soviética e é um dos jogos mais vendidos da história.',
                        'image' => get_template_directory_uri() . '/assets/curiosidades/tetris.webp',
                        'tag' => 'Puzzle',
                        'date' => '2024-01-05'
                    )
                ));
                
                foreach ($curiosities as $curiosity) :
                ?>
                <div class="news-card">
                    <div class="news-image">
                        <img src="<?php echo esc_url($curiosity['image']); ?>" alt="<?php echo esc_attr($curiosity['title']); ?>">
                        <div class="news-tag"><?php echo esc_html($curiosity['tag']); ?></div>
                    </div>
                    <div class="news-content">
                        <div class="news-date"><?php echo esc_html(date('d/m/Y', strtotime($curiosity['date']))); ?></div>
                        <h3><?php echo esc_html($curiosity['title']); ?></h3>
                        <p class="news-excerpt"><?php echo esc_html($curiosity['excerpt']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const matrixInput = document.getElementById('matrixInput');
    const matrixStart = document.getElementById('matrixStart');
    const matrixClear = document.getElementById('matrixClear');
    const roulette = document.getElementById('roulette');
    const matrixResult = document.getElementById('matrixResult');
    const volumeControl = document.getElementById('volumeControl');
    const volumeValue = document.getElementById('volumeValue');
    const durationControl = document.getElementById('durationControl');
    const durationValue = document.getElementById('durationValue');
    const audioUpload = document.getElementById('audioUpload');
    
    let customAudio = null;
    let isRunning = false;
    
    // Volume control
    volumeControl.addEventListener('input', function() {
        volumeValue.textContent = this.value + '%';
    });
    
    // Duration control
    durationControl.addEventListener('input', function() {
        durationValue.textContent = (this.value / 1000).toFixed(1) + 's';
    });
    
    // Audio upload
    audioUpload.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const url = URL.createObjectURL(file);
            customAudio = new Audio(url);
            customAudio.volume = volumeControl.value / 100;
        }
    });
    
    // Matrix roulette functionality
    matrixStart.addEventListener('click', function() {
        if (isRunning) return;
        
        const options = matrixInput.value.trim().split('\n').filter(option => option.trim() !== '');
        
        if (options.length < 2) {
            alert('<?php esc_js_e('Digite pelo menos 2 opções!', 'spocky-games'); ?>');
            return;
        }
        
        isRunning = true;
        matrixResult.style.display = 'none';
        matrixStart.disabled = true;
        
        const duration = parseInt(durationControl.value);
        const startTime = Date.now();
        
        // Play audio if available
        if (customAudio) {
            customAudio.currentTime = 0;
            customAudio.volume = volumeControl.value / 100;
            customAudio.play().catch(e => console.log('Audio play failed:', e));
        }
        
        const interval = setInterval(() => {
            const randomOption = options[Math.floor(Math.random() * options.length)];
            roulette.textContent = randomOption;
            
            if (Date.now() - startTime >= duration) {
                clearInterval(interval);
                
                // Final result
                const finalOption = options[Math.floor(Math.random() * options.length)];
                roulette.textContent = finalOption;
                
                setTimeout(() => {
                    matrixResult.textContent = '🎯 ' + finalOption;
                    matrixResult.style.display = 'block';
                    isRunning = false;
                    matrixStart.disabled = false;
                }, 500);
            }
        }, 100);
    });
    
    matrixClear.addEventListener('click', function() {
        matrixInput.value = '';
        roulette.textContent = '<?php esc_js_e('Digite opções à esquerda', 'spocky-games'); ?>';
        matrixResult.style.display = 'none';
    });
});
</script>

<?php
get_footer();
