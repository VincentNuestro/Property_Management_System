<?php
include("../mms_database.php");
$response = array();
$response["CatTag"] = array();

$getData = mysql_query("SELECT T.`reqCatCode`, T.`reqTagCode`, T.`reqTagDesc`, C.`reqCatDesc`
from `tblreqtags` T
Left Join `tblreqcategory` C on T.`reqCatCode` = C.`reqCatCode`");
if(mysql_num_rows($getData)<>0){
	while($items = mysql_fetch_array($getData)){
		$List = array();
		$List["reqCatCode"] = $items["reqCatCode"];
		$List["reqTagCode"] = $items["reqTagCode"];
		$List["reqTagDesc"] = $items["reqTagDesc"];
		$List["reqCatDesc"] = $items["reqCatDesc"];
		array_push($response["CatTag"], $List);
	}
$response["success"] = 1;
}else{
$response["success"] = 0;
}
echo json_encode($response);
?>
