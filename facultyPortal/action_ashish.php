<!-- -------------------------------------------------*** JAI SHRI KRISHNA ***--------------------------------------- -->
<?php 
session_start();
require('../adminstrative/config.php');

if(isset($_POST['make_attendance'])){
    foreach ($_POST['attendance'] as $key => $attendance_status){
        $student_name = $_POST['student_name'][$key];
        $roll_no = $_POST['roll_no'][$key];
        $subject_name = $_POST['subject_name'][$key];
        $subject_code = $_POST['subject_code'][$key];
        $course = $_POST['course'][$key];
        $branch = $_POST['branch'][$key];
        $semester = $_POST['semester'][$key];
        $section = $_POST['section'][$key];
        $date = $_POST['date'][$key];
        $query = "INSERT INTO `attendance`(`status`,`roll_no`,`student_name`,`date`,`subject_name`,`subject_code`,`course`,`branch`,`semester`,`section`) VALUES('$attendance_status','$roll_no','$student_name','$date','$subject_name','$subject_code','$course','$branch','$semester','$section')";
        $result = mysqli_query($conn,$query);
    }
    if(mysqli_affected_rows($conn)){
        $_SESSION['mssg'] = "Attendance taken successfully of ".$subject_name." for the date ".$date;
        echo "Attendance Taken Successfully!";
    }
header("location:index.php");
}


if(isset($_POST['update_attendance'])){
    foreach ($_POST['attendance'] as $key => $attendance_status){
        $subject_code = $_POST['subject_code'][$key];
        $subject_name = $_POST['subject_name'][$key];
        $roll_no = $_POST['roll_no'][$key];
        $course = $_POST['course'][$key];
        $branch = $_POST['branch'][$key];
        $semester = $_POST['semester'][$key];
        $section = $_POST['section'][$key];
        $date = $_POST['date'][$key];
        $modified_date = date('y-m-d');

        $query = " UPDATE `attendance` SET `status`='$attendance_status',`modified_date`='$modified_date' WHERE `course`='$course' AND `branch`='$branch' AND `semester`='$semester' AND `section`='$section' AND `date`='$date' AND `subject_code`='$subject_code' AND `roll_no`='$roll_no'";
        $result = mysqli_query($conn,$query);
    }
    if(mysqli_affected_rows($conn)){
        $_SESSION['mssg'] = "Attendance Updated Successfully of ".$subject_name." for the date ".$date;
    }
    header("location:index.php");
}
?>