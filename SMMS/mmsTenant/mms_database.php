<?php

date_default_timezone_get();
date_default_timezone_set('Asia/Manila');
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
$connection = mysql_connect('localhost', 'gates', 'g@tes2009');
if (!$connection) {
	die('Could not connect: ' . mysql_error());
}

$database = "gates_smm2";

$db =  mysql_select_db($database, $connection); //or die("Error on database: " . mysql_error());
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET COLLATION_CONNECTION = 'utf8_unicode_ci'");

$createTableChatHeader = "CREATE TABLE `gates_smm2`.`tbltenant_chat_header`(  
  `id` INT NOT NULL AUTO_INCREMENT,
  `sender_userid` VARCHAR(20) DEFAULT NULL,
  `receiver_userid` VARCHAR(20) DEFAULT NULL,
  `messageid` VARCHAR(20) DEFAULT NULL,
  `xdatetime` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1";
mysql_query($createTableChatHeader);

$createTableChat = "CREATE TABLE `gates_smm2`.`tbltenant_chat`(  
  `id` INT NOT NULL AUTO_INCREMENT,
  `messageid` VARCHAR(20),
  `message` TEXT,
  `xdatetime` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1";
mysql_query($createTableChat);

$alterTableChat = "ALTER TABLE `$database`.`tbltenant_chat`   
  ADD COLUMN `sender_id` VARCHAR(20) NULL AFTER `message`";
mysql_query($alterTableChat);


$rename1 = "RENAME TABLE `$database`.`tbltenant_chat` TO `$database`.`tblchat_log`";
mysql_query($rename1);

$rename2 = "RENAME TABLE `$database`.`tbltenant_chat_header` TO `$database`.`tblchat_header`";
mysql_query($rename2);

$cretenewtable = "CREATE TABLE `gates_smm2`.`tblchat_record`(  
  `id` INT NOT NULL AUTO_INCREMENT,
  `userid` VARCHAR(20),
  `messageid` VARCHAR(20),
  PRIMARY KEY (`id`))ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1";
mysql_query($cretenewtable);


$altertable = "ALTER TABLE `$database`.`tblchat_header`   
  CHANGE `xdatetime` `xdatetime` VARCHAR(50) NULL";
mysql_query($altertable);

$altertablerecordchat = "ALTER TABLE `$database`.`tblchat_record`   
  ADD COLUMN `xdatetime` VARCHAR(50) NULL AFTER `messageid`";
mysql_query($altertablerecordchat);

$deletexdateinchatheader="ALTER TABLE `$database`.`tblchat_header`   
  DROP COLUMN `xdatetime`";
mysql_query($deletexdateinchatheader);

?>	
