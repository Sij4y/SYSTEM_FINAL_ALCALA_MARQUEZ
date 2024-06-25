<?php
session_start();
include "profile_details.php";

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
        'price' => 0
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
                }, 300); // Hold the preloader for 0.3 seconds (300 milliseconds)
            });

            const paymentMethodSelect = document.getElementById('payment_method');
            const referenceNoInput = document.getElementById('reference_no');
            const paymentProofInput = document.getElementById('payment_proof');
            const accountNameGroup = document.getElementById('account_name_group');
            const paymentProofGroup = document.getElementById('payment_proof_group');

            paymentMethodSelect.addEventListener('change', function() {
                if (paymentMethodSelect.value === 'cod') {
                    referenceNoInput.value = Math.floor(10000 + Math.random() * 90000); // Generate a random 5-digit number
                    referenceNoInput.readOnly = true; // Make the reference number input read-only
                    paymentProofInput.removeAttribute('required'); // Make payment proof optional for COD
                    paymentProofGroup.style.display = 'none'; // Hide payment proof field
                } else {
                    referenceNoInput.value = '';
                    referenceNoInput.readOnly = false; // Make the reference number input editable
                    paymentProofInput.setAttribute('required', ''); // Make payment proof required for other payment methods
                    paymentProofGroup.style.display = 'block'; // Show payment proof field
                }
            });

            // Trigger change event to set initial state based on default selection
            paymentMethodSelect.dispatchEvent(new Event('change'));
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
                <p><strong>Quantity:</strong> <?php echo htmlspecialchars($item['quantity']); ?></p>
                <p><strong>Price:</strong> <?php echo htmlspecialchars($item['price']); ?></p>
                <p><strong>Size:</strong> <?php echo isset($item['size']) ? htmlspecialchars($item['size']) : 'N/A'; ?></p>
                <p><strong>GCash:</strong> 09306247025</p>
            </div>
        </div>
        <div class="form-container">
            <h2>Payment method</h2>
            <?php if ($payment_success === true): ?>
                <p class="success-message">Payment successful!</p>
            <?php elseif ($payment_success === false): ?>
                <p class="error-message">Payment failed!</p>
            <?php endif; ?>
            <form action="db_checkout.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="payment_method">Payment Method</label>
                    <select id="payment_method" name="payment_method" required>
                        <option value="gcash">GCash</option>
                        <option value="maya">PayMaya</option>
                        <option value="cod">Cash on Delivery (COD)</option>
                    </select>
                </div>
                <div class="form-group" id="account_name_group">
                    <label for="user_name">Account Name or Just put NA if COD</label>
                    <input type="text" id="user_name" name="user_name" required>
                </div>
                <div class="form-group">
                    <label for="reference_no">Reference No</label>
                    <input type="text" id="reference_no" name="reference_no" pattern="[0-9]{13}" title="Please enter exactly 13 digits" required>
                </div>
                <div class="form-group" id="payment_proof_group">
                    <label for="payment_proof">Upload a screenshot of your payment proof.</label>
                    <input type="file" id="payment_proof" name="payment_proof" accept="image/*" required>
                </div>
                <div class="form-group">
                    <button type="button" onclick="window.location.href='cart.php'">Back</button>
                    <button type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
