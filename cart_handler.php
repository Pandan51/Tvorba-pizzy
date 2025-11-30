<?php
session_start();

// Initialize the cart array if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Define prices for components (e.g., $10 base, $0.50 per unit of topping)
const BASE_PRICE = 10.00;
const TOPPING_UNIT_PRICE = 0.50;

// --- Function to calculate the item price based on toppings ---
function calculatePizzaPrice($base, $toppings) {
    // Start with the base price
    $total_price = BASE_PRICE;

    // Add price for each topping quantity
    foreach ($toppings as $quantity) {
        $total_price += $quantity * TOPPING_UNIT_PRICE;
    }

    return $total_price;
}

function createPizzaId(){

}

// --- Logic for adding item to cart (POST request) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add') {

    // 1. Sanitize and extract general data
    $item_id = htmlspecialchars($_POST['item_id']); // e.g., '101' for pizza
    $quantity = (int)$_POST['quantity'];

    // Guard clause: Don't add if quantity is zero or less
    if ($quantity <= 0) {
        header('Location: index.php'); // Redirect back to product page
        exit;
    }

    // 2. Extract specific pizza data
    $base = htmlspecialchars($_POST['base']);

    $toppings = [
        'cheese' => (int)$_POST['cheese'],
        'pepperoni' => (int)$_POST['pepperoni'],
        'pineapple' => (int)$_POST['pineapple'],
        'spinach' => (int)$_POST['spinach'],
        'mushrooms' => (int)$_POST['mushrooms'],
        'herbs' => (int)$_POST['herbs'],
    ];

    // 3. Calculate the unique price for this specific pizza configuration
    $unit_price = calculatePizzaPrice($base, $toppings);

    // 4. Create a unique identifier for this specific pizza
    // This is CRITICAL because two pizzas with the same $item_id but different toppings
    // should be treated as separate items in the cart.
    $unique_id = $item_id . '_' . md5(serialize([$base, $toppings]));

    // 5. Build the item array
    $new_item = [
        'id' => $item_id, // Base ID (e.g., '101' for pizza)
        'name' => "{$base} base",
        'base' => $base,
        'toppings' => $toppings,
        'price' => $unit_price, // Unit price of ONE customized pizza
        'quantity' => $quantity,
    ];

    // 6. Add to session cart
    if (array_key_exists($unique_id, $_SESSION['cart'])) {
        // If the EXACT same pizza (same base/toppings) is added again, increase its quantity
        $_SESSION['cart'][$unique_id]['quantity'] += $quantity;
    } else {
        // Add the unique new item to the cart
        $_SESSION['cart'][$unique_id] = $new_item;
    }

    // Redirect to view the cart
    header('Location: view_cart.php');
    exit;
}

// --- Logic for removing item from cart (GET request) ---
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'remove') {
    // Use the unique_id (not just item_id) passed in the URL
    $unique_id = htmlspecialchars($_GET['unique_id']);

    if (isset($_SESSION['cart'][$unique_id])) {
        unset($_SESSION['cart'][$unique_id]);
    }

    header('Location: view_cart.php');
    exit;
}

// Redirect back if accessed directly without action
header('Location: index.php');
exit;
?>