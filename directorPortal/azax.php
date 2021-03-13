<?php 
require('../adminstrative/config.php');
$course = $_POST['course'];
$semester = $_POST['semester'];
$branch = $_POST['branch'];
$startdate = $_POST['startdate'];
$enddate = $_POST['enddate'];
//this condition will only execute if semester value is empty and if it also contains some value then else part will execute.
if($semester =="" && $branch==""){
  $sql="SELECT Count(case WHEN `course` = '$course' AND (`date` BETWEEN '$startdate' AND '$enddate') AND `status`='Present'  THEN `status` END) * 100/ Count(case WHEN `course` = '$course' AND (`date` BETWEEN '$startdate' AND '$enddate') THEN `status` END) FROM `attendance`";
  $result = mysqli_query($conn,$sql);
  $row = mysqli_fetch_array($result);
  echo $row[0];
  mysqli_close($conn);
}else{
  $sql="SELECT Count(case WHEN `course` = '$course' AND `semester`='$semester' AND `branch`='$branch' AND (`date` BETWEEN '$startdate' AND '$enddate') AND `status`='Present'  THEN `status` END) * 100/ Count(case WHEN `course` = '$course' AND `semester`='$semester' AND `branch`='$branch' AND (`date` BETWEEN '$startdate' AND '$enddate') THEN `status` END) FROM `attendance`";
  $result = mysqli_query($conn,$sql);
  $row = mysqli_fetch_array($result);
  echo $row[0];
  mysqli_close($conn);
}

?>