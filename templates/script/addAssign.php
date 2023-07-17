<?php
session_start();
include_once('../../config/basic.php');

$database = connection();

$task = unserialize($_SESSION['task']);

if ($_POST['p_user_assign'] != null)
    $task->add_user_assign($database, $_POST['p_user_assign']);
else if ($_POST['p_observ_assign'] != null)
    $task->add_observ_assign($database, $_POST['p_observ_assign']);
else
    $task->add_days($database, $_POST['p_day']);

$_SESSION['task'] = serialize($task);

if ($_POST['p_day'] != null)
    header('Location: ' . stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/explore/nT5.php');
else
    header('Location: ' . stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/explore/nT2.php');

exit();
