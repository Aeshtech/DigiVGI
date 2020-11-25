<?php
  require('config.php');
  require('bootstrap.php');
  require('action3.php');
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

<body onload="preloader()">
    <!-- ===============================Preloader======================== -->

    <div id="wrapper">
        <h3 style="margin-top: 10px;">DigiVgi</h3>
        <!-- ----------------Spinner--------------------- -->
        <div class="loading-spinner"></div>

        <!-- ----------------Bounsing Balls-------------- -->
        <div class="loading-dots">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
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
        <a href="Course.php">Course</a>
        <a href="Subject.php" class="active">Subject</a>
        <a href="AssignFaculty.php">Assign Faculty</a>

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


    <!-- ======================Dynamic Table================ -->
    <div class="row admin-dashboard">

        <div class="grid-item1 input-icons ">
            <i class="fa fa-search  icon" style="top: 111px;"></i>
            <input class="input-field" type="text" onkeyup="filterTable3(event)" placeholder="---Search---">
        </div>

        <!--------------------------List of Subjects-------------------------->
        <div class="grid-item2">

            <div class="input-icons">
                <i class="fa fa-search  icon"></i>
                <input type="text" onkeyup="filterTable3(event)" placeholder="---------Search---------">
            </div>
            <h1>Subject List</h1>

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

            <table class="List" id="subjectList">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Semester</th>
                        <th>Section</th>
                        <th>Subject Name</th>
                        <th>Subject Code</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "select * from subject";
                    $result = mysqli_query($conn, $sql); 
                    if(mysqli_num_rows($result)>0){     // mysqli_num_rows() return total count of rows!
                        while($row = mysqli_fetch_assoc($result)){
                    ?>
                    <tr>
                        <td><?php echo $row['course'] ?></td>
                        <td><?php echo $row['semester'] ?></td>
                        <td><?php echo $row['section'] ?></td>
                        <td><?php echo $row['subjectname'] ?></td>
                        <td><?php echo $row['subjectcode'] ?></td>
                        <td class="text-center">
                            <a href="subject.php?id=<?php echo $row['id'] ?>" class="update">Update</a>
                            <a href="action3.php?delete=<?php echo $row['id'] ?>" class="delete"
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

        <!------------------------Add subject Form----------------- -->
        <div class="grid-item3 form">
            <h1>Add Subject</h1>
            <!---- Input form--- -->
            <form action="action3.php" method="post" autocomplete="off">
                <div>
                    <input type="hidden" name="id" value="<?= $id;?>">

                    <label>Course:</label>
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
                        <option value='' selected disabled>select</option>
                        <option value="A" <?php if($section=='A'){echo "selected";} ?>> A</option>
                        <option value="B" <?php if($section=='B'){echo "selected";} ?>> B </option>
                        <option value="C" <?php if($section=='C'){echo "selected";} ?>> C </option>
                    </select>
                </div>
                <div>
                    <label>Subject Name:</label>
                    <input type="text" name="subjectname" required placeholder="-----Subject Name-----"
                        value="<?= $subjectname;?>">
                </div>
                <div>
                    <label>Subject Code:</label>
                    <input type="text" name="subjectcode" required placeholder="-----Subject Code------"
                        value="<?= $subjectcode;?>">
                </div>
                <div>
                    <?php if($update==true){ ?>
                    <input type="submit" value="Update Record" name="update">
                    <?php } else{ ?>
                    <input type="submit" value="Add Record" name="submit">
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>

    <script src="myapp.js"></script>
</body>

</html>