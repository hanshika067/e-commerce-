<?php
session_start();
include 'db_connect.php';

// Fetch categories
$categories = $conn->query("SELECT * FROM categories");

// Get category filter
$categoryFilter = "";
if (isset($_GET['category']) && $_GET['category'] !== "") {
    $categoryFilter = "WHERE category_id = " . intval($_GET['category']);
}


// Sorting logic (only for selected category)
$orderBy = "price ASC";
if (isset($_GET['sort']) && $_GET['sort'] != "") {
    if ($_GET['sort'] == "price_high") $orderBy = "price DESC";
    if ($_GET['sort'] == "rating_high") $orderBy = "rating DESC";
}

// Fetch products for selected category
$sql = "SELECT * FROM products";
if ($categoryFilter) {
    $sql .= " $categoryFilter";
}
$sql .= " ORDER BY $orderBy";

$products = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Shop</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <div class="logo">E-Shop</div>
    <div class="nav-links">
        <a href="index.php" class="btn">All Products</a>
        <?php while ($cat = $categories->fetch_assoc()): ?>
            <a href="index.php?category=<?php echo $cat['id']; ?>" class="btn"><?php echo $cat['name']; ?></a>
        <?php endwhile; ?>
    </div>
    <a href="cart.php" class="cart-icon">🛒 Cart</a>
</div>

<!-- Sorting Buttons -->
<div class="sort-options">
    <a href="index.php?category=<?php echo $_GET['category'] ?? ''; ?>&sort=price_low" class="sort-btn">Price: Low to High</a>
    <a href="index.php?category=<?php echo $_GET['category'] ?? ''; ?>&sort=price_high" class="sort-btn">Price: High to Low</a>
    <a href="index.php?category=<?php echo $_GET['category'] ?? ''; ?>&sort=rating_high" class="sort-btn">Best Rating</a>
</div>

<!-- Product Grid -->
<div class="product-grid">
    <?php while ($row = $products->fetch_assoc()): ?>
        <div class="product-card">
            <a href="product.php?id=<?php echo $row['id']; ?>">
            <td>
            <img src="images/<?php echo $row['image']; ?>" alt="Product Image">
            "></td>
            <h2><?php echo $row['name']; ?></h2>
            </a>
            <p>Price: $<?php echo number_format($row['price'], 2); ?></p>
            <p>Rating: ⭐ <?php echo $row['rating']; ?></p>
            <form action="cart.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                <button type="submit" class="add-to-cart">Add to Cart</button>
            </form>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>
