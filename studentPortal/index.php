<!-- -------------------------------------------------*** JAI SHRI KRISHNA ***--------------------------------------- -->
<?php
session_start();
if(!$_SESSION['username_student'])
{
    header('Location: ../index.php');
}
  require('../adminstrative/config.php');
//   require('../adminstrative/bootstrap.php');
error_reporting(E_ERROR | E_WARNING | E_PARSE );

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal</title>
    <link rel="stylesheet" href="../digivgi_styles.css">
    <script src="https://kit.fontawesome.com/471f9934c1.js"></script>
</head>

<body>
    <?php require('stu_header.php');?>
    <div class="attendance-mssg">
        <?php
            if(isset($_SESSION['mssg'])&& $_SESSION['mssg'] !='')
            {
            echo '<b>'.$_SESSION['mssg'].'</b>';
                unset($_SESSION['mssg']);
            }
    ?>
    </div>

    <?php 
    $studentid = $_SESSION['username_student'];
    $query = "SELECT `course`,`branch`,`semester`,`section`,`registration`,`name` FROM `student` WHERE `email`='$studentid' AND `user_type`='student'";
    $result = mysqli_query($conn,$query);
    $data = mysqli_fetch_assoc($result);
    $course = $data['course'];
    $branch = $data['branch'];
    $semester = $data['semester'];
    $section = $data['section'];
    $roll_no = $data['registration'];
    $student_name = $data['name'];
    ?>
    <!-- =============================Subjects list in grid============================= -->
    <div id="grid-container">
        <?php

$sql = "SELECT `subjectname`,`subjectcode` from `assignfaculty` where `course`= '$course' AND `branch`='$branch' AND `semester` = '$semester' AND `section` = '$section'";
$result1 = mysqli_query($conn, $sql);

