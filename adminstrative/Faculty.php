<!-- ===================================================================JAI SHREE KRISHNA=================================================== -->
<?php
  require('config.php');
  require('action.php');
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
        <a href="Faculty.php" class="active">Faculty</a>
        <a href="Student.php">Student</a>
        <a href="AssignFaculty.php">Assign Faculty</a>
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

  
<!------ -----------Dynamic table---------------->
<div class="row admin-dashboard">
  <div class="grid-item1 input-icons">
  <i class="fa fa-search  icon" style="top: 111px;"></i>
    <input type="text" onkeyup="filterTable(event)" placeholder="--------Quick-Search---------">
  </div>
  
  <!-----List of Faculty ----->
  <div class="grid-item2">
    <div class="input-icons">
    <i class="fa fa-search  icon"></i>
    <input type="text" onkeyup="filterTable(event)" placeholder="------Quick-Search------">
  </div>

    <h1>Faculty List</h1>
    <!------------ Status of operations perform on Record -------------->
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

    <input type="button" value="Right"  onclick="scrollWinRight()">
    <input type="button" value="Left"  onclick="scrollWinLeft()">

    <table class="List" id="facultyList">
      <thead>
        <tr>
            <th>Photo</th>
            <th>Full Name</th>
            <th>Contact No</th>
            <th>Course</th>
            <th>Branch</th>
            <th>Gender</th>
            <th>Email</th>
            <!-- <th>Password</th> -->
            <th>Action</th>
        </tr>
      </thead>
      <tbody>

        <?php
          $sql = "SELECT * FROM `faculty` WHERE `course`='$admin_course' AND `branch`='$admin_branch'";
          $result = mysqli_query($conn, $sql);  
        	if(mysqli_num_rows($result)>0){     // mysqli_num_rows() return total count of rows!
          		while($row = mysqli_fetch_assoc($result)){
          ?>
        <tr>
          <td><img src="<?php echo $row['photo'] ?>" style="width: 40px;height: 40px;border-radius: 50%;border: 2px solid var(--primary);"></td>
          <td><?php echo $row['name'] ?></td>
          <td><?php echo $row['phone'] ?></td>
          <td><?php echo $row['course'] ?></td>
          <td><?php echo $row['branch'] ?></td>
          <td><?php echo $row['gender'] ?></td>
          <td><?php echo $row['email'] ?></td>
          <!-- <td><?php echo $row['password'] ?></td> -->
          <td class="text-center">
            <a href="show.php?id=<?php echo $row['id'] ?>" class="show">Details</a>
            <a href="Faculty.php?id=<?php echo $row['id'] ?>" class="update">Update</a>
            <a href="action.php?delete=<?php echo $row['id'] ?>" class="delete" onclick="return confirm('Are you sure to delete this record?')">Delete</a>
          </td>
        </tr>
        <?php
          }
        }
        ?>
        </tbody>
      </table>
    </div>

  <!------------------------Add Faculty Form----------------- -->
  <div class="grid-item3 form" >
    <h1>Add Faculty</h1>

    <!---- Input form--- -->
    <form action="action.php" method="post" enctype="multipart/form-data" autocomplete="off">
      <div> 
        <input type="hidden" name="id" value="<?= $id;?>" >
        <input type="hidden" name="user_type" value="faculty">
        <label>Full Name*:</label>
        <label class="validation-error hide" id="fullNameValidationError">This field is required.</label>
        <input type="text" name="name" id="fullName" required  placeholder="-----Full Name-----" value="<?= $name; ?>">
      </div>
      <div>
        <label>Contact No:</label>
        <input type="text" name="phone" maxlength="10" minlength="10" id="contactNo" required placeholder="-----Contact No----" value="<?= $phone; ?>">
      </div>
      <div>
        <label>Gender:</label>
        <select name="gender" required="required" id="gender" >
        <option value='' selected disabled>select</option>
        <option value="male" <?php if($gender=='male'){echo "selected";} ?>> Male </option>
        <option value="female" <?php if($gender=='female'){echo "selected";} ?>> Female </option>
        <option value="not-defined" <?php if($gender=='not-defined'){echo "selected";} ?>> Not Defined </option>
      </select>
      </div>
      <div>
        <label>Email-ID:</label>
        <input type="email" name="email" id="email" required placeholder="-----Email-id-------" value="<?= $email; ?>">
      </div>
      <div>
        <label>Password</label>
        <input type="text" name="password" id="password" placeholder="-----Password----">
        <input type="hidden" name="oldpassword" value="<?=$password; ?>">    <!---for retain oldpassword if not set on update operation--->
      </div>
      <div class="photodiv">
        <img src="<?= $photo; ?>" id="output" >
        <label>Choose Photo
        <input type="file" name="photo" required id="photo" onchange="loadfile(event)" style="display: none;">
        </label>
        <input type="hidden" name="oldimage" value="<?=$photo; ?>"> <!-------for unlink oldimage on update operation----------->
      </div>
      <div>
      <?php if($update==true){ ?>
        <input type="submit" value="Update Record" name="update">
        <!-- ---this will remove 'required' attribute from file input when updating so the user not have to set image again if no need! -->
        <script>
        var sharmaji = document.querySelector('#photo');
        if (sharmaji){
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
  function scrollWinRight(){
    window.scrollBy(460,0);
  }
  function scrollWinLeft(){
    window.scrollBy(-460,0);
  }
  
  // to load image in img #output on select file input.
  var loadfile = function(event) {
    var image = document.getElementById('output');
    image.src = URL.createObjectURL(event.target.files[0]);
    };

</script>
</body>
</html>