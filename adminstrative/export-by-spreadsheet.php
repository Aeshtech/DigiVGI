<?php
//-----------------------------------------------JAI SHREE KRISHNA-----------------------------------------------!! 
session_start();
$_SESSION['username_admin'];

//call the autoload
require '../vendor/autoload.php';
//load phpspreadsheet class using namespaces
use PhpOffice\PhpSpreadsheet\Spreadsheet;
//call iofactory instead of xlsx writer
use PhpOffice\PhpSpreadsheet\IOFactory;
//phpspreadsheet Date class
use PhpOffice\PhpSpreadsheet\Shared\Date;
//phpspreadsheet numberformat style class
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
//rich text class
use PhpOffice\PhpSpreadsheet\RichText\RichText;
//phpspreadsheet style color
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Color\Conditional;

//make a new spreadsheet object
$spreadsheet = new Spreadsheet();
//get current active sheet (first sheet)
$sheet = $spreadsheet->getActiveSheet();

//set default font
$spreadsheet->getDefaultStyle()
			->getFont()
			->setName('Arial')
			->setSize(10);


require('../adminstrative/config.php');
$username = $_SESSION['username_admin'];
$sql = "SELECT `photo`,`course`,`branch` FROM `admin` WHERE `email`='$username'";
$rslt = mysqli_query($conn,$sql);
$pro = mysqli_fetch_assoc($rslt);
$profile = $pro['photo'];
$admin_course =$pro['course'];
$admin_branch =$pro['branch'];

if(isset($_POST['export_attendance'])){
    $subjectname = $_POST['subjectname'];
    // $course = $_POST['course'];
    // $branch = $_POST['branch'];
    $semester = $_POST['semester'];
    $section = $_POST['section'];
    $startdate = $_POST['startdate'];
    $lastdate = $_POST['lastdate'];
}   

// Fetching distinct date and set in spreadsheet on x axis 
$query1= "SELECT DISTINCT `date` FROM `attendance` WHERE `subject_name`='$subjectname' AND `course`='$admin_course' AND `branch`='$admin_branch' AND `semester`='$semester' AND `section`='$section' AND `date` BETWEEN '$startdate' AND '$lastdate' ORDER BY `date`";
$result1 = mysqli_query($conn,$query1);  
$result2 = mysqli_query($conn,$query1);  //we have to take result set twice as to use it again in nested loop because it free after single use only.
$total_date_count = mysqli_num_rows($result1);


// this loop runs till condition true and set column dimension to auto size.!!
$total_columns = $total_date_count +3;
$t=1;
$u='A';
while($t<=$total_columns){
    $spreadsheet->getActiveSheet()->getColumnDimension($u)->setAutoSize(true);
    $t++;
    $u++;
}

// this loop set total fetched dates values in upper most row..!!
$y='C';
while($row1=mysqli_fetch_object($result1)){
    $spreadsheet->getActiveSheet()
    ->setCellValue($y.'1', $row1->date);
    $y++;
}

// Fetching roll_no and student_name for to set these on y-axis i.e left most columns.
$query2 = "SELECT DISTINCT `roll_no`,`student_name` FROM `attendance` WHERE `subject_name`='$subjectname' AND `course`='$admin_course' AND `branch`='$admin_branch' AND `semester`='$semester' AND `section`='$section' AND `date` BETWEEN '$startdate' AND '$lastdate' ORDER BY `roll_no`,`student_name`,`date`";
$result3 = mysqli_query($conn,$query2);
$result4 = mysqli_query($conn,$query2);
$total_students_count = mysqli_num_rows($result3);


// this loop set total fetched students roll_no & names values in left most coloumns..!!
$x=2;
while($row3=mysqli_fetch_object($result3)){
    $spreadsheet->getActiveSheet()
    ->setCellValue('A'.$x, $row3->roll_no)
    ->setCellValue('B'.$x, $row3->student_name);
    $x++;
}

// Fetching status and set the status of each students corrosponding to date. 
$query3 = "SELECT `status` FROM `attendance` WHERE `subject_name`='$subjectname' AND `course`='$admin_course' AND `branch`='$admin_branch' AND `semester`='$semester' AND `section`='$section' AND `date` BETWEEN '$startdate' AND '$lastdate' ORDER BY `roll_no`,`student_name`,`date`";
$result5 = mysqli_query($conn,$query3);

while($row5=mysqli_fetch_assoc($result5)){
    $array[] = $row5['status'];
}


//for making default coordiantes to get total no of 'present' of students wise i.e row wise.
$j='1';
$cordp = 'C';
while($j<$total_date_count){
    $cordp++;
    $j++;
}

$index=0;                                         //$index variable will iterate in $array in inner loop and will not reset like $j and $k. 
$i=2;                                             //$i variable will use to iterate outer loop.
while($row2=mysqli_fetch_object($result4)){       // **outer loop should run till total no of students
    $j='1';                                      //$j varable will only use for run inner loop as less than = total no of date.
    $k='C';                                      // $k variable will use for iterate alphabet coordinate in spreadsheet.
    while($j<=$total_date_count){                //**inner loop should run till total no of dates.

       $spreadsheet->getActiveSheet()->setCellValue($k.$i,$array[$index]);
       $j++;
       $k++;
       $index++;
    }
    $spreadsheet->getActiveSheet()->setCellValue($k.$i,"=COUNTIF(C".$i.":".$cordp.$i.',"Present")' );
    $i++;    
}


//for making default coordiantes to get total no of 'present' date wise i.e coloumn wise.
$cordq= $total_students_count+2; 
$cordr= $total_students_count+1; 


//this loop will run till no of dates and set the total 'Present' in each date on very last row.  
$a='1';
$b='C';
while($a<=$total_date_count){
    $spreadsheet->getActiveSheet()->setCellValue($b.$cordq,"=COUNTIF(".$b."2:".$b.$cordr.',"Present")');
    $a++;
    $b++;
}



$conditional1 = new \PhpOffice\PhpSpreadsheet\Style\Conditional();
$conditional1->setConditionType(\PhpOffice\PhpSpreadsheet\Style\Conditional::CONDITION_CONTAINSTEXT);
$conditional1->addCondition("Present");
$conditional1->getStyle()->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_GREEN);
$conditional1->getStyle()->getFont()->setBold(true);

$conditional2 = new \PhpOffice\PhpSpreadsheet\Style\Conditional();
$conditional2->setConditionType(\PhpOffice\PhpSpreadsheet\Style\Conditional::CONDITION_CONTAINSTEXT);
$conditional2->addCondition("Absent");
$conditional2->getStyle()->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
$conditional2->getStyle()->getFont()->setBold(true);

$conditionalStyles = $spreadsheet->getActiveSheet()->getStyle("C2")->getConditionalStyles();
$conditionalStyles[] = $conditional1;
$conditionalStyles[] = $conditional2;
$spreadsheet->getActiveSheet()->getStyle('C2')->setConditionalStyles($conditionalStyles);



//set the header first, so the result will be treated as an xlsx file.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

//make it an attachment so we can define filename
header('Content-Disposition: attachment;filename="databyspreadsheet.xlsx"');

//create IOFactory object
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//save into php output
$writer->save('php://output');