<!-- ADDING OF WORK ORDER -->
<div class="modal fade fade-scale" id="mdlNewWorkOrder" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Create Work Order</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="widget-box widget-color-blue3">
                                    <div class="widget-header">
                                        <h5 class="widget-title txtPanelHeader">Tenant Information</h5>
                                    </div>
                                    <div class="widget-body">
                                        <div class="widget-main padding-6"> 
                                            <div class="well">
                                                <div class="row" style="height: 48.5vh; overflow-y: scroll; overflow-x: hidden;">
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <label class="control-label thSysTenant">Tenant</label>
                                                            <label class="pull-right">
                                                                <input type="checkbox" class="ace" id="chkAllTenant" onclick="fncSelectAllTenant();">
                                                                <span class="lbl middle padding-4"> Select All</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <select id="txtWoTenant" class="form-control searchy_select txtCWOReq" multiple style="width: 100%;" data-placeholder="-- Select Tenant --"></select>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <label class="control-label">Assigned Department</label>
                                                        </div>
                                                        <div class="col-md-12" id="divDepSetHeight">
                                                            <select id="txtWoDepartment" class="form-control searchy_select2 txtCWOReq" onchange="fncShowPersonnel(); fncAllowSelectAll();" style="width: 100%;" data-placeholder="-- Select Department --"></select>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <label class="control-label">Assigned Personnel</label>
                                                            <label class="pull-right">
                                                                <input type="checkbox" class="ace" id="chkAllPersonnel" onclick="fncSelectAllPersonnel();">
                                                                <span class="lbl middle padding-4"> Select All</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <select id="txtWoPersonnel" class="form-control searchy_select txtCWOReq" multiple style="width: 100%;" data-placeholder="-- Select Personnel --">
                                                                <option value=''>-- Select Personnel --</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <label class="control-label">Remarks</label>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <textarea class="form-control" id="txtWoRemarks" style="resize: none;height: 60px;" maxlength="255"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-toolbox padding-8 clearfix">
                                        <button id="btnWoSave" class="btn btn-primary btn-sm pull-right btn-round" style="float: right;" onclick="fncCreateWorkOrder()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving..."><i class="ace-icon fa fa-check"></i>&nbsp;Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="btn-group pull-right">
                                    <button class="btn btn-sm btn-danger pull-right btn-round" onclick="fncMainDelete();">&nbsp;Remove Task</button>
                                    <button class="btn btn-sm btn-warning pull-right btn-round" onclick="fncMainUncheckAll();" style="margin-right: 5px;">&nbsp;Unselect All</button>
                                    <button class="btn btn-sm btn-success pull-right btn-round" onclick="fncMainCheckAll();" style="margin-right: 5px;">&nbsp;Select All</button>
                                    <button class="btn btn-sm btn-info pull-right btn-round" onclick="$('#mdlMainTask').modal('show'); fncloadSelectFilterCategory(); fncLoadAddTask(); $('#tbodySelectedTask tr').unbind('click');" style="margin-right: 5px;">&nbsp;Add Task</button>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group" style="margin-top: -10px;">

                            <div class="col-md-12">
                                <div class="widget-box widget-color-blue3">
                                    <div class="widget-body">
                                        <div class="widget-main" style="padding: 0px;">
                                            <div class="parent">
                                                <table class="table table-bordered table-hover fixTable">
                                                    <thead>
                                                        <tr>
                                                            <th style="background-color: #6379AA;color: white;width: 25%;">Category</th>
                                                            <th style="background-color: #6379AA;color: white;width: 35%;">Task</th>
                                                            <th style="background-color: #6379AA;color: white;width: 20%;">Reading Date</th>
                                                            <th style="background-color: #6379AA;color: white;width: 20%;text-align: right;">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodySelectedTask"></tbody>
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
                                                <p id="txtWOTotalAmount" style="text-align: right;margin-bottom: 0px; font-size: 19.5px;">0.00</p>
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

