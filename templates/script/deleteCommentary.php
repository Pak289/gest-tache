<?php
session_start();
include_once('../../config/basic.php');

$database = connection();

if(isset($_POST['p_commentary_id'])) {
    delete($database,$_POST['p_commentary_id']);
    header('Location: ' . stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/explore.php');
    exit();
} else {
    delete($database,$_POST['t_commentary_id']);
    header('Location: ' . stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/exploreTask.php');
    exit();
}

function delete($database,$id) {
    $stmt = $database->prepare("DELETE FROM DATING WHERE commentary_id = :id");
    $stmt->execute(array(
        ':id' => $id
    ));

    $stmt = $database->prepare("DELETE FROM COMMENTARY WHERE id = :id");
    $stmt->execute(array(
        ':id' => $id
    ));
}