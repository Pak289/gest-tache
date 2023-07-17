<?php
session_start();
include_once ('../../config/basic.php');

try {

    $database = connection();

    $stmt = $database->prepare("INSERT INTO SITES VALUES (NULL,:wording,:abv,:number,:street,:pc,:city,:ug,false)");

    try{
        $stmt->execute(array(
            ':wording' => $_POST['name'],
            ':abv' => $_POST['abv'],
            ':number' => $_POST['number'],
            ':street' => $_POST['street'],
            ':pc' => $_POST['pc'],
            ':city' => $_POST['city'],
            ':ug' => $_POST['ug']
        ));

        $_SESSION['result2'] = "Le site a bien été ajouté.";

        header('Location: '. stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/gestion/sites.php');
        exit();
    } catch (PDOException $error) {
        die('Erreur : ' . $error->getCode() . ' - ' . $error->getMessage());
    }

} catch(PDOException $error) {
    die('Erreur : ' . $error->getCode() . ' - ' . $error->getMessage());
}
