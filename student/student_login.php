<?php
// Start the session
session_start();

// Connect to the database
$db = mysqli_connect("localhost", "root", "", "library");

if (!$db) {
  die("Connection failed: " . mysqli_connect_error());
}

// Initialize session messages
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);

if (isset($_POST['submit'])) {
  // Get the input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  // Use a prepared statement to prevent SQL injection
  $stmt = $db->prepare("SELECT * FROM `student` WHERE username = ? AND password = ?");
  $stmt->bind_param("ss", $username, $password);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows == 0) {
    $_SESSION['message'] = "The username and password do not match.";
  } else {
    // Redirect to the homepage or another page after successful login
    $_SESSION['username'] = $username; // Store username in session
    header("Location: index.php");
    exit();
  }

  $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student Login</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
  <div class="wrapper">
    <header>
      <div class="container">
        <div class="header__holder">
          <div class="logo">
            <a href="#">
              <img src="images/book.jpg" alt="Library Logo" />
              <span>LIBRARY MANAGEMENT SYSTEM</span>
            </a>
          </div>
          <nav>
            <ul>
              <li><a href="index.php">HOME</a></li>
              <li><a href="books.php">BOOKS</a></li>
              <li><a href="student_login.php">STUDENT LOGIN</a></li>
              <li><a href="admin_login.php">ADMIN LOGIN</a></li>
              <li><a href="feedback.php">FEEDBACK</a></li>
              <li><a href="student_login.php"><span class="glyphicon glyphicon-log-in"> LOGIN</span></a></li>
              <li><a href="student_login.php"><span class="glyphicon glyphicon-log-out"> LOGOUT</span></a></li>
              <li><a href="registration.php"><span class="glyphicon glyphicon-user"> SIGN UP</span></a></li>
            </ul>
          </nav>
        </div>
      </div>
    </header>
    <section class="login-banner">
      <img src="./images/login.jpg" alt="Login Image" class="loginImg" />
      <div class="banner__content">
        <div class="banner__box">
          <form class="login-form" name="login" action="" method="post">
            <input type="text" name="username" placeholder="Username" required />
            <input type="password" name="password" placeholder="Password" required />
            <input class="btn btn-default" type="submit" name="submit" value="Login" style="color: black; width: 100px; height: 35px">
          </form>
          <?php if ($message) : ?>
            <p style="color: red;"><?php echo htmlspecialchars($message); ?></p>
          <?php endif; ?>
          <p style="color: white">
            <br />
            <a style="color: white" href="#">Forget Password?</a>&nbsp;&nbsp;
            New user?<a style="color: white" href="registration.php">Sign Up</a>
          </p>
        </div>
      </div>
    </section>

    <footer>
      <div class="container">
        <div class="footer__box">
          <p>Email: <a href="mailto:library12@gmail.com">library12@gmail.com</a></p>
          <p>Mobile: <a href="tel:9821638024">9821638024</a></p>
        </div>
      </div>
    </footer>
  </div>
</body>

</html>