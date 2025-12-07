<?php
session_start();

// Initialize the cart array if it doesn't exist
if (empty($_SESSION['cart'])    ) {
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

// Využivá počet jednotlivých vlastností pro sestavení ID
function createPizzaCombinationId($_base, $_toppings): string
{
    $returnId = "";
    if($_base === "Ketchup"){
        $returnId = "0";
    }
    elseif ($_base === "Cream"){
        $returnId = "1";
    }


    foreach ($_toppings as $_topping) {
        $returnId .= "_$_topping";
    }

    return trim($returnId, "_");
}

//Přidávání pizzy do košíku
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add') {


    $quantity = htmlspecialchars((int)$_POST['quantity']);

    // Pokud je quantita 0, není co přidávat
    if ($quantity <= 0) {
        header('Location: index.php'); // Redirect back to product page
        exit;
    }

    //Základ pizzy = Kečup nebo Smetana
    $base = htmlspecialchars($_POST['base']);

    //Přísady
    $toppings = [
        'cheese' => (int)$_POST['cheese'],
        'pepperoni' => (int)$_POST['pepperoni'],
        'pineapple' => (int)$_POST['pineapple'],
        'spinach' => (int)$_POST['spinach'],
        'mushrooms' => (int)$_POST['mushrooms'],
        'herbs' => (int)$_POST['herbs'],
    ];

    // Cena
    $unit_price = calculatePizzaPrice($toppings);

    //ID pro kombinaci pizzy
    $item_id = createPizzaCombinationId($base, $toppings);

    // Representace pizzy
    $new_item = [
        'id' => $item_id, // Base ID (e.g., '101' for pizza)
        'name' => "$base",
        'base' => $base,
        'toppings' => $toppings,
        'price' => $unit_price, // Unit price of ONE customized pizza
        'quantity' => $quantity,
    ];

    // Přidání pizzy
    if (array_key_exists($item_id, $_SESSION['cart'])) {
        // Pokud už je, zvýšit počet
        $_SESSION['cart'][$item_id]['quantity'] += $quantity;
    } else {
        // Jinak dáme do košíku
        $_SESSION['cart'][$item_id] = $new_item;
    }

    // Přesměrovat na stránku košíku
    header('Location: view_cart.php');
    exit;
}

// Odstranění pizzy z košíku
else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'remove') {
    // ID pro identifikaci určité pizzy
    $item_id = htmlspecialchars($_POST['unique_id']);


    if (isset($_SESSION['cart'][$item_id])) {
        unset($_SESSION['cart'][$item_id]);
    }

    header('Location: view_cart.php');
    exit;
}
// Zrušit objednávku
else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'clearCart') {
    session_unset();
}
//Tlačitko pro zvýšení o 1
else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'incrementQuantity')
{
    $id = $_POST['unique_id'];
    $_SESSION['cart'][$id]['quantity']++;

    header('Location: view_cart.php');
    exit;
}
//Tlačitko pro zmenšení o 1
else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'decrementQuantity')
{
    $id = $_POST['unique_id'];
    $_SESSION['cart'][$id]['quantity']--;

    if($_SESSION['cart'][$id]['quantity'] == 0)
    {
        unset($_SESSION['cart'][$id]);
    }
    header('Location: view_cart.php');
    exit;
}


header('Location: index.php');
exit;
