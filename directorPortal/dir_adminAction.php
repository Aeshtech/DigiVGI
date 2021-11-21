<!-- -------------------------------------------------*** JAI SHRI KRISHNA ***--------------------------------------- -->
<?php 
session_start();
if(!$_SESSION['username_director']){
    header('Location: ../index.php');
}
require('../adminstrative/config.php');


// selecting all email exist in the db for prevent redundancy!
$chk_query = "SELECT `email` FROM `admin`";
$chk_result = mysqli_query($conn,$chk_query);

if(($_SERVER['REQUEST_METHOD']=='POST')  && isset($_POST['submit'])){
    $user_type = 'admin';
    $email = $_POST['email'];
    $email = filter_var($email,FILTER_SANITIZE_EMAIL);
    $name = $_POST['name'];
    $course = $_POST['course'];
    $branch = $_POST['branch'];
    $phone = $_POST['phone'];
    $newPwd = $_POST['newPassword'];

    // ------ for check weather any email exist already in the db same as of user's entered if yes then give error mssg. -------//
    while($chk_rows=mysqli_fetch_assoc($chk_result)){
		if($chk_rows['email']==$email){
			$_SESSION['common_mssg'] = "This Email is already registered !!";
			header('location:dir_admin.php');
		break;
		}
	}
    $imgtype = strtolower(pathinfo($_FILES['photo']['name'],PATHINFO_EXTENSION));   //taking extension from file name.
    if($_FILES['photo']['name'] ==""){
        $_SESSION['common_mssg'] = "Please choose a profile photo!";
        header('location:dir_admin.php');
    }else if(isset($_FILES['photo']['name']) && ($_FILES['photo']['name']!="") && ($imgtype!="jpg" && $imgtype!="jpeg" && $imgtype!="png")){
        $_SESSION['common_mssg'] = "Image should be in ('jpeg','jpg' or'png') only!";
        header('location:dir_admin.php');
    }else if($_FILES['photo']['size'] >= 500000){
        $_SESSION['common_mssg'] = 'Image size should be less than 500KB!';
        header('location:dir_admin.php');
    }else if($email==''){
        $_SESSION['common_mssg'] = 'Email-id should not be empty!';
        header('location:dir_admin.php');
    }
    else if(filter_var($email,FILTER_VALIDATE_EMAIL) != TRUE){
        $_SESSION['common_mssg'] = 'Please enter valid email address!';
        header('location:dir_admin.php');
    }else if(!preg_match("/^[a-zA-Z- ']*$/",$name)){
		$_SESSION['common_mssg'] = "Name can only contain letters and white space";
		header('location:dir_admin.php');
    }else if(!preg_match("/^\d{10}$/",$phone)){
		$_SESSION['pcommon_mssg'] = "It should contain only 10 digit valid number!";
		header('location:dir_admin.php');
    }else if($newPwd ==''){
        $_SESSION['common_mssg'] = 'Password should not be empty!';
        header('location:dir_admin.php');
    }else if(strlen($newPwd)<6){
        $_SESSION['common_mssg'] = 'Password length must be altleast six characters!';
        header('location:dir_admin.php');
    }
    // runs only when their is no error exist as defined above.
    elseif($_SESSION['common_mssg']==""){
        $seprated = explode(".",$_FILES['photo']['name']);
        $newfilename = round(microtime(true)).'.'.end($seprated);
        $upload = "uploads_admin/".$newfilename;
        move_uploaded_file($_FILES['photo']['tmp_name'], $upload);

        $password = password_hash($newPwd,PASSWORD_BCRYPT);

        $query = "INSERT INTO `admin`(`name`, `phone`,`course`,`branch`,`email`,`password`,`photo`,`user_type`) VALUES ('$name','$phone','$course','$branch','$email','$password','$upload','$user_type')";
        $result = mysqli_query($conn,$query);
        if(mysqli_affected_rows($conn)){
		    $_SESSION['success_mssg'] = "Successfully assigned a new admin!";
		    header('location:dir_admin.php');
        }
    }
}

