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
 * @return	boolean
 * @access public
 * @version       0.0.1
 * @since         0.0.1
 */
  public function main( $content )
  {
    $this->init( );
    
t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $content, $this->extKey, 3 );
    $content = '<<<XML' . PHP_EOL . $content . PHP_EOL . 'XML;';
t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $content, $this->extKey, 3 );
    
    $xml = simplexml_load_string( '<<<XML' . PHP_EOL . $content . PHP_EOL . 'XML;' );
    if( ! $xml )
    {
      $subject  = 'Failed';
      $body     = 'XML string could not open.' . PHP_EOL
                . PHP_EOL
                . 'Content : ' . $content . PHP_EOL
                . PHP_EOL
                . __CLASS__ . '::' .  __METHOD__ . ' (' . __LINE__ . ')';
      $this->pObj->drsMailToAdmin( $subject, $body );
      
      return false;
    }
    
      // programm data
    $programm = $this->getProgramm( $xml );

    $prompt = implode( ';' . $programm );
    t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 3 );
    
    if( ! $programm )
    {
      return false;
    }

    $prompt = implode( ';' . $programm );
    t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 3 );

      // category data
    $bereiche = $this->getBereiche( $xml );
      // item data
    $angebote = $this->getAngebote( $xml );

    

    $subject  = 'Failed';
    $body     = __CLASS__ . '::' .  __METHOD__ . ' (' . __LINE__ . ')';
    $this->pObj->drsMailToAdmin( $subject, $body );

    return false;
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

    return false;
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

    return false;
  }

/**
 * getProgramm( )  :
 *
 * @param       object      $xml      : xml object
 * @return	array       $content  :
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function getProgramm( $xml )
  {
//<Programm>
//  <programm_bezeichnung></programm_bezeichnung>
//  <programm_beginn></programm_beginn>
//  <programm_ende></programm_ende>
//  <Bereich>
//    ...
//  </Bereich>
//</Programm>
    
    $programm = array
    (
      'programm_bezeichnung'  => $xml->programm_bezeichnung,
      'programm_beginn'       => $xml->programm_beginn,
      'programm_ende'         => $xml->programm_ende
    );
    
    //$this->promptAndMail( 'Programm', $programm );

    $prompt = implode( ';' . $programm );
    t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 3 );

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