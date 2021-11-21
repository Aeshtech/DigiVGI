<!-- -------------------------------------------------*** JAI SHRI KRISHNA ***--------------------------------------- -->
<?php 
session_start();
if(!$_SESSION['username_student'])
{
    header('Location: ../index.php');
}
$student = $_SESSION['username_student'];
require('../adminstrative/config.php');
require('stu_header.php');

if(isset($_POST['view_attendance'])){
    foreach ($_POST['subjectcode'] as $key => $subject_code){
        $subject_name = $_POST['subjectname'][$key];
        $course = $_POST['course'][$key];
        $branch = $_POST['branch'][$key];
        $semester = $_POST['semester'][$key];
        $section = $_POST['section'][$key];
        $startdate = $_POST['startdate'][$key];
        $enddate = $_POST['enddate'][$key];
        $roll_no = $_POST['roll_no'][$key];
        $student_name = $_POST['student_name'][$key];

        $query = "SELECT `status`,`date` FROM `attendance` WHERE `subject_code`='$subject_code' AND `roll_no` = '$roll_no' AND `course`='$course' AND `branch`='$branch' AND `semester`='$semester' AND `section`='$section' AND `date` BETWEEN '$startdate' AND '$enddate' ORDER BY `date`";
        $result = mysqli_query($conn,$query);
        
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>view Attendance</title>
    <link rel="stylesheet" href="../digivgi_styles.css">
</head>

<body>
<div class="navBottom"></div>
    <div class="subject-name-container">
        <span style="font-size: 20px;"><?php echo $subject_name;?></span>
        <span style="font-size: 14px;margin-left: 10px;font-family: serif;"><?php echo $subject_code;?></span><br>
        <span style="font-size: 20px;"><?php echo $student_name;?></span>
        <span style="font-size: 14px;margin-left: 10px;font-family: serif;"><?php echo $roll_no;?></span>
    </div>

            <div style="overflow: auto;">
                <table class="view_attendance" style="text-align: center;">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?Php
                        if(mysqli_num_rows($result)>0){
                            while($row = mysqli_fetch_assoc($result)){?>
                            <tr>
                                <td><?php echo $row['date'];?></td>
                                <td><?php echo $row['status'];?></td>
                            </tr>
                        <?php
                        }
                    }else{
                        echo "No record was found!!";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
</body>
</html>