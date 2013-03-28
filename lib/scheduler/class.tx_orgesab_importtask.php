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
 *   97: class tx_orgesab_ImportTask extends tx_scheduler_Task
 *
 *              SECTION: Main
 *  263:     public function execute( )
 *
 *              SECTION: Additional information for scheduler
 *  339:     public function getAdditionalInformation( )
 *
 *              SECTION: Converting
 *  364:     private function convertContent( )
 *  386:     private function convertContentDrsMail( $success )
 *  410:     private function convertContentInstance( )
 *
 *              SECTION: DRS - Development Reporting System
 *  439:     private function drsDebugTrail( $level = 1 )
 *  485:     public function drsMailToAdmin( $subject='Information', $body=null )
 *
 *              SECTION: Get private
 *  597:     private function getContent( )
 *  621:     private function getContentInstance( )
 *
 *              SECTION: Get public
 *  647:     public function getAdminmail( )
 *  660:     public function getImportMode( )
 *  673:     public function getImportUrl( )
 *  686:     public function getReportMode( )
 *
 *              SECTION: Initials
 *  707:     private function init( )
 *  733:     private function initDRS( )
 *  775:     private function initRequirements( )
 *  804:     private function initRequirementsAdminmail( )
 *  832:     private function initRequirementsAllowUrlFopen( )
 *  871:     private function initRequirementsOs( )
 *  923:     private function initRegistryInstance( )
 *  936:     private function initTimetracking( )
 *
 *              SECTION: Registry
 *  960:     public function registryGet( $key )
 *  984:     public function registryKey( $key )
 * 1027:     public function registrySet( $key, $value )
 *
 *              SECTION: Time tracking
 * 1061:     private function timeTracking_init( )
 * 1083:     private function timeTracking_log( $debugTrailLevel, $prompt )
 * 1135:     private function timeTracking_prompt( $debugTrailLevel, $prompt )
 *
 *              SECTION: Update
 * 1172:     private function updateDatabase( )
 * 1194:     private function updateDatabaseDrsMail( $success )
 * 1218:     private function updateDatabaseInstance( )
 *
 * TOTAL FUNCTIONS: 30
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */

/**
 * Class "tx_orgesab_ImportTask" provides procedures for check import and control orgesab mailboxes
 *
 * @author        Dirk Wildt (http://wildt.at.die-netzmacher.de/)
 * @package        TYPO3
 * @subpackage    orgesab
 * @version       0.0.1
 * @since         0.0.1
 */
class tx_orgesab_ImportTask extends tx_scheduler_Task {

  /**
    * Extension key
    *
    * @var string $extKey
    */
    public $extKey = 'orgesab';

  /**
    * Extension configuration by the extension manager
    *
    * @var array $extConf
    */
    private $extConf;

  /**
    * The convert object
    *
    * @var object
    */
    private $convert;

  /**
    * DRS mode: display prompt in every case
    *
    * @var boolean $drsModeAll
    */
    public $drsModeAll;

  /**
    * DRS mode: display prompt in error case only
    *
    * @var boolean $drsModeError
    */
    public $drsModeError;

  /**
    * DRS mode: display prompt in warning case only
    *
    * @var boolean $drsModeWarn
    */
    public $drsModeWarn;

  /**
    * DRS mode: display prompt in info case only
    *
    * @var boolean $drsModeInfo
    */
    public $drsModeInfo;

  /**
    * DRS mode: display prompt in warning case only
    *
    * @var boolean $drsModeConvert
    */
    public $drsModeConvert;

  /**
    * DRS mode: display prompt in performance case
    *
    * @var boolean $drsModePerformance
    */
    public $drsModePerformance;

  /**
    * DRS mode: display prompt in importTask case
    *
    * @var boolean $drsModeImportTask
    */
    public $drsModeImportTask;

  /**
    * DRS mode: display prompt in sql case
    *
    * @var boolean $drsModeSql
    */
    public $drsModeSql;

  /**
    * DRS mode: display prompt in warning case only
    *
    * @var boolean $drsModeXml
    */
    public $drsModeXml;

  /**
    * An email address to be used during the process
    *
    * @var string $orgesab_orgesabAdminEmail
    */
    private $orgesab_orgesabAdminEmail;

  /**
    * Report mode: ever, never, update
    *
    * @var string
    */
    private $orgesab_importMode;

