ALTER TABLE `%prefix%tower_info` CHANGE `outpost_name` `outpost_id` BIGINT( 20 ) NOT NULL DEFAULT '0';
DROP TABLE `%prefix%outpost_update_log`;
DROP TABLE IF EXISTS `%prefix%module_vars`;
CREATE TABLE `%prefix%module_vars` (`id` int(11) unsigned NOT NULL auto_increment,`active` tinyint(1) NOT NULL default '0',`modname` varchar(64) NOT NULL default '',`name` varchar(64) NOT NULL default '',`value` longtext,PRIMARY KEY  (`id`),KEY `modname` (`modname`),KEY `name` (`name`)) ENGINE=MyISAM;
DROP TABLE IF EXISTS `%prefix%modules`;
CREATE TABLE IF NOT EXISTS `%prefix%modules` (
  `modid` int(11) unsigned NOT NULL auto_increment,
  `modname` varchar(64) NOT NULL default '',
  `moddisplayname` varchar(64) NOT NULL default '',
  `moddescription` varchar(255) NOT NULL default '',
  `moddirectory` varchar(64) NOT NULL default '',
  `modversion` varchar(10) NOT NULL default '0',
  `modadmin_capable` tinyint(1) NOT NULL default '0',
  `moduser_capable` tinyint(1) NOT NULL default '0',
  `modstate` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`modid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;