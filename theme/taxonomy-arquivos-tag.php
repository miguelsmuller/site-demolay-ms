<?php get_header(); ?>

<!-- CONTEÚDO PRÉVIO -->
<div class="container-auxiliar">
    <div class="container">

    </div>
</div>

<!-- CONTEÚDO PRINCIPAL -->
<div class="container-principal" role="main">
    <div class="container">

        <!-- NOTÍCIAS / BARRA LATERAL -->
        <div class="row">

            <!-- COLUNA DE NOTICIAS -->
            <section class="col-sm-12 col-md-8">
                <header>
                    <?php $term = get_term_by( 'slug', get_query_var( 'term' ), 'arquivos-tag' ); ?>
                    <h1>Biblioteca - Referências "<?php echo $term->name ?>"</h1>
                </header>

                
                <?php
            $termchildren = get_term_children( $term->term_id, 'arquivos-tag' );

            // CASO SEJA UMA CATEGORIA COM CATEGORIAS FILHOS
            if ( count($termchildren) >= 1) {
                echo str_replace("\r\n", "<br/>", $term->description);
                $args = array(
                    'taxonomy'          => 'arquivos-tag',
                    'hide_empty'        => false,
                    'title_li'          => '',
                    'child_of'          => $term->term_id
                );
                echo '<ul class="well list-unstyled">';
                    wp_list_categories( $args );
                echo '</ul>';

            // CASO SEJA A ULTIMA CATEGORIA NA ESCALA HIERÁRQUICA
            }else{
                echo $term->description ;

                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                $loop = new WP_Query(array(
                    'post_type' => 'arquivo',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'arquivos-tag',
                            'field' => 'slug',
                            'terms' => $term->slug,
                            'include_children' => false
                        )
                    ),
                    'paged'   => $paged,
                    'orderby' => 'title',
                    'order'   => 'ASC'
                ));
            ?>
                <ul class="list-unstyled">
                    <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                        <?php
                        //DADOS BÁSICOS DA PUBLICAÇÃO
                        $id                   = $post->ID;
                        $title                = get_the_title();
                        $permalink            = get_permalink();

                        //META DADOS DA PUBLICAÇÃO
                        $urlArquivo          = get_post_meta($post->ID, 'urlArquivo', TRUE);
                        $dirArquivo          = get_post_meta($post->ID, "dirArquivo", TRUE);
                        $nomeArquivo         = get_post_meta($post->ID, "nomeArquivo", TRUE);
                        $extArquivo          = get_post_meta($post->ID, "extArquivo", TRUE);
                        $quantidadeDownloads = get_post_meta($post->ID, 'quantidadeDownloads', TRUE);
                        $privado             = get_post_meta($post->ID, 'privado', TRUE)  == 'TRUE' ? TRUE : FALSE;
                        $indisponivel        = get_post_meta($post->ID, 'indisponivel', TRUE)  == 'TRUE' ? TRUE : FALSE;

                        //PREPARAR ALGUNS VALORES
                        $dirArquivo          = str_replace("#", "/", $dirArquivo);
                        $quantidadeDownloads = empty($quantidadeDownloads) ? '0' : $quantidadeDownloads;

                        //ALGUMAS
                        $permalink_visualizar = get_permalink().'action-arquivo/visualizar';
                        $permalink_download   = get_permalink().'action-arquivo/download';

                        if ($indisponivel == TRUE ) {
                            $links = "<p>Esse download se encontra indisponível no momento.</p>";
                            $conteudo = "";
                        } else {
                            if ( (($privado == TRUE) && (is_user_logged_in())) || ($privado == FALSE) ){
                                $links = "<div class='clearfix' style='margin-top: 12px;'>
                                    <span class='pull-right'>
                                    <a class='btn btn-primary' href='$permalink_visualizar' target='_blank'>Visualizar</a>
                                    <a class='btn btn-primary' href='$permalink_download'>Download</a></span>
                                </div>";
                                $conteudo = get_the_content();
                            }else{
                                $links = "<p>Você precisa ser um membro registrado para poder acessar esse arquivo.</p>";
                                $conteudo = "";
                            }
                        }
                    ?>
                    <li class="well">
                        <ul class="list-unstyled">
                            <li><h5 class="nomargin"><?php the_title(); ?></h5></li>
                            <li><?php echo $conteudo; ?></li>
                            <li><?php echo $links; ?></li>
                        </ul>
                    </li>

                    <?php endwhile; wp_reset_query(); ?>
                </ul>
            <?php
                if ( function_exists( 'paginacao' ) ) paginacao();
            }
            ?>
                    
            </section>

            <!-- BARRA LATERAL -->
            <aside class="col-sm-12 col-md-4">
                <?php
                $instance = array('title'=>'Categorias da Biblioteca');
                $args = array(
                    'before_widget'=>'<div class="panel panel-default">',
                    'after_widget'=>'</div></div>',
                    'before_title'=>'<h1 class="heading"><span class="title">',
                    'after_title'=>'</span><span class="bottom"></span></h1><div class="panel-body">'
                );
                the_widget( 'ClassWidgetArquivo', $instance, $args );
                ?>
                <?php dynamic_sidebar('sidebar-secundaria'); ?>
            </aside>

        </div>
    </div>
</div>


<?php get_footer(); ?>
