<?php
	set_time_limit(0);
	date_default_timezone_set("Asia/Manila");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
	
	// Main Database
	$connection = mysql_connect('localhost', 'gates', 'g@tes2009');
	if (!$connection) { 
		die('Could not connect: ' . mysql_error()); 
	}
	mysql_select_db("gates_smm", $connection) or die("Error on database: " . mysql_error());
	mysql_query("SET NAMES 'utf8'");
	mysql_query("SET CHARACTER SET utf8");
	mysql_query("SET COLLATION_CONNECTION = 'utf8_unicode_ci'");
	
	function addleadingzero($num)
	{
		$maxid = "";
		$str = strlen($num);
		if($str == 1)
		{ $maxid = "000000" . $num; }
		elseif($str == 2)
		{ $maxid = "00000" . $num; }
		elseif($str == 3)
		{ $maxid = "0000" . $num; }
		elseif($str == 4)
		{ $maxid = "000" . $num; }
		elseif($str == 5)
		{ $maxid = "00" . $num; }
		elseif($str == 6)
		{ $maxid = "0" . $num; }
		else
		{ $maxid = $num; }
		
		return $maxid;
	}
	
	function createidno($tagname, $table, $tblid)
	{
		$myid = "";
		$getmaxno = "SELECT lastid FROM mall_directory_recordid WHERE tablename = '" . $table . "'";
		$maxno = mysql_fetch_array(mysql_query($getmaxno));
		$gettblid = "select " . $tblid . " from " . $table . " ORDER BY ID DESC LIMIT 0, 1";
		$tblid = mysql_fetch_array(mysql_query($gettblid));
		if($tagname == "")
		{
			if($maxno[0] == "")
			{
				if($tblid[0] == "")
				{ $myid = addleadingzero("1"); }
				else
				{ $myid = addleadingzero($tblid[0]); }
				$sql = "INSERT INTO mall_directory_recordid(tablename, lastid, dateadded) VALUES('" . $table . "', '" . $myid . "', '" . date("Y-m-d") . "')";
				$result = mysql_query($sql);
			}
			else
			{
				if(is_numeric($maxno[0]))
				{
					$myid = addleadingzero($maxno[0]+1);
					$sql = "UPDATE mall_directory_recordid SET lastid = '" . $myid . "', dateadded = '" . date("Y-m-d") . "' where tablename = '" . $table . "'";
					$result = mysql_query($sql);
				}
				else
				{
					$myid = addleadingzero("1");
					$sql = "INSERT INTO mall_directory_recordid(tablename, lastid, dateadded) VALUES('" . $table . "', '" . $myid . "', '" . date("Y-m-d") . "')";
					$result = mysql_query($sql);
				}
			}
		}
		else
		{
			if($maxno[0] == "")
			{
				if($tblid[0] == "")
				{ $myid = $tagname . "-" . addleadingzero("1"); }
				else
				{
					if(is_numeric($tblid[0]))
					{
						$myarr = explode("-", $tblid[0]);
						$myid = $tagname . "-" . addleadingzero($myarr[1]);
					}
					else
					{ $myid = $tagname . "-" . addleadingzero("1"); }
				}
				$sql = "INSERT INTO mall_directory_recordid(tablename, lastid, dateadded) VALUES('" . $table . "', '" . $myid . "', '" . date("Y-m-d") . "')";
				$result = mysql_query($sql);
			}
			else
			{
				$arr = explode("-", $maxno[0]);
				if(is_numeric(end($arr)))
				{
					$myid = $tagname . "-" . addleadingzero(end($arr)+1);
					$sql = "UPDATE mall_directory_recordid SET lastid = '" . $myid . "', dateadded = '" . date("Y-m-d") . "' where tablename = '" . $table . "'";
					$result = mysql_query($sql);
				}
				else
				{
					$myid = $tagname . "-" . addleadingzero("1");
					$sql = "INSERT INTO mall_directory_recordid(tablename, lastid, dateadded) VALUES('" . $table . "', '" . $myid . "', '" . date("Y-m-d") . "')";
					$result = mysql_query($sql);
				}
			}
		}
		return $myid;
	}
?>