<?php
//session_start();
require_once "../connection/connection.php"; ?>
<?php
$form_id = $_GET['form_id'];
$query = "select * from admission_form where form_id='$form_id'";
$result = mysqli_query($con, $query);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
    $form_status = $row["form_status"];
    $remark = $row["remark"];
    $fees_status = $row["fees_status"];
    $fname = $row["first_name"];
    $mname = $row["middle_name"];
    $lname = $row["last_name"];
    $dob = $row["dob"];
    $dobObj = new DateTime($dob);
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
    $c_name = "";
    $s_name = "";

    $query1 = "SELECT *
    FROM courses AS c
    INNER JOIN stream AS s
    ON c.stream_id = s.id
    WHERE c.course_code = '$course'";

    $execute = mysqli_query($con, $query1);
    if ($execute) {
        $row1 = mysqli_fetch_array($execute);
        $c_name = $row1["course_name"];
        $s_name = $row1["stream_name"];
    }
    if ($ssc_path != NULL) {
        $ssc_status = "Uploaded";
    } else {
        $ssc_status = "Error";
    }
    if ($hsc_path != NULL) {
        $hsc_status = "Uploaded";
    } else {
        $hsc_status = "Error";
    }
    if ($aadhar_path != NULL) {
        $aadhar_status = "Uploaded";
    } else {
        $aadhar_status = "Error";
    }
} else {
    echo "<script>alert('Error');</script>";
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
            background-color: #f7fafc;
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

        div.btn {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;

        }

        button.home {
            margin: 5;
            border-radius: 5px;
            color: white;
        }

        button span span {
            color: white;
        }
    </style>
    <title>View Form</title>
</head>

<body>
    <?php
    //echo $form_id;
    
    ?>
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
            if ($remark != "") {
                ?>
                <tr>
                    <th><label>Remark</label></th>
                    <td><label>
                            <?php echo ucfirst($remark); ?>
                        </label></td>
                </tr>
            <?php } ?>
            <tr>
                <th><label>Fees Status</label></th>
                <td><label>
                        <?php echo ucfirst($fees_status); ?>
                    </label></td>
            </tr>
            <tr>
                <th><label>Stream</label></th>
                <td><label>
                        <?php echo ucfirst($s_name); ?>
                    </label></td>
            </tr>
            <tr>
                <th><label>Course</label></th>
                <td><label>
                        <?php echo ucfirst($c_name); ?>
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
            <tr>
                <th><label> Telephone No</label></th>
                <td><label>
                        <?php echo $alt_mno; ?>
                    </label></td>
            </tr>
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
                <td style="display:flex;justify-content:center;align-items:center; margin:auto;">

                    <a class="my-button" href="/CMS/Admission_form/<?php echo $hsc_path ?>" target="_blank"
                        rel="noopener noreferrer">View</a>


                </td>
            </tr>
        </table>


    </div>

    <div class="btn">
        <button class="home"><a href="admission_list.php">
                <span class="span-mother">
                    <span>G</span>
                    <span>o</span>
                    <span>&nbsp;</span>
                    <span>B</span>
                    <span>a</span>
                    <span>c</span>
                    <span>k</span>
                </span></a>
        </button>
        <br>
        <button class="home" style="background-color: greenyellow;"><a
                href="update-function.php?accept_id=<?php echo $form_id ?>">
                <span class="span-mother">
                    <span>A</span>
                    <span>c</span>
                    <span>c</span>
                    <span>e</span>
                    <span>p</span>
                    <span>t</span>
                </span></a>
        </button>
        <br>
        <button class="home" style="background-color: red;" onClick="getReason()">
            <span class="span-mother">
                <span>R</span>
                <span>e</span>
                <span>j</span>
                <span>e</span>
                <span>c</span>
                <span>t</span>
            </span>
        </button>

        <script>
            function getReason() {
                var reason = prompt("Please enter reason for rejection:");
                if (reason != null && reason != "") {
                    window.location.href = 'update-function.php?reject_id=<?php echo $form_id ?>&reason=' + reason;
                }
            }
        </script>

        <br>
        <button class="home" style="background-color: burlywood;" onClick="processing()">
            <span class="span-mother">
                <span>P</span>
                <span>r</span>
                <span>o</span>
                <span>c</span>
                <span>e</span>
                <span>s</span>
                <span>s</span>
                <span>i</span>
                <span>n</span>
                <span>g</span>
            </span></a>
        </button>
        <script>
            function processing() {
                var remark = prompt("Please enter remark for rejection:");
                if (remark != null && remark != "") {
                    window.location.href = 'update-function.php?process_id=<?php echo $form_id ?>&remark=' + remark;
                }
            }
        </script>
    </div>
</body>

</html>