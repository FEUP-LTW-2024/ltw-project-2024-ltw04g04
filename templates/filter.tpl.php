
<?php function drawFilter() { ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Filter Items</title>
        <link rel="stylesheet" type="text/css" href="../css/style-f.css">
    </head>
    <body>
        <div class="filter-container">
            <h2>Filter Items</h2>
            <form id="filter-form" action="../actions/action_search_filter.php" method="get"> 
                <div class="filter-category">
                    <?php 
                    $categories = getCategories();
                    ?>
                    <label for="category-filter">Category:</label>
                    <select id="category-filter" name="category">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?php echo $category['CategoryName']; ?>"><?php echo $category['CategoryName']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-size">
                    <?php 
                    $sizes = getSizes();
                    ?>
                    <label>Size:</label>
                    <?php foreach ($sizes as $size) : ?>
                        <label class="size-checkbox">
                            <input type="checkbox" name="size[]" value="<?php echo $size['Size_']; ?>">
                            <?php echo $size['Size_']; ?>
                        </label>
                    <?php endforeach; ?>
                </div>
                <div class="filter-model">
                    <?php 
                    $models = getModels(); 
                    ?>
                    <label for="model-filter">Model:</label>
                    <select id="model-filter" name="model">
                        <option value="">Any model</option>
                        <?php foreach ($models as $model) : ?>
                            <option value="<?php echo $model['Model']; ?>"><?php echo $model['Model']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-brand">
                    <?php 
                    $brands = getBrands(); 
                    ?>
                    <label for="brand-filter">Brand:</label>
                    <select id="brand-filter" name="brand"> <
                        <option value="">Any brand</option>
                        <?php foreach ($brands as $brand) : ?>
                            <option value="<?php echo $brand['Brand']; ?>"><?php echo $brand['Brand']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit">Apply</button>
            </form>
        </div>
    </body>
    </html>
<?php } ?>

<?php
function drawFilteredItemsPage($filteredItems) {
    echo '<div class="filtered-items-container">';
    foreach ($filteredItems as $item) {
        echo '<div class="item">';
        echo '<img src="' . $item['imageLink'] . '" alt="Item Image">';
        echo '<h2>' . $item['name'] . '</h2>';
        echo '<p>Price: ' . $item['price'] . '</p>';
        echo '<p>Brand: ' . $item['brand'] . '</p>';
        echo '<p>Model: ' . $item['model'] . '</p>';
        echo '<p>Condition: ' . $item['condition'] . '</p>';
        echo '<p>Category: ' . $item['category'] . '</p>';
        echo '<p>Size: ' . $item['size'] . '</p>';
        echo '</div>';
    }
    echo '</div>';
}
?>

