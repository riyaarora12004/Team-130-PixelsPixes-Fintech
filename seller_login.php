<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM sellers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $seller = $result->fetch_assoc();

        if ($seller && password_verify($password, $seller['password'])) {
            $_SESSION['seller_id'] = $seller['id'];
            $_SESSION['username'] = $seller['username'];
            header("Location: products.php");
            exit();
        } else {
            echo "<div class='error'>Invalid email or password.</div>";
        }

        $stmt->close();
    } else {
        echo "<div class='error'>Please fill all required fields.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Login</title>
    <style>
        /* General Styles */
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

        /* Form Container */
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

        /* Form Fields */
        input {
            width: calc(100% - 20px);
            padding: 12px;
            margin: 10px 0;
            border: 2px solid #2F4858;
            border-radius: 5px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input:focus {
            border-color: #D67D7D;
            outline: none;
            background-color: #FFF7F3;
        }

        /* Button */
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

        /* Error Message */
        .error {
            text-align: center;
            margin-top: 10px;
            padding: 10px;
            width: 350px;
            background-color: #FFD1D1;
            color: #B22222;
            border-radius: 5px;
            font-size: 16px;
        }
    </style>
</head>
<body>

<h2>Seller Login</h2>

<div class="form-container">
    <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
