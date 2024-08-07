<?php include('../common/header.php') ?>
<?php
//session_start();
require_once "../connection/connection.php";
if (!isset($_SESSION['redirect_url'])) {
  $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
}
if (!isset($_SESSION["Logininfo"])) {
  echo '<script type="text/javascript">window.location.href = "index.php";</script>';
} else {
  $userid = $_SESSION['Logininfo']['user_id'];
  $password = $_SESSION['Logininfo']['password'];
}

?>
<?php

ob_start();
if (isset($_POST['submit'])) {
  $user_department = $_POST['user_department'] ?? null;
  $user_id = $_POST['user_id'] ?? null;
  $title = $_POST['title'] ?? null;
  $message = $_POST['message'] ?? null;
  $duration = $_POST['duration'] ?? null;
  $departments = $_POST['departments'] ?? [];

  if ($user_department === 'all_departments') {
    $insert_query = "INSERT INTO notifications (title, message, sender_id, receiver_id, usertype, duration) 
                     VALUES (?, ?, ?, NULL, 'department', ?)";
    $stmt = mysqli_prepare($con, $insert_query);
    mysqli_stmt_bind_param($stmt, 'sssi', $title, $message, $name, $duration);
    $run1 = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if ($run1) {
      // redirectToNotificationPage();
    }
  } elseif (!empty($departments)) {
    $insert_query = "INSERT INTO notifications (title, message, sender_id, receiver_id, usertype, duration) 
                     VALUES (?, ?, ?, ?, NULL, ?)";
    $stmt = mysqli_prepare($con, $insert_query);
    mysqli_stmt_bind_param($stmt, 'ssssi', $title, $message, $name, $department, $duration);
    foreach ($departments as $department) {
      $run1 = mysqli_stmt_execute($stmt);
      if (!$run1) {
        echo "Error inserting notification for department ID: $department";
      }
    }
    mysqli_stmt_close($stmt);
    // redirectToNotificationPage();
  } else {
    echo "Please select at least one department to send notification.";
  }
}

