<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'database.php';

if (!isset($_SESSION['seller_id'])) {
    die("You must be logged in as a seller to add products.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['name']) && !empty($_POST['price']) && !empty($_POST['description']) && isset($_FILES['image'])) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $seller_id = $_SESSION['seller_id'];
        
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        
        // Insert product into database
        $stmt = $conn->prepare("INSERT INTO products (name, price, image, description, seller_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sdssi", $name, $price, $target_file, $description, $seller_id);
        
        if ($stmt->execute()) {
            echo "Product added successfully!";
            header("Location: seller_dashboard.php");
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Please fill all required fields and upload an image.";
    }
}
?>

<form method="post" action="seller_dashboard.php" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Product Name" required>
    <input type="number" step="0.01" name="price" placeholder="Price" required>
    <input type="file" name="image" required>
    <textarea name="description" placeholder="Product Description" required></textarea>
    <button type="submit">Add Product</button>
</form>
