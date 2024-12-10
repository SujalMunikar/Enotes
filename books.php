<?php
session_start();
require_once 'db_config.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: dashboard.php");
  exit;
}
$user_name = ""; // Initialize the variable to prevent 'undefined' error
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
.book-container {
    display: flex;
    padding: 20px;
}

.category-sidebar {
            width: 200px;
            max-height: 400px;
            overflow-y: hidden;
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 8px;
            margin-right: 15px;
            overflow: auto;
        }

        .category-sidebar h3 {
            margin-bottom: 10px;
            font-size: 1.2rem;
            color: #333;
        }

        .category-sidebar ul {
            list-style: none;
            padding: 0;
        }

        .category-sidebar li {
            margin-bottom: 10px;
        }

        .category-sidebar a {
            text-decoration: none;
            color: #444;
            display: block;
            padding: 8px 10px;
            background-color: #fff;
            border-radius: 5px;
            transition: ease 0.3s;
        }

        .category-sidebar a:hover {
            background-color: #ddd;
        }
.sort-filter {
    gap: 10px; 
    display: flex;
    justify-content: flex-end;
    padding: 10px;
    margin-bottom: 10px;
    margin-right: 10px;
    background-color: white;
    border-bottom: 1px solid #ddd;
    position: sticky;
    top: 0;
    z-index: 10;
}
.book-display {
    flex: 1;
    overflow-y: auto;
}
.book-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 15px;
    margin-right: 10px;
}
.book-item {
    background-color: #f9f9f9;
    padding: 10px;
    border: 0.5px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
    text-align: center;
    
}
.book-item img {
    max-width: 100%;
    height: 180px;
    object-fit: cover;
    /* background-size: cover; */
    border-radius: 5px;
    margin-bottom: 20px;
}
.book-item h4 {
    font-size: 1rem;
    text-decoration: none;
    color: #333;
    margin: 0px 0 5px 0;
}

.book-item p {
    font-size: 0.9rem;
    color: #666;
}
.book-container {
    overflow: hidden;
}

main {
    overflow-y: auto;
  height: 120vh;
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
          <li><a href="contact.php">Contact</a></li>
          <li><a href="books.php">Books</a></li>
          <li><span class="navbar-text"><?php echo $user_name; ?></span></li>
          <li><a href="dashboard.php?logout=true" class="btn btn-link">Log Out</a></li>
        </ul>
      </nav>
    </header>

<main class="book-container">
<?php
// Fetch all unique categories from the database
$categories = $conn->query("SELECT DISTINCT category FROM pdfbooks");
// Initialize an array to hold all the unique categories
$allCategories = [];
// Check the result set returned by the query for the category
while ($cat = $categories->fetch_assoc()) {
    $allCategories[] = $cat['category'];
}

// Get user input for filtering and sorting
$categoryFilter = ''; 
if (isset($_GET['category'])) {
    $categoryFilter = $_GET['category'];
}

$sort_order = 'default'; 
if (isset($_GET['sort'])) {
    $sort_order = $_GET['sort']; 
}

// create query for filtering books
$query = "";
$result = null;
if (!empty($categoryFilter)) {
    $query = "SELECT * FROM pdfbooks WHERE category = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("Error preparing query: " . $conn->error);
    }
    $stmt->bind_param("s", $categoryFilter); 
    $stmt->execute();
    $result = $stmt->get_result(); 
} else {
    // If no category filter is applied, fetch all books
    $query = "SELECT * FROM pdfbooks";
    $result = $conn->query($query); 
    if ($result === false) {
        die("Error executing query: " . $conn->error);
    }
}

$books = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        // if 'publish_date' exists, else assign "Unknown"
        if (!isset($row['publish_date'])) {
            $row['publish_date'] = "Unknown";
        } else {
            $row['publish_date'] = (string)$row['publish_date'];
        }
        // Adding the books row to the books array
        $books[] = $row;
    }
}

// Apply sorting to the filtered books
if ($sort_order == 'oldest') {
    for ($i = 0; $i < count($books) - 1; $i++) {
        for ($j = $i + 1; $j < count($books); $j++) {
            if ((int)$books[$i]['publish_date'] > (int)$books[$j]['publish_date']) {
                $temp = $books[$i];
                $books[$i] = $books[$j];
                $books[$j] = $temp;
            }
        }
    }
} elseif ($sort_order == 'latest') {
    for ($i = 0; $i < count($books) - 1; $i++) {
        for ($j = $i + 1; $j < count($books); $j++) {
            if ((int)$books[$i]['publish_date'] < (int)$books[$j]['publish_date']) {
                $temp = $books[$i];
                $books[$i] = $books[$j];
                $books[$j] = $temp;
            }
        }
    }
} elseif ($sort_order == 'asc') {
    for ($i = 0; $i < count($books) - 1; $i++) {
        for ($j = $i + 1; $j < count($books); $j++) {
            if (strcmp($books[$i]['bookname'], $books[$j]['bookname']) > 0) {
                $temp = $books[$i];
                $books[$i] = $books[$j];
                $books[$j] = $temp;
            }
        }
    }
} elseif ($sort_order == 'desc') {
    for ($i = 0; $i < count($books) - 1; $i++) {
        for ($j = $i + 1; $j < count($books); $j++) {
            if (strcmp($books[$i]['bookname'], $books[$j]['bookname']) < 0) {
                $temp = $books[$i];
                $books[$i] = $books[$j];
                $books[$j] = $temp;
            }
        }
    }
}
?>

