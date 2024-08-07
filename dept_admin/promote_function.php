<?php
session_start();
require_once "../connection/connection.php";

if(isset($_POST['res-btn']))
{
    $err = "";
    $suc = "";
    $jump = "";
    $course_code = $_POST['crs'];
    $admin_dept_id = $_POST['admin_dep_id'];
    foreach($_POST['count'] as $i)
    {
        $select = $semester = $_POST['sem'];
        $enro = $_POST['enrollment_no'][$i];
        $sem_check = "SELECT no_of_semester FROM courses WHERE course_code ='$course_code'";
        $sem_run = mysqli_query($con , $sem_check);
        if($sem_run)
        {
            $date = date('M,Y');
            $sem_row = mysqli_fetch_assoc($sem_run);
            $no_of_sem = $sem_row['no_of_semester'];
            if($semester == $no_of_sem)
            {
                $std_gra = "UPDATE `student_info` SET `fees_status`='',`exam_status`='',`current_semester`='',`class_id`='' , `graduation_day`='$date'
                WHERE enrollment_no = '$enro' ";
                $gra_run = mysqli_query($con , $std_gra);
                if($gra_run)
                {
                    $suc = "<script>alert('SucessFully Graduated On $date');</script>";
                    $jump = "<script>window.location.href='promote_class.php?course_code=$course_code';</script>";
                }
                else
                {
                    $err = "<script>alert('error updating');</script>";
                    $jump = "<script>window.location.href='promote_class.php?course_code=$course_code';</script>";
                }
            }
            else
            {
                $pro_sem = $select + 1 ;
                $check = "SELECT * FROM class WHERE course_code = '$course_code' AND sem = '$pro_sem' AND dept_id = '$admin_dept_id' ";
                $check_run = mysqli_query($con , $check);
                if((mysqli_num_rows($check_run)) > 0 )
                {
                    $check_row = mysqli_fetch_assoc($check_run);
                    $str = $check_row['no_of_student'];
                    $class_id = $check_row['class_id'];
                    $check_str = "SELECT COUNT(class_id) AS str FROM student_info WHERE class_id = '$class_id' ";
                    $run_str = mysqli_query($con ,$check_str);
                    if($run_str)
                    {
                        $row_str = mysqli_fetch_assoc($run_str);
                        $a_str = $row_str['str'];
                        if($str <= $a_str)
                        {
                            $err = "<script>alert('Class lenght is Full , Create a new class.');</script>";
                            $jump = "<script>window.location.href='class.php';</script>";
                        }
                        else
                        {
                            $std_pro = "UPDATE `student_info` SET `fees_status`='unpaid',`exam_status`='',`current_semester`='$pro_sem',`class_id`='$class_id'
                            WHERE enrollment_no = '$enro' ";
                            $std_run = mysqli_query($con , $std_pro);
                            if($std_run)
                            {
                                $suc = "<script>alert('SucessFully Promoted To Semester :  $pro_sem');</script>";
                                $jump ="<script>window.location.href='promote_class.php?course_code=$course_code';</script>";

                            }
                            else
                            {
                                $err = "<script>alert('error updating');</script>";
                                $jump = "<script>window.location.href='promote_class.php?course_code=$course_code';</script>";
                            }

                        }
                    }
    
                }
                else
                {
                    $err = "<script>alert('NO class found Create a class.');</script>";
                    $jump = "<script>window.location.href='class.php';</script>";
                }

            }
        }
        
    }
    if($err != "")
    {
        echo $err . $jump ;
    }
    else
    {
        echo $suc . $jump ;
    }
}
?>