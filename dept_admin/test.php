<?php 
    require_once "../connection/connection.php";
?>
<!-- <?php
    // connect to the database
    //$conn = mysqli_connect("localhost", "username", "password", "database_name");

    // define an array of days and times
    $days = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday');
    $times = array('9:00', '10:00', '11:00', '12:00', '2:00', '3:00');

    // query the database to get the timetable data
    $sql = "SELECT * FROM time_table ORDER BY day, time";
    $result = mysqli_query($con, $sql);

    // create an empty array to store the timetable data
    $timetable = array();

    // loop through the result set and store the data in the timetable array
    while ($row = mysqli_fetch_assoc($result)) {
        $timetable[$row['day']][$row['time']] = $row;
    }

    // create a table to display the timetable data
    echo '<table>';

    // create a table header row with the days as the column headers
    echo '<thead><tr><th>Time</th>';
    foreach ($days as $day) {
        echo '<th>' . $day . '</th>';
    }
    echo '</tr></thead>';

    // create a table body with the times as the row headers
    echo '<tbody>';
    foreach ($times as $time) {
        echo '<tr><th>' . $time . '</th>';
        foreach ($days as $day) {
            echo '<td>';
            // check if there is data for the current day and time
            if (isset($timetable[$day][$time])) {
                // display the data in a table format
                $row = $timetable[$day][$time];
                echo '<b>Subject:</b> ' . $row['subject_code'] . '<br>';
                echo '<b>Teacher:</b> ' . $row['course-code'] . '<br>';
                echo '<b>Room:</b> ' . $row['class_id'];
            }
            echo '</td>';
        }
        echo '</tr>';
    }
    echo '</tbody>';

    echo '</table>';

    // close the database connection
    //mysqli_close($conn);


?> -->
<?php
function get_t_id($course_code , $class_id , $semester , $con)
{

    $query1 = "SELECT course_id FROM courses WHERE course_code = ?";
    $stmt = mysqli_prepare($con, $query1);
    mysqli_stmt_bind_param($stmt, "s", $course_code);
    mysqli_stmt_execute($stmt);
    $result1 = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result1);
    $course = $row["course_id"];
    $course_id = str_pad($course, 2, '0', STR_PAD_LEFT);

    // Check if there is any existing subjects code for the given combination
    $query = "SELECT id FROM time_table WHERE class_id = ? AND course_code = ? AND sem = ? ORDER BY id DESC LIMIT 1";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'sss', $class_id, $course_code, $semester);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $sem = str_pad($semester, 2, '0', STR_PAD_LEFT); 

    if (mysqli_stmt_num_rows($stmt) > 0) {
        // If there is an existing subjects code, increment the last 2 digits by 1
        mysqli_stmt_bind_result($stmt, $last_subjects_code);
        mysqli_stmt_fetch($stmt);
        $last_digits = substr($last_subjects_code, -2);
        $next_digits = str_pad(intval($last_digits) + 1, 2, '0', STR_PAD_LEFT);
        $next_subjects_code = $course_id . $class_id . $sem . $next_digits;
        
        echo "<br>" . $last_subjects_code ;
        echo "<br>" . $last_digits ;
        echo "<br>" . $next_digits ;
        echo "<br>" . $next_subjects_code ;
    } else {
        // If there is no existing subjects code, start from 01
        $next_subjects_code = $course_id . $class_id . $sem . "01";
    }

    return $next_subjects_code;
}     
 $t = get_t_id('BCA', '403' , '3' ,$con);
?>
<!-- <?php
    if((mysqli_num_rows($tt_run)) > 0)
    {
    $tt_row['first_name']=$tt_row['last_name']="lol";
    while ($tt_row = mysqli_fetch_array($tt_run))
    {
    $tt_row['time'];
    $mon = $tues = $wed = $thru = $fri = $sat = "";
    echo "";
    foreach($time_from as $time)
    {
    if ($time > $tt_row['time'])
    { $t = $tt_row['time'];
    if($tt_row['day'] == 'monday')
    {
    $mon = ($tt_row['room'] . " - " . $tt_row['subjects_name'] ."
    " . $tt_row['first_name'] . $tt_row['last_name']);
    }
    elseif($tt_row['day'] == 'tuesday')
    {
    $tues = ($tt_row['room'] . " - " . $tt_row['subjects_name'] ."
    " . $tt_row['first_name'] . $tt_row['last_name']);
    }
    elseif($tt_row['day'] == 'wednesday')
    {
    $wed = ($tt_row['room'] . " - " . $tt_row['subjects_name'] ."
    " . $tt_row['first_name'] . $tt_row['last_name']);
    }
    elseif($tt_row['day'] == 'thursday')
    {
    $thru = ($tt_row['room'] . " - " . $tt_row['subjects_name'] ."
    " . $tt_row['first_name'] . $tt_row['last_name']);
    }
    elseif($tt_row['day'] == 'friday')
    {
    $fri = ($tt_row['room'] . " - " . $tt_row['subjects_name'] ."
    " . $tt_row['first_name'] . $tt_row['last_name']);
    }
    elseif($tt_row['day'] == 'saturday')
    {
    $sat = ($tt_row['room'] . " - " . $tt_row['subjects_name'] ."
    " . $tt_row['first_name'] . $tt_row['last_name']);
    }
    }
    }
    echo "" . $t . "";
    echo "" . $mon . "";
    echo "" . $tues ."";
    echo "" . $wed . "";
    echo "" . $thru . "";
    echo "" . $fri . "";
    echo "" . $sat . "";
    echo "";
    }
    }
?> -->