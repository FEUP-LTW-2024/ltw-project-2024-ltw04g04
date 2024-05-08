<?php declare(strict_types = 1); ?>

<?php function drawSearchItems(array $items) { ?>
    <body>
        <main>
            <?php foreach ($items as $item) { ?>
                <a href="../pages/item.php?id=<?= $item['itemId'] ?>">
                <div class="cart-item">
                    <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>">
                        <div class="item-details"> 
                                <p><?= $item['name'] ?></p>
                                <p class="detail"><?= $item['price'] ?> $ </p>  
                                <p class="detail"> Brand: <?= $item['brand'] ?></p>      
                                <p class="detail"> Model: <?= $item['model'] ?></p>     
                                <p class="detail"> Condition: <?= $item['condition'] ?></p>      
                                <p class="detail"> Category: <?= $item['category'] ?></p>     
                                <p class="detail"> Size: <?= $item['size'] ?></p>
                                <p class="detail"> In stock: <?= $item['stock'] ?></p>
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