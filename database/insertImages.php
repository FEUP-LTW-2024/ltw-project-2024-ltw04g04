<?php 
declare(strict_types = 1);
require_once(__DIR__ . '/../database/get_database.php');

function insertItemWithImage(PDO $pdo, $itemId, $name, $price, $brand, $model, $condition, $category, $imagePath, $stock, $size) {

    $imageData = file_get_contents($imagePath);
    
    $stmt = $pdo->prepare("INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
                           VALUES (:itemId, :name, :price, :brand, :model, :condition, :category, :stock, :image, :size)");


    $stmt->bindParam(':itemId', $itemId);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':brand', $brand);
    $stmt->bindParam(':model', $model);
    $stmt->bindParam(':condition', $condition);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':stock', $stock);
    $stmt->bindParam(':image', $imageData, PDO::PARAM_LOB); // Use PDO::PARAM_LOB for BLOB data
    $stmt->bindParam(':size', $size);

    $stmt->execute();
}

$pdo = getDatabaseConnection();

insertItemWithImage($pdo, 101, 'Sapphire Bracelet', 29, 'Blue Jewelers', 'SB2024', 'New', 'Beads and bracelets', 1, '/pages/imgs/itemId1', 7);
insertItemWithImage($pdo, 102, 'Emerald Earrings', 5, 'Green Gems', 'EE2024', 'Used', 'Earrings', 3, '/pages/imgs/itemId2', 8);
insertItemWithImage($pdo, 103, 'Amethyst Ring', 25, 'Purple Jewelry', 'AR2024', 'New', 'Rings', 2, '/pages/imgs/itemId3', 9);
insertItemWithImage($pdo, 104, 'Topaz Necklace', 30, 'Golden Treasures', 'TN2024', 'Used', 'Necklaces', 5, '/pages/imgs/itemId4', 10);
insertItemWithImage($pdo, 105, 'Diamond Necklace', 500, 'Diamonds Inc.', 'DN2024', 'New', 'Necklaces', 10, '/pages/imgs/itemId5', 1);
insertItemWithImage($pdo, 106, 'Gold Bracelet', 350, 'Gold Empire', 'GB2024', 'New', 'Beads and bracelets', 5, '/pages/imgs/itemId6', 2);
insertItemWithImage($pdo, 107, 'Silver Earrings', 80, 'Silver Works', 'SE2024', 'New', 'Earrings', 8, '/pages/imgs/itemId7', 3);
insertItemWithImage($pdo, 108, 'Ruby Ring', 300, 'Gemstone Jewelry', 'RR2024', 'New', 'Rings', 3,'/pages/imgs/itemId8', 4);
insertItemWithImage($pdo, 109, 'Pearl Necklace', 200, 'Pearl Paradise', 'PN2024', 'New', 'Necklaces', 6,'/pages/imgs/itemId9', 5);
insertItemWithImage($pdo, 110, 'Leather Watch', 150, 'Watch Co.', 'LW2024', 'New', 'Clocks', 4,'/pages/imgs/itemId10', 6);
insertItemWithImage($pdo, 111, 'Sapphire Pendant', 180, 'Blue Stone Creations', 'SP2024', 'New', 'Necklaces', 5,'/pages/imgs/itemId11', 10);
insertItemWithImage($pdo, 112, 'Emerald Brooch', 90, 'Emerald Designs', 'EB2024', 'New', 'Accessories', 3,'/pages/imgs/itemId12', 8);
insertItemWithImage($pdo, 113, 'Gold Bangle', 220, 'Golden Touch', 'GB2024', 'New', 'Beads and bracelets', 1,'/pages/imgs/itemId13', 7);
insertItemWithImage($pdo, 114, 'Diamond Pendant Necklace', 300, 'Diamond Dreams', 'DPN2024', 'New', 'Necklaces', 5,'/pages/imgs/itemId14', 10);
insertItemWithImage($pdo, 115, 'Diamond Stud Earrings', 150, 'Luxury Jewels', 'DSE2024', 'New', 'Earrings', 3,'/pages/imgs/itemId15', 8);
insertItemWithImage($pdo, 116, 'Pearl Necklace', 80, 'Ocean Pearls', 'PN2024', 'New', 'Necklaces', 5, '/pages/imgs/itemId16', 10);
insertItemWithImage($pdo, 117, 'Ruby Bracelet', 100, 'Red Gemstones', 'RB2024', 'New', 'Beads and bracelets', 1, '/pages/imgs/itemId17', 7);
insertItemWithImage($pdo, 118, 'Gold Chain', 200, 'Golden Creations', 'GC2024', 'New', 'Necklaces', 5, '/pages/imgs/itemId18', 10);
insertItemWithImage($pdo, 119, 'Silver Hoop Earrings', 50, 'Silver Treasures', 'SHE2024', 'New', 'Earrings', 3, '/pages/imgs/itemId19', 8);
insertItemWithImage($pdo, 120, 'Opal Ring', 120, 'Opal Jewelry Co.', 'OR2024', 'New', 'Rings', 2, '/pages/imgs/itemId20', 9);

// eu pensei em primeiro inserir os items sem imagens, mas depois seria igual, 
// pois teríamos de os procurar na mesma na base de dados para colocar a imagem correspondente

?>