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
        <!--added a cdn link by searching font awesome4 cdn and getting this link from https://www.bootstrapcdn.com/fontawesome/ this url*/-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            body {
                background-image: url('webpic/newbg22.png'); /* Set background image */
                background-size: cover; /* Cover the entire viewport */
                background-repeat: no-repeat; /* Prevent repeating of the image */
            }
        </style>
  </head>
    <body>
        <!--<div class ="header">-->
        <div class="container">
            <div class="navbar">
                <div class="logo">
                <a href="home.php"><img src="webpic/logo3.png" width="125px"></a>
                </div>
                <nav>
                    <ul id="MenuItems">
                        <li><a href="home.php">Home</a></li>
                         <li><a href="products3.html">Products</a></li>
                         <li><a href="account.html">Account</a></li>

                    </ul>
                </nav>
                <a href="cart.html"><img src="webpic/cart.png" class="cart-img" width="30px" height="30px"></a>
                <img src="webpic/menu.png" class="menu-icon" onClick="menutoggle()" >
            </div>
           
        </div>

<div class="small-container single-product">
    <div class="row">
        <div class="col-2">
            <img src="webpic/itcard1.png" width="100%" class="product-img-hover">
            <img src="webpic/itcard2.png" width="100%" class="product-img-hover">
        </div>
        <div class="col-2">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <p>CARD</p>
                <h1>BSIT CARD </h1>
                <h4>P50</h4>
                <input type="hidden" name="product_id" value="1">
                <input type="hidden" name="product_name" value="BSIT CARD">
                <input type="hidden" name="product_price" value="50">
                <input type="hidden" name="product_image" value="webpic/itcard1.png">



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
    <!-- </form>  -->
</body>
</html>


       <script>
document.getElementById("add-to-cart-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the default form submission

    // Get the selected size
    var selectedSize = document.getElementById("size").value;

    // Retrieve product information from hidden input fields
    var productId = document.querySelector('input[name="product_id"]').value;
    var productName = document.querySelector('input[name="product_name"]').value;
    var productPrice = document.querySelector('input[name="product_price"]').value;
    var productImage = document.querySelector('input[name="product_image"]').value;

    // You can now do something with the selected size and product information, like add it to the cart or perform further processing
    console.log("Selected size: " + selectedSize);
    console.log("Product ID: " + productId);
    console.log("Product Name: " + productName);
    console.log("Product Price: " + productPrice);
    console.log("Product Image: " + productImage);
    // For example, you might want to send this information to a server using AJAX to add the item to the cart
    // Here, we're just logging it to the console for demonstration purposes
});
</script>

<script>
            var menuItems=document.getElementById("MenuItems");
            
            MenuItems.style.maxHeight="0px";
            function menutoggle(){
                if(MenuItems.style.maxHeight == "0px"){
                    MenuItems.style.maxHeight="200px";
                }
                else{
                    MenuItems.style.maxHeight="0px";
                }
            }
        </script>

        