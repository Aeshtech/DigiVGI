<!-- ===================================================================JAI SHREE KRISHNA=================================================== -->
<?php
session_start();
if(!$_SESSION['username_admin'])
{
    header('Location: ../index.php');
}
  require_once('config.php');
  $upload = 'uploads/';

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "select * from faculty where id=".$id;
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
    }else {
      $errorMsg = 'Could not Find Any Record';
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>PHP CRUD</title>
    <link rel="stylesheet" href="styles/V2.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" charset="utf-8"></script>
  </head>
  <body>

  <!-- ==============================DigiVGI-Header================= -->
  <header>
        <div class="logodiv">
            <h1>Digi VGI</h1>
            <img src="vgi-logo.jpg" id="logo" style="left: 55%;top:14px">
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

      <div class="container" style="margin-top:150px;">
        <div class="row justify-content-center">
          <div class="card">
            <div class="card-header">
            <h5><i class="fa fa-user-tag">
              <span><?php echo $row['name'] ?></span></i>
            </h5>
            </div>
            <div class="card-body">
              <div class="row" style="margin-top:0px;"> <!-- Using inline style bcoz in custom-css i gave top-margin 100 to row which affects boots class row -->
                <div class="col-md">
                    <img src="<?php echo $row['photo'] ?>" height="200">
                </div>
                <div class="col-md">
                    <h5 class="form-control"><i class="fa fa-mobile-alt">
                      <span><?php echo $row['phone'] ?></span>
                    </i></h5>

                    <h5 class="form-control"><i class="fa fa-venus-mars">
                      <span><?php echo $row['gender'] ?></span>
                    </i></h5>

                    <h5 class="form-control"><i class="fa fa-envelope">
                      <span><?php echo $row['email'] ?></span>
                    </i></h5>

                      <a class="btn btn-outline-danger" href="faculty.php"><i class="fa fa-sign-out-alt"></i><span>Back</span></a>

                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <script src="js/bootstrap.min.js" charset="utf-8"></script>
      <script src="https://code.jquery.com/jquery-3.3.1.min.js" charset="utf-8"></script>
    </body>
  </html>
