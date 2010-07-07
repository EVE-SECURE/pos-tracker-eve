--
-- Table structure for table `pos2_material_static`
--
DROP TABLE IF EXISTS `%prefix%material_static`;
CREATE TABLE `%prefix%material_static` (
  `material_id` int(10) NOT NULL,
  `material_name` varchar(255) collate latin1_general_ci default NULL,
  `material_type` tinyint(3) NOT NULL default '0',
  `material_volume` float NOT NULL default '0',
  PRIMARY KEY  (`material_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Data i tabell `pos3_material_static`
-- 

INSERT INTO `%prefix%material_static` (`material_id`, `material_name`, `material_type`, `material_volume`) VALUES 
(0, 'None', 0, 0),
(16634, 'Atmospheric Gases', 1, 0.2),
(16643, 'Cadmium', 1, 0.4),
(16647, 'Caesium', 1, 0.4),
(16641, 'Chromium', 1, 0.6),
(16640, 'Cobalt', 1, 0.4),
(16650, 'Dysprosium', 1, 1),
(16635, 'Evaporite Deposits', 1, 0.2),
(16648, 'Hafnium', 1, 0.8),
(16633, 'Hydrocarbons', 1, 0.2),
(16646, 'Mercury', 1, 0.8),
(16651, 'Neodymium', 1, 1),
(16644, 'Platinum', 1, 1),
(16652, 'Promethium', 1, 1),
(16639, 'Scandium', 1, 0.4),
(16636, 'Silicates', 1, 0.2),
(16649, 'Technetium', 1, 0.8),
(16653, 'Thulium', 1, 1),
(16638, 'Titanium', 1, 0.4),
(16637, 'Tungsten', 1, 0.4),
(16642, 'Vanadium', 1, 1),
(16663, 'Caesarium Cadmide', 2, 1),
(16659, 'Carbon Polymers', 2, 1),
(16660, 'Ceramic Powder', 2, 1),
(16655, 'Crystallite Alloy', 2, 1),
(16668, 'Dysporite', 2, 1),
(16656, 'Fernite Alloy', 2, 1),
(16669, 'Ferrofluid', 2, 1),
(17769, 'Fluxed Condensates', 2, 1),
(16665, 'Hexite', 2, 1),
(16666, 'Hyperflurite', 2, 1),
(16667, 'Neo Mercurite', 2, 1),
(16662, 'Platinum Technite', 2, 1),
(17960, 'Prometium', 2, 1),
(16657, 'Rolled Tungsten Alloy', 2, 1),
(16658, 'Silicon Diborite', 2, 1),
(16664, 'Solerium', 2, 1),
(16661, 'Sulfuric Acid', 2, 1),
(16654, 'Titanium Chromide', 2, 1),
(17959, 'Vanadium Hafnite', 2, 1),
(16670, 'Crystalline Carbonide', 3, 0.05),
(17317, 'Fermionic Condensates', 3, 1.3),
(16673, 'Fernite Carbide', 3, 0.05),
(16683, 'Ferrogel', 3, 1),
(16679, 'Fullerides', 3, 0.15),
(16682, 'Hypersynaptic Fibers', 3, 0.6),
(16681, 'Nanotransistors', 3, 0.25),
(16680, 'Phenolic Composites', 3, 0.2),
(16678, 'Sylramic Fibers', 3, 0.075),
(16671, 'Titanium Carbide', 3, 0.05),
(16672, 'Tungsten Carbide', 3, 0.05),
(29660, 'Unrefined Dysporite', 2, 1),
(29663, 'Unrefined Ferrofluid', 2, 1),
(29659, 'Unrefined Fluxed Condensates', 2, 1),
(29664, 'Unrefined Hyperflurite', 2, 1),
(29661, 'Unrefined Neo Mercurite', 2, 1),
(29662, 'Unrefined Prometium', 2, 1);

- --------------------------------------------------------

--
-- Table structure for table `pos2_reaction_static`
--
DROP TABLE IF EXISTS `%prefix%reaction_static`;
CREATE TABLE `%prefix%reaction_static` (
  `reaction_id` int(10) NOT NULL,
  `material_id` int(10) NOT NULL,
  `material_produced` int(10) NOT NULL,
  `material1_id` int(10) NOT NULL,
  `material1_required` int(10) NOT NULL,
  `material2_id` int(10) NOT NULL,
  `material2_required` int(10) NOT NULL,
  `material3_id` int(10) NOT NULL,
  `material3_required` int(10) NOT NULL,
  `material4_id` int(10) NOT NULL,
  `material4_required` int(10) NOT NULL,
  PRIMARY KEY  (`reaction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Data i tabell `pos3_reaction_static`
-- 

INSERT INTO `%prefix%reaction_static` (`reaction_id`, `material_id`, `material_produced`, `material1_id`, `material1_required`, `material2_id`, `material2_required`, `material3_id`, `material3_required`, `material4_id`, `material4_required`) VALUES 
(1, 16663, 200, 16643, 100, 16647, 100, 0, 0, 0, 0),
(2, 16659, 200, 16633, 100, 16636, 100, 0, 0, 0, 0),
(3, 16660, 200, 16635, 100, 16636, 100, 0, 0, 0, 0),
(4, 16655, 200, 16640, 100, 16643, 100, 0, 0, 0, 0),
(5, 16668, 200, 16650, 100, 16646, 100, 0, 0, 0, 0),
(6, 16656, 200, 16639, 100, 16642, 100, 0, 0, 0, 0),
(7, 16669, 200, 16648, 100, 16650, 100, 0, 0, 0, 0),
(8, 17769, 200, 16651, 100, 16653, 100, 0, 0, 0, 0),
(9, 16665, 200, 16641, 100, 16644, 100, 0, 0, 0, 0),
(10, 16666, 200, 16642, 100, 16652, 100, 0, 0, 0, 0),
(11, 16667, 200, 16646, 100, 16651, 100, 0, 0, 0, 0),
(12, 16662, 200, 16644, 100, 16649, 100, 0, 0, 0, 0),
(13, 17960, 200, 16643, 100, 16652, 100, 0, 0, 0, 0),
(14, 16657, 200, 16637, 100, 16644, 100, 0, 0, 0, 0),
(15, 16658, 200, 16635, 100, 16636, 100, 0, 0, 0, 0),
(16, 16664, 200, 16641, 100, 16647, 100, 0, 0, 0, 0),
(17, 16661, 200, 16634, 100, 16635, 100, 0, 0, 0, 0),
(18, 16654, 200, 16638, 100, 16641, 100, 0, 0, 0, 0),
(19, 17959, 200, 16642, 100, 16648, 100, 0, 0, 0, 0),
(20, 16670, 10000, 16659, 100, 16655, 100, 0, 0, 0, 0),
(21, 17317, 200, 16663, 100, 17960, 100, 16668, 100, 17769, 100),
(22, 16673, 10000, 16659, 100, 16656, 100, 0, 0, 0, 0),
(23, 16683, 400, 16665, 100, 16666, 100, 17960, 100, 16669, 100),
(24, 16679, 3000, 16659, 100, 16662, 100, 0, 0, 0, 0),
(25, 16682, 750, 17959, 100, 16664, 100, 16668, 100, 0, 0),
(26, 16681, 1500, 16661, 100, 16662, 100, 16667, 100, 0, 0),
(27, 16680, 2200, 16658, 100, 16663, 100, 17959, 100, 0, 0),
(28, 16678, 6000, 16659, 100, 16665, 100, 0, 0, 0, 0),
(29, 16671, 10000, 16658, 100, 16654, 100, 0, 0, 0, 0),
(30, 16672, 10000, 16661, 100, 16657, 100, 0, 0, 0, 0),
(31, 29660, 1, 16643, 100, 16646, 100, 0, 0, 0, 0),
(32, 29661, 1, 16644, 100, 16646, 100, 0, 0, 0, 0),
(33, 29662, 1, 16641, 100, 16643, 100, 0, 0, 0, 0),
(34, 29663, 1, 16643, 100, 16648, 100, 0, 0, 0, 0),
(35, 29664, 1, 16641, 100, 16642, 100, 0, 0, 0, 0),
(36, 29659, 1, 16642, 100, 16644, 100, 0, 0, 0, 0);

UPDATE `%prefix%silo_info` SET `material_id` = '16634' WHERE `material_id` =1;
UPDATE `%prefix%silo_info` SET `material_id` = '16643' WHERE `material_id` =2;
UPDATE `%prefix%silo_info` SET `material_id` = '16647' WHERE `material_id` =3;
UPDATE `%prefix%silo_info` SET `material_id` = '16641' WHERE `material_id` =4;
UPDATE `%prefix%silo_info` SET `material_id` = '16640' WHERE `material_id` =5;
UPDATE `%prefix%silo_info` SET `material_id` = '16650' WHERE `material_id` =6;
UPDATE `%prefix%silo_info` SET `material_id` = '16635' WHERE `material_id` =7;
UPDATE `%prefix%silo_info` SET `material_id` = '16648' WHERE `material_id` =8;
UPDATE `%prefix%silo_info` SET `material_id` = '16633' WHERE `material_id` =9;
UPDATE `%prefix%silo_info` SET `material_id` = '16646' WHERE `material_id` =10;
UPDATE `%prefix%silo_info` SET `material_id` = '16651' WHERE `material_id` =11;
UPDATE `%prefix%silo_info` SET `material_id` = '16644' WHERE `material_id` =12;
UPDATE `%prefix%silo_info` SET `material_id` = '16652' WHERE `material_id` =13;
UPDATE `%prefix%silo_info` SET `material_id` = '16639' WHERE `material_id` =14;
UPDATE `%prefix%silo_info` SET `material_id` = '16636' WHERE `material_id` =15;
UPDATE `%prefix%silo_info` SET `material_id` = '16649' WHERE `material_id` =16;
UPDATE `%prefix%silo_info` SET `material_id` = '16653' WHERE `material_id` =17;
UPDATE `%prefix%silo_info` SET `material_id` = '16638' WHERE `material_id` =18;
UPDATE `%prefix%silo_info` SET `material_id` = '16637' WHERE `material_id` =19;
UPDATE `%prefix%silo_info` SET `material_id` = '16642' WHERE `material_id` =20;
UPDATE `%prefix%silo_info` SET `material_id` = '16663' WHERE `material_id` =21;
UPDATE `%prefix%silo_info` SET `material_id` = '16659' WHERE `material_id` =22;
UPDATE `%prefix%silo_info` SET `material_id` = '16660' WHERE `material_id` =23;
UPDATE `%prefix%silo_info` SET `material_id` = '16655' WHERE `material_id` =24;
UPDATE `%prefix%silo_info` SET `material_id` = '16668' WHERE `material_id` =25;
UPDATE `%prefix%silo_info` SET `material_id` = '16656' WHERE `material_id` =26;
UPDATE `%prefix%silo_info` SET `material_id` = '16669' WHERE `material_id` =27;
UPDATE `%prefix%silo_info` SET `material_id` = '17769' WHERE `material_id` =28;
UPDATE `%prefix%silo_info` SET `material_id` = '16665' WHERE `material_id` =29;
UPDATE `%prefix%silo_info` SET `material_id` = '16666' WHERE `material_id` =30;
UPDATE `%prefix%silo_info` SET `material_id` = '16667' WHERE `material_id` =31;
UPDATE `%prefix%silo_info` SET `material_id` = '16662' WHERE `material_id` =32;
UPDATE `%prefix%silo_info` SET `material_id` = '17960' WHERE `material_id` =33;
UPDATE `%prefix%silo_info` SET `material_id` = '16657' WHERE `material_id` =34;
UPDATE `%prefix%silo_info` SET `material_id` = '16658' WHERE `material_id` =35;
UPDATE `%prefix%silo_info` SET `material_id` = '16664' WHERE `material_id` =36;
UPDATE `%prefix%silo_info` SET `material_id` = '16661' WHERE `material_id` =37;
UPDATE `%prefix%silo_info` SET `material_id` = '16654' WHERE `material_id` =38;
UPDATE `%prefix%silo_info` SET `material_id` = '17959' WHERE `material_id` =39;
UPDATE `%prefix%silo_info` SET `material_id` = '16670' WHERE `material_id` =40;
UPDATE `%prefix%silo_info` SET `material_id` = '17317' WHERE `material_id` =41;
UPDATE `%prefix%silo_info` SET `material_id` = '16673' WHERE `material_id` =42;
UPDATE `%prefix%silo_info` SET `material_id` = '16683' WHERE `material_id` =43;
UPDATE `%prefix%silo_info` SET `material_id` = '16679' WHERE `material_id` =44;
UPDATE `%prefix%silo_info` SET `material_id` = '16682' WHERE `material_id` =45;
UPDATE `%prefix%silo_info` SET `material_id` = '16681' WHERE `material_id` =46;
UPDATE `%prefix%silo_info` SET `material_id` = '16680' WHERE `material_id` =47;
UPDATE `%prefix%silo_info` SET `material_id` = '16678' WHERE `material_id` =48;
UPDATE `%prefix%silo_info` SET `material_id` = '16671' WHERE `material_id` =49;
UPDATE `%prefix%silo_info` SET `material_id` = '16672' WHERE `material_id` =50;




UPDATE `%prefix%reactor_info` SET `material_id` = '16634' WHERE `material_id` =1;
UPDATE `%prefix%reactor_info` SET `material_id` = '16643' WHERE `material_id` =2;
UPDATE `%prefix%reactor_info` SET `material_id` = '16647' WHERE `material_id` =3;
UPDATE `%prefix%reactor_info` SET `material_id` = '16641' WHERE `material_id` =4;
UPDATE `%prefix%reactor_info` SET `material_id` = '16640' WHERE `material_id` =5;
UPDATE `%prefix%reactor_info` SET `material_id` = '16650' WHERE `material_id` =6;
UPDATE `%prefix%reactor_info` SET `material_id` = '16635' WHERE `material_id` =7;
UPDATE `%prefix%reactor_info` SET `material_id` = '16648' WHERE `material_id` =8;
UPDATE `%prefix%reactor_info` SET `material_id` = '16633' WHERE `material_id` =9;
UPDATE `%prefix%reactor_info` SET `material_id` = '16646' WHERE `material_id` =10;
UPDATE `%prefix%reactor_info` SET `material_id` = '16651' WHERE `material_id` =11;
UPDATE `%prefix%reactor_info` SET `material_id` = '16644' WHERE `material_id` =12;
UPDATE `%prefix%reactor_info` SET `material_id` = '16652' WHERE `material_id` =13;
UPDATE `%prefix%reactor_info` SET `material_id` = '16639' WHERE `material_id` =14;
UPDATE `%prefix%reactor_info` SET `material_id` = '16636' WHERE `material_id` =15;
UPDATE `%prefix%reactor_info` SET `material_id` = '16649' WHERE `material_id` =16;
UPDATE `%prefix%reactor_info` SET `material_id` = '16653' WHERE `material_id` =17;
UPDATE `%prefix%reactor_info` SET `material_id` = '16638' WHERE `material_id` =18;
UPDATE `%prefix%reactor_info` SET `material_id` = '16637' WHERE `material_id` =19;
UPDATE `%prefix%reactor_info` SET `material_id` = '16642' WHERE `material_id` =20;
UPDATE `%prefix%reactor_info` SET `material_id` = '16663' WHERE `material_id` =21;
UPDATE `%prefix%reactor_info` SET `material_id` = '16659' WHERE `material_id` =22;
UPDATE `%prefix%reactor_info` SET `material_id` = '16660' WHERE `material_id` =23;
UPDATE `%prefix%reactor_info` SET `material_id` = '16655' WHERE `material_id` =24;
UPDATE `%prefix%reactor_info` SET `material_id` = '16668' WHERE `material_id` =25;
UPDATE `%prefix%reactor_info` SET `material_id` = '16656' WHERE `material_id` =26;
UPDATE `%prefix%reactor_info` SET `material_id` = '16669' WHERE `material_id` =27;
UPDATE `%prefix%reactor_info` SET `material_id` = '17769' WHERE `material_id` =28;
UPDATE `%prefix%reactor_info` SET `material_id` = '16665' WHERE `material_id` =29;
UPDATE `%prefix%reactor_info` SET `material_id` = '16666' WHERE `material_id` =30;
UPDATE `%prefix%reactor_info` SET `material_id` = '16667' WHERE `material_id` =31;
UPDATE `%prefix%reactor_info` SET `material_id` = '16662' WHERE `material_id` =32;
UPDATE `%prefix%reactor_info` SET `material_id` = '17960' WHERE `material_id` =33;
UPDATE `%prefix%reactor_info` SET `material_id` = '16657' WHERE `material_id` =34;
UPDATE `%prefix%reactor_info` SET `material_id` = '16658' WHERE `material_id` =35;
UPDATE `%prefix%reactor_info` SET `material_id` = '16664' WHERE `material_id` =36;
UPDATE `%prefix%reactor_info` SET `material_id` = '16661' WHERE `material_id` =37;
UPDATE `%prefix%reactor_info` SET `material_id` = '16654' WHERE `material_id` =38;
UPDATE `%prefix%reactor_info` SET `material_id` = '17959' WHERE `material_id` =39;
UPDATE `%prefix%reactor_info` SET `material_id` = '16670' WHERE `material_id` =40;
UPDATE `%prefix%reactor_info` SET `material_id` = '17317' WHERE `material_id` =41;
UPDATE `%prefix%reactor_info` SET `material_id` = '16673' WHERE `material_id` =42;
UPDATE `%prefix%reactor_info` SET `material_id` = '16683' WHERE `material_id` =43;
UPDATE `%prefix%reactor_info` SET `material_id` = '16679' WHERE `material_id` =44;
UPDATE `%prefix%reactor_info` SET `material_id` = '16682' WHERE `material_id` =45;
UPDATE `%prefix%reactor_info` SET `material_id` = '16681' WHERE `material_id` =46;
UPDATE `%prefix%reactor_info` SET `material_id` = '16680' WHERE `material_id` =47;
UPDATE `%prefix%reactor_info` SET `material_id` = '16678' WHERE `material_id` =48;
UPDATE `%prefix%reactor_info` SET `material_id` = '16671' WHERE `material_id` =49;
UPDATE `%prefix%reactor_info` SET `material_id` = '16672' WHERE `material_id` =50;