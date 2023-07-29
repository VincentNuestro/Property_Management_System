<?php

date_default_timezone_get();
date_default_timezone_set('Asia/Manila');
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
$connection = mysql_connect('localhost', 'gates', 'g@tes2009');
if (!$connection) {
	die('Could not connect: ' . mysql_error());
}

$db =  mysql_select_db("gates_smm2", $connection); //or die("Error on database: " . mysql_error());
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET COLLATION_CONNECTION = 'utf8_unicode_ci'");

	function getsysdate(){
		$sql = mysql_fetch_array(mysql_query("SELECT eoddate FROM tbltrans_eod ORDER BY eoddate DESC LIMIT 0,1"));
		if($sql[0] == ""){
			return date("Y-m-d"); //if eod table is empty
		}else{
			return date("Y-m-d", strtotime($sql[0]));
		}
	}
?>

