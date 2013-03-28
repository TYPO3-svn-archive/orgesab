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
    
    $records = array(
      'tx_orgesab' => array(
        'truncate' => true,
        'records'  => $this->setOrgesab( $content ),
      ),
      'tx_orgesab_cat' => array(
        'truncate' => true,
        'records'  => $this->setOrgesabCat( $content ),
      ),
      'tx_orgesab_mm_tx_orgesab_cat' => array(
        'truncate' => true,
        'records'  => $this->setOrgesabMmCat( $content ),
      ),
    );

    return $records;
  }



  /***********************************************
   *
   * Get
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
          'bereich_zuordnung'     => ( string ) $bereich->bereich_zuordnung,  
          'angebot_ausgebucht'    => ( string ) $angebot->angebot_ausgebucht,
          'angebot_bereich'       => ( string ) $angebot->angebot_bereich,
          'angebot_beschreibung'  => ( string ) $angebot->angebot_beschreibung,
          'angebot_details'       => ( string ) $angebot->angebot_details,
          'angebot_inhalte'       => ( string ) $angebot->angebot_inhalte,
          'angebot_keywords'      => ( string ) $angebot->angebot_keywords,
          'angebot_kursleiter1'   => ( string ) $angebot->angebot_kursleiter1,
          'angebot_kursleiter2'   => ( string ) $angebot->angebot_kursleiter2,
          'angebot_link'          => ( string ) $angebot->angebot_link,
          'angebot_name'          => ( string ) $angebot->angebot_name,
          'angebot_nr'            => ( string ) $angebot->angebot_nr,
          'angebot_ort1'          => ( string ) $angebot->angebot_ort1,
          'angebot_ort2'          => ( string ) $angebot->angebot_ort2,
          'angebot_ort3'          => ( string ) $angebot->angebot_ort3,
          'angebot_ort4'          => ( string ) $angebot->angebot_ort4,
          'angebot_ort5'          => ( string ) $angebot->angebot_ort5,
          'angebot_preis_1'       => ( string ) $angebot->angebot_preis_1,
          'angebot_preis_2'       => ( string ) $angebot->angebot_preis_2,
          'angebot_preis_3'       => ( string ) $angebot->angebot_preis_3,
          'angebot_tag1'          => ( string ) $angebot->angebot_tag1,
          'angebot_tag2'          => ( string ) $angebot->angebot_tag2,
          'angebot_tag3'          => ( string ) $angebot->angebot_tag3,
          'angebot_tag4'          => ( string ) $angebot->angebot_tag4,
          'angebot_tag5'          => ( string ) $angebot->angebot_tag5,
          'angebot_uhrzeit1'      => ( string ) $angebot->angebot_uhrzeit1,
          'angebot_uhrzeit2'      => ( string ) $angebot->angebot_uhrzeit2,
          'angebot_uhrzeit3'      => ( string ) $angebot->angebot_uhrzeit3,
          'angebot_uhrzeit4'      => ( string ) $angebot->angebot_uhrzeit4,
          'angebot_uhrzeit5'      => ( string ) $angebot->angebot_uhrzeit5,
          'angebot_zeitraum'      => ( string ) $angebot->angebot_zeitraum,
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
      $prompt = 'The second and the last Angebot: ';
      t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 0 );
      $prompt = var_export( $angebote[1], true);
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
    $id = 0;
    
    foreach( $xml->Bereich as $bereich )
    {
      $id++;
      $bereiche[$id] = ( string ) $bereich->bereich_zuordnung;

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
      'programm_bezeichnung'  => ( string ) $xml->programm_bezeichnung,
      'programm_beginn'       => ( string ) $xml->programm_beginn,
      'programm_ende'         => ( string ) $xml->programm_ende
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
   * Init
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
   * Set tables
   *
   **********************************************/

