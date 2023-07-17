<?php
session_start();
include_once ('../../config/basic.php');


try {

    $database = connection();

    $email = strtolower($_POST['email']);

    $stmt = $database->prepare("SELECT * FROM USERS WHERE email = :email");

    $stmt->execute(array(
        ':email'=>$email
    ));

    if($stmt->rowCount() > 0)
    {
        $user = $stmt->fetch();

        if(password_verify($_POST['password'],$user[5]))
        {

            $stmt = $database->prepare("SELECT * FROM USERS_GROUPS WHERE id = :id");
            $stmt->execute(array(
                ':id'=>$user[6]
            ));

            $group = $stmt->fetch();

            $user = new stm_Client($user[0], $user[1], $user[2],$user[4], $user[6], $user[7], $group);
            $_SESSION['user'] = serialize($user);

            header('Location: ' . stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/pci.php');
            exit();
        } else {
            $_SESSION['error'] = 'Veuillez vérifier votre mot de passe.';

            header('Location: '. stm_Router::$URL . 'index.php');
            exit();
        }
    } else {
        $_SESSION['error'] = 'Veuillez vérifier votre email.';

        header('Location: '. stm_Router::$URL . 'index.php');
        exit();
    }
} catch(PDOException $error) {
    die('Erreur : ' . $error->getCode() . ' - ' . $error->getMessage());
}
