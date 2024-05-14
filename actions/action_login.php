<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../utils/session.php');

    $session = new Session();
    $db = getDatabaseConnection();
    $error = '';
    
    if(isset($_POST['submit'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (User::emailExists($db, $email)) {
            $user = User::loginUser($db, $email, $password);
    
            if ($user !== null) {
                $session->setUserId($user->userId);
                $session->setUserEmail($user->email);
                $session->setUserName($user->name);
                $session->setUserUsername($user->username);
                $session->setPassword($user->password);
                $session->setIsAdmin($user->isAdmin);
            } else {
                $error = 'Invalid email or password';  
            }

        } else {
            $error = 'Email does not exist';
        }

    } else {
        $error = 'Login was not sucessfull, try again.'; 
    }


    if($error !== '') {
        $_SESSION['error'] = $error;
        header("Location: ../pages/login.php"); 
        exit(); 
    } else {
        header("Location: ../pages/account.php"); 
        exit();
    }
?>
