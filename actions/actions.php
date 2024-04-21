<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../utils/session.php');

function getDatabaseConnection() : PDO {
    $db = new PDO('sqlite:' . __DIR__ . '/../database/database.db');
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $db;
}


function signUp(string $userName, string $name, string $email, string $password, string $reenterPassword): string {
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
        User::registerUser($db, $userName, $name, $email, $password);
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
            $session->setUserUserName($user->userName);
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



function getCategories() : array {
    $db = getDatabaseConnection();

    /* Query para obter as categorias da base de dados */
    $stmt = $db->query('SELECT CategoryName FROM Category');
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $categories;
}

function getSizes() : array {
    $db = getDatabaseConnection();

    /* Query para obter todos os tamanhos*/
    $stmt = $db->query('SELECT DISTINCT Size_ FROM Item');
    $sizes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $sizes;
}

function getBrands() : array {
    $db = getDatabaseConnection();

    /* Query para obter todos os tamanhos*/
    $stmt = $db->query('SELECT DISTINCT Brand FROM Item');
    $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $brands;
}

function getModels() : array {
    $db = getDatabaseConnection();

    /* Query para obter todos os tamanhos*/
    $stmt = $db->query('SELECT DISTINCT Model FROM Item');
    $models = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $models;
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