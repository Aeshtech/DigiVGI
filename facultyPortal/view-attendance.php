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
        
    }

    // <!-- Fetching distinct date   -->
    $query1= "SELECT DISTINCT `date` FROM `attendance` WHERE `subject_name`='$subject_name' AND `course`='$course' AND `branch`='$branch' AND `semester`='$semester' AND `section`='$section' AND `date` BETWEEN '$startdate' AND '$enddate' ORDER BY `date`";
    $result1 = mysqli_query($conn,$query1);
    $total_date_count = mysqli_num_rows($result1);


    // Fetching roll_no and student_name for to set these on y-axis i.e left most columns.
    $query2 = "SELECT DISTINCT `roll_no`,`student_name` FROM `attendance` WHERE `subject_name`='$subject_name' AND `course`='$course' AND `branch`='$branch' AND `semester`='$semester' AND `section`='$section' AND `date` BETWEEN '$startdate' AND '$enddate' ORDER BY `roll_no`,`student_name`,`date`";
    $result2 = mysqli_query($conn,$query2);

    
    // Fetching status and set the status of each students corrosponding to date. 
    $query3 = "SELECT `status` FROM `attendance` WHERE `subject_name`='$subject_name' AND `course`='$course' AND `branch`='$branch' AND `semester`='$semester' AND `section`='$section' AND `date` BETWEEN '$startdate' AND '$enddate' ORDER BY `roll_no`,`student_name`,`date`";
    $result3 = mysqli_query($conn,$query3);

    $j=0;
    while($row3=mysqli_fetch_assoc($result3)){
        $arr[] = $row3['status'];
        $j++;
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
                        <th>Roll No</th>
                            <th>Student Name</th>
                            <?php
                            if(mysqli_num_rows($result1)>0){
                                while($row1 = mysqli_fetch_assoc($result1)){?>
                                <th><?=$row1['date']?></th>
                            <?php
                            }
                            }?>
                        </tr>
                    </thead>
                    <tbody>
                    <?Php
                        $j=0;
                        if(mysqli_num_rows($result2)>0){
                            while($row2 = mysqli_fetch_assoc($result2)){?>
                        <tr>
                            <td><?= $row2['roll_no'];?></td>
                            <td><?= $row2['student_name'];?></td>
                            <?php
                                $i=0;
                                while($i<$total_date_count){?>
                                <td><?= $arr[$j] ?></td>
                                <?php
                                $j++;
                                $i++;
                            }?>
                        </tr>
                        <?php
                        }
                    }else{
                        echo "No record was found!!";}?>
                </tbody>
                </table>
            </div>
</body>

</html>