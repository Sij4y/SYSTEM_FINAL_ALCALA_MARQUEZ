<?php
session_start();
include "db.php"; // Include your database connection script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and retrieve form data
    $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';
    $reference_no = isset($_POST['reference_no']) ? $_POST['reference_no'] : '';
    $user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '';

    // File upload handling (only if not COD)
    $uploadFile = '';
    if ($payment_method !== 'cod') {
        $uploadDir = 'uploads/'; // Directory where uploaded files will be stored
        $uploadFile = $uploadDir . basename($_FILES['payment_proof']['name']);
        if (!move_uploaded_file($_FILES['payment_proof']['tmp_name'], $uploadFile)) {
            // Handle file upload error
            $_SESSION['payment_success'] = false;
            header("Location: checkout.php"); // Redirect back to checkout page
            exit();
        }
    }

    // Check if the product is in the cart
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        // Get the last added product from the cart
        $item = end($_SESSION['cart']);

        $image = $item['image'];
        $name = $item['name'];
        $price = $item['price'];
        $size = isset($item['size']) ? $item['size'] : 'N/A';
        $quantity = isset($item['quantity']) ? $item['quantity'] : 1;

        // Check if the product has already been paid for
        $sql_check_paid = "SELECT payment_status FROM payment WHERE product_name = ? AND user_name = ? LIMIT 1";
        $stmt_check_paid = $conn->prepare($sql_check_paid);
        $stmt_check_paid->bind_param("ss", $name, $user_name);
        $stmt_check_paid->execute();
        $stmt_check_paid->bind_result($payment_status);
        $stmt_check_paid->fetch();
        $stmt_check_paid->close();

        if ($payment_status == 'Paid') {
            $_SESSION['payment_success'] = false; // Product already paid, set failure message
            header("Location: checkout.php"); // Redirect back to checkout page
            exit();
        }

        // Determine the payment status
        $payment_status = ($payment_method === 'cod') ? 'Pending' : 'Paid';

        // Insert data into the database
        $sql = "INSERT INTO payment (user_name, product_image, product_name, price, size, quantity, reference_no, payment_method, payment_status, payment_proof)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Bind parameters to the SQL statement
        $stmt->bind_param("sssdsissss", $user_name, $image, $name, $price, $size, $quantity, $reference_no, $payment_method, $payment_status, $uploadFile);

        // Execute the SQL statement
        if ($stmt->execute()) {
            $_SESSION['payment_success'] = true; // Flag for success message
            header("Location: product_checkout.php"); // Redirect to the checkout page
            exit();
        } else {
            $_SESSION['payment_success'] = false; // Flag for failure message
            header("Location: checkout.php"); // Redirect back to checkout page
            exit();
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "No product in the cart to update.";
    }
}

// Close the database connection
$conn->close();
?>
