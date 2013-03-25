<?php
/*
 * Register necessary class names with autoloader
 */
$extensionPath = t3lib_extMgm::extPath('orgesab');
return array(
    'tx_orgesab_importtask'                          => $extensionPath . 'lib/scheduler/class.tx_orgesab_importtask.php',
    'tx_orgesab_importtask_additionalfieldprovider'  => $extensionPath . 'lib/scheduler/class.tx_orgesab_importtask_additionalfieldprovider.php',
    'tx_orgesab_quotatask'                          => $extensionPath . 'lib/scheduler/class.tx_orgesab_quotatask.php',
    'tx_orgesab_quotatask_additionalfieldprovider'  => $extensionPath . 'lib/scheduler/class.tx_orgesab_quotatask_additionalfieldprovider.php',
    'tx_orgesab_testtask'                           => $extensionPath . 'lib/scheduler/class.tx_orgesab_testtask.php',
    'tx_orgesab_testtask_additionalfieldprovider'   => $extensionPath . 'lib/scheduler/class.tx_orgesab_testtask_additionalfieldprovider.php',
);
?>