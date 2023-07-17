<?php
session_start();
include_once('../../config/basic.php');

$database = connection();

$task = unserialize($_SESSION[$_POST['p_task_id'].'task']);

$task->archiveTask($database);

unset($_SESSION[$_POST['p_task_id'].'task']);

header('Location: ' . stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/explore.php');
exit();
