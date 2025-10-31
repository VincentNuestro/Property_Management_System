/*
SQLyog Ultimate v11.33 (32 bit)
MySQL - 5.5.39 : Database - gates_smm
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`gates_smm` /*!40100 DEFAULT CHARACTER SET latin1 */;

/*Table structure for table `mall_directory_categories` */

DROP TABLE IF EXISTS `mall_directory_categories`;

CREATE TABLE `mall_directory_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryid` varchar(20) DEFAULT NULL,
  `categoryname` varchar(200) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `dateadded` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `mall_directory_categories` */

insert  into `mall_directory_categories`(`id`,`categoryid`,`categoryname`,`color`,`dateadded`) values (1,'CAT-0000001','Department Stores','rgba(46, 141, 239, 1)','2017-05-25');
insert  into `mall_directory_categories`(`id`,`categoryid`,`categoryname`,`color`,`dateadded`) values (2,'CAT-0000002','Electronics and Entertainment','rgba(0, 160, 177, 1)','2017-05-25');
insert  into `mall_directory_categories`(`id`,`categoryid`,`categoryname`,`color`,`dateadded`) values (3,'CAT-0000003','Fashion','rgba(167, 0, 174, 1)','2017-05-25');
insert  into `mall_directory_categories`(`id`,`categoryid`,`categoryname`,`color`,`dateadded`) values (4,'CAT-0000004','Food','rgba(0, 166, 0, 1)','2017-05-25');
insert  into `mall_directory_categories`(`id`,`categoryid`,`categoryname`,`color`,`dateadded`) values (5,'CAT-0000005','Health and Beauty','rgba(191, 30, 75, 1)','2017-05-25');
insert  into `mall_directory_categories`(`id`,`categoryid`,`categoryname`,`color`,`dateadded`) values (6,'CAT-0000006','Home and Housewares','rgba(220, 87, 46, 1)','2017-05-25');
insert  into `mall_directory_categories`(`id`,`categoryid`,`categoryname`,`color`,`dateadded`) values (7,'CAT-0000007','Personal Services','rgba(100, 62, 191, 1)','2017-05-25');
insert  into `mall_directory_categories`(`id`,`categoryid`,`categoryname`,`color`,`dateadded`) values (8,'CAT-0000008','Shoes','rgba(10, 91, 196, 1)','2017-05-25');
insert  into `mall_directory_categories`(`id`,`categoryid`,`categoryname`,`color`,`dateadded`) values (9,'CAT-0000009','Specialty','rgba(51, 51, 51, 1)','2017-05-25');
insert  into `mall_directory_categories`(`id`,`categoryid`,`categoryname`,`color`,`dateadded`) values (10,'CAT-0000010','Sports and Fitness','rgba(76, 44, 102, 1)','2017-05-25');

/*Table structure for table `mall_directory_floors` */

DROP TABLE IF EXISTS `mall_directory_floors`;

CREATE TABLE `mall_directory_floors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `floorid` varchar(20) DEFAULT NULL,
  `floorname` varchar(200) DEFAULT NULL,
  `width` float DEFAULT NULL,
  `height` float DEFAULT NULL,
  `ext` varchar(20) DEFAULT NULL,
  `dateadded` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `mall_directory_floors` */

insert  into `mall_directory_floors`(`id`,`floorid`,`floorname`,`width`,`height`,`ext`,`dateadded`) values (1,'FLOOR-0000001','1st Floor',1600,1091,'jpg','2017-05-25');
insert  into `mall_directory_floors`(`id`,`floorid`,`floorname`,`width`,`height`,`ext`,`dateadded`) values (3,'FLOOR-0000002','Second Floor',1035,415,'jpg','2017-05-26');
insert  into `mall_directory_floors`(`id`,`floorid`,`floorname`,`width`,`height`,`ext`,`dateadded`) values (4,'FLOOR-0000003','Third Floor',2397,1158,'png','2017-05-26');

/*Table structure for table `mall_directory_other_coordinates` */

DROP TABLE IF EXISTS `mall_directory_other_coordinates`;

CREATE TABLE `mall_directory_other_coordinates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `floorid` varchar(20) DEFAULT NULL,
  `otherid` varchar(20) DEFAULT NULL,
  `coordid` varchar(20) DEFAULT NULL,
  `lat` varchar(100) DEFAULT NULL,
  `lon` varchar(100) DEFAULT NULL,
  `dateadded` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=latin1;

