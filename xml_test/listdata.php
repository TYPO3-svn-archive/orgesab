<?php
	
	$filename = 'xml-daten/import.xml';
	
	if(file_exists($filename)) {
		
		$xml = simplexml_load_file($filename);
				

echo 'X' . $xml->Programm . 'Y' . PHP_EOL;
echo 'X' . $xml->programm_bezeichnung . 'Y' . PHP_EOL;

		if($xml) {
			// alle Bereiche ausgeben
			foreach ($xml->Bereich as $bereich) {
				echo '<div class="bereich">';
				echo '<h3>'.$bereich->bereich_zuordnung.'</h3>';
				
				// alle Angebote eines Bereichs ausgeben
				echo '<ul class="liste">';
				foreach ($bereich->Angebot as $angebot) {
					echo '<li><a href="detail.php?lgid='.$angebot->angebot_nr.'" title="Termin des Lehrgangs: '.$angebot->angebot_zeitraum.'">'.$angebot->angebot_name.'</a></li>';
				}
				echo '</ul>';
				echo '</div>';
			} 
		} else {
			echo '<p>Die Datei names '. $filename .' konnte nicht geoeffnet werden</p>';
		}
	}

?> 
