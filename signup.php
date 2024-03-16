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
    <link rel="stylesheet" href="css/login.css" />
    <title>SignUp</title>
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
            <div class="form--heading">Sign up for your account</div>
            <div class="form--heading heading2">Enter roll number and password to generate otp to verify account.</div>
            <form autocomplete="off" method="post">
                <div class="form-input-container">
                    <input type="text" id="roll" name="roll" placeholder="Roll Number" />
                </div>
                <div class="form-input-container">
                    <input type="password" id="password" name="password" placeholder="Password" />
                </div>
                <div class="form-input-container">
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" />
                </div>
                <input type="submit" value="Generate OTP" id="submit1" name="submit1" class="button">
                <p class="heading2"> Already have an account?<a href="index.php"> Click Here</a></p>
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

if ($_SERVER['REQUEST_METHOD'] ==  'POST' && isset($_POST['submit1'])) {

    $roll = $_POST['roll'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password == $confirm_password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "SELECT * FROM `users` WHERE `roll` = '$roll'";

        $result = mysqli_query($con, $sql);
        $rows_user = mysqli_num_rows($result);
        if ($rows_user == 1) {
            $row = mysqli_fetch_assoc($result);
            $approved = $row['approved'];
            if ($approved == 'yes') {
                echo ("<script>alert('Account already exists, please login to access it');</script>");
            } else if ($approved == 'no') {
                $OTP = generateOTP($roll);
                $sql = "UPDATE `users` SET `timestamp` = current_timestamp(), `otp` = '$OTP', `otp_expired` = 'no' WHERE `roll` = '$roll'";
                $result = mysqli_query($con, $sql);
                if ($result) {
                    echo ("<script>alert('Account not verified, new OTP sent to smail! Enter OTP to verify account');</script>");
                    session_start();
                    $_SESSION['roll_acc_verify'] = $roll;
                    $_SESSION['acc_verify'] = 'true';
                    header('refresh: 0.01; url=account_verify.php');
                } else {
                    echo ("<script>console.log('$con->error');</script>");
                    echo ("<script>alert('Some error occured!')</script>");
                }
            }
        } else {
            $OTP = generateOTP($roll);
            $sql = "INSERT INTO `users` ( `roll`, `password`,`timestamp`,`otp`,`approved`, `otp_expired`) VALUES ('$roll', '$hash', current_timestamp(),'$OTP','no','no')";
            $result = mysqli_query($con, $sql);
            if ($result) {
                echo ("<script>alert('OTP sent to smail! Enter OTP to verify account');</script>");
                session_start();
                $_SESSION['roll_acc_verify'] = $roll;
                $_SESSION['acc_verify'] = 'true';
                header('refresh: 0.01; url=account_verify.php');
            } else {
                echo ("<script>console.log('$con->error');</script>");
                echo ("<script>alert('Some error occured!')</script>");
            }
        }
    } else {
        echo ("<script>alert('Passwords not matching')</script>");
    }
} else if ($_SERVER['REQUEST_METHOD'] ==  'POST' && isset($_POST['submit2'])) {
}


?>