<?php
//call the autoload
require 'vendor/autoload.php';
//load phpspreadsheet class using namespaces
use PhpOffice\PhpSpreadsheet\Spreadsheet;
//call iofactory instead of xlsx writer
use PhpOffice\PhpSpreadsheet\IOFactory;
//phpspreadsheet Date class
use PhpOffice\PhpSpreadsheet\Shared\Date;
//phpspreadsheet numberformat style class
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
//rich text class
use \PhpOffice\PhpSpreadsheet\RichText\RichText;
//phpspreadsheet style color
use \PhpOffice\PhpSpreadsheet\Style\Color;

//make a new spreadsheet object
$spreadsheet = new Spreadsheet();
//get current active sheet (first sheet)
$sheet = $spreadsheet->getActiveSheet();

//set default font
$spreadsheet->getDefaultStyle()
			->getFont()
			->setName('Arial')
			->setSize(10);

//set column dimension to auto size
$spreadsheet->getActiveSheet()
			->getColumnDimension('B')
			->setAutoSize(true);
$spreadsheet->getActiveSheet()
			->getColumnDimension('C')
			->setAutoSize(true);

//simple text data
$spreadsheet->getActiveSheet()
			->setCellValue('A1',"String")
			->setCellValue('B1',"Simple Text")
			->setCellValue('C1',"This is Phpspreadsheet");

//symbols
$spreadsheet->getActiveSheet()
			->setCellValue('A2',"String")
			->setCellValue('B2',"Symbols")
			->setCellValue('C2',"ÚÔÛï¢£´°ƤǠњс҃ҭ");

//utf-8 string
$spreadsheet->getActiveSheet()
			->setCellValue('A3',"String")
			->setCellValue('B3',"UTF-8")
			->setCellValue('C3',"добро пожаловать в мой учебник видео");


//integer
$spreadsheet->getActiveSheet()
			->setCellValue('A4',"Number")
			->setCellValue('B4',"Integer")
			->setCellValue('C4',55);

//float
$spreadsheet->getActiveSheet()
			->setCellValue('A5',"Number")
			->setCellValue('B5',"Float")
			->setCellValue('C5',55.55);

//negative
$spreadsheet->getActiveSheet()
			->setCellValue('A6',"Number")
			->setCellValue('B6',"Negative")
			->setCellValue('C6',-55.55);
//boolean
$spreadsheet->getActiveSheet()
			->setCellValue('A7',"Number")
			->setCellValue('B7',"Boolean")
			->setCellValue('C7',true)
			->setCellValue('D7',false);

//date datatype
//make a variable from current timestamp
$dateTimeNow = time();

//date
$spreadsheet->getActiveSheet()
			->setCellValue('A8',"Date/Time")
			->setCellValue('B8',"Date")
			->setCellValue('C8',Date::PHPToExcel($dateTimeNow));

//set the cell format into a date
$spreadsheet->getActiveSheet()
			->getStyle('C8')
			->getNumberFormat()
			->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);


//date with time
$spreadsheet->getActiveSheet()
			->setCellValue('A9',"Date/Time")
			->setCellValue('B9',"Date Time")
			->setCellValue('C9',Date::PHPToExcel($dateTimeNow));

//set the cell format into a date
$spreadsheet->getActiveSheet()
			->getStyle('C9')
			->getNumberFormat()
			->setFormatCode(NumberFormat::FORMAT_DATE_DATETIME);

//only time
$spreadsheet->getActiveSheet()
			->setCellValue('A10',"Date/Time")
			->setCellValue('B10',"Only Time")
			->setCellValue('C10',Date::PHPToExcel($dateTimeNow));

//set the cell format into a date
$spreadsheet->getActiveSheet()
			->getStyle('C10')
			->getNumberFormat()
			->setFormatCode(NumberFormat::FORMAT_DATE_TIME4);

//rich text
$spreadsheet->getActiveSheet()
			->setCellValue('A11',"Rich text");

$richText = new RichText();
$richText->createText('normal text ');
$payable = $richText->createTextRun('bold italic and dark green');
$payable->getFont()->setBold(true);
$payable->getFont()->setItalic(true);
$payable->getFont()->setColor( new Color( Color::COLOR_DARKGREEN ) );

//add a rich text
$redText = $richText->createTextRun('red text');
$redText->getFont()->setColor( new Color( Color::COLOR_RED ) );

$richText->createText(' normal text again');
$spreadsheet->getActiveSheet()->getCell('C11')->setValue($richText);

//hyperlink
$spreadsheet->getActiveSheet()
			->setCellValue('A12',"Hyperlink")
			->setCellValue('B12',"Cell Hyperlink")
			->setCellValue('C12',"Visit Gemul's Channel");

//set the cell as hyperlink
$spreadsheet->getActiveSheet()
			->getCell('C12')
			->getHyperlink()
			->setUrl('https://youtube.com/c/GemulChannel')
			->setTooltip('Go to my youtube channel');

//hyperlink with formula
$spreadsheet->getActiveSheet()
			->setCellValue('A13',"Hyperlink")
			->setCellValue('B13',"Formula Hyperlink")
			->setCellValue('C13',"=HYPERLINK(\"https://youtube.com/c/GemulChannel\",\"My Youtube Channel\")");

//change worksheet name
$spreadsheet->getActiveSheet()
			->setTitle('Phpspreadsheet Chapter 2');














//set the header first, so the result will be treated as an xlsx file.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

//make it an attachment so we can define filename
header('Content-Disposition: attachment;filename="result.xlsx"');

//create IOFactory object
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//save into php output
$writer->save('php://output');