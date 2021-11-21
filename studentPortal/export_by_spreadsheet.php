<?php
//===================================================JAI SHREE KRISHNA======================================= -->
session_start();
if(!$_SESSION['username_student'])
{
    header('Location: ../index.php');
}
require('../adminstrative/config.php');

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



$spreadsheet->getActiveSheet()->getStyle('A1:G1')->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffff00');
$spreadsheet->getActiveSheet()->getStyle('A1:G1')->getFont()->setSize(14);
$spreadsheet->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);


if(isset($_POST['export_attendance'])){
foreach ($_POST['subjectcode'] as $key => $subject_code){
        $subject_name = $_POST['subjectname'][$key];
        $course = $_POST['course'][$key];
        $branch = $_POST['branch'][$key];
        $semester = $_POST['semester'][$key];
        $section = $_POST['section'][$key];
        $startdate = $_POST['startdate'][$key];
        $enddate = $_POST['enddate'][$key];
        $roll_no = $_POST['roll_no'][$key];
        $student_name = $_POST['student_name'][$key];
    }
}


// this loop will run from coloumn coordinate A to G and set coloumn to autosize.
foreach(range('A','G') as $coloumnId){
    $spreadsheet->getActiveSheet()->getColumnDimension($coloumnId)->setAutoSize(true);
}

//set default font
$spreadsheet->getDefaultStyle()
			->getFont()
			->setName('Arial')
			->setSize(10);


            $spreadsheet->getActiveSheet()
            ->setCellValue("B1","DigiVGI")
            ->setCellValue("D1","Powered By")
            ->setCellValue("F1","AeshTech")

            ->setCellValue("A3","Student Name-")
            ->setCellValue("B3",$student_name)
            ->setCellValue("C3","Roll No-")
            ->setCellValue("D3",$roll_no)

            ->setCellValue("A4","Course-")
            ->setCellValue("B4",$course)
            ->setCellValue("C4","Subject Name-")
            ->setCellValue("D4",$subject_name)

            ->setCellValue("A5","Branch-")
            ->setCellValue("B5",$branch)
            ->setCellValue("C5","Semester-")
            ->setCellValue("D5",$semester)
            ->setCellValue("E5","Section-")
            ->setCellValue("F5",$section)

            ->setCellValue("A6","Start Date-")
            ->setCellValue("B6",$startdate)
            ->setCellValue("C6","End Date-")
            ->setCellValue("D6",$enddate)

            ->setCellValue("A8","Date")
            ->setCellValue("B8","Status");



$query = "SELECT `status`,`date` FROM `attendance` WHERE `subject_code`='$subject_code' AND `roll_no`='$roll_no' AND `course`='$course' AND `branch`='$branch' AND `semester`='$semester' AND `section`='$section' AND `date` BETWEEN '$startdate' AND '$enddate' ORDER BY `date`";
$result = mysqli_query($conn,$query);


$i=9;
$index=0;
while($row=mysqli_fetch_assoc($result)){
$spreadsheet->getActiveSheet()->setCellValue("A".$i ,$row['date']);
$spreadsheet->getActiveSheet()->setCellValue("B".$i ,$row['status']);
$i++;
$index++;
}

$cord = $i-1;
$spreadsheet->getActiveSheet()->setCellValue("A".$i,"Total Present-");
$spreadsheet->getActiveSheet()->setCellValue("B".$i,"=COUNTIF(B9:B".$cord.',"Present")');

//set the header first, so the result will be treated as an xlsx file.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

//make it an attachment so we can define filename
header('Content-Disposition: attachment;filename="DigiVGI-Exported.xlsx"');

//create IOFactory object
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//save into php output
$writer->save('php://output');
?>