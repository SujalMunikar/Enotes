<?php
require_once 'db_config.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM pdfbooks WHERE B_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$file = $result->fetch_assoc();

if (!$file) {
    die("File not found.");
}

$title = $file['bookname'];
$description = $file['description'];
$pdfPath = $file['pdf_path'];
$imagePath = $file['image_path'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0 ;
            background-color: lightgray;
            display:flex;
            justify-content: center;
        }

        .details-container {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            max-width: 800px;
            width: 100%;
            margin: 20px;
            text-align: center;
        }

        .details-container img {
            width: 100%;
            max-width: 300px;
            height: auto;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .details-container h1 {
            font-size: 25px;
            margin-bottom: 5px;
            color: brown;
        }

        .details-container p {
            margin: 10px 0 0 250px;
            font-size: 20px;
            line-height: 1.5;
            text-align: left;
        }

        .details-container .actions a {
            display: inline-block;
            margin: 30px 0 15px 20px;
            padding: 15px 20px;
            text-decoration: none;
            color: #fff;
            background-color: #2c67f2;
            border-radius: 5px;
        }

        .details-container .actions a:hover {
            background-color: #1a4ab8;
        }

        .back-button {
            display: inline-block;
           font-size: 20px;
            color: #2c67f2;
            text-decoration: none;
             background: none;
            border: none;
            cursor: pointer;
            padding: 20px 15px;
            border-radius: 10px;
            margin-bottom: 0px;
        }

        .back-button:hover {
            background-color: rgba(44, 103, 242, 0.1);
        }
        
    </style>
</head>
<body>
    <div class="details-container">
        <a href="books.php" class="back-button">Go Back</a>
        <h1>Book Details</h1>
        <img src="<?= $imagePath ?>" alt="Book Image">
        <p><strong>BookName:</strong> <?= $title ?></p>
        <p><strong>Description:</strong> <?= $description ?></p>
        <p><strong>Category:</strong> <?= $file['category'] ?></p>
        <div class="actions">
            <a href="<?= $pdfPath ?>" target="_blank">View PDF</a>
            <a href="download.php?id=<?= $id ?>">Download PDF</a>
        </div>
    </div>
</body>
</html>