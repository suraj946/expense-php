<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Expense Tracker</title>
    <link rel="stylesheet" href="/assets/css/signup.css">
    <link rel="stylesheet" href="/assets/css/global.css">
</head>

<body>
    <?php
      session_start();
      if (isset($_SESSION['user'])) {
          header("Location: /");
          exit();
      }
      if(isset($error)){
          echo '<div class="server-error" id="serverError">' . $error . '</div>';
          unset($error);
      }
    ?>
    <div class="signup-wrapper">
        <div class="signup-container">
            <h2 class="signup-heading">Create Your Account</h2>
            <form id="signupForm" action="/signup" method="POST">

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" id="name" placeholder="Enter your full name">
                    <div id="nameError" class="error-message"></div>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email">
                    <div id="emailError" class="error-message"></div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your password">
                    <div id="passwordError" class="error-message"></div>
                </div>

                <div class="form-group">
                    <button type="submit">Sign Up</button>
                </div>

                <div class="form-footer">
                    <p>Already have an account? <a href="/login">Login here</a></p>
                </div>
            </form>
        </div>
    </div>

    <script src="/assets/js/signup.js"></script>
    <script src="/assets/js/global.js"></script>
</body>

</html>
