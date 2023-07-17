<?php
include_once('../../../config/basic.php');
session_start();

if(isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    include_once('../../generic/head.php'); //Add HEAD part to the code ?>

    <body class="layout" style="background: #EAEAEA;">

    <?php include_once('../../generic/header.php'); //Add HEADER part to the code ?>

    <!--    @Start     #Content -->

    <div class="card shadow-1 rounded-3 vself-center self-center vcenter" style="width: 25rem; background: white;">
        <div class="card-header">Changer de mot de passe</div>
        <div class="divider"></div>
        <div class="card-content">
            <form action="../../script/passwordChange.php" method="POST">
                <div class="form-field" style="width: 20rem;">
                    <label for="oldpwd">Ancien mot de passe</label>
                    <input type="password" id="oldpwd" name="oldpwd" class="form-control rounded-1" />
                    <br />
                    <label for="newpwd">Nouveau mot de passe</label>
                    <input type="password" id="newpwd" name="newpwd" class="form-control rounded-1" />
                    <br />
                    <label for="newpwdc">Confirmation</label>
                    <input type="password" id="newpwdc" name="newpwdc" class="form-control rounded-1" />
                    <br />
                    <?php if(isset($_SESSION['error']) && $_SESSION['error'] != null) echo "<div class=\"p-3 my-2 rounded-2 error\">" . $_SESSION['error'] . "</div>"; $_SESSION['error'] = null; ?>
                    <?php if(isset($_SESSION['success']) && $_SESSION['success'] == true) echo "<div class=\"p-3 my-2 rounded-2 success\">" . 'Votre mot de passe a bien été changé.' . "</div>"; $_SESSION['success'] = null;?>

                    <br />
                    <button type="submit" name="submit" class="btn small shadow-1 rounded-1 outline opening txt-blue lg" style="width: 20rem;"><span class="outline-text">Changer</span></button>
                </div>
            </form>
        </div>
        <?php include_once('../../generic/footer.php'); //Add FOOTER part to the code ?>
    </div>

    <!--     @End      #Content -->

    </body>

<?php } else { $_SESSION['error'] = 'Veuillez vous authentifier !'; header('Location: ../../index.php'); exit(); } ?>
