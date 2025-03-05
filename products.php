<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'database.php';

if (!isset($_SESSION['seller_id'])) {
    die("<div class='error'>You must be logged in as a seller to add products.</div>");
}

$seller_id = $_SESSION['seller_id'];

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['name']) && !empty($_POST['price']) && !empty($_POST['description']) && isset($_POST['product_type']) && !empty($_POST['phone_number'])) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $product_type = $_POST['product_type'];
        $phone_number = $_POST['phone_number'];  // Added phone number field
        $seller_id = $_SESSION['seller_id'];
        
        if ($product_type == 'Product' && isset($_FILES['image'])) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        } else {
            $target_file = NULL;
        }

        // Update the SQL query to include the phone number
        $stmt = $conn->prepare("INSERT INTO products (name, price, image, description, seller_id, product_type, phone_number) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sdsssss", $name, $price, $target_file, $description, $seller_id, $product_type, $phone_number);

        
        if ($stmt->execute()) {
            $message = "<div class='success'>Product/Service added successfully!</div>";
        } else {
            $message = "<div class='error'>Error: " . $stmt->error . "</div>";
        }
        
        $stmt->close();
    } else {
        $message = "<div class='error'>Please fill all required fields and upload an image if it's a product.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product/Service</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #FAE1DD;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
        }

        h2 {
            color: #2F4858;
            text-align: center;
            font-size: 28px;
        }

        .form-container {
            background: #FFFFFF;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .form-container:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.3);
        }

        input, select, textarea {
            width: calc(100% - 20px);
            padding: 12px;
            margin: 10px 0;
            border: 2px solid #2F4858;
            border-radius: 5px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input:focus, textarea:focus, select:focus {
            border-color: #D67D7D;
            outline: none;
            background-color: #FFF7F3;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #2F4858;
            color: white;
            border: none;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: #D67D7D;
        }

        .success, .error {
            text-align: center;
            margin-top: 10px;
            padding: 10px;
            width: 350px;
            border-radius: 5px;
            font-size: 16px;
        }

        .success {
            background-color: #D4EDDA;
            color: #155724;
        }

        .error {
            background-color: #FFD1D1;
            color: #B22222;
        }
    </style>
</head>
<body>

<h2>Add a New Product/Service</h2>
<?= $message; ?>
<div class="form-container">
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Product/Service Name" required>
        <input type="number" step="0.01" name="price" placeholder="Price" required>
        
        <select name="product_type" id="product_type" required>
            <option value="Product">Product</option>
            <option value="Service">Service</option>
        </select>
        
        <div id="image_upload_container">
            <input type="file" name="image">
        </div>

        <textarea name="description" placeholder="Description" required></textarea>
        <input type="text" name="phone_number" placeholder="Phone Number" required> <!-- Added phone number input -->
        <button type="submit">Add Product/Service</button>
    </form>
</div>

<script>
    const productTypeSelect = document.getElementById('product_type');
    const imageUploadContainer = document.getElementById('image_upload_container');

    function toggleImageUpload() {
        if (productTypeSelect.value === 'Service') {
            imageUploadContainer.style.display = 'none'; 
        } else {
            imageUploadContainer.style.display = 'block'; 
        }
    }

    toggleImageUpload();

    productTypeSelect.addEventListener('change', toggleImageUpload);
</script>

</body>
</html>
