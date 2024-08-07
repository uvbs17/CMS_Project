<?php

//Combine variable initialization into a loop
$fields = ['name', 'email', 'subject', 'message'];
foreach ($fields as $field) {
  $$field = isset($_POST[$field]) ? $_POST[$field] : '';
}

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                         //Disable verbose debug output in production
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.sendgrid.net';                    //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'apikey';                               //SMTP username
    $mail->Password   = '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';   //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('smitzaveri123@gmail.com', $name);
    $mail->addAddress($email, 'Smit');        //Add a recipient
    $mail->addAddress('smitzaveri1003@gmail.com');                //Name is optional
    $mail->addReplyTo('smitzaveri123@gmail.com', 'Information');

    //Content
    $mail->isHTML(true);                                         //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $message;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    header("Location: sent.html");                               //Redirect to success page on successful send

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
