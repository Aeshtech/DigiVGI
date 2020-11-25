<?php
session_start();
require "adminstrative/config.php";
$username1 = $_SESSION['username_admin'];
$username2 = $_SESSION['username_faculty'];
$username3 = $_SESSION['username_student'];

if(isset($_POST['signoutBtn'])){
    setcookie('digivgi_email',"",time() - 84600);
    setcookie('digivgi_password',"",time() - 84600);

    $sql = "UPDATE `admin` SET `isactive`='no' WHERE `email`='$username1';UPDATE `faculty` SET `isactive`='no' WHERE `email`='$username2';UPDATE `student` SET `isactive`='no' WHERE `email`='$username3'";
    mysqli_multi_query($conn,$sql); 

    
    session_destroy();
    unset($_SESSION['username_admin']);
    unset($_SESSION['username_faculty']);
    unset($_SESSION['username_student']);
    
    header('Location:index.php');
}

?>