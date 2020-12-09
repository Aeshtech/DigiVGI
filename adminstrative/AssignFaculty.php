<?php
require('config.php');
session_start();
if(!$_SESSION['username_admin'])
{
    header('Location: ../index.php');
}
require("config.php");

$username = $_SESSION['username_admin'];
$sql = "SELECT `course`,`branch` FROM `admin` WHERE `email`='$username'";
$rslt = mysqli_query($conn,$sql);
$pro = mysqli_fetch_assoc($rslt);
$admin_course =$pro['course'];
$admin_branch =$pro['branch'];

$update=false;
$course="";
$branch="";
$semester="";
$section="";
$facultyname="";
$facultyid="";
$subjectname="";
$subjectcode="";
$cpermit="";


/*------------For inserting record in database--------- */
if(isset($_POST['submit'])){
    $semester = $_POST['semester'];
    $section = $_POST['section'];
    $facultyname = $_POST['facultyname'];
    $facultyid = $_POST['facultyid'];
    $facultyid = filter_var($facultyid,FILTER_SANITIZE_EMAIL);
    $subjectname = trim($_POST['subjectname']);
    $subjectcode = trim($_POST['subjectcode']);
    $confirm_sub_code = trim($_POST['confirm_sub_code']);
    $cpermit = $_POST['cpermit'];

    if(!preg_match("/^[a-zA-Z- ']*$/",$facultyname)){
		$_SESSION['error'] = "Name can only contain letters and white space!";
    }else if(isset($facultyid) && ($facultyid=="")){
		$_SESSION['error'] = "Faculty Id should not be empty!!";
	}else if(filter_var($facultyid,FILTER_VALIDATE_EMAIL) != TRUE){
		$_SESSION['error'] = 'Please enter valid email address!';
	}else if($subjectcode==""){
        $_SESSION['error'] = 'Subject code should not be empty!';
    }else if($confirm_sub_code==""){
        $_SESSION['error'] = 'Subject code confirmation should not be empty!';
    }else if($subjectcode != $confirm_sub_code){
        $_SESSION['error'] = "Subject code confirmation doesn't match!";
    }else{
        $query = "INSERT INTO `assignfaculty`(`course`,`branch`,`semester`,`section`,`facultyname`,`facultyid`,`subjectname`,`subjectcode`,`cpermit`)VALUES('$admin_course','$admin_branch','$semester','$section','$facultyname','$facultyid','$subjectname','$confirm_sub_code','$cpermit')";
        if(mysqli_query($conn,$query)){
            $_SESSION['status'] = 'Successfully inserted!';
        }
    }
}

/*------------For deleting record from database--------- */
if(isset($_POST['delete'])){
	$id = $_POST['delete'];
    $sql = "delete from assignfaculty where id =".$id;
    $result = mysqli_query($conn, $sql);
    if($result){
        $_SESSION['status'] = 'Successfully Deleted!';
    }
}


/*-------------------------------- updating record-------------------------  */

if(isset($_POST['update_id'])){
	$id = $_POST['id'];
	

// fetching record from db based on id and assigining below into variables which is working as value for 'form' in assignfaculty.php!
$query = "SELECT * FROM `assignfaculty` WHERE id = '$id' ";
$result=mysqli_query($conn,$query);
$numRows = mysqli_num_rows($result);
if($numRows==1){
    $row = mysqli_fetch_assoc($result);
    
    $semester = $row['semester'];
    $section = $row['section'];
    $facultyname = $row['facultyname'];
    $facultyid = $row['facultyid'];
    $subjectname = $row['subjectname'];
    $subjectcode = $row['subjectcode'];
    $cpermit = $row['cpermit'];
    $update=true;
}
}

/*================================Updating Record==================================== */

// we are using Php procedural oriented approach here for updating record.

