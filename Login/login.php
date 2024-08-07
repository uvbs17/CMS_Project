<!-- PHP Starts Here -->

<?php
session_start();
require_once "../connection/connection.php";
$message = "Email Or Password Does Not Match";
if (isset($_POST["btnlogin"])) {
    $username = $_POST["email"];
    $password = $_POST["password"];

    $query = "select * from student_info where user_id='$username' and password='$password' ";
    $result = mysqli_query($con, $query);
    $query2 = "DELETE FROM notifications 
    WHERE created_at < NOW() - INTERVAL duration * 3600 SECOND;;";
    mysqli_query($con, $query2);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $urname = $row["user_id"];
        $pass = $row["password"];
        if ($username == $urname && $password == $pass) {
            $_SESSION['Logininfo'] = array('user_id' => $row['user_id'], 'password' => $row['password'], 'role' => 'std');
            // header('Location: ../student/student-index.php');
            if (isset($_SESSION['redirect_url'])) {
                $redirect_url = $_SESSION['redirect_url'];
                unset($_SESSION['redirect_url']);
                header('Location: ' . $redirect_url);
            } else {
                header('Location: ../student/student-index.php');
            }
        } else {
            echo "Error";
        }
    } else {
        header("Location: login.php");
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
            top: 20%;
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
            <header>Login</header>
            <form action="login.php" method="post">
                <div class="field">
                    <span class="fa fa-user"></span>
                    <input type="text" name="email" value="202301090001" placeholder="User ID" required>
                </div>
                <div class="field space">
                    <span class="fa fa-lock"></span>
                    <input type="Password" name="password" value="202301090001" placeholder="Password" class="pass-key"
                        required>
                    <span class="show">show</span>
                </div>
                <div class="pass">
                    <!-- <?php echo $message; ?> -->
                </div>
                <div class="field">
                    <input type="submit" name="btnlogin" value="LOGIN">
                </div>
                <a href="forgot_password.php" class="forgot-link">Forgot Password ?</a>
            </form>
        </div>
    </div>
    <script>
        const pass_field = document.querySelector('.pass-key');
        const showBtn = document.querySelector('.show');
        showBtn.addEventListener('click', function () {
            if (pass_field.type === 'password') {
                pass_field.type = 'text';
                showBtn.textContent = 'HIDE';
                showBtn.style.color = '#3498db';
            } else {
                pass_field.type = 'password';
                showBtn.textContent = 'SHOW';
                showBtn.style.color = '#222';
            }
        });
    </script>
</body>

</html>