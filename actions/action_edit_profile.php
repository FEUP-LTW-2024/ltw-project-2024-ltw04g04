<?php
  declare(strict_types = 1);
  require_once(__DIR__ . '/../database/get_database.php');
  require_once(__DIR__ . '/../database/user.class.php');
  require_once(__DIR__ . '/../utils/session.php');

  $session = new Session();
  $db = getDatabaseConnection();
  $user = User::getUserWithId($db, $session->getUserId());

  if ($user) {
    $new_username = $_POST['username'];
    $new_name = $_POST['name'];
    $new_adress = $_POST['address'];
    $new_city = $_POST['city'] ;
    $new_country = $_POST['country'];
    $new_postalCode = $_POST['postal_code'];
    
    User::upgradeUser($db, $new_username, $new_name, $new_adress, $new_city, $new_country, $new_postalCode, $user->userId);

    $session->setUserName($user->name);
    $session->setUserUsername($user->username);
    $session->setAddress($user->address);
    $session->setCity($user->city);
    $session->setCountry($user->country);
    $session->setPostalCode($user->postalCode);
  }

  header('Location: ../pages/account.php');
?>