if(mysqli_num_rows($result1)>0){
    $i=0;     // mysqli_num_rows() return total count of rows!
    while($row = mysqli_fetch_assoc($result1)){
        $i++;
        $subjectname =  $row['subjectname'];
        $subjectcode =  $row['subjectcode'];
        $date = date("Y-m-d");
        ?>
        <div id="grid-item">
            <div class="subject-name">
                <h2><?php echo $row['subjectname']?></h2>
            </div>
            <!-- -----for view record------ -->
            <a href="#openModal-view[<?php echo $i ?>]">
            <div class="view-record-container" style="top: 25%;">
                <i class="fas fa-eye"style="color: white;margin-right:5px;"></i>
            <span style="font-size: 18px;">View Attendance</span>
            </div>
            </a>
            
            <!-- -----for export record------ -->
            <a href="#openModal-export[<?php echo $i ?>]">
            <div class="export-record-container">
                <i class="fas fa-file-excel"style="color: white;margin-right:5px;"></i>
                <span style="font-size: 18px;">Export Attendance</span>
            </div>
            </a>

            <?php 
            $query2 = "SELECT COUNT(`status`) FROM `attendance` WHERE `course`='$course' AND `branch`='$branch' AND `semester`='$semester' AND `section`='$section' AND `status`='Present' AND `roll_no`='$roll_no' AND `subject_code`='$subjectcode'";
            $result2 = mysqli_query($conn,$query2);
            $row2 = mysqli_fetch_array($result2);
            $total_present = $row2[0];
            
            $query3 = "SELECT COUNT(`status`) FROM `attendance` WHERE `course`='$course' AND `branch`='$branch' AND `semester`='$semester' AND `section`='$section' AND `subject_code`='$subjectcode' AND `roll_no`='$roll_no'";
            $result3 = mysqli_query($conn,$query3);
            $row3 = mysqli_fetch_array($result3);
            $total_status = $row3[0];
                        
             // if $total_status is 0 than we simply assign present_percent_status= 0 for instead of getting divide by zero error. 
             if($total_status !== "0"){
                $percentage = ($total_present/$total_status)*100;
                // format precentage upto 1 decimal place. 
                $present_percent_subject = number_format($percentage,1);
            }else{
                $present_percent_subject = "0";
            }
            ?>
            <h3 class="present_percent_subject" style="margin-top:17vh;color:white;font-family: cursive;">Total Present = <?=$present_percent_subject; ?>%</h3>

            <?php 
                $sql_query = "SELECT `status` FROM `attendance` WHERE `date`='$date' AND `course`='$course' AND `branch`='$branch' AND `semester`='$semester' AND `section`='$section' AND `roll_no`='$roll_no' AND `subject_code`='$subjectcode'";
                $sql_result = mysqli_query($conn,$sql_query);
                $status = mysqli_fetch_assoc($sql_result);
                $status = $status['status'];
                if($status=='Present'){?>
                <button class="pulse-button-p">P</button>
                <svg class="heart" viewBox="0 0 32 29.6">
                    <path d="M23.6,0c-3.4,0-6.3,2.7-7.6,5.6C14.7,2.7,11.8,0,8.4,0C3.8,0,0,3.8,0,8.4c0,9.4,9.5,11.9,16,21.2c6.1-9.3,16-12.1,16-21.2C32,3.8,28.2,0,23.6,0z" />
                </svg>

            <?php }elseif($status=='Absent'){?>

                <button class="pulse-button-a">A</button>

                <?php }else{
                    echo "<span style='position:absolute;left:50%;transform:translateX(-50%);width:100%;bottom:10px;font-size:larger;color:white;'>Today attendance not taken yet!<span>"; 
                }
                ?>
        </div>

        <!-- ------------Form as modal for view attendance record--------------- -->
        <form action="view_attendance.php" id="openModal-view[<?php echo $i ?>]" method="POST" class="modalDialog">
            
            <input type="hidden" name="subjectname[<?php echo $i ?>]" value="<?php echo $row['subjectname']?>">
            <input type="hidden" name="subjectcode[<?php echo $i ?>]" value="<?php echo $row['subjectcode']?>">
            <input type="hidden" name="course[<?php echo $i ?>]" value="<?php echo $course; ?>">
            <input type="hidden" name="branch[<?php echo $i ?>]" value="<?php echo $branch; ?>">
            <input type="hidden" name="semester[<?php echo $i ?>]" value="<?php echo $semester; ?>">
            <input type="hidden" name="section[<?php echo $i ?>]" value="<?php echo $section; ?>">
            <input type="hidden" name="roll_no[<?php echo $i ?>]" value="<?php echo $roll_no;?>">
            <input type="hidden" name="student_name[<?php echo $i ?>]" value="<?php echo $student_name;?>">

            <div>
                <a href="#close" title="Close" class="close">X</a>
                <h2>View Attendance </h2>
                <b>Enter the starting date you want to see the record!</b><br>
                <input type="date" name="startdate[<?php echo $i ?>]" min="2020-08-11"
                    max="<?php  echo date("Y-m-d"); ?>" required><br>

                <b>Enter the last date you want to see the record!</b><br>
                <input type="date" name="enddate[<?php echo $i ?>]" min="2020-08-11" max="<?php  echo date("Y-m-d"); ?>"
                    required><br>

                <input type="submit" name="view_attendance" value="View Attendance">
            </div>
        </form>

        <!-- ------------Form as modal for export attendance record--------------- -->
        <form action="export_by_spreadsheet.php" id="openModal-export[<?php echo $i ?>]" method="POST" class="modalDialog">

            <input type="hidden" name="subjectname[<?php echo $i ?>]" value="<?php echo $row['subjectname']?>">
            <input type="hidden" name="subjectcode[<?php echo $i ?>]" value="<?php echo $row['subjectcode']?>">
            <input type="hidden" name="course[<?php echo $i ?>]" value="<?php echo $course; ?>">
            <input type="hidden" name="branch[<?php echo $i ?>]" value="<?php echo $branch; ?>">
            <input type="hidden" name="semester[<?php echo $i ?>]" value="<?php echo $semester; ?>">
            <input type="hidden" name="section[<?php echo $i ?>]" value="<?php echo $section; ?>">
            <input type="hidden" name="roll_no[<?php echo $i ?>]" value="<?php echo $roll_no;?>">
            <input type="hidden" name="student_name[<?php echo $i ?>]" value="<?php echo $student_name;?>">

            <div>
                <a href="#close" title="Close" class="close">X</a>
                <h2>Export Attendance </h2>
                <b>Enter the starting date you want to export the record!</b><br>
                <input type="date" name="startdate[<?php echo $i ?>]" min="2020-08-11"
                    max="<?php  echo date("Y-m-d"); ?>" required><br>

                <b>Enter the last date you want to export the record!</b><br>
                <input type="date" name="enddate[<?php echo $i ?>]" min="2020-08-11" max="<?php  echo date("Y-m-d"); ?>"
                    required><br>

                <input type="submit" name="export_attendance" value="Export Attendance">
            </div>
        </form>
        <?php
}
}
?>
</div>
<!-- ----------Footer-------------- -->
<footer >
    <div class="footer">
        <a href="https://www.instagram.com/its_ashish_52/"><i class="fa fa-instagram fa-2x" aria-hidden="true"></i></a>
        <a href="https://twitter.com/DevloperAshish"><i class="fa fa-twitter fa-2x" aria-hidden="true"></i></a>
        <a href="https://www.facebook.com/Aeshtech52"><i class="fa fa-facebook fa-2x" aria-hidden="true"></i></a>
        <hr><br>
        <span>&copy 2020 DigiVGI. All rights reserved</span>
    </div>
</footer>
</body>

</html>