<?php
  declare(strict_types = 1);
  require_once(__DIR__ . '/../database/get_database.php');
  require_once(__DIR__ . '/../database/user.class.php');
  require_once(__DIR__ . '/../utils/session.php');

  $session = new Session();

  if ($_SESSION['csrf'] === $_POST['csrf']) {
    $db = getDatabaseConnection();
    $user = User::getUserWithId($db, $session->getUserId());

    if ($user) {
      $new_username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
      $new_name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
      $new_adress = htmlspecialchars($_POST['address'], ENT_QUOTES, 'UTF-8');
      $new_city = htmlspecialchars($_POST['city'], ENT_QUOTES, 'UTF-8');
      $new_country = htmlspecialchars($_POST['country'], ENT_QUOTES, 'UTF-8');
      $new_postalCode = htmlspecialchars($_POST['postal_code'], ENT_QUOTES, 'UTF-8');

      User::updateUser($db, $new_username, $new_name, $new_adress, $new_city, $new_country, $new_postalCode, $user->userId);

      $session->setUserName($user->name);
      $session->setUserUsername($user->username);
      $session->setAddress($user->address);
      $session->setCity($user->city);
      $session->setCountry($user->country);
      $session->setPostalCode($user->postalCode);

      if(isset($_FILES["profile_image"]) && $_FILES["profile_image"]["error"] == 0) {
        $imageDir = '../pages/imgs/imgsForProfile/';
        $targetFile = $imageDir . basename($_FILES["profile_image"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($imageFileType, $allowedExtensions)) {
          $uniqueFilename = uniqid() . '_' . $_FILES["profile_image"]["name"];
          $targetFile = $imageDir . $uniqueFilename;
          
          if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFile)) {
            $imagePath = '/' . $targetFile;
            User::updateUserProfileImage($db, $imagePath ,$user->userId);
          } 
        }
      }

    }
  }

  header('Location: ../pages/account.php');
  exit();
?>