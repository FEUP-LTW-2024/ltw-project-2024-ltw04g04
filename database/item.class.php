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
        public string $imageLink;
        public int $size;

        public function __construct(int $itemId, string $name, int $price, string $brand, string $model, string $condition, string $category, string $imageLink, int $size) {
            $this->itemId = $itemId;
            $this->name = $name;
            $this->price = $price;
            $this->brand = $brand;
            $this->model = $model;
            $this->condition = $condition;
            $this->category = $category;
            $this->state = $state;
            $this->imageLink = $imageLink;
            $this->size = $size;
        }

        static function getItemWithId(PDO $db, int $itemId): Item {
            $stmt = $db->prepare('
                SELECT ItemId, Name_, Price, Brand, Model, Condition, Category, Image_, Size_
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
                $item['Image_'] ?? "",
                $item['Size_'],
                );
            } else return null;
        }



        public function getItemDetails(int $item_id, PDO $pdo) {

            // Sanitize the received item ID to prevent SQL injection
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

    }
?>