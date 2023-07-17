<?php
session_start();
include_once ('../../config/basic.php');

$group = array(
    $_POST['user'],
    $_POST['group'],
    $_POST['site'],
    $_POST['ug'],
    $_POST['subtask'],
    $_POST['task'],
    $_POST['project'],
    $_POST['commentary']
);

for($i = 0; $i <= sizeof($group)-1; $i++){
    if($group[$i] == 'on')
        $group[$i] = true;
    else
        $group[$i] = null;
}

try {

    $database = connection();

    $stmt = $database->prepare("INSERT INTO USERS_GROUPS VALUES (NULL,:wording,:user,:group,:site,:ug,:subtask,:task,:project,:commentary)");

    try{
        $stmt->execute(array(
            ':wording' => $_POST['name'],
            ':user' => $group[0],
            ':group' => $group[1],
            ':site' => $group[2],
            ':ug' => $group[3],
            ':subtask' => $group[4],
            ':task' => $group[5],
            ':project' => $group[6],
            ':commentary' => $group[7]
        ));

        $_SESSION['result2'] = "Le groupe a bien été ajouté.";

        header('Location: '. stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/gestion/groups.php');
        exit();
    } catch (PDOException $error) {
        die('Erreur : ' . $error->getCode() . ' - ' . $error->getMessage());
    }

} catch(PDOException $error) {
    die('Erreur : ' . $error->getCode() . ' - ' . $error->getMessage());
}