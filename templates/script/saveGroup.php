<?php
session_start();
include_once('../../config/basic.php');

$database = connection();

$stmt = $database->prepare("UPDATE USERS_GROUPS SET userPerms = :user, groupPerms = :group, sitePerms = :site, UGPerms = :ug, SubTaskPerms = :subTask, TaskPerms = :task, ProjectPerms = :project, CompanyPerms = :company, canWriteCommentary = :write WHERE id = :id");
$stmt->execute(array(
    ':user' => $_POST['user'],
    ':group' => $_POST['group'],
    ':site' => $_POST['site'],
    ':ug' => $_POST['ug'],
    ':subTask' => $_POST['subTask'],
    ':task' => $_POST['task'],
    ':project' => $_POST['project'],
    ':company' => $_POST['company'],
    ':write' => $_POST['write'],
    ':id' => $_POST['groupId']
));

header('Location: ' . stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/gestion/groups.php');
exit();
