<!-- -------------------------------------------------*** JAI SHRI KRISHNA ***--------------------------------------- -->
<?php 
session_start();
if(!$_SESSION['username_faculty'])
{
    header('Location: ../index.php');
}

require('../adminstrative/config.php');
include('header.php');

if(isset($_POST['view_attendance'])){
    foreach ($_POST['subjectcode'] as $key => $subject_code){
        $subject_name = $_POST['subjectname'][$key];
        $course = $_POST['course'][$key];
        $branch = $_POST['branch'][$key];
        $semester = $_POST['semester'][$key];
        $section = $_POST['section'][$key];
        $startdate = $_POST['startdate'][$key];
        $enddate = $_POST['enddate'][$key];

        $query = "SELECT `status`,`roll_no`,`student_name`,`date` FROM `attendance` WHERE `subject_code`='$subject_code' AND `course`='$course' AND `branch`='$branch' AND `semester`='$semester' AND `section`='$section' AND `date` BETWEEN '$startdate' AND '$enddate' ORDER BY `date`";
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

    <div class="subject-name-over-table">
        <h2><?php echo $subject_name ?></h2>
        <b><?= $course ?></b>
        <b><?= $branch ?></b>
        <b><?= $semester ?></b>
        <b><?= $section ?></b>
    </div>
            <div style="overflow: auto;">
                <table class="view_attendance">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Name</th>
                            <th>Roll No</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?Php

    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){?>
                        <tr>
                            <td><?php echo $row['date'];?></td>
                            <td><?php echo $row['status'];?></td>
                            <td><?php echo $row['student_name'];?></td>
                            <td><?php echo $row['roll_no'];?></td>
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