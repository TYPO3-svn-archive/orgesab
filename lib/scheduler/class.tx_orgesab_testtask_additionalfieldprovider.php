<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009-2011 François Suter <francois@typo3.org>
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
 * Aditional fields provider class for usage with the Scheduler's test task
 *
 * @author        François Suter <francois@typo3.org>
 * @package        TYPO3
 * @subpackage    tx_orgesab
 */
class tx_orgesab_TestTask_AdditionalFieldProvider implements tx_scheduler_AdditionalFieldProvider {

    var $extLabel = 'Org +ESAB';

    /**
 * This method is used to define new fields for adding or editing a task
 * In this case, it adds an email field
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
 */
    public function getAdditionalFields(array &$taskInfo, $task, tx_scheduler_Module $parentObject) {

            // Initialize extra field value
        if (empty($taskInfo['orgesab_orgesabAdminEmail'])) {
            if ($parentObject->CMD == 'add') {
                    // In case of new task and if field is empty, set default email address
                $taskInfo['orgesab_orgesabAdminEmail'] = $GLOBALS['BE_USER']->user['email'];

            } elseif ($parentObject->CMD == 'edit') {
                    // In case of edit, and editing a test task, set to internal value if not data was submitted already
                $taskInfo['orgesab_orgesabAdminEmail'] = $task->orgesab_orgesabAdminEmail;
            } else {
                    // Otherwise set an empty value, as it will not be used anyway
                $taskInfo['orgesab_orgesabAdminEmail'] = '';
            }
        }

            // Write the code for the field
        $fieldID    = 'orgesab_orgesabAdminEmail';
        $fieldValue = htmlspecialchars( $taskInfo['orgesab_orgesabAdminEmail'] );
        $fieldCode  = '<input type="text" name="tx_scheduler[orgesab_orgesabAdminEmail]" id="' . $fieldID . '" value="' . $fieldValue . '" size="30" />';
        $additionalFields = array();
        $additionalFields[$fieldID] = array(
            'code'     => $fieldCode,
            'label'    => 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:label.orgesabAdminEmail',
            'cshKey'   => '_MOD_tools_txschedulerM1',
            'cshLabel' => $fieldID
        );

        return $additionalFields;
    }

    /**
 * This method checks any additional data that is relevant to the specific task
 * If the task class is not relevant, the method is expected to return TRUE
 *
 * @param	array		$submittedData Reference to the array containing the data submitted by the user
 * @param	tx_scheduler_Module		$parentObject Reference to the calling object (Scheduler's BE module)
 * @return	boolean		TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
 */
    public function validateAdditionalFields(array &$submittedData, tx_scheduler_Module $parentObject) {
        $submittedData['orgesab_orgesabAdminEmail'] = trim($submittedData['orgesab_orgesabAdminEmail']);

        if (empty($submittedData['orgesab_orgesabAdminEmail'])) {
            $prompt = $this->extLabel . ': ' . $GLOBALS['LANG']->sL( 'LLL:EXT:orgesab/lib/scheduler/locallang.xml:msg.enterEmail' );
            $parentObject->addMessage( $prompt, t3lib_FlashMessage::ERROR );
            $result = FALSE;
        } else {
            $result = TRUE;
        }

        return $result;
    }

    /**
 * This method is used to save any additional input into the current task object
 * if the task class matches
 *
 * @param	array		$submittedData Array containing the data submitted by the user
 * @param	tx_scheduler_Task		$task Reference to the current task object
 * @return	void
 */
    public function saveAdditionalFields(array $submittedData, tx_scheduler_Task $task) {
        $task->orgesab_orgesabAdminEmail = $submittedData['orgesab_orgesabAdminEmail'];
    }
}

if (defined('TYPO3_MODE') && isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/orgesab/lib/scheduler/class.tx_orgesab_testtask_additionalfieldprovider.php'])) {
    include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/orgesab/lib/scheduler/class.tx_orgesab_testtask_additionalfieldprovider.php']);
}

?>