<?php
if ( ! defined( 'ABSPATH' ) ) exit;

include dirname(__FILE__).'/../assets/components/Aqua-Resizer/aq_resizer.php';

include 'class-post-type-area.php';
include 'class-post-type-entidade.php';
include 'class-post-type-projeto.php';
include 'class_post_type_featured_picture.php';

/**
 * Criação dos menus, Configuração dos Thumbnails e dos ativação dos formatos de posts
 */
add_action( 'after_setup_theme', 'after_setup_theme' );
function after_setup_theme() {
    register_nav_menus(array(
        'menu-principal'       => 'Menu Principal',
        'menu-superior'        => 'Menu Superior Visitante',
        'menu-superior-logado' => 'Menu Superior Logado',
        'menu-rodape'          => 'Menu Rodapé'
    ));

    add_theme_support('post-thumbnails', array('post', 'page'));
    set_post_thumbnail_size( 250, 180, array( 'center', 'center') );
}


/**
 * Criação dos menus, Configuração dos Thumbnails e dos ativação dos formatos de posts
 */
add_action( 'init', 'init_wp' );
function init_wp() {
    update_option('thumbnail_size_w', 300);
    update_option('thumbnail_size_h', 300); // arhive notica
    update_option('thumbnail_crop', 1 );

    update_option('medium_size_w', 700); // entidade e people
    update_option('medium_size_h', 700);
    if(!get_option("medium_crop"))
        add_option("medium_crop", "1");
    else
        update_option("medium_crop", "1");

    update_option('large_size_w', 1024);
    update_option('large_size_h', 1024);
    if(!get_option("large_crop"))
        add_option("large_crop", "1");
    else
        update_option("large_crop", "1");

    //add_image_size('thumbnail-large', 855, 380, true );
    //add_image_size('slide', '750', '290', array( 'top', 'center') );

    /**
     * 220x220 archive-entidade
     * 500x500 archive-area
     * 250x180 archive
     * 750x290 index - slide
     * 745x170 index - noticia
     * 975x200 single AND page
     */

    /**
     * 300X300 archive-entidade AND archive-area NORMAL
     * 250x180 archive NORMAL
     * 750x290 index - slide AQ_RESIZE
     * 1170x240 index - noticia AND single AND page AQ_RESIZE
     */
}


/**
 * Registra uma área de widgets e desabilita alguns widgets padrões
 */
add_action( 'widgets_init', 'widgets_init' );
function widgets_init() {
    register_sidebar( array(
            'name'          => 'Sidebar Principal',
            'id'            => 'sidebar-principal',
            'description'   => 'Sidebar Principal',
            'before_widget' => '<div class="panel panel-default">',
            'before_title'  => '<h1 class="heading"><span class="title">',
            'after_title'   => '</span><span class="bottom"></span></h1><div class="panel-body">',
            'after_widget'  => '</div></div>'
        ));
        register_sidebar( array(
            'name'          => 'Sidebar Secundária',
            'id'            => 'sidebar-secundaria',
            'description'   => 'Sidebar Secundária',
            'before_widget' => '<div class="panel panel-default">',
            'before_title'  => '<h1 class="heading"><span class="title">',
            'after_title'   => '</span><span class="bottom"></span></h1><div class="panel-body">',
            'after_widget'  => '</div></div>'
        ));

    unregister_widget( 'WP_Widget_Pages' );
    unregister_widget( 'WP_Widget_Calendar' );
    unregister_widget( 'WP_Widget_Archives' );
    unregister_widget( 'WP_Widget_Links' );
    unregister_widget( 'WP_Widget_Meta' );
    unregister_widget( 'WP_Widget_Categories' );
    unregister_widget( 'WP_Widget_Recent_Posts' );
    unregister_widget( 'WP_Widget_Recent_Comments' );
    unregister_widget( 'WP_Widget_RSS' );
    unregister_widget( 'WP_Widget_Tag_Cloud' );
}


/**
 * Carrega os arquivos JS's e CSS's do tema
 */
