<!-- ===================================================================JAI SHREE KRISHNA=================================================== -->
<?php
  include('config.php');
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
$id="";
$reg="";
$name="";
$semester="";
$section="";
$phone="";
$gender="";
$email="";
$photo="default.jpg";
$password="";


function test_input($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
/*------------For inserting record in database--------- */
if(isset($_POST['submit'])){
	$user_type = $_POST['user_type'];
    $registration = $_POST['registration'];
    $name = $_POST['name'];
    $semester = $_POST['semester'];
    $section = $_POST['section'];
	$gender = $_POST['gender'];
	$email = $_POST['email'];
    $phone = $_POST['phone'];
	$email = filter_var($email,FILTER_SANITIZE_EMAIL);
	$email = test_input($email);
	$pwd = trim($_POST['password']);
	$password = password_hash($pwd,PASSWORD_BCRYPT);

	$imagetype = strtolower(pathinfo($_FILES['photo']['name'],PATHINFO_EXTENSION));    //taking extension from file name.

	if(!preg_match("/^[a-zA-Z- ']*$/",$name)){
		$_SESSION['error'] = "Name can only contain letters and white space!";
    }else if(!preg_match("/^\d{10}$/",$registration)){
		$_SESSION['error'] = "Registration no can only contain numberic value!";
    }else if(!preg_match("/^\d{10}$/",$phone)){
		$_SESSION['error'] = "Phone should contain only 10 digit valid number!";
    }else if(isset($pwd) && ($pwd=="")){
		$_SESSION['error'] = "Password should not be empty!!";
	}else if(strlen($pwd)<6){
		$_SESSION['error'] = "Password must include atleast six characters!";
	}else if(isset($email) && ($email=="")){
		$_SESSION['error'] = "Email should not be empty!!";
	}else if(filter_var($email,FILTER_VALIDATE_EMAIL) != TRUE){
		$_SESSION['error'] = 'Please enter valid email address!';
	}
	else if($imagetype!="jpg" && $imagetype!="jpeg" && $imagetype!="png"){
		$_SESSION['error'] = "Image should be in ('jpeg','jpg' or'png') only!";
	}
	else if($_FILES['photo']['size'] >= 500000){
		$_SESSION['error'] = 'Image size should be less than 500KB!';
	}else{
		$seprated = explode(".",$_FILES['photo']['name']);          //this will fetch name of the file from the $_FILES array and separate its by '.' period.
	    $newfilename = round(microtime(true)).'.'.end($seprated);  // this will generate a random no by microtime & round function and concenate it with extension taking by end() function from seprated filename! Use this to give each image file a unique name.
	    $upload = "uploads2/".$newfilename;          // assigning the path to variable.
		$tempname = $_FILES['photo']['tmp_name'];  //this will fetch temporary name of the file from the $_FILES array..!
		
		$query = "INSERT INTO `student`(`registration`,`name`,`phone`,`course`,`branch`,`semester`,`section`,`email`,`gender`,`password`,`photo`,`user_type`)VALUES('$registration','$name','$phone','$admin_course','$admin_branch','$semester','$section','$email','$gender','$password','$upload','$user_type')";
	    $result=mysqli_query($conn,$query);
		if($result){
			$_SESSION['status'] = 'Successfully Inserted!';
			move_uploaded_file($tempname,$upload);
		}
	}
}

/*------------For deleting record from database--------- */
if(isset($_POST['delete'])){
	$id = $_POST['id'];
	// this will remove photo from uploads directory also...!
	$sql = "select photo from student where id = ".$id;
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_assoc($result);
		$image = $row['photo'];
		unlink($image);

		// this will delete selected record from database permanently!
		$sql = "delete from student where id =".$id;
		if(mysqli_query($conn, $sql)){
			$_SESSION['status'] = 'Successfully Deleted!';
			header('location:student.php');
		}
	}
}

