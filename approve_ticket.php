<?php
include "dbconnect.php";

$id = $_GET['id'];
$update_sql = "UPDATE `user_content` SET `approved` = 'yes' WHERE `sno` = '$id';";

$result_update = mysqli_query($con, $update_sql);

if ($result_update) {
    header('Location: admin.php');
}
