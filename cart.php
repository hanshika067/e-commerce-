<?php
session_start();
include 'db_connect.php';

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

//  Add items to cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $productId = intval($_POST['product_id']); // Ensure valid product ID
    if (!in_array($productId, $_SESSION['cart'])) { // Prevent duplicates
        $_SESSION['cart'][] = $productId;
    }
}

//  Remove item from cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_id'])) {
    $removeId = $_POST['remove_id']; // Store in a variable
    $_SESSION['cart'] = array_values(array_filter($_SESSION['cart'], function ($id) use ($removeId) {
        return $id != $removeId;
    }));
}

// ✅ Fetch cart products
$cartProducts = [];
$totalPrice = 0;

if (!empty($_SESSION['cart'])) {
    $cartIds = implode(",", array_map('intval', $_SESSION['cart'])); // Ensure valid SQL
    $query = "SELECT * FROM products WHERE id IN ($cartIds)";
    $cartProducts = $conn->query($query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="cart-styles.css">
</head>
<body>

<div class="cart-navbar">🛒 Shopping Cart</div>

<div class="cart-container">
    <h2>Your Cart</h2>

    <?php if (empty($_SESSION['cart'])): ?>
        <p class="empty-cart-msg">🛍️ Your cart is empty!</p>
        <a href="index.php" class="back-home">🔄 Continue Shopping</a>
    <?php else: ?>
        <table class="cart-table">
            <tr>
                <th>Product</th>
                <th>Image</th>
                <th>Price</th>
                <th>Action</th>
            </tr>

            <?php while ($row = $cartProducts->fetch_assoc()): 
                $totalPrice += $row['price'];
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt="Product Image"></td>
                    <td>$<?php echo number_format($row['price'], 2); ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="remove_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="remove-btn">❌ Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <p class="total-price">Total: <strong>$<?php echo number_format($totalPrice, 2); ?></strong></p>

        <div class="cart-buttons">
            <a href="index.php" class="back-home">🏠 Go to Home</a>
            <a href="checkout.php" class="checkout-btn">🛍️ Proceed to Checkout</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
