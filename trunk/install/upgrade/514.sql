DROP TABLE IF EXISTS `%prefix%prices`;
CREATE TABLE IF NOT EXISTS `%prefix%prices` (
  `typeID` int(11) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `Value` decimal(20,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`typeID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `%prefix%prices` (`typeID`, `Name`, `Value`) VALUES
(44, 'Enriched Uranium', 5996.68),
(3683, 'Oxygen', 121.30),
(3689, 'Mechanical Parts', 5743.42),
(9832, 'Coolant', 4944.39),
(9848, 'Robotics', 41513.87),
(16274, 'Helium Isotopes', 569.46),
(17889, 'Hydrogen Isotopes', 651.37),
(17887, 'Oxygen Isotopes', 580.97),
(17888, 'Nitrogen Isotopes', 548.46),
(16273, 'Liquid Ozone', 334.61),
(16272, 'Heavy Water', 24.71);

INSERT INTO `%prefix%invTypes` (`typeID`, `groupID`, `typeName`, `graphicID`, `radius`, `mass`, `volume`, `capacity`, `portionSize`, `raceID`, `basePrice`, `published`, `marketGroupID`, `chanceOfDuplicating`, `iconID`) VALUES 
(3514, 659, 'Revenant', 10038, 2840, 1546875000, 62000000, 1405, 1, 32, 12349014100, 1, 1392, 0.07, NULL),
(3515, 1013, 'Revenant Blueprint', 309, 0, 0, 0.01, 0, 1, NULL, 18500000000, 1, NULL, 0, NULL);

ALTER TABLE `%prefix%user` ADD `user_track` VARCHAR( 10 ) NOT NULL DEFAULT '0';

CREATE TABLE IF NOT EXISTS `%prefix%settings` (
  `id` int(3) NOT NULL,
  `name` varchar(40) NOT NULL,
  `gsetting` int(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;