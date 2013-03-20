<?php

########################################################################
# Extension Manager/Repository config file for ext "orgesab".
#
# Auto generated 26-03-2011 01:56
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Org +Esab',
	'description' => 'Extend the Organiser with a esab database!',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '3.0.2',
	'dependencies' => 'org',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'beta',
	'uploadfolder' => 1,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 1,
	'lockType' => '',
	'author' => 'Dirk Wildt (Die Netzmacher)',
	'author_email' => 'http://wildt.at.die-netzmacher.de',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'org' => '3.0.0-3.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'suggests' => array(
	),
	'_md5_values_when_last_written' => 'a:24:{s:9:"ChangeLog";s:4:"7e7c";s:21:"ext_conf_template.txt";s:4:"70bb";s:12:"ext_icon.gif";s:4:"ec42";s:14:"ext_tables.php";s:4:"038a";s:14:"ext_tables.sql";s:4:"b482";s:16:"locallang_db.xml";s:4:"2f6c";s:7:"tca.php";s:4:"5dae";s:23:"ext_icon/esab.gif";s:4:"1dc3";s:42:"lib/class.tx_orgesab_extmanager.php";s:4:"4cf8";s:17:"lib/locallang.xml";s:4:"a968";s:20:"res/realurl_conf.php";s:4:"5203";s:36:"res/html/esab/331/default.tmpl";s:4:"dc7d";s:25:"static/base/constants.txt";s:4:"41fc";s:21:"static/base/setup.txt";s:4:"c0e8";s:33:"static/calendar/201/constants.txt";s:4:"d41d";s:29:"static/calendar/201/setup.txt";s:4:"0151";s:41:"static/calendar/201/expired/constants.txt";s:4:"d41d";s:37:"static/calendar/201/expired/setup.txt";s:4:"adef";s:33:"static/calendar/211/constants.txt";s:4:"d41d";s:29:"static/calendar/211/setup.txt";s:4:"7d21";s:35:"static/esab/331/constants.txt";s:4:"d41d";s:31:"static/esab/331/setup.txt";s:4:"9fd9";s:20:"tsConfig/de/page.txt";s:4:"6526";s:25:"tsConfig/default/page.txt";s:4:"6526";}',
);

?>