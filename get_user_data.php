<?php
require_once 'db_config.php';

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $sql_user_data = "SELECT * FROM users WHERE id = '$userId'";
    $result_user_data = $conn->query($sql_user_data);

    if ($result_user_data->num_rows == 1) {
        $row_user_data = $result_user_data->fetch_assoc();

        echo "<h2>User Details</h2>";
        echo "<ul>";
        echo "<li><strong>User ID:</strong> " . $row_user_data['id'] . "</li>";
        echo "<li><strong>Email:</strong> " . $row_user_data['email'] . "</li>";
        echo "<li><strong>Username:</strong> " . $row_user_data['username'] . "</li>";
        echo "<li><strong>Number:</strong> " . $row_user_data['number'] . "</li>";
        echo "</ul>";
    } else {
        echo "User not found.";
    }
}
?>