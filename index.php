<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vishveshwarya AMS</title>
    <link rel="stylesheet" href="adminstrative/styles/V2.css">
    <script src="https://kit.fontawesome.com/471f9934c1.js"></script>
</head>

<body>
    <!--------Header------->
    <div class="log-navbar">
        <header>
            <span id="digivgi">DigiVGI</span>
            <img src="vgi-logo1.png" alt="!" class="vgi_logo1">
            <img src="vgi-logo2.png" alt="!" class="vgi_logo2">
            <img src="vgi-logo-bg.png" alt="!" class="vgi_logo_bg">
        </header>
    </div>

    <!-- Login form -->
    <div class="box">
        <h2>Digi VGI</h2>
        <?php
            if(isset($_SESSION['status'])&& $_SESSION['status'] !='')
            {
            echo '<b style="color:red;margin-left:10%;font-size:16px;">'.$_SESSION['status'].'</b>';
                unset($_SESSION['status']);
            }
            ?>
        <form action="login.php" method="post">
            
            <div class="inputbox">
                <input type="email" name="email" class="f-input"  value="<?php if(isset($_COOKIE['digivgi_email'])) { echo $_COOKIE['digivgi_email'];} ?> " required>
                <label>Username</label>
            </div>
            
            <div class="inputbox">
                <input type="password" name="password" class="f-input" value="<?php if(isset($_COOKIE['digivgi_password'])) { echo $_COOKIE['digivgi_password'];} ?>" required>
                <label>Password</label>
            </div>
            
            <div class="remember_me">
                <input type="checkbox" name="remember_me" <?php if(isset($_COOKIE['digivgi_email'])) { ?> checked <?php }?> >
                <b>Remember Me</b>
            </div>
            <input class="f-submit" name="login_btn" type="submit" value="Log-in">
        </form>
        <div class="forgotPassword">
            <b>Forgot Password</b>-<a href="forgotpassword.php" >Click Here</a>
        </div>
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