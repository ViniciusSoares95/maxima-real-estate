<?php
/**
 * Admin da Seção de Logos
 */
class Maxima_Logos_Admin {
    
    public function __construct() {
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post_logo_parceiro', array($this, 'save_meta_boxes'));
        add_filter('manage_logo_parceiro_posts_columns', array($this, 'add_admin_columns'));
        add_action('manage_logo_parceiro_posts_custom_column', array($this, 'display_admin_columns'), 10, 2);
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
    }
    
    /**
     * Adicionar meta boxes
     */
    public function add_meta_boxes() {
        add_meta_box(
            'maxima_logo_details',
            __('Detalhes do Logo', 'maxima'),
            array($this, 'render_details_meta_box'),
            'logo_parceiro',
            'normal',
            'high'
        );
    }
    
    /**
     * Renderizar meta box
     */
    public function render_details_meta_box($post) {
        wp_nonce_field('maxima_logo_save_meta', 'maxima_logo_meta_nonce');
        
        $website = get_post_meta($post->ID, '_logo_website', true);
        $destaque = get_post_meta($post->ID, '_logo_destaque', true);
        ?>
        
        <div style="display: grid; gap: 15px; padding: 10px 0;">
            <div>
                <label for="logo_website" style="display: block; margin-bottom: 5px; font-weight: bold;">
                    <?php _e('Website da Empresa:', 'maxima'); ?>
                </label>
                <input type="url" id="logo_website" name="logo_website" 
                       value="<?php echo esc_url($website); ?>" 
                       style="width: 100%; padding: 8px;" 
                       placeholder="<?php esc_attr_e('https://exemplo.com.br', 'maxima'); ?>">
                <p style="margin-top: 5px; color: #666; font-size: 12px;">
                    <?php _e('Link para o site da empresa (opcional)', 'maxima'); ?>
                </p>
            </div>
            
            <div>
                <label for="logo_destaque" style="display: block; margin-bottom: 5px; font-weight: bold;">
                    <input type="checkbox" id="logo_destaque" name="logo_destaque" 
                           value="1" <?php checked($destaque, '1'); ?>>
                    <?php _e('Destacar este logo', 'maxima'); ?>
                </label>
                <p style="margin-top: 5px; color: #666; font-size: 12px;">
                    <?php _e('Logos destacados aparecem primeiro no carrossel', 'maxima'); ?>
                </p>
            </div>
            
            <div>
                <p style="font-weight: bold; margin-bottom: 5px;"><?php _e('Recomendações:', 'maxima'); ?></p>
                <ul style="color: #666; font-size: 12px; margin: 0; padding-left: 20px;">
                    <li><?php _e('Use imagens com fundo transparente (PNG)', 'maxima'); ?></li>
                    <li><?php _e('Dimensão ideal: 400x200 pixels', 'maxima'); ?></li>
                    <li><?php _e('Formato: PNG, JPG ou SVG', 'maxima'); ?></li>
                </ul>
            </div>
        </div>
        <?php
    }
    
    /**
     * Salvar meta boxes
     */
    public function save_meta_boxes($post_id) {
        // Verificar nonce
        if (!isset($_POST['maxima_logo_meta_nonce']) || 
            !wp_verify_nonce($_POST['maxima_logo_meta_nonce'], 'maxima_logo_save_meta')) {
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
            'logo_website' => 'esc_url_raw',
            'logo_destaque' => 'absint'
        );
        
        foreach ($fields as $field => $sanitize_callback) {
            if (isset($_POST[$field])) {
                $value = call_user_func($sanitize_callback, $_POST[$field]);
                update_post_meta($post_id, '_logo_' . str_replace('logo_', '', $field), $value);
            } else {
                // Se é checkbox e não foi marcado, salva como 0
                if ($field === 'logo_destaque') {
                    update_post_meta($post_id, '_logo_destaque', 0);
                }
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
                $new_columns['thumbnail'] = __('Logo', 'maxima');
                $new_columns['website'] = __('Website', 'maxima');
                $new_columns['destaque'] = __('Destacado', 'maxima');
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
                    echo get_the_post_thumbnail($post_id, array(80, 40), array(
                        'style' => 'border-radius: 4px; background: #f5f5f5; padding: 5px;'
                    ));
                } else {
                    echo '<span style="color: #999; background: #f5f5f5; padding: 5px 10px; border-radius: 4px;">' . __('Sem imagem', 'maxima') . '</span>';
                }
                break;
                
            case 'website':
                $website = get_post_meta($post_id, '_logo_website', true);
                if ($website) {
                    echo '<a href="' . esc_url($website) . '" target="_blank" style="font-size: 12px;">' . esc_html($website) . '</a>';
                } else {
                    echo '<span style="color: #999;">—</span>';
                }
                break;
                
            case 'destaque':
                $destaque = get_post_meta($post_id, '_logo_destaque', true);
                if ($destaque) {
                    echo '<span style="color: #46b450; font-weight: bold;">✓</span>';
                } else {
                    echo '<span style="color: #999;">—</span>';
                }
                break;
        }
    }
    
    /**
     * Enqueue admin styles
     */
    public function enqueue_admin_styles($hook) {
        if ('post.php' !== $hook && 'post-new.php' !== $hook) {
            return;
        }
        
        global $post_type;
        if ('logo_parceiro' !== $post_type) {
            return;
        }
        
        wp_enqueue_style(
            'maxima-logos-admin',
            get_template_directory_uri() . '/assets/css/logos-admin.css',
            array(),
            '1.0.0'
        );
    }
}

new Maxima_Logos_Admin();