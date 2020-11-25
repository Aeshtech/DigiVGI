<!-- -------------------------------------------------------JAI SHREE KRISHNA-------------------------------------------- -->
<?php
session_start();
require("adminstrative/config.php");

if($_SERVER['REQUEST_METHOD']=='POST')
{
    $username = $_POST['email'];
    $username = filter_var($username,FILTER_SANITIZE_EMAIL);
    $username = filter_var($username,FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];


    //Here we have three distinct queries below which are doing union operation on same name and equal number of fields from three different tables
    // After execution, we will get the desired credentials of the user, if the entered email was found in any one of the table i.e student or faculty or admin and if not found then give the error as 'Inavlid Username'.
 
    $query="SELECT `email`,`password`,`name`,`user_type` FROM `faculty` WHERE `email`= ? UNION SELECT `email`,`password`,`name`,`user_type` FROM `student` WHERE `email`=? UNION  SELECT `email`,`password`,`name`,`user_type` FROM `admin` WHERE `email`= ?";

    $stmt=mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"sss",$username,$username,$username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $numRows = mysqli_num_rows($result);        
    }

    //this block is only execute if there is any unique email-id in db matches with the user entered email.
    if($numRows==1){
        $row = mysqli_fetch_assoc($result);

        //cookie will set if password is correct.
        if(password_verify($password,$row['password'])){
            if(isset($_POST['remember_me'])){
                setcookie('digivgi_email',$username,time()+ 84600);
                setcookie('digivgi_password',$password,time()+ 84600);
            }
        }

        //Password_verify function returns true if B-crypted key matches with the user entered plain password and false otherwise!

        //this block will only execute if password is true and user_type = 'student'.
        if(password_verify($password,$row['password']) && $row['user_type']=='student'){
            $_SESSION['username_student']= $username;
            $sql = "UPDATE `student` SET `isactive`='yes' WHERE `email`='$username'";
            mysqli_query($conn,$sql);  
            header('Location:studentPortal/index.php');
        }
        //this block will only execute if password is true and user_type = 'faculty'.
        elseif(password_verify($password,$row['password']) && $row['user_type']=='faculty'){
            $_SESSION['username_faculty']= $username;
            $sql = "UPDATE `faculty` SET `isactive`='yes' WHERE `email`='$username'";
            mysqli_query($conn,$sql);  
            header('Location:facultyPortal/index.php');
        }
        //this block will only execute if password is true and user_type = 'adminif
        elseif(password_verify($password,$row['password']) && $row['user_type']=='admin'){
            $_SESSION['username_admin']= $username;
            $sql = "UPDATE `admin` SET `isactive`='yes' WHERE `email`='$username'";
            mysqli_query($conn,$sql);  
            header('Location:adminstrative/index.php');
        }
        //this block will give error mssg as invalid password if there is no condtion match in above three. 
        else{
            $_SESSION['status'] = 'Invalid Password!';
            header('Location:index.php');
        }
    }
    //this block will execute if there is no email found as entered by the user.
    else{
        $_SESSION['status'] = 'Invalid Username!';
        header('Location:index.php');
    }



    
    
    
    // Function to get the client IP address
    // function get_client_ip() {
    //     $ipaddress = '';
    //     if (isset($_SERVER['HTTP_CLIENT_IP']))
    //         $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    //     else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
    //         $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    //     else if(isset($_SERVER['HTTP_X_FORWARDED']))
    //         $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    //     else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
    //         $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    //     else if(isset($_SERVER['HTTP_FORWARDED']))
    //         $ipaddress = $_SERVER['HTTP_FORWARDED'];
    //     else if(isset($_SERVER['REMOTE_ADDR']))
    //         $ipaddress = $_SERVER['REMOTE_ADDR'];
    //     else
    //         $ipaddress = 'UNKNOWN';
    //     return $ipaddress;
    // }
?>