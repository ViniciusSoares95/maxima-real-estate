<?php
/**
 * AJAX para Galeria
 */
class Maxima_Galeria_Ajax {
    
    public function __construct() {
        add_action('wp_ajax_maxima_load_gallery_page', array($this, 'load_gallery_page'));
        add_action('wp_ajax_nopriv_maxima_load_gallery_page', array($this, 'load_gallery_page'));
    }
    
    /**
     * Carregar página via AJAX
     */
    public function load_gallery_page() {
        // Verificar nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'maxima_gallery_nonce')) {
            wp_send_json_error(array('message' => 'Nonce inválido'));
            wp_die();
        }
        
        $paged = isset($_POST['paged']) ? absint($_POST['paged']) : 1;
        $current_url = isset($_POST['current_url']) ? esc_url_raw($_POST['current_url']) : '';
        
        // Extrair atributos do shortcode da URL se disponível
        $atts = $this->extract_shortcode_atts($current_url);
        
        // Query
        $args = array(
            'post_type' => 'galeria_item',
            'posts_per_page' => isset($atts['itens_por_pagina']) ? intval($atts['itens_por_pagina']) : 6,
            'paged' => $paged,
            'post_status' => 'publish'
        );
        
        // Filtrar por categoria se especificado
        if (isset($atts['categoria']) && !empty($atts['categoria'])) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'categoria_galeria',
                    'field' => 'slug',
                    'terms' => $atts['categoria']
                )
            );
        }
        
        $query = new WP_Query($args);
        
        if ($query->have_posts()) {
            // Gerar HTML dos itens
            ob_start();
            while ($query->have_posts()) {
                $query->the_post();
                include get_template_directory() . '/templates/gallery-item.php';
            }
            $html = ob_get_clean();
            
            // Gerar base URL para paginação
            $base_url = get_pagenum_link(1);
            if ($current_url) {
                $base_url = remove_query_arg('paged', $current_url);
                $base_url = add_query_arg('paged', '%#%', $base_url);
            }
            
            // Gerar paginação
            ob_start();
            ?>
            <nav class="gallery-pagination" id="galleryPagination">
                <?php
                $pagination_args = array(
                    'base' => $base_url,
                    'format' => '?paged=%#%',
                    'current' => $paged,
                    'total' => $query->max_num_pages,
                    'prev_text' => __('‹', 'maxima'),
                    'next_text' => __('›', 'maxima'),
                    'type' => 'list',
                    'add_args' => false,
                    'prev_next' => true,
                    'show_all' => false,
                    'end_size' => 1,
                    'mid_size' => 2
                );
                
                echo paginate_links($pagination_args);
                ?>
            </nav>
            <?php
            $pagination = ob_get_clean();
            
            wp_reset_postdata();
            
            wp_send_json_success(array(
                'html' => $html,
                'pagination' => $pagination,
                'current_page' => $paged,
                'total_pages' => $query->max_num_pages
            ));
        } else {
            wp_send_json_error(array('message' => 'Nenhum item encontrado'));
        }
        
        wp_die();
    }
    
    /**
     * Extrair atributos do shortcode da URL
     */
    private function extract_shortcode_atts($url) {
        $atts = array();
        
        if (!$url) return $atts;
        
        // Parse URL
        $url_parts = parse_url($url);
        if (!isset($url_parts['query'])) return $atts;
        
        parse_str($url_parts['query'], $query_args);
        
        // Mapear parâmetros de URL para atributos do shortcode
        if (isset($query_args['categoria'])) {
            $atts['categoria'] = sanitize_text_field($query_args['categoria']);
        }
        
        if (isset($query_args['itens_por_pagina'])) {
            $atts['itens_por_pagina'] = intval($query_args['itens_por_pagina']);
        }
        
        return $atts;
    }
}

new Maxima_Galeria_Ajax();