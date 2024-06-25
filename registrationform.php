<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CET Online Store | Register</title>

  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <!-- Custom styles -->
  <style>
    body {
      background-image: url('webpic/newbg13.png');
      background-size: cover;
      background-position: center;
      height: 100vh;
      margin: 0;
      padding: 0;
      color: black; /* Black font color */
    }

    .register-box {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 400px;
      background: #ca6e1e; /* Orange background */
      box-shadow: 0 15px 25px rgba(0, 0, 0, .6);
      border-radius: 10px;
      padding: 40px;
      box-sizing: border-box;
    }

    .register-box {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 400px;
      background: #ca6e1e; /* Orange background */
      box-shadow: 0 15px 25px rgba(0, 0, 0, .6);
      border-radius: 10px;
      padding: 40px;
      box-sizing: border-box;
    }

    .register-box .card.card-outline.card-primary {
      border: 1px solid black; /* Black border */
    }

    .register-box .card-header {
      color: black; /* Black font color */
      font-size: 2rem;
      text-align: center;
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
      padding-bottom: 20px;
      margin-bottom: 20px;
    }

    .register-box .card-body {
      color: black; /* Black font color */
    }

    .register-box .input-group {
      margin-bottom: 20px;
    }

    .register-box .form-control {
      background: rgba(255, 255, 255, 0.2);
      border: none;
      border-bottom: 1px solid black;
      color: black;
    }

    .register-box .form-control:focus {
      background: transparent;
      border-color: black;
      box-shadow: none;
    }

    .register-box .btn-primary {
      background: transparent;
      border: 1px solid black;
      color: black;
      transition: all 0.3s ease;
    }

    .register-box .btn-primary:hover {
      background-color: #ffa03b ; /* Darker shade of orange on hover */
      border-color: #ffa03b f;
    }

    .register-box .alert-danger {
      background-color: rgba(139, 0, 0, 0.7);
      color: white;
      border: none;
    }

    .register-box .checkbox {
      margin-bottom: 20px;
    }
  </style>
</head>
<body class="hold-transition register-page">

<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header">
      <h1 class="h1"><b>CET</b> Online Store</h1>
      <!-- Display error message if user input exists -->
      <?php if (isset($_GET['error'])) { ?>
        <div class="alert alert-danger">
          <?php echo $_GET['error']; ?>
        </div>
      <?php } ?>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Register</p>

      <form action="register.php" method="post">

      <div class="input-group mb-3">
          <input id="username" type="text" class="form-control" name="username" placeholder="Student ID" pattern="[0-9]+" title="Student ID must contain only digits" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input id="Last_name" type="text" class="form-control" name="Last_name" placeholder="Last name" pattern="[A-Za-z]+" title="Please enter letters only" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input id="First_name" type="text" class="form-control" name="First_name" placeholder="First name" pattern="[A-Za-z]+" title="Please enter letters only" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input id="Middle_name" type="text" class="form-control" name="Middle_name" placeholder="Middle name" pattern="[A-Za-z]+" title="Please enter letters only">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input id="Email" type="email" class="form-control" name="Email" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <select id="Status" class="form-control" name="Status" required>
            <option value="" disabled selected> Department</option>
            <option value="BSIT">BSIT</option>
            <option value="BSCS">BSCS</option>
            <option value="BSCE">BSCE</option>
          </select>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
       
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
        </div>

      </form>

      <div class="row">
  <div class="col-12">
    <a href="loginform.php" class="btn btn-secondary btn-block">I already have an account</a>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Check if the browser supports local storage
    if (typeof(Storage) !== "undefined") {
      // Retrieve values from local storage and set them as input values
      document.getElementById("username").value = localStorage.getItem("username") || '';
      document.getElementById("password").value = localStorage.getItem("password") || '';
      document.getElementById("Last_name").value = localStorage.getItem("Last_name") || '';
      document.getElementById("First_name").value = localStorage.getItem("First_name") || '';
      document.getElementById("Middle_name").value = localStorage.getItem("Middle_name") || '';
      document.getElementById("Email").value = localStorage.getItem("Email") || '';
      document.getElementById("Status").value = localStorage.getItem("Status") || '';

      // Store input values in local storage when the form is submitted
      document.getElementById("submitBtn").addEventListener("click", function() {
        localStorage.setItem("username", document.getElementById("username").value);
        localStorage.setItem("password", document.getElementById("password").value);
        localStorage.setItem("Last_name", document.getElementById("Last_name").value);
        localStorage.setItem("First_name", document.getElementById("First_name").value);
        localStorage.setItem("Middle_name", document.getElementById("Middle_name").value);
        localStorage.setItem("Email", document.getElementById("Email").value);
        localStorage.setItem("Status", document.getElementById("Status").value);

        // Mark the form as submitted
        document.querySelector("form").submitted = true;
      });

      // Clear local storage when navigating away from the page without submitting the form
      window.addEventListener('beforeunload', function(event) {
        if (!document.querySelector("form").submitted) {
          localStorage.removeItem("username");
          localStorage.removeItem("password");
          localStorage.removeItem("Last_name");
          localStorage.removeItem("First_name");
          localStorage.removeItem("Middle_name");
          localStorage.removeItem("Email");
          localStorage.removeItem("Status");

          // Hide the error message if it is currently displayed
          var errorAlert = document.getElementById("errorAlert");
          if (errorAlert) {
            errorAlert.style.display = "none";
          }
        }
      });

      // Remove the error message from the URL
      if (window.history.replaceState) {
        const url = new URL(window.location.href);
        url.searchParams.delete('error');
        window.history.replaceState({ path: url.href }, '', url.href);
      }

      // Clear the error message after refreshing the page
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
