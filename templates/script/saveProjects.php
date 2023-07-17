<?php
session_start();
include_once('../../config/basic.php');

$database = connection();

$stmt = $database->prepare("UPDATE PROJECTS SET title = :name, wording = :desc, ug_id = :ug_id, site_id = :site_id WHERE id = :id");
$stmt->execute(array(
    ':name' => $_POST['name'],
    ':desc' => $_POST['desc'],
    ':ug_id' => $_POST['ug'],
    ':site_id' => $_POST['site'],
    ':id' => $_POST['groupId']
));

header('Location: ' . stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/gestion/projects.php');
exit();
