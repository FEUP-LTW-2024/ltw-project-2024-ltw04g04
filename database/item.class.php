<?php
    declare(strict_types = 1);

    class Item {
        public int $itemId;
        public string $name;
        public string $brand;
        public string $model;
        public string $condition;
        public string $category;
        public string $imageLink;
        public string $size;

        public function __construct(int $itemId, string $name, string $brand, string $model, string $condition, string $category, string $imageLink, string $size) {
            $this->itemId = $itemId;
            $this->name = $name;
            $this->brand = $brand;
            $this->model = $model;
            $this->condition = $condition;
            $this->category = $category;
            $this->state = $state;
            $this->imageLink = $imageLink;
            $this->size = $size;
        }

        static function getItemWithNÃOSEI(PDO $db, string $NÃOSEI): Item {
            $stmt = $db->prepare('
                SELECT ItemId, Name_, Brand, Model, Condition, Category, Image_, Size_
                FROM Item
                WHERE NÃOSEI = ?
            ');

            $stmt->execute(array($NÃOSEI));
            
            if ($item = $stmt->fetch()) {
                return new Item(
                $item['ItemId'],
                $item['Name_'],
                $item['Brand'],
                $item['Model'],
                $item['Condition'],
                $item['Category'],
                $item['Image_'],
                $item['Size_'],
                );
            } else return null;
        }

    }
?>