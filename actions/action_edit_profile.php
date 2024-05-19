<?php
  declare(strict_types=1);
  require_once(__DIR__ . '/../database/get_database.php');
  require_once(__DIR__ . '/../database/user.class.php');
  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../utils/utils.php');

  $session = new Session();

  if ($_SESSION['csrf'] === $_POST['csrf']) {
      $db = getDatabaseConnection();
      $user = User::getUserWithId($db, $session->getUserId());

      if ($user) {
          $new_username = cleanInput($_POST['username']);
          $new_name = cleanInput($_POST['name']);
          $new_address = cleanInput($_POST['address']);
          $new_city = cleanInput($_POST['city']);
          $new_country = cleanInput($_POST['country']);
          $new_postalCode = cleanInput($_POST['postal_code']);

          User::updateUser($db, $new_username, $new_name, $new_address, $new_city, $new_country, $new_postalCode, $user->userId);

          $session->setUserName($new_name);
          $session->setUserUsername($new_username);
          $session->setAddress($new_address);
          $session->setCity($new_city);
          $session->setCountry($new_country);
          $session->setPostalCode($new_postalCode);
      }
  }

  header('Location: ../pages/account.php');
?>
