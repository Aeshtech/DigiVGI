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
    $oldimage = $_POST['oldimage'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    $imgtype = strtolower(pathinfo($_FILES['photo']['name'],PATHINFO_EXTENSION));   //taking extension from file name.
    if(isset($_FILES['photo']['name']) && ($_FILES['photo']['name']!="") && ($imgtype!="jpg" && $imgtype!="jpeg" && $imgtype!="png")){
        $_SESSION['photoErr'] = "Image should be in ('jpeg','jpg' or'png') only!";
    }else if($_FILES['photo']['size'] >= 500000){
        $_SESSION['photoErr'] = 'Image size should be less than 500KB!';
    }else if(!preg_match("/^[a-zA-Z- ']*$/",$name)){
		$_SESSION['nameErr'] = "Only letters and white space allowed!";
    }
    else if(!preg_match("/^\d{10}$/",$phone)){
		$_SESSION['phoneErr'] = "It should contain only 10 digit valid number!";
    }
    else{
        if(isset($_FILES['photo']['name']) && ($_FILES['photo']['name']!="")){   // checking if file input was taken or not on updation!
            $seprated = explode(".",$_FILES['photo']['name']);
            $newfilename = round(microtime(true)).'.'.end($seprated);
            $upload = "uploads_faculty/".$newfilename;
            $path = "../directorPortal/uploads_faculty/".$newfilename;
            unlink("../directorPortal/".$oldimage);
            move_uploaded_file($_FILES['photo']['tmp_name'], $path);
        }
        else{
            $upload=$oldimage;
        }
        $query = "UPDATE `faculty` SET `name`='$name',`phone`='$phone',`photo`='$upload' WHERE `email`='$username'";
        $result = mysqli_query($conn,$query);
        if(mysqli_affected_rows($conn)){
		    $_SESSION['success'] = "Profile updated successfully!";
        }
    }
}

function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}  

$query = "SELECT * FROM `faculty` WHERE `email`='$username'";
$result  = mysqli_query($conn,$query);
if(mysqli_num_rows($result)==1){
    $row = mysqli_fetch_assoc($result);
    $photo = $row['photo'];
    $email = $row['email'];
    $name = $row['name'];
    $phone = $row['phone'];
}
require('header.php');
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
    <div style="margin-top:60px;background:none;height:1px;"></div>

    <div class="update_profile">
        <a href="index.php" class="back_btn">Back</a>
        <span>
        <?php
            if(isset($_SESSION['success'])&& $_SESSION['success'] !='')
            {
            echo '<span style="color:black;background:chartreuse;border-radius: 5px;">'.$_SESSION['success'].'</span>';
                unset($_SESSION['success']);
            }
            ?>
        </span><br>

        <img id="output" src="../directorPortal/<?php echo $photo; ?>"><br>
            <?php
            if(isset($_SESSION['photoErr'])&& $_SESSION['photoErr'] !='')
            {
            echo '<b>'.$_SESSION['photoErr'].'</b>';
                unset($_SESSION['photoErr']);
            }
            ?><br>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data" >
            <input type="hidden" name="oldimage" value="<?php echo $photo; ?>">   <!-------for unlink oldimage on update operation----------->
            <input type="file" name="photo" id="file" onchange="loadfile(event)" style="display: none;"> <!-- input 'file' field display hidden for profile photo, label will work as input element -->
            <div class="label" style="margin:10px auto 20px;">
                <label for="file">Choose your profile photo</label>
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
            
            <input type="submit" value="Update" name="update">
        </form>
    </div>
    

   

    <script type="text/javascript">
    var loadfile = function(event) {
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
    };
    
    function stopRKey(evt) {
        var evt = (evt) ? evt : ((event) ? event : null);
        var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
        if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
        }
        
    document.onkeypress = stopRKey;

    if(window.history.replaceState){
        window.history.replaceState(null,null,window.location.href);
    }
    </script>
</body>

</html>