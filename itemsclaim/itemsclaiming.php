<style>
    .parent {
        height: 60vh;
    }
</style>
<div class="page-header">
    <div class="row form-group" style="margin-bottom: 0px;padding-top:10px;background-color: #edf4f8;padding-bottom: 10px;">
        <div class="col-md-3 col-xs-12">
            <h1 style="font-weight: bold;">BAGGAGE LOGS</h1>
        </div>
        <div class="col-md-9">
            <span class="label label-xlg label-success arrowed-in-right arrowed pull-right" style="margin-right: 5px;">Claimed</span>
            <span class="label label-xlg label-warning arrowed-in-right arrowed pull-right" style="margin-right: 5px;">Deposited</span>
        </div>
    </div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="row form-group" style="margin-bottom: 0px;">
			<div class="col-md-2 col-xs-12" style="padding-left: 0px;padding-bottom: 5px;">
				<span class="input-icon" style="width: 100%;">
                    <input type="text" class="form-control" placeholder="Search" id="txtItemListKey">
                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                </span>
            </div>
            <div class="col-md-2" style="padding-bottom: 5px;padding-left:0px;">
                <h5><a onclick="loadBaggageLogsFilter('BaggageLogs')" id="LINK_BaggageLogs_filter" class="popover-info" data-rel="popover" data-placement="bottom" title="Filter by" data-content='
                <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                    <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:95px;">&nbsp;&nbsp;Select by&nbsp;</legend>
                    <div class="form-group row" style="margin:0px;">
                        <div class="col-md-4">
                            <label>
                                <input name="form-field-checkboxselect" class="ace ace-checkbox-2 itemsfilter" type="checkbox" value="CardID" id="filter_CardID">
                                <span class="lbl"> Card ID</span>
                            </label> 
                        </div>
                        <div class="col-md-4">
                            <label>
                                <input name="form-field-checkboxselect" class="ace ace-checkbox-2 itemsfilter" type="checkbox" value="Description" id="filter_Description">
                                <span class="lbl"> Item</span>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <label>
                                <input name="form-field-checkboxselect" class="ace ace-checkbox-2 itemsfilter" type="checkbox" value="Name" id="filter_Name">
                                <span class="lbl"> Owner Name</span>
                            </label>
                        </div>
                    </div>
                </fieldset>

                <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                    <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:95px;">&nbsp;&nbsp;Status&nbsp;</legend>
                    <div class="form-group row" style="margin:0px;">
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            <label class="label label-lg label-warning arrowed-in-right arrowed">
                                <input name="form-field-checkboxstat" class="ace" type="checkbox" value="Deposited" id="filter_Deposited">
                                <span class="lbl"> Deposited</span>
                            </label> 
                        </div>
                        <div class="col-md-4">
                            <label class="label label-lg label-success arrowed-in-right arrowed">
                                <input name="form-field-checkboxstat" class="ace" type="checkbox" value="Claimed" id="filter_Claimed">
                                <span class="lbl"> Claimed</span>
                            </label>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </fieldset>

                <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_deposited">
                    <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:120px;">&nbsp;Date Deposited</legend>
                    <div class="form-group row" style="margin:0px;">
                        <div class="col-md-2">
                            <label style="margin-top:5px;">
                                <input name="form-field-checkbox" class="ace ace-checkbox-2" type="checkbox" id="chkdepositcheck" onclick="checkfirstdate();">
                                <span class="lbl"> Date</span>
                            </label>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                <input class="form-control div_depo date-picker" type="text" id="depositstart" data-provide="datepicker">
                            </div>                              
                        </div>
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                <input class="form-control div_depo date-picker" type="text" id="depositend" data-provide="datepicker">
                            </div>                              
                        </div>
                    </div>
                </fieldset>

                <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_claimed">
                    <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:100px;">&nbsp;&nbsp;Date Claimed</legend>
                    <div class="form-group row" style="margin:0px;">
                        <div class="col-md-2">
                            <label style="margin-top:5px;">
                                <input name="form-field-checkbox" class="ace ace-checkbox-2" type="checkbox" id="chkclaimcheck" onclick="checksecdate();">
                                <span class="lbl"> Date</span>
                            </label>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                <input class="form-control div_claim date-picker" type="text" id="claimstart" data-provide="datepicker">
                            </div>                              
                        </div>
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                <input class="form-control div_claim date-picker" type="text" id="claimend" data-provide="datepicker">
                            </div>                              
                        </div>
                    </div>
                </fieldset>

                <div class="form-group row" style="padding-left:8px;margin-bottom:0px;">
                    <div class="col-md-9" style="padding-right:0px;">
                        <div class="alert alert-info" style="padding-top:10px;padding-bottom:10px;">
                            <button class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
                            Click "<b>OK</b>" to filter data and permanently save the filter selected.
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-xs btn-info btn-round" onclick="saveBaggageLogsFilter()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">OK</button>
                    </div>
                </div>'><i class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;Select Filter here</a></h5>
            </div>
            <div class="col-md-4" style="padding-bottom: 5px;padding-left:0px;"></div>
            <div class="col-md-1 pull-right hide isadmin select-printbaggagelogs" style="padding-bottom: 5px;padding-left:0px;">
                <h5><a onclick="printbyfilter();" id="ehehe" class="popover-info" data-rel="popover" data-placement="bottom" style="float: right; margin-right: 15px; font-size: 15px;" title="Print by" data-content='
                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:95px;">&nbsp;&nbsp;Status&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-2"></div>
                            <div class="col-md-4">
                                <label class="label label-lg label-warning arrowed-in-right arrowed">
                                    <input name="form-field-checkbox" class="ace chkfilterbystat" type="checkbox" value="Deposited" checked>
                                    <span class="lbl"> Deposited</span>
                                </label> 
                            </div>
                            <div class="col-md-4">
                                <label class="label label-lg label-success arrowed-in-right arrowed">
                                    <input name="form-field-checkbox" class="ace chkfilterbystat" type="checkbox" value="Claimed" checked>
                                    <span class="lbl"> Claimed</span>
                                </label>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_deposited2">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:120px;">&nbsp;Date Deposited</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-2">
                                <label style="margin-top:5px;">
                                    <input name="form-field-checkbox" class="ace ace-checkbox-2" type="checkbox" id="chkdepositcheck2" onclick="checkfirstdate2();">
                                    <span class="lbl"> Date</span>
                                </label>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                    <input class="form-control div_depo2 date-picker" type="text" id="depositstart2" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>">
                                </div>                              
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                    <input class="form-control div_depo2 date-picker" type="text" id="depositend2" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>">
                                </div>                              
                            </div>
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_claimed2">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:100px;">&nbsp;&nbsp;Date Claimed</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-2">
                                <label style="margin-top:5px;">
                                    <input name="form-field-checkbox" class="ace ace-checkbox-2" type="checkbox" id="chkclaimcheck2" onclick="checksecdate2();">
                                    <span class="lbl"> Date</span>
                                </label>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                    <input class="form-control div_claim2 date-picker" type="text" id="claimstart2" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>">
                                </div>                              
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                    <input class="form-control div_claim2 date-picker" type="text" id="claimend2" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>">
                                </div>                              
                            </div>
                        </div>
                    </fieldset>

                    <div class="form-group row" style="padding-left:8px;margin-bottom:0px;">
                        <div class="col-md-9" style="padding-right:0px;">
                            <div class="alert alert-info" style="padding-top:10px;padding-bottom:10px;">
                                <button class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
                                Select the range of date you want to print.
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-xs btn-success btn-round" onclick="printmesenpai()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">Print</button>
                        </div>
                    </div'><i class="glyphicon glyphicon-print bigger-110"></i>&nbsp;&nbsp;Print</a>
                </h5>
            </div>
            <div class="col-md-2 pull-right" style="padding-bottom: 5px;padding-left:0px;">
                <button type="button" class="btn btn-sm btn-info btn-block isadmin hide select-deposititem btn-round" onclick="openmodal_deposititem();">Deposit Item</button>
            </div>
		</div>
		<div class="row form-group" style="margin-bottom: 0px !important;">
			<div class="parent">
				<table id="simple-table" class="table table-bordered fixTable">
        			<thead>
        				<tr>
        					<th width='10%'>Card ID<span class="btnsortdash-baggagelogs fa fa-sort bigger-130 pull-right" id="CardID"></span></th>
                                <th width='22%'>Owner's Name<span class="btnsortdash-baggagelogs fa fa-sort bigger-130 pull-right" id="Name"></span></th> 
                                <th width='25%'>Item<span class="btnsortdash-baggagelogs fa fa-sort bigger-130 pull-right" id="Description"></span></th>
                                <th width='10%'>Date In<span class="btnsortdash-baggagelogs fa fa-sort bigger-130 pull-right" id="DepositDate"></span></th>
                                <th width='10%'>Time In<span class="btnsortdash-baggagelogs fa fa-sort bigger-130 pull-right" id="DepositTime"></span></th>
                                <th width='10%'>Date Out<span class="btnsortdash-baggagelogs fa fa-sort bigger-130 pull-right" id="ClaimDate"></span></th>
                                <th width='10%'>Time Out<span class="btnsortdash-baggagelogs fa fa-sort bigger-130 pull-right" id="ClaimTime"></span></th>
                                <th width='1%'>Status<span class="btnsortdash-baggagelogs fa fa-sort bigger-130 pull-right" id="Status"></span></th>
        					<th width='2%' class='hide isadmin select-claimitem'>Option</th>
        				</tr>
        			</thead>
                    <tbody id="tbldepositlist"></tbody>
                </table>
            </div>
            <table class="tabledash_footer table" style="margin: 0px !important;">
                <thead>
                    <tr>
                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                            <font id="txtItemListEntries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                            <input id="txtItemListPage" type="hidden">
                            <ul id="ulPaginationItemList" class="pagination pull-right"></ul>
                        </th>
                    </tr>
                </thead>
            </table>
		</div>
	</div>
