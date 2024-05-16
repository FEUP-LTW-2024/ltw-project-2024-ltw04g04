<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../database/item.class.php');
    require_once(__DIR__ . '/../database/shoppingCart.class.php');

    $db = getDatabaseConnection();
    $session = new Session();
    $userId = $session->getUserId();

    if (!$userId) {
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

