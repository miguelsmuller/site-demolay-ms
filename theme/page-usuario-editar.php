<?php
if ( !is_user_logged_in() ) {
    $pageNew = get_option( 'configUsuarios' );
    $pageNew = $pageNew['pageEditUser'];
    wp_redirect( get_page_link($pageNew), 302 );
}else{
    $retorno    = '';
    if (!empty($_POST)) {
            $nome   = $_POST['nome'];

            $userId = get_current_user_id();
            wp_update_user(
                array(
                    'ID'       => $userId,
                    'first_name' => $nome
                )
            );
    }
    ?>
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

                <?php echo $retorno; ?>

                <!-- COLUNA DE NOTICIAS -->
                <section class="col-xs-12 col-md-8 col-lg-offset-2">

                    <form action="" method="post" class="customForm validate">
                        <h1><?php the_title(); ?></h1>


                    </form>

                </section>

            </div>
        </div>
    </div>

<?php endwhile; ?>

<?php get_footer(); ?>
<?php
}
