<?php
session_start();
require_once 'db_config.php';

// Initialize variables
$isLoggedIn = false;

// Check if the user is logged in by checking session
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch user data from the database
    $sql_get_user = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql_get_user);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result_get_user = $stmt->get_result();

    if ($result_get_user->num_rows === 1) {
        $row_user_data = $result_get_user->fetch_assoc();
        $user_name = $row_user_data['username'];
        $isLoggedIn = true;
    }
}

// Handle logout functionality
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ENotes Website</title>
    <link rel="stylesheet" href="pdf/stu.css" />
    <style>
      
        /* Alert Box Styling */
        #alert-box {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            border-radius: 5px;
            z-index: 1000;
        }
        .hero {
  display: flex;
  justify-content: flex-start; 
  align-items: left;
  padding: 40px; 
}
.hero .btns {
  display: flex;
  align-items: center;
  justify-content: flex-start;
  gap: 10px;
}


.img1 {
    position: absolute;
    right: 20px; 
    top: 50%; 
    transform: translateY(-50%);
}
    </style>
</head>
<body>
    <!-- Navbar -->
<header>
      <nav class="navbar">
        <div class="logo">
          <div class="img" >
            <img src="images/logo.jpg" alt="" />
          </div>
          <div class="logo-header">
            <h4><a href="dashboard.php">ENotes</a></h4>
            <small>ENotes book Website</small>
          </div>
        </div>
        <ul class="nav-list">
            <?php if ($isLoggedIn): ?>
          <li><a href="dashboard.php">Home</a></li>
     
          <li><a href="contact.php">Contact</a></li>
          <li><a href="books.php">Books</a></li>
          <li><span class="navbar-text">Welcome, <?php echo htmlspecialchars($user_name); ?></span></li>
          <li><a href="dashboard.php?logout=true" class="btn btn-link">Log Out</a></li>
          <?php else: ?>
        <li><a href="dashboard.php" >Home</a></li>
          <li><a href="#" class="restricted-link btn btn-primary">Service</a></li>
          <li><a href="contact.php" class="restricted-link btn btn-primary">Contact</a></li>
          <li><a href="books.php" class="restricted-link btn btn-primary">Books</a></li>
           <button class="login"><a href="index.php">Log In</a></button>
          <?php endif; ?>
        </ul>

      </nav>
    </header>

    <!-- Dashboard Content -->
    <section class="hero">
      <div class="main">
        <div class="content">
          <small>Get your ebooks here</small>
          <h2>At our Website</h2>
          <h5>Books are digitally provided by us</h5>
          <p>
            Are you ready to join and learn with us to gain new way to learn and further develop and enhance the way you precieve the books you read and help us achieve the next addition to our books.
          </p>
          
          <?php if ($isLoggedIn): ?>
            <div class="img1">
          <img
            src="images/dash.png"
            alt=""
          />
          </div>
          <?php else: ?>
          <div class="btns">
             <a href="index.php"> <button>Connect with us</button></a>
            <button>See other Features</button>
          </div>
        </div>
        <div class="img1">
          <img
            src="images/dash.png"
            alt=""
          />
        </div>
        <?php endif; ?>
      </div>
  
      <div class="orange-circle"></div>
      <div class="blue-circle"></div>
  
    </section>

    <div class="container">
    <h2>&emsp;&emsp;Welcome to Dashboard, <?php echo $isLoggedIn ? ($user_name) : 'Guest'; ?></h2>
  
</div>

<div id="alert-box" style="display: none;">You need to log in to access this feature.</div>


    <section class="news">
      <div class="heading">
        <div class="title">
          <h4>ENooks Visuals</h4>
          <p style="text-align: justify; line-height: 1.4; margin-bottom: 0px;">
            The path we aspire for the betterment of learning <br>
            Providing quality materials, we focus on improving
          </p>
        </div>
        <div class="btn">
          <button>View More <i class="fa-solid fa-arrow-right"></i></button>
        </div>
      </div>
      <div class="news-container">
        <div class="post">
          <div class="img">
            <img src="images/pic2.jpg" alt="" />
          </div>
          <h5>Why e-notes online?</h5>
          <p style="text-align: justify; line-height: 1.6; margin-bottom: 10px;">
            E-Notes make studying easier and more flexible.
            You can read anywhere, anytime, without carrying heavy books.
            They're also eco-friendly and often cheaper. 
            With it, you can search, view, and take notes directly on them, making learning faster and more fun.
          </p>
        </div>
        <div class="post">
          <div class="img">
            <img src="images/news-2.webp" alt="" />
          </div>
          <h5>What differentiates our website?</h5>
          <p style="text-align: justify; line-height: 1.6; margin-bottom: 10px;">
            Our site is simple and easy to use. We offer well-organized e-books for all subjects, so you can quickly find what you need. Unlike other sites, we focus on providing study materials that are perfect for students like you.
          </p>
        </div>
        <div class="post">
          <div class="img">
            <img src="images/news-3.jpg" alt="" />
          </div>
          <h5>What can we achieve?</h5>
          <p style="text-align: justify; line-height: 1.6; margin-bottom: 10px;">
            We want to help students learn better and reach their goals. By offering a variety of e-books, we make it easier to study and succeed. Whether you're preparing for exams or learning new topics, we're here to support your journey.
          </p>
        
        </div>
        <div class="post">
          <div class="img">
            <img src="images/news-4.jpg" alt="" />
          </div>
          <h5>Why us for your study material?</h5>
          <p style="text-align: justify; line-height: 1.6; margin-bottom: 10px;">
            We provide e-books that are carefully selected for students. Our collection is designed to match your academic needs, helping you learn faster and smarter. With us, you get reliable resources that make studying more effective.
          </p>
         
        </div>
      </div>
    </section>

    
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
 
<script>
   document.addEventListener("DOMContentLoaded", function() { 
    // Only show alert if user is not logged in 
    <?php 
    if (!$isLoggedIn): ?> 
    document.body.addEventListener('click', function(event) { 
        if (event.target.classList.contains('restricted-link')) { 
            event.preventDefault(); 
            showAlert(); }
        });

        function showAlert() {
            const alertBox = document.getElementById('alert-box');
            alertBox.style.display = 'block';
            setTimeout(function() {
                alertBox.style.display = 'none';
            }, 3000); // Hide after 3 seconds

            // Hide alert on click
            alertBox.addEventListener('click', function() {
                alertBox.style.display = 'none';
            });
        }
        <?php endif; ?>
    });
</script>
</body>
</html>

