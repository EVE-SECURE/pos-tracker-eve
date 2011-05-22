UPDATE `%prefix%structure_static` SET `name` = 'X-Large Ship Assembly Array' WHERE `%prefix%structure_static`.`id` =24656;

INSERT INTO `%prefix%structure_static` (`id` ,`name` ,`pg` ,`cpu`) VALUES ('29613', 'Large Ship Assembly Array', '300000', '1000');

CREATE TABLE IF NOT EXISTS `%prefix%prices` (
  `Name` varchar(20) NOT NULL,
  `Value` decimal(20,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`Name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `%prefix%prices` (`Name`, `Value`) VALUES
('Enriched Uranium', 100.00),
('Oxygen', 100.00),
('Mechanical Parts', 100.00),
('Coolant', 100.00),
('Robotics', 100.00),
('Helium Isotopes', 100.00),
('Hydrogen Isotopes', 100.00),
('Nitrogen Isotopes', 100.00),
('Oxygen Isotopes', 100.00),
('Liquid Ozone', 100.00),
('Heavy Water', 100.00);
