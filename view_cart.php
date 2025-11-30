<?php
session_start();
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Your Shopping Cart</h2>

    <?php if (empty($_SESSION['cart'])): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <table border="1">
            <tr><th>Item</th><th>Toppings</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th>Action</th></tr>
            <?php $total = 0; ?>
            <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td>
                        <?php
                        foreach ($item["toppings"] as $topping => $value) {
                            if($value != 0)
                            {
                            ?> <p><?php echo $topping;?> - <?php echo ($value);?></p> <?php
                            }
                        }
                    ?>
                    </td>
                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo (int)$item['quantity']; ?></td>
                    <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                    <td><a href="cart_handler.php?action=remove&unique_id=<?php echo $id; ?>">Remove</a></td>
                </tr>
                <?php $total += $item['price'] * $item['quantity']; ?>
            <?php endforeach; ?>
            <tr>
                <td colspan="3" align="right"><strong>Total:</strong></td>
                <td><strong>$<?php echo number_format($total, 2); ?></strong></td>
                <td></td>
            </tr>
        </table>
    <?php endif;
    var_dump($_SESSION['cart']);
    ?>


    <p><a href="../pizza/index.php">Continue Shopping</a></p>

</body>
</html>
