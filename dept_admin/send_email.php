<?php
$to       = 'gandhitanmay513@gmail.com';
$subject  = 'My test email';
$message  = 'Hi, my message!';
$headers  = "From:smitzaveri123@gmail.com \r\n";
$headers  = "MIME-Version: 1.0 \r\n";
$headers = "Content-type: text/html \r\n";
if(mail($to, $subject, $message, $headers))
    {echo "Email sent";}
else{
    echo "Email sending failed";}
?>