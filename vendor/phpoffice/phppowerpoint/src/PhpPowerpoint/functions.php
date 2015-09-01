<?php
/**
 * Header file
*/
use PhpOffice\PhpPowerpoint\Autoloader;
use PhpOffice\PhpPowerpoint\Settings;
use PhpOffice\PhpPowerpoint\IOFactory;

error_reporting(E_ALL & ~E_NOTICE);
define('CLI', (PHP_SAPI == 'cli') ? true : false);
define('EOL', CLI ? PHP_EOL : '<br />');
define('SCRIPT_FILENAME', basename($_SERVER['SCRIPT_FILENAME'], '.php'));
define('IS_INDEX', SCRIPT_FILENAME == 'index');

// require_once __DIR__ . '/../src/PhpPowerpoint/Autoloader.php';
// Autoloader::register();

// Set writers
// $writers = array('PowerPoint2007' => 'pptx', 'ODPresentation' => 'odp');
$writers = array('PowerPoint2007' => 'pptx');

// Return to the caller script when runs by CLI
if (CLI) {
	return;
}

// Set titles and names
$pageHeading = str_replace('_', ' ', SCRIPT_FILENAME);
$pageTitle = IS_INDEX ? 'Welcome to ' : "{$pageHeading} - ";
$pageTitle .= 'PHPPowerPoint';
$pageHeading = IS_INDEX ? '' : "<h1>{$pageHeading}</h1>";

// Populate samples
$files = '';
if ($handle = opendir('.')) {
	while (false !== ($file = readdir($handle))) {
		if (preg_match('/^Sample_\d+_/', $file)) {
			$name = str_replace('_', ' ', preg_replace('/(Sample_|\.php)/', '', $file));
			$files .= "<li><a href='{$file}'>{$name}</a></li>";
		}
	}
	closedir($handle);
}

/**
 * Write documents
 *
 * @param \PhpOffice\PhpWord\PhpWord $phpWord
 * @param string $filename
 * @param array $writers
 */
function write($phpPowerPoint, $filename, $writers)
{
	// $result = '';
	$result = false;
	
	// Write documents
	foreach ($writers as $writer => $extension) {
		if (!is_null($extension)) {
			$xmlWriter = IOFactory::createWriter($phpPowerPoint, $writer);
			/* DEV */
			// $result = $xmlWriter->save("/home/guizao/ppts/{$filename}.{$extension}");
			// chmod("/home/guizao/ppts/{$filename}.{$extension}", 0777);

			/* PRODUTCTION */
			$xmlWriter->save("/home2/hd2/ppts/{$filename}.{$extension}");
			chmod("/home2/hd2/ppts/{$filename}.{$extension}", 0777);
		// } else {
			// $result .= ' ... NOT DONE!';
		}
		// $result .= EOL;
		// $result = true;
	}

	// $result .= getEndingNotes($writers);

	return $result;
}

/**
 * Get ending notes
 *
 * @param array $writers
 */
function getEndingNotes($writers)
{
	$result = '';

	// Do not show execution time for index
	if (!IS_INDEX) {
		$result .= date('H:i:s') . " Done writing file(s)" . EOL;
		$result .= date('H:i:s') . " Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB" . EOL;
	}

	// Return
	if (CLI) {
		$result .= 'The results are stored in the "results" subdirectory.' . EOL;
	} else {
		if (!IS_INDEX) {
			$types = array_values($writers);
			$result .= '<p>&nbsp;</p>';
			$result .= '<p>Results: ';
			foreach ($types as $type) {
				if (!is_null($type)) {
					$resultFile = 'results/' . SCRIPT_FILENAME . '.' . $type;
					if (file_exists($resultFile)) {
						$result .= "<a href='{$resultFile}' class='btn btn-primary'>{$type}</a> ";
					}
				}
			}
			$result .= '</p>';
		}
	}

	return $result;
}

/**
 * Creates a templated slide
 *
 * @param PHPPowerPoint $objPHPPowerPoint
 * @return PHPPowerPoint_Slide
 */
function createTemplatedSlide(PhpOffice\PhpPowerpoint\PhpPowerpoint $objPHPPowerPoint)
{
	// Create slide
	$slide = $objPHPPowerPoint->createSlide();
	
	// Add logo
	// $shape = $slide->createDrawingShape();
	// $shape->setName('PHPPowerPoint logo')
	// 	->setDescription('PHPPowerPoint logo')
	// 	->setPath('./resources/phppowerpoint_logo.gif')
	// 	->setHeight(36)
	// 	->setOffsetX(10)
	// 	->setOffsetY(10);
	// $shape->getShadow()->setVisible(true)
	// 	->setDirection(45)
	// 	->setDistance(10);

	// Return slide
	return $slide;
}
?>