add_action('wp_enqueue_scripts', 'enqueue_scripts' );
function enqueue_scripts(){
	$template_dir = get_bloginfo('template_directory');

  $enabled_jquery = TRUE;
		if ( apply_filters( 'enabled_jquery', $enabled_jquery )  == TRUE ) {
			wp_deregister_script( 'jquery' );

			wp_register_script( 'jquery', $template_dir .'/assets/components/jquery/dist/jquery.js', null, null, true );
			wp_enqueue_script( 'jquery' );
		}

	// COMMON STYLE AND SCRIPT
	wp_register_script( 'common-js', $template_dir .'/assets/js/javascript.min.js', array('jquery'), null, true );
	wp_localize_script(
		'common-js',
		'common_params',
		array(
			'site_url'  => esc_url( site_url() )
		)
	);

	wp_enqueue_script( 'common-js' );
	wp_enqueue_style( 'common-css', $template_dir .'/assets/css/style.css' );

  wp_enqueue_style('owl-core', get_bloginfo('template_directory').'/assets/components/owl.carousel/dist/assets/owl.carousel.min.css', false, '', true );
  wp_enqueue_style('owl-theme', get_bloginfo('template_directory').'/assets/components/owl.carousel/dist/assets/owl.theme.default.min.css', false, '', true );

  wp_enqueue_style( 'google-font', 'http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800');
  if ( is_single() || is_page() ) {
      wp_enqueue_script('lightbox', get_bloginfo('template_directory').'/assets/components/lightbox/js/lightbox.min.js', false, '', true );
      wp_enqueue_style('lightbox', get_bloginfo('template_directory').'/assets/components/lightbox/css/lightbox.css');
  }
}


/**
 * Função quer permite a página infinita
 */
add_action('wp_ajax_infinite_scroll', 'wp_infinite_scroll');
add_action('wp_ajax_nopriv_infinite_scroll', 'wp_infinite_scroll');
function wp_infinite_scroll(){
    $template        = $_POST['template'];
    $post_type       = $_POST['post_type'];
    $posts_per_page  = $_POST['posts_per_page'];
    $paged           = $_POST['paged'];

    query_posts(array('post_type' => $post_type, 'posts_per_page' => $posts_per_page, 'paged' => $paged,));
    get_template_part( $template );

    exit;
}


/**
 * Evira o envio de imagem com tamanho pequeno
 */
add_filter('wp_handle_upload_prefilter','minimin_image_size');
function minimin_image_size($file)
{
    $img  =getimagesize($file['tmp_name']);
    $min_size = array('width' => '600', 'height' => '600');
    $max_size = array('width' => '2048', 'height' => '2048');
    $width = $img[0];
    $height = $img[1];

    if ($width < $min_size['width'] )
        return array("error"=>"Imagem muito pequena. Largura miníma é {$min_size['width']}px. A imagem que você enviou possui $width px de largura");

    elseif ($height <  $min_size['height'])
        return array("error"=>"Imagem muito pequena. Altura miníma é {$min_size['height']}px. A imagem que você enviou possui $height px de altura");

    elseif ($width >  $max_size['width'])
        return array("error"=>"Imagem muito grande. Altura máxima é {$max_size['width']}px. A imagem que você enviou possui $width px de altura");

    elseif ($height >  $max_size['height'])
        return array("error"=>"Imagem muito grande. Altura máxima é {$max_size['height']}px. A imagem que você enviou possui $height px de altura");

    else
        return $file;
}


/**
 * Remove o CSS e o JS do CF7 onde não tem necessidade
 */
add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );
add_action( 'wp_head', 'cf_register_assets' );
function cf_register_assets() {
	if ( is_page( 'contact-us' ) ) {
		wpcf7_enqueue_scripts();
		wpcf7_enqueue_styles();
	}
}



/**
 * Mensagem de atualização de navegador inseguro
 */
add_filter( 'navigator_insecure', 'navigator_insecure' );
function navigator_insecure( $msg ){
    return 'Parece que está a usar uma versão não segura do <a href="%update_url%" class="alert-link">%name%</a>. Para melhor navegar no nosso site, por favor atualize o seu browser.<br/><a href="%update_url%" class="alert-link">Clique aqui para ser direcionado para atualização do %name% agora.</a>';
}


/**
 * Mensagem de atualização de navegador desatualizado
 */
add_filter( 'navigator_upgrade', 'navigator_upgrade' );
function navigator_upgrade( $msg ){
    return 'Parece que está a usar uma versão antiga do <a href="%s" class="alert-link"%name%</a>. Para melhor navegar no nosso site, por favor atualize o seu browser.<br/><a href="%update_url%" class="alert-link">Clique aqui para ser direcionado para atualização do %name% agora.</a>';
}


