<?php
session_start();
require_once 'db_config.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check admin table for correct value with table
    $sql_admin = "SELECT * FROM admins WHERE (username = ?) LIMIT 1";
    $pr_admin = $conn->prepare($sql_admin);
    $pr_admin->bind_param('s', $username);
    $pr_admin->execute();
    $result_admin = $pr_admin->get_result();

// Check if there is exactly one result
if (mysqli_num_rows($result_admin) == 1) {

    //Fetch the array with the result
    $row_admin = mysqli_fetch_assoc($result_admin);

    //Get the password from respective data in the table
    $admin_password = $row_admin['password'];

        if (password_verify($password, $admin_password)) {
            // $_SESSION['admin_id'] = $row_admin['id'];
            $_SESSION['admin_name'] = $row_admin['username'];
             // Assuming 'id' as the admin's unique identifier creating sesion variable'admin_id' for admin
            header('Location: admin_dashboard.php');
            exit();
        }else {
            $_SESSION['error'] = "Invalid password";
            $_SESSION['active_form'] = 'login';
            header('Location: index.php');
            exit();
        }
    }

    // Check user table for correct value with table using firstname
    $sql_user = "SELECT * FROM users WHERE (username = ? OR email = ?) LIMIT 1";
    $pr_user = $conn->prepare($sql_user);
    $pr_user->bind_param('ss', $username,$username);
    $pr_user->execute();
    $result_user = $pr_user->get_result();


    // Check if there is exactly one result
if (mysqli_num_rows($result_user) == 1) {

    //Fetch the array with the result
    $row_user = mysqli_fetch_assoc($result_user);

    //Get the password from respective data in the table
    $user_password = $row_user['password'];

        if ($password == $user_password) {
            $_SESSION['user_id'] = $row_user['id'];
                // Assuming 'id' as the user's unique identifier creating sesion variable'user_id' for users
            header('Location: dashboard.php');
            exit();
        }else {
            // user password is wrong
            $_SESSION['error2'] = "Invalid password";
            $_SESSION['active_form'] = 'login';
            header('Location: index.php');
            exit();
        }
    } else {
        // User not found, redirect to login page with invalid username error
        $_SESSION['error1'] = "Invalid username or email";
        $_SESSION['active_form'] = 'login';
        header('Location: index.php');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
?>
