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
                <a href="#tab1">Liste des entreprises existants</a>
            </li>
            <li class="tab-link">
                <a href="#tab2">Ajouter une entreprise</a>
            </li>
        </ul>

        <div id="tab1" class="p-3">
            <?php if(isset($_SESSION['result']) && $_SESSION['result'] != null) { ?>
                <div class="p-3 my-2 rounded-2 <?php if(isset($_SESSION['result']) && $_SESSION['result'] == "Le projet a bien été supprimé.") echo 'success'; else echo 'error' ?>"><?php echo $_SESSION['result']; $_SESSION['result'] = null; ?></div>
            <?php } ?>
            <div class="responsive-table shadow-2" style="margin-top: 3rem; background: white;">
                <table class="table hover centered">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Adresse</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $database = connection();

                    $stmt = $database->prepare('SELECT * FROM COMPANY');
                    $stmt->execute();
                    $array = $stmt->fetchAll(PDO::FETCH_BOTH);

                    foreach ($array as $item)
                    {
                        ?>
                        <tr>
                            <td><?php echo $item[1]; ?></td>
                            <td><?php echo $item[2] . ' ' . $item[3] . ' ' . $item[4] . ' ' . $item[5]; ?></td>
                            <td>
                                <form action="../../script/deleteCompany.php" method="POST" onsubmit="return confirm('Êtes-vous sûr ?');">
                                    <input type="hidden" name="groupId" value="<?php echo $item[0]; ?>"/>
                                    <button type="submit" class="press hoverable-1"
                                            style="background: url('../../../public/pictures/remove.png') no-repeat; width: 24px; height: 24px; border-radius: 50%; text-decoration: none; border: none; cursor: pointer"></button>
                                </form>
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
                <div class="card-header">Création d'un projet</div>
                <div class="divider"></div>
                <div class="card-content">
                    <form action="../../script/createCompany.php" method="post" style="width: 20rem;">
                        <div class="form-field">
                            <label for="name">Nom de l'entreprise :</label>
                            <input type="text" name="name" class="form-control rounded-1 item" placeholder="Crous BTP" required/>
                            <label for="number">Numéro de rue :</label>
                            <input type="text" name="number" class="form-control rounded-1 item" placeholder="1" required/>
                            <label for="street">Rue :</label>
                            <input type="text" name="street" class="form-control rounded-1 item" placeholder="Rue des Crousiens" required/>
                            <label for="pc">Code postal :</label>
                            <input type="text" name="pc" class="form-control rounded-1 item" placeholder="67999" required/>
                            <label for="city">Ville :</label>
                            <input type="text" name="city" class="form-control rounded-1 item" placeholder="Crousbourg" required/>
                            <button type="submit" class="btn small shadow-1 rounded-1 outline opening txt-blue vself-center item" style="margin-top: 1.5rem;"><span class="outline-text">Créer l'entreprise</span></button>
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
