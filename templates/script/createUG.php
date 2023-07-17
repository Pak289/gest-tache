<?php
session_start();
include_once ('../../config/basic.php');

try {

    $database = connection();

    $stmt = $database->prepare("INSERT INTO UG VALUES (NULL,:wording,:abv,:type,:number,:street,:pc,:city,false)");

    try{
        $stmt->execute(array(
            ':wording' => $_POST['name'],
            ':abv' => $_POST['abv'],
            ':type' => $_POST['type'],
            ':number' => $_POST['number'],
            ':street' => $_POST['street'],
            ':pc' => $_POST['pc'],
            ':city' => $_POST['city']
        ));

        $_SESSION['result2'] = "L'UG a bien été ajouté.";

        header('Location: '. stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/gestion/ug.php');
        exit();
    } catch (PDOException $error) {
        die('Erreur : ' . $error->getCode() . ' - ' . $error->getMessage());
    }

} catch(PDOException $error) {
    die('Erreur : ' . $error->getCode() . ' - ' . $error->getMessage());
}
