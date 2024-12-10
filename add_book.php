<?php
session_start();
require_once 'db_config.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_name'])) {
    header("Location: index.php");
    exit();
}

$admin_id = $_SESSION['admin_name'];

// Fetch admin data
$sql_get_admin = "SELECT * FROM admins WHERE username = ?";
$stmt = $conn->prepare($sql_get_admin);
$stmt->bind_param('s', $admin_id);
$stmt->execute();
$result_get_admin = $stmt->get_result();

if ($result_get_admin->num_rows === 1) {
    $row_admin_data = $result_get_admin->fetch_assoc();
    $admin_name = $row_admin_data['username'];
}

// Check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pdfPath = 'uploads_img/' . $_FILES['pdf']['name'];
    $imagePath = 'uploads_img/' . $_FILES['image']['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $title = $_POST['bookname'];
    $publish_date = $_POST['publish_date'];

    // Move uploaded files
    if (move_uploaded_file($_FILES['pdf']['tmp_name'], $pdfPath) && move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
        $stmt = $conn->prepare("INSERT INTO pdfbooks (bookname, description, category, publish_date,pdf_path, image_path) VALUES (?, ?, ?, ?, ?, ?)");
       
        $stmt->bind_param("ssssss", $title, $description, $category, $publish_date,$pdfPath, $imagePath); 

        if ($stmt->execute()) {
            header("Location: add_book.php");
            exit();
        } else {
            echo "Execute failed: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Failed to upload files.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Book</title>
    <link rel="stylesheet" href="css/addbooks.css" />
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
    
</head>
<body>
    <h2>Upload Books</h2>
    <form action="add_book.php" method="post" enctype="multipart/form-data">
        <label>Choose a Pdf file</label>
        <input type="file" name="pdf" accept=".pdf" required >
        <label>Choose a image file</label>
        <input type="file" name="image" accept="image/*" required>
        <label>BookName</label>
        <input type="text" name="bookname" placeholder="Enter book Name" required>
        <label>Description</label>
        <input type="text" name="description" placeholder="Enter description"  rows="5" required>
        <label>Select a category</label>
        <select name="category"  required style="overflow-y: auto;">
            <option value="C">C</option>
            <option value="C++">C++</option>
            <option value="Java">Java</option>
            <option value="php">php</option>
            <option value="Linux">Linux</option>
            <option value="Sql">Sql</option>
            <option value="ComputerNetwork">ComputerNetwork</option>
            <option value="Django">Django</option>
            <option value="xml">XML</option>
            <option value="React JS">React JS</option>
            <option value="DBMS">DBMS</option>
           
        </select>
        <input type="number" name="publish_date" placeholder="Enter publication year" min="1000" max="9999" oninput="fixednum(this)" required>
        <button type="submit">Upload</button>
    </form>
    <script>
        function fixednum(input) {
            if (input.value.length > 4) {
                input.value = input.value.slice(0, 4);
            }
        }
    </script>
</body>
</html>
