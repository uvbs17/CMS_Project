<?php
require_once "../connection/connection.php";

// Check if search button was clicked
if (isset($_POST["btnsearch"])) {
    // Get form ID from POST data
    $form_id = $_POST["form_id"];

    // Retrieve admission form data from database
    $query = "SELECT * FROM admission_form WHERE form_id=?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $form_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // If form found, retrieve data and calculate formatted DOB and semester month/year
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $form_status = $row["form_status"];
        $remark = $row["remark"];
        $fees_status = $row["fees_status"];
        $fname = $row["first_name"];
        $mname = $row["middle_name"];
        $lname = $row["last_name"];
        $dobObj = new DateTime($row["dob"]);
        $formattedDOB = $dobObj->format('d-m-Y');
        $gender = $row["gender"];
        $email = $row["email"];
        $mobile = $row["mobile_no"];
        $alt_mno = $row["alter_mno"];
        $aadharno = $row["aadhar_no"];
        $aadhar_path = $row["aadhar_path"];
        $cast = $row["cast"];
        $disability = $row["disability"];
        $stream = $row["stream"];
        $course = $row["course"];
        $ssc_board = $row["ssc_board"];
        $sqlDate = $row["ssc_m_y"];
        $dateObj = date_create_from_format('Y-m', $sqlDate);
        $sem = date_format($dateObj, 'F, Y');
        $per_ssc = $row["ssc_percentage"];
        $ssc_path = $row["ssc_result_path"];
        $hsc_board = $row["hsc_board"];
        $sqlDate2 = $row["hsc_m_y"];
        $dateObj2 = date_create_from_format('Y-m', $sqlDate2);
        $hem = date_format($dateObj2, 'F, Y');
        $per_hsc = $row["hsc_percentage"];
        $hsc_path = $row["hsc_result_path"];
        $c_name="";
        $s_name="";

        // Retrieve course and stream names from database
        $query1 = "SELECT c.course_name, s.stream_name
        FROM courses AS c
        INNER JOIN stream AS s
        ON c.stream_id = s.id
        WHERE c.course_code = ?";
        $stmt1 = mysqli_prepare($con, $query1);
        mysqli_stmt_bind_param($stmt1, "s", $course);
        mysqli_stmt_execute($stmt1);
        $execute = mysqli_stmt_get_result($stmt1);

        $row1 = mysqli_fetch_assoc($execute);
        $c_name = isset($row1["course_name"]);
        $s_name = isset($row1["stream_name"]);
        // Check upload status of each file
        function checkUploadStatus($path)
        {
            return ($path != NULL) ? "Uploaded" : "Error";
        }
        $ssc_status = checkUploadStatus($ssc_path);
        $hsc_status = checkUploadStatus($hsc_path);
        $aadhar_status = checkUploadStatus($aadhar_path);
    } else {
        // If form not found, display error message
        echo "<script>alert('Incorrect Application ID.');</script>";
        echo "<script>window.location.href='status.php';</script>";

    }
} else {
    // If search button not clicked, redirect to status page
    header("Location: status.php");
}
?>
<html>

<head>
    <style>
        * {
            margin: 0;
            padding: 0;
            color: #1a1f36;
            box-sizing: border-box;
            word-wrap: break-word;
            font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto,
                Helvetica Neue, Ubuntu, sans-serif;
        }

        body {
            min-height: 100%;
            background-color: #E2ECF4;
        }

        h1 {
            margin-top: 20px;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            border: 1px solid #ddd;
        }

        th,
        td {
            text-align: center;
            padding: 16px;
        }

        th:first-child,
        td:first-child {
            text-align: left;
        }

        .my-button {
            background-color: #3653f8;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.25);
            position: relative;
            overflow: hidden;
        }

        .my-button:after {
            content: "";
            background-color: rgba(255, 255, 255, 0.2);
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            opacity: 0;
        }

        .my-button:hover:after {
            animation: ripple_401 1s ease-out;
        }

        @keyframes ripple_401 {
            0% {
                width: 5px;
                height: 5px;
                opacity: 1;
            }

            100% {
                width: 200px;
                height: 200px;
                opacity: 0;
            }
        }


        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        @media screen and (max-width: 480px) {

            /* styles for mobile devices */
            table {
                /* margin: 40px 0; */
            }
        }

        @media screen and (min-device-width: 768px) {

            /* styles for tablets */
            table {
                margin: 40px 10%;
            }
        }

        @media screen and (min-width: 1024px) {

            /* styles for laptop screens */
            table {
                margin: 40px 25%;
            }
        }

        div.btn {
            display: grid;
            margin-bottom: 50px;
        }

        .home {
            font-weight: bold;
            color: white;
            border-radius: 2rem;
            width: 95.02px;
            margin: auto;
            height: 42.66px;
            border: none;
            background-color: #3653f8;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .home .span-mother {
            display: flex;
            overflow: hidden;
        }

        tbody {
            background-color: #fff;
            border: 0px solid gainsboro;
            border-radius: 10px;
            box-shadow: rgba(60, 66, 87, 0.12) 0px 7px 14px 0px,
                rgba(0, 0, 0, 0.12) 0px 3px 6px 0px;
        }

        tbody tr th {
            width: 200px;
            border-right: 1px solid gainsboro;
        }

        h1 {
            letter-spacing: 0px;
            font-size: 36px;
            color: #5469d4;
            text-decoration: unset;
        }

        a span span {
            color: #ffffff;
        }

        a {
            text-decoration: none;
            color: white;
        }
    </style>
    <title>View Form</title>
