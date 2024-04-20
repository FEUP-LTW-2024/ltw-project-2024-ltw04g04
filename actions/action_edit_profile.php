<?php
  declare(strict_types = 1);

  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  if (!$session->isLoggedIn()) die(header('Location: /'));

  require_once(__DIR__ . '/../database/user.class.php');


  $db = getDatabaseConnection();

  $user = User::getUserWithId($db, $session->getId());


  if ($user) {
    $user->userName = $_POST['userName'];
    $user->name = $_POST['name'];
    $user->address = $_POST['address'];
    $user->city = $_POST['city'];
    $user->country = $_POST['country'];
    $user->postalcode = $_POST['postal_code'];
    
    $user->saveData($db);

    $session->setName($user->name());
  }

  header('Location: ../pages/user.php');
?>