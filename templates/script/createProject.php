<?php
session_start();
include_once ('../../config/basic.php');

try {

    $database = connection();

    $stmt = $database->prepare("INSERT INTO PROJECTS VALUES (NULL,:name,:desc,:ug,:site,false)");

    if($_POST['ug'] == 'Aucun')
        $ug = NULL;
    else
        $ug = $_POST['ug'];

    if($_POST['site'] == 'Aucun')
        $site = NULL;
    else
        $site = $_POST['site'];

    try{
        $stmt->execute(array(
            ':name' => $_POST['name'],
            ':desc' => $_POST['desc'],
            ':ug' => $ug,
            ':site' => $site
        ));

        $_SESSION['result2'] = "Le projet a bien été ajouté.";

        header('Location: '. stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/gestion/projects.php');
        exit();
    } catch (PDOException $error) {
        die('Erreur : ' . $error->getCode() . ' - ' . $error->getMessage());
    }

} catch(PDOException $error) {
    die('Erreur : ' . $error->getCode() . ' - ' . $error->getMessage());
}
