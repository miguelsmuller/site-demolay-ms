<?php while ( have_posts() ) : the_post(); ?>
    <!-- POST ITEM -->

        <div class="col-xs-4">
            <article class="list-artigo">
                <?php
                    $thumb = get_post_thumbnail_id();
                    $img_url = wp_get_attachment_url( $thumb,'full' );
                    $image = aq_resize( $img_url, 250, 180, true );
                    if ($image == ""){
                        $image = get_bloginfo( 'template_directory' ) . "/assets/images/no-image-min.png";
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
            </article>

        </div>

<?php endwhile; ?>