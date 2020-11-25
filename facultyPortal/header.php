<!-- ---------------------------------------------------*** JAI SHREE KRISHNA ***-------------------------------------------->
<?php
  require('../adminstrative/config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../digivgi_styles.css">
    <script src="https://kit.fontawesome.com/471f9934c1.js"></script>
</head>

<body>
    <!-- =====================AeshTech Header======================= -->
    <?php
    $email = $_SESSION['username_faculty'];
    $query = "SELECT `name`,`photo` FROM `faculty` WHERE email='$email'";
    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($result);
    ?>

    <div class="logo-for-lap">
        <h1>DigiVGI</h1>
        <img src="..\adminstrative\vgi-logo.jpg" alt="Not Found">
    </div>
    <header class="header">
        <div class="dropdown">
            <div class="profile"><img src="../adminstrative/<?php echo $row['photo']; ?>" alt="Not Found"></div>
            <div class="dropdown-content">
                <a><i class="fas fa-user-circle"></i><?php echo $row['name']; ?></a>
                <a><i class="fas fa-envelope"></i><?php echo $email; ?></a>
                <form action="../logout.php" method="POST">
                    <a><i class="fas fa-sign-out-alt"></i><input type="submit" name="signoutBtn"
                            value="Sign-out"></input></a>
                </form>
            </div>
        </div>
        <div class="logo">
            <h2>DigiVGI</h2>
            <img src="..\adminstrative\vgi-logo.jpg">
        </div>

        <!-- =============Menu icon================ -->
        <input class="menu-btn" type="checkbox" id="menu-btn">
        <label class="menu-icon" for="menu-btn">
            <span class="navicon"></span>
        </label>

        <ul class="menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="facultyProfile.php">Profile</a></li>
            <li><a href="facultyPrivacy.php">Privacy</a></li>
            <li><a href="about.php">About us</a></li>
            <li><a href="#">Library</a></li>
        </ul>
    </header>
</body>

</html>