<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php wp_title( '|', true, 'right' ); ?></title>

    <link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/assets/icons/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php bloginfo('template_directory'); ?>/assets/icons/favicon-144.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php bloginfo('template_directory'); ?>/assets/icons/favicon-114.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php bloginfo('template_directory'); ?>/assets/icons/favicon-72.png">
    <link rel="apple-touch-icon-precomposed" href="<?php bloginfo('template_directory'); ?>/assets/icons/favicon-57.png">

    <?php wp_head();?>

    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-49237500-1', 'demolayms.com.br');
      ga('send', 'pageview');

    </script>
</head>
<body <?php body_class(); ?>>
    <?php do_action('after_body'); ?>

    <!-- CABEÇALHO -->
    <header class="container-header">
        <div class="container">

            <div class="row">
                <div class="col-xs-2">
                    <!-- LOGO -->
                    <a href="<?php bloginfo( 'url' ); ?>">
                        <img src="<?php echo get_bloginfo( 'template_directory' ) ?>/assets/images/logo-gcems.png" alt="Grande Capítulo do Mato Grosso do Sul" class="logo-gcems">
                    </a>
                </div>

                <nav class="col-xs-10">
                    <a href="<?php bloginfo( 'url' ); ?>">
                        <img src="<?php echo get_bloginfo( 'template_directory' ) ?>/assets/images/nome-gcems.png" alt="Grande Capítulo do Mato Grosso do Sul" class="nome-gcems">
                    </a>

                    <?php
                    if ( !is_user_logged_in() ) {
                        wp_nav_menu(array(
                            'theme_location' => 'menu-superior',
                            'container'      => false,
                            'menu_id'        => 'menu-superior',
                            'menu_class'     => 'nav-superior'
                        ));
                    } else {
                        wp_nav_menu(array(
                        'theme_location' => 'menu-superior-logado',
                        'container'      => false,
                        'menu_id'        => 'menu-superior-logado',
                        'menu_class'     => 'nav-superior'
                    ));
                    }
                    wp_nav_menu(array(
                        'theme_location' => 'menu-principal',
                        'container'      => false,
                        'menu_id'        => 'menu-principal',
                        'menu_class'     => 'nav navbar-nav nav-principal',
                        'fallback_cb'    => 'fallbackNoMenu',
                        'walker'         => new MenuBootstrap()
                    ));
                    ?>
                </nav>
            </div>

        </div>
    </header>
