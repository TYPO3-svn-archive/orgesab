<?php
if (!defined ('TYPO3_MODE')) 
{
  die ('Access denied.');
}



  ////////////////////////////////////////////////////////////////////////////
  // 
  // INDEX
  
  // Set TYPO3 version
  // Configuration by the extension manager
  //    Localization support
  //    Store record configuration
  // Enables the Include Static Templates
  // Add pagetree icons
  // Configure third party tables
  // draft field tx_orgesab
  //    tx_org_cal
  // TCA tables
  //    orgesab



  ////////////////////////////////////////////////////////////////////////////
  //
  // Set TYPO3 version

  // Set TYPO3 version as integer (sample: 4.7.7 -> 4007007)
list( $main, $sub, $bugfix ) = explode( '.', TYPO3_version );
$version = ( ( int ) $main ) * 1000000;
$version = $version + ( ( int ) $sub ) * 1000;
$version = $version + ( ( int ) $bugfix ) * 1;
$typo3Version = $version;
  // Set TYPO3 version as integer (sample: 4.7.7 -> 4007007)

if( $typo3Version < 3000000 ) 
{
  $prompt = '<h1>ERROR</h1>
    <h2>Unproper TYPO3 version</h2>
    <ul>
      <li>
        TYPO3 version is smaller than 3.0.0
      </li>
      <li>
        constant TYPO3_version: ' . TYPO3_version . '
      </li>
      <li>
        integer $this->typo3Version: ' . ( int ) $this->typo3Version . '
      </li>
    </ul>
      ';
  die ( $prompt );
}
  // Set TYPO3 version

    

  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 
  // Configuration by the extension manager
  
$confArr  = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);

  // Language for labels of static templates and page tsConfig
$llStatic = $confArr['LLstatic'];
switch( true ) 
{
  case( $llStatic == 'German' ):
    $llStatic = 'de';
    break;
  default:
    $llStatic = 'default';
}
  // Language for labels of static templates and page tsConfig

  // Simplify the Organiser
$bool_exclude_none    = 1;
$bool_exclude_default = 1;
switch ($confArr['TCA_simplify_organiser'])
{
  case('None excluded: Editor has access to all'):
    $bool_exclude_none    = 0;
    $bool_exclude_default = 0;
    break;
  case('All excluded: Administrator configures it'):
      // All will be left true.
    break;
  case('Default (recommended)'):
    $bool_exclude_default = 0;
  default:
}
  // Simplify the Organiser

  // Simplify backend forms
$bool_time_control = true;
if (strtolower(substr($confArr['TCA_simplify_time_control'], 0, strlen('no'))) == 'no')
{
  $bool_time_control = false;
}
  // Simplify backend forms

  // Store record configuration
$bool_wizards_wo_add_and_list       = false;
$bool_full_wizardSupport_allTables  = true;
$str_marker_pid                     = '###CURRENT_PID###';
switch($confArr['store_records']) 
{
  case('Multi grouped: record groups in different directories'):
    //var_dump('MULTI');
    $str_store_record_conf        = 'pid IN (###PAGE_TSCONFIG_IDLIST###)';
    $bool_wizards_wo_add_and_list = true;
    break;
  case('Clear presented: each record group in one directory at most'):
    //var_dump('CLEAR');
    $str_store_record_conf        = 'pid IN (###PAGE_TSCONFIG_ID###)';
    $bool_wizards_wo_add_and_list = true;
    break;
  case('Easy 2: same as easy 1 but with storage pid'):
    $str_marker_pid         = '###STORAGE_PID###';
    $str_store_record_conf  = 'pid=###STORAGE_PID###';
    break;
  case('Easy 1: all in the same directory'):
  default:
    //var_dump('EASY');
    $str_store_record_conf        = 'pid=###CURRENT_PID###';
}
  // Store record configuration
  // Configuration of the extension manager



  ////////////////////////////////////////////////////////////////////////////
  // 
  // Enables the Include Static Templates

  // Case $llStatic
