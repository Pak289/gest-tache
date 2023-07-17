<?php
include_once('../../../config/basic.php');
session_start();

if (isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    $task = unserialize($_SESSION['task']);

    if (isset($_POST['p_recurrence']))
        $task->set_type(true);

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
            <div class="card-header">Création d'une tâche (4/5)</div>
            <div class="divider"></div>
            <div class="card-content">
                <form action="<?php echo ($task->get_type() === true) ? 'nT5.php' : 'endTask.php'; ?>" method="post"
                      style="width: 20rem;">
                    <div class="form-field">
                        <label for="p_sDate">Date <?php echo ($task->get_type() === true) ? ' de début de récurrence' : ' d\'échéance'; ?>
                            :
                            <input value="<?php echo $task->get_sDate(); ?>" type="text"
                                   name="p_sDate" class="form-control rounded-1 item" placeholder="27/01/2000"/>
                        </label>
                        <?php if ($task->get_type() === true) { ?>
                            <label for="p_eDate">Date de fin de récurrence :
                                <input value="<?php echo $task->get_eDate(); ?>"
                                       type="text" name="p_eDate" class="form-control rounded-1 item"
                                       placeholder="24/04/2021"/>
                            </label>
                        <?php } ?>
                        <div style="display: flex; flex-flow: row nowrap; align-items: center; justify-content: center; align-content: center; margin: 1rem 0;">
                            <form action="nT3.php" method="POST" style="margin-right: 1rem;">
                                <div class="form-field">
                                    <button type="submit" formaction="nT3.php"
                                            class="btn small shadow-1 rounded-1 outline opening txt-airforce vself-center item"
                                            style="margin-top: 1.5rem;"><span class="outline-text">Retour</span>
                                    </button>
                                </div>
                            </form>
                            <div class="form-field">
                                <button type="submit"
                                        class="btn small shadow-1 rounded-1 outline opening txt-airforce vself-center item"
                                        style="margin-top: 1.5rem;"><span class="outline-text">Suivant</span></button>
                            </div>
                        </div>
                    </div>
                </form>
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
