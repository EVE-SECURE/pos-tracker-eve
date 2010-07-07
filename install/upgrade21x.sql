ALTER TABLE `%prefix%silo_info` ADD `silo_link` INT( 11 ) NOT NULL DEFAULT '0';
ALTER TABLE `%prefix%tower_info` ADD `onlineSince` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
DROP TABLE IF EXISTS `%prefix%module_vars`;
CREATE TABLE `%prefix%module_vars` (`id` int(11) unsigned NOT NULL auto_increment,`active` tinyint(1) NOT NULL default '0',`modname` varchar(64) NOT NULL default '',`name` varchar(64) NOT NULL default '',`value` longtext,PRIMARY KEY  (`id`),KEY `modname` (`modname`),KEY `name` (`name`)) ENGINE=MyISAM;
ALTER TABLE `%prefix%tower_info` CHANGE `outpost_name` `outpost_id` BIGINT( 20 ) NOT NULL DEFAULT '0';