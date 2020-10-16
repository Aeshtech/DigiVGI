<!-- ===================================================================JAI SHREE KRISHNA=================================================== -->
<?php
session_start();
if(!$_SESSION['username_admin'])
{
    header('Location: ../index.php');
}
require("config.php");
$update=false;
$id="";
$name="";
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
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
	$email = $_POST['email'];
	$email = filter_var($email,FILTER_SANITIZE_EMAIL);
	$email = test_input($email);
	$pwd = trim($_POST['password']);
	$password = password_hash($pwd,PASSWORD_BCRYPT);

	$imagetype = strtolower(pathinfo($_FILES['photo']['name'],PATHINFO_EXTENSION));    //taking extension from file name.

	if(!preg_match("/^[a-zA-Z- ']*$/",$name)){
		$_SESSION['error'] = "Name can only contain letters and white space!";
		header('location:faculty.php');
    }
    else if(!preg_match("/^\d{10}$/",$phone)){
		$_SESSION['error'] = "Phone should contain only 10 digit valid number!";
		header('location:faculty.php');
    }else if(isset($pwd) && ($pwd=="")){
		$_SESSION['error'] = "Password should not be empty!!";
		header('location:faculty.php');
	}else if(strlen($pwd)<6){
		$_SESSION['error'] = "Password must include atleast six characters!";
		header('location:faculty.php');
	}else if(isset($email) && ($email=="")){
		$_SESSION['error'] = "Email should not be empty!!";
		header('location:faculty.php');
	}else if(filter_var($email,FILTER_VALIDATE_EMAIL) != TRUE){
		$_SESSION['error'] = 'Please enter valid email address!';
		header('location:faculty.php');
	}
	else if($imagetype!="jpg" && $imagetype!="jpeg" && $imagetype!="png"){
		$_SESSION['error'] = "Image should be in ('jpeg','jpg' or'png') only!";
		header('location:faculty.php');
	}
	else if($_FILES['photo']['size'] >= 500000){
		$_SESSION['error'] = 'Image size should be less than 500KB!';
		header('location:faculty.php');
	}else{
		$seprated = explode(".",$_FILES['photo']['name']);          //this will fetch name of the file from the $_FILES array and separate its by '.' period.
	    $newfilename = round(microtime(true)).'.'.end($seprated);  // this will generate a random no by microtime & round function and concenate it with extension taking by end() function from seprated filename! Use this to give each image file a unique name.
		
		$upload = "uploads/".$newfilename;          // assigning the path to variable.
		$tempname = $_FILES['photo']['tmp_name'];  //this will fetch temporary name of the file from the $_FILES array..!
		
		$query = "INSERT INTO `faculty`(`name`,`phone`,`gender`,`email`,`password`,`photo`,`user_type`)VALUES('$name','$phone','$gender','$email','$password','$upload','$user_type')";
		$result=mysqli_query($conn,$query);
		if($result){
		    $_SESSION['status'] = 'Successfully Inserted!';
		    move_uploaded_file($tempname,$upload);
			header('location:faculty.php');
		}
		
	}
}


/*------------For deleting record from database--------- */
if(isset($_GET['delete'])){
	$id = $_GET['delete'];
	
	// this will remove photo from uploads directory also.
	$sql = "select photo from faculty where id = ".$id;
	$result = mysqli_query($conn, $sql);

	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_assoc($result);
		$image = $row['photo'];
		unlink($image);

		// this will delete selected record from database permanently!
		$sql = "delete from faculty where id=$id";
		if(mysqli_query($conn, $sql)){
			$_SESSION['status'] = 'Successfully Deleted!';
			header('location:faculty.php');
		}
	}
}

/*---------------For update record-----------*/


// taking credentials from db to Form for updation.
  if(isset($_GET['id'])){
    $id = $_GET['id'];
  
    $query = "SELECT * FROM faculty WHERE id=?";
    $stmt= $conn->prepare($query);
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $result=$stmt->get_result();
	$row=$result->fetch_assoc();

    $id=$row['id'];
    $name=$row['name'];
    $phone = $row['phone'];
    $gender = $row['gender'];
    $email = $row['email'];
	$photo = $row['photo'];
	$password = $row['password'];
	$update=true;   //for change submit button of the form at faculty.php...!
  }

//   update credentials on press update button.
  if(isset($_POST['update'])){
	  $id =$_POST['id'];
	  $name = $_POST['name'];
	  $phone = $_POST['phone'];
	  $gender = $_POST['gender'];
	  $email = $_POST['email'];
	  $email = filter_var($email,FILTER_SANITIZE_EMAIL);
	  $email = test_input($email);
	  $oldimage = $_POST['oldimage'];
	  $oldpassword = $_POST['oldpassword'];
	  $pwd = $_POST['password'];			  

	  $imgtype = strtolower(pathinfo($_FILES['photo']['name'],PATHINFO_EXTENSION));
	  
	  if(!preg_match("/^[a-zA-Z- ']*$/",$name)){
		$_SESSION['error'] = "Name can only contain letters and white space!";
		header('location:faculty.php');
    }else if(!preg_match("/^\d{10}$/",$phone)){
		$_SESSION['error'] = "Phone should contain only 10 digit valid number!";
		header('location:faculty.php');
    }else if(isset($_FILES['photo']['name']) && ($_FILES['photo']['name']!="") && ($imgtype!="jpg" && $imgtype!="jpeg" && $imgtype!="png")){
		  $_SESSION['error'] = "Image should be in ('jpeg','jpg' or'png') only!";
		  header('location:faculty.php');
		}else if($_FILES['photo']['size'] >= 500000){
			$_SESSION['error'] = 'Image size should be less than 500KB!';
			header('location:faculty.php');
		}else if(filter_var($email,FILTER_VALIDATE_EMAIL) != TRUE){
			$_SESSION['error'] = 'Please enter valid email address!';
			header('location:faculty.php');
		}
		else{
			if(isset($_FILES['photo']['name']) && ($_FILES['photo']['name']!="")){   // checking if file input was taken or not on updation!
				$seprated = explode(".",$_FILES['photo']['name']);
		        $newfilename = round(microtime(true)).'.'.end($seprated);
		        $upload = "uploads/".$newfilename;
		        unlink($oldimage);
				move_uploaded_file($_FILES['photo']['tmp_name'], $upload);
			}else{
				$upload=$oldimage;
			}
			if(isset($pwd) && ($pwd!="")){
				$password = password_hash($pwd,PASSWORD_BCRYPT);
			}
			else{	
				$password = $oldpassword;
			}
			$query="UPDATE `faculty` SET `name`=?,`phone`=?,`gender`=?,`email`= ?, `password` = ?,`photo`=? WHERE `id`=? ";
			$stmt=$conn->prepare($query);
			$stmt->bind_param("ssssssi", $name,$phone,$gender,$email,$password,$upload,$id);
			if($stmt->execute()){
				$_SESSION['status'] = 'Successfully Updated!';
				header('location:faculty.php');
			}
		}
	}	  
?>