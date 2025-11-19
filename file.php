<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'Id');
$sheet->setCellValue('B1', 'Name');
$sheet->setCellValue('C1', 'Email');

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="file.xlsx"');
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