<!-- ADDING OF TASK -->
<div class="modal fade fade-scale" id="mdlMainTask" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="fncCloseTaskSelection();">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Select Task</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-4 col-md-4 col-lg-4" id="divSelectTaskCat">
                        <select id="txtWOSelectFilterCategory" class="form-control searchy_select" onchange="fncLoadAddTask();" style="width: 100%;"></select>
                    </div>
                    <div class="col-xs-4 col-md-4 col-lg-4">
                        <span class="input-icon" style="width: 100%;">
                            <input type="text" class="form-control" id="txtSelectSearchTask" title="Search" placeholder="Search">
                            <i class="ace-icon fa fa-search nav-search-icon"></i>
                        </span>
                    </div>
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="parent" style="margin-top: 10px;">
                            <table class="table table-bordered table-hover fixTable">
                                <thead>
                                    <tr>
                                        <th style="width: 40%;">Category</th>       
                                        <th style="width: 40%;">Task</th>       
                                        <th style="text-align: right; width: 20%;">Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodySelectTask"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger btn-sm btn-round" onclick="fncCloseTaskSelection();">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL FOR VIEWING DETAILS -->
<div class="modal fade fade-scale" id="detailedWO" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick='$("#detailedWO").modal("hide");tblworkorder();'>&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Work Order Details</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Tenant Information -->
                        <div class="widget-container-col ui-sortable">
                            <div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
                                <div class="widget-header">
                                    <h4 class="widget-title txtPanelHeader"> Information</h4>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="row ">
                                            <div class="col-md-12">
                                                <div class="row form-group">
                                                    <div class="row form-group">
                                                        <div class="col-md-3">
                                                            <img class="img-thumbnail form-control" src="assets/images/noimage5.png" id="imgViewWOTenantImage" style="border: 2px solid #bdc3c7; height: 200px;">
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-xs-12">
                                                                <h2 class="blue header bolder" id="txtViewWOTradeName"></h2>
                                                            </div>
                                                            <div class="col-xs-12">
                                                                <div class="row form-group">
                                                                    <div class="profile-user-info profile-user-info-striped">
                                                                        <div class="profile-info-row">
                                                                            <div class="profile-info-name" style="white-space: nowrap;"> <?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?> ID </div>
                                                                            <div class="profile-info-value">
                                                                                <span id="txtViewWOTenantID"></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="profile-info-row">
                                                                            <div class="profile-info-name" style="white-space: nowrap;"> Company Name </div>
                                                                            <div class="profile-info-value">
                                                                                <span id="txtViewWOCompany"></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="profile-info-row">
                                                                            <div class="profile-info-name txtSysBuilding" style="white-space: nowrap;"> Mall </div>
                                                                            <div class="profile-info-value">
                                                                                <span id="txtViewWOMall"></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="profile-info-row">
                                                                            <div class="profile-info-name" style="white-space: nowrap;"> Contact Person </div>
                                                                            <div class="profile-info-value">
                                                                                <span id="txtViewWOContactPerson"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                          </div>
                        </div>
                        <div class="widget-container-col ui-sortable">
                            <div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
                                <div class="widget-header">
                                    <h4 class="widget-title">Work Order Information</h4>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="row well">
                                            <div class="row">
                                                <div class="row form-group">
                                                    <div class="col-md-3">
                                                        <div class="row form-group">
                                                            <label class="col-md-12">Start Date</label>
                                                            <div class="col-md-12">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control date-picker btnforscheduling" value="<?php echo date('m/d/Y'); ?>" id="txtViewWOStarDate" style="background-color: white !important;">
                                                                    <label class="input-group-addon"><i class="fa fa-calendar"></i></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="row form-group">
                                                            <label class="col-md-12">Start Time</label>
                                                            <div class="col-md-12">
                                                                <div class="input-group">
                                                                    <input type="time" class="form-control btnforscheduling" value="<?php echo date('H:i'); ?>" id="txtViewWOStartTime" style="background-color: white !important;">
                                                                    <label class="input-group-addon"><i class="fa fa-clock-o"></i></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="row form-group">
                                                            <label class="col-md-12">End Date</label>
                                                            <div class="col-md-12">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control date-picker btnforscheduling"  id="txtViewWOEndDate" style="background-color: white !important;">
                                                                    <label class="input-group-addon"><i class="fa fa-calendar"></i></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="row form-group">
                                                            <label class="col-md-12">End Time</label>
                                                            <div class="col-md-12">
                                                                <div class="input-group">
                                                                    <input type="time" class="form-control btnforscheduling" id="txtViewWOEndTime" style="background-color: white !important;">
                                                                    <label class="input-group-addon"><i class="fa fa-clock-o"></i></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="row form-group">
                                                            <label class="col-md-12">Work Order ID</label>
                                                            <div class="col-md-12">
                                                                <input type="text" class="form-control" id="txtViewWOID" disabled style="background-color: white !important;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="row form-group">
                                                            <label class="col-md-12">Status</label>
                                                            <div class="col-md-12">
                                                                <input type="text" class="form-control" id="txtViewWOStatus" disabled style="background-color: white !important;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="row form-group">
                                                            <label class="col-md-12">Department</label>
                                                            <div class="col-md-12" id="divViewWODepartment">
                                                                <select class="form-control searchy_select btnforscheduling" id="txtViewWOUserDepartment" style="background-color: white !important; width: 100%;"></select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="row form-group">
                                                            <label class="col-md-12">Personnel</label>
                                                            <div class="col-md-12">
                                                                <select multiple class="form-control searchy_select btnforscheduling" id="txtViewWOPersonnel" style="background-color: white !important;"></select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-control-group">
                                                    <div class="col-md-12">
                                                        <button class="btn btn-primary btn-sm pull-right btn-round btnforscheduling" onclick="fncSaveWOSchedule();"><i class="fa fa-check"></i>&nbsp;Save Schedule</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- JOB AND TASK LIST CONTAINER -->
                        <div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
                            <div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
                                <div class="widget-header">
                                    <h4 class="widget-title"> Work Order Task List</h4>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="row well">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="preLoad_div_jobandtask"></div>
                                                    <div id="div_jobandtask"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger btn-sm btn-round" onclick='$("#detailedWO").modal("hide");tblworkorder();'>Close</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL FOR SHOWING PROGRESS PER TASK -->
