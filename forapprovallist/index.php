
<?php 
	if($_GET['type'] == 'proposalapprovallist'){
		include "proposal/index.php";
		include "proposal/script.php";
	}elseif($_GET['type'] == 'awardnoticelist'){
		include "awards/index.php";
		include "awards/script.php";
	}elseif($_GET['type'] == 'contractslist'){
		include "contracts/index.php";
		include "contracts/script.php";
	}
?>