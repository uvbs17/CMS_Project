<?php include('../common/header.php') ?>
<?php
//session_start();
require_once "../connection/connection.php";
if (!isset($_SESSION['redirect_url'])) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
}
if (!isset($_SESSION["Logininfo"])) {
    echo '<script type="text/javascript">window.location.href = "../login/login.php";</script>';
} else {
    $enrollment_no = $_SESSION['Logininfo']['user_id'];
    $password = $_SESSION['Logininfo']['password'];
    $qu = "SELECT `class_id` FROM student_info WHERE enrollment_no = $enrollment_no";
    $result = mysqli_query($con, $qu);
    while($row = mysqli_fetch_assoc($result)) {
     $class_id =  $row["class_id"];
   }
}

?>
<!---------------- Session Ends form here ------------------------>


<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" sizes="32x32" href="/CMS/Images/fav.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/CMS/Images/fav.png">

    <!-- css style goes here -->

    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/footer.css">
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <style>
        td {
            height: 45px;
            text-align: center;
        }

        thead tr th {
            height: 45px;
            background-color: darkslategrey;
            color: white;
            text-align: center;
        }

        table {
            border-radius: 20px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
    </style>
    <title>Student Dashboard</title>
    <!-- css style go to end here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <?php include('../common/student-sidebar.php') ?>

    <main role="main" class="col-xl-10 col-lg-12 col-md-12 ml-sm-auto px-md-4 mb-2 w-100">
        <div class="sub-main">
            <div class="p-0 rounded text-center">
                <h1>Announcement</h1>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <section class="table-responsive-md mt-3">
                        <table style="margin-bottom: 10px;"
                            class="w-100  table-dark container table-striped table-hover table-elements table-one-tr"
                            cellpadding="10">
                            <thead class="thead-dark">
                                <tr class="text-center text-white table-three table-tr-head">
                                    <th style="border-radius: 20px 0 0 0;">Sr. No. </th>
                                    <th>Title</th>
                                    <th>Message</th>
                                    <th style="border-radius: 0 20px 0 0;">Announcement By</th>
                                </tr>
                            </thead>
                            <?php

                            // Retrieve notifications from the database
                            $sql = "SELECT * FROM `notifications` WHERE `receiver_id` = '$enrollment_no' OR `usertype` = 'student' or `usertype` ='$class_id'";
                            $result = $con->query($sql);
                            $sr = 1;
                            if ($result->num_rows > 0) {
                                // Generate HTML code for each notification row
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $sr . "</td>";
                                    echo "<td>" . $row["title"] . "</td>";
                                    echo "<td>" . $row["message"] . "</td>";
                                    echo "<td>" . $row["sender_id"] . "</td>";
                                    echo "</tr>";
                                    $sr++;
                                }
                            } else {
                                echo "<tr><td colspan='4'>No notifications found.</td></tr>";
                            }
                            ?>
                        </table>
                    </section>
                </div>
            </div>
        </div>
    </main>
    <script type="text/javascript" src="../bootstrap/js/jquery.min.js"></script>
    <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
</body>

</html>