<?php

require "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$phone = htmlspecialchars($_POST['phone']);
$message = htmlspecialchars($_POST['message']);

$mail = new PHPMailer((true));

try {
  $mail->isSMTP();
  $mail->SMTPAuth = true;
  $mail->SMTPSecure = 'ssl';
  $mail->Host = 'smtp.gmail.com';
  $mail->Port = '465';
  $mail->isHTML(false);

  $mail->Username = $_ENV["EMAIL"];
  $mail->Password = $_ENV["PASSWORD"];

  $mail->setFrom($email, $name);
  $mail->addAddress($_ENV["EMAIL"], "Joshua");

  $mail->Subject = "Enquiry from $name";
  $mail->Body = "Phone Number: $phone\n $message";

  $mail->send();

  echo "Email Successfully Sent.";
} catch (Exception $e) {
  echo "Error sending email: {$mail->ErrorInfo}";
}
