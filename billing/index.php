<style>
.parent {
    height: 60vh;
}
.parent2 {
    height: 60vh;
}
.parent3 {
    height: 39vh;
}
.parent4 {
    height: 30vh;
}
.parent5 {
    height: 44vh;
}
</style>
<div class="page-header">
    <div class="row form-group" style="margin-bottom: 0px;padding-top:10px;background-color: #edf4f8;padding-bottom: 10px;">
        <div class="col-md-2">
            <h1 style="font-weight: bold;">BILLING</h1>
            <h6 style="color:#2679B5;">&nbsp;&nbsp;&nbsp;<label id="txtpageheader"></label></h6>
        </div>
        <div class="col-md-10 col-xs-12" id="txtpageheaderstat">
            <span class="label label-xlg label-pink arrowed-in-right arrowed pull-right"><i class="ace-icon fa fa-tag bigger-80"></i>&nbsp;&nbsp;Basic Rent/SQM or % of GS&nbsp;</span>
            <span class="label label-xlg label-purple arrowed-in-right arrowed pull-right"><i class="ace-icon fa fa-tag bigger-80"></i>&nbsp;&nbsp;Basic Rent/SQM + % of GS&nbsp;</span>
            <span class="label label-xlg label-yellow arrowed-in-right arrowed pull-right"><i class="ace-icon fa fa-tag bigger-80"></i>&nbsp;&nbsp;% on GS&nbsp;</span>
            <span class="label label-xlg label-success arrowed-in-right arrowed pull-right"><i class="ace-icon fa fa-tag bigger-80"></i>&nbsp;&nbsp;Fixed Rent&nbsp;</span>
            <span class="label label-xlg label-info arrowed-in-right arrowed pull-right"><i class="ace-icon fa fa-tag bigger-80"></i>&nbsp;&nbsp;Basic Rent/SQM&nbsp;</span>
        </div>
    </div>
</div>
<?php 
	if($_GET['type'] == 'listofpenalty'){
		include "billing/penalty/index.php";
		echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('List of Penalty'); $('#txtpageheaderstat').css('display', 'none'); }) </script>";
	}else if($_GET['type'] == 'listofpdc'){
		include "billing/pdc/index.php";
		echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('List of PDC'); $('#txtpageheaderstat').css('display', 'none'); }) </script>";
	}else{
		include "billing/billing/index.php";
		echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('List of Tenants'); $('#txtpageheaderstat').css('display', 'block'); }) </script>";
	}
?>