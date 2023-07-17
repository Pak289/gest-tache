<?php
session_start();
include_once ('../../config/basic.php');

try {

    $database = connection();

    $stmt = $database->prepare("INSERT INTO COMPANY VALUES (NULL,:name,:number,:street,:pc,:city)");

    try{
        $stmt->execute(array(
            ':name' => $_POST['name'],
            ':number' => $_POST['number'],
            ':street' => $_POST['street'],
            ':pc' => $_POST['pc'],
            ':city' => $_POST['city']
        ));

        $_SESSION['result'] = "L'entreprise a bien été ajouté.";

        header('Location: '. stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/gestion/company.php');
        exit();
    } catch (PDOException $error) {
        die('Erreur : ' . $error->getCode() . ' - ' . $error->getMessage());
    }

} catch(PDOException $error) {
    die('Erreur : ' . $error->getCode() . ' - ' . $error->getMessage());
}
