<?php get_header(); ?>

<?php
global $query_string;

$query_args = explode("&", $query_string);
$search_query = array();

foreach($query_args as $key => $string) {
    $query_split = explode("=", $string);
    $search_query[$query_split[0]] = urldecode($query_split[1]);
}

$search_query = array_merge( $search_query, array('posts_per_page' => -1) );
$search = new WP_Query($search_query);

global $wp_query;
$total_results = $wp_query->found_posts;

$titulo = 'Resultado da busca para "'. get_search_query() .'"';
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

                <?php if ( $search->have_posts() ) : ?>
                    <?php while ( $search->have_posts() ) : $search->the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" class="row">
                            <div class="col-xs-12">
                                <header>
                                    <h4>
                                        <?php
                                        printf('<a href="%s">[%s] %s</a>',
                                            get_permalink(),
                                            ucfirst (get_post_type()),
                                            get_the_title()
                                        );
                                        ?>
                                        <div class="well well-sm well-search well-resumo clearfix">
                                            <ul class="list-unstyled list-inline pull-left">
                                                <li>
                                                    <i class="icon-calendar"></i> <?php echo get_the_time('d/m/Y') ?>
                                                </li>
                                                <li>
                                                    <?php
                                                        if ( comments_open() ) {
                                                            echo '<i class="icon-comment"></i> <a href="'. get_comments_link() .'">';
                                                            echo comments_number( 'Sem Comentários', '1 Comentários', '% Comentários' );
                                                            echo '</a>';
                                                        }
                                                    ?>
                                                </li>
                                            </ul>
                                            <?php if ( 'post' == get_post_type() ) { ?>
                                            <ul class="list-unstyled list-inline pull-right">
                                                <li>
                                                    <i class="icon-bookmark"></i> <?php the_category(', '); ?>
                                                </li>
                                                <li>
                                                    <i class="icon-tags"></i> <?php the_tags(''); ?>
                                                </li>
                                            </ul>
                                            <?php } ?>
                                        </div>
                                    </h4>
                                </header>

                                <div class="entry-content">
                                    <?php the_excerpt(); ?>
                                </div>

                                <hr>

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
