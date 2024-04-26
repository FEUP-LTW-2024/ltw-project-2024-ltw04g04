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
            $error = 'Invalid email address.';
        } else if (User::emailExists($db, $email)) {
            $error = 'Email was already used.';
        } else if (User::usernameExists($db, $username)) {
            $error = 'Username was already used.';
        } else if (strlen($password) < 5) {
            $error = 'Password must be at least 5 characters long.';
        } else if ($password !== $reenterPassword) {
            $error = 'Passwords do not match.';
        } else {
            User::registerUser($db, $username, $name, $email, $password);
        }
    }


    if($error !== '') { 
        $_SESSION['error'] = $error;
        header("Location: ../pages/signup.php");
        exit();  
    } else {
        header("Location: ../pages/login.php");
        exit();  
    }
?>