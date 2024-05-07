
<?php
function getUserItemIds(PDO $pdo, int $userId): array {
    $stmt = $pdo->prepare('SELECT ItemId FROM SellerItem WHERE UserId = :userId');
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
    return $result ? $result : [];
}
?>


<?php 
function drawUserPage(PDO $pdo, User $user, bool $editMode) {
    $items = getUserItemIds($pdo, $user->userId);
?>
    <main>
        <section id="profile">
            <div id="avatar"><img src="imgs/avatar.png" alt="User Avatar"></div>
            <div id="userInfo">
                <h1><?= $user->name ?></h1>
                <form action="../actions/action_edit_profile.php" method="post" class="<?= $editMode ? 'editForm' : 'notEdit' ?>">
                    <h2>Profile</h2>
                    <?php if ($editMode) : ?>
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" value="<?= $user->username ?>">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" value="<?= $user->name ?>">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" value="<?= $user->email ?>">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" value="<?= $user->city ?>" >
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" value="<?= $user->address ?>">
                        <label for="country">Country</label>
                        <input type="text" id="country" name="country" value="<?= $user->country ?>">
                        <label for="postal_code">Postal Code</label>
                        <input type="text" id="postal_code" name="postal_code" value="<?= $user->postalCode ?>">
                        <button type="submit" id="editButton">Save</button>
                        
                    <?php else : ?>
                        <p><strong>Username:</strong> <?= $user->username ?></p>
                        <p><strong>Name:</strong> <?= $user->name ?></p>
                        <p><strong>Email:</strong> <?= $user->email ?></p>
                        <p><strong>City:</strong> <?= $user->city ?></p>
                        <p><strong>Address:</strong> <?= $user->address ?></p>
                        <p><strong>Country:</strong> <?= $user->country ?></p>
                        <p><strong>Postal Code:</strong> <?= $user->postalCode ?></p>
                        <a href="?edit" id="editButton">Edit</a>
                    <?php endif; ?>

                </form>
            </div>
        </section>
        
        <section id="articles">
            <?php if (count($items) > 0) : ?>
                <h2>My arcticles</h2>
                <div class="itemGrid">
                    <?php foreach ($items as $index => $i) : ?>
                        <?php $item = Item::getItemWithId($pdo, $i); ?>
                        <article class="articleItem<?= ($index % 3 == 2) ? ' lastInRow' : '' ?>">
                            <a href="item.php?id=<?= $item->itemId ?>">
                                <img src="<?= $item->imageLink ?>" class="articleImage" alt="Item Image">
                            </a>
                            <h3><?= $item->name ?></h3>
                            <p><?= $item->price ?> $</p>
                        </article>
                    <?php endforeach; ?>
                    <article class="articleItem">
                        <a href="/../pages/add_item.php" id="addItemButtonExtra">+</a>
                        <p>Add item</p>
                    </article>
                </div>
            <?php else : ?>
                <h2>My articles</h2>
                <p>Add items to start selling.</p>
                <a href="/../pages/add_item.php" id="addItemButton">Sell now</a>
            <?php endif; ?>
        </section>
    </main>
<?php } ?>

<?php
    function getItemIdsInCart(PDO $pdo, int $userId): array {
        $stmt = $pdo->prepare('SELECT ShoppingCart.ItemId
                        FROM ShoppingCart 
                        WHERE ShoppingCart.BuyerId = :userId');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $itemIds = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $itemIds[] = $row['ItemId'];
        }
        return $itemIds;
    }
?>


<?php
function drawShoppingCart($pdo, $session) {
    ?>

    <script defer src="../templates/cartOperations.js"></script>

    <main>
        <h1 id="myCart">My Shopping Cart</h1>
        <section id="shoppingCart">
            <section id="items">
                <?php
                
                $userId = $session->getUserId();
                $subTotal = ShoppingCart::calculateCartTotal($pdo);
                $subTotalFormatted =  number_format($subTotal, 2) . '$';
                
                if (!$userId) {
                    echo "<p>Log in to view your shopping cart.</p>";

                } else {
                    
                    $itemIds = getItemIdsInCart($pdo, $userId);

                    if ($itemIds) { 

                        foreach ($itemIds as $index => $itemId) : 
                            $item = Item::getItemWithId($pdo, $itemId); 
                            $quantity = ShoppingCart::getItemQuantityInCart($pdo, $userId, $itemId);
                            ?>
                            <div class="cart-item">
                                <img src="<?= $item->image ?>" alt="<?= $item->name ?>">
                                <div class="item-details">
                                    <a href="../pages/item.php?id=<?= $item->itemId ?>">
                                        <p><?= $item->name ?></p>
                                    </a>
                                    <p class="detail"><?= $item->price ?> $ </p>  
                                    <p class="detail"> Brand: <?= $item->brand ?></p>      
                                    <p class="detail"> Model: <?= $item->model ?></p>     
                                    <p class="detail"> Condition: <?= $item->condition ?></p>      
                                    <p class="detail"> Category: <?= $item->category ?></p>          
                                    <p class="detail"> Size: <?= $item->size ?></p>
                                    <p class="detail"> In stock: <?= $item->stock ?></p>
                                    <div class="buttons-wrapper">
                                        <button class="increase-button" data-item-id="<?php echo $item->itemId; ?>">+</button>
                                        <button class="decrease-button" data-item-id="<?php echo $item->itemId; ?>">-</button>
                                        <button class="remove-button" data-item-id="<?php echo $item->itemId; ?>">Remove</button>

                                        <p class="detail-quantity"> Quantity: <?= $quantity ?></p>
                                    </div> 

                                </div>
                            </div>
                            <?php
                        endforeach;
                    } else {
                        echo "<p>Your shopping cart is empty.</p>";
                    }
                }
                ?>
            </section>
            <section id="summary">
                <h1>Order Summary</h1>
                <p id="subtotal">Subtotal: <?= $subTotalFormatted ?></p> 
                <button onclick="checkout()">Checkout</button>
            </section>
        </section>
    </main>
    </body>
    </html>
    <?php
}
?>



<?php function drawFavourites() { ?>
        <main>
            <h1 id= "myFavs" >Wish List</h1>
                <section id="items">
                    
                </section>
        </main>
    </body>
    </html>
<?php } ?>

