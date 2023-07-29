<div class="row">
    <div class="col-xs-12">
        <div class="row form-group" style="margin-bottom: 0px;">
            <div class="col-md-2 col-xs-12" style="padding-bottom: 5px;padding-right: 0px;">
                <span class="input-icon" style="width: 100%;">
                    <input type="text" class="form-control" id="txtsearchpen" title="Search" placeholder="Search">
                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                </span>
            </div>
            <div class="col-md-4" style="padding-bottom: 5px;padding-right:0px;">
                <h5><a onclick="loadPenaltyFilter('Penalty')" id="LINK_Penalty_filter" class="popover-info" data-rel="popover" data-placement="bottom" title="Filter by" data-content='
                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                    <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:95px;">&nbsp;&nbsp;Search by&nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-6">
                                <label>
                                    <input name="form-field-checkboxpen" class="ace ace-checkbox-2 tenant_module_filter" type="checkbox" value="a.TenantID" id="filter_a.TenantID">
                                    <span class="lbl"> <?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?> ID</span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label>
                                    <input name="form-field-checkboxpen" class="ace ace-checkbox-2 tenant_module_filter" type="checkbox" value="b.tradename" id="filter_b.tradename">
                                    <span class="lbl"> <span class="thSysTenant"></span></span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label>
                                    <input name="form-field-checkboxpen" class="ace ace-checkbox-2 tenant_module_filter" type="checkbox" value="a.reference" id="filter_a.reference">
                                    <span class="lbl"> Penalty Code</span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label>
                                    <input name="form-field-checkboxpen" class="ace ace-checkbox-2 tenant_module_filter" type="checkbox" value="a.description" id="filter_a.description">
                                    <span class="lbl"> Description</span>
                                </label>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_chkappdate">
                    <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:55px;">&nbsp;&nbsp;Date&nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                    <input class="form-control div_app date-picker" type="text" name="" id="pendatefrom" data-provide="datepicker">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                    <input class="form-control div_app date-picker" type="text" name="" id="pendateto" data-provide="datepicker">
                                </div>
                            </div>
                            <div class="col-md-1"></div>
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
                            <button class="btn btn-xs btn-info btn-round" onclick="savePenaltyFilter()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">OK</button>
                        </div>
                    </div>'>
                    <i class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;Select Filter here</a>
                </h5>
            </div>
            <div class="col-md-4" style="padding-bottom: 5px;text-align: right;"></div>
            <div class="col-md-2 col-xs-12" style="padding-bottom: 5px;padding-right: 0px;">
                <button class="btn btn-info btn-sm pull-right btn-block hide isadmin select-postpenalty btn-round" onclick="showcreatenewpenalty();"> Post Penalty</button>
            </div>
        </div>
        <div class="row form-group" style="margin-bottom: 0px !important;">
            <div class="parent">
                <table id="simple-table" class="table  table-bordered table-striped fixTable">
                    <thead>
                        <tr>
                            <th style="width: 7%;">Date</th>
                            <th style="width: 10%;"><?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?> ID</th>
                            <th style="width: 15%;" class="thSysTenant">Trade Name</th>
                            <th style="width: 10%;">Penalty Code</th>
                            <th style="width: 20%;">Description</th>
                            <th style="width: 8%; text-align: right;">Amount</th>
                            <th style="width: 8%; text-align: right;">VAT Amount</th>
                            <th style="width: 9%; text-align: right;">Total Amount</th>
                            <th style="width: 8%; text-align: right;">Balance</th>
                            <th style="width: 5%;z-index: 1;">Option</th>
                        </tr>
                    </thead>
                    <tbody id="tbllistofpenalties"></tbody>
                </table>
            </div>
            <table class="tabledash_footer table" style="margin: 0px !important;">
                <thead>
                    <tr>
                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                            <font id="txtbillingentries123" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                            <input id="txt_userpage10" type="hidden">
                            <ul id="ulpaginationlistofpenalties" class="pagination pull-right"></ul>
                        </th>
                    </tr>
                </thead>
            </table>
        </div> 
    </div>
</div>

