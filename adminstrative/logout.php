<?php
session_start();

if(isset($_POST['signoutBtn']))
{
    setcookie('digivgi_email',"",time() - 84600);
    setcookie('digivgi_password',"",time() - 84600);
    session_destroy();
    unset($_SESSION['username_admin']);
    unset($_SESSION['username_faculty']);
    unset($_SESSION['username_student']);
    
    header('Location:../index.php');
}

?>