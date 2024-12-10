<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'project';

$conn = mysqli_connect($servername, $username, $password,);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "CREATE DATABASE IF NOT EXISTS project";
if ($conn->query($sql) === TRUE) {
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}


$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($conn===false) {
    die("Connection failed: " .mysqli_connect_error());
}

$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    number VARCHAR(10) NOT NULL,
    password VARCHAR(255) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

$sql = "CREATE TABLE IF NOT EXISTS pdfbooks (
    B_id INT AUTO_INCREMENT PRIMARY KEY,
    bookname VARCHAR(255),
    description TEXT,
    category VARCHAR(50),
    publish_date INT,
    pdf_path VARCHAR(255) NOT NULL,
    image_path VARCHAR(255) NOT NULL
 )";
 if ($conn->query($sql) === TRUE) {
 } else {
     echo "Error creating table: " . $conn->error . "<br>";
 }

?>