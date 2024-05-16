<?php declare(strict_types = 1);
     require_once(__DIR__ . '/../database/wishList.class.php');
     require_once(__DIR__ . '/../database/item.class.php');
?>

<?php function drawSearchItems(PDO $pdo, Session $session,array $items) { ?>
    <script defer src="../templates/cartOperations.js"></script>
    <body>
        <main>
            <?php foreach ($items as $item) { 
                $userId = $session->getUserId();
                $isItemInWishlist = WishList::isItemInWishList($pdo, $userId, $item['itemId']);
                $heartIconSrc = $isItemInWishlist ? '/../pages/imgs/heart-icon-painted.png' : '/../pages/imgs/heart-icon.png';
                ?>
                <a href="../pages/item.php?id=<?= $item['itemId'] ?>">
                <div class="cart-item">
                    <img src="<?= $item['imageLink'] ?>" alt="<?= $item['name'] ?>">
                        <div class="item-details"> 
                                <p><?= $item['name'] ?></p>
                                <p class="detail"><?= $item['price'] ?> $ </p>  
                                <p class="detail"> Brand: <?= $item['brand'] ?></p>      
                                <p class="detail"> Model: <?= $item['model'] ?></p>     
                                <p class="detail"> Condition: <?= $item['condition'] ?></p>      
                                <p class="detail"> Category: <?= $item['category'] ?></p>     
                                <p class="detail"> Size: <?= $item['size'] ?></p>
                                <p class="detail"> In stock: <?= $item['stock'] ?></p>
                                <p class="detail-heart">
                                        <img src="<?php echo $heartIconSrc; ?>" alt="Favourite" class = "heart-icon "id="heart-icon-<?php echo $item['itemId']; ?>" onclick="toggleWishlist(<?php echo $item['itemId']; ?>)">
                                </p>
                        </div>
                </div> 
                </a>
            <?php } ?>
        </main>
    </body>
<?php } ?>

<?php function drawNoSearchItems() { ?>
    <body>
        <main>
            <p> No items found. </p>
        </main>
    </body>
<?php } ?>