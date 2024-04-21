<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  if (!$session->isLogin()) die(header('Location: /'));

  require_once(__DIR__ . '/../database/user.class.php');

  $db = getDatabaseConnection();

  $user = User::getUserWithId($db, $session->getUserId());


  if ($user) {
    $user->userName = $_POST['userName_'];
    $user->name = $_POST['name_'];
    $user->address = $_POST['address_'];
    $user->city = $_POST['city_'];
    $user->country = $_POST['country_'];
    $user->postalcode = $_POST['postal_code_'];
    
    $user->saveData($db);

    $session->setName($user->name());
  }

  header('Location: ../pages/user.php');
?>