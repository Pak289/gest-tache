<?php
include_once('../../../config/basic.php');
session_start();

if(isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    include_once('../../generic/head.php'); //Add HEAD part to the code ?>

    <body class="layout with-sidenav" style="background: #EAEAEA;">

    <?php include_once('../../generic/header.php'); //Add HEADER part to the code ?>

    <?php include_once('../../generic/sidenav.php'); //Add HEADER part to the code ?>


    <!--    @Start     #Content -->

    <style>
        .item {
            margin: 0.5rem 0;
        }
    </style>

    <div class="tab shadow-1 full-width" id="example-tab" data-ax="tab">
        <ul class="tab-menu shadow-2" style="background: white;">
            <li class="tab-link active">
                <a href="#tab1">Liste et permission des groupes existants</a>
            </li>
            <li class="tab-link">
                <a href="#tab2">Créer un nouveau groupe</a>
            </li>
        </ul>

        <div id="tab1" class="p-3">
            <?php if(isset($_SESSION['result']) && $_SESSION['result'] != null) { ?>
            <div class="p-3 my-2 rounded-2 <?php if(isset($_SESSION['result']) && $_SESSION['result'] == "Le groupe a bien été supprimé.") echo 'success'; else echo 'error' ?>"><?php echo $_SESSION['result']; $_SESSION['result'] = null; ?></div>
            <?php } ?>
            <div class="responsive-table shadow-2" style="margin-top: 3rem; background: white;">
                <table class="table hover centered">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Utilisateur</th>
                        <th>Groupe</th>
                        <th>Site</th>
                        <th>UG</th>
                        <th>Sous-tâche</th>
                        <th>Tâche</th>
                        <th>Projet</th>
                        <th>Entreprise</th>
                        <th>Écriture</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $database = connection();

                        $stmt = $database->prepare('SELECT * FROM USERS_GROUPS');
                        $stmt->execute();
                        $users_groups = $stmt->fetchAll(PDO::FETCH_BOTH);

                        foreach ($users_groups as $group) {
                    ?>
                    <tr>
                        <td><?php echo $group[1] ?></td>
                        <form action="../../script/saveGroup.php" method="POST">
                            <td>
                                <select class="form-control rounded-1 item" name="user" id="select" required>
                                        <option value="0" <?php if($group[2] == "0") echo "selected" ?>>Non</option>
                                        <option value="1" <?php if($group[2] == "1") echo "selected" ?>>Oui</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control rounded-1 item" name="group" id="select" required>
                                        <option value="0" <?php if($group[3] == "0") echo "selected" ?>>Non</option>
                                        <option value="1" <?php if($group[3] == "1") echo "selected" ?>>Oui</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control rounded-1 item" name="site" id="select" required>
                                        <option value="0" <?php if($group[4] == "0") echo "selected" ?>>Non</option>
                                        <option value="1" <?php if($group[4] == "1") echo "selected" ?>>Oui</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control rounded-1 item" name="ug" id="select" required>
                                        <option value="0" <?php if($group[5] == "0") echo "selected" ?>>Non</option>
                                        <option value="1" <?php if($group[5] == "1") echo "selected" ?>>Oui</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control rounded-1 item" name="subTask" id="select" required>
                                        <option value="0" <?php if($group[6] == "0") echo "selected" ?>>Non</option>
                                        <option value="1" <?php if($group[6] == "1") echo "selected" ?>>Oui</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control rounded-1 item" name="task" id="select" required>
                                        <option value="0" <?php if($group[7] == "0") echo "selected" ?>>Non</option>
                                        <option value="1" <?php if($group[7] == "1") echo "selected" ?>>Oui</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control rounded-1 item" name="project" id="select" required>
                                        <option value="0" <?php if($group[8] == "0") echo "selected" ?>>Non</option>
                                        <option value="1" <?php if($group[8] == "1") echo "selected" ?>>Oui</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control rounded-1 item" name="company" id="select" required>
                                        <option value="0" <?php if($group[9] == "0") echo "selected" ?>>Non</option>
                                        <option value="1" <?php if($group[9] == "1") echo "selected" ?>>Oui</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control rounded-1 item" name="write" id="select" required>
                                        <option value="0" <?php if($group[10] == "0") echo "selected" ?>>Non</option>
                                        <option value="1" <?php if($group[10] == "1") echo "selected" ?>>Oui</option>
                                </select>
                            </td>
                            <td>
                                <div class="centered"
                                     style="display: flex; flex-flow: row nowrap; align-items: center; justify-content: center">
                                <input type="hidden" name="groupId" value="<?php echo $group[0] ?>"/>
                                <button type="submit" class="press hoverable-1"
                                        style="background: url('../../../public/pictures/floppy-disk.png') no-repeat; width: 24px; height: 24px; text-decoration: none; border: none; cursor: pointer; margin-right: 1rem;"></button>
                            </form>
                                    <form action="../../script/deleteGroup.php" method="POST" onsubmit="return confirm('Êtes-vous sûr ?');">
                                        <input type="hidden" name="groupId" value="<?php echo $group[0]; ?>"/>
                                        <button type="submit" class="press hoverable-1"
                                                style="background: url('../../../public/pictures/remove.png') no-repeat; width: 24px; height: 24px; border-radius: 50%; text-decoration: none; border: none; cursor: pointer"></button>
                                    </form>
                                </div>
                        </td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="tab2" class="p-3 vself-center self-center vcenter">
            <div class="card shadow-1 rounded-3 vcenter" style="width: 25rem; background: white; margin-top: 3rem">
                <div class="card-header">Création de groupe</div>
                <div class="divider"></div>
                <div class="card-content">
                    <form action="../../script/createGroup.php" method="post">
                        <div class="form-field">
                            <label for="name">Le nom du groupe sera :</label>
                            <input type="text" name="name" class="form-control rounded-1 item" placeholder="Exemple" />
                            <label>Le groupe peut-il accèder à ...</label>
                            <div class="grix xs1 center item">
                                <p>... Gestion des utilisateurs ?</p>
                                <label class="form-switch">
                                    Non
                                    <input name="user" type="checkbox"/>
                                    <span class="slider small"></span>
                                    Oui
                                </label>
                            </div>
                            <div class="grix xs1 center item">
                                <p>... Gestion des groupes ?</p>
                                <label class="form-switch">
                                    Non
                                    <input name="group" type="checkbox"/>
                                    <span class="slider small"></span>
                                    Oui
                                </label>
                            </div>
                            <div class="grix xs1 center item">
                                <p>... Gestion des sites ?</p>
                                <label class="form-switch">
                                    Non
                                    <input name="site" type="checkbox"/>
                                    <span class="slider small"></span>
                                    Oui
                                </label>
                            </div>
                            <div class="grix xs1 center item">
                                <p>... Gestion des UG ?</p>
                                <label class="form-switch">
                                    Non
                                    <input name="ug" type="checkbox"/>
                                    <span class="slider small"></span>
                                    Oui
                                </label>
                            </div>
                            <div class="grix xs1 center item">
                                <p>... Gestion des projets ?</p>
                                <label class="form-switch">
                                    Non
                                    <input name="project" type="checkbox"/>
                                    <span class="slider small"></span>
                                    Oui
                                </label>
                            </div>
                            <label>Le groupe pourra ...</label>
                            <div class="grix xs1 center item">
                                <p>... Créer/Modifier/Supprimer des sous-tâches ?</p>
                                <label class="form-switch">
                                    Non
                                    <input name="subtask" type="checkbox"/>
                                    <span class="slider small"></span>
                                    Oui
                                </label>
                            </div>
                            <div class="grix xs1 center item">
                                <p>... Créer/Modifier/Supprimer des tâches ?</p>
                                <label class="form-switch">
                                    Non
                                    <input name="task" type="checkbox"/>
                                    <span class="slider small"></span>
                                    Oui
                                </label>
                            </div>
                            <div class="grix xs1 center item">
                                <p>... Écrire des commentaires ?</p>
                                <label class="form-switch">
                                    Non
                                    <input name="commentary" type="checkbox"/>
                                    <span class="slider small"></span>
                                    Oui
                                </label>
                            </div>
                            <button type="submit" class="btn small shadow-1 rounded-1 outline opening txt-blue vself-center item" style="margin-top: 1.5rem;"><span class="outline-text">Créer le groupe</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!--     @End      #Content -->

    <?php include_once('../../generic/footer.php'); //Add FOOTER part to the code ?>

    </body>

<?php } else { $_SESSION['error'] = 'Veuillez vous authentifier !'; header('Location: ../../index.php'); exit(); } ?>
