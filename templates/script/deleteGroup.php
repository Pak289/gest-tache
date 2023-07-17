<?php
session_start();
include_once ('../../config/basic.php');

try {

    $database = connection();

    $stmt = $database->prepare("DELETE FROM USERS_GROUPS WHERE id = :id");

    $stmt->execute(array(
        ':id'=>$_POST['groupId']
    ));

    if($stmt->rowCount() == 0)
        $_SESSION['result'] = "Une erreur est survenue. Veuillez consulter la documentation pour plus d'informations.";
    else
        $_SESSION['result'] = "Le groupe a bien été supprimé.";

    header('Location: '. stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/gestion/groups.php');
    exit();

} catch(PDOException $error) {
    die('Erreur : ' . $error->getCode() . ' - ' . $error->getMessage());
}