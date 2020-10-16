<?php 

ini_set( 'display_errors', 1 );
error_reporting( E_ALL );
$from = "ashishpandit5376@gmail.com";
$to = "ashishpandit5376@gmail.com";
$subject = "Checking PHP mail";
$message = "PHP mail works just fine";
$headers = "From:" . $from;
if(mail($to,$subject,$message, $headers)){
    echo "The email message was sent.";
}else{
    echo "Email sending failed";
}
?>
