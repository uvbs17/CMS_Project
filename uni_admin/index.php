<!-- PHP Starts Here -->
<?php //include('../common/header.php') ?>
<?php 
    session_start();
    require_once "../connection/connection.php"; 
    $message="Email Or Password Does Not Match";
    if(isset($_POST["btnlogin"]))
    {
        $username=$_POST["email"];
        $password=$_POST["password"];

        $query="select * from uniadmin_info where user_id='$username' and password='$password' ";
        $result=mysqli_query($con,$query);
        if (mysqli_num_rows($result)>0) {
            $row=mysqli_fetch_array($result);
            $urname=$row["user_id"];
            $pass=$row["password"];
            if($username== $urname && $password == $pass)
            {
                $_SESSION['Logininfo']= array('user_id' => $row['user_id'] , 'password' => $row['password'] , 'role' => 'admin');
                header('Location: uni_admin-index.php');
                
            }
            else
            {
                echo "Error";
            }
        }
        else
        { 
            //header("Location:index.php");
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
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
      .gg-arrow-left 
        {
            box-sizing: border-box;
            position: relative;
            display: block;
            transform: scale(var(--ggs,1));
            width: 22px;
            height: 22px;
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
        div.content {
        border-radius: 30px;
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
    <title>Document</title>
</head>

<body>
    <div class="bg-img">
        <div class="content">
        <a href="../"><div class="gg-arrow-left" ></div></a>
            <header>Admin Login</header>
            <form action="index.php" method="post">
                <div class="field">
                    <span class="fa fa-user"></span>
                    <input type="text" name="email" value="uni_admin" placeholder="User ID" required>
                </div>
                <div class="field space">
                    <span class="fa fa-lock"></span>
                    <input type="Password" name="password" value="uni" placeholder="Password" class="pass-key" required>
                    <span class="show">show</span>
                </div>
                <div class="pass">
                    <!-- <?php echo $message; ?> -->
                </div>
                <div class="field">
                    <input type="submit" name="btnlogin" value="LOGIN">
                </div>
            </form>
        </div>
    </div>
    <script>
        const pass_field = document.querySelector('.pass-key');
        const showBtn = document.querySelector('.show');
        showBtn.addEventListener('click',function () {
            if (pass_field.type === 'password') {
                pass_field.type = 'text';
                showBtn.textContent = 'HIDE';
                showBtn.style.color = '#3498db';
            }else{
                pass_field.type = 'password';
                showBtn.textContent = 'SHOW';
                showBtn.style.color = '#222';
            }
        });
    </script>
</body>

</html>