<?php
include "dbconnect.php";

$id = $_GET['id'];
$delete_sql = "DELETE FROM `user_content` WHERE `sno` = '$id'";

$result_delete = mysqli_query($con, $delete_sql);

if ($result_delete) {
    header('Location: mytickets.php');
}

echo "<script>console.log('In');</script>"
?>
<html>

</html>