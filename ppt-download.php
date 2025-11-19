<?php
require_once 'vendor/autoload.php';

use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request.");
}

$ppt = new PhpPresentation();
$ppt->removeSlideByIndex(0); 

$uploadDir = "images/";
$images = [];

foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
    if (!empty($tmpName)) {
        $fileName = basename($_FILES['images']['name'][$key]);
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($tmpName, $filePath)) {
            $images[] = $filePath;
        }
    }
}

if (empty($images)) {
    die("No images uploaded.");
}

foreach ($images as $img) {
    $slide = $ppt->createSlide();

    $shape = $slide->createDrawingShape();
    $shape->setName("Image")
        ->setPath($img)
        ->setHeight(400)
        ->setOffsetX(150)
        ->setOffsetY(80);
}

$filename = "images_presentation.pptx";
$writer = IOFactory::createWriter($ppt, 'PowerPoint2007');
$writer->save($filename);

header("Content-Type: application/vnd.openxmlformats-officedocument.presentationml.presentation");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Length: " . filesize($filename));

readfile($filename);
unlink($filename);

exit;
?>
