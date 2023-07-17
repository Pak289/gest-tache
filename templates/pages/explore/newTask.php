<?php
include_once('../../../config/basic.php');
session_start();

if (isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);

    if (!isset($_SESSION['task']))
        $_SESSION['task'] = serialize(new stm_Task());

    $task = unserialize($_SESSION['task']);

    $task->set_project_id($_SESSION['project_id']);

    $_SESSION['task'] = serialize($task);

    include_once('../../generic/head.php'); //Add HEAD part to the code ?>

    <body class="layout" style="background: #EAEAEA;">

    <?php include_once('../../generic/header.php');
    echo $_SESSION['session'] //Add HEADER part to the code ?>

    <!--    @Start     #Content -->

    <?php
    $database = connection();

    $stmt = $database->prepare('SELECT U.id,U.name FROM UG U, PROJECTS P WHERE P.id = :id AND ug_id = U.id');
    $stmt->execute(array(
        ':id' => $_SESSION['project_id']
    ));

    $ug_id = $stmt->fetchAll(PDO::FETCH_BOTH);
    ?>

    <style>
        .item {
            margin: 0.5rem 0;
        }
    </style>

    <div class="self-center vcenter" style="margin-top: 4rem;">
        <div class="card shadow-1 rounded-3 vcenter" style="width: 25rem; background: white">
            <div class="card-header">Création d'une tâche (1/5)</div>
            <div class="divider"></div>
            <div class="card-content">
                <form action="nT2.php" method="post" style="width: 20rem;">
                    <div class="form-field">
                        <label for="p_ug"> UG :
                            <select class="form-control rounded-1 item" name="p_ug" id="select" readonly>
                                <option value="<?php echo $ug_id[0][0] ?>" <?php if ($task->get_site_id() == $ug_id[0][0]) echo 'selected' ?> > <?php echo $ug_id[0][1] ?></option>
                            </select>
                        </label>
                        <label for="p_site">Site(s) :
                            <select class="form-control rounded-1 item" name="p_site" id="select">
                                <?php
                                $database = connection();

                                $stmt = $database->prepare('SELECT id,name FROM SITES WHERE ug_id = :id');
                                $stmt->execute(array(
                                    ':id' => $ug_id[0][0]
                                ));
                                $groups = $stmt->fetchAll(PDO::FETCH_BOTH);

                                foreach ($groups as $item) {
                                    ?>
                                    <option value="<?php echo $item[0] ?>" <?php if ($task->get_site_id() == $item[0]) echo 'selected' ?> > <?php echo $item[1] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </label>
                        <label for="p_name">Nom de la tâche :
                            <input value="<?php echo $task->get_title() ?>" type="text"
                                   name="p_name" class="form-control rounded-1 item" placeholder="Réparer le robinet"
                                   required/>
                        </label>
                        <label for="p_desc">Description :
                            <input value="<?php echo $task->get_wording() ?>" type="text"
                                   name="p_desc" class="form-control rounded-1 item"
                                   placeholder="Il faudra un tournevis ..."
                                   required/>
                        </label>
                        <label for="p_states">État assigné :
                            <select class="form-control rounded-1 item" name="p_states" id="select" required>
                                <?php
                                $database = connection();

                                $stmt = $database->prepare('SELECT id,wording FROM STATES');
                                $stmt->execute();
                                $groups = $stmt->fetchAll(PDO::FETCH_BOTH);

                                foreach ($groups as $item) {
                                    ?>
                                    <option value="<?php echo $item[0] ?>" <?php if ($task->get_state_id() == $item[0]) echo 'selected'; ?> > <?php echo $item[1] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </label>
                        <label for="p_priority">Priorité :
                            <select class="form-control rounded-1 item" name="p_priority" id="priorsity" required>
                                <option disabled selected>Veuillez sélectionner</option>
                                <?php
                                $database = connection();

                                $stmt = $database->prepare('SELECT * FROM PRIORITY');
                                $stmt->execute();
                                $groups = $stmt->fetchAll(PDO::FETCH_BOTH);

                                foreach ($groups as $item) {
                                    ?>
                                    <option value="<?php echo $item[0] ?>" <?php if ($task->get_priority_id() == $item[0]) echo 'selected' ?>> <?php echo $item[1] ?> </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </label>
                        <label for="p_etp">Choix de l'entreprise :
                            <select class="form-control rounded-1 item" name="p_etp" id="etp" required>
                                <option disabled selected>Veuillez sélectionner</option>
                                <?php
                                $database = connection();

                                $stmt = $database->prepare('SELECT id,name FROM COMPANY');
                                $stmt->execute();
                                $groups = $stmt->fetchAll(PDO::FETCH_BOTH);

                                foreach ($groups as $item) {
                                    ?>
                                    <option value="<?php echo $item[0] ?>" <?php if ($task->get_company_id() == $item[0]) echo 'selected' ?>> <?php echo $item[1] ?> </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </label>
                        <label for="p_localisation">Localisation :
                            <input value="<?php echo $task->get_localisation() ?>" type="text"
                                   name="p_localisation" class="form-control rounded-1 item"
                                   placeholder="Dans la chaufferie ..."/>
                        </label>
                        <div style="display: flex; flex-flow: row nowrap; align-items: center; justify-content: center; align-content: center; margin: 1rem 0;">
                            <form action="../explore.php" method="POST" style="margin-right: 1rem;">
                                <div class="form-field">
                                    <button type="submit" formaction="../explore.php"
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
