<?php
include_once('../../config/basic.php');
session_start();

if (isset($_SESSION['user'])) {
$user = unserialize($_SESSION['user']);

include_once('../generic/head.php'); //Add HEAD part to the code ?>

<div class="layout" style="background: #EAEAEA;">

    <?php include_once('../generic/header.php'); //Add HEADER part to the code ?>

    <!--    @Start     #Content -->

    <div style="display: flex; flex-flow: row wrap; justify-content: center; align-items: center; align-content: center;">

        <!-- Liste des tâches -->

        <div class="card shadow-1 fx-col" style="background: white; max-width: 80%; width: 100%">
            <div class="d-flex fx-row">
                <div class="d-flex vcenter fx-center px-4" style="background: white; color: black; width: 24rem;">
                    <h4>Mes tâches :</h4>
                </div>
                <div class="flex fx-col fx-grow">
                    <div class="card-content"
                         style="display: flex; flex-flow: row nowrap; justify-content: space-between">
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
                    $database = connection();

                    $stmt = $database->prepare("SELECT * FROM WORK WHERE user_id = :user_id");
                    $stmt->execute(array(
                        ':user_id' => $user->getId()
                    ));

                    $works = $stmt->fetchAll(PDO::FETCH_BOTH);

                    foreach ($works as $work) {
                        $stmt = $database->prepare("SELECT * FROM TASKS WHERE id = :id AND visibility IS NULL");
                        $stmt->execute(array(
                            ':id' => $work[2]
                        ));

                        $tasks = $stmt->fetchAll(PDO::FETCH_BOTH);

                        foreach ($tasks as $task) {
                            $task = new stm_Task_Herite($database, $task);
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
                                                <input type="hidden" name="p_task_id"
                                                       value="<?php echo $task->get_id() ?>">
                                                <button type="submit" class="press hoverable-1"
                                                        style="background: url('../../public/pictures/remove.png') no-repeat; width: 24px; height: 24px; border-radius: 50%; text-decoration: none; border: none; cursor: pointer"></button>
                                            </form>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>
                        <?php }
                    } ?>
                    </tbody>
                </table>
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
