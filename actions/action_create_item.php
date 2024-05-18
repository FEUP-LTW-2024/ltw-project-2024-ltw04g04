<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/item.class.php');
    require_once(__DIR__ . '/../utils/utils.php');

    $session = new Session();
    $db = getDatabaseConnection();

    if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_SESSION['csrf'] === $_POST['csrf'])) {
        $name = cleanInput($_POST['name']);
        $price = intval($_POST['price']);
        $brand = cleanInput($_POST['brand']);
        $model = cleanInput($_POST['model']);
        $condition = cleanInput($_POST['condition']);
        $category = cleanInput($_POST['category']);
        $stock = intval($_POST['stock']);
        $size = intval($_POST['size']);

        if (strlen($name) < 5) {
            echo "O nome deve ter pelo menos 5 caracteres.";
            exit();
        }
        
        if ($stock <= 0) {
            echo "O estoque deve ser maior que zero.";
            exit();
        }
    
        if(isset($_FILES["item_image"]) && $_FILES["item_image"]["error"] == 0) {
            $imageDir = '../pages/imgs/imgsForItems/';
            $targetFile = $imageDir . basename($_FILES["item_image"]["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
            if (!in_array($imageFileType, $allowedExtensions)) {
                echo "Apenas arquivos JPG, JPEG, PNG e GIF são permitidos.";
                exit();
            }

            $uniqueFilename = uniqid() . '_' . $_FILES["item_image"]["name"];
            $targetFile = $imageDir . $uniqueFilename;


            if (move_uploaded_file($_FILES["item_image"]["tmp_name"], $targetFile)) {
                $imagePath = '/' . $imageDir . $_FILES["item_image"]["name"];
                echo "<p>$imagePath</p>";

                $id = Item::insertItemInDatabase($db, $name, $price, $brand, $model, $condition, $category, $stock, $imagePath, $size);

                
                $stmt = $db->prepare('
                    INSERT INTO SellerItem (UserId, ItemId)
                    VALUES (?, ?)               
                    ');
                $stmt->execute([$session->getUserId(), $id]);
                header('Location: ../pages/account.php');
                exit();
            } else {
                echo "Sorry, error in upload archive.";
            }
        } else {
            echo "No image files uploaded or an error occurred while uploading.";
        }

    } else {
        header('Location: ../pages/error.php');
        exit();
    }
?>



