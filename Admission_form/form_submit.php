<?php
require_once "../connection/connection.php";
error_reporting(0);
$check = false;
$err = "";
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
    $fname = $_POST["fname"];
    $mname = $_POST["mname"];
    $lname = $_POST["lname"];
    $dob = $_POST["dob"];
    $email = $_POST["email"];
    $mobile = $_POST["mobile"];
    $alt_mno = $_POST["alt_mno"];
    $stream = $_POST["stream"];
    $course = $_POST["course"];
    $sem = $_POST["ssc_emy"];
    //$sdate = date('Y-m', strtotime($sem)); //converting Month type into mysql readable format / but somehow now working without this
    $per_ssc = $_POST["per_ssc"];
    $hem = $_POST["hsc_exam_month_year"];
    //$hdate = date('Y-m', strtotime($hem)); //converting Month type into mysql readable format
    $per_hsc = $_POST["per_hsc"];
    $aadharno = $_POST["aadharno"];

    // SSC file validation strating here
    if (isset($_FILES['ssc_file']) && $_FILES['ssc_file']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['ssc_file']['name'];
        $fileType = $_FILES['ssc_file']['type'];
        $fileSize = $_FILES['ssc_file']['size'];
        $filesTmpName = $_FILES['ssc_file']['tmp_name'];

        $stype = ".pdf";

        $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'application/pdf'];
        $maxSize = 5 * 1024 * 1024;

        if (!in_array($fileType, $allowedTypes) || $fileSize > $maxSize) {
            echo "Please select a file of type PNG, JPEG, JPG, or PDF and size less than 5MB";
        } else {
            if ($fileType == "image/png") {
                $stype = ".png";
            } elseif ($fileType == "image/jpeg") {
                $stype = ".jpeg";
            } elseif ($fileType == "image/jpg") {
                $stype = ".jpg";
            }
            $ssc_path = ("uploads/ssc_result/" . $aadharno . "_ssc_result_" . $fname . $stype);
            //*********************************** staring hsc validation here***********************************************           
            if (isset($_FILES['hsc_file']) && $_FILES['hsc_file']['error'] === UPLOAD_ERR_OK) {
                $fileName = $_FILES['hsc_file']['name'];
                $fileType = $_FILES['hsc_file']['type'];
                $fileSize = $_FILES['hsc_file']['size'];
                $filehTmpName = $_FILES['hsc_file']['tmp_name'];

                $htype = ".pdf";

                $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'application/pdf'];
                $maxSize = 5 * 1024 * 1024;

                if (!in_array($fileType, $allowedTypes) || $fileSize > $maxSize) {
                    echo "Please select a file of type PNG, JPEG, JPG, or PDF and size less than 5MB";
                } else {
                    if ($fileType == "image/png") {
                        $htype = ".png";
                    } elseif ($fileType == "image/jpeg") {
                        $htype = ".jpeg";
                    } elseif ($fileType == "image/jpg") {
                        $htype = ".jpg";
                    }
                    $hsc_path = ("uploads/hsc_result/" . $aadharno . "_hsc_result_" . $fname . $htype);
                    //**************************** starting aadhar validation here *************************************
                    if (isset($_FILES['aadhar_file']) && $_FILES['aadhar_file']['error'] === UPLOAD_ERR_OK) {
                        $fileName = $_FILES['aadhar_file']['name'];
                        $fileType = $_FILES['aadhar_file']['type'];
                        $fileSize = $_FILES['aadhar_file']['size'];
                        $fileaTmpName = $_FILES['aadhar_file']['tmp_name'];

                        $atype = ".pdf";

                        $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'application/pdf'];
                        $maxSize = 5 * 1024 * 1024;

                        if (!in_array($fileType, $allowedTypes) || $fileSize > $maxSize) {
                            echo "Please select a file of type PNG, JPEG, JPG, or PDF and size less than 5MB for aadhar card";
                        } else {
                            if ($fileType == "image/png") {
                                $atype = ".png";
                            } elseif ($fileType == "image/jpeg") {
                                $atype = ".jpeg";
                            } elseif ($fileType == "image/jpg") {
                                $atype = ".jpg";
                            }
                            $aadhar_path = ("uploads/aadhar/" . $aadharno . "_aadhar_no_" . $fname . $atype);

                            //********** Admission form number genrater *******************************************

                            // YEAR AND MONTH 

                            //$Y = date('Ym'); //202303
                            $y = date('Y'); //2023
                            //$ym = date('ym');//2303

                            // STREAM ID
                            $stream; //01
                            $str_id = str_pad($stream, 2, '0', STR_PAD_LEFT); //0022 + 1 = 0023 


                            // DEPT ID

                            $dept_query = "SELECT dept_id FROM courses WHERE course_code = '$course'";
                            $run = mysqli_query($con, $dept_query);
                            if ($run) {
                                $row = mysqli_fetch_array($run);
                                $dept_id = $row["dept_id"]; //02
                            } else {
                                $err = "Error Gentrating application No.";
                            }
                            // MAX ID FOR APPLICANT NUMBER

                            $max_query = "SELECT MAX(id) FROM admission_form";
                            $max_run = mysqli_query($con, $max_query);
                            $max_row = mysqli_fetch_array($max_run);
                            $maxid = $max_row["MAX(id)"] + 1;
                            $app_id = str_pad($maxid, 4, '0', STR_PAD_LEFT); //0022 + 1 = 0023 

                            // FORM ID

                            $form_id = ($y . $str_id . $dept_id . $app_id);

                            //*** Starting Insert query here *********************************************** 

                            $gender = $_POST["gender"];
                            $cast = $_POST["cast"];
                            $disability = $_POST["disability"];
                            $lseb = $_POST["last-ssc-exam-board"]; // lsed = last_ssc_exam_board
                            $lheb = $_POST["last_hsc_exam_board"]; // lheb = last HSC exam board  

                            $admission_query = "INSERT INTO admission_form (id,form_id, form_status, remark,fees_status, first_name, middle_name, last_name, 
                            dob, gender, email, mobile_no, alter_mno, aadhar_no, aadhar_path, cast, disability, stream, course,dept_id,ssc_board,
                            ssc_m_y, ssc_percentage, ssc_result_path, hsc_board, hsc_m_y, hsc_percentage, hsc_result_path,application_date) 
                            VALUES (NULL ,'$form_id' , 'submitted' , NULL ,'pending','$fname','$mname','$lname','$dob','$gender','$email','$mobile','$alt_mno',
                            '$aadharno','$aadhar_path','$cast','$disability','$str_id','$course','$dept_id','$lseb','$sem','$per_ssc',
                            '$ssc_path','$lheb','$hem','$per_hsc','$hsc_path',CURRENT_TIMESTAMP)";

                            $form = mysqli_query($con, $admission_query);

                            if ($form) {
                                move_uploaded_file($filesTmpName, $ssc_path);
                                move_uploaded_file($filehTmpName, $hsc_path);
                                move_uploaded_file($fileaTmpName, $aadhar_path);
                                $check = true;
                            } else {
                                $err = "Error while uploading the data  ";
                            }
                        }
                    } else {
                        $err = "Error while uploading Aadhar card,check the document type is (png,jpg,jpeg,png) and less than 5Mb";
                    }
                }
            } else {
                $err = "Error while uploading HSC result,check the document type is (png,jpg,jpeg,png) and less than 5Mb";
            }
        }
    } else {
        $err = "Error while uploading SSC result,check the document type is (png,jpg,jpeg,png) and less than 5Mb";
    }
} else {
    //header("Location: admissionform.php");
}
?>
<html>

