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
 *   70: class tx_orgesab_xml_AdditionalFieldProvider implements tx_scheduler_AdditionalFieldProvider
 *
 *              SECTION: Bulding the form
 *  101:     public function getAdditionalFields( array &$taskInfo, $task, tx_scheduler_Module $parentObject )
 *  131:     private function getFieldImportMode( array &$taskInfo, $task, $parentObject )
 *  204:     private function getFieldImportUrl( array &$taskInfo, $task, $parentObject )
 *  262:     private function getFieldOrgesabAdminEmail( array &$taskInfo, $task, $parentObject )
 *  320:     private function getFieldReportMode( array &$taskInfo, $task, $parentObject )
 *
 *              SECTION: Saving
 *  393:     public function saveAdditionalFields( array $submittedData, tx_scheduler_Task $task )
 *  411:     private function saveFieldImportMode( array $submittedData, tx_scheduler_Task $task )
 *  426:     private function saveFieldImportUrl( array $submittedData, tx_scheduler_Task $task )
 *  442:     private function saveFieldOrgesabAdminEmail( array $submittedData, tx_scheduler_Task $task )
 *  457:     private function saveFieldReportMode( array $submittedData, tx_scheduler_Task $task )
 *
 *              SECTION: Validating
 *  480:     public function validateAdditionalFields( array &$submittedData, tx_scheduler_Module $parentObject )
 *  536:     private function validateFieldFrequency( array &$submittedData, tx_scheduler_Module $parentObject )
 *  561:     private function validateFieldImportMode( array &$submittedData, tx_scheduler_Module $parentObject )
 *  601:     private function validateFieldImportUrl( array &$submittedData, tx_scheduler_Module $parentObject )
 *  632:     private function validateFieldOrgesabAdminEmail( array &$submittedData, tx_scheduler_Module $parentObject )
 *  658:     private function validateFieldReportMode( array &$submittedData, tx_scheduler_Module $parentObject )
 *  698:     private function validateFieldStart( array &$submittedData, tx_scheduler_Module $parentObject )
 *  726:     public function validateOS( tx_scheduler_Module $parentObject )
 *
 * TOTAL FUNCTIONS: 18
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
class tx_orgesab_xml {

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
 * @access      public
 * @version       0.0.1
 * @since         0.0.1
 */
  public function main( )
  {
    $success = false;
    $this->updateDatabase = false;
    
    $this->init( );

    if( ! $this->xmlFetchFile( ) ) 
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
 * @access      private
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
 * @return	boolean
 * @access      public
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
 * @access      private
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
 * xmlFetchFile( )  : 
 *
 * @return	boolean
 * @access      private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function xmlFetchFile( )
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
 * @access      private
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

if (defined('TYPO3_MODE') && isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/orgesab/lib/xml/class.tx_orgesab_xml.php'])) {
  include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/orgesab/lib/xml/class.tx_orgesab_xml.php']);
}

?>