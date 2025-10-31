<style>
.parent2 {
	height: 50vh;
}
.parent3 {
	height: 20vh;
}
</style>
<div class="page-header">
	<div class="row form-group" style="margin-bottom: 0px;padding-top:10px;background-color: #edf4f8;padding-bottom: 10px;">
		<div class="col-md-6">
			<h1 style="font-weight: bold;">COMPLAINTS</h1>
			<h6 style="color:#2679B5;">&nbsp;&nbsp;&nbsp;<label id="txtpageheader"></label></h6>
		</div>
		<div class="col-md-6">
			<div id="legendsofcomplaints">
				<span class="label label-xlg label-yellow arrowed-in-right arrowed pull-right" style="">Low Priority</span>
				<span class="label label-xlg label-warning arrowed-in-right arrowed pull-right" style="margin-right: 5px;">Medium Priority</span>
				<span class="label label-xlg label-danger arrowed-in-right arrowed pull-right" style="margin-right: 5px;">High Priority</span>
			</div>
			<div id="legendsofhouserules" style="display: none;">
				<span class="pull-right"><i class="fa fa-circle" style="color: #333;"></i> More than 3 Offense</span>
				<span class="pull-right"><i class="fa fa-circle" style="color: #D15B47;"></i> 3rd Offense&nbsp;&nbsp;</span>
				<span class="pull-right"><i class="fa fa-circle" style="color: #D6487E;"></i> 2nd Offense&nbsp;&nbsp;</span>
				<span class="pull-right"><i class="fa fa-circle" style="color: #F89406;"></i> 1st Offense&nbsp;&nbsp;</span>
				<span class="pull-right">Violation Level :&nbsp;&nbsp;</span>
			</div>
		</div>
	</div>
</div>
<?php 
	if($_GET['type'] == 'clist'){
		include "complaints/complaints.php";
		echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('List of Complaint'); $('#legendsofcomplaints').css('display', 'block'); $('#legendsofhouserules').css('display', 'none'); }) </script>";
	}else if($_GET['type'] == 'irlist'){
		include "complaints/incidentreports.php";
		echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('List of List of Violations'); $('#legendsofcomplaints').css('display', 'none'); $('#legendsofhouserules').css('display', 'block'); }) </script>";
	}else{
		include "complaints/complaints.php";
		echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('List of Complaint'); $('#legendsofcomplaints').css('display', 'block'); $('#legendsofhouserules').css('display', 'none'); }) </script>";
	}
	include "complaints/script.php";
	include "complaints/complaintsmodal.php";
	include "complaints/printcomplaints.php";
?>