<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!file_exists('database.php')) {
    die("Error: database.php file is missing!");
}
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entrepreneur_name = $_POST['entrepreneur_name'];  // Added entrepreneur name field
    $name = $_POST['name'];
    $idea = $_POST['idea'];
    $amount = $_POST['amount'];
    $crowdfunding_type = $_POST['crowdfunding_type'];

    if (empty($entrepreneur_name) || empty($name) || empty($idea) || empty($amount) || empty($crowdfunding_type)) {
        die("<div class='error'>All fields are required!</div>");
    }

    $sql = "INSERT INTO entrepreneurs (entrepreneur_name, name, idea, amount, crowdfunding_type) VALUES ('$entrepreneur_name', '$name', '$idea', '$amount', '$crowdfunding_type')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div class='success'>Idea submitted successfully!</div>";
    } else {
        echo "<div class='error'>Error: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Your Business Idea</title>
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
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .form-container:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        }

        /* Form Fields */
        input, textarea, select {
            width: calc(100% - 20px);
            padding: 10px;
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

        textarea {
            height: 80px;
            resize: none;
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

        /* Success & Error Messages */
        .success, .error {
            text-align: center;
            margin-top: 10px;
            padding: 10px;
            width: 350px;
            font-size: 16px;
            border-radius: 5px;
        }

        .success {
            background-color: #C9E4C5;
            color: #2F4858;
        }

        .error {
            background-color: #FFD1D1;
            color: #B22222;
        }
    </style>
</head>
<body>

<h2>Submit Your Business Idea</h2>

<div class="form-container">
    <form method="POST">
        <input type="text" name="entrepreneur_name" placeholder="Entrepreneur Name" required> <!-- Added entrepreneur name field -->
        <input type="text" name="name" placeholder="Business Name" required>
        <textarea name="idea" placeholder="Describe your idea" required></textarea>
        <input type="number" name="amount" placeholder="Amount Needed (₹)" required>

        <label for="crowdfunding_type">Select Crowdfunding Type:</label>
        <select name="crowdfunding_type" id="crowdfunding_type" required>
            <option value="">-- Select Type --</option>
            <option value="Debt-based">Debt-Based (Loan-based)</option>
            <option value="Donation-based">Donation-Based (No repayment)</option>
        </select>

        <button type="submit">Submit</button>
    </form>
</div>

</body>
</html>
