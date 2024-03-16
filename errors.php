<?php

error_reporting(E_ALL);
ini_set("display_errors", 0);

function customErrorHandler($errno, $errstr, $errfile, $errline)
{
    echo "<script>console.log('Error: [$errno] $errstr - $errfile, At Line: $errline');</script>";
    // error_log($err_msg . PHP_EOL, 3, "log.txt");
}

// Can only work for warnings, not for fatal errors
set_error_handler("customErrorHandler");
