<?php
require("template.php");
include("dir_adminAction.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View & Make Admin</title>
    <link rel="stylesheet" type="text/css" href="../adminstrative/styles/V2.css">
</head>
<body>
<div id="dir_main">


<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalScrollable" style="margin: 15px;font-weight:bold;">
Admin Form</button>
<?php
        if(isset($_SESSION['success_mssg'])&& $_SESSION['success_mssg'] !=''){
            echo '<span class="success_mssg">'.$_SESSION['success_mssg'].'</span>';
            unset($_SESSION['success_mssg']);
        }
        if(isset($_SESSION['common_mssg'])&& $_SESSION['common_mssg'] !='')
        {
            echo '<span class="common_mssg">'.$_SESSION['common_mssg'].'</span>';
            unset($_SESSION['common_mssg']);
        }
?><br>


<!-- Modal -->
<div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Admin Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


      <div class="update_profile">
        <img id="output" src="<?= $photo; ?>"><br>
        
        <!-- form in the modal body for creation and updation of admin course wise.  -->
        <form method="POST" action="dir_adminAction.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=$id;?>">
            
            <input type="file" name="photo" id="file" onchange="loadfile(event)" style="display: none;" required>
            <!-- input 'file' field display hidden for profile photo, label will work as input element -->
            <div class="label" style="margin:10px auto 20px;">
              <label for="file" style="cursor:pointer;" class="btn-primary">Choose profile photo</label>
            </div><br>
            <input type="hidden" name="oldimage" value="<?=$oldimage;?>">

            <label>Course
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
            </label><br>

            <label>Branch:
                    <select name="branch" required id="branch">
                        <option value='None' selected <?php if($branch=='none'){echo "selected";} ?>>None</option>
                        <option value="CSE" <?php if($branch=='CSE'){echo "selected";} ?>>Computer Science & Engg.</option>
                        <option value="EE" <?php if($branch=='EE'){echo "selected";} ?>>Electrical Engg.</option>
                        <option value="EEE" <?php if($branch=='EEE'){echo "selected";} ?>>Electrical & Elecronics Engg.</option>
                        <option value="ME" <?php if($branch=='ME'){echo "selected";} ?>>Mechanical Engg.</option>
                        <option value="CIVIL" <?php if($branch=='CIVIL'){echo "selected";} ?>>Civil Engg.</option>
                    </select>
            </label><br>

            <label>Name<input type="text" name="name" placeholder="------Enter New Admin Name------ " value="<?=$name; ?>" required></label><br>

            <label>Phone<input type="text" name="phone" maxlength="10" minlength="10" placeholder="------Enter Phone No------" value="<?=$phone; ?>" required></label><br>

            <label>Email<input type="email" name="email" placeholder="-------Enter Valid Emaill-Id-------" value="<?=$email; ?>" required></label><br>

            <label >Password
            <input type="Password" name="newPassword" placeholder="-------Enter New Password------" >
            </label><br>
            <input type="hidden" name="oldpassword" value="<?=$password; ?>">

            <?php if($update==true){ ?>
              <button type="submit" class="btn btn-success" name="update">Update Record</button>
              <!-- ---this will remove 'required' attribute from file input when updating so the user not have to set image again if no need! -->
              <script>
              var sharmaji = document.querySelector('#file');
              if (sharmaji){
                  sharmaji.removeAttribute('required');
              }
              </script>
              <?php } else{ ?>
                <button type="submit" class="btn btn-primary" name="submit">Add Record</button>
              <?php } ?>
        </form>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- -------Modal end-------- -->


<!-- =================================Table Start======================= -->
<div class="search-div">
    <input type="text" onkeyup="filterTable(event)" placeholder="------Quick-Search------">
</div>
<!-----List of Faculty ----->
<div class="grid-item2">

    <h2>Admin List</h2>

    <table class="List" id="facultyList">
      <thead>
        <tr>
            <th>Photo</th>
            <th>Full Name</th>
            <th>Contact No</th>
            <th>Course</th>
            <th>Branch</th>
            <th>Email</th>
            <th>Active</th>
            <th>Action</th>
        </tr>
      </thead>
      <tbody>

        <?php
          $sql = "SELECT * FROM `admin`";
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
          <td><?php echo $row['email'] ?></td>
          <td><?php echo $row['isactive'] ?></td>
          <td class="text-center">
            <a href="dir_admin.php?id=<?php echo $row['id'] ?>"class="update"><b>Update</b></a>
            <a href="dir_adminAction.php?delete=<?php echo $row['id'] ?>" class="delete" onclick="return confirm('Are you sure to delete this record?')"><b>Delete</b></a>
          </td>
        </tr>
        <?php
          }
        }
        ?>
        </tbody>
      </table>
    </div>

</div>
</body>
<script>
 
var loadfile = function(event) {
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
    };
</script>
<script type="text/javascript" src="../adminstrative/myapp.js"></script>
</html>