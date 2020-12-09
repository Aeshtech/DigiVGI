<!-- =======================================================JAI SHREE KRISHNA============================================ -->
<?php 
require("adminPrivacyAction.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="styles/V2.css">
    <style>
        .update_profile{
            margin-top: 10vh;
        }
        .update_profile input{
            width: 35%;
        }
    </style>
</head>
<body>

<!-- ==============================DigiVGI-Header================= -->
<header>
    <div class="logodiv">
        <a><img src="vgi-logo.jpg" id="logo"></a>
        <h1>Digi VGI</h1>
    </div>
</header>

<body>

    <div class="update_profile">
        <a class="back_btn" href="index.php">Go Back</a>
        <?php
            if(isset($_SESSION['success'])&& $_SESSION['success'] !='')
            {
            echo '<span style="background:greenyellow;color:black;">'.$_SESSION['success'].'</span>';
                unset($_SESSION['success']);
            }
            ?>
            <br>

        <form method="POST" action="adminPrivacyAction.php" autocomplete="off" >
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
    
    </body>
</html>