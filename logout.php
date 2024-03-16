<?php
session_start();
session_unset();
session_destroy();
setcookie("roll", "", time() - 86400 * 7, "/");
header("Location: index.php");
exit();
