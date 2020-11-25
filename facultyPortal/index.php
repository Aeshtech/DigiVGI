<!-- -------------------------------------------------*** JAI SHRI KRISHNA ***--------------------------------------- -->
<?php
session_start();
if(!$_SESSION['username_faculty'])
{
    header('Location: ../index.php');
}
  require('../adminstrative/config.php');
error_reporting(E_ERROR | E_WARNING | E_PARSE );

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Portal</title>
    <link rel="stylesheet" href="../digivgi_styles.css">
    <script src="https://kit.fontawesome.com/471f9934c1.js"></script>
</head>

<body>
<?php require('header.php');?>
    <div class="attendance-mssg">
    <?php
            if(isset($_SESSION['mssg'])&& $_SESSION['mssg'] !='')
            {
            echo '<b>'.$_SESSION['mssg'].'</b>';
                unset($_SESSION['mssg']);
            }
    ?>
    </div>

    <!-- =============================Subjects list in grid============================= -->
    <div id="grid-container">
        <?php
$facultyid = $_SESSION['username_faculty'];
$sql = "SELECT * from `assignfaculty` where `facultyid`='$facultyid'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result)>0){
    $i=0;     // mysqli_num_rows() return total count of rows!
    while($row = mysqli_fetch_assoc($result)){
        $i++;
        ?>
        <div id="grid-item">
            <div class="subject-name">
                <h2><?php echo $row['subjectname']?></h2>
            </div>
            <form action="smart_attendance.php" method="POST">
                <input type="hidden" name="course" value="<?php echo $row['course']?>">
                <input type="hidden" name="branch" value="<?php echo $row['branch']?>">
                <input type="hidden" name="semester" value="<?php echo $row['semester']?>">
                <input type="hidden" name="section" value="<?php echo $row['section']?>">
                <input type="hidden" name="subjectname" value="<?php echo $row['subjectname']?>">
                <input type="hidden" name="subjectcode" value="<?php echo $row['subjectcode']?>">
                <input type="hidden" name="cpermit" value="<?php echo $row['cpermit']?>">

                <input type="date" name="date" min="2020-08-11" max="<?php  echo date("Y-m-d"); ?>"
                    value="<?php  echo date("Y-m-d"); ?>" required><br>

                <!-- -----for view record------ -->
                <span class="view-record"><a href="#openModal-view[<?php echo $i ?>]"><i class="fas fa-eye fa-2x"
                style="color: white;"></a></i></span>
                
                <span class="subject-code">(<?php echo $row['subjectcode']?>)</span>

                <!-- -----for export record------ -->
                <span class="export-record"><a href="#openModal-export[<?php echo $i ?>]"><i class="fas fa-file-excel fa-2x"
                            style="color: white;"></a></i></span>
                
                <input type="submit" name="submit" value="Make Attendance"><br>
            </form>
        </div>

        <!-- ------------Form as modal for view attendance record--------------- -->
        <form action="view-attendance.php" id="openModal-view[<?php echo $i ?>]" method="POST" class="modalDialog">

            <input type="hidden" name="course[<?php echo $i ?>]" value="<?php echo $row['course'] ?>">
            <input type="hidden" name="branch[<?php echo $i ?>]" value="<?php echo $row['branch'] ?>">
            <input type="hidden" name="semester[<?php echo $i ?>]" value="<?php echo $row['semester'] ?>">
            <input type="hidden" name="section[<?php echo $i ?>]" value="<?php echo $row['section'] ?>">
            <input type="hidden" name="subjectname[<?php echo $i ?>]" value="<?php echo $row['subjectname']?>">
            <input type="hidden" name="subjectcode[<?php echo $i ?>]" value="<?php echo $row['subjectcode']?>">

            <div>
                <a href="#close" title="Close" class="close">X</a>
                <h2>View Attendance </h2>
                <b>Enter the starting date you want to see the record!</b><br>
                <input type="date" name="startdate[<?php echo $i ?>]" min="2020-08-11" max="<?php  echo date("Y-m-d"); ?>" required><br>

                <b>Enter the last date you want to see the record!</b><br>
                <input type="date" name="enddate[<?php echo $i ?>]" min="2020-08-11" max="<?php  echo date("Y-m-d"); ?>" required><br>

                <input type="submit" name="view_attendance" value="View Attendance">
            </div>
        </form>

        <!-- ------------Form as modal for export attendance record--------------- -->
        <form action="export-by-spreadsheet.php" id="openModal-export[<?php echo $i ?>]" method="POST" class="modalDialog">

            <input type="hidden" name="course[<?php echo $i ?>]" value="<?php echo $row['course'] ?>">
            <input type="hidden" name="branch[<?php echo $i ?>]" value="<?php echo $row['branch'] ?>">
            <input type="hidden" name="semester[<?php echo $i ?>]" value="<?php echo $row['semester'] ?>">
            <input type="hidden" name="section[<?php echo $i ?>]" value="<?php echo $row['section'] ?>">
            <input type="hidden" name="subjectname[<?php echo $i ?>]" value="<?php echo $row['subjectname']?>">
            <input type="hidden" name="subjectcode[<?php echo $i ?>]" value="<?php echo $row['subjectcode']?>">

            <div>
                <a href="#close" title="Close" class="close">X</a>
                <h2>Export Attendance </h2>
                <b>Enter the starting date you want to export the record!</b><br>
                <input type="date" name="startdate[<?php echo $i ?>]" min="2020-08-11" max="<?php  echo date("Y-m-d"); ?>" required><br>

                <b>Enter the last date you want to export the record!</b><br>
                <input type="date" name="enddate[<?php echo $i ?>]" min="2020-08-11" max="<?php  echo date("Y-m-d"); ?>" required><br>

                <input type="submit" name="export_attendance" value="Export Attendance">
            </div>
        </form>
        <?php
}
}
?>
</div>

<!--------- Footer -------->
<footer >
    <div class="footer">
        <a href="https://www.instagram.com/its_ashish_52/"><i class="fa fa-instagram fa-2x" aria-hidden="true"></i></a>
        <a href="https://twitter.com/DevloperAshish"><i class="fa fa-twitter fa-2x" aria-hidden="true"></i></a>
        <a href="https://www.facebook.com/Aeshtech52"><i class="fa fa-facebook fa-2x" aria-hidden="true"></i></a>
        <hr><br>
        <span>&copy 2020 DigiVGI. All rights reserved</span>
    </div>
</footer>

</body>

</html>