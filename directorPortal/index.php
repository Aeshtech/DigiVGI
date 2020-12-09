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

    
    <div id="activestatus_grid_container" >
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


</body>
</html>