<aside class="category-sidebar">
    <h3>Category</h3>
    <ul>
        <li><a href="books.php">All Books</a></li>
        <?php foreach ($allCategories as $category): ?>
            <li><a href="books.php?category=<?= urlencode($category) ?>"><?= htmlspecialchars($category) ?></a></li>
        <?php endforeach; ?>
    </ul>
</aside>

<section class="book-display">
    <div class="sort-filter">
        <label for="sort">Sort by:</label>
        <select id="sort" onchange="location = this.value;">
            <option value="books.php?category=<?= $categoryFilter ?>&sort=default" <?= $sort_order == 'default' ? 'selected' : '' ?>>Related</option>
            <option value="books.php?category=<?=$categoryFilter?>&sort=oldest" <?= $sort_order == 'oldest' ? 'selected' : '' ?>>Oldest</option>
            <option value="books.php?category=<?= $categoryFilter ?>&sort=latest" <?= $sort_order == 'latest' ? 'selected' : '' ?>>Latest</option>
            <option value="books.php?category=<?=$categoryFilter ?>&sort=asc" <?= $sort_order == 'asc' ? 'selected' : '' ?>>Ascending Alphabet</option>
            <option value="books.php?category=<?= $categoryFilter ?>&sort=desc" <?= $sort_order == 'desc' ? 'selected' : '' ?>>Descending Alphabet</option>
        </select>
    </div>

    <div class="book-grid">
        <?php if (count($books) > 0): ?>
            <?php foreach ($books as $book): ?>
                <div class="book-item">
                    <a href="details.php?id=<?= $book['B_id'] ?>">
                        <img src="<?= $book['image_path'] ?>" alt="Book Image" style="width:100%;height:150px;">
                        <h4><?= $book['bookname'] ?></h4>
                        <p>Year: <?= $book['publish_date'] ?></p>
                        <!-- <p>Category: <?= $book['category'] ?></p> -->
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No books found in this category.</p>
        <?php endif; ?>
    </div>
</section>



        </section>
</main>

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
            <li><a href="#" class=" btn btn-primary">C</a></li>
            <li><a href="#" class=" btn btn-primary">C++</a></li>
            <li><a href="#" class=" btn btn-primary">Java</a></li>
            <li><a href="#" class=" btn btn-primary">php</a></li>
            <li><a href="#" class=" btn btn-primary">React</a></li>
            <li><a href="#" class=" btn btn-primary">Sql</a></li>
            <li><a href="#" class=" btn btn-primary">linux</a></li>
          </ul>
        </div>
        <div class="quick-links list">
          <h4>Quick Links</h4>
          <ul>
            <li><a href="dashboard.php" class=" btn btn-primary">About Us</a></li>
            <li><a href="#" class=" btn btn-primary">Contact Us</a></li>
            <li><a href="#" class=" btn btn-primary">Latest</a></li>
            <li><a href="#" class=" btn btn-primary">Popular</a></li>
            <li><a href="#" class=" btn btn-primary">Most Viewed</a></li>
            <li><a href="books.php" class=" btn btn-primary">Books</a></li>
            <li><a href="#" class=" btn btn-primary">ReadList</a></li>
          </ul>
        </div>
        <div class="our-location">
          <h4>Our Location</h4>
          <div class="map" style="margin-top: 1rem">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3533.331712639985!2d85.36118019999999!3d27.676140799999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb1a1bed1bdd29%3A0x70040fb78c745729!2sSamriddhi%20College!5e0!3m2!1sen!2snp!4v1730720487912!5m2!1sen!2snp" class=" btn btn-primary"
              height="100"
              style="width: 100%; border: none; border-radius: 5px"
              allowfullscreen=""
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
             ></iframe>
          </div>
          <ul>
           
              <a href="#" class=" btn btn-primary">Lokanthali-1, 44800, Bhaktapur</a
              ><hr style="border:0.5px solid #E4E0E1;">
           <br> 
            
              <a href="#" class=" btn btn-primary">+977-9840031102</a>
            <hr style="border:0.5px solid #E4E0E1;">
            <br>
              <a href="#" class=" btn btn-primary">Support at:<br>ABC@gmail.com</a>
                <br><br><br><br>
            
          </ul>
        </div>
      </div>
    </footer>
    <button class="back-to-top">∧</button>
    <script src="js/back-to-top.js"></script>
  </body>
</html>