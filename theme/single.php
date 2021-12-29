<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
    <!-- CONTEÚDO PRÉVIO -->
    <div class="container-auxiliar">
        <div class="container">

            <?php
                $thumb = get_post_thumbnail_id();
                $img_url = wp_get_attachment_url( $thumb,'full' );
                $image = aq_resize( $img_url, 975, 200, true );
                if ($image){
            ?>

            <div class="row">
                <section class="col-xs-10 col-md-offset-1">

                    <a href="<?php the_permalink() ?>">
                        <img src="<?php echo $image ?>" class="img-responsive img-thumbnail" alt="<?php the_title(); ?>"/>
                    </a>
                </section>
            </div>

            <?php
                }
            ?>

        </div>
    </div>

    <!-- CONTEÚDO PRINCIPAL -->
    <div class="container-principal" role="main">
        <div class="container">

            <!-- NOTÍCIAS / BARRA LATERAL -->
            <div class="row">

                <!-- COLUNA DE NOTICIAS -->
                <section class="col-sm-12 col-md-8">
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <header>
                                <h1><?php the_title(); ?></h1>
                            </header>
                            <div class="well well-sm well-resumo clearfix">
                                <ul class="list-unstyled list-inline pull-left">
                                    <li>
                                        <i class="icon-calendar"></i> <?php echo get_the_time('d/m/Y') ?>
                                    </li>
                                    <li>
                                        <i class="icon-comment"></i> <a href="<?php comments_link(); ?>"><?php comments_number(); ?></a>
                                    </li>
                                </ul>
                                <ul class="list-unstyled list-inline pull-right">
                                    <li>
                                        <i class="icon-bookmark"></i> <?php the_category(', '); ?>
                                    </li>
                                    <li>
                                        <i class="icon-tags"></i> <?php the_tags(''); ?>
                                    </li>
                                </ul>
                            </div>
                            <div class="entry-content">
                                <?php the_content(); ?>
                            </div>
                        </article>
                        <?php
                            if ( comments_open() || '0' != get_comments_number() )
                                comments_template();
                        ?>

                </section>

                <!-- BARRA LATERAL -->
                <aside class="col-sm-12 col-md-4">
                    <?php dynamic_sidebar('sidebar-secundaria'); ?>
                </aside>

            </div>
        </div>
    </div>
<?php endwhile; ?>

<?php get_footer(); ?>