  /**
    * Import URL
    *
    * @var string
    */
    private $orgesab_importUrl;

  /**
    * Report mode: ever, never, update, warn
    *
    * @var string
    */
    private $orgesab_reportMode;

  /**
    * Report mode: ever, never, update, warn
    *
    * @var uid
    */
    private $orgesab_sysfolderUid;


  /**
    * registry object
    *
    * @var object
    */
    private $registry;

  /**
    * t3lib_timeTrack object
    *
    * @var object
    */
    private $TT;

   /**
    * Endtime of previous process
    *
    * @var integer
    */
    private $tt_prevEndTime;

  /**
    * Level of warning
    *
    * @var integer
    */
    private $tt_prevPrompt;

  /**
    * Startime of the script
    *
    * @var integer
    */
    private $tt_startTime;

  /**
    * The update object
    *
    * @var object
    */
    private $update;

  /**
    * The get object
    *
    * @var object
    */
    private $get;



  /***********************************************
   *
   * Main
   *
   **********************************************/

/**
 * execute( )  : Function executed from the Scheduler.
 *               * Sends an email
 *
 * @return	boolean
 * @access public
 * @version       0.0.1
 * @since         0.0.1
 */
  public function execute( )
  {
      // Init var for debug trail
    $debugTrailLevel = 1;

      // RETURN false : init is unproper
    if( ! $this->init( ) )
    {
      $this->timeTracking_log( $debugTrailLevel, 'END' );
      return false;
    }
      // RETURN false : init is unproper

      // RETURN false : content is unproper
    $xml = $this->getContent( );
    if( ! $xml )
    {
      $this->timeTracking_log( $debugTrailLevel, 'END' );
      return false;
    }
      // RETURN false : content is unproper

      // RETURN true : content is up to date
    if( $this->get->getContentIsUpToDate( ) )
    {
      $this->timeTracking_log( $debugTrailLevel, 'END' );
      return true;
    }
      // RETURN true : content is up to date

    $md5 = md5( var_export( $xml, true ) );

      // RETURN false : content is unproper
    $content = $this->convertContent( $xml );
    if( ! $content )
    {
      $this->timeTracking_log( $debugTrailLevel, 'END' );
      return false;
    }
      // RETURN false : content is unproper

      // RETURN false : database could not updated
    if( ! $this->updateDatabase( $content ) )
    {
      return false;
    }
      // RETURN false : database could not updated

      // Set registry
    $key    = 'md5LastContent';
    $value  = $md5;
    $this->registrySet( $key, $value );
      // Set registry

    return true;
  }



  /***********************************************
   *
   * Additional information for scheduler
   *
   **********************************************/

  /**
 * getAdditionalInformation( ) : This method returns the destination mail address as additional information
 *
 * @return	string		Information to display
 * @access public
 * @version       0.0.1
 * @since         0.0.1
 */
  public function getAdditionalInformation( )
  {
    $orgesabAdminEmail  = 'Admin'
                        . ': '
                        . $this->orgesab_orgesabAdminEmail
                        ;
    return $orgesabAdminEmail;
  }



