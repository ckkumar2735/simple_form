<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $name = isset($_POST["con_name"]) ? htmlspecialchars(trim($_POST["con_name"])) : "Name Not Provided";
    $address = isset($_POST["con_address"]) ? htmlspecialchars(trim($_POST["con_address"])) : "Address Not Provided";
    $type = isset($_POST["type"]) ? htmlspecialchars(trim($_POST["type"])) : "Type Not Provided";
    $number_of_bedrooms = isset($_POST["number_of_bedrooms"]) ? htmlspecialchars(trim($_POST["number_of_bedrooms"])) : "Number of Bedrooms Not Provided";
    $location = isset($_POST["location"]) ? htmlspecialchars(trim($_POST["location"])) : "Location Not Provided";
    $phone = isset($_POST["con_phone"]) ? htmlspecialchars(trim($_POST["con_phone"])) : "Phone Not Provided";
    $terms_agree = isset($_POST['check']) ? 'Yes' : 'No';

    // Prepare email body
    $bodyHTML = '<p><strong>Name: </strong>' . $name . '</p>';
    $bodyHTML .= '<p><strong>Address: </strong>' . $address . '</p>';
    $bodyHTML .= '<p><strong>Type: </strong>' . $type . '</p>';
    $bodyHTML .= '<p><strong>Number of Bedrooms: </strong>' . $number_of_bedrooms . '</p>';
    $bodyHTML .= '<p><strong>Location: </strong>' . $location . '</p>';
    $bodyHTML .= '<p><strong>Mobile Number: </strong>' . $phone . '</p>';
    $bodyHTML .= '<p><strong>Agreed to Terms: </strong>' . $terms_agree . '</p>';

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'md-32.webhostbox.net';
        $mail->SMTPAuth = true;
        $mail->Username = 'contact@kokanvant.com';
        $mail->Password = 'vivekg@123@@';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Recipients
        $mail->setFrom('contact@kokanvant.com', 'Contact Form');
        $mail->addAddress('contact@kokanvant.com'); 

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Contact Form : ' . $name . ' - ' . date("Y-m-d");
        $mail->Body = $bodyHTML;

        $mail->send();
        // echo json_encode(['success' => true, 'message' => 'Email sent successfully']);
                header("location:index.php");

    } catch (Exception $e) {
        // Email sending failed
        echo json_encode(['success' => false, 'error' => 'Email not sent. Error: ' . $mail->ErrorInfo]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
?>
