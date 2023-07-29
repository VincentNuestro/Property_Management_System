<style>
.ace-settings-box.open {
    max-width: 800px !important;
}

.myupload{
    border: dashed 1px #999;
    padding: 15px;
    display: block;
    margin: 10px;
}
.myupload h1{
    font-size: 18px;
    font-weight: 400 !important;
    color: #999;
    text-align: center;
    margin-top: 10px;
    margin-bottom: 20px;
}
.myupload input[type="file"]{ 
    opacity: 0; 
}
</style>

<div class="page-header">
    <div class="row form-group" style="margin-bottom: 0px;padding-top:10px;background-color: #edf4f8;padding-bottom: 10px;">
        <div class="col-md-6">
            <h1 style="font-weight: bold;" id="<!-- txtMainModuleHeader -->">MAINTENANCE</h1>
            <h6 style="color:#2679B5;">&nbsp;&nbsp;&nbsp;<label id="txtpageheader"></label></h6>
        </div>
        <div class="col-md-6">
            <div id="pangwo" style="display: none;" class="pull-right">
                <span class="label label-xlg label-success arrowed-in-right arrowed">Resolved</span>
                <span class="label label-xlg label-warning arrowed-in-right arrowed">Pending</span>
                <span class="label-xlg bolder">|</span>
                <span class="label label-xlg label-primary arrowed-in-right arrowed">Posted</span>
                <span class="label label-xlg label-danger arrowed-in-right arrowed">Not Posted</span>
            </div>
            <div id="pangcomplaints" style="display: none;">
                <span class="label label-xlg label-yellow arrowed-in-right arrowed pull-right">Low Priority</span>
                <span class="label label-xlg label-warning arrowed-in-right arrowed pull-right">Medium Priority</span>
                <span class="label label-xlg label-danger arrowed-in-right arrowed pull-right">High Priority</span>
            </div>
            <div id="pangmeter" style="display: none;" class="pull-right">
                <span>Status :</span>
                <span class='fa fa-flash orange'></span> Electric |
                <span class='fa fa-tint blue'></span> Water |
                <span class='fa fa-fire red'></span> Gas
            </div>
        </div>
    </div>
</div>

<?php 
    if($_GET['type'] == 'wolist'){
        include "maintenance/workorder/index.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtMainModuleHeader').text('Maintenance - Work Order'); $('#txtpageheader').text('List of Work Order'); $('#pangwo').css('display', 'block'); $('#pangcomplaints').css('display', 'none'); $('#pangmeter').css('display', 'none'); }) </script>";
    }else if($_GET['type'] == 'complaints'){
        include "maintenance/complaints/index.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtMainModuleHeader').text('Maintenance - Complaints'); $('#txtpageheader').text('List of Complaint'); $('#pangwo').css('display', 'none'); $('#pangcomplaints').css('display', 'block'); $('#pangmeter').css('display', 'none');}) </script>";
    }else if($_GET['type'] == 'budget'){
        include "maintenance/budget/index.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtMainModuleHeader').text('Maintenance - Budget'); $('#txtpageheader').text('List of Maintenance Budget'); $('#pangwo').css('display', 'none'); $('#pangcomplaints').css('display', 'none'); $('#pangmeter').css('display', 'none');}) </script>";
    }else if($_GET['type'] == 'metermanagement'){
        include "maintenance/metermanagement/index.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtMainModuleHeader').text('Maintenance - Meter Management'); $('#txtpageheader').text('List of Meter'); $('#pangwo').css('display', 'none'); $('#pangcomplaints').css('display', 'none'); $('#pangmeter').css('display', 'block');}) </script>";
    }else if($_GET['type'] == 'asset'){
        include "maintenance/asset/index.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtMainModuleHeader').text('Maintenance - Assets & Equipments'); $('#txtpageheader').text('List of Asset & Equipments'); $('#pangwo').css('display', 'none'); $('#pangcomplaints').css('display', 'none'); $('#pangmeter').css('display', 'none');}) </script>";
    }else{
        include "maintenance/workorder/index.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtMainModuleHeader').text('Maintenance - Work Order'); $('#txtpageheader').text('Work Order List'); $('#pangwo').css('display', 'block'); $('#pangcomplaints').css('display', 'none'); $('#pangmeter').css('display', 'none');}) </script>";
    }
?>
