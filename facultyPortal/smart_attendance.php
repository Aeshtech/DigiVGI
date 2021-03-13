<!-- -------------------------------------------------*** JAI SHRI KRISHNA ***--------------------------------------- -->
<?php
session_start();
if(!$_SESSION['username_faculty'])
{
    header('Location: ../index.php');
}
require('../adminstrative/config.php');
require('header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://kit.fontawesome.com/471f9934c1.js"></script>
</head>

<body>
    <div class="navBottom"></div>


    <?php
if(isset($_POST['submit'])){
    $course = $_POST['course'];
    $branch = $_POST['branch'];
    $semester = $_POST['semester'];
    $section = $_POST['section'];
    $subjectname = $_POST['subjectname'];
    $subjectcode = $_POST['subjectcode'];
    $cpermit = $_POST['cpermit'];
    $date = $_POST['date'];
}?>




    <?php
$sql = "SELECT * FROM `attendance` where `subject_code`= '$subjectcode' AND `course`='$course' AND `branch`='$branch' AND `semester`='$semester' AND `section`='$section' AND `date`= '$date' ";
$sql_result = mysqli_query($conn,$sql);
if(mysqli_num_rows($sql_result)>0){
?>

    <?php 
    if($cpermit=='Yes'){
    ?>


    <div id="grid-container-aesh">
        <form action="action_ashish.php" method="POST">

            <div class="subject_name">
                <h2><?php echo $subjectname?></h2>
                <b><?php echo $course ?></b>
                <b><?php echo $branch ?></b>
                <b><?php echo $semester ?></b>
                <b><?php echo $section ?></b>
            </div>
            <marquee style="color:red;behavior:scroll;font-size:10px;display:block;">Note:Please do not refresh page
                before click on save,
                it may lost your current record!!</marquee>

            <?php 
$query = "SELECT DISTINCT `roll_no`,`status`,`student_name`,`course`,`branch`,`semester`,`section` FROM `attendance` WHERE `course`='$course' AND `branch`='$branch' AND `semester`='$semester' AND `section`='$section' AND `date`='$date' AND `subject_code`='$subjectcode'";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){?>

            <?php 
    $i=0;
    while($row = mysqli_fetch_assoc($result)){
        $course = $row['course'];
        $branch = $row['branch'];
        $semester = $row['semester'];
        $section = $row['section'];
        $roll_no = $row['roll_no'];
        $i++;
?>
            <div id="grid-item-aesh">
                <div class="student_name">
                    <span class="serial-no"><?php echo $i ?></span>
                    <h2><?php echo $row['student_name']?></h2>
                </div>

                <!-- Mandatory..Give each student radio button name different! -->
                <input type="hidden" name="course[<?php echo $i ?>]" value="<?php echo $course ?>">
                <input type="hidden" name="branch[<?php echo $i ?>]" value="<?php echo $branch ?>">
                <input type="hidden" name="semester[<?php echo $i ?>]" value="<?php echo $semester ?>">
                <input type="hidden" name="section[<?php echo $i ?>]" value="<?php echo $section ?>">
                <input type="hidden" name="subject_code[<?php echo $i ?>]" value="<?php echo $subjectcode; ?>">
                <input type="hidden" name="subject_name[<?php echo $i ?>]" value="<?php echo $subjectname; ?>">
                <input type="hidden" name="date[<?php echo $i ?>]" value="<?php echo $date; ?>">
                <input type="hidden" name="roll_no[<?php echo $i ?>]" value="<?php echo $roll_no ?>">

                <label class="status-label1">
                    <input type="radio" name="attendance[<?php echo $i ?>]" value="Present"
                        style="width: 20px;height:20px;" <?php if($row['status']=='Present'){?>checked<?php }?>>
                    <strong>Present</strong>
                </label>

                <label class="status-label2">
                    <input type="radio" name="attendance[<?php echo $i ?>]" value="Absent"
                        style="width: 20px;height:20px;" <?php if($row['status']=='Absent'){?>checked<?php }?>>
                    <strong>Absent</strong>
                </label>

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
                <b class="present_percent_subject" style="color:white;font-family: cursive;"><?=$present_percent_subject; ?>%</b>
            </div>
            <?Php
    }
}
?>

            <input type="submit" name="update_attendance" value="Save" class="save_attendance"
                onclick="return confirm('Are you sure to make these attendance!')">
        </form>
    </div>

    <?php
    }else{
        echo "<h1 style='margin-left:35%;color:blue;'>Sorry:-/</h1><br>
        <strong style='color:red;margin-left:20px;'>You don't have C-Permit for this subject to change previous record!</strong>
        <br><b><a href='index.php'>Go Back</a>";
    }
}
 else{?>

    <div id="grid-container-aesh">
        <form action="action_ashish.php" method="POST">
            <?php 
$query = "SELECT * FROM `student` WHERE `course`='$course' AND `branch`='$branch' AND `semester`='$semester' AND `section`='$section' ORDER BY `registration`";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){ ?>

            <div class="subject_name">
                <h2><?php echo $subjectname?></h2>
                <b><?php echo $course ?></b>
                <b><?php echo $branch ?></b>
                <b><?php echo $semester ?></b>
                <b><?php echo $section ?></b>
            </div>

            <marquee style="color:red;behavior:scroll;font-size:10px;display:block;">Note:Please do not refresh page
                before click on save,
                it may lost your current record!!</marquee>

            <?php
    $i=0;
    while($row = mysqli_fetch_assoc($result)){
        $name = $row['name'];
        $course = $row['course'];
        $branch = $row['branch'];
        $semester = $row['semester'];
        $section = $row['section'];
        $roll_no = $row['registration'];
        $i++;
?>

            <div id="grid-item-aesh">
                <div class="student_name">
                    <span class="serial-no"><?php echo $i ?></span>
                    <h2><?php echo $row['name']?></h2>
                </div>

                <br>

                <input type="hidden" name="roll_no[<?php echo $i ?>]" value="<?php echo $roll_no ?>">
                <input type="hidden" name="student_name[<?php echo $i ?>]" value="<?php echo $name ?>">
                <input type="hidden" name="course[<?php echo $i ?>]" value="<?php echo $course ?>">
                <input type="hidden" name="branch[<?php echo $i ?>]" value="<?php echo $branch?>">
                <input type="hidden" name="semester[<?php echo $i ?>]" value="<?php echo $semester ?>">
                <input type="hidden" name="section[<?php echo $i ?>]" value="<?php echo $section ?>">
                <input type="hidden" name="subject_name[<?php echo $i ?>]" value="<?php echo $subjectname; ?>">
                <input type="hidden" name="subject_code[<?php echo $i ?>]" value="<?php echo $subjectcode; ?>">
                <input type="hidden" name="date[<?php echo $i ?>]" value="<?php echo $date; ?>">

                <!-- For checking is there any subject with this code in db which has been taken attendance already-->
                <input type="hidden" name="subjectcode" value="<?php echo $subjectcode; ?>">

                <!-- Mandatory..Give each student radio button name different! -->
                <label class="status-label1">
                    <input type="radio" name="attendance[<?php echo $i ?>]" value="Present"
                        style="width: 20px;height:20px;" class="present_button">
                    <strong>Present</strong>
                </label>
                <label class="status-label2">
                    <input type="radio" name="attendance[<?php echo $i ?>]" value="Absent"
                        style="width: 20px;height:20px;" checked class="absent_button">
                    <strong>Absent</strong>
                </label>

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
            <b class="present_percent_subject" style="color:white;font-family: cursive;"><?=$present_percent_subject; ?>%</b>

            </div>
            <?Php
    }
}else{
    echo '<h3 style="color:Red;">No Student registered yet in '.$course.' of branch '.$branch.' semester '.$semester.' and section '.$section.'</h3><br>
    <b style="color:blueviolet;">Please try to contact your admin.</b>';
}
?>

            <input type="submit" name="make_attendance" value="Save" class="save_attendance"
                onclick="return confirm('Are you sure to make these attendance!')">
        </form>
        <input type="checkbox" id="selectall" onchange="selectall()">
    </div>
    <?php } ?>

    <script>
    function selectall() {
        var x = document.getElementsByClassName("present_button");
        var y = document.getElementsByClassName("absent_button");
        var z = document.getElementById("selectall").checked;
        if (z == true) {
            for (var i = 0; i <= x.length; i++) {
                x[i].checked = true;
            }
        } else {
            for (var i = 0; i <= y.length; i++) {
                y[i].checked = true;
            }
        }
    }
    </script>
</body>

</html>