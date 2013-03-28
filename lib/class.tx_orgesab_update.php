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
 *   56: class tx_orgesab_update
 *
 *              SECTION: Main
 *   88:     public function main( )
 *
 *              SECTION: Init
 *  118:     private function init( )
 *
 *              SECTION: Set
 *  146:     public function setPobj( $pObj )
 *
 * TOTAL FUNCTIONS: 3
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */

/**
 * Class "tx_orgesab_update" provides procedures for update the database
 *
 * @author        Dirk Wildt (http://wildt.at.die-netzmacher.de/)
 * @package        TYPO3
 * @subpackage    orgesab
 * @version       0.0.1
 * @since         0.0.1
 */
class tx_orgesab_update {

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
 * @param       array     $content  :        
 * @return	boolean
 * @access public
 * @version       0.0.1
 * @since         0.0.1
 */
  public function main( $content )
  {
    $success = false;

    $this->init( );
    $this->insert( $content );
    
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
   * Insert
   *
   **********************************************/

/**
 * insert( )  :
 *
 * @param       array     $content  :        
 * @return	boolean
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function insert( $content )
  {
$prompt = implode( '; ', array_keys( $content ) );
t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 0 );
    
    foreach( $content as $tables => $table )
    {
      $tableName  = $tables;
      $truncate   = $table['truncate'];
      $records    = $table['records'];
$prompt = $tableName;
t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 0 );
$prompt = $truncate;
t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 0 );
$prompt = implode( '; ', array_keys( $records ) );
t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 0 );
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
}

if (defined('TYPO3_MODE') && isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/orgesab/lib/class.tx_orgesab_update.php'])) {
  include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/orgesab/lib/class.tx_orgesab_update.php']);
}

?>