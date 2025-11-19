<?php
require 'config.php';
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
$sql = "SELECT profile.name, profile.class, marks.hindi, marks.english, marks.maths, marks.science, marks.sst FROM `students_profile` As `profile` INNER JOIN `students_marks` As `marks` ON profile.id = marks.student_id";
$result = $conn->query($sql);
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$headers = ['Id', 'Name', 'Class', 'Hindi', 'English', 'Maths', 'Science', 'SSt', 'Total', 'Percentage', 'Grade'];
$column = 'A';
$row = 1;
foreach($headers as $header){
  $sheet->setCellValue($column.$row, $header);
  $column++;
}
// $sheet->setCellValue('A1', 'Id');
// $sheet->setCellValue('B1', 'Name');
// $sheet->setCellValue('C1', 'Class');
// $sheet->setCellValue('D1', 'Hindi');
// $sheet->setCellValue('E1', 'English');
// $sheet->setCellValue('F1', 'Maths');
// $sheet->setCellValue('G1', 'Science');
// $sheet->setCellValue('H1', 'SSt');
// $sheet->setCellValue('I1', 'Total');
// $sheet->setCellValue('J1', 'Percentage');
// $sheet->setCellValue('K1', 'Grade');
$rowNum = 2;
while($fetch = mysqli_fetch_assoc($result)){
  $name = ucfirst($fetch['name']);
  $class = $fetch['class'];
  $hindiMarks = $fetch['hindi'];
  $englishMarks = $fetch['english'];
  $mathsMarks = $fetch['maths'];
  $scienceMarks = $fetch['science'];
  $sstMarks = $fetch['sst'];
//   $total = $hindiMarks + $englishMarks + $mathsMarks + $scienceMarks + $sstMarks;
    //   $percentage = ($total / 500)*100;
    //       if($percentage >= 90){
    //         $grade = 'A+';
    //     } elseif($percentage <= 90 && $percentage >= 80){
    //         $grade = 'A';
    //     } elseif($percentage <= 80 && $percentage >=70){
    //         $grade = 'B';
    //     } elseif($percentage <= 70 && $percentage >= 60){
    //         $grade = 'C';
    //     } elseif($percentage <= 60 && $percentage >=50){
    //         $grade = 'D';
    //     } else {
    //         $grade = 'F';
    //     }
    $sheet->setCellValue('A'.$rowNum, $rowNum-1);
    $sheet->setCellValue('B'.$rowNum, $name);
    $sheet->setCellValue('C'.$rowNum, $class);
    $sheet->setCellValue('D'.$rowNum, $hindiMarks);
    $sheet->setCellValue('E'.$rowNum, $englishMarks);
    $sheet->setCellValue('F'.$rowNum, $mathsMarks);
    $sheet->setCellValue('G'.$rowNum, $scienceMarks);
    $sheet->setCellValue('H'.$rowNum, $sstMarks);
    $sheet->setCellValue('I'.$rowNum, "=SUM(D{$rowNum}:H{$rowNum})");
    $sheet->setCellValue('J'.$rowNum, "=I{$rowNum}/500*100");
    $sheet->setCellValue('K'.$rowNum, "=IF(J{$rowNum}>=90, \"A\", IF(J{$rowNum}>=80, \"B\", IF(J{$rowNum}>=70, \"C\", IF(J{$rowNum}>=60, \"D\", \"F\"))))");
    $rowNum++;
    //   echo 'Name'." ".$fetch['name'];
    //   echo "<br>";
    //   echo 'Total'." ".$percentage;
    //   echo "<br>";
    }
    //  echo json_encode($data);
    // $data = [];
    // if($result){
    // while($row = mysqli_fetch_assoc($result)){
    //     $data[] = $row;
    // }
    // echo json_encode($data);
    // }else{
    //     echo "Error";
    // }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="report.xlsx"');
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
?>