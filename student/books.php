<?php
include "connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>books</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
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
                            <li><a href="feedback.php">FEEDBACK</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
        <h2>List Of Books</h2>
        <?php
        $res = mysqli_query($db, "SELECT * FROM `books` ORDER BY `books`.`name` ASC;");
        echo "<table class='table table-bordered table-hover'>";
        echo "<tr style='backgrpond-color: white;'>";

        echo "<th>";
        echo "ID";
        echo "</th>";
        echo "<th>";
        echo "Book-Name";
        echo "</th>";
        echo "<th>";
        echo "Authors Name";
        echo "</th>";
        echo "<th>";
        echo "Edition";
        echo "</th>";
        echo "<th>";
        echo "Status";
        echo "</th>";
        echo "<th>";
        echo "Quantity";
        echo "</th>";
        echo "<th>";
        echo "Department";
        echo "</th>";

        echo "</tr>";

        while ($row = mysqli_fetch_assoc($res)) {
            echo "<tr>";
            echo "<td>";
            echo $row['bid'];
            echo "</td>";
            echo "<td>";
            echo $row['name'];
            echo "</td>";
            echo "<td>";
            echo $row['authors'];
            echo "</td>";
            echo "<td>";
            echo $row['edition'];
            echo "</td>";
            echo "<td>";
            echo $row['status'];
            echo "</td>";
            echo "<td>";
            echo $row['quantity'];
            echo "</td>";
            echo "<td>";
            echo $row['department'];
            echo "</td>";

            echo "</tr>";
        }
        echo "</table>"; ?>


    </div>
</body>

</html>