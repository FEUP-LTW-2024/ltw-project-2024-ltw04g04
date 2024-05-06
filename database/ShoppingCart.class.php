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

        public static function manageCartItem($pdo, $buyerId, $item_id, $action)
        {
            try {
                switch($action) {
                    case 'add':
                        return self::addItemToCart($pdo, $buyerId, $item_id);
                        break;

                    case 'remove':
                        return self::removeItemFromCart($pdo, $item_id);
                        break;
                    
                    case 'total':
                        $subtotal = self::calculateCartTotal($pdo);
                        return array('success' => true, 'subtotal' => $subtotal);
                        break;
                    
                    default:
                        return array('error' => 'Invalid action');
                        break;
                }
            } catch (PDOException $e) {
                return array('error' => 'Database error: ' . $e->getMessage());
            }

        }

        
        static function addItemToCart($pdo, $buyerId, $item_id) {
            try {
                $stmt = $pdo->prepare("SELECT * FROM ShoppingCart WHERE ItemId = :item_id");
                $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
                $stmt->execute();
                $existing_item = $stmt->fetch(PDO::FETCH_ASSOC);
        
                if($existing_item) {
                    $stmt = $pdo->prepare("UPDATE ShoppingCart SET Quantity = Quantity + 1 WHERE ItemId = :item_id");
                    $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
                    $stmt->execute();
                } else {
                    $stmt = $pdo->prepare("INSERT INTO ShoppingCart (buyerId, ItemId, Quantity) VALUES (:buyer_id, :item_id, 1)");
                    $stmt->bindParam(':buyer_id', $buyerId, PDO::PARAM_INT);
                    $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
                    $stmt->execute();
                }
        
                return array('success' => 'Item added to cart successfully');
        
            } catch (PDOException $e) {
                return array('error' => 'Database error: ' . $e->getMessage());
            }
        }
        

        static function removeItemFromCart($pdo, $item_id) {
            try {
                $stmt = $pdo->prepare("SELECT Quantity FROM ShoppingCart WHERE ItemId = :item_id");
                $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
                $stmt->execute();
                $quantity = $stmt->fetchColumn();
        
                if($quantity > 1) {
                    $stmt = $pdo->prepare("UPDATE ShoppingCart SET Quantity = Quantity - 1 WHERE ItemId = :item_id");
                    $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
                    $stmt->execute();
                } else {
                    $stmt = $pdo->prepare("DELETE FROM ShoppingCart WHERE ItemId = :item_id");
                    $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
                    $stmt->execute();
                }
        
                return array('success' => 'Item removed from cart successfully');
        
            } catch (PDOException $e) {
                return array('error' => 'Database error: ' . $e->getMessage());
            }
        }        

        static function calculateCartTotal(PDO $pdo): float {
            try {
                $stmt = $pdo->prepare("SELECT SUM(i.Price * sc.Quantity) AS total_price 
                                        FROM ShoppingCart sc 
                                        INNER JOIN Item i ON sc.ItemId = i.ItemId");
                $stmt->execute();
                $total = $stmt->fetchColumn();
                
                return (float)$total;
            } catch (PDOException $e) {
                return 0.0;
            }
        }

        static function getItemQuantityInCart(PDO $pdo, int $buyerId, int $itemId): int {
            try {
                $stmt = $pdo->prepare("SELECT Quantity FROM ShoppingCart WHERE buyerId = :buyerId AND ItemId = :itemId");
                $stmt->bindParam(':buyerId', $buyerId, PDO::PARAM_INT);
                $stmt->bindParam(':itemId', $itemId, PDO::PARAM_INT);
                $stmt->execute();
                $quantity = $stmt->fetchColumn();
                
                return $quantity ? (int)$quantity : 0;
            } catch (PDOException $e) {
                return 0;
            }
        }
        
        
    }

?>

