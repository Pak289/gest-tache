<?php
include_once('../../../config/basic.php');
session_start();

if(isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    $task = unserialize($_SESSION['task']);

    include_once('../../generic/head.php'); //Add HEAD part to the code ?>

    <body class="layout" style="background: #EAEAEA;">

    <?php include_once('../../generic/header.php'); //Add HEADER part to the code ?>

    <!--    @Start     #Content -->

    <style>
        .item {
            margin: 0.5rem 0;
        }
    </style>

    <div class="self-center vcenter" style="margin-top: 4rem;">
        <div class="card shadow-1 rounded-3 vcenter" style="width: 25rem; background: white; margin-top: 0rem">
            <div class="card-header">Création d'une tâche (3/5)</div>
            <div class="divider"></div>
            <div class="card-content">
                <form action="nT4.php" method="post" style="width: 20rem;">
                    <div class="form-field">
                        <label for="p_recurrence">Sera-t-elle récurrente ?</label>
                        <div class="grix xs1 center item">
                            <label class="form-switch">
                                Non
                                <input name="p_recurrence" type="checkbox"/>
                                <span class="slider small"></span>
                                Oui
                            </label>
                        </div>
                    </div>
                    <div style="display: flex; flex-flow: row nowrap; align-items: center; justify-content: center; align-content: center; margin: 1rem 0;">
                        <form action="nT2.php" method="POST" style="margin-right: 1rem;">
                            <div class="form-field">
                                <button type="submit" formaction="nT2.php" class="btn small shadow-1 rounded-1 outline opening txt-airforce vself-center item" style="margin-top: 1.5rem;"><span class="outline-text">Retour</span></button>
                            </div>
                        </form>
                        <div class="form-field">
                            <button type="submit" class="btn small shadow-1 rounded-1 outline opening txt-airforce vself-center item" style="margin-top: 1.5rem;"><span class="outline-text">Suivant</span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--     @End      #Content -->

    <?php include_once('../../generic/footer.php'); //Add FOOTER part to the code ?>

    </body>

<?php } else { $_SESSION['error'] = 'Veuillez vous authentifier !'; header('Location: ../../index.php'); exit(); } ?>
