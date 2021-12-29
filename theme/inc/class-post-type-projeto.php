<?php
/*
Name: Post Type Entidade
Description: Gerencia o Custom Post Type Slide
Version: 1.0
Author: Miguel Müller
AuthorURI: https://github.com/miguelsneto
license: Creative Commons - Atribuição-NãoComercial-SemDerivados 3.0 Não Adaptada License.
LicenseURI: http://creativecommons.org/licenses/by-nc-nd/3.0/
*/

class ClassPostTypeProjeto
{
    public function __construct(){
        add_action('init', array( &$this, 'initPostType'));
    }

    // #############################################################
    // Inicia o Post Type
    // #############################################################
    function initPostType(){
        register_post_type( 'projeto',
            array(
                'labels' => array(
                    'name'               => 'Projetos',
                    'singular_name'      => 'Projeto',
                    'add_new'            => 'Adicionar Novo',
                    'add_new_item'       => 'Adicionar novo Projeto',
                    'edit_item'          => 'Editar Projeto',
                    'new_item'           => 'Novo Projeto',
                    'view_item'          => 'Ver Projeto',
                    'search_items'       => 'Buscar Projeto',
                    'not_found'          => 'Nenhuma Projeto encontrado',
                    'not_found_in_trash' => 'Nenhuma Projeto encontrado na lixeira',
                    'parent_item_colon'  => '',
                    'menu_name'          => 'Projetos'
                ),

                'hierarchical'    => false,
                'public'          => true,
                'query_var'       => true,
                'rewrite'         => array('with_front' => false),
                'menu_position'   => null,
                'supports'        => array( 'title','editor' ),
                'has_archive'     => true,
                'capability_type' => 'post',
                'menu_icon'       => 'dashicons-media-interactive',
            )
        );

        /*register_taxonomy('tipo-projeto',array('projeto'),
            array(
                'labels'  => array(
                    'name'              => 'Tipos de projetos',
                    'singular_name'     => 'Tipo de projeto',
                    'search_items'      => 'Buscar Tipos de projetos',
                    'all_items'         => 'Tipos de projetos',
                    'parent_item'       => 'Tipo de projeto pai',
                    'parent_item_colon' => 'Tipo de projeto pai',
                    'edit_item'         => 'Editar Tipo de projeto',
                    'update_item'       => 'Atualizar Tipo de projeto',
                    'add_new_item'      => 'Adicionar novo Tipo de projeto'
                ),
                'public'        => true,
                'hierarchical'  => true,
                'show_ui'       => true,
                'query_var'     => true,
                'show_tagcloud' => false,
                'rewrite'       => array( 'slug' => 'tipo-projeto', 'with_front' => false ),
        ));*/

    }
}
$ClassPostTypeProjeto = new ClassPostTypeProjeto();
