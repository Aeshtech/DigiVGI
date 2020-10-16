<!-- =======================================================JAI SHREE KRISHNA============================================ -->
<?php 
require("makeAdminAction.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Admin</title>
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
        <!-- <div><h2>Make DigiVgi Admin</h2></div> -->
        <?php
        if(isset($_SESSION['success'])&& $_SESSION['success'] !=''){
            echo "<span style='background:yellow;color:black;'>".$_SESSION['success']."</span>";
            unset($_SESSION['success']);
        }
        if(isset($_SESSION['confirmPwdErr'])&& $_SESSION['confirmPwdErr'] !='')
        {
            echo '<span>'.$_SESSION['confirmPwdErr'].'</span>';
            unset($_SESSION['confirmPwdErr']);
        }
        ?><br>
                

        <img id="output" src="signature.png"><br><br>
            <?php
            if(isset($_SESSION['photoErr'])&& $_SESSION['photoErr'] !='')
            {
            echo '<span>'.$_SESSION['photoErr'].'</span>';
                unset($_SESSION['photoErr']);
            }
            ?><br>

        <form method="POST" action="makeAdminAction.php" enctype="multipart/form-data" >
            <input type="file" name="photo" id="file" onchange="loadfile(event)" style="display: none;"> <!-- input 'file' field display hidden for profile photo, label will work as input element -->
            <div class="label" style="margin:10px auto 20px;">
                <label for="file" style="cursor:pointer;">Choose profile photo</label>
            </div>

            <label>Email*<input type="email" name="email" placeholder="-------Enter Valid Emaill-Id-------"></label><br>
            <?php
            if(isset($_SESSION['emailErr'])&& $_SESSION['emailErr'] !='')
            {
            echo '<span>'.$_SESSION['emailErr'].'</span>';
                unset($_SESSION['emailErr']);
            }
            ?><br>
            <label>Name<input type="text" name="name" placeholder="------Enter New Admin Name------ "></label><br>
            <?php
            if(isset($_SESSION['nameErr'])&& $_SESSION['nameErr'] !='')
            {
            echo '<span>'.$_SESSION['nameErr'].'</span>';
                unset($_SESSION['nameErr']);
            }
            ?><br>
            <label>Phone<input type="text" name="phone" maxlength="10" minlength="10" placeholder="------Enter Phone No------"></label><br>
           <?php
            if(isset($_SESSION['phoneErr'])&& $_SESSION['phoneErr'] !='')
            {
            echo '<span>'.$_SESSION['phoneErr'].'</span>';
                unset($_SESSION['phoneErr']);
            }
            ?><br>
            <label>Gender
                <select name="gender">
                    <option value="Select" selected disabled>Select</option>
                    <option value="female" >Female</option>
                    <option value="male" >Male</option>
                    <option value="not-Defined">Not Defined</option>
                </select>
            </label><br><br> 

            <label style="margin-right: 20px;">Password
            <input type="Password" name="newPassword" placeholder="-------Enter New Password------">
            </label><br>

            <?php
            if(isset($_SESSION['pwdErr'])&& $_SESSION['pwdErr'] !='')
            {
            echo '<span>'.$_SESSION['pwdErr'].'</span>';
                unset($_SESSION['pwdErr']);
            }
            ?><br>

            <label style="margin-right:80px;">Confirm Password
            <input type="Password" name="confirmPassword" placeholder="-------Confirm New Password------">
            </label><br>

            <input type="submit" value="Make Admin" name="makeAdmin" onclick="return confirm('Please make sure all credentials are correct!!')">
        </form>
    </div>
    

   

    <script>
    var loadfile = function(event) {
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
    };

    function goBack(){
        window.history.back();
    }
    </script>
</body>
</html> 