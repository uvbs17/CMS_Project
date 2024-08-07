<?php session_start();
    error_reporting(0); ?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    *::-webkit-scrollbar-track {
        /* -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3); */
        background-color: #F5F5F5;
        border-radius: 10px;
    }

    *::-webkit-scrollbar {
        width: 10px;
        background-color: #F5F5F5;


    }

    *::-webkit-scrollbar-thumb {
        border-radius: 10px;
        background-color: #1f5b6e;
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);

    }

    div.aboutcard {
        scroll-snap-align: start;
        scroll-margin-top: 70px;
    }


    @media (900px <=width) {
        ul.navbar-nav.ml-auto.py-4.py-md-0 {
            position: absolute;
            right: -210px;

        }

        div.dropdown-menu.show {
            position: absolute;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            top: 60px;
            left: -25px;
            margin-left: -60px;
        }

        div.col-12 {
            left: -100px;
        }
    }

    @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
        /* your styles here */

        div.col-12 {
            left: -10px;
        }

        div.dropdown-menu.show {
            position: absolute;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            top: 0px;
            right: 1;
            margin-left: -2px;
        }
    }

    li.nav-item.pl-4.pl-md-0.ml-0.ml-md-4 {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* @media (760px <=width) {

        a.nav-link {
            margin-top: 12px;
        }

    } */

    a.dropdown-item:first-child {
        margin-top: 0px;
    }

    a.dropdown-item {
        background-color: #f1f1fa;
        margin-top: 10px;
        border-bottom: 1.5px solid #1f5b6e;
        border-radius: 15px;
    }

    a.dropdown-item:hover {
        background-color: #1f5b6e;
    }

    div.avtar {
        display: grid;
    }

    li div strong {
        font-size: 15px;
        text-align: center;
    }

    .dropdown-menu-noti {
        max-height: 250px;
        overflow-y: auto;
        width: 280px;
        left: -150px !important;
        border-radius: 8px;
        border: none;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    }


    /* View All Notifications Link Styles */
    .noti-all {
        display: block;
        position: relative;
        z-index: 1;
        padding: 10px;
        text-align: center;
        color: #007bff;
        font-weight: bold;
    }



    .noti-item {
        display: block;
        padding: 12px 20px;
        font-size: 14px;
        color: #333;
        text-decoration: none;
    }

    .noti-item h6 {
        font-size: 16px;
        margin-bottom: 5px;
    }

    .noti-item p {
        margin-bottom: 0;
    }

    .noti-item:hover {
        background-color: #f1f1f1;
    }

    .noti-all:hover {
        text-decoration: underline;
    }

    .dropdown-divider {
        margin: 0;
    }

    i.fa.fa-bell {
  font-size: 22px;
}

    /* Notification Badge Styles */
    .noti-badge {
        display: inline-block;
        font-size: 11px;
        font-weight: bold;
        background-color: #dc3545;
        border-radius: 50%;
        padding: 6px 7px;
    }
    span.badge.rounded-pill.badge-notification.bg-danger.noti-badge{    
        position: absolute;
    top: -4px;
    left: 4px;
    margin: 0 10px;
    display: flex;
    color: white;
    width: auto;
    max-height: 16px;
    font-size:  11px !important;
    /* align-content: center; */
    align-items: center;
    justify-content: center;
}
    /* i.fa.fa-bell {
    font-size: 11px !important;
} */


</style>
<div class="navigation-wrap bg-light start-header start-style">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="navbar navbar-expand-md navbar-light">

                    <a class="navbar-brand" href="/CMS/"><img style="height: 60px;
  width: 130px;" src="/CMS/Images/logo.png" alt="hello"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto py-4 py-md-0">

                            <?php if (isset($_SESSION['Logininfo'])): ?>
                                <!-- show HTML logout button -->
                                <?php
                                $check = $_SESSION['Logininfo']['role'];
                                $deptid = isset($_SESSION['Logininfo']['dep_id']);
                                $name = $_SESSION['Logininfo']['user_id'];


                                // Get the current URL
                                $current_url = $_SERVER['REQUEST_URI'];

                                if ($check == 'std' && (strpos($current_url, 'uni_admin') !== false || strpos($current_url, 'teacher') !== false || strpos($current_url, 'dept_admin') !== false)) {
                                    // Redirect to student dashboard
                                    // $dashboard = '/CMS/student/student-index.php';
                                    // header("Location: $dashboard");
                                    echo '<script>window.location.href = "/CMS/student/student-index.php";</script>';
                                    exit;
                                } elseif (($check == 'admin') && strpos($current_url, 'student') !== false) {
                                    // Redirect to appropriate dashboard
                                    // $dashboard = '/CMS/uni_admin/uni_admin-index.php';
                                    // header("Location: $dashboard");
                                    echo '<script>window.location.href = "/CMS/uni_admin/uni_admin-index";</script>';
                                    exit;
                                } elseif (($check == 'fac') && strpos($current_url, 'student') !== false) {
                                    // Redirect to appropriate dashboard
                                    // $dashboard = '/CMS/faculty/teacher-index.php';
                                    // header("Location: $dashboard");
                                    echo '<script>window.location.href = "/CMS/faculty/teacher-index.php";</script>';
                                    exit;
                                } elseif ($check == 'dept' && (strpos($current_url, 'student') !== false || strpos($current_url, 'uni_admin') !== false || strpos($current_url, 'teacher') !== false)) {
                                    // Redirect to department administrator dashboard
                                    // $dashboard = '/CMS/dept_admin/admin-index.php';
                                    // header("Location: $dashboard");
                                    echo '<script>window.location.href = "/CMS/dept_admin/admin-index.php";</script>';
                                    exit;
                                }


                                if ($check == 'std') {
                                    $dashboard = '/CMS/student/student-index.php';
                                    $profile = '/CMS/student/display-student.php';
                                } elseif ($check == 'admin') {
                                    $dashboard = '/CMS/uni_admin/uni_admin-index.php';
                                    $profile = '/CMS/uni_admin/adduniadmin.php';
                                } elseif ($check == 'fac') {
                                    $dashboard = '/CMS/faculty/teacher-index.php';
                                    $profile = '/CMS/faculty/display-teacher.php';
                                } elseif ($check == 'dept') {
                                    $dashboard = '/CMS/dept_admin/admin-index.php';
                                    $profile = '/CMS/dept_admin/manage-accounts.php';
                                }
                                ?>

                                <!-- notification start -->
                               <?php
                               if ($check == 'std') {
                               $con=mysqli_connect("localhost","root","","cms");
                               
                               $enrollment_no = $_SESSION['Logininfo']['user_id'];
                               $qu = "SELECT `class_id` FROM student_info WHERE enrollment_no = $enrollment_no";
                               $result = mysqli_query($con, $qu);
                               while($row = mysqli_fetch_assoc($result)) {
                                $class_id =  $row["class_id"];
                              }
                               $query1 = "SELECT * FROM `notifications` WHERE `receiver_id` = '$enrollment_no' OR `usertype` = 'student' or `usertype` = '$class_id' ";
                               $result1 = mysqli_query($con, $query1);
                               $notifications = mysqli_fetch_all($result1, MYSQLI_ASSOC);
                               $notification_count = count($notifications);
                               
                               ?>
                               
                               <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4 dropdown">
                                  <div class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                                       aria-haspopup="true" aria-expanded="false">
                                       <i class="fa fa-bell"></i>
                                       <?php if ($notification_count > 0): ?>
                                           <?php if ($notification_count <= 4): ?>
                                               <span class="badge rounded-pill badge-notification bg-danger noti-badge"><?= $notification_count ?></span>
                                           <?php else: ?>
                                               <span class="badge rounded-pill badge-notification bg-danger noti-badge">4+</span>
                                           <?php endif; ?>
                                       <?php endif; ?>
                                   </div>
                                  
                               
                                   <div class="dropdown-menu dropdown-menu-noti  dropdown-menu-right" aria-labelledby="navbarDropdown">
                                       <?php
                                       if ($notification_count > 0) {
                                           $query2 = "SELECT * FROM `notifications` WHERE `receiver_id` = '$enrollment_no' OR `usertype` = 'student' or `usertype` ='$class_id' ORDER BY `notification_id` DESC LIMIT 4";
                                           
                                           $result2 = mysqli_query($con, $query2);
                                           while ($notification = mysqli_fetch_assoc($result2)) {
                                               echo '<div class="noti-item" href="#">';
                                               echo '<h6>' . htmlspecialchars($notification['title']) . '</h6>';
                                               echo '<p>' . htmlspecialchars($notification['message']) . '</p>';
                                               echo '</div>';
                                           }
                                       } else {
                                           echo '<div class="noti-item" href="#">';
                                           echo '<h6>No notifications</h6>';
                                           echo '</div>';
                                       }
                                       ?>
                               
                                       <div class="dropdown-divider"></div>
                                       <a class="noti-all" href="/CMS/student/allnotification.php">View all notifications</a>
                                   </div>
                               </li>
                               <?php } ?>
                               <?php
                               if ($check == 'fac') {
                               $con = mysqli_connect("localhost","root","","cms");
                               
                               $enrollment_no = $_SESSION['Logininfo']['user_id'];
                               $query1 = "SELECT COUNT(*) AS num_unread FROM `notifications` WHERE `usertype` = 'faculty'";
                               $result1 = mysqli_query($con, $query1);
                               $notification_count = mysqli_fetch_assoc($result1)['num_unread'];
                               ?>
                               
                               <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4 dropdown">
                                   <div class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                                       aria-haspopup="true" aria-expanded="false">
                                       <i class="fa fa-bell"></i>
                                       <?php if ($notification_count > 0): ?>
                                           <?php if ($notification_count <= 4): ?>
                                               <span class="badge rounded-pill badge-notification bg-danger noti-badge"><?= $notification_count ?></span>
                                           <?php else: ?>
                                               <span class="badge rounded-pill badge-notification bg-danger noti-badge">4+</span>
                                           <?php endif; ?>
                                       <?php endif; ?>
                                   </div>
                               
                                   <div class="dropdown-menu dropdown-menu-noti  dropdown-menu-right" aria-labelledby="navbarDropdown">
                                       <?php
                                       if ($notification_count > 0) {
                                        $query2 = "SELECT * FROM `notifications` WHERE `usertype` = 'faculty' ORDER BY `notification_id` DESC LIMIT 4";
                                           $result2 = mysqli_query($con, $query2);
                                           while ($notification = mysqli_fetch_assoc($result2)) {
                                               echo '<div class="noti-item" href="#">';
                                               echo '<h6>' . htmlspecialchars($notification['title']) . '</h6>';
                                               echo '<p>' . htmlspecialchars($notification['message']) . '</p>';
                                               echo '</div>';
                                           }
                                       } else {
                                           echo '<div class="noti-item" href="#">';
                                           echo '<h6>No notifications</h6>';
                                           echo '</div>';
                                       }
                                       ?>
                               
                                       <div class="dropdown-divider"></div>
                                       <a class="noti-all" href="/CMS/faculty/allnotification.php">View all notifications</a>
                                   </div>
                               </li>
                               <?php } 

                               if ($check == 'dept') {
                               $con=mysqli_connect("localhost","root","","cms");
                                $deptid = $_SESSION['Logininfo']['dep_id'];

                               $query1 = "SELECT COUNT(*) AS num_unread FROM `notifications` WHERE `receiver_id` = '$deptid' OR `usertype` = 'department' AND `sender_id` = 'uni_admin'";
                               $result1 = mysqli_query($con, $query1);
                               $notification_count = mysqli_fetch_assoc($result1)['num_unread'];
                               ?>
                               
                               <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4 dropdown">
                                   <div class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                                       aria-haspopup="true" aria-expanded="false">
                                       <i class="fa fa-bell"></i>
                                       <?php if ($notification_count > 0): ?>
                                           <?php if ($notification_count <= 4): ?>
                                               <span class="badge rounded-pill badge-notification bg-danger noti-badge"><?= $notification_count ?></span>
                                           <?php else: ?>
                                               <span class="badge rounded-pill badge-notification bg-danger noti-badge">4+</span>
                                           <?php endif; ?>
                                       <?php endif; ?>
                                   </div>
                               
                                   <div class="dropdown-menu dropdown-menu-noti  dropdown-menu-right" aria-labelledby="navbarDropdown">
                                       <?php
                                       if ($notification_count > 0) {
                                           $query2 = "SELECT * FROM notifications 
                                           WHERE receiver_id = '$deptid' OR (usertype = 'department' AND sender_id = 'uni_admin') 
                                           ORDER BY notification_id DESC
                                           LIMIT 4";

                                           $result2 = mysqli_query($con, $query2);
                                           while ($notification = mysqli_fetch_assoc($result2)) {
                                               echo '<div class="noti-item" href="#">';
                                               echo '<h6>' . htmlspecialchars($notification['title']) . '</h6>';
                                               echo '<p>' . htmlspecialchars($notification['message']) . '</p>';
                                               echo '</div>';
                                           }
                                       } else {
                                           echo '<div class="noti-item" href="#">';
                                           echo '<h6>No notifications</h6>';
                                           echo '</div>';
                                       }
                                       ?>
                               
                                       <div class="dropdown-divider"></div>
                                       <a class="noti-all" href="/CMS/dept_admin/allnotification.php">View all notifications</a>

                                   </div>
                               </li>
                               <?php } ?>
                                
                                <!-- notification end -->

                                <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                    <div class="avtar" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                                        aria-expanded="false">
                                        <img style="opacity: 1; width: 38px; height: 38px;  border-radius: 50px;"
                                            src="/CMS/Images/avtar.png" alt="hello">
                                        <!-- <strong style="font-size: 15px;">
                                            <?php //echo $name; ?>
                                        </strong> -->
                                    </div>
                                    <div style=" margin-top: 10px; padding: 10px; border-radius: 30px; display:grid;"
                                        class="menu dropdown-menu">
                                        <a style="padding: 10px; margin: auto; margin-top: 2px; border-radius: 15px 15px 0 0;"
                                            class="dropdown-item" href="<?php echo $dashboard; ?>">Dashboard
                                        </a>
                                        <a style="padding: 10px; margin: auto; margin-top: 2px; border-radius: 0px;"
                                            class="dropdown-item" href="<?php echo $profile; ?>">Profile</a>

                                        <a style="padding: 10px; margin: auto; margin-top: 2px; border-radius: 0 0 15px 15px;"
                                            class="dropdown-item" href="/CMS/Login/logout.php">Logout</a>
                                    </div>
                                </li>
                            <?php else: ?>
                                <!-- show HTML login button -->
                                <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                    <a class="nav-link" href="/CMS/">Home</a>
                                </li>
<style>
    div.dropdown-menu.show {
  border-radius: 15px;
  padding: 7px;
  display:grid;
}
</style>
                                <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                                        aria-haspopup="true" aria-expanded="false">Admission</a>
                                    <div  class="dropdown-menu">
                                        <a style="padding: 10px; margin: auto; border-radius: 10px 10px 0 0;"
                                            class="dropdown-item" href="/CMS/Admission_form/admissionform.php">Admission
                                            Form</a>
                                        <a style="padding: 10px; margin: auto; margin-top: 2px; border-radius: 0 0 10px 10px;"
                                            class="dropdown-item" href="/CMS/Admission_form/status.php">Admission status</a>
                                    </div>
                                </li>
                                <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                    <a class="nav-link" href="/CMS/about-us.php">About Us</a>
                                </li>
                                <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                    <a class="nav-link" href="/CMS/contact-us.php">Contact</a>
                                </li>
                                <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                    <a class="nav-link" href="/CMS/Login/login.php">Login</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>

                </nav>
            </div>
        </div>
    </div>
</div>
<script>
    function genratQR() {
        document.querySelector("#qr-image").style.display = "block";
        let QRtext = document.querySelector("#text").value;
        if (QRtext.trim().length == 0) {
            document.querySelector("#qr-image .error").innerHTML = "Please Enter Text";
            document.querySelector("#img").style.display = "none";
        } else {
            document.querySelector("#img").style.display = "block";
            document.querySelector("#qr-image error").innerHTML = "";
            document.querySelector("#ing").src = "https://api.qrserver.com/v1/create-qr-code/?size=240×240&data=" + QRtext;
        }
    }
</script>