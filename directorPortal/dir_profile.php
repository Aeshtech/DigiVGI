<!-- =======================================================JAI SHREE KRISHNA============================================ -->
<?php
require("template.php");
require('../adminstrative/config.php');
$username = $_SESSION['username_director'];



// ----------------------------For Update profile--------------------------------//

//defining variables.
$imgErr="";
$emailErr="";
$nameErr="";
$phoneErr="";
$Success_mssg="";


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $_POST['id'];
    $oldimage = $_POST['oldimage'];
    $email = $_POST['email'];
    $email = filter_var($email,FILTER_SANITIZE_EMAIL);
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    $imgtype = strtolower(pathinfo($_FILES['photo']['name'],PATHINFO_EXTENSION));   //taking extension from file name.
    if(isset($_FILES['photo']['name']) && ($_FILES['photo']['name']!="") && ($imgtype!="jpg" && $imgtype!="jpeg" && $imgtype!="png")){
        $imgErr = "Image should be in ('jpeg','jpg' or'png') only!";
    }else if($_FILES['photo']['size'] >= 500000){
        $imgErr= 'Image size should be less than 500KB!';
    }else if(!preg_match("/^[a-zA-Z- ']*$/",$name)){
		$nameErr = "Only letters and white space allowed!";
    }
    else if(!preg_match("/^\d{10}$/",$phone)){
		$phoneErr= "It should contain only 10 digit valid number!";
    }else if(filter_var($email,FILTER_VALIDATE_EMAIL) != TRUE){
        $emailErr = 'Please enter valid email address!';
    }else{
        if(isset($_FILES['photo']['name']) && ($_FILES['photo']['name']!="")){   // checking if file input was taken or not on updation!
            $seprated = explode(".",$_FILES['photo']['name']);
            $newfilename = round(microtime(true)).'.'.end($seprated);
            $upload = "dir_uploads/".$newfilename;
            move_uploaded_file($_FILES['photo']['tmp_name'], $upload);
            unlink($oldimage);
        }
        else{
            $upload=$oldimage;
        }
        $query = "UPDATE `director` SET `name`='$name',`email`='$email',`phone`='$phone',`photo`='$upload' WHERE `id`= '$id'";
        $result = mysqli_query($conn,$query);
        if(mysqli_affected_rows($conn)){
		    $Success_mssg = "Profile updated successfully!";
        }
        // if email updation successfully than redirects to login page.
        if($email != $username){
            session_destroy();
            header('location:../index.php');
        }
    }
}

function test_input($data){
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($conn,$data);
    return $data;
}

$query = "SELECT * FROM `director` WHERE `email`='$username'";
$result  = mysqli_query($conn,$query);
if(mysqli_num_rows($result)==1){
$row = mysqli_fetch_assoc($result);
$id = $row['id'];
$photo = $row['photo'];
$email = $row['email'];
$name = $row['name'];   
$phone = $row['phone'];
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Director Profile</title>
    <link rel="stylesheet" type="text/css" href="../adminstrative/styles/V2.css">
    <style>
        .update_profile input{
            width: 35%;
        }
        .update_profile span{
            background: greenyellow;
            color: darkgreen;
        }
    </style>
</head>

<body>
    <div id="dir_main">
    <div class="update_profile" style="margin-top:10vh;">
        <?php
           if($Success_mssg!='')
           {
           echo '<span>'.$Success_mssg.'</span>';
           }
            ?>
            <br>

        <img id="output" src="<?php echo $photo; ?>"><br><br>
            <?php
            if($imgErr!='')
            {
            echo '<span>'.$imgErr.'</span>';
            }
            ?><br>

        <form method="POST" action="" enctype="multipart/form-data" >
            <input type="hidden" name="id" value="<?= $id ?>" >

            <!-------for unlink oldimage on update operation----------->
            <input type="hidden" name="oldimage" value="<?php echo $photo; ?>">
            <input type="file" name="photo" id="file" onchange="loadfile(event)" style="display: none;"> 

            <!-- above input 'file' display hidden and label will work as input element -->
            <div class="label" style="margin:10px auto 20px;">
                <label for="file" style="cursor:pointer;background:yellow;">Choose your profile photo</label>
            </div>

            <label>Email*<input type="email" name="email" value="<?php echo $email; ?>"></label><br>
            <?php
            if($emailErr!='')
            {
            echo '<span>'.$emailErr.'</span>';
            }
            ?><br>
            <label>Name<input type="text" name="name" value="<?php echo $name;?>" required></label><br>
            <?php
            if($nameErr!='')
            {
            echo '<span>'.$nameErr.'</span>';
            }
            ?><br>
            <label>Phone<input type="text" name="phone" value="<?php echo $phone;?>" maxlength="10" minlength="10" placeholder="Phone no." required></label><br>
           <?php
            if($phoneErr!='')
            {
            echo '<span>'.$phoneErr.'</span>';
            }
            ?><br>   

            <input type="submit" value="Update" name="update" onclick="return confirm('Please make sure all credentials are correct!!')" style="border:2px soild black;">
        </form>
    </div>
    
    <div class="admin-profile-note">
        <h2>Remember</h2>
        <p>Please reload the page after update profile.</p>
        <p>If you try to successfully change your email than you will be redirected to login page, and you have login again with your new email ! </p>
    </div>   
    </div>




    <script>
    var loadfile = function(event) {
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
    };

    if(window.history.replaceState){
        window.history.replaceState(null,null,window.location.href);
    }

    </script>
    </body>
</html>