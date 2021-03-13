<?php 
require("template.php");
require('../adminstrative/config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../adminstrative/styles/V2.css">
</head>

<body>

    <?php
    $sql = "SELECT COUNT(`isactive`) FROM `admin` WHERE `isactive`='yes';";
    $sql.= "SELECT COUNT(`isactive`) FROM `faculty` WHERE `isactive`='yes';";
    $sql.= "SELECT COUNT(`isactive`) FROM `student` WHERE `isactive`='yes'";
    if (mysqli_multi_query($conn, $sql)) {
        do {
          // Store first result set
          if ($result = mysqli_store_result($conn)) {
              $i=0;
            while ($row = mysqli_fetch_row($result)) {
                $array[]= $row[$i];
            }
            mysqli_free_result($result);
          }
           //Prepare next result set
        } while (mysqli_next_result($conn));
      }
    ?>

    <div id="dir_index_container">
        <div id="activestatus_grid_container">
            <h1 style="font-weight: bold;">Active</h1>
            <div id="activestatus_grid_item">
                <h2>Admin</h2>
                <h1><?= $array[0] ?></h1>
            </div>
            <div id="activestatus_grid_item">
                <h2>Faculty</h2>
                <h1><?= $array[1] ?></h1>
            </div>
            <div id="activestatus_grid_item">
                <h2>Student</h2>
                <h1><?= $array[2] ?></h1>
            </div>
        </div>


        <div id="dir_index_item">
            <div class="dir_azax_input">
                <form>
                    <select name="users" id="dir_course">
                        <option value="">Select Course:</option>
                        <option value="B.Tech">B.Tech </option>
                        <option value="B.Pharma">B.Pharma</option>
                        <option value="B.Sc">B.Sc</option>
                        <option value="Polytechnic">Polytechnic</option>
                    </select>
                    <select name="semester" id="dir_semester">
                        <option value="" selected>Select Semester</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                    </select>
                    <select name="branch" id="dir_branch">
                        <option value="">Select Branch</option>
                        <option value="CSE">Computer Science</option>
                        <option value="ME">Mechanical</option>
                        <option value="EEE">EEE</option>
                        <option value="EE">EE</option>
                    </select>

                    <input type="date" id="dir_startdate">
                    <input type="date" id="dir_enddate">

                    <input type="button" onclick="showUser()" value="Filter">
                </form>
            </div>
            <hr>

            <div id="chart" style="display: inline-block;">
                <div id="wrapper">
                    <b style="color:darkviolet;margin-left:10px;font-size:18px;">Please select course, semester and date for which you want to see the attendance status.</b>

                    <h3>AeshTech</h3>
                    <!-- ----------------Spinner--------------------- -->
                    <div class="loading-spinner"></div>

                    <!-- ----------------Bounsing Balls-------------- -->
                    <div class="loading-dots">
                        <div class="bounce1"></div>
                        <div class="bounce2"></div>
                        <div class="bounce3"></div>
                    </div>
                </div>
            </div>

            <div class="dir_guide_container">
                <h2 style="text-align: center;color:darkviolet">Read me!!</h2>
                <ul>
                    <li>Hii, I am Ashish Sharma Chief Developer and Promoter of DigiVGI</li>
                    <li>This panel contains five input fields in top bar.</li>
                    <li>1. Course 2. Semester 3. Branch 4. Start Date 5. End Date.</li>
                    <li>You can easily track the status of whole college by providing above inputs.</li>
                    <li><b>You can track the status of entire course by leaving out semester and branch field.</b></li>
                </ul>
            </div>
        </div>
    </div>

</body>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="../adminstrative/myapp.js"></script>
</html>