<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Class_Post_Type_Area
{
    /**
     * Construtor da Classe
     */
    public function __construct(){
        // Actions
        add_action('init', array( &$this, 'init_post_type'));

        // Filters
        add_filter('post_updated_messages', array( &$this, 'post_updated_messages'));
    }


    /**
     * Cria o tipo de post slide
     */
    function init_post_type(){

        //REGISTER ARQUIVO POST TYPE
        register_post_type( 'area',
            array(
                'labels' => array(
                    'name'               => 'Areas',
                    'singular_name'      => 'Area',
                    'add_new'            => 'Adicionar area',
                    'add_new_item'       => 'Adicionar area',
                    'edit_item'          => 'Editar area',
                    'new_item'           => 'Novo area',
                    'view_item'          => 'Ver area',
                    'search_items'       => 'Buscar area',
                    'not_found'          => 'Nenhuma Area encontrada',
                    'not_found_in_trash' => 'Nenhuma Area encontrada na lixeira',
                    'parent'             => 'Area',
                    'menu_name'          => 'Area'
                ),

                'hierarchical'    => false,
                'public'          => true,
                'query_var'       => true,
                'supports'        => array( 'title' ),
                'has_archive'     => false,
                'capability_type' => 'post',
                'rewrite'         => array('slug' => 'estrutura', 'with_front' => false),
                'menu_icon'       => 'dashicons-networking',
                'show_ui'         => true,
                'show_in_menu'    => true,
            )
        );


        if(function_exists("register_field_group"))
        {
            register_field_group(array (
                'id' => 'acf_area',
                'title' => 'Area',
                'fields' => array (
                    array (
                        'key' => 'field_536e5ce077ea9',
                        'label' => 'Membros',
                        'name' => 'membros',
                        'type' => 'repeater',
                        'required' => 1,
                        'sub_fields' => array (
                            array (
                                'key' => 'field_536e5cf777eaa',
                                'label' => 'CID',
                                'name' => 'cid',
                                'type' => 'text',
                                'column_width' => '',
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'formatting' => 'html',
                                'maxlength' => '',
                            ),
                            array (
                                'key' => 'field_536e5d5377ead',
                                'label' => 'Imagem de Perfil',
                                'name' => 'image_perfil',
                                'type' => 'image',
                                'column_width' => '',
                                'save_format' => 'object',
                                'preview_size' => 'thumbnail',
                                'library' => 'all',
                            ),
                            array (
                                'key' => 'field_536e5d1f77eac',
                                'label' => 'Nome',
                                'name' => 'nome',
                                'type' => 'text',
                                'column_width' => '',
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'formatting' => 'html',
                                'maxlength' => '',
                            ),
                            array (
                                'key' => 'field_536e5d7977eae',
                                'label' => 'Cargo',
                                'name' => 'cargo',
                                'type' => 'text',
                                'column_width' => '',
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'formatting' => 'html',
                                'maxlength' => '',
                            ),
                            array (
                                'key' => 'field_536e5d8377eaf',
                                'label' => 'Capítulo',
                                'name' => 'capitulo',
                                'type' => 'text',
                                'column_width' => '',
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'formatting' => 'html',
                                'maxlength' => '',
                            ),
                            array (
                                'key' => 'field_53b302c3dbd4b',
                                'label' => 'É Maçom',
                                'name' => 'e_macom',
                                'type' => 'checkbox',
                                'column_width' => '',
                                'choices' => array (
                                    'sim' => 'sim',
                                ),
                                'default_value' => '',
                                'layout' => 'vertical',
                            ),
                            array (
                                'key' => 'field_53b302b1dbd4a',
                                'label' => 'Loja Maçônica',
                                'name' => 'loja_maconica',
                                'type' => 'text',
                                'conditional_logic' => array (
                                    'status' => 1,
                                    'rules' => array (
                                        array (
                                            'field' => 'field_53b302c3dbd4b',
                                            'operator' => '==',
                                            'value' => 'sim',
                                        ),
                                    ),
                                    'allorany' => 'all',
                                ),
                                'column_width' => '',
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'formatting' => 'html',
                                'maxlength' => '',
                            ),
                            array (
                                'key' => 'field_53b303363193b',
                                'label' => 'E-Mail institucional',
                                'name' => 'mail',
                                'type' => 'email',
                                'column_width' => '',
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                            ),
                            array (
                                'key' => 'field_53b303413193c',
                                'label' => 'Facebook',
                                'name' => 'facebook',
                                'type' => 'text',
                                'column_width' => '',
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'formatting' => 'html',
                                'maxlength' => '',
                            ),
                        ),
                        'row_min' => 1,
                        'row_limit' => '',
                        'layout' => 'row',
                        'button_label' => 'Adicionar Membro',
                    ),
                ),
                'location' => array (
                    array (
                        array (
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'area',
                            'order_no' => 0,
                            'group_no' => 0,
                        ),
                    ),
                ),
                'options' => array (
                    'position' => 'normal',
                    'layout' => 'no_box',
                    'hide_on_screen' => array (
                    ),
                ),
                'menu_order' => 0,
            ));
        }

    }


    /**
     * Personaliza as mensagens do processo de salvamento
     */
    function post_updated_messages( $messages ) {
        global $post;
        $link = esc_url( get_permalink($post->ID));
        $link_preview = esc_url( add_query_arg('preview', 'true', get_permalink($post->ID)));
        $date = date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ));

        $messages['arquivo'] = array(
            1  => sprintf('<strong>Estrutura</strong> atualizada com sucesso - <a href="%s">Ver Estrutura</a>', $link),
            6  => sprintf('<strong>Estrutura</strong> publicada com sucesso - <a href="%s">Ver Estrutura</a>', $link),
            9  => sprintf('<strong>Estrutura</strong> agendanda para: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Ver Estrutura</a>',$date ,$link),
            10 => sprintf('Rascunho do <strong>Estrutura</strong> atualizada. <a target="_blank" href="%s">Ver Estrutura</a>', $link_preview),
        );
        return $messages;
    }
}
$Class_Post_Type_Area = new Class_Post_Type_Area();
