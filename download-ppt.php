<?php
require_once 'vendor/autoload.php';
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;
$images = [
    "code-review-tools.png",
    "code-review-tools.png",
    "code-review-tools.png",
    "code-review-tools.png"
];
$ppt = new PhpPresentation();
$ppt->removeSlideByIndex(0);
foreach ($images as $img) {
    $slide = $ppt->createSlide();
    $shape = $slide->createDrawingShape();
    $shape->setPath($img)
          ->setHeight(500)
          ->setOffsetX(100)
          ->setOffsetY(50);
}
$filename = "my_presentation.pptx";
$writer = IOFactory::createWriter($ppt, 'PowerPoint2007');
$writer->save($filename);
header("Content-Type: application/vnd.openxmlformats-officedocument.presentationml.presentation");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Length: " . filesize($filename));
readfile($filename);
unlink($filename);
exit;
?>
