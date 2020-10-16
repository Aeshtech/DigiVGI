<!-- ==================================================================JAI SHREE KRISHNA============================================= -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance View</title>
    <link rel="stylesheet" href="../digivgi_styles.css">
    <style>
    .logodiv{
  position: fixed;
  width: 100%;
  margin-bottom:20px;
  text-align: center;
  padding: 2px;
  background:rgb(236, 236, 236);
  height: 3.5em;
  top: 0;
}
img#logo{
  width: 40px;
  border-radius: 50%;
  position: absolute;
  left: 66%;
  top: 8px;
}
.logodiv h1{
  font-size: 2em;
  display: inline-block;
  text-shadow: 2px 2px 4px black;
  background: rgb(0, 102, 255);
  color: white;
  padding: 5px 70px 5px 20px;
  border-radius: 20px;
  border: 2px double white;
  margin-top:0.5px;
}
div.home-footer{
    color:white;
    background-color: rgb(0, 102, 255);
    text-align: center;
    position: fixed;
    width: 100%;
    height: 35px;
    font-size: medium;
    bottom: 0;
    padding: 5px;
    font-size: 20px;
}
div.home-footer a{
  color: white;
  font-size: medium;
  float: right;
  margin-right:20px ;
}

@media only screen and (min-width:612px){
    img#logo{
        left: 54%;
    }
}
</style>
</head>

<body>
    <!-- ==============================DigiVGI-Header================= -->
    <header>
        <div class="logodiv">
            <h1>Digi VGI</h1>
            <img src="vgi-logo.jpg" id="logo">
        </div>
    </header>


    <?php 
require('config.php');
if(isset($_POST['view-based-on-subject'])){
    $subjectname = $_POST['subjectname'];
    $course = $_POST['course'];
    $branch = $_POST['branch'];
    $semester = $_POST['semester'];
    $section = $_POST['section'];
    $startdate = $_POST['startdate'];
    $lastdate = $_POST['lastdate'];
    
    $query = "SELECT `status`,`roll_no`,`student_name`,`date` FROM `attendance` WHERE `subject_name`='$subjectname' AND `course`='$course' AND `branch`='$branch' AND `semester`='$semester' AND `section`='$section' AND `date` BETWEEN '$startdate' AND '$lastdate' ORDER BY `date`";
    $result = mysqli_query($conn,$query);?>
    
    <div class="subject-name-over-table" style="margin: 10vh 1vh 2vh 1vh;">
        <h2><?php echo $subjectname ?></h2>
        <b><?= $course ?></b>
        <b><?= $branch ?></b>
        <b><?= $semester ?></b>
        <b><?= $section ?></b>
    </div>
            <div style="overflow: auto;">
                <table class="view_attendance" style="text-align: center;margin-bottom: 5vh;">
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
                        echo "No record was found!!";}?>

                    </tbody>
                </table>
            </div>
            <?php
}elseif(isset($_POST['view-based-on-student'])){
    $roll_no = $_POST['roll_no'];
    $subjectname = $_POST['subjectname'];
    $startdate = $_POST['startdate'];
    $lastdate = $_POST['lastdate'];
    $query = "SELECT `status`,`date` FROM `attendance` WHERE `subject_name`='$subjectname' AND `roll_no` = '$roll_no' AND `date` BETWEEN '$startdate' AND '$lastdate' ORDER BY `date`";
    $result = mysqli_query($conn,$query);?>

    <h2 class="subject-name-over-table" style="margin: 10vh 5vh 2vh 5vh;"><?php echo $subjectname ?></h2>
    <div style="width:50%;margin:auto;">
        <table class="view_attendance" style="text-align:center;margin-bottom: 5vh;">
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
                echo "No record was found!!";}?>

            </tbody>
        </table>
    </div>

<?php
}
?>

<footer>
    <div class="home-footer">
        <b style="font-size: medium;float:left">CDP Ashish Sharma</b>
        <b style="font-size: medium;">&copy 2020 DigiVGI, All rights reserved.</b>
        <a href="https://aeshtech.com/"><b>Powered By-Aeshtech</b></a>
    </div>
</footer>
</body>
</html>