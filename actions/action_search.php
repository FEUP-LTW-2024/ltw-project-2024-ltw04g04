<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../database/item.class.php');

    $db = getDatabaseConnection();

    if (isset($_GET['query'])) {
        $search = $db->quote($_GET['query']);
        $search = trim($search, "'");
        $search = '%'.$search.'%';
        $results = Item::getItemWithName($db, $search);

        $query_string = http_build_query(['results' => $results]);
        header("Location: ../pages/search.php?" . $query_string); 
        exit();
    }
?>