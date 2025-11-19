<?php
require 'config.php';
require 'vendor/autoload.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$stmt = $conn->prepare("
    SELECT 
        profile.id,
        profile.name, 
        profile.class, 
        marks.hindi, 
        marks.english, 
        marks.maths, 
        marks.science, 
        marks.sst 
    FROM students_profile AS profile
    INNER JOIN students_marks AS marks
        ON profile.id = marks.student_id
");
$stmt->execute();

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$headers = ['Id','Name','Class','Hindi','English','Maths','Science','SSt','Total','Percentage','Grade'];

$column = 'A';
foreach($headers as $header){
    $sheet->setCellValue($column.'1', $header);
    $column++;
}

$rowNum = 2;

while($fetch = $stmt->fetch(PDO::FETCH_ASSOC)){

    $sheet->setCellValue("A{$rowNum}", $fetch['id']);
    $sheet->setCellValue("B{$rowNum}", ucfirst($fetch['name']));
    $sheet->setCellValue("C{$rowNum}", $fetch['class']);
    $sheet->setCellValue("D{$rowNum}", $fetch['hindi']);
    $sheet->setCellValue("E{$rowNum}", $fetch['english']);
    $sheet->setCellValue("F{$rowNum}", $fetch['maths']);
    $sheet->setCellValue("G{$rowNum}", $fetch['science']);
    $sheet->setCellValue("H{$rowNum}", $fetch['sst']);

    $sheet->setCellValue("I{$rowNum}", "=SUM(D{$rowNum}:H{$rowNum})");
    $sheet->setCellValue("J{$rowNum}", "=I{$rowNum}/500*100");
    $sheet->setCellValue("K{$rowNum}", "=IF(J{$rowNum}>=90,\"A\",IF(J{$rowNum}>=80,\"B\",IF(J{$rowNum}>=70,\"C\",IF(J{$rowNum}>=60,\"D\",\"F\"))))");

    $rowNum++;
}


header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="report.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;

?>
