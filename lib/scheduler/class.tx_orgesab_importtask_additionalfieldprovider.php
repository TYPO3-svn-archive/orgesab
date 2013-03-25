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

  /**
    * getAdditionalFields( )  : This method is used to define new fields for adding or editing a task
    *                           In this case, it adds an email field
    *
    * @param array $taskInfo Reference to the array containing the info used in the add/edit form
    * @param object $task When editing, reference to the current task object. Null when adding.
    * @param tx_scheduler_Module $parentObject Reference to the calling object (Scheduler's BE module)
    * @return array    Array containing all the information pertaining to the additional fields
    *                    The array is multidimensional, keyed to the task class name and each field's id
    *                    For each field it provides an associative sub-array with the following:
    *                        ['code']        => The HTML code for the field
    *                        ['label']        => The label of the field (possibly localized)
    *                        ['cshKey']        => The CSH key for the field
    *                        ['cshLabel']    => The code of the CSH label
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
    $additionalFields = $additionalFields + $this->getFieldImportMode( $taskInfo, $task, $parentObject );
    $additionalFields = $additionalFields + $this->getFieldImportLimitDefault( $taskInfo, $task, $parentObject );
    $additionalFields = $additionalFields + $this->getFieldImportLimitRemove( $taskInfo, $task, $parentObject );
    $additionalFields = $additionalFields + $this->getFieldImportLimitWarn( $taskInfo, $task, $parentObject );
    $additionalFields = $additionalFields + $this->getFieldImportReduceMailbox( $taskInfo, $task, $parentObject );
//    importDefaultLimit
    
    return $additionalFields;
  }

  /**
    * getFieldImportReduceMailbox( )  : This method is used to define new fields for adding or editing a task
    *                                           In this case, it adds an email field
    *
    * @param array $taskInfo Reference to the array containing the info used in the add/edit form
    * @param object $task When editing, reference to the current task object. Null when adding.
    * @param tx_scheduler_Module $parentObject Reference to the calling object (Scheduler's BE module)
    * @return array    Array containing all the information pertaining to the additional fields
    *                    The array is multidimensional, keyed to the task class name and each field's id
    *                    For each field it provides an associative sub-array with the following:
    *                        ['code']        => The HTML code for the field
    *                        ['label']        => The label of the field (possibly localized)
    *                        ['cshKey']        => The CSH key for the field
    *                        ['cshLabel']    => The code of the CSH label
    * @version       0.0.1
    * @since         0.0.1
    */
  private function getFieldImportReduceMailbox( array &$taskInfo, $task, $parentObject ) 
  {
      // IF : field is empty, initialize extra field value
    if( empty( $taskInfo['orgesab_importReduceMailbox'] ) ) 
    {
      if( $parentObject->CMD == 'add' ) 
      {
          // In case of new task and if field is empty, set default email address
        $taskInfo['orgesab_importReduceMailbox'] = '90';
      } 
      elseif( $parentObject->CMD == 'edit' ) 
      {
          // In case of edit, and editing a test task, set to internal value if not data was submitted already
        $taskInfo['orgesab_importReduceMailbox'] = $task->orgesab_importReduceMailbox;
      }
      else
      {
          // Otherwise set an empty value, as it will not be used anyway
        $taskInfo['orgesab_importReduceMailbox'] = '';
      }
    }
      // IF : field is empty, initialize extra field value

      // Write the code for the field
    $fieldID    = 'orgesab_importReduceMailbox';
    $fieldValue = htmlspecialchars( $taskInfo['orgesab_importReduceMailbox'] );
    $fieldCode  = '<input type="text" name="tx_scheduler[orgesab_importReduceMailbox]" id="' . $fieldID . '" value="' . $fieldValue . '" size="3"  maxlength="3"/>';
    $additionalFields = array( );
    $additionalFields[$fieldID] = array
    (
      'code'     => $fieldCode,
      'label'    => 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.importReduceMailbox',
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
    * @param array $taskInfo Reference to the array containing the info used in the add/edit form
    * @param object $task When editing, reference to the current task object. Null when adding.
    * @param tx_scheduler_Module $parentObject Reference to the calling object (Scheduler's BE module)
    * @return array    Array containing all the information pertaining to the additional fields
    *                    The array is multidimensional, keyed to the task class name and each field's id
    *                    For each field it provides an associative sub-array with the following:
    *                        ['code']        => The HTML code for the field
    *                        ['label']        => The label of the field (possibly localized)
    *                        ['cshKey']        => The CSH key for the field
    *                        ['cshLabel']    => The code of the CSH label
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
    * @param array $taskInfo Reference to the array containing the info used in the add/edit form
    * @param object $task When editing, reference to the current task object. Null when adding.
    * @param tx_scheduler_Module $parentObject Reference to the calling object (Scheduler's BE module)
    * @return array    Array containing all the information pertaining to the additional fields
    *                    The array is multidimensional, keyed to the task class name and each field's id
    *                    For each field it provides an associative sub-array with the following:
    *                        ['code']        => The HTML code for the field
    *                        ['label']        => The label of the field (possibly localized)
    *                        ['cshKey']        => The CSH key for the field
    *                        ['cshLabel']    => The code of the CSH label
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
    * @param array $taskInfo Reference to the array containing the info used in the add/edit form
    * @param object $task When editing, reference to the current task object. Null when adding.
    * @param tx_scheduler_Module $parentObject Reference to the calling object (Scheduler's BE module)
    * @return array    Array containing all the information pertaining to the additional fields
    *                    The array is multidimensional, keyed to the task class name and each field's id
    *                    For each field it provides an associative sub-array with the following:
    *                        ['code']        => The HTML code for the field
    *                        ['label']        => The label of the field (possibly localized)
    *                        ['cshKey']        => The CSH key for the field
    *                        ['cshLabel']    => The code of the CSH label
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
    * @param array $taskInfo Reference to the array containing the info used in the add/edit form
    * @param object $task When editing, reference to the current task object. Null when adding.
    * @param tx_scheduler_Module $parentObject Reference to the calling object (Scheduler's BE module)
    * @return array    Array containing all the information pertaining to the additional fields
    *                    The array is multidimensional, keyed to the task class name and each field's id
    *                    For each field it provides an associative sub-array with the following:
    *                        ['code']        => The HTML code for the field
    *                        ['label']        => The label of the field (possibly localized)
    *                        ['cshKey']        => The CSH key for the field
    *                        ['cshLabel']    => The code of the CSH label
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
    * getFieldImportLimitDefault( )  : This method is used to define new fields for adding or editing a task
    *                                           In this case, it adds an email field
    *
    * @param array $taskInfo Reference to the array containing the info used in the add/edit form
    * @param object $task When editing, reference to the current task object. Null when adding.
    * @param tx_scheduler_Module $parentObject Reference to the calling object (Scheduler's BE module)
    * @return array    Array containing all the information pertaining to the additional fields
    *                    The array is multidimensional, keyed to the task class name and each field's id
    *                    For each field it provides an associative sub-array with the following:
    *                        ['code']        => The HTML code for the field
    *                        ['label']        => The label of the field (possibly localized)
    *                        ['cshKey']        => The CSH key for the field
    *                        ['cshLabel']    => The code of the CSH label
    * @version       0.0.1
    * @since         0.0.1
    */
  private function getFieldImportLimitDefault( array &$taskInfo, $task, $parentObject ) 
  {
      // IF : field is empty, initialize extra field value
    if( empty( $taskInfo['orgesab_importLimitDefault'] ) ) 
    {
      if( $parentObject->CMD == 'add' ) 
      {
          // In case of new task and if field is empty, set default email address
        $taskInfo['orgesab_importLimitDefault'] = '100';
      } 
      elseif( $parentObject->CMD == 'edit' ) 
      {
          // In case of edit, and editing a test task, set to internal value if not data was submitted already
        $taskInfo['orgesab_importLimitDefault'] = $task->orgesab_importLimitDefault;
      }
      else
      {
          // Otherwise set an empty value, as it will not be used anyway
        $taskInfo['orgesab_importLimitDefault'] = '';
      }
    }
      // IF : field is empty, initialize extra field value

      // Write the code for the field
    $fieldID    = 'orgesab_importLimitDefault';
    $fieldValue = htmlspecialchars( $taskInfo['orgesab_importLimitDefault'] );
    $fieldCode  = '<input type="text" name="tx_scheduler[orgesab_importLimitDefault]" id="' . $fieldID . '" value="' . $fieldValue . '" size="5" maxlength="5"/>';
    $additionalFields = array( );
    $additionalFields[$fieldID] = array
    (
      'code'     => $fieldCode,
      'label'    => 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.importLimitDefault',
      'cshKey'   => '_MOD_tools_txschedulerM1',
      'cshLabel' => $fieldID
    );
      // Write the code for the field

    return $additionalFields;
  }

  /**
    * getFieldImportLimitRemove( )  : This method is used to define new fields for adding or editing a task
    *                                           In this case, it adds an email field
    *
    * @param array $taskInfo Reference to the array containing the info used in the add/edit form
    * @param object $task When editing, reference to the current task object. Null when adding.
    * @param tx_scheduler_Module $parentObject Reference to the calling object (Scheduler's BE module)
    * @return array    Array containing all the information pertaining to the additional fields
    *                    The array is multidimensional, keyed to the task class name and each field's id
    *                    For each field it provides an associative sub-array with the following:
    *                        ['code']        => The HTML code for the field
    *                        ['label']        => The label of the field (possibly localized)
    *                        ['cshKey']        => The CSH key for the field
    *                        ['cshLabel']    => The code of the CSH label
    * @version       0.0.1
    * @since         0.0.1
    */
  private function getFieldImportLimitRemove( array &$taskInfo, $task, $parentObject ) 
  {
      // IF : field is empty, initialize extra field value
    if( empty( $taskInfo['orgesab_importLimitRemove'] ) ) 
    {
      if( $parentObject->CMD == 'add' ) 
      {
          // In case of new task and if field is empty, set default email address
        $taskInfo['orgesab_importLimitRemove'] = '105';
      } 
      elseif( $parentObject->CMD == 'edit' ) 
      {
          // In case of edit, and editing a test task, set to internal value if not data was submitted already
        $taskInfo['orgesab_importLimitRemove'] = $task->orgesab_importLimitRemove;
      }
      else
      {
          // Otherwise set an empty value, as it will not be used anyway
        $taskInfo['orgesab_importLimitRemove'] = '';
      }
    }
      // IF : field is empty, initialize extra field value

      // Write the code for the field
    $fieldID    = 'orgesab_importLimitRemove';
    $fieldValue = htmlspecialchars( $taskInfo['orgesab_importLimitRemove'] );
    $fieldCode  = '<input type="text" name="tx_scheduler[orgesab_importLimitRemove]" id="' . $fieldID . '" value="' . $fieldValue . '" size="3"  maxlength="3"/>';
    $additionalFields = array( );
    $additionalFields[$fieldID] = array
    (
      'code'     => $fieldCode,
      'label'    => 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.importLimitRemove',
      'cshKey'   => '_MOD_tools_txschedulerM1',
      'cshLabel' => $fieldID
    );
      // Write the code for the field

    return $additionalFields;
  }

  /**
    * getFieldImportLimitWarn( )  : This method is used to define new fields for adding or editing a task
    *                                           In this case, it adds an email field
    *
    * @param array $taskInfo Reference to the array containing the info used in the add/edit form
    * @param object $task When editing, reference to the current task object. Null when adding.
    * @param tx_scheduler_Module $parentObject Reference to the calling object (Scheduler's BE module)
    * @return array    Array containing all the information pertaining to the additional fields
    *                    The array is multidimensional, keyed to the task class name and each field's id
    *                    For each field it provides an associative sub-array with the following:
    *                        ['code']        => The HTML code for the field
    *                        ['label']        => The label of the field (possibly localized)
    *                        ['cshKey']        => The CSH key for the field
    *                        ['cshLabel']    => The code of the CSH label
    * @version       0.0.1
    * @since         0.0.1
    */
  private function getFieldImportLimitWarn( array &$taskInfo, $task, $parentObject ) 
  {
      // IF : field is empty, initialize extra field value
    if( empty( $taskInfo['orgesab_importLimitWarn'] ) ) 
    {
      if( $parentObject->CMD == 'add' ) 
      {
          // In case of new task and if field is empty, set default email address
        $taskInfo['orgesab_importLimitWarn'] = '95';
      } 
      elseif( $parentObject->CMD == 'edit' ) 
      {
          // In case of edit, and editing a test task, set to internal value if not data was submitted already
        $taskInfo['orgesab_importLimitWarn'] = $task->orgesab_importLimitWarn;
      }
      else
      {
          // Otherwise set an empty value, as it will not be used anyway
        $taskInfo['orgesab_importLimitWarn'] = '';
      }
    }
      // IF : field is empty, initialize extra field value

      // Write the code for the field
    $fieldID    = 'orgesab_importLimitWarn';
    $fieldValue = htmlspecialchars( $taskInfo['orgesab_importLimitWarn'] );
    $fieldCode  = '<input type="text" name="tx_scheduler[orgesab_importLimitWarn]" id="' . $fieldID . '" value="' . $fieldValue . '" size="3"  maxlength="3"/>';
    $additionalFields = array( );
    $additionalFields[$fieldID] = array
    (
      'code'     => $fieldCode,
      'label'    => 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.importLimitWarn',
      'cshKey'   => '_MOD_tools_txschedulerM1',
      'cshLabel' => $fieldID
    );
      // Write the code for the field

    return $additionalFields;
  }


  /**
    * getFieldImportMode( )  : This method is used to define new fields for adding or editing a task
    *                                           In this case, it adds an email field
    *
    * @param array $taskInfo Reference to the array containing the info used in the add/edit form
    * @param object $task When editing, reference to the current task object. Null when adding.
    * @param tx_scheduler_Module $parentObject Reference to the calling object (Scheduler's BE module)
    * @return array    Array containing all the information pertaining to the additional fields
    *                    The array is multidimensional, keyed to the task class name and each field's id
    *                    For each field it provides an associative sub-array with the following:
    *                        ['code']        => The HTML code for the field
    *                        ['label']        => The label of the field (possibly localized)
    *                        ['cshKey']        => The CSH key for the field
    *                        ['cshLabel']    => The code of the CSH label
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
    * validateAdditionalFields( ) : This method checks any additional data that is relevant to the specific task
    *                               If the task class is not relevant, the method is expected to return TRUE
    *
    * @param array     $submittedData Reference to the array containing the data submitted by the user
    * @param tx_scheduler_Module $parentObject Reference to the calling object (Scheduler's BE module)
    * @return boolean TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
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

    if( ! $this->validateFieldImportMode( $submittedData, $parentObject ) ) 
    {
      $bool_isValidatingSuccessful = false;
    } 

    if( ! $this->validateFieldImportLimitDefault( $submittedData, $parentObject ) ) 
    {
      $bool_isValidatingSuccessful = false;
    } 

    if( ! $this->validateFieldImportLimitRemove( $submittedData, $parentObject ) ) 
    {
      $bool_isValidatingSuccessful = false;
    } 

    if( ! $this->validateFieldImportLimitWarn( $submittedData, $parentObject ) ) 
    {
      $bool_isValidatingSuccessful = false;
    } 


    if( ! $this->validateFieldImportReduceMailbox( $submittedData, $parentObject ) ) 
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
    * @param array     $submittedData Reference to the array containing the data submitted by the user
    * @param tx_scheduler_Module $parentObject Reference to the calling object (Scheduler's BE module)
    * @return boolean TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
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
    * @param array     $submittedData Reference to the array containing the data submitted by the user
    * @param tx_scheduler_Module $parentObject Reference to the calling object (Scheduler's BE module)
    * @return boolean TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
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
    * @param array     $submittedData Reference to the array containing the data submitted by the user
    * @param tx_scheduler_Module $parentObject Reference to the calling object (Scheduler's BE module)
    * @return boolean TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
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
    * @param array     $submittedData Reference to the array containing the data submitted by the user
    * @param tx_scheduler_Module $parentObject Reference to the calling object (Scheduler's BE module)
    * @return boolean TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
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
    * @param array     $submittedData Reference to the array containing the data submitted by the user
    * @param tx_scheduler_Module $parentObject Reference to the calling object (Scheduler's BE module)
    * @return boolean TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
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
    * validateFieldImportLimitDefault( )  : This method checks any additional data that is relevant to the specific task
    *                                     If the task class is not relevant, the method is expected to return TRUE
    *
    * @param array     $submittedData Reference to the array containing the data submitted by the user
    * @param tx_scheduler_Module $parentObject Reference to the calling object (Scheduler's BE module)
    * @return boolean TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
    * @version       0.0.1
    * @since         0.0.1
    */
  private function validateFieldImportLimitDefault( array &$submittedData, tx_scheduler_Module $parentObject ) 
  {
    $bool_isValidatingSuccessful = true;

    $submittedData['orgesab_importLimitDefault'] = ( int ) $submittedData['orgesab_importLimitDefault'];

    switch( true )
    {
      case( $submittedData['orgesab_importLimitDefault'] < 50 ):
        $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.enterImportLimitDefault' );
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
    * validateFieldImportLimitRemove( )  : This method checks any additional data that is relevant to the specific task
    *                                     If the task class is not relevant, the method is expected to return TRUE
    *
    * @param array     $submittedData Reference to the array containing the data submitted by the user
    * @param tx_scheduler_Module $parentObject Reference to the calling object (Scheduler's BE module)
    * @return boolean TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
    * @version       0.0.1
    * @since         0.0.1
    */
  private function validateFieldImportLimitRemove( array &$submittedData, tx_scheduler_Module $parentObject ) 
  {
    $bool_isValidatingSuccessful = true;

    $submittedData['orgesab_importLimitRemove'] = ( int ) $submittedData['orgesab_importLimitRemove'];

    switch( true )
    {
      case( $submittedData['orgesab_importLimitRemove'] < 100 ):
      case( $submittedData['orgesab_importLimitRemove'] > 150 ):
        $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.enterImportLimitRemove' );
        $parentObject->addMessage( $prompt, t3lib_FlashMessage::ERROR );
        $bool_isValidatingSuccessful = false;
        break;
      case( $submittedData['orgesab_importLimitRemove'] <= $submittedData['orgesab_importLimitWarn'] ):
        $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.enterImportLimitRemoveMustBeBigger' );
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
    * validateFieldImportLimitWarn( )  : This method checks any additional data that is relevant to the specific task
    *                                     If the task class is not relevant, the method is expected to return TRUE
    *
    * @param array     $submittedData Reference to the array containing the data submitted by the user
    * @param tx_scheduler_Module $parentObject Reference to the calling object (Scheduler's BE module)
    * @return boolean TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
    * @version       0.0.1
    * @since         0.0.1
    */
  private function validateFieldImportLimitWarn( array &$submittedData, tx_scheduler_Module $parentObject ) 
  {
    $bool_isValidatingSuccessful = true;

    $submittedData['orgesab_importLimitWarn'] = ( int ) $submittedData['orgesab_importLimitWarn'];

    switch( true )
    {
      case( $submittedData['orgesab_importLimitWarn'] < 50 ):
      case( $submittedData['orgesab_importLimitWarn'] > 120 ):
        $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.enterImportLimitWarn' );
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
    * validateFieldImportMode( )  : This method checks any additional data that is relevant to the specific task
    *                                     If the task class is not relevant, the method is expected to return TRUE
    *
    * @param array     $submittedData Reference to the array containing the data submitted by the user
    * @param tx_scheduler_Module $parentObject Reference to the calling object (Scheduler's BE module)
    * @return boolean TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
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
    * validateFieldImportReduceMailbox( )  : This method checks any additional data that is relevant to the specific task
    *                                     If the task class is not relevant, the method is expected to return TRUE
    *
    * @param array     $submittedData Reference to the array containing the data submitted by the user
    * @param tx_scheduler_Module $parentObject Reference to the calling object (Scheduler's BE module)
    * @return boolean TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
    * @version       0.0.1
    * @since         0.0.1
    */
  private function validateFieldImportReduceMailbox( array &$submittedData, tx_scheduler_Module $parentObject ) 
  {
    $bool_isValidatingSuccessful = true;

    $submittedData['orgesab_importReduceMailbox'] = ( int ) $submittedData['orgesab_importReduceMailbox'];

    switch( true )
    {
      case( $submittedData['orgesab_importReduceMailbox'] < 50 ):
      case( $submittedData['orgesab_importReduceMailbox'] > 100 ):
        $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.enterImportReduceMailbox' );
        $parentObject->addMessage( $prompt, t3lib_FlashMessage::ERROR );
        $bool_isValidatingSuccessful = false;
        break;
      case( $submittedData['orgesab_importReduceMailbox'] >= $submittedData['orgesab_importLimitRemove'] ):
        $prompt = $this->msgPrefix . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.enterImportReduceMailboxMustBeSmaller' );
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
    * @param array     $submittedData Reference to the array containing the data submitted by the user
    * @param tx_scheduler_Module $parentObject Reference to the calling object (Scheduler's BE module)
    * @return boolean TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
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
    * @param array     $submittedData Reference to the array containing the data submitted by the user
    * @param tx_scheduler_Module $parentObject Reference to the calling object (Scheduler's BE module)
    * @return boolean TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
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
    * @param array $submittedData Array containing the data submitted by the user
    * @param tx_scheduler_Task $task Reference to the current task object
    * @return void
    * @version       0.0.1
    * @since         0.0.1
    */
  public function saveAdditionalFields( array $submittedData, tx_scheduler_Task $task )
  {
    $this->saveFieldOrgesabAdminCompany( $submittedData, $task );
    $this->saveFieldOrgesabAdminEmail( $submittedData, $task );
    $this->saveFieldOrgesabAdminName( $submittedData, $task );
    $this->saveFieldOrgesabAdminPhone( $submittedData, $task );
    $this->saveFieldImportMode( $submittedData, $task );
    $this->saveFieldImportLimitDefault( $submittedData, $task );
    $this->saveFieldImportLimitRemove( $submittedData, $task );
    $this->saveFieldImportLimitWarn( $submittedData, $task );
    $this->saveFieldImportReduceMailbox( $submittedData, $task );
  }

  /**
    * saveFieldOrgesabAdminCompany( ) : This method is used to save any additional input into the current task object
    *                           if the task class matches
    *
    * @param array $submittedData Array containing the data submitted by the user
    * @param tx_scheduler_Task $task Reference to the current task object
    * @return void
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
    * @param array $submittedData Array containing the data submitted by the user
    * @param tx_scheduler_Task $task Reference to the current task object
    * @return void
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
    * @param array $submittedData Array containing the data submitted by the user
    * @param tx_scheduler_Task $task Reference to the current task object
    * @return void
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
    * @param array $submittedData Array containing the data submitted by the user
    * @param tx_scheduler_Task $task Reference to the current task object
    * @return void
    * @version       0.0.1
    * @since         0.0.1
    */
  private function saveFieldOrgesabAdminPhone( array $submittedData, tx_scheduler_Task $task )
  {
    $task->orgesab_orgesabAdminPhone = $submittedData['orgesab_orgesabAdminPhone'];
  }

  /**
    * saveFieldImportMode( ) : This method is used to save any additional input into the current task object
    *                           if the task class matches
    *
    * @param array $submittedData Array containing the data submitted by the user
    * @param tx_scheduler_Task $task Reference to the current task object
    * @return void
    * @version       0.0.1
    * @since         0.0.1
    */
  private function saveFieldImportMode( array $submittedData, tx_scheduler_Task $task )
  {
    $task->orgesab_importMode = $submittedData['orgesab_importMode'];
  }

  /**
    * saveFieldImportLimitDefault( ) : This method is used to save any additional input into the current task object
    *                           if the task class matches
    *
    * @param array $submittedData Array containing the data submitted by the user
    * @param tx_scheduler_Task $task Reference to the current task object
    * @return void
    * @version       0.0.1
    * @since         0.0.1
    */
  private function saveFieldImportLimitDefault( array $submittedData, tx_scheduler_Task $task )
  {
    $orgesab_importLimitDefault       = ( int ) $submittedData['orgesab_importLimitDefault'];
    $task->orgesab_importLimitDefault = $orgesab_importLimitDefault;
  }

  /**
    * saveFieldImportLimitRemove( ) : This method is used to save any additional input into the current task object
    *                           if the task class matches
    *
    * @param array $submittedData Array containing the data submitted by the user
    * @param tx_scheduler_Task $task Reference to the current task object
    * @return void
    * @version       0.0.1
    * @since         0.0.1
    */
  private function saveFieldImportLimitRemove( array $submittedData, tx_scheduler_Task $task )
  {
    $orgesab_importLimitRemove       = ( int ) $submittedData['orgesab_importLimitRemove'];
    $task->orgesab_importLimitRemove = $orgesab_importLimitRemove;
  }

  /**
    * saveFieldImportLimitWarn( ) : This method is used to save any additional input into the current task object
    *                           if the task class matches
    *
    * @param array $submittedData Array containing the data submitted by the user
    * @param tx_scheduler_Task $task Reference to the current task object
    * @return void
    * @version       0.0.1
    * @since         0.0.1
    */
  private function saveFieldImportLimitWarn( array $submittedData, tx_scheduler_Task $task )
  {
    $orgesab_importLimitWarn       = ( int ) $submittedData['orgesab_importLimitWarn'];
    $task->orgesab_importLimitWarn = $orgesab_importLimitWarn;
  }

  /**
    * saveFieldImportReduceMailbox( ) : This method is used to save any additional input into the current task object
    *                           if the task class matches
    *
    * @param array $submittedData Array containing the data submitted by the user
    * @param tx_scheduler_Task $task Reference to the current task object
    * @return void
    * @version       0.0.1
    * @since         0.0.1
    */
  private function saveFieldImportReduceMailbox( array $submittedData, tx_scheduler_Task $task )
  {
    $orgesab_importReduceMailbox       = ( int ) $submittedData['orgesab_importReduceMailbox'];
    $task->orgesab_importReduceMailbox = $orgesab_importReduceMailbox;
  }

  
}

if (defined('TYPO3_MODE') && isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/orgesab/lib/scheduler/class.tx_orgesab_importtask_additionalfieldprovider.php'])) {
  include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/orgesab/lib/scheduler/class.tx_orgesab_importtask_additionalfieldprovider.php']);
}

?>