/*-------------------------For update record---------------------- */

  if(isset($_POST['update_id'])){
	$id = $_POST['id'];
	
	// fetching record from db based on id and assigining below into variables which is working as value for 'form' in student.php!
    $query = "SELECT * FROM student WHERE id =?";
    $stmt= $conn->prepare($query);
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $result=$stmt->get_result();
	$row=$result->fetch_assoc();

	$id=$row['id'];
    $reg=$row['registration'];
    $name=$row['name'];
	$phone = $row['phone'];
    $semester = $row['semester'];
    $section = $row['section'];
    $email = $row['email'];
    $gender = $row['gender'];
	$photo = $row['photo'];
	$password = $row['password'];
	$update=true;   //for change submit button of the form at student.php...!
  }
  if(isset($_POST['update'])){
	  $id = $_POST['id'];
	  $reg =$_POST['registration'];
	  $name = $_POST['name'];
	  $phone = $_POST['phone'];
	  $course = $admin_course;
	  $branch = $admin_branch;
      $semester = $_POST['semester'];
      $section = $_POST['section'];
	  $email = $_POST['email'];
	  $email = filter_var($email,FILTER_SANITIZE_EMAIL);
	  $email = test_input($email);
	  $gender = $_POST['gender'];
	  $oldimage = $_POST['oldimage'];
	  $oldpassword = $_POST['oldpassword'];
	  $pwd = $_POST['password'];

	  $imgtype = strtolower(pathinfo($_FILES['photo']['name'],PATHINFO_EXTENSION));
	  
	  if(!preg_match("/^[a-zA-Z- ']*$/",$name)){
		$_SESSION['error'] = "Name can only contain letters and white space!";
    }else if(!preg_match("/^\d{10}$/",$reg)){
		$_SESSION['error'] = "Registration no can only contain numberic value!";
    }else if(!preg_match("/^\d{10}$/",$phone)){
		$_SESSION['error'] = "Phone should contain only 10 digit valid number!";
    }else if(isset($_FILES['photo']['name']) && ($_FILES['photo']['name']!="") && ($imgtype!="jpg" && $imgtype!="jpeg" && $imgtype!="png")){
		$_SESSION['error'] = "Image should be in ('jpeg','jpg' or'png') only!";
	  }else if($_FILES['photo']['size'] >= 500000){
		  $_SESSION['error'] = 'Image size should be less than 500KB!';
	  }else if(filter_var($email,FILTER_VALIDATE_EMAIL) != TRUE){
		  $_SESSION['error'] = 'Please enter valid email address!';
		}
		else{
		  if(isset($_FILES['photo']['name']) && ($_FILES['photo']['name']!="")){
			  $seprated = explode(".",$_FILES['photo']['name']);
			  $newfilename = round(microtime(true)).'.'.end($seprated);
			  $upload = "uploads2/".$newfilename;
			  move_uploaded_file($_FILES['photo']['tmp_name'], $upload);
			  unlink($oldimage);
			}else{
				$upload=$oldimage;
			}
			if(isset($pwd) && ($pwd!="")){
				$password = password_hash($pwd,PASSWORD_BCRYPT);
			}
			else{	
				$password = $oldpassword;
			}
			$query="UPDATE `student` SET `registration`=?,`name`=?,`phone`=?,`semester`=?,`section`=?,`email`=?,`gender`=?, `password`=?,`photo`=? WHERE `id`=? ";
			$stmt=$conn->prepare($query);
			$stmt->bind_param("sssssssssi", $reg,$name,$phone,$semester,$section,$email,$gender,$password,$upload,$id);
			if($stmt->execute()){
				$_SESSION['status'] = 'Successfully Updated!';
			}
		}
	}
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
            <a href="Student.php" class="active">Student</a>
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
                            <form action="show2.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $row['id']?>">
                                <input type="submit" value="Details" name="show2"  class="show">
                            </form>
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

        <!------------------------Add Student Form----------------- -->
        <div class="grid-item3 form">
            <h1>Add Student</h1>
            <!---- Input form--- -->
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data" autocomplete="off">
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

     //for prevent resubmission of form accidentally.
     if(window.history.replaceState){
        window.history.replaceState(null,null,window.location.href);
    }
    </script>
</body>

</html>