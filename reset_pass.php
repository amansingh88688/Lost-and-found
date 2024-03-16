<?php
session_start();

if (isset($_SESSION['loggedin'])) {
    header('Location: home.php');
    exit();
} else if (isset($_COOKIE['roll'])) {
    $_SESSION['loggedin'] = true;
    $_SESSION['roll'] = $_COOKIE['roll'];
} else if (!isset($_SESSION['forgot_pass'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="css/login.css?v=<?php echo time(); ?>" />
    <title>Reset Password | Lost and Found Portal</title>
    <script src="js/prevent_back.js"></script>

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
            <div class="form--heading">New Password</div>
            <div class="form--heading heading2">Enter the new password (and remeber it ;)</div>
            <form autocomplete="off" method="post">
                <div class="form-input-container">
                    <input type="password" id="password" name="password" placeholder="Password" />
                </div>
                <div class="form-input-container">
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" />
                </div>
                <input type="submit" value="Submit" id="otp_btn" name="otp_btn" class="button">
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
    $roll = $_SESSION['roll_forgot_pass'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password == $confirm_password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE `users` SET `password` = '$hash' WHERE `roll` = '$roll'";

        $result = mysqli_query($con, $sql);
        if ($result) {
            session_unset();
            session_destroy();
            echo ("<script>alert('Password Updated!');</script>");
            header('refresh: 0.01; url=index.php');
        } else {
            echo ("<script>alert('Some error occured!');</script>");
            header('refresh: 0.01; url=index.php');
        }
    } else {
        echo ("<script>alert('Passwords not matching')</script>");
    }
}

?>