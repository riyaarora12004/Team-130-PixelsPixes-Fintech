<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$message = ""; // To display success or error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'database.php';
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO investors (name, email, password) VALUES ('$name', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        $message = "<p class='success'>Signup successful! <a href='investor_login.php'>Login here</a></p>";
    } else {
        $message = "<p class='error'>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investor Signup</title>
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

        /* Success & Error Messages */
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

<h2>Investor Signup</h2>

<?php echo $message; ?>

<div class="form-container">
    <form method="POST">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign Up</button>
    </form>
</div>

</body>
</html>
