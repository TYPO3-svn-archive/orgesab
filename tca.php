<?php

if (!defined ('TYPO3_MODE'))
{
  die ('Access denied.');
}



  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 
  // INDEX
  // -----
  // Configuration by the extension manager
  //    Localization support
  //    Store record configuration
  // General Configuration
  // Wizards and config drafts
  // TCA
  //   tx_orgesab



  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 
  // Configuration by the extension manager

$bool_LL = false;
$confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['orgesab']);

  // Localization support
if (strtolower(substr($confArr['LLsupport'], 0, strlen('yes'))) == 'yes')
{
  $bool_LL = true;
}
  // Localization support

  // Simplify the Organiser
$bool_exclude_none    = true;
$bool_exclude_default = true;
switch ($confArr['TCA_simplify_organiser'])
{
  case('None excluded: Editor has access to all'):
    $bool_exclude_none    = false;
    $bool_exclude_default = false;
    break;
  case('All excluded: Administrator configures it'):
      // All will be left true.
    break;
  case('Default (recommended)'):
    $bool_exclude_default = false;
  default:
}
  // Simplify the Organiser


  // Simplify backend forms
$bool_fegroup_control = true;
if (strtolower(substr($confArr['TCA_simplify_fegroup_control'], 0, strlen('no'))) == 'no')
{
  $bool_fegroup_control = false;
}
$bool_time_control = true;
if (strtolower(substr($confArr['TCA_simplify_time_control'], 0, strlen('no'))) == 'no')
{
  $bool_time_control = false;
}
  // Simplify backend forms

  // Full wizard support
$bool_full_wizardSupport_catTables = true;
if (strtolower(substr($confArr['full_wizardSupport'], 0, strlen('no'))) == 'no')
{
  $bool_full_wizardSupport_catTables = false;
}
  // Full wizard support

  // Store record configuration
$bool_full_wizardSupport_allTables = true;
switch($confArr['store_records']) 
{
  case('Multi grouped: record groups in different directories'):
    $str_store_record_conf              = 'pid IN (###PAGE_TSCONFIG_IDLIST###)';
    $bool_full_wizardSupport_allTables  = false;
    break;
  case('Clear presented: each record group in one directory at most'):
    $str_store_record_conf              = 'pid IN (###PAGE_TSCONFIG_ID###)';
    $bool_full_wizardSupport_allTables  = false;
    break;
  case('Easy 2: same as 1 but with storage pid'):
    $str_marker_pid         = '###STORAGE_PID###';
    $str_store_record_conf  = 'pid=###STORAGE_PID###';
  case('Easy 1: all in the same directory'):
  default:
    $str_marker_pid         = '###CURRENT_PID###';
    $str_store_record_conf  = 'pid=###CURRENT_PID###';
}
  // Store record configuration
  // Configuration by the extension manager



    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 
    // General Configuration
    
    // JSopenParams for all wizards
  $JSopenParams     = 'height=680,width=800,status=0,menubar=0,scrollbars=1';
    // General Configuration



  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 
  // Wizards and config drafts

  $conf_datetime = array (
    'type'    => 'input',
    'size'    => '10',
    'max'     => '20',
    'eval'    => 'datetime',
    'default' => mktime(date('H'),date('i'),0,date('m'),date('d'),date('Y')),
  );
  
  $conf_datetimeend = $conf_datetime;
  unset($conf_datetimeend['default']);

  $conf_input_30_trim = array (
    'type' => 'input',
    'size' => '30',
    'eval' => 'trim'
  );

  $conf_input_30_trimRequired = array (
    'type' => 'input',
    'size' => '30',
    'eval' => 'trim,required'
  );
  
  $conf_input_80_trim = array (
    'type' => 'input',
    'size' => '80',
    'eval' => 'trim'
  );
  $conf_text_50_10 = array (
    'type' => 'text',
    'cols' => '50', 
    'rows' => '10',
  );
  
  $conf_text_rte = array (
    'type' => 'text',
    'cols' => '30',
    'rows' => '5',
    'wizards' => array(
      '_PADDING' => 2,
      'RTE' => array(
        'notNewRecords' => 1,
        'RTEonly'       => 1,
        'type'          => 'script',
        'title'         => 'Full screen Rich Text Editing|Formatteret redigering i hele vinduet',
        'icon'          => 'wizard_rte2.gif',
        'script'        => 'wizard_rte.php',
      ),
    ),
  );

  $conf_hidden = array (
    'exclude' => $bool_exclude_default,
    'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
    'config'  => array (
      'type'    => 'check',
      'default' => '0'
    )
  );
  // Other wizards and config drafts



  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //
  // tx_orgesab - without any localisation support

