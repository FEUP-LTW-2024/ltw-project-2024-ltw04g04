<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../database/item.class.php');
    require_once(__DIR__ . '/../database/shoppingCart.class.php');
    require_once(__DIR__ . '/../utils/utils.php');

    $db = getDatabaseConnection();
    $session = new Session();
    $userId = $session->getUserId();

    if (!$userId) {
        echo "<p>Log in to view your shopping cart.</p>";

    } else {
        $userId = (int)cleanInput($userId);

        $itemIds = shoppingCart::getItemIdsInCart($db, $userId);

        if ($itemIds) {
            foreach ($itemIds as $index => $itemId) {
                $itemId = (int)cleanInput($itemId);

                $item = Item::getItemWithId($db, $itemId);
                $quantity = shoppingCart::getItemQuantityInCart($db, $userId, $itemId);
                ?>
                <div class="cart-item">

                <img src="<?= cleanInput($item->imageLink) ?>" alt="<?= cleanInput($item->name) ?>" onclick="redirectToItemPage(<?php echo $item->itemId ?>, '<?php echo $_SESSION['csrf']; ?>')">
                    <div class="item-details">
                        <p onclick="redirectToItemPage(<?php echo $item->itemId ?>, '<?php echo $_SESSION['csrf']; ?>')"><?= cleanInput($item->name) ?></p>
                        <p class="detail"><?= cleanInput(intval($item->price)) ?> $ </p>
                        <p class="detail"> Brand: <?= cleanInput($item->brand) ?></p>
                        <p class="detail"> Model: <?= cleanInput($item->model) ?></p>
                        <p class="detail"> Condition: <?= cleanInput($item->condition) ?></p>
                        <p class="detail"> Category: <?= cleanInput($item->category) ?></p>
                        <p class="detail"> Size: <?= cleanInput(intval($item->size)) ?></p>
                        <p class="detail"> In stock: <?= cleanInput(intval($item->stock)) ?></p>
                        
                        <div class="buttons-wrapper">
                            <button class="increase-button" data-item-id="<?php echo  $itemId; ?>">+</button>
                            <button class="decrease-button" data-item-id="<?php echo  $itemId; ?>">-</button>
                            <button class="remove-button" data-item-id="<?php echo  $itemId; ?>">Remove</button>

                            <p class="detail-quantity"> Quantity: <?= cleanInput(intval($quantity)) ?></p>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>Your shopping cart is empty.</p>";
        }
    }
?>


