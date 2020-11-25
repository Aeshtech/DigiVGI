<?php 
session_start();
if(!$_SESSION['username_admin'])
{
    header('Location: ../index.php');
}
require("config.php");

$username = $_SESSION['username_admin'];
$sql = "SELECT `course`,`branch` FROM `admin` WHERE `email`='$username'";
$rslt = mysqli_query($conn,$sql);
$pro = mysqli_fetch_assoc($rslt);
$admin_course =$pro['course'];
$admin_branch =$pro['branch'];

$update=false;
$course="";
$branch="";
$semester="";
$section="";
$facultyname="";
$facultyid="";
$subjectname="";
$subjectcode="";
$cpermit="";


/*------------For inserting record in database--------- */
if(isset($_POST['submit'])){
    $semester = $_POST['semester'];
    $section = $_POST['section'];
    $facultyname = $_POST['facultyname'];
    $facultyid = $_POST['facultyid'];
    $facultyid = filter_var($facultyid,FILTER_SANITIZE_EMAIL);
    $subjectname = trim($_POST['subjectname']);
    $subjectcode = trim($_POST['subjectcode']);
    $confirm_sub_code = trim($_POST['confirm_sub_code']);

    if(isset($facultyid) && ($facultyid=="")){
		$_SESSION['error'] = "Faculty Id should not be empty!!";
		header('location:assignFaculty.php');
	}else if(filter_var($facultyid,FILTER_VALIDATE_EMAIL) != TRUE){
		$_SESSION['error'] = 'Please enter valid email address!';
		header('location:assignFaculty.php');
	}else if($subjectcode==""){
        $_SESSION['error'] = 'Subject code should not be empty!';
		header('location:assignFaculty.php');
    }else if($confirm_sub_code==""){
        $_SESSION['error'] = 'Subject code confirmation should not be empty!';
		header('location:assignFaculty.php');
    }else if($subjectcode != $confirm_sub_code){
        $_SESSION['error'] = "Subject code confirmation doesn't match!";
		header('location:assignFaculty.php');
    }else{
        $query = "INSERT INTO `assignfaculty`(`course`,`branch`,`semester`,`section`,`facultyname`,`facultyid`,`subjectname`,`subjectcode`)VALUES('$admin_course','$admin_branch','$semester','$section','$facultyname','$facultyid','$subjectname','$confirm_sub_code')";
        if(mysqli_query($conn,$query)){
            $_SESSION['status'] = 'Successfully inserted!';
            header('location:assignfaculty.php');
        }
    }
}

/*------------For deleting record from database--------- */
if(isset($_GET['delete'])){
	$id = $_GET['delete'];
    $sql = "delete from assignfaculty where id =".$id;
    $result = mysqli_query($conn, $sql);
    if($result){
        $_SESSION['status'] = 'Successfully Deleted!';
        header('location:assignfaculty.php');
    }
}


/*-------------------------------- updating record-------------------------  */

if(isset($_GET['id'])){
	$id = $_GET['id'];
	

// fetching record from db based on id and assigining below into variables which is working as value for 'form' in assignfaculty.php!
$query = "SELECT * FROM `assignfaculty` WHERE id = '$id' ";
$result=mysqli_query($conn,$query);
$numRows = mysqli_num_rows($result);
if($numRows==1){
    $row = mysqli_fetch_assoc($result);
    
    $semester = $row['semester'];
    $section = $row['section'];
    $facultyname = $row['facultyname'];
    $facultyid = $row['facultyid'];
    $subjectname = $row['subjectname'];
    $subjectcode = $row['subjectcode'];
    $update=true;
}
}

/*================================Updating Record==================================== */

// we are using Php procedural oriented approach here for updating record.

if(isset($_POST['update'])){
    $id = $_POST['id'];
    $semester = $_POST['semester'];
    $section = $_POST['section'];
    $facultyname = $_POST['facultyname'];
    $facultyid = $_POST['facultyid'];
    $facultyid = filter_var($facultyid,FILTER_SANITIZE_EMAIL);
    $subjectname = trim($_POST['subjectname']);
    $subjectcode = trim($_POST['subjectcode']);
    $confirm_sub_code = trim($_POST['confirm_sub_code']);

    if(isset($facultyid) && ($facultyid=="")){
		$_SESSION['error'] = "Faculty Id should not be empty!!";
		header('location:assignFaculty.php');
	}else if(filter_var($facultyid,FILTER_VALIDATE_EMAIL) != TRUE){
		$_SESSION['error'] = 'Please enter valid email address!';
		header('location:assignFaculty.php');
	}else if($subjectcode==""){
        $_SESSION['error'] = 'Subject code should not be empty!';
		header('location:assignFaculty.php');
    }else if($confirm_sub_code==""){
        $_SESSION['error'] = 'Subject code confirmation should not be empty!';
		header('location:assignFaculty.php');
    }else if($subjectcode != $confirm_sub_code){
        $_SESSION['error'] = "Subject code confirmation doesn't match!";
		header('location:assignFaculty.php');
    }else{
        $query = "UPDATE `assignfaculty` set `semester`='$semester', `section`='$section',`facultyname`='$facultyname',`facultyid`='$facultyid', `subjectname`='$subjectname', `subjectcode`='$confirm_sub_code' WHERE `id`='$id'";
        $result= mysqli_query($conn,$query);
        if(mysqli_affected_rows($conn)==1){
            $_SESSION['status'] = 'Successfully Updated !';
            header('location:assignfaculty.php');
        }
    }
}

?>