$TCA['tx_orgesab'] = array (
  'ctrl' => $TCA['tx_orgesab']['ctrl'],
  'interface' => array (
    'showRecordFieldList' => '
        externalid, title,bookedup,bookingurl,eventbegin,eventend,spaceoftime,staff1,staff2,price1,price2,price3,tx_orgesab_cat,bodytext,skills,details,category
      , tx_org_cal
      , tx_orgesab_cat
      , location1,location2,location3,location4,location5
      , day1,day2,day3,day4,day5
      , hours1,hours2,hours3,hours4,hours5
      , hidden,fe_group
      , keywords,description'
  ),
  'feInterface' => $TCA['tx_orgesab']['feInterface'],
  'columns' => array (
    'externalid' => array (
      'exclude' => 0,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.externalid',
      'config'  => $conf_input_30_trimRequired,
    ),
    'title' => array (
      'exclude' => 0,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.title',
      'config'  => $conf_input_30_trimRequired,
    ),
    'bookedup' => array (
      'exclude' => $bool_exclude_none,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.bookedup',
      'config' => array (
        'type' => 'check'
      )
    ),
    'bookingurl' => array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.bookingurl',
      'config' => array (
        'type' => 'text',
        'cols' => '30',
        'rows' => '3',
        'wizards' => array(
          '_PADDING' => 2,
          'link' => array(
            'type' => 'popup',
            'title' => 'Link',
            'icon' => 'link_popup.gif',
            'script' => 'browse_links.php?mode=wizard',
            'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1'
          )
        ),
        'softref' => 'typolink[linkList]'
      )
    ),
    'eventbegin' => array (
      'exclude' => 0,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.eventbegin',
      'config'  => $conf_datetime,
    ),
    'eventend' => array (
      'exclude' => 0,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.eventend',
      'config'  => $conf_datetimeend,
    ),
    'spaceoftime' => array (
      'exclude' => 0,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.spaceoftime',
      'config'  => $conf_input_30_trim,
    ),
    'staff1' => array (
      'exclude' => 0,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.staff1',
      'config'  => $conf_input_30_trim,
    ),
    'staff2' => array (
      'exclude' => 0,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.staff2',
      'config'  => $conf_input_30_trim,
    ),
    'price1' => array (
      'exclude' => 0,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.price1',
      'config'  => $conf_input_30_trim,
    ),
    'price2' => array (
      'exclude' => 0,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.price2',
      'config'  => $conf_input_30_trim,
    ),
    'price3' => array (
      'exclude' => 0,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.price3',
      'config'  => $conf_input_30_trim,
    ),
    'tx_orgesab_cat' => array (
      'exclude'   => $bool_exclude_default,
      'label'     => 'LLL:EXTorgesablocallang_db.xml:tx_orgesab.tx_orgesab_cat',
      'config'    => array (
        'type'                => 'select',
        'size'                => 10,
        'minitems'            => 0,
        'maxitems'            => 99,
        'MM'                  => 'tx_orgesab_mm_tx_orgesab_cat',
        'foreign_table'       => 'tx_orgesab_cat',
//        'foreign_table_where' => 'AND tx_orgesab_cat.' . $str_store_record_conf . ' AND tx_orgesab_cat.deleted = 0 AND tx_orgesab_cat.hidden = 0 ORDER BY tx_orgesab_cat.title',
        'foreign_table_where' => 'AND  tx_orgesab_cat.deleted = 0 AND tx_orgesab_cat.hidden = 0 ORDER BY tx_orgesab_cat.title',
        'form_type'           => 'user',
        'userFunc'            => 'tx_cpstcatree->getTree',
        'treeView'            => 1,
        'expandable'          => 1,
        'expandFirst'         => 0,
        'expandAll'           => 0,
        'wizards' => array (
          '_PADDING'  => 2,
          '_VERTICAL' => 0,
          'add' => array (
            'type'   => 'script',
            'title'  => 'LLL:EXTorgesablocallang_db.xml:wizard.tx_orgesab_cat.add',
            'icon'   => 'add.gif',
            'params' => array (
              'table'    => 'tx_orgesab_cat',
              'pid'      => $str_marker_pid,
              'setValue' => 'prepend'
            ),
            'script' => 'wizard_add.php',
          ),
          'list' => array (
            'type'   => 'script',
            'title'  => 'LLL:EXTorgesablocallang_db.xml:wizard.tx_orgesab_cat.list',
            'icon'   => 'list.gif',
            'params' => array (
              'table' => 'tx_orgesab_cat',
              'pid'   => $str_marker_pid,
            ),
            'script' => 'wizard_list.php',
          ),
          'edit' => array (
            'type'                      => 'popup',
            'title'                     => 'LLL:EXTorgesablocallang_db.xml:wizard.tx_orgesab_cat.edit',
            'script'                    => 'wizard_edit.php',
            'popup_onlyOpenIfSelected'  => 1,
            'icon'                      => 'edit2.gif',
            'JSopenParams'              => $JSopenParams,
          ),
        ),
      ),
    ),
    'bodytext' => array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.bodytext',
      'config'  => $conf_text_rte,
    ),
    'skills' => array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.skills',
      'config'  => $conf_text_50_10,
    ),
    'details' => array (
      'exclude' => 0,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.details',
      'config'  => $conf_text_50_10,
    ),
    'category' => array (
      'exclude' => 0,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.category',
      'config'  => $conf_input_80_trim,
    ),
    'tx_org_cal' => array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.tx_org_cal',
      'config'  => array (
        'type'                => 'select', 
        'size'                => $size_calendar,
        'minitems'            => 0,
        'maxitems'            => 999,
        'MM'                  => 'tx_orgesab_mm_tx_org_cal',
        'foreign_table'       => 'tx_org_cal',
        'foreign_table_where' => 'AND tx_org_cal.' . $str_store_record_conf . ' ORDER BY tx_org_cal.datetime DESC, title',
        'wizards' => array(
          '_PADDING'  => 2,
          '_VERTICAL' => 0,
          'add' => array(
            'type'   => 'script',
            'title'  => 'LLL:EXT:orgesab/locallang_db.xml:wizard.tx_org_cal.add',
            'icon'   => 'add.gif',
            'params' => array(
              'table'    => 'tx_org_cal',
              'pid'      => $str_marker_pid,
              'setValue' => 'prepend'
            ),
            'script' => 'wizard_add.php',
          ),
          'list' => array(
            'type'   => 'script',
            'title'  => 'LLL:EXT:orgesab/locallang_db.xml:wizard.tx_org_cal.list',
            'icon'   => 'list.gif',
            'params' => array(
              'table' => 'tx_org_cal',
              'pid'   => $str_marker_pid,
            ),
            'script' => 'wizard_list.php',
          ),
          'edit' => array(
            'type'                      => 'popup',
            'title'                     => 'LLL:EXT:orgesab/locallang_db.xml:wizard.tx_org_cal.edit',
            'script'                    => 'wizard_edit.php',
            'popup_onlyOpenIfSelected'  => 1,
            'icon'                      => 'edit2.gif',
            'JSopenParams'              => $JSopenParams,
          ),
        ),
      ),
    ),
    'price1' => array (
      'exclude' => 0,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.price1',
      'config'  => $conf_input_80_trim,
    ),
    'price2' => array (
      'exclude' => 0,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.price2',
      'config'  => $conf_input_80_trim,
    ),
    'price3' => array (
      'exclude' => 0,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.price3',
      'config'  => $conf_input_80_trim,
    ),
    'day1' => array (
      'exclude' => 0,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.day1',
      'config'  => $conf_input_80_trim,
    ),
    'day2' => array (
      'exclude' => 0,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.day2',
      'config'  => $conf_input_80_trim,
    ),
    'day3' => array (
      'exclude' => 0,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.day3',
      'config'  => $conf_input_80_trim,
    ),
    'day4' => array (
      'exclude' => 0,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.day4',
      'config'  => $conf_input_80_trim,
    ),
    'day5' => array (
      'exclude' => 0,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.day5',
      'config'  => $conf_input_80_trim,
    ),
    'hours1' => array (
      'exclude' => 0,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.hours1',
      'config'  => $conf_input_80_trim,
    ),
    'hours2' => array (
      'exclude' => 0,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.hours2',
      'config'  => $conf_input_80_trim,
    ),
    'hours3' => array (
      'exclude' => 0,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.hours3',
      'config'  => $conf_input_80_trim,
    ),
    'hours4' => array (
      'exclude' => 0,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.hours4',
      'config'  => $conf_input_80_trim,
    ),
    'hours5' => array (
      'exclude' => 0,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.hours5',
      'config'  => $conf_input_80_trim,
    ),
    'hidden'    => $conf_hidden,
    'fe_group'  => $conf_fegroup,
    'keywords'  => array (
      'label'     => 'LLL:EXT:org/locallang_db.xml:tca_phrase.keywords',
      'l10n_mode' => 'prefixLangTitle',
      'exclude'   => $bool_exclude_default,
      'config'    => $conf_input_80_trim,
    ),
    'description' => array (
      'label'     => 'LLL:EXT:org/locallang_db.xml:tca_phrase.description',
      'l10n_mode' => 'prefixLangTitle',
      'exclude'   => $bool_exclude_default,
      'config'    => $conf_text_50_10,
    ),
  ),
  'types' =>  array 
  (
    '0' =>  array
    (
      'showitem' => '
            --div--;LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.div_event
          , externalid
          , title 
          , bookedup
          , bookingurl
          , eventbegin
          , eventend
          , spaceoftime
          , staff1
          , staff2
          , price1
          , price2
          , price3
          , tx_orgesab_cat
          , details
          , category
          , bodytext;;;richtext[]:rte_transform[mode=ts];
          , skills
          , --div--;LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.div_calendar
          , tx_org_cal
          , --div--;LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.div_location
          , location1
          , location2
          , location3
          , location4
          , location5
          , --div--;LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.div_days
          , day1
          , day2
          , day3
          , day4
          , day5
          , --div--;LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.div_hours
          , hours1
          , hours2
          , hours3
          , hours4
          , hours5
          , --div--;LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.div_control
          , hidden
          ,fe_group
          , --div--;LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.div_seo
          , keywords
          , description' 
        ,
    ),
  ),
  'palettes' => array ( )
);
if( ! $bool_full_wizardSupport_allTables )
{
  unset( $TCA['tx_orgesab']['columns']['tx_org_cal']['config']['wizards']['add']      );
  unset( $TCA['tx_orgesab']['columns']['tx_org_cal']['config']['wizards']['list']     );
  unset( $TCA['tx_orgesab']['columns']['tx_orgesab_cat']['config']['wizards']['add']  );
  unset( $TCA['tx_orgesab']['columns']['tx_orgesab_cat']['config']['wizards']['list'] );
}
  // tx_orgesab - without any localisation support



  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 
  // tx_orgesab_cat
  
$TCA['tx_orgesab_cat'] = array (
  'ctrl' => $TCA['tx_orgesab_cat']['ctrl'],
  'interface' => array (
    'showRecordFieldList' => '
        title
      , uid_parent
      , hidden',
  ),
  'columns' => array (
    'title' => array (
      'exclude' => 0,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab_cat.title',
      'config'  => $conf_input_30_trimRequired,
    ),
    'uid_parent' => array (
      'exclude'   => 0,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab_cat.uid_parent',
      'config'    => array (
        'type'          => 'select',
        'size'          => 1,
        'minitems'      => 0,
        'maxitems'      => 2,
        'trueMaxItems'  => 1,
        'form_type'     => 'user',
        'userFunc'      => 'tx_cpstcatree->getTree',
        'foreign_table' => 'tx_orgesab_cat',
        'treeView'      => 1,
        'expandable'    => 1,
        'expandFirst'   => 0,
        'expandAll'     => 0,
      ),
    ),
    'hidden'    => $conf_hidden,
  ),
  'types' => array
  (
    '0' => array 
    (
      'showitem' => '
          title
        , uid_parent
        , hidden'
    ),
  ),
  'palettes' => array ( ),
);
  // tx_orgesab_cat