<?php
	session_start();
	include("../../connect.php");

	switch ($_POST['form']) {
		case 'OccupiedUnits':

			$sql = "SELECT unitname , CASE WHEN `status` = 'Occupied' THEN 2 WHEN `status` = 'Vacant' THEN 0 ELSE 1 END stat , coalesce(b.floor,'---') , 100
					FROM tblref_unit  a
					LEFT JOIN `tblref_floorsetup` b ON b.`floorid` = a.`floorid` WHERE a.mallid = '".$_POST['mallid']."' ORDER BY b.floor DESC";
			$res = mysql_query( $sql , $connection );
			$arr = array();
			$x = 0;
			$y = 0;
			$label = "";
			$yCategories = array();
			$xWith = array();
			while ( $row = mysql_fetch_array( $res ) ) {

				if( $label != '' ){
					if( $label == $row[2] ){
						$x++;
					} else {
						$y++;
						array_push( $xWith , $x );
						$x = 0;
						array_push( $yCategories , $row[2] );
					}
				} else {
					array_push( $yCategories , $row[2] );
				}

				$color = "";
				if( $row[1] == 2 ){
					$color = "#F89406";
				} else if( $row[1] == 1 ){
					$color = "#82AF6F";
				} else {
					$color = "#E7E7E7";
				}

				$str = "";
				// if( strlen( $row[0] ) > 4 ){
				// 	$str = substr($row[0], 0 , 4)."...";
				// } else {
					$str = $row[0];
				// }

				array_push( $arr , array( "pointPadding" => 10 , "rowsize" => 0.87 , "colsize" => 0.9 , "name" => $row[0] , "borderWidth" => 0.5 , "dataLabels" => array( "enabled" => true , "color" => "black" , "style" => array( "HcTextStroke" => null , "textShadow" => 'none' ) , "format" => $str ) , "data" => array( array( "x" => (int)$x , "y" => (int)$y , "value" => (int)$row[3] , "color" => $color , "stat" => $row[1] )  ) ) );
				$label = $row[2];
			}

			$width = 0;
			if( max( $xWith ) < 7 ){
				$width = 'calc(100%)';
			} else {
				$width = ((max( $xWith )/5)*800)."px";
			}
			$height = 0;
			if( $y+1 < 5 ){
				$height = ( $y+1 );
			} else {
				$height = ( $y+1 )/5;
			}
			echo json_encode( $arr )."##".(($height)*400)."##".json_encode( $yCategories )."##".$width;
		break;

		case 'byFloorsGraph':
			$sql = "SELECT b.floor , COUNT(a.id)
					FROM tblref_unit  a
					LEFT JOIN `tblref_floorsetup` b ON b.`floorid` = a.`floorid` WHERE a.mallid = '".$_POST['mallid']."' AND `status` = 'Occupied'
					GROUP BY b.floor";
			$res = mysql_query( $sql , $connection );
			$arr = array();
			while ( $row = mysql_fetch_array( $res ) ) {
				array_push( $arr , array( "name" => $row[0] , "data" => array( array( "name" => $row[0] , "y" => (int)$row[1] ) ) , "dataLabels" => array( "enabled" => true ) ) );
			} 
			echo json_encode( $arr );
		break;

	}

?>