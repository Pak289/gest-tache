<?php
include_once('./config/core/stm_Router.php');
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Simplified Task Manager 0.1.0</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="<?php stm_Router::public('css/axentix.css') ?>">
    <script src="https://cdn.jsdelivr.net/npm/axentix@1.0.0/dist/js/axentix.min.js"></script>
    <style>
        .logo {
            height: 80%;
            background-color: white;
            border-radius: 50%;
        }

        .background {
            background-color: #4F6D7A;
            color: white;
        }

        #profil-title {
            margin-left: 1rem;
        }
    </style>
</head>

<body class="layout" style="background: #EAEAEA;">
<header>
    <nav class="navbar shadow-1 background">
        <img class="logo sidenav-logo" src="<?php stm_Router::public('pictures/logo-crous-strasbourg.svg') ?>"
             alt="Logo"/>
        <p id="profil-title">Gestionnaire de Tâches Simplifiées</p>
    </nav>
</header>

<!-- Content -->

<div class="card shadow-1 rounded-3 hoverable-1 vself-center self-center vcenter"
     style="width: 25rem; background: white;">
    <div class="card-header">S'authentifier</div>
    <div class="divider"></div>
    <div class="card-content">
        <form action="./templates/script/connection.php" method="POST">
            <div class="form-field" style="width: 20rem;">
                <label for="email">Adresse mail</label>
                <input type="email" id="email" name="email" class="form-control rounded-1"
                       placeholder="exemple@crous-strasbourg.fr"/>
                <br/>
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" class="form-control rounded-1"/>
                <br/>
                <?php if (isset($_SESSION['error']) && $_SESSION['error'] != null) echo "<div class=\"p-3 my-2 rounded-2 error\">" . $_SESSION['error'] . "</div>"; ?>
                <br/>
                <button type="submit" name="submit" class="btn small shadow-1 rounded-1 outline opening txt-blue lg"
                        style="width: 20rem;"><span class="outline-text">Connexion</span></button>
            </div>
        </form>
    </div>
    <footer class="footer fx-center background">
        0.1.0 - Crous Strasbourg © 2020
    </footer>
</div>

<!-- End -->

</body>

<? if (isset($_SESSION['error'])) $_SESSION['error'] = null; ?>
