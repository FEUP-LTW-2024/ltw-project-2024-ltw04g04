<?php
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../utils/utils.php');

    if (isset($_GET['query'])) {
        $search = cleanInput($_GET['query']);

        $db = getDatabaseConnection();

        $query = "SELECT Name_ FROM ITEM WHERE Name_ LIKE ?"; 
        $stmt = $db->prepare($query);
        $stmt->execute([$search . '%']);
        $results = $stmt->fetchAll(PDO::FETCH_COLUMN);

        header('Content-Type: application/json');
        echo json_encode($results);
        exit();
    }
?>

