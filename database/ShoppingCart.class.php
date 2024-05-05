<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../database/get_database.php');

class ShoppingCart {

    public int $CartId;
    public int $buyerId;
    public int $itemId;
    public int $quantity;

    public function __construct(int $CartId, int $buyerId, int $itemId, int $quantity) {
        $this->CartId = $CartId;
        $this->buyerId = $buyerId;
        $this->itemId = $itemId;
        $this->quantity = $quantity;
    }

    // Function to handle actions on cart
    public static function manageCartItem($pdo, $item_id, $action)
    {
        try {
            switch($action) {
                
                case 'add':
                    return self::addItemToCart($pdo, $item_id);
                    break;

                case 'remove':
                    return self::removeItemFromCart($pdo, $item_id);
                    break;
                
                default:
                    return array('error' => 'Invalid action');
                    break;
            }
        } catch (PDOException $e) {
            return array('error' => 'Database error: ' . $e->getMessage());
        }

    }

    
    
    // Function to add an item to the shopping cart
    private static function addItemToCart($pdo, $item_id)
    {
        try {
            // Check if item already in cart
            $stmt = $pdo->prepare("SELECT * FROM ShoppingCart WHERE ItemId = :item_id");
            $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
            $stmt->execute();
            $existing_item = $stmt->fetch(PDO::FETCH_ASSOC);

            if($existing_item) {
                // increment quantity if already in cart
                $stmt = $pdo->prepare("UPDATE ShoppingCart SET Quantity = Quantity + 1 WHERE ItemId = :item_id");
                $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
                $stmt->execute();
            } else {
                // add with quantity of 1 if not in cart
                $stmt = $pdo->prepare("INSERT INTO ShoppingCart (ItemId, Quantity) VALUES (:item_id, 1)");
                $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
                $stmt->execute();
            }

            return array('success' => 'Item added to cart successfully');

        } catch (PDOException $e) {
            return array('error' => 'Database error: ' . $e->getMessage());
        }
    }


    // Function to remove an item from the shopping cart
    private static function removeItemFromCart($pdo, $item_id)
    {
        try {
            // Check if item is in cart
            $stmt = $pdo->prepare("SELECT * FROM ShoppingCart WHERE ItemId = :item_id");
            $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
            $stmt->execute();
            $existing_item = $stmt->fetch(PDO::FETCH_ASSOC);

            if($existing_item) {
                // decrement quantity if in cart
                $stmt = $pdo->prepare("UPDATE ShoppingCart SET Quantity = Quantity - 1 WHERE ItemId = :item_id");
                $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
                $stmt->execute();

                // remove from cart if quantity is 0
                $stmt = $pdo->prepare("DELETE FROM ShoppingCart WHERE ItemId = :item_id AND Quantity = 0");
                $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
                $stmt->execute();
            }

            return array('success' => 'Item removed from cart successfully');

        } catch (PDOException $e) {
            return array('error' => 'Database error: ' . $e->getMessage());
        }
    }

    // Function to calculate the total price of items in the shopping cart
    private function calculateCartTotal(PDO $pdo) {
        try {
            // Obrigado chatgpt
            $stmt = $pdo->query("SELECT SUM(i.Price * sc.Quantity) AS total_price 
                                FROM ShoppingCart sc 
                                INNER JOIN Item i ON sc.ItemId = i.ItemId");
            $total = $stmt->fetchColumn();

            $total = $total ? $total : 0;

            return $total;

        } catch (PDOException $e) {
            // Handle database errors
            return null;
        }
    }

}


if (isset($_POST['itemId']) and isset($_POST['action'])) {
    
    $itemId = $_POST['itemId'];
    $action = $_POST['action'];
    $pdo = getDatabaseConnection();
    
    $result = ShoppingCart::manageCartItem($pdo, $itemId, $action);
    
    echo json_encode($result);   
} 
else {   
    echo json_encode(array('error' => 'Invalid request'));
}

?>

