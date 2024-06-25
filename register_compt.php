<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
           
            background-image: url('webpic/newbg12.png');
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            padding: 0;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-wrapper {
            width: 300px;
            padding: 20px;
            background: rgba(24, 20, 20, 0.987);
            box-shadow: 0 15px 25px rgba(0, 0, 0, .6);
            border-radius: 10px;
            text-align: center;
        }

        .form-wrapper h2 {
            color: white;
        }

        .form-wrapper .btn-primary {
            background-color: transparent;
            border: 1px solid #ffa03b;
            color: #ffffff;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .form-wrapper .btn-primary:hover {
            background-color: #b55d1b;
            border-color: #b55d1b;
        }
    </style>
</head>
<body>
    <div class="form-wrapper">
        <form action="loginform.php">
            <h2>Please click the "verify" link to verify your email..</h2><br><br>
            <button class="btn btn-primary">Click to login</button><br>
        </form>
    </div>
</body>
</html>
