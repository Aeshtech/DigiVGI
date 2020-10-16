<!-- ---------------------------------------------------*** JAI SHREE KRISHNA ***-------------------------------------------->
<?php
  require('../adminstrative/config.php');
?>

    <!-- =====================AeshTech Header======================= -->
    <?php
    $email = $_SESSION['username_student'];
    $query = "SELECT `name`,`photo` FROM `student` WHERE email='$email'";
    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($result);
    ?>

    <div class="logo-for-lap">
        <h1>DigiVgi</h1>
        <img src="..\adminstrative\vgi-logo.jpg" alt="Not Found">
    </div>
    <header class="header">
        <div class="dropdown">
            <div class="profile"><img src="../adminstrative/<?php echo $row['photo']; ?>" alt="Not Found"></div>
            <div class="dropdown-content">
                <a><i class="fas fa-user-circle"></i><?php echo $row['name']; ?></a>
                <a><i class="fas fa-envelope"></i><?php echo $email; ?></a>
                <form action="../adminstrative/logout.php" method="POST">
                    <a><i class="fas fa-sign-out-alt"></i><input type="submit" name="signoutBtn"
                            value="Sign-out"></input></a>
                </form>
            </div>
        </div>
        <div class="logo">
            <h2>DigiVgi</h2>
            <img src="..\adminstrative\vgi-logo.jpg">
        </div>

        <!-- =============Menu icon================ -->
        <input class="menu-btn" type="checkbox" id="menu-btn">
        <label class="menu-icon" for="menu-btn">
            <span class="navicon"></span>
        </label>

        <ul class="menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="studentProfile.php">Profile</a></li>
            <li><a href="studentPrivacy.php">Privacy</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="#">Library</a></li>
        </ul>
    </header>
