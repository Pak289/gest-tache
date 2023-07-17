<?php
session_start();
include_once ('../../config/basic.php');


try {

    $database = connection();

    $stmt = $database->prepare("SELECT password FROM USERS WHERE id = :id");

    $user = unserialize($_SESSION['user']);

    $stmt->execute(array(
        ":id"=>$user->getId()
    ));

    if($stmt->rowCount() > 0)
    {
        $stmt = $stmt->fetch();

        if(password_verify($_POST['oldpwd'],$stmt[0])) {
            if($_POST['newpwd'] == $_POST['newpwdc'] && $_POST['newpwd'] != null && $_POST['newpwdc'] != null) {
                try {
                    $stmt = $database->prepare("UPDATE USERS SET password = :password WHERE id = :id");

                    $stmt->execute(array(
                        ':id'=>$user->getId(),
                        ':password'=>password_hash($_POST['newpwd'],PASSWORD_BCRYPT)
                    ));

                    $_SESSION['success'] = true;

                    header('Location: ' . stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/profil/changepwd.php');
                    exit();

                } catch (PDOException $error){
                    die('Erreur : ' . $error->getCode() . ' - ' . $error->getMessage());
                }
            } else {
                $_SESSION['error'] = 'Veuillez vérifier votre nouveau couple mot de passe.';

                header('Location: ' . stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/profil/changepwd.php');
                exit();
            }
        } else {
            $_SESSION['error'] = 'Veuillez vérifier votre ancien mot de passe.';

            header('Location: ' . stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/profil/changepwd.php');
            exit();
        }
    }
} catch (PDOException $error) {
    die('Erreur : ' . $error->getCode() . ' - ' . $error->getMessage());
}