<?php
    declare(strict_types=1);
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../utils/utils.php');

    $session = new Session();
    $db = getDatabaseConnection();
    $error = '';

    if (isset($_POST['submit']) && ($_SESSION['csrf'] === $_POST['csrf'])) {
        $email = cleanInput($_POST['email']); 
        $password = cleanInput($_POST['password']); 

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Invalid email address.';
        } else {
            if (User::emailExists($db, $email)) {
                $user = User::loginUser($db, $email, $password);

                if ($user !== null) {
                    if (password_verify($password, $user->password)) { 
                        $session->setUserId($user->userId);
                        $session->setUserEmail($user->email);
                        $session->setUserName($user->name);
                        $session->setUserUsername($user->username);
                        $session->setIsAdmin($user->isAdmin);
                    } else {
                        $error = 'Invalid email or password';
                    }
                } else {
                    $error = 'Invalid email or password';
                }
            } else {
                $error = 'Email does not exist';
            }
        }
    } else {
        $error = 'Login was not successful, try again.';
    }

    if ($error !== '') {
        $_SESSION['error'] = $error;
        header("Location: ../pages/login.php");
        exit();
    } else {
        header("Location: ../pages/account.php");
        exit();
    }
?>


