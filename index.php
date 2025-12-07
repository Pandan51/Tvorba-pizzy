<?php
session_start();

// Initialize the cart array in the session if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
//function valueFromSlider($value) {
//    return $value * sin($value);
//}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<h1>Make your own Pizza!</h1>
<form action="cart_handler.php" method="post">
    <div class="row">

        <input type="hidden" id="InputAction" name="action" value="add">
    </div>
<!--    <div class="row">-->
<!--        <label for="InputId">Id</label>-->
<!--        <input type="number" id="InputId" name="item_id" value="101">-->
<!--    </div>-->
    <div class="row">
        <label for="pizzaBase">Base</label>
        <select name="base" id="pizzaBase">
            <option selected="selected" value="Ketchup">Ketchup</option>
            <option value="Cream">Cream</option>
        </select>
    </div>

    <div class="row">
        <label for="cheeseTopping">Cheese:</label>
        <input type="number" id="cheeseTopping" name="cheese" value="0" min="0" max="50">
    </div>
    <div class="row">
        <label for="pepperoniTopping">Pepperoni:</label>
        <input type="number" id="pepperoniTopping" name="pepperoni" value="0" min="0" max="50">
    </div>
    <div class="row">
        <label for="pineappleTopping">Pineapple:</label>
        <input type="number" id="pineappleTopping" name="pineapple" value="0" min="0" max="50">
    </div>
    <div class="row">
        <label for="spinachTopping">Spinach:</label>
        <input type="number" id="spinachTopping" name="spinach" value="0" min="0" max="50">
    </div>
    <div class="row">
        <label for="mushroomsTopping">Mushrooms:</label>
        <input type="number" id="mushroomsTopping" name="mushrooms" value="0" min="0" max="50">
    </div>
    <div class="row">
        <label for="herbsTopping">Herbs:</label>
        <input type="number" id="herbsTopping" name="herbs" value="0" min="0" max="50">
    </div>

    <div class="row">
        <label for="inputNumber">Count</label>
        <input type="number" id="inputNumber" name="quantity" value="1" min="1">
    </div>

    <?php var_dump($_SESSION); ?>



    <button type="submit">Add to Cart</button>
</form>

</body>
</html>

