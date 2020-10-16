<?php
session_start();
if(!$_SESSION['username_admin'])
{
    header('Location: ../index.php');
}
require("config.php");
$update=false;
$id="";
$course="";
$semester="";
$section="";
$subjectname="";
$subjectcode="";


/*------------For inserting record in database--------- */
if(isset($_POST['submit'])){
    $course = $_POST['course'];
    $semester = $_POST['semester'];
    $section = $_POST['section'];
    $subjectname = $_POST['subjectname'];
    $subjectcode = $_POST['subjectcode'];

    $query = "INSERT INTO `subject`(`course`,`semester`,`section`,`subjectname`,`subjectcode`)VALUES('$course','$semester','$section','$subjectname','$subjectcode')";
	if(mysqli_query($conn,$query)){
        $_SESSION['status'] = 'Successfully inserted!';
        header('location:subject.php');
    }
}

/*------------For deleting record from database--------- */
if(isset($_GET['delete'])){
	$id = $_GET['delete'];
    $sql = "delete from subject where id =".$id;
    $result = mysqli_query($conn, $sql);
    if($result){
        $_SESSION['status'] = 'Successfully Deleted!';
        header('location:subject.php');
    }
}


/*-------------------------------- updating record-------------------------  */

if(isset($_GET['id'])){
	$id = $_GET['id'];
	
// fetching record from db based on id and assigining below into variables which is working as value for 'form' in subject.php!
$query = "SELECT * FROM `subject` WHERE id = '$id' ";
$result=mysqli_query($conn,$query);
$numRows = mysqli_num_rows($result);
if($numRows==1){
    $row = mysqli_fetch_assoc($result);

    $course = $row['course'];
    $semester = $row['semester'];
    $section = $row['section'];
    $subjectname = $row['subjectname'];
    $subjectcode = $row['subjectcode'];
    $update=true;
}
}

/*================================Updating Record==================================== */

// we are using Php procedural oriented approach here for updating record.

if(isset($_POST['update'])){
    $id = $_POST['id'];
    $course = $_POST['course'];
    $semester = $_POST['semester'];
    $section = $_POST['section'];
    $subjectname = $_POST['subjectname'];
    $subjectcode = $_POST['subjectcode'];
    $query = "UPDATE `subject` set `course`='$course', `semester`='$semester', `section`='$section', `subjectname`='$subjectname', `subjectcode`='$subjectcode' WHERE `id`='$id'";
    $result=mysqli_query($conn,$query);
    if(mysqli_affected_rows($conn)){
        $_SESSION['status'] = 'Successfully Updated !';
        header('location:subject.php');
    }
}

?>