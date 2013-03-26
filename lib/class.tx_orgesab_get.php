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
 *   70: class tx_orgesab_get_AdditionalFieldProvider implements tx_scheduler_AdditionalFieldProvider
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
 * @return	boolean
 * @access      public
 * @version       0.0.1
 * @since         0.0.1
 */
  public function main( )
  {
      // Init
    $this->init( );

      // Get the content
    $content = $this->getContent( );

      // RETURN false : content isn't proper
    if( ! $content ) 
    {
      return false;
    }
      // RETURN false : content isn't proper
    
      // Set var $contentIsUpToDate
    $this->setContentIsUpdated( $content );
    
      // RETURN true : content is proper
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
 * @access      private
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
 * @access      private
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
    if( $this->pObj->drsError )
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
 * @return	boolean
 * @access      private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function getContent( )
  {
    $handle = fopen( $this->pObj->getImportUrl( ), 'r' );
    if( ! $this->getContentIsRessource( $handle ) )
    {
      fclose( $handle );
      return false;
    }
    $content  = stream_get_contents( $handle );
    if( ! $this->getContentIsNotEmpty( $content ) )
    {
      fclose( $handle );
      return false;
    }
    fclose( $handle );
    
    return $content;
  }

/**
 * getContentIsNotEmpty( )  : 
 *
 * @return	boolean
 * @access      private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function getContentIsNotEmpty( $content )
  {
    if( $content )
    {
      return true;
    }
    
      // DRS
    if( $this->pObj->drsError )
    {
      $prompt = 'content is empty: ' . $this->pObj->getImportUrl( );
      t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 3 );
    }
      // DRS
    
      // e-mail to admin
    $subject  = 'Failed';
    $body     = 'Sorry, but content of URL is empty. ' . PHP_EOL 
              . 'URL: ' . $this->pObj->getImportUrl( ) . PHP_EOL
              . PHP_EOL
              . __CLASS__ . '::' .  __METHOD__ . ' (' . __LINE__ . ')';
    $this->pObj->drsMailToAdmin( $subject, $body );
      // e-mail to admin

    return false;
  }

/**
 * getContentIsRessource( )  : 
 *
 * @return	boolean
 * @access      private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function getContentIsRessource( $handle )
  {
    if( is_resource( $handle ) )
    {
      return true;
    }
    
      // DRS
    if( $this->pObj->drsError )
    {
      $prompt = 'Can\'t get a ressource for  ' . $this->pObj->getImportUrl( );
      t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 3 );
    }
      // DRS
    
      // e-mail to admin
    $subject  = 'Failed';
    $body     = 'Sorry, but ressource of fopen( ) isn\'t proper. ' . PHP_EOL 
              . 'URL: ' . $this->pObj->getImportUrl( ) . PHP_EOL
              . PHP_EOL
              . __CLASS__ . '::' .  __METHOD__ . ' (' . __LINE__ . ')';
    $this->pObj->drsMailToAdmin( $subject, $body );
      // e-mail to admin

    return false;
  }

/**
 * getContentIsUpToDate( )  : 
 *
 * @return	boolean
 * @access      public
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
 * @return	boolean
 * @access      private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function getMd5( $content )
  {
    $md5 = md5( $content );
    return $md5;
  }

/**
 * getMd5Comparision( )  : 
 *
 * @return	boolean
 * @access      private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function getMd5Comparision( $content )
  {
    $contentIsUpToDate = false;

    $md5CurrFile = $this->getMd5( $content );
    $md5LastFile = $this->pObj->registryGet( );
    
    if( $md5CurrFile != $md5LastFile )
    {
      $contentIsUpToDate = false;
    }

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
 * @return	boolean
 * @access      private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function setContentIsUpdated( $content )
  {
    $success = false;

    switch( $this->pObj->getImportMode( ) )
    {
      case( 'ever'):
        $this->contentIsUpToDate = false;
        $success = true;
        break;
      case( 'never'):
        $this->contentIsUpToDate = true;
        $success = true;
        break;
      case( 'update'):
        $this->contentIsUpToDate = $this->getMd5Comparision( $content );
        $success = true;
        break;
      default:
        $success = false;
          // DRS
        if( $this->pObj->drsError )
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

    return $success;
  }

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
    if( is_object( $pObj ) )
    {
      $this->pObj = $pObj;
      return true;
    }
    
      // DRS
    if( $this->pObj->drsError )
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