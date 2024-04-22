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
    //echo $user->name;
    //echo $_POST['name'];
    
    $new_username = $_POST['username'];
    $new_name = $_POST['name'];
    $new_adress = $_POST['address'];
    $new_city = $_POST['city'] ;
    $new_country = $_POST['country'];
    $new_postalCode = $_POST['postal_code'];
    

    
    User::saveData($db, $new_username, $new_name, $new_adress, $new_city, $new_country, $new_postalCode, $user->userId);

    //echo $user->name;

    $session->setUserName($user->name);
    $session->setUserUserName($user->username);
    $session->setAddress($user->address);
    $session->setCity($user->city);
    $session->setCountry($user->country);
    $session->setPostalCode($user->postalCode);

   

  }

  header('Location: ../pages/user.php');
?>
<!DOCTYPE html>
<html>
<main>

</main>
</html>
