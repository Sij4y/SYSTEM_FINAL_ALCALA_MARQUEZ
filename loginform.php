<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CET Online Store | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

  <!-- Linking Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="style4.css">

  <style>
    .preloader {
      display: flex;
      align-items: center;
      justify-content: center;
      position: fixed;
      width: 100%;
      height: 100%;
      background: #fff;
      z-index: 9999;
      transition: transform 1s ease, opacity 1s ease;
    }
    .preloader.hidden {
      transform: translateY(-100%);
      opacity: 0;
    }
  </style>
</head>
<body class="hold-transition login-page">
  <!-- Preloader -->
  <div class="preloader">
      <img class="animation__shake" src="webpic/ramon.png" alt="AdminLTELogo" height="400" width="400">
  </div>

  <div class="login-box">
    <div class="card-body">
      <h1 class="text-center p-3">LOGIN</h1>

      <?php if (isset($_GET['error'])) { ?>
          <div id="errorAlert" class="alert alert-danger"><?php echo $_GET['error']; ?></div>
      <?php } ?>

      <form action="index.php" method="post">
        <div class="user-box">
          <input type="text" id="username" class="form-control" name="username" value="<?php echo $_GET['uname'] ?? ''; ?>" required>
          <label>Student ID</label>
        </div>
        <div class="user-box">
          <input type="password" id="password" class="form-control" name="password" required>
          <label>Password</label>
        </div>
        <button type="submit" id="submitBtn">Login</button>
        <div>
          Don't have an account? <a href="registrationform.php">Register</a>
        </div>
      </form>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const preloader = document.querySelector('.preloader');

      window.addEventListener('load', function() {
        setTimeout(() => {
          preloader.classList.add('hidden');
        }, 500); // Hold the preloader for 0.5 seconds (500 milliseconds)
      });

      if (typeof(Storage) !== "undefined") {
        document.getElementById("username").value = localStorage.getItem("username") || '';
        document.getElementById("password").value = localStorage.getItem("password") || '';

        document.getElementById("submitBtn").addEventListener("click", function() {
          localStorage.setItem("username", document.getElementById("username").value);
          localStorage.setItem("password", document.getElementById("password").value);
          document.querySelector("form").submitted = true;
        });

        window.addEventListener('beforeunload', function(event) {
          if (!document.querySelector("form").submitted) {
            localStorage.removeItem("username");
            localStorage.removeItem("password");

            var errorAlert = document.getElementById("errorAlert");
            if (errorAlert) {
              errorAlert.style.display = "none";
            }
          }
        });

        if (window.history.replaceState) {
          const url = new URL(window.location.href);
          url.searchParams.delete('error');
          window.history.replaceState({ path: url.href }, '', url.href);
        }

        window.addEventListener('load', function() {
          const errorMessage = document.getElementById('errorAlert');
          if (errorMessage) {
            setTimeout(() => errorMessage.style.display = 'none', 5000);
          }
        });
      }
    });
  </script>

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
</body>
</html>