switch(true) {
  case($llStatic == 'de'):
      // German
    t3lib_extMgm::addStaticFile($_EXTKEY,'static/base/',                  'Org +ESAB: Basis (immer einbinden!)' );
    t3lib_extMgm::addStaticFile($_EXTKEY,'static/views/46476/',           'Org +ESAB: Views (immer einbinden!)' );
    t3lib_extMgm::addStaticFile($_EXTKEY,'static/base/css/',              'Org +ESAB: +CSS' );
//    t3lib_extMgm::addStaticFile($_EXTKEY,'static/calendar/201/',          'Org +ESAB: Kalender');
//    t3lib_extMgm::addStaticFile($_EXTKEY,'static/calendar/201/expired/',  'Org +ESAB: +Kalender Archiv');
////    t3lib_extMgm::addStaticFile($_EXTKEY,'static/calendar/211/',          'Org +ESAB: Kalender - Rand');
//    switch( true )
//    {
//      case( $typo3Version < 4007000 ):
//        t3lib_extMgm::addStaticFile($_EXTKEY,'static/base/typo3/4.6/',    'Org +ESAB: +Basis fuer TYPO3 < 4.7 (einbinden!)');
//        break;
//      default:
//        t3lib_extMgm::addStaticFile($_EXTKEY,'static/base/typo3/4.6/',    'Org +ESAB: +Basis fuer TYPO3 < 4.7 (NICHT einbinden!)');
//        break;
//    }
    break;
  default:
      // English
    t3lib_extMgm::addStaticFile($_EXTKEY,'static/base/',                  'Org +ESAB: Basis (obligate!)' );
    t3lib_extMgm::addStaticFile($_EXTKEY,'static/views/46476/',           'Org +ESAB: Views (obligate!)' );
    t3lib_extMgm::addStaticFile($_EXTKEY,'static/base/css/',              'Org +ESAB: +CSS' );
//    t3lib_extMgm::addStaticFile($_EXTKEY,'static/calendar/201/',          'Org +ESAB: Calendar');
//    t3lib_extMgm::addStaticFile($_EXTKEY,'static/calendar/201/expired/',  'Org +ESAB: +Calendar expired');
//    t3lib_extMgm::addStaticFile($_EXTKEY,'static/calendar/211/',          'Org +ESAB: Calendar - Margin');
//    t3lib_extMgm::addStaticFile($_EXTKEY,'static/esab/46476/',            'Org +ESAB: Esab');
//    switch( true )
//    {
//      case( $typo3Version < 4007000 ):
//        t3lib_extMgm::addStaticFile($_EXTKEY,'static/base/typo3/4.6/',    'Org +ESAB: +Basis for TYPO3 < 4.7 (obligate!)');
//        break;
//      default:
//        t3lib_extMgm::addStaticFile($_EXTKEY,'static/base/typo3/4.6/',    'Org +ESAB: +Basis for TYPO3 < 4.7 (don\'t use it!)');
//        break;
//    }
}
  // Case $llStatic
  // Enables the Include Static Templates



  ////////////////////////////////////////////////////////////////////////////
  // 
  // Add pagetree icons

  // Case $llStatic
