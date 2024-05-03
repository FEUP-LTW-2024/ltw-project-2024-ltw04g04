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
function drawItem($pdo, $item) { ?>
    <body>
        <main>
            <section id="item">
                <div id="itemImg"><img src="imgs/itemTemplate.png" alt="Image of item"></div>   <!-- CHANGE -->
                
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
                        <form action="/../pages/seller.php" method="get">
                            <input type="hidden" name="id" value="<?= (int)getSellerId($pdo, $item->itemId) ?>">
                            <button type="submit" id="accountSeller">></button>
                        </form>
                    </div>

                </div>

            </section>
        </main> 
    </body>
<?php } ?>
