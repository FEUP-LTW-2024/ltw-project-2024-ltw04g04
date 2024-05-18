<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../database/get_database.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/item.class.php');

$session = new Session();
$db = getDatabaseConnection();

if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_SESSION['csrf'] === $_POST['csrf'])) {
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $price = intval($_POST['price']);
    $brand = htmlspecialchars($_POST['brand'], ENT_QUOTES, 'UTF-8');
    $model = htmlspecialchars($_POST['model'], ENT_QUOTES, 'UTF-8');
    $condition = htmlspecialchars($_POST['condition'], ENT_QUOTES, 'UTF-8');
    $category = htmlspecialchars($_POST['category'], ENT_QUOTES, 'UTF-8');
    
    $stock = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);
    $size = filter_input(INPUT_POST, 'size', FILTER_VALIDATE_INT);


    // Verifica se um arquivo foi enviado
    if(isset($_FILES["item_image"]) && $_FILES["item_image"]["error"] == 0) {
        $imageDir = '../pages/imgs/imgsForItems/';
        $targetFile = $imageDir . basename($_FILES["item_image"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        
        // Verifica o tipo de arquivo
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
        if (!in_array($imageFileType, $allowedExtensions)) {
            echo "Apenas arquivos JPG, JPEG, PNG e GIF são permitidos.";
            //header ?
            exit();
        }

        // Gera um nome de arquivo único para evitar colisões
        $uniqueFilename = uniqid() . '_' . $_FILES["item_image"]["name"];
        $targetFile = $imageDir . $uniqueFilename;


        if (move_uploaded_file($_FILES["item_image"]["tmp_name"], $targetFile)) {
            $imagePath = '/' . $targetFile;

            $id = Item::insertItemInDatabase($db, $name, $price, $brand, $model, $condition, $category, $stock, $imagePath, $size);

            
            $stmt = $db->prepare('
                INSERT INTO SellerItem (UserId, ItemId)
                VALUES (?, ?)               
                ');
            $stmt->execute([$session->getUserId(), $id]);
            header('Location: ../pages/account.php');
            exit();
        } else {
            echo "Desculpe, ocorreu um erro ao carregar o arquivo.";
        }
    } else {
        echo "Nenhum arquivo de imagem enviado ou ocorreu um erro durante o upload.";
    }

} else {
    header('Location: ../pages/error.php');
    exit();
}
?>



