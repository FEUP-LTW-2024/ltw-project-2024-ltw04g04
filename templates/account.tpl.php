<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../database/shoppingCart.class.php');
    require_once(__DIR__ . '/../database/item.class.php');
    require_once(__DIR__ . '/../database/insertImages.php');
?>


<?php 
function drawUserPage(PDO $pdo, User $user, bool $editMode) {
    $items = Item::getUserItemIds($pdo, $user->userId);
?>
    <main>
        <section id="profile">
            <div id="avatar"><img src="imgs/avatar.png" alt="User Avatar"></div>
            <div id="userInfo">
            <h1><?= $user->name ?> 
                <?php if ($user->isAdmin) : ?>
                    <img src="/../pages/imgs/verified-icon.png" alt="Verified" id="verified" class="verified"></br>
                    <span class="admin-text">Administrator</span>
                <?php endif; ?></h1>
                <form action="../actions/action_edit_profile.php" method="post" class="<?= $editMode ? 'editForm' : 'notEdit' ?>">
                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
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



<?php function drawShoppingCart($db, $session) { ?>
    <script defer src="../templates/cartOperations.js"></script>

    <?php $userId = $session->getUserId(); ?>

    <body>
        <main>
            <h1 id="myCart">My Shopping Cart</h1>
            <section id="shoppingCart">
                <section id="items">
                   <?php if (!$userId) {
                            echo "<p>Log in to view your shopping cart.</p>";

                        } else {
                            $itemIds = shoppingCart::getItemIdsInCart($db, $userId);

                            if ($itemIds) { 
                                foreach ($itemIds as $index => $itemId) : 
                                    $item = Item::getItemWithId($db, $itemId); 
                                    $quantity = shoppingCart::getItemQuantityInCart($db, $userId, $itemId);
                                    ?>
                                    <div class="cart-item">
                                        <img src="<?= $item->imageLink ?>" alt="<?= $item->name ?>">
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
                    <?php if (!$userId) { ?>
                        <h1>Order Summary</h1>
                        <p id="subtotal">Subtotal: </p>     
                    <?php } else { 
                        $subTotal = shoppingCart::calculateCartTotal($db, $userId);
                        $subTotalFormatted =  number_format($subTotal, 2) . '$'; ?>
                        <h1>Order Summary</h1>
                        <p id="subtotal">Subtotal: <?= $subTotalFormatted ?></p> 
                        <button onclick="window.location.href = 'payment.php'">Checkout</button>  
                    <?php } ?>
                </section>
            </section>
        </main>
    </body>
    
<?php } ?>

<?php
    function getItemIdsInWishList(PDO $pdo, int $userId): array {
        $stmt = $pdo->prepare('SELECT WishList.ItemId
                        FROM WishList 
                        WHERE WishList.BuyerId = :userId');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $itemIds = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $itemIds[] = $row['ItemId'];
        }
        return $itemIds;
    }
?>


<?php function drawFavourites(PDO $pdo, Session $session) { ?>
    <script defer src="../templates/cartOperations.js"></script>
        <main>
            <h1 id= "myFavs" >Wish List</h1>
            <section id="items-list">
                <?php
                
                $userId = $session->getUserId();
                
                if (!$userId) {
                    echo "<p>Log in to view your wish list.</p>";

                } else {
                    
                    $itemIds = getItemIdsInWishList($pdo, $userId);

                    if ($itemIds) { 

                        foreach ($itemIds as $index => $itemId) : 
                            $item = Item::getItemWithId($pdo, $itemId); 
                            //$item->imageLink = '/pages/imgs/imgsForitems/item1.jpg';
                            $isItemInWishlist = WishList::isItemInWishList($pdo, $userId, $itemId);
                            $heartIconSrc = $isItemInWishlist ? '/../pages/imgs/heart-icon-painted.png' : '/../pages/imgs/heart-icon.png';
                            ?>

                            <div class="cart-item">
                                <img src="<?= $item->imageLink ?>" alt="<?= $item->name ?>">
                                <div class="item-details">
                                    <a href="../pages/item.php?id=<?= $item->itemId ?>">
                                        <p><?= $item->name ?></p>
                                    </a>
                                    <p class="detail"> <?= number_format($item->price, 2) ?> $</p>  
                                    <p class="detail"> Brand: <?= $item->brand ?></p>      
                                    <p class="detail"> Model: <?= $item->model ?></p>     
                                    <p class="detail"> Condition: <?= $item->condition ?></p>      
                                    <p class="detail"> Category: <?= $item->category ?></p>     
                                    <p class="detail"> Size: <?= $item->size ?></p>
                                    <p class="detail-heart">
                                        <img src="<?php echo $heartIconSrc; ?>" alt="Favourite" class = "heart-icon "id="heart-icon-<?php echo $item->itemId; ?>" onclick="toggleWishlist(<?php echo $item->itemId; ?>)">
                                    </p>
                                </div>
                            </div>
                            <?php
                        endforeach;
                    } else {
                        echo "<p>Your wish list is empty.</p>";
                    }
                }
                ?>
            </section>
        </main>
    </body>
    </html>
<?php } ?>


<?php
function usersList(PDO $pdo, Session $session) {
    $users = User::getAllUsersExceptCurrent($pdo, $session->getUserId());
?>
    <main>
        <h2 class="usersList">List of Sellers</h2>
        <div class="users-container">
            <?php foreach ($users as $user): ?>
                <div class="user">
                    <img src="../pages/imgs/user-icon.png" alt="User Icon">
                    <div class="user-details">
                        <p>Name: <?= $user['Name_'] ?></p>
                        <p>Username: <?= $user['Username'] ?></p>
                        <div class="admin-action">
                            <?php if ($user->isAdmin) : ?>
                                <form action="../actions/action_make_admin.php" method="post">
                                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                                    <input type="hidden" name="user_id" value="<?= $user['UserId'] ?>">
                                    <input type="hidden" name="action" value="remove_admin">
                                    <input type="submit" name="remove_admin" value="Remove Admin" class="remove-admin">
                                </form>
                            <?php else : ?>
                                <form action="../actions/action_make_admin.php" method="post">
                                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                                    <input type="hidden" name="user_id" value="<?= $user['UserId'] ?>">
                                    <input type="hidden" name="action" value="make_admin">
                                    <input type="submit" name="make_admin" value="Make Admin" class="make-admin">
                                </form>
                            <?php endif; ?>
                        </div>
                        <a href="../pages/seller.php?id=<?= $user['UserId'] ?>" class="profile-button">Profile</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
<?php
}
?>


