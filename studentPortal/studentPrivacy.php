<!-- =======================================================JAI SHREE KRISHNA============================================ -->
<?php 
session_start();
if(!$_SESSION['username_student'])
{
    header('Location: ../index.php');
}
require('../adminstrative/config.php');
$username = $_SESSION['username_student'];
// ----------------------------For Update profile--------------------------------//

if($_SERVER['REQUEST_METHOD']=='POST'){
    $newPwd = $_POST['newPassword'];
    $confirmPwd = $_POST['confirmPassword'];

    if($newPwd ==''){
        $_SESSION['pwdErr'] = 'Password should not be empty!';
        header('location:studentPrivacy.php');
    }else if(strlen($newPwd)<6){
        $_SESSION['pwdErr'] = 'Password length must be altleast six characters!';
    }
    else if($confirmPwd == ''){
        $_SESSION['confirmPwdErr'] = 'Confirm password should not be empty!';
    }else if($confirmPwd != $newPwd){
        $_SESSION['confirmPwdErr'] = 'Password Confirmation does not match!';
    }else{
        $password = password_hash($confirmPwd,PASSWORD_BCRYPT);

        $query = "UPDATE `student` SET `password`='$password' WHERE `email`= '$username'";
        $result = mysqli_query($conn,$query);

        if(mysqli_affected_rows($conn)==1){
            $_SESSION['success'] = 'Password updated successfully!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="../digivgi_styles.css">
</head>
<body class="profile_bg">
<?php require('stu_header.php'); ?>
<div class="navBottom"></div>

    <div class="update_profile" style="margin-top: 5%;">
    <a href="index.php" class="back_btn">Back</a>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" autocomplete="off" >
        <br><h2 style="margin-top: 5vh;">Change Password</h2>

            <?php
            if(isset($_SESSION['success'])&& $_SESSION['success'] !='')
            {
            echo '<span style="color:black;background:chartreuse;border-radius: 5px;">'.$_SESSION['success'].'</span>';
                unset($_SESSION['success']);
            }
            ?>
            <br>

            <div class="update_privacy">
            <label>New Password
                <input type="Password" name="newPassword">
            </label><br>

            <?php
            if(isset($_SESSION['pwdErr'])&& $_SESSION['pwdErr'] !='')
            {
            echo '<b>'.$_SESSION['pwdErr'].'</b>';
                unset($_SESSION['pwdErr']);
            }
            ?><br><br>

            <label>Confirm Password
                <input type="Password" name="confirmPassword">
            </label<br><br>

            <?php
            if(isset($_SESSION['confirmPwdErr'])&& $_SESSION['confirmPwdErr'] !='')
            {
            echo '<b>'.$_SESSION['confirmPwdErr'].'</b>';
                unset($_SESSION['confirmPwdErr']);
            }
            ?><br>

            </div>

            <input type="submit" value="Update" name="update" onclick="return confirm('Are you sure ?')">
        </form>
    </div>
    

   
</body>
</html>