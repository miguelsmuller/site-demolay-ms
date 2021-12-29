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
                            <div class="entry-content">


<?php if( have_rows('membros') ): ?>
    <?php while( have_rows('membros') ): the_row();

        // vars
        $cid           = get_sub_field('cid');
        $image_perfil  = get_sub_field('imagem');
        $nome          = get_sub_field('nome');
        $cargo        = get_sub_field('cargo');
        $capitulo      = get_sub_field('capitulo');
        $convento      = get_sub_field('convento');
        $loja_maconica = get_sub_field('loja_maconica');
        $mail          = get_sub_field('mail');
        $telefone      = get_sub_field('telefone');

        ?>

        <div class="row perfil-pessoa">
            <div class="col-xs-4">
                <?php
                $img_url    = wp_get_attachment_url( $image_perfil['id'],'full' );
                $image      = aq_resize( $img_url, 500, 500, true );
                if (!$image) {
                    $image = get_bloginfo('template_directory') . '/assets/images/avatar-nao-disponivel.png';
                }
                ?>
                <img class="img-responsive img-thumbnail" src="<?php echo $image; ?>" title="<?php echo $image_perfil['alt'] ?>" alt="<?php echo $image_perfil['alt'] ?>"/>
            </div>
            <div class="col-xs-8">
                <h2 style="margin: 0px 0px 6px; font-weight: bold; "><?php echo $cargo; ?></h2>
                <p><span style="line-height: 100%; margin: 0px; padding: 0 0 4px 0; font-size: 18px;"><?php echo $nome; ?></span> (<a target=_blank href=http://sisdm.demolay.org.br/demolay/publico/ConsultaCid.action?cid=<?php echo $cid; ?>><?php echo $cid; ?></a>)</p>
                <p><i class="icon-home"></i> <span>Capítulo: </span><?php echo $capitulo; ?></p>

                <?php if ($convento != ''){ ?>
                <p><i class="icon-home"></i> <span>Convento: </span><?php echo $convento; ?></p>
                <?php } ?>

                <?php if ($loja_maconica != ''){ ?>
                <p><i class="icon-home"></i> <span>Loja: </span><?php echo $loja_maconica; ?></p>
                <?php } ?>

                <p><i class="icon-envelope-alt"></i> <span>Email: <a href="mailto:<?php echo $mail; ?> target="_blank"></span><?php echo $mail; ?></a></p>
                <p><i class="icon-phone"></i> <span>Telefone: </span><?php echo $telefone; ?></p>

            </div>
        </div>

    <?php endwhile; ?>
<?php endif; ?>




                            </div>
                        </article>

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
