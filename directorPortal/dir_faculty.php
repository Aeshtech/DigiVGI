<?php
require("template.php");
include("dir_facultyAction.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View & Make Admin</title>
    <link rel="stylesheet" type="text/css" href="../adminstrative/styles/V2.css">
    <script type="text/javascript" src="../adminstrative/myapp.js"></script>
    <style>
        .grid-item3 label{
            color: black;
        }
        .grid-item3 input,#gender{
            color: black;
            border: 2px solid black;
            font-size: 15px;
        }
    </style>
</head>
<body>
<div id="dir_main">

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalScrollable" style="margin: 15px;font-weight:bold;">Faculty Form</button>
<?php
        if(isset($_SESSION['success_mssg'])&& $_SESSION['success_mssg'] !=''){
            echo "<span class='success_mssg'>".$_SESSION['success_mssg']."</span>";
            unset($_SESSION['success_mssg']);
        }
        if(isset($_SESSION['common_mssg'])&& $_SESSION['common_mssg'] !='')
        {
            echo '<span class="common_mssg">'.$_SESSION['common_mssg'].'</span>';
            unset($_SESSION['common_mssg']);
        }
?><br>


<!-- ----------Modal Start--------- -->
<div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Faculty Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
<!------------------------Add Faculty Form----------------- -->
  <div class="grid-item3 form" >
    <!---- Input form--- -->
    <form action="dir_facultyAction.php" method="post" enctype="multipart/form-data" autocomplete="off">
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

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- -===================Modal End================= -->



<!-- =================================Table Start======================= -->
<div class="search-div">
    <input type="text" onkeyup="filterTable(event)" placeholder="------Quick-Search------">
</div>
<!-----List of Faculty ----->
<div class="grid-item2">

    <h2>Faculty List</h2>

    <table class="List" id="facultyList">
      <thead>
        <tr>
            <th>Photo</th>
            <th>Full Name</th>
            <th>Contact No</th>
            <th>Email</th>
            <th>Active</th>
            <th>Action</th>
        </tr>
      </thead>
      <tbody>

        <?php
          $sql = "SELECT * FROM `faculty`";
          $result = mysqli_query($conn, $sql);  
        	if(mysqli_num_rows($result)>0){     // mysqli_num_rows() return total count of rows!
          		while($row = mysqli_fetch_assoc($result)){
          ?>
        <tr>
          <td><img src="<?php echo $row['photo'] ?>" style="width: 40px;height: 40px;border-radius: 50%;border: 2px solid var(--primary);"></td>
          <td><?php echo $row['name'] ?></td>
          <td><?php echo $row['phone'] ?></td>
          <td><?php echo $row['email'] ?></td>
          <td><?php echo $row['isactive'] ?></td>
          <td class="text-center">
            <a href="dir_faculty.php?id=<?php echo $row['id'] ?>" class="update">Update</a>
            <a href="dir_facultyAction.php?delete=<?php echo $row['id'] ?>" class="delete" onclick="return confirm('Are you sure to delete this record?')">Delete</a>
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
</html>