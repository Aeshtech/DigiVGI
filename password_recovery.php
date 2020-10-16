<?php
session_start();
require("adminstrative/config.php");

if (isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["action"]) && ($_GET["action"]=="reset") && !isset($_POST["action"])){
  $key = $_GET["key"];
  $email = $_GET["email"];
  $curDate = date("Y-m-d H:i:s");

  $query = "SELECT * FROM `password_reset_temp` WHERE `key`='$key' AND `email`= '$email'";
  $result = mysqli_query($conn,$query);
  $numRow = mysqli_num_rows($result);
  $error = "";
  if ($numRow==""){
  $error .= '<h1 style="color:red;text-align:center;">Invalid Link</h1>
<p>The link is invalid/expired or you have already used the key in which case it is 
deactivated.</p>
<p><a href="http://localhost/DigiVgi/forgotpassword.php">Click here</a> to reset password.</p>';
 }else{
  $row = mysqli_fetch_assoc($result);
  $expDate = $row['expDate'];
  if ($expDate >= $curDate){
  ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Recovery</title>
    <link rel="stylesheet" href="adminstrative/styles/V2.css">
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

    <div class="box" style="text-align: center;height:35em;">
        <h2>Digi VGI</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" name="update">
            <p style="color:var(--primary);font-weight:bold;font-size:15px;">Enter your new password!</p>
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="email" value="<?php echo $email;?>" />

            <div class="inputbox" style="margin-top: 60px;">
                <input type="password" name="pass1" class="f-input" maxlength="15" required>
                <label>Password</label>
            </div>
            <div class="inputbox" style="margin-top: 60px;">
                <input type="password" name="pass2" class="f-input" maxlength="15" required>
                <label>Confirm Password</label>
            </div>

            <input class="f-submit" type="submit" value="Reset Password">
        </form>
    </div>
</body>
</html>
<?php
}else{
$error .= "<h1 style='color:red;text-align:center;'>Link Expired!</h1>
<p>The link is expired You are trying to use the expired link which 
as valid only 24 hours (1 days after request).<br> You can try once again by <a href='http://localhost/DigiVgi/forgotpassword.php'>Click Here</a><hr></p>";
}
}
if($error!=""){
  echo "<div class='error'>".$error."</div><br />";
  } 
} // isset email key validate end
 
 
if(isset($_POST["email"]) && (!empty($_POST["email"])) && isset($_POST["action"]) && ($_POST["action"]=="update")){
$error="";
$pass1 = mysqli_real_escape_string($conn,$_POST["pass1"]);
$pass2 = mysqli_real_escape_string($conn,$_POST["pass2"]);
$email = $_POST["email"];
$curDate = date("Y-m-d H:i:s");
if ($pass1!=$pass2){
echo "<h1 style='color:red;'>Error: Password do not match. Both password should be same!</h1><br>
<button onclick='window.history.back();' style='padding:7px;font-size:18px;'>Back</button>";
}else{
$pass1 = password_hash($pass1,PASSWORD_BCRYPT);

$special1 = "UPDATE `student` SET `password`='$pass1' WHERE `email`='$email' AND `user_type`= 'student'";
$special2 = "UPDATE `faculty` SET `password`='$pass1' WHERE `email`='$email' AND `user_type`= 'faculty'";
$special3 = "UPDATE `admin` SET `password`='$pass1' WHERE `email`='$email' AND `user_type`= 'admin'";
mysqli_query($conn,$special1);
mysqli_query($conn,$special2);
mysqli_query($conn,$special3);

mysqli_query($conn,"DELETE FROM `password_reset_temp` WHERE `email`='$email'");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recoverd</title>
    <style>
    .successfully-recoverd{
        text-align: center;
        font-size: 2em;
        color: green;
        border: 10px groove aliceblue;
        font-weight: bold;
        font-family: georgia;
        background: chartreuse;
        }
    </style>
</head>
<body>
<?php
echo '<div class="successfully-recoverd"><h3 style="color: black;">DigiVGI</h3><p>Congratulations! <br> Your password has been updated successfully.</p>
<p><a href="http://localhost/DigiVgi/index.php">Login</a></p></div><br />';
   } 
}
?>
</body>
</html>
