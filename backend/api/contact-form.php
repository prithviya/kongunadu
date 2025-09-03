<?php

// header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../config.php';  // Include the database connection
require_once __DIR__ . '/../schema/contact.php';  // Include the schema database

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$name = $_POST['name'];
$mobile = $_POST['phone'] ?? '';
$email = $_POST['email'];
$product = $_POST['subject'];
$message = $_POST['message'];

try {
    // Insert data into the database
    $stmt = $mysqli->prepare("INSERT INTO contact_form (name, phone, email, product, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $mobile, $email, $product, $message);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        // Create an instance of PHPMailer for sending emails
        $mail = new PHPMailer(true);

        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['EMAIL_FROM'];
        $mail->Password = $_ENV['EMAIL_PASSWORD'];
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Send email to the client
        $mail->setFrom($_ENV['EMAIL_FROM'], $_ENV['EMAIL_NAME']);
        $mail->addAddress($_ENV['EMAIL_TO']);
        $mail->addBCC($_ENV['EMAIL_BCC']);
        $mail->isHTML(true);
        $mail->Subject = 'Contact Form';
        include('../mail-template/contact-detail.php');
        $mail->send();

        // Send acknowledgment email to the user
        $mail->clearAddresses(); // Clear the previous recipient
        $mail->addAddress($email); // Add the user's email
        $mail->Subject = 'Thank you for contacting us';
        include('../mail-template/acknowledgement.php');
        $mail->send();

        echo "<strong>Great !</strong> We received your response. We will contact you soon.";
    } else {
        echo "Error: Unable to save your data.";
    }
    
    $stmt->close();
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}

?>
