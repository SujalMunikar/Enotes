<?php

require_once 'db_config.php';
require_once 'admin.php';

session_start();
$activeForm = $_SESSION['active_form'] ?? 'login';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login in/Sign up</title>
    <link rel="stylesheet" href="css/style1.css">

</head>

<body>

    <div class="container <?= $activeForm === 'sign-up' ? 'right-panel-active' : '' ?>" id="container">
         <!-- Sign Up Form -->
        <div class="form-container sign-up-container">
            <form action="register_process.php" method="post">
                <h1>Create Account</h1>
                <span>Enter your details for registration</span>
                <?php
if (isset($_SESSION['error4'])) {
    echo "<p style='color: red;  margin: 0;'>" . $_SESSION['error4'] . "</p>";
    unset($_SESSION['error4']); // Clear the message after refreshing
}
?>
                <input type="text" placeholder="Username" name="username" id="username" required />
              <?php
if (isset($_SESSION['error3'])) {
    echo "<p style='color: red;  margin: 0;'>" . $_SESSION['error3'] . "</p>";
    unset($_SESSION['error3']); // Clear the message after refreshing
}
?>
<?php
if (isset($_SESSION['error8'])) {
    echo "<p style='color: red;  margin: 0;'>" . $_SESSION['error8'] . "</p>";
    unset($_SESSION['error8']); // Clear the message after refreshing
}
?>
                <input type="email" placeholder="Email" name="email" id="email" required />
              
                <input type="tel" placeholder="Phone Number" name="number" id="number" maxlength="10" required />
                <?php
if (isset($_SESSION['error5'])) {
    echo "<p style='color: red;  margin: 0;'>" . $_SESSION['error5'] . "</p>";
    unset($_SESSION['error5']); 
}
?> 
                <input type="password" name="password" id="password" placeholder="Password" required />
                <input type="password" placeholder="Confirm Password" name="confirm_password" id="confirm_password" required />
                <button class="submit-btn" type="submit" name="Register" value="Register">Sign Up</button>
                <?php
if (isset($_SESSION['error7'])) {
    echo "<p style='color: red;  margin: 0;'>" . $_SESSION['error7'] . "</p>";
    unset($_SESSION['error7']); 
}
?> 
   <?php
if (isset($_SESSION['success'])) {
    echo "<p style='color: green;  margin: 0;'>" . $_SESSION['success'] . "</p>";
}
?> 
            </form>
        </div>
        <div class="form-container sign-in-container">
            <a href="dashboard.php" class="back-button">
                Go Back
            </a>
            <form action="login_process.php" method="post">
                <h1>Sign in</h1>
                <span>Enter your account details</span>
                <?php
if (isset($_SESSION['error1'])) {
    echo "<p style='color: red;  margin: 0;'>" . $_SESSION['error1'] . "</p>";
    unset($_SESSION['error1']);
}
?>
                <input type="text" placeholder="Username or Email" name="username" id="username" required />
                <?php
if (isset($_SESSION['error2'])) {
    echo "<p style='color: red; margin: 0;'>" . $_SESSION['error2'] . "</p>";
    unset($_SESSION['error2']); // Clear the message after refreshing
}
?>
                <input type="password" name="password" id="password" placeholder="Password" required />
                <a href="#">Forgot your password?</a>
                <button class="login-btn" type="submit" name="login" value="Login">Sign In</button>
            </form>
        </div>
         <!-- Overlay Panels -->
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Reconnect with us!</h1>
                    <p>Keep connected with us <br>Login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Connect with us!</h1>
                    <p>Enter your personal details and connect with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('signUp').addEventListener('click', () => {
            document.getElementById('container').classList.add("right-panel-active");
        });

        document.getElementById('signIn').addEventListener('click', () => {
            document.getElementById('container').classList.remove("right-panel-active");
        });
    </script>

</body>

</html>
<?php session_unset(); ?>
