<div class="page-header">
	<div class="row form-group" style="margin-bottom: 0px;padding-top:10px;background-color: #edf4f8;padding-bottom: 10px;">
      	<div class="col-md-3">
        	<h1 style="font-weight: bold;">REPORTS</h1>
            <h6 style="color:#2679B5;">&nbsp;&nbsp;&nbsp;<label id="txtpageheader"></label></h6>
      	</div>
    </div>
</div>

<?php 
    if ( $_GET['type'] == 'tsr' ) {
         include "reports/tenantsalesreport/index.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('Tenant Sales Reports'); }) </script>";
    }else if ( $_GET['type'] == 'ir' ) {
    	include "reports/inquiry_report/index.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('Inquiry Reports'); }) </script>";
	}else if ( $_GET['type'] == 'lrep' ) {
        include "reports/leasingreports/index.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('Leasing Reports'); }) </script>";
    }else if ( $_GET['type'] == 'ar' ) {
		include "reports/app_report/index.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('Application Reports'); }) </script>";
	}else if ( $_GET['type'] == 'uh' ) {
		include "reports/unit_history/unithistory.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('Unit History'); }) </script>";
	}else if ( $_GET['type'] == 'th' ) {
		include "reports/tenantshistory/tenantshistory.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('Tenant History'); }) </script>";
	}else if ( $_GET['type'] == 'sa' ) {
		include "reports/salesaudit/index.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('Sales Audit'); }) </script>";
	}else if ( $_GET['type'] == 'accreditation' ) {
		include "reports/accreditation/index.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('Accreditation'); }) </script>";
	}else if ( $_GET['type'] == 'at' ) {
		include "reports/audittrail/index.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('Audit Trail'); }) </script>";
	}else if ( $_GET['type'] == 'csvur' ) {
        include "reports/csvuploadreport/index.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('CSV Upload Reports'); }) </script>";
    }else if ( $_GET['type'] == 'tcp' ) {
        include "reports/tenantchargespayments/index.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('Tenants Charges and Payments'); }) </script>";
    }else if ( $_GET['type'] == 'rent' ) {
        include "reports/tenantsrentrep/index.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('Tenant Rents'); }) </script>";
    }else if ( $_GET['type'] == 'gatep' ) {
        include "reports/gatepassrep/index.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('Gate Pass'); }) </script>";
    }else if ( $_GET['type'] == 'workp' ) {
        include "reports/workpermitrep/index.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('Work Permit'); }) </script>";
    }
?>