function test_input($data){
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($conn,$data);
    return $data;
}

/*------------For deleting record from database--------- */
if(isset($_GET['delete'])){
	$id = $_GET['delete'];
	
	// this will remove photo from uploads directory also.
	$sql = "SELECT `photo` FROM `admin` WHERE `id` = '$id'";
	$result = mysqli_query($conn, $sql);

	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_assoc($result);
		$image = $row['photo'];
		unlink($image);

		// this will delete selected record from database permanently!
		$query2 = "DELETE FROM `admin` WHERE `id`='$id'";
		mysqli_query($conn, $query2);
		if(mysqli_affected_rows($conn)==1){
			$_SESSION['common_mssg'] = 'Successfully Deleted!';
			header('location:dir_admin.php');
		}
    }
}


$update=false;
$id="";
$name="";
$phone="";
$course="";
$branch="";
$email="";
$photo="default.jpg";
$password="";

/*---------------For update record-----------*/


// taking credentials from db to Form for updation.
if(isset($_GET['id'])){
    $id = $_GET['id'];
  
    $query = "SELECT * FROM `admin` WHERE id=?";
    $stmt= $conn->prepare($query);
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $result=$stmt->get_result();
	$row=$result->fetch_assoc();

    $id=$row['id'];
    $name=$row['name'];
    $phone = $row['phone'];
    $course = $row['course'];
    $branch = $row['branch'];
    $email = $row['email'];
	$oldimage = $row['photo'];
	$photo = $row['photo'];
	$password = $row['password'];
    $update=true;   //for change submit button of the form at dir_admin.php...!
  }

//   update credentials on press update button.
if(($_SERVER['REQUEST_METHOD']=='POST')  && isset($_POST['update'])){
    $id =$_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $course = $_POST['course'];
    $branch = $_POST['branch'];
    $email = $_POST['email'];
    $email = filter_var($email,FILTER_SANITIZE_EMAIL);
    $email = test_input($email);
    $oldimage = $_POST['oldimage'];
    $oldpassword = $_POST['oldpassword'];
    $pwd = $_POST['newPassword'];			  

    $imgtype = strtolower(pathinfo($_FILES['photo']['name'],PATHINFO_EXTENSION));
    
    if(!preg_match("/^[a-zA-Z- ']*$/",$name)){
      $_SESSION['common_mssg'] = "Name can only contain letters and white space!";
      header('location:dir_admin.php');
  }else if(!preg_match("/^\d{10}$/",$phone)){
      $_SESSION['common_mssg'] = "Phone should contain only 10 digit valid number!";
      header('location:dir_admin.php');
  }else if(isset($_FILES['photo']['name']) && ($_FILES['photo']['name']!="") && ($imgtype!="jpg" && $imgtype!="jpeg" && $imgtype!="png")){
        $_SESSION['common_mssg'] = "Image should be in ('jpeg','jpg' or'png') only!";
        header('location:dir_admin.php');
      }else if($_FILES['photo']['size'] >= 500000){
          $_SESSION['common_mssg'] = 'Image size should be less than 500KB!';
          header('location:dir_admin.php');
      }else if(filter_var($email,FILTER_VALIDATE_EMAIL) != TRUE){
          $_SESSION['common_mssg'] = 'Please enter valid email address!';
          header('location:dir_admin.php');
      }
      else{
          if(isset($_FILES['photo']['name']) && ($_FILES['photo']['name']!="")){   // checking if file input was taken or not on updation!
              $seprated = explode(".",$_FILES['photo']['name']);
              $newfilename = round(microtime(true)).'.'.end($seprated);
              $upload = "uploads_admin/".$newfilename;
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
          $query3="UPDATE `admin` SET `name`='$name',`phone`='$phone',`course`='$course',`branch`='$branch',`email`= '$email', `password` = '$password',`photo`='$upload' WHERE `id`='$id'";
          mysqli_query($conn,$query3);
          if(mysqli_affected_rows($conn)==1){
              $_SESSION['success_mssg'] = 'Successfully Updated!';
              header('location:dir_admin.php');
          }
      }
  }

?>