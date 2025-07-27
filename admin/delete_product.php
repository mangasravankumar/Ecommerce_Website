<?php
session_start();
include '../includes/db.php'; // Adjust path if needed

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Check if product ID is passed
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Delete the product
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);

    // Redirect back to manage products page
    header("Location: manage_products.php");
    exit();
} else {
    echo "Invalid request: No product ID provided.";
}
?>
