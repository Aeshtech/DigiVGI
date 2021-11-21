<!-- =======================================================JAI SHREE KRISHNA============================================ -->
<?php 
session_start();
if(!$_SESSION['username_admin'])
{
    header('Location: ../index.php');
}
require('config.php');
$username = $_SESSION['username_admin'];


// ----------------------------For Update profile--------------------------------//

if($_SERVER['REQUEST_METHOD']=='POST'){
    $id = $_POST['id'];
    $oldimage = $_POST['oldimage'];
    $email = $_POST['email'];
    $email = filter_var($email,FILTER_SANITIZE_EMAIL);
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
    }else if(filter_var($email,FILTER_VALIDATE_EMAIL) != TRUE){
        $_SESSION['emailErr'] = 'Please enter valid email address!';
    }else{
        if(isset($_FILES['photo']['name']) && ($_FILES['photo']['name']!="")){   // checking if file input was taken or not on updation!
            $seprated = explode(".",$_FILES['photo']['name']);
            $newfilename = round(microtime(true)).'.'.end($seprated);
            $upload = "uploads_admin/".$newfilename;
            $upload_dir = "../directorPortal/uploads_admin/".$newfilename;
            move_uploaded_file($_FILES['photo']['tmp_name'], $upload_dir);
            unlink("../directorPortal/".$oldimage);
        }
        else{
            $upload=$oldimage;
        }
        $query = "UPDATE `admin` SET `name`='$name',`email`='$email',`phone`='$phone',`photo`='$upload' WHERE `id`= '$id'";
        $result = mysqli_query($conn,$query);
        if(mysqli_affected_rows($conn)){
            $_SESSION['success'] = "Profile updated successfully!";
        }
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

// for getting the details of session director and fill in the form.
$query = "SELECT * FROM `admin` WHERE `email`='$username'";
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
        <h1>Digi VGI</h1>
    </div>
</header>

<body>

    <div class="update_profile">
        <a class="back_btn" href="index.php">Go Back</a>
        <?php
            if(isset($_SESSION['success'])&& $_SESSION['success'] !='')
            {
            echo "<span style='background:greenyellow;color:black;'>".$_SESSION['success']."</span>";
                unset($_SESSION['success']);
            }
            ?>
            <br>

        <!-- --------------Admin Profile------------- -->
        <img id="output" src="../directorPortal/<?php echo $photo; ?>" style="margin-top:2vh;"><br><br>
        <?php
        if(isset($_SESSION['photoErr'])&& $_SESSION['photoErr'] !='')
        {
        echo '<span>'.$_SESSION['photoErr'].'</span>';
            unset($_SESSION['photoErr']);
        }
        ?><br>

        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $id ?>" >
            <input type="hidden" name="oldimage" value="<?php echo $photo; ?>">   <!-------for unlink oldimage on update operation----------->
            <input type="file" name="photo" id="file" onchange="loadfile(event)" style="display: none;"> 

            <!-- above input 'file' display hidden and label will work as input element -->
            <div class="label" style="margin:10px auto 20px;">
                <label for="file" style="cursor:pointer;">Choose your profile photo</label>
            </div>

            <label>Email*<input type="email" name="email" value="<?php echo $email; ?>" required></label><br>
            <?php
            if(isset($_SESSION['emailErr'])&& $_SESSION['emailErr'] !='')
            {
            echo '<span>'.$_SESSION['emailErr'].'</span>';
                unset($_SESSION['emailErr']);
            }
            ?><br>
            <label>Name<input type="text" name="name" value="<?php echo $name;?>" required></label><br>
            <?php
            if(isset($_SESSION['nameErr'])&& $_SESSION['nameErr'] !='')
            {
            echo '<span>'.$_SESSION['nameErr'].'</span>';
                unset($_SESSION['nameErr']);
            }
            ?><br>
            <label>Phone<input type="text" name="phone" value="<?php echo $phone;?>" maxlength="10" minlength="10" placeholder="Phone no." required></label><br>
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
    }
    if(window.history.replaceState){
        window.history.replaceState(null,null,window.location.href);
    }
    </script>
    </body>
</html>