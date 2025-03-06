<?php
session_start();
include 'database.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$products_per_page = 4; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$offset = ($page - 1) * $products_per_page; 

$search_query = '';
if (isset($_GET['search'])) {
    $search_query = htmlspecialchars($_GET['search']);
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_index'])) {
    $remove_index = $_POST['remove_index'];
    if (isset($_SESSION['cart'][$remove_index])) {
        array_splice($_SESSION['cart'], $remove_index, 1);
    }
}

// Modify queries to search by name or description
$products_sql = "SELECT products.*, sellers.email FROM products 
                 INNER JOIN sellers ON products.seller_id = sellers.id
                 WHERE products.product_type = 'Product' 
                 AND (products.name LIKE ? OR products.description LIKE ?)
                 LIMIT $products_per_page OFFSET $offset";
$services_sql = "SELECT products.*, sellers.email FROM products 
                 INNER JOIN sellers ON products.seller_id = sellers.id
                 WHERE products.product_type = 'Service' 
                 AND (products.name LIKE ? OR products.description LIKE ?)";

$search_term = '%' . $search_query . '%';

// Prepare and execute the product query
$stmt_products = $conn->prepare($products_sql);
$stmt_products->bind_param("ss", $search_term, $search_term);
$stmt_products->execute();
$products = $stmt_products->get_result();

// Prepare and execute the service query
$stmt_services = $conn->prepare($services_sql);
$stmt_services->bind_param("ss", $search_term, $search_term);
$stmt_services->execute();
$services = $stmt_services->get_result();

// Count the total number of products matching the search
$total_products_result = $conn->prepare("SELECT COUNT(*) AS total FROM products WHERE product_type = 'Product' AND (name LIKE ? OR description LIKE ?)");
$total_products_result->bind_param("ss", $search_term, $search_term);
$total_products_result->execute();
$total_products_row = $total_products_result->get_result()->fetch_assoc();
$total_products = $total_products_row['total'];

$total_pages = ceil($total_products / $products_per_page); // Calculate total pages
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product & Service Listings</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FAE1DD;
            display: flex;
            justify-content: center;
        }
        .container {
            display: flex;
            width: 90%;
            max-width: 1200px;
            margin-top: 20px;
            gap: 20px;
        }

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

        /* Product & Service Sections */
        .listings-section {
            width: 70%;
            padding: 20px;
        }

        .section-title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #2F4858;
            border-bottom: 2px solid #2F4858;
            padding-bottom: 5px;
        }

        .product-list, .service-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .product-card, .service-card {
            background-color: white;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .product-card:hover, .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .product-card img, .service-card img {
            width: 100px;
            height: 100px;
            border-radius: 5px;
        }

        .product-card button, .service-card button {
            background-color: #FF6F61;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }

        .product-card button:hover, .service-card button:hover {
            background-color: #d84337;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            padding: 10px;
            margin: 0 5px;
            background-color: #FF6F61;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }

        .pagination a:hover {
            background-color: #d84337;
        }
/* Search Bar */
form {
    margin: 20px 0;
    display: flex;
    justify-content: center;
    gap: 10px;
}

form input[type="text"] {
    padding: 8px;
    width: 200px;
    height: 30px; /* Set height to keep it compact */
    border: 1px solid #FF6F61;
    border-radius: 5px;
    font-size: 14px;
}

form button {
    padding: 8px 12px;
    height: 30px; /* Match height with input field */
    background-color: #FF6F61;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

form button:hover {
    background-color: #d84337;
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
    <!-- Search Form -->

    <div class="listings-section">
    <form method="GET">
        <input type="text" name="search" placeholder="Search by name or description" value="<?php echo $search_query; ?>">
        <button type="submit">Search</button>
    </form>
        <div>
            <h2 class="section-title">Products</h2>
            <div class="product-list">
                <?php
                if ($products->num_rows > 0) {
                    while ($row = $products->fetch_assoc()) {
                        echo "<div class='product-card'>";
                        echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
                        echo "<p>Price: $" . htmlspecialchars($row['price']) . "</p>";
                        echo "<img src='" . htmlspecialchars($row['image']) . "' alt='Product Image'>";
                        echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                        echo "<p><strong>Seller Email:</strong> " . htmlspecialchars($row['email']) . "</p>";
                        echo "<p><strong>Seller Phone-Number:</strong> " . htmlspecialchars($row['phone_number']) . "</p>";
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
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>&search=<?php echo $search_query; ?>">Previous</a>
            <?php endif; ?>
            <?php if ($page < $total_pages): ?>
                <a href="?page=<?php echo $page + 1; ?>&search=<?php echo $search_query; ?>">Next</a>
            <?php endif; ?>
        </div>
        <div>
            <h2 class="section-title">Services</h2>
            <div class="service-list">
                <?php
                if ($services->num_rows > 0) {
                    while ($row = $services->fetch_assoc()) {
                        echo "<div class='service-card'>";
                        echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
                        echo "<p>Price: $" . htmlspecialchars($row['price']) . "</p>";
                        echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                        echo "<p><strong>Seller Email:</strong> " . htmlspecialchars($row['email']) . "</p>";
                        echo "<p><strong>Seller Phone-Number:</strong> " . htmlspecialchars($row['phone_number']) . "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No services available.</p>";
                }
                ?>
            </div>
        </div>
        
    </div>
</div>

</body>
</html>
