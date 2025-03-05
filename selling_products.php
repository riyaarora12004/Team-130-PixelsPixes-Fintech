<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Signup</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #FAE1DD;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            text-align: center;
        }

        h1 {
            color: #2F4858;
            font-size: 32px;
            margin-bottom: 10px;
        }

        p {
            font-size: 18px;
            color: #444;
        }

        .main-buttons {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .main-buttons button {
            background-color: #2F4858;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 18px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .main-buttons button:hover {
            background-color: #D67D7D;
        }

        .form-container {
            margin-top: 30px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease-in-out;
        }

        .form-container:hover {
            transform: scale(1.02);
        }

        .form-container button {
            background-color: #2F4858;
            color: white;
            border: none;
            padding: 10px 16px;
            font-size: 16px;
            margin: 5px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: #D67D7D;
        }
    </style>
</head>
<body>
    <h1>Welcome to Our Platform</h1>
    <p>Please choose an option:</p>

    <form method="post" class="main-buttons">
        <button type="submit" name="user">User</button>
        <button type="submit" name="seller">Seller</button>
        <button type="button" onclick="window.location.href='seller_dashboard.php'">Browse Products</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['user'])) {
            echo '<div class="form-container">
                    <form action="user_login.php" method="post">
                        <button type="submit">User Login</button>
                    </form>
                    <form action="user_signup.php" method="post">
                        <button type="submit">User Signup</button>
                    </form>
                  </div>';
        }
        
        if (isset($_POST['seller'])) {
            echo '<div class="form-container">
                    <form action="seller_login.php" method="post">
                        <button type="submit">Seller Login</button>
                    </form>
                    <form action="seller_signup.php" method="post">
                        <button type="submit">Seller Signup</button>
                    </form>
                  </div>';
        }
    }
    ?>
</body>
</html>
