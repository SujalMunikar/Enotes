<?php
 require_once 'db_config.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT pdf_path FROM pdfbooks WHERE B_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$file = $result->fetch_assoc();

if (!$file) {
    die("File not found.");
}

$pdfPath = $file['pdf_path'];

// Serve the file as a download
header("Content-Type: application/pdf");
header("Content-Disposition: attachment; filename=" . basename($pdfPath));
readfile($pdfPath);
?>
