<?php
require_once(__DIR__ . '/../database/get_database.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/utils.php');

session_start(); 

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['csrf_token'], $_SESSION['csrf'], $input['order_id']) && $input['csrf_token'] === $_SESSION['csrf']) {
        try {
            $orderId = (int)$input['order_id'];
            $pdo = getDatabaseConnection(); 
            $stmt = $pdo->prepare('DELETE FROM OrderItem WHERE OrderId = :orderId');
            $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
            $success = $stmt->execute();

            if ($success) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete order from the database']);
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>

