<!-- -------------------------------------------------*** JAI SHRI KRISHNA ***--------------------------------------- -->
<?php
require('studentProfileAction.php');   
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update your profile</title>
    <link rel="stylesheet" href="../digivgi_styles.css">
</head>
<body class="profile_bg">
<?php require('stu_header.php'); ?>

    <div style="margin-top:60px;background:none;height:1px;"></div>

    <div class="update_profile">
        <button onclick="goBack()">Back</button>
        <span>
        <?php
            if(isset($_SESSION['success'])&& $_SESSION['success'] !='')
            {
            echo '<span style="color:black;background:chartreuse;border-radius: 5px;">'.$_SESSION['success'].'</span>';
                unset($_SESSION['success']);
            }
            ?>
        </span><br>

        <img id="output" src="../adminstrative/<?php echo $photo; ?>"
            style="width:80px;height:80px;border-radius:50%;border:2px solid white;"><br>
            <?php
            if(isset($_SESSION['photoErr'])&& $_SESSION['photoErr'] !='')
            {
            echo '<b>'.$_SESSION['photoErr'].'</b>';
                unset($_SESSION['photoErr']);
            }
            ?><br>

        <form method="POST" action="studentProfileAction.php" enctype="multipart/form-data" >
            <input type="hidden" name="oldimage" value="<?php echo $photo; ?>">   <!-------for unlink oldimage on update operation----------->
            <input type="file" name="photo" id="file" onchange="loadfile(event)" style="display: none;"> <!-- input 'file' field display hidden for profile photo, label will work as input element -->
            <div class="label" style="margin:10px auto 20px;">
                <label for="file">Change your profile photo</label>
            </div>

            <label>Email*<input type="text" readonly value="<?php echo $email; ?>"></label><br>
            <label>Name<input type="text" name="name" value="<?php echo $name;?>"></label><br>
            <?php
            if(isset($_SESSION['nameErr'])&& $_SESSION['nameErr'] !='')
            {
            echo '<b>'.$_SESSION['nameErr'].'</b>';
                unset($_SESSION['nameErr']);
            }
            ?><br>
            <label>Phone<input type="text" name="phone" value="<?php echo $phone;?>" maxlength="10" minlength="10" placeholder="Phone no."></label><br>
           <?php
            if(isset($_SESSION['phoneErr'])&& $_SESSION['phoneErr'] !='')
            {
            echo '<b>'.$_SESSION['phoneErr'].'</b>';
                unset($_SESSION['phoneErr']);
            }
            ?><br>
            <label>Gender
                <select name="gender">
                    <option value="female" <?php if($gender=='female'){echo "selected";}?>>Female</option>
                    <option value="male" <?php if($gender=='male'){echo "Selected";}?> >Male</option>
                    <option value="not-Defined" <?php if($gender=='not-defined'){echo "selected";}?>>Not Defined</option>
                </select>
            </label>
            
            <input type="submit" value="Update" name="update">
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