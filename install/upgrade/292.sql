ALTER TABLE `%prefix%tower_info` ADD `powergrid` INT( 10 ) UNSIGNED NOT NULL, ADD `cpu` INT( 10 ) UNSIGNED NOT NULL;
ALTER TABLE `%prefix%system_status` DROP `constellationSovereignty`, DROP `sovereigntyLevel`;
ALTER TABLE `%prefix%system_status` ADD `corporationID` INT( 20 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `allianceID`;