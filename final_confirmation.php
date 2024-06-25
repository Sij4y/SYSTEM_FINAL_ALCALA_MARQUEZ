<?php
session_start(); // Start the session

// Check if the order has been confirmed
if (!isset($_SESSION['order_confirmed']) || $_SESSION['order_confirmed'] !== true) {
    // Redirect to the home page if the order has not been confirmed
    header("Location: home.php");
    exit();
}

// Clear the order confirmation flag after displaying the message
unset($_SESSION['order_confirmed']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Confirmation</title>
    <link rel="stylesheet" href="style.css"> <!-- Add your CSS file -->
</head>
<body>
    <div class="confirmation-message">
        <h2>Order Confirmed!</h2>
        <p>Your order has been successfully placed. Thank you for shopping with us!</p>
    </div>
</body>
</html>
