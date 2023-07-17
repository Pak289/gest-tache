<?php
session_start();
include_once('../../config/basic.php');

try {

    $database = connection();

    $task = unserialize($_SESSION['task']);

    $task->sendTask($database);

    unset($task);
    unset($_SESSION['task']);

    header('Location: ' . stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/explore.php');
    exit();
} catch (PDOException $error) {
    die('Erreur : ' . $error->getCode() . ' - ' . $error->getMessage());
}