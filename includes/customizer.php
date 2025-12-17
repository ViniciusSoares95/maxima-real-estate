<?php
/**
 * Customizer settings for video background
 * 
 * @package Maxima
 */

/**
 * Callback para mostrar controles de upload
 */
function maxima_video_tipo_upload_callback($control) {
    return $control->manager->get_setting('video_sobre_tipo')->value() == 'upload';
}

/**
 * Callback para mostrar controles de URL
 */
function maxima_video_tipo_url_callback($control) {
    return $control->manager->get_setting('video_sobre_tipo')->value() == 'url';
}

/**
 * Sanitização customizada para URLs de vídeo
 */
function maxima_sanitize_video_url($input) {
    $input = esc_url_raw($input);
    
    // Validar extensão do arquivo
    $path = parse_url($input, PHP_URL_PATH);
    $extension = pathinfo($path, PATHINFO_EXTENSION);
    $allowed_extensions = array('mp4', 'webm', 'ogv', 'mov', 'm4v');
    
    if (!empty($extension) && !in_array(strtolower($extension), $allowed_extensions)) {
        return ''; // Retorna vazio se extensão não permitida
    }
    
    return $input;
}

/**
 * Sanitização para IDs de mídia
 */
function maxima_sanitize_media_id($input) {
    $input = absint($input);
    
    // Verificar se o ID existe e é um vídeo
    if ($input > 0) {
        $attachment = get_post($input);
        if (!$attachment || $attachment->post_type !== 'attachment') {
            return 0;
        }
        
        // Verificar se é um vídeo
        $mime_type = get_post_mime_type($input);
        if (strpos($mime_type, 'video/') !== 0) {
            return 0;
        }
    }
    
    return $input;
}

/**
 * Adicionar configurações de vídeo no Customizer
 */
