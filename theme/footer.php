<?php $configTema = get_option( 'config_theme' ); ?>

<!-- RODAPÉ -->
<footer class="footer-main">

    <!-- 1º SEÇÃO DO RODAPÉ -->
    <section class="primary">
        <div class="container">
            <div class="row">

                <!-- INFORMAÇÕES DE CONTATO -->
                <div class="col-xs-4">
                    <div class="rodape-contato">
                        <img src="<?php echo get_bloginfo( 'template_directory' ) ?>/assets/images/nome-white-gcems.png" alt="Grande Capítulo do Mato Grosso do Sul">
                        <p><?php echo $configTema['address']; ?></p>
                    </div>
                </div>

                <!-- MENU DO RODAPÉ -->
                <div class="col-xs-5">
                    <?php
                    $menuOptions = array(
                        'theme_location'    => 'menu-rodape',
                        'container'         => false,
                        'menu_class'      => 'rodape-menu',
                    );
                    wp_nav_menu($menuOptions);
                    ?>
                </div>

                <!-- LIDERANÇAS ESTADUAIS -->
                <div class="col-xs-3">
                    <?php
                    echo '<ul class="rodape-lideranca">';
                        echo '<li>';
                            echo 'Grande Mestre Estadual';
                            echo '<br/>'. $configTema['gme'];
                        echo '</li>';

                        echo '<li>';
                            echo 'Mestre Conselheiro Estadual';
                            echo '<br/>'. $configTema['mce'];
                        echo '</li>';

                        echo '<li>';
                            echo 'Mestre Conselheiro Estadual Adjunto';
                            echo '<br/>'. $configTema['mcea'];
                        echo '</li>';
                    echo '</ul>';
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- 2º SEÇÃO DO RODAPÉ -->
    <section class="secondary">
        <div class="container">
            <div class="row">
                <div class="col-xs-8">
                    <p><?php echo copyright(); ?> Todos os direitos reservados ao Grande Capítulo do Estado do Mato Grosso do Sul. Este material não pode ser publicado, transmitido por broadcast, reescrito ou redistribuição sem prévia autorização.</p>
                </div>
                <div class="col-xs-4">
                    <a href="http://www.devim.com.br" target="_blank">
                    <img src="<?php echo get_bloginfo( 'template_directory' ) ?>/assets/images/logo-devim.png" alt="Devim - Desenvolvimento e Gestão Web" class="logo-devim">
                    </a>
                </div>
            </div>
        </div>
    </section>
</footer>

<?php wp_footer(); ?>
</body>
</html>