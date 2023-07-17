<?php
include_once('../../../config/basic.php');
session_start();

if (isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    include_once('../../generic/head.php'); //Add HEAD part to the code ?>

    <body class="layout with-sidenav" style="background: #EAEAEA;">

    <?php include_once('../../generic/header.php'); //Add HEADER part to the code ?>

    <?php include_once('../../generic/sidenav.php'); //Add HEADER part to the code ?>

    <!--    @Start     #Content -->

    <div style="display: flex; flex-flow: row wrap; justify-content: center; align-items: flex-start; align-content: center">

        <div class="card shadow-1 light-hoverable-1 rounded-3 item vcenter">
            <div class="card-header">Espace de gestion</div>
            <div class="card-content" style="display: flex; flex-flow: column nowrap; justify-content: center; align-content: center; align-items: center; text-align: justify">
                <p>
                    Bienvenue dans l'espace de gestion, vous pouvez télécharger la documentation d'utilisation en cliquant sur le bouton ci-dessous.
                </p>
                <button class="btn shadow-1 rounded-1 background txt-white" style="margin-top: 1rem;"><a href="<?php echo stm_Router::$URL . stm_Router::$PUBLIC . 'files/documentation.pdf' ?>" target="_blank">Télécharger la documentation</a></button>
            </div>
        </div>
    </div>

    <!--     @End      #Content -->

    <?php include_once('../../generic/footer.php'); //Add FOOTER part to the code ?>

    </body>

<?php } else {
    $_SESSION['error'] = 'Veuillez vous authentifier !';
    header('Location: ../../index.php');
    exit();
} ?>
