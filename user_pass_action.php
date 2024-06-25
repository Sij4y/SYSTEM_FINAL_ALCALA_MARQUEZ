<?php
// Include the database connection file
include "db.php";

// Start session (needed for accessing session variables)
session_start();

// Get Logged-In User Information
$user_id = $_SESSION['user_id']; // Assuming user ID is stored in the session after login

// SQL Query: Select user data from the 'user' table based on the session user_id
$sql_user = "SELECT user_id, password FROM user WHERE user_id = ?";
$stmt_user = mysqli_prepare($conn, $sql_user);
mysqli_stmt_bind_param($stmt_user, "i", $user_id);
mysqli_stmt_execute($stmt_user);
$result_user = mysqli_stmt_get_result($stmt_user);

if ($result_user && mysqli_num_rows($result_user) > 0) {
    $row_user = mysqli_fetch_assoc($result_user);
    $current_password_db = $row_user['password'];

    // Get User Inputs from Form
    $current_password = $_POST['currentPassword'];
    $new_password = $_POST['newPassword'];
    $confirm_password = $_POST['confirmPassword'];

    // Input Validation
    $errors = array(); 

    // Verify current password
    if ($current_password !== $current_password_db) {
        $errors[] = "Current password is incorrect.";
    }

    // Validate new password and confirmation
    if ($new_password !== $confirm_password) {
        $errors[] = "New password and confirm password do not match.";
    }

    // Check if new password is different from the old one
    if ($new_password === $current_password) {
        $errors[] = "New password cannot be the same as your current password.";
    }

    // Validate password strength: at least one letter and one number
    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]+$/', $new_password)) { 
        $errors[] = "New password must contain at least one letter and one number.";
    }

    // Check if new password exists in password history
    $sql_history_check = "SELECT * FROM password_history WHERE user_id = ?";
    $stmt_history_check = mysqli_prepare($conn, $sql_history_check);
    mysqli_stmt_bind_param($stmt_history_check, "i", $user_id);
    mysqli_stmt_execute($stmt_history_check);
    $result_history_check = mysqli_stmt_get_result($stmt_history_check);

    while ($row_history = mysqli_fetch_assoc($result_history_check)) {
        if ($new_password === $row_history['password']) {
            $errors[] = "New password has been used before. Please choose a different password.";
            break;
        }
    }

    // Handle Validation Errors
    if (!empty($errors)) {
        $_SESSION['user_pass_error'] = implode(", ", $errors); 
        header("Location: security_dash.php");
        exit();
    }

    // Update User Password in the Database
    $sql = "UPDATE user SET password = ? WHERE user_id = ?";
    $stmt_update = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt_update, 'si', $new_password, $user_id); 

    if (mysqli_stmt_execute($stmt_update)) {
        // Insert into password history
        $sql_history = "INSERT INTO password_history (user_id, password, date_updated) VALUES (?, ?, NOW())"; 
        $stmt_history = mysqli_prepare($conn, $sql_history);
        mysqli_stmt_bind_param($stmt_history, 'is', $user_id, $new_password);
        mysqli_stmt_execute($stmt_history);

        $_SESSION['user_pass_success'] = "Your password has been updated successfully";
        header("Location: security_dash.php");
    } else {
        $error_message = mysqli_error($conn);
        $error_message = urlencode("Your password could not be updated: $error_message");
        $_SESSION['user_pass_error'] = $error_message;
        header("Location: security_dash.php");
        exit();
    }
} else {
    $_SESSION['user_pass_error'] = "User not found";
    header("Location: security_dash.php");
    exit();
}
?>
