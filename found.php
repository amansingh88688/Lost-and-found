<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    if (!isset($_COOKIE['roll'])) {
        header('Location: index.php');
        session_unset();
        session_destroy();
        exit();
    } else {
        $_SESSION['loggedin'] = true;
        $_SESSION['roll'] = $_COOKIE['roll'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Found Item | Lost and Found Portal</title>
    <link rel="stylesheet" href="css/found.css?v=<?php echo time(); ?>">
    <!-- <script src="js/prevent_back.js"></script> -->
</head>

<body oncontextmenu="return false;" onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">
    <div class="header">
        <h1 class="green-text">FOUND!!!</h1>
        <div class="buttons">
            <a href="home.php" class="button home-button">Home</a>
            <a href="lost.php" class="button home-button">Lost</a>
            <a href="logout.php" class="button logout-button">Logout</a>
        </div>
    </div>
    <form action="" method="post" enctype="multipart/form-data">

        <div class="column-container">
            <div class="column column1">
                <h2>Item Details:</h2>
                <div class="form">
                    <input type="text" id="item" name="item" placeholder="Name" required>
                </div>
                <div class="form">
                    <input type="text" id="place" name="place" placeholder="Where did you find it?" required>
                </div>
                <div class="form">
                    <input type="text" name="date" id="date" placeholder="When did you find it? (Date and Time)" required>
                </div>
                <div class="form">
                    <label for="itemImage">Attach an image</label>
                    <input type="file" id="image" name="image" accept="image/*" required>
                </div>
            </div>
            <div class="column column2">
                <h2>Your Details:</h2>
                <div class="form">
                    <input type="text" id="name" name="name" placeholder="Name" required>
                </div>
                <div class="form">
                    <input type="text" id="roll" name="roll" placeholder="Roll Number" required>
                </div>
                <div class="form">
                    <input type="text" id="phone" name="phone" placeholder="Phone" required>
                </div>
                <div class="form">
                    <input type="text" id="smail" name="smail" placeholder="Smail" required>
                </div>
                <div class="form">
                    <input type="text" id="hostel" name="hostel" placeholder="Hostel" required>
                </div>
                <div class="form submit column">

                    <input type="submit" value="Raise Ticket" class="raise-ticket-button">
                </div>
            </div>

        </div>
    </form>

</body>

</html>


<?php

include 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] ==  'POST') {
    echo ("<script>console.log('Post');</script>");

    $item = $_POST['item'];
    $place = $_POST['place'];
    $date = $_POST['date'];
    $name = $_POST['name'];
    $roll = $_POST['roll'];
    $phone = $_POST['phone'];
    $smail = $_POST['smail'];
    $hostel = $_POST['hostel'];

    $temp_img = $_FILES['image']['tmp_name'];
    $img = addslashes(file_get_contents($temp_img));

    $insert_sql = "INSERT INTO user_content (item, place, date, image, name, roll, phone, smail, hostel, type, approved) VALUES ('$item', '$place', '$date', '$img','$name','$roll','$phone','$smail','$hostel','found','no')";

    $result_insert = mysqli_query($con, $insert_sql);

    if ($result_insert) {
        echo "<script>alert('Ticket raise! It will be displayed after being approved by the admins');</script>";
    } else {
        echo "<script>alert('Could not upload');</script>";
    }
}
?>