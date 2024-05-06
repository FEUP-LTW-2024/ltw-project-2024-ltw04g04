<?php 
declare(strict_types = 1);
require_once(__DIR__ . '/../database/get_database.php');
require_once(__DIR__ . '/../database/item.class.php'); // movi o require antes de chamar a função drawFilter
require_once(__DIR__ . '/../templates/filter.tpl.php');

drawFilter();
?>