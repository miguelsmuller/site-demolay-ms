<?php get_header(); ?>

<?php
if (is_tax('tipo-entidade')){
    $categoria = single_cat_title("", false);
    $titulo = $categoria .' filiados ao GCE-MS';
}elseif (is_tax('regiao-administrativa')){
    $categoria = single_cat_title("", false);
    $titulo = 'Entidades da ' . $categoria .' filiadas ao GCE-MS';
}else{
    $titulo = 'Entidades Filiadas';
}
?>


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
                    <h1><?php echo $titulo; ?></h1>
                </header>

            <?php if ( have_posts() ) : ?>

                <?php while ( have_posts() ) : the_post(); ?>

                    <article id="post-<?php the_ID(); ?>" class="row vmargin">

                        <!-- THUMBNAIL -->
                        <div class="col-xs-4">
                            <?php
                            $thumbnail = get_field('thumbnail');

                            if( $thumbnail ) {
                                $new_url = wp_get_attachment_image_src($thumbnail['id'], 'thumbnail');
                                $thumbnail['url'] = $new_url[0];
                                echo '<img width="100%" class="img-responsive img-thumbnail" src="'. $thumbnail['url'] .'" />';
                            } else {
                                $image = get_bloginfo( 'template_directory' ) . '/assets/images/sem-emblema-entidade.png';
                                echo '<img src="'. $image .'" class="img-responsive img-thumbnail" alt="Imagem não disponível">';
                            }
                            ?>
                        </div>

                        <!-- CONTENT -->
                        <div class="col-xs-8">

                            <header>
                                <h4>
                                    <!-- <a href="<?php the_permalink() ?>"> -->
                                        <?php the_title(); ?> Nº <?php echo get_field('numero_entidade') ?>
                                    <!-- </a> -->
                                </h4>
                            </header>
                            <div class="entry-content">
                                <?php
                                echo '<p>Fundado em: '. get_field('data_fundacao') .'</p>';

                                $local['endereco'] = get_field('endereco');
                                $local['cidade']   = get_field('cidade');
                                echo '<p>' . implode(' - ', $local) . '<p>';

                                echo '<p>E-mail: '. get_field('email') .'</p>';
                                echo '<p>Site: '. get_field('site') .'</p>';
                                ?>
                                <!-- <p><a class="btn btn-primary" href="<?php the_permalink() ?>">Ver ficha completa</a></p> -->
                            </div>
                        </div>

                    </article>




                <?php endwhile; ?>

            <?php else : ?>
                <?php get_template_part( 'no-results', 'index' ); ?>
            <?php endif; ?>

            </section>

            <!-- BARRA LATERAL -->
            <aside class="col-sm-12 col-md-4">
                <?php dynamic_sidebar('sidebar-secundaria'); ?>
            </aside>

        </div>
    </div>
</div>


<?php get_footer(); ?>
