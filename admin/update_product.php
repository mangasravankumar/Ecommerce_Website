<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $price = floatval($_POST['price']);
    $description = $_POST['description'];

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $imageName = basename($_FILES['image']['name']);
        $imagePath = '../images/' . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);

        // Update with image
        $stmt = $conn->prepare("UPDATE products SET name=?, price=?, description=?, image=? WHERE id=?");
        $stmt->execute([$name, $price, $description, $imageName, $id]);
    } else {
        // Update without image
        $stmt = $conn->prepare("UPDATE products SET name=?, price=?, description=? WHERE id=?");
        $stmt->execute([$name, $price, $description, $id]);
    }

    header("Location: manage_products.php");
    exit();
} else {
    echo "Invalid Request.";
}
?>
