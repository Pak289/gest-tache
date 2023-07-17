<?php
session_start();
include_once('../../config/basic.php');

$database = connection();

$task = unserialize($_SESSION[$_POST['p_task_id'].'task']);

$task->set_priority_id($_POST['p_priority']);
$task->set_state_id($_POST['p_state']);
$task->set_localisation($_POST['loca']);
$task->set_company_id($_POST['etp']);
$task->modifyStatePriority($database);

$_SESSION[$_POST['p_task_id'].'task'] = serialize($task);

header('Location: ' . stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/exploreTask.php');
exit();