  /***********************************************
   *
   * Converting
   *
   **********************************************/

/**
 * convertContent( )  :
 *
 * @return	boolean
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function convertContent( $xml )
  {
    $this->convertContentInstance( );
    $content = $this->convert->main( $xml );

    return $content;
  }

/**
 * convertContentDrsMail( )  :
 *
 * @param	[type]		$$success: ...
 * @return	void
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function convertContentDrsMail( $success )
  {
    switch( $success )
    {
      case( false ):
        $subject  = 'Failed';
        break;
      case( true ):
      default:
        $subject  = 'Success';
        break;
    }
    $body     = __CLASS__ . '::' .  __METHOD__ . ' (' . __LINE__ . ')';
    $this->drsMailToAdmin( $subject, $body );
  }

/**
 * convertContentInstance( )  :
 *
 * @return	boolean
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function convertContentInstance( )
  {
    $path2lib = t3lib_extMgm::extPath( $this->extKey ) . 'lib/';

    require_once( $path2lib . 'class.tx_orgesab_convert.php' );

    $this->convert = t3lib_div::makeInstance( 'tx_orgesab_convert' );
    $this->convert->setPobj( $this );
  }



  /***********************************************
   *
   * DRS - Development Reporting System
   *
   **********************************************/

/**
 * drsDebugTrail( ): Returns class, method and line of the call of this method.
 *                    The calling method is a debug method - if it is called by another
 *                    method, please set the level in the calling method to 2.
 *
 * @param	integer		$level      : integer
 * @return	array		$arr_return : with elements class, method, line and prompt
 * @access private
 * @version 0.0.1
 * @since   0.0.1
 */
  private function drsDebugTrail( $level = 1 )
  {
    $arr_return = null;

      // Get the debug trail
    $debugTrail_str = t3lib_utility_Debug::debugTrail( );

      // Get debug trail elements
    $debugTrail_arr = explode( '//', $debugTrail_str );

      // Get class, method
    $classMethodLine = $debugTrail_arr[ count( $debugTrail_arr) - ( $level + 2 )];
    list( $classMethod ) = explode ( '#', $classMethodLine );
    list($class, $method ) = explode( '->', $classMethod );
      // Get class, method

      // Get line
    $classMethodLine = $debugTrail_arr[ count( $debugTrail_arr) - ( $level + 1 )];
    list( $dummy, $line ) = explode ( '#', $classMethodLine );
    unset( $dummy );
      // Get line

      // RETURN content
    $arr_return['class']  = trim( $class );
    $arr_return['method'] = trim( $method );
    $arr_return['line']   = trim( $line );
    $arr_return['prompt'] = $arr_return['class'] . '::' . $arr_return['method'] . ' (' . $arr_return['line'] . ')';

    return $arr_return;
      // RETURN content
  }



/**
 * drsMailToAdmin( ): Returns class, method and line of the call of this method.
 *                    The calling method is a debug method - if it is called by another
 *                    method, please set the level in the calling method to 2.
 *
 * @param	string		$subject     : ...
 * @param	string		$body        : ...
 * @return	array		$arr_return  : with elements class, method, line and prompt
 * @access public
 * @version 0.0.1
 * @since   0.0.1
 */
  public function drsMailToAdmin( $subject='Information', $body=null )
  {
    switch( true )
    {
      case( $this->orgesab_reportMode == 'never' ):
          // DRS
        if( $this->drsModeInfo )
        {
          $prompt = 'Report mode is "never": DRS mail isn\'t sent.';
          t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 2 );
        }
          // DRS
        return;
        break;
    }
      // Get call method
    if( basename( PATH_thisScript ) == 'cli_dispatch.phpsh' )
    {
      $calledBy = 'CLI module dispatcher';
      $site     = '-';
    }
    else
    {
      $calledBy = 'TYPO3 backend';
      $site     = t3lib_div::getIndpEnv( 'TYPO3_SITE_URL' );
    }
      // Get call method

    $subject  = 'Org +ESAB: '
              . $subject
              ;

      // Get execution information
    $exec = $this->getExecution( );

    $start    = $exec->getStart( );
    $end      = $exec->getEnd( );
    $interval = $exec->getInterval( );
    $multiple = $exec->getMultiple( );
    $cronCmd  = $exec->getCronCmd( );
    $body     = $body
              . '


Org +ESAB
- - - - - - - - - - - - - - - -
UID:        ' . $this->taskUid . '
Sitename:   ' . $GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'] . '
Site:       ' . $site . '
Called by:  ' . $calledBy . '
tstamp:     ' . date( 'Y-m-d H:i:s' ) . ' [' . time( ) . ']
start:      ' . date( 'Y-m-d H:i:s', $start ) . ' [' . $start . ']
end:        ' . ( ( empty( $end ) ) ? '-' : ( date( 'Y-m-d H:i:s', $end ) . ' [' . $end . ']') ) . '
interval:   ' . $interval . '
multiple:   ' . ( $multiple ? 'yes' : 'no' ) . '
cronCmd:    ' . ( $cronCmd ? $cronCmd : 'not used' )
              ;

      // Prepare mailer and send the mail
    try
    {
      /** @var $mailer t3lib_mail_message */
      $mailer = t3lib_div::makeInstance( 't3lib_mail_message' );
      $mailer->setFrom( array( $this->orgesab_orgesabAdminEmail => 'Org +ESAB' ) );
      $mailer->setReplyTo( array( $this->orgesab_orgesabAdminEmail => 'Org +ESAB' ) );
      $mailer->setSubject( 'Org +ESAB: ' . $subject );
      $mailer->setBody( $body );
      $mailer->setTo( $this->orgesab_orgesabAdminEmail );

      $mailsSend  = $mailer->send( );
      $success    = ( $mailsSend > 0 );
    }
    catch( Exception $e )
    {
      throw new t3lib_exception( $e->getMessage( ) );
    }

      // DRS
    if( $this->drsModeImportTask || $this->drsModeImportError )
    {
      switch( $success )
      {
        case( false ):
          $prompt = 'Undefined error. E-mail couldn\'t sent to "' . $this->orgesab_orgesabAdminEmail . '"';
          t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 3 );
          break;
        case( true ):
        default:
          $prompt = 'E-mail is sent to "' . $this->orgesab_orgesabAdminEmail . '"';
          t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, -1 );
          break;
      }
    }
      // DRS
  }



  /***********************************************
   *
   * Get private
   *
   **********************************************/

