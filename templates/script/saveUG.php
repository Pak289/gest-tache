<?php
session_start();
include_once('../../config/basic.php');

$database = connection();

$stmt = $database->prepare("UPDATE UG SET name = :name, abreviation = :abv, type = :type  WHERE id = :id");
$stmt->execute(array(
    ':name' => $_POST['name'],
    ':abv' => $_POST['abv'],
    ':type' => $_POST['type'],
    ':id' => $_POST['groupId']
));

header('Location: ' . stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/gestion/ug.php');
exit();
