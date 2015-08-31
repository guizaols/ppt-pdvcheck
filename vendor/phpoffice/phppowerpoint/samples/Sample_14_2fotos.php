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
$width  = 453;
$height = 359;

$setX1  = 17;
$setY1  = 177;
$setX2  = 487;
$setY2  = 177;

$posicoes = array(array('setX1' => $setX1, 'setY1' => $setY1), array('setX2' => $setX2, 'setY2' => $setY2));

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
  if($cont < 2) {
    $currentSlide->addShape($shape);
    $cont = $cont + 1;
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