/**
 * getContent( )  :
 *
 * @return	boolean
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function getContent( )
  {
      // Initiate the get class
    $this->getContentInstance( );

      // RETURN true : proper content
    $xml = $this->get->main( );
    if( $xml )
    {
      return $xml;
    }
      // RETURN true : proper content

    $subject  = 'Failed';
    $body     = 'Unporper XML' . PHP_EOL
              . PHP_EOL
              . __CLASS__ . '::' .  __METHOD__ . ' (' . __LINE__ . ')';
    $this->pObj->drsMailToAdmin( $subject, $body );

    return false;
  }

/**
 * getContentInstance( )  :
 *
 * @return	boolean
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function getContentInstance( )
  {
    $path2lib = t3lib_extMgm::extPath( $this->extKey ) . 'lib/';

    require_once( $path2lib . 'class.tx_orgesab_get.php' );

    $this->get        = t3lib_div::makeInstance( 'tx_orgesab_get' );
    $this->get->setPobj( $this );
  }



  /***********************************************
   *
   * Get public
   *
   **********************************************/

/**
 * getAdminmail( ):
 *
 * @return	void
 * @access public
 * @version       0.0.1
 * @since         0.0.1
 */
  public function getAdminmail( )
  {
    return $this->orgesab_orgesabAdminEmail;
  }

/**
 * getImportMode( ):
 *
 * @return	void
 * @access public
 * @version       0.0.1
 * @since         0.0.1
 */
  public function getImportMode( )
  {
    return $this->orgesab_importMode;
  }

/**
 * getImportUrl( ):
 *
 * @return	void
 * @access public
 * @version       0.0.1
 * @since         0.0.1
 */
  public function getImportUrl( )
  {
    return $this->orgesab_importUrl;
  }

/**
 * getReportMode( ):
 *
 * @return	void
 * @access public
 * @version       0.0.1
 * @since         0.0.1
 */
  public function getReportMode( )
  {
    return $this->orgesab_reportMode;
  }

/**
 * getAdminmail( ):
 *
 * @return	void
 * @access public
 * @version       0.0.1
 * @since         0.0.1
 */
  public function getSysfolderUid( )
  {
    return $this->orgesab_sysfolderUid;
  }



  /***********************************************
   *
   * Initials
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
    $success = true;

      // Get the extension configuration by the extension manager
    $this->extConf = unserialize( $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['orgesab'] );

    $this->initDRS( );

    if( ! $this->initRequirements( ) )
    {
      $success = false;
      return $success;
    }

    $this->initRegistryInstance( );

    $this->initTimetracking( );

    return $success;
  }

  /**
 * initDRS( )  : Init the DRS - Development Reporting System
 *
 * @return	void
 * @version       0.0.1
 * @since         0.0.1
 */
  private function initDRS( )
  {

    if( $this->extConf['debuggingDrs'] == 'Disabled' )
    {
      return;
    }

    $this->drsModeAll   = true;
    $this->drsModeError = true;
    $this->drsModeWarn  = true;
    $this->drsModeInfo  = true;

    $prompt = 'DRS - Development Reporting System: ' . $this->extConf['debuggingDrs'];
    t3lib_div::devlog( '[tx_orgesab_ImportTask] ' . $prompt, $this->extKey, 0 );

    switch( $this->extConf['debuggingDrs'] )
    {
      case( 'Enabled (for debugging only!)' ):
        $this->drsModeConvert     = true;
        $this->drsModeImportTask  = true;
        $this->drsModePerformance = true;
        $this->drsModeSql         = true;
        $this->drsModeXml         = true;
        break;
      default:
          // :TODO: Error msg per email to admin
        $this->drsModeConvert     = true;
        $this->drsModeImportTask  = true;
        $this->drsModePerformance = true;
        $this->drsModeSql         = true;
        $this->drsModeXml         = true;
        $prompt = 'DRS mode isn\'t defined.';
        t3lib_div::devlog( '[tx_orgesab_ImportTask] ' . $prompt, $this->extKey, 3 );
        break;
    }
  }

