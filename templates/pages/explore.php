<?php
include_once('../../config/basic.php');
session_start();

if (isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);

    include_once('../generic/head.php'); //Add HEAD part to the code ?>

    <body class="layout" style="background: #EAEAEA;">

    <?php include_once('../generic/header.php'); //Add HEADER part to the code ?>

    <!--    @Start     #Content -->

    <?php

    if (isset($_POST['project_id'])) {
        $_SESSION['project_id'] = $_POST['project_id'];
        $id = $_SESSION['project_id'];
    } else {
        $id = $_SESSION['project_id'];
    }
    $database = connection();

    $stmt = $database->prepare('SELECT * FROM PROJECTS WHERE id = :id');
    $stmt->execute(array(
        ':id' => $id
    ));

    $stmt = $stmt->fetchAll(PDO::FETCH_BOTH);
    ?>

    <div style="display: flex; flex-flow: row wrap; justify-content: center; align-items: center; align-content: center;">

        <!-- Projet -->

        <div class="card shadow-1 fx-column" style="background: white; width: 80%;">
            <div style="background: white; display: flex; align-items: center; align-content: center; height: 2rem">
                <form action="pci.php" method="POST"
                      style="width: 5rem; display: flex; justify-content: center; align-items: center; align-content: center">
                    <button type="submit" class="press hoverable-1"
                            style="background: url('../../public/pictures/share.png') no-repeat; width: 32px; height: 32px; text-decoration: none; border: none; cursor: pointer"></button>
                </form>
                <h4 class="background"
                    style="margin: 0; padding-left: 1rem; width:100%"><?php echo $stmt[0]['title']; ?></h4>
            </div>
            <p style="margin-left: 2rem"><?php echo $stmt[0]['wording']; ?></p>
        </div>

        <!-- Liste des tâches -->

        <div class="card shadow-1 fx-col" style="background: white; max-width: 80%; width: 100%">
            <div class="d-flex fx-row">
                <div class="d-flex vcenter fx-center px-4" style="background: white; color: black; width: 24rem;">
                    <h4>Liste des tâches :</h4>
                </div>
                <div class="flex fx-col fx-grow">
                    <div class="card-content"
                         style="display: flex; flex-flow: row nowrap; justify-content: space-between">
                        <?php if ($user->getGroup()->getTaskPerms() == true) { ?>
                            <form action="explore/newTask.php" method="POST">
                                <input type="hidden" name="project_id" value="<?php echo $id; ?>">
                                <button type="submit" class="btn shadow-1 rounded-1 small background"
                                        style="width: 15rem; margin-left: 0.5rem;">Créer une nouvelle tâche
                                </button>
                            </form>
                        <?php } ?>
                        <input type="text" id="research" class="form-control rounded-4 shadow-1 white ds-input"
                               style="width: 15rem;" onkeyup="research()" placeholder="Rechercher dans le titre..">
                        <input type="button" class="btn shadow-1 rounded-1 small background" id="btnExport"
                               value="Exporter vers XLS" onclick="Export()"/>
                    </div>
                </div>
            </div>
            <div class="responsive-table">
                <table class="table hover centered" id="tblTask">
                    <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>PA</th>
                        <th>Site</th>
                        <th>Localisation</th>
                        <th>Priorité</th>
                        <th>État</th>
                        <th>Entreprise</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $stmt = $database->prepare("SELECT * FROM TASKS WHERE project_id = :id AND visibility IS NULL");
                    $stmt->execute(array(
                        ':id' => $id
                    ));

                    $tasks = $stmt->fetchAll(PDO::FETCH_BOTH);

                    foreach ($tasks

                             as $task) {
                        $task = new stm_Task_Herite($database, $task, $id);
                        $_SESSION[$task->get_id() . 'task'] = serialize($task);
                        ?>
                        <tr>
                            <td><?php echo $task->get_title() ?></td>
                            <td style="overflow: hidden; max-width: 10rem; text-overflow: ellipsis; white-space: nowrap"><?php echo $task->get_wording() ?></td>
                            <td><?php foreach ($task->get_user_assign() as $users) echo $users[3] . ' ' ?></td>
                            <td><?php echo $task->get_site($database, $task->get_site_id())[0] ?></td>
                            <td><?php echo $task->get_localisation() ?></td>
                            <td><?php echo $task->get_priority($database, $task->get_priority_id())[0] ?></td>
                            <td><?php echo $task->get_state($database, $task->get_state_id())[0] ?></td>
                            <td><?php echo $task->get_company($database, $task->get_company_id())[0] ?></td>
                            <td>
                                <div class="centered"
                                     style="display: flex; flex-flow: row nowrap; align-items: center; justify-content: center">

                                    <form action="../script/exploreTask.php" method="POST">
                                        <input type="hidden" name="p_task_id" value="<?php echo $task->get_id() ?>">
                                        <button type="submit" class="press hoverable-1"
                                                style="background: url('../../public/pictures/double-chevron.png') no-repeat; width: 24px; height: 24px; text-decoration: none; border: none; cursor: pointer; margin-right: 1rem;"></button>
                                        </button>
                                    </form>
                                    <?php if ($user->getGroup()->getTaskPerms()) { ?>
                                        <form action="../script/delete.php" method="POST"
                                              onsubmit="return confirm('Êtes-vous sûr ?');">
                                            <input type="hidden" name="p_task_id" value="<?php echo $task->get_id() ?>">
                                            <button type="submit" class="press hoverable-1"
                                                    style="background: url('../../public/pictures/remove.png') no-repeat; width: 24px; height: 24px; border-radius: 50%; text-decoration: none; border: none; cursor: pointer"></button>
                                        </form>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
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
                            <input type="hidden" name="p_project_id" value="<?php echo $id; ?>">
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

                        $stmt = $database->prepare("SELECT C.id,firstname,wording,posting_date FROM COMMENTARY C, DATING D, USERS U WHERE D.project_id = :project_id AND D.commentary_id = C.id AND D.user_id = U.id ORDER BY posting_date DESC");
                        $stmt->execute(array(
                            ':project_id' => $id
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
                                            <input type="hidden" value="<?php echo $item[0] ?>" name="p_commentary_id"/>
                                        </form>
                                    <?php } ?>
                                    <b><?php echo $item[1] ?></b> : <?php echo $item[2] ?></div>
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

    <script>
        $('#btnExport').click(function () {
            $(document).ready(function () {
                $("#tblTask").table2excel({
                    filename: "Tache.xls"
                });
            });
        });

        function research() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("research");
            filter = input.value.toUpperCase();
            table = document.getElementById("tblTask");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>

<?php } else {
    $_SESSION['error'] = 'Veuillez vous authentifier !';
    header('Location: ../index.php');
    exit();
} ?>
