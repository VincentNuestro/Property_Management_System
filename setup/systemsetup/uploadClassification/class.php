<?php
	$checkHeader = array('classCode', 'className');
	$checker = 0;
	$displayError = "";
	$row = 1;
	$num = 0;
	if (($handle = fopen($_FILES['file']['tmp_name'], "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$num = count($data);
			// echo "<p> $num fields in line $row: <br /></p>\n";
			// echo "<br>";
			
			if ( $row == 1 ) {
				for ($c=0; $c < $num; $c++) {
					// echo $data[$c] . "<br />\n";
					if ( $data[$c] != $checkHeader[$c] ) {
						$checker = 1;
						$displayError .= "Wrong header details on column " . $c . "<br>";
					}
				}
			}
			$row++;	
		}

		fclose($handle);
	}

	if ( $num != COUNT($checkHeader) ) {
		echo "0|Required number of fields doesn't match on the CSV file.";
	}

	else {
		$counter = 0;
		if ( $checker == 0 ) {
			echo "1|";
			$f = fopen($_FILES['file']['tmp_name'], "r");
			while (($line = fgetcsv($f)) !== false) {
				if ( $counter == 0 ) {

				}

				else {
					echo "<tr>";
					foreach ($line as $cell) {
						echo "<td>" . htmlspecialchars($cell) . "</td>";
					}
					echo "</tr>\n";
				}
				$counter++;
					
			}
			fclose($f);
		}

		else {
			echo "0|".$displayError;
		}
	}
?>