<?php 
    declare(strict_types = 1); 
    require_once(__DIR__ . '/../database/wishList.class.php');
    require_once(__DIR__ . '/../utils/utils.php');
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
    $session = new Session();
    if ($userId == -1) {
        $isSeller = false;
    } else {
        $isSeller = (int)getSellerId($pdo, $item->itemId) === $userId;
    }
    $sellerIdValue = $isSeller ? $userId : (int)getSellerId($pdo, $item->itemId);
    $isItemInWishlist = WishList::isItemInWishList($pdo, $userId, $item->itemId);
    $heartIconSrc = $isItemInWishlist ? '/../pages/imgs/heart-icon-painted.png' : '/../pages/imgs/heart-icon.png';
    $current = User::getUserWithId($pdo, $sellerIdValue);
?>
    <script src="../javascript/cartOperations.js"></script>
        <main>
            <section id="item">
                <div id="itemImg"><img src="<?= $item->imageLink ?>" alt="<?= $item->name ?>"></div>   
                <div id="containers">
                    <div id="itemContainer">
                        <h2><?= $item->name ?></h2>      
                        <p> <?= number_format($item->price, 2) ?> $ </p>    
                        <p> Available Stock: <?= $item->stock ?> </p>
                        <?php if ($item->stock != 0 && $session->isLogin()) {?>
                            <button type="button" id="addItemToCart" data-item-id="<?= $item->itemId ?>">Add to shopping cart</button>
                            <p class="detail">
                            <img src="<?php echo $heartIconSrc; ?>" alt="Favourite" class = "heart-icon" id="heart-icon-<?php echo $item->itemId; ?>" onclick="toggleWishlist(event,<?php echo $item->itemId; ?>)">
                            Favourite </p>
                        <?php }?>
                        
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
                        <div class = "profilePic" id="sellerImg"><img img src="<?= $current->profileImage ?>" alt="Image of icon account"></div>
                        <h3><?= cleanInput(getSellerNamePD($pdo, $item->itemId)) ?></h3>
                        <form id="toSellerPage" action="../actions/action_process_seller.php" method="post">
                            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                            <input type="hidden" name="seller-id" value="<?= $sellerIdValue ?>">
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
    $sizes = getSizes();
    $conditions = getConditions();
    $models = getModels();
    $brands = getBrands();  
?>
   <main>
    <h2 class = "creationHeader">Create New Item</h2>
        <form action="../actions/action_create_item.php" method="post" enctype="multipart/form-data" class="form-container">
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" required><br><br>

            <label for="price">Price:</label><br>
            <input type="number" id="price" name="price" min="0" required><br><br>

            <label for="brand">Brand:</label><br>
            <select id="brand" name="brand" required>
                <option value="">Select brand</option>
                <?php foreach ($brands as $brand): ?>
                    <option value="<?php echo $brand['BrandName']; ?>"><?php echo $brand['BrandName']; ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="model">Model:</label><br>
            <select id="model" name="model" required>
                <option value="">Select model</option>
                <?php foreach ($models as $model): ?>
                    <option value="<?php echo $model['ModelName']; ?>"><?php echo $model['ModelName']; ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="condition">Condition:</label><br>
            <select id="condition" name="condition" required>
                <option value="">Select condition</option>
                <?php foreach ($conditions as $condition): ?>
                    <option value="<?php echo $condition['ConditionName']; ?>"><?php echo $condition['ConditionName']; ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="category">Category:</label><br>
            <select id="category" name="category" required>
                <option value="">Select category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="size">Size:</label><br>
            <select id="size" name="size" required>
                <option value="">Select size</option>
                <?php foreach ($sizes as $size): ?>
                    <option value="<?php echo $size['SizeVal']; ?>"><?php echo $size['SizeVal']; ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="stock">Stock:</label><br>
            <input type="text" id="stock" name="stock" required><br><br>

            <label for="item_image">Select Image:</label><br>
            <input type="file" id="item_image" name="item_image" accept="image/*" required><br><br>


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
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
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
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <h3>Add New Category</h3>
            <label for="new_category_name">New category name:</label>
            <input type="text" id="new_category_name" name="new_category_name" required>
            <input type="submit" name="add_category" value="Add" class="button-add-category">
        </form>
    </main>

    <?php
}
?>

