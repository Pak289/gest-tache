<?php
session_start();
include_once ('../../config/basic.php');

    $database = connection();

    $stmt = $database->prepare("UPDATE USERS set password = :password WHERE id = :id");
    $password = generatePassword();
    $stmt->execute(array(
        ':password' => $password[1],
        ':id' => $_POST['groupId']
    ));
    
        $_SESSION['result'] = "Changement de mot de passe effectué ! Son nouveau mot de passe est : " . $password[0];

        header('Location: '. stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/gestion/users.php');
        exit();


function generatePassword(): array
{
    $password = random_bytes(5);
    $password = bin2hex($password);

    $hash = password_hash($password, PASSWORD_BCRYPT);

    $array = array(
        $password,
        $hash
    );

    return $array;
}
