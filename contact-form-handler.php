<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Honeypot field
    if (!empty($_POST["website"])) {
        http_response_code(400);
        echo "There was a problem with your submission, please try again.";
        exit;
    }

    // Collect and sanitize form data
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $category = strip_tags(trim($_POST["request_category"]));
    $message = strip_tags(trim($_POST["query"]));

    // Validate form data
    if (empty($name) || empty($email) || empty($category) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Please fill in all required fields and provide a valid email address.";
        exit;
    }

    // Send email using PHPMailer
    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'v234126.serveradd.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'admin@streaming.sg';
        $mail->Password = '53710000@tT';
        $mail->SMTPSecure = 'tls'; // or 'ssl' if required
        $mail->Port = 587; // or 465 if using SSL

        // Email settings
        $mail->setFrom($email, $name);
        $mail->addReplyTo($email, $name);
        $mail->addAddress('getmaven@gmail.com', 'Kumar S');
        $mail->isHTML(true);
        $mail->Subject = 'Contact Form Submission';
        $mail->Body = "Name: {$name}<br>Email: {$email}<br>Category: {$category}<br>Message: {$message}";


        // Send email
        $mail->send();
        http_response_code(200);
        echo 'Message has been sent';
    } catch (Exception $e) {
        http_response_code(500);
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>
