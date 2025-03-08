<?php
    // Logic to register a user (for now, just display sanitized input)
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"]) && isset($_POST["password"])) {
        if (empty(trim($_POST['email'])) || empty(trim($_POST['password']))) {
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var alertPlaceholder = document.getElementById('alert-placeholder');
                var alert = document.createElement('div');
                alert.className = 'alert alert-danger';
                alert.role = 'alert';
                alert.innerHTML = 'Email and password are required.';
                alertPlaceholder.appendChild(alert);
            });
            </script>";
        } else {
            $email    = htmlspecialchars($_POST["email"]);                   // Sanitize email to prevent XSS
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash password for security
            echo "<script>
            localStorage.setItem('email', '$email');
            localStorage.setItem('hashedPassword', '$password');
            document.addEventListener('DOMContentLoaded', function() {
                var alertPlaceholder = document.getElementById('alert-placeholder');
                var alert = document.createElement('div');
                alert.className = 'alert alert-success';
                alert.role = 'alert';
                alert.innerHTML = 'Email and hashed password stored in local storage.';
                alertPlaceholder.appendChild(alert);
            });
            setTimeout(function() {
                    window.location.href = 'login.php';
                }, 5000);
        </script>";
        }
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1>Registration</h1>

        <!-- Placeholder for Bootstrap alerts -->
        <div id="alert-placeholder"></div>

        <!-- Registration Form -->
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" required>
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">I agree to the terms and conditions</label>
            </div>

            <button type="submit" class="btn btn-primary" id="submitBtn" disabled>Submit</button>
        </form>
        <!-- End of Registration Form -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        // Enable/Disable submit button based on checkbox state
        document.getElementById("exampleCheck1").addEventListener("change", function() {
            document.getElementById("submitBtn").disabled = !this.checked;
        });
    </script>
</body>
</html>
