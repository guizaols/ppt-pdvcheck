<?php

set_time_limit(10);

include_once 'Sample_Header.php';

use PhpOffice\PhpPowerpoint\PhpPowerpoint;
use PhpOffice\PhpPowerpoint\DocumentLayout;
use PhpOffice\PhpPowerpoint\IOFactory;
use PhpOffice\PhpPowerpoint\Style\Alignment;
use PhpOffice\PhpPowerpoint\Style\Color;
use PhpOffice\PhpPowerpoint\Slide;
use PhpOffice\PhpPowerpoint\AbstractShape;
use PhpOffice\PhpPowerpoint\Shape\MemoryDrawing;
use PhpOffice\PhpPowerpoint\Shape\RichText;
use PhpOffice\PhpPowerpoint\Shape\Group;

$pptReader = IOFactory::createReader('ODPresentation');
$oPHPPresentation = $pptReader->load('resources/Sample_12.odp');

$oTree = new PhpPptTree($oPHPPresentation);
echo $oTree->display();
if (!CLI) {
	include_once 'Sample_Footer.php';
}
