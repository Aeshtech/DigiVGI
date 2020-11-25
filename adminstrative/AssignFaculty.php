<?php
  require('config.php');
  require_once('action4.php');
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
        <a href="Faculty.php">Faculty</a>
        <a href="Student.php">Student</a>
        <a href="AssignFaculty.php" class="active">Assign Faculty</a>
        <a href="About.php">About us</a>


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
                            <a href="assignfaculty.php?id=<?php echo $row['id'] ?>" class="update">Update</a>
                            <a href="action4.php?delete=<?php echo $row['id'] ?>" class="delete"
                                onclick="return confirm('Are you sure to delete this record?')">Delete</a>
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
            <form action="action4.php" method="post" autocomplete="off">
                <div>
                    <input type="hidden" name="id" value="<?= $id;?>">
                    <!-- <label>Course:</label>
                    <select name="course" required id="course">
                        <option value='' selected disabled>select</option>
                        <option value="B.Tech" <?php if($course=='B.Tech'){echo "selected";} ?>> B.Tech </option>
                        <option value="B.Pharma" <?php if($course=='B.Pharma'){echo "selected";} ?>> B.Pharma </option>
                        <option value="Polytechnic" <?php if($course=='Polytechnic'){echo "selected";} ?>> Polytechnic
                        </option>
                        <option value="B.BA" <?php if($course=='B.BA'){echo "selected";} ?>> B.BA </option>
                        <option value="B.Sc" <?php if($course=='B.Sc'){echo "selected";} ?>> B.Sc </option>
                        <option value="M.Tech" <?php if($course=='M.Tech'){echo "selected";} ?>> M.Tech </option>
                        <option value="M.Pharma" <?php if($course=='M.Pharma'){echo "selected";} ?>> M.Pharma </option>
                        <option value="M.BA" <?php if($course=='M.BA'){echo "selected";} ?>> M.BA </option>
                        <option value="M.Sc" <?php if($course=='M.Sc'){echo "selected";} ?>> M.Sc </option>
                    </select>
                </div>
                <div>
                    <label>Branch:</label>
                    <select name="branch" required id="branch">
                        <option value='None' selected <?php if($branch=='none'){echo "selected";} ?>>None</option>
                        <option value="CSE" <?php if($branch=='CSE'){echo "selected";} ?>>Computer Science & Engg.</option>
                        <option value="EE" <?php if($branch=='EE'){echo "selected";} ?>>Electrical Engg.</option>
                        <option value="EEE" <?php if($branch=='EEE'){echo "selected";} ?>>Electrical & Elecronics Engg.</option>
                        <option value="ME" <?php if($branch=='ME'){echo "selected";} ?>>Mechanical Engg.</option>
                        <option value="CIVIL" <?php if($branch=='CIVIL'){echo "selected";} ?>>Civil Engg.</option>
                    </select>
                </div> -->
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
                    <select name="c-permit" required style="width:70px;height:25px;border-radius:5px;">
                        <option value='no' selected <?php if($cpermit=='no'){echo "selected";} ?>>NO</option>
                        <option value="yes" <?php if($cpermit=='yes'){echo "selected";} ?>>Yes</option>
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