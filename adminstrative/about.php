<!-- ===================================================================JAI SHREE KRISHNA=================================================== -->
<?php
session_start();
if (!$_SESSION['username_admin']) {
    header('Location: ../index.php');
}
require('config.php');
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://kit.fontawesome.com/471f9934c1.js"></script>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles/V2.css">
    <link rel="stylesheet" href="../about_digivgi.css">
    <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../nivo-slider/themes/default/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="../nivo-slider/nivo-slider.css" type="text/css" media="screen" />
    <style>
        .founder_coloumn {
            position: absolute;
            margin: 0;
            top: 18vh;
            left: 50%;
            width: 65%;
            transform: translateX(-50%);
            border-bottom: 5px double blueviolet;

        }

        .main-section {
            position: absolute;
            width: 65%;
            top: 70vh;
            left: 50%;
            transform: translateX(-50%);
            font-family: sans-serif;
            font-size: 17px;
        }

        div.dropdown-content {
            right: 0;
        }

        .logodiv2 #logo {
            left: 54%;
            top: 10px;
        }
    </style>
</head>

<body>

    <!-- ==============================DigiVGI-Header================= -->
    <header>
        <div class="logodiv">
            <img src="vgi-logo.jpg" id="logo">
            <h1>Digi VGI</h1>
        </div>

        <?php
        $username = $_SESSION['username_admin'];
        $sql = "SELECT `photo` FROM `admin` WHERE `email`='$username'";
        $rslt = mysqli_query($conn, $sql);
        $pro = mysqli_fetch_assoc($rslt);
        $profile = $pro['photo'];

        ?>
        <!-- ===============Navigation Bar========================== -->
        <div class="topnav" id="myTopnav">
            <a href="index.php">Home</a>
            <a href="Student.php">Student</a>
            <a href="AssignFaculty.php">Assign Faculty</a>
            <a href="About.php" class="active">About us</a>

            <div class="profile_div">
                <span class="profile_name"><?php echo $username; ?></span>
                <div class="dropdown">
                    <div class="profile"><img src="../directorPortal/<?= $profile; ?>"></div>
                    <div class="dropdown-content">
                        <form action="../logout.php" method="POST">
                            <a><i class="fas fa-sign-out-alt"></i><input type="submit" name="signoutBtn" value="Log-out" style="color: var(--primary);"></input></a>
                        </form>
                        <a href="adminProfile.php"><i class="fas fa-user-circle"></i>Profile</a>
                        <a href="adminPrivacy.php"><i class="fas fa-key"></i>Privacy</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- ========================================= -->
    <div class="founder_coloumn">

        <div class="slider-wrapper theme-default">
            <div id="slider" class="nivoSlider">
                <img src="../nivo-slider/demo/images/toystory.jpg" data-thumb="nivo-slider/demo/images/toystory.jpg" alt="" />
                <img src="../nivo-slider/demo/images/up.jpg" data-thumb="nivo-slider/demo/images/up.jpg" alt="" title="This is an example of a caption" />
                <img src="../nivo-slider/demo/images/walle.jpg" data-thumb="nivo-slider/demo/images/walle.jpg" alt="" data-transition="slideInLeft" />
                <img src="../nivo-slider/demo/images/nemo.jpg" data-thumb="nivo-slider/demo/images/nemo.jpg" alt="" title="#htmlcaption" />
            </div>
            <div id="htmlcaption" class="nivo-html-caption"> <strong>Welcome</strong> to DigiVGI <em>Nice</em>
                slider with <a href="#">a link</a>. </div>
        </div>

    </div>
    <div class="main-section">

        <section style="margin-bottom: 10vh;">
            <h2 style="margin-top: 20px;color:blueviolet;">About us:</h2><br>
            <p><b>DigiVGI</b> which can be expanded as Digital Vishveshwarya Group of Instiutions (VGI) was established
                in the year 2020 in order to impart high quality digital education concerned services. DigiVGI is a
                students attendance management system (SAMS) originated by a VGI B.Tech(CSE) student to manage all
                record from their mobile phone just in couple of seconds. </p><br>

            <p>DigiVGI provides great priviledes to all faculty members to make students attendance subject wise which
                are assigned by respective admin of Digivgi together with access of update their record. Faculty members
                can view their respective subjects attendance record by selecting date of previous record as well as
                export it on excel for further assistance.</p><br>

            <p>It provides time to time updates to students about their attendance status so that they can cross check
                it via status blinkers in green (Snipshot-1) or red (Snipshot-2) color showing Present or Absent on each subject only for current
                date. You can also view your desired attendance record by selecting first and last date. You can also
                take backup for your attendance.
            </p>
            <img src="../assets/snipshot3.jpg" alt="!" width="45%" style="margin-right: 10px;">
            <img src="../assets/snipshot4.jpg" alt="!" width="45%">
        </section>
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript" src="../nivo-slider/jquery.nivo.slider.js"></script>
    <script type="text/javascript">
        $(window).load(function() {
            $('#slider').nivoSlider();
        });
    </script>
</body>

</html>