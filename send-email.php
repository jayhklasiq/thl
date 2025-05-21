<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
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
  $mail->Host = 'smtp.zoho.com';
  $mail->Port = '465';
  $mail->isHTML(false);

  $mail->Username = $_ENV['EMAIL'];
  $mail->Password = $_ENV['PASSWORD'];

  $mail->setFrom($_ENV['EMAIL'], $name); // Use your own email as the sender
  $mail->addReplyTo($email, $name);      // User's email as reply-to
  $mail->addAddress($_ENV["EMAIL"], $name); // Use the form name as recipient name

  $mail->Subject = "Enquiry from $name";
  $mail->Body = "Phone Number: $phone\n $message";

  $mail->send();

  echo "Email Successfully Sent. <a href='/'>Go to Home Page</a>";
} catch (Exception $e) {
  echo "Error sending email: {$mail->ErrorInfo}. <a href='/'>Go to Home Page</a>";
}
