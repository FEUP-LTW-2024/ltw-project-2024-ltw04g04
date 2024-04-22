<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../utils/session.php');

    $db = getDatabaseConnection();
    $error = ''; 

    // string $username, string $name, string $email, string $password, string $reenterPassword -----------

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
?>