<div class="modal fade fade-scale" id="taskscheduler" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;" id="taskschedulertext"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-2 col-md-2">
                        <div class="row form-group">
                            <label class="col-md-12">Amount</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="txtSchedLineAmount" style="text-align: right;">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4 col-md-4">
                        <div class="row form-group">
                            <label class="col-md-12">Status</label>
                            <div class="col-xs-6 col-md-6">
                                <label>
                                    <input name="form-field-radioschedlinestat" type="radio" id="Resolved" value="Resolved" class="schedlinestat ace">
                                    <span class="lbl"> Resolved</span>
                                </label>
                            </div>
                            <div class="col-xs-6 col-md-6">
                                <label>
                                    <input name="form-field-radioschedlinestat" type="radio" checked id="Pending" value="Pending" class="schedlinestat ace">
                                    <span class="lbl"> Pending</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4 col-md-4 pull-right">
                        <div class="row form-group">
                            <label class="col-md-12 hidden-xs">&nbsp;</label>
                            <div class="col-md-12">
                                <div class="btn-group pull-right">
                                    <button class="btn btn-sm btn-success taskschedulerbtn btn-round" onclick="appendschedline();"><i class="fa fa-plus"></i> Add another schedule</button>
                                    <button class="btn btn-sm btn-danger taskschedulerbtn btn-round" onclick="deletecheckedschedline();"><i class="fa fa-trash-o"></i> Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="parent">
                        <input type="hidden" id="schedlineids">
                        <input type="hidden" id="determinator" value="1">
                            <table id="tblschedline" class="table table-bordered table-striped fixTable tblschedline">
                                <thead>
                                    <th width="3%"></th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Duration</th>
                                </thead>
                                <tbody id="tbodyschedline"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary taskschedulerbtn btn-sm btn-round" onclick="saveschedline();"><i class="fa fa-check"></i> Save</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL FOR RESOLVING WORK ORDER SENT FROM COMPLAINTS -->
