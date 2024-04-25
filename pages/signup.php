<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');

    $session = new Session();
    $login = false;
    drawHeaderForm($login);
    
?>
