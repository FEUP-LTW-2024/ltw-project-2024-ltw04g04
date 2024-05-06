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

        static function manageWishListItem($pdo, $userId, $item_id, $action) {
            try {
                switch($action) {
                    case 'add-to-wishlist':
                        $response = self::addItemToList($pdo, $userId, $item_id);
                        break;
                    case 'remove-from-wishlist':
                        $response = self::removeItemFromList($pdo, $userId, $item_id);
                        break;
                    default:
                        $response = array('error' => 'Invalid action');
                        break;
                }
                return $response;
            } catch (PDOException $e) {
                return array('error' => 'Database error: ' . $e->getMessage());
            }
        }

        static function removeItemFromList($pdo, $userId, $item_id) {
            try {
                $stmt = $pdo->prepare("DELETE FROM WishList WHERE userId = :user_id AND ItemId = :item_id");
                $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
                $stmt->execute();
                return array('success' => 'Item removed from wishlist successfully');
            } catch (PDOException $e) {
                return array('error' => 'Database error: ' . $e->getMessage());
            }
        }

        
        static function addItemToList($pdo, $userId, $item_id) {
            try {
                $stmt = $pdo->prepare("SELECT * FROM WishList WHERE userId = :user_id AND ItemId = :item_id");
                $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
                $stmt->execute();
                $existing_item = $stmt->fetch(PDO::FETCH_ASSOC);
        
                if($existing_item) {
                    $stmt = $pdo->prepare("DELETE FROM WishList WHERE userId = :user_id AND ItemId = :item_id");
                    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                    $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
                    $stmt->execute();
                    return array('success' => 'Item removed from wishlist successfully');
                } else {
                    $stmt = $pdo->prepare("INSERT INTO WishList (userId, ItemId) VALUES (:user_id, :item_id)");
                    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                    $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
                    $stmt->execute();
                    return array('success' => 'Item added to wishlist successfully');
                }
        
            } catch (PDOException $e) {
                return array('error' => 'Database error: ' . $e->getMessage());
            }
        }          
        
    }

?>
