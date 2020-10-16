<!-- -------------------------------------------------*** JAI SHRI KRISHNA ***--------------------------------------- -->
<?php 
session_start();
if(!$_SESSION['username_student'])
{
    header('Location: ../index.php');
}
require('../adminstrative/config.php');
$username = $_SESSION['username_student'];
$query = "SELECT * FROM `student` WHERE `email`='$username'";
$result  = mysqli_query($conn,$query);
if(mysqli_num_rows($result)==1){
    $row = mysqli_fetch_assoc($result);
    $photo = $row['photo'];
    $email = $row['email'];
    $name = $row['name'];
    $phone = $row['phone'];
    $gender = $row['gender'];

}

// ----------------------------For Update profile--------------------------------//

if($_SERVER['REQUEST_METHOD']=='POST'){
    $oldimage = $_POST['oldimage'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];

    $imgtype = strtolower(pathinfo($_FILES['photo']['name'],PATHINFO_EXTENSION));   //taking extension from file name.
    if(isset($_FILES['photo']['name']) && ($_FILES['photo']['name']!="") && ($imgtype!="jpg" && $imgtype!="jpeg" && $imgtype!="png")){
        $_SESSION['photoErr'] = "Image should be in ('jpeg','jpg' or'png') only!";
        header('location:studentProfile.php');
    }else if($_FILES['photo']['size'] >= 500000){
        $_SESSION['photoErr'] = 'Image size should be less than 500KB!';
        header('location:studentProfile.php');
    }else if(!preg_match("/^[a-zA-Z- ']*$/",$name)){
		$_SESSION['nameErr'] = "Only letters and white space allowed!";
		header('location:studentProfile.php');
    }
    else if(!preg_match("/^\d{10}$/",$phone)){
		$_SESSION['phoneErr'] = "It should contain only 10 digit valid number!";
		header('location:studentProfile.php');
    }
    else{
        if(isset($_FILES['photo']['name']) && ($_FILES['photo']['name']!="")){   // checking if file input was taken or not on updation!
            $seprated = explode(".",$_FILES['photo']['name']);
            $newfilename = round(microtime(true)).'.'.end($seprated);
            $path = "../adminstrative/uploads2/".$newfilename;   //faculty uploads folder path.
            $upload = "uploads2/".$newfilename;
            unlink("../adminstrative/".$oldimage);
            move_uploaded_file($_FILES['photo']['tmp_name'], $path);
        }
        else{
            $upload=$oldimage;
        }
        $query = "UPDATE `student` SET `name`='$name',`phone`='$phone',`gender`='$gender',`photo`='$upload' WHERE `email`='$username'";
        $result = mysqli_query($conn,$query);
        if(mysqli_affected_rows($conn)){
		    $_SESSION['success'] = "Profile updated successfully!";
		    header('location:studentProfile.php');
        }
    }
}

function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>