/*Data for the table `mall_directory_other_coordinates` */

insert  into `mall_directory_other_coordinates`(`id`,`floorid`,`otherid`,`coordid`,`lat`,`lon`,`dateadded`) values (1,'FLOOR-0000001','0000001','M-0000001','428.3935546875','631.4375','2017-05-27');
insert  into `mall_directory_other_coordinates`(`id`,`floorid`,`otherid`,`coordid`,`lat`,`lon`,`dateadded`) values (2,'FLOOR-0000001','0000001','M-0000002','270.5810546875','348.625','2017-05-27');
insert  into `mall_directory_other_coordinates`(`id`,`floorid`,`otherid`,`coordid`,`lat`,`lon`,`dateadded`) values (3,'FLOOR-0000001','0000003','M-0000003','692.4560546875','583.7812500000001','2017-05-27');
insert  into `mall_directory_other_coordinates`(`id`,`floorid`,`otherid`,`coordid`,`lat`,`lon`,`dateadded`) values (4,'FLOOR-0000001','0000005','M-0000004','964.0074754166668','540.8124999999999','2017-05-27');
insert  into `mall_directory_other_coordinates`(`id`,`floorid`,`otherid`,`coordid`,`lat`,`lon`,`dateadded`) values (5,'FLOOR-0000001','0000005','M-0000005','964.0074754166668','540.8124999999999','2017-05-27');
insert  into `mall_directory_other_coordinates`(`id`,`floorid`,`otherid`,`coordid`,`lat`,`lon`,`dateadded`) values (6,'FLOOR-0000001','0000005','M-0000006','580.1299037169088','494.90528561259043','2017-05-27');
insert  into `mall_directory_other_coordinates`(`id`,`floorid`,`otherid`,`coordid`,`lat`,`lon`,`dateadded`) values (7,'FLOOR-0000001','0000005','M-0000007','580.1299037169088','494.90528561259043','2017-05-27');
insert  into `mall_directory_other_coordinates`(`id`,`floorid`,`otherid`,`coordid`,`lat`,`lon`,`dateadded`) values (8,'FLOOR-0000001','0000005','M-0000008','580.1299037169088','494.90528561259043','2017-05-27');
insert  into `mall_directory_other_coordinates`(`id`,`floorid`,`otherid`,`coordid`,`lat`,`lon`,`dateadded`) values (9,'FLOOR-0000001','0000006','M-0000009','740.8935546875','529.8749999999999','2017-05-27');
insert  into `mall_directory_other_coordinates`(`id`,`floorid`,`otherid`,`coordid`,`lat`,`lon`,`dateadded`) values (11,'FLOOR-0000001','0000006','M-0000011','854.6431568077331','453.3095159017478','2017-05-27');
insert  into `mall_directory_other_coordinates`(`id`,`floorid`,`otherid`,`coordid`,`lat`,`lon`,`dateadded`) values (23,'FLOOR-0000001','0000001','M-0000023','1171.581608364204','672.740098866399','2017-05-27');
insert  into `mall_directory_other_coordinates`(`id`,`floorid`,`otherid`,`coordid`,`lat`,`lon`,`dateadded`) values (25,'FLOOR-0000001','0000006','M-0000025','328.3935546875','483','2017-05-29');
insert  into `mall_directory_other_coordinates`(`id`,`floorid`,`otherid`,`coordid`,`lat`,`lon`,`dateadded`) values (68,'FLOOR-0000002','0000001','M-0000058','811.6400530300699','192.34590542128467','2017-06-03');
insert  into `mall_directory_other_coordinates`(`id`,`floorid`,`otherid`,`coordid`,`lat`,`lon`,`dateadded`) values (69,'FLOOR-0000002','0000001','M-0000059','251.68888115506988','218.62520229628467','2017-06-03');
insert  into `mall_directory_other_coordinates`(`id`,`floorid`,`otherid`,`coordid`,`lat`,`lon`,`dateadded`) values (70,'FLOOR-0000002','0000001','M-0000060','505.3851702175699','135.74434292128467','2017-06-03');
insert  into `mall_directory_other_coordinates`(`id`,`floorid`,`otherid`,`coordid`,`lat`,`lon`,`dateadded`) values (71,'FLOOR-0000002','0000005','M-0000061','591.2982561550699','224.68965542128473','2017-06-03');
insert  into `mall_directory_other_coordinates`(`id`,`floorid`,`otherid`,`coordid`,`lat`,`lon`,`dateadded`) values (72,'FLOOR-0000002','0000005','M-0000062','746.9525530300699','222.66817104628473','2017-06-03');
insert  into `mall_directory_other_coordinates`(`id`,`floorid`,`otherid`,`coordid`,`lat`,`lon`,`dateadded`) values (73,'FLOOR-0000002','0000006','M-0000063','327.4945452175699','163.03438198378473','2017-06-03');

