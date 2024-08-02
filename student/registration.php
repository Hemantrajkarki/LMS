<?php
// Start the session
session_start();

// Connect to the database
$db = mysqli_connect("localhost", "root", "", "library");

if (!$db) {
  die("Connection failed: " . mysqli_connect_error());
}

// Initialize session messages
if (isset($_SESSION['message'])) {
  $message = $_SESSION['message'];
  unset($_SESSION['message']);
} else {
  $message = '';
}

if (isset($_POST['submit'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $sql = "SELECT username FROM student WHERE username = '$username'";
  $res = mysqli_query($db, $sql);

  if (mysqli_num_rows($res) > 0) {
    $_SESSION['message'] = "Username already exists.";
  } else {
    $first = mysqli_real_escape_string($db, $_POST['first']);
    $last = mysqli_real_escape_string($db, $_POST['last']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $contact = mysqli_real_escape_string($db, $_POST['contact']);

    $sql = "INSERT INTO student (first, last, username, password, email, contact) VALUES ('$first', '$last', '$username', '$password', '$email', '$contact')";

    if (mysqli_query($db, $sql)) {
      $_SESSION['message'] = "Registration successful.";
    } else {
      $_SESSION['message'] = "Error: " . mysqli_error($db);
    }
  }

  mysqli_close($db);
  // Redirect to the same page to show the message
  header("Location: registration.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student Registration</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
  <script type="text/javascript">
    // Display the PHP session message as a JavaScript alert
    window.onload = function() {
      <?php if ($message) : ?>
        alert('<?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>');
      <?php endif; ?>
    };
  </script>
</head>

<body>
  <div class="wrapper">
    <header>
      <div class="container">
        <div class="header__holder">
          <div class="logo">
            <a href="#">
              <img src="images/book.jpg" />
              <span>LIBRARY MANAGEMENT SYSTEM</span>
            </a>
          </div>
          <nav>
            <ul>
              <li><a href="index.php">HOME</a></li>
              <li><a href="books.php">BOOKS</a></li>
              <li><a href="student_login.php">STUDENT_LOGIN</a></li>
              <li><a href="">REGISTRATION</a></li>
              <li><a href="feedback.php">FEEDBACK</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </header>
    <section class="reg-banner">
      <div class="RegImg">
        <div class="banner__content">
          <div class="banner__box">
            <h1 style="text-align: center; font-size: 24px">User Registration Form</h1>
            <form class="register-form" action="" method="post">
              <input type="text" name="first" placeholder="First Name" required="" />
              <input type="text" name="last" placeholder="Last Name" required="" />
              <input type="text" name="username" placeholder="Username" required="" />
              <input type="password" name="password" placeholder="Password" required="" />
              <input type="text" name="email" placeholder="Email" required="" />
              <input type="text" name="contact" placeholder="Phone No." required="" />
              <input class="btn btn-default" type="submit" name="submit" value="Sign Up" style="color: black; width: 100px; height: 35px">
            </form>
          </div>
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