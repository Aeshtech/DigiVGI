<!-- =====================================================JAI SHREE KRISHNA========================================= -->
<?php
session_start();
require("adminstrative/config.php");
// Import PHPMailer classes into the global namespace
       // These must be at the top of your script, not inside a function
       use PHPMailer\PHPMailer\PHPMailer;
       use PHPMailer\PHPMailer\SMTP;
       use PHPMailer\PHPMailer\Exception;
       
       // Load Composer's autoloader
       require 'vendor/autoload.php';

if(isset($_POST["email"]) && (!empty($_POST["email"]))){
    $email = $_POST["email"];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!$email) {
        $_SESSION['status'] ="Invalid email address please type a valid email address!";
       }else{
       $sql_query = "SELECT `name`,`email`,`user_type` FROM `faculty` WHERE email='$email' UNION  SELECT `name`,`email`,`user_type` FROM `student` WHERE email='$email' UNION SELECT `name`,`email`,`user_type` FROM `admin` WHERE email='$email'";
       $result = mysqli_query($conn,$sql_query);
       $numRow = mysqli_num_rows($result);
       $row = mysqli_fetch_assoc($result);
       if ($numRow==""){
       $_SESSION['status']= "No user is registered with this email address!";
       }else{
       $name = $row['name'];    
       $expFormat = mktime(
       date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y")
       );
       $expDate = date("Y-m-d H:i:s",$expFormat);
       $key = time().sha1($email);
       $addKey = substr(sha1(uniqid(rand(),1)),3,10);
       $key = $key . $addKey;           //encrypted token key.


       $query = "INSERT INTO `password_reset_temp`(`email`, `key`, `expDate`) VALUES('$email','$key','$expDate')";
       mysqli_query($conn,$query);
       
       $output='<strong style="color:Green;">Dear,'.$name.'</strong> ';
       $output.='<p style="color:red;bakground:yellow;">It seems that you have requested to reset your DigiVGI Password.</p>';
       $output.='<p>-------------------------------------------------------------</p>';
       $output.='<p><a href="http://localhost/DigiVgi/password_recovery.php?key='.$key.'&email='.$email.'&action=reset" target="_blank"><h2>Reset Password</h2></a></p>'; 
       $output.='<p>-------------------------------------------------------------</p>';
       $output.='<p style="color:red;backrground:yellow;">If you did not request this forgotten password email, no action 
       is needed, your password will not be reset. However, you should log into 
       your account and change your security password as someone may have guessed it.</p>';
       $output.='<p>Thanks,</p>';
       $output.='<p>From-<b>DigiVGI</p>';
       $body = $output; 
       $subject = "Password Recovery - DigiVgi Team";
       

       // Instantiation and passing `true` enables exceptions
       $mail = new PHPMailer(true);

       try {
           //Server settings
           // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                    // Enable verbose debug output
           $mail->isSMTP();                                            // Send using SMTP
           $mail->Host       = 'smtp.gmail.com';                      // Set the SMTP server to send through
           $mail->SMTPAuth   = true;                                 // Enable SMTP authentication
           $mail->Username   = 'ashishpandit5376@gmail.com';          // SMTP username
           $mail->Password   = '@dev.ashish11';                      // SMTP password
           $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
           $mail->Port       = 587;                                // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
           
           
           //Recipients
           $mail->setFrom('ashishpandit5376@gmail.com', 'DigiVgi');
           $mail->addAddress($email,$name);     // Add a recipient
        //    $mail->addAddress('ashishpandit5376@gmail.com');               // Name is optional
           // $mail->addReplyTo('info@example.com', 'Information');
           // $mail->addCC('cc@example.com');
           // $mail->addBCC('bcc@example.com');
       
           // Attachments
           // $mail->addAttachment('vgi-logo[1].png');         // Add attachments
           // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
           // Content
           $mail->isHTML(true);                                  // Set email format to HTML
           $mail->Subject = $subject;
           $mail->Body    = $body;
       
           $mail->send();
           $_SESSION['mail_success'] = 'Check your mail to reset password!';
        }catch (Exception $e) {
            $_SESSION['mail_fail'] = "Message could not be sent-Mailer Error!";
        }
    }
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vishveshwarya AMS</title>
    <link rel="stylesheet" href="adminstrative/styles/V2.css">
    <style>
    b.forgot-pwd-success-mssg{
        color:green;
        border-radius:20px;
        background:chartreuse;
        padding:5px;font-size:15px;
        position:absolute;top: 17vh;
        width: 100%;
        text-align:center;
    }
    @media only screen and (min-width:612px){
        b.forgot-pwd-success-mssg{
            width: 30%;
            left: 50%;
            transform: translateX(-50%);
        }
    }
    </style>
</head>

<body>
    <!--------Header------->
    <div class="log-navbar">
        <header id="nav1">
            <span id="digivgi">DigiVGI</span>
            <img src="vgi-logo1.png" alt="!" class="vgi_logo1">
            <img src="vgi-logo2.png" alt="!" class="vgi_logo2">
            <img src="vgi-logo-bg.png" alt="!" class="vgi_logo_bg">
        </header>
    </div>
    <?php
    if(isset($_SESSION['mail_success'])&& $_SESSION['mail_success'] !=''){
        echo '<b class="forgot-pwd-success-mssg">'.$_SESSION['mail_success'].'</b>';
        unset($_SESSION['mail_success']);
            }   
    if(isset($_SESSION['mail_fail'])&& $_SESSION['mail_fail'] !=''){
        echo '<b style="color:red;font-size:15px;position:absolute;top: 18vh;width: 100%;text-align:center;">'.$_SESSION['mail_fail'].'</b>';
        unset($_SESSION['mail_fail']);
            }
    ?>
    <!-- Mailing form -->
    <div class="box" style="text-align: center;height:25em;">
        <h2>Digi VGI</h2>
        <form action="" method="post">
            <p style="color:var(--primary);font-weight:bold;font-size:15px;">Enter your email address:</p>
            <?php
            if(isset($_SESSION['status'])&& $_SESSION['status'] !='')
            {
            echo '<b style="color:red;font-size:16px;">'.$_SESSION['status'].'</b>';
            unset($_SESSION['status']);
            }
            ?>
            <div class="inputbox" style="margin-top: 60px;">
                <input type="email" name="email" class="f-input" required>
                <label>Username</label>
            </div>

            <input class="f-submit" name="login_btn" type="submit" value="Send">
        </form>
    </div>

    <!--------- Footer -------->
    <footer >
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="svg-footer">
      <path fill="#e6e6fa" fill-opacity="1" d="M0,32L720,224L1440,0L1440,320L720,320L0,320Z"></path>
    </svg>
    <div class="footer">
        <a href="https://www.instagram.com/its_ashish_52/"><i class="fa fa-instagram fa-2x" aria-hidden="true" style="color: var(--primary);"></i></a>
        <a href="https://twitter.com/DevloperAshish"><i class="fa fa-twitter fa-2x" aria-hidden="true" style="color: var(--primary);"></i></a>
        <a href="https://www.facebook.com/Aeshtech52"><i class="fa fa-facebook fa-2x" aria-hidden="true" style="color: var(--primary);"></i></a>
        <hr>
        <span>&copy 2020 DigiVGI. All rights reserved</span>
    </div>
    </footer>
</body>

</html>