<div class="row">
	<div class="col-xs-12">
		<div class="row form-group" style="margin-bottom: 0px;">
            <div class="col-xs-6 col-md-2" style="padding-bottom: 5px;padding-left:0px;">
                <select id="filterbymodule" onchange='$("#txtauditpage").val("1"); displayaudittrail();' class="form-control"></select>
            </div>
            <div class="col-xs-6 col-md-2" style="padding-bottom: 5px;padding-left:0px;">
                <span class="input-icon" style="width: 100%;">
                    <input type="text" class="form-control" placeholder="Search" id="txtaudittrail" title="Search">
                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                </span>
            </div>
            <div class="col-md-3 col-xs-12" style="padding-bottom: 5px;padding-left:0px;">
                <div class="input-daterange input-group">
                    <input type="text" class="form-control date-picker" id="dateFrom5" value="<?php echo date('m/d/Y'); ?>">
                    <span class="input-group-addon">
                        <i class="fa fa-exchange"></i>
                    </span>
                    <input type="text" class="form-control date-picker" id="dateTo5" value="<?php echo date('m/d/Y'); ?>">
                </div>
            </div>
            <div class="col-md-1 col-xs-6">
                <button class="btn btn-info btn-sm btn-round" onclick='$("#txtauditpage").val("1"); displayaudittrail();'><i class="fa fa-search"></i> Go</button>
            </div>
            <div class="col-md-2 col-xs-6 pull-right">
                <h5 class="pull-right"><a onclick="printaudittrail();" class="popover-info hide isadmin select-printaudittrail" data-rel="popover" data-placement="bottom" title="Print by"><i class="glyphicon glyphicon-print bigger-110"></i>&nbsp;&nbsp;Print</a></h5>
            </div>
		</div>
		<div class="row form-group" style="margin-bottom: 0px !important;">
            <div class="parent">
				<table class="table table-bordered fixTable">
                    <thead>
                        <tr>
							<th style="width: 15%;">User Name</th>
                            <th style="width: 9%;">Time</th>
                            <th style="width: 9%;">Date</th>
                            <th style="width: 15%;">Module</th>
                            <th style="width: 22%;">Action</th>
                            <th style="width: 30%;">Details</th>
                        </tr>
                    </thead>
                    <tbody id="displayaudittrail"></tbody>
                </table>
            </div>
            <table class="tabledash_footer table" style="margin: 0px !important;">
                <thead>
                    <tr>
                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                            <font id="txtauditrailentries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                            <input id="txtauditpage" type="hidden">
                            <ul id="ulpaginationaudittrail" class="pagination pull-right"></ul>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<?php
include("script.php");
include("printaudittrail.php");
?>