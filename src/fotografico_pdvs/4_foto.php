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
		$width  = 423;
		$height = 253;

		$setX1  = 37;
		$setY1  = 102;
		$setX2  = 506;
		$setY2  = 102;
		$setX3  = 37;
		$setY3  = 408;
		$setX4  = 506;
		$setY4  = 408;

		$posicoes = array(array('setX1' => $setX1, 'setY1' => $setY1), array('setX2' => $setX2, 'setY2' => $setY2),
		                  array('setX3' => $setX3, 'setY3' => $setY3), array('setX4' => $setX4, 'setY4' => $setY4));

		$setTextoX1 = 37;
		$setTextoY1 = 359;
		$setTextoX2 = 506;
		$setTextoY2 = 359;
		$setTextoX3 = 37;
		$setTextoY3 = 668;
		$setTextoX4 = 506;
		$setTextoY4 = 668;

		$posicoes_txt = array(array('setX1' => $setTextoX1, 'setY1' => $setTextoY1), array('setX2' => $setTextoX2, 'setY2' => $setTextoY2),
		                 			array('setX3' => $setTextoX3, 'setY3' => $setTextoY3), array('setX4' => $setTextoX4, 'setY4' => $setTextoY4));

		// $files = glob($path.  '/*.jpg', GLOB_BRACE);
		// foreach($files as $file) {
		//   echo($file);
		// }

		$params 	 = $_REQUEST;
		// print_r($params);
		$report_id = $_GET['id'];

		foreach ($params as $pdv => $fotos) {
			if($pdv != 'id') {
				$fotos 			 = str_replace('=>', ':', $fotos);
				$fotos 			 = str_replace("\\", '', $fotos);
				$array_fotos = json_decode($fotos);
				$cont 			 = 1;

				foreach ($array_fotos as $answer_id => $dados) {
					if($cont == 1) {
						$currentSlide = createTemplatedSlide($objPHPPresentation);
						// TEXTOS
							$shape = $currentSlide->createRichTextShape();
							$shape->setWidth(915);
							$shape->setHeight(75);
							$shape->setOffsetX(15);
							$shape->setOffsetY(11);
							$shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
							$textRun = $shape->createTextRun(str_replace('_', ' ', $pdv));
							$textRun->getFont()->setBold(true);
							$textRun->getFont()->setSize(14);

							$shape->createBreak();

							$textRun = $shape->createTextRun('DATA: ');
							$textRun->getFont()->setBold(true);
							$textRun->getFont()->setSize(12);
							$textRun = $shape->createTextRun($dados[1]);
							$textRun->getFont()->setSize(12);

							$shape->createBreak();

							$textRun = $shape->createTextRun('PROMOTOR: ');
							$textRun->getFont()->setBold(true);
							$textRun->getFont()->setSize(12);
							$textRun = $shape->createTextRun($dados[2]);
							$textRun->getFont()->setSize(12);
						// TEXTOS
					}

				  $shape = new Drawing();
			  	$shape->setName($answer_id)
			    	    ->setDescription($answer_id)
			    	    ->setPath($path . $answer_id . '/ppt_' . $dados[0])
			      	  ->setWidth($width)
			      	  ->setHeight($height)
			      	  ->setOffsetX($posicoes[$cont-1]['setX'.$cont])
			      	  ->setOffsetY($posicoes[$cont-1]['setY'.$cont]);
			  	$currentSlide->addShape($shape);

					$shape = $currentSlide->createRichTextShape();
					$shape->setWidth(415);
					$shape->setHeight(37);
					$shape->setOffsetX($posicoes_txt[$cont-1]['setX'.$cont]);
					$shape->setOffsetY($posicoes_txt[$cont-1]['setY'.$cont]);
					$textRun = $shape->createTextRun($dados[3]);
					$textRun->getFont()->setBold(true);
					$textRun->getFont()->setSize(12);
					$textRun->getFont()->setColor(new Color('FF0000'));

			  	if($cont < 4) {
			  		$cont = $cont + 1;
			  	} else {
			  		$cont = 1;
			  	}
				}
			}
		}

		// Save file
		echo write($objPHPPresentation, 'fotografico_pdvs_'.$report_id, $writers);
	}
?>
