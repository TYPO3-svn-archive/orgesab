<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2013 Dirk Wildt (http://wildt.at.die-netzmacher.de/)
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/


/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   61: class tx_orgesab_xml
 *
 *              SECTION: Main
 *   93:     public function main( )
 *
 *              SECTION: Init
 *  139:     private function init( )
 *
 *              SECTION: Set
 *  167:     public function setPobj( $pObj )
 *
 *              SECTION: Main
 *  196:     private function xmlForDatabase( )
 *  227:     private function convertContent( )
 *  247:     private function xmlIsUpdated( )
 *
 * TOTAL FUNCTIONS: 6
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */

/**
 * Class "tx_orgesab_xml" provides procedures for import an xml file
 *
 * @author        Dirk Wildt (http://wildt.at.die-netzmacher.de/)
 * @package        TYPO3
 * @subpackage    orgesab
 * @version       0.0.1
 * @since         0.0.1
 */
class tx_orgesab_convert {

  /**
    * Extension key
    *
    * @var string $extKey
    */
    public $extKey = 'orgesab';

  /**
    * Parent object
    *
    * @var object
    */
    private $pObj;



  /***********************************************
   *
   * Main
   *
   **********************************************/

/**
 * main( )  :
 *
 * @param       object      $xml      : the xml object
 * @return	array       $content  : 
 * @access public
 * @version       0.0.1
 * @since         0.0.1
 */
  public function main( $xml )
  {
    $this->init( );
    
    $content = array(
      'programm' => $this->getProgramm( $xml ),
      'bereiche' => $this->getBereiche( $xml ),
      'angebote' => $this->getAngebote( $xml )
    );

    return $content;
  }



  /***********************************************
   *
   * Init
   *
   **********************************************/

/**
 * getAngebote( )  :
 *
 * @param       object      $xml      : xml object
 * @return	array       $content  :
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function getAngebote( $xml )
  {
    $angebote = array( );

      // LOOP : Bereiche
    foreach( $xml->Bereich as $bereich )
    {
        // LOOP : Angebote
      foreach( $bereich->Angebot as $angebot )
      {
        $angebote[] = array
        (
          'bereich_zuordnung'     => $bereich->bereich_zuordnung,  
          'angebot_nr'            => $angebot->angebot_nr,
          'angebot_nr'            => $angebot->angebot_nr,
          'angebot_ausgebucht'    => $angebot->angebot_ausgebucht,
          'angebot_bereich'       => $angebot->angebot_bereich,
          'angebot_beschreibung'  => $angebot->angebot_beschreibung,
          'angebot_details'       => $angebot->angebot_details,
          'angebot_inhalte'       => $angebot->angebot_inhalte,
          'angebot_keywords'      => $angebot->angebot_keywords,
          'angebot_kursleiter1'   => $angebot->angebot_kursleiter1,
          'angebot_kursleiter2'   => $angebot->angebot_kursleiter2,
          'angebot_link'          => $angebot->angebot_link,
          'angebot_name'          => $angebot->angebot_name,
          'angebot_nr'            => $angebot->angebot_nr,
          'angebot_ort1'          => $angebot->angebot_ort1,
          'angebot_ort2'          => $angebot->angebot_ort2,
          'angebot_ort3'          => $angebot->angebot_ort3,
          'angebot_ort4'          => $angebot->angebot_ort4,
          'angebot_ort5'          => $angebot->angebot_ort5,
          'angebot_preis_1'       => $angebot->angebot_preis_1,
          'angebot_preis_2'       => $angebot->angebot_preis_2,
          'angebot_preis_3'       => $angebot->angebot_preis_3,
          'angebot_tag1'          => $angebot->angebot_tag1,
          'angebot_tag2'          => $angebot->angebot_tag2,
          'angebot_tag3'          => $angebot->angebot_tag3,
          'angebot_tag4'          => $angebot->angebot_tag4,
          'angebot_tag5'          => $angebot->angebot_tag5,
          'angebot_uhrzeit1'      => $angebot->angebot_uhrzeit1,
          'angebot_uhrzeit2'      => $angebot->angebot_uhrzeit2,
          'angebot_uhrzeit3'      => $angebot->angebot_uhrzeit3,
          'angebot_uhrzeit4'      => $angebot->angebot_uhrzeit4,
          'angebot_uhrzeit5'      => $angebot->angebot_uhrzeit5,
          'angebot_zeitraum'      => $angebot->angebot_zeitraum,
        );
      }
        // LOOP : Angebote
    } 
      // LOOP : Bereiche
    
      // DRS
    if( $this->pObj->drsModeConvert )
    {
      $number = count( $angebote );
      $prompt = 'Programm contains #' . $number . ' Angebote.';
      t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 0 );
      $prompt = 'The first and the last Angebote: ';
      t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 0 );
      $prompt = var_export( $angebote[0], true);
      t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 0 );
      $prompt = var_export( $angebote[ $number - 1 ], true);
      t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 0 );
    }
      // DRS

    return $angebote;
  }

/**
 * getBereiche( )  :
 *
 * @param       object      $xml      : xml object
 * @return	array       $content  :
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function getBereiche( $xml )
  {
//      <Programm>
//        <Bereich>
//          <bereich_zuordnung></bereich_zuordnung>
//          <Angebot>
//            ...
//          </Angebot>
//        </Bereich>
//      </Programm>

    $bereiche = array( );
    
    foreach( $xml->Bereich as $bereich )
    {
      $bereiche[] = $bereich->bereich_zuordnung;

    } 
    
    $bereiche = array_unique( $bereiche );
    
      // DRS
    if( $this->pObj->drsModeConvert )
    {
      $prompt = 'Bereiche: ' . var_export( $bereiche, true );
      t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 0 );
    }
      // DRS

    return $bereiche;
  }

/**
 * getProgramm( )  :
 *
 * @param       object      $xml      : xml object
 * @return	array       $programm :
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function getProgramm( $xml )
  {
//      <Programm>
//        <programm_bezeichnung></programm_bezeichnung>
//        <programm_beginn></programm_beginn>
//        <programm_ende></programm_ende>
//        <Bereich>
//          ...
//        </Bereich>
//      </Programm>
    
    $programm = array
    (
      'programm_bezeichnung'  => $xml->programm_bezeichnung,
      'programm_beginn'       => $xml->programm_beginn,
      'programm_ende'         => $xml->programm_ende
    );
    
      // DRS
    if( $this->pObj->drsModeConvert )
    {
      $prompt = 'Programm: ' . var_export( $programm, true );
      t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 0 );
    }
      // DRS

    return $programm;
  }



  /***********************************************
   *
   * Get
   *
   **********************************************/

/**
 * init( )  :
 *
 * @return	boolean
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function init( )
  {
    if( ! $this->initPobj( ) )
    {
      return false;
    }

    return true;
  }

/**
 * initPobj( )  :
 *
 * @return	boolean
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function initPobj( )
  {
    if( is_object( $this->pObj ) )
    {
      return true;
    }

      // DRS
    if( $this->pObj->drsModeError )
    {
      $prompt = 'pObj isn\'t any object';
      t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 3 );
    }
      // DRS

      // e-mail to admin
    $subject  = 'Failed';
    $body     = 'Sorry, but pObj isn\'t any object. ' . PHP_EOL
              . PHP_EOL
              . __CLASS__ . '::' .  __METHOD__ . ' (' . __LINE__ . ')';
    $this->pObj->drsMailToAdmin( $subject, $body );
      // e-mail to admin

    return false;
  }



  /***********************************************
   *
   * Prompt and Mail
   *
   **********************************************/

/**
 * promptAndMail( )
 *
 * @return	void
 * @access      private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function promptAndMail( $tag, $content )
  {
    $subject  = 'Failed';
    $body     = 'XML tag: ' . $tag . PHP_EOL
              . 'Content ' . implode( '; ' . $content )
              . PHP_EOL
              . __CLASS__ . '::' .  __METHOD__ . ' (' . __LINE__ . ')';
    $this->pObj->drsMailToAdmin( $subject, $body );
  }



  /***********************************************
   *
   * Set
   *
   **********************************************/

/**
 * setPobj( )  :
 *
 * @param	[type]		$$pObj: ...
 * @return	boolean
 * @access public
 * @version       0.0.1
 * @since         0.0.1
 */
  public function setPobj( $pObj )
  {
    if( ! is_object( $pObj ) )
    {
      $prompt = 'pObj isn\'t an object' . PHP_EOL
              . __METHOD__ . ' (' . __LINE__ . ')'
              ;
      die( $prompt );
    }
    $this->pObj = $pObj;
  }



  /***********************************************
   *
   * Main
   *
   **********************************************/

/**
 * convertXmlToArray( )  :
 *
 * @return	array
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function convertXmlToArray( $content )
  {
    $xml = new SimpleXMLElement( $content );
    
    $programm = $this-
    $subject  = 'Failed';
    $body     = __CLASS__ . '::' .  __METHOD__ . ' (' . __LINE__ . ')';
    $this->pObj->drsMailToAdmin( $subject, $body );

    return false;
  }
  
}

if (defined('TYPO3_MODE') && isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/orgesab/lib/class.tx_orgesab_convert.php'])) {
  include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/orgesab/lib/class.tx_orgesab_convert.php']);
}

?>