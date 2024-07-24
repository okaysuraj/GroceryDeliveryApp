<?php
// shop_dashboard.php

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

// Handle item addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_item'])) {
    $item_name = $_POST['item_name'];
    $quantity = $_POST['quantity'];
    $details = $_POST['details'];
    $location = $_POST['location'];
    $delivery_date = $_POST['delivery_date'];
    $delivery_time = $_POST['delivery_time'];

    $stmt = $conn->prepare("INSERT INTO items (item_name, quantity, details, location, delivery_date, delivery_time) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sissss", $item_name, $quantity, $details, $location, $delivery_date, $delivery_time);

    if ($stmt->execute()) {
        echo "Item added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Handle item deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_item'])) {
    $item_id = $_POST['item_id'];

    $stmt = $conn->prepare("DELETE FROM items WHERE id = ?");
    $stmt->bind_param("i", $item_id);

    if ($stmt->execute()) {
        echo "Item deleted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch items for display
$result = $conn->query("SELECT id, item_name, quantity, details, location, delivery_date, delivery_time FROM items");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Dashboard</title>
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
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
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
            margin: 10px 0;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .item-list {
            margin-top: 20px;
        }
        .item-list table {
            width: 100%;
            border-collapse: collapse;
        }
        .item-list table, .item-list th, .item-list td {
            border: 1px solid #ddd;
        }
        .item-list th, .item-list td {
            padding: 10px;
            text-align: left;
        }
        .item-list th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Shop Dashboard</h1>
    </div>

    <div class="container">
        <h2>Add New Item</h2>
        <form action="shop_dashboard.php" method="post">
            <div class="form-group">
                <label for="item_name">Item Name:</label>
                <input type="text" id="item_name" name="item_name" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" required>
            </div>
            <div class="form-group">
                <label for="details">Details:</label>
                <textarea id="details" name="details" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="location">Shop Location:</label>
                <input type="text" id="location" name="location" required>
            </div>
            <div class="form-group">
                <label for="delivery_date">Estimated Delivery Date:</label>
                <input type="date" id="delivery_date" name="delivery_date" required>
            </div>
            <div class="form-group">
                <label for="delivery_time">Estimated Delivery Time:</label>
                <input type="time" id="delivery_time" name="delivery_time" required>
            </div>
            <button type="submit" name="add_item" class="btn">Add Item</button>
        </form>

        <h2>Manage Items</h2>
        <div class="item-list">
            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Details</th>
                        <th>Location</th>
                        <th>Delivery Date</th>
                        <th>Delivery Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($row['details']); ?></td>
                        <td><?php echo htmlspecialchars($row['location']); ?></td>
                        <td><?php echo htmlspecialchars($row['delivery_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['delivery_time']); ?></td>
                        <td>
                            <form action="shop_dashboard.php" method="post" style="display:inline;">
                                <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                <button type="submit" name="delete_item" class="btn" style="background-color:#f44336;">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
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
