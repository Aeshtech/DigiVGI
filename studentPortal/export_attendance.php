<!-- ===================================================JAI SHREE KRISHNA======================================= -->
<?php
require('../adminstrative/config.php');

foreach ($_POST['subjectcode'] as $key => $subject_code){
        $subject_name = $_POST['subjectname'][$key];
        $course = $_POST['course'][$key];
        $semester = $_POST['semester'][$key];
        $section = $_POST['section'][$key];
        $startdate = $_POST['startdate'][$key];
        $enddate = $_POST['enddate'][$key];
        $roll_no = $_POST['roll_no'][$key];
        $student_name = $_POST['student_name'][$key];

        $query = "SELECT `status`,`date` FROM `attendance` WHERE `subject_code`='$subject_code' AND `roll_no`='$roll_no' AND `course`='$course' AND `semester`='$semester' AND `section`='$section' AND `date` BETWEEN '$startdate' AND '$enddate' ORDER BY `date`";
        $result = mysqli_query($conn,$query);
    }
        $html='<table>
        <thead>---DIGIVGI ATTENDANCE---<br>Subject '.$subject_name.'-'.$subject_code.'<br>Student Name-'.$student_name.'<br>Roll No-'.$roll_no.'<br>From '.$startdate.' To '.$enddate.'</thead>
        <tr><td>Date</td><td>Status</td></tr>';
        while($row=mysqli_fetch_assoc($result)){
            $html.='<tr><td>'.$row['date'].'</td><td>'.$row['status'].'</td></tr>';
        }
        $html.='</table>';
        header('Content-Type:application/xls');
        header('Content-Disposition:attachment;filename='.$subject_name.'.xls');
        echo $html;
?>