<div class="modal fade fade-scale" id="modalresolvingofcomplaint" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Complaints</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div id="nilalamanngpuso"></div>
                </div>
            </div>
            <input type="hidden" id="rikimaru">
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm btn-round" id="nilalamanngpusobtn" onclick='$("#modalresolvingofcomplaint").modal("hide");saveresolvingofcomplaint();'>Save</button>
                <button class="btn btn-danger btn-sm btn-round" onclick='$("#modalresolvingofcomplaint").modal("hide");'>Close</button>
            </div>
        </div>
    </div>
</div>

<!-- MULTIPLE PRINTING OF WORK ORDERS BASED ON DATE RANGE CHOSEN -->
<div id="mpowobodrc" style="display: none;">
    <table style="width: 100%;" cellspacing="0" cellpadding="0">
        <tbody id="template2"></tbody>
    </table>
    <p style="text-align: right;">
        <span style="font-weight: 700;">Repair Details Status :</span>&nbsp;&nbsp;
        <span class="fa fa-circle" style="color: #F89406;"></span> Pending&nbsp;&nbsp;
        <span class="fa fa-circle" style="color: #69AA46;"></span> Resolved&nbsp;&nbsp;
        <span class="fa fa-circle" style="color: #428BCA;"></span> Ongoing&nbsp;&nbsp;
    </p>
    <p style="font-size: 15px;text-align: right;">From:&nbsp;&nbsp;<label id="dateFromwoprint"></label>&nbsp;&nbsp;To&nbsp;&nbsp;<label id="dateTowoprint"></label></p>
    <center style="font-size: 22px;font-weight: bold;background-color: #666;color: white;width: 100%;">Work Order List</center>
    <table style="width: 100%;">
        <thead>
            <tr>
                <td>Date Entry</td>
                <td>Work Order ID</td>
                <td class="thSysTenant">Trade Name</td>
                <td>Repair Details</td>
                <td>Assigned To</td>
                <td>Status</td>
            </tr>
            <tr><td colspan="6"><hr style="margin-top: -5px;"></td></tr>
        </thead>
        <tbody id="tblmpowobodrc"></tbody>
    </table>
</div>

<!-- MODAL FOR PRINTING SINGLE JOB ORDER -->
<div id="joprintpreview" style="display: none;">
    <table style="width: 100%;" cellspacing="0" cellpadding="0">
        <tbody id="template3"></tbody>
    </table>
    <center style="font-size: 32px;font-weight: bold;border-bottom: 3px solid black;width: 100%;">Work Order Report</center>
    <table cellspacing="0" style="border: none; width: 100%;white-space: nowrap;margin-top: 10px;margin-bottom: 10px;">
        <tr>
            <td><strong>J.O. Series</strong></td>
            <td id="txtPrintWOID" style="color: red; font-weight: bold;"></td>
        </tr>
        <tr>
            <td style="width: 20%;">Tenant ID : </td>
            <td id="txtPrintWOTenantID" style="width: 30%;"></td>
            <td style="width: 20%;" class="thSysTenant"></td>
            <td id="txtPrintStoreName" style="width: 30%;"></td>
        </tr>
        <tr>
            <td>Contact Person : </td>
            <td id="txtPrintContactPerson"></td>
            <td>Contact Number : </td>
            <td id="txtPrintContactNumber"></td>
        </tr>
    </table>
    <div id="jotasklistcontainer"></div>
</div>