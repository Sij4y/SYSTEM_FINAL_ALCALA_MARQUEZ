<?php
session_start(); // Start the session to store cart data

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the add to cart button is clicked
    if (isset($_POST['add_to_cart'])) {
        // Get the product data from the form
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_quantity = $_POST['quantity'];
        $product_image = $_POST['product_image'];
        $product_size = $_POST['size']; // Add this line to get the selected size

        // Create an array to hold product data
        $product_data = array(
            'id' => $product_id,
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => $product_quantity,
            'image' => $product_image,
            'size' => $product_size // Add the selected size to the product data
        );

        // Add the product data to the session cart array
        $_SESSION['cart'][] = $product_data;

        // Redirect back to the page after adding the product to the cart
        header("Location: cart.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products - CET ONLINE</title>
    <link rel="stylesheet" href="style2.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            background-image: url('webpic/newbg22.png'); /* Set background image */
            background-size: cover; /* Cover the entire viewport */
            background-repeat: no-repeat; /* Prevent repeating of the image */
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
    <script>
        function validateForm() {
            var selectedSize = document.getElementById("size").value;
            if (selectedSize == "Select Size") {
                alert("Please select a size before adding to cart.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <!-- Preloader -->
    <div class="preloader">
        <img class="animation__shake" src="webpic/ramon.png" alt="AdminLTELogo" height="400" width="400">
    </div>
<div class="container">
    <div class="navbar">
        <div class="logo">
            <a href="home.php"><img src="webpic/logo3.png" width="125px"></a>
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

<div class="small-container single-product">
    <div class="row">
        <div class="col-2">
            <img src="webpic/s3.png" width="100%" class="product-img-hover">
        </div>
        <div class="col-2">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm();">
                <p>TSHIRT</p>
                <h1>CET TSHIRT MEN</h1>
                <h4>P300</h4>
                <input type="hidden" name="product_id" value="1">
                <input type="hidden" name="product_name" value="CET OFFICIALS">
                <input type="hidden" name="product_price" value="300">
                <input type="hidden" name="product_image" value="webpic/s3.png">

                <select id="size" name="size">
                    <option>Select Size</option>
                    <option value="Small">Small</option>
                    <option value="Medium">Medium</option>
                    <option value="Large">Large</option>
                    <option value="Extra-large">Extra Large</option>
                    <option value="Double-extra-large">Double Extra Large</option>
                </select>

                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" value="1" min="1">
                <br><br>
                <div class="buttons">
                    <button type="submit" name="add_to_cart" class="btn btn-buy">
                    <img src="webpic/cart.png" alt="Cart" class="btn-icon"> Add to Cart
                    
                </div>
            </form>
        </div>
    </div>
</div>

<div class="size-chart">
    <h2>Size Chart</h2>
    <table>
        <tr>
            <th>US Size</th>
            <th>Chest (inches)</th>
            <th>Waist (inches)</th>
            <th>Hip (inches)</th>
        </tr>
        <tr>
            <td>Small</td>
            <td>34-36</td>
            <td>28-30</td>
            <td>34-36</td>
        </tr>
        <tr>
            <td>Medium</td>
            <td>38-40</td>
            <td>32-34</td>
            <td>38-40</td>
        </tr>
        <tr>
            <td>Large</td>
            <td>42-44</td>
            <td>36-38</td>
            <td>42-44</td>
        </tr>
        <tr>
            <td>X-Large</td>
            <td>46-48</td>
            <td>40-42</td>
            <td>46-48</td>
        </tr>
        <tr>
            <td>Double Extra Large</td>
            <td>46-48</td>
            <td>40-42</td>
            <td>46-48</td>
        </tr>
    </table>
</div>

<script>
    var menuItems = document.getElementById("MenuItems");

    menuItems.style.maxHeight = "0px";

    function menutoggle() {
        if (menuItems.style.maxHeight == "0px") {
            menuItems.style.maxHeight = "200px";
        } else {
            menuItems.style.maxHeight = "0px";
        }
    }
</script>
</body>
</html>
