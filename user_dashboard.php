<?php
// user_dashboard.php

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "grocery_delivery";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle adding items to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $item_id = $_POST['item_id'];
    $user_id = 1; // You should get this from session or login

    $stmt = $conn->prepare("INSERT INTO cart (user_id, item_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $item_id);

    if ($stmt->execute()) {
        echo "Item added to cart.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch product categories
$categories = $conn->query("SELECT * FROM categories");

// Fetch items from each shop
$items = $conn->query("SELECT i.id, i.item_name, i.quantity, i.details, i.location, i.delivery_date, i.delivery_time, s.shopname 
                        FROM items i 
                        JOIN shops s ON i.shop_id = s.id");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
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
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .categories, .items {
            margin-bottom: 20px;
        }
        .categories h2, .items h2 {
            margin-bottom: 15px;
        }
        .categories ul, .items ul {
            list-style-type: none;
            padding: 0;
        }
        .categories li, .items li {
            margin-bottom: 10px;
        }
        .items ul {
            display: flex;
            flex-wrap: wrap;
        }
        .items .item {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            flex: 1;
            max-width: calc(33.333% - 20px);
            box-sizing: border-box;
        }
        .item h3 {
            margin-top: 0;
        }
        .form-group input[type="number"] {
            width: 100px;
        }
        .btn {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px 0;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>User Dashboard</h1>
    </div>

    <div class="container">
        <div class="categories">
            <h2>Product Categories</h2>
            <ul>
                <?php while ($row = $categories->fetch_assoc()): ?>
                <li><?php echo htmlspecialchars($row['category_name']); ?></li>
                <?php endwhile; ?>
            </ul>
        </div>

        <div class="items">
            <h2>Available Items</h2>
            <ul>
                <?php while ($row = $items->fetch_assoc()): ?>
                <li class="item">
                    <h3><?php echo htmlspecialchars($row['item_name']); ?></h3>
                    <p>Shop: <?php echo htmlspecialchars($row['shopname']); ?></p>
                    <p>Quantity: <?php echo htmlspecialchars($row['quantity']); ?></p>
                    <p>Details: <?php echo htmlspecialchars($row['details']); ?></p>
                    <p>Location: <?php echo htmlspecialchars($row['location']); ?></p>
                    <p>Estimated Delivery: <?php echo htmlspecialchars($row['delivery_date']) . ' ' . htmlspecialchars($row['delivery_time']); ?></p>
                    <form action="user_dashboard.php" method="post">
                        <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                        <button type="submit" name="add_to_cart" class="btn">Add to Cart</button>
                    </form>
                </li>
                <?php endwhile; ?>
            </ul>
        </div>

        <div class="cart">
            <h2>Your Cart</h2>
            <p>Cart details would go here.</p>
            <!-- Display cart items and total here -->
            <form action="checkout.php" method="post">
                <button type="submit" class="btn">Proceed to Checkout</button>
            </form>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 Grocery Delivery Application. All rights reserved.</p>
    </div>
</body>
</html>

<?php
$conn->close();
?>
