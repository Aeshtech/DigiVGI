<!-- ==================================================================JAI SHREE KRISHNA============================================= -->
<?php
session_start();
require('config.php');

$_SESSION['username_admin'];
$username = $_SESSION['username_admin'];
$sql = "SELECT `course`,`branch` FROM `admin` WHERE `email`='$username'";
$rslt = mysqli_query($conn,$sql);
$pro = mysqli_fetch_assoc($rslt);
$admin_course =$pro['course'];
$admin_branch =$pro['branch'];
?>

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
    $semester = $_POST['semester'];
    $section = $_POST['section'];
    $startdate = $_POST['startdate'];
    $lastdate = $_POST['lastdate'];

    // <!-- Fetching distinct date   -->
    $query1= "SELECT DISTINCT `date` FROM `attendance` WHERE `subject_name`='$subjectname' AND `course`='$admin_course' AND `branch`='$admin_branch' AND `semester`='$semester' AND `section`='$section' AND `date` BETWEEN '$startdate' AND '$lastdate' ORDER BY `date`";
    $result1 = mysqli_query($conn,$query1);
    $total_date_count = mysqli_num_rows($result1);


    // Fetching roll_no and student_name for to set these on y-axis i.e left most columns.
    $query2 = "SELECT DISTINCT `roll_no`,`student_name` FROM `attendance` WHERE `subject_name`='$subjectname' AND `course`='$admin_course' AND `branch`='$admin_branch' AND     `semester`='$semester' AND `section`='$section' AND `date` BETWEEN '$startdate' AND '$lastdate' ORDER BY `roll_no`,`student_name`,`date`";
    $result2 = mysqli_query($conn,$query2);

    
    // Fetching status and set the status of each students corrosponding to date. 
    $query3 = "SELECT `status` FROM `attendance` WHERE `subject_name`='$subjectname' AND `course`='$admin_course' AND `branch`='$admin_branch' AND `semester`='$semester' AND `section`='$section' AND `date` BETWEEN '$startdate' AND '$lastdate' ORDER BY `roll_no`,`student_name`,`date`";
    $result3 = mysqli_query($conn,$query3);

    $j=0;
    while($row3=mysqli_fetch_assoc($result3)){
        $arr[] = $row3['status'];
        $j++;
    }
    ?>
    <div class="subject-name-over-table" style="margin: 10vh 1vh 2vh 1vh;">
        <h2><?php echo $subjectname ?></h2>
        <b><?= $admin_course ?></b>
        <b><?= $admin_branch ?></b>
        <b><?= $semester ?></b>
        <b><?= $section ?></b>
    </div>
            <div style="overflow: auto;">
                <table class="view_attendance" style="text-align: center;margin-bottom: 3vh;">
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