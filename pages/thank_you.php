<?php
session_start();
$orderId = $_GET['order_id'] ?? null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thank You</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body style="background-color: #f7f7f7; font-family: Arial, sans-serif;">

<div style="max-width: 600px; margin: 50px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); text-align: center;">

    <h2 style="margin-bottom: 20px;">🎉 Thank you for your order!</h2>

    <?php if ($orderId): ?>
        <p style="font-size: 18px; margin-bottom: 30px;">Your order ID is: <strong>#<?= htmlspecialchars($orderId) ?></strong></p>
    <?php else: ?>
        <p style="font-size: 18px; margin-bottom: 30px;">Your order has been placed!</p>
    <?php endif; ?>

    <a href="../index.php" style="display: inline-block; padding: 10px 20px; background-color: #28a745; color: white; border-radius: 5px; text-decoration: none;">Continue Shopping</a>

</div>

</body>
</html>
