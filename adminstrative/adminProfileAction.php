<!-- -------------------------------------------------*** JAI SHRI KRISHNA ***--------------------------------------- -->
<?php 
session_start();
if(!$_SESSION['username_admin'])
{
    header('Location: ../index.php');
}
require('config.php');
$username = $_SESSION['username_admin'];
$query = "SELECT * FROM `admin` WHERE `email`='$username'";
$result  = mysqli_query($conn,$query);
if(mysqli_num_rows($result)==1){
    $row = mysqli_fetch_assoc($result);
    $id = $row['id'];
    $photo = $row['photo'];
    $email = $row['email'];
    $name = $row['name'];   
    $phone = $row['phone'];

}

// ----------------------------For Update profile--------------------------------//

if($_SERVER['REQUEST_METHOD']=='POST'){
    $id = $_POST['id'];
    $oldimage = $_POST['oldimage'];
    $email = $_POST['email'];
    $email = filter_var($email,FILTER_SANITIZE_EMAIL);
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    $imgtype = strtolower(pathinfo($_FILES['photo']['name'],PATHINFO_EXTENSION));   //taking extension from file name.
    if(isset($_FILES['photo']['name']) && ($_FILES['photo']['name']!="") && ($imgtype!="jpg" && $imgtype!="jpeg" && $imgtype!="png")){
        $_SESSION['photoErr'] = "Image should be in ('jpeg','jpg' or'png') only!";
        header('location:adminProfile.php');
    }else if($_FILES['photo']['size'] >= 500000){
        $_SESSION['photoErr'] = 'Image size should be less than 500KB!';
        header('location:adminProfile.php');
    }else if(!preg_match("/^[a-zA-Z- ']*$/",$name)){
		$_SESSION['nameErr'] = "Only letters and white space allowed!";
		header('location:adminProfile.php');
    }
    else if(!preg_match("/^\d{10}$/",$phone)){
		$_SESSION['phoneErr'] = "It should contain only 10 digit valid number!";
		header('location:adminProfile.php');
    }else if(filter_var($email,FILTER_VALIDATE_EMAIL) != TRUE){
        $_SESSION['emailErr'] = 'Please enter valid email address!';
        header('location:adminProfile.php');
      }else{
        if(isset($_FILES['photo']['name']) && ($_FILES['photo']['name']!="")){   // checking if file input was taken or not on updation!
            $seprated = explode(".",$_FILES['photo']['name']);
            $newfilename = round(microtime(true)).'.'.end($seprated);
            $upload = "uploads3/".$newfilename;
            unlink("../adminstrative/".$oldimage);
            move_uploaded_file($_FILES['photo']['tmp_name'], $upload);
        }
        else{
            $upload=$oldimage;
        }
        $query = "UPDATE `admin` SET `name`='$name',`email`='$email',`phone`='$phone',`photo`='$upload' WHERE `id`= '$id'";
        $result = mysqli_query($conn,$query);
        if(mysqli_affected_rows($conn)){
		    $_SESSION['success'] = "Profile updated successfully!";
		    header('location:adminProfile.php');
        }
        if($email != $username){
            session_destroy();
            header('location:../index.php');
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