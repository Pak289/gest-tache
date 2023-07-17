<?php
session_start();
include_once('../../config/basic.php');

$database = connection();

$stmt = $database->prepare("UPDATE USERS SET name = :name, firstname = :firstname, ini = :abv, email = :email, group_id = :group_id, ug_id = :ug_id WHERE id = :id");
$stmt->execute(array(
    ':name' => $_POST['name'],
    ':firstname' => $_POST['firstname'],
    ':abv' => $_POST['abv'],
    ':email' => $_POST['email'],
    ':group_id' => $_POST['pgroup'],
    ':ug_id' => $_POST['pug'],
    ':id' => $_POST['groupId']
));
    
header('Location: ' . stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/gestion/users.php');
exit();
