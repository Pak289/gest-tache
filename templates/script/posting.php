<?php
session_start();
include_once ('../../config/basic.php');

$database = connection();
$stmt = $database->prepare("INSERT INTO COMMENTARY VALUES (NULL,:wording,null)");
$stmt->execute(array(
    ':wording' => $_POST['message']
));

$lastCommentary = $database->lastInsertId();

if (isset($_POST['p_task_id'])) {
    $task = unserialize($_SESSION[$_SESSION['p_task_id'].'task']);
    $user = unserialize($_SESSION['user']);
    $task->postMessage($database,$lastCommentary,$user);

    header('Location: '. stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/exploreTask.php');
    exit();
} else if (isset($_POST['p_project_id'])) {
    $user = unserialize($_SESSION['user']);
    $stmt = $database->prepare("INSERT INTO DATING VALUES (:project_id,NULL,:user,:commentary_id,:date,NULL)");

    date_default_timezone_set('Europe/Paris');
    $date = date('Y-m-d H:i:s',time());

    $stmt->execute(array(
        ':project_id' => $_POST['p_project_id'],
        ':user' => $user->getId(),
        ':commentary_id' => $lastCommentary,
        ':date' => $date
    ));

    header('Location: '. stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/explore.php');
    exit();
}