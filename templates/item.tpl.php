<?php declare(strict_types = 1); ?>

<?php function drawItem($item) { ?>
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
                <h3>Seller Name</h3>       <!-- CHANGE -->
                <button type="button" id="accountSeller"> > </button>
            </div>
            </div>

        </section>
    </main> 
</body>

<?php } ?>