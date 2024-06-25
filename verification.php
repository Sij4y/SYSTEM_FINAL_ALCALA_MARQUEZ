<?php
// // Connection to the database
include "db.php";

// Retrieve the email and verification code from the URL
$email = $_GET['email'];
$verification_code = $_GET['code'];

// Check if the verification code exists in the database
$sql = "SELECT * FROM user WHERE Email='$email' AND verification_code='$verification_code'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Update the 'verified' column to 1
    $verified = '1';
    $sql_update = "UPDATE user SET verified = '$verified' WHERE Email='$email' AND verification_code='$verification_code'";
    if (mysqli_query($conn, $sql_update)) {
      //  redirect to a success page or display a success message
        header("Location: loginform.php");

    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    echo "Invalid verification code.";
}

// Closing the database connection
mysqli_close($conn);
?>