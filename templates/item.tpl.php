<?php declare(strict_types = 1); 
 require_once(__DIR__ . '/../database/wishList.class.php');
?>

<?php
function getSellerNamePD(PDO $pdo, $itemId) {
    $stmt = $pdo->prepare('SELECT u.Name_ as sellerName FROM User u INNER JOIN SellerItem si ON u.UserId = si.UserId WHERE si.ItemId = :itemId');
    $stmt->bindParam(':itemId', $itemId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$result) return "No Name";
    return $result['sellerName'];
}
?>

<?php
function getSellerId(PDO $pdo, int $itemId): int {
    $stmt = $pdo->prepare('SELECT UserId FROM SellerItem WHERE ItemId = :itemId');
    $stmt->bindParam(':itemId', $itemId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return (int)$result['UserId'];
}
?>

<?php
function drawItem($pdo, $userId, $item) { 
    if ($userId == -1) {
        $isSeller = false;
    } else {
        $isSeller = (int)getSellerId($pdo, $item->itemId) === $userId;
    }
    $sellerProfileURL = $isSeller ? '/../pages/account.php' : '/../pages/seller.php';
    $sellerIdValue = $isSeller ? $userId : (int)getSellerId($pdo, $item->itemId);
    $isItemInWishlist = WishList::isItemInWishList($pdo, $userId, $item->itemId);
    $heartIconSrc = $isItemInWishlist ? '/../pages/imgs/heart-icon-painted.png' : '/../pages/imgs/heart-icon.png';
?>
    <script src="../templates/cartOperations.js"></script>
        <main>
            <section id="item">
                <div id="itemImg"><img src="imgs/itemTemplate.png" alt="Image of item"></div>  
                <div id="containers">
                    <div id="itemContainer">
                        <h2><?= $item->name ?></h2>      
                        <p> <?= number_format($item->price, 2) ?> $ </p>    
                        <p> Available Stock: <?= $item->stock ?> </p>
                        <button type="button" id="addItemToCart" data-item-id="<?= $item->itemId ?>">Add to shopping cart</button>
                        <p class="detail">
                            <img src="<?php echo $heartIconSrc; ?>" alt="Favourite" class = "heart-icon" id="heart-icon-<?php echo $item->itemId; ?>" onclick="toggleWishlist(<?php echo $item->itemId; ?>)">
                        Favourite</p>
                        
                        <nav id="details">
                            <input type="checkbox" id="hamburger"> 

                            <div id="bar">
                                <h3>Product details</h3>
                                <label class="hamburger" for="hamburger"></label>
                            </div>
                            
                            <p class="detail"> Brand: <?= $item->brand ?></p>      
                            <p class="detail"> Model: <?= $item->model ?></p>     
                            <p class="detail"> Condition: <?= $item->condition ?></p>      
                            <p class="detail"> Category: <?= $item->category ?></p>     
                            <p class="detail"> Size: <?= $item->size ?></p>     
                        </nav>
                    </div>

                    <div id="sellerContainer">
                        <div id="sellerImg"><img src="imgs/user-icon.png" alt="Image of icon account"></div>
                        <h3><?= htmlspecialchars(getSellerNamePD($pdo, $item->itemId), ENT_QUOTES, 'UTF-8') ?></h3>
                        <form action="<?= $sellerProfileURL ?>" method="get">
                            <input type="hidden" name="id" value="<?= $sellerIdValue ?>">
                            <button type="submit" id="accountSeller">></button>
                        </form>
                    </div>

                </div>

            </section>
        </main> 
<?php } ?>

<?php
function sellingItem(PDO $pdo) {
    $stmt = $pdo->query('SELECT CategoryName FROM Category');
    $categories = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>
   <main>
    <h2 class = "creationHeader">Create New Item</h2>
        <form action="../actions/action_create_item.php" method="post" class="form-container">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" required><br><br>

            <label for="price">Price:</label><br>
            <input type="number" id="price" name="price" min="0" required><br><br>

            <label for="brand">Brand:</label><br>
            <input type="text" id="brand" name="brand" required><br><br>

            <label for="model">Model:</label><br>
            <input type="text" id="model" name="model" required><br><br>

            <label for="condition">Condition:</label><br>
            <input type="text" id="condition" name="condition" required><br><br>

            <label for="category">Category:</label><br>
            <select id="category" name="category" required>
                <option value="">Select category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="size">Size:</label><br>
            <input type="text" id="size" name="size" required><br><br>

            <label for="stock">Stock:</label><br>
            <input type="text" id="stock" name="stock" required><br><br>

            <input type="submit" value="Create Item" class="button-create-item">
        </form>
    </main>

    <?php
}
?>

<?php
function editCategories(PDO $pdo) {
    $stmt = $pdo->query('SELECT CategoryName FROM Category');
    $categories = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>
   <main>
    <h2 class = "editCategory">Change categories</h2>
        <form action="../actions/action_edit_category.php" method="post" class="category-container">
            <h3>Delete Category</h3>
            <label for="category_id_to_delete">Select category to delete:</label>
            <select id="category_id_to_delete" name="category_id_to_delete">
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" name="delete_category" value="Delete" class="button-delete-category">
        </form>

        <form action="../actions/action_edit_category.php" method="post" class="category-container">
            <h3>Add New Category</h3>
            <label for="new_category_name">New category name:</label>
            <input type="text" id="new_category_name" name="new_category_name" required>
            <input type="submit" name="add_category" value="Add" class="button-add-category">
        </form>
    </main>

    <?php
}
?>


