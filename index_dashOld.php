<?php
session_start();
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header('Location: loginform.php');
    exit();
}
// Include database connection file
include_once 'db.php';
// Get user ID from session
$user_id = $_SESSION['user_id'];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process form data
    $last_name = $_POST['Last_name'];
    $first_name = $_POST['First_name'];
    $middle_name = $_POST['Middle_name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Note: You should hash the password before storing it in the database
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $social_media = $_POST['social_media'];

    // Profile picture upload
    if (isset($_FILES['profile_picture'])) {
        $file_name = $_FILES['profile_picture']['name'];
        $file_tmp = $_FILES['profile_picture']['tmp_name'];
        move_uploaded_file($file_tmp, "uploads/" . $file_name); // Save the uploaded file to a directory
        $profile_picture = "uploads/" . $file_name;
    }

    // Update user's profile in the database
    $sql = "INSERT INTO user_profile (Last_name, First_name, Middlle_name, email, password, phone_number, address, date_of_birth, gender, social_media, profile_picture) VALUES ('$last_name', '$first_name' , '$middle_name',$email','$password', '$phone_number', '$address', '$date_of_birth', '$gender', '$social_media', '$profile_picture')";

    if ($conn->query($sql) === TRUE) {
        // Profile updated successfully
        echo "Profile updated successfully";
    } else {
        // Error updating profile
        echo "Error updating profile: " . $conn->error;
    }

    $conn->close();
}
?>