/*Table structure for table `mall_directory_others` */

DROP TABLE IF EXISTS `mall_directory_others`;

CREATE TABLE `mall_directory_others` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `otherid` varchar(20) DEFAULT NULL,
  `othername` varchar(200) DEFAULT NULL,
  `dateadded` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `mall_directory_others` */

insert  into `mall_directory_others`(`id`,`otherid`,`othername`,`dateadded`) values (1,'0000001','Restroom','2017-05-25');
insert  into `mall_directory_others`(`id`,`otherid`,`othername`,`dateadded`) values (2,'0000002','Kiosk','2017-05-25');
insert  into `mall_directory_others`(`id`,`otherid`,`othername`,`dateadded`) values (3,'0000003','ATM','2017-05-25');
insert  into `mall_directory_others`(`id`,`otherid`,`othername`,`dateadded`) values (4,'0000004','Management','2017-05-25');
insert  into `mall_directory_others`(`id`,`otherid`,`othername`,`dateadded`) values (5,'0000005','Elevator','2017-05-26');
insert  into `mall_directory_others`(`id`,`otherid`,`othername`,`dateadded`) values (6,'0000006','Escalator','2017-05-27');

/*Table structure for table `mall_directory_recordid` */

DROP TABLE IF EXISTS `mall_directory_recordid`;

CREATE TABLE `mall_directory_recordid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tablename` varchar(200) DEFAULT NULL,
  `lastid` varchar(20) DEFAULT NULL,
  `dateadded` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `mall_directory_recordid` */

insert  into `mall_directory_recordid`(`id`,`tablename`,`lastid`,`dateadded`) values (1,'mall_directory_categories','CAT-0000010','2017-05-25');
insert  into `mall_directory_recordid`(`id`,`tablename`,`lastid`,`dateadded`) values (3,'mall_directory_shops','0000018','2017-05-26');
insert  into `mall_directory_recordid`(`id`,`tablename`,`lastid`,`dateadded`) values (4,'mall_directory_others','0000006','2017-05-26');
insert  into `mall_directory_recordid`(`id`,`tablename`,`lastid`,`dateadded`) values (5,'mall_directory_floors','FLOOR-0000003','2017-05-26');
insert  into `mall_directory_recordid`(`id`,`tablename`,`lastid`,`dateadded`) values (8,'mall_directory_shops_coordinates','S-0000019','2017-06-03');
insert  into `mall_directory_recordid`(`id`,`tablename`,`lastid`,`dateadded`) values (9,'mall_directory_other_coordinates','M-0000063','2017-06-03');
insert  into `mall_directory_recordid`(`id`,`tablename`,`lastid`,`dateadded`) values (10,'mall_directory_route','L-0000027','2017-05-30');

/*Table structure for table `mall_directory_route` */

