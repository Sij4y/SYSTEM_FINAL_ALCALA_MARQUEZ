<?php
session_start();
include "profile_details.php";

// Check if the user is not logged in, then redirect to login page
if (!isset($_SESSION['username'])) {
    header('Location: loginform.php');
    exit;
}
?>
<html>
    
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
        <title>CET ONLINE STORE website</title>
        <link rel="stylesheet" href="style.css">
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
    <div class ="header"> <!-- Header section begins -->
    <div class="container"> <!-- Container for header content -->
        <div class="navbar"> <!-- Navigation bar -->
            <div class="logo"> <!-- Logo -->
                <a href="home.php"><img src="webpic/ramon.png" width="125px"></a>
            </div>
            <nav>
                <ul id="MenuItems"> <!-- List of navigation items -->
                    <li><a href="admin.php">Home</a></li>
                     <li><a href="order.php">Orders</a></li>
                     <li><a href="logout.php">Logout</a></li>
                  
                     

                </ul>
            </nav>
          
        </div>
        <div class="row"> <!-- Header content row -->
            <div class="col-2">
                <h1>Admin<br>account</h1> <!-- Heading -->
             
            </div>
            <div class="col-2">
                <img src="webpic/logo1.png"> <!-- Logo image -->
            </div>
        </div>
    </div>
</div> 
        

        
        
        <!-----------------------------------js for toggle menu----------------------------------------------->
        <script>
            var menuItems=document.getElementById("MenuItems"); // Getting the element with ID "MenuItems"
            
            MenuItems.style.maxHeight="0px"; // Setting the maximum height of MenuItems to 0px initially
            function menutoggle(){ // Function to toggle menu visibility
                if(MenuItems.style.maxHeight == "0px"){ // If menu is closed
                    MenuItems.style.maxHeight="200px"; // Open the menu by setting max height to 200px
                }
                else{ // If menu is open
                    MenuItems.style.maxHeight="0px"; // Close the menu by setting max height back to 0px
                }
            }
</script>

    </body>
</html>