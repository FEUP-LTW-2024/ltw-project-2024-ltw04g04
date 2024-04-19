<?php

// test connection to database: was successful
require_once 'connectDB.php';

try {
    // Get a PDO instance by calling the function
    $db = getDatabaseConnection();

    // Example query to fetch data
    $stmt = $db->query('SELECT * FROM User');
    
    // Fetch the results
    $results = $stmt->fetchAll();

    // Output the results
    var_dump($results);

} catch (PDOException $e) {
    // If an exception is thrown, display the error message
    echo 'Connection failed: ' . $e->getMessage();
}


// test fetching item, but db still empty
/*include 'shoppingCart.php';

// Assuming $item_id contains the item ID received from the client-side
$item_id = $_GET['item_id'];

// Call the function to fetch item details
$itemDetails = getItemDetails($item_id);

// Convert the result to JSON and echo it
echo json_encode($itemDetails);

*/

// test if item ID and action are received from the client-side
/*if(isset($_POST['item_id']) && isset($_POST['action'])) {

    $item_id = filter_var($_POST['item_id'], FILTER_SANITIZE_NUMBER_INT);
    $action = $_POST['action'];

    if ($action === 'add') {
        $result = addItemToCart($pdo, $item_id);
    } else if ($action === 'remove') {
        $result = removeItemFromCart($pdo, $item_id);
    } else {
        $result = array('error' => 'Invalid action');
    }

    echo json_encode($result);
} else {
    // If item ID or action is not provided, respond with an error message
    echo json_encode(array('error' => 'Item ID or action not provided'));
}*/



?>

