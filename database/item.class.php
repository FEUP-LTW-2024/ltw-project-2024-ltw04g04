<?php
    declare(strict_types = 1);

    class Item {
        public int $itemId;
        public string $name;
        public int $price;
        public string $brand;
        public string $model;
        public string $condition;
        public string $category;
        public int $stock;
        public string $imageLink;
        public int $size;

        public function __construct(int $itemId, string $name, int $price, string $brand, string $model, string $condition, string $category, int $stock, string $imageLink, int $size) {
            $this->itemId = $itemId;
            $this->name = $name;
            $this->price = $price;
            $this->brand = $brand;
            $this->model = $model;
            $this->condition = $condition;
            $this->category = $category;
            $this->stock = $stock;
            $this->imageLink = $imageLink;
            $this->size = $size;
        }

        static function getItemWithId(PDO $db, int $itemId): Item {
            $stmt = $db->prepare('
                SELECT ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_
                FROM Item
                WHERE ItemId = ?
            ');

            $stmt->execute(array($itemId));
            
            if ($item = $stmt->fetch()) {
                return new Item(
                $item['ItemId'],
                $item['Name_'],
                $item['Price'],
                $item['Brand'],
                $item['Model'],
                $item['Condition'],
                $item['Category'],
                $item['Stock'],
                $item['Image_'] ?? "",
                $item['Size_'],
                );
            } else return null;
        }


        static function getItemsWithName(PDO $db, string $itemName): array {
            $items = [];
            $stmt = $db->prepare('
                SELECT ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_
                FROM Item
                WHERE Name_ LIKE ?
            ');
            $stmt->execute(array($itemName));
            
            while ($item = $stmt->fetch()) {
                $items[] = new Item(
                    $item['ItemId'],
                    $item['Name_'],
                    $item['Price'],
                    $item['Brand'],
                    $item['Model'],
                    $item['Condition'],
                    $item['Category'],
                    $item['Stock'],
                    $item['Image_'] ?? "",
                    $item['Size_']
                );
            }
            return $items;
        }


        static function getItemsWithCategory(PDO $db, string $itemCategory): array {
            $items = [];
            $stmt = $db->prepare('
                SELECT ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_
                FROM Item
                WHERE Category = ?
            ');
            $stmt->execute(array($itemCategory));
            
            while ($item = $stmt->fetch()) {
                $items[] = new Item(
                    $item['ItemId'],
                    $item['Name_'],
                    $item['Price'],
                    $item['Brand'],
                    $item['Model'],
                    $item['Condition'],
                    $item['Category'],
                    $item['Stock'],
                    $item['Image_'] ?? "",
                    $item['Size_']
                );
            }
            return $items;
        }


        public function getItemDetails(int $item_id, PDO $pdo) {
            $item_id = filter_var($item_id, FILTER_SANITIZE_NUMBER_INT);

            try {
                $stmt = $pdo->prepare("SELECT * FROM Item WHERE ItemId = :item_id");

                $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);

                $stmt->execute();

                $item = $stmt->fetch(PDO::FETCH_ASSOC);

                if($item) {
                    return $item;
                } else {
                    return array('error' => 'Item not found');
                }
                
            } catch (PDOException $e) {
                return array('error' => 'Database error: ' . $e->getMessage());
            }
        }


        static function getFilteredItems(PDO $db, array $filters): array {
            $sql = 'SELECT * FROM Item WHERE 1';
            $params = [];
        
            if (isset($filters['brand']) && $filters['brand'] !== '') {
                $sql .= ' AND Brand = ?';
                $params[] = $filters['brand'];
            }
        
            if (isset($filters['model']) && $filters['model'] !== '') {
                $sql .= ' AND Model = ?';
                $params[] = $filters['model'];
            }
        
            if (isset($filters['category']) && $filters['category'] !== '') {
                $sql .= ' AND Category = ?';
                $params[] = $filters['category'];
            }
        
            if (isset($filters['size']) && is_array($filters['size']) && count($filters['size']) > 0) {
                $placeholders = implode(',', array_fill(0, count($filters['size']), '?'));
                $sql .= " AND Size_ IN ($placeholders)";
                $params = array_merge($params, $filters['size']);
            }
        
            $stmt = $db->prepare($sql);
            $stmt->execute($params);
        
            $items = [];
            while ($item = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $items[] = new Item(
                    $item['ItemId'],
                    $item['Name_'],
                    $item['Price'],
                    $item['Brand'],
                    $item['Model'],
                    $item['Condition'],
                    $item['Category'],
                    $item['Stock'],
                    $item['Image_'] ?? "",
                    $item['Size_']
                );
            }
            return $items;
        }


        static function getStockWithItemId(PDO $db, int $itemId): int {
            $stmt = $db->prepare('
                SELECT Stock
                FROM Item
                WHERE ItemId = ?
            ');

            $stmt->execute(array($itemId));
            
            if ($item = $stmt->fetch()) {
                return $item['Stock'];
            } else return null;
        }
        

        static function getNextItemId(PDO $db): int {
            $stmt = $db->query('SELECT MAX(ItemId) FROM Item');
            $maxId = $stmt->fetchColumn();
            return $maxId + 1;
        }


        static function getUserItemIds(PDO $pdo, int $userId): array {
            $stmt = $pdo->prepare('SELECT ItemId FROM SellerItem WHERE UserId = :userId');
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
            return $result ? $result : [];
        }


        static function updateStock(PDO $db, int $itemId, int $diffQuantity): void {
            $stmt = $db->prepare("UPDATE Item SET Stock = Stock - :diff_quantity WHERE ItemId = :item_id");
            $stmt->bindParam(':diff_quantity', $diffQuantity, PDO::PARAM_INT);
            $stmt->bindParam(':item_id', $itemId, PDO::PARAM_INT);
            $stmt->execute();
        }
    

        public function insertItemInDatabase(PDO $db, int $idItem, string $name, int $price, string $brand, string $model, string $condition, string $category, int $stock, string $imageLink, int $size): void {
            $stmt = $db->prepare('
                INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ');
            $stmt->execute([$idItem, $name, $price, $brand, $model, $condition, $category, $stock, $imageLink, $size]);
        }
    }

?>