<?php
    declare(strict_types=1);
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../database/item.class.php');
    require_once(__DIR__ . '/../utils/utils.php'); 

    $db = getDatabaseConnection();

    if (isset($_GET['query'])) {
        $search = cleanInput($_GET['query']);
        $search = '%' . $search . '%'; 
        $results = Item::getItemsWithName($db, $search);

        $query_string = http_build_query(['results' => $results]);
        header("Location: ../pages/search.php?" . $query_string);
        exit();
    }
?>
