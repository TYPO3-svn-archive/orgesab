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
 *   70: class tx_orgesab_ImportTask_AdditionalFieldProvider implements tx_scheduler_AdditionalFieldProvider
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
 * Aditional fields provider class for usage with the orgesab import task
 *
 * @author        Dirk Wildt (http://wildt.at.die-netzmacher.de/)
 * @package        TYPO3
 * @subpackage    orgesab
 * @version       0.0.1
 * @since         0.0.1
 */
class tx_orgesab_ImportTask_AdditionalFieldProvider implements tx_scheduler_AdditionalFieldProvider
{

  var $msgPrefix = 'Org +ESAB Import';



  /***********************************************
  *
  * Bulding the form
  *
  **********************************************/

  /**
 * getAdditionalFields( )  : This method is used to define new fields for adding or editing a task
 *                           In this case, it adds an email field
 *
 *                    The array is multidimensional, keyed to the task class name and each field's id
 *                    For each field it provides an associative sub-array with the following:
 *                        ['code']        => The HTML code for the field
 *                        ['label']        => The label of the field (possibly localized)
 *                        ['cshKey']        => The CSH key for the field
 *                        ['cshLabel']    => The code of the CSH label
 *
 * @param	array		$taskInfo Reference to the array containing the info used in the add/edit form
 * @param	object		$task When editing, reference to the current task object. Null when adding.
 * @param	tx_scheduler_Module		$parentObject Reference to the calling object (Scheduler's BE module)
 * @return	array		Array containing all the information pertaining to the additional fields
 * @version       0.0.1
 * @since         0.0.1
 */
  public function getAdditionalFields( array &$taskInfo, $task, tx_scheduler_Module $parentObject )
  {
    $additionalFields = array( )
                      + $this->getFieldOrgesabAdminEmail( $taskInfo, $task, $parentObject )
                      + $this->getFieldReportMode( $taskInfo, $task, $parentObject )
                      + $this->getFieldImportUrl( $taskInfo, $task, $parentObject )
                      + $this->getFieldImportMode( $taskInfo, $task, $parentObject )
                      ;

    return $additionalFields;
  }

  /**
 * getFieldImportMode( )  : This method is used to define new fields for adding or editing a task
 *                                           In this case, it adds an email field
 *
 *                    The array is multidimensional, keyed to the task class name and each field's id
 *                    For each field it provides an associative sub-array with the following:
 *                        ['code']        => The HTML code for the field
 *                        ['label']        => The label of the field (possibly localized)
 *                        ['cshKey']        => The CSH key for the field
 *                        ['cshLabel']    => The code of the CSH label
 *
 * @param	array		$taskInfo Reference to the array containing the info used in the add/edit form
 * @param	object		$task When editing, reference to the current task object. Null when adding.
 * @param	tx_scheduler_Module		$parentObject Reference to the calling object (Scheduler's BE module)
 * @return	array		Array containing all the information pertaining to the additional fields
 * @version       0.0.1
 * @since         0.0.1
 */
  private function getFieldImportMode( array &$taskInfo, $task, $parentObject )
  {
      // IF : field is empty, initialize extra field value
    if( empty( $taskInfo['orgesab_importMode'] ) )
    {
      if( $parentObject->CMD == 'add' )
      {
          // In case of new task and if field is empty, set default email address
        $taskInfo['orgesab_importMode'] = 'test';
      }
      elseif( $parentObject->CMD == 'edit' )
      {
          // In case of edit, and editing a test task, set to internal value if not data was submitted already
        $taskInfo['orgesab_importMode'] = $task->orgesab_importMode;
      }
      else
      {
          // Otherwise set an empty value, as it will not be used anyway
        $taskInfo['orgesab_importMode'] = '';
      }
    }
      // IF : field is empty, initialize extra field value

      // Write the code for the field
    $fieldID      = 'orgesab_importMode';
    $fieldValue   = $taskInfo['orgesab_importMode'];
    $labelRemove  = $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.importMode.remove' );
    $labelWarn    = $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.importMode.warn' );
    $labelTest    = $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.importMode.test' );
    $selected               = array( );
    $selected['remove']     = null;
    $selected['test']       = null;
    $selected['warn']       = null;
    $selected[$fieldValue]  = ' selected="selected"';

    $fieldCode    = '
                      <select name="tx_scheduler[orgesab_importMode]" id="' . $fieldID . '" size="1" style="width:300px;">
                        <option value="remove"' . $selected['remove'] . '>' . $labelRemove . '</option>
                        <option value="warn"' . $selected['warn'] . '>' . $labelWarn . '</option>
                        <option value="test"' . $selected['test'] . '>' . $labelTest . '</option>
                      </select>
                    ';
    $additionalFields = array( );
    $additionalFields[$fieldID] = array
    (
      'code'     => $fieldCode,
      'label'    => 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.importMode',
      'cshKey'   => '_MOD_tools_txschedulerM1',
      'cshLabel' => $fieldID
    );
      // Write the code for the field

    return $additionalFields;
  }

  /**
 * getFieldImportUrl( )  : This method is used to define new fields for adding or editing a task
 *                                           In this case, it adds an email field
 *
 *                    The array is multidimensional, keyed to the task class name and each field's id
 *                    For each field it provides an associative sub-array with the following:
 *                        ['code']        => The HTML code for the field
 *                        ['label']        => The label of the field (possibly localized)
 *                        ['cshKey']        => The CSH key for the field
 *                        ['cshLabel']    => The code of the CSH label
 *
 * @param	array		$taskInfo Reference to the array containing the info used in the add/edit form
 * @param	object		$task When editing, reference to the current task object. Null when adding.
 * @param	tx_scheduler_Module		$parentObject Reference to the calling object (Scheduler's BE module)
 * @return	array		Array containing all the information pertaining to the additional fields
 * @version       0.0.1
 * @since         0.0.1
 */
  private function getFieldImportUrl( array &$taskInfo, $task, $parentObject )
  {
      // IF : field is empty, initialize extra field value
    if( empty( $taskInfo['orgesab_importUrl'] ) )
    {
      if( $parentObject->CMD == 'add' )
      {
          // In case of new task and if field is empty, set default email address
        $taskInfo['orgesab_importUrl'] = '100';
      }
      elseif( $parentObject->CMD == 'edit' )
      {
          // In case of edit, and editing a test task, set to internal value if not data was submitted already
        $taskInfo['orgesab_importUrl'] = $task->orgesab_importUrl;
      }
      else
      {
          // Otherwise set an empty value, as it will not be used anyway
        $taskInfo['orgesab_importUrl'] = '';
      }
    }
      // IF : field is empty, initialize extra field value

      // Write the code for the field
    $fieldID    = 'orgesab_importUrl';
    $fieldValue = htmlspecialchars( $taskInfo['orgesab_importUrl'] );
    $fieldCode  = '<input type="text" name="tx_scheduler[orgesab_importUrl]" id="' . $fieldID . '" value="' . $fieldValue . '" size="5" maxlength="5"/>';
    $additionalFields = array( );
    $additionalFields[$fieldID] = array
    (
      'code'     => $fieldCode,
      'label'    => 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.importUrl',
      'cshKey'   => '_MOD_tools_txschedulerM1',
      'cshLabel' => $fieldID
    );
      // Write the code for the field

    return $additionalFields;
  }

  /**
 * getFieldOrgesabAdminEmail( )  : This method is used to define new fields for adding or editing a task
 *                                           In this case, it adds an email field
 *
 *                    The array is multidimensional, keyed to the task class name and each field's id
 *                    For each field it provides an associative sub-array with the following:
 *                        ['code']        => The HTML code for the field
 *                        ['label']        => The label of the field (possibly localized)
 *                        ['cshKey']        => The CSH key for the field
 *                        ['cshLabel']    => The code of the CSH label
 *
 * @param	array		$taskInfo Reference to the array containing the info used in the add/edit form
 * @param	object		$task When editing, reference to the current task object. Null when adding.
 * @param	tx_scheduler_Module		$parentObject Reference to the calling object (Scheduler's BE module)
 * @return	array		Array containing all the information pertaining to the additional fields
 * @version       0.0.1
 * @since         0.0.1
 */
  private function getFieldOrgesabAdminEmail( array &$taskInfo, $task, $parentObject )
  {
      // IF : field is empty, initialize extra field value
    if( empty( $taskInfo['orgesab_orgesabAdminEmail'] ) )
    {
      if( $parentObject->CMD == 'add' )
      {
          // In case of new task and if field is empty, set default email address
        $taskInfo['orgesab_orgesabAdminEmail'] = $GLOBALS['BE_USER']->user['email'];
      }
      elseif( $parentObject->CMD == 'edit' )
      {
          // In case of edit, and editing a test task, set to internal value if not data was submitted already
        $taskInfo['orgesab_orgesabAdminEmail'] = $task->orgesab_orgesabAdminEmail;
      }
      else
      {
          // Otherwise set an empty value, as it will not be used anyway
        $taskInfo['orgesab_orgesabAdminEmail'] = '';
      }
    }
      // IF : field is empty, initialize extra field value

      // Write the code for the field
    $fieldID    = 'orgesab_orgesabAdminEmail';
    $fieldValue = htmlspecialchars( $taskInfo['orgesab_orgesabAdminEmail'] );
    $fieldCode  = '<input type="text" name="tx_scheduler[orgesab_orgesabAdminEmail]" id="' . $fieldID . '" value="' . $fieldValue . '" size="50" />';
    $additionalFields = array( );
    $additionalFields[$fieldID] = array
    (
      'code'     => $fieldCode,
      'label'    => 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.orgesabAdminEmail',
      'cshKey'   => '_MOD_tools_txschedulerM1',
      'cshLabel' => $fieldID
    );
      // Write the code for the field

    return $additionalFields;
  }

  /**
 * getFieldReportMode( )  : This method is used to define new fields for adding or editing a task
 *                                           In this case, it adds an email field
 *
 *                    The array is multidimensional, keyed to the task class name and each field's id
 *                    For each field it provides an associative sub-array with the following:
 *                        ['code']        => The HTML code for the field
 *                        ['label']        => The label of the field (possibly localized)
 *                        ['cshKey']        => The CSH key for the field
 *                        ['cshLabel']    => The code of the CSH label
 *
 * @param	array		$taskInfo Reference to the array containing the info used in the add/edit form
 * @param	object		$task When editing, reference to the current task object. Null when adding.
 * @param	tx_scheduler_Module		$parentObject Reference to the calling object (Scheduler's BE module)
 * @return	array		Array containing all the information pertaining to the additional fields
 * @version       0.0.1
 * @since         0.0.1
 */
  private function getFieldReportMode( array &$taskInfo, $task, $parentObject )
  {
      // IF : field is empty, initialize extra field value
    if( empty( $taskInfo['orgesab_reportMode'] ) )
    {
      if( $parentObject->CMD == 'add' )
      {
          // In case of new task and if field is empty, set default email address
        $taskInfo['orgesab_reportMode'] = 'test';
      }
      elseif( $parentObject->CMD == 'edit' )
      {
          // In case of edit, and editing a test task, set to internal value if not data was submitted already
        $taskInfo['orgesab_reportMode'] = $task->orgesab_reportMode;
      }
      else
      {
          // Otherwise set an empty value, as it will not be used anyway
        $taskInfo['orgesab_reportMode'] = '';
      }
    }
      // IF : field is empty, initialize extra field value

      // Write the code for the field
    $fieldID      = 'orgesab_reportMode';
    $fieldValue   = $taskInfo['orgesab_reportMode'];
    $labelRemove  = $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.reportMode.remove' );
    $labelWarn    = $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.reportMode.warn' );
    $labelTest    = $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.reportMode.test' );
    $selected               = array( );
    $selected['remove']     = null;
    $selected['test']       = null;
    $selected['warn']       = null;
    $selected[$fieldValue]  = ' selected="selected"';

    $fieldCode    = '
                      <select name="tx_scheduler[orgesab_reportMode]" id="' . $fieldID . '" size="1" style="width:300px;">
                        <option value="remove"' . $selected['remove'] . '>' . $labelRemove . '</option>
                        <option value="warn"' . $selected['warn'] . '>' . $labelWarn . '</option>
                        <option value="test"' . $selected['test'] . '>' . $labelTest . '</option>
                      </select>
                    ';
    $additionalFields = array( );
    $additionalFields[$fieldID] = array
    (
      'code'     => $fieldCode,
      'label'    => 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.reportMode',
      'cshKey'   => '_MOD_tools_txschedulerM1',
      'cshLabel' => $fieldID
    );
      // Write the code for the field

    return $additionalFields;
  }



  /***********************************************
  *
  * Saving
  *
  **********************************************/

  /**
 * saveAdditionalFields( ) : This method is used to save any additional input into the current task object
 *                           if the task class matches
 *
 * @param	array		$submittedData Array containing the data submitted by the user
 * @param	tx_scheduler_Task		$task Reference to the current task object
 * @return	void
 * @version       0.0.1
 * @since         0.0.1
 */
  public function saveAdditionalFields( array $submittedData, tx_scheduler_Task $task )
  {
    $this->saveFieldOrgesabAdminEmail( $submittedData, $task );
    $this->saveFieldReportMode( $submittedData, $task );
    $this->saveFieldImportUrl( $submittedData, $task );
    $this->saveFieldImportMode( $submittedData, $task );
  }

  /**
 * saveFieldImportMode( ) : This method is used to save any additional input into the current task object
 *                           if the task class matches
 *
 * @param	array		$submittedData Array containing the data submitted by the user
 * @param	tx_scheduler_Task		$task Reference to the current task object
 * @return	void
 * @version       0.0.1
 * @since         0.0.1
 */
  private function saveFieldImportMode( array $submittedData, tx_scheduler_Task $task )
  {
    $task->orgesab_reportMode = $submittedData['orgesab_importMode'];
  }

  /**
 * saveFieldImportUrl( ) : This method is used to save any additional input into the current task object
 *                           if the task class matches
 *
 * @param	array		$submittedData Array containing the data submitted by the user
 * @param	tx_scheduler_Task		$task Reference to the current task object
 * @return	void
 * @version       0.0.1
 * @since         0.0.1
 */
  private function saveFieldImportUrl( array $submittedData, tx_scheduler_Task $task )
  {
    $orgesab_importUrl       = ( int ) $submittedData['orgesab_importUrl'];
    $task->orgesab_importUrl = $orgesab_importUrl;
  }

  /**
 * saveFieldOrgesabAdminEmail( ) : This method is used to save any additional input into the current task object
 *                           if the task class matches
 *
 * @param	array		$submittedData Array containing the data submitted by the user
 * @param	tx_scheduler_Task		$task Reference to the current task object
 * @return	void
 * @version       0.0.1
 * @since         0.0.1
 */
  private function saveFieldOrgesabAdminEmail( array $submittedData, tx_scheduler_Task $task )
  {
    $task->orgesab_orgesabAdminEmail = $submittedData['orgesab_orgesabAdminEmail'];
  }

  /**
 * saveFieldReportMode( ) : This method is used to save any additional input into the current task object
 *                           if the task class matches
 *
 * @param	array		$submittedData Array containing the data submitted by the user
 * @param	tx_scheduler_Task		$task Reference to the current task object
 * @return	void
 * @version       0.0.1
 * @since         0.0.1
 */
  private function saveFieldReportMode( array $submittedData, tx_scheduler_Task $task )
  {
    $task->orgesab_reportMode = $submittedData['orgesab_reportMode'];
  }



  /***********************************************
  *
  * Validating
  *
  **********************************************/

  /**
 * validateAdditionalFields( ) : This method checks any additional data that is relevant to the specific task
 *                               If the task class is not relevant, the method is expected to return TRUE
 *
 * @param	array		$submittedData Reference to the array containing the data submitted by the user
 * @param	tx_scheduler_Module		$parentObject Reference to the calling object (Scheduler's BE module)
 * @return	boolean		TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
 * @version       0.0.1
 * @since         0.0.1
 */
  public function validateAdditionalFields( array &$submittedData, tx_scheduler_Module $parentObject )
  {
    $bool_isValidatingSuccessful = true;

//    $prompt = var_export( $submittedData, true );
//    $parentObject->addMessage( $prompt, t3lib_FlashMessage::INFO );


    if( ! $this->validateOS( $parentObject ) )
    {
      return false;
    }

    if( ! $this->validateFieldFrequency( $submittedData, $parentObject ) )
    {
      $bool_isValidatingSuccessful = false;
    }

    if( ! $this->validateFieldImportMode( $submittedData, $parentObject ) )
    {
      $bool_isValidatingSuccessful = false;
    }

    if( ! $this->validateFieldImportUrl( $submittedData, $parentObject ) )
    {
      $bool_isValidatingSuccessful = false;
    }

    if( ! $this->validateFieldOrgesabAdminEmail( $submittedData, $parentObject ) )
    {
      $bool_isValidatingSuccessful = false;
    }

    if( ! $this->validateFieldReportMode( $submittedData, $parentObject ) )
    {
      $bool_isValidatingSuccessful = false;
    }

    if( ! $this->validateFieldStart( $submittedData, $parentObject ) )
    {
      $bool_isValidatingSuccessful = false;
    }

    return $bool_isValidatingSuccessful;
  }

  /**
 * validateFieldFrequency( )  : This method checks any additional data that is relevant to the specific task
 *                                     If the task class is not relevant, the method is expected to return TRUE
 *
 * @param	array		$submittedData Reference to the array containing the data submitted by the user
 * @param	tx_scheduler_Module		$parentObject Reference to the calling object (Scheduler's BE module)
 * @return	boolean		TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
 * @version       0.0.1
 * @since         0.0.1
 */
  private function validateFieldFrequency( array &$submittedData, tx_scheduler_Module $parentObject )
  {
    $bool_isValidatingSuccessful = true;

    $submittedData['frequency'] = ( int ) $submittedData['frequency'];

    if( $submittedData['frequency'] < 86400 )
    {
      $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.enterFrequency' );
      $parentObject->addMessage( $prompt, t3lib_FlashMessage::WARNING );
    }

    return $bool_isValidatingSuccessful;
  }

  /**
 * validateFieldImportMode( )  : This method checks any additional data that is relevant to the specific task
 *                                     If the task class is not relevant, the method is expected to return TRUE
 *
 * @param	array		$submittedData Reference to the array containing the data submitted by the user
 * @param	tx_scheduler_Module		$parentObject Reference to the calling object (Scheduler's BE module)
 * @return	boolean		TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
 * @version       0.0.1
 * @since         0.0.1
 */
  private function validateFieldImportMode( array &$submittedData, tx_scheduler_Module $parentObject )
  {
    $bool_isValidatingSuccessful = true;

      // Messages depending on mode
    switch( $submittedData['orgesab_importMode'] )
    {
      case( 'remove' ):
        $prompt = $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.importMode.remove' );;
        $parentObject->addMessage( $prompt, t3lib_FlashMessage::WARNING );
        break;
      case( 'test' ):
        $prompt = $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.importMode.test' );;
        $parentObject->addMessage( $prompt, t3lib_FlashMessage::INFO );
        break;
      case( 'warn' ):
        $prompt = $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.importMode.warn' );;
        $parentObject->addMessage( $prompt, t3lib_FlashMessage::INFO );
        break;
      default:
        $bool_isValidatingSuccessful = false;
        $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.importMode.undefined' );;
        $parentObject->addMessage( $prompt, t3lib_FlashMessage::ERROR );
        break;
    }
      // Messages depending on mode

    return $bool_isValidatingSuccessful;
  }

  /**
 * validateFieldImportUrl( )  : This method checks any additional data that is relevant to the specific task
 *                                     If the task class is not relevant, the method is expected to return TRUE
 *
 * @param	array		$submittedData Reference to the array containing the data submitted by the user
 * @param	tx_scheduler_Module		$parentObject Reference to the calling object (Scheduler's BE module)
 * @return	boolean		TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
 * @version       0.0.1
 * @since         0.0.1
 */
  private function validateFieldImportUrl( array &$submittedData, tx_scheduler_Module $parentObject )
  {
    $bool_isValidatingSuccessful = true;

    $submittedData['orgesab_importUrl'] = ( int ) $submittedData['orgesab_importUrl'];

    switch( true )
    {
      case( $submittedData['orgesab_importUrl'] < 50 ):
        $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.enterImportUrl' );
        $parentObject->addMessage( $prompt, t3lib_FlashMessage::ERROR );
        $bool_isValidatingSuccessful = false;
        break;
      default:
        $bool_isValidatingSuccessful = true;
        break;
    }

    return $bool_isValidatingSuccessful;
  }

  /**
 * validateFieldOrgesabAdminEmail( )  : This method checks any additional data that is relevant to the specific task
 *                                     If the task class is not relevant, the method is expected to return TRUE
 *
 * @param	array		$submittedData Reference to the array containing the data submitted by the user
 * @param	tx_scheduler_Module		$parentObject Reference to the calling object (Scheduler's BE module)
 * @return	boolean		TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
 * @version       0.0.1
 * @since         0.0.1
 */
  private function validateFieldOrgesabAdminEmail( array &$submittedData, tx_scheduler_Module $parentObject )
  {
    $bool_isValidatingSuccessful = true;

    $submittedData['orgesab_orgesabAdminEmail'] = trim( $submittedData['orgesab_orgesabAdminEmail'] );

    if( empty( $submittedData['orgesab_orgesabAdminEmail'] ) )
    {
      $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.enterOrgesabAdminEmail' );
      $parentObject->addMessage( $prompt, t3lib_FlashMessage::ERROR );
      $bool_isValidatingSuccessful = false;
    }

    return $bool_isValidatingSuccessful;
  }

  /**
 * validateFieldReportMode( )  : This method checks any additional data that is relevant to the specific task
 *                                     If the task class is not relevant, the method is expected to return TRUE
 *
 * @param	array		$submittedData Reference to the array containing the data submitted by the user
 * @param	tx_scheduler_Module		$parentObject Reference to the calling object (Scheduler's BE module)
 * @return	boolean		TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
 * @version       0.0.1
 * @since         0.0.1
 */
  private function validateFieldReportMode( array &$submittedData, tx_scheduler_Module $parentObject )
  {
    $bool_isValidatingSuccessful = true;

      // Messages depending on mode
    switch( $submittedData['orgesab_reportMode'] )
    {
      case( 'remove' ):
        $prompt = $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.reportMode.remove' );;
        $parentObject->addMessage( $prompt, t3lib_FlashMessage::WARNING );
        break;
      case( 'test' ):
        $prompt = $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.reportMode.test' );;
        $parentObject->addMessage( $prompt, t3lib_FlashMessage::INFO );
        break;
      case( 'warn' ):
        $prompt = $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.reportMode.warn' );;
        $parentObject->addMessage( $prompt, t3lib_FlashMessage::INFO );
        break;
      default:
        $bool_isValidatingSuccessful = false;
        $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.reportMode.undefined' );;
        $parentObject->addMessage( $prompt, t3lib_FlashMessage::ERROR );
        break;
    }
      // Messages depending on mode

    return $bool_isValidatingSuccessful;
  }

  /**
 * validateFieldStart( )  : This method checks any additional data that is relevant to the specific task
 *                                     If the task class is not relevant, the method is expected to return TRUE
 *
 * @param	array		$submittedData Reference to the array containing the data submitted by the user
 * @param	tx_scheduler_Module		$parentObject Reference to the calling object (Scheduler's BE module)
 * @return	boolean		TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
 * @version       0.0.1
 * @since         0.0.1
 */
  private function validateFieldStart( array &$submittedData, tx_scheduler_Module $parentObject )
  {
    $bool_isValidatingSuccessful = true;

    $submittedData['start'] = ( int ) $submittedData['start'];

    $inAnHour = time( ) + ( 60 * 60 );

    if( $submittedData['start'] < $inAnHour )
    {
      $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.enterStart' );
      $parentObject->addMessage( $prompt, t3lib_FlashMessage::ERROR );
      $bool_isValidatingSuccessful = false;
    }

    return $bool_isValidatingSuccessful;
  }

  /**
 * validateOS( ) : This method checks any additional data that is relevant to the specific task
 *                               If the task class is not relevant, the method is expected to return TRUE
 *
 * @param	array		$submittedData Reference to the array containing the data submitted by the user
 * @param	tx_scheduler_Module		$parentObject Reference to the calling object (Scheduler's BE module)
 * @return	boolean		TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
 * @version       0.0.1
 * @since         0.0.1
 */
  public function validateOS( tx_scheduler_Module $parentObject )
  {
    $bool_isValidatingSuccessful = true;

      // SWITCH : OS of the server
    switch( strtolower( PHP_OS ) )
    {
      case( 'linux' ):
          // Linux is proper: Follow the workflow
        break;
      default:
        $bool_isValidatingSuccessful = false;
        $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.osIsNotSupported' );
        $prompt = str_replace( '###PHP_OS###', PHP_OS, $prompt );
        $parentObject->addMessage( $prompt, t3lib_FlashMessage::ERROR );
    }
      // SWITCH : OS of the server

    return $bool_isValidatingSuccessful;
  }


}

if (defined('TYPO3_MODE') && isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/orgesab/lib/scheduler/class.tx_orgesab_importtask_additionalfieldprovider.php'])) {
  include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/orgesab/lib/scheduler/class.tx_orgesab_importtask_additionalfieldprovider.php']);
}

?>