<?php
session_start();
include_once '../../config/basic.php';

$user = unserialize($_SESSION['user']);

$database = connection()
    if($_POST['search'] != "") {
$stmt = $database->prepare("SELECT * FROM TASKS WHERE (title LIKE :text OR wording LIKE :text) AND visibility IS NULL");
$stmt->execute(array(
    ':text' => '%'.$_POST['search'].'%'
));
    }
    else {
$stmt = $database->prepare("SELECT * FROM TASKS WHERE visibility IS NULL");
$stmt->execute();
}

$_SESSION['search'] = $stmt->fetchAll(PDO::FETCH_BOTH);

header('Location: '. stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/search.php');
exit();
