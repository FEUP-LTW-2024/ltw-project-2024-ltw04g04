<?php declare(strict_types = 1);
     require_once(__DIR__ . '/../database/wishList.class.php');
     require_once(__DIR__ . '/../database/item.class.php');
?>

<?php function drawSearchItems(PDO $pdo, Session $session,array $items) { ?>
    <script defer src="../javascript/cartOperations.js"></script>
    <script defer src="../javascript/itemRedirect.js"></script>
    <body>
        <main>
            <?php foreach ($items as $item) { 
                $userId = $session->getUserId();
                $isItemInWishlist = WishList::isItemInWishList($pdo, $userId, $item['itemId']);
                $heartIconSrc = $isItemInWishlist ? '/../pages/imgs/heart-icon-painted.png' : '/../pages/imgs/heart-icon.png';
                ?>
                
                <div class="cart-item" onclick="redirectToItemPage(<?php echo $item['itemId']; ?>, '<?php echo $_SESSION['csrf']; ?>')">
                    <img src="<?= $item['imageLink'] ?>" alt="<?= $item['name'] ?>">
                        <div class="item-details"> 
                                <p><?= $item['name'] ?></p>
                                <p class="detail"><?= $item['price'] ?> $ </p>  
                                <p class="detail"> Brand: <?= $item['brand'] ?></p>      
                                <p class="detail"> Model: <?= $item['model'] ?></p>     
                                <p class="detail"> Condition: <?= $item['condition'] ?></p>      
                                <p class="detail"> Category: <?= $item['category'] ?></p>     
                                <p class="detail"> Size: <?= $item['size'] ?></p>
                                <p class="detail"> In stock: 
                                    <?php if ($item['stock'] == 0): ?> <span class="sold-out">Sold out</span>
                                    <?php else: ?> <?= $item['stock'] ?>
                                    <?php endif; ?>
                                </p>

                                <p class="detail-heart">
                                    <?php if ($session->isLogin()) {?>
                                        <img src="<?php echo $heartIconSrc; ?>" alt="Favourite" class="heart-icon" id="heart-icon-<?php echo $item['itemId']; ?>" onclick="toggleWishlist(event, <?php echo $item['itemId']; ?>)">
                                    <?php } ?>
                                </p>
                        </div>
                </div> 
                
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