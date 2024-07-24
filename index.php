<?php
// index.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grocery Delivery Application</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f8ff;
            color: #333;
        }
        .header, .footer {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 10px 0;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 80vh;
        }
        .btn {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .footer {
            position: absolute;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Welcome to Grocery Delivery</h1>
    </div>

    <div class="container">
        <h2>Get Started</h2>
        <a href="register_user.php" class="btn">Register New User</a>
        <a href="login_user.php" class="btn">Login as User</a>
        <a href="login_shop.php" class="btn">Login as Shop</a>
        <a href="register_shop.php" class="btn">Register as Shop</a>
    </div>

    <div class="footer">
        <p>&copy; 2024 Grocery Delivery Application. All rights reserved.</p>
    </div>
</body>
</html>
