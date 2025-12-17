<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Incluir arquivos da galeria
 */
require_once get_template_directory() . '/includes/gallerycpt/class-gallery-cpt.php';
require_once get_template_directory() . '/includes/gallerycpt/class-gallery-shortcode.php';
require_once get_template_directory() . '/includes/gallerycpt/class-gallery-admin.php';
require_once get_template_directory() . '/includes/gallerycpt/class-gallery-ajax.php';

/**
 * Incluir arquivos dos Logos
 */
require_once get_template_directory() . '/includes/logoscpt/class-logos-cpt.php';
require_once get_template_directory() . '/includes/logoscpt/class-logos-shortcode.php';
require_once get_template_directory() . '/includes/logoscpt/class-logos-admin.php';

require_once get_template_directory() . '/includes/customizer.php';


function maxima_scripts()
{
    // CSS
    wp_enqueue_style('bootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css', [], '5.3.2');
    wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', [], '6.4.0');
    wp_enqueue_style('maxima-style', get_stylesheet_uri(), array(), null, 'all');
    wp_enqueue_style('gallery-style', get_template_directory_uri() . '/assets/css/gallery.css', array(), null, 'all');
    // CSS dos Logos
    wp_enqueue_style('logos-style', get_template_directory_uri() . '/assets/css/logos.css', array(), null, 'all');

    // JS - USANDO A VERSÃO NATIVA DO JQUERY DO WORDPRESS
    wp_enqueue_script('jquery'); // Carrega o jQuery do WordPress
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);
    
    // JavaScript principal - DEPENDE do jQuery
    wp_enqueue_script('maxima-main-js', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);

     // JavaScript da galeria - SEMPRE carregar
    $gallery_js_path = get_template_directory() . '/assets/js/gallery.js';
    if (file_exists($gallery_js_path)) {
        wp_enqueue_script(
            'maxima-gallery-js',
            get_template_directory_uri() . '/assets/js/gallery.js',
            array('jquery'),
            '1.0.0',
            true
        );

// JavaScript dos Logos - carrega apenas se necessário
    if (is_page() || is_single()) {
        $logos_js_path = get_template_directory() . '/assets/js/logos.js';
        if (file_exists($logos_js_path)) {
            wp_enqueue_script(
                'maxima-logos-js',
                get_template_directory_uri() . '/assets/js/logos.js',
                array('jquery'),
                '1.0.0',
                true
            );
        }
    }
        
        // Localizar script com dados
        wp_localize_script('maxima-gallery-js', 'maximaGallery', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('maxima_gallery_nonce')
        ));
    }

    
}

add_action('wp_enqueue_scripts', 'maxima_scripts');

function maxima_preload_resources() {
    ?>
    <!-- Preload do Font Awesome -->
    <link rel="preload" as="font" href="<?php echo get_template_directory_uri(); ?>/assets/fonts/Nexa-XBold.woff2" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php
}
add_action('wp_head', 'maxima_preload_resources', 0);

function maxima_config()
{
    register_nav_menus(
        array(
            'maxima_main_menu_left' => __('Menu Principal Esquerda', 'maxima'),
            'maxima_main_menu_right' => __('Menu Principal Direita', 'maxima'),
        )
    );

    // Adicionar suporte a post thumbnails
    add_theme_support('post-thumbnails');

     // Tamanhos de imagem para a galeria
    add_image_size('maxima-gallery-thumb', 400, 300, true);
    add_image_size('maxima-gallery-large', 1200, 800, true);

    // Tamanhos de imagem para os logos
    add_image_size('maxima-logo-thumb', 400, 200, false); // Tamanho padrão para exibição
    add_image_size('maxima-logo-large', 800, 400, false); // Tamanho maior se necessário

    // Adicionar logo customizado no tema
    add_theme_support('custom-logo', array(
        'width' => 180,
        'height' => 50,
        'flex-height' => true,
        'flex-width' => true
    ));

    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array(
        'comment-list',
        'comment-form',
        'search-form',
        'gallery',
        'caption',
        'style',
        'script'
    ));

    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'maxima_config');