/**
 * initRequirements( ) :
 *
 * @return	boolean
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function initRequirements( )
  {
    if( ! $this->initRequirementsAdminmail( ) )
    {
      return false;
    }

    if( ! $this->initRequirementsOs( ) )
    {
      return false;
    }

    if( ! $this->initRequirementsAllowUrlFopen( ) )
    {
      return false;
    }

    return true;

  }

/**
 * initRequirementsAdminmail( ) :
 *
 * @return	boolean
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function initRequirementsAdminmail( )
  {
      // RETURN : email address is given
    if ( ! empty( $this->orgesab_orgesabAdminEmail ) )
    {
      return true;
    }
      // RETURN : email address is given

      // DRS
    if( $this->drsModeError )
    {
      $prompt = 'email address is missing for the Org +ESAB admin.';
      t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 3 );
    }
      // DRS

    return false;
  }

/**
 * initRequirementsAllowUrlFopen( ) :
 *
 * @return	boolean
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function initRequirementsAllowUrlFopen( )
  {
    $allow_url_fopen = ini_get( 'allow_url_fopen');

      // RETURN : true. allow_url_fopen is enabled
    if( $allow_url_fopen )
    {
      return true;
    }
      // RETURN : true. allow_url_fopen is enabled

      // DRS
    if( $this->drsModeError )
    {
      $prompt = 'PHP ini property allow_url_fopen is disabled.';
      t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 3 );
    }
      // DRS

      // Send e-mail to admin
    $subject  = 'Failed';
    $body     = 'Sorry, but PHP ini property allow_url_fopen is disabled.' . PHP_EOL
              . PHP_EOL
              . __CLASS__ . '::' .  __METHOD__ . ' (' . __LINE__ . ')'
              ;
    $this->drsMailToAdmin( $subject, $body );
      // Send e-mail to admin

    return false;
  }

/**
 * initRequirementsOs( ) :
 *
 * @return	boolean
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function initRequirementsOs( )
  {
    $os = false;

      // SWITCH : server OS
    switch( strtolower( PHP_OS ) )
    {
      case( 'linux' ):
          // Linux is proper: Follow the workflow
        $os = true;
        break;
      default:
          // OS isn't supported
        $os = false;
    }
      // SWITCH : server OS

      // RETURN : os is supported
    if( $os )
    {
      return true;
    }
      // RETURN : os is supported

      // DRS
    if( $this->drsModeError )
    {
      $prompt = 'Sorry, but the operating system "' . PHP_OS . '" isn\'t supported by TYPO3 Org +ESAB.';
      t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 3 );
    }
      // DRS

      // e-mail to admin
    $subject  = 'Failed';
    $body     = 'Sorry, but ' . PHP_OS . ' isn\'t supported.' . PHP_EOL
              . PHP_EOL
              . __CLASS__ . '::' .  __METHOD__ . ' (' . __LINE__ . ')'
              ;
    $this->drsMailToAdmin( $subject, $body );
      // e-mail to admin

    return $os;
  }

  /**
 * initTimetracking( ) :
 *
 * @return	boolean
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function initRegistryInstance( )
  {
    $this->registry = t3lib_div::makeInstance('t3lib_Registry');
  }

  /**
 * initTimetracking( ) :
 *
 * @return	boolean
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function initTimetracking( )
  {
    $this->timeTracking_init( );
    $debugTrailLevel = 1;
    $this->timeTracking_log( $debugTrailLevel, 'START' );
  }



  /***********************************************
   *
   * Registry
   *
   **********************************************/

