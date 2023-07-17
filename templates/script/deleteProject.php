<?php
session_start();
include_once ('../../config/basic.php');

try {

    $database = connection();

    $stmt = $database->prepare("UPDATE PROJECTS SET visibility = true WHERE id = :id");

    $stmt->execute(array(
        ':id'=>$_POST['groupId']
    ));

    if($stmt->rowCount() == 0)
        $_SESSION['result'] = "Une erreur est survenue. Veuillez consulter la documentation pour plus d'informations.";
    else
        $_SESSION['result'] = "Le projet a bien été supprimé.";

    header('Location: '. stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/gestion/projects.php');
    exit();

} catch(PDOException $error) {
    die('Erreur : ' . $error->getCode() . ' - ' . $error->getMessage());
}
