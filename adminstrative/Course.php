<?php
session_start();
if(!$_SESSION['username_admin'])
{
    header('Location: ../index.php');
}
require('config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles/V2.css">
    <style>
        textarea:hover{
            background-color: chartreuse;
        }
    </style>
</head>
<body>
  <!-- ==============================DigiVGI-Header================= -->
<header>
    <div class="logodiv">
        <!-- <a><img src="vgi-logo.jpg" id="logo"></a> -->
        <h1>Digi VGI</h1>
    </div>

    <?php 
    $username = $_SESSION['username_admin'];
    $sql = "SELECT `photo` FROM `admin` WHERE `email`='$username'";
    $rslt = mysqli_query($conn,$sql);
    $pro = mysqli_fetch_assoc($rslt);
    $profile = $pro['photo'];

    ?>
    <!-- ===============Navigation Bar========================== -->
    <div class="topnav" id="myTopnav">
        <a href="#">Home</a>
        <a href="Faculty.php">Faculty</a>
        <a href="Student.php">Student</a>
        <a href="Course.php" class="active">Course</a>
        <a href="Subject.php" >Subject</a>
        <a href="AssignFaculty.php" >Assign Faculty</a>

        <div class="profile_div">
            <span class="profile_name"><?php echo $username;?></span>
            <div class="dropdown">
                <div class="profile"><img src="<?=$profile;?>"></div>
                <div class="dropdown-content">
                  <form action="../logout.php" method="POST">
                      <a><i class="fas fa-sign-out-alt"></i><input type="submit" name="signoutBtn" value="Log-out" style="color: var(--primary);"></input></a>
                  </form>
                  <a href="adminProfile.php"><i class="fas fa-user-circle"></i>Profile</a>
                  <a href="adminPrivacy.php"><i class="fas fa-key"></i>Privacy</a>
                  <a href="makeAdmin.php"><i class="fas fa-user-circle"></i>Make Admin</a>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- ========================================= -->
      <div class="coursesform">
          <h1>Add Course:</h1>
          <form>
              <label>Name:</label>
              <input type="text" id="coursesName" disabled placeholder="----------------------Name of Course-----------------">
              <label>Semesters:</label>
              <input type="number" min="1" max="10" disabled id="validSemesters" placeholder="----------------------Valid Semester's-----------------">
              <label>Section:</label>
              <input type="text" id="validSections" disabled placeholder="----------------------Section-name---------------------">
              <input type="submit" value="Add Record" name="submit">
          </form>
      </div>


<script src="myapp.js"></script>
</body>
</html>