/**
 * registryGet( ):
 *
 * @param	[type]		$$key: ...
 * @return	void
 * @access public
 * @version       0.0.1
 * @since         0.0.1
 */
  public function registryGet( $key )
  {
      // RETURN null  : key is unproper
    if( ! $this->registryKey( $key ) )
    {
      return null;
    }
      // RETURN null  : key is unproper

      // Get value from registry
    $namespace = 'tx_' . $this->extKey;
    $value = $this->registry->get( $namespace, $key );

    return $value;
  }

/**
 * registryKey( ):
 *
 * @param	[type]		$$key: ...
 * @return	void
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function registryKey( $key )
  {
    switch( $key )
    {
      case( 'md5LastContent' ):
        return true;
        break;
      default:
          // Follow the workflow
        break;

    }

      // DRS
    if( $this->drsModeError )
    {
      $prompt = 'Key for registry is undefined. Key is ' . $key;
      t3lib_div::devLog( '[tx_orgesab_ImportTask]: ' . $prompt, $this->extKey, 3 );
    }
      // DRS

      // Send e-mail to admin
    $subject  = 'Failed';
    $body     = 'Sorry, but key for registry is undefined. Key is ' . $key . PHP_EOL
              . PHP_EOL
              . __CLASS__ . '::' .  __METHOD__ . ' (' . __LINE__ . ')'
              ;
    $this->drsMailToAdmin( $subject, $body );
      // Send e-mail to admin

    return false;
  }

/**
 * registrySet( ):
 *
 * @param	[type]		$$key: ...
 * @param	[type]		$value: ...
 * @return	void
 * @access public
 * @version       0.0.1
 * @since         0.0.1
 */
  public function registrySet( $key, $value )
  {
      // RETURN null  : key is unproper
    if( ! $this->registryKey( $key ) )
    {
      return null;
    }
      // RETURN null  : key is unproper

    if( empty( $value ) )
    {
      // Do nothing
    }

      // Update registry
    $namespace = 'tx_' . $this->extKey;
    $this->registry->set( $namespace, $key, $value );
  }



  /***********************************************
   *
   * Set public
   *
   **********************************************/

/**
 * setAdminmail( ):
 *
 * @return	void
 * @access public
 * @version       0.0.1
 * @since         0.0.1
 */
  public function setAdminmail( $value )
  {
    $this->orgesab_orgesabAdminEmail = $value;
  }

/**
 * setImportMode( ):
 *
 * @return	void
 * @access public
 * @version       0.0.1
 * @since         0.0.1
 */
  public function setImportMode( $value )
  {
    $this->orgesab_importMode = $value;
  }

/**
 * setImportUrl( ):
 *
 * @return	void
 * @access public
 * @version       0.0.1
 * @since         0.0.1
 */
  public function setImportUrl( $value )
  {
    $this->orgesab_importUrl = $value;
  }

/**
 * setReportMode( ):
 *
 * @return	void
 * @access public
 * @version       0.0.1
 * @since         0.0.1
 */
  public function setReportMode( $value )
  {
    $this->orgesab_reportMode = $value;
  }