DROP TABLE IF EXISTS `mall_directory_route`;

CREATE TABLE `mall_directory_route` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `floorid` varchar(20) DEFAULT NULL,
  `shopid` varchar(20) DEFAULT NULL,
  `routeid` varchar(20) DEFAULT NULL,
  `coord` text,
  `dateadded` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `mall_directory_route` */

insert  into `mall_directory_route`(`id`,`floorid`,`shopid`,`routeid`,`coord`,`dateadded`) values (1,'FLOOR-0000001','S-0000001','L-0000014','[[1291.1591941629154,798.3216208191886],[1102.6123046875005,674.4062500000002],[1013.5498046875005,796.2812500000002]]','2017-05-30');
insert  into `mall_directory_route`(`id`,`floorid`,`shopid`,`routeid`,`coord`,`dateadded`) values (2,'FLOOR-0000001','S-0000010','L-0000015','[[1078.372453547785,762.7190415422872],[1051.0498046874998,740.4218749999999],[1011.9873046874998,795.8906249999999]]','2017-05-30');
insert  into `mall_directory_route`(`id`,`floorid`,`shopid`,`routeid`,`coord`,`dateadded`) values (3,'FLOOR-0000001','S-0000011','L-0000016','[[975.788116542879,683.4495564782198],[1031.5185546874998,604.4843749999998],[1115.1123046874998,666.2031249999998],[1013.5498046874998,795.1093749999998]]','2017-05-30');
insert  into `mall_directory_route`(`id`,`floorid`,`shopid`,`routeid`,`coord`,`dateadded`) values (4,'FLOOR-0000001','S-0000008','L-0000017','[[927.8076171874997,588.8846216298327],[947.9248046874999,556.0468749999998],[1096.3623046875,671.6718749999998],[1007.3188757761469,790.374197278382]]','2017-05-30');
insert  into `mall_directory_route`(`id`,`floorid`,`shopid`,`routeid`,`coord`,`dateadded`) values (5,'FLOOR-0000001','S-0000006','L-0000018','[[789.3665972458934,593.7107527494959],[786.9873046874998,518.1562500000001],[912.7685546874998,518.1562500000001],[1113.5498046874998,666.5937500000001],[1017.2649012649553,793.442980133817]]','2017-05-30');
insert  into `mall_directory_route`(`id`,`floorid`,`shopid`,`routeid`,`coord`,`dateadded`) values (6,'FLOOR-0000001','S-0000007','L-0000019','[[526.9050082997885,591.0763813717373],[527.2673133374997,513.8137413500001],[910.8610633374997,516.1574913500001],[1115.1579383374997,665.3762413500001],[1014.3766883374997,794.6731163500001]]','2017-05-30');
insert  into `mall_directory_route`(`id`,`floorid`,`shopid`,`routeid`,`coord`,`dateadded`) values (7,'FLOOR-0000001','S-0000016','L-0000020','[[979.2244752583711,475.9710492277428],[931.7635377583711,535.4914947064658],[1104.419787758371,657.3664947064658],[1009.1072877583711,792.5227447064657]]','2017-05-30');
insert  into `mall_directory_route`(`id`,`floorid`,`shopid`,`routeid`,`coord`,`dateadded`) values (8,'FLOOR-0000001','S-0000009','L-0000021','[[785.2062812589381,427.13614926164905],[783.4716796875003,506.046875],[897.5341796875003,506.828125],[1111.5966796875005,664.640625],[1008.6948494799483,795.6674552075519]]','2017-05-30');
insert  into `mall_directory_route`(`id`,`floorid`,`shopid`,`routeid`,`coord`,`dateadded`) values (9,'FLOOR-0000001','S-0000003','L-0000022','[[150.46579776006843,497.4055766571541],[861.2060546875,504.875],[1108.0810546875,668.9375],[1015.8935546875,792.375]]','2017-05-30');
insert  into `mall_directory_route`(`id`,`floorid`,`shopid`,`routeid`,`coord`,`dateadded`) values (10,'FLOOR-0000001','S-0000004','L-0000023','[[309.6435546875,410.73437499999994],[303.3935546875,512.6875],[873.7060546875,498.625],[1108.0810546875,659.5625],[1009.6435546875,789.25]]','2017-05-30');
insert  into `mall_directory_route`(`id`,`floorid`,`shopid`,`routeid`,`coord`,`dateadded`) values (11,'FLOOR-0000001','S-0000014','L-0000024','[[368.2373046875,573.8203124999999],[369.0185546875,509.5625],[876.8310546875,511.125],[1108.0810546875,656.4375],[1009.6435546875,786.125]]','2017-05-30');
insert  into `mall_directory_route`(`id`,`floorid`,`shopid`,`routeid`,`coord`,`dateadded`) values (12,'FLOOR-0000001','S-0000015','L-0000025','[[586.3037109374999,638.9570312499995],[650.2685546875,639.25],[647.1435546875,503.3125],[879.9560546875,508],[1108.0810546875,658],[1000.2685546875,790.8125]]','2017-05-30');
insert  into `mall_directory_route`(`id`,`floorid`,`shopid`,`routeid`,`coord`,`dateadded`) values (13,'FLOOR-0000001','S-0000005','L-0000026','[[576.4151628125007,380.73191305],[575.2685546875,497.0625],[864.3310546875,500.1875],[1103.3935546875,672.0625],[1012.7685546875,797.0625]]','2017-05-30');
insert  into `mall_directory_route`(`id`,`floorid`,`shopid`,`routeid`,`coord`,`dateadded`) values (14,'FLOOR-0000001','S-0000002','L-0000027','[[1048.1927908016155,253.88513979227326],[878.3935546875,504.875],[1106.5185546875,654.875],[1004.9560546875,797.0625]]','2017-05-30');

