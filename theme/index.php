<?php get_header(); ?>

<!-- CONTEÚDO PRÉVIO -->
<div class="container-auxiliar">
    <div class="container">
        <div class="row">

            <!-- SLIDER DE IMAGENS -->
            <section class="col-xs-8">
                <?php
                global $ClassPostTypeSlide;
                $loop = new WP_Query(array(
                    'post_type'      => 'featured-picture',
                    'post_status'    => 'publish',
                    'posts_per_page' => -1,
                    'orderby'        => 'date',
                    'order'          => 'DESC'
                ));

                if ( $loop->have_posts() ){
                ?>
                    <div id="slider" class="owl-carousel owl-theme slider">
                        <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                            <div class="item">
                                <?php
                                if (get_field('tipo_destino') == 'interno'){
                                    $destino = get_field('destino_interno');
                                    $destino = get_permalink( $destino->ID );
                                }else{
                                    $destino = get_field('destino_externo');
                                }
                                if($destino == '') $destino = '#';

                                $nova_janela = get_field('nova_janela');
                                $nova_janela = isset($nova_janela[0]) ? 'sim' : 'nao';
                                $nova_janela = $nova_janela == 'sim' ? ' target="_blank"' : '';

                                $thumbnail  = get_field('thumbnail');
                                $img_url    = wp_get_attachment_url( $thumbnail['id'],'full' );
                                $image      = aq_resize( $img_url, 750, 290, true );
                                ?>
                                <a href="<?php echo $destino; ?>" <?php echo $nova_janela; ?>>
                                    <img src="<?php echo $image ?>" class="img-responsive" alt="<?php the_title(); ?>"/>
                                </a>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php } ?>
            </section>

            <!-- PESQUISAS -->
            <section class="col-xs-4">
                <ul class="box-pesquisas">
                    <li>
                        <div class="row">
                        <div class="col-xs-12">
                            <h1 class="heading">
                                <span class="title">Encontre um assunto</span>
                            </h1>
                            <form action="<?php echo get_bloginfo( 'url' ) ?>" method="get" accept-charset="utf-8">
                                <fieldset>
                                    <div class="form-group">
                                        <input type="text" name="s" id="search" class="form-control" value="" placeholder="Critério de pesquisa">
                                    </div>
                                    <input class="btn btn-theme btn-block" type="submit" value="Procurar">
                                </fieldset>
                            </form>
                        </div>
                        </div>
                    </li>

                    <li>
                        <div class="row">
                        <div class="col-xs-12">
                            <h1 class="heading">
                                <span class="title">Encontre um capítulo</span>
                            </h1>
                            <form action="<?php echo get_bloginfo( 'url' ) ?>" method="get" accept-charset="utf-8">
                                <fieldset>
                                    <div class="form-group">
                                        <input type="text" name="s" id="search" class="form-control" value="" placeholder="Critério de pesquisa">
                                    </div>
                                    <input class="btn btn-theme btn-block" type="submit" value="Procurar">
                                </fieldset>
                            </form>
                        </div>
                        </div>
                    </li>
                </ul>
            </section>

        </div>
    </div>
</div>

<!-- CONTEÚDO PRINCIPAL -->
<div class="container-principal" role="main">
    <div class="container">

        <!-- VEJA MAIS -->
        <section class="row">
            <?php
            $queryPageDestaque = new WP_Query(array(
                'post_type'      => 'page',
                'posts_per_page' => '-1',
                'order'          => 'ASC',
                'orderby'        => 'menu_order',
                'meta_query'     => array(
                    array(
                        'key'     => 'mostrar_index',
                        'value'   => '1',
                        'compare' => '='
                    )
                ),
            ));

            if ( $queryPageDestaque->have_posts()) {
            ?>
                <ul class="box-veja-mais">
                    <?php
                    while ( $queryPageDestaque->have_posts() ) : $queryPageDestaque->the_post();
                    ?>
                        <li class="col-xs-3">
                            <div class="item">
                                <a href="<?php the_permalink() ?>">
                                    <h2><?php the_title(); ?></h2>
                                    <?php echo wp_trim_words(get_the_excerpt(),20); ?>
                                </a>
                            </div>
                        </li>
                    <?php
                    endwhile;
                    ?>
                </ul>
            <?php
            }
            ?>
        </section>

        <!-- NOTÍCIAS / BARRA LATERAL -->
        <div class="row">

            <!-- COLUNA DE NOTICIAS -->
            <section id="content" class="col-sm-8">
                <?php if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : the_post(); ?>

                    <article class="resumo-artigo">
                        <div id="post-<?php the_ID(); ?>" class="row">
                            <div class="col-xs-12">

                                <?php
                                    $thumb = get_post_thumbnail_id();
                                    $img_url = wp_get_attachment_url( $thumb,'full' );
                                    $image = aq_resize( $img_url, 1170, 240, true );
                                    if ($image == ""){
                                        $image = get_bloginfo( 'template_directory' ) . "/assets/images/no-image.png";
                                    }
                                ?>
                                <a href="<?php the_permalink() ?>">
                                    <img src="<?php echo $image ?>" class="img-responsive img-resumo-artigo" alt="<?php the_title(); ?>"/>
                                </a>


                                <header class="header-resumo-artigo">
                                    <h4>
                                        <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
                                    </h4>
                                </header>

                                <div class="entry-resumo-artigo">
                                    <?php echo wp_trim_excerpt(strip_shortcodes(get_the_excerpt())); ?>
                                </div>

                                <div class="footer-resumo-artigo clearfix">
                                    <ul>
                                        <li><i class="fa fa-calendar"></i> <?php echo get_the_time('d/m/Y') ?></li>
                                        <li><i class="fa fa-comment"></i> <a href="<?php comments_link(); ?>"><?php comments_number(); ?></a></li>
                                        <li><i class="fa fa-bookmark"></i> <?php the_category(', '); ?></li>
                                    </ul>
                                    <a href="<?php the_permalink() ?>">
                                        <span class="ler-mais">LER MAIS <i class="fa fa-chevron-right"></i><span>
                                    </a>
                                </div>

                            <div>
                        </div>
                    </article>

                    <?php endwhile; ?>
                <?php else : ?>
                    <?php get_template_part( 'no-results', 'index' ); ?>
                <?php endif; ?>
            </section>

            <!-- BARRA LATERAL -->
            <aside  class="col-sm-4">
                <?php dynamic_sidebar('sidebar-principal'); ?>
            </aside>

        </div>
    </div>
</div>

<?php get_footer(); ?>
