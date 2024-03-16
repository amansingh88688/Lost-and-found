<?php
include "errors.php";

$url = "localhost";
$user = "root";
$pass = "";
$dbname = "lost_found_portal";


$con = mysqli_connect($url, $user, $pass, $dbname);

if (mysqli_connect_errno()) {
    echo ("<script>console.log('Connection Failed');</script>");
} else {
    echo ("<script>console.log('Connection Success');</script>");
}
