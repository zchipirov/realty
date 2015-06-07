# Host: localhost  (Version: 5.5.23)
# Date: 2015-06-07 23:46:57
# Generator: MySQL-Front 5.3  (Build 4.198)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "admin"
#

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) DEFAULT NULL,
  `passwd` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

#
# Data for table "admin"
#

INSERT INTO `admin` VALUES (1,'admin1','admin'),(2,'admin2','123123'),(3,'admin3','123123'),(5,'admin4','admin'),(6,'admin51','123123');

#
# Structure for table "objects"
#

DROP TABLE IF EXISTS `objects`;
CREATE TABLE `objects` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `stype` int(11) unsigned DEFAULT NULL COMMENT '0 - квартира, 1 - комната, 2 - дача, 3 - дом, 4 - гараж, 5 - земельный участок',
  `status` int(11) unsigned DEFAULT NULL COMMENT '0 - новостройка, 1 - вторичка, 2 - другое',
  `title` varchar(255) DEFAULT NULL COMMENT 'заголовок',
  `sdesc` text COMMENT 'описание',
  `price` int(11) unsigned DEFAULT NULL,
  `soption` int(11) unsigned DEFAULT NULL COMMENT '0 - аренда в сутки, 1 - аренда в месяц, 2 - продажа',
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `dt` datetime DEFAULT NULL,
  `area` int(11) DEFAULT NULL COMMENT 'площадь',
  `rooms` int(11) DEFAULT NULL COMMENT 'количество комнат',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

#
# Data for table "objects"
#

INSERT INTO `objects` VALUES (6,0,0,'Новое объявление1','123123',3500000,2,'89188275398','ул. Владикавказская, д. 35','2015-06-07 20:06:20',280,5),(7,0,0,'Новое объявление12','123123',3500000,2,'89188275398','ул. Владикавказская, д. 35','2015-06-07 20:06:26',280,5),(11,0,0,'Новое объявление12','123123',3500000,2,'89188275398','ул. Владикавказская, д. 35','2015-06-07 21:06:47',280,5);

#
# Structure for table "photo"
#

DROP TABLE IF EXISTS `photo`;
CREATE TABLE `photo` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Idobject` int(11) unsigned DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "photo"
#