<div class="modal fade fade-scale" id="createnewpenalty" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="closeandclear();">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Posting of Penalty</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4 col-xs-12">
                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="widget-box widget-color-blue3">
                                    <div class="widget-header">
                                        <h5 class="widget-title txtPanelHeader">Tenant Information</h5>
                                    </div>
                                    <div class="widget-body">
                                        <div class="widget-main padding-6"> 
                                            <div class="well">
                                                <div class="row">
                                                    <div class="row form-group">
                                                        <label class="col-md-12">Date</label>
                                                        <div class="col-md-12">
                                                            <input type="text" class="form-control date-picker" style="background-color: white !important;" disabled id="txtPPTransDate">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <label class="col-md-12 thSysTenant">Tenant</label>
                                                        <div class="col-md-12">
                                                            <select class="form-control txtPPInitiateClear searchy_select" id="txtPPTenant" onchange="showTenantInfo();"></select>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <div class="row form-group">
                                                                <label class="col-md-12">Status</label>
                                                                <div class="col-md-12">
                                                                    <input type="text" class="form-control txtPPInitiateClear" style="background-color: white !important;" readonly id="txtPPStatus">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <label class="col-md-12">Billing Type</label>
                                                        <div class="col-md-12">
                                                            <input type="text" class="form-control txtPPInitiateClear" style="background-color: white !important;" readonly id="txtPPBillingType">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-toolbox padding-8 clearfix">
                                        <a href="#" class="btn btn-primary btn-sm pull-right btn-round" style="float: right;" onclick="PostPPCharges()"><i class="ace-icon fa fa-check"></i>&nbsp;Post Penalty</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-xs-12">
                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="btn-group pull-right">
                                    <button class="btn btn-sm btn-info btn-round" onclick="fncCheckPTenantFirst();">Add Penalty</button>
                                    <button class="btn btn-sm btn-success btn-round" onclick="btnPPSelectAll();">Select All</button>
                                    <button class="btn btn-sm btn-warning btn-round" onclick="btnPPUnselectAll();">Unselect All</button>
                                    <button class="btn btn-sm btn-danger btn-round" onclick="btnPPRemoveSelected();">Remove Penalty</button>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group" style="margin-top: -10px;">
                            <div class="col-md-12">
                                <div class="widget-box widget-color-blue3">
                                    <div class="widget-body" style="height: 390px;">
                                        <div class="widget-main" style="padding: 0px;">
                                            <div style="">
                                                <table class="table table-bordered table-hover fixTable">
                                                    <thead>
                                                        <tr>
                                                            <th style="background-color: #6379AA;color: white;width: 15%;">Penalty Code</th>
                                                            <th style="background-color: #6379AA;color: white;width: 25%;">Penalty</th>
                                                            <th style="background-color: #6379AA;color: white;width: 15%;">Reference</th>
                                                            <th style="background-color: #6379AA;color: white;width: 15%;text-align: right;">Amount</th>
                                                            <th style="background-color: #6379AA;color: white;width: 15%;text-align: right;">VAT</th>
                                                            <th style="background-color: #6379AA;color: white;width: 15%;text-align: right;">Total Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyPenaltyList"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-toolbox padding-8 clearfix">
                                        <div class="row">
                                            <div class="col-lg-9 col-xs-6" style="font-weight: bold;text-align: right;">
                                                <p style="margin-bottom: 0px; font-size: 19.5px;">Total Amount :</p>
                                            </div>
                                            <div class="col-lg-3 col-xs-6" style="font-weight: bold;">
                                                <p id="txtPPTotalCharges" style="text-align: right;margin-bottom: 0px; font-size: 19.5px;">0.00</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>      
                            </div>
                        </div>
                    </div>
                    <div class="form-group row" style="margin-bottom: 0px;">
                        <div class="col-lg-12 col-xs-12">
                            <div class="hr hr8 hr-double hr-dotted"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdlBillPenaltyList" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Penalty List</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-4 col-md-4 col-lg-4">
                        <span class="input-icon" style="width: 100%;">
                            <input type="text" class="form-control" id="txtBillSearchPenalty" title="Search" placeholder="Search">
                            <i class="ace-icon fa fa-search nav-search-icon"></i>
                        </span>
                    </div>
                    <div class=" col-xs-12 col-md-12 col-lg-12">
                        <div class="parent2" style="margin-top: 10px;"> 
                            <table class="table table-bordered table-hover fixTable">
                                <thead>
                                    <tr>
                                        <th style="width: 20%;">Penalty Code</th>
                                        <th style="width: 60%;">Penalty Description</th>                
                                        <th style="width: 20%; text-align: right;">Amount</th>                
                                    </tr>
                                </thead>
                                <tbody id="tblBillPenaltyList"></tbody>
                            </table>
                        </div>
                        <table class="tabledash_footer table" style="margin: 0px !important;">
                            <thead>
                                <tr>
                                    <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                        <font style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                        <input type="hidden">
                                        <ul class="pagination pull-right"></ul>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ADD QUANTITY -->
<div class="modal fade fade-scale" id="mdlPenaltyInfo" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Post Penalty</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row form-group">
                            <label class="col-md-12">Penalty Code</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control txtPPHiddenValue" id="txtPPCode" readonly style="background-color: white !important;">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-12">Penalty Description</label>
                            <div class="col-md-12">
                                <textarea class="form-control txtPPHiddenValue" style="resize: none;height: 100px;background-color: white !important;" id="txtPPDescription" readonly></textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-12">Amount</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control txtPPHiddenValue amount" id="txtPPRate" style="background-color: white !important;text-align: right;" onkeypress="return isNumberKey(event)">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-12">Reference</label>
                            <div class="col-md-12">
                                <textarea class="form-control" style="resize: none;height: 100px;" id="txtPPBillingParticulars"></textarea>
                            </div>
                        </div>
                    </div>
                </div>              
            </div>
            <div class="modal-footer">
                <div class="btn-group">
                    <button class="btn btn-sm btn-primary btn-round" id="wotaskmodalclose" onclick="fncgetSelectedPenalties();">Add</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("script.php"); ?>