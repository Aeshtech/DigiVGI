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
</head>
<body>

<!-- ==============================DigiVGI-Header================= -->
<header>
    <div class="logodiv">
        <!-- <a><img src="vgi-logo.jpg" id="logo"></a> -->
        <h1>Digi VGI</h1>
    </div>
</header>

<body class="profile_bg">

    <div class="update_profile">
        <button onclick="goBack()">Go Back</button>
        <?php
            if(isset($_SESSION['success'])&& $_SESSION['success'] !='')
            {
            echo '<span style="background:yellow;color:var(--primary);">'.$_SESSION['success'].'</span>';
                unset($_SESSION['success']);
            }
            ?>
            <br>

        <form method="POST" action="adminPrivacyAction.php" autocomplete="off" >
            <div class="label" style="margin:10px auto 80px;">
                <h1>***Change Password***</h1>
            </div>
            <div class="update_privacy">
            <input type="Password" name="newPassword" placeholder="-------Enter New Password------"><br>

            <?php
            if(isset($_SESSION['pwdErr'])&& $_SESSION['pwdErr'] !='')
            {
            echo '<span>'.$_SESSION['pwdErr'].'</span>';
                unset($_SESSION['pwdErr']);
            }
            ?><br>

            <input type="Password" name="confirmPassword" placeholder="-------Confirm New Password------"><br>

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
    

   

    <script>

    function goBack(){
        window.history.back();
    }
    </script>
    </body>
</html>