<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../templates/filter.tpl.php');
    drawFilter();

    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        $filters = [];
        if (isset($_GET['category']) && $_GET['category'] !== '') {
            $filters['category'] = $_GET['category'];
        }
        if (isset($_GET['model']) && $_GET['model'] !== '') {
            $filters['model'] = $_GET['model'];
        }
        if (isset($_GET['brand']) && $_GET['brand'] !== '') {
            $filters['brand'] = $_GET['brand'];
        }
        if (isset($_GET['size']) && is_array($_GET['size']) && count($_GET['size']) > 0) {
            $filters['size'] = $_GET['size'];
        }

        if (!empty($filters)) {
            $filteredItems = Item::getFilteredItems($pdo, $filters);
        }
    }
?>

