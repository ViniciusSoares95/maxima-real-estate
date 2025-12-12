<?php
/**
 * Admin da Galeria
 */
class Maxima_Galeria_Admin {
    
    public function __construct() {
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post_galeria_item', array($this, 'save_meta_boxes'));
        add_filter('manage_galeria_item_posts_columns', array($this, 'add_admin_columns'));
        add_action('manage_galeria_item_posts_custom_column', array($this, 'display_admin_columns'), 10, 2);
    }
    
    /**
     * Adicionar meta boxes
     */
    public function add_meta_boxes() {
        add_meta_box(
            'maxima_gallery_details',
            __('Detalhes do Imóvel', 'maxima'),
            array($this, 'render_details_meta_box'),
            'galeria_item',
            'normal',
            'high'
        );
    }
    
    /**
     * Renderizar meta box
     */
    public function render_details_meta_box($post) {
        wp_nonce_field('maxima_gallery_save_meta', 'maxima_gallery_meta_nonce');
        
        $area = get_post_meta($post->ID, '_gallery_area', true);
        $suites = get_post_meta($post->ID, '_gallery_suites', true);
        $location = get_post_meta($post->ID, '_gallery_location', true);
        ?>
        
        <div style="display: grid; gap: 15px; padding: 10px 0;">
            <div>
                <label for="gallery_area" style="display: block; margin-bottom: 5px; font-weight: bold;">
                    <?php _e('Área (m²):', 'maxima'); ?>
                </label>
                <input type="text" id="gallery_area" name="gallery_area" 
                       value="<?php echo esc_attr($area); ?>" 
                       style="width: 100%; padding: 8px;" 
                       placeholder="<?php esc_attr_e('Ex: 150', 'maxima'); ?>">
            </div>
            
            <div>
                <label for="gallery_suites" style="display: block; margin-bottom: 5px; font-weight: bold;">
                    <?php _e('Número de Suítes:', 'maxima'); ?>
                </label>
                <input type="number" id="gallery_suites" name="gallery_suites" 
                       value="<?php echo esc_attr($suites); ?>" 
                       min="0" step="1" style="width: 100%; padding: 8px;" 
                       placeholder="<?php esc_attr_e('Ex: 3', 'maxima'); ?>">
            </div>
            
            <div>
                <label for="gallery_location" style="display: block; margin-bottom: 5px; font-weight: bold;">
                    <?php _e('Localização/Descrição:', 'maxima'); ?>
                </label>
                <input type="text" id="gallery_location" name="gallery_location" 
                       value="<?php echo esc_attr($location); ?>" 
                       style="width: 100%; padding: 8px;"
                       placeholder="<?php esc_attr_e('Ex: Vista panorâmica | Centro', 'maxima'); ?>">
            </div>
        </div>
        <?php
    }
    
    /**
     * Salvar meta boxes
     */
    public function save_meta_boxes($post_id) {
        // Verificar nonce
        if (!isset($_POST['maxima_gallery_meta_nonce']) || 
            !wp_verify_nonce($_POST['maxima_gallery_meta_nonce'], 'maxima_gallery_save_meta')) {
            return;
        }
        
        // Verificar autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        // Verificar permissões
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // Salvar campos
        $fields = array(
            'gallery_area' => 'sanitize_text_field',
            'gallery_suites' => 'absint',
            'gallery_location' => 'sanitize_text_field'
        );
        
        foreach ($fields as $field => $sanitize_callback) {
            if (isset($_POST[$field])) {
                $value = call_user_func($sanitize_callback, $_POST[$field]);
                update_post_meta($post_id, '_gallery_' . str_replace('gallery_', '', $field), $value);
            }
        }
    }
    
    /**
     * Adicionar colunas no admin
     */
    public function add_admin_columns($columns) {
        $new_columns = array();
        
        foreach ($columns as $key => $value) {
            $new_columns[$key] = $value;
            
            if ($key === 'title') {
                $new_columns['thumbnail'] = __('Imagem', 'maxima');
                $new_columns['area'] = __('Área', 'maxima');
                $new_columns['suites'] = __('Suítes', 'maxima');
            }
        }
        
        return $new_columns;
    }
    
    /**
     * Exibir conteúdo das colunas
     */
    public function display_admin_columns($column, $post_id) {
        switch ($column) {
            case 'thumbnail':
                if (has_post_thumbnail($post_id)) {
                    echo get_the_post_thumbnail($post_id, array(80, 60), array(
                        'style' => 'border-radius: 4px;'
                    ));
                } else {
                    echo '<span style="color: #999;">—</span>';
                }
                break;
                
            case 'area':
                $area = get_post_meta($post_id, '_gallery_area', true);
                echo $area ? esc_html($area . ' m²') : '<span style="color: #999;">—</span>';
                break;
                
            case 'suites':
                $suites = get_post_meta($post_id, '_gallery_suites', true);
                echo $suites ? esc_html($suites) : '<span style="color: #999;">—</span>';
                break;
        }
    }
}

new Maxima_Galeria_Admin();