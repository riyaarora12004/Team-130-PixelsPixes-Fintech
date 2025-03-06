<?php
include 'database.php';
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['investor_id'])) {
    die("You must be logged in as an investor to invest!");
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Error: This page must be accessed via a form submission.");
}

if (!isset($_POST['entrepreneur_id']) || !isset($_POST['amount'])) {
    die("Error: Missing required form data.");
}

$entrepreneur_id = $_POST['entrepreneur_id'];
$investor_id = $_SESSION['investor_id'];
$amount_invested = $_POST['amount'];

if (!is_numeric($amount_invested) || $amount_invested <= 0) {
    die("Error: Invalid investment amount.");
}

$sql = "INSERT INTO investments (investor_id, entrepreneur_id, amount_invested) VALUES ('$investor_id', '$entrepreneur_id', '$amount_invested')";


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investment Confirmation</title>
    <style>
        /* Reset some basic styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #FAE1DD;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #1E3A40;
            text-align: center;
        }

        /* Container for the content */
        .container {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* Hover effect for the container */
        .container:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        /* Heading styles */
        h1 {
            font-size: 32px;
            margin-bottom: 20px;
            color: #1E3A40;
        }

        /* Button and Links */
        a {
            text-decoration: none;
            color: #ffffff;
            background-color: #1E3A40;
            padding: 12px 24px;
            border-radius: 5px;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #D67D7D;
        }

        /* Message styles */
        .message {
            font-size: 18px;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #C9E4C5;
            color: #2F4858;
            border-radius: 5px;
        }

        .error {
            background-color: #FFD1D1;
            color: #B22222;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Investment Confirmation</h1>
    <p class="message">Your investment has been successfully recorded!</p>
    <a href="investment_history.php">View Your Investment History</a>
</div>

</body>
</html>
