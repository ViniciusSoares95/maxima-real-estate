<?php
/**
 * Custom Post Type para Logos de Portfólio
 */
class Maxima_Logos_CPT {
    
    public function __construct() {
        add_action('init', array($this, 'register_cpt'));
        add_action('init', array($this, 'register_taxonomy'));
    }
    
    /**
     * Registrar CPT
     */
    public function register_cpt() {
        $labels = array(
            'name'                  => _x('Logos de Parceiros', 'Post Type General Name', 'maxima'),
            'singular_name'         => _x('Logo de Parceiro', 'Post Type Singular Name', 'maxima'),
            'menu_name'             => __('Logos Parceiros', 'maxima'),
            'name_admin_bar'        => __('Logo de Parceiro', 'maxima'),
            'archives'              => __('Arquivo de Logos', 'maxima'),
            'attributes'            => __('Atributos do Logo', 'maxima'),
            'parent_item_colon'     => __('Logo Pai:', 'maxima'),
            'all_items'             => __('Todos os Logos', 'maxima'),
            'add_new_item'          => __('Adicionar Novo Logo', 'maxima'),
            'add_new'               => __('Adicionar Novo', 'maxima'),
            'new_item'              => __('Novo Logo', 'maxima'),
            'edit_item'             => __('Editar Logo', 'maxima'),
            'update_item'           => __('Atualizar Logo', 'maxima'),
            'view_item'             => __('Ver Logo', 'maxima'),
            'view_items'            => __('Ver Logos', 'maxima'),
            'search_items'          => __('Buscar Logo', 'maxima'),
            'not_found'             => __('Não encontrado', 'maxima'),
            'not_found_in_trash'    => __('Não encontrado na lixeira', 'maxima'),
            'featured_image'        => __('Imagem do Logo', 'maxima'),
            'set_featured_image'    => __('Definir imagem do logo', 'maxima'),
            'remove_featured_image' => __('Remover imagem do logo', 'maxima'),
            'use_featured_image'    => __('Usar como imagem do logo', 'maxima'),
            'insert_into_item'      => __('Inserir no logo', 'maxima'),
            'uploaded_to_this_item' => __('Enviado para este logo', 'maxima'),
            'items_list'            => __('Lista de logos', 'maxima'),
            'items_list_navigation' => __('Navegação da lista', 'maxima'),
            'filter_items_list'     => __('Filtrar lista', 'maxima'),
        );

        $args = array(
            'label'                 => __('Logo de Parceiro', 'maxima'),
            'description'           => __('Logos de empresas parceiras para exibição em carrossel', 'maxima'),
            'labels'                => $labels,
            'supports'              => array('title', 'thumbnail'),
            'taxonomies'            => array('categoria_logo'),
            'hierarchical'          => false,
            'public'                => false,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 26,
            'menu_icon'             => 'dashicons-building',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => false,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
        );

        register_post_type('logo_parceiro', $args);
    }
    
    /**
     * Registrar taxonomia
     */
    public function register_taxonomy() {
        $labels = array(
            'name'              => _x('Categorias de Logos', 'taxonomy general name', 'maxima'),
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
            'rewrite'           => array('slug' => 'categoria-logo'),
        );

        register_taxonomy('categoria_logo', array('logo_parceiro'), $args);
    }
}

new Maxima_Logos_CPT();