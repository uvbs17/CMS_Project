<!-- PHP Starts Here -->

<?php
session_start();
require_once "../connection/connection.php";
//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the mobile number entered by the user
    $mobile_no = $_POST['mobile_no'];

    // Retrieve the user's email, middle name, user ID, and password from the database
    $query = "SELECT email, middle_name, user_id, password FROM student_info WHERE mobile_no = ? OR user_id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ss", $mobile_no, $mobile_no);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Destructure the fetched row into individual variables
        extract($row);

        // Send the password to the user's email address
        sendPassword($email, $middle_name, $user_id, $password);
    }
}






function sendpassword($email, $mname, $enrollment_no, $password)
{


    //Load Composer's autoloader
    require '../vendor/autoload.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF; //Disable verbose debug output in production
        $mail->isSMTP(); //Send using SMTP
        $mail->Host = 'smtp.sendgrid.net'; //Set the SMTP server to send through
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Username = 'apikey'; //SMTP username
        $mail->Password = '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'; //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
        $mail->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('smitzaveri123@gmail.com', 'Bhagwan Mahavir University');
        $mail->addAddress($email, $mname); //Add a recipient
        // $mail->addAddress('smitzaveri1003@gmail.com'); //Name is optional
        // $mail->addReplyTo('smitzaveri123@gmail.com', 'Information');

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = 'Password';
        $mail->isHTML(true);

        // set the body of the message with the enrollment details table
        $mail->Body = '<html>
        <head>
          <style>
            body {
              font-family: Arial, sans-serif;
              font-size: 16px;
              line-height: 1.5;
              color: #333;
              margin: 0;
              padding: 0;
              background-color: #f5f5f5;
            }
            h1 {
              font-size: 24px;
              font-weight: bold;
              margin-top: 0;
            }
            p {
              margin-bottom: 20px;
            }
            .container {
              max-width: 600px;
              margin: 0 auto;
              padding: 20px;
              background-color: #fff;
              border-radius: 4px;
              box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
            table {
              border-collapse: collapse;
              width: 100%;
              margin-bottom: 20px;
            }
            th, td {
              border: 1px solid #ddd;
              padding: 10px;
              text-align: left;
            }
            th {
              background-color: #f5f5f5;
            }
            .message {
              background-color: #f9f9f9;
              padding: 15px;
              border-radius: 4px;
              border-left: 4px solid #3498db;
              margin-bottom: 20px;
            }
          </style>
        </head>
        <body>
          <div class="container">
            <h1>Password Reset</h1>
            <div class="message">
              <p>Dear ' . $mname . ',</p>
              <p>We have received your request to reset your password. As per your request, we are sending you the old login credentials for your account with Bhagwan Mahavir University.</p>
            </div>
      
            <p>Please find below your updated enrollment details:</p>
            <table>
              <tr>
                <th>User ID</th>
                <th>Password</th>
              </tr>
              <tr>
                <td>' . $enrollment_no . '</td><td>' . $password . '</td>
                </tr>
                </table>
          
                <p>Note that this is your temporary password, and you will need to change it immediately after your first login for security reasons. Please keep these details safe and secure, as they will be needed throughout your academic journey with us. If you encounter any issues or have any questions, please do not hesitate to reach out to our support team, who are always happy to assist.</p>
          
                <p>We hope you have a great experience studying at Bhagwan Mahavir University.</p>
          
                <p>Best regards,<br>BMU</p>
              </div>
            </body>
          </html>';
        
        $mail->send();
        header("Location: login.php"); //Redirect to success page on successful send

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}

?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <title>Document</title>
    <style>
        .gg-arrow-left {
            box-sizing: border-box;
            position: relative;
            display: block;
            transform: scale(var(--ggs, 1));
            width: 22px;
            height: 22px;
        }

        div.content {
            border-radius: 30px;
            animation: tilt-in-fwd-tr 0.6s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
        }

        form div input {
            border-radius: 20px;
        }

        div.field {
            border-radius: 20px;
        }

        div.gg-arrow-left {
            position: absolute;
            top: 10%;
            left: 40px;
            font-weight: 900;
        }

        .gg-arrow-left::after,
        .gg-arrow-left::before {
            content: "";
            display: block;
            box-sizing: border-box;
            position: absolute;
            left: 3px;
        }

        .gg-arrow-left::after {
            width: 8px;
            height: 8px;
            border-bottom: 2px solid white;
            border-left: 2px solid white;
            transform: rotate(45deg);
            bottom: 7px;
        }

        .gg-arrow-left::before {
            width: 16px;
            height: 2px;
            bottom: 10px;
            background: white;
        }

        @keyframes tilt-in-fwd-tr {
            0% {
                transform: rotateY(20deg) rotateX(35deg) translate(300px, -300px) skew(-35deg, 10deg);
                opacity: 0;
            }

            100% {
                transform: rotateY(100) rotateX(0deg) translate(0, 0) skew(0deg, 0deg);
                opacity: 1;
            }
        }

        form a {
            color: white;
            position: absolute;
            right: 25px;
            margin: 15px;
            font-size: 15px;
            font-family: 'Open Sans', sans-serif;
            text-decoration: none;
        }


        a.forgot-link:hover {
            color: #333;
            border-color: #333;
        }



        div div header {
            margin-bottom: 20px;
        }
        .bg-img {
            background: url("https://images.pexels.com/photos/289737/pexels-photo-289737.jpeg?auto=compress&cs=tinysrgb&w=1820&h=1281&dpr=1") center no-repeat fixed !important;
            height: 100vh;
        }

        .bg-img:after {
            position: absolute;
            content: "";
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            /* background: rgba(255, 255, 255, 0.174); */
            background-color: rgba(0, 0, 0, 0.5);
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">

</head>

<body>
    <div class="bg-img">
        <div class="content tilt-in-fwd-tr">
            <a href="../">
                <div class="gg-arrow-left"></div>
            </a>
            <header>Forgot Password</header>
            <form action="" method="post">
                <div class="field">
                    <span class="fa fa-user"></span>
                    <input type="text" name="mobile_no" value="" placeholder="Enter Mobile Number Or User ID" required>
                </div>
                <div class="pass">
                    <!-- <?php echo $message; ?> -->
                </div>
                <div class="field">
                    <input type="submit" name="btnlogin" value="SUBMIT">
                </div>
                <a href="login.php" class="forgot-link">Login ?</a>
            </form>
        </div>
    </div>
</body>

</html>