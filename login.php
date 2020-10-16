<?php
session_start();
require("adminstrative/config.php");

if($_SERVER['REQUEST_METHOD']=='POST')
{
    $username = $_POST['email'];
    $username = filter_var($username,FILTER_SANITIZE_EMAIL);
    $username = filter_var($username,FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];
    $query="SELECT `email`,`password`,`name`,`photo`,`user_type` FROM faculty WHERE `email`='$username' UNION SELECT `email`,`password`,`name`,`photo`,`user_type` FROM student WHERE `email`='$username' UNION SELECT `email`,`password`,`name`,`photo`,`user_type` FROM admin WHERE `email`='$username'" ;
    $result=mysqli_query($conn,$query);
    $numRows = mysqli_num_rows($result);        
    }
    if($numRows==1){
        $row = mysqli_fetch_assoc($result);

        // Remember me on set if password is correct.
        if(password_verify($password,$row['password'])){
            if(isset($_POST['remember_me'])){
                setcookie('digivgi_email',$username,time()+ 84600);
                setcookie('digivgi_password',$password,time()+ 84600);
            }
        }

        if(password_verify($password,$row['password']) && $row['user_type']=='student'){
            $_SESSION['username_student']= $username;
            header('Location:studentPortal/index.php');
        }
        elseif(password_verify($password,$row['password']) && $row['user_type']=='faculty'){
            $_SESSION['username_faculty']= $username;
            header('Location:facultyPortal/index.php');
        }
        elseif(password_verify($password,$row['password']) && $row['user_type']=='admin'){
            $_SESSION['username_admin']= $username;
            header('Location:adminstrative/index.php');
        }
        else{
            $_SESSION['status'] = 'Invalid Password!';
            header('Location:index.php');
        }
    }
    else{
        $_SESSION['status'] = 'Invalid Username!';
        header('Location:index.php');
    }


?>