/**
 * Helper function para obter a URL do vídeo MP4
 */
function get_video_sobre_mp4() {
    $tipo = get_theme_mod('video_sobre_tipo', 'upload');
    $video_mp4 = '';
    
    if ($tipo === 'upload') {
        $mp4_id = absint(get_theme_mod('video_sobre_mp4_upload', 0));
        if ($mp4_id > 0) {
            $video_mp4 = esc_url(wp_get_attachment_url($mp4_id));
        }
    } else {
        $video_mp4 = esc_url(get_theme_mod('video_sobre_mp4_url', ''));
    }
    
    return $video_mp4;
}

/**
 * Helper function para obter a URL do vídeo WebM
 */
function get_video_sobre_webm() {
    $tipo = get_theme_mod('video_sobre_tipo', 'upload');
    $video_webm = '';
    
    if ($tipo === 'upload') {
        $webm_id = absint(get_theme_mod('video_sobre_webm_upload', 0));
        if ($webm_id > 0) {
            $video_webm = esc_url(wp_get_attachment_url($webm_id));
        }
    } else {
        $video_webm = esc_url(get_theme_mod('video_sobre_webm_url', ''));
    }
    
    return $video_webm;
}

/**
 * Helper function para obter a URL da imagem poster
 */
function get_video_sobre_poster() {
    $poster_id = absint(get_theme_mod('video_sobre_poster', 0));
    if ($poster_id > 0) {
        return esc_url(wp_get_attachment_url($poster_id));
    }
    return '';
}

/**
 * Verifica se deve exibir o vídeo
 */
function should_display_video_sobre() {
    $ativo = wp_validate_boolean(get_theme_mod('video_sobre_ativo', true));
    $mobile = wp_validate_boolean(get_theme_mod('video_sobre_mobile', true));
    
    if (!$ativo) {
        return false;
    }
    
    // Verificar se está em dispositivo móvel
    if (wp_is_mobile() && !$mobile) {
        return false;
    }
    
    // Verificar se há vídeo configurado
    $mp4 = get_video_sobre_mp4();
    $webm = get_video_sobre_webm();
    
    return !empty($mp4) || !empty($webm);
}

/**
 * Obter URL do vídeo padrão do tema
 */
function get_video_default_mp4() {
    return esc_url(get_template_directory_uri() . '/assets/videos/sobre-maxima.mp4');
}

function get_video_default_webm() {
    return esc_url(get_template_directory_uri() . '/assets/videos/sobre-maxima.webm');
}

/**
 * ============================================
 * GET VIDEO DATA - FUNÇÃO PRINCIPAL
 * Similar à sua função get_onde_comprar_data()
 * ============================================
 */
function get_video_sobre_data() {
    $video_data = array(
        'ativo'          => should_display_video_sobre(),
        'mp4'            => get_video_sobre_mp4(),
        'webm'           => get_video_sobre_webm(),
        'poster'         => get_video_sobre_poster(),
        'mobile'         => wp_validate_boolean(get_theme_mod('video_sobre_mobile', true)),
        'fallback_default' => wp_validate_boolean(get_theme_mod('video_fallback_default', true)),
        'tipo'           => get_theme_mod('video_sobre_tipo', 'upload'),
    );
    
    // Aplicar fallback padrão se necessário
    if ($video_data['fallback_default']) {
        if (empty($video_data['mp4'])) {
            $video_data['mp4'] = get_video_default_mp4();
        }
        if (empty($video_data['webm'])) {
            $video_data['webm'] = get_video_default_webm();
        }
    }
    
    // Verificar se tem vídeo
    $video_data['has_video'] = !empty($video_data['mp4']) || !empty($video_data['webm']);
    
    return $video_data;
}

