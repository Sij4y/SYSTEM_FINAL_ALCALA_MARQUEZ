<?php
session_start();
include "db.php"; // Ensure this file contains the database connection code

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mark_paid'])) {
    // Validate reference_no exists
    if (!isset($_POST['reference_no']) || empty($_POST['reference_no'])) {
        $_SESSION['message'] = "Reference number not provided.";
        header("Location: order.php");
        exit;
    }

    // Sanitize input
    $reference_no = mysqli_real_escape_string($conn, $_POST['reference_no']);

    // Update payment status to 'paid'
    $sql = "UPDATE payment SET payment_status = 'paid' WHERE reference_no = '$reference_no'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Payment status updated to Paid successfully.";
    } else {
        $_SESSION['message'] = "Error updating payment status: " . mysqli_error($conn);
    }

    mysqli_close($conn);
    header("Location: order.php");
    exit;
} else {
    $_SESSION['message'] = "Invalid request.";
    header("Location: order.php");
    exit;
}
?>