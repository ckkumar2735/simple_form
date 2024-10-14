<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $name = isset($_POST["name"]) ? htmlspecialchars(trim($_POST["name"])) : "Name Not Provided";
    $email = isset($_POST["email"]) ? htmlspecialchars(trim($_POST["email"])) : "Email Not Provided";
    $mobile = isset($_POST["mobile"]) ? htmlspecialchars(trim($_POST["mobile"])) : "Mobile Not Provided";
    $business = isset($_POST["business"]) ? htmlspecialchars(trim($_POST["business"])) : "Business Name Not Provided";

    // Prepare email body
    $bodyHTML = '<h2>New Callback Request</h2>';
    $bodyHTML .= '<p><strong>Name: </strong>' . $name . '</p>';
    $bodyHTML .= '<p><strong>Email: </strong>' . $email . '</p>';
    $bodyHTML .= '<p><strong>Mobile Number: </strong>' . $mobile . '</p>';
    $bodyHTML .= '<p><strong>Business Name: </strong>' . $business . '</p>';

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // SMTP server configuration
        $mail->isSMTP();
        $mail->Host = 'md-32.webhostbox.net'; // Your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'contact@kokanvant.com'; // Your SMTP username
        $mail->Password = 'vivekg@123@@'; // Your SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Recipients
        $mail->setFrom('contact@kokanvant.com', 'Contact Form');
        $mail->addAddress('chandansir617@gmail.com'); // Your email address to receive form data

        // Email content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'New Callback Request from ' . $name;
        $mail->Body = $bodyHTML;

        // Send email
        $mail->send();

        // Redirect or success message
        header("location:index.php"); // Redirect after successful submission
    } catch (Exception $e) {
        // If email sending fails
        echo json_encode(['success' => false, 'error' => 'Email not sent. Error: ' . $mail->ErrorInfo]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
?>