if(isset($_POST['update'])){
    $id = $_POST['id'];
    $semester = $_POST['semester'];
    $section = $_POST['section'];
    $facultyname = $_POST['facultyname'];
    $facultyid = $_POST['facultyid'];
    $facultyid = filter_var($facultyid,FILTER_SANITIZE_EMAIL);
    $subjectname = trim($_POST['subjectname']);
    $subjectcode = trim($_POST['subjectcode']);
    $confirm_sub_code = trim($_POST['confirm_sub_code']);
    $cpermit = $_POST['cpermit'];

    if(isset($facultyid) && ($facultyid=="")){
		$_SESSION['error'] = "Faculty Id should not be empty!!";
	}else if(filter_var($facultyid,FILTER_VALIDATE_EMAIL) != TRUE){
		$_SESSION['error'] = 'Please enter valid email address!';
	}else if($subjectcode==""){
        $_SESSION['error'] = 'Subject code should not be empty!';
    }else if($confirm_sub_code==""){
        $_SESSION['error'] = 'Subject code confirmation should not be empty!';
    }else if($subjectcode != $confirm_sub_code){
        $_SESSION['error'] = "Subject code confirmation doesn't match!";
    }else{
        $query = "UPDATE `assignfaculty` set `semester`='$semester', `section`='$section',`facultyname`='$facultyname',`facultyid`='$facultyid', `subjectname`='$subjectname', `subjectcode`='$confirm_sub_code',`cpermit`='$cpermit' WHERE `id`='$id'";
        $result= mysqli_query($conn,$query);
        if(mysqli_affected_rows($conn)==1){
            $_SESSION['status'] = 'Successfully Updated !';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://kit.fontawesome.com/471f9934c1.js"></script>
    <link rel="stylesheet" href="styles/V2.css">
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
    $sql = "SELECT `photo`,`course`,`branch` FROM `admin` WHERE `email`='$username'";
    $rslt = mysqli_query($conn,$sql);
    $pro = mysqli_fetch_assoc($rslt);
    $profile = $pro['photo'];
    $admin_course =$pro['course'];
    $admin_branch =$pro['branch'];

    ?>
    <!-- ===============Navigation Bar========================== -->
    <div class="topnav" id="myTopnav">
        <a href="index.php">Home</a>
        <a href="Student.php">Student</a>
        <a href="AssignFaculty.php" class="active">Assign Faculty</a>
        <a href="About.php">About us</a>


        <div class="profile_div">
            <span class="profile_name"><?php echo $username;?></span>
            <div class="dropdown">
                <div class="profile"><img src="../directorPortal/<?=$profile;?>"></div>
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


    <!-- =============================Dynamic table=============================-->

    <div class="row admin-dashboard">

        <div class="grid-item1 input-icons ">
            <i class="fa fa-search  icon" style="top: 111px;"></i>
            <input class="input-field" type="text" onkeyup="filterTable4(event)" placeholder="---Search---">
        </div>

        <!-- ===============================List of Faculty=====================  -->
        <div class="grid-item2">

            <div class="input-icons">
                <i class="fa fa-search  icon"></i>
                <input type="text" onkeyup="filterTable4(event)" placeholder="---------Search---------">
            </div>
            <h1>Assigned Faculty List</h1>
            <!-- Status of operations perform on Record -->
            <div id="success_status">
            <?php
            if(isset($_SESSION['status'])&& $_SESSION['status'] !='')
            {
            echo '<b>'.$_SESSION['status'].'</b>';
                unset($_SESSION['status']);
            }
            ?>
            </div>
            <div id="failed_status">
            <?php
            if(isset($_SESSION['error'])&& $_SESSION['error'] !='')
            {
            echo '<b>'.$_SESSION['error'].'</b>';
                unset($_SESSION['error']);
            }
            ?>
            </div>
            

            <table class="List" id="assignSubjectList">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Branch</th>
                        <th>Semester</th>
                        <th>Section</th>
                        <th>Faculty name</th>
                        <th>Faculty id</th>
                        <th>Subject Name</th>
                        <th>Subject Code</th>
                        <th>C-Permit</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM `assignfaculty` WHERE `course`='$admin_course' AND `branch`='$admin_branch'";
                    $result = mysqli_query($conn, $sql); 
                    if(mysqli_num_rows($result)>0){               // mysqli_num_rows() return total count of rows!
                        while($row = mysqli_fetch_assoc($result)){
                    ?>
                    <tr>
                        <td><?php echo $row['course'] ?></td>
                        <td><?php echo $row['branch'] ?></td>
                        <td><?php echo $row['semester'] ?></td>
                        <td><?php echo $row['section'] ?></td>
                        <td><?php echo $row['facultyname'] ?></td>
                        <td><?php echo $row['facultyid'] ?></td>
                        <td><?php echo $row['subjectname'] ?></td>
                        <td><?php echo $row['subjectcode'] ?></td>
                        <td><?php echo $row['cpermit'] ?></td>
                        <td class="text-center">
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
                                <input type="hidden" name="id" value="<?php echo $row['id']?>">
                                <input type="submit" value="Update" name="update_id" class="update">
                            </form>
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
                                <input type="hidden" name="id" value="<?php echo $row['id']?>">
                                <input type="submit" value="Delete" name="delete" class="delete" onclick="return confirm('Are you sure to delete this record?')">
                            </form>
                        </td>
                    </tr>
                    <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>


        <!-- ========================= Input form==================== -->
        <div class="grid-item3 form">
            <h1>Assign Faculty</h1>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" autocomplete="off">
                <div>
                    <input type="hidden" name="id" value="<?= $id;?>">
                <div>
                    <label>Semester:</label>
                    <select name="semester" id="semester" required>
                        <option value='' selected disabled>select</option>
                        <option value="1" <?php if($semester=='1'){echo "selected";} ?>> 1</option>
                        <option value="2" <?php if($semester=='2'){echo "selected";} ?>> 2 </option>
                        <option value="3" <?php if($semester=='3'){echo "selected";} ?>> 3 </option>
                        <option value="4" <?php if($semester=='4'){echo "selected";} ?>> 4 </option>
                        <option value="5" <?php if($semester=='5'){echo "selected";} ?>> 5 </option>
                        <option value="6" <?php if($semester=='6'){echo "selected";} ?>> 6 </option>
                        <option value="7" <?php if($semester=='7'){echo "selected";} ?>> 7 </option>
                        <option value="8" <?php if($semester=='8'){echo "selected";} ?>> 8 </option>
                    </select>
                </div>
                <div>
                    <label>Section:</label>
                    <select name="section" required id="section">
                        <option value='None' selected <?php if($section=='None'){echo "selected";} ?>>None</option>
                        <option value="A" <?php if($section=='A'){echo "selected";} ?>> A</option>
                        <option value="B" <?php if($section=='B'){echo "selected";} ?>> B </option>
                        <option value="C" <?php if($section=='C'){echo "selected";} ?>> C </option>
                    </select>
                </div>
                <div>
                    <label>Faculty Name:</label>
                    <input type="text" name="facultyname" required placeholder="-----Faculty name-----"
                        value="<?= $facultyname;?>">
                </div>
                <div>
                    <label>Faculty Id:</label>
                    <input type="email" name="facultyid" required placeholder="-----Faculty id-----"
                        value="<?= $facultyid;?>">
                </div>
                <div>
                    <label>Subject Name:</label>
                    <input type="text" name="subjectname" required placeholder="-----Assign Subject ----"
                        value="<?= $subjectname;?>">
                </div>
                <div>
                    <label>Subject Code:</label>
                    <input type="text" name="subjectcode" required placeholder="-----Subject Code----"
                        value="<?= $subjectcode;?>">
                </div>
                <div>
                    <label>Subject Code confirm:</label>
                    <input type="text" name="confirm_sub_code" required  placeholder="-----Confirm subject code----"
                        value="<?= $subjectcode;?>">
                </div>
                <div>
                    <label>C-Permit (Attendance Update Permit):</label>
                    <select name="cpermit" required style="width:70px;height:25px;border-radius:5px;">
                        <option value='No' selected <?php if($cpermit=='No'){echo "selected";} ?>>No</option>
                        <option value="Yes" <?php if($cpermit=='Yes'){echo "selected";} ?>>Yes</option>
                    </select>
                </div>
                <div>
                    <?php if($update==true){ ?>
                    <input type="submit" value="Update Record" name="update">
                    <?php } else{ ?>
                    <input type="submit" value="Add Record" name="submit">
                    <?php }
                  ?>
                </div>
            </form>
        </div>
    </div>

    <script src="myapp.js"></script>
</body>

</html>