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
  // Wizard fe_users
  // Other wizards and config drafts
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
    // Rows of fe_group select box
  $size_fegroup     = 10;
    // General Configuration



  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 
  // Wizard fe_users

  // Wizard for fe_users
  $arr_config_feuser = array(
    'type'                => 'select', 
    'size'                => $size_feuser, 
    'minitems'            => 0,
    'maxitems'            => 999,
    'foreign_table'       => 'fe_users',
    'foreign_table_where' => 'AND fe_users.' . $str_store_record_conf . ' ORDER BY fe_users.last_name',
    'wizards' => array(
      '_PADDING'  => 2,
      '_VERTICAL' => 0,
      'add' => array(
        'type'   => 'script',
        'title'  => 'LLL:EXT:orgesab/locallang_db.xml:wizard.fe_user.add',
        'icon'   => 'add.gif',
        'params' => array(
          'table'    => 'fe_users',
          'pid'      => $str_marker_pid,
          'setValue' => 'prepend'
        ),
        'script' => 'wizard_add.php',
      ),
      'list' => array(
        'type'   => 'script',
        'title'  => 'LLL:EXT:orgesab/locallang_db.xml:wizard.fe_user.list',
        'icon'   => 'list.gif',
        'params' => array(
          'table' => 'fe_users',
          'pid'   => $str_marker_pid,
        ),
        'script' => 'wizard_list.php',
      ),
      'edit' => array(
        'type'                      => 'popup',
        'title'                     => 'LLL:EXT:orgesab/locallang_db.xml:wizard.fe_user.edit',
        'script'                    => 'wizard_edit.php',
        'popup_onlyOpenIfSelected'  => 1,
        'icon'                      => 'edit2.gif',
        'JSopenParams'              => $JSopenParams,
      ),
    ),
  );
  if(!$bool_full_wizardSupport_allTables)
  {
    unset($arr_config_feuser['wizards']['add']);
    unset($arr_config_feuser['wizards']['list']);
  }
  // Wizard for fe_users

  // Wizard fe_users



  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 
  // Other wizards and config drafts

  $conf_file_document = array (
    'type'          => 'group',
    'internal_type' => 'file',
    'allowed'       => '',
    'disallowed'    => 'php,php3', 
    'max_size'      => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'], 
    'uploadfolder'  => 'uploads/tx_org',
    'size'          => 10,
    'minitems'      => 0,
    'maxitems'      => 99,
  );

  $conf_file_image = array (
    'type'          => 'group',
    'internal_type' => 'file',
    'allowed'       => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'], 
    'max_size'      => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'], 
      // Don't change uploads/tx_org!
    'uploadfolder'  => 'uploads/tx_org',
    'show_thumbs'   => 1,
    'size'          => 3,
    'minitems'      => 0,
    'maxitems'      => 20,
  );
  
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
  $conf_text_30_05 = array (
    'type' => 'text',
    'cols' => '30', 
    'rows' => '5',
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
  $conf_fegroup = array (
    'exclude'     => $bool_fegroup_control,
    'l10n_mode'   => 'mergeIfNotBlank',
    'label'       => 'LLL:EXT:lang/locallang_general.php:LGL.fe_group',
    'config'      => array (
      'type'      => 'select',
      'size'      => $size_fegroup,
      'maxitems'  => 20,
      'items' => array (
        array('LLL:EXT:lang/locallang_general.php:LGL.hide_at_login', -1),
        array('LLL:EXT:lang/locallang_general.php:LGL.any_login', -2),
        array('LLL:EXT:lang/locallang_general.php:LGL.usergroups', '--div--')
      ),
      'exclusiveKeys' => '-1,-2',
      'foreign_table' => 'fe_groups'
    )
  );
  $conf_pages = array (
    'label'   => 'LLL:EXT:org/locallang_db.xml:tca_phrase.pages',
    'exclude' => $bool_exclude_none,
    'config'  => array (
      'type'          => 'group',
      'internal_type' => 'db',
      'allowed'       => 'pages',
      'size'          => '10',
      'maxitems'      => '99',
      'minitems'      => '0',
      'show_thumbs'   => '1'
    )
  );
  // Other wizards and config drafts



  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //
  // tx_orgesab - without any localisation support

  // Don't display relations to feuser by default 
$bool_exclude_feuser = true;

$TCA['tx_orgesab'] = array (
  'ctrl' => $TCA['tx_orgesab']['ctrl'],
  'interface' => array (
    'showRecordFieldList' =>  'title,subtitle,producer,length,staff,bodytext,'.
                              'teaser_title,teaser_subtitle,teaser_short,'.
                              'actor,puppeteer,dancer,vocals,musician,video,narrator,'.
                              'director,advisor,assistant,'.
                              'stage_design,tailoring,requisite,garment,makeup,'.
                              'stage_manager,technical_manager,technique,light,sound,'.
                              'otherslabel,others,'.
                              'documents_from_path,documents,documentscaption,documentslayout,documentssize,' .
                              'tx_org_news,'.
                              'image,imagecaption,imageseo,imagewidth,imageheight,imageorient,imagecaption,imagecols,imageborder,imagecaption_position,image_link,image_zoom,image_noRows,image_effects,image_compression,' .
                              'embeddedcode,print,printcaption,printseo,'.
                              'tx_org_cal,'.
                              'hidden,pages,fe_group,'.
                              'keywords,description'
  ),
  'feInterface' => $TCA['tx_orgesab']['feInterface'],
  'columns' => array (
    'title' => array (
      'exclude' => 0,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.title',
      'config'  => $conf_input_30_trimRequired,
    ),
    'subtitle' => array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.subtitle',
      'config'  => $conf_input_30_trim,
    ),
    'producer' => array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.producer',
      'config'  => $conf_input_30_trim,
    ),
    'length' => array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.length',
      'config'  => $conf_input_30_trim,
    ),
    'staff' => array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.staff',
      'config'  => $conf_text_rte,
    ),
    'bodytext' => array (
      'exclude'   => $bool_exclude_default,
      'label'     => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.bodytext',
      'l10n_mode' => 'prefixLangTitle',
      'config'    => $conf_text_rte,
    ),
    'teaser_title' => array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.teaser_title',
      'config'  => $conf_input_30_trim,
    ),
    'teaser_subtitle' => array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.teaser_subtitle',
      'config'  => $conf_input_30_trim,
    ),
    'teaser_short' => array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.teaser_short',
      'config'    => $conf_text_50_10,
    ),
    'actor' => array (
      'exclude' => $bool_exclude_none,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.actor',
      'config'  => $arr_config_feuser,
    ),
    'puppeteer' => array (
      'exclude' => $bool_exclude_none,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.puppeteer',
      'config'  => $arr_config_feuser,
    ),
    'dancer' => array (
      'exclude' => $bool_exclude_none,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.dancer',
      'config'  => $arr_config_feuser,
    ),
    'vocals' => array (
      'exclude' => $bool_exclude_none,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.vocals',
      'config'  => $arr_config_feuser,
    ),
    'musician' => array (
      'exclude' => $bool_exclude_none,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.musician',
      'config'  => $arr_config_feuser,
    ),
    'video' => array (
      'exclude' => $bool_exclude_none,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.video',
      'config'  => $arr_config_feuser,
    ),
    'narrator' => array (
      'exclude' => $bool_exclude_none,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.narrator',
      'config'  => $arr_config_feuser,
    ),
    'director' => array (
      'exclude' => $bool_exclude_none,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.director',
      'config'  => $arr_config_feuser,
    ),
    'advisor' => array (
      'exclude' => $bool_exclude_none,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.advisor',
      'config'  => $arr_config_feuser,
    ),
    'assistant' => array (
      'exclude' => $bool_exclude_none,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.assistant',
      'config'  => $arr_config_feuser,
    ),
    'stage_design' => array (
      'exclude' => $bool_exclude_none,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.stage_design',
      'config'  => $arr_config_feuser,
    ),
    'tailoring' => array (
      'exclude' => $bool_exclude_none,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.tailoring',
      'config'  => $arr_config_feuser,
    ),
    'requisite' => array (
      'exclude' => $bool_exclude_none,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.requisite',
      'config'  => $arr_config_feuser,
    ),
    'garment' => array (
      'exclude' => $bool_exclude_none,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.garment',
      'config'  => $arr_config_feuser,
    ),
    'makeup' => array (
      'exclude' => $bool_exclude_none,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.makeup',
      'config'  => $arr_config_feuser,
    ),
    'stage_manager' => array (
      'exclude' => $bool_exclude_none,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.stage_manager',
      'config'  => $arr_config_feuser,
    ),
    'technical_manager' => array (
      'exclude' => $bool_exclude_none,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.technical_manager',
      'config'  => $arr_config_feuser,
    ),
    'technique' => array (
      'exclude' => $bool_exclude_none,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.technique',
      'config'  => $arr_config_feuser,
    ),
    'light' => array (
      'exclude' => $bool_exclude_none,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.light',
      'config'  => $arr_config_feuser,
    ),
    'sound' => array (
      'exclude' => $bool_exclude_none,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.sound',
      'config'  => $arr_config_feuser,
    ),
    'otherslabel' => array (
      'exclude' => $bool_exclude_none,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.otherslabel',
      'config'  => $conf_input_30_trim,
    ),
    'others' => array (
      'exclude' => $bool_exclude_none,
      'label'   => 'LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.others',
      'config'  => $arr_config_feuser,
    ),
    'documents_from_path' => array(
      'exclude' => $bool_exclude_default,
      'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.code',
      'config' => array(
        'type' => 'input',
        'size' => '50',
        'max' =>  '80',
        'eval' => 'trim',
      ),
    ),
    'documents' => array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:org/locallang_db.xml:tca_phrase.documents',
      'config'  => $conf_file_document,
    ),
    'documentscaption' => array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:org/locallang_db.xml:tca_phrase.documentscaption',
      'config'  => $conf_text_30_05,
    ),
    'documentslayout' => array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:org/locallang_db.xml:tca_phrase.documentslayout',
      'config'  => array (
        'type'      => 'select',
        'size'      => 1,
        'maxitems'  => 1,
        'items' => array (
          array('LLL:EXT:org/locallang_db.xml:tca_phrase.documentslayout.0', 0),
          array('LLL:EXT:org/locallang_db.xml:tca_phrase.documentslayout.1', 1),
          array('LLL:EXT:org/locallang_db.xml:tca_phrase.documentslayout.2', 2),
        ),
      )
    ),
    'documentssize' => array(
      'exclude' => $bool_exclude_default,
      'label' => 'LLL:EXT:cms/locallang_ttc.xml:filelink_size',
      'config' => array(
        'type' => 'check',
        'items' => array (
          '1'     => array(
            '0' => 'LLL:EXT:lang/locallang_core.xml:labels.enabled',
          ),
        ),
      ),
    ),
    'tx_org_news' => array (
      'exclude' => $bool_exclude_none,
      'label'   => 'LLL:EXT:org/locallang_db.xml:tca_phrase.news',
      'config'  => array (
        'type'                => 'select', 
        'size'                => $size_news,
        'minitems'            => 0,
        'maxitems'            => 999,
        'MM'                  => 'tx_orgesab_mm_tx_org_news',
        'foreign_table'       => 'tx_org_news',
        'foreign_table_where' => 'AND tx_org_news.' . $str_store_record_conf . ' ORDER BY tx_org_news.datetime DESC, title',
        'wizards' => array(
          '_PADDING'  => 2,
          '_VERTICAL' => 0,
          'add' => array(
            'type'   => 'script',
            'title'  => 'LLL:EXT:orgesab/locallang_db.xml:wizard.tx_org_news.add',
            'icon'   => 'add.gif',
            'params' => array(
              'table'    => 'tx_org_news',
              'pid'      => $str_marker_pid,
              'setValue' => 'prepend'
            ),
            'script' => 'wizard_add.php',
          ),
          'list' => array(
            'type'   => 'script',
            'title'  => 'LLL:EXT:orgesab/locallang_db.xml:wizard.tx_org_news.list',
            'icon'   => 'list.gif',
            'params' => array(
              'table' => 'tx_org_news',
              'pid'   => $str_marker_pid,
            ),
            'script' => 'wizard_list.php',
          ),
          'edit' => array(
            'type'                      => 'popup',
            'title'                     => 'LLL:EXT:orgesab/locallang_db.xml:wizard.tx_org_news.edit',
            'script'                    => 'wizard_edit.php',
            'popup_onlyOpenIfSelected'  => 1,
            'icon'                      => 'edit2.gif',
            'JSopenParams'              => $JSopenParams,
          ),
        ),
      ),
    ),
    'image' => array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:org/locallang_db.xml:tca_phrase.image',
      'config'  => $conf_file_image,
    ),
    'imagecaption' => array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:org/locallang_db.xml:tca_phrase.imagecaption',
      'config'  => $conf_text_30_05,
    ),
    'imagecaption_position' => array (
      'exclude' => $bool_exclude_none,
      'label' => 'LLL:EXT:cms/locallang_ttc.xml:imagecaption_position',
      'config' => array (
        'type' => 'select',
        'items' => array (
          array('', ''),
          array('LLL:EXT:cms/locallang_ttc.xml:imagecaption_position.I.1', 'center'),
          array('LLL:EXT:cms/locallang_ttc.xml:imagecaption_position.I.2', 'right'),
          array('LLL:EXT:cms/locallang_ttc.xml:imagecaption_position.I.3', 'left')
        ),
        'default' => ''
      )
    ),
    'imageseo' => array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:org/locallang_db.xml:tca_phrase.imageseo',
      'config'  => $conf_text_30_05,
    ),
    'imagewidth' => array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:cms/locallang_ttc.xml:imagewidth',
      'config'  => array (
        'type'      => 'input',
        'size'      => '10',
        'max'       => '10',
        'eval'      => 'trim',
        'checkbox'  => '0',
        'default'   => '160c'
      )
    ),
    'imageheight' => array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:cms/locallang_ttc.xml:imageheight',
      'config'  => array (
        'type'      => 'input',
        'size'      => '10',
        'max'       => '10',
        'eval'      => 'trim',
        'checkbox'  => '0',
        'default'   => '120c'
      )
    ),
    'imageorient' => array (
      'label' => 'LLL:EXT:cms/locallang_ttc.xml:imageorient',
      'config' => array (
        'type' => 'select',
        'items' => array (
          array('LLL:EXT:cms/locallang_ttc.xml:imageorient.I.0', 0, 'selicons/above_center.gif'),
          array('LLL:EXT:cms/locallang_ttc.xml:imageorient.I.1', 1, 'selicons/above_right.gif'),
          array('LLL:EXT:cms/locallang_ttc.xml:imageorient.I.2', 2, 'selicons/above_left.gif'),
          array('LLL:EXT:cms/locallang_ttc.xml:imageorient.I.3', 8, 'selicons/below_center.gif'),
          array('LLL:EXT:cms/locallang_ttc.xml:imageorient.I.4', 9, 'selicons/below_right.gif'),
          array('LLL:EXT:cms/locallang_ttc.xml:imageorient.I.5', 10, 'selicons/below_left.gif'),
          array('LLL:EXT:cms/locallang_ttc.xml:imageorient.I.6', 17, 'selicons/intext_right.gif'),
          array('LLL:EXT:cms/locallang_ttc.xml:imageorient.I.7', 18, 'selicons/intext_left.gif'),
          array('LLL:EXT:cms/locallang_ttc.xml:imageorient.I.8', '--div--'),
          array('LLL:EXT:cms/locallang_ttc.xml:imageorient.I.9', 25, 'selicons/intext_right_nowrap.gif'),
          array('LLL:EXT:cms/locallang_ttc.xml:imageorient.I.10', 26, 'selicons/intext_left_nowrap.gif')
        ),
        'selicon_cols' => 6,
        'default' => '0',
        'iconsInOptionTags' => 1,
      )
    ),
    'imageborder' => array (
      'exclude' => $bool_exclude_none,
      'label' => 'LLL:EXT:cms/locallang_ttc.xml:imageborder',
      'config' => array (
        'type' => 'check'
      )
    ),
    'image_noRows' => array (
      'exclude' => $bool_exclude_none,
      'label' => 'LLL:EXT:cms/locallang_ttc.xml:image_noRows',
      'config' => array (
        'type' => 'check'
      )
    ),
    'image_link' => array (
      'exclude' => $bool_exclude_default,
      'label' => 'LLL:EXT:cms/locallang_ttc.xml:image_link',
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
    'image_zoom' => array (
      'exclude' => $bool_exclude_default,
      'label' => 'LLL:EXT:cms/locallang_ttc.xml:image_zoom',
      'config' => array (
        'type' => 'check'
      )
    ),
    'image_effects' => array (
      'exclude' => $bool_exclude_default,
      'label' => 'LLL:EXT:cms/locallang_ttc.xml:image_effects',
      'config' => array (
        'type' => 'select',
        'items' => array (
          array('LLL:EXT:cms/locallang_ttc.xml:image_effects.I.0', 0),
          array('LLL:EXT:cms/locallang_ttc.xml:image_effects.I.1', 1),
          array('LLL:EXT:cms/locallang_ttc.xml:image_effects.I.2', 2),
          array('LLL:EXT:cms/locallang_ttc.xml:image_effects.I.3', 3),
          array('LLL:EXT:cms/locallang_ttc.xml:image_effects.I.4', 10),
          array('LLL:EXT:cms/locallang_ttc.xml:image_effects.I.5', 11),
          array('LLL:EXT:cms/locallang_ttc.xml:image_effects.I.6', 20),
          array('LLL:EXT:cms/locallang_ttc.xml:image_effects.I.7', 23),
          array('LLL:EXT:cms/locallang_ttc.xml:image_effects.I.8', 25),
          array('LLL:EXT:cms/locallang_ttc.xml:image_effects.I.9', 26)
        )
      )
    ),
    'image_frames' => array (
      'exclude' => $bool_exclude_none,
      'label' => 'LLL:EXT:cms/locallang_ttc.xml:image_frames',
      'config' => array (
        'type' => 'select',
        'items' => array (
          array('LLL:EXT:cms/locallang_ttc.xml:image_frames.I.0', 0),
          array('LLL:EXT:cms/locallang_ttc.xml:image_frames.I.1', 1),
          array('LLL:EXT:cms/locallang_ttc.xml:image_frames.I.2', 2),
          array('LLL:EXT:cms/locallang_ttc.xml:image_frames.I.3', 3),
          array('LLL:EXT:cms/locallang_ttc.xml:image_frames.I.4', 4),
          array('LLL:EXT:cms/locallang_ttc.xml:image_frames.I.5', 5),
          array('LLL:EXT:cms/locallang_ttc.xml:image_frames.I.6', 6),
          array('LLL:EXT:cms/locallang_ttc.xml:image_frames.I.7', 7),
          array('LLL:EXT:cms/locallang_ttc.xml:image_frames.I.8', 8)
        )
      )
    ),
    'image_compression' => array (
      'exclude' => $bool_exclude_none,
      'label' => 'LLL:EXT:cms/locallang_ttc.xml:image_compression',
      'config' => array (
        'type' => 'select',
        'items' => array (
          array('LLL:EXT:lang/locallang_general.php:LGL.default_value', 0),
          array('LLL:EXT:cms/locallang_ttc.xml:image_compression.I.1', 1),
          array('GIF/256', 10),
          array('GIF/128', 11),
          array('GIF/64', 12),
          array('GIF/32', 13),
          array('GIF/16', 14),
          array('GIF/8', 15),
          array('PNG', 39),
          array('PNG/256', 30),
          array('PNG/128', 31),
          array('PNG/64', 32),
          array('PNG/32', 33),
          array('PNG/16', 34),
          array('PNG/8', 35),
          array('LLL:EXT:cms/locallang_ttc.xml:image_compression.I.15', 21),
          array('LLL:EXT:cms/locallang_ttc.xml:image_compression.I.16', 22),
          array('LLL:EXT:cms/locallang_ttc.xml:image_compression.I.17', 24),
          array('LLL:EXT:cms/locallang_ttc.xml:image_compression.I.18', 26),
          array('LLL:EXT:cms/locallang_ttc.xml:image_compression.I.19', 28)
        )
      )
    ),
    'imagecols' => array (
      'exclude' => $bool_exclude_default,
      'label' => 'LLL:EXT:cms/locallang_ttc.xml:imagecols',
      'config' => array (
        'type' => 'select',
        'items' => array (
          array('1', 1),
          array('2', 2),
          array('3', 3),
          array('4', 4),
          array('5', 5),
          array('6', 6),
          array('7', 7),
          array('8', 8)
        ),
        'default' => 1
      )
    ),
    'embeddedcode' => array (
      'label'   => 'LLL:EXT:org/locallang_db.xml:tca_phrase.embeddedcode',
      'exclude' => $bool_exclude_none,
      'config'  => $conf_text_50_10,
    ),
    'print' => array (
      'exclude' => $bool_exclude_none,
      'label'   => 'LLL:EXT:org/locallang_db.xml:tca_phrase.print',
      'config'  => $conf_file_image,
    ),
    'printcaption' => array (
      'exclude' => $bool_exclude_none,
      'label'   => 'LLL:EXT:org/locallang_db.xml:tca_phrase.imagecaption',
      'config'  => $conf_text_30_05,
    ),
    'printseo' => array (
      'exclude' => $bool_exclude_none,
      'label'   => 'LLL:EXT:org/locallang_db.xml:tca_phrase.imageseo',
      'config'  => $conf_text_30_05,
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
    'hidden'    => $conf_hidden,
    'pages'     => $conf_pages,
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
  'types' => array (
    '0' => array('showitem' =>  
      '--div--;LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.div_esab,   title;;;;1-1-1,subtitle,producer,length,staff;;;richtext[]:rte_transform[mode=ts];,bodytext;;;richtext[]:rte_transform[mode=ts];,'.
      '--div--;LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.div_teaser,       teaser_title,teaser_subtitle,teaser_short,'.
      '--div--;LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.div_actors,       actor,puppeteer,dancer,vocals,musician,video,narrator,'.
      '--div--;LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.div_direction,    director,advisor,assistant,'.
      '--div--;LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.div_requirements, stage_design,tailoring,requisite,garment,makeup,'.
      '--div--;LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.div_technique,    stage_manager,technical_manager,technique,light,sound,'.
      '--div--;LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.div_others,       otherslabel,others,'.
      '--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.images,' .
        '--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.imagefiles;imagefiles,' .
        '--palette--;LLL:EXT:org/locallang_db.xml:palette.image_accessibility;image_accessibility,' .
        '--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.imageblock;imageblock,' .
        '--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.imagelinks;imagelinks,' .
        '--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.image_settings;image_settings,' .
      '--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.media,' .
        '--palette--;LLL:EXT:cms/locallang_ttc.xml:media;documents_upload,' .
        '--palette--;LLL:EXT:org/locallang_db.xml:palette.appearance;documents_appearance,' .
      '--div--;LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.div_news,         tx_org_news,'.
      '--div--;LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.div_calendar,     tx_org_cal,'.
      '--div--;LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.div_control,      hidden,pages,fe_group,'.
      '--div--;LLL:EXT:orgesab/locallang_db.xml:tx_orgesab.div_seo,          keywords,description'.
                          ''),
  ),
  'palettes' => array (
     '1'  => array('showitem' => 'starttime,endtime,'),
    'documents_appearance' => array(
      'showitem' => 'documentslayout;LLL:EXT:org/locallang_db.xml:tca_phrase.documentslayout,documentssize;LLL:EXT:cms/locallang_ttc.xml:filelink_size_formlabel',
      'canNotCollapse' => 1,
    ),
    'documents_upload' => array(
      'showitem' => 'documents_from_path;LLL:EXT:org/locallang_db.xml:tca_phrase.documents_from_path, --linebreak--,' .
                    'documents;LLL:EXT:cms/locallang_ttc.xml:media.ALT.uploads_formlabel, documentscaption;LLL:EXT:cms/locallang_ttc.xml:imagecaption.ALT.uploads_formlabel;;nowrap, --linebreak--,',
      'canNotCollapse' => 1,
    ),
    'image_accessibility' => array(
      'showitem' => 'imageseo;LLL:EXT:org/locallang_db.xml:tca_phrase.imageseo,',
      'canNotCollapse' => 1,
    ),
    'imageblock' => array(
      'showitem' => 'imageorient;LLL:EXT:cms/locallang_ttc.xml:imageorient_formlabel, imagecols;LLL:EXT:cms/locallang_ttc.xml:imagecols_formlabel, --linebreak--,' .
                    'image_noRows;LLL:EXT:cms/locallang_ttc.xml:image_noRows_formlabel, imagecaption_position;LLL:EXT:cms/locallang_ttc.xml:imagecaption_position_formlabel',
      'canNotCollapse' => 1,
    ),
    'imagefiles' => array(
      'showitem' => 'image;LLL:EXT:cms/locallang_ttc.xml:image_formlabel, imagecaption;LLL:EXT:cms/locallang_ttc.xml:imagecaption_formlabel,',
      'canNotCollapse' => 1,
    ),
    'imagelinks' => array(
      'showitem' => 'image_zoom;LLL:EXT:cms/locallang_ttc.xml:image_zoom_formlabel, image_link;LLL:EXT:cms/locallang_ttc.xml:image_link_formlabel',
      'canNotCollapse' => 1,
    ),
    'image_settings' => array(
      'showitem' => 'imagewidth;LLL:EXT:cms/locallang_ttc.xml:imagewidth_formlabel, imageheight;LLL:EXT:cms/locallang_ttc.xml:imageheight_formlabel, imageborder;LLL:EXT:cms/locallang_ttc.xml:imageborder_formlabel, --linebreak--,' .
                    'image_compression;LLL:EXT:cms/locallang_ttc.xml:image_compression_formlabel, image_effects;LLL:EXT:cms/locallang_ttc.xml:image_effects_formlabel, image_frames;LLL:EXT:cms/locallang_ttc.xml:image_frames_formlabel',
      'canNotCollapse' => 1,
    ),
  )
);
if(!$bool_full_wizardSupport_allTables)
{
  unset($TCA['tx_orgesab']['columns']['tx_org_cal']['config']['wizards']['add']);
  unset($TCA['tx_orgesab']['columns']['tx_org_cal']['config']['wizards']['list'] );
  unset($TCA['tx_orgesab']['columns']['tx_org_news']['config']['wizards']['add']);
  unset($TCA['tx_orgesab']['columns']['tx_org_news']['config']['wizards']['list'] );
}
  // tx_orgesab - without any localisation support