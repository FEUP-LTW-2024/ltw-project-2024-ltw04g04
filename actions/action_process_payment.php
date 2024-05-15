<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $session = new Session();
    $db = getDatabaseConnection();

    if ($_SESSION['csrf'] === $_POST['csrf']) {
        $address = $_POST['adress'];
        $city = $_POST['city'];
        $country = $_POST['country'];
        $postalCode = $_POST['postal-code'];
        if ($adress === "" || $city === "" || $country === "" || $postalCode === "") {
            $adressInfo = User::getAdressInfo($db, $session->getUserId());
            $address = $adressInfo[0];
            $city = $adressInfo[1];
            $country = $adressInfo[2];
            $postalCode = $adressInfo[3];
        }
        $cardNumber = $_POST['card-number'];
        $expirationDate = $_POST['expiration-date'];
        $cvv = $_POST['cvv'];
    }
?>