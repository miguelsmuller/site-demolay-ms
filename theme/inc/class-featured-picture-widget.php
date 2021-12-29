<?php
class Class_Widget_Featured_Picture extends WP_Widget
{
    function __construct(){
        $widget_ops  = array( 'description' => 'Mostra uma lista dos destaques cadastrados' );
        $control_ops = array();

        parent::__construct( 'widget-featured-picture', '- Widget Chamada Lateral', $widget_ops, $control_ops );
    }

    function widget( $args, $instance ) {
        extract( $args );

        $slides = new WP_Query( array(
            'post_type' => 'featured-picture',
            'posts_per_page' => -1,
            'orderby'=> 'date',
            'order'=> 'DESC'
        ) );

        while ( $slides->have_posts() ) {
            $slides->the_post();

            if (get_field('tipo_destino') == 'interno'){
                $destino_interno = get_field('destino_interno');
                $url_path =  get_permalink( $destino_interno->ID );
            }else{
                $url_path = get_field('destino_externo');
            }

            $nova_janela = get_post_meta( get_the_ID(), 'nova_janela', true ) == 'TRUE' ? ' target="_blank"' : '';

            echo '<div class="widget-featured-picture">';

            echo '<div class="panel panel-image panel-default">';
            echo "<a href='$url_path' $nova_janela>";

            $thumbnail  = get_field('thumbnail');
            $img_url    = wp_get_attachment_url( $thumbnail['id'],'full' );
            $image      = aq_resize( $img_url, 773, 335, true );
            printf('<img src="%s" alt="%s" class="img-responsive img-thumbnail">',
                $image,
                get_the_title()
            );
            echo "</a>";
            echo '</div>';

            echo '</div>';
        }


    }

    function update( $new_instance, $old_instance ){
        $instance = $old_instance;

        $instance['quantidade'] = strip_tags( $new_instance['quantidade'] );
        $instance['aleatorio'] = strip_tags( $new_instance['aleatorio'] );

        return $instance;
    }

    /* FORMULÁRIO DE ADMINITRAÇÃO DO BACKEND
    =================================================================== */
    function form( $instance ) {

        /* VALORES PADRÕES */
        $defaults = array( 'quantidade' => __('4'), 'aleatorio' => true );
        $instance = wp_parse_args( (array) $instance, $defaults );

        wp_enqueue_media();

        ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'quantidade' ); ?>">Quantidade de imagens:</label>
            <input id="<?php echo $this->get_field_id( 'quantidade' ); ?>" name="<?php echo $this->get_field_name( 'quantidade' ); ?>" value="<?php echo $instance['quantidade']; ?>" class="widefat" type="text" />
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked( isset( $instance['aleatorio']), true ); ?> id="<?php echo $this->get_field_id( 'aleatorio' ); ?>" name="<?php echo $this->get_field_name( 'aleatorio' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'aleatorio' ); ?>">Imagens aleatórias</label>
        </p>
    <?php
    }
}

?>
