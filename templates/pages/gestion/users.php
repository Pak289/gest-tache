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
                <a href="#tab1">Liste des utilisateurs existants</a>
            </li>
            <li class="tab-link">
                <a href="#tab2">Créer un utilisateur</a>
            </li>
        </ul>

        <div id="tab1" class="p-3">
            <?php if(isset($_SESSION['result']) && $_SESSION['result'] != null) { ?>
                <div class="p-3 my-2 rounded-2 <?php if(isset($_SESSION['result']) && $_SESSION['result'] == "L'utilisateur a bien été supprimé.") echo 'success'; else echo 'error' ?>"><?php echo $_SESSION['result']; $_SESSION['result'] = null; ?></div>
            <?php } ?>
            <div class="responsive-table shadow-2" style="margin-top: 3rem; background: white;">
                <table class="table hover centered">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Initiale</th>
                        <th>Email</th>
                        <th>Groupe</th>
                        <th>UG</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $database = connection();

                    $stmt = $database->prepare('SELECT * FROM USERS');
                    $stmt->execute();
                    $array = $stmt->fetchAll(PDO::FETCH_BOTH);

                    foreach ($array as $item)
                    {
                        ?>
                        <tr>
                        <form action="../../script/saveUsers.php" method="POST">
                            <td><input type="text" name="name" style="width: 7rem" class="form-control rounded-1 item"
            value="<?php echo $item[1]; ?>" required/></td>
                            <td><input type="text" name="firstname" style="width: 7rem" class="form-control rounded-1 item" value="<?php echo $item[2]; ?>"
           required/></td>
                            <td><input type="text" name="abv" style="width: 5rem" class="form-control rounded-1 item" value="<?php echo $item[3]; ?>"
required/></td>
                            <td><input type="text" name="email" style="width: 21rem" class="form-control rounded-1 item" value="<?php echo $item[4]; ?>"
required/></td>
                            <td>
                                <select class="form-control rounded-1 item" name="pgroup" id="select" required>
                                    <?php
                                    $database = connection();

                                    $stmt = $database->prepare('SELECT id,wording FROM USERS_GROUPS');
                                    $stmt->execute();
                                    $groups = $stmt->fetchAll(PDO::FETCH_BOTH);

                                    foreach ($groups as $groupp)
                                    {
                                        ?>
                                        <option value="<?php echo $groupp[0] ?>" <?php if($item[6] == $groupp[0]) echo 'selected' ?>> <?php echo $groupp[1] ?> </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <select class="form-control rounded-1 item" name="pug" id="select">
                                    <?php
                                    $stmt = $database->prepare('SELECT id,name FROM UG WHERE visibility = false');
                                    $stmt->execute();
                                    $UG = $stmt->fetchAll(PDO::FETCH_BOTH);

                                    foreach ($UG as $ugg)
                                    {
                                        ?>
                                        <option value="<?php echo $ugg[0] ?>" <?php if($item[7] == $ugg[0]) echo "selected" ?>> <?php echo $ugg[1] ?> </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <div class="centered"
                                     style="display: flex; flex-flow: row nowrap; align-items: center; justify-content: center">
                                    <input type="hidden" name="groupId" value="<?php echo $item[0]; ?>"/>
                                    <button type="submit" class="press hoverable-1"
                                            style="background: url('../../../public/pictures/floppy-disk.png') no-repeat; width: 24px; height: 24px; text-decoration: none; border: none; cursor: pointer; margin-right: 1rem;"></button>
                                    </button>
                                </form>
                                <form action="../../script/resetPassword.php" method="POST" onsubmit="return confirm('Êtes-vous sûr ?');">
                                    <input type="hidden" name="groupId" value="<?php echo $item[0]; ?>"/>
                                    <button type="submit" class="press hoverable-1"
                                            style="background: url('../../../public/pictures/double-chevron.png') no-repeat; width: 24px; height: 24px; border-radius: 50%; text-decoration: none; border: none; cursor: pointer; margin-right: 1rem;"></button>
                                </form>
                                <form action="../../script/deleteUser.php" method="POST" onsubmit="return confirm('Êtes-vous sûr ?');">
                                    <input type="hidden" name="groupId" value="<?php echo $item[0]; ?>"/>
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
                <div class="card-header">Création d'un utilisateur</div>
                <div class="divider"></div>
                <div class="card-content">
                    <form action="../../script/createUser.php" method="post" style="width: 20rem;">
                        <div class="form-field">
                            <label for="name">Nom :</label>
                            <input type="text" name="name" class="form-control rounded-1 item" placeholder="Armstrong" required/>
                            <label for="firstname">Prénom :</label>
                            <input type="text" name="firstname" class="form-control rounded-1 item" placeholder="Louis" required/>
                            <label for="ini">Initiale :</label>
                            <input type="text" name="ini" class="form-control rounded-1 item" placeholder="AL" required/>
                            <label for="email">Email :</label>
                            <input type="text" name="email" class="form-control rounded-1 item" placeholder="exemple@crous-strasbourg.fr" required/>
                            <label for="group">Groupe utilisateur :</label>
                            <select class="form-control rounded-1 item" name="group" id="select" required>
                                <?php
                                $database = connection();

                                $stmt = $database->prepare('SELECT id,wording FROM USERS_GROUPS');
                                $stmt->execute();
                                $groups = $stmt->fetchAll(PDO::FETCH_BOTH);

                                foreach ($groups as $item)
                                {
                                    ?>
                                    <option value="<?php echo $item[0] ?>" <?php if($item[0] == 4) echo 'selected' ?>> <?php echo $item[1] ?> </option>
                                    <?php
                                }
                                ?>
                            </select>
                            <label for="ug">UG de rattachement :</label>
                            <select class="form-control rounded-1 item" name="ug" id="select">
                                <option selected>Aucun</option>
                                <?php
                                $database = connection();

                                $stmt = $database->prepare('SELECT id,name FROM UG WHERE visibility = false');
                                $stmt->execute();
                                $UG = $stmt->fetchAll(PDO::FETCH_BOTH);

                                foreach ($UG as $item)
                                {
                                    ?>
                                    <option value="<?php echo $item[0] ?>"> <?php echo $item[1] ?> </option>
                                    <?php
                                }
                                ?>
                            </select>
                            <label>*Un email contenant le mot de passe sera envoyé à l'adresse indiqué.</label>
                            <button type="submit" class="btn small shadow-1 rounded-1 outline opening txt-blue vself-center item" style="margin-top: 1.5rem;"><span class="outline-text">Créer l'utilisateur</span></button>
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
