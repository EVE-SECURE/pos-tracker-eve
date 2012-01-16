ALTER TABLE `%prefix%tower_info` ADD `fuelblock` INT( 10 ) unsigned NOT NULL;
ALTER TABLE `%prefix%update_log` ADD INDEX ( `type_id` );

INSERT INTO `%prefix%settings` (`id`, `name`, `gsetting`) VALUES ('4', 'API Proxy', '0');
INSERT INTO `%prefix%prices` (`typeID`, `Name`, `Value`) VALUES ('4247', 'Amarr Fuel Block', '0.00'), ('4051', 'Caldari Fuel Block', '0.00'), ('4312', 'Gallente Fuel Block', '0.00'), ('4246', 'Minmatar Fuel Block', '0.00');
INSERT INTO `%prefix%invTypes` VALUES ('4051', '1136', 'Caldari Fuel Block', null, '0', '0', '5', '0', '40', null, '95.0000', '1', '1413', '0', '10834');
INSERT INTO `%prefix%invTypes` VALUES ('4247', '1136', 'Amarr Fuel Block', null, '0', '0', '5', '0', '40', null, '95.0000', '1', '1413', '0', '10835');
INSERT INTO `%prefix%invTypes` VALUES ('4312', '1136', 'Gallente Fuel Block', null, '0', '0', '5', '0', '40', null, '95.0000', '1', '1413', '0', '10833');
INSERT INTO `%prefix%invTypes` VALUES ('4246', '1136', 'Minmatar Fuel Block', null, '0', '0', '5', '0', '40', null, '95.0000', '1', '1413', '0', '10836');
INSERT INTO `%prefix%invTypes` VALUES ('4314', '1137', 'Caldari Fuel Block Blueprint', null, '0', '0', '0.01', '0', '1', '1', '10000000', '1', '1412', '0', '10834');
INSERT INTO `%prefix%invTypes` VALUES ('4315', '1137', 'Amarr Fuel Block Blueprint', null, '0', '0', '0.01', '0', '1', '4', '10000000', '1', '1412', '0', '10835');
INSERT INTO `%prefix%invTypes` VALUES ('4313', '1137', 'Gallente Fuel Block Blueprint', null, '0', '0', '0.01', '0', '1', '8', '10000000', '1', '1412', '0', '10833');
INSERT INTO `%prefix%invTypes` VALUES ('4316', '1137', 'Minmatar Fuel Block Blueprint', null, '0', '0', '0.01', '0', '1', '2', '10000000', '1', '1412', '0', '10836');
INSERT INTO `%prefix%invTypes` VALUES ('3962', '1106', 'Customs Office Gantry', '2945', '1857', '1000000', '7600', '19500001', '1', null, '0', '1', '1410', '0', null);
INSERT INTO `%prefix%invTypes` VALUES ('3963', '1048', 'Customs Office Gantry Blueprint', null, '0', '0', '0.01', '0', '1', null, '25000001', '1', null, '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `%prefix%tower_fbstatic`
--

CREATE TABLE IF NOT EXISTS `%prefix%tower_fbstatic` (
  `typeID` bigint(20) NOT NULL,
  `typeName` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `pos_race` tinyint(3) NOT NULL DEFAULT '0',
  `pos_size` tinyint(3) NOT NULL DEFAULT '0',
  `race_isotope` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `pg` int(10) NOT NULL DEFAULT '0',
  `cpu` int(10) NOT NULL DEFAULT '0',
  `fuel_hangar` int(10) NOT NULL DEFAULT '0',
  `strontium_hangar` int(10) NOT NULL DEFAULT '0',
  `strontium` int(10) NOT NULL DEFAULT '0',
  `fuelblockID` int(10) NOT NULL,
  `fuelblock` int(10) NOT NULL,
  PRIMARY KEY (`typeID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `%prefix%tower_fbstatic`
--

INSERT INTO `%prefix%tower_fbstatic` (`typeID`, `typeName`, `pos_race`, `pos_size`, `race_isotope`, `pg`, `cpu`, `fuel_hangar`, `strontium_hangar`, `strontium`, `fuelblockID`, `fuelblock`) VALUES
(12235, 'Amarr Control Tower', 1, 3, 'Helium', 5000000, 5500, 140000, 50000, 400, 4247, 40),
(20059, 'Amarr Control Tower Medium', 1, 2, 'Helium', 2500000, 2750, 70000, 25000, 200, 4247, 20),
(20060, 'Amarr Control Tower Small', 1, 1, 'Helium', 1250000, 1375, 35000, 12500, 100, 4247, 10),
(27539, 'Angel Control Tower', 5, 3, 'Hydrogen', 4375000, 6000, 140000, 50000, 400, 4246, 36),
(27607, 'Angel Control Tower Medium', 5, 2, 'Hydrogen', 2187500, 3000, 70000, 25000, 200, 4246, 18),
(27610, 'Angel Control Tower Small', 5, 1, 'Hydrogen', 1093750, 1500, 35000, 12500, 100, 4246, 9),
(27530, 'Blood Control Tower', 6, 3, 'Helium', 5000000, 5500, 140000, 50000, 400, 4247, 36),
(27589, 'Blood Control Tower Medium', 6, 2, 'Helium', 2500000, 2750, 70000, 25000, 200, 4247, 18),
(27592, 'Blood Control Tower Small', 6, 1, 'Helium', 1250000, 1375, 35000, 12500, 100, 4247, 9),
(16213, 'Caldari Control Tower', 2, 3, 'Nitrogen', 2750000, 7500, 140000, 50000, 400, 4051, 40),
(20061, 'Caldari Control Tower Medium', 2, 2, 'Nitrogen', 1375000, 3750, 70000, 25000, 200, 4051, 20),
(20062, 'Caldari Control Tower Small', 2, 1, 'Nitrogen', 687500, 1875, 35000, 12500, 100, 4051, 10),
(27532, 'Dark Blood Control Tower', 7, 3, 'Helium', 5000000, 5500, 140000, 50000, 400, 4247, 32),
(27591, 'Dark Blood Control Tower Medium', 7, 2, 'Helium', 2500000, 2750, 70000, 25000, 200, 4247, 16),
(27594, 'Dark Blood Control Tower Small', 7, 1, 'Helium', 1250000, 1375, 35000, 12500, 100, 4247, 8),
(27540, 'Domination Control Tower', 8, 3, 'Hydrogen', 4375000, 6000, 140000, 50000, 400, 4246, 32),
(27609, 'Domination Control Tower Medium', 8, 2, 'Hydrogen', 2187500, 3000, 70000, 25000, 200, 4246, 16),
(27612, 'Domination Control Tower Small', 8, 1, 'Hydrogen', 1093750, 1500, 35000, 12500, 100, 4246, 8),
(27535, 'Dread Guristas Control Tower', 9, 3, 'Nitrogen', 2750000, 7500, 140000, 50000, 400, 4051, 32),
(27597, 'Dread Guristas Control Tower Medium', 9, 2, 'Nitrogen', 1375000, 3750, 70000, 25000, 200, 4051, 16),
(27600, 'Dread Guristas Control Tower Small', 9, 1, 'Nitrogen', 687500, 1875, 35000, 12500, 100, 4051, 8),
(12236, 'Gallente Control Tower', 3, 3, 'Oxygen', 3750000, 6750, 140000, 50000, 400, 4312, 40),
(20063, 'Gallente Control Tower Medium', 3, 2, 'Oxygen', 1875000, 3375, 70000, 25000, 200, 4312, 20),
(20064, 'Gallente Control Tower Small', 3, 1, 'Oxygen', 937500, 1688, 35000, 12500, 100, 4312, 10),
(27533, 'Guristas Control Tower', 10, 3, 'Nitrogen', 2750000, 7500, 140000, 50000, 400, 4051, 36),
(27595, 'Guristas Control Tower Medium', 10, 2, 'Nitrogen', 1375000, 3750, 70000, 25000, 200, 4051, 18),
(27598, 'Guristas Control Tower Small', 10, 1, 'Nitrogen', 687500, 1875, 35000, 12500, 100, 4051, 9),
(16214, 'Minmatar Control Tower', 4, 3, 'Hydrogen', 4375000, 6000, 140000, 50000, 400, 4246, 40),
(20065, 'Minmatar Control Tower Medium', 4, 2, 'Hydrogen', 2187500, 3000, 70000, 25000, 200, 4246, 20),
(20066, 'Minmatar Control Tower Small', 4, 1, 'Hydrogen', 1093750, 1500, 35000, 12500, 100, 4246, 10),
(27780, 'Sansha Control Tower', 11, 3, 'Helium', 5000000, 5500, 140000, 50000, 400, 4247, 36),
(27782, 'Sansha Control Tower Medium', 11, 2, 'Helium', 2500000, 2750, 70000, 25000, 200, 4247, 18),
(27784, 'Sansha Control Tower Small', 11, 1, 'Helium', 1250000, 1375, 35000, 12500, 100, 4247, 9),
(27536, 'Serpentis Control Tower', 12, 3, 'Oxygen', 3750000, 6750, 140000, 50000, 400, 4312, 36),
(27601, 'Serpentis Control Tower Medium', 12, 2, 'Oxygen', 1875000, 3375, 70000, 25000, 200, 4312, 18),
(27604, 'Serpentis Control Tower Small', 12, 1, 'Oxygen', 937500, 1688, 35000, 12500, 100, 4312, 9),
(27538, 'Shadow Control Tower', 13, 3, 'Oxygen', 3750000, 6750, 140000, 50000, 400, 4312, 32),
(27603, 'Shadow Control Tower Medium', 13, 2, 'Oxygen', 1875000, 3375, 70000, 25000, 200, 4312, 16),
(27606, 'Shadow Control Tower Small', 13, 1, 'Oxygen', 937500, 1688, 35000, 12500, 100, 4312, 8),
(27786, 'True Sansha Control Tower', 14, 3, 'Helium', 5000000, 5500, 140000, 50000, 400, 4247, 32),
(27788, 'True Sansha Control Tower Medium', 14, 2, 'Helium', 2500000, 2750, 70000, 25000, 200, 4247, 16),
(27790, 'True Sansha Control Tower Small', 14, 1, 'Helium', 1250000, 1375, 35000, 12500, 100, 4247, 8);