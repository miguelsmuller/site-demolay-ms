<?php get_header(); ?>

<?php
if (is_date()){
    $titulo = 'Notícias Publicadas no período de '. get_the_time('F \d\e\ Y');
}elseif (is_category()){
    $categoria = single_cat_title("", false);
    $titulo = 'Notícias publicadas na categoria '. $categoria;
}elseif (is_tag()){
    $categoria = single_cat_title("", false);
    $titulo = 'Notícias publicadas com a tag '. $categoria;
}else{
    $titulo = 'Notícias Publicadas';
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
                <div class="row">

                    <?php
                        $args = array( 'paged'=> $paged );
                        $args['name'] = '';
                        $args['pagename'] = '';

                        global $wp_query;
                        $args = array_merge( $wp_query->query_vars, $args );
                        query_posts( $args );
                    ?>

                    <?php if ( have_posts() ) : ?>
                        <div id="article-list">
                            <?php get_template_part( 'loop-archive', get_post_format() ); ?>
                        </div>
                    <?php else : ?>
                    <?php endif; ?>

                    <button id="load-more" type="button" class="btn btn-primary btn-block btn-theme btn-lg" data-loading-text="Carregando  ..." data-template="loop-archive" data-post-type="post" data-posts-per-page="<?php echo get_option( 'posts_per_page' ) ?>" data-max-page="<?php echo $wp_query->max_num_pages; ?>" autocomplete="off">Carregar mais notícias</button>

                </div>
            </section>

            <!-- BARRA LATERAL -->
            <aside class="col-sm-12 col-md-4">
                <?php dynamic_sidebar('sidebar-secundaria'); ?>
            </aside>

        </div>
    </div>
</div>


<?php get_footer(); ?>
