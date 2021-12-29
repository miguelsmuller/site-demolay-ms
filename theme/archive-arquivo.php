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
                    <h1>Biblioteca de Arquivos</h1>
                </header>

                <div class="row">
                <div class="col-sm-6">
                    <h1 class="heading">
                        <span class="title">Últimos Arquivos</span>
                        <span class="bottom"></span>
                    </h1>
                    <?php
                        $query_ultimos_arquivos = new WP_Query(array(
                            'post_type'      => 'arquivo',
                            'orderby'        => 'date',
                            'order'          => 'DESC',
                            'posts_per_page' => 8
                        ));
                        echo '<ul class="well list-unstyled">';
                        while ( $query_ultimos_arquivos->have_posts() ) : $query_ultimos_arquivos->the_post();
                            echo '<li class="">';
                            echo '<table style="width: 100%;">
                            <tr>
                            <td>'.get_the_title().'</td>
                            <td style="width: 55px;">
                                <span style="margin-left: 10px;">
                                <a href="' . get_permalink() . 'action/view" target="_blank"><i class="fa fa-search"></i></a> |
                                <a href="' . get_permalink() . 'action/down" target="_blank"><i class="fa fa-download"></i></a>
                                </span>
                            </td>
                            </tr>
                            </table>';
                            echo '</li>';
                        endwhile;
                        echo '</ul>';
                    ?>
                </div>
                <div class="col-sm-6">
                    <h1 class="heading">
                        <span class="title">Arquivos Populares</span>
                        <span class="bottom"></span>
                    </h1>
                    <?php
                        $query_arquivos_populares = new WP_Query(array(
                            'post_type'      => 'arquivo',
                            'orderby'        => 'meta_value_num',
                            'meta_key'       => 'file_qtdown',
                            'order'          => 'DESC',
                            'posts_per_page' => 8
                        ));
                        echo '<ul class="well list-unstyled">';
                        while ( $query_arquivos_populares->have_posts() ) : $query_arquivos_populares->the_post();
                        echo '<li class="">';
                            echo '<table style="width: 100%;">
                            <tr>
                            <td>'.get_the_title().'</td>
                            <td style="width: 55px;">
                                <span style="margin-left: 10px;">
                                <a href="' . get_permalink() . 'action/view" target="_blank"><i class="fa fa-search"></i></a> |
                                <a href="' . get_permalink() . 'action/down" target="_blank"><i class="fa fa-download"></i></a>
                                </span>
                            </td>
                            </tr>
                            </table>';
                            echo '</li>';


                        endwhile;
                        echo '</ul>';
                    ?>
                </div>
            </div>
            <div class="row vmargin">
                <div class="col-sm-12">
                    <h1 class="heading">
                        <span class="title">Categorias da Biblioteca</span>
                        <span class="bottom"></span>
                    </h1>
                    <?php
                        $args = array(
                            'taxonomy'          => 'arquivo-categoria',
                            'hide_empty'        => false,
                            'title_li'          => ''
                        );
                        echo '<ul class="well list-unstyled">';
                            wp_list_categories( $args );
                        echo '</ul>';
                    ?>
                </div>
            </div>
            <div class="row vmargin">
                <div class="col-sm-12">
                    <h1 class="heading">
                        <span class="title">Referências mais usadas</span>
                        <span class="bottom"></span>
                    </h1>
                    <?php
                        echo '<div class="tab-pane fade active in widget-tagcloud" id="tags">';
                        $args = array(
                            'orderby'   => 'count',
                            'order'     => 'DESC',
                            'taxonomy'  => 'arquivo-referencia'
                        );
                        wp_tag_cloud($args);
                        echo '</div>';
                    ?>
                </div>
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
