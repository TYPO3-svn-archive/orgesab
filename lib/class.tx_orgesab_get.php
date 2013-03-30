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
 *   64: class tx_orgesab_get
 *
 *              SECTION: Main
 *  103:     public function main( )
 *
 *              SECTION: Init
 *  141:     private function init( )
 *  159:     private function initPobj( )
 *
 *              SECTION: Get
 *  201:     private function getContent( )
 *  228:     public function getContentIsUpToDate( )
 *  242:     private function getMd5( $xml )
 *  257:     private function getMd5Comparision( $xml )
 *
 *              SECTION: Set
 *  290:     private function setContentIsUpdated( $xml )
 *  341:     public function setPobj( $pObj )
 *
 * TOTAL FUNCTIONS: 9
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */

/**
 * Class "tx_orgesab_get" provides procedures for import an fetch file
 *
 * @author        Dirk Wildt (http://wildt.at.die-netzmacher.de/)
 * @package        TYPO3
 * @subpackage    orgesab
 * @version       0.0.1
 * @since         0.0.1
 */
class tx_orgesab_get {

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

  /**
    * Status of the xml file
    *
    * @var boolean
    */
    private $contentIsUpToDate;



  /***********************************************
   *
   * Main
   *
   **********************************************/

/**
 * main( )  :
 *
 * @return	object		$xml  : the xml object
 * @access public
 * @version       0.0.1
 * @since         0.0.1
 */
  public function main( )
  {
      // Init
    $this->init( );

      // Get the content
    $xml = $this->getContent( );

      // RETURN false : content isn't proper
    if( ! $xml )
    {
      return false;
    }
      // RETURN false : content isn't proper

      // Set var $contentIsUpToDate
    $this->setContentIsUpdated( $xml );

      // RETURN true : content is proper
    return $xml;
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
   * Get
   *
   **********************************************/

/**
 * getContent( )  :
 *
 * @return	object		$xml : xml object
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function getContent( )
  {
    $xml = simplexml_load_file( $this->pObj->getImportUrl( ) );
    if( $xml )
    {
      return $xml;
    }

    $subject  = 'Failed';
    $body     = 'XML file could not open.' . PHP_EOL
              . PHP_EOL
              . 'Url : ' . $this->pObj->getImportUrl( ) . PHP_EOL
              . PHP_EOL
              . __CLASS__ . '::' .  __METHOD__ . ' (' . __LINE__ . ')';
    $this->pObj->drsMailToAdmin( $subject, $body );

    return false;
  }

/**
 * getContentIsUpToDate( )  :
 *
 * @return	boolean
 * @access public
 * @version       0.0.1
 * @since         0.0.1
 */
  public function getContentIsUpToDate( )
  {
    return $this->contentIsUpToDate;
  }

/**
 * getMd5( )  :
 *
 * @param	object		$xml  : the xml object
 * @return	integer		$md5  :
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function getMd5( $xml )
  {
    $md5 = md5( var_export( $xml, true ) );
    return $md5;
  }

/**
 * getMd5Comparision( )  :
 *
 * @param	object		$xml                : the xml object
 * @return	boolean		$contentIsUpToDate  :
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function getMd5Comparision( $xml )
  {
    $contentIsUpToDate  = false;
    $key                = 'md5LastContent';

    $md5CurrFile = $this->getMd5( $xml );
    $md5LastFile = $this->pObj->registryGet( $key );

    switch( $md5CurrFile != $md5LastFile )
    {
      case( true ):
          // DRS
        $prompt = 'File isn\'t up to date.';
        $contentIsUpToDate = false;
        break;
      case( false ):
      default:
          // DRS
        $prompt = 'File is up to date.';
        $contentIsUpToDate = true;
        break;
    }

      // DRS
    if( $this->pObj->drsModeInfo )
    {
      $prompt = $prompt
              . ' md5 current file: ' . $md5CurrFile. '; md5 last file: ' . $md5LastFile;
      t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 0 );
    }
      // DRS

    return $contentIsUpToDate;
  }



  /***********************************************
   *
   * Set
   *
   **********************************************/

/**
 * setContentIsUpdated( )  :
 *
 * @param	object		$xml  : the xml object
 * @return	boolean
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function setContentIsUpdated( $xml )
  {
    $success = false;

    switch( $this->pObj->getImportMode( ) )
    {
      case( 'ever'):
        $prompt = 'Import mode: ever';
        $this->contentIsUpToDate = false;
        $success = true;
        break;
      case( 'never'):
        $prompt = 'Import mode: never';
        $this->contentIsUpToDate = true;
        $success = true;
        break;
      case( 'update'):
        $prompt = 'Import mode: update';
        $this->contentIsUpToDate = $this->getMd5Comparision( $xml );
        $success = true;
        break;
      default:
        $success = false;
          // DRS
        if( $this->pObj->drsModeError )
        {
          $prompt = 'Undefined value for import mode';
          t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 3 );
        }
          // DRS

          // e-mail to admin
        $subject  = 'Failed';
        $body     = 'Undefined value for import mode. ' . PHP_EOL
                  . PHP_EOL
                  . __CLASS__ . '::' .  __METHOD__ . ' (' . __LINE__ . ')';
        $this->pObj->drsMailToAdmin( $subject, $body );
          // e-mail to admin

        break;
    }

      // DRS
    if( $this->pObj->drsModeInfo )
    {
      $prompt = 'contentIsUpToDate is set to "' . $this->contentIsUpToDate . "'";
      t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 0 );
    }
      // DRS
    return $success;
  }

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
    if( is_object( $pObj ) )
    {
      $this->pObj = $pObj;
      return true;
    }

      // DRS
    if( $this->pObj->drsModeError )
    {
      $prompt = 'pObj isn\'t an object';
      t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 3 );
    }
      // DRS

      // e-mail to admin
    $subject  = 'Failed';
    $body     = 'pObj isn\'t an object. ' . PHP_EOL
              . PHP_EOL
              . __CLASS__ . '::' .  __METHOD__ . ' (' . __LINE__ . ')';
    $this->pObj->drsMailToAdmin( $subject, $body );
      // e-mail to admin

    return false;
  }
}

if (defined('TYPO3_MODE') && isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/orgesab/fetch/class.tx_orgesab_get.php'])) {
  include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/orgesab/fetch/class.tx_orgesab_get.php']);
}

?>