/**
 * Determina a imagem que será usada no fundo da página de login
 */
add_filter( 'change_login_bg', 'change_login_bg' );
function change_login_bg( $img ){
    return get_bloginfo( 'template_directory' ) . '/assets/images/bg-main.png';
}


/**
 * Determina a imagem que será usada como logo na página de login
 */
add_filter( 'change_login_logo', 'change_login_logo' );
function change_login_logo( $img ){
    return get_bloginfo( 'template_directory' ) . '/assets/images/image-login.png';
}


/**
 * Cria um formulário pra ser usada pra configuração do tema
 */
add_action( 'admin_init', 'admin_init' );
function admin_init()
{
    /**
     * Endereçamento
     */
    add_settings_section(
        'section-address',             // ID usado para identificar esta secção e com a qual se registrar opções
        'Endereço de correspondência', // Título a ser exibido na página de administração
        null,                          // Callback usado para tornar a descrição da seção
        'page-config-theme'            // Página em que para adicionar esta seção de opções
    );
    add_settings_field(
        'address',                      // ID usado para identificar o campo ao longo do tema
        'Endereço de correspondência:', //Label do elemento na interface de opção
        function () {
            $config_theme = get_option( 'config_theme' );
            $html =  '<textarea id="address" name="config_theme[address]" rows="6" cols="70">' . $config_theme['address'] . '</textarea>';
            echo $html;
        },
        'page-config-theme', // A página em que esta opção será exibida
        'section-address'    // O nome da secção à qual pertence este campo
    );

    /**
     * Lideranças
     */
    add_settings_section(
        'section-leadership',
        'Lideranças desse grande capítulo',
        null,
        'page-config-theme'
    );
    add_settings_field(
        'gme',
        'Grande Mestre Estadual:',
        function () {
            $config_theme = get_option( 'config_theme' );
            $html = '<input type="text" id="gme" name="config_theme[gme]" value="'. $config_theme['gme'] .'" class="regular-text">';
            echo $html;
        },
        'page-config-theme',
        'section-leadership'
    );
    add_settings_field(
        'mce',
        'MCE:',
        function () {
            $config_theme = get_option( 'config_theme' );
            $html = '<input type="text" id="mce" name="config_theme[mce]" value="'. $config_theme['mce'] .'" class="regular-text">';
            echo $html;
        },
        'page-config-theme',
        'section-leadership'
    );
    add_settings_field(
        'mcea',
        'MCEA:',
        function () {
            $config_theme = get_option( 'config_theme' );
            $html = '<input type="text" id="mcea" name="config_theme[mcea]" value="'. $config_theme['mcea'] .'" class="regular-text">';
            echo $html;
        },
        'page-config-theme',
        'section-leadership'
    );


    register_setting(
        'page-config-theme',
        'config_theme',
        function( $input ) {
            $output = array();

            foreach( $input as $key => $val ) {

                if( isset ( $input[$key] ) ) {
                    $output[$key] = strip_tags( stripslashes( $input[$key] ), '<br><br/><br />' );
                }
                //if( isset ( $input[$key] ) ) {
                    //$output[$key] = esc_url_raw( strip_tags( stripslashes( $input[$key] ) ) );
                //}
            }
            return apply_filters( 'sandbox_theme_sanitize_social_options', $output, $input );
        }
    );
}


/**
 * Cria um item do menu para o formulário criado
 */
add_action( 'admin_menu', 'admin_menu' );
function admin_menu()
{
    $page = add_submenu_page(
        'options-general.php',// $parent_slug
        'Outras configurações',// $page_title
        'Outras configurações',// $menu_title
        'administrator',// $capability
        'config-theme',// $menu_slug
        function () {
            ?>
            <div class="wrap">
                <div id="icon-options-general" class="icon32"></div>
                <h2>Configurações Gerais</h2>
                <form method="post" action="options.php">
                    <?php
                    settings_fields( 'page-config-theme' );
                    do_settings_sections( 'page-config-theme' );
                    submit_button();
                    ?>
                </form>
            </div>
            <?php
        }
    );
}


