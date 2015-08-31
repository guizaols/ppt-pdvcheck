<?
	require_once '../../vendor/phpoffice/phppowerpoint/src/PhpPowerpoint/Autoloader.php';
	\PhpOffice\PhpPowerpoint\Autoloader::register();
	use PhpOffice\PhpPowerpoint\PhpPowerpoint;
	use PhpOffice\PhpPowerpoint\Shape\Drawing;
	use PhpOffice\PhpPowerpoint\Shape\MemoryDrawing;
	use PhpOffice\PhpPowerpoint\Style\Alignment;
	use PhpOffice\PhpPowerpoint\Style\Bullet;
	use PhpOffice\PhpPowerpoint\Style\Color;
	include_once '../../vendor/phpoffice/phppowerpoint/src/PhpPowerpoint/functions.php';

	if(!empty($_REQUEST) && !empty($_GET['id'])) {
		// Create new PHPPresentation object
		// echo date('H:i:s') . ' Create new PHPPresentation object'.EOL;
		$objPHPPresentation = new PhpPowerpoint();

		// Create slide
		// echo date('H:i:s') . ' Create slide'.EOL;
		$currentSlide = $objPHPPresentation->getActiveSlide();
		$shape = $currentSlide->createRichTextShape();
		$shape->setWidth(650);
		$shape->setHeight(60);
		$shape->setOffsetX(155);
		$shape->setOffsetY(330);
		$shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
		$textRun = $shape->createTextRun('RELATÓRIO FOTOGRÁFICO');
		$textRun->getFont()->setBold(true);
		$textRun->getFont()->setSize(32);
		$textRun->getFont()->setColor(new Color('FF0000'));

		// Fotos
		// $path   = '/home/guizao/projetos/dev/freezing-bugfixes/public/uploads/answer/answer_url_image/';
		$path   = '/home2/hd2/sistemas/pdvcheck/producao/freezing-bugfixes/public/uploads/answer/answer_url_image/';
		$width  = 700;
		$height = 500;

		$setX1 = 65;
		$setY1 = 189;

		// $files = glob($path.  '/*.jpg', GLOB_BRACE);
		// foreach($files as $file) {
		//   echo($file);
		// }

		$params 	 = $_REQUEST;
		print_r($params);
		$report_id = $_GET['id'];

		foreach ($params as $pdv => $fotos) {
			$fotos = str_replace('=>', ':', $fotos);
			$array_fotos = json_decode($fotos);
			
			foreach ($array_fotos as $answer_id => $dados) {
				$currentSlide = createTemplatedSlide($objPHPPresentation);

				$shape = $currentSlide->createRichTextShape();
				$shape->setWidth(915);
				$shape->setHeight(75);
				$shape->setOffsetX(15);
				$shape->setOffsetY(11);
				$shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
				$textRun = $shape->createTextRun(str_replace('_', ' ', $pdv));
				$textRun->getFont()->setBold(true);
				$textRun->getFont()->setSize(16);
				// $textRun->getFont()->setColor(new Color( 'FF000000' ));

				$shape->createBreak();
				$shape->createBreak();

				$textRun = $shape->createTextRun('DATA: ');
				$textRun->getFont()->setBold(true);
				$textRun->getFont()->setSize(14);
				$textRun = $shape->createTextRun($dados[3]);
				$textRun->getFont()->setSize(14);

				$shape->createBreak();

				$textRun = $shape->createTextRun('QUESTÃO: ');
				$textRun->getFont()->setBold(true);
				$textRun->getFont()->setSize(14);
				$textRun = $shape->createTextRun($dados[3]);
				$textRun->getFont()->setSize(14);

				$shape->createBreak();

				$textRun = $shape->createTextRun('PROMOTOR: ');
				$textRun->getFont()->setBold(true);
				$textRun->getFont()->setSize(14);
				$textRun = $shape->createTextRun($dados[2]);
				$textRun->getFont()->setSize(14);				

			  $shape = new Drawing();
		  	$shape->setName($answer_id)
		    	    ->setDescription($answer_id)
		    	    ->setPath($path . $answer_id . '/' . $dados[0])
		      	  ->setWidth($width)
		      	  ->setHeight($height)
		      	  ->setOffsetX($setX1)
		      	  ->setOffsetY($setY1);
		  	// $currentSlide = createTemplatedSlide($objPHPPresentation);
		  	$currentSlide->addShape($shape);
			}
		}

		// Save file
		echo write($objPHPPresentation, 'fotografico_pdvs_'.$report_id, $writers);
	}
?>
