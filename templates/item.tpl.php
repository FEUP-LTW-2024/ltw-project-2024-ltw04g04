<?php declare(strict_types = 1); ?>
<?php
function getSellerNamePD(PDO $pdo, $itemId) {
    $stmt = $pdo->prepare('SELECT u.Name_ as sellerName FROM User u INNER JOIN SellerItem si ON u.UserId = si.UserId WHERE si.ItemId = :itemId');
    $stmt->bindParam(':itemId', $itemId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
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
    $isSeller = (int)getSellerId($pdo, $item->itemId) === $userId;
    $sellerProfileURL = $isSeller ? '/../pages/account.php' : '/../pages/seller.php';
    $sellerIdValue = $isSeller ? $userId : (int)getSellerId($pdo, $item->itemId);
?>
    <body>
        <main>
            <section id="item">
                <div id="itemImg"><img src="imgs/itemTemplate.png" alt="Image of item"></div>  
                <div id="containers">
                    <div id="itemContainer">
                        <h2><?= $item->name ?></h2>      
                        <p> <?= $item->price ?> $ </p>  
                        <button type="button" id="addItemToCart">Add to shopping cart</button>

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
    </body>
<?php } ?>

<?php
function sellingItem() {
?>
<main>
    <h2>Create New Item</h2>
    <form action="../actions/create_item.php" method="post">
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
            <option value="Beads and bracelets">Beads and bracelets</option>
            <option value="Earrings">Earrings</option>
            <option value="Rings">Rings</option>
            <option value="Necklaces">Necklaces</option>
            <option value="Accessories">Accessories</option>
            <option value="Clocks">Clocks</option>
        </select><br><br>

        <label for="size">Size:</label><br>
        <input type="text" id="size" name="size" required><br><br>

        <input type="submit" value="Create Item">
    </form>
</main>

<?php
}
?>


