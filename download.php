<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
require 'config.php';
$sql = "SELECT id, name, class FROM students_profile";
$result = $conn->query($sql);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'Id');
$sheet->setCellValue('B1', 'Name');
$sheet->setCellValue('C1', 'Class');

$rowNum = 2;
while($row = $result->fetch_assoc()) {
    $sheet->setCellValue('A' . $rowNum, $row['id']);
    $sheet->setCellValue('B' . $rowNum, $row['name']);
    $sheet->setCellValue('C' . $rowNum, $row['class']);
    $rowNum++;
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="users.xlsx"');
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
