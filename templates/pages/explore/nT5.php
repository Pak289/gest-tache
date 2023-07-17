<?php
include_once('../../../config/basic.php');
session_start();

if (isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    $task = unserialize($_SESSION['task']);

    if ($_POST['p_sDate'] != null) $task->set_sDate($_POST['p_sDate']);
    if ($_POST['p_eDate'] != null) ($task->get_type() != true) ? $task->set_eDate(null) : $task->set_eDate($_POST['p_eDate']);

    $_SESSION['task'] = serialize($task);

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
        <div class="card shadow-1 rounded-3 vcenter" style="width: 25rem; background: white; margin-top: 0">
            <div class="card-header">Création d'une tâche (5/5)</div>
            <div class="divider"></div>
            <div class="card-content">
                <div class="form-field">
                    <form action="../../script/addAssign.php" method="post" style="width: 20rem;">
                        <div class="form-field">
                            <label for="p_day">Jour(s) concerné(s) :</label>
                            <select class="form-control rounded-1 item" name="p_day" id="select" required>
                                <?php
                                $database = connection();

                                $stmt = $database->prepare('SELECT id,wording FROM DAY_DAYS');
                                $stmt->execute();
                                $groups = $stmt->fetchAll(PDO::FETCH_BOTH);

                                foreach ($groups as $item) {
                                    ?>
                                    <option value="<?php echo $item[0] ?>"> <?php echo $item[1] . ' ' . $item[2] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <button type="submit" formaction="../../script/addAssign.php"
                                    class="btn small shadow-1 rounded-1 outline opening txt-blue vself-center item"
                                    style="margin-top: 1.5rem;"><span class="outline-text">Ajouter</span></button>
                        </div>
                    </form>
                </div>
                <div class="form-field">
                    <?php foreach ($task->get_days() as $item => $value) { ?>
                        <form action="../../script/removeAssign.php" method="POST"
                              style="display: flex; flex-flow: row nowrap;">
                            <button type="submit" class="press shadow-2 "
                                    style="margin-right: 1rem; color: white; background: #BF1A2F; width: 1.5rem; height: 1.5rem; font-size: 0.7rem; border-radius: 50%; display: flex; justify-content: center; align-items: center">
                                <b>X</b></button>
                            <input type="hidden" value="<?php echo $item ?>" name="d_array_id"/>
                            <p style="font-size: 0.5rem;"><?php echo $value[1] . ' ' . $value[2]; ?></p>
                        </form>
                    <?php } ?>
                </div>
                <div style="display: flex; flex-flow: row nowrap; align-items: center; justify-content: center; align-content: center; margin: 1rem 0;">
                    <form action="nT3.php" method="POST" style="margin-right: 1rem;">
                        <div class="form-field">
                            <button type="submit"
                                    class="btn small shadow-1 rounded-1 outline opening txt-airforce vself-center item"
                                    style="margin-top: 1.5rem;"><span
                                        class="outline-text">Retour</span></button>
                        </div>
                    </form>
                    <form action="endTask.php" method="POST">
                        <div class="form-field">
                            <button type="submit"
                                    class="btn small shadow-1 rounded-1 outline opening txt-airforce vself-center item"
                                    style="margin-top: 1.5rem;"><span class="outline-text"
                                                                      formaction="endTask.php">Suivant</span></button>
                        </div>
                    </form>
                </div>
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
