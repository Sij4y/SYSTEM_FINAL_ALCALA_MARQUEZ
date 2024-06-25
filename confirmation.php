<?php

$sname= "localhost: 4307";

$uname= "root";

$password= "";

$db_name= "cetweb";

$conn = mysqli_connect($sname, $uname, $password, $db_name);
// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['confirm_order'])) {
    $user_id = 1; // Replace with actual user ID if you have a user system

    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $product_name = $item['name'];
            $product_price = $item['price'];
            $product_size = isset($item['size']) ? $item['size'] : "N/A";
            $quantity = $item['quantity'];
            $subtotal = $product_price * $quantity;
            $order_total = $subtotal; // This assumes single item orders for simplicity

            // Insert the order details into the user table
            $stmt = $conn->prepare("INSERT INTO user (user_id, product_name, product_price, product_size, quantity, subtotal, order_total, order_date) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("isdsiid", $user_id, $product_name, $product_price, $product_size, $quantity, $subtotal, $order_total);
            $stmt->execute();
        }
    }

    // Clear the cart
    unset($_SESSION['cart']);

    // Set a flag to indicate the order has been confirmed
    $_SESSION['order_confirmed'] = true;

    // Redirect to the final confirmation page
    header("Location: final_confirmation.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style3.css">
    <style>
        body {
            background-image: url('webpic/bg3.png'); /* Set background image */
            background-size: cover; /* Cover the entire viewport */
            background-repeat: no-repeat; /* Prevent repeating of the image */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .confirmation-container {
            background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent background for better readability */
            padding: 20px;
            border-radius: 10px; /* Rounded corners */
            text-align: center;
            max-width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Add shadow for depth */
        }
        h2 {
            font-size: 28px; /* Larger heading font */
            color: #333;
        }
        p {
            font-size: 18px; /* Font size for message */
            color: #555;
        }
        .home-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px; /* Larger padding */
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px; /* Larger font */
            transition: background-color 0.3s ease;
            text-decoration: none;
        }
        .home-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="confirmation-container">
        <h2>Order Confirmed!</h2>
        <p>Thank you for your purchase. Your order has been placed successfully.</p>
        <a href="home.php" class="home-btn">Back to Home</a>
    </div>
</body>
</html>
