<?php
require_once 'db_config.php';

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        echo "<p><strong>ID:</strong> " . ($user['id']) . "</p>";
        echo "<p><strong>Name:</strong> " . ($user['username']) . "</p>";
        echo "<p><strong>Email:</strong> " . ($user['email']) . "</p>";
        echo "<p><strong>Email:</strong> " . ($user['number']) . "</p>";
    } else {
        echo "User not found.";
    }
}
?>
