<?php
session_start();

// Initialize the cart array if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Define prices for components (e.g., $10 base, $0.50 per unit of topping)
const BASE_PRICE = 6.00;
const TOPPING_UNIT_PRICE = 0.50;

// --- Function to calculate the item price based on toppings ---
function calculatePizzaPrice($toppings):float {
    // Start with the base price
    $total_price = BASE_PRICE;

    // Add price for each topping quantity
    foreach ($toppings as $quantity) {
        $total_price += $quantity * TOPPING_UNIT_PRICE;
    }

    return $total_price;
}

function createPizzaCombinationId($_base, $_toppings): string
{
    $returnId = "";
    if($_base === "Ketchup"){
        $returnId = "0";
    }
    elseif ($_base === "Cream"){
        $returnId = "1";
    }
    else
    {
//        throw new Exception("Not in range of toppings");
    }

    foreach ($_toppings as $_topping) {
        $returnId .= "_$_topping";
    }

    return trim($returnId, "_");
}

// --- Logic for adding item to cart (POST request) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add') {

    // 1. Sanitize and extract general data
//    $item_id = htmlspecialchars($_POST['item_id']); // e.g., '101' for pizza
    $quantity = htmlspecialchars((int)$_POST['quantity']);

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
    $unit_price = calculatePizzaPrice($toppings);

    // 4. Create a unique identifier for this specific pizza
    // This is CRITICAL because two pizzas with the same $item_id but different toppings
    // should be treated as separate items in the cart.
//    $unique_id = $item_id . '_' . md5(serialize([$base, $toppings]));
    $item_id = createPizzaCombinationId($base, $toppings);

    // 5. Build the item array
    $new_item = [
        'id' => $item_id, // Base ID (e.g., '101' for pizza)
        'name' => "$base",
        'base' => $base,
        'toppings' => $toppings,
        'price' => $unit_price, // Unit price of ONE customized pizza
        'quantity' => $quantity,
    ];

    // 6. Add to session cart
    if (array_key_exists($item_id, $_SESSION['cart'])) {
        // If the EXACT same pizza (same base/toppings) is added again, increase its quantity
        $_SESSION['cart'][$item_id]['quantity'] += $quantity;
    } else {
        // Add the unique new item to the cart
        $_SESSION['cart'][$item_id] = $new_item;
    }

    // Redirect to view the cart
    header('Location: view_cart.php');
    exit;
}

// --- Logic for removing item from cart (GET request) ---
else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'remove') {
    // Use the unique_id (not just item_id) passed in the URL
    $item_id = htmlspecialchars($_POST['unique_id']);

    if (isset($_SESSION['cart'][$item_id])) {
        unset($_SESSION['cart'][$item_id]);
    }

    header('Location: view_cart.php');
    exit;
}
else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'clearCart') {
    session_unset();
}

// Redirect back if accessed directly without action
header('Location: index.php');
exit;
