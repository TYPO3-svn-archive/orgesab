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
  public function main( )
  {
    $success = false;
    $this->updateDatabase = false;

    $this->init( );

    if( ! $this->convertContent( ) )
    {
      return $success;
    }

    if( ! $this->xmlIsUpdated( ) )
    {
      $success = true;
      return $success;
    }

    if( ! $this->xmlForDatabase( ) )
    {
      return $success;
    }

    $subject  = 'Failed';
    $body     = __CLASS__ . '::' .  __METHOD__ . ' (' . __LINE__ . ')';
    $this->pObj->drsMailToAdmin( $subject, $body );

    return $success;
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
    if( ! is_object( $this->pObj ) )
    {
      $prompt = 'pObj isn\'t an object' . PHP_EOL
              . __METHOD__ . ' (' . __LINE__ . ')'
              ;
      die( $prompt );
    }
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
 * xmlForDatabase( )  :
 *
 * @return	boolean
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function xmlForDatabase( )
  {
    $success = false;
    $this->updateDatabase = false;

    if( ! $this->xmlIsUpdated( ) )
    {
      $success = true;
      return $success;
    }

    if( ! $this->xmlForDatabase( ) )
    {
      return $success;
    }

    $subject  = 'Failed';
    $body     = __CLASS__ . '::' .  __METHOD__ . ' (' . __LINE__ . ')';
    $this->pObj->drsMailToAdmin( $subject, $body );

    return $success;
  }

/**
 * convertContent( )  :
 *
 * @return	boolean
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function convertContent( )
  {
    $success = false;
    $this->updateDatabase = false;

    $subject  = 'Failed';
    $body     = __CLASS__ . '::' .  __METHOD__ . ' (' . __LINE__ . ')';
    $this->pObj->drsMailToAdmin( $subject, $body );

    return $success;
  }

/**
 * xmlIsUpdated( )  :
 *
 * @return	boolean
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function xmlIsUpdated( )
  {
    $success = false;
    $this->updateDatabase = true;

    $subject  = 'Failed';
    $body     = __CLASS__ . '::' .  __METHOD__ . ' (' . __LINE__ . ')';
    $this->pObj->drsMailToAdmin( $subject, $body );

    return $success;
  }
}

if (defined('TYPO3_MODE') && isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/orgesab/lib/class.tx_orgesab_convert.php'])) {
  include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/orgesab/lib/class.tx_orgesab_convert.php']);
}

?>