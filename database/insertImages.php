<?php 
declare(strict_types = 1);
require_once(__DIR__ . '/../database/get_database.php');

function insertImageIfNotExists($itemId, $imagePath) {
    
    $pdo = getDatabaseConnection();

    // Check if the image already exists for the given item
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM Item WHERE ItemId = :itemId AND Image_ IS NOT NULL");
    $stmt->bindParam(':itemId', $itemId);
    $stmt->execute();
    $imageExists = $stmt->fetchColumn();

    // insert image if it doesn't exist
    if (!$imageExists) {
        $imageData = file_get_contents($imagePath);
        $stmt = $pdo->prepare("UPDATE Item SET Image_ = :image WHERE ItemId = :itemId");
        $stmt->bindParam(':itemId', $itemId);
        $stmt->bindParam(':image', $imageData, PDO::PARAM_LOB);
        $stmt->execute();
    }
}


$stmt = $pdo->query("SELECT ItemId, ImagePath FROM Item");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $itemId = $row['ItemId'];
    $imagePath = $row['ImagePath'];

    // If there's an image associated with the item, insert it if it doesn't already exist
    if ($imagePath) {
        insertImageIfNotExists($pdo, $itemId, $imagePath);
    }
}


$pdo = getDatabaseConnection();

$stmt = $pdo->query("SELECT ItemId FROM Item");

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $itemId = $row['ItemId'];

    $rightmostDigit = $itemId % 10;

    // Construct the image path for the current item ID
    $imagePath = '/pages/imgs/itemId' . $rightmostDigit; 

    insertImageIfNotExists($pdo, $itemId, $imagePath);
}

/*insertImageIfNotExists(101, '/pages/imgs/itemId1');
insertImageIfNotExists(102, '/pages/imgs/itemId2');
insertImageIfNotExists(103, '/pages/imgs/itemId3');
insertImageIfNotExists(104, '/pages/imgs/itemId4');
insertImageIfNotExists(105, '/pages/imgs/itemId5');
insertImageIfNotExists(106, '/pages/imgs/itemId6');
insertImageIfNotExists(107, '/pages/imgs/itemId7');
insertImageIfNotExists(108, '/pages/imgs/itemId8');
insertImageIfNotExists(109, '/pages/imgs/itemId9');
insertImageIfNotExists(110, '/pages/imgs/itemId10');
insertImageIfNotExists(111, '/pages/imgs/itemId11');
insertImageIfNotExists(112, '/pages/imgs/itemId12');
insertImageIfNotExists(113, '/pages/imgs/itemId13');
insertImageIfNotExists(114, '/pages/imgs/itemId14');
insertImageIfNotExists(115, '/pages/imgs/itemId15');
insertImageIfNotExists(116, '/pages/imgs/itemId16');
insertImageIfNotExists(117, '/pages/imgs/itemId17');
insertImageIfNotExists(118, '/pages/imgs/itemId18');
insertImageIfNotExists(119, '/pages/imgs/itemId19');
insertImageIfNotExists(120, '/pages/imgs/itemId20');*/


?>