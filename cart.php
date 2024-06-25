<?php
session_start();
include "db.php"; // Ensure this file contains the database connection
include "profile_details.php";

// Check if the user is not logged in, then redirect to login page
if (!isset($_SESSION['username'])) {
    header('Location: loginform.php');
    exit;
}
// Initialize cart total
$cart_total = 0;

// Function to check if the product already exists in the cart
function product_exists_in_cart($product_name) {
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            if ($item['name'] === $product_name) {
                return true;
            }
        }
    }
    return false;
}

// Check if the remove button is clicked
if (isset($_GET['remove']) && isset($_GET['index'])) {
    $index = $_GET['index'];
    // Remove the product from the cart based on the index
    unset($_SESSION['cart'][$index]);
    // Reset array keys to maintain sequential indexing
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    // Redirect back to the cart page
    header("Location: cart.php");
    exit();
}

// Check if the checkout button is clicked
if (isset($_POST['checkout']) && isset($_POST['selected_product'])) {
    $selected_product = $_POST['selected_product'];
    // Set the status of the selected product to 'Paid'
    $_SESSION['cart'][$selected_product]['status'] = 'Paid';
    // Redirect to the checkout page
    header("Location: checkout.php");
    exit();
}

// Check if a new product has been added
if (isset($_POST['add_to_cart'])) {
    $new_product_name = 'New Product'; // Example product name
    if (!product_exists_in_cart($new_product_name)) {
        // Example of adding a new product to the cart
        $new_product = array(
            'image' => 'new_product_image.jpg',
            'name' => $new_product_name,
            'price' => 29.99,
            'quantity' => 1,
            // Add other fields as needed
        );

        // Add new product to the cart
        $_SESSION['cart'][] = $new_product;
    } else {
        // Handle case where product already exists in the cart
        echo "<script>alert('This product is already in the cart.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="style6.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const preloader = document.querySelector('.preloader');
            window.addEventListener('load', function() {
                setTimeout(() => {
                    preloader.classList.add('hidden');
                }, 300); // Hold the preloader for 0.4 seconds (400 milliseconds)
            });

            // JavaScript to ensure only one checkbox is checked at a time
            const checkboxes = document.querySelectorAll('input[name="selected_product"]');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        checkboxes.forEach(cb => {
                            if (cb !== this) cb.checked = false;
                        });
                    }
                });
            });

            // JavaScript to validate at least one checkbox is checked before form submission
            const checkoutForm = document.querySelector('form');
            checkoutForm.addEventListener('submit', function(event) {
                const isChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
                if (!isChecked) {
                    event.preventDefault();
                    alert('Please select at least one product to proceed with checkout.');
                }
            });
        });
    </script>
    <style>
        /* Add any additional CSS styles here */
        input[type="checkbox"] {
            accent-color: orange;
        }
        .subtotal {
            color: orange;
        }
    </style>
</head>
<body>
    <!-- Preloader -->
    <div class="preloader">
        <img class="animation__shake" src="webpic/ramon.png" alt="Preloader Image" height="400" width="400">
    </div>

    <!-- Navbar -->
    <div class="container">
        <div class="navbar">
            <div class="logo">
                <a href="index.html"><img src="webpic/logo3.png" width="125px"></a>
            </div>
            <nav>
                <ul id="MenuItems">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="products.html">Products</a></li>
                    <li><a href="edit_profile.php">Account</a></li>
                </ul>
            </nav>
            <a href="cart.php"><img src="webpic/cart.png" class="cart-img" width="30px" height="30px"></a>
            <img src="webpic/menu.png" class="menu-icon" onClick="menutoggle()">
        </div>
    </div>

    <!-- Shopping Cart -->
    <div class="container">
        <h2>Shopping Cart</h2>
        <form method="post" action="cart.php">
            <table>
                <tr>
                    <th></th> <!-- Checkbox column header -->
                    <th>Product</th>
                    <th>Price</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
                <?php
                if (!empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $index => $item) {
                        $subtotal = $item['price'] * $item['quantity'];
                        $cart_total += $subtotal;
                        ?>
                        <tr>
                            <td><input type="checkbox" name="selected_product" value="<?php echo $index; ?>"></td> <!-- Checkbox for each product -->
                            <td>
                                <img src="<?php echo $item['image']; ?>" alt="Product Image" class="product-img">
                                <div>
                                    <p><?php echo $item['name']; ?></p>
                                </div>
                            </td>
                            <td><?php echo $item['price']; ?></td>
                            <td><?php echo isset($item['size']) ? $item['size'] : "N/A"; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td class="subtotal"><?php echo $subtotal; ?></td> <!-- Add class 'subtotal' to subtotal cell -->
                            <td><button class="remove-btn" type="button" onclick="removeProduct(<?php echo $index; ?>)">Remove</button></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="7">Your cart is empty.</td>
                    </tr>
                    <?php
                }
                ?>
                <tr class="total">
                    <td colspan="4">Total:</td>
                    <td colspan="3" class="subtotal"><?php echo $cart_total; ?></td> <!-- Add class 'subtotal' to total cell -->
                </tr>
            </table>

            <!-- Checkout Button -->
            <?php if (!empty($_SESSION['cart'])): ?>
            <button type="submit" name="checkout" class="checkout-btn">Checkout</button>
            <?php endif; ?>
        </form>
    </div>

    <!-- JavaScript for Removing Product and Menu Toggle -->
    <script>
        function removeProduct(index) {
            // Redirect to the same page with remove parameter and index
            window.location.href = "cart.php?remove=true&index=" + index;
        }

        var menuItems = document.getElementById("MenuItems");
        menuItems.style.maxHeight = "0px";
        function menutoggle() {
            if(menuItems.style.maxHeight == "0px") {
                menuItems.style.maxHeight = "200px";
            } else {
                menuItems.style.maxHeight = "0px";
            }
        }
    </script>
</body>
</html>