function redirectToNotificationPage() {
  echo '<script type="text/javascript">window.location.href = "notification.php";</script>';
  exit;
}

 
 ?>



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
    div.modal-header.bg-info.text-white {
      border-radius: 20px;
      margin: 10;
    }

    div.modal-content {
      border-radius: 30px;
    }

    td {
      height: 45px;
      text-align: center;
    }

    .btn {
      border: 0;
      border-radius: 30px;
    }

    .btn-primary {
      border: 0;
      background-color: #1f5b6e;
    }

    thead tr th {
      height: 45px;
      background-color: darkslategrey;
      color: white;
      text-align: center;
    }

    div.btn.btn-block.table-one.text-white.d-flex {
      background-color: #245e71;
    }

    div.btn.btn-block.text-white.table-three.d-flex {
      background-color: #245e71;
    }

    div.btn.btn-block.text-white.table-two.d-flex {
      background-color: #245e71;
    }

    table {
      border-radius: 20px;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
      margin-bottom: 20px;
    }

    input.btn.btn-primary.ml-auto {
      border-radius: 30px;
      background-color: #1f5b6e;
    }

    input.form-control {
      border-radius: 30px;
    }

    a.btn.btn-danger {
      border-radius: 20px;
    }

    label {
      font-weight: bold;
    }

    textarea {
      resize: none;
      border-radius: 30px;
    }
  </style>
  <title>Admin - Register Teacher</title>
  <!-- css style go to end here -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
  <?php include('../common/uni_admin-sidebar.php') ?>
  <main role="main" class="col-xl-10 col-lg-12 col-md-12 ml-sm-auto px-md-4 mb-2 w-100">
    <div class="sub-main">

      <div class="p-0 rounded text-center">
        <h1>Notification:</h1>
      </div>
      <!-- Code for sending notifications to department -->
      <button type="button" class="btn btn-primary stdadd" data-toggle="modal" data-target=".bd-example-modal-lg">
        Send Notification
      </button>
      <div class="col-md-12 pt-2 mb-2">

        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
          aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-info text-white">
                <h4 class="modal-title text-center">Send Notification</h4>
              </div>
              <div class="modal-body">
                <form action="notification.php" method="post" class="my-5">
                  <div class="form-row">
                    <div class="col-md-4 mb-3">
                      <div class="form-check">
                        <input type="checkbox" name="user_department" value="all_departments" class="form-check-input"
                          id="departmentCheck">
                        <label class="form-check-label" for="departmentCheck">
                          Send to all departments
                        </label>
                      </div>
                    </div>
                    <?php
                    // Retrieve departments
                    $sql = 'SELECT * FROM department';
                    $result = mysqli_query($con, $sql);
                    if (!$result) {
                      die('Error retrieving departments: ' . mysqli_error($conn));
                    }
                    // Generate options
                    $options = '';
                    while ($row = mysqli_fetch_assoc($result)) {
                      $options .= '<option value="' . $row['dept_id'] . '">' . $row['dept_name'] . " (" . $row['dept_id'] . ")" . '</option>';
                    }
                    ?>
                    <div class="col-md-4 mb-3">
                      <div class="form-group">
                        <!-- Add some styling to the label -->
                        <label style="font-weight: bold; font-size: 18px;" for="departmentSelect">Send To Particular
                          Departments:</label>
                        <br>
                        <!-- add "multiple" attribute and modify "name" attribute -->
                        <select class="form-control" name="departments[]" id="departmentSelect" multiple
                          style="height: 100px;">
                          <!-- <option disabled selected>Select department</option> -->
                          <?= $options; ?>
                        </select>
                        <small class="form-text text-muted">Hold down the Ctrl (Windows) or Cmd (Mac) key to select
                          multiple departments.</small>
                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <div class="form-group">
                        <label for="durationSelect">Duration:</label>
                        <select class="form-control" name="duration" id="durationSelect">
                          <option value="24" selected>1 Day</option>
                          <option value="48">2 Days</option>
                          <option value="72">3 Days</option>
                          <option value="96">4 Days</option>
                          <option value="120">5 Days</option>
                          <option value="144">6 Days</option>
                          <option value="168">7 Days</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-6 mb-3">
                      <label for="titleInput">Title:</label>
                      <input id="titleInput" type="text" name="title" class="form-control" autocomplete="off"
                        placeholder="Enter a title" required>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="messageTextarea">Message:</label>
                      <textarea name="message" cols="10" rows="1" class="form-control" id="messageTextarea"
                        autocomplete="off" placeholder="Enter a message" required></textarea>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-12">
                      <input type="submit" name="submit" value="Send Now" class="btn btn-primary ml-auto">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="row">
        <div class="col-md-12 ml-2">
          <section class="mt-3">
            <table style="margin-left: 0 ;margin-right:0;"
              class="w-100  table-dark container table-striped table-hover table-elements table-one-tr "
              cellpadding="10">
              <thead class="thead-dark">
                <tr class="table-tr-head table-three text-white">
                  <th style="border-radius: 20px 0 0 0;">No</th>
                  <th>Title</th>
                  <th>Message</th>
                  <th>Sender</th>
                  <th>Receiver</th>
                  <th style="border-radius: 0 20px 0 0;">Action</th>
                </tr>
              </thead>
              <?php
              // Prepare the query using a prepared statement
              $query = "SELECT notification_id, title, message, sender_id, receiver_id
                                      FROM notifications
                                      WHERE sender_id = ?";
              $stmt = mysqli_prepare($con, $query);
              mysqli_stmt_bind_param($stmt, 's', $name);
              mysqli_stmt_execute($stmt);
              $result = mysqli_stmt_get_result($stmt);

              if (mysqli_num_rows($result) > 0) {
                $sr = 1;
                foreach ($result as $row) {
                  echo "<tr>";
                  echo "<td>$sr</td>";
                  echo "<td>{$row['title']}</td>";
                  echo "<td>{$row['message']}</td>";
                  echo "<td>{$row['sender_id']}</td>";
                  echo "<td>{$row['receiver_id']}</td>";
                  echo '<td width="20"><a class="btn btn-danger" href="/CMS/dept_admin/delete-function.php?notification_id=' . $row["notification_id"] . '" onclick="return confirm(\'Are you sure you want to delete this notification?\');">Delete</a></td>';
                  echo "</tr>";
                  $sr++;
                }
              } else {
                echo "<tr><td colspan='6' style='text-align: center;'>There are no notifications to show.</td></tr>";
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