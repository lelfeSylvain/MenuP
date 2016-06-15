<?php

/* 
 * CREATE TABLE IF NOT EXISTS `menu2_repas2` (
  `titm` varchar(100) DEFAULT NULL,
  `ent` varchar(120) DEFAULT NULL,
  `plat` varchar(120) DEFAULT NULL,
  `lait` varchar(70) DEFAULT NULL,
  `des` varchar(120) DEFAULT NULL,
  `type` varchar(7) NOT NULL,
  `annee` int(11) NOT NULL,
  `numsema` smallint(6) NOT NULL,
  `numserv` smallint(6) NOT NULL,
  `urlimage` varchar(90) DEFAULT NULL,
  PRIMARY KEY (`annee`,`numsema`,`numserv`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
 * ENGINE=InnoDB DEFAULT CHARSET=utf8;
 * 
 * mémo de transformation de la BD
 Ajouter une colonne num à menu2_repas : ALTER TABLE `menu2_repas` ADD `num` SMALLINT NOT NULL 
update menu2_repas set num = numserv-1 
modifier la clé de menu2_repas : ALTER TABLE `menu2_repas`
  DROP PRIMARY KEY,
   ADD PRIMARY KEY(
     `annee`,
     `numsema`,
     `num`);
détruire la colonne numserv :ALTER TABLE `menu2_repas` DROP `numserv` 
renommer num en numserv : ALTER TABLE `menu2_repas` CHANGE `num` `numserv` SMALLINT( 6 ) NOT NULL 
recopier les mes2 dans titre 1 occurrence : update menu2_repas set titm = mes2 where type='message' and mes2 is not null AND mes2 <> ""
update menu2_repas set titm = mes1 where type='message'  AND titm is null
détruire mes1 et mes2 :
ALTER TABLE `menu2_repas`   DROP `mes1`;
ALTER TABLE `menu2_repas`   DROP `mes2`;
 * 
 *  enlever les "" : update menu2_repas set titm =null where titm =""
 * update menu2_repas set des3 =null where des3 =""
 * update menu2_repas set des2 =null where des2 =""
 * update menu2_repas set des1 =null where des1 =""
 * update menu2_repas set ent1 =null where ent1 =""
 * update menu2_repas set ent2 =null where ent2 =""
 * update menu2_repas set `plat` =null where `plat` =""
 * update menu2_repas set `lait` =null where `lait` =""
 * update menu2_repas set `urlimage` =null where `urlimage` =""
 * delete from menu2_repas WHERE `titm` IS NULL
AND `ent1` IS NULL
AND `ent2` IS NULL
AND `plat` IS NULL
AND `lait` IS NULL
AND `des1` IS NULL
AND `des2` IS NULL
AND `des3` IS NULL
AND `urlimage` IS NULL
SELECT * FROM `menu2_repas` WHERE ent2 is null and type <> 'message'
 * SELECT * FROM `menu2_repas` WHERE ent2 ='' and type <> 'message'
 * 
 * 
 * 
 */

