<!-- ===================================================================JAI SHREE KRISHNA=================================================== -->
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
$id="";
$reg="";
$name="";
$semester="";
$section="";
$phone="";
$gender="";
$email="";
$photo="default.jpg";
$password="";


function test_input($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
/*------------For inserting record in database--------- */
if(isset($_POST['submit'])){
	$user_type = $_POST['user_type'];
    $registration = $_POST['registration'];
    $name = $_POST['name'];
    $semester = $_POST['semester'];
    $section = $_POST['section'];
	$gender = $_POST['gender'];
	$email = $_POST['email'];
    $phone = $_POST['phone'];
	$email = filter_var($email,FILTER_SANITIZE_EMAIL);
	$email = test_input($email);
	$pwd = trim($_POST['password']);
	$password = password_hash($pwd,PASSWORD_BCRYPT);

	$imagetype = strtolower(pathinfo($_FILES['photo']['name'],PATHINFO_EXTENSION));    //taking extension from file name.

	if(!preg_match("/^[a-zA-Z- ']*$/",$name)){
		$_SESSION['error'] = "Name can only contain letters and white space!";
		header('location:student.php');
    }else if(!preg_match("/^\d{10}$/",$registration)){
		$_SESSION['error'] = "Registration no can only contain numberic value!";
		header('location:student.php');
    }else if(!preg_match("/^\d{10}$/",$phone)){
		$_SESSION['error'] = "Phone should contain only 10 digit valid number!";
		header('location:student.php');
    }else if(isset($pwd) && ($pwd=="")){
		$_SESSION['error'] = "Password should not be empty!!";
		header('location:student.php');
	}else if(strlen($pwd)<6){
		$_SESSION['error'] = "Password must include atleast six characters!";
		header('location:student.php');
	}else if(isset($email) && ($email=="")){
		$_SESSION['error'] = "Email should not be empty!!";
		header('location:student.php');
	}else if(filter_var($email,FILTER_VALIDATE_EMAIL) != TRUE){
		$_SESSION['error'] = 'Please enter valid email address!';
		header('location:student.php');
	}
	else if($imagetype!="jpg" && $imagetype!="jpeg" && $imagetype!="png"){
		$_SESSION['error'] = "Image should be in ('jpeg','jpg' or'png') only!";
		header('location:student.php');
	}
	else if($_FILES['photo']['size'] >= 500000){
		$_SESSION['error'] = 'Image size should be less than 500KB!';
		header('location:student.php');
	}else{
		$seprated = explode(".",$_FILES['photo']['name']);          //this will fetch name of the file from the $_FILES array and separate its by '.' period.
	    $newfilename = round(microtime(true)).'.'.end($seprated);  // this will generate a random no by microtime & round function and concenate it with extension taking by end() function from seprated filename! Use this to give each image file a unique name.
	    $upload = "uploads2/".$newfilename;          // assigning the path to variable.
		$tempname = $_FILES['photo']['tmp_name'];  //this will fetch temporary name of the file from the $_FILES array..!
		
		$query = "INSERT INTO `student`(`registration`,`name`,`phone`,`course`,`branch`,`semester`,`section`,`email`,`gender`,`password`,`photo`,`user_type`)VALUES('$registration','$name','$phone','$admin_course','$admin_branch','$semester','$section','$email','$gender','$password','$upload','$user_type')";
	    $result=mysqli_query($conn,$query);
		if($result){
			$_SESSION['status'] = 'Successfully Inserted!';
			move_uploaded_file($tempname,$upload);
			header('location:student.php');
		}
	}
}

/*------------For deleting record from database--------- */
if(isset($_POST['delete'])){
	$id = $_GET['id'];
	// this will remove photo from uploads directory also...!
	$sql = "select photo from student where id = ".$id;
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_assoc($result);
		$image = $row['photo'];
		unlink($image);

		// this will delete selected record from database permanently!
		$sql = "delete from student where id =".$id;
		if(mysqli_query($conn, $sql)){
			$_SESSION['status'] = 'Successfully Deleted!';
			header('location:student.php');
		}
	}
}

