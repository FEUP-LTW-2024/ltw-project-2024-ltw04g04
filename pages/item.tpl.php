
<?php 
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/item.class.php');
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../pages/navigation.php');
    //require_once(__DIR__ . '/../pages/imgs');

    $session = new Session();
    $categories = getCategories();
    generateNavigationMenu($session, $categories);

    // Supondo que você já tenha o ID do item disponível
    $itemId = 101; // Exemplo de ID do item
    
    // Obtém a instância do banco de dados
    $db = getDatabaseConnection();

    // Obtém as informações do item do banco de dados
    $item = Item::getItemWithId($db, $itemId);

    // Verifica se o item foi encontrado
    if ($item) {
        // Chama a função para exibir o item
        showItem($item);
    } else {
        echo "Item not found.";
    }
?>

<?php function showItem($item) { ?>
<body>
    <main>
        <section id="item">
            <div id="itemImg"><img src="imgs/itemTemplate.png" alt="Image of item"></div>   <!-- CHANGE -->
            
            <div id="containers">
            <div id="itemContainer">
                <h2><?= $item->name ?></h2>       <!-- CHANGE -->
                <p> <?= $item->price ?> $ </p>       <!-- CHANGE -->
                <button type="button" id="addItemToCart">Add to shopping cart</button>

                <nav id="details">
                    <input type="checkbox" id="hamburger"> 

                    <div id="bar">
                    <h3>Product details</h3>
                    <label class="hamburger" for="hamburger"></label>
                    </div>
                    
                    <p class="detail"> Brand: <?= $item->brand ?></p>       <!-- CHANGE -->
                    <p class="detail"> Model: <?= $item->model ?></p>       <!-- CHANGE -->
                    <p class="detail"> Condition: <?= $item->condition ?></p>       <!-- CHANGE -->
                    <p class="detail"> Category: <?= $item->category ?></p>       <!-- CHANGE -->
                    <p class="detail"> Size: <?= $item->size ?></p>       <!-- CHANGE -->
                    <!-- ADD THE OTHERS -->
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