<?php

include_once 'Sample_Header.php';

use PhpOffice\PhpPowerpoint\PhpPowerpoint;
use PhpOffice\PhpPowerpoint\Shape\Drawing;
use PhpOffice\PhpPowerpoint\Shape\MemoryDrawing;

// Create new PHPPresentation object
echo date('H:i:s') . ' Create new PHPPresentation object'.EOL;
$objPHPPresentation = new PhpPowerpoint();

// Create slide
echo date('H:i:s') . ' Create slide'.EOL;
$currentSlide = $objPHPPresentation->getActiveSlide();

// Fotos
$path   = '/home/guizao/projetos/dev/freezing-bugfixes/public/uploads/answer/answer_url_image/';
$width  = 800;
$height = 600;

$setX1 = 79;
$setY1 = 94;

$files = glob($path.  '/*.jpg', GLOB_BRACE);
foreach($files as $file) {
  echo($file);
}

for ($i = 1; $i <= 6; $i++) {
  $shape = new Drawing();
  $shape->setName($i)
        ->setDescription($i)
        ->setPath($path . $i . '/' . $i . '.jpg')
        ->setWidth($width)
        ->setHeight($height)
        ->setOffsetX($setX1)
        ->setOffsetY($setY1);
  $currentSlide = createTemplatedSlide($objPHPPresentation);
  $currentSlide->addShape($shape);    
}

// Save file
echo write($objPHPPresentation, basename(__FILE__, '.php'), $writers);
if (!CLI) {
	include_once 'Sample_Footer.php';
}

?>
