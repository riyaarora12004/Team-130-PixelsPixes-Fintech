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

echo "Investor ID: $investor_id, Entrepreneur ID: $entrepreneur_id, Amount Invested: $amount_invested<br>";

$sql = "INSERT INTO investments (investor_id, entrepreneur_id, amount_invested) VALUES ('$investor_id', '$entrepreneur_id', '$amount_invested')";
if ($conn->query($sql) === TRUE) {
    echo "Investment recorded successfully! <a href='investment_history.php'>View History</a>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