<head>
    <style>
        html {
            display: grid;
            min-height: 100%;
        }

        body {
            display: grid;
            overflow: hidden;
            font-family: 'Lato', sans-serif;
            text-transform: uppercase;
            text-align: center;
        }

        #container {
            position: relative;
            align-items: center;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 7%;
            margin-left: 18%;
            margin-right: 5%;
            /* overflow: hidden;
            width: 1000px;
            height: 500px; */
            /* border: 5px solid black; */
        }

        h1 {
            font-size: 0.9em;
            font-weight: 100;
            letter-spacing: 3px;
            padding-top: 5px;
            color: #FCFCFC;
            padding-bottom: 5px;
            text-transform: uppercase;
        }

        .green {
            color: rgba(153, 219, 180, 0.8);
            /* 20% darker */
            font-size: large;

        }

        .red {
            color: rgba(239, 141, 156, 0.9);
            /* 10% darker */
            font-size: large;

        }

        .alert {
            font-size: larger;
            font-weight: 1000;
            letter-spacing: 5px;
        }

        p {
            margin-top: -10px;
            font-weight: 100;
            font-size: small;
            color: darken(#777777, 10%);
            letter-spacing: 1px;
        }

        button,
        .dot {
            cursor: pointer;
        }

        #success-box {
            position: absolute;
            width: 50%;
            height: 100%;
            /* left: 25%; */
            background: linear-gradient(to bottom right, #B0DB7D 40%, #99DBB4 100%);
            border-radius: 20px;
            box-shadow: 5px 5px 20px rgba(#CBCDD3, 10%);
            perspective: 40px;
        }

        #error-box {
            position: absolute;
            width: 50%;
            height: 100%;
            /* right: 25%; */
            background: linear-gradient(to bottom left, #EF8D9C 40%, #FFC39E 100%);
            border-radius: 20px;
            box-shadow: 5px 5px 20px rgba(#CBCDD3, 10%);
        }

        .dot {
            width: 16px;
            height: 16px;
            background: #FCFCFC;
            border-radius: 50%;
            position: absolute;
            top: 4%;
            right: 6%;
        }

        .dot:hover {
            background-color: rgba(252, 252, 252, 0.8);
            /* 80% opacity */
        }


        .two {
            right: 12%;
            opacity: .5;
        }

        .face {
            position: absolute;
            width: 100px;
            height: 100px;
            background: #FCFCFC;
            border-radius: 50%;
            border: 1px solid #777777;
            top: 8%;
            left: 37.5%;
            z-index: 2;
            animation: bounce 1s ease-in infinite;
        }

        .face2 {
            position: absolute;
            width: 100px;
            height: 100px;
            background: #FCFCFC;
            border-radius: 50%;
            border: 1px solid #777777;
            top: 8%;
            left: 37.5%;
            z-index: 2;
            animation: roll 3s ease-in-out infinite;
        }

        .eye {
            position: absolute;
            width: 8px;
            height: 8px;
            background: #777777;
            border-radius: 50%;
            top: 35%;
            left: 20%;
        }

        .right {
            left: 68%;
        }

        .mouth {
            position: absolute;
            top: 43%;
            left: 41%;
            width: 14px;
            height: 14px;
            border-radius: 50%;
        }

        .happy {
            border: 2px solid;
            border-color: transparent #777777 #777777 transparent;
            transform: rotate(45deg);
        }

        .sad {
            top: 55%;
            border: 2px solid;
            border-color: #777777 transparent transparent #777777;
            transform: rotate(45deg);
        }

        div div p {
            color: #fff;
        }

        .shadow {
            position: absolute;
            width: 100px;
            height: 22px;
            opacity: .5;
            background: #777777;
            left: 40%;
            top: 35%;
            border-radius: 50%;
            z-index: 1;
        }

        .scale {
            animation: scale 1s ease-in infinite;
        }

        .move {
            animation: move 3s ease-in-out infinite;
        }


        .message {
            position: absolute;
            width: 100%;
            text-align: center;
            height: 60%;
            top: 53%;
        }

        .button-box {
            position: absolute;
            background: #FCFCFC;
            width: 50%;
            height: 15%;
            border-radius: 20px;
            left: 25%;
            outline: 0;
            border: none;
            box-shadow: 2px 2px 10px rgba(#777777, .5);
            transition: all .5s ease-in-out;
        }

        .button-box:hover {
            background-color: rgba(252, 252, 252, 0.95);
            transform: scale(1.05);
            transition: all .3s ease-in-out;
        }

        @keyframes bounce {
            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes scale {
            50% {
                transform: scale(0.9);
            }
        }

        @keyframes roll {
            0% {
                transform: rotate(0deg);
                left: 25%;
            }

            50% {
                left: 60%;
                transform: rotate(168deg);
            }

            100% {
                transform: rotate(0deg);
                left: 25%;
            }
        }

        @keyframes move {
            0% {
                left: 25%;
            }

            50% {
                left: 60%;
            }

            100% {
                left: 25%;
            }
        }

        p {
            color: #777777;
            letter-spacing: 2px;
        }

        a {
            color: #B0DB7D;
            text-decoration: none;
        }

        .a:hover {
            color: #FFC39E;
        }

        @media screen and (max-width: 480px) {
            #container {
                margin: auto;
                margin-left: 0px;
                margin-right: 0px;
                padding: 0;
                height: 350px;
                width: 90%;

            }

            .alert {
                margin-top: -20;
                margin-bottom: 5;
            }

            .green {
                margin: 0;
            }

            .button-box {
                bottom: 4%;
            }

            #success-box {
                position: absolute;
                width: 340px;
                height: 280px;
            }

            #error-box {
                position: absolute;
                width: 340px;
                height: 280px;
            }

            h1 {
                letter-spacing: 0px;
            }

        }


        @media screen and (min-device-width: 768px) and (max-width: 1024px) {
            #container {
                margin: auto;
                display: flex;
                justify-content: center;
                align-items: center;
                /* margin-left: 0px; */
                /* margin-right: 0px; */
                padding: 0;
                height: 300px;
                width: 90%;

            }

            .alert {
                margin-top: -20;
                margin-bottom: 5;
            }

            .green {
                margin: 0;
            }

            .button-box {
                bottom: 4%;
            }

            #success-box {
                position: absolute;
                width: 340px;
                height: 280px;
            }

            #error-box {
                position: absolute;
                width: 340px;
                height: 280px;
            }

            h1 {
                letter-spacing: 0px;
                margin: 0;
            }

        }


        @media screen and (min-width: 1024px) {

            #container {
                margin: auto;
                padding: 0;
                height: 350px;
                width: 40%;

            }

            .alert {
                margin-top: -20;
                margin-bottom: 5;
            }

            .green {
                margin: 0;
            }

            .button-box {
                bottom: 4%;
            }

            #success-box {
                position: absolute;
                width: 340px;
                left: 15%;
                /* top: 25%; */
                height: 300px;
            }

            #error-box {
                position: absolute;
                width: 340px;
                top: 15%;
                right: 26%;
                height: 300px;
            }

            h1 {
                letter-spacing: 0px;
                margin: 0;
            }

        }

        p {
            margin: auto;
        }

        div div p {
            color: #fff;
            display: flex;
            justify-content: center;
        }

        /* CSS */
        .button-45 {
            background-color: transparent;
            background-position: 0 0;
            border: 0.5px solid #FEE0E0;
            border-radius: 1px;
            /* box-sizing: border-box; */
            color: #FEE0E0;
            margin: 6 10;
            cursor: pointer;

        }
    </style>
    <style>
                            .button-45 {
                                position: relative;
                            }

                            /* Tooltip container */
                            .tooltip {
                                visibility: hidden;
                                width: 130px;
                                background-color: #000;
                                color: #fff;
                                text-align: center;
                                border-radius: 6px;
                                padding: 5px 2px;
                                position: absolute;
                                z-index: 1;
                                bottom: 150%;
                                left: 50%;
                                margin-left: -60px;
                                opacity: 0;
                                transition: opacity 0.3s;
                            }

                            /* Tooltip arrow */
                            .tooltip:after {
                                content: "";
                                position: absolute;
                                top: 100%;
                                left: 50%;
                                margin-left: -5px;
                                border-width: 5px;
                                border-style: solid;
                                border-color: #000 transparent transparent transparent;
                            }

                            /* Show the tooltip when hovering over the button */
                            .button-45:hover .tooltip {
                                visibility: visible;
                                opacity: 1;
                            }

                            h1.green {
                                margin-top: -70px;
                                background-color: white;
                                padding: 10px 20px;
                                border-radius: 30px;
                            }
                        </style>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,300,0,0" />
    <title>Form submission</title>
