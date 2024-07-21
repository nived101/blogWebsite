<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST["contactSubmit"])) {


    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'nivedkm102@gmail.com';  // Your Gmail address
        $mail->Password = 'swfdntxlhgkvvmnm';   // Your Gmail password or app password
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Recipients
        $mail->setFrom('nivedkm102@gmail.com', 'Blogs');
        $mail->addAddress($_POST["email"]);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $_POST["subject"];
        $mail->Body    = $_POST["feedback"];

        $mail->send();
        echo '<script>alert("Thank you for your Contacting us!"); window.location.href = "index.php";</script>';
        exit();
    } catch (Exception $e) {
        echo "<p>Sorry, there was an error sending your feedback. Please try again later.</p>";
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
