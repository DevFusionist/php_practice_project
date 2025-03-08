<?php
session_start();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div class="container mt-5">
      <h1>Login</h1>

      <!-- Placeholder for Bootstrap alerts -->
      <div id="alert-placeholder"></div>

      <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"]) && isset($_POST["password"])) {
              if (empty(trim($_POST['email'])) || empty(trim($_POST['password']))) {
                  echo "<div class='alert alert-danger' role='alert'>Email and password are required.</div>";
              } else {
                  $email                = htmlspecialchars($_POST["email"]);
                  $password             = $_POST["password"];
                  $storedEmail          = $_POST["storedEmail"];
                  $storedHashedPassword = $_POST["storedHashedPassword"];

                  // Verify the email and password
                  if ($email === $storedEmail && password_verify($password, $storedHashedPassword)) {
                      // Store email in session
                      $_SESSION['email'] = $email;

                      // Redirect to dashboard
                      echo "<script>window.location.href = 'dashboard.php';</script>";
                  } else {
                      // Display an error alert
                      echo "<div class='alert alert-danger' role='alert'>Invalid email or password.</div>";
                  }
              }
          }
      ?>

      <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="loginForm">
        <!-- Your login form fields here -->
        <div class="mb-3">
          <label for="loginEmail" class="form-label">Email address</label>
          <input type="email" class="form-control" id="loginEmail" name="email" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3">
          <label for="loginPassword" class="form-label">Password</label>
          <input type="password" class="form-control" id="loginPassword" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
      </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
      document.getElementById("loginForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent form submission

        var email = document.getElementById("loginEmail").value;
        var password = document.getElementById("loginPassword").value;

        // Retrieve stored email and hashed password from local storage
        var storedEmail = localStorage.getItem("email");
        var storedHashedPassword = localStorage.getItem("hashedPassword");

        // Create a form data object to send to the server
        var formData = new FormData();
        formData.append("email", email);
        formData.append("password", password);
        formData.append("storedEmail", storedEmail);
        formData.append("storedHashedPassword", storedHashedPassword);

        // Submit the form data to the server
        fetch("", {
          method: "POST",
          body: formData
        })
        .then(response => response.text())
        .then(data => {
          document.open();
          document.write(data);
          document.close();
        })
        .catch(error => console.error('Error:', error));
      });
    </script>
  </body>
</html>