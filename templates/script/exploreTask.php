<?php
session_start();
include_once('../../config/basic.php');

    $_SESSION['p_task_id'] = $_POST['p_task_id'];

    header('Location: ' . stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/exploreTask.php');
    exit();
