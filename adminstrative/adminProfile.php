<!-- =======================================================JAI SHREE KRISHNA============================================ -->
<?php 
require("adminProfileAction.php");
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
        <h1>Digi VGI</h1>
    </div>
</header>

<body class="profile_bg">

    <div class="update_profile">
        <button onclick="goBack()">Go Back</button>
        <?php
            if(isset($_SESSION['success'])&& $_SESSION['success'] !='')
            {
            echo "<span style='background:yellow;color:black;'>".$_SESSION['success']."</span>";
                unset($_SESSION['success']);
            }
            ?>
            <br>

        <img id="output" src="../adminstrative/<?php echo $photo; ?>"><br><br>
            <?php
            if(isset($_SESSION['photoErr'])&& $_SESSION['photoErr'] !='')
            {
            echo '<span>'.$_SESSION['photoErr'].'</span>';
                unset($_SESSION['photoErr']);
            }
            ?><br>

        <form method="POST" action="adminProfileAction.php" enctype="multipart/form-data" >
            <input type="hidden" name="id" value="<?= $id ?>" >
            <input type="hidden" name="oldimage" value="<?php echo $photo; ?>">   <!-------for unlink oldimage on update operation----------->
            <input type="file" name="photo" id="file" onchange="loadfile(event)" style="display: none;"> 

            <!-- above input 'file' display hidden and label will work as input element -->
            <div class="label" style="margin:10px auto 20px;">
                <label for="file" style="cursor:pointer;">Change your profile photo</label>
            </div>

            <label>Email*<input type="email" name="email" value="<?php echo $email; ?>"></label><br>
            <?php
            if(isset($_SESSION['emailErr'])&& $_SESSION['emailErr'] !='')
            {
            echo '<span>'.$_SESSION['emailErr'].'</span>';
                unset($_SESSION['emailErr']);
            }
            ?><br>
            <label>Name<input type="text" name="name" value="<?php echo $name;?>"></label><br>
            <?php
            if(isset($_SESSION['nameErr'])&& $_SESSION['nameErr'] !='')
            {
            echo '<span>'.$_SESSION['nameErr'].'</span>';
                unset($_SESSION['nameErr']);
            }
            ?><br>
            <label>Phone<input type="text" name="phone" value="<?php echo $phone;?>" maxlength="10" minlength="10" placeholder="Phone no."></label><br>
           <?php
            if(isset($_SESSION['phoneErr'])&& $_SESSION['phoneErr'] !='')
            {
            echo '<span>'.$_SESSION['phoneErr'].'</span>';
                unset($_SESSION['phoneErr']);
            }
            ?><br>   

            <input type="submit" value="Update" name="update" onclick="return confirm('Please make sure all credentials are correct!!')">
        </form>
    </div>
    
    <div class="admin-profile-note">
        <h2>Remember</h2>
        <p>If you try to successfully change your email than you will be redirected to login page, and you have login again with your new email ! </p>
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