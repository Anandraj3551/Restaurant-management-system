<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
    <title>Reservation</title>
    <link rel="stylesheet" href="reserv.css">
</head>

<body class="header">

    <nav>
        <div class="img1">
            <a href="home.html"> <img src="logo.png" alt="" height="100px" width="120px">
            </a>
        </div>
        <a href="#" class="logo">North Indian Resturant </a>

        <div class="nav-links">
            <ul>
                <li>
                    <a href="home.html">HOME</a>
                </li>
                <li><a href="menu.html">MENU</a></li>
                <li><a href="gallery.html">GALLERY</a></li>

                <li><a href="aboutus.html">ABOUT US</a></li>
            </ul>
        </div>
    </nav>
    <?php
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $number = $_POST['number'];
            $email = $_POST['email'];
            $date = $_POST['date'];
            $time = $_POST['time'];
            $people = $_POST['people'];
            $message = $_POST['message'];

            if (!empty($name) || !empty($number) || !empty($email) || !empty($date) || !empty($time) || !empty($people) || !empty($message)) {
                $host = "localhost";
                $dbusername = "root";
                $dbpassword = "";
                $dbname = "reservation";
                $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
                if (mysqli_connect_error()) {
                    die('connect error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
                } else {
                    $SELECT = "SELECT email from reservation where email=? limit 1";
                    $INSERT = "INSERT Into reservation(name,number,email,date,time,people,message) values(?,?,?,?,?,?,?)";

                    $stmt = $conn->prepare($SELECT);
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    $stmt->bind_result($email);
                    $stmt->store_result();
                    $rnum = $stmt->num_rows();
                    if ($rnum == 0) {
                        $stmt->close();


                        $stmt = $conn->prepare($INSERT);
                        $stmt->bind_param("sisssis", $name, $number, $email, $date, $time, $people, $message);
                        $stmt->execute();
                        echo "<center><h3 style='color:white'>Your table has been booked</h3></center>";
                    } else {
                        echo "<center><h3 style='color:white'>Someone has already register using this email</h3></center>";
                    }
                    $stmt->close();
                    $conn->close();
                }
            } else {
                echo "<center><h3 style='color:white'>All Field are required</h3></center>";
                die();
            }
        }
        ?>
    <div class="hero">

        <form action="" method="POST">
            <div class="row">
                <div class="input-group">
                    <input type="text" name="name" id="name" required>
                    <label for="name">Your Name</label>
                </div>
                <div class="input-group">
                    <input type="text" name="number" id="number" required>
                    <label for="number">Phone No.</label>
                </div>
            </div>
            <div class="input-group">
                <input type="email" name="email" id="email" required>
                <label for="email">Email Id</label>
            </div>
            <div class="input-group">
                <input type="date" name="date" id="date" required>
                <label for="date"></label>
            </div>
            <div class="input-group">
                <input type="time" name="time" id="time" required>
                <label for="time"></label>
            </div>
            <div class="input-group">
                <input type="number" name="people" id="people" required min="1" max="12">
                <label for="people">No. of people</label>
            </div>
            <div class="input-group">
                <textarea id="message" name="message" rows="8" required></textarea>
                <label for="message">Your Message</label>
            </div>
            <div class="btn">
                <button type="submit" name="submit">Book a Table</button>
            </div>
        </form>
        <br/>
       
        <br/>
    </div>
</body>

</html>