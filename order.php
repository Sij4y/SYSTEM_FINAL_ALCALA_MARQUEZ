<?php
session_start();
include "db.php"; // Ensure this file contains the database connection code

// Fetch data from the database
$sql = "
    SELECT u.username, u.email, up.full_name, 
           p.payment_proof, p.product_image, p.product_name, p.price, p.size, p.quantity, p.reference_no, p.payment_status
    FROM user u
    JOIN user_profile up ON u.user_id = up.user_id
    JOIN payment p ON u.user_id = p.user_id
";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Check if any data was retrieved
if (mysqli_num_rows($result) > 0) {
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $users = [];
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
   
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            background-image: url('webpic/newbg33.png');
            background-size: cover;
            background-repeat: no-repeat;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            margin: auto;
            overflow: hidden;
            padding: 50px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
            text-align: left;
        }

        th, td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .back-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .back-button:hover {
            background-color: #555;
        }

        .mark-as-paid-button {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .paid-button {
            background-color: #ccc;
            color: #333;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
        }

        img {
            max-width: 50px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Information</h1>
        <?php if (isset($_SESSION['message'])): ?>
            <p><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
        <?php endif; ?>
        <?php if (!empty($users)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Fullname</th>
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Reference No</th>
                        <th> Status</th>
                        <th>Payment Final</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                            <td><img src="<?php echo htmlspecialchars($user['product_image']); ?>" alt="Product Image"></td>
                            <td><?php echo htmlspecialchars($user['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($user['price']); ?></td>
                            <td><?php echo htmlspecialchars($user['size']); ?></td>
                            <td><?php echo htmlspecialchars($user['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($user['reference_no']); ?></td>
                            <td><?php echo htmlspecialchars($user['payment_status']); ?></td>
                            <td>
                                <?php if ($user['payment_status'] == 'Pending'): ?>
                                    <form method="POST" action="update_status.php">
                                        <input type="hidden" name="reference_no" value="<?php echo htmlspecialchars($user['reference_no']); ?>">
                                        <button type="submit" name="mark_paid" class="mark-as-paid-button">Mark as Paid</button>
                                    </form>
                                <?php elseif ($user['payment_status'] == 'paid'): ?>
                                    <span class="paid-button">Paid</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No Orders found.</p>
        <?php endif; ?>
    </div>
    <button class="back-button" onclick="window.location.href='admin.php'">Back to Admin</button>
</body>
</html>