/*Table structure for table `mall_directory_shops` */

DROP TABLE IF EXISTS `mall_directory_shops`;

CREATE TABLE `mall_directory_shops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shopid` varchar(20) DEFAULT NULL,
  `shopname` varchar(200) DEFAULT NULL,
  `categoryid` varchar(100) DEFAULT NULL,
  `dateadded` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

/*Data for the table `mall_directory_shops` */

insert  into `mall_directory_shops`(`id`,`shopid`,`shopname`,`categoryid`,`dateadded`) values (1,'0000001','Puregold','CAT-0000001','2017-05-30');
insert  into `mall_directory_shops`(`id`,`shopid`,`shopname`,`categoryid`,`dateadded`) values (2,'0000002','Hypermarket','CAT-0000001','2017-05-25');
insert  into `mall_directory_shops`(`id`,`shopid`,`shopname`,`categoryid`,`dateadded`) values (3,'0000003','Samsung','CAT-0000002','2017-05-25');
insert  into `mall_directory_shops`(`id`,`shopid`,`shopname`,`categoryid`,`dateadded`) values (4,'0000004','ASUS','CAT-0000002','2017-05-25');
insert  into `mall_directory_shops`(`id`,`shopid`,`shopname`,`categoryid`,`dateadded`) values (5,'0000005','Cherry Mobile','CAT-0000002','2017-05-25');
insert  into `mall_directory_shops`(`id`,`shopid`,`shopname`,`categoryid`,`dateadded`) values (6,'0000006','Bench','CAT-0000003','2017-05-25');
insert  into `mall_directory_shops`(`id`,`shopid`,`shopname`,`categoryid`,`dateadded`) values (10,'0000007','Food Court','CAT-0000004','2017-05-25');
insert  into `mall_directory_shops`(`id`,`shopid`,`shopname`,`categoryid`,`dateadded`) values (11,'0000008','Uniqlo','CAT-0000003','2017-05-25');
insert  into `mall_directory_shops`(`id`,`shopid`,`shopname`,`categoryid`,`dateadded`) values (13,'0000009','Jollibee','CAT-0000004','2017-05-25');
insert  into `mall_directory_shops`(`id`,`shopid`,`shopname`,`categoryid`,`dateadded`) values (16,'0000010','McDo','CAT-0000004','2017-05-25');
insert  into `mall_directory_shops`(`id`,`shopid`,`shopname`,`categoryid`,`dateadded`) values (17,'0000011','Medical City','CAT-0000005','2017-05-25');
insert  into `mall_directory_shops`(`id`,`shopid`,`shopname`,`categoryid`,`dateadded`) values (18,'0000012','Ace Hardware','CAT-0000006','2017-05-25');
insert  into `mall_directory_shops`(`id`,`shopid`,`shopname`,`categoryid`,`dateadded`) values (19,'0000013','Rustans','CAT-0000001','2017-05-26');
insert  into `mall_directory_shops`(`id`,`shopid`,`shopname`,`categoryid`,`dateadded`) values (20,'0000014','Robinsons','CAT-0000001','2017-05-26');
insert  into `mall_directory_shops`(`id`,`shopid`,`shopname`,`categoryid`,`dateadded`) values (21,'0000015','Watsons','CAT-0000001','2017-05-26');
insert  into `mall_directory_shops`(`id`,`shopid`,`shopname`,`categoryid`,`dateadded`) values (22,'0000016','Adidas','CAT-0000008','2017-05-26');
insert  into `mall_directory_shops`(`id`,`shopid`,`shopname`,`categoryid`,`dateadded`) values (23,'0000017','Puma','CAT-0000008','2017-05-26');
insert  into `mall_directory_shops`(`id`,`shopid`,`shopname`,`categoryid`,`dateadded`) values (24,'0000018','Golds Gym','CAT-0000010','2017-05-26');

