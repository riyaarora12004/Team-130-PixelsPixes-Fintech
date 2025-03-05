<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (!empty($username) && !empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash password securely
        $_SESSION['username'] = $username;
        header("Location: seller_dashboard.php");
        exit();
    } else {
        $error = "Both fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Signup</title>
    <style>
        /* General Page Styling */
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

        /* Signup Form Container */
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
            transform: scale(1.03);
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

        /* Submit Button */
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
            color: #B22222;
            background-color: #FFD1D1;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            text-align: center;
        }

        /* Link Styling */
        a {
            color: #2F4858;
            font-weight: bold;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #D67D7D;
        }
    </style>
</head>
<body>

<h2>Seller Signup</h2>

<div class="form-container">
    <?php if (!empty($error)) { echo "<div class='error'>$error</div>"; } ?>

    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign Up</button>
    </form>

    <p>Already have an account? <a href="seller_login.php">Login here</a></p>
</div>

</body>
</html>
