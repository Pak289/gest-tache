<?php
include_once('../../../config/basic.php');
session_start();

if (isset($_SESSION['user'])) {
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
                <a href="#tab1">Liste des sites existants</a>
            </li>
            <li class="tab-link">
                <a href="#tab2">Créer un site</a>
            </li>
        </ul>

        <div id="tab1" class="p-3">
            <?php if (isset($_SESSION['result']) && $_SESSION['result'] != null) { ?>
                <div class="p-3 my-2 rounded-2 <?php if (isset($_SESSION['result']) && $_SESSION['result'] == "Le site a bien été supprimé.") echo 'success'; else echo 'error' ?>"><?php echo $_SESSION['result'];
                    $_SESSION['result'] = null; ?></div>
            <?php } ?>
            <div class="responsive-table shadow-2" style="margin-top: 3rem; background: white;">
                <table class="table hover centered">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Abréviation</th>
                        <th>Adresse</th>
                        <th>UG d'appartenance</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $database = connection();

                    $stmt = $database->prepare('SELECT * FROM SITES WHERE visibility = false');
                    $stmt->execute();
                    $sites = $stmt->fetchAll(PDO::FETCH_BOTH);

                    foreach ($sites as $site) {
                        ?>
                        <tr>
                            <form action="../../script/saveSites.php" method="POST">
                                <td><input type="text" name="name" class="form-control rounded-1 item"
                                    value="<?php echo $site[1]; ?>" required/></td>
                                <td><input type="text" name="abv" class="form-control rounded-1 item"
                                           value="<?php echo $site[2]; ?>" required/></td>
                                <td><?php echo $site[3] . ' ' . $site[4] . ' ' . $site[5] . ' ' . $site[6]; ?></td>
                                <td><select class="form-control rounded-1 item" name="ug" id="select" required>
                                        <?php
                                        $database = connection();

                                        $stmt = $database->prepare('SELECT id,name FROM UG WHERE visibility = false');
                                        $stmt->execute();
                                        $ugs = $stmt->fetchAll(PDO::FETCH_BOTH);

                                        foreach ($ugs as $ug) { ?>
                                            <option value="<?php echo $ug[0] ?>" <?php if($site[7] == $ug[0]) echo "selected" ?> > <?php echo $ug[1] ?> </option>
                                            <?php } ?>
                                    </select></td>
                                <td>
                                    <div class="centered"
                                         style="display: flex; flex-flow: row nowrap; align-items: center; justify-content: center">
                                    <input type="hidden" name="groupId" value="<?php echo $site[0]; ?>"/>
                                    <button type="submit" class="press hoverable-1"
                                            style="background: url('../../../public/pictures/floppy-disk.png') no-repeat; width: 24px; height: 24px; text-decoration: none; border: none; cursor: pointer; margin-right: 1rem;"></button>
                                    </button>
                            </form>
                            <form action="../../script/deleteSite.php" method="POST"
                                  onsubmit="return confirm('Êtes-vous sûr ?');">
                                <input type="hidden" name="groupId" value="<?php echo $site[0]; ?>"/>
                                <button type="submit" class="press hoverable-1"
                                        style="background: url('../../../public/pictures/remove.png') no-repeat; width: 24px; height: 24px; border-radius: 50%; text-decoration: none; border: none; cursor: pointer"></button>
                            </form>
                            </div>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="tab2" class="p-3 vself-center self-center vcenter">
            <div class="card shadow-1 rounded-3 vcenter" style="width: 25rem; background: white; margin-top: 3rem">
                <div class="card-header">Création d'un site</div>
                <div class="divider"></div>
                <div class="card-content">
                    <form action="../../script/createSite.php" method="post">
                        <div class="form-field">
                            <label for="name">Le nom du site sera :</label>
                            <input type="text" name="name" class="form-control rounded-1 item"
                                   placeholder="Cité Crousiversitaire" required/>
                            <label for="abv">Version contracté :</label>
                            <input type="text" name="abv" class="form-control rounded-1 item" placeholder="Crousiver"
                                   required/>
                            <label for="number">Numéro de rue :</label>
                            <input type="text" name="number" class="form-control rounded-1 item" placeholder="1"
                                   required/>
                            <label for="street">Rue :</label>
                            <input type="text" name="street" class="form-control rounded-1 item"
                                   placeholder="Rue des Crousiens" required/>
                            <label for="pc">Code postal :</label>
                            <input type="text" name="pc" class="form-control rounded-1 item" placeholder="67999"
                                   required/>
                            <label for="city">Ville :</label>
                            <input type="text" name="city" class="form-control rounded-1 item" placeholder="Crousbourg"
                                   required/>
                            <label for="ug">UG de rattachement :</label>
                            <select class="form-control rounded-1 item" name="ug" id="select" required>
                                <?php
                                $database = connection();

                                $stmt = $database->prepare('SELECT id,name FROM UG WHERE visibility = false');
                                $stmt->execute();
                                $sites = $stmt->fetchAll(PDO::FETCH_BOTH);

                                foreach ($sites as $site) {
                                    ?>
                                    <option value="<?php echo $site[0] ?>"> <?php echo $site[1] ?> </option>
                                    <?php
                                }
                                ?>
                            </select>
                            <button type="submit"
                                    class="btn small shadow-1 rounded-1 outline opening txt-blue vself-center item"
                                    style="margin-top: 1.5rem;"><span class="outline-text">Créer le site</span></button>
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
