<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../database/get_database.php');

    class WishList {

        public int $listId;
        public int $userId;
        public int $itemId;

        public function __construct(int $listId, int $userId, int $itemId) {
            $this->listId = $listId;
            $this->userId = $userId;
            $this->itemId = $itemId;
        }


        static function removeItemFromList($pdo, $userId, $itemId) {
            try {
                $stmt = $pdo->prepare("DELETE FROM WishList WHERE BuyerId = :userId AND ItemId = :itemId");
                $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
                $stmt->bindParam(':itemId', $itemId, PDO::PARAM_INT); 
                $stmt->execute();
                return array('success' => 'Item removed from wishlist successfully');
            } catch (PDOException $e) {
                return array('error' => 'Database error: ' . $e->getMessage());
            }
        }

        
        static function addItemToList($pdo, $userId, $itemId) {
            try {
                $stmt = $pdo->prepare("SELECT MAX(WishListId) + 1 AS nextId FROM WishList");
                $stmt->execute();
                $nextId = $stmt->fetch(PDO::FETCH_ASSOC)['nextId'];
        
                if ($nextId === null) {
                    $nextId = 1;
                }
        
                $stmt = $pdo->prepare("INSERT INTO WishList (WishListId, BuyerId, ItemId) VALUES (:wishlist_id, :userId, :itemId)");
                $stmt->bindParam(':wishlist_id', $nextId, PDO::PARAM_INT);
                $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
                $stmt->bindParam(':itemId', $itemId, PDO::PARAM_INT);
                $stmt->execute();
        
                return array('success' => 'Item added to wishlist successfully');
            } catch (PDOException $e) {
                return array('error' => 'Database error: ' . $e->getMessage());
            }
        }

        static function isItemInWishList($pdo, $userId, $itemId) {
            try {
                $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM WishList WHERE BuyerId = :userId AND ItemId = :itemId");
                $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
                $stmt->bindParam(':itemId', $itemId, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $count = intval($result['count']);
                
                return $count > 0;
            } catch (PDOException $e) {
                return array('error' => 'Database error: ' . $e->getMessage());
            }
        }
         
    }

?>

