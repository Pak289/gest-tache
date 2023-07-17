<header>
    <nav class="navbar shadow-1 background">
        <img class="logo sidenav-logo" src="<?php stm_Router::public('pictures/logo-crous-strasbourg.svg') ?>"
             alt="Logo"/>
        <p class="wording">Gestionnaire de Tâches Simplifiées</p>
        <div class="centered">
            <form class="search" method="POST" action="../script/search.php">
            <span style="position: relative; display: inline-block; direction: ltr;"><input
                        class="form-control rounded-4 shadow-1 white ds-input" style="background: #F2F7F2" type="text"
                        name="search"
                        id="search" placeholder="Rechercher..." autocomplete="off" spellcheck="false"
                        style="position: relative; vertical-align: top;"
                        formaction="../script/search.php">
            </form>
        </div>
        <div class="navbar-menu ml-auto">
            <a class="navbar-link" href="<?php echo stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/pti.php' ?>">Mes
                tâches</a>
            <a class="navbar-link" href="<?php echo stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/pci.php' ?>">Mes
                projets</a>
            <?php if ($user->getGroup()->getProjectPerms() || $user->getGroup()->getGroupPerms() || $user->getGroup()->getUserPerms() || $user->getGroup()->getUGPerms() || $user->getGroup()->getSitePerms() ||
                $user->getGroup()->getCompanyPerms()) { ?>

                <a class="navbar-link"
                   href="<?php echo stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/gestion/index.php' ?>">Gestionnaire</a>
            <?php } ?>
            <div class="dropdown" id="dropdown2" data-ax="dropdown">
                <div class="navbar-link dropdown-trigger">
                    Mon profil
                </div>
                <div class="dropdown-content right-aligned white shadow-1">
                    <p class="dropdown-item shadow-2" style="background: #313D5A; color: white;">
                        Bonjour <?php echo $user->getFirstname(); ?> !</p>
                    <a class="dropdown-item"
                       href="<?php echo stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/profil/profil.php' ?>">Mes
                        informations</a>
                    <a class="dropdown-item"
                       href="<?php echo stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/profil/changepwd.php' ?>">Changer
                        de mot de passe</a>
                    <a class="dropdown-item"
                       href="<?php echo stm_Router::$URL . stm_Router::$TEMPLATES . 'script/disconnect.php' ?>">Se
                        déconnecter</a>
                </div>
            </div>
        </div>
    </nav>
</header>
