<!-- =======================================================JAI SHREE KRISHNA============================================ -->
<?php 
require("facultyPrivacyAction.php");
require('header.php');
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
<div class="navBottom"></div>

    <div class="update_profile" style="margin-top: 5%;">
    <button onclick="goBack()">Back</button>

        <form method="POST" action="facultyPrivacyAction.php" autocomplete="off" >
            <div class="label" style="margin:10px auto 35px;">
                <h2>Change Password</h2>
            </div>

            <?php
            if(isset($_SESSION['success'])&& $_SESSION['success'] !='')
            {
            echo '<span style="color:black;background:chartreuse;border-radius: 5px;">'.$_SESSION['success'].'</span>';
                unset($_SESSION['success']);
            }
            ?>
            <br><br>

            <div class="update_privacy">
            <label>New Password<br>
                <input type="Password" name="newPassword">
            </label><br>

            <?php
            if(isset($_SESSION['pwdErr'])&& $_SESSION['pwdErr'] !='')
            {
            echo '<b>'.$_SESSION['pwdErr'].'</b>';
                unset($_SESSION['pwdErr']);
            }
            ?><br><br>

            <label>Confirm Password<br>
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
    

   

    <script>

    function goBack(){
        window.history.back();
    }
    </script>
</body>
</html>