switch(true) {
  case($llStatic == 'de'):
      // German
    $TCA['pages']['columns']['module']['config']['items'][] = 
       array('Org: Esab', 'org_reptr', t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/esab.gif');
    break;
  default:
      // English
    $TCA['pages']['columns']['module']['config']['items'][] = 
       array('Org: Esab', 'org_reptr', t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/esab.gif');
}
  // Case $llStatic

  //  @see #34858, 120719, uherrmann
t3lib_SpriteManager::addTcaTypeIcon('pages', 'contains-org_reptr',
         t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon/esab.gif');

  // Add pagetree icons



  /////////////////////////////////////////////////
  //
  // Add default page and user TSconfig

t3lib_extMgm::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $_EXTKEY . '/tsConfig/' . $llStatic . '/page.txt">');
  // Add default page and user TSconfig



  ////////////////////////////////////////////////////////////////////////////
  // 
  // Configure third party tables
  
  // draft field tx_orgesab
  // tx_org_cal

  // draft field tx_orgesab
$arr_tx_orgesab = array (
  'exclude' => $bool_exclude_default,
  'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab',
  'config'  => array (
    'type'     => 'select', 
    'size'     =>  30, 
    'minitems' =>   0,
    'maxitems' =>   1,
    'MM'                  => '%MM%',
    'MM_opposite_field'   => '%MM_opposite_field%',
    'foreign_table'       => 'tx_orgesab',
    'foreign_table_where' => 'AND tx_orgesab.' . $str_store_record_conf . ' ORDER BY tx_orgesab.title',
    'wizards' => array(
      '_PADDING'  => 2,
      '_VERTICAL' => 0,
      'add' => array(
        'type'   => 'script',
        'title'  => 'LLL:EXT:orgesab/locallang_db.xml:wizard.tx_orgesab.add',
        'icon'   => 'add.gif',
        'params' => array(
          'table'    => 'tx_orgesab',
          'pid'      => $str_marker_pid,
          'setValue' => 'prepend'
        ),
        'script' => 'wizard_add.php',
      ),
      'list' => array(
        'type'   => 'script',
        'title'  => 'LLL:EXT:orgesab/locallang_db.xml:wizard.tx_orgesab.list',
        'icon'   => 'list.gif',
        'params' => array(
          'table'   => 'tx_orgesab',
          'pid'     => $str_marker_pid,
        ),
        'script' => 'wizard_list.php',
      ),
      'edit' => array(
        'type'                      => 'popup',
        'title'                     => 'LLL:EXT:orgesab/locallang_db.xml:wizard.tx_orgesab.edit',
        'script'                    => 'wizard_edit.php',
        'popup_onlyOpenIfSelected'  => 1,
        'icon'                      => 'edit2.gif',
        'JSopenParams'              => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
      ),
    ),
  ),
);
  // draft field tx_orgesab

  // tx_org_cal
t3lib_div::loadTCA('tx_org_cal');

  // typeicons: Add type_icon
$TCA['tx_org_cal']['ctrl']['typeicons']['tx_orgesab'] = 
  '../typo3conf/ext/orgesab/ext_icon/esab.gif';
  // typeicons: Add type_icon

  // showRecordFieldList: Add field tx_orgesab
$showRecordFieldList = $TCA['tx_org_cal']['interface']['showRecordFieldList'];
$showRecordFieldList = $showRecordFieldList.',tx_orgesab';
$TCA['tx_org_cal']['interface']['showRecordFieldList'] = $showRecordFieldList;
  // showRecordFieldList: Add field tx_orgesab

  // columns: Add field tx_orgesab
$TCA['tx_org_cal']['columns']['tx_orgesab']                                =
  $arr_tx_orgesab;
$TCA['tx_org_cal']['columns']['tx_orgesab']['label']                       =
  'LLL:EXT:orgesab/locallang_db.xml:tx_org_cal.tx_orgesab';
$TCA['tx_org_cal']['columns']['tx_orgesab']['config']['MM']                =
  'tx_orgesab_mm_tx_org_cal';
$TCA['tx_org_cal']['columns']['tx_orgesab']['config']['MM_opposite_field'] =
  'tx_org_cal';

if($bool_wizards_wo_add_and_list)
{
  unset($TCA['tx_org_cal']['columns']['tx_orgesab']['config']['wizards']['add']);
  unset($TCA['tx_org_cal']['columns']['tx_orgesab']['config']['wizards']['list']);
}
  // columns: Add field tx_orgesab

  // columns: extend type
$TCA['tx_org_cal']['columns']['type']['config']['items']['tx_orgesab'] = array
(
  '0' => 'LLL:EXT:orgesab/locallang_db.xml:tx_org_cal.type.tx_orgesab',
  '1' => 'tx_orgesab',
  '2' => 'EXT:orgesab/ext_icon/esab.gif',
);
  // columns: extend type

  // Insert type [esab] with fields to TCAtypes
$TCA['tx_org_cal']['types']['tx_orgesab']['showitem'] = 
  '--div--;LLL:EXT:org/locallang_db.xml:tx_org_cal.div_calendar,    type,title,datetime,tx_org_caltype,tx_orgesab,'.
  '--div--;LLL:EXT:org/locallang_db.xml:tx_org_cal.div_event,       tx_org_location,tx_org_calentrance,'.
  '--div--;LLL:EXT:org/locallang_db.xml:tx_org_cal.div_department,  tx_org_department,'.
  '--div--;LLL:EXT:org/locallang_db.xml:tx_org_cal.div_control,     hidden;;1;;,fe_group'.
  ''
;
//$TCA['tx_org_cal']['types']['tx_orgesab']['showitem'] = '
//    --div--;LLL:EXT:org/locallang_db.xml:tx_org_cal.div_calendar
//    ,title
//    ,type
//    ,tx_orgesab
//    ,'
//;

  // Insert div [esab] with fields to TCAtypes
  // tx_org_cal
  // Configure third party tables



  ////////////////////////////////////////////////////////////////////////////
  // 
  // TCA tables

  // esab ///////////////////////////////////////////////////////////////////
$TCA['tx_orgesab'] = array (
  'ctrl' => array (
    'title'             => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab',
    'label'             => 'title',
    'tstamp'            => 'tstamp',
    'crdate'            => 'crdate',
    'cruser_id'         => 'cruser_id',
    'default_sortby'    => 'ORDER BY title',
    'delete'            => 'deleted',
    'enablecolumns'     => array (
      'disabled'  => 'hidden',
      'fe_group'  => 'fe_group',
    ),
    'readOnly'          => $confArr['databaseReadonly'],
    'dividers2tabs'     => true,
    'hideAtCopy'        => false,
    'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
    'thumbnail'         => 'image',
    'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/esab.gif',
  ),
);

$TCA['tx_orgesab_cat'] = array (
  'ctrl' => array (
    'title'             => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab_cat',
    'label'             => 'title',
    'tstamp'            => 'tstamp',
    'crdate'            => 'crdate',
    'cruser_id'         => 'cruser_id',
    'default_sortby'    => 'ORDER BY title',
    'delete'            => 'deleted',
    'enablecolumns'     => array (
      'disabled'  => 'hidden',
    ),
    'readOnly'          => $confArr['databaseReadonly'],
    'dividers2tabs'     => true,
    'hideAtCopy'        => false,
    'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
    'thumbnail'         => 'image',
    'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/esab.gif',
    'treeParentField'   => 'uid_parent',
  ),
);
  // esab ///////////////////////////////////////////////////////////////////

  // TCA tables //////////////////////////////////////////////////////////////

?>