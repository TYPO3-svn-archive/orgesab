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
    $this->init( );
    
    if( ! $this->truncate( $content ) )
    {
      return false;
    }

    if( ! $this->insert( $content ) )
    {
      return false;
    }
    
    return true;
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
    $recordCounter  = 0;
    
    foreach( $content as $table => $properties )
    {
      foreach( $properties['records'] as $record )
      {
        if( ! $this->insertQuery( $table, $record, $recordCounter ) )
        {
          return false;
        }
        $recordCounter++;
      }
    }

    return true;
  }

/**
 * insertQuery( )  :
 *
 * @param       string    $table          :
 * @param       array     $record         :
 * @param       array     $recordCounter  :
 * @return	void
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function insertQuery( $table, $record, $recordCounter )
  {
    $success = null;
    
    $query = $GLOBALS['TYPO3_DB']->INSERTquery( $table, $record );
    $GLOBALS['TYPO3_DB']->exec_INSERTquery( $table, $record );
    $error = $GLOBALS['TYPO3_DB']->sql_error( );

    switch( $error )
    {
      case( true ):
        $this->promptError( $query, $error );
        $success = false;
        break;
      case( false ):
      default:
        $this->promptSuccess( $query, $recordCounter );
        $success = true;
        break;
    }
    return $success;
  }



  /***********************************************
   *
   * Prompts
   *
   **********************************************/

/**
 * promptError( )  :
 *
 * @param       string    $table          :
 * @param       array     $record         :
 * @param       array     $recordCounter  :
 * @return	void
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function promptError( $query, $error )
  {
    $this->promptErrorDrs(   $query, $error );
    $this->promptErrorMail(  $query, $error );
  }

/**
 * promptErrorDrs( )  :
 *
 * @param       string    $table          :
 * @param       array     $record         :
 * @param       array     $recordCounter  :
 * @return	void
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function promptErrorDrs( $query, $error )
  {
    if( ! $this->pObj->drsModeSql )
    {
      return;
    }

    $prompt = 'Error: ' . $error;
    t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 3 );
    $prompt = 'Query: ' . $query;
    t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 2 );
  }

/**
 * promptErrorMail( )  :
 *
 * @param       string    $table          :
 * @param       array     $record         :
 * @param       array     $recordCounter  :
 * @return	void
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function promptErrorMail( $query, $error )
  {
    $subject  = 'SQL query failed';
    $body     = 'Sorry, but query isn\'t proper. ' . PHP_EOL
              . PHP_EOL
              . 'Error: ' . $error
              . PHP_EOL
              . 'Query: ' . $query . PHP_EOL
              . PHP_EOL
              . __CLASS__ . '::' .  __METHOD__ . ' (' . __LINE__ . ')';
    $this->pObj->drsMailToAdmin( $subject, $body );
  }

/**
 * promptSuccess( )  :
 *
 * @param       string    $table          :
 * @param       array     $record         :
 * @param       array     $recordCounter  :
 * @return	void
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function promptSuccess( $query, $recordCounter )
  {
      // RETURN : no DRS
    if( ! $this->pObj->drsModeSql )
    {
      return;
    }
      // RETURN : no DRS

    switch( true )
    {
      case( $recordCounter >= 1 ):
          // Prompt nothing
        break;
      case( $recordCounter == 0 ):
      default:
        $prompt = $query;
        t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, -1 );
        break;
    }
    unset( $recordCounter );
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
   * Truncate
   *
   **********************************************/

/**
 * truncate( )  :
 *
 * @param       array     $content  :        
 * @return	array     $truncate :
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function truncate( $content )
  {
    $success  = null;
    $query    = null;
    
    foreach( $content as $table => $properties )
    {
      if( ! $properties['truncate'] )
      {
        continue;
      }
      $query = $query
              . 'TRUNCATE ' . $table . '; ' 
              ;
      continue 2;
    }
    
    $GLOBALS['TYPO3_DB']->sql_query( $query );
    $error = $GLOBALS['TYPO3_DB']->sql_error( );

    switch( $error )
    {
      case( true ):
        $this->promptError( $query, $error );
        $success = false;
        break;
      case( false ):
      default:
        $recordCounter = 0;
        $this->promptSuccess( $query, $recordCounter );
        $success = true;
        break;
    }
    return $success;
  }
}

if (defined('TYPO3_MODE') && isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/orgesab/lib/class.tx_orgesab_update.php'])) {
  include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/orgesab/lib/class.tx_orgesab_update.php']);
}

?>