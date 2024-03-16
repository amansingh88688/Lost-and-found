
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

function generateOTP($roll)
{
    $OTP = rand(1000, 9999);
    try {
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Mailer = 'smtp';
        $mail->SMTPAuth = true;
        $mail->CharSet = 'utf-8';
        $mail->Username = 'shashwatkedia33@gmail.com';
        $mail->Password = 'hwpyozeadzalgkws';
        $mail->SMTPSecure = 'tls';
        $mail->Port = '587';
        $mail->addAddress($roll . '@smail.iitm.ac.in');
        $mail->isHTML(true);
        $mail->Subject = 'OTP';
        $mail->Body = 'OTP for the Lost & Found Portal is ' . $OTP . '. The OTP is valid for 15 minutes only.';
        $mail->send();
    } catch (Exception $e) {
        echo "Exception $e";
    }
    return $OTP;
}
