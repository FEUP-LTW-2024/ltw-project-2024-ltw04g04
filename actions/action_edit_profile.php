<?php
  declare(strict_types = 1);
  include 'actions.php';

  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../database/user.class.php');

  $session = new Session();

  if (!$session->isLogin()) die(header('Location: /'));


  $db = getDatabaseConnection();

  $user = User::getUserWithId($db, $session->getUserId());


  if ($user) {
    $user->userName = $_POST['userName_'];
    $user->name = $_POST['name_'];
    $user->address = $_POST['address_'];
    $user->city = $_POST['city_'] ;
    $user->country = $_POST['country_'];
    $user->postalCode = $_POST['postal_code_'];
    
    $user->saveData($db);

    $session->setUserName($user->name);
    $session->setUserUserName($user->userName);
    $session->setAddress($user->address);
    $session->setCity($user->city);
    $session->setCountry($user->country);
    $session->setPostalCode($user->postalCode);

    
  }

  header('Location: ../pages/user.php');
?>