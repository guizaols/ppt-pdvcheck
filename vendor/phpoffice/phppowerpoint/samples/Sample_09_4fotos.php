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

// Generate an image
// echo date('H:i:s') . ' Generate an image'.EOL;
// $gdImage = @imagecreatetruecolor(140, 20) or die('Cannot Initialize new GD image stream');
// $textColor = imagecolorallocate($gdImage, 255, 255, 255);
// imagestring($gdImage, 1, 5, 5,  'Created with PHPPresentation', $textColor);

// Add a generated drawing to the slide
// echo date('H:i:s') . ' Add a drawing to the slide'.EOL;
// $shape = new MemoryDrawing();
// $shape->setName('Sample image')
//       ->setDescription('Sample image')
//       ->setImageResource($gdImage)
//       ->setRenderingFunction(MemoryDrawing::RENDERING_JPEG)
//       ->setMimeType(MemoryDrawing::MIMETYPE_DEFAULT)
//       ->setHeight(36)
//       ->setOffsetX(10)
//       ->setOffsetY(10);
// $currentSlide->addShape($shape);

// $currentSlide = $objPHPPresentation->getActiveSlide();

$path   = '/home/guizao/projetos/dev/freezing-bugfixes/public/uploads/answer/answer_url_image/';
$width  = 500;
$height = 283;

$setX1  = 15;
$setY1  = 102;
$setX2  = 491;
$setY2  = 102;
$setX3  = 15;
$setY3  = 396;
$setX4  = 491;
$setY4  = 396;

$posicoes = array(array('setX1' => $setX1, 'setY1' => $setY1), array('setX2' => $setX2, 'setY2' => $setY2),
                  array('setX3' => $setX3, 'setY3' => $setY3), array('setX4' => $setX4, 'setY4' => $setY4));

$cont = 1;
for ($i = 1; $i <= 6; $i++) {
  $shape = new Drawing();
  $shape->setName($i)
        ->setDescription($i)
        ->setPath($path . $i . '/' . $i . '.jpg')
        ->setWidth($width)
        ->setHeight($height)
        ->setOffsetX($posicoes[$cont-1]['setX'.$cont])
        ->setOffsetY($posicoes[$cont-1]['setY'.$cont]);
  if($cont < 4) {
    $cont = $cont + 1;
    $currentSlide->addShape($shape);
  } else {
    $cont = 1;
    $currentSlide = createTemplatedSlide($objPHPPresentation);
    $currentSlide->addShape($shape);
  }
}

// Save file
echo write($objPHPPresentation, basename(__FILE__, '.php'), $writers);
if (!CLI) {
	include_once 'Sample_Footer.php';
}
