<?php
include_once('../../config/basic.php');
session_start();

if (isset($_SESSION['user'])) {

    $database = connection();

    $user = unserialize($_SESSION['user']);
    $task = unserialize($_SESSION[$_SESSION['p_task_id'] . 'task']);

    include_once('../generic/head.php'); //Add HEAD part to the code ?>

    <body class="layout" style="background: #EAEAEA;">

    <?php include_once('../generic/header.php'); //Add HEADER part to the code ?>

    <!--    @Start     #Content -->

    <div style="display: flex; flex-flow: row wrap; justify-content: center; align-items: center; align-content: center;">

        <!-- Projet -->

        <div class="card shadow-1 fx-colum" style="background: white; width: 80%;">
            <div style="background: white; display: flex; align-items: center; align-content: center; height: 2rem">
                <form action="explore.php" method="POST"
                      style="width: 5rem; display: flex; justify-content: center; align-items: center; align-content: center">
                    <button type="submit" class="press hoverable-1"
                            style="background: url('../../public/pictures/share.png') no-repeat; width: 32px; height: 32px; text-decoration: none; border: none; cursor: pointer"></button>
                </form>
                <h4 class="background"
                    style="margin: 0; padding-left: 1rem; width:100%"><?php echo $task->get_title() . "   " ?></h4>
            </div>
            <p style="margin-left: 2rem"><?php echo $task->get_wording() ?></p>
        </div>

        <!-- Liste des tâches -->

        <div class="card shadow-1"
             style="background: white; width: 80%; display: flex; flex-flow: row nowrap; justify-content: space-between; align-items: flex-start; align-content: center;">
            <?php if ($task->get_sDate() != null) { ?>
                <div style="display: flex; flex-flow: column nowrap; width: 33%">
                    <div style="display: flex; flex-flow: column nowrap; align-items: baseline; align-content: flex-start; margin-top: 0.5rem;">
                        <h6 style="margin: 0 5%"><?php echo ($task->get_type() === true) ? 'Début de récurrence' : 'Date d\'échéance'; ?>
                            :</h6>
                        <p style="margin-left: 5%"><?php echo $task->get_sDate() ?></p>
                    </div>
                    <?php if ($task->get_type() === true) { ?>
                        <div style="display: flex; flex-flow: column nowrap; align-items: baseline; align-content: flex-start; margin-top: 0.5rem;">
                            <h6 style="margin: 0 5%">Fin de récurrence :</h6>
                            <p style="margin-left: 5%"><?php echo $task->get_eDate() ?></p>
                        </div>
                        <div style="display: flex; flex-flow: column nowrap; align-items: baseline; align-content: flex-start; margin-top: 0.5rem;">
                            <h6 style="margin: 0 5%">Jour(s) récurrent(s) :</h6>
                            <?php foreach ($task->get_days() as $day) { ?>
                                <p style="margin: 0.5rem 5%"><?php echo $day[0][1]; ?></p>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
            <div style="display: flex; flex-flow: column nowrap; width: 34%">
                <div style="display: flex; flex-flow: row nowrap; align-items: baseline; align-content: flex-start; margin-top: 0.5rem;">
                    <h6 style="margin: 0 5%">UG :</h6>
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
                    <h6 style="margin: 0 5%">Site :</h6>
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
                <div style="display: flex; flex-flow: row nowrap; align-items: baseline; align-content: flex-start; margin-top: 1rem;">
                    <h6 style="margin: 0 5%">Personne(s) Assignée(s) :</h6>
                </div>
                <div style="display: flex; flex-flow: column nowrap; align-items: baseline; align-content: flex-start; margin-top: 0.5rem;">
                    <?php foreach ($task->get_user_assign() as $users) { ?>
                        <p style="margin: 0.5rem 5%"><?php echo $users[1] . ' ' . $users[2] ?></p>
                    <?php } ?>
                </div>
                <div style="display: flex; flex-flow: column nowrap; align-items: baseline; align-content: flex-start; margin-top: 0.5rem;">
                    <h6 style="margin: 0 5%">Observateur(s) Assignée(s) :</h6>
                </div>
                <div style="display: flex; flex-flow: column nowrap; align-items: baseline; align-content: flex-start; margin-top: 0.5rem;">
                    <?php foreach ($task->get_observ_assign() as $observ) { ?>
                        <p style="margin: 0.5rem 5%"><?php echo $observ[1] . ' ' . $observ[2] ?></p>
                    <?php } ?>
                </div>
            </div>
            <div style="display: flex; flex-flow: column nowrap; width: 33%">
                <form action="../script/save.php" method="POST">
                    <div style="display: flex; flex-flow: row nowrap; align-items: baseline; align-content: flex-start; margin-top: 0.5rem;">
                        <h6 style="margin: 0 5%">Localisation :</h6>
                        <input type="text" name="loca" style="margin: 0" class="form-control rounded-1 item"
                               value="<?php echo ($task->get_localisation() != null) ? $task->get_localisation() : 'Non Attribué'; ?>"
                               required/>
                    </div>
                    <div style="display: flex; flex-flow: row nowrap; align-items: baseline; align-content: flex-start; margin-top: 0.5rem;">
                        <h6 style="margin: 0 5%">Entreprise :</h6>
                        <select
                                class="form-control rounded-1 item" name="etp" id="select"
                                style="width: 7rem; margin: 0" required>
                            <?php
                            $database = connection();

                            $stmt = $database->prepare('SELECT * FROM COMPANY');
                            $stmt->execute();
                            $priority = $stmt->fetchAll(PDO::FETCH_BOTH);

                            foreach ($priority as $item) {
                                ?>
                                <option value="<?php echo $item[0] ?>" <?php if ($task->get_company_id() == $item[0]) echo 'selected' ?> > <?php echo $item[1] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div style="display: flex; flex-flow: row nowrap; align-items: baseline; align-content: flex-start; margin-top: 0.5rem;">
                        <h6 style="margin: 0 5%">Priorité :</h6>
                        <div style="display: flex; align-items: center; justify-content: center">
                            <select
                                    class="form-control rounded-1 item" name="p_priority" id="select"
                                    style="width: 7rem; margin: 0" required>
                                <?php
                                $database = connection();

                                $stmt = $database->prepare('SELECT * FROM PRIORITY');
                                $stmt->execute();
                                $priority = $stmt->fetchAll(PDO::FETCH_BOTH);

                                foreach ($priority as $item) {
                                    ?>
                                    <option value="<?php echo $item[0] ?>" <?php if ($task->get_priority_id() == $item[0]) echo 'selected' ?> > <?php echo $item[1] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div style="display: flex; flex-flow: row nowrap; align-items: baseline; align-content: flex-start; margin-top: 0.5rem;">
                        <h6 style="margin: 0 5%">État :</h6>
                        <div style="display: flex; align-items: center; justify-content: center">
                            <select
                                    class="form-control rounded-1 item" name="p_state" id="select"
                                    style="width: 7rem; margin: 0" required>
                                <?php
                                $database = connection();

                                $stmt = $database->prepare('SELECT * FROM STATES');
                                $stmt->execute();
                                $priority = $stmt->fetchAll(PDO::FETCH_BOTH);

                                foreach ($priority as $item) {
                                    ?>
                                    <option value="<?php echo $item[0] ?>" <?php if ($task->get_state_id() == $item[0]) echo 'selected' ?> > <?php echo $item[1] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="centered"
                         style="display: flex; flex-flow: row nowrap; align-items: center; justify-content: center; margin: 1rem 0">
                        <input type="hidden" name="p_task_id" value="<?php echo $task->get_id() ?>">
                        <button type="submit" class="press hoverable-1"
                                style="background: url('../../public/pictures/floppy-disk.png') no-repeat; width: 24px; height: 24px; text-decoration: none; border: none; cursor: pointer; margin-right: 1rem;"></button>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Messagerie -->

        <div class="card shadow-1 fx-row" style="background: white; max-width: 80%; width: 100%">
            <div class="d-flex vcenter fx-center px-4" style="background: white; color: black; width: 24rem;">
                <h4>Commentaires :</h4>
            </div>
            <div class="flex fx-col fx-grow">
                <div class="card-content">
                    <?php if ($user->getGroup()->getCanWriteCommentary() == true) { ?>
                        <form action="../script/posting.php" method="POST">
                            <input type="hidden" name="p_task_id" value="<?php echo $_SESSION['p_task_id']; ?>">
                            <div style="display: flex; flex-flow: row nowrap; justify-content: flex-start; justify-items: center; align-items: center">
                                <input type="text" name="message" class="form-control rounded-1"
                                       placeholder="Écrire un commentaire ..." required/>
                                <button type="submit" class="btn shadow-1 rounded-1 small background"
                                        style="width: 7rem; margin-left: 0.5rem;">Envoyer
                                </button>
                            </div>
                        </form>
                    <?php } ?>
                    <div style="display: flex; flex-flow: column nowrap; justify-content: flex-start; justify-items: left; align-items: flex-start; max-width: 100%; margin-top: 1rem;">
                        <?php
                        $database = connection();

                        $stmt = $database->prepare("SELECT C.id,firstname,wording,posting_date FROM COMMENTARY C, DATING D, USERS U WHERE D.task_id = :p_task_id AND D.commentary_id = C.id AND D.user_id = U.id ORDER BY posting_date DESC");
                        $stmt->execute(array(
                            ':p_task_id' => $_SESSION['p_task_id']
                        ));
                        $stmt = $stmt->fetchAll(PDO::FETCH_BOTH);

                        foreach ($stmt as $item) {
                            ?>
                            <div class="divider" style="margin: 0.1rem 0;"></div>
                            <div class="txt-left">
                                <p style="font-size: 0.5rem;">Le <?php echo $item[3] ?> : </p>
                                <div style="display: flex; flex-flow: row nowrap; align-items: center; margin-bottom: 0.2rem">
                                    <?php if ($user->getGroup()->getCanWriteCommentary() == true) { ?>
                                        <form action="../script/deleteCommentary.php" method="POST"
                                              onsubmit="return confirm('Êtes-vous sûr ?');"
                                              style="display: flex; flex-flow: row nowrap;">
                                            <button type="submit" class="press shadow-2 "
                                                    style="margin-right: 0.5rem; color: white; background: #BF1A2F; width: 1rem; height: 1rem; font-size: 0.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center">
                                                <b>x</b></button>
                                            <input type="hidden" value="<?php echo $item[0] ?>" name="t_commentary_id"/>
                                        </form>
                                    <?php } ?>
                                    <b><?php echo $item[1] ?></b> : <?php echo $item[2] ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <!--     @End      #Content -->

    <?php include_once('../generic/footer.php'); //Add FOOTER part to the code ?>

    </body>

<?php } else {
    $_SESSION['error'] = 'Veuillez vous authentifier !';
    header('Location: ../index.php');
    exit();
} ?>
