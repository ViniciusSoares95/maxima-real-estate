<?php
/**
 * Custom Post Type para Galeria
 */
class Maxima_Galeria_CPT {
    
    public function __construct() {
        add_action('init', array($this, 'register_cpt'));
        add_action('init', array($this, 'register_taxonomy'));
    }
    
    /**
     * Registrar CPT
     */
    public function register_cpt() {
        $labels = array(
            'name'                  => _x('Itens da Galeria', 'Post Type General Name', 'maxima'),
            'singular_name'         => _x('Item da Galeria', 'Post Type Singular Name', 'maxima'),
            'menu_name'             => __('Galeria', 'maxima'),
            'name_admin_bar'        => __('Item da Galeria', 'maxima'),
            'archives'              => __('Arquivo da Galeria', 'maxima'),
            'attributes'            => __('Atributos do Item', 'maxima'),
            'parent_item_colon'     => __('Item Pai:', 'maxima'),
            'all_items'             => __('Todos os Itens', 'maxima'),
            'add_new_item'          => __('Adicionar Novo Item', 'maxima'),
            'add_new'               => __('Adicionar Novo', 'maxima'),
            'new_item'              => __('Novo Item', 'maxima'),
            'edit_item'             => __('Editar Item', 'maxima'),
            'update_item'           => __('Atualizar Item', 'maxima'),
            'view_item'             => __('Ver Item', 'maxima'),
            'view_items'            => __('Ver Itens', 'maxima'),
            'search_items'          => __('Buscar Item', 'maxima'),
            'not_found'             => __('Não encontrado', 'maxima'),
            'not_found_in_trash'    => __('Não encontrado na lixeira', 'maxima'),
            'featured_image'        => __('Imagem do Item', 'maxima'),
            'set_featured_image'    => __('Definir imagem', 'maxima'),
            'remove_featured_image' => __('Remover imagem', 'maxima'),
            'use_featured_image'    => __('Usar como imagem do item', 'maxima'),
            'insert_into_item'      => __('Inserir no item', 'maxima'),
            'uploaded_to_this_item' => __('Enviado para este item', 'maxima'),
            'items_list'            => __('Lista de itens', 'maxima'),
            'items_list_navigation' => __('Navegação da lista', 'maxima'),
            'filter_items_list'     => __('Filtrar lista', 'maxima'),
        );

        $args = array(
            'label'                 => __('Item da Galeria', 'maxima'),
            'description'           => __('Itens para galeria de imóveis', 'maxima'),
            'labels'                => $labels,
            'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
            'taxonomies'            => array('categoria_galeria'),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 25,
            'menu_icon'             => 'dashicons-format-gallery',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
        );

        register_post_type('galeria_item', $args);
    }
    
    /**
     * Registrar taxonomia
     */
    public function register_taxonomy() {
        $labels = array(
            'name'              => _x('Categorias da Galeria', 'taxonomy general name', 'maxima'),
            'singular_name'     => _x('Categoria', 'taxonomy singular name', 'maxima'),
            'search_items'      => __('Buscar Categorias', 'maxima'),
            'all_items'         => __('Todas as Categorias', 'maxima'),
            'parent_item'       => __('Categoria Pai', 'maxima'),
            'parent_item_colon' => __('Categoria Pai:', 'maxima'),
            'edit_item'         => __('Editar Categoria', 'maxima'),
            'update_item'       => __('Atualizar Categoria', 'maxima'),
            'add_new_item'      => __('Adicionar Nova Categoria', 'maxima'),
            'new_item_name'     => __('Nome da Nova Categoria', 'maxima'),
            'menu_name'         => __('Categorias', 'maxima'),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'show_in_rest'      => true,
            'rewrite'           => array('slug' => 'categoria-galeria'),
        );

        register_taxonomy('categoria_galeria', array('galeria_item'), $args);
    }
}

new Maxima_Galeria_CPT();