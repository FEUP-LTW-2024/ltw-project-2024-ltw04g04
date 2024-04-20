<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../database/user.class.php');
  session_start();

  if (!$session->isLoggedIn()) die(header('Location: /'));

  $db = getDatabaseConnection();

  $id = isset($_SESSION['id']) ? $_SESSION['id'] : null; 
  $name = $session->getId();
  $email = $session->getUserEmail();
  $password;
  $address;
  $city;
  $country;
  $postalCode

  $user = User::getCustomer($db, $session->getId());

  if ($user) {
    $user->userId = $_POST['first_name'];
    $customer->lastName = $_POST['last_name'];
    
    $customer->save($db);

    $session->setName($customer->name());
  }

  header('Location: ../pages/profile.php');
?>