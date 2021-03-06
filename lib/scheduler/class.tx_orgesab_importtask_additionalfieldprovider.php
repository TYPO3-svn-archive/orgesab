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
 *   73: class tx_orgesab_ImportTask_AdditionalFieldProvider implements tx_scheduler_AdditionalFieldProvider
 *
 *              SECTION: Bulding the form
 *  106:     public function getAdditionalFields( array &$taskInfo, $task, tx_scheduler_Module $parentObject )
 *  137:     private function getFieldImportMode( array &$taskInfo, $task, $parentObject )
 *  210:     private function getFieldImportUrl( array &$taskInfo, $task, $parentObject )
 *  268:     private function getFieldOrgesabAdminEmail( array &$taskInfo, $task, $parentObject )
 *  326:     private function getFieldReportMode( array &$taskInfo, $task, $parentObject )
 *  402:     private function getFieldSysfolderUid( array &$taskInfo, $task, $parentObject )
 *
 *              SECTION: Saving
 *  460:     public function saveAdditionalFields( array $submittedData, tx_scheduler_Task $task )
 *  479:     private function saveFieldImportMode( array $submittedData, tx_scheduler_Task $task )
 *  495:     private function saveFieldImportUrl( array $submittedData, tx_scheduler_Task $task )
 *  511:     private function saveFieldOrgesabAdminEmail( array $submittedData, tx_scheduler_Task $task )
 *  526:     private function saveFieldReportMode( array $submittedData, tx_scheduler_Task $task )
 *  542:     private function saveFieldSysfolderUid( array $submittedData, tx_scheduler_Task $task )
 *
 *              SECTION: Validating
 *  565:     public function validateAdditionalFields( array &$submittedData, tx_scheduler_Module $parentObject )
 *  626:     private function validateFieldFrequency( array &$submittedData, tx_scheduler_Module $parentObject )
 *  651:     private function validateFieldImportMode( array &$submittedData, tx_scheduler_Module $parentObject )
 *  691:     private function validateFieldImportUrl( array &$submittedData, tx_scheduler_Module $parentObject )
 *  721:     private function validateFieldOrgesabAdminEmail( array &$submittedData, tx_scheduler_Module $parentObject )
 *  747:     public function validateOS( tx_scheduler_Module $parentObject )
 *  778:     private function validateFieldReportMode( array &$submittedData, tx_scheduler_Module $parentObject )
 *  822:     private function validateFieldStart( array &$submittedData, tx_scheduler_Module $parentObject )
 *  853:     private function validateFieldSysfolderUid( array &$submittedData, tx_scheduler_Module $parentObject )
 *
 * TOTAL FUNCTIONS: 21
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

  public $msgPrefix = 'Org +ESAB Import';

  private $defaultImportUrl = 'http://my-domain.com/my.xml';



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
                      + $this->getFieldSysfolderUid( $taskInfo, $task, $parentObject )
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
          // In case of new task and if field is empty, set to
        $taskInfo['orgesab_importMode'] = 'update';
      }
      elseif( $parentObject->CMD == 'edit' )
      {
          // In case of edit, and editing a test task, set to internal value if not data was submitted already
        $taskInfo['orgesab_importMode'] = $task->getImportMode( );
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
    $labelUpdate  = $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.importMode.update' );
    $labelEver    = $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.importMode.ever' );
    $labelNever   = $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.importMode.never' );
    $selected               = array( );
    $selected['ever']       = null;
    $selected['never']      = null;
    $selected['update']     = null;
    $selected[$fieldValue]  = ' selected="selected"';

    $fieldCode    = '
                      <select name="tx_scheduler[orgesab_importMode]" id="' . $fieldID . '" size="1" style="width:300px;">
                        <option value="update"' . $selected['import'] . '>' . $labelUpdate  . '</option>
                        <option value="ever"'   . $selected['ever']   . '>' . $labelEver    . '</option>
                        <option value="never"'  . $selected['never']  . '>' . $labelNever   . '</option>
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
          // In case of new task and if field is empty, set to ..
        $taskInfo['orgesab_importUrl'] = $this->defaultImportUrl;
      }
      elseif( $parentObject->CMD == 'edit' )
      {
          // In case of edit, and editing a test task, set to internal value if not data was submitted already
        $taskInfo['orgesab_importUrl'] = $task->getImportUrl( );
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
    $fieldCode  = '<input type="text" name="tx_scheduler[orgesab_importUrl]" id="' . $fieldID . '" value="' . $fieldValue . '" size="80" maxlength="255"/>';
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
        $taskInfo['orgesab_orgesabAdminEmail'] = $task->getAdminmail( );
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
        $taskInfo['orgesab_reportMode'] = 'update';
      }
      elseif( $parentObject->CMD == 'edit' )
      {
          // In case of edit, and editing a test task, set to internal value if not data was submitted already
        $taskInfo['orgesab_reportMode'] = $task->getReportMode( );
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
    $labelEver    = $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.reportMode.ever' );
    $labelNever   = $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.reportMode.never' );
    $labelUpdate  = $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.reportMode.update' );
    $labelWarn    = $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.reportMode.warn' );
    $selected               = array( );
    $selected['ever']       = null;
    $selected['never']      = null;
    $selected['update']     = null;
    $selected['warn']       = null;
    $selected[$fieldValue]  = ' selected="selected"';

    $fieldCode    = '
                      <select name="tx_scheduler[orgesab_reportMode]" id="' . $fieldID . '" size="1" style="width:300px;">
                        <option value="update"' . $selected['update'] . '>' . $labelUpdate  . '</option>
                        <option value="ever"'   . $selected['ever']   . '>' . $labelEver    . '</option>
                        <option value="never"'  . $selected['never']  . '>' . $labelNever   . '</option>
                        <option value="warn"'   . $selected['warn']   . '>' . $labelWarn    . '</option>
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

  /**
 * getFieldSysfolderUid( )  : This method is used to define new fields for adding or editing a task
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
  private function getFieldSysfolderUid( array &$taskInfo, $task, $parentObject )
  {
      // IF : field is empty, initialize extra field value
    if( empty( $taskInfo['orgesab_sysfolderUid'] ) )
    {
      if( $parentObject->CMD == 'add' )
      {
          // In case of new task and if field is empty, set it to ...
        $taskInfo['orgesab_sysfolderUid'] = null;
      }
      elseif( $parentObject->CMD == 'edit' )
      {
          // In case of edit, and editing a test task, set to internal value if not data was submitted already
        $taskInfo['orgesab_sysfolderUid'] = $task->getSysfolderUid( );
      }
      else
      {
          // Otherwise set an empty value, as it will not be used anyway
        $taskInfo['orgesab_sysfolderUid'] = null;
      }
    }
      // IF : field is empty, initialize extra field value

      // Write the code for the field
    $fieldID    = 'orgesab_sysfolderUid';
    $fieldValue = htmlspecialchars( $taskInfo['orgesab_sysfolderUid'] );
    $fieldCode  = '<input type="text" name="tx_scheduler[orgesab_sysfolderUid]" id="' . $fieldID . '" value="' . $fieldValue . '" size="5" />';
    $additionalFields = array( );
    $additionalFields[$fieldID] = array
    (
      'code'     => $fieldCode,
      'label'    => 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.sysfolderUid',
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
    $this->saveFieldImportMode( $submittedData, $task );
    $this->saveFieldImportUrl( $submittedData, $task );
    $this->saveFieldOrgesabAdminEmail( $submittedData, $task );
    $this->saveFieldReportMode( $submittedData, $task );
    $this->saveFieldSysfolderUid( $submittedData, $task );
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
//    $task->orgesab_reportMode = $submittedData['orgesab_importMode'];
    $task->setImportMode( $submittedData['orgesab_importMode'] );
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
    //$task->orgesab_importUrl = $submittedData['orgesab_importUrl'];
    $task->setImportUrl( $submittedData['orgesab_importUrl'] );
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
    $task->setAdminmail( $submittedData['orgesab_orgesabAdminEmail'] );
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
//    $task->orgesab_reportMode = $submittedData['orgesab_reportMode'];
    $task->setReportMode( $submittedData['orgesab_reportMode'] );
  }

  /**
 * saveFieldSysfolderUid( ) : This method is used to save any additional input into the current task object
 *                           if the task class matches
 *
 * @param	array		$submittedData Array containing the data submitted by the user
 * @param	tx_scheduler_Task		$task Reference to the current task object
 * @return	void
 * @version       0.0.1
 * @since         0.0.1
 */
  private function saveFieldSysfolderUid( array $submittedData, tx_scheduler_Task $task )
  {
    $task->setSysfolderUid( $submittedData['orgesab_sysfolderUid'] );
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

    if( ! $this->validateFieldSysfolderUid( $submittedData, $parentObject ) )
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

    if( $submittedData['frequency'] > ( 60 * 60 * 24 )  )
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
      case( 'ever' ):
        $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.importMode.ever' );;
        $parentObject->addMessage( $prompt, t3lib_FlashMessage::INFO );
        break;
      case( 'never' ):
        $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.importMode.never' );;
        $parentObject->addMessage( $prompt, t3lib_FlashMessage::WARNING );
        break;
      case( 'update' ):
        $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.importMode.update' );;
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

    switch( true )
    {
      case( empty( $submittedData['orgesab_importUrl'] ) ):
      case( $submittedData['orgesab_importUrl'] == $this->defaultImportUrl ):
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
      // #i0006, 130413, dwildt, 1+
    return $bool_isValidatingSuccessful;

      // #i0006, 130413, dwildt, -
//      // SWITCH : OS of the server
//    switch( strtolower( PHP_OS ) )
//    {
//      case( 'linux' ):
//          // Linux is proper: Follow the workflow
//        break;
//      default:
//        $bool_isValidatingSuccessful = false;
//        $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.osIsNotSupported' );
//        $prompt = str_replace( '###PHP_OS###', PHP_OS, $prompt );
//        $parentObject->addMessage( $prompt, t3lib_FlashMessage::ERROR );
//    }
//      // SWITCH : OS of the server
//
//    return $bool_isValidatingSuccessful;
      // #i0006, 130413, dwildt, -
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
      case( 'ever' ):
        $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.reportMode.ever' );;
        $parentObject->addMessage( $prompt, t3lib_FlashMessage::INFO );
        break;
      case( 'never' ):
        $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.reportMode.never' );;
        $parentObject->addMessage( $prompt, t3lib_FlashMessage::WARNING );
        break;
      case( 'update' ):
        $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.reportMode.update' );;
        $parentObject->addMessage( $prompt, t3lib_FlashMessage::INFO );
        break;
      case( 'warn' ):
        $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.reportMode.warn' );;
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
      $prompt = $this->msgPrefix
              . ': '
              . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.enterStart' )
              ;
      $parentObject->addMessage( $prompt, t3lib_FlashMessage::ERROR );
      $bool_isValidatingSuccessful = false;
    }

    return $bool_isValidatingSuccessful;
  }

  /**
 * validateFieldSysfolderUid( )  : This method checks any additional data that is relevant to the specific task
 *                                     If the task class is not relevant, the method is expected to return TRUE
 *
 * @param	array		$submittedData Reference to the array containing the data submitted by the user
 * @param	tx_scheduler_Module		$parentObject Reference to the calling object (Scheduler's BE module)
 * @return	boolean		TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
 * @version       0.0.1
 * @since         0.0.1
 */
  private function validateFieldSysfolderUid( array &$submittedData, tx_scheduler_Module $parentObject )
  {
    $bool_isValidatingSuccessful = true;

    $submittedData['orgesab_sysfolderUid'] = ( int ) $submittedData['orgesab_sysfolderUid'];

    if( $submittedData['orgesab_sysfolderUid'] < 1 )
    {
      $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.enterSysfolderUid' );
      $parentObject->addMessage( $prompt, t3lib_FlashMessage::ERROR );
      $bool_isValidatingSuccessful = false;
    }

    return $bool_isValidatingSuccessful;
  }


}

if (defined('TYPO3_MODE') && isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/orgesab/lib/scheduler/class.tx_orgesab_importtask_additionalfieldprovider.php'])) {
  include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/orgesab/lib/scheduler/class.tx_orgesab_importtask_additionalfieldprovider.php']);
}

?>