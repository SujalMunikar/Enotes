<?php
session_start();
require_once 'db_config.php';


if (!isset($_SESSION['admin_name'])) {
    header("Location: index.php");
    exit();
}


// Check if the admin is logged in by checking session
if (isset($_SESSION['admin_name'])) {
    $admin_id = $_SESSION['admin_name'];

    $sql_get_admin = "SELECT * FROM admins WHERE  username = ?";
    $stmt = $conn->prepare($sql_get_admin);
    $stmt->bind_param('i', $admin_id);
    $stmt->execute();
    $result_get_admin = $stmt->get_result();

    if ($result_get_admin->num_rows === 1) {
        $row_admin_data = $result_get_admin->fetch_assoc();
        $admin_name = $row_admin_data['username'];
    }
}

// Query to count the':'ers in the 'users' table
$totalUsersQuery = "SELECT COUNT(*) AS total_users FROM users";
$totalUsersResult = $conn->query($totalUsersQuery);
$totalUsers = $totalUsersResult->fetch_assoc()['total_users'];

// Query to count the':'oks in the 'pdfdoc' table
$totalBooksQuery = "SELECT COUNT(*) AS total_books FROM pdfbooks";
$totalBooksResult = $conn->query($totalBooksQuery);
$totalBooks = $totalBooksResult->fetch_assoc()['total_books'];

// Fetch users for table view
$sql_users = "SELECT * FROM users";
$result_users = $conn->query($sql_users);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $userId = $_POST['user_id'];
    $deleteQuery = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    header("Location: admin_dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/new.css">
    <style>
/* Sidebar Styling */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 200px;
    height: 100%;
    background-color: #787676;
    padding: 20px;
    box-shadow: 2px 0 10px rgba(174, 174, 174, 0.1);
    color: white;
}

    .sidebar .logo{
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-left: 20%;
}

.sidebar .logo img{
    display: flex;
    align-items: center;
    width: 100px;
    border-radius: 5px;
}

.sidebar .items {
    display: flex;
    flex-direction: column;
    width: 100%;
    text-align: center;
    margin-top: 30px;
}
.sidebar .items a {
    color: #fff;
    text-decoration: none;
    padding: 15px 0;
    width: 100%;
    font-size: 26px;
   
}

.sidebar .items a:hover {
    background-color: #555; 
    color: #ddd; 
}

</style>
</head>
<body>
<nav>
  
    
    <div class="sidebar">
    <div class="logo">
    <div class="img" >
            <img src="images/logo.jpg" alt="" />
          </div>
    </div>
    <div class="items">
        <a href="admin_dashboard.php">Dashboard</a><br>
        <a href="add_book.php">Add Books</a><br>
        <a href="logout.php">Logout</a><br>
        </div>
    </div>
</nav>
<div class="main-content">
<h2 class="heading">Welcome, <?php echo ($admin_name); ?>!</h2>
<div class="dashboard-container">
    <div class="dashboard-box1">
        <h3>Total Users</h3>
        <p><?php echo $totalUsers; ?></p>
    </div>
    <div class="dashboard-box2">
        <h3>Total Books</h3>
        <p> <?php echo $totalBooks; ?></p>
    </div>
</div>
    <!-- User Table -->
    <div class="dashboard-table-container">
    <h2>All Users</h2>
    <table class="dashboard-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = $result_users->fetch_assoc()): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                
                <td>
                    <button class="view" onclick="viewUser(<?php echo $user['id']; ?>)">View</button>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <button type="submit" class="delete" name="delete" onclick="return confirm('Delete user:')" >Delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</div>
<!-- Modal for Viewing User Details -->
<div id="viewModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3>User Details</h3>
        <p id="userDetails"></p>
    </div>
</div>

<script>
function viewUser(userId) {
    fetch('view_user.php?id=' + userId)
        .then(response => response.text())
        .then(data => {
            document.getElementById('userDetails').innerHTML = data;
            document.getElementById('viewModal').style.display = 'block';
        });
}

function closeModal() {
    document.getElementById('viewModal').style.display = 'none';
}
</script>
</body>
</html>
