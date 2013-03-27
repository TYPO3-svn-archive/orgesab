<?php

$url = 'https://www.buchsys.de/esab/cgi/xml_export.pl';

$xml = simplexml_load_file( $url );

if( ! $xml ) 
{
  echo '<p>Datei ' . $url . ' konnte nicht gelesen werden</p>';
  die( );
}

$angebote = array( );

echo $xml->programm_bezeichnung . '<br />' . PHP_EOL;

foreach( $xml->Bereich as $bereich )
{
  echo '<div class="bereich">';
  echo '<h3>'.$bereich->bereich_zuordnung.'</h3>';

  // alle Angebote eines Bereichs ausgeben
  echo '<ul class="liste">';
  foreach( $bereich->Angebot as $angebot ) 
  {
    echo '<li><a href="detail.php?lgid='.$angebot->angebot_nr.'" title="Termin des Lehrgangs: '.$angebot->angebot_zeitraum.'">'.$angebot->angebot_name.'</a></li>';
    $angebote[] = array( 
      'angebot_nr' => $angebot->angebot_nr,
    );
  }
  echo '</ul>';
  echo '</div>';
} 

print_r( $angebote );
echo $angebote[0]['angebot_nr'];


?>