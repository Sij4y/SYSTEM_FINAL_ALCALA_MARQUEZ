<?php
session_start();
include "profile_details.php";
include "db.php"; // Include your database connection

// Check if the user is not logged in, then redirect to login page
if (!isset($_SESSION['username'])) {
    header('Location: loginform.php');
    exit;
}

// Assuming the product data is stored in the session
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Get the last added product from the cart (or adjust as needed)
    $item = end($_SESSION['cart']);
} else {
    // Handle the case where there is no product in the cart
    $item = array(
        'image' => 'default_image_path.jpg', // Provide a default image path
        'name' => 'No product',
        'price' => 0,
        'quantity' => 0,
        'size' => 'N/A'
    );
}

// Retrieve user details from the database
$username = $_SESSION['username'];
$query = "SELECT user_name, reference_no, payment_proof FROM payment WHERE user_name = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    die('Execute failed: ' . htmlspecialchars($stmt->error));
}

$user = $result->fetch_assoc();

if ($user === null) {
    // No user found
    $user = array(
        'user_name' => 'N/A',
        'reference_no' => 'N/A',
        'payment_proof' => 'default_image_path.jpg' // Provide a default image path
    );
}

// Check for payment success flag
$payment_success = isset($_SESSION['payment_success']) ? $_SESSION['payment_success'] : null;
unset($_SESSION['payment_success']); // Clear the session variable after use
?>
<!DOCTYPE html>
<html>
<head>
    <title>Payment method</title>
    <link rel="stylesheet" href="style5.css">
    <style>
        /* Add any additional CSS here */
        .form-group {
            margin-bottom: 25px;
        }
        .form-group button {
            margin-right: 10px;
        }
        .sidebar {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .product-img {
            max-width: 100%; /* Adjust maximum width as needed */
            height: auto; /* Maintain aspect ratio */
            display: block;
            margin: 0 auto; /* Center the image horizontally */
        }
        .sidebar-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px; /* Add padding for spacing */
        }
        .sidebar-footer {
            padding: 20px; /* Add padding for spacing */
        }
        .preloader {
            display: flex;
            align-items: center;
            justify-content: center;
            position: fixed;
            width: 100%;
            height: 100%;
            background: #fff;
            z-index: 9999;
            transition: transform 1s ease, opacity 1s ease;
        }
        .preloader.hidden {
            transform: translateY(-100%);
            opacity: 0;
        }
        .success-message {
            color: green;
            font-weight: bold;
        }
        .error-message {
            color: red;
            font-weight: bold;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const preloader = document.querySelector('.preloader');

            window.addEventListener('load', function() {
                setTimeout(() => {
                    preloader.classList.add('hidden');
                }, 300); // Hold the preloader for 0.4 seconds (400 milliseconds)
            });
        });
    </script>
</head>
<body>
    <!-- Preloader -->
    <div class="preloader">
        <img class="animation__shake" src="webpic/ramon.png" alt="AdminLTELogo" height="400" width="400">
    </div>
    <div class="container">
        <div class="sidebar">
            <div class="sidebar-content">
                <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="Product Image" class="product-img">
            </div>
            <div class="sidebar-footer">
                
                
            </div>
        </div>
        <div class="form-container">
    <h2>Check out status</h2>
    <?php if ($payment_success === true): ?>
        <p class="success-message" style="font-size: 50px;">Payment status Success.</p>
    <?php elseif ($payment_success === false): ?>
        <p class="error-message" style="font-size: 50px;">Payment Failed status.</p>
    <?php endif; ?>
            
            <div class="form-group">
                <button type="button" onclick="window.location.href='products.html'">Back</button>
            </div>
        </div>
    </div>
</body>
</html>