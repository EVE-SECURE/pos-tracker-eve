DROP TABLE IF EXISTS `%prefix%moonmaterials`;
CREATE TABLE `%prefix%moonmaterials` (
 `moonID` int(11) NOT NULL default '0',
 `material_id` int(10) NOT NULL default '0',
 `abundance` tinyint(4) default NULL,
 `notes` varchar(255) default NULL,
 `taken` tinyint(1) default '0',
 `characterID` bigint(20) NOT NULL default '0',
 `datetime` bigint(20) NOT NULL default '0',
 UNIQUE KEY `moonID` (`moonID`,`material_id`),
 KEY `moonID_2` (`moonID`),
 KEY `material_id` (`material_id`)
) ENGINE=MyISAM;
