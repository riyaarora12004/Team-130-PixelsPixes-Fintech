<?php
session_start();
include 'database.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add product to cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    
    if ($product) {
        $_SESSION['cart'][] = $product; 
    }
}

// Remove product from cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_index'])) {
    $remove_index = $_POST['remove_index'];
    if (isset($_SESSION['cart'][$remove_index])) {
        array_splice($_SESSION['cart'], $remove_index, 1);
    }
}

// Fetch products from database
$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Listing</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FAE1DD;
            display: flex;
            justify-content: center;
        }
        .products-section h2 {
            text-align: right;
            margin-right: -100px; /* Adjust this value for more or less shift */
            font-size: 24px;
            font-weight: bold;
            color: #2F4858;
        }
        .container {
            display: flex;
            width: 90%;
            max-width: 1200px;
            margin-top: 20px;
            gap: 20px;
        }

        /* Cart Section */
        .cart-section {
            width: 30%;
            padding: 20px;
            background-color: #2F4858;
            color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ffffff33;
        }

        .remove-btn {
            background-color: #e63946;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }

        .remove-btn:hover {
            background-color: #a0001d;
        }

        /* Product Section */
        .products-section {
            width: 70%;
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .product-card {
            background-color: white;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .product-card img {
            width: 100px;
            height: 100px;
            border-radius: 5px;
        }

        .product-card button {
            background-color: #FF6F61;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }

        .product-card button:hover {
            background-color: #d84337;
        }

        /* Responsive Design */
        @media (max-width: 900px) {
            .container {
                flex-direction: column;
                align-items: center;
            }

            .cart-section {
                width: 100%;
            }

            .products-section {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Left Sidebar: Cart Section -->
    <div class="cart-section">
        <h2>Your Cart</h2>
        <?php
        $total = 0;
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $index => $item) {
                echo "<div class='cart-item'>";
                echo "<p>" . $item['name'] . " - $" . $item['price'] . "</p>";
                echo "<form method='post' style='display:inline;'>";
                echo "<input type='hidden' name='remove_index' value='" . $index . "'>";
                echo "<button type='submit' class='remove-btn'>Remove</button>";
                echo "</form>";
                echo "</div>";
                
                $total += $item['price'];
            }
            echo "<h3>Total: $" . number_format($total, 2) . "</h3>";
        } else {
            echo "<p>Cart is empty.</p>";
        }
        ?>
    </div>

    <!-- Right Side: Products Section -->
    <div class="products-section">
        <h2>Products List</h2><br>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='product-card'>";
                echo "<h3>" . $row['name'] . "</h3>";
                echo "<p>Price: $" . $row['price'] . "</p>";
                echo "<img src='" . $row['image'] . "' alt='Product Image'>";
                echo "<p>" . $row['description'] . "</p>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='product_id' value='" . $row['id'] . "'>";
                echo "<button type='submit'>Add to Cart</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "<p>No products available.</p>";
        }
        ?>
    </div>
</div>

</body>
</html>
