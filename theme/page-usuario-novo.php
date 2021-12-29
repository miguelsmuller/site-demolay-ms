<?php
if ( is_user_logged_in() ) {
    $pageEdit = get_option( 'configUsuarios' );
    $pageEdit = $pageEdit['pageEditUser'];
    wp_redirect( get_page_link($pageEdit), 302 );
}else{
    include get_template_directory().'/inc-system/assets/recaptcha/recaptchalib.php';

    $retorno    = '';
    if (!empty($_POST)) {
        $privatekey = get_field('key_recaptcha_secret', 'option');


        $resp = recaptcha_check_answer ($privatekey,
            $_SERVER["REMOTE_ADDR"],
            $_POST["recaptcha_challenge_field"],
            $_POST["recaptcha_response_field"]);

        if (!$resp->is_valid) {

            $retorno = '<div class="alert alert-danger">
                            <strong>CAPCHA ERROR</strong> Os caracteres de validação não conferem.
                        </div>';

        } else {
            $txtCid         = $_POST['txtCid'];
            $txtNome        = $_POST['txtNome'];
            $txtDNascimento = $_POST['txtDNascimento'];
            $txtEMail       = $_POST['txtEMail'];

            $userId = username_exists( $txtCid );
            if ( !$userId and email_exists($txtEMail) == false ) {

                $random_password    = wp_generate_password( $length=6, $include_standard_special_chars=false );
                $userId             = wp_create_user( $txtCid, $random_password, $txtEMail );

                if (!is_object($userId)) {
                    //update_user_meta($userId, 'dNascimento', $txtDNascimento);
                    wp_update_user(
                        array(
                            'ID'       => $userId,
                            'first_name' => $txtNome,
                            'nickname' => 'Usuario'
                        )
                    );


                    $retorno = '<div class="alert alert-success">
                                <strong>SUCESSO</strong> Sua senha foi enviada para o seu email.
                            </div>';

                    /* E-MAIL NOTIFICAÇÃO GCERJ
                    ================================================== */
                    $headers[] = 'From: DeMolay MS <nao-responda@demolayms.com.br>';
                    $headers[] = 'Content-Type: text/html';

                    $mensagem     = "Seu cadastro de usuário para acesso a informações restritas foi feito com sucesso<br />";
                    $mensagem     .= "Para que você possa acessar use as seguintes credenciais de acesso:<br />";
                    $mensagem     .= "<b><i>CID: </i></b>". $txtCid . "<br />";
                    $mensagem     .= "<b><i>Senha: </i></b>". $random_password . "<br />";

                    $statusEnvio = wp_mail($txtEMail, 'Novo Usuário - Credenciais de acesso ', $mensagem, $headers );
                } else {
                    $retorno = '<div class="alert alert-danger">
                                <strong>ERRO</strong> Ocorreu um erro na criação do seu usuário.
                            </div>';
                }

            }else{

                $retorno = '<div class="alert alert-danger">
                                <strong>EMAIL EXISTENTE</strong> É necessário escolher um email que não esteja em uso.
                            </div>';
            }
        }
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
                <section class="col-xs-12 col-md-4 col-lg-offset-1">

                    <form action="<?php echo wp_login_url(); ?>" method="post" class="customForm validate">
                        <h1>Área restrita</h1>

                        <input type="hidden" name="redirect_to" value="<?php bloginfo( 'url' ); ?>" />

                        <div class="form-group">
                            <label for="log">CID:</label>
                            <input type="text" class="form-control" id="log" name="log">
                        </div>

                        <div class="form-group">
                            <label for="pwd">Senha:</label>
                            <input type="password" class="form-control" id="pwd" name="pwd">
                        </div>

                        <div class="form-group">
                            <p>
                               <a href="<?php echo get_option('home'); ?>/wp-login.php?action=lostpassword">Recuperar senha</a>
                            </p>
                            <input type="submit" name="cmdEnviar" value="Fazer Login" class="btn btn-primary pull-right" />
                        </div>
                    </form>

                </section>

                <section class="col-xs-12 col-md-4 col-lg-offset-1">

                    <form action="" method="post" class="customForm validate">
                        <h1>Novo por aqui?</h1>

                            <div class="form-group">
                                <label for="txtCid">CID:</label>
                                <input type="text" class="form-control" id="txtCid" name="txtCid">
                                <p class="help-block">Seu login será feito com o número da CID.</p>
                            </div>

                            <div class="form-group">
                                <label for="txtNome">Nome Completo:</label>
                                <input type="text" class="form-control" id="txtNome" name="txtNome">
                            </div>

                            <div class="form-group">
                                <label for="txtDNascimento">Data de Nascimento:</label>
                                <input type="text" class="form-control" id="txtDNascimento" name="txtDNascimento">
                            </div>

                            <div class="form-group">
                                <label for="txtEMail">E-mail:</label>
                                <input type="text" class="form-control" id="txtEMail" name="txtEMail">
                                <p class="help-block">Sua senha será enviada para esse email.</p>
                            </div>

                            <div class="form-group">
                                <?php
                                    $publickey = get_field('key_recaptcha_public', 'option');
                                    echo recaptcha_get_html($publickey);
                                ?>
                            </div>

                            <div class="form-group text-right">
                                <input type="submit" name="cmdEnviar" value="Realizar Cadastro" class="btn btn-primary" />
                            </div>

                    </form>

                </section>

            </div>
        </div>
    </div>

<?php endwhile; ?>

<?php get_footer(); ?>
<?php
}
