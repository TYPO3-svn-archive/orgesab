<?php

  //////////////////////////////////
  //
  // TEMPLATE
  
  // Template file for
  // typo3conf/realurl_conf.php


  //////////////////////////////////
  //
  // Default real URL configuration

$TYPO3_CONF_VARS['EXTCONF']['realurl'] = array
(
  '_DEFAULT' => array
  (
    'init' => array
    (
      'respectSimulateStaticURLs' => 0,
      'enableCHashCache'          => 1,
      'appendMissingSlash'        => 'ifNotFile',
      'enableUrlDecodeCache'      => 1,
      'enableUrlEncodeCache'      => 1,
      'reapplyAbsRefPrefix'       => 1,
    ),
    'pagePath' => array
    (
      'type'              => 'user',
      'userFunc'          => 'EXT:realurl/class.tx_realurl_advanced.php:&tx_realurl_advanced->main',
      'spaceCharacter'    => '-',
      'languageGetVar'    => 'L',
      'expireDays'        => 7,
      'rootpage_id'       => 0,
      'firstHitPathCache' => 1,
    ),
    'preVars' => array
    (
      array
      (
        'GETvar'    => 'no_cache',
        'valueMap'  => array
        (
          'nc' => 1,
        ),
        'noMatch' => 'bypass',
      ),
    ),
  ),
);


  //////////////////////////////////
  //
  // Real URL configuration for all pages

$TYPO3_CONF_VARS['EXTCONF']['realurl']['_DEFAULT']['postVarSets'] = array
(
  '_DEFAULT' => array 
  (
    // news: organiser_news
    'news' => array 
    (
      array
      (
        'GETvar' => 'tx_browser_pi1[showUid]',
        'lookUpTable' => array
        (
          'table'               => 'tx_organiser_news',
          'id_field'            => 'uid',
          'alias_field'         => 'title',
          'addWhereClause'      => ' AND NOT deleted AND NOT hidden',
          'useUniqueCache'      => 1,
          'useUniqueCache_conf' => array
          (
            'strtolower'      => 1,
            'spaceCharacter'  => '-',
          ),
        )
      ),
    ),
    'browse' => array 
    (
      array 
      (
        'GETvar' => 'tx_browser_pi1[azTab]',
      ),
      array 
      (
        'GETvar' => 'tx_browser_pi1[pointer]',
      ),
    ),
    'sort' => array 
    (
      array 
      (
        'GETvar' => 'tx_browser_pi1[sort]',
      ),
    ),
    'suche' => array 
    (
      array 
      (
        'GETvar' => 'tx_browser_pi1[sword]',
      ),
    ),
  ),
);

?>
