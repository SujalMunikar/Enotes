<?php
session_start();
require_once 'db_config.php';

// Get the submitted username and password from the registration form
$username = $_POST['username'];
$email = $_POST['email'];
$number = $_POST['number'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error3'] = 'Invalid email format.';
    // Keep the sign-up form active
    $_SESSION['active_form'] = 'sign-up';
    header('Location: index.php');
    exit();
}

$sql = "SELECT id FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

 // check data table, if email already exists, redirect back to the registration page with an error message
if ($result->num_rows > 0) {
    $_SESSION['error8'] = 'Email already registered';
    $_SESSION['active_form'] = 'sign-up';
    header('Location: index.php');
    exit();
}

// Check if the username already exists in the database
$sql = "SELECT id FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

// username already exists, redirect back to the registration page with an error message
if ($result->num_rows > 0) {
    $_SESSION['error4'] = 'Username taken';
    $_SESSION['active_form'] = 'sign-up';
    header('Location: index.php');
    exit();
}

// Check if the password and confirm password match
if ($password !== $confirm_password) {
    $_SESSION['error5'] = 'Passwords do not match';
    $_SESSION['active_form'] = 'sign-up';
    header('Location: index.php');
    exit();
}

// Insert the new user into the database
$sql = "INSERT INTO users (username, email, number, password) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssss', $username, $email, $number, $password);

if ($stmt->execute()) {
    $_SESSION['success'] = 'Registration completed';
    $_SESSION['active_form'] = 'sign-up';
    header('Location: index.php');
} else {
    $_SESSION['error7'] = 'Registration failed';
    $_SESSION['active_form'] = 'sign-up';
    header('Location: index.php');
}
?>
