<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../utils/session.php');

    $session = new Session();
    $db = getDatabaseConnection();
    $error = ''; 

    if(isset($_POST['submit'])) {
        $username = $_POST['username'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $reenterPassword = $_POST['reenter_password'];
    
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
    }


    if($error !== '') { 
        $_SESSION['error'] = $error;
        header("Location: ../pages/signup.php");
        exit();  
    } else {
        header("Location: ../pages/account.php");
        exit();  
    }
?>