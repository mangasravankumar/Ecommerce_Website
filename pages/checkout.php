<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include '../includes/db.php';

$user_id = $_SESSION['user_id'];

// Get cart items
$stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($cart_items)) {
    echo "<h2>Your cart is empty.</h2>";
    exit();
}

$product_ids = array_column($cart_items, 'product_id');
$placeholders = implode(',', array_fill(0, count($product_ids), '?'));
$stmt = $conn->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
$stmt->execute($product_ids);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle order submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    // Calculate total
    $total = 0;
    foreach ($cart_items as $item) {
        foreach ($products as $product) {
            if ($product['id'] == $item['product_id']) {
                $total += $product['price'] * $item['quantity'];
            }
        }
    }

    // Insert into orders table
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount) VALUES (?, ?)");
    $stmt->execute([$user_id, $total]);
    $order_id = $conn->lastInsertId();

    // Insert into order_items
    foreach ($cart_items as $item) {
        foreach ($products as $product) {
            if ($product['id'] == $item['product_id']) {
                $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
                $stmt->execute([$order_id, $product['id'], $item['quantity'], $product['price']]);
            }
        }
    }

    // Clear the cart
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->execute([$user_id]);

    // Redirect to thank you page
    header("Location: thank_you.php?order_id=$order_id");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <style>
        body { font-family: Arial; padding: 40px; background: #f5f5f5; }
        .box { max-width: 600px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; }
        h2 { text-align: center; }
        .item { margin-bottom: 15px; border-bottom: 1px solid #ccc; padding-bottom: 10px; }
        .item-name { font-weight: bold; }
        .total { font-size: 1.3em; text-align: right; margin-top: 20px; }
        .btn { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #28a745; color: #fff; text-decoration: none; border-radius: 5px; border: none; cursor: pointer; }
    </style>
</head>
<body>
<div class="box">
    <h2>Order Summary</h2>
    <?php
    $total_cost = 0;
    foreach ($products as $product) {
        $quantity = 0;
        foreach ($cart_items as $item) {
            if ($item['product_id'] == $product['id']) {
                $quantity = $item['quantity'];
                break;
            }
        }
        $subtotal = $product['price'] * $quantity;
        $total_cost += $subtotal;
        echo "<div class='item'>
                <div class='item-name'>{$product['name']} x {$quantity}</div>
                <div>Price: \${$product['price']} | Subtotal: \${$subtotal}</div>
              </div>";
    }
    ?>
    <div class="total">Total: $<?= number_format($total_cost, 2); ?></div>

    <!-- Place Order Form -->
    <form method="POST">
        <button type="submit" name="place_order" class="btn">Place Order</button>
    </form>
</div>
</body>
</html>
