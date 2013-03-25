<?php

if( ! defined ( 'TYPO3_MODE' ) ) 
{
  die ('Access denied.');
}

  // Get the extensions's configuration
$extConf = unserialize( $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['orgesab'] );

  // If sample tasks should be shown,
  // register information for the test tasks
if( ! empty ( $extConf['showSampleTasks'] ) )
{
  $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['tx_orgesab_TestTask'] = array
  (
    'extension'        => $_EXTKEY,
    'title'            => 'LLL:EXT:' . $_EXTKEY . '/lib/scheduler/locallang.xml:label.testTask.name',
    'description'      => 'LLL:EXT:' . $_EXTKEY . '/lib/scheduler/locallang.xml:label.testTask.description',
    'additionalFields' => 'tx_orgesab_TestTask_AdditionalFieldProvider'
  );
  $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['tx_orgesab_QuotaTask'] = array
  (
    'extension'        => $_EXTKEY,
    'title'            => 'LLL:EXT:' . $_EXTKEY . '/lib/scheduler/locallang.xml:label.quotaTask.name',
    'description'      => 'LLL:EXT:' . $_EXTKEY . '/lib/scheduler/locallang.xml:label.quotaTask.description',
    'additionalFields' => 'tx_orgesab_QuotaTask_AdditionalFieldProvider'
  );
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['tx_orgesab_ImportTask'] = array
(
  'extension'        => $_EXTKEY,
  'title'            => 'LLL:EXT:' . $_EXTKEY . '/lib/scheduler/locallang.xml:label.importTask.name',
  'description'      => 'LLL:EXT:' . $_EXTKEY . '/lib/scheduler/locallang.xml:label.importTask.description',
  'additionalFields' => 'tx_orgesab_ImportTask_AdditionalFieldProvider'
);

?>