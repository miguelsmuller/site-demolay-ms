<?php get_header(); ?>

<!-- CONTEÚDO PRÉVIO -->
<div class="container-manutencao">
    <div class="container">
        <div class="row logo-gcems">

            <img id="logo-manutencao" src="<?php echo get_bloginfo( 'template_directory' ) ?>/assets/images/logo-gcems.png" alt="Grande Capítulo do Mato Grosso do Sul">

        </div>

        <div id="box-manutencao" class="jumbotron">
            <div class="container">
                <h1 class="heading heading-center">
                    <span class="left"></span>
                    <span class="title">SITE EM MANUTENÇÃO</span>
                    <span class="right"></span>
                </h1>
                <?php
                global $ClassMaintenance;
                $retorno = $ClassMaintenance->getRetorno();
                $retorno = $retorno['date'].' ás '.$retorno['time'];
                ?>
                <p class="text-center">Lamentamos o inconveninente. No momento estamos trabalhando em áreas do site que podem ocasionar instabilidade.</p>
                <p class="text-center">A previsão de retorno é para <strong><?php echo $retorno ?> hrs</strong></p>
            </div>
        </div>

    </div>
</div>

<?php get_footer(); ?>
