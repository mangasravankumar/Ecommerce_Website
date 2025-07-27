<?php
session_start();
include '../includes/db.php'; // adjust path if needed

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "No product selected.";
    exit();
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "Product not found.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f4f4f4;
            padding: 40px;
        }
        form {
            background-color: #fff;
            padding: 25px;
            width: 400px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
        label {
            font-weight: bold;
        }
        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 5px;
        }
        button:hover {
            background-color: #218838;
        }
        a.back {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

<form method="post" action="update_product.php" enctype="multipart/form-data">
    <h2>Edit Product</h2>
    <input type="hidden" name="id" value="<?= $product['id']; ?>">

    <label>Name</label>
    <input type="text" name="name" value="<?= htmlspecialchars($product['name']); ?>" required>

    <label>Price</label>
    <input type="number" step="0.01" name="price" value="<?= $product['price']; ?>" required>

    <label>Description</label>
    <textarea name="description" required><?= htmlspecialchars($product['description']); ?></textarea>

    <label>Image (optional)</label>
    <input type="file" name="image">

    <button type="submit">Update Product</button>
</form>

<a href="manage_products.php" class="back">← Back to Manage Products</a>

</body>
</html>