<?php
function editBrands(PDO $pdo) {
    $stmt = $pdo->query('SELECT BrandName FROM Brand');
    $brands = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>
   <main>
    <h2 class = "editBrand">Change brands</h2>
        <form action="../actions/action_edit_brand.php" method="post" class="brand-container">
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <h3>Delete Brand</h3>
            <label for="brand_id_to_delete">Select brand to delete:</label>
            <select id="brand_id_to_delete" name="brand_id_to_delete">
                <?php foreach ($brands as $brand): ?>
                    <option value="<?php echo $brand; ?>"><?php echo $brand; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" name="delete_brand" value="Delete" class="button-delete-brand">
        </form>

        <form action="../actions/action_edit_brand.php" method="post" class="brand-container">
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <h3>Add New Brand</h3>
            <label for="new_brand_name">New brand name:</label>
            <input type="text" id="new_brand_name" name="new_brand_name" required>
            <input type="submit" name="add_brand" value="Add" class="button-add-brand">
        </form>
    </main>
    <?php
}
?>

<?php
function editConditions(PDO $pdo) {
    $stmt = $pdo->query('SELECT ConditionName FROM Condition');
    $conditions = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>
   <main>
    <h2 class = "editCondition">Change conditions</h2>
        <form action="../actions/action_edit_condition.php" method="post" class="condition-container">
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <h3>Delete Condition</h3>
            <label for="condition_id_to_delete">Select condition to delete:</label>
            <select id="condition_id_to_delete" name="condition_id_to_delete">
                <?php foreach ($conditions as $condition): ?>
                    <option value="<?php echo $condition; ?>"><?php echo $condition; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" name="delete_condition" value="Delete" class="button-delete-condition">
        </form>

        <form action="../actions/action_edit_condition.php" method="post" class="condition-container">
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <h3>Add New Condition</h3>
            <label for="new_condition_name">New condition name:</label>
            <input type="text" id="new_condition_name" name="new_condition_name" required>
            <input type="submit" name="add_condition" value="Add" class="button-add-condition">
        </form>
    </main>

    <?php
}
?>

<?php
function editModels(PDO $pdo) {
    $stmt = $pdo->query('SELECT ModelName FROM Model');
    $models = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>
   <main>
    <h2 class = "editModel">Change models</h2>
        <form action="../actions/action_edit_model.php" method="post" class="model-container">
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <h3>Delete Model</h3>
            <label for="model_id_to_delete">Select model to delete:</label>
            <select id="model_id_to_delete" name="model_id_to_delete">
                <?php foreach ($models as $model): ?>
                    <option value="<?php echo $model; ?>"><?php echo $model; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" name="delete_model" value="Delete" class="button-delete-model">
        </form>

        <form action="../actions/action_edit_model.php" method="post" class="model-container">
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <h3>Add New Model</h3>
            <label for="new_model_name">New model name:</label>
            <input type="text" id="new_model_name" name="new_model_name" required>
            <input type="submit" name="add_model" value="Add" class="button-add-model">
        </form>
    </main>

    <?php
}
?>

<?php
function editSizes(PDO $pdo) {
    $stmt = $pdo->query('SELECT SizeVal FROM Size_');
    $sizes = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>
   <main>
    <h2 class = "editSize">Change sizes</h2>
        <form action="../actions/action_edit_size.php" method="post" class="size-container">
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <h3>Delete Size</h3>
            <label for="size_id_to_delete">Select size to delete:</label>
            <select id="size_id_to_delete" name="size_id_to_delete">
                <?php foreach ($sizes as $size): ?>
                    <option value="<?php echo $size; ?>"><?php echo $size; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" name="delete_size" value="Delete" class="button-delete-size">
        </form>

        <form action="../actions/action_edit_size.php" method="post" class="size-container">
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <h3>Add New Size</h3>
            <label for="new_size_name">New size value:</label>
            <input type="text" id="new_size_name" name="new_size_name" required>
            <input type="submit" name="add_size" value="Add" class="button-add-size">
        </form>
    </main>

    <?php
}
?>


