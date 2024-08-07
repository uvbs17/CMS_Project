<!-- PHP Starts Here -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <title>Application status</title>
    <style>
        div div header {
            margin-bottom: 0px !important;
        }

        div div form {
            margin: auto;
            height: auto;
        }

        div.content.tilt-in-fwd-tr {
            padding: 20px;
        }

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
            top: 12%;
            left: 38px;
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
    </style>
</head>

<body>
    <div class="bg-img">
        <div class="content tilt-in-fwd-tr">
            <a title="home" href="../">
                <div class="gg-arrow-left"></div>
            </a>
            <header style="font-size: x-large; ">Application status</header>
            <form action="viewform.php" method="post"><br><br>
                <div class="field">
                    <span class="fa fa-user"></span>
                    <input type="text" name="form_id" value="" placeholder="Application Id (12 digit)"
                        pattern="(?=.*\d).{12,11,10}" title="Enter a 12 Digit Application ID" required>
                </div>
                <br>
                <div class="field">
                    <input type="submit" name="btnsearch" value="CHECK STATUS">
                </div>
            </form>
        </div>
    </div>
</body>

</html>