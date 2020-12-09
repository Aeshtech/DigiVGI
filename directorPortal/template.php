<!-- ==========================JAI SHREE KRSIHNA==================== -->
<?php
session_start();
if(!$_SESSION['username_director'])
{
    header('Location: ../index.php');
}
  require('../adminstrative/config.php');
error_reporting(E_ERROR | E_WARNING | E_PARSE );

$username = $_SESSION['username_director'];
    $sql = "SELECT `name`,`photo`FROM `director` WHERE `email`='$username'";
    $rslt = mysqli_query($conn,$sql);
    $pro = mysqli_fetch_assoc($rslt);
    $profile = $pro['photo'];
    $name = $pro['name'];
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Director Portal</title>
    <link rel="stylesheet" type="text/css" href="../adminstrative/styles/V2.css">

    
    <!-- ----------Bootstrap links-------- -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- ----------------------------------------------------- -->
</head>
<body>
    <div id="dir_left">
        <div id="dir_profile_left">
            <img src="../adminstrative/vgi-logo.jpg" >
        </div>

        <div id="dir_nav-left">
        <ul>
            <a href="index.php"><li>Home</li></a>
            <a href="dir_admin.php"><li>Admin</li></a>
            <a href="dir_faculty.php"><li>Faculty</li></a>
            <a href="dir_privacy.php"><li>Privacy</li></a>
            <a href=""><li>About</li></a>
        </ul>
        </div>

        <footer class="dir_nav-footer">
            <a href="https://www.aeshtech.com" target="blank">Powered By- Aeshtech</a>
        </footer>
    </div>


    <div id="dir_top-container">
        <header>
            <div class="logodiv2">
                <h1>Digi VGI</h1>
                <img src="../adminstrative/vgi-logo.jpg" id="logo">
                
                <div class="profile_div" style="margin: 2px 20px auto auto;">
                    <span class="profile_name" style="color:white;position:absolute;font-size: 18px;right: 70px;top: 20px;"><?php echo $name;?></span>
                    <div class="dropdown">
                        <div class="profile"><img src="<?=$profile;?>" style="width:45px;height:45px;"></div>
                        <div class="dropdown-content" style="top: 44px;">
                            <form action="../logout.php" method="POST">
                                <a><i class="fas fa-sign-out-alt"></i><input type="submit" name="signoutBtn" value="Log-out"
                                        style="color: var(--primary);"></input></a>
                            </form>
                            <a href="dir_profile.php" style="font-size: 18px;font-weight:bold"><i class="fas fa-user-circle"></i>Profile</a>
                            <a style="font-size: 17px;font-weight:bold"><i class="fas fa-user"></i><?=$username; ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    </div>
</body>
</html>