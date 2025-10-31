<div class="page-header">
    <div class="row form-group" style="margin-bottom: 0px;padding-top:10px;background-color: #edf4f8;padding-bottom: 10px;">
        <div class="col-md-3">
            <h1 style="font-weight: bold;"><?php if(SysLeaseSetup('softwaretype') == '5'){ echo "BUYER"; }else{ echo "TENANTS"; } ?></h1>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-8">
            <label class='label label-xlg pull-right arrowed-in-right arrowed label-inverse'>Terminated</label>
            <label class='label label-xlg pull-right arrowed-in-right arrowed label-danger'>Expired Lease</label>
            <label class='label label-xlg pull-right arrowed-in-right arrowed label-warning'>On Hold</label>
            <label class='label label-xlg pull-right arrowed-in-right arrowed label-success'>Active</label>
            <label class='label label-xlg pull-right arrowed-in-right arrowed label-purple'>Arrival</label>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-xs-12">
        <div class="row form-group" style="margin-bottom: 0px;">
            <div class="col-md-2 col-xs-12" style="padding-bottom: 5px;padding-left:0px;">
                <span class="input-icon" style="width: 100%;">
                    <input type="text" class="form-control" placeholder="Search" title="Search" id="txtsearchtenantlist">
                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                </span>
            </div>
            <div class="col-md-2 col-xs-2" style="padding-bottom: 5px;padding-left:0px;">
                <h5><a onclick="loadTenantsFilter('Tenant')" id="LINK_Tenant_filter" class="popover-info" data-rel="popover" data-placement="bottom" title="Filter by" data-content='
                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                    <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:95px;">&nbsp;&nbsp;Search by&nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-6">
                                <label>
                                    <input name="form-field-checkboxtttttttt" class="ace ace-checkbox-2 tenant_module_filter" type="checkbox" value="TenantID" id="filter_TenantID">
                                    <span class="lbl"> <?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?> ID</span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label>
                                    <input name="form-field-checkboxtttttttt" class="ace ace-checkbox-2 tenant_module_filter" type="checkbox" value="merchant_code" id="filter_merchant_code">
                                    <span class="lbl"> Merchant Code</span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label>
                                    <input name="form-field-checkboxtttttttt" class="ace ace-checkbox-2 tenant_module_filter" type="checkbox" value="tradename" id="filter_tradename">
                                    <span class="lbl"> <span class="thSysTenant"></span></span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label>
                                    <input name="form-field-checkboxtttttttt" class="ace ace-checkbox-2 tenant_module_filter" type="checkbox" value="companyname" id="filter_companyname">
                                    <span class="lbl"> Company Name</span>
                                </label>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                    <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:120px;">&nbsp;&nbsp;Tenant Status&nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-6">
                                <label style="margin-bottom: 0px;margin-top: 0px;margin-right: 30px;">
                                    <input name="form-field-checkbox-tstatus" class="ace ace-checkbox-2 chk_tenant_tstatus" type="checkbox" value="Occupied" id="filter_Occupied">
                                    <span class="lbl"> Occupied Tenants </span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label style="margin-bottom: 0px;margin-top: 0px;margin-right: 30px;">
                                    <input name="form-field-checkbox-tstatus" class="ace ace-checkbox-2 chk_tenant_tstatus" type="checkbox" value="Unoccupied" id="filter_Unoccupied">
                                    <span class="lbl"> Arrival Tenants </span>
                                </label>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                    <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:100px;">&nbsp;&nbsp;Filter Status&nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-6">
                                <label class="label label-lg label-success arrowed-in-right arrowed">
                                    <input name="form-field-checkbox-stado" class="ace" type="checkbox" value="Active" id="filter_Active">
                                    <span class="lbl"> Active </span>
                                </label>  
                            </div>
                            <div class="col-md-6">
                                <label class="label label-lg label-warning arrowed-in-right arrowed">
                                    <input name="form-field-checkbox-stado" class="ace" type="checkbox" value="OnHold" id="filter_OnHold">
                                    <span class="lbl"> On Hold </span>
                                </label>  
                            </div>
                            <div class="col-md-6">
                                <label class="label label-lg label-danger arrowed-in-right arrowed">
                                    <input name="form-field-checkbox-stado" class="ace" type="checkbox" value="ExpiredLease" id="filter_ExpiredLease">
                                    <span class="lbl"> Expired Lease </span>
                                </label>  
                            </div>
                            <div class="col-md-6">
                                <label class="label label-lg label-inverse arrowed-in-right arrowed">
                                    <input name="form-field-checkbox-stado" class="ace" type="checkbox" value="Terminated" id="filter_Terminated">
                                    <span class="lbl"> Terminated </span>
                                </label>  
                            </div>
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_chkappdate">
                    <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:110px;">&nbsp;&nbsp;Contract Date&nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                    <input class="form-control div_app date-picker" type="text" name="" id="contractstart" data-provide="datepicker">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                    <input class="form-control div_app date-picker" type="text" name="" id="contractend" data-provide="datepicker">
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
                        <button class="btn btn-xs btn-info btn-round" onclick="saveTenantFilter()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">OK</button>
                    </div>'>
                    <i class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;Select Filter here</a></h5>
            </div>
            <div class="col-md-2 col-xs-12 pull-right" style="padding-bottom: 5px;padding-right:0px;">
                <button class="btn btn-primary btn-sm btn-round btn-block" onclick="$arr = [];$arr.push( 'key='+$('#txtsearchtenantlist').val() );getheaderprint('<?php echo $_SESSION['MMS-Designation']; ?>','tenantslist',JSON.stringify($arr));"> List of Tenants</button>
            </div>
            <div class="col-md-2 col-xs-12 pull-right" style="padding-bottom: 5px;padding-right:0px;">
                <button class="btn btn-info btn-sm hide isadmin select-createnewtenant btn-round" style="width: 100% !important;" onclick="fncNewInquiry();">New <?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?></button>
            </div>
        </div>
        <div class="row form-group" style="margin-bottom: 0px !important;">
            <div class="parent">
                <table class="table table-bordered table-striped fixTable">
                    <thead>
                        <tr>
                            <th><?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?> ID</th>
                            <th>Unit</th>
                            <th>Store Code</th>
                            <th class="thSysTenant">Trade Name</th>
                            <th>Company Name</th>
                            <th>Occupancy Date</th>
                            <th>Billing Type</th>
                            <th>Industry</th>
                            <th style="z-index: 1;">Status</th>
                            <th style="z-index: 1;">Options</th>
                        </tr>
                    </thead>
                    <tbody id="tbltenantlists"></tbody>
                </table>
            </div>
            <table class="tabledash_footer table" style="margin: 0px !important;">
                <thead>
                    <tr>
                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                            <font id="txtTenantListEntries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                            <input id="txtLoadTenantPageCount" type="hidden">
                            <ul id="ulTenantListPageCont" class="pagination pull-right"></ul>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" role="dialog" id="mdl_NewTPComplaints">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick='$("#mdl_NewTPComplaints").modal("hide");$("#mdl_NewTPComplaints :input").val("");'>&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">New Complaint</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-12">
                       Complaint Code
                    </div>
                    <div class="col-md-12">
                        <div class="input-group">
                            <select class="form-control newComplaintCodeReq2" id="txtTPComplaints" onchange="ShowPreDescription(this.value);"></select>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-sm btn-success" onclick="AddTPComplaintCode()">
                                    <span class="fa fa-plus"></span>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-12">
                        Complaint Description
                    </div>
                    <div class="col-md-12">
                        <textarea class="form-control newComplaintCodeReq2" style="height: 100px;resize: none;" id="txtTPDescription"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-round btn-sm" onclick="SavenewTPComplaints();"><span class="fa fa-check"></span> Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" role="dialog" id="mdl_NewTPComplaintCode">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick='$("#mdl_NewTPComplaintCode").modal("hide");$("#txtTPAddComplaints").val("");$("#txtTPAddDescription").val("");'>&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">New Complaint</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-12">
                       Complaint Code
                    </div>
                    <div class="col-md-12">
                        <input type="text" class="form-control newComplaintCodeReq" id="txtTPAddComplaints">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-12">
                        Complaint Description
                    </div>
                    <div class="col-md-12">
                        <textarea class="form-control newComplaintCodeReq" style="height: 100px;resize: none;" id="txtTPAddDescription"></textarea>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-12">
                        Priority Status
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <div class="radio">
                                <label>
                                    <input name="form-field-radio" type="radio" class="ace radPrioStat" value="High Priority">
                                    <span class="lbl">&nbsp;High</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="radio">
                                <label>
                                    <input name="form-field-radio" type="radio" class="ace radPrioStat" value="Medium Priority">
                                    <span class="lbl">&nbsp;Medium</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="radio">
                                <label>
                                    <input name="form-field-radio" type="radio" class="ace radPrioStat" value="Low Priority" checked>
                                    <span class="lbl">&nbsp;Low</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm btn-round" onclick="SaveNewComplaintCode();"><span class="fa fa-check"></span> Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdlAmendment" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Contract Amendments</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3 pull-right">
                        <button class="btn btn-info btn-sm btn-round btn-block">Create Amendment</button>
                    </div>
                    <div class=" col-xs-12 col-md-12 col-lg-12">
                        <div style="margin-top: 10px;" class="parent"> 
                            <table class="table table-bordered table-hover fixTable">
                                <thead>
                                    <tr>
                                        <th style="width: 20%;">Amendment No.</th>
                                        <th style="width: 20%;">Date Created</th>
                                        <th style="width: 20%;">Created By</th>
                                        <th style="width: 20%;">Status</th>                   
                                        <th style="width: 20%;">Actions</th>                   
                                    </tr>
                                </thead>
                                <tbody id="tbodyAmendmentList"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger btn-sm btn-round" onclick="$('#mdlAmendment').modal('hide');">Close</button>
            </div>
        </div>
    </div>
</div>

<?php
    include("tenantscripts.php");
    include("modaltenantinfos.php");
    include("global_form/index.php");
    include("global_events/index.php");
?>