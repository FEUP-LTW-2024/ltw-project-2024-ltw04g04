<?php
    declare(strict_types=1);
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../database/item.class.php');
    require_once(__DIR__ . '/../utils/utils.php'); 

    $db = getDatabaseConnection();

    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        $filters = [];
        if (isset($_GET['category']) && $_GET['category'] !== '') {
            $filters['category'] = cleanInput($_GET['category']); 
        }
        if (isset($_GET['model']) && $_GET['model'] !== '') {
            $filters['model'] = cleanInput($_GET['model']); 
        }
        if (isset($_GET['brand']) && $_GET['brand'] !== '') {
            $filters['brand'] = cleanInput($_GET['brand']); 
        }
        if (isset($_GET['size']) && is_array($_GET['size']) && count($_GET['size']) > 0) {
            $sizes = [];
            foreach ($_GET['size'] as $size) {
                $sizes[] = cleanInput($size); 
            }
            $filters['size'] = $sizes;
        } 
            
        $filteredItems = Item::getFilteredItems($db, $filters);
        $query_string = http_build_query(['results' => $filteredItems]);
        header("Location: ../pages/search.php?" . $query_string); 
        exit;
    }
?>
