<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Signup</title>
    <style>
        /* General Page Styling */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #FAE1DD, #F8C5B0);
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
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        p {
            font-size: 18px;
            color: #555;
            margin-bottom: 20px;
        }

        /* Button Styling */
        .main-buttons {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .main-buttons button {
            background: #2F4858;
            color: white;
            border: none;
            padding: 14px 24px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.4s ease-in-out;
            box-shadow: 3px 3px 8px rgba(0, 0, 0, 0.2);
            text-transform: uppercase;
        }

        .main-buttons button:hover {
            background: #D67D7D;
            transform: translateY(-4px);
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.3);
        }

        /* Form Container Styling */
        .form-container {
            margin-top: 30px;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
            transition: all 0.4s ease-in-out;
            width: 300px;
        }

        .form-container:hover {
            transform: scale(1.05);
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.4);
        }

        .form-container button {
            background: #2F4858;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
            width: 100%;
            margin: 5px 0;
        }

        .form-container button:hover {
            background: #D67D7D;
            transform: scale(1.05);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-buttons {
                flex-direction: column;
                gap: 15px;
            }
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
