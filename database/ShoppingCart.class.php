<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../database/item.class.php');

    class shoppingCart {

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


        public static function getItemIdsInCart(PDO $db, int $userId): array {
            $stmt = $db->prepare('SELECT ShoppingCart.ItemId
                            FROM ShoppingCart 
                            WHERE ShoppingCart.BuyerId = :userId');
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $itemIds = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $itemIds[] = $row['ItemId'];
            }
            return $itemIds;
        }

        public static function manageCartItem($db, $buyerId, $item_id, $action)
        {
            try {
                switch($action) {
                    case 'add':
                        return self::addItemToCart($db, $buyerId, $item_id);
                        break;
                    
                    case 'decrease':
                        return self::decreaseItemFromCart($db,$buyerId, $item_id);
                        break;

                    case 'remove':
                        return self::removeItemFromCart($db,$buyerId, $item_id);
                        break;
                    
                    case 'total':
                        $subtotal = self::calculateCartTotal($db);
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

        
        static function addItemToCart($db, $buyerId, $item_id) {
            try {
                
                $stmt = $db->prepare("SELECT * FROM ShoppingCart WHERE ItemId = :item_id AND buyerId = :buyer_id");
                $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
                $stmt->bindParam(':buyer_id', $buyerId, PDO::PARAM_INT);
                $stmt->execute();
                $existing_item = $stmt->fetch(PDO::FETCH_ASSOC);

                $stock = Item::getStockWithItemId($db, $item_id);
        
                if ($existing_item) {
                    $quantity = $existing_item['Quantity'];
                    if ($quantity < $stock) {
                        $stmt = $db->prepare("UPDATE ShoppingCart SET Quantity = Quantity + 1 WHERE ItemId = :item_id AND buyerId = :buyer_id");
                        $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
                        $stmt->bindParam(':buyer_id', $buyerId, PDO::PARAM_INT);
                        $stmt->execute();
                    } else {
                        return array('error' => 'Stock limit reached for this item');
                    }
                } else {
                    $stmt = $db->prepare("INSERT INTO ShoppingCart (buyerId, ItemId, Quantity) VALUES (:buyer_id, :item_id, 1)");
                    $stmt->bindParam(':buyer_id', $buyerId, PDO::PARAM_INT);
                    $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
                    $stmt->execute();
                }
        
                return array('success' => 'Item added to cart successfully');
        
            } catch (PDOException $e) {
                return array('error' => 'Database error: ' . $e->getMessage());
            }
        }
        
        

        static function decreaseItemFromCart($db, $buyerId, $item_id) {
            try {
                $stmt = $db->prepare("SELECT Quantity FROM ShoppingCart WHERE ItemId = :item_id AND BuyerId = :buyer_id");
                $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
                $stmt->bindParam(':buyer_id', $buyerId, PDO::PARAM_INT);
                $stmt->execute();
                $quantity = $stmt->fetchColumn();
        
                if ($quantity > 1) {
                    $stmt = $db->prepare("UPDATE ShoppingCart SET Quantity = Quantity - 1 WHERE ItemId = :item_id AND BuyerId = :buyer_id");
                    $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
                    $stmt->bindParam(':buyer_id', $buyerId, PDO::PARAM_INT);
                    $stmt->execute();
                } else {
                    $stmt = $db->prepare("DELETE FROM ShoppingCart WHERE ItemId = :item_id AND BuyerId = :buyer_id");
                    $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
                    $stmt->bindParam(':buyer_id', $buyerId, PDO::PARAM_INT);
                    $stmt->execute();
                }
        
                return array('success' => 'Item removed from cart successfully');
        
            } catch (PDOException $e) {
                return array('error' => 'Database error: ' . $e->getMessage());
            }
        }
        

        static function removeItemFromCart($db, $buyerId, $item_id) {
            try {
                $stmt = $db->prepare("DELETE FROM ShoppingCart WHERE ItemId = :item_id AND BuyerId = :buyer_id");
                $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
                $stmt->bindParam(':buyer_id', $buyerId, PDO::PARAM_INT);
                $stmt->execute();
        
                return array('success' => 'Item removed from cart successfully');
        
            } catch (PDOException $e) {
                return array('error' => 'Database error: ' . $e->getMessage());
            }
        }
           

        static function calculateCartTotal(PDO $db, int $userId): float {
            try {
                $stmt = $db->prepare("
                    SELECT SUM(i.Price * sc.Quantity) AS total_price 
                    FROM ShoppingCart sc 
                    INNER JOIN Item i ON sc.ItemId = i.ItemId
                    WHERE buyerId = :buyerId
                ");
                $stmt->bindParam(':buyerId', $userId, PDO::PARAM_INT);
                $stmt->execute();
                $total = $stmt->fetchColumn();
                
                return (float)$total;
            } catch (PDOException $e) {
                return 0.0;
            }
        }

        static function getItemQuantityInCart(PDO $db, int $buyerId, int $itemId): int {
            try {
                $stmt = $db->prepare("SELECT Quantity FROM ShoppingCart WHERE buyerId = :buyerId AND ItemId = :itemId");
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

