<!-- ===================================================JAI SHREE KRISHNA======================================= -->
<?php
require('../adminstrative/config.php');

foreach ($_POST['subjectcode'] as $key => $subject_code){
        $subject_name = $_POST['subjectname'][$key];
        $course = $_POST['course'][$key];
        $branch = $_POST['branch'][$key];
        $semester = $_POST['semester'][$key];
        $section = $_POST['section'][$key];
        $startdate = $_POST['startdate'][$key];
        $enddate = $_POST['enddate'][$key];

        $query = "SELECT `status`,`roll_no`,`student_name`,`date` FROM `attendance` WHERE `subject_code`='$subject_code' AND `course`='$course' AND `branch`='$branch' AND `semester`='$semester' AND `section`='$section' AND `date` BETWEEN '$startdate' AND '$enddate' ORDER BY `date`";
        $result = mysqli_query($conn,$query);
    }
        $html='<table><thead>---DIGIVGI ATTENDANCE---<br>Course-'.$course.' Branch-'.$branch.'<br>Subject '.$subject_name.' -'.$subject_code.'<br>Sem-'.$semester.'  Section-'.$section.'<br>From '.$startdate.' To '.$enddate.'</thead><tr><br><td>Date</td><td>Roll-No</td><td>Student-Name</td><td>Status</td></tr>';

        while($row=mysqli_fetch_assoc($result)){
            $html.='<tr><td>'.$row['date'].'</td><td>'.$row['roll_no'].'</td><td>'.$row['student_name'].'</td><td>'.$row['status'].'</td></tr>';
        }
        $html.='</table>';
        header('Content-Type:application/xls');
        header('Content-Disposition:attachment;filename='.$subject_name.'.xls');
        echo $html;
?>