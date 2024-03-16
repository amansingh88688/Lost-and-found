<?php
session_start();

if (isset($_SESSION['loggedin'])) {
    header('Location: home.php');
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
    <link rel="stylesheet" href="css/login.css?v=<?php echo time(); ?>" />
    <title>Forgot Password | Lost and Found Portal</title>
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
            <div class="form--heading">Forgot Password?</div>
            <div class="form--heading heading2">Enter your roll number to generate OTP to set new password.</div>
            <form autocomplete="off" method="post">
                <div class="form-input-container">
                    <input type="text" id="roll" name="roll" placeholder="Roll Number" />
                </div>
                <a href="index.php">Have an account?</a>
                <input type="submit" value="Generate OTP" id="otp_btn" name="otp_btn" class="button">
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
include "generate_otp.php";

if ($_SERVER['REQUEST_METHOD'] ==  'POST') {
    $roll = $_POST['roll'];

    $sql = "SELECT * FROM `users` WHERE `roll` = '$roll' AND `approved` = 'yes'";
    $result = mysqli_query($con, $sql);
    $rows_user = mysqli_num_rows($result);
    if ($rows_user == 1) {
        $row = mysqli_fetch_assoc($result);
        $OTP = generateOTP($roll);
        $sql = "UPDATE `users` SET `timestamp` = current_timestamp(),`otp` = '$OTP',`otp_expired` = 'no' WHERE `roll` = '$roll' ";
        $result = mysqli_query($con, $sql);
        if ($result) {
            $_SESSION['roll_forgot_pass'] = $roll;
            $_SESSION['forgot_pass'] = 'true';
            header('Location: otp_verify.php');
        } else {
            echo ("<script>console.log('$con->error');</script>");
            echo ("<script>alert('Some error occured!')</script>");
        }
    } else {
        echo ("<script>alert('Account not found or not verified')</script>");
    }
}
?>