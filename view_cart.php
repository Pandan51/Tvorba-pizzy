<?php
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles/view_cart-style.css" media="screen">
    <title>Document</title>
</head>
<body>
    <div class="h2-container">
        <h2>Your Shopping Cart</h2>
        <h2>Delivery details</h2>
    </div>
    <div class="container">

        <div class="shopping-cart">


        <?php if (empty($_SESSION['cart'])): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <table border="1">
                <tr><th>Base</th><th>Toppings</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th>Action</th></tr>
                <?php $total = 0; ?>
                <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td>
                            <?php
                            foreach ($item["toppings"] as $topping => $value) {
                                if($value != 0)
                                {
                                ?> <p><?php echo htmlspecialchars($topping);?> - <?php echo ($value);?></p> <?php
                                }
                            }
                        ?>
                        </td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo (int)$item['quantity']; ?></td>
                        <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                        <td>
                            <form action="cart_handler.php" method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="remove">
                                <input type="hidden" name="unique_id" value="<?php echo $id; ?>">
                                <button type="submit">Remove</button>
                            </form>
                        </td>
                    </tr>
                    <?php $total += $item['price'] * $item['quantity']; ?>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4" ><strong>Total:</strong></td>
                    <td><strong>$<?php echo number_format($total, 2); ?></strong></td>
                    <td>
                        <form action="cart_handler.php" method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="clearCart">
                            <input type="hidden" name="unique_id" value="<?php echo $id; ?>">
                            <button type="submit">Clear cart</button>
                        </form>
                    </td>
                </tr>
            </table>
        <?php endif;
        var_dump($_SESSION['cart']);
        ?>


        <div class="flex-space-between flex-align-items-center">
            <p><a href="../pizza/index.php">Continue Shopping</a></p>
        </div>
        </div>
        <div>

            <form action="order_handler.php" method="POST" style="display:inline;">
                <input type="hidden" name="action" value="order">
                <div class="row">
                    <label for="emailInput">Email:</label>
                    <input type="text" id="emailInput" name="email" required>
                </div>
                <div class="row">
                    <label for="nameInput">Name:</label>
                    <input type="text" id="nameInput" name="name" required>
                </div>
                <div class="row">
                    <label for="surnameInput">Surname:</label>
                    <input type="text" id="surnameInput" name="surname" required>
                </div>
                <div class="row">
                    <label for="streetNameInput">Street Name:</label>
                    <input type="text" id="streetNameInput" name="streetName" required>
                </div>
                <div class="row">
                    <label for="streetNumInput">Street Number:</label>
                    <input type="number" id="streetNumInput" name="streetNum" required>
                </div>
                <div class="row">
                    <label for="cityInput">City:</label>
                    <input type="text" id="cityInput" name="city" required>
                </div>

                <div class="row">
                    <label for="PostcodeInput">Postcode:</label>
                    <input type="text" id="PostcodeInput" name="postcode" required>
                </div>
                <div class="row">
                    <label for="phoneNumInput">Phone No:</label>
                    <input type="number" id="phoneNumInput" name="phoneNum" required>
                </div>
                <div class="row">
                    <label for="soulInput">Giving up your soul agreement:</label>
                    <input type="checkbox" id="soulInput" name="soulAgreement" required>
                </div>
                <button type="submit">Confirm order</button>

            </form>
        </div>
    </div>



</body>
</html>
