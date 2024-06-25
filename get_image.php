<?php
// Include the database connection file
include 'db.php';

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Fetch the user's profile information from the database
    $userId = $_SESSION['user_id'];
    $query = "SELECT profile_picture FROM user_profile WHERE user_id = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $query);

    // Check if the statement was prepared correctly
    if ($stmt) {
        // Bind the user ID parameter to the statement
        mysqli_stmt_bind_param($stmt, 'i', $userId);
        // Execute the query
        mysqli_stmt_execute($stmt);
        // Store the result
        mysqli_stmt_store_result($stmt);
        // Bind the result to the $profile_picture variable
        mysqli_stmt_bind_result($stmt, $profile_picture);

        // Fetch the profile picture if it exists
        if (mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_fetch($stmt);
            // No need to base64 encode, simply use the URL/path
        } else {
            // No profile picture found, handle the error (show default, etc.)
            $profile_picture = null;
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Handle statement preparation error
        echo "Failed to prepare the SQL statement: " . mysqli_error($conn);
    }
} else {
    echo "User is not logged in.";
}

// // Close the database connection
// mysqli_close($conn);
?>
