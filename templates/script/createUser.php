<?php
session_start();
include_once ('../../config/basic.php');

try {

    $database = connection();

    $stmt = $database->prepare("INSERT INTO USERS VALUES (NULL,:name,:firstname, :ini, :email,:password,:group,:ug)");

    $password = generatePassword();

    if($_POST['ug'] == 'Aucun')
        $ug = 0;
    else
        $ug = $_POST['ug'];

    try{
        $stmt->execute(array(
            ':name' => $_POST['name'],
            ':firstname' => $_POST['firstname'],
            ':ini' => $_POST['ini'],
            ':email' => $_POST['email'],
            ':group' => $_POST['group'],
            ':password' => $password[1],
            ':ug' => $ug
        ));

        $_SESSION['result'] = "L'utilisateur a bien été ajouté. Son mot de passe est : " . $password[0];
        sendPassword($_POST['email'],$password);

        header('Location: '. stm_Router::$URL . stm_Router::$TEMPLATES . 'pages/gestion/users.php');
        exit();
    } catch (PDOException $error) {
        die('Erreur : ' . $error->getCode() . ' - ' . $error->getMessage());
    }

} catch(PDOException $error) {
    die('Erreur : ' . $error->getCode() . ' - ' . $error->getMessage());
}


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

function sendPassword($email, $password)
{
    $to = $email;
    $subject = 'Votre mot de passe STM';
    $message = 'Votre mot de passe STM est : ' . $password[0];
    $headers = 'From : noreply-stm@crous-strasbourg.fr';

    mail($to, $subject, $message, $headers);
}

