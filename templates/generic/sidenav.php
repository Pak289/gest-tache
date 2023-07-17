<?php $activePage = basename($_SERVER['PHP_SELF'], ".php"); ?>

<div class="sidenav shadow-1 large fixed white">
    <a href="index.php" class="sidenav-link <?php if($activePage == 'index') echo 'active'; ?>">Accueil</a>
    <?php if($user->getGroup()->getProjectPerms() == true) { ?>
    <a href="projects.php" class="sidenav-link <?php if($activePage == 'projects') echo 'active'; ?>">Gestion des projets</a>
    <?php } ?>
    <?php if($user->getGroup()->getGroupPerms() == true) { ?>
    <a href="groups.php" class="sidenav-link <?php if($activePage == 'groups') echo 'active'; ?>">Gestion des groupes</a>
    <?php } ?>
    <?php if($user->getGroup()->getUserPerms() == true) { ?>
    <a href="users.php" class="sidenav-link <?php if($activePage == 'users') echo 'active'; ?>">Gestion des utilisateurs</a>
    <?php } ?>
    <?php if($user->getGroup()->getUGPerms() == true) { ?>
    <a href="ug.php" class="sidenav-link <?php if($activePage == 'ug') echo 'active'; ?>">Gestion des UG</a>
    <?php } ?>
    <?php if($user->getGroup()->getSitePerms() == true) { ?>
    <a href="sites.php" class="sidenav-link <?php if($activePage == 'sites') echo 'active'; ?>">Gestion des sites</a>
    <?php } ?>
    <?php if($user->getGroup()->getCompanyPerms() == true) { ?>
    <a href="company.php" class="sidenav-link <?php if($activePage == 'company') echo 'active'; ?>">Gestion des entreprises</a>
    <?php } ?>
</div>

<?php unset($activePage); ?>
