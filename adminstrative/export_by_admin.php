<!-- ===================================================================JAI SHREE KRISHNA=================================================== -->
<?php  
require('config.php');

if(isset($_POST['export_attendance'])){
    $subjectname = $_POST['subjectname'];
    $course = $_POST['course'];
    $branch = $_POST['branch'];
    $semester = $_POST['semester'];
    $section = $_POST['section'];
    $startdate = $_POST['startdate'];
    $lastdate = $_POST['lastdate'];

    $query = "SELECT `status`,`roll_no`,`student_name`,`date` FROM `attendance` WHERE `subject_name`='$subjectname' AND `course`='$course' AND `branch`='$branch' AND `semester`='$semester' AND `section`='$section' AND `date` BETWEEN '$startdate' AND '$lastdate' ORDER BY `date`";
    $result = mysqli_query($conn,$query);

    $html='<table><thead>---DIGIVGI ATTENDANCE---<br>Course-'.$course.' Branch-'.$branch.'<br>Subject Name- '.$subjectname.'<br>Semester- '.$semester.'  Section- '.$section.'<br>From '.$startdate.' To '.$lastdate.'</thead><tr><br><td>Date</td><td>Roll-No</td><td>Student-Name</td><td>Status</td></tr>';

    while($row=mysqli_fetch_assoc($result)){
        $html.='<tr><td>'.$row['date'].'</td><td>'.$row['roll_no'].'</td><td>'.$row['student_name'].'</td><td>'.$row['status'].'</td></tr>';
    }
    $html.='</table>';
    header('Content-Type:application/xls');
    header('Content-Disposition:attachment;filename='.$subjectname.'.xls');
    echo $html;
}
?>