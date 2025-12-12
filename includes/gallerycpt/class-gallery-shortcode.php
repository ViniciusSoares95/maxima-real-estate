<?php
/**
 * Shortcode para Galeria
 */
class Maxima_Galeria_Shortcode {
    
    public function __construct() {
        add_shortcode('maxima_galeria', array($this, 'render_shortcode'));
    }
    
    /**
     * Renderizar shortcode
     */
    public function render_shortcode($atts) {
        // Atributos do shortcode
        $atts = shortcode_atts(array(
            'categoria' => '',
            'itens_por_pagina' => 6,
            'mostrar_filtro' => 'false',
            'layout' => 'grid'
        ), $atts, 'maxima_galeria');
        
        // Iniciar buffer de saída
        ob_start();
        
        // Carregar template
        $template_path = get_template_directory() . '/templates/gallery-template.php';
        if (file_exists($template_path)) {
            // Passar atributos para o template
            global $maxima_galeria_atts;
            $maxima_galeria_atts = $atts;
            
            include $template_path;
        } else {
            // Fallback
            $this->render_fallback($atts);
        }
        
        return ob_get_clean();
    }
    
    /**
     * Fallback
     */
    private function render_fallback($atts) {
        echo '<div class="alert alert-warning">Template da galeria não encontrado.</div>';
    }
}

new Maxima_Galeria_Shortcode();