</head>

<body>
    <h1 style="text-align: center;">Submitted Application</h1>

    <div class="container">
        <table>
            <tr>
                <th><label>Application ID</label></th>
                <td><label>
                        <?php echo ucfirst($form_id); ?>
                    </label></td>
            </tr>
            <tr>
                <th><label>Application Status</label></th>
                <td><label>
                        <?php echo ucfirst($form_status); ?>
                    </label></td>
            </tr>
            <?php
                if($remark != "")
                {
            ?>            
            <tr>
                <th><label>Remark</label></th>
                <td><label>
                        <?php echo ucfirst($remark); ?>
                    </label></td>
            </tr>
            <?php
                }
            ?>
            <tr>
                <th><label>Fees Status</label></th>
                <td><label>
                        <?php echo ucfirst($fees_status); ?>
                    </label></td>
            </tr>
            <tr>
                <th><label>Stream</label></th>
                <td><label>
                        <?php echo ucfirst($stream); ?>
                    </label></td>
            </tr>
            <tr>
                <th><label>Course</label></th>
                <td><label>
                        <?php echo ucfirst($course); ?>
                    </label></td>
            </tr>
            <tr>
                <th><label>Name</label></th>
                <td><label>
                        <?php echo ucfirst($fname); ?>
                    </label></td>
            </tr>
            <tr>
                <th><label>Middle Name</label></th>
                <td><label>
                        <?php echo ucfirst($mname); ?>
                    </label></td>
            </tr>
            <tr>
                <th><label>Last Name</label></th>
                <td><label>
                        <?php echo ucfirst($lname); ?>
                    </label></td>
            </tr>
            <tr>
                <th><label>Date of Birth</label></th>
                <td><label>
                        <?php echo $formattedDOB; ?>
                    </label></td>
            </tr>
            <tr>
                <th><label>Gender</label></th>
                <td><label>
                        <?php echo ucfirst($gender); ?>
                    </label></td>
            </tr>
            <tr>
                <th><label>Email</label></th>
                <td><label>
                        <?php echo $email; ?>
                    </label></td>
            </tr>
            <tr>
                <th><label> Contact No</label></th>
                <td><label>
                        <?php echo $mobile; ?>
                    </label></td>
            </tr>
            <?php
            if(isset($alt_mno) && !empty($alt_mno)) {
            ?>
                <tr>
                    <th><label> Telephone No</label></th>
                    <td><label><?php echo $alt_mno; ?></label></td>
                </tr>
            <?php
            }
            ?>
            
            <tr>
                <th><label>Aadhar Number</label></th>
                <td><label>
                        <?php echo $aadharno; ?>
                    </label></td>
            </tr>
            <tr>
                <th><label>Aadhar Card</label></th>
                <td style="display:flex;justify-content:center;align-items:center;magin:auto;">

                    <a class="my-button" href="/CMS/Admission_form/<?php echo $aadhar_path ?>" target="_blank"
                        rel="noopener noreferrer">View</a>


                </td>
            </tr>
            <tr>
                <th><label>Cast</label></th>
                <td><label>
                        <?php echo ucfirst($cast); ?>
                    </label></td>
            </tr>
            <tr>
                <th><label>Last SSC Qualifying Board</label></th>
                <td><label>
                        <?php echo $ssc_board; ?>
                    </label></td>
            </tr>
            <tr>
                <th><label>Year - Month of Qualifying</label></th>
                <td><label>
                        <?php echo $sem; ?>
                    </label></td>
            </tr>
            <tr>
                <th><label>Percentage scored in SSC</label></th>
                <td><label>
                        <?php echo $per_ssc; ?>
                    </label></td>
            </tr>
            <tr>
                <th><label>SSC Result</label></th>
                <td style="display:flex;justify-content:center;align-items:center;magin:auto;">

                    <a class="my-button" href="/CMS/Admission_form/<?php echo $ssc_path ?>" target="_blank"
                        rel="noopener noreferrer">View</a>


                </td>
            </tr>
            <tr>
                <th><label>Last HSC Qualifying Board</label></th>
                <td><label>
                        <?php echo $hsc_board; ?>
                    </label></td>
            </tr>
            <tr>
                <th><label>Year - Month of Qualifying</label></th>
                <td><label>
                        <?php echo $hem; ?>
                    </label></td>
            </tr>
            <tr>
                <th><label>Percentage scored in HSC</label></th>
                <td><label>
                        <?php echo $per_hsc; ?>
                    </label></td>
            </tr>
            <tr>
                <th><label>HSC Result</label></th>
                <td style="display:flex;justify-content:center;align-items:center;magin:auto;">

                    <a class="my-button" href="/CMS/Admission_form/<?php echo $hsc_path ?>" target="_blank"
                        rel="noopener noreferrer">View</a>


                </td>
            </tr>
        </table>
    </div>

    <div class="btn">

        <button class="home"><a href="../">
                <span class="span-mother">
                    <span>G</span>
                    <span>o</span>
                    <span>&nbsp;</span>
                    <span>H</span>
                    <span>o</span>
                    <span>m</span>
                    <span>e</span>
                </span></a>
        </button>
    </div>
</body>

</html>