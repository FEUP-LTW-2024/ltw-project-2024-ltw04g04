<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../utils/session.php');


function signUp(string $username, string $name, string $email, string $password, string $reenterPassword): string {
    $db = getDatabaseConnection();
    $error = ''; 

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // INVALID EMAIL
        $error = 'Invalid email address.';
    } else if (User::emailExists($db, $email)) {
        // EMAIL ALREADY USED
        $error = 'Email was already used.';
    } else if (User::usernameExists($db, $username)) {
        // USERNAME ALREADY USED
        $error = 'Username was already used.';
    } else if (strlen($password) < 5) {
        // INVALID PASSWORD - 5 chars min
        $error = 'Password must be at least 5 characters long.';
    } else if ($password !== $reenterPassword) {
        // INVALID REENTER PASSWORD
        $error = 'Passwords do not match.';
    } else {
        // VALID -> REGISTER
        User::registerUser($db, $username, $name, $email, $password);
    }

    return $error;
}


function login(Session $session, string $email, string $password): string {

    $db = getDatabaseConnection();
    $error = '';
  
    if (User::emailExists($db, $email)) {
        $user = User::loginUser($db, $email, $password);

        if ($user !== null) {

            $session->setUserId($user->userId);
            $session->setUserEmail($user->email);
            $session->setUserName($user->name);
            $session->setUserUserName($user->username);
            $session->setPassword($user->password);

            header("Location: user.php"); 
            exit();

        } else {
            $error = 'Invalid email or password';  
        }
    } else {
        $error = 'Email does not exist';
    }

    return $error;
}



/*
try {
        $db = getDatabaseConnection();
        //echo "Connecting to database successfull!";
    } catch (PDOException $e) {
        echo "Error connecting to database: " . $e->getMessage();
    }
    */
?>