</div>

<div class="modal fade fade-scale" id="modal_deposititem">
    <div class="modal-dialog modal-md">
        <div class="modal-content" style="width:100% !important;">
            <div id="depositloading"></div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="closemodal_deposititem()">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Deposit Item</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="row form-group">
                            <div class="col-md-3">
                                Card ID
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control deposit_required" id="txtCardID">
                            </div>
                            <div class="col-md-2">
                                Quantity
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control deposit_required" id="txtQuantity">
                            </div>
                        </div>
                        <div class="row form-group" style="margin-top: -10px;">
                            <div class="col-md-3">
                                Name
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control deposit_required" id="txtNames">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                Item Description
                            </div>
                            <div class="col-md-9">
                                <textarea class="form-control deposit_required" id="txtItemDescription" style="resize: none;height: 90px;"></textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                Notes
                            </div>
                            <div class="col-md-9">
                                <textarea class="form-control" id="txtNotes" style="resize: none;height: 90px;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-primary btn-round" onclick="savedeposititem();"><i class="fa fa-check"></i> Save</button>
            </div>
        </div>
    </div>
</div>

<div id="txtItemListPrint" style="display: none;">
    <table style="width: 100%;" cellspacing="0" cellpadding="0">
        <tbody id="template"></tbody>
    </table>
    <p style="font-size: 15px; text-align: right;">From:&nbsp;&nbsp;<label id="txtItemListPrintDateFrom"></label>&nbsp;&nbsp;To&nbsp;&nbsp;<label id="txtItemListPrintDateTo"></label></p>
    <center style="font-size: 22px;font-weight: bold;background-color: #666;color: white;width: 100%;margin-top: -15px;">Baggage Logs</center>
    <table style="width: 100%;">
        <thead>
            <tr>
                <td>Card ID</td>
                <td>Owner's Name</td>
                <td>Item</td>
                <td>Date In</td>
                <td>Time In</td>
                <td>Date Out</td>
                <td>Time Out</td>
                <td>Status</td>
            </tr>
            <td colspan="8"><hr></td>
        </thead>
        <tbody id="tblItemListPrint"></tbody>
    </table>
</div>

<input type="hidden" id="BaggageLogsSortType" value="ASC">
<input type="hidden" id="BaggageLogsSortBy" value="CardID">

<?php
    include("script.php");
?>