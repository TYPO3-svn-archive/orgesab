<?php

	$filename = 'xml-daten/import.xml';
	$lgid = $_GET['lgid'];
	
	if (file_exists('xml-daten/import.xml')) {

		$xml = simplexml_load_file('xml-daten/import.xml');

		if($xml) {
			foreach ($xml->Bereich as $bereich) {
				foreach ($bereich->Angebot as $angebot) {
					$angebot->addAttribute("lgid", $angebot->angebot_nr);				
				}
			}   
		} else {
			echo '<p>Die Datei names '. $filename .' konnte nicht geoeffnet werden</p>';
		}
		
		$path ='/Programm/Bereich/Angebot[@lgid='.$lgid.']';

		if (!$res = $xml->xpath($path)) {
			echo '<p class"error">Ein Lehrgang mit diese Nummer ist nicht nicht vorhanden!</p>';
		} else {

			echo '<hr /><p><strong>'.$res[0]->angebot_ausgebucht.'</strong></p><hr />';
			echo '<p><strong>'.$res[0]->angebot_bereich.'</strong></p>';
			echo '<h1>'.$res[0]->angebot_name.'</h1>';
			echo '<p><strong>Angebot-Nr.:&nbsp;</strong>'.$res[0]->angebot_nr.'</p>';
			echo '<p><strong>Beschreibung:&nbsp;</strong>'.$res[0]->angebot_beschreibung.'</p><hr />';

			echo '<p><strong>Details:&nbsp;</strong>'.$res[0]->angebot_details.'</p><hr />';
			echo '<p><strong>Inhalt:&nbsp;</strong>'.$res[0]->angebot_inhalt.'</p><hr />';
			echo '<p><strong>Keywords:&nbsp;</strong>'.$res[0]->angebot_keywords.'</p><hr />';
			
			echo '<p><strong>Kursleiter 1:&nbsp;</strong>'.$res[0]->angebot_kursleiter1.'</p>';
			echo '<p><strong>Kursleiter 2:&nbsp;</strong>'.$res[0]->angebot_kursleiter2.'</p><hr />';
			
			echo '<p><strong>Ort 1:&nbsp;</strong>'.$res[0]->angebot_ort1.'</p>';
			echo '<p><strong>Ort 2:&nbsp;</strong>'.$res[0]->angebot_ort2.'</p>';
			echo '<p><strong>Ort 3:&nbsp;</strong>'.$res[0]->angebot_ort3.'</p>';
			echo '<p><strong>Ort 4:&nbsp;</strong>'.$res[0]->angebot_ort4.'</p>';
			echo '<p><strong>Ort 5:&nbsp;</strong>'.$res[0]->angebot_ort5.'</p><hr />';
			
			echo '<p><strong>Preis 1:&nbsp;</strong>'.$res[0]->angebot_preis1.'</p>';
			echo '<p><strong>Preis 2:&nbsp;</strong>'.$res[0]->angebot_preis2.'</p>';
			echo '<p><strong>Preis 3:&nbsp;</strong>'.$res[0]->angebot_preis3.'</p><hr />';
			
			echo '<p><strong>Tag 1:&nbsp;</strong>'.$res[0]->angebot_tag1.'</p>';
			echo '<p><strong>Tag 2:&nbsp;</strong>'.$res[0]->angebot_tag2.'</p>';
			echo '<p><strong>Tag 3:&nbsp;</strong>'.$res[0]->angebot_tag3.'</p>';
			echo '<p><strong>Tag 4:&nbsp;</strong>'.$res[0]->angebot_tag4.'</p>';
			echo '<p><strong>Tag 5:&nbsp;</strong>'.$res[0]->angebot_tag5.'</p><hr />';

			echo '<p><strong>Uhrzeit 1:&nbsp;</strong>'.$res[0]->angebot_uhrzeit1.'</p>';
			echo '<p><strong>Uhrzeit 2:&nbsp;</strong>'.$res[0]->angebot_uhrzeit2.'</p>';
			echo '<p><strong>Uhrzeit 3:&nbsp;</strong>'.$res[0]->angebot_uhrzeit3.'</p>';
			echo '<p><strong>Uhrzeit 4:&nbsp;</strong>'.$res[0]->angebot_uhrzeit4.'</p>';
			echo '<p><strong>Uhrzeit 5:&nbsp;</strong>'.$res[0]->angebot_uhrzeit5.'</p><hr />';
	
			echo '<p><strong>Zeitraum:&nbsp;</strong>'.$res[0]->angebot_zeitraum.'</p><hr />';
			
			echo '<p><strong><a href="'.$res[0]->angebot_link.'" class="booking_'.$res[0]->angebot_ausgebucht.'" target="_blank">Diesen Lehrgang buchen</a></strong></p>';

		}
		
	} else {
		exit("Konnte Datei nicht laden.");
	}	
?> 