/*Table structure for table `mall_directory_shops_coordinates` */

DROP TABLE IF EXISTS `mall_directory_shops_coordinates`;

CREATE TABLE `mall_directory_shops_coordinates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `floorid` varchar(20) DEFAULT NULL,
  `categoryid` varchar(20) DEFAULT NULL,
  `shopid` varchar(20) DEFAULT NULL,
  `coordid` varchar(20) DEFAULT NULL,
  `coord` text,
  `dateadded` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

/*Data for the table `mall_directory_shops_coordinates` */

insert  into `mall_directory_shops_coordinates`(`id`,`floorid`,`categoryid`,`shopid`,`coordid`,`coord`,`dateadded`) values (1,'FLOOR-0000001','CAT-0000001','0000001','S-0000001','[[[1047.833073984836,844.3328654378687],[1319.7080739848361,1044.3328654378686],[1534.485314340995,753.3289193447297],[1262.462827392603,552.3103762005088],[1047.833073984836,844.3328654378687]]]','2017-05-26');
insert  into `mall_directory_shops_coordinates`(`id`,`floorid`,`categoryid`,`shopid`,`coordid`,`coord`,`dateadded`) values (2,'FLOOR-0000001','CAT-0000001','0000002','S-0000002','[[[840.9784523926031,285.1228762005087],[1079.5400307554587,460.46623121316105],[1255.4071292106278,222.95779477569545],[1016.1028688355818,47.304048371385505],[840.9784523926031,285.1228762005087]]]','2017-05-26');
insert  into `mall_directory_shops_coordinates`(`id`,`floorid`,`categoryid`,`shopid`,`coordid`,`coord`,`dateadded`) values (3,'FLOOR-0000001','CAT-0000001','0000013','S-0000003','[[[64.33298526006843,584.319639157154],[236.20798526006843,584.319639157154],[236.59861026006843,411.27276415715414],[65.11423526006843,410.49151415715414],[64.33298526006843,584.319639157154]]]','2017-05-26');
insert  into `mall_directory_shops_coordinates`(`id`,`floorid`,`categoryid`,`shopid`,`coordid`,`coord`,`dateadded`) values (4,'FLOOR-0000001','CAT-0000001','0000014','S-0000004','[[[245.9716796875,464.24999999999994],[353.7841796875,464.24999999999994],[354.1748046875,403.31249999999994],[372.9248046875,402.92187499999994],[373.3154296875,357.21874999999994],[245.9716796875,357.21874999999994],[245.9716796875,464.24999999999994]]]','2017-05-26');
insert  into `mall_directory_shops_coordinates`(`id`,`floorid`,`categoryid`,`shopid`,`coordid`,`coord`,`dateadded`) values (5,'FLOOR-0000001','CAT-0000001','0000015','S-0000005','[[[544.2862565625003,449.67722555],[593.8956315625003,449.67722555],[593.8956315625003,405.53660055],[612.2550065625003,405.53660055],[612.2550065625003,399.28660054999995],[632.1768815625003,399.48191304999995],[632.3721940625003,393.03660054999995],[663.4268815625003,393.03660054999995],[664.0128190625007,312.56785055000006],[505.41906906250074,311.78660055000006],[505.41906906250074,384.05222555000006],[488.8175065625006,383.85691305000006],[488.8175065625006,397.33347555000006],[544.0909440625006,397.13816305000006],[544.2862565625003,449.67722555]]]','2017-05-26');
insert  into `mall_directory_shops_coordinates`(`id`,`floorid`,`categoryid`,`shopid`,`coordid`,`coord`,`dateadded`) values (6,'FLOOR-0000001','CAT-0000003','0000008','S-0000006','[[[761.8255864211902,659.961473072479],[816.3177739211902,659.961473072479],[816.9076080705966,527.4600324265127],[761.8294830705966,527.8506574265127],[761.8255864211902,659.961473072479]]]','2017-05-26');
insert  into `mall_directory_shops_coordinates`(`id`,`floorid`,`categoryid`,`shopid`,`coordid`,`coord`,`dateadded`) values (7,'FLOOR-0000001','CAT-0000004','0000007','S-0000007','[[[501.3190707997885,660.0216938717373],[552.8815707997885,660.0216938717373],[553.2721957997885,522.1310688717373],[500.53782079978845,522.1310688717373],[501.3190707997885,660.0216938717373]]]','2017-05-26');
insert  into `mall_directory_shops_coordinates`(`id`,`floorid`,`categoryid`,`shopid`,`coordid`,`coord`,`dateadded`) values (8,'FLOOR-0000001','CAT-0000004','0000009','S-0000008','[[[897.9248046874997,623.5525903798327],[914.7216796874997,623.3572778798327],[914.7216796874997,614.1775903798327],[926.6357421874997,614.1775903798327],[957.6904296874997,572.5760278798327],[932.4951171874997,554.2166528798327],[897.9248046874997,598.9432153798327],[897.9248046874997,623.5525903798327]]]','2017-05-26');
insert  into `mall_directory_shops_coordinates`(`id`,`floorid`,`categoryid`,`shopid`,`coordid`,`coord`,`dateadded`) values (9,'FLOOR-0000001','CAT-0000004','0000010','S-0000009','[[[768.4094062589381,460.72989926164905],[802.0031562589381,460.72989926164905],[802.0031562589381,414.44083676164905],[796.1437812589381,414.24552426164905],[796.3390937589381,393.542399261649],[768.6047187589381,393.542399261649],[768.4094062589381,460.72989926164905]]]','2017-05-26');
insert  into `mall_directory_shops_coordinates`(`id`,`floorid`,`categoryid`,`shopid`,`coordid`,`coord`,`dateadded`) values (10,'FLOOR-0000001','CAT-0000005','0000011','S-0000010','[[[1026.419328547785,793.9690415422872],[1064.700578547785,821.7034165422872],[1130.3255785477847,731.8596665422871],[1093.0208910477847,703.7346665422871],[1026.419328547785,793.9690415422872]]]','2017-05-26');
insert  into `mall_directory_shops_coordinates`(`id`,`floorid`,`categoryid`,`shopid`,`coordid`,`coord`,`dateadded`) values (11,'FLOOR-0000001','CAT-0000006','0000012','S-0000011','[[[910.6441083642037,737.3849641929216],[946.7769208642037,763.7521516929216],[1040.9321247215544,634.9828987635179],[998.3539997215546,603.146961263518],[911.1918325489863,720.7409424537913],[910.6441083642037,737.3849641929216]]]','2017-05-27');
insert  into `mall_directory_shops_coordinates`(`id`,`floorid`,`categoryid`,`shopid`,`coordid`,`coord`,`dateadded`) values (14,'FLOOR-0000001','CAT-0000008','0000016','S-0000014','[[[351.8310546875,625.5781249999999],[384.6435546875,625.9687499999999],[384.6435546875,521.6718749999999],[352.2216796875,522.0624999999999],[351.8310546875,625.5781249999999]]]','2017-05-29');
insert  into `mall_directory_shops_coordinates`(`id`,`floorid`,`categoryid`,`shopid`,`coordid`,`coord`,`dateadded`) values (15,'FLOOR-0000001','CAT-0000008','0000016','S-0000015','[[[552.8076171874999,659.5624999999995],[553.0029296874999,618.3515624999995],[619.7998046874999,618.7421874999995],[619.7998046874999,659.5624999999995],[552.8076171874999,659.5624999999995]]]','2017-05-30');
insert  into `mall_directory_shops_coordinates`(`id`,`floorid`,`categoryid`,`shopid`,`coordid`,`coord`,`dateadded`) values (16,'FLOOR-0000001','CAT-0000008','0000017','S-0000016','[[[950.9041627583711,499.0179242277428],[971.8026002583711,514.0569867277428],[1007.5447877583711,465.8147992277428],[970.0447877583711,437.88511172774275],[954.0291627583711,459.36948672774275],[950.9041627583711,499.0179242277428]]]','2017-05-30');
insert  into `mall_directory_shops_coordinates`(`id`,`floorid`,`categoryid`,`shopid`,`coordid`,`coord`,`dateadded`) values (17,'FLOOR-0000002','CAT-0000001','0000001','S-0000017','[[[262.93968696056777,393.68849717261446],[489.85130805431777,393.68849717261446],[489.85130805431777,194.06691514136452],[261.92894477306777,194.06691514136452],[262.93968696056777,307.77541123511446],[222.50999946056774,307.77541123511446],[222.50999946056774,350.73195420386446],[262.93968696056777,351.23732529761446],[262.93968696056777,393.68849717261446]]]','2017-06-03');
insert  into `mall_directory_shops_coordinates`(`id`,`floorid`,`categoryid`,`shopid`,`coordid`,`coord`,`dateadded`) values (18,'FLOOR-0000002','CAT-0000001','0000002','S-0000018','[[[827.4757998219861,350.546052406109],[874.4753115407361,350.546052406109],[873.9699404469861,376.319978187359],[915.9157412282361,376.319978187359],[916.4211123219861,350.546052406109],[1010.4201357594861,350.040681312359],[1010.4201357594862,192.36490006235903],[928.0446474782362,193.37564224985903],[928.0446474782362,180.74136490610903],[884.0773623219862,180.74136490610903],[883.5719912282362,194.38638443735903],[827.9811709157362,194.38638443735903],[827.4757998219861,350.546052406109]]]','2017-06-03');
insert  into `mall_directory_shops_coordinates`(`id`,`floorid`,`categoryid`,`shopid`,`coordid`,`coord`,`dateadded`) values (19,'FLOOR-0000002','CAT-0000001','0000013','S-0000019','[[[604.5531867419079,192.20449034125897],[801.1425422106579,191.69911924750897],[801.1425422106579,95.17324034125897],[611.1230109606579,95.67861143500897],[611.6283820544079,126.50624815375897],[604.3005011950328,126.25356260688397],[604.5531867419079,192.20449034125897]]]','2017-06-03');

/*Table structure for table `mall_directory_top_searches` */

DROP TABLE IF EXISTS `mall_directory_top_searches`;

CREATE TABLE `mall_directory_top_searches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shopid` varchar(20) DEFAULT NULL,
  `shopname` varchar(200) DEFAULT NULL,
  `ctr` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mall_directory_top_searches` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
