/*
MySQL Data Transfer
Source Host: localhost
Source Database: gapro_hela
Target Host: localhost
Target Database: gapro_hela
Date: 05/17/2016 12:04:43 PM
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for salesconfirmation
-- ----------------------------

CREATE TABLE `salesconfirmation` (
  `styleId` bigint(20) NOT NULL DEFAULT '0',
  `bpoNo` varchar(80) NOT NULL DEFAULT '',
  `accmgrconfirm` int(11) DEFAULT NULL,
  `shipconfirm` int(11) DEFAULT NULL,
  `accuserid` int(11) DEFAULT NULL,
  `accmgrconfirmon` datetime DEFAULT NULL,
  `shipuserid` int(11) DEFAULT NULL,
  `shipconfirmon` datetime DEFAULT NULL,
  PRIMARY KEY (`styleId`,`bpoNo`),
  UNIQUE KEY `styleId` (`styleId`),
  UNIQUE KEY `bpoNo` (`bpoNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


