<?php
session_start();
require_once 'db_config.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: dashboard.php");
  exit;
}
// Initialize the variable to prevent 'undefined' error
$user_name = ""; 
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];

  // Fetch user data from the database
  $sql_get_user = "SELECT username FROM users WHERE id = ?";
  $stmt = $conn->prepare($sql_get_user);
  $stmt->bind_param('i', $user_id);
  $stmt->execute();
  $result_get_user = $stmt->get_result();

  if ($result_get_user->num_rows === 1) {
      $row_user_data = $result_get_user->fetch_assoc();
      $user_name = $row_user_data['username'];
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENotes Website</title>
    <link rel="stylesheet" href="css/stu.css" />
    <style>
        .contact-container {
            max-width: 500px;
            margin: 100px auto 0 auto;
            background: #fff;


            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .contact-container h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
            color: #7262dc;
        }

        .contact-form {
            display: flex;
            flex-direction: column;
        }

        .contact-form input, .contact-form textarea {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .contact-form button {
            padding: 10px;
            background-color: #7262dc;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .contact-form button:hover {
            background-color: grey;
        }
    </style>
</head>
<body>
    <header>
      <nav class="navbar">
        <div class="logo">
          <div class="img" >
            <img src="images/logo.jpg" alt="" />
          </div>
          <div class="logo-header">
            <h4><a href="dashboard.php">ENotes</a></h4>
            <small>ENotes books Website</small>
          </div>
        </div>
        <ul class="nav-list">
          <li><a href="dashboard.php">Home</a></li>
          <li><a href="#">Contact</a></li>
          <li><a href="books.php">Books</a></li>
          <li><span class="navbar-text"><?php echo $user_name; ?></span></li>
          <li><a href="dashboard.php?logout=true" class="btn btn-link">Log Out</a></li>
        </ul>
      </nav>
    </header>

    <div class="contact-container">
        <h1>Contact Us</h1>
 
            <form method="POST" action="" class="contact-form">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <textarea name="message" placeholder="Your Message" rows="5" required></textarea>
                <button type="submit">Send Message</button>
            </form>
    </div>

    <section class="subscription">
    </section>
    <footer>
      <div class="container">
        <div class="logo-description">
          <div class="logo">
            <div class="img">
              <img src="images/logo.jpg" alt="" />
            </div>
            <div class="title">
              <h4>ENotes</h4>
              <small>ENotes book Website</small>
            </div>
          </div>
          <div class="logo-body">
            <p style="text-align: justify; line-height: 1.3; margin-bottom: 5px;">
             We are fully obligated to provide you the best notes that are available with us and our customers. if you are intrested with helping us grow, come join us to secure notes for betterment of other users.
            </p>
          </div>
          <div class="social-links">
            <h4>Follow Us</h4>
          </div>
        </div>
        <div class="categories list">
          <h4>Book Categories</h4>
          <ul>
            <li><a href="#" class="restricted-link btn btn-primary">C</a></li>
            <li><a href="#" class="restricted-link btn btn-primary">C++</a></li>
            <li><a href="#" class="restricted-link btn btn-primary">Java</a></li>
            <li><a href="#" class="restricted-link btn btn-primary">php</a></li>
            <li><a href="#" class="restricted-link btn btn-primary">React</a></li>
            <li><a href="#" class="restricted-link btn btn-primary">Sql</a></li>
            <li><a href="#" class="restricted-link btn btn-primary">linux</a></li>
          </ul>
        </div>
        <div class="quick-links list">
          <h4>Quick Links</h4>
          <ul>
            <li><a href="dashboard.php" class="restricted-link btn btn-primary">About Us</a></li>
            <li><a href="#" class="restricted-link btn btn-primary">Contact Us</a></li>
            <li><a href="#" class="restricted-link btn btn-primary">Latest</a></li>
            <li><a href="#" class="restricted-link btn btn-primary">Popular</a></li>
            <li><a href="#" class="restricted-link btn btn-primary">Most Viewed</a></li>
            <li><a href="books.php" class="restricted-link btn btn-primary">Books</a></li>
            <li><a href="#" class="restricted-link btn btn-primary">ReadList</a></li>
          </ul>
        </div>
        <div class="our-location">
          <h4>Our Location</h4>
          <div class="map" style="margin-top: 1rem">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3533.331712639985!2d85.36118019999999!3d27.676140799999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb1a1bed1bdd29%3A0x70040fb78c745729!2sSamriddhi%20College!5e0!3m2!1sen!2snp!4v1730720487912!5m2!1sen!2snp" class="restricted-link btn btn-primary"
              height="100"
              style="width: 100%; border: none; border-radius: 5px"
              allowfullscreen=""
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
             ></iframe>
          </div>
          <ul>
           
              <a href="#" class="restricted-link btn btn-primary">Lokanthali-1, 44800, Bhaktapur</a
              ><hr style="border:0.5px solid #E4E0E1;">
           <br> 
            
              <a href="#" class="restricted-link btn btn-primary">+977-9840031102</a>
            <hr style="border:0.5px solid #E4E0E1;">
            <br>
              <a href="#" class="restricted-link btn btn-primary">Support at:<br>ABC@gmail.com</a>
                <br><br><br><br>
            
          </ul>
        </div>
      </div>
    </footer>
    <button class="back-to-top">∧</button>
    <script src="js/back-to-top.js"></script>
  </body>
</html>