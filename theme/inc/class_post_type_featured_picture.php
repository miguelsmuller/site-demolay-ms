<?php
if ( ! defined( 'ABSPATH' ) ) exit;

include 'class-featured-picture-widget.php';

class Class_Post_Type_Featured_Picture
{
    /**
     * Construtor da Classe
     */
    public function __construct(){
        // Actions
        add_action( 'init', array( &$this, 'init_post_type'));
        add_action( 'admin_head', array( &$this, 'admin_head'));


        // Filters
        add_filter( 'post_updated_messages', array( &$this, 'post_updated_messages'));

        // Mudança das colunas do WP-ADMIN
        add_filter( 'manage_edit-featured-picture_columns',array( &$this, 'create_custom_column' ));
        add_action( 'manage_featured-picture_posts_custom_column',array( &$this, 'manage_custom_column' ));
        add_filter( 'manage_edit-featured-picture_sortable_columns',array( &$this, 'manage_sortable_columns' ));

        // Adiciona widget
        add_action('widgets_init', array( &$this, 'widgets_init' ));
    }


    /**
     * Cria o tipo de post slide
     */
    function init_post_type()
    {
        register_post_type( 'featured-picture',
            array(
                'labels' => array(
                    'name'               => 'Chamada lateral',
                    'singular_name'      => 'Chamada lateral',
                    'add_new'            => 'Adicionar nova chamada lateral',
                    'add_new_item'       => 'Adicionar nova chamada lateral',
                    'edit'               => 'Editar',
                    'edit_item'          => 'Editar chamada lateral',
                    'new_item'           => 'Novo chamada lateral',
                    'view'               => 'Ver',
                    'view_item'          => 'Ver chamada lateral',
                    'search_items'       => 'Buscar chamada',
                    'not_found'          => 'Nenhuma chamada encontrado',
                    'not_found_in_trash' => 'Nenhuma chamada encontrado na lixeira',
                    'parent'             => 'Chamada lateral',
                    'menu_name'          => 'Chamada lateral'
                ),

                'hierarchical'       => false,
                'public'             => false,
                'query_var'          => true,
                'supports'           => array('title','thumbnail'),
                'has_archive'        => true,
                'capability_type'    => 'post',
                'menu_icon'          => 'dashicons-star-filled',
                'show_ui'            => true,
                'show_in_menu'       => true,

            )
        );


        if(function_exists("register_field_group")) {
            register_field_group(array (
                'id' => 'acf_featured-picture',
                'title' => 'Imagem de Destaque',
                'fields' => array (
                    array (
                        'key' => 'field_54b5cb6a1d6ga',
                        'label' => 'Imagem',
                        'name' => 'thumbnail',
                        'type' => 'image',
                        'required' => 1,
                        'save_format' => 'object',
                        'preview_size' => 'thumbnail',
                        'library' => 'all',
                    ),
                    array (
                        'key' => 'field_54b5cb761d6gb',
                        'label' => 'Tipo de Destino',
                        'name' => 'tipo_destino',
                        'type' => 'radio',
                        'required' => 1,
                        'choices' => array (
                            'interno' => 'Destino Interno',
                            'externo' => 'Destino Externo',
                        ),
                        'other_choice' => 0,
                        'save_other_choice' => 0,
                        'default_value' => '',
                        'layout' => 'horizontal',
                    ),
                    array (
                        'key' => 'field_54b5cb781d6gc',
                        'label' => 'Destino Externo',
                        'name' => 'destino_externo',
                        'type' => 'text',
                        'required' => 1,
                        'conditional_logic' => array (
                            'status' => 1,
                            'rules' => array (
                                array (
                                    'field' => 'field_54b5cb761d6gb',
                                    'operator' => '==',
                                    'value' => 'externo',
                                ),
                            ),
                            'allorany' => 'all',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => '',
                    ),
                    array (
                        'key' => 'field_54b5cb791d6gd',
                        'label' => 'Destino Interno',
                        'name' => 'destino_interno',
                        'type' => 'post_object',
                        'required' => 1,
                        'conditional_logic' => array (
                            'status' => 1,
                            'rules' => array (
                                array (
                                    'field' => 'field_54b5cb761d6gb',
                                    'operator' => '==',
                                    'value' => 'interno',
                                ),
                            ),
                            'allorany' => 'all',
                        ),
                        'post_type' => array (
                            0 => 'post',
                            1 => 'page',
                            2 => 'evento',
                            3 => 'arquivo',
                        ),
                        'taxonomy' => array (
                            0 => 'all',
                        ),
                        'allow_null' => 0,
                        'multiple' => 0,
                    ),
                    array (
                        'key' => 'field_54b5cb7b1d6ge',
                        'label' => 'Abrir em nova Janela',
                        'name' => 'nova_janela',
                        'type' => 'checkbox',
                        'choices' => array (
                            'sim' => 'Sim, eu gostaria que essa página fosse aberta em uma nova janela',
                        ),
                        'default_value' => '',
                        'layout' => 'vertical',
                    ),
                ),
                'location' => array (
                    array (
                        array (
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'featured-picture',
                            'order_no' => 0,
                            'group_no' => 0,
                        ),
                    ),
                ),
                'options' => array (
                    'position' => 'normal',
                    'layout' => 'default',
                    'hide_on_screen' => array (
                        0 => 'permalink',
                        1 => 'the_content',
                        2 => 'excerpt',
                        3 => 'custom_fields',
                        4 => 'discussion',
                        5 => 'comments',
                        6 => 'revisions',
                        7 => 'slug',
                        8 => 'author',
                        9 => 'format',
                        10 => 'featured_image',
                        11 => 'categories',
                        12 => 'tags',
                        13 => 'send-trackbacks',
                    ),
                ),
                'menu_order' => 0,
            ));
        }
    }


    /**
     * Inclui código CSS no painel administrativo
     */
    function admin_head()
    {
        global $post;

        //Apenas no modo de edição do Post Type
        if ( isset($post->post_type) && $post->post_type == 'featured-picture' ){
        ?>
            <style type="text/css" media="screen">
                .column-featured_image{
                    width: 300px;
                }
                .misc-pub-visibility,
                .misc-pub-curtime{
                    display: none;
                }
                .misc-pub-section {
                    padding: 6px 10px 18px;
                }
                .label-red,
                .label-green,
                .label-gray{
                    position: relative;
                    top: 5px;
                    padding: .3em 0.6em .3em;
                    font-weight: bold;
                    border-radius: .25em;
                    line-height: 1;
                    color: #FFF;
                    text-align: center;
                    white-space: nowrap;
                    vertical-align: baseline;
                    display: inline;
                }
                .label-red{
                    background-color: #D9534F;
                }
                .label-green{
                    background-color: #5CB85C;
                }
                .label-gray{
                    background-color: #777;
                }
            </style>
        <?php
        }
        //Em qualquer página do painel administrativo
        ?>
    <?php
    }


    /**
     * Personaliza as mensagens do processo de salvamento
     */
    function post_updated_messages( $messages ) {
        global $post;
        $postDate = date_i18n(get_option('date_format'), strtotime( $post->post_date ));

        $messages['featured-picture'] = array(
            1  => '<strong>Destaque</strong> atualizado com sucesso',
            6  => '<strong>Destaque</strong> publicado com sucesso',
            9  => sprintf('<strong>Destaque</strong> agendando para <strong>%s</strong>', $postDate),
            10 => 'Rascunho do <strong>Destaque</strong> atualizado'
        );
        return $messages;
    }


    /**
     * Cria uma coluna na lista de slides do painel administrativo
     */
    function create_custom_column($columns)
    {
        global $post;

        $new = array();
        foreach($columns as $key => $title) {
            if ( $key=='title' )
                $new['featured_image'] = 'Destaque';
            if ( $key=='date' ){
                $new['status'] = 'Situação';
                $new['link']    = 'Link';
            }
            $new[$key] = $title;
        }
    return $new;
    }


    /**
     * Inseri valor na coluna especifica da listagem do painel administrativo
     */
    function manage_custom_column ($column)
    {
        global $post;

        switch( $column ) {
            case 'featured_image' :
                $thumbnail = get_field('thumbnail');

                if( $thumbnail ) {
                    if ( in_array( 'slide', get_intermediate_image_sizes() )){
                        $new_url = wp_get_attachment_image_src($thumbnail['id'], 'slide');
                        $thumbnail['url'] = $new_url[0];
                    }else{
                        $new_url = wp_get_attachment_image_src($thumbnail['id'], 'thumbnail');
                        $thumbnail['url'] = $new_url[0];
                    }

                    $url_edit_post = get_bloginfo('wpurl') .'/wp-admin/post.php?post='.$post->ID.'&action=edit';
                    echo '<a href="'. $url_edit_post .'"><img width="100%" src="'. $thumbnail['url'] .'" /></a>';
                }
                break;

            case 'status' :
                if (get_post_status( $post->ID ) == 'draft') {
                    echo '<span class="label-red">Rascunho</span>';
                }else{
                    echo '<span class="label-green">Publicado</span>';
                }
                break;

            case 'link' :
                if (get_field('tipo_destino') == 'interno'){
                    $destino_interno = get_field('destino_interno');
                    echo '<span class="label-gray">Interno</span><br><br><a href="'. get_permalink( $destino_interno->ID ) .'"target="_blank">['. $destino_interno->post_type . '] - ' . $destino_interno->post_title .'</a>';
                }else{
                    echo '<span class="label-gray">Externo</span><br><br><a href="'. get_field('destino_externo') .'" target="_blank">'. get_field('destino_externo') .'</a>';
                }
                break;
        }
    }


    /**
     * Permite que a coluna seja ordenada de acordo com o valor
     */
    function manage_sortable_columns( $columns ){
        $columns['status'] = 'status';
        return $columns;
    }


    /**
    * Register "arquivo" post type widget
    *
    * @return void
    */
    function widgets_init() {
        register_widget( 'Class_Widget_Featured_Picture' );
    }
}
$Class_Post_Type_Featured_Picture = new Class_Post_Type_Featured_Picture();
