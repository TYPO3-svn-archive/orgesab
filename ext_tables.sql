# INDEX
# -----
# tx_orgesab
# tx_orgesab_mm_tx_org_cal
# tx_orgesab_mm_tx_org_headquarters
# tx_orgesab_mm_tx_org_news

# fe_users
# tx_org_tx_org_cal
# tx_org_tx_org_headquarters
# tx_org_tx_org_news



#
# Table structure for table 'tx_orgesab'
#
CREATE TABLE tx_orgesab (
  uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
  pid int(11) unsigned DEFAULT '0' NOT NULL,
  tstamp int(11) unsigned DEFAULT '0' NOT NULL,
  crdate int(11) unsigned DEFAULT '0' NOT NULL,
  cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
  deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
  title tinytext,
  subtitle tinytext,
  producer tinytext,
  length tinytext,
  staff mediumtext,
  teaser_title tinytext,
  teaser_subtitle tinytext,
  teaser_short mediumtext,
  bodytext mediumtext NOT NULL,
  actor tinytext,
  puppeteer tinytext,
  dancer tinytext,
  vocals tinytext,
  musician tinytext,
  video tinytext,
  narrator tinytext,
  director tinytext,
  advisor tinytext,
  assistant tinytext,
  stage_design tinytext,
  tailoring tinytext,
  requisite tinytext,
  garment tinytext,
  makeup tinytext,
  stage_manager tinytext,
  technical_manager tinytext,
  technique tinytext,
  light tinytext,
  sound tinytext,
  otherslabel tinytext,
  others tinytext,
  documents_from_path tinytext,
  documents text,
  documentscaption tinytext,
  documentslayout tinyint(4) unsigned DEFAULT '0' NOT NULL,
  documentssize tinyint(4) unsigned DEFAULT '0' NOT NULL,
  tx_org_news text,
  image text,
  imagecaption text,
  imageseo text,
  imageheight tinytext,
  imagewidth tinytext,
  imageorient tinyint(4) unsigned NOT NULL default '0',
  imagecaption text,
  imagecols tinyint(4) unsigned NOT NULL default '0',
  imageborder tinyint(4) unsigned NOT NULL default '0',
  imagecaption_position varchar(12) default '',
  image_link text,
  image_zoom tinyint(3) unsigned NOT NULL default '0',
  image_noRows tinyint(3) unsigned NOT NULL default '0',
  image_effects tinyint(3) unsigned NOT NULL default '0',
  image_compression tinyint(3) unsigned NOT NULL default '0',
  image_frames tinyint(3) unsigned NOT NULL default '0',
  embeddedcode text,
  print text,
  printcaption text,
  printseo text,
  tx_org_cal tinytext,
  hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
  pages tinytext,
  fe_group int(11) DEFAULT '0' NOT NULL,
  keywords text,
  description text,
  
  PRIMARY KEY (uid),
  KEY parent (pid)
);



#
# Table structure for table 'tx_orgesab_mm_tx_org_cal'
#
CREATE TABLE tx_orgesab_mm_tx_org_cal (
  uid_local int(11) unsigned DEFAULT '0' NOT NULL,
  uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting         int(11) unsigned DEFAULT '0' NOT NULL,
  sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'tx_orgesab_mm_tx_org_headquarters'
#
CREATE TABLE tx_orgesab_mm_tx_org_headquarters (
  uid_local int(11) unsigned DEFAULT '0' NOT NULL,
  uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting         int(11) unsigned DEFAULT '0' NOT NULL,
  sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'tx_orgesab_mm_tx_org_news'
#
CREATE TABLE tx_orgesab_mm_tx_org_news (
  uid_local int(11) unsigned DEFAULT '0' NOT NULL,
  uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting int(11) unsigned DEFAULT '0' NOT NULL,
  sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'fe_users'
#
CREATE TABLE fe_users (
  tx_orgesab tinytext
);



#
# Table structure for table 'tx_org_cal'
#
CREATE TABLE tx_org_cal (
  tx_orgesab tinytext
);



#
# Table structure for table 'tx_org_headquarters'
#
CREATE TABLE tx_org_headquarters (
  tx_orgesab_premium tinytext,
  tx_orgesab tinytext
);



#
# Table structure for table 'tx_org_news'
#
CREATE TABLE tx_org_news (
  tx_orgesab tinytext
);