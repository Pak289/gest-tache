<?php
include_once('../../../config/basic.php');
session_start();

if(isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    include_once('../../generic/head.php'); //Add HEAD part to the code ?>

    <body class="layout" style="background: #EAEAEA;">

    <?php include_once('../../generic/header.php'); //Add HEADER part to the code ?>

    <!--    @Start     #Content -->

    <div class="card shadow-1 rounded-3 hoverable-1 vself-center self-center vcenter" style="width: 25rem; background: white;">
        <div class="card-header">Mes informations :</div>
        <div class="divider"></div>
        <div class="card-content">
            <div class="form-field" style="width: 20rem;">
                <label>Identifiant :</label>
                <b class="footer"><?php echo $user->getId() ?></b>
                <label>Nom :</label>
                <b class="footer"><?php echo $user->getName() ?></b>
                <label>Prénom :</label>
                <b class="footer"><?php echo $user->getFirstName() ?></b>
                <label>Adresse email :</label>
                <p class="footer"><?php echo $user->getEmail() ?></p>
                <label>Groupe utilisateur :</label>
                <p class="footer"><?php echo $user->getGroup()->getWording(); ?></p>
            </div>
        </div>
        <footer class="footer fx-center background">
            0.1.0 - Crous Strasbourg © 2020
        </footer>
    </div>

    <!--     @End      #Content -->

    </body>

<?php } else { $_SESSION['error'] = 'Veuillez vous authentifier !'; header('Location: ../../index.php'); exit(); } ?>
