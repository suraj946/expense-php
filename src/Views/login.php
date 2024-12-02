<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Expense Tracker</title>
    <link rel="stylesheet" href="/assets/css/login.css">
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
    <div class="login-wrapper">
        <div class="login-container">
            <h2 class="login-heading">Login to Your Account</h2>
            <form id="loginForm" action="/login" method="POST">

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" placeholder="Enter email">
                    <div id="emailError" class="error-message"></div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter password">
                    <div id="passwordError" class="error-message"></div>
                </div>

                <div class="form-group">
                    <button type="submit">Login</button>
                </div>

                <div class="form-footer">
                    <p>Don't have an account? <a href="/signup">Sign up here</a></p>
                </div>
            </form>
        </div>
    </div>

    <script src="/assets/js/login.js"></script>
    <script src="/assets/js/global.js"></script>
</body>

</html>