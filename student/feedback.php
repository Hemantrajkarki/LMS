<?php
include "connection.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Feedback</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <style type="text/css">
        .form-control {
            height: 50px;

        }
    </style>
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
                            <li><a href="student_login.php">STUDENT_LOGIN</a></li>
                            <li><a href="feedback.php">FEEDBACK</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>

        <div class="feedback-wrapper">
            <div class="feedback-inner">
                <h4>If you have any suggestion or questions please comment below.</h4>
                <form action="" method="post">
                    <input class="form-control" type="text" name="comment" placeholder="Write something..." required>
                    <br>
                    <button id="comment-submit" class="btn btn-default" type="submit" name="submit">
                        Comment
                    </button>

                </form>


            </div>

            <div id="comment-table" class="show-table">
                <div id="time-counter">5</div>
                <?php
                if (isset($_POST['submit'])) {
                    // Sanitize input to prevent SQL injection
                    $comment = mysqli_real_escape_string($db, $_POST['comment']);

                    // Use prepared statements to prevent SQL injection
                    $stmt = $db->prepare("INSERT INTO comments (comment) VALUES (?)");
                    $stmt->bind_param("s", $comment);

                    if ($stmt->execute()) {
                        // Redirect to avoid resubmission on refresh
                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit();
                    } else {
                        echo "Error inserting comment: " . $stmt->error;
                    }

                    $stmt->close();
                }

                // Query to fetch comments
                $q = "SELECT * FROM comments ORDER BY id DESC LIMIT 1";
                $res = mysqli_query($db, $q);

                if ($res) {
                    if (mysqli_num_rows($res) > 0) {
                        // Display comments
                        echo "<table class='table table-bordered'>";
                        echo "<tr><th>Comment</th></tr>"; // Table header
                        while ($row = mysqli_fetch_assoc($res)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['comment']) . "</td>"; // Safely output comment
                            echo "</tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "No comments found.";
                    }
                } else {
                    echo "Error fetching comments: " . mysqli_error($db);
                }
                ?>


            </div>
        </div>



        <script>
            const commentBtn = document.getElementById("comment-submit");
            const commentTable = document.getElementById("comment-table");
            const commentCounter = document.getElementById("time-counter");

            let countdown = 5; // Countdown time in seconds

            function updateCounter() {
                commentCounter.textContent = countdown;
                if (countdown > 0) {
                    countdown -= 1;
                } else {
                    clearInterval(counterInterval);
                    commentTable.classList.remove("show-table");
                }
            }

            // Initialize the countdown timer
            const counterInterval = setInterval(updateCounter, 1000);
        </script>

    </div>

</body>

</html>