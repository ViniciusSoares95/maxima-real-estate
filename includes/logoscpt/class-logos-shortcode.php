<?php
/**
 * Shortcode para Logos de Parceiros
 */
class Maxima_Logos_Shortcode {
    
    public function __construct() {
        add_shortcode('maxima_logos', array($this, 'render_shortcode'));
    }
    
    /**
     * Renderizar shortcode
     */
    public function render_shortcode($atts) {
        // Atributos do shortcode
        $atts = shortcode_atts(array(
            'categoria' => '',
            'limite' => -1,
            'ordem' => 'date',
            'ordemby' => 'DESC',
            'mostrar_titulo' => 'true',
            'mostrar_descricao' => 'true'
        ), $atts, 'maxima_logos');
        
        // Iniciar buffer de saída
        ob_start();
        
        // Carregar template
        $template_path = get_template_directory() . '/templates/logos-template.php';
        if (file_exists($template_path)) {
            // Passar atributos para o template
            global $maxima_logos_atts;
            $maxima_logos_atts = $atts;
            
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
        echo '<div class="alert alert-warning">Template dos logos não encontrado.</div>';
    }
}

new Maxima_Logos_Shortcode();