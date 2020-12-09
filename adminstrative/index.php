<!-- ===================================================================JAI SHREE KRISHNA=================================================== -->
<?php
session_start();
if(!$_SESSION['username_admin'])
{
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
</head>

<body>
    <!-- ==============================DigiVGI-Header================= -->
    <header>
        <div class="logodiv">
            <h1>Digi VGI</h1>
            <img src="vgi-logo.jpg" id="logo">
        </div>

        <?php 
    $username = $_SESSION['username_admin'];
    $sql = "SELECT `photo`,`course`,`branch` FROM `admin` WHERE `email`='$username'";
    $rslt = mysqli_query($conn,$sql);
    $pro = mysqli_fetch_assoc($rslt);
    $profile = $pro['photo'];
    $admin_course =$pro['course'];
    $admin_branch =$pro['branch'];
    ?>
        <!-- ===============Navigation Bar========================== -->
        <div class="topnav" id="myTopnav">
            <a href="index.php" class="active">Home</a>
            <a href="Student.php">Student</a>
            <a href="AssignFaculty.php">Assign Faculty</a>
            <a href="About.php">About us</a>


            <div class="profile_div">
                <span class="profile_name"><?php echo $username;?></span>
                <div class="dropdown">
                    <div class="profile"><img src="../directorPortal/<?=$profile;?>"></div>
                    <div class="dropdown-content">
                        <form action="../logout.php" method="POST">
                            <a><i class="fas fa-sign-out-alt"></i><input type="submit" name="signoutBtn" value="Log-out"
                                    style="color: var(--primary);"></input></a>
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
    <div id="home-grid">

        <!-- -----------------First grid for view attendance based on Subject------------- -->
        <div class="home-grid-item1">
            <h2>View Attendance (Based On Subject)</h2><br><br>

            <form action="home_action.php" method="POST">
            <div>
                <label>Subject Name:</label>
                <select name="subjectname" required class="subjectname" required>
                <option value="" selected disabled>Select Subject</option>
                    <?php 
                    $query = "SELECT DISTINCT `subjectname` FROM `assignfaculty` WHERE `course`='$admin_course' AND `branch`='$admin_branch'";
                    $result = mysqli_query($conn,$query);
                    if(mysqli_num_rows($result)>0){
                        while($row = mysqli_fetch_assoc($result)){?>
                    <option value="<?php echo $row['subjectname']; ?>"><?php echo $row['subjectname']; ?></option>
                    <?php }} ?>
                </select>
            </div>
            <div>
                <label>Semester:</label>
                <select name="semester" class="semester" required>
                    <option value='' selected disabled>select</option>
                    <option value="1"> 1</option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                    <option value="6"> 6 </option>
                    <option value="7"> 7 </option>
                    <option value="8"> 8 </option>
                </select>
            </div>
            <div >
                <label>Section:</label>
                <select name="section" required class="section">
                    <option value='None' selected>None</option>
                    <option value="A"> A</option>
                    <option value="B"> B </option>
                    <option value="C"> C </option>
                </select>
            </div>
            <div>
                <!-- start date from user want to see attendance -->
                <label>From:</label>
                <input type="date" name="startdate" min="2020-08-11" max="<?php  echo date("Y-m-d"); ?>" required class="start_date">
            </div>
            <div>
                <!-- last date upto user want to see attendance -->
                <label>TO</label>
                <input type="date" name="lastdate" min="2020-08-11" max="<?php  echo date("Y-m-d"); ?>" required class="last_date">
            </div>
            <div style="margin:4vh auto;">
                <input type="submit" name="view-based-on-subject" value="View Attendance">
            </div>
            </form>
        </div>

        <!-- -----------------Second grid for view attendance based on student------------- -->
        <div class="home-grid-item2">
            <h2>View Attendance (Based On Student)</h2><br><br>

            <form action="home_action.php" method="POST">
            <div>
                <label>Subject Name:</label>
                <select name="subjectname" required class="subjectname">
                <option value="" selected disabled>Select Subject</option>
                    <?php
                    $query = "SELECT DISTINCT `subjectname` FROM `assignfaculty` WHERE `course`='$admin_course' AND `branch`='$admin_branch'";
                    $result = mysqli_query($conn,$query);
                    if(mysqli_num_rows($result)>0){
                        while($row = mysqli_fetch_assoc($result)){?>
                        <option value="<?php echo $row['subjectname']; ?>"><?php echo $row['subjectname']; ?></option>
                    <?php }} ?>
                </select>
            </div>
            <div>
                <label>Roll No:</label>
                <input type="text" required name="roll_no" placeholder=" Enter student Roll No">
            </div>
            <div>
                <!-- start date from user want to see attendance -->
                <label>From:</label>
                <input type="date" name="startdate" min="2020-08-11" max="<?php  echo date("Y-m-d"); ?>" required class="start_date">
            </div>
            <div>
                <!-- last date upto user want to see attendance -->
                <label>TO</label>
                <input type="date" name="lastdate" min="2020-08-11" max="<?php  echo date("Y-m-d"); ?>" required class="last_date">
            </div>
            <div style="margin:4vh auto;">
                <input type="submit" name="view-based-on-student" value="View Attendance">
            </div>
            </form>
        </div>

        <!-- -----------------Third grid for Export attendance!------------- -->
        <div class="home-grid-item3">
            <h2>Export Attendance Record</h2><br><br>

            <form action="export-by-spreadsheet.php" method="POST">
            <div>
                <label>Subject Name:</label>
                <select name="subjectname" required class="subjectname">
                    <option value="" selected disabled>Select Subject</option>
                    <?php 
                    $query = "SELECT DISTINCT `subjectname` FROM `assignfaculty` WHERE `course`='$admin_course' AND `branch`='$admin_branch'";
                    $result = mysqli_query($conn,$query);
                    if(mysqli_num_rows($result)>0){
                        while($row = mysqli_fetch_assoc($result)){?>
                    <option value="<?php echo $row['subjectname']; ?>"><?php echo $row['subjectname']; ?></option>
                    <?php }} ?>
                </select>
            </div>
            
            <div>
                <label>Semester:</label>
                <select name="semester" class="semester" required>
                    <option value='' selected disabled>select</option>
                    <option value="1"> 1</option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                    <option value="6"> 6 </option>
                    <option value="7"> 7 </option>
                    <option value="8"> 8 </option>
                </select>
            </div>
            <div >
                <label>Section:</label>
                <select name="section" required class="section">
                    <option value='None' selected>None</option>
                    <option value="A"> A</option>
                    <option value="B"> B </option>
                    <option value="C"> C </option>
                </select>
            </div>
            <div>
                <!-- start date from user want to see attendance -->
                <label>From:</label>
                <input type="date" name="startdate" min="2020-08-11" max="<?php  echo date("Y-m-d"); ?>" required class="start_date">
            </div>
            <div>
                <!-- last date upto user want to see attendance -->
                <label>TO</label>
                <input type="date" name="lastdate" min="2020-08-11" max="<?php  echo date("Y-m-d"); ?>" required class="last_date">
            </div>
            <div style="margin:4vh auto;">
                <input type="submit" name="export_attendance" value="Export Attendance">
            </div>
            </form>
        </div>
    </div>
    
    <footer>
        <div class="home-footer">
            <b style="font-size: medium;float:left">CDP Ashish Sharma</b>
            <b style="font-size: medium;">&copy 2020 DigiVGI, All rights reserved.</b>
            <a href="https://aeshtech.com/"><b>Powered By-Aeshtech</b></a>
        </div>
    </footer>
    <script src="myapp.js"></script>
</body>

</html>