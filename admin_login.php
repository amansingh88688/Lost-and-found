<?php
session_start();

if (isset($_SESSION['loggedin'])) {
    header('Location: admin.php');
    exit();
} else if (isset($_COOKIE['roll'])) {
    $_SESSION['loggedin'] = true;
    $_SESSION['roll'] = $_COOKIE['roll'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="css/login.css" />
    <title>Admin Login | Lost and Found Portal</title>
    <!-- <script src="js/prevent_back.js"></script> -->

</head>

<body oncontextmenu="return false;" onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">
    <nav>
        <h1>Student's Lost n Found Portal in IIT Madras</h1>
        <div class="logo">
            <img src="images/logo.png" alt="Logo Image" />
        </div>
    </nav>

    <div class="container">
        <div class="form form--signup">
            <div class="form--heading">Sign In to admin account</div>
            <div class="form--heading heading2">Sign In to admin account using your Username and Password</div>
            <form autocomplete="off" method="post">
                <div class="form-input-container">
                    <input type="text" id="roll" name="roll" placeholder="Username" />
                </div>
                <div class="form-input-container">
                    <input type="password" id="password" name="password" placeholder="Password" />
                </div>
                <a href="#">Forgot Password?</a>
                <button class="button">Sign In</button>
                <a href="index.php">User Login</a>
            </form>
        </div>

        <div class="message signup">
            <div class="btn-wrapper">
                <p><b>"Lost and Found at IIT Madras"</b> is a platform dedicated to helping members of the IIT
                    Madras community locate their lost belongings and report found items. It simplifies the process
                    of reuniting people with their lost items, promoting a more organized and helpful environment
                    within the campus.</p>
            </div>
        </div>
    </div>
</body>

</html>


<?php
include "dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] ==  'POST') {

    $roll = $_POST['roll'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM `admin` WHERE `roll` = '$roll'";

    $result = mysqli_query($con, $sql);
    $rows_user = mysqli_num_rows($result);
    if ($rows_user == 1) {
        $row = mysqli_fetch_assoc($result);
        $hash = $row['password'];
        // if (password_verify($password, $hash)) {
        if ($password === $hash) {
            setcookie("roll", $roll, time() + 86400 * 7, "/");
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['roll'] = $roll;
            header("Location: admin.php");
            exit();
        } else {
            echo ("<script>alert('Incorrect Password')</script>");
        }
    } else {
        echo ("<script>alert('Account not found')</script>");
    }
}
?>