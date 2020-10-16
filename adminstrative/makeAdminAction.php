<!-- -------------------------------------------------*** JAI SHRI KRISHNA ***--------------------------------------- -->
<?php 
session_start();
if(!$_SESSION['username_admin'])
{
    header('Location: ../index.php');
}
require('config.php');
$username = $_SESSION['username_admin'];


// ----------------------------For Add DigiVgi Admin profile--------------------------------//

if($_SERVER['REQUEST_METHOD']=='POST'){
    $user_type = 'admin';
    $email = $_POST['email'];
    $email = filter_var($email,FILTER_SANITIZE_EMAIL);
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $newPwd = $_POST['newPassword'];
    $confirmPwd = $_POST['confirmPassword'];

    $imgtype = strtolower(pathinfo($_FILES['photo']['name'],PATHINFO_EXTENSION));   //taking extension from file name.
    if($_FILES['photo']['name'] ==""){
        $_SESSION['photoErr'] = "Please choose a profile photo!";
        header('location:makeAdmin.php');
    }else if(isset($_FILES['photo']['name']) && ($_FILES['photo']['name']!="") && ($imgtype!="jpg" && $imgtype!="jpeg" && $imgtype!="png")){
        $_SESSION['photoErr'] = "Image should be in ('jpeg','jpg' or'png') only!";
        header('location:makeAdmin.php');
    }else if($_FILES['photo']['size'] >= 500000){
        $_SESSION['photoErr'] = 'Image size should be less than 500KB!';
        header('location:makeAdmin.php');
    }else if($email==''){
        $_SESSION['emailErr'] = 'Email-id should not be empty!';
        header('location:makeAdmin.php');
    }
    else if(filter_var($email,FILTER_VALIDATE_EMAIL) != TRUE){
        $_SESSION['emailErr'] = 'Please enter valid email address!';
        header('location:makeAdmin.php');
    }else if(!preg_match("/^[a-zA-Z- ']*$/",$name)){
		$_SESSION['nameErr'] = "Only letters and white space allowed!";
		header('location:makeAdmin.php');
    }else if(!preg_match("/^\d{10}$/",$phone)){
		$_SESSION['phoneErr'] = "It should contain only 10 digit valid number!";
		header('location:makeAdmin.php');
    }else if($newPwd ==''){
        $_SESSION['pwdErr'] = 'Password should not be empty!';
        header('location:makeAdmin.php');
    }else if(strlen($newPwd)<6){
        $_SESSION['pwdErr'] = 'Password length must be altleast six characters!';
        header('location:makeAdmin.php');
    }
    else if($confirmPwd == ''){
        $_SESSION['confirmPwdErr'] = 'Confirm password should not be empty!';
        header('location:makeAdmin.php');
    }else if($confirmPwd != $newPwd){
        $_SESSION['confirmPwdErr'] = 'Password Confirmation does not match!';
        header('location:makeAdmin.php');
    }
    else{
        $seprated = explode(".",$_FILES['photo']['name']);
        $newfilename = round(microtime(true)).'.'.end($seprated);
        $upload = "uploads3/".$newfilename;
        move_uploaded_file($_FILES['photo']['tmp_name'], $upload);
        $password = password_hash($confirmPwd,PASSWORD_BCRYPT);
        $query = "INSERT INTO `admin`(`name`, `phone`, `gender`, `email`, `password`, `photo`, `user_type`) VALUES ('$name','$phone','$gender','$email','$password','$upload','$user_type')";
        $result = mysqli_query($conn,$query);
        if(mysqli_affected_rows($conn)){
		    $_SESSION['success'] = "Successfully assigned a new admin!";
		    header('location:makeAdmin.php');
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
?>
<div style="background:red;color:white;text-align:center;"><h1>Access Denied!</h1></div>