<?php
session_start();
include 'db.php';

$message = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['First_name'];
    $last_name = $_POST['Last_name'];
    $middle_name = $_POST['Middle_name'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $social_media = $_POST['social_media'];
    $education = isset($_POST['education']) ? $_POST['education'] : ''; // Optional field
    $job = isset($_POST['job']) ? $_POST['job'] : ''; // Optional field
    $skills = isset($_POST['skills']) ? $_POST['skills'] : ''; // Optional field

    // Handle Profile Picture Upload
    $profile_picture = '';
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif']; // Allowed image types

    if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] == UPLOAD_ERR_OK) {
        if (in_array($_FILES["profile_picture"]["type"], $allowed_types)) {
            $profile_picture = file_get_contents($_FILES["profile_picture"]["tmp_name"]);
            $profile_picture = mysqli_real_escape_string($conn, $profile_picture);
        } else {
            header("Location: edit_profile.php?error=" . urlencode("Invalid file type. Please upload an image (JPEG, PNG, or GIF)"));
            exit();
        }
    }

    // Validate Phone Number
    if (!empty($phone_number) && !preg_match('/^\+[1-9]{1}[0-9]{3,14}$/', $phone_number)) {
        header("Location: edit_profile.php?error=" . urlencode("Invalid phone number format"));
        exit();
    }

    // Validate Social media
    if (!empty($social_media) && !preg_match('/^(https?:\/\/)?(www\.)?(facebook\.com|twitter\.com|instagram\.com|linkedin\.com|youtube\.com|snapchat\.com)\/.+$/', $social_media)) {
        header("Location: edit_profile.php?error=" . urlencode("Invalid social media URL"));
        exit;
    }

    // Validate date of birth
    if (!empty($date_of_birth)) {
        $current_date = date("Y-m-d");
        $min_age_date = date("Y-m-d", strtotime("-13 years"));

        if ($date_of_birth > $current_date) {
            header("Location: edit_profile.php?error=" . urlencode("Date of birth cannot be in the future"));
            exit;
        }

        if ($date_of_birth > $min_age_date) {
            header("Location: edit_profile.php?error=" . urlencode("You must be at least 13 years old"));
            exit;
        }
    }

    $full_name = trim("$first_name $middle_name $last_name");

    if(isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

    // Update user profile information
    $query = "UPDATE user_profile SET Full_name='$full_name', phone_number='$phone_number', address='$address',
     date_of_birth='$date_of_birth', gender='$gender', social_media='$social_media', profile_picture='$profile_picture',
     education='$education', job='$job', skills='$skills' WHERE user_id = $userId";

    // Update user table
    $sql = "UPDATE user SET Last_name='$last_name', First_name='$first_name', Middle_name='$middle_name' 
    WHERE user_id = $userId";

    if (mysqli_query($conn, $sql) && mysqli_query($conn, $query)) {
        header("Location: edit_profile.php?success=Profile updated successfully");
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
}
}

mysqli_close($conn);
?>
