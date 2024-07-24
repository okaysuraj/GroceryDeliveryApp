<?php
// process_register_shop.php

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

// Get POST data
$shopname = $_POST['shopname'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO shops (shopname, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $shopname, $email, $password);

if ($stmt->execute()) {
    echo "New shop registered successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
