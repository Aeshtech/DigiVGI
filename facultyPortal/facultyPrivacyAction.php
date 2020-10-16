<!-- -------------------------------------------------*** JAI SHRI KRISHNA ***--------------------------------------- -->
<?php 
session_start();
if(!$_SESSION['username_faculty'])
{
    header('Location: ../index.php');
}
require('../adminstrative/config.php');
$username = $_SESSION['username_faculty'];
// ----------------------------For Update profile--------------------------------//

if($_SERVER['REQUEST_METHOD']=='POST'){
    $newPwd = $_POST['newPassword'];
    $confirmPwd = $_POST['confirmPassword'];

    if($newPwd ==''){
        $_SESSION['pwdErr'] = 'Password should not be empty!';
        header('location:facultyPrivacy.php');
    }else if(strlen($newPwd)<6){
        $_SESSION['pwdErr'] = 'Password length must be altleast six characters!';
        header('location:facultyPrivacy.php');
    }
    else if($confirmPwd == ''){
        $_SESSION['confirmPwdErr'] = 'Confirm password should not be empty!';
        header('location:facultyPrivacy.php');
    }else if($confirmPwd != $newPwd){
        $_SESSION['confirmPwdErr'] = 'Password Confirmation does not match!';
        header('location:facultyPrivacy.php');
    }else{
        $password = password_hash($confirmPwd,PASSWORD_BCRYPT);

        $query = "UPDATE `faculty` SET `password`='$password' WHERE `email`= '$username'";
        $result = mysqli_query($conn,$query);

        if(mysqli_affected_rows($conn)==1){
            $_SESSION['success'] = 'Password updated successfully!';
            header('location:facultyPrivacy.php');
        }
    }
}