<?php 
declare(strict_types = 1);
require_once(__DIR__ . '/../database/get_database.php');


$pdo = getDatabaseConnection();

// Create separate folders for each type of images

// ---- Section where only images for items are handled, folder is called 'imgsForItems' ----

//if (!is_dir('pages/imgs')) mkdir('pages/imgs');
//if (!is_dir('pages/imgs/imgsForItems')) mkdir('pages/imgs/imgsForItems');


function processImage($pdo, $filePath, $title) {

    $original = @imagecreatefromjpeg($filePath);
    if (!$original) $original = @imagecreatefrompng($filePath);
    if (!$original) $original = @imagecreatefromgif($filePath);

    if (!$original) die('Unknown image format!');

    $stmt = $pdo->prepare("INSERT INTO Images (title) VALUES(?)");
    $stmt->execute(array($title));

    $id = $pdo->lastInsertId();

    $directoryPath = dirname($filePath);  // Get the directory path from filePath
    $originalFileName = "$directoryPath/$id.jpg";  

    imagejpeg($original, $originalFileName);

    imagedestroy($original);
}


$imageDir = __DIR__ . 'pages/imgs/imgsForItems';
$images = glob("$imageDir/*.{jpg,png,gif}", GLOB_BRACE);

foreach ($images as $imagePath) {
    //$title = array($_POST['title']);
    $title = basename($imagePath);  // a description for the image that gets stored, can be the path
    processImage($pdo, $imagePath, $title);
}

/*if (!is_dir('pages/imgs')) mkdir('pages/imgs');
if (!is_dir('pages/imgs/imgsForItems')) mkdir('pages/imgs/imgsForItems');

$original = @imagecreatefromjpeg($tempFileName);
if (!$original) $original = @imagecreatefrompng($tempFileName);
if (!$original) $original = @imagecreatefromgif($tempFileName);

    if (!$original) die('Unknown image format!');

    $stmt = $pdo->prepare("INSERT INTO Images (title) VALUES(?)");
    $stmt->execute(array($_POST['title']));

    $id = $pdo->lastInsertId();

    $originalFileName = "pages/imgs/imgsForItems/$id.jpg";

    imagejpeg($original, $originalFileName);

    imagedestroy($original);*/

/* // Ensure the titles are provided in a corresponding manner, e.g., $_POST['titles'] as an array
if (!isset($_POST['titles']) || !is_array($_POST['titles'])) {
    die('No titles provided or titles are not in the correct format.');
}

$titles = $_POST['titles'];

if (count($images) != count($titles)) {
    die('The number of images and titles do not match.');
}
// Process each image
foreach ($images as $index => $imagePath) {
    $title = $titles[$index];  // Get the corresponding title
    processImage($pdo, $imagePath, $title);
}   */

// -----------

?>

