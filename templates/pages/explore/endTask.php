<?php
include_once('../../../config/basic.php');
session_start();

if (isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    $task = unserialize($_SESSION['task']);

    if ($_POST['p_sDate'] != null)
        $task->set_sDate($_POST['p_sDate']);

    $_SESSION['task'] = serialize($task);

    include_once('../../generic/head.php'); //Add HEAD part to the code ?>

    <body class="layout" style="background: #EAEAEA;">

    <?php include_once('../../generic/header.php'); //Add HEADER part to the code ?>

    <!--    @Start     #Content -->

    <?php

    $database = connection();

    $stmt = $database->prepare('SELECT * FROM PROJECTS WHERE id = :id');
    $stmt->execute(array(
        ':id' => $task->get_project_id()
    ));

    $stmt = $stmt->fetchAll(PDO::FETCH_BOTH);
    ?>

    <div style="display: flex; flex-flow: column wrap; justify-content: center; align-items: center; align-content: center;">
        <div class="card shadow-1 fx-row" style="background: white; width: 80%">
            <div class="d-flex vcenter fx-center background" style="color: ghostwhite; width: 14rem;">
                <h4><?php echo $stmt[0]['title']; ?></h4>
            </div>
            <div class="flex fx-col fx-grow">
                <div class="card-content">
                    <p>
                        <?php echo $stmt[0]['wording']; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="card shadow-1"
             style="background: white; width: 80%; display: flex; flex-flow: row nowrap; justify-content: space-between; align-items: flex-start; align-content: center;">
            <div style="display: flex; flex-flow: column nowrap; width: 33%">
                <div style="display: flex; flex-flow: row nowrap; align-items: baseline; align-content: flex-start; margin-top: 0.5rem;">
                    <h4 style="margin: 0 5%">Titre tâche :</h4>
                    <p><?php echo $task->get_title() ?></p>
                </div>
                <div style="display: flex; flex-flow: row nowrap; align-items: center; align-content: flex-start;">
                    <h4 style="margin: 0 5%">Description :</h4>
                </div>
                <div style="display: flex; flex-flow: row nowrap; align-items: center; align-content: flex-start;">
                    <p style="margin: 0.5rem 5%" align="justify"><?php echo $task->get_wording() ?></p>
                </div>
                <?php if ($_POST['p_sDate'] != null) { ?>
                    <div style="display: flex; flex-flow: column nowrap; align-items: baseline; align-content: flex-start; margin-top: 0.5rem;">
                        <h4 style="margin: 0 5%"><?php echo ($task->get_type() != null) ? 'Début de récurrence' : 'Date d\'échéance'; ?>
                            :</h4>
                        <p style="margin-left: 5%"><?php echo $task->get_sDate() ?></p>
                    </div>
                    <?php if ($task->get_type() != null) { ?>
                        <div style="display: flex; flex-flow: column nowrap; align-items: baseline; align-content: flex-start; margin-top: 0.5rem;">
                            <h4 style="margin: 0 5%">Fin de récurrence :</h4>
                            <p style="margin-left: 5%"><?php echo $task->get_eDate() ?></p>
                        </div>
                        <div style="display: flex; flex-flow: column nowrap; align-items: baseline; align-content: flex-start; margin-top: 0.5rem;">
                            <h4 style="margin: 0 5%">Jour(s) récurrent(s) :</h4>
                            <?php foreach ($task->get_days() as $day) { ?>
                                <p style="margin: 0.5rem 5%"><?php echo $day[1] . ' ' . $day[2] ?></p>
                            <?php } ?>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
            <div style="display: flex; flex-flow: column nowrap; width: 34%">
                <div style="display: flex; flex-flow: row nowrap; align-items: baseline; align-content: flex-start; margin-top: 0.5rem;">
                    <h4 style="margin: 0 5%">UG :</h4>
                    <p><?php
                        $tempo = $database->prepare("SELECT name FROM UG WHERE id = :id");
                        $tempo->execute(array(
                            ':id' => $task->get_ug_id()
                        ));
                        $tempo = $tempo->fetchAll(PDO::FETCH_BOTH);

                        echo $tempo[0][0];
                        ?></p>
                </div>
                <div style="display: flex; flex-flow: row nowrap; align-items: baseline; align-content: flex-start; margin-top: 0.5rem;">
                    <h4 style="margin: 0 5%">Site :</h4>
                    <p><?php
                        if ($task->get_site_id() != null) {
                            $tempo = $database->prepare("SELECT name FROM SITES WHERE id = :id");
                            $tempo->execute(array(
                                ':id' => $task->get_site_id()
                            ));
                            $tempo = $tempo->fetchAll(PDO::FETCH_BOTH);

                            echo $tempo[0][0];
                        } else
                            echo 'Non Attribué';
                        ?></p>
                </div>
                <div style="display: flex; flex-flow: row nowrap; align-items: baseline; align-content: flex-start; margin-top: 0.5rem;">
                    <h4 style="margin: 0 5%">Localisation :</h4>
                    <p><?php echo ($task->get_localisation() != null) ? $task->get_localisation() : 'Non Attribué'; ?></p>
                </div>
                <div style="display: flex; flex-flow: row nowrap; align-items: baseline; align-content: flex-start; margin-top: 0.5rem;">
                    <h4 style="margin: 0 5%">Entreprise :</h4>
                    <p><?php
                        if ($task->get_company_id() != null) {
                            $tempo = $database->prepare("SELECT name FROM COMPANY WHERE id = :id");
                            $tempo->execute(array(
                                ':id' => $task->get_company_id()
                            ));
                            $tempo = $tempo->fetchAll(PDO::FETCH_BOTH);

                            echo $tempo[0][0];
                        } else
                            echo 'Non Attribué';
                        ?></p>
                </div>
                <div style="display: flex; flex-flow: row nowrap; align-items: baseline; align-content: flex-start; margin-top: 0.5rem;">
                    <h4 style="margin: 0 5%">Priorité :</h4>
                    <p><?php
                        if ($task->get_priority_id() != null) {
                            $tempo = $database->prepare("SELECT wording FROM PRIORITY WHERE id = :id");
                            $tempo->execute(array(
                                ':id' => $task->get_priority_id()
                            ));
                            $tempo = $tempo->fetchAll(PDO::FETCH_BOTH);

                            echo $tempo[0][0];
                        } else
                            echo 'Non Attribué';
                        ?></p>
                </div>
            </div>
            <div style="display: flex; flex-flow: column nowrap; width: 33%">
                <div style="display: flex; flex-flow: row nowrap; align-items: baseline; align-content: flex-start; margin-top: 1rem;">
                    <h4 style="margin: 0 5%">Personne(s) Assignée(s) :</h4>
                </div>
                <div style="display: flex; flex-flow: column nowrap; align-items: baseline; align-content: flex-start; margin-top: 0.5rem;">
                    <?php foreach ($task->get_user_assign() as $user) { ?>
                        <p style="margin: 0.5rem 5%"><?php echo $user[1] . ' ' . $user[2] ?></p>
                    <?php } ?>
                </div>
                <div style="display: flex; flex-flow: column nowrap; align-items: baseline; align-content: flex-start; margin-top: 0.5rem;">
                    <h4 style="margin: 0 5%">Observateur(s) Assignée(s) :</h4>
                </div>
                <div style="display: flex; flex-flow: column nowrap; align-items: baseline; align-content: flex-start; margin-top: 0.5rem;">
                    <?php foreach ($task->get_observ_assign() as $user) { ?>
                        <p style="margin: 0.5rem 5%"><?php echo $user[1] . ' ' . $user[2] ?></p>
                    <?php } ?>
                </div>
                <div style="display: flex; flex-flow: row nowrap; align-items: baseline; align-content: flex-start; margin-top: 0.5rem;">
                    <h4 style="margin: 0 5%">État :</h4>
                    <p><?php
                        if ($task->get_state_id() != null) {
                            $tempo = $database->prepare("SELECT wording FROM STATES WHERE id = :id");
                            $tempo->execute(array(
                                ':id' => $task->get_state_id()
                            ));
                            $tempo = $tempo->fetchAll(PDO::FETCH_BOTH);

                            echo $tempo[0][0];
                        } else
                            echo 'Non Attribué';
                        ?></p>
                </div>
            </div>
        </div>
        <div style="display: flex; flex-flow: row nowrap; align-items: center; justify-content: center; align-content: center; margin: 1rem 0;">
            <form action="<?php echo ($task->get_type() === true) ? 'nT5.php' : 'nT4.php'; ?>" method="POST"
                  style="margin-right: 1rem;">
                <div class="form-field">
                    <button type="submit"
                            class="btn small shadow-1 rounded-1 outline opening txt-airforce vself-center item"
                            style="margin-top: 1.5rem; background: whitesmoke"
                            formaction="<?php echo ($task->get_type() != null) ? 'nT5.php' : 'nT4.php'; ?>"><span
                                class="outline-text">Retour</span></button>
                </div>
            </form>
            <form action="../../script/newTask.php" method="POST">
                <div class="form-field">
                    <button type="submit"
                            class="btn small shadow-1 rounded-1 outline opening txt-airforce vself-center item"
                            style="margin-top: 1.5rem; background: white"><span class="outline-text">Validation</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!--     @End      #Content -->

    <?php include_once('../../generic/footer.php'); //Add FOOTER part to the code ?>

    </body>

<?php } else {
    $_SESSION['error'] = 'Veuillez vous authentifier !';
    header('Location: ../index.php');
    exit();
} ?>
