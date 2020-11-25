<!-- ===================================================================JAI SHREE KRISHNA=================================================== -->
<?php
  include('config.php');
  require('action2.php');
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    $admin_course = $pro['course'];
    $admin_branch = $pro['branch'];

    ?>
        <!-- ===============Navigation Bar========================== -->
        <div class="topnav" id="myTopnav">
            <a href="index.php">Home</a>
            <a href="Faculty.php">Faculty</a>
            <a href="Student.php" class="active">Student</a>
            <a href="AssignFaculty.php">Assign Faculty</a>
            <a href="About.php">About us</a>

            <div class="profile_div">
                <span class="profile_name"><?php echo $username;?></span>
                <div class="dropdown">
                    <div class="profile"><img src="<?=$profile;?>"></div>
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
    <!------ -----------Dynamic table---------------->
    <div class="row admin-dashboard">

        <div class="grid-item1 input-icons ">
            <i class="fa fa-search  icon" style="top: 111px;"></i>
            <input class="input-field" type="text" onkeyup="filterTable2(event)" placeholder="-------Quick-Search--------">
        </div>

        <!-----List of Students----->
        <div class="grid-item2">
            <div class="input-icons">
                <i class="fa fa-search  icon"></i>
                <input type="text" onkeyup="filterTable2(event)" placeholder="--------Quick-Search-------">
            </div>
            <h1>Student List</h1>
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

            <table class="List" id="studentList">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Registration</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Branch</th>
                        <th>Semester</th>
                        <th>Section</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Gender</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM `student` WHERE `course`='$admin_course' AND `branch`='$admin_branch'";
                    $result = mysqli_query($conn, $sql); 
                    if(mysqli_num_rows($result)>0){     // mysqli_num_rows() return total count of rows!
                        while($row = mysqli_fetch_assoc($result)){
                    ?>
                    <tr>
                        <td><img src="<?php echo $row['photo'] ?>"
                                style="width: 40px;height: 40px;border-radius: 50%;border: 2px solid var(--primary);">
                        </td>
                        <td><?php echo $row['registration'] ?></td>
                        <td><?php echo $row['name'] ?></td>
                        <td><?php echo $row['course'] ?></td>
                        <td><?php echo $row['branch'] ?></td>
                        <td><?php echo $row['semester'] ?></td>
                        <td><?php echo $row['section'] ?></td>
                        <td><?php echo $row['email'] ?></td>
                        <td><?php echo $row['phone'] ?></td>
                        <td><?php echo $row['gender'] ?></td>
                        <td class="text-center">
                            <a href="show2.php?id=<?php echo $row['id'] ?>" class="show">Details</a>
                            <a href="Student.php?id=<?php echo $row['id'] ?>" class="update">Update</a>
                            <a href="action2.php?delete=<?php echo $row['id'] ?>" class="delete"
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

        <!------------------------Add Student Form----------------- -->
        <div class="grid-item3 form">
            <h1>Add Student</h1>
            <!---- Input form--- -->
            <form action="action2.php" method="post" enctype="multipart/form-data" autocomplete="off">
                <div>
                    <input type="hidden" name="id" value="<?= $id;?>">
                    <input type="hidden" name="user_type" value="student">
                    <label>Full Name*:</label>
                    <label class="validation-error hide" id="studentNameValidationError">This field is required.</label>
                    <input type="text" name="name" id="studentFullName" placeholder="-----Full Name-----"
                        value="<?= $name;?>" required>
                </div>
                <div>
                    <label>Regitration No:</label>
                    <input type="text" maxlength="10" minlength="10" required name="registration" id="registrationNo"
                        placeholder="-----Registration No-------" value="<?= $reg;?>">
                </div>
                
                <div>
                    <label for="semester">Semester:</label>
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
                    <label for="section">Section:</label>
                    <select name="section" required id="section">
                        <option value='None' selected <?php if($section=='None'){echo "selected";} ?>>None</option>
                        <option value="A" <?php if($section=='A'){echo "selected";} ?>> A</option>
                        <option value="B" <?php if($section=='B'){echo "selected";} ?>> B </option>
                        <option value="C" <?php if($section=='C'){echo "selected";} ?>> C </option>
                    </select>
                </div>
                <div>
                    <label>Email-ID:</label>
                    <input type="text" name="email" required id="studentEmail" placeholder="-----Email-Id----"
                        value="<?= $email;?>">
                </div>
                <div>
                    <label>Contact No:</label>
                    <input type="text" required maxlength="10" minlength="10" name="phone" id="studentContactNo"
                        placeholder="-----Contact No----" value="<?= $phone;?>">
                </div>
                <div>
                    <label>Gender:</label>
                    <select name="gender" required="required" id="gender">
                        <option value='' selected disabled>select</option>
                        <option value="male" <?php if($gender=='male'){echo "selected";} ?>> Male </option>
                        <option value="female" <?php if($gender=='female'){echo "selected";} ?>> Female </option>
                        <option value="not-defined" <?php if($gender=='not-defined'){echo "selected";} ?>> Not Defined
                        </option>
                    </select>
                </div>
                <div>
                    <label>Password:</label>
                    <input type="text" maxlength="12" minlength="4" name="password" id="studentPassword"
                        placeholder="-----Password----">
                    <input type="hidden" name="oldpassword" value="<?=$password; ?>">
                    <!---for retain oldpassword if not set on update operation--->
                </div>
                <div class="photodiv">
                    <input type="hidden" name="oldimage" value="<?=$photo; ?>">
                    <label>
                        choose Photo
                        <input type="file" name="photo" required id="photo" onchange="loadfile(event)"
                            style="display:none;">
                    </label>
                    <img src="<?= $photo; ?>" id="output">
                </div>
                <div>
                    <?php if($update==true){ ?>
                    <input type="submit" value="Update Record" name="update">

                    <!-- ---This will remove required attribute from file input when updating so the user not have to set image again if no need! -->
                    <script>
                    let sharmaji = document.querySelector('#photo');
                    if (sharmaji) {
                        sharmaji.removeAttribute('required');
                    }
                    </script>
                    <?php } else{ ?>
                    <input type="submit" value="Add Record" name="submit">
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>

    <script src="myapp.js"></script>
    <script>
    // to load image in img #output on select file input.
    var loadfile = function(event) {
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
    };
    </script>
</body>

</html>