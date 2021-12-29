<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Class_Post_Type_Entidade
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
        add_filter( 'pre_get_posts', array( &$this, 'wp_pre_get_posts' ));

        // Mudança das colunas do WP-ADMIN
        add_filter( 'manage_edit-entidade_columns', array( &$this, 'create_custom_column'));
        add_action( 'manage_entidade_posts_custom_column', array( &$this, 'manage_custom_column'));
        add_filter( 'manage_edit-entidade_sortable_columns', array( &$this, 'manage_sortable_columns'));

        // Inclui select de listagem no WP-ADMIN
        add_filter( 'restrict_manage_posts', array( &$this, 'restrict_manage_posts' ));
        add_filter( 'parse_query', array( &$this, 'parse_query' ));
    }


    /**
     * Cria o tipo de post evento
     */
    function init_post_type(){
        register_post_type( 'entidade',
            array(
                'labels' => array(
                    'name'               => 'Entidades',
                    'singular_name'      => 'Entidade',
                    'add_new'            => 'Adicionar Novo',
                    'add_new_item'       => 'Adicionar novo Entidade',
                    'edit_item'          => 'Editar Entidade',
                    'new_item'           => 'Novo Entidade',
                    'view_item'          => 'Ver Entidade',
                    'search_items'       => 'Buscar Entidade',
                    'not_found'          => 'Nenhuma Entidade encontrado',
                    'not_found_in_trash' => 'Nenhuma Entidade encontrado na lixeira',
                    'parent_item_colon'  => '',
                    'menu_name'          => 'Entidades'
                ),

                'public'             => false,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'rewrite'            => array('slug'=>'entidades','with_front'=>false),
                'capability_type'    => 'post',
                'has_archive'        => true,
                'hierarchical'       => false,
                'menu_position'      => null,
                'menu_icon'          => 'dashicons-star-filled',
                'supports'           => array('title','thumbnail')
            )
        );

        register_taxonomy('regiao-administrativa',array('entidade'),
            array(
                'labels'  => array(
                    'name'              => 'Regiões Administrativas',
                    'singular_name'     => 'Região',
                    'search_items'      => 'Buscar região',
                    'all_items'         => 'Regiões',
                    'parent_item'       => 'Região pai',
                    'parent_item_colon' => 'Região pai',
                    'edit_item'         => 'Editar Região',
                    'update_item'       => 'Atualizar Região',
                    'add_new_item'      => 'Adicionar nova região'
                ),
                'public'        => true,
                'hierarchical'  => true,
                'show_ui'       => true,
                'query_var'     => true,
                'show_tagcloud' => false,
                'rewrite'       => array( 'slug' => 'entidades/regiao', 'with_front' => false ),
        ));

        register_taxonomy('tipo-entidade',array('entidade'),
            array(
                'labels'  => array(
                    'name'              => 'Tipos de Capítulos',
                    'singular_name'     => 'Tipos',
                    'search_items'      => 'Buscar tipo',
                    'all_items'         => 'Tipos',
                    'parent_item'       => '',
                    'parent_item_colon' => '',
                    'edit_item'         => 'Editar tipo',
                    'update_item'       => 'Atualizar tipo',
                    'add_new_item'      => 'Adicionar novo tipo'
                ),
                'public'        => true,
                'hierarchical'  => true,
                'show_ui'       => true,
                'query_var'     => true,
                'show_tagcloud' => false,
                'rewrite'       => array( 'slug' => 'entidades/tipo', 'with_front' => false ),
        ));

        if(function_exists("register_field_group")){
            register_field_group(array (
                'id' => 'acf_entidade',
                'title' => 'Entidade',
                'fields' => array (
                    array (
                        'key' => 'field_54cfb9116b443',
                        'label' => 'Número da Entidade',
                        'name' => 'numero_entidade',
                        'type' => 'number',
                        'required' => 1,
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'min' => 1,
                        'max' => '',
                        'step' => '',
                    ),
                    array (
                        'key' => 'field_54cfb9116b490',
                        'label' => 'Estandarte',
                        'name' => 'thumbnail',
                        'type' => 'image',
                        'required' => 0,
                        'save_format' => 'object',
                        'preview_size' => 'thumbnail',
                        'library' => 'all',
                    ),
                    array (
                        'key' => 'field_54cfbb526b449',
                        'label' => 'Data de Fundação',
                        'name' => 'data_fundacao',
                        'type' => 'date_picker',
                        'date_format' => 'yymmdd',
                        'display_format' => 'dd/mm/yy',
                        'first_day' => 1,
                    ),
                    array (
                        'key' => 'field_54cfb9396b444',
                        'label' => 'Situação da Entidade',
                        'name' => 'situacao_entidade',
                        'type' => 'select',
                        'required' => 1,
                        'choices' => array (
                            'ativo' => 'Ativo',
                            'inativo' => 'Inativo',
                            'irregular' => 'Irregular',
                        ),
                        'default_value' => 'ativo',
                        'allow_null' => 0,
                        'multiple' => 0,
                    ),
                    array (
                        'key' => 'field_54cfb9c06b445',
                        'label' => 'Endereço de Correspondência',
                        'name' => 'endereco',
                        'type' => 'text',
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => '',
                    ),
                    array (
                        'key' => 'field_54cfba176b446',
                        'label' => 'Cidade',
                        'name' => 'cidade',
                        'type' => 'select',
                        'required' => 1,
                        'choices' => array (
                            'Água Clara' => 'Água Clara',
                            'Alcinópolis' => 'Alcinópolis',
                            'Amambai' => 'Amambai',
                            'Anastácio' => 'Anastácio',
                            'Anaurilândia' => 'Anaurilândia',
                            'Angélica' => 'Angélica',
                            'Antônio João' => 'Antônio João',
                            'Aparecida do Taboado' => 'Aparecida do Taboado',
                            'Aquidauana' => 'Aquidauana',
                            'Aral Moreira' => 'Aral Moreira',
                            'Bandeirantes' => 'Bandeirantes',
                            'Bataguassu' => 'Bataguassu',
                            'Batayporã' => 'Batayporã',
                            'Campo Grande' => 'Campo Grande',
                            'Cassilândia' => 'Cassilândia',
                            'Douradina' => 'Douradina',
                            'Dourados' => 'Dourados',
                            'Eldorado' => 'Eldorado',
                            'Fátima do Sul' => 'Fátima do Sul',
                            'Figueirão' => 'Figueirão',
                            'Glória de Dourados' => 'Glória de Dourados',
                            'Guia Lopes da Laguna' => 'Guia Lopes da Laguna',
                            'Iguatemi' => 'Iguatemi',
                            'Inocência' => 'Inocência',
                            'Itaporã' => 'Itaporã',
                            'Itaquiraí' => 'Itaquiraí',
                            'Ivinhema' => 'Ivinhema',
                            'Japorã' => 'Japorã',
                            'Jaraguari' => 'Jaraguari',
                            'Jardim' => 'Jardim',
                            'Jateí' => 'Jateí',
                            'Juti' => 'Juti',
                            'Mundo Novo' => 'Mundo Novo',
                            'Naviraí' => 'Naviraí',
                            'Nova Alvorada do Sul' => 'Nova Alvorada do Sul',
                            'Nova Andradina' => 'Nova Andradina',
                            'Novo Horizonte do Sul' => 'Novo Horizonte do Sul',
                            'Paraíso das Águas' => 'Paraíso das Águas',
                            'Paranaíba' => 'Paranaíba',
                            'Paranhos' => 'Paranhos',
                            'Pedro Gomes' => 'Pedro Gomes',
                            'Ponta Porã' => 'Ponta Porã',
                            'Porto Murtinho' => 'Porto Murtinho',
                            'Ribas do Rio Pardo' => 'Ribas do Rio Pardo',
                            'Rio Brilhante' => 'Rio Brilhante',
                            'Rio Negro' => 'Rio Negro',
                            'Rio Verde de Mato Grosso' => 'Rio Verde de Mato Grosso',
                            'Rochedo' => 'Rochedo',
                            'Santa Rita do Pardo' => 'Santa Rita do Pardo',
                            'São Gabriel do Oeste' => 'São Gabriel do Oeste',
                            'Selvíria' => 'Selvíria',
                            'Sete Quedas' => 'Sete Quedas',
                            'Sidrolândia' => 'Sidrolândia',
                            'Sonora' => 'Sonora',
                            'Tacuru' => 'Tacuru',
                            'Taquarussu' => 'Taquarussu',
                            'Terenos' => 'Terenos',
                            'Três Lagoas' => 'Três Lagoas',
                            'Vicentina' => 'Vicentina',
                        ),
                        'default_value' => '',
                        'allow_null' => 0,
                        'multiple' => 0,
                    ),
                    array (
                        'key' => 'field_54cfbb2d6b447',
                        'label' => 'Email',
                        'name' => 'email',
                        'type' => 'email',
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                    ),
                    array (
                        'key' => 'field_54cfbb446b448',
                        'label' => 'Site',
                        'name' => 'site',
                        'type' => 'text',
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => '',
                    ),
                    array (
                        'key' => 'field_54cfbb6f6b44a',
                        'label' => 'Localização',
                        'name' => 'localizacao',
                        'type' => 'google_map',
                        'center_lat' => '-20.4810998',
                        'center_lng' => '-54.635534',
                        'zoom' => '',
                        'height' => 250,
                    ),
                ),
                'location' => array (
                    array (
                        array (
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'entidade',
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

        global $wp_rewrite;
        add_rewrite_rule(
            'entidade/tipo/([^/]*)',
            'index.php?tipo-entidade=$matches[1]',
            'top'
        );
        add_rewrite_rule(
            'entidade/regiao/([^/]*)',
            'index.php?regiao-administrativa=$matches[1]',
            'top'
        );
    }


    /**
     * Inclui código CSS no painel administrativo
     */
    function admin_head(){
        global $post;

        //Apenas no modo de edição do Post Type
        if ( isset($post->post_type) && $post->post_type == 'entidade' ){
        ?>
            <style type="text/css" media="screen">
                .column-tipo_entidade{
                    width: 120px;
                }
                .column-title{
                    width: 380px;
                }
                .column-numero_entidade {
                    width: 80px;
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
                .label-yellow,
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
                .label-yellow{
                    background-color: #f0ad4e;
                }
                .label-gray{
                    background-color: #777;
                }
            </style>
        <?php
        }
    }


    /**
     * Personaliza as mensagens do processo de salvamento
     */
    function post_updated_messages($messages){
        global $post, $post_ID;
        $link = esc_url( get_permalink($post_ID));
        $link_preview = esc_url( add_query_arg('preview', 'true', get_permalink($post_ID)));
        $date = date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ));

        $messages['evento'] = array(
            1  => sprintf('<strong>Evento</strong> atualizado com sucesso - <a href="%s">Ver Evento</a>', $link),
            6  => sprintf('<strong>Evento</strong> publicado com sucesso - <a href="%s">Ver Evento</a>', $link),
            9  => sprintf('<strong>Evento</strong> agendando para: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Ver Evento</a>',$date ,$link),
            10 => sprintf('Rascunho do <strong>Evento</strong> atualizado. <a target="_blank" href="%s">Ver Evento</a>', $link_preview),
        );
        return $messages;
    }


    /**
     * PRECISA DE UM COMENTÁRIO
     */
    function wp_pre_get_posts( $query ) {
        if ( !is_admin() && $query->is_main_query() && ( $query->is_post_type_archive('entidade') || is_tax('tipo-entidade') || is_tax('regiao-administrativa') )) {
            $query->set( 'post_type', 'entidade');
            $query->set( 'posts_per_page', '-1');
            $query->set( 'meta_query', array(
                array(
                    'key' => 'situacao_entidade',
                    'value' => 'ativo',
                    'compare' => '=',
                )
            ));
        }
        return $query;
    }


    /**
     * Cria uma coluna na lista de slides do painel administrativo
     */
    function create_custom_column($columns){
        global $post;

        $new = array();
        foreach($columns as $key => $title) {
            if ( $key=='title' ){
                $new['tipo_entidade'] = 'Tipo';
            }
            if ( $key=='date' ){
                $new['numero_entidade']   = 'Número';
                $new['situacao_entidade'] = 'Situação';
                $new['cidade']            = 'Cidade';
                $new['regiao_entidade']   = 'Região';
            }
            $new[$key] = $title;
        }
        unset( $new['date'] );
    return $new;
    }


    /**
     * Inseri valor na coluna especifica da listagem do painel administrativo
     */
    function manage_custom_column ($column)
    {
        global $post;

        switch( $column ) {
            case 'tipo_entidade' :
                $terms = get_the_terms( $post->ID, 'tipo-entidade' );
                if ( !empty( $terms ) ) {
                    $out = array();
                    foreach ( $terms as $term ) {
                        $out[] = sprintf( '<a href="%s">%s</a>',
                            esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'tipo-entidade' => $term->slug ), 'edit.php' ) ),
                            esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'tipo-entidade', 'display' ) )
                        );
                    }
                    echo join( ', ', $out );
                }
                else {
                    echo 'Não categorizado';
                }
                break;

            case 'numero_entidade' :
                echo get_field('numero_entidade');
                break;

            case 'situacao_entidade' :
                if (get_field('situacao_entidade') == 'ativo') {
                    echo '<span class="label-green">Ativo</span>';
                }elseif (get_field('situacao_entidade') == 'inativo') {
                    echo '<span class="label-red">Inativo</span>';
                }else{
                    echo '<span class="label-yellow">Irregular</span>';
                }
                break;

            case 'cidade' :
                echo get_field('cidade');
                break;

            case 'regiao_entidade' :
                $terms = get_the_terms( $post->ID, 'regiao-administrativa' );
                if ( !empty( $terms ) ) {
                    $out = array();
                    foreach ( $terms as $term ) {
                        $out[] = sprintf( '<a href="%s">%s</a>',
                            esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'regiao-administrativa' => $term->slug ), 'edit.php' ) ),
                            esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'regiao-administrativa', 'display' ) )
                        );
                    }
                    echo join( ', ', $out );
                }
                else {
                    echo 'Não categorizado';
                }
                break;
        }
    }


    /**
     * Permite que a coluna seja ordenada de acordo com o valor
     */
    function manage_sortable_columns( $columns ){
        $columns['tipoEntidade']     = 'tipoEntidade';
        $columns['numEntidade']      = 'numEntidade';
        $columns['situacaoEntidade'] = 'situacaoEntidade';
        $columns['regiaoEntidade']   = 'regiaoEntidade';
        return $columns;
    }


    /**
     * Cria caixa de seleção para filtragem no wp-admin
     */
    function restrict_manage_posts(){
        $screen = get_current_screen();
        global $wp_query;
        if ( $screen->post_type == 'entidade' ) {
            wp_dropdown_categories( array(
                'show_option_all' => 'Todas os tipos',
                'taxonomy'        => 'tipo-entidade',
                'name'            => 'tipo-entidade',
                'orderby'         => 'name',
                'selected'        => ( isset( $wp_query->query['tipo-entidade'] ) ? $wp_query->query['tipo-entidade'] : '' ),
                'hierarchical'    => false,
                'depth'           => 3,
                'show_count'      => false,
                'hide_empty'      => true,
            ) );
            wp_dropdown_categories( array(
                'show_option_all' => 'Todas as Regiões',
                'taxonomy'        => 'regiao-administrativa',
                'name'            => 'regiao-administrativa',
                'orderby'         => 'name',
                'selected'        => ( isset( $wp_query->query['regiao-administrativa'] ) ? $wp_query->query['regiao-administrativa'] : '' ),
                'hierarchical'    => false,
                'depth'           => 3,
                'show_count'      => false,
                'hide_empty'      => true,
            ) );
        }
    }


    /**
     * Passa valores de seleção para query
     */
    function parse_query( $query ){
        $qv = &$query->query_vars;
        if ( ( isset( $qv['tipo-entidade'] ) ) && is_numeric( $qv['tipo-entidade'] ) && $qv['tipo-entidade'] != '0' ) {
            $term = get_term_by( 'id', $qv['tipo-entidade'], 'tipo-entidade' );
            $qv['tipo-entidade'] = $term->slug;
        }
        if ( ( isset( $qv['regiao-administrativa'] ) ) && is_numeric( $qv['regiao-administrativa'] ) && $qv['regiao-administrativa'] != '0' ) {
            $term = get_term_by( 'id', $qv['regiao-administrativa'], 'regiao-administrativa' );
            $qv['regiao-administrativa'] = $term->slug;
        }
    }
}
$Class_Post_Type_Entidade = new Class_Post_Type_Entidade();
