<?php
// Connection from the database
include "db.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoload file
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get user input from the registrationform.php
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'];
    $last_name = $_POST['Last_name'];
    $first_name = $_POST['First_name'];
    $middle_name = $_POST['Middle_name'];
    $Email = $_POST['Email'];
    $Status = $_POST['Status'];

    // Check if fields are empty
    if (empty($username)) {
        header("Location: registrationform.php?error=Add username.");
        exit();
    }

    if (empty($password)) {
        header("Location: registrationform.php?error=Add password.");
        exit();
    }

    if (empty($last_name) || empty($first_name)) {
        header("Location: registrationform.php?error=Complete the following requirements.");
        exit();
    }

    if (empty($Email)) {
        // Redirect back to the registration form with an error message
        header("Location: registrationform.php?error=Please add an email address.");
        exit();
    } elseif (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        // Redirect back to the registration form with an error message
        header("Location: registrationform.php?error=Invalid email.");
        exit();
    }

    // Check if username already exists in the database
    $username_check_query = "SELECT * FROM user WHERE Username='$username' LIMIT 1";
    $result = mysqli_query($conn, $username_check_query);
    $user = mysqli_fetch_assoc($result);
    if ($user) {
        $existingUsername = $user['Username'];
        header("Location: registrationform.php?error=Username '$existingUsername' already exists. Please try another one.");
        exit();
    }

    // Check if email already exists in the database
    $email_check_query = "SELECT * FROM user WHERE Email='$Email' LIMIT 1";
    $result = mysqli_query($conn, $email_check_query);
    $user = mysqli_fetch_assoc($result);
    if ($user) {
        $existingEmail = $user['Email'];
        header("Location: registrationform.php?error='$existingEmail' already exists. Please try another one.");
        exit();
    }

    // Generate verification code
    $verification_code = mt_rand(100000, 999999);

    // Insert the new user into the database
    $sql = "INSERT INTO user (username, password, Last_name, First_name, Middle_name, Email, Status, verification_code)
            VALUES ('$username', '$password', '$last_name', '$first_name', '$middle_name', '$Email', '$Status', '$verification_code')";

    // Executing the SQL query
    if (mysqli_query($conn, $sql)) {
        // Get the user_id of the inserted record
        $user_id = mysqli_insert_id($conn);

        // Concatenate first name, middle name, and last name into full name
        $full_name = trim("$first_name $middle_name $last_name");

        $query = "INSERT INTO user_profile (user_id, full_name) VALUES ('$user_id', '$full_name')";
        if (mysqli_query($conn, $query)) {
            try {
                // SMTP configuration
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';  // SMTP server address
                $mail->SMTPAuth = true;
                $mail->Username = 'ricoalcala902@gmail.com';  // SMTP username
                $mail->Password = 'ggqk lith serc auor';  // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  // Enable TLS encryption
                $mail->Port = 465;  // TCP port to connect to

                // Email content
                $mail->setFrom('ricoalcala902@gmail.com');
                $mail->addAddress($Email);
                $mail->isHTML(true);
                $mail->Subject = 'Email Verification';
                $mail->Body = 'Please click the "verify" link to verify your email: <a href="http://localhost/system/verification.php?email=' . $Email . '&code=' . $verification_code . '">Verify</a>';

                // Send email
                $mail->send();
                header("Location: register_compt.php?message=Verification email sent. Please check your email to verify your account.");
            } catch (Exception $e) {
                header("Location: registrationform.php?error=Failed to send verification email. Please try again later.");
            }
        } else {
            echo "ERROR: Hush! Sorry $sql. " . mysqli_error($conn);
        }
    }
}

// Closing the database connection
mysqli_close($conn);
?>
