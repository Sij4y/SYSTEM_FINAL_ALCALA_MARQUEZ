<?php
session_start();
include "db.php";

if (isset($_POST['username']) && isset($_POST['password'])) { 
    // Validate user input
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Validate username and password
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);

    // Check if the username is empty
    if (empty($username)) {
        header("Location: Loginform.php?error=Username is required");
        exit();
    // Check if the password is empty
    } else if (empty($password)) {
        header("Location: Loginform.php?error=Password is required");
        exit();
    } else {
        // Check the admin table for matching username and password
        $sql_admin = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
        $result_admin = mysqli_query($conn, $sql_admin);

        // If admin credentials match, redirect to admin.php
        if (mysqli_num_rows($result_admin) === 1) {
            $row_admin = mysqli_fetch_assoc($result_admin);
            $_SESSION['username'] = $row_admin['username'];
            $_SESSION['admin_id'] = $row_admin['user_id'];
            header("Location: admin.php");
            exit();
        } else {
            // Query the database to check if the username and password match for regular users
            $sql_user = "SELECT * FROM user WHERE username='$username' AND password='$password'";
            $result_user = mysqli_query($conn, $sql_user);

            // If user input matches, log in the user and redirect to the home page
            if (mysqli_num_rows($result_user) === 1) {
                $row_user = mysqli_fetch_assoc($result_user);

                if ($row_user['verified'] == 0) {
                    // User is not verified, redirect with an error message
                    header("Location: loginform.php?error=Please verify your email first. Check your email for the verification link.");
                    exit();
                }

                $Active = 'Online';
                $sql_active = "UPDATE user SET Active = '$Active' WHERE username = '$username'";
                mysqli_query($conn, $sql_active);

                if ($row_user['username'] === $username && $row_user['password'] === $password) {
                    echo "Logged in!";
                    $_SESSION['username'] = $row_user['username'];
                    $_SESSION['name'] = $row_user['name'];
                    $_SESSION['user_id'] = $row_user['user_id'];
                    header("Location: home.php");
                    exit();
                } else {
                    // Redirect to the login form with an error message
                    header("Location: Loginform.php?error=Incorrect Username or password");
                    exit();
                }
            } else {
                // Redirect to the login form with an error message
                header("Location: Loginform.php?error=Incorrect Username or password");
                exit();
            }
        }
    }
} else {
    // Redirect to the login form if username and password are not set
    header("Location: Loginform.php");
    exit();
}
?>