/*-------------------------For update record---------------------- */

  if(isset($_POST['update_id'])){
	$id = $_POST['id'];
	
	// fetching record from db based on id and assigining below into variables which is working as value for 'form' in student.php!
    $query = "SELECT * FROM student WHERE id =?";
    $stmt= $conn->prepare($query);
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $result=$stmt->get_result();
	$row=$result->fetch_assoc();

	$id=$row['id'];
    $reg=$row['registration'];
    $name=$row['name'];
	$phone = $row['phone'];
    $semester = $row['semester'];
    $section = $row['section'];
    $email = $row['email'];
    $gender = $row['gender'];
	$photo = $row['photo'];
	$password = $row['password'];
	$update=true;   //for change submit button of the form at student.php...!
  }
  if(isset($_POST['update'])){
	  $id = $_POST['id'];
	  $reg =$_POST['registration'];
	  $name = $_POST['name'];
	  $phone = $_POST['phone'];
	  $course = $_POST['course'];
	  $branch = $_POST['branch'];
      $semester = $_POST['semester'];
      $section = $_POST['section'];
	  $email = $_POST['email'];
	  $email = filter_var($email,FILTER_SANITIZE_EMAIL);
	  $email = test_input($email);
	  $gender = $_POST['gender'];
	  $oldimage = $_POST['oldimage'];
	  $oldpassword = $_POST['oldpassword'];
	  $pwd = $_POST['password'];

	  $imgtype = strtolower(pathinfo($_FILES['photo']['name'],PATHINFO_EXTENSION));
	  
	  if(!preg_match("/^[a-zA-Z- ']*$/",$name)){
		$_SESSION['error'] = "Name can only contain letters and white space!";
		header('location:student.php');
    }else if(!preg_match("/^\d{10}$/",$reg)){
		$_SESSION['error'] = "Registration no can only contain numberic value!";
		header('location:student.php');
    }else if(!preg_match("/^\d{10}$/",$phone)){
		$_SESSION['error'] = "Phone should contain only 10 digit valid number!";
		header('location:student.php');
    }else if(isset($_FILES['photo']['name']) && ($_FILES['photo']['name']!="") && ($imgtype!="jpg" && $imgtype!="jpeg" && $imgtype!="png")){
		$_SESSION['error'] = "Image should be in ('jpeg','jpg' or'png') only!";
		header('location:student.php');
	  }else if($_FILES['photo']['size'] >= 500000){
		  $_SESSION['error'] = 'Image size should be less than 500KB!';
		  header('location:student.php');
	  }else if(filter_var($email,FILTER_VALIDATE_EMAIL) != TRUE){
		  $_SESSION['error'] = 'Please enter valid email address!';
		  header('location:student.php');
		}
		else{
		  if(isset($_FILES['photo']['name']) && ($_FILES['photo']['name']!="")){
			  $seprated = explode(".",$_FILES['photo']['name']);
			  $newfilename = round(microtime(true)).'.'.end($seprated);
			  $upload = "uploads2/".$newfilename;
			  move_uploaded_file($_FILES['photo']['tmp_name'], $upload);
			  unlink($oldimage);
			}else{
				$upload=$oldimage;
			}
			if(isset($pwd) && ($pwd!="")){
				$password = password_hash($pwd,PASSWORD_BCRYPT);
			}
			else{	
				$password = $oldpassword;
			}
			$query="UPDATE `student` SET `registration`=?,`name`=?,`phone`=?,`semester`=?,`section`=?,`email`=?,`gender`=?, `password`=?,`photo`=? WHERE `id`=? ";
			$stmt=$conn->prepare($query);
			$stmt->bind_param("sssssssssi", $reg,$name,$phone,$semester,$section,$email,$gender,$password,$upload,$id);
			if($stmt->execute()){
				$_SESSION['status'] = 'Successfully Updated!';
				header('location:student.php');
			}
		}
	}

?>