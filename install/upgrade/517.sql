INSERT INTO `%prefix%structure_static` (`id`, `name`, `pg`, `cpu`) VALUES (32245, 'Hyasyoda Mobile Laboratory', 110000, 600);

UPDATE `%prefix%moonsinstalled` set `regionName`=concat(regionName ,' R' , right(`regionID`,2)) WHERE `regionName` = 'Unknown';

UPDATE `%prefix%mapregions` set `regionName`=concat(regionName ,' R' , right(`regionID`,2)) WHERE `regionName` = 'Unknown';

UPDATE `%prefix%mapconstellations` set `constellationName`=concat(constellationName ,' C' , right(`constellationID`,3)) WHERE `constellationName` = 'Unknown';

UPDATE `%prefix%evemoons` set moonName=REPLACE(moonName,"Uncharted Planet",`systemName`) WHERE `moonName` like 'Uncharted%';