/**
 * setSysfolderUid( ):
 *
 * @return	void
 * @access public
 * @version       0.0.1
 * @since         0.0.1
 */
  public function setSysfolderUid( $value )
  {
    $this->orgesab_sysfolderUid = $value;
  }




  /***********************************************
   *
   * Time tracking
   *
   **********************************************/

  /**
 * timeTracking_init( ):  Init the timetracking object. Set the global $startTime.
 *
 * @return	void
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function timeTracking_init( )
  {
      // Init the timetracking object
    require_once( PATH_t3lib . 'class.t3lib_timetrack.php' );
    $this->TT = new t3lib_timeTrack;
    $this->TT->start( );
      // Init the timetracking object

      // Set the global $startTime.
    $this->tt_startTime = $this->TT->getDifferenceToStarttime();
  }

  /**
 * timeTracking_log( ): Prompts a message in devLog with current run time in miliseconds
 *
 * @param	integer		$debugTrailLevel  : level for the debug trail
 * @param	string		$line             : current line in calling method
 * @param	string		$prompt           : The prompt for devlog.
 * @return	void
 * @version       0.0.1
 * @since         0.0.1
 */
  private function timeTracking_log( $debugTrailLevel, $prompt )
  {
      // RETURN: DRS shouldn't report performance prompts
    if( ! $this->drsModePerformance )
    {
      return;
    }
      // RETURN: DRS shouldn't report performance prompts

      // Get the current time
    $endTime = $this->TT->getDifferenceToStarttime( );

    $debugTrail = $this->drsDebugTrail( $debugTrailLevel );

    // Prompt the current time
    $mSec   = sprintf("%05d", ( $endTime - $this->tt_startTime ) );
    $prompt = $mSec . ' ms ### ' .
              $debugTrail['prompt'] . ': ' . $prompt;
    t3lib_div::devLog( $prompt, $this->extKey, 0 );

    $timeOfPrevProcess = $endTime - $this->tt_prevEndTime;

    switch( true )
    {
      case( $timeOfPrevProcess >= 10000 ):
        $this->tt_prevPrompt = 3;
        $prompt = 'Previous process needs more than 10 sec (' . $timeOfPrevProcess / 1000 . ' sec)';
        t3lib_div::devLog('[WARN/PERFORMANCE] ' . $prompt, $this->extKey, 3 );
        break;
      case( $timeOfPrevProcess >= 250 ):
        $this->tt_prevPrompt = 2;
        $prompt = 'Previous process needs more than 0.25 sec (' . $timeOfPrevProcess / 1000 . ' sec)';
        t3lib_div::devLog('[WARN/PERFORMANCE] ' . $prompt, $this->extKey, 2 );
        break;
      default:
        $this->tt_prevPrompt = 0;
        // Do nothing
    }
    $this->tt_prevEndTime = $endTime;
  }

  /**
 * timeTracking_prompt( ):  Method checks, wether previous prompt was a
 *                          warning or an error. If yes the given prompt will loged by devLog
 *
 * @param	integer		$debugTrailLevel  : level for the debug trail
 * @param	string		$prompt: The prompt for devlog.
 * @return	void
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function timeTracking_prompt( $debugTrailLevel, $prompt )
  {
    $debugTrail = $this->drsDebugTrail( $debugTrailLevel );

    switch( true )
    {
      case( $this->tt_prevPrompt == 3 ):
        $prompt_02 = 'ERROR';
        break;
      case( $this->tt_prevPrompt == 2 ):
        $prompt_02 = 'WARN';
        break;
      default:
          // Do nothing
        return;
    }

    $prompt = 'Details about previous process: ' . $prompt . ' (' . $debugTrail['prompt'] . ')';
    t3lib_div::devLog('[INFO/PERFORMANCE] ' . $prompt, $this->extKey, $this->tt_prevPrompt );
  }



  /***********************************************
   *
   * Update
   *
   **********************************************/

/**
 * updateDatabase( )  :
 *
 * @return	boolean
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function updateDatabase( )
  {
    $success = false;

    $this->updateDatabaseInstance( );
    $success = $this->update->main( );

    $success = true;
    $this->updateDatabaseDrsMail( $success );

    return $success;
  }

/**
 * updateDatabaseDrsMail( )  :
 *
 * @param	[type]		$$success: ...
 * @return	void
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function updateDatabaseDrsMail( $success )
  {
    switch( $success )
    {
      case( false ):
        $subject  = 'Failed';
        break;
      case( true ):
      default:
        $subject  = 'Success';
        break;
    }
    $body     = __CLASS__ . '::' .  __METHOD__ . ' (' . __LINE__ . ')';
    $this->drsMailToAdmin( $subject, $body );
  }

/**
 * updateDatabaseInstance( )  :
 *
 * @return	boolean
 * @access private
 * @version       0.0.1
 * @since         0.0.1
 */
  private function updateDatabaseInstance( )
  {
    $path2lib = t3lib_extMgm::extPath( $this->extKey ) . 'lib/';

    require_once( $path2lib . 'class.tx_orgesab_update.php' );

    $this->update = t3lib_div::makeInstance( 'tx_orgesab_update' );
    $this->update->setPobj( $this );
  }

}

if (defined('TYPO3_MODE') && isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/orgesab/lib/scheduler/class.tx_orgesab_importtask.php'])) {
  include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/orgesab/lib/scheduler/class.tx_orgesab_importtask.php']);
}

?>