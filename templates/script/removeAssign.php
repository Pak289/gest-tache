<?php
session_start();
include_once('../../config/basic.php');

$task = unserialize($_SESSION['task']);

if ($_POST['u_array_id'] != null)
    $task->rm_user_assign($_POST['u_array_id']);
else if ($_POST['o_array_id'] != null)
    $task->rm_observ_assign($_POST['o_array_id']);
else
    $task->rm_days($_POST['d_array_id']);


$_SESSION['task'] = serialize($task);

if ($_POST['d_array_id'] != null)
    header('Location: ' . stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/explore/nT5.php');
else
    header('Location: ' . stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/explore/nT2.php');

exit();