/**
 * PRECISA DE UM COMENTÁRIO
 */
add_action('add_meta_boxes', 'add_meta_boxe_page');
function add_meta_boxe_page() {
    add_meta_box(
        'page_option',
        'Opções da página:',
        function(){
            global $post;
            wp_nonce_field('nonce_action', 'nonce_name');

            $mostrar_index = get_post_meta( get_the_ID(), 'mostrar_index', True);
            $mostrar_index = ( empty($mostrar_index) or ($mostrar_index == 0)) ? False : True;

            ?>
            <div id="extrafields">
                <table class="form-table">
                    <tbody>
                        <tr valign="top">
                            <th scope="row"><label for="mostrar_index">Mostrar essa página na home: </label></th>
                            <td>
                                <input type="checkbox" id="mostrar_index" name="mostrar_index" <?php checked( $mostrar_index, True ); ?> />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php
        },
        'page',
        'side',
        'default'
    );
}


/**
 * PRECISA DE UM COMENTÁRIO
 */
add_action('save_post', 'save_meta_page');
function save_meta_page( $post_id ) {
    if (get_post_type($post_id) !== 'page')
    return $post_id;

    // Antes de dar inicio ao salvamento precisamos verificar 3 coisas:
    // Verificar se a publicação é salva automaticamente
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    //Verificar o valor nonce criado anteriormente, e finalmente
    if( !isset( $_POST['nonce_name'] ) || !wp_verify_nonce($_POST['nonce_name'], 'nonce_action') ) return;
    //Verificar se o usuário atual tem acesso para salvar a pulicação
    if( !current_user_can( 'edit_post' ) ) return;

    // MOSTRAR_THUMB_SINGLE
    $valueChk = isset( $_POST['mostrar_index'] ) && $_POST['mostrar_index'] ? 1 : 0;
        update_post_meta( $post_id, 'mostrar_index', $valueChk );
}


/**
 * Callback para paginação customizada
 */
function do_pagination( $args = array() ) {
    global $wp_query;

    $defaults = array(
        'big_number' => 999999999,
        'base'       => str_replace( 999999999, '%#%', get_pagenum_link( 999999999 ) ),
        'format'     => '?paged=%#%',
        'current'    => max( 1, get_query_var( 'paged' ) ),
        'total'      => $wp_query->max_num_pages,
        'prev_next'  => true,
        'end_size'   => 1,
        'mid_size'   => 2,
        'type'       => 'list'
    );

    $args = wp_parse_args( $args, $defaults );
    extract( $args, EXTR_SKIP );

    if ( $total == 1 ) return;

    $paginate_links = apply_filters( 'paginacao', paginate_links( array(
        'base'      => $base,
        'format'    => $format,
        'current'   => $current,
        'total'     => $total,
        'prev_next' => $prev_next,
        'end_size'  => $end_size,
        'mid_size'  => $mid_size,
        'type'      => $type
    ) ) );

    echo preg_replace( "/<ul class='page-numbers/", "<ul class='pagination", $paginate_links);
}


/**
 * PRECISA DE UM COMENTÁRIO
 */
function list_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);
?>
    <li id="comment-<?php comment_ID() ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?>>

    <div class="comment-avatar">
        <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
    </div>

    <div class="comment-body">
        <?php if ( $comment->comment_approved == '0' ) : ?>
            <em class="label label-warning label-awaiting-moderation">Esse comentário está aguardando moderação.</em>
        <?php endif; ?>
        <?php
            $name = '<cite class="fn">'. get_comment_author_link() .'</cite>';
            $time = human_time_diff( get_comment_date('U'), current_time('timestamp') ) . ' atrás';
            $time = '<a href="'. htmlspecialchars( get_comment_link( $comment->comment_ID ) ) . '">'. $time . '</a>';
            echo $name .' • '. $time ;
        ?>

        <?php edit_comment_link( '(Edit)', '  ', '' );?>

        <?php comment_text(); ?>

        <div class="reply">
        <?php
            $argsMerge = array_merge( $args, array(
                                        'add_below' => 'div-comment',
                                        'depth' => $depth,
                                        'max_depth' => $args['max_depth'] )
            );
            $replyLink = get_comment_reply_link( $argsMerge );
            echo $replyLink;
        ?>
        </div>
    </div>
<?php
}