/**
 * setOrgesab( )  :
 *
 * @param       array       $content  : 
 * @return	array       $records  :
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function  setOrgesab( $content )
  {
    $records = array( );
    
      // LOOP : Angebote
    foreach( $content['angebote'] as $uid => $angebot )
    {
      $records[] = array
      (
        'uid'       => $uid,
        'pid'       => $this->pObj->getSysfolderUid( ),
        'tstamp'    => time( ),
        'crdate'    => time( ),
        'cruser_id' => null,
        'deleted'   => 0,
          
        'bodytext'    => $angebot['angebot_details'],
        'bookedup'    => $angebot['angebot_ausgebucht'],
        'bookingurl'  => $angebot['angebot_link'],
        'category'    => $angebot['angebot_bereich'],
        'day1'        => $angebot['angebot_tag1'],
        'day2'        => $angebot['angebot_tag2'],
        'day3'        => $angebot['angebot_tag3'],
        'day4'        => $angebot['angebot_tag4'],
        'day5'        => $angebot['angebot_tag5'],
        'externalid'  => $angebot['angebot_nr'],
        'eventbegin'  => $this->setOrgesabFieldEventBegin( $angebot ),
        'eventend'    => $this->setOrgesabFieldEventEnd(   $angebot ),
        'hours1'      => $angebot['angebot_uhrzeit1'],
        'hours2'      => $angebot['angebot_uhrzeit2'],
        'hours3'      => $angebot['angebot_uhrzeit3'],
        'hours4'      => $angebot['angebot_uhrzeit4'],
        'hours5'      => $angebot['angebot_uhrzeit5'],
        'location1'   => $angebot['angebot_ort1'],
        'location2'   => $angebot['angebot_ort2'],
        'location3'   => $angebot['angebot_ort3'],
        'location4'   => $angebot['angebot_ort4'],
        'location5'   => $angebot['angebot_ort5'],
        'price1'      => $angebot['angebot_preis_1'],
        'price2'      => $angebot['angebot_preis_2'],
        'price3'      => $angebot['angebot_preis_3'],
        'skills'      => $angebot['angebot_inhalte'],
        'staff1'      => $angebot['angebot_kursleiter1'],
        'staff2'      => $angebot['angebot_kursleiter2'],
        'title'       => $angebot['angebot_name'],
        
        'tx_orgesab_cat'  => $angebot['1'],
        'tx_org_cal'      => $angebot['null'],
        
        'hidden'      => $angebot['0'],
        'fe_group'    => $angebot['null'],

        'keywords'    => $angebot['angebot_keywords'],
        'description' => $angebot['angebot_beschreibung'],
      );
    } 
      // LOOP : Angebote
    
      // DRS
    if( $this->pObj->drsModeConvert )
    {
      $number = count( $records );
      $prompt = 'tx_orgesab contains #' . $number . ' records';
      t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 0 );
      $prompt = 'The second and the last record: ';
      t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 0 );
      $prompt = var_export( $records[1], true);
      t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 0 );
      $prompt = var_export( $records[ $number - 1 ], true);
      t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 0 );
    }
      // DRS

    return $records;
  }

/**
 * setOrgesabCat( )  :
 *
 * @param       array       $content  : 
 * @return	array       $records  :
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function  setOrgesabCat( $content )
  {
    $records = array( );
    
    return $records;
  }

/**
 * setOrgesab( )  :
 *
 * @param       array       $content  : 
 * @return	array       $records  :
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function  setOrgesabFieldEventBegin( $angebot )
  {
    $second = 0;

    // 09:30-17:00
    list( $timeBegin ) = explode( '-', $angebot['angebot_uhrzeit1'] );

    // 23.06. - 28.06.2013 || Herbst 2013 || 28.09.2013
    list( $periodBegin, $periodEnd ) = explode( '-', $angebot['angebot_zeitraum'] );
    $periodBegin = trim( $periodBegin );
    
    list( $hour, $minute )      = explode( ':', $timeBegin );
    $hour   = ( int ) $hour;
    $minute = ( int ) $minute;
    list( $day, $month, $year ) = explode( '.', $periodBegin );
    $day    = ( int ) $day;
    $month  = ( int ) $month;
    $year   = ( int ) $year;
    if( empty( $year ) )
    {
      list( $dummy, $dummy, $year ) = explode( '.', $periodEnd );
      $year = ( int ) $year;
    }
    
    switch (true )
    {
      case( empty( $day   ) ):
      case( empty( $month ) ):
      case( empty( $year  ) ):
          // DRS
        if( $this->pObj->drsModeError )
        {
          $uid    = $angebot['angebot_nr'];
          $title  = $angebot['angebot_name'];
          $period = $angebot['angebot_zeitraum'];
          $hours  = $angebot['angebot_uhrzeit1'];
          $prompt = 'Unproper period in Angebot "' . $title . '" '
                  . '(# ' . $uid . '): ' . $period . ' ' . $hours;
          t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 3 );
        }
          // DRS
        break;
      default:
        // Result is proper
        break;
    }

    $timestamp = mktime( $hour, $minute, $second, $month, $day, $year );
    
    return $timestamp;
  }

/**
 * setOrgesabFieldEventEnd( )  :
 *
 * @param       array       $content  : 
 * @return	array       $records  :
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function  setOrgesabFieldEventEnd( $angebot )
  {
    $second = 0;

    // 09:30-17:00
    list( $timeBegin, $timeEnd ) = explode( '-', $angebot['angebot_uhrzeit1'] );
    if( empty ( $timeEnd ) )
    {
      $timeEnd = $timeBegin;
    }
    // 23.06. - 28.06.2013 || Herbst 2013 || 28.09.2013
    list( $periodBegin, $periodEnd ) = explode( '-', $angebot['angebot_zeitraum'] );
    if( empty ( $periodEnd ) )
    {
      $periodEnd = $periodBegin;
    }
    $periodEnd = trim( $periodEnd );
    
    list( $hour, $minute )      = explode( ':', $timeEnd );
    $hour   = ( int ) $hour;
    $minute = ( int ) $minute;
    list( $day, $month, $year ) = explode( '.', $periodEnd );
    $day    = ( int ) $day;
    $month  = ( int ) $month;
    $year   = ( int ) $year;
    
    switch (true )
    {
      case( empty( $day   ) ):
      case( empty( $month ) ):
      case( empty( $year  ) ):
          // DRS
        if( $this->pObj->drsModeError )
        {
          $uid    = $angebot['angebot_nr'];
          $title  = $angebot['angebot_name'];
          $period = $angebot['angebot_zeitraum'];
          $hours  = $angebot['angebot_uhrzeit1'];
          $prompt = 'Unproper period in Angebot "' . $title . '" '
                  . '(# ' . $uid . '): ' . $period . ' ' . $hours;
          t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 3 );
        }
          // DRS
        break;
      default:
        // Result is proper
        break;
    }

    $timestamp = mktime( $hour, $minute, $second, $month, $day, $year );
    
    return $timestamp;
  }

/**
 * setOrgesabFieldEventEnd( )  :
 *
 * @param       array       $content  : 
 * @return	array       $records  :
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function  setOrgesabMmCat( $content )
  {
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