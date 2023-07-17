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
                <a href="#tab1">Liste des UG existants</a>
            </li>
            <li class="tab-link">
                <a href="#tab2">Créer une UG</a>
            </li>
        </ul>

        <div id="tab1" class="p-3">
            <?php if (isset($_SESSION['result']) && $_SESSION['result'] != null) { ?>
                <div class="p-3 my-2 rounded-2 <?php if (isset($_SESSION['result']) && $_SESSION['result'] == "L'UG a bien été supprimé.") echo 'success'; else echo 'error' ?>"><?php echo $_SESSION['result'];
                    $_SESSION['result'] = null; ?></div>
            <?php } ?>
            <div class="responsive-table shadow-2" style="margin-top: 3rem; background: white;">
                <table class="table hover centered">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Abréviation</th>
                        <th>Type</th>
                        <th>Adresse</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $database = connection();

                    $stmt = $database->prepare('SELECT * FROM UG WHERE visibility = false');
                    $stmt->execute();
                    $users_groups = $stmt->fetchAll(PDO::FETCH_BOTH);

                    foreach ($users_groups as $group) {
                        ?>
                        <tr>
                            <form action="../../script/saveUG.php" method="POST">
                                <td><input type="text" name="name" class="form-control rounded-1 item"
                                            value="<?php echo $group[1]; ?>" required/></td>
                                <td><input type="text" name="abv" class="form-control rounded-1 item" value="<?php echo $group[2]; ?>"
                                           required/></td>
                                <td><select class="form-control rounded-1 item" name="type" id="select" required>
                                        <option value="Hébergement" <?php if($group[3] == "Hébergement") echo "selected" ?>>Hébergement</option>
                                        <option value="Restauration" <?php if($group[3] == "Restauration") echo "selected" ?>>Restauration</option>
                                        <option value="Administration" <?php if($group[3] == "Administration") echo "selected" ?>>Administration</option>
                                </select></td>
                                <td><?php echo $group[4] . ' ' . $group[5] . ' ' . $group[6] . ' ' . $group[7]; ?></td>
                                <td>
                                    <div class="centered"
                                         style="display: flex; flex-flow: row nowrap; align-items: center; justify-content: center">
                                    <input type="hidden" name="groupId" value="<?php echo $group[0]; ?>"/>
                                    <button type="submit" class="press hoverable-1"
                                            style="background: url('../../../public/pictures/floppy-disk.png') no-repeat; width: 24px; height: 24px; text-decoration: none; border: none; cursor: pointer; margin-right: 1rem;"></button>
                                    </button>
                            </form>
                            <form action="../../script/deleteUG.php" method="POST"
                                  onsubmit="return confirm('Êtes-vous sûr ?');">
                                <input type="hidden" name="groupId" value="<?php echo $group[0]; ?>"/>
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
                <div class="card-header">Création d'une UG</div>
                <div class="divider"></div>
                <div class="card-content">
                    <form action="../../script/createUG.php" method="post">
                        <div class="form-field">
                            <label for="name">Le nom de l'UG sera :</label>
                            <input type="text" name="name" class="form-control rounded-1 item"
                                   placeholder="Cité Crousiversitaire" required/>
                            <label for="abv">Version contracté :</label>
                            <input type="text" name="abv" class="form-control rounded-1 item" placeholder="Crousiver"
                                   required/>
                            <label for="select">Type d'UG :</label>
                            <select class="form-control rounded-1 item" name="type" id="select" required>
                                <option value="Hébergement">Hébergement</option>
                                <option value="Restauration">Restauration</option>
                                <option value="Administration">Administration</option>
                            </select>
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
                            <button type="submit"
                                    class="btn small shadow-1 rounded-1 outline opening txt-blue vself-center item"
                                    style="margin-top: 1.5rem;"><span class="outline-text">Créer l'UG</span></button>
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
