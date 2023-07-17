<?php
session_start();
include_once('../../config/basic.php');

$database = connection();

$stmt = $database->prepare("UPDATE SITES SET name = :name, abreviation = :abv, ug_id = :ug_id WHERE id = :id");
$stmt->execute(array(
    ':name' => $_POST['name'],
    ':abv' => $_POST['abv'],
    ':ug_id' => $_POST['ug'],
    ':id' => $_POST['groupId']
));

header('Location: ' . stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/gestion/sites.php');
exit();
