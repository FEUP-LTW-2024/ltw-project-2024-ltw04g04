<?php 
declare(strict_types = 1);
require_once(__DIR__ . '/../database/get_database.php');


$pdo = getDatabaseConnection();

// Create separate folders for each type of images

// Section where only images for items are handled, folder is called 'imgsForItems' ----

if (!is_dir('pages/imgs')) mkdir('pages/imgs');
if (!is_dir('pages/imgs/imgsForItems')) mkdir('pages/imgs/imgsForItems');


function processImage($pdo, $filePath, $title) {

    $original = @imagecreatefromjpeg($filePath);
    if (!$original) $original = @imagecreatefrompng($filePath);
    if (!$original) $original = @imagecreatefromgif($filePath);

    if (!$original) die('Unknown image format!');

    $stmt = $pdo->prepare("INSERT INTO Images (title) VALUES(?)");
    $stmt->execute(array($title));

    $id = $pdo->lastInsertId();

    $originalFileName = "pages/imgs/imgsForItems/$id.jpg";

    imagejpeg($original, $originalFileName);

    imagedestroy($original);
}


$imageDir = 'pages/imgs/imgsForItems';
$images = glob("$imageDir/*.{jpg,png,gif}", GLOB_BRACE);

foreach ($images as $imagePath) {
    //$title = array($_POST['title']);
    $title = basename($imagePath);  // a description for the image that gets stored, can be the path
    processImage($pdo, $imagePath, $title);
}

// -----------

?>

