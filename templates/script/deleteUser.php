<?php
session_start();
include_once ('../../config/basic.php');

try {

    $database = connection();

    $stmt = $database->prepare("DELETE FROM USERS WHERE id = :id");

    $stmt->execute(array(
        ':id'=>$_POST['groupId']
    ));

    if($stmt->rowCount() == 0)
        $_SESSION['result'] = "Une erreur est survenue. Veuillez consulter la documentation pour plus d'informations.";
    else
        $_SESSION['result'] = "L'utilisateur a bien été supprimé.";

    header('Location: '. stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/gestion/users.php');
    exit();

} catch(PDOException $error) {
    die('Erreur : ' . $error->getCode() . ' - ' . $error->getMessage());
}