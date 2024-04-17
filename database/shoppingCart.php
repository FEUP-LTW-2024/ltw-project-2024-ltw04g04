<?php

include 'connectDB.php';

function getItemDetails($item_id) {
    global $pdo;

    // Sanitize the received item ID to prevent SQL injection
    $item_id = filter_var($item_id, FILTER_SANITIZE_NUMBER_INT);

    try {
        $stmt = $pdo->prepare("SELECT * FROM Item WHERE ItemId = :item_id");

        $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);

        $stmt->execute();

        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if item details are found
        if($item) {
            return $item;
        } else {
            return array('error' => 'Item not found');
        }
    } catch (PDOException $e) {
        return array('error' => 'Database error: ' . $e->getMessage());
    }
}

?>