</head>

<body>
    <div id="container">
        <?php
        if ($check == true) {
            ?>
            <div id="success-box">
                <div class="face">
                    <div class="eye"></div>
                    <div class="eye right"></div>
                    <div class="mouth happy"></div>
                </div>
                <div class="shadow scale"></div>
                <div class="message">
                    <h1 class="alert">Success!</h1>
                    <p>Your application ID is:</p>
                    <p>
                        <?php echo " <br>" . $form_id; ?>
                        <!-- HTML !-->
                        <button class="button-45" onClick="copyToClipboard('<?php echo $form_id; ?>')">
                            <span class="material-symbols-outlined">
                                content_copy
                            </span>
                        </button>

                        

                        <script>
                            function copyToClipboard(text) {
                                var tempTextArea = document.createElement("textarea");
                                tempTextArea.value = text;
                                document.body.appendChild(tempTextArea);
                                tempTextArea.select();
                                document.execCommand("copy");
                                document.body.removeChild(tempTextArea);

                                // Create a success message element and set its attributes
                                var tooltip = document.createElement("div");
                                tooltip.setAttribute("class", "tooltip");
                                tooltip.textContent = "Copied to clipboard!";

                                // Attach the tooltip to the button
                                var button = document.querySelector(".button-45");
                                button.appendChild(tooltip);

                                // Hide the tooltip after 3 seconds
                                setTimeout(function () {
                                    tooltip.style.opacity = "0";
                                    setTimeout(function () {
                                        button.removeChild(tooltip);
                                    }, 300);
                                }, 3000);
                            }
                        </script>

                        <button class="button-box"><a href="/CMS/">
                                <h1 class="green">Home page</h1>
                            </a></button>
                </div>
                <?php
        } else {
            // $err = "Error while uploading SSC result,check the document type is (png,jpg,jpeg,png) and less than 5Mb";
            // $err = "Error while uploading HSC result,check the document type is (png,jpg,jpeg,png) and less than 5Mb";
            //    $err = "Error while uploading Aadhar card,check the document type is (png,jpg,jpeg,png) and less than 5Mb";
            // $err = "Error while uploading the data  "
        
            ?>
                <div id="error-box">
                    <div class="face2">
                        <div class="eye"></div>
                        <div class="eye right"></div>
                        <div class="mouth sad"></div>
                    </div>
                    <div class="shadow move"></div>
                    <div class="message">
                        <h1 class="alert">Error!</h1>
                        <p>
                            <?php echo $err; ?>
                        </p>
                    </div>
                    <button class="button-box"><a href="#" id="back-link">
                            <h1 class="red">Go Back</h1>
                        </a></button>
                    <script>
                        // Get the anchor tag element by its ID
                        const backLink = document.getElementById('back-link');

                        // Add an event listener to the anchor tag to listen for clicks
                        backLink.addEventListener('click', function (event) {
                            event.preventDefault(); // Prevent default link behavior

                            // Redirect to previous URL
                            window.history.back();
                        });
                    </script>

                </div>
                <?php
        }
        ?>
        </div>
</body>

</html>