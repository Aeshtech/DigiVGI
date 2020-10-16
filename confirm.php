<?php 
$to_mail = "ashishpandit5376@gmail.com";
$subject = "DigiVgi Password Reset";
$body = "Hii, $to_mail. Click here to recreate your digivgi password http://localhost/DigiVgi/reset_password.php";
$sender_email = "From:ashishpandit5376@gmail.com";
if(mail($to_mail,$subject,$body,$sender_email)){
    echo "Email has been successfully sent to $to_mail...";
}else{
    echo "Email sending failed...";
}
?>