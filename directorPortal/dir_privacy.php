<!-- =======================================================JAI SHREE KRISHNA============================================ -->
<?php
require("template.php");
require('../adminstrative/config.php');
$username = $_SESSION['username_director'];

// ----------------------------For Update director Privacy--------------------------------//

if($_SERVER['REQUEST_METHOD']=='POST'){
    $newPwd = $_POST['newPassword'];
    $confirmPwd = $_POST['confirmPassword'];

    if($newPwd ==''){
        $_SESSION['pwdErr'] = 'Password should not be empty!';
    }else if(strlen($newPwd)<6){
        $_SESSION['pwdErr'] = 'Password length must be altleast six characters!';
    }
    else if($confirmPwd == ''){
        $_SESSION['confirmPwdErr'] = 'Confirm password should not be empty!';
    }else if($confirmPwd != $newPwd){
        $_SESSION['confirmPwdErr'] = 'Password Confirmation does not match!';
    }else{
        $password = password_hash($confirmPwd,PASSWORD_BCRYPT);

        $query = "UPDATE `director` SET `password`='$password' WHERE `email`= '$username'";
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
    <title>Director Privacy</title>
    <link rel="stylesheet" type="text/css" href="../adminstrative/styles/V2.css">
    <style>
        
        .update_profile input{
            width: 35%;
        }
    </style>
</head>
<body>
<div id="dir_main">
<div class="update_profile" style="margin-top: 10vh;">
        <?php
            if(isset($_SESSION['success'])&& $_SESSION['success'] !='')
            {
            echo '<span style="background:greenyellow;color:black;">'.$_SESSION['success'].'</span>';
                unset($_SESSION['success']);
            }
            ?>
            <br>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" autocomplete="off" >
            <div class="label" style="margin:10px auto 80px;">
                <h1>***Change Password***</h1>
            </div>
            <div class="update_privacy">
            <input type="Password" name="newPassword" placeholder="-------Enter New Password------" required><br>

            <?php
            if(isset($_SESSION['pwdErr'])&& $_SESSION['pwdErr'] !='')
            {
            echo '<span>'.$_SESSION['pwdErr'].'</span>';
                unset($_SESSION['pwdErr']);
            }
            ?><br>

            <input type="Password" name="confirmPassword" placeholder="-------Confirm New Password------" required><br>

            <?php
            if(isset($_SESSION['confirmPwdErr'])&& $_SESSION['confirmPwdErr'] !='')
            {
            echo '<span>'.$_SESSION['confirmPwdErr'].'</span>';
                unset($_SESSION['confirmPwdErr']);
            }
            ?><br>

            </div>

            <input type="submit" value="Update" name="update" onclick="return confirm('Are you sure ?')">
        </form>
    </div>
</div>
</body>
</html>