function maxima_video_customizer($wp_customize) {
    
    // Seção para Vídeo da Página Sobre
    $wp_customize->add_section('video_sobre_section', array(
        'title'       => esc_html__('Vídeo - Página Sobre', 'maxima'),
        'description' => esc_html__('Configure o vídeo de fundo da página sobre. Faça upload do vídeo ou cole uma URL externa.', 'maxima'),
        'priority'    => 120,
        'capability'  => 'edit_theme_options',
    ));
    
    // Opção: Tipo de vídeo (upload ou URL)
    $wp_customize->add_setting('video_sobre_tipo', array(
        'default'           => 'upload',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
        'type'              => 'theme_mod',
    ));
    
    $wp_customize->add_control('video_sobre_tipo', array(
        'label'       => esc_html__('Fonte do Vídeo', 'maxima'),
        'description' => esc_html__('Escolha como deseja adicionar o vídeo', 'maxima'),
        'section'     => 'video_sobre_section',
        'settings'    => 'video_sobre_tipo',
        'type'        => 'radio',
        'choices'     => array(
            'upload' => esc_html__('Upload do vídeo', 'maxima'),
            'url'    => esc_html__('URL externa', 'maxima'),
        ),
    ));
    
    // Configuração para UPLOAD do vídeo MP4
    $wp_customize->add_setting('video_sobre_mp4_upload', array(
        'default'           => 0,
        'sanitize_callback' => 'maxima_sanitize_media_id',
        'transport'         => 'refresh',
        'type'              => 'theme_mod',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 
        'video_sobre_mp4_upload',
        array(
            'label'       => esc_html__('Vídeo MP4 (Upload)', 'maxima'),
            'description' => esc_html__('Faça upload do vídeo em formato MP4. Tamanho máximo: 50MB', 'maxima'),
            'section'     => 'video_sobre_section',
            'settings'    => 'video_sobre_mp4_upload',
            'mime_type'   => 'video/mp4',
            'active_callback' => 'maxima_video_tipo_upload_callback',
        )
    ));
    
    // Configuração para UPLOAD do vídeo WebM
    $wp_customize->add_setting('video_sobre_webm_upload', array(
        'default'           => 0,
        'sanitize_callback' => 'maxima_sanitize_media_id',
        'transport'         => 'refresh',
        'type'              => 'theme_mod',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 
        'video_sobre_webm_upload',
        array(
            'label'       => esc_html__('Vídeo WebM (Upload - Opcional)', 'maxima'),
            'description' => esc_html__('Vídeo em formato WebM para melhor compatibilidade', 'maxima'),
            'section'     => 'video_sobre_section',
            'settings'    => 'video_sobre_webm_upload',
            'mime_type'   => 'video/webm',
            'active_callback' => 'maxima_video_tipo_upload_callback',
        )
    ));
    
    // Configuração para URL do vídeo MP4 (externo)
    $wp_customize->add_setting('video_sobre_mp4_url', array(
        'default'           => '',
        'sanitize_callback' => 'maxima_sanitize_video_url',
        'transport'         => 'refresh',
        'type'              => 'theme_mod',
    ));
    
    $wp_customize->add_control('video_sobre_mp4_url', array(
        'label'       => esc_html__('URL do Vídeo MP4 (Externo)', 'maxima'),
        'description' => esc_html__('Cole a URL completa do vídeo MP4 (ex: https://site.com/video.mp4)', 'maxima'),
        'section'     => 'video_sobre_section',
        'settings'    => 'video_sobre_mp4_url',
        'type'        => 'url',
        'active_callback' => 'maxima_video_tipo_url_callback',
    ));
    
    // Configuração para URL do vídeo WebM (externo)
    $wp_customize->add_setting('video_sobre_webm_url', array(
        'default'           => '',
        'sanitize_callback' => 'maxima_sanitize_video_url',
        'transport'         => 'refresh',
        'type'              => 'theme_mod',
    ));
    
    $wp_customize->add_control('video_sobre_webm_url', array(
        'label'       => esc_html__('URL do Vídeo WebM (Externo - Opcional)', 'maxima'),
        'description' => esc_html__('Cole a URL completa do vídeo WebM', 'maxima'),
        'section'     => 'video_sobre_section',
        'settings'    => 'video_sobre_webm_url',
        'type'        => 'url',
        'active_callback' => 'maxima_video_tipo_url_callback',
    ));
    
    // Configuração para imagem de fallback/poster
    $wp_customize->add_setting('video_sobre_poster', array(
        'default'           => 0,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
        'type'              => 'theme_mod',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 
        'video_sobre_poster',
        array(
            'label'       => esc_html__('Imagem de Fallback/Poster', 'maxima'),
            'description' => esc_html__('Imagem exibida enquanto o vídeo carrega', 'maxima'),
            'section'     => 'video_sobre_section',
            'settings'    => 'video_sobre_poster',
            'mime_type'   => 'image',
        )
    ));
    
    // Configuração para ativar/desativar vídeo
    $wp_customize->add_setting('video_sobre_ativo', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
        'type'              => 'theme_mod',
    ));
    
    $wp_customize->add_control('video_sobre_ativo', array(
        'label'       => esc_html__('Ativar Vídeo de Fundo', 'maxima'),
        'description' => esc_html__('Desmarque para desativar o vídeo nesta página', 'maxima'),
        'section'     => 'video_sobre_section',
        'settings'    => 'video_sobre_ativo',
        'type'        => 'checkbox',
    ));
    
    // Configuração para vídeo em mobile
    $wp_customize->add_setting('video_sobre_mobile', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
        'type'              => 'theme_mod',
    ));
    
    $wp_customize->add_control('video_sobre_mobile', array(
        'label'       => esc_html__('Exibir Vídeo em Dispositivos Móveis', 'maxima'),
        'description' => esc_html__('Desmarque para desativar o vídeo apenas em smartphones', 'maxima'),
        'section'     => 'video_sobre_section',
        'settings'    => 'video_sobre_mobile',
        'type'        => 'checkbox',
    ));
    
    // Configuração para fallback padrão
    $wp_customize->add_setting('video_fallback_default', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
        'type'              => 'theme_mod',
    ));
    
    $wp_customize->add_control('video_fallback_default', array(
        'label'       => esc_html__('Usar Vídeo Padrão como Fallback', 'maxima'),
        'description' => esc_html__('Se nenhum vídeo for configurado, usar o vídeo padrão do tema', 'maxima'),
        'section'     => 'video_sobre_section',
        'settings'    => 'video_fallback_default',
        'type'        => 'checkbox',
    ));
}

add_action('customize_register', 'maxima_video_customizer');