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
 * Aditional fields provider class for usage with the orgesab quota task
 *
 * @author        Dirk Wildt (http://wildt.at.die-netzmacher.de/)
 * @package        TYPO3
 * @subpackage    orgesab
 * @version       0.0.1
 * @since         0.0.1
 */
class tx_orgesab_QuotaTask_AdditionalFieldProvider implements tx_scheduler_AdditionalFieldProvider
{

  var $msgPrefix = 'Org +ESAB Quota';

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
    $additionalFields = array( );
    $additionalFields = $additionalFields + $this->getFieldOrgesabAdminCompany( $taskInfo, $task, $parentObject );
    $additionalFields = $additionalFields + $this->getFieldOrgesabAdminEmail( $taskInfo, $task, $parentObject );
    $additionalFields = $additionalFields + $this->getFieldOrgesabAdminName( $taskInfo, $task, $parentObject );
    $additionalFields = $additionalFields + $this->getFieldOrgesabAdminPhone( $taskInfo, $task, $parentObject );
    $additionalFields = $additionalFields + $this->getFieldQuotaMode( $taskInfo, $task, $parentObject );
    $additionalFields = $additionalFields + $this->getFieldQuotaLimitDefault( $taskInfo, $task, $parentObject );
    $additionalFields = $additionalFields + $this->getFieldQuotaLimitRemove( $taskInfo, $task, $parentObject );
    $additionalFields = $additionalFields + $this->getFieldQuotaLimitWarn( $taskInfo, $task, $parentObject );
    $additionalFields = $additionalFields + $this->getFieldQuotaReduceMailbox( $taskInfo, $task, $parentObject );
//    quotaDefaultLimit

    return $additionalFields;
  }

  /**
 * getFieldQuotaReduceMailbox( )  : This method is used to define new fields for adding or editing a task
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
  private function getFieldQuotaReduceMailbox( array &$taskInfo, $task, $parentObject )
  {
      // IF : field is empty, initialize extra field value
    if( empty( $taskInfo['orgesab_quotaReduceMailbox'] ) )
    {
      if( $parentObject->CMD == 'add' )
      {
          // In case of new task and if field is empty, set default email address
        $taskInfo['orgesab_quotaReduceMailbox'] = '90';
      }
      elseif( $parentObject->CMD == 'edit' )
      {
          // In case of edit, and editing a test task, set to internal value if not data was submitted already
        $taskInfo['orgesab_quotaReduceMailbox'] = $task->orgesab_quotaReduceMailbox;
      }
      else
      {
          // Otherwise set an empty value, as it will not be used anyway
        $taskInfo['orgesab_quotaReduceMailbox'] = '';
      }
    }
      // IF : field is empty, initialize extra field value

      // Write the code for the field
    $fieldID    = 'orgesab_quotaReduceMailbox';
    $fieldValue = htmlspecialchars( $taskInfo['orgesab_quotaReduceMailbox'] );
    $fieldCode  = '<input type="text" name="tx_scheduler[orgesab_quotaReduceMailbox]" id="' . $fieldID . '" value="' . $fieldValue . '" size="3"  maxlength="3"/>';
    $additionalFields = array( );
    $additionalFields[$fieldID] = array
    (
      'code'     => $fieldCode,
      'label'    => 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.quotaReduceMailbox',
      'cshKey'   => '_MOD_tools_txschedulerM1',
      'cshLabel' => $fieldID
    );
      // Write the code for the field

    return $additionalFields;
  }


  /**
 * getFieldOrgesabAdminCompany( )  : This method is used to define new fields for adding or editing a task
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
  private function getFieldOrgesabAdminCompany( array &$taskInfo, $task, $parentObject )
  {
      // IF : field is empty, initialize extra field value
    if( empty( $taskInfo['orgesab_orgesabAdminCompany'] ) )
    {
      if( $parentObject->CMD == 'add' )
      {
          // In case of new task and if field is empty, set default email address
        $taskInfo['orgesab_orgesabAdminCompany'] = $GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'];
      }
      elseif( $parentObject->CMD == 'edit' )
      {
          // In case of edit, and editing a test task, set to internal value if not data was submitted already
        $taskInfo['orgesab_orgesabAdminCompany'] = $task->orgesab_orgesabAdminCompany;
      }
      else
      {
          // Otherwise set an empty value, as it will not be used anyway
        $taskInfo['orgesab_orgesabAdminCompany'] = '';
      }
    }
      // IF : field is empty, initialize extra field value

      // Write the code for the field
    $fieldID    = 'orgesab_orgesabAdminCompany';
    $fieldValue = htmlspecialchars( $taskInfo['orgesab_orgesabAdminCompany'] );
    $fieldCode  = '<input type="text" name="tx_scheduler[orgesab_orgesabAdminCompany]" id="' . $fieldID . '" value="' . $fieldValue . '" size="50" />';
    $additionalFields = array( );
    $additionalFields[$fieldID] = array
    (
      'code'     => $fieldCode,
      'label'    => 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.orgesabAdminCompany',
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
 * getFieldOrgesabAdminName( )  : This method is used to define new fields for adding or editing a task
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
  private function getFieldOrgesabAdminName( array &$taskInfo, $task, $parentObject )
  {
      // IF : field is empty, initialize extra field value
    if( empty( $taskInfo['orgesab_orgesabAdminName'] ) )
    {
      if( $parentObject->CMD == 'add' )
      {
          // In case of new task and if field is empty, set default email address
        $taskInfo['orgesab_orgesabAdminName'] = $GLOBALS['BE_USER']->user['realName'];
      }
      elseif( $parentObject->CMD == 'edit' )
      {
          // In case of edit, and editing a test task, set to internal value if not data was submitted already
        $taskInfo['orgesab_orgesabAdminName'] = $task->orgesab_orgesabAdminName;
      }
      else
      {
          // Otherwise set an empty value, as it will not be used anyway
        $taskInfo['orgesab_orgesabAdminName'] = '';
      }
    }
      // IF : field is empty, initialize extra field value

      // Write the code for the field
    $fieldID    = 'orgesab_orgesabAdminName';
    $fieldValue = htmlspecialchars( $taskInfo['orgesab_orgesabAdminName'] );
    $fieldCode  = '<input type="text" name="tx_scheduler[orgesab_orgesabAdminName]" id="' . $fieldID . '" value="' . $fieldValue . '" size="50" />';
    $additionalFields = array( );
    $additionalFields[$fieldID] = array
    (
      'code'     => $fieldCode,
      'label'    => 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.orgesabAdminName',
      'cshKey'   => '_MOD_tools_txschedulerM1',
      'cshLabel' => $fieldID
    );
      // Write the code for the field

    return $additionalFields;
  }


  /**
 * getFieldOrgesabAdminPhone( )  : This method is used to define new fields for adding or editing a task
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
  private function getFieldOrgesabAdminPhone( array &$taskInfo, $task, $parentObject )
  {
      // IF : field is empty, initialize extra field value
    if( empty( $taskInfo['orgesab_orgesabAdminPhone'] ) )
    {
      if( $parentObject->CMD == 'add' )
      {
          // In case of new task and if field is empty, set default email address
        $taskInfo['orgesab_orgesabAdminPhone'] = '000 00000000';
      }
      elseif( $parentObject->CMD == 'edit' )
      {
          // In case of edit, and editing a test task, set to internal value if not data was submitted already
        $taskInfo['orgesab_orgesabAdminPhone'] = $task->orgesab_orgesabAdminPhone;
      }
      else
      {
          // Otherwise set an empty value, as it will not be used anyway
        $taskInfo['orgesab_orgesabAdminPhone'] = '';
      }
    }
      // IF : field is empty, initialize extra field value

      // Write the code for the field
    $fieldID    = 'orgesab_orgesabAdminPhone';
    $fieldValue = htmlspecialchars( $taskInfo['orgesab_orgesabAdminPhone'] );
    $fieldCode  = '<input type="text" name="tx_scheduler[orgesab_orgesabAdminPhone]" id="' . $fieldID . '" value="' . $fieldValue . '" size="50" />';
    $additionalFields = array( );
    $additionalFields[$fieldID] = array
    (
      'code'     => $fieldCode,
      'label'    => 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.orgesabAdminPhone',
      'cshKey'   => '_MOD_tools_txschedulerM1',
      'cshLabel' => $fieldID
    );
      // Write the code for the field

    return $additionalFields;
  }

  /**
 * getFieldQuotaLimitDefault( )  : This method is used to define new fields for adding or editing a task
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
  private function getFieldQuotaLimitDefault( array &$taskInfo, $task, $parentObject )
  {
      // IF : field is empty, initialize extra field value
    if( empty( $taskInfo['orgesab_quotaLimitDefault'] ) )
    {
      if( $parentObject->CMD == 'add' )
      {
          // In case of new task and if field is empty, set default email address
        $taskInfo['orgesab_quotaLimitDefault'] = '100';
      }
      elseif( $parentObject->CMD == 'edit' )
      {
          // In case of edit, and editing a test task, set to internal value if not data was submitted already
        $taskInfo['orgesab_quotaLimitDefault'] = $task->orgesab_quotaLimitDefault;
      }
      else
      {
          // Otherwise set an empty value, as it will not be used anyway
        $taskInfo['orgesab_quotaLimitDefault'] = '';
      }
    }
      // IF : field is empty, initialize extra field value

      // Write the code for the field
    $fieldID    = 'orgesab_quotaLimitDefault';
    $fieldValue = htmlspecialchars( $taskInfo['orgesab_quotaLimitDefault'] );
    $fieldCode  = '<input type="text" name="tx_scheduler[orgesab_quotaLimitDefault]" id="' . $fieldID . '" value="' . $fieldValue . '" size="5" maxlength="5"/>';
    $additionalFields = array( );
    $additionalFields[$fieldID] = array
    (
      'code'     => $fieldCode,
      'label'    => 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.quotaLimitDefault',
      'cshKey'   => '_MOD_tools_txschedulerM1',
      'cshLabel' => $fieldID
    );
      // Write the code for the field

    return $additionalFields;
  }

  /**
 * getFieldQuotaLimitRemove( )  : This method is used to define new fields for adding or editing a task
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
  private function getFieldQuotaLimitRemove( array &$taskInfo, $task, $parentObject )
  {
      // IF : field is empty, initialize extra field value
    if( empty( $taskInfo['orgesab_quotaLimitRemove'] ) )
    {
      if( $parentObject->CMD == 'add' )
      {
          // In case of new task and if field is empty, set default email address
        $taskInfo['orgesab_quotaLimitRemove'] = '105';
      }
      elseif( $parentObject->CMD == 'edit' )
      {
          // In case of edit, and editing a test task, set to internal value if not data was submitted already
        $taskInfo['orgesab_quotaLimitRemove'] = $task->orgesab_quotaLimitRemove;
      }
      else
      {
          // Otherwise set an empty value, as it will not be used anyway
        $taskInfo['orgesab_quotaLimitRemove'] = '';
      }
    }
      // IF : field is empty, initialize extra field value

      // Write the code for the field
    $fieldID    = 'orgesab_quotaLimitRemove';
    $fieldValue = htmlspecialchars( $taskInfo['orgesab_quotaLimitRemove'] );
    $fieldCode  = '<input type="text" name="tx_scheduler[orgesab_quotaLimitRemove]" id="' . $fieldID . '" value="' . $fieldValue . '" size="3"  maxlength="3"/>';
    $additionalFields = array( );
    $additionalFields[$fieldID] = array
    (
      'code'     => $fieldCode,
      'label'    => 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.quotaLimitRemove',
      'cshKey'   => '_MOD_tools_txschedulerM1',
      'cshLabel' => $fieldID
    );
      // Write the code for the field

    return $additionalFields;
  }

  /**
 * getFieldQuotaLimitWarn( )  : This method is used to define new fields for adding or editing a task
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
  private function getFieldQuotaLimitWarn( array &$taskInfo, $task, $parentObject )
  {
      // IF : field is empty, initialize extra field value
    if( empty( $taskInfo['orgesab_quotaLimitWarn'] ) )
    {
      if( $parentObject->CMD == 'add' )
      {
          // In case of new task and if field is empty, set default email address
        $taskInfo['orgesab_quotaLimitWarn'] = '95';
      }
      elseif( $parentObject->CMD == 'edit' )
      {
          // In case of edit, and editing a test task, set to internal value if not data was submitted already
        $taskInfo['orgesab_quotaLimitWarn'] = $task->orgesab_quotaLimitWarn;
      }
      else
      {
          // Otherwise set an empty value, as it will not be used anyway
        $taskInfo['orgesab_quotaLimitWarn'] = '';
      }
    }
      // IF : field is empty, initialize extra field value

      // Write the code for the field
    $fieldID    = 'orgesab_quotaLimitWarn';
    $fieldValue = htmlspecialchars( $taskInfo['orgesab_quotaLimitWarn'] );
    $fieldCode  = '<input type="text" name="tx_scheduler[orgesab_quotaLimitWarn]" id="' . $fieldID . '" value="' . $fieldValue . '" size="3"  maxlength="3"/>';
    $additionalFields = array( );
    $additionalFields[$fieldID] = array
    (
      'code'     => $fieldCode,
      'label'    => 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.quotaLimitWarn',
      'cshKey'   => '_MOD_tools_txschedulerM1',
      'cshLabel' => $fieldID
    );
      // Write the code for the field

    return $additionalFields;
  }


  /**
 * getFieldQuotaMode( )  : This method is used to define new fields for adding or editing a task
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
  private function getFieldQuotaMode( array &$taskInfo, $task, $parentObject )
  {
      // IF : field is empty, initialize extra field value
    if( empty( $taskInfo['orgesab_quotaMode'] ) )
    {
      if( $parentObject->CMD == 'add' )
      {
          // In case of new task and if field is empty, set default email address
        $taskInfo['orgesab_quotaMode'] = 'test';
      }
      elseif( $parentObject->CMD == 'edit' )
      {
          // In case of edit, and editing a test task, set to internal value if not data was submitted already
        $taskInfo['orgesab_quotaMode'] = $task->orgesab_quotaMode;
      }
      else
      {
          // Otherwise set an empty value, as it will not be used anyway
        $taskInfo['orgesab_quotaMode'] = '';
      }
    }
      // IF : field is empty, initialize extra field value

      // Write the code for the field
    $fieldID      = 'orgesab_quotaMode';
    $fieldValue   = $taskInfo['orgesab_quotaMode'];
    $labelRemove  = $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.quotaMode.remove' );
    $labelWarn    = $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.quotaMode.warn' );
    $labelTest    = $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.quotaMode.test' );
    $selected               = array( );
    $selected['remove']     = null;
    $selected['test']       = null;
    $selected['warn']       = null;
    $selected[$fieldValue]  = ' selected="selected"';

    $fieldCode    = '
                      <select name="tx_scheduler[orgesab_quotaMode]" id="' . $fieldID . '" size="1" style="width:300px;">
                        <option value="remove"' . $selected['remove'] . '>' . $labelRemove . '</option>
                        <option value="warn"' . $selected['warn'] . '>' . $labelWarn . '</option>
                        <option value="test"' . $selected['test'] . '>' . $labelTest . '</option>
                      </select>
                    ';
    $additionalFields = array( );
    $additionalFields[$fieldID] = array
    (
      'code'     => $fieldCode,
      'label'    => 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.quotaMode',
      'cshKey'   => '_MOD_tools_txschedulerM1',
      'cshLabel' => $fieldID
    );
      // Write the code for the field

    return $additionalFields;
  }


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

    if( ! $this->validateFieldOrgesabAdminCompany( $submittedData, $parentObject ) )
    {
      $bool_isValidatingSuccessful = false;
    }

    if( ! $this->validateFieldOrgesabAdminEmail( $submittedData, $parentObject ) )
    {
      $bool_isValidatingSuccessful = false;
    }

    if( ! $this->validateFieldOrgesabAdminName( $submittedData, $parentObject ) )
    {
      $bool_isValidatingSuccessful = false;
    }

    if( ! $this->validateFieldOrgesabAdminPhone( $submittedData, $parentObject ) )
    {
      $bool_isValidatingSuccessful = false;
    }

    if( ! $this->validateFieldQuotaMode( $submittedData, $parentObject ) )
    {
      $bool_isValidatingSuccessful = false;
    }

    if( ! $this->validateFieldQuotaLimitDefault( $submittedData, $parentObject ) )
    {
      $bool_isValidatingSuccessful = false;
    }

    if( ! $this->validateFieldQuotaLimitRemove( $submittedData, $parentObject ) )
    {
      $bool_isValidatingSuccessful = false;
    }

    if( ! $this->validateFieldQuotaLimitWarn( $submittedData, $parentObject ) )
    {
      $bool_isValidatingSuccessful = false;
    }


    if( ! $this->validateFieldQuotaReduceMailbox( $submittedData, $parentObject ) )
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
 * validateFieldOrgesabAdminCompany( )  : This method checks any additional data that is relevant to the specific task
 *                                     If the task class is not relevant, the method is expected to return TRUE
 *
 * @param	array		$submittedData Reference to the array containing the data submitted by the user
 * @param	tx_scheduler_Module		$parentObject Reference to the calling object (Scheduler's BE module)
 * @return	boolean		TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
 * @version       0.0.1
 * @since         0.0.1
 */
  private function validateFieldOrgesabAdminCompany( array &$submittedData, tx_scheduler_Module $parentObject )
  {
    $bool_isValidatingSuccessful = true;

    $submittedData['orgesab_orgesabAdminCompany'] = trim( $submittedData['orgesab_orgesabAdminCompany'] );

    if( empty( $submittedData['orgesab_orgesabAdminCompany'] ) )
    {
      $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.enterOrgesabAdminCompany' );
      $parentObject->addMessage( $prompt, t3lib_FlashMessage::ERROR );
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
 * validateFieldOrgesabAdminName( )  : This method checks any additional data that is relevant to the specific task
 *                                     If the task class is not relevant, the method is expected to return TRUE
 *
 * @param	array		$submittedData Reference to the array containing the data submitted by the user
 * @param	tx_scheduler_Module		$parentObject Reference to the calling object (Scheduler's BE module)
 * @return	boolean		TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
 * @version       0.0.1
 * @since         0.0.1
 */
  private function validateFieldOrgesabAdminName( array &$submittedData, tx_scheduler_Module $parentObject )
  {
    $bool_isValidatingSuccessful = true;

    $submittedData['orgesab_orgesabAdminName'] = trim( $submittedData['orgesab_orgesabAdminName'] );

    if( empty( $submittedData['orgesab_orgesabAdminName'] ) )
    {
      $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.enterOrgesabAdminName' );
      $parentObject->addMessage( $prompt, t3lib_FlashMessage::ERROR );
      $bool_isValidatingSuccessful = false;
    }

    return $bool_isValidatingSuccessful;
  }

  /**
 * validateFieldOrgesabAdminPhone( )  : This method checks any additional data that is relevant to the specific task
 *                                     If the task class is not relevant, the method is expected to return TRUE
 *
 * @param	array		$submittedData Reference to the array containing the data submitted by the user
 * @param	tx_scheduler_Module		$parentObject Reference to the calling object (Scheduler's BE module)
 * @return	boolean		TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
 * @version       0.0.1
 * @since         0.0.1
 */
  private function validateFieldOrgesabAdminPhone( array &$submittedData, tx_scheduler_Module $parentObject )
  {
    $bool_isValidatingSuccessful = true;

    $submittedData['orgesab_orgesabAdminPhone'] = trim( $submittedData['orgesab_orgesabAdminPhone'] );

    if( empty( $submittedData['orgesab_orgesabAdminPhone'] ) )
    {
      $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.enterOrgesabAdminPhone' );
      $parentObject->addMessage( $prompt, t3lib_FlashMessage::ERROR );
      $bool_isValidatingSuccessful = false;
    }

    if( $submittedData['orgesab_orgesabAdminPhone'] == '000 00000000' )
    {
      $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.enterOrgesabAdminPhone' );
      $parentObject->addMessage( $prompt, t3lib_FlashMessage::ERROR );
      $bool_isValidatingSuccessful = false;
    }



    return $bool_isValidatingSuccessful;
  }

  /**
 * validateFieldQuotaLimitDefault( )  : This method checks any additional data that is relevant to the specific task
 *                                     If the task class is not relevant, the method is expected to return TRUE
 *
 * @param	array		$submittedData Reference to the array containing the data submitted by the user
 * @param	tx_scheduler_Module		$parentObject Reference to the calling object (Scheduler's BE module)
 * @return	boolean		TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
 * @version       0.0.1
 * @since         0.0.1
 */
  private function validateFieldQuotaLimitDefault( array &$submittedData, tx_scheduler_Module $parentObject )
  {
    $bool_isValidatingSuccessful = true;

    $submittedData['orgesab_quotaLimitDefault'] = ( int ) $submittedData['orgesab_quotaLimitDefault'];

    switch( true )
    {
      case( $submittedData['orgesab_quotaLimitDefault'] < 50 ):
        $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.enterQuotaLimitDefault' );
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
 * validateFieldQuotaLimitRemove( )  : This method checks any additional data that is relevant to the specific task
 *                                     If the task class is not relevant, the method is expected to return TRUE
 *
 * @param	array		$submittedData Reference to the array containing the data submitted by the user
 * @param	tx_scheduler_Module		$parentObject Reference to the calling object (Scheduler's BE module)
 * @return	boolean		TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
 * @version       0.0.1
 * @since         0.0.1
 */
  private function validateFieldQuotaLimitRemove( array &$submittedData, tx_scheduler_Module $parentObject )
  {
    $bool_isValidatingSuccessful = true;

    $submittedData['orgesab_quotaLimitRemove'] = ( int ) $submittedData['orgesab_quotaLimitRemove'];

    switch( true )
    {
      case( $submittedData['orgesab_quotaLimitRemove'] < 100 ):
      case( $submittedData['orgesab_quotaLimitRemove'] > 150 ):
        $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.enterQuotaLimitRemove' );
        $parentObject->addMessage( $prompt, t3lib_FlashMessage::ERROR );
        $bool_isValidatingSuccessful = false;
        break;
      case( $submittedData['orgesab_quotaLimitRemove'] <= $submittedData['orgesab_quotaLimitWarn'] ):
        $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.enterQuotaLimitRemoveMustBeBigger' );
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
 * validateFieldQuotaLimitWarn( )  : This method checks any additional data that is relevant to the specific task
 *                                     If the task class is not relevant, the method is expected to return TRUE
 *
 * @param	array		$submittedData Reference to the array containing the data submitted by the user
 * @param	tx_scheduler_Module		$parentObject Reference to the calling object (Scheduler's BE module)
 * @return	boolean		TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
 * @version       0.0.1
 * @since         0.0.1
 */
  private function validateFieldQuotaLimitWarn( array &$submittedData, tx_scheduler_Module $parentObject )
  {
    $bool_isValidatingSuccessful = true;

    $submittedData['orgesab_quotaLimitWarn'] = ( int ) $submittedData['orgesab_quotaLimitWarn'];

    switch( true )
    {
      case( $submittedData['orgesab_quotaLimitWarn'] < 50 ):
      case( $submittedData['orgesab_quotaLimitWarn'] > 120 ):
        $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.enterQuotaLimitWarn' );
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
 * validateFieldQuotaMode( )  : This method checks any additional data that is relevant to the specific task
 *                                     If the task class is not relevant, the method is expected to return TRUE
 *
 * @param	array		$submittedData Reference to the array containing the data submitted by the user
 * @param	tx_scheduler_Module		$parentObject Reference to the calling object (Scheduler's BE module)
 * @return	boolean		TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
 * @version       0.0.1
 * @since         0.0.1
 */
  private function validateFieldQuotaMode( array &$submittedData, tx_scheduler_Module $parentObject )
  {
    $bool_isValidatingSuccessful = true;

      // Messages depending on mode
    switch( $submittedData['orgesab_quotaMode'] )
    {
      case( 'remove' ):
        $prompt = $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.quotaMode.remove' );;
        $parentObject->addMessage( $prompt, t3lib_FlashMessage::WARNING );
        break;
      case( 'test' ):
        $prompt = $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.quotaMode.test' );;
        $parentObject->addMessage( $prompt, t3lib_FlashMessage::INFO );
        break;
      case( 'warn' ):
        $prompt = $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.quotaMode.warn' );;
        $parentObject->addMessage( $prompt, t3lib_FlashMessage::INFO );
        break;
      default:
        $bool_isValidatingSuccessful = false;
        $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.quotaMode.undefined' );;
        $parentObject->addMessage( $prompt, t3lib_FlashMessage::ERROR );
        break;
    }
      // Messages depending on mode

    return $bool_isValidatingSuccessful;
  }

  /**
 * validateFieldQuotaReduceMailbox( )  : This method checks any additional data that is relevant to the specific task
 *                                     If the task class is not relevant, the method is expected to return TRUE
 *
 * @param	array		$submittedData Reference to the array containing the data submitted by the user
 * @param	tx_scheduler_Module		$parentObject Reference to the calling object (Scheduler's BE module)
 * @return	boolean		TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
 * @version       0.0.1
 * @since         0.0.1
 */
  private function validateFieldQuotaReduceMailbox( array &$submittedData, tx_scheduler_Module $parentObject )
  {
    $bool_isValidatingSuccessful = true;

    $submittedData['orgesab_quotaReduceMailbox'] = ( int ) $submittedData['orgesab_quotaReduceMailbox'];

    switch( true )
    {
      case( $submittedData['orgesab_quotaReduceMailbox'] < 50 ):
      case( $submittedData['orgesab_quotaReduceMailbox'] > 100 ):
        $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.enterQuotaReduceMailbox' );
        $parentObject->addMessage( $prompt, t3lib_FlashMessage::ERROR );
        $bool_isValidatingSuccessful = false;
        break;
      case( $submittedData['orgesab_quotaReduceMailbox'] >= $submittedData['orgesab_quotaLimitRemove'] ):
        $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.enterQuotaReduceMailboxMustBeSmaller' );
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
    $this->saveFieldOrgesabAdminCompany( $submittedData, $task );
    $this->saveFieldOrgesabAdminEmail( $submittedData, $task );
    $this->saveFieldOrgesabAdminName( $submittedData, $task );
    $this->saveFieldOrgesabAdminPhone( $submittedData, $task );
    $this->saveFieldQuotaMode( $submittedData, $task );
    $this->saveFieldQuotaLimitDefault( $submittedData, $task );
    $this->saveFieldQuotaLimitRemove( $submittedData, $task );
    $this->saveFieldQuotaLimitWarn( $submittedData, $task );
    $this->saveFieldQuotaReduceMailbox( $submittedData, $task );
  }

  /**
 * saveFieldOrgesabAdminCompany( ) : This method is used to save any additional input into the current task object
 *                           if the task class matches
 *
 * @param	array		$submittedData Array containing the data submitted by the user
 * @param	tx_scheduler_Task		$task Reference to the current task object
 * @return	void
 * @version       0.0.1
 * @since         0.0.1
 */
  private function saveFieldOrgesabAdminCompany( array $submittedData, tx_scheduler_Task $task )
  {
    $task->orgesab_orgesabAdminCompany = $submittedData['orgesab_orgesabAdminCompany'];
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
 * saveFieldOrgesabAdminName( ) : This method is used to save any additional input into the current task object
 *                           if the task class matches
 *
 * @param	array		$submittedData Array containing the data submitted by the user
 * @param	tx_scheduler_Task		$task Reference to the current task object
 * @return	void
 * @version       0.0.1
 * @since         0.0.1
 */
  private function saveFieldOrgesabAdminName( array $submittedData, tx_scheduler_Task $task )
  {
    $task->orgesab_orgesabAdminName = $submittedData['orgesab_orgesabAdminName'];
  }

  /**
 * saveFieldOrgesabAdminPhone( ) : This method is used to save any additional input into the current task object
 *                           if the task class matches
 *
 * @param	array		$submittedData Array containing the data submitted by the user
 * @param	tx_scheduler_Task		$task Reference to the current task object
 * @return	void
 * @version       0.0.1
 * @since         0.0.1
 */
  private function saveFieldOrgesabAdminPhone( array $submittedData, tx_scheduler_Task $task )
  {
    $task->orgesab_orgesabAdminPhone = $submittedData['orgesab_orgesabAdminPhone'];
  }

  /**
 * saveFieldQuotaMode( ) : This method is used to save any additional input into the current task object
 *                           if the task class matches
 *
 * @param	array		$submittedData Array containing the data submitted by the user
 * @param	tx_scheduler_Task		$task Reference to the current task object
 * @return	void
 * @version       0.0.1
 * @since         0.0.1
 */
  private function saveFieldQuotaMode( array $submittedData, tx_scheduler_Task $task )
  {
    $task->orgesab_quotaMode = $submittedData['orgesab_quotaMode'];
  }

  /**
 * saveFieldQuotaLimitDefault( ) : This method is used to save any additional input into the current task object
 *                           if the task class matches
 *
 * @param	array		$submittedData Array containing the data submitted by the user
 * @param	tx_scheduler_Task		$task Reference to the current task object
 * @return	void
 * @version       0.0.1
 * @since         0.0.1
 */
  private function saveFieldQuotaLimitDefault( array $submittedData, tx_scheduler_Task $task )
  {
    $orgesab_quotaLimitDefault       = ( int ) $submittedData['orgesab_quotaLimitDefault'];
    $task->orgesab_quotaLimitDefault = $orgesab_quotaLimitDefault;
  }

  /**
 * saveFieldQuotaLimitRemove( ) : This method is used to save any additional input into the current task object
 *                           if the task class matches
 *
 * @param	array		$submittedData Array containing the data submitted by the user
 * @param	tx_scheduler_Task		$task Reference to the current task object
 * @return	void
 * @version       0.0.1
 * @since         0.0.1
 */
  private function saveFieldQuotaLimitRemove( array $submittedData, tx_scheduler_Task $task )
  {
    $orgesab_quotaLimitRemove       = ( int ) $submittedData['orgesab_quotaLimitRemove'];
    $task->orgesab_quotaLimitRemove = $orgesab_quotaLimitRemove;
  }

  /**
 * saveFieldQuotaLimitWarn( ) : This method is used to save any additional input into the current task object
 *                           if the task class matches
 *
 * @param	array		$submittedData Array containing the data submitted by the user
 * @param	tx_scheduler_Task		$task Reference to the current task object
 * @return	void
 * @version       0.0.1
 * @since         0.0.1
 */
  private function saveFieldQuotaLimitWarn( array $submittedData, tx_scheduler_Task $task )
  {
    $orgesab_quotaLimitWarn       = ( int ) $submittedData['orgesab_quotaLimitWarn'];
    $task->orgesab_quotaLimitWarn = $orgesab_quotaLimitWarn;
  }

  /**
 * saveFieldQuotaReduceMailbox( ) : This method is used to save any additional input into the current task object
 *                           if the task class matches
 *
 * @param	array		$submittedData Array containing the data submitted by the user
 * @param	tx_scheduler_Task		$task Reference to the current task object
 * @return	void
 * @version       0.0.1
 * @since         0.0.1
 */
  private function saveFieldQuotaReduceMailbox( array $submittedData, tx_scheduler_Task $task )
  {
    $orgesab_quotaReduceMailbox       = ( int ) $submittedData['orgesab_quotaReduceMailbox'];
    $task->orgesab_quotaReduceMailbox = $orgesab_quotaReduceMailbox;
  }


}

if (defined('TYPO3_MODE') && isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/orgesab/lib/scheduler/class.tx_orgesab_quotatask_additionalfieldprovider.php'])) {
  include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/orgesab/lib/scheduler/class.tx_orgesab_quotatask_additionalfieldprovider.php']);
}

?>