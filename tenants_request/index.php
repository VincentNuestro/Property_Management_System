
<?php 
	if($_GET['type'] == 'trrequest'){
		include "tenants_request/TRrequest/index.php";
	}else if($_GET['type'] == 'trapproval'){
		include "tenants_request/TRapproval/index.php";
	}
?>