<?php
$records_per_page = 10;
$total_records_query = "SELECT COUNT(*) as count FROM student_info WHERE dept_id = '$admin_dept_id' AND (enrollment_no LIKE '%{$_POST['query']}%' OR first_name LIKE '%{$_POST['query']}%' OR middle_name LIKE '%{$_POST['query']}%' OR last_name LIKE '%{$_POST['query']}%' OR current_address LIKE '%{$_POST['query']}%' OR session LIKE '%{$_POST['query']}%' OR course_code LIKE '%{$_POST['query']}%')";
$total_records_result = mysqli_query($con, $total_records_query);
$total_records = mysqli_fetch_assoc($total_records_result)['count'];
$total_pages = ceil($total_records / $records_per_page);

$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $records_per_page;

$query = "SELECT * FROM student_info WHERE dept_id = '$admin_dept_id' AND (enrollment_no LIKE '%{$_POST['query']}%' OR first_name LIKE '%{$_POST['query']}%' OR middle_name LIKE '%{$_POST['query']}%' OR last_name LIKE '%{$_POST['query']}%' OR current_address LIKE '%{$_POST['query']}%' OR session LIKE '%{$_POST['query']}%' OR course_code LIKE '%{$_POST['query']}%') LIMIT $offset, $records_per_page";
$run = mysqli_query($con, $query);

while ($row = mysqli_fetch_array($run)) { ?>
    <tr>
      <td>
        <?php echo $row["enrollment_no"] ?>
      </td>
      <td>
        <?php echo $row["first_name"] . " " . $row["middle_name"] . " " . $row["last_name"] ?>
      </td>
      <td>
        <?php echo $row["current_address"] ?>
      </td>
      <td>
        <?php echo $row["session"] ?>
      </td>
      <td>
        <?php echo $row["course_code"] ?>
      </td>
      <!-- date_format($date,"Y/m/d H:i:s"); -->
      <td>
        <?php echo date("d-m-Y", strtotime($row["admission_date"])); ?>
      </td>
      <td>
        <?php $profile_image = $row["profile_image"] ?>
        <?php $profile_image = $row["profile_image"];
          if ($profile_image) {
            echo '<img style="border-radius:50px;" height="50px" width="50px" alt="img" src="/CMS/Student/images/' . $profile_image . '">';
          } else {
            echo '<img style="border-radius:50px;" height="50px" width="50px" alt="no img" src="/CMS/Images/student-no-image.jpg">';
          }
        ?>
      </td>
      <td width='170'>
        <?php
        echo "<a class='btn btn-primary' href=../Student/display-Student.php?enrollment_no=" . $row['enrollment_no'] . ">Profile</a> ";

        ?>
        <a class="btn btn-danger"
          href="delete-function.php?enrollment_no=<?= $row['enrollment_no'] ?>"
          onclick="return confirm('Are you sure you want to remove this student?')">Delete</a>
      </td>
    </tr>
<?php }
?>