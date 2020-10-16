<!-- -------------------------------------------------*** JAI SHRI KRISHNA ***--------------------------------------- -->
<?php 
session_start();
if(!$_SESSION['username_admin'])
{
    header('Location: ../index.php');
}
require('config.php');
$username = $_SESSION['username_admin'];
// ----------------------------For Update profile--------------------------------//

if($_SERVER['REQUEST_METHOD']=='POST'){
    $newPwd = $_POST['newPassword'];
    $confirmPwd = $_POST['confirmPassword'];

    if($newPwd ==''){
        $_SESSION['pwdErr'] = 'Password should not be empty!';
        header('location:adminPrivacy.php');
    }else if(strlen($newPwd)<6){
        $_SESSION['pwdErr'] = 'Password length must be altleast six characters!';
        header('location:adminPrivacy.php');
    }
    else if($confirmPwd == ''){
        $_SESSION['confirmPwdErr'] = 'Confirm password should not be empty!';
        header('location:adminPrivacy.php');
    }else if($confirmPwd != $newPwd){
        $_SESSION['confirmPwdErr'] = 'Password Confirmation does not match!';
        header('location:adminPrivacy.php');
    }else{
        $password = password_hash($confirmPwd,PASSWORD_BCRYPT);

        $query = "UPDATE `admin` SET `password`='$password' WHERE `email`= '$username'";
        $result = mysqli_query($conn,$query);

        if(mysqli_affected_rows($conn)==1){
            $_SESSION['success'] = 'Password updated successfully!';
            header('location:adminPrivacy.php');
        }
    }
}