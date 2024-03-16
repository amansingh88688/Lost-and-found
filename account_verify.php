<?php
session_start();

if (isset($_SESSION['loggedin'])) {
    header('Location: home.php');
    exit();
} else if (isset($_COOKIE['roll'])) {
    $_SESSION['loggedin'] = true;
    $_SESSION['roll'] = $_COOKIE['roll'];
} else if (!isset($_SESSION['acc_verify'])) {
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
    <title>Verify Account | Lost and Found Portal</title>
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
            <div class="form--heading">Verify OTP</div>
            <div class="form--heading heading2">Enter the OTP sent to your smail, to verify the account.</div>
            <form method="post">
                <div class="form-input-container">
                    <input type="text" id="otp" name="otp" placeholder="OTP" />
                </div>
                <input type="submit" value="Verify OTP" id="otp_btn" name="otp_btn" class="button">
                <a href="index.php">Log In?</a>
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
    $inputOTP = $_POST['otp'];
    $roll = $_SESSION['roll_acc_verify'];
    $sql = "SELECT * FROM `users` WHERE `roll` = '$roll'";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $time = $row['timestamp'];
        $sql2 = "SELECT * FROM `users` WHERE `roll` = '$roll' AND `otp_expired` != 'yes' AND NOW() <= DATE_ADD('$time', INTERVAL 15 MINUTE)";
        $result2 = mysqli_query($con, $sql2);
        $number = mysqli_num_rows($result2);
        if ($number == 1) {
            $row2 = mysqli_fetch_assoc($result2);
            $otp = $row2['otp'];
            if ($inputOTP == $otp) {
                $sql = "UPDATE `users` SET `otp_expired` = 'yes', `approved` = 'yes' WHERE `roll` = '$roll';";
                $result = mysqli_query($con, $sql);
                echo ("<script>alert('Account verified! Login to continue')</script>");
                session_unset();
                session_destroy();
                header('refresh: 0.01; url=index.php');
            } else {
                echo ("<script>alert('Incorrect OTP!')</script>");
            }
        } else {
            echo ("<script>alert('OTP Expired!')</script>");
        }
    }
}

?>