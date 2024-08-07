<?php
require_once "../connection/connection.php";
if ($_POST['type'] == "") {
    $sql = "SELECT * FROM stream";
    $query = mysqli_query($con, $sql);
    $str = "";
    while ($row = mysqli_fetch_array($query)) {
        $str .= "<option value='{$row['id']}'>{$row['stream_name']}</option>";
    }
} else if ($_POST['type'] == "coursedata") {
    $sql = "SELECT * FROM courses WHERE stream_id = {$_POST['id']}";
    $query = mysqli_query($con, $sql);
    $str = "";
    $uv = "<option value=''>Select Course</option>";
    echo '<script>var course = document.getElementById("disCourse");
         course.style.display = "block";</script>';

    while ($row = mysqli_fetch_array($query)) {

        $str .= "<option value='{$row['course_code']}'>{$row['course_name']}</option>";
    }
} else if ($_POST['type'] == "Select Stream") {
    $u = "<option value=''>Select Course</option>";
    echo $u;
}

echo $uv;
echo $str;
