<div class="modal fade fade-scale" id="mdl_NewSched" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="fncAddNewSetupX();">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Create New Schedule</h4>
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
                                                <input type="hidden" id="txtSchedID">
                                                <div class="row" style="height: 48.5vh; overflow-y: scroll; overflow-x: hidden;">
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <label class="control-label thSysTenant">Tenant</label>
                                                            <label class="pull-right">
                                                                <input type="checkbox" class="ace" id="chkMSAllTenant" onclick="fncMSSelectAllTenant();">
                                                                <span class="lbl middle padding-4"> Select All</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <select id="txtSchedTenant" class="form-control searchy_select isSchedReq" multiple style="width: 100%;" data-placeholder="-- Select Tenant --"></select>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <label class="control-label">Assigned Department</label>
                                                        </div>
                                                        <div class="col-md-12" id="divMSDepartment">
                                                            <select class="form-control isSchedReq searchy_select" id="txtSchedDepartment" onchange="fncSelectPersonnel(this.value); fncMSAllowSelectAll();" style="width: 100%;" data-placeholder="-- Select Department --"></select>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <label class="control-label">Assigned Personnel</label>
                                                            <label class="pull-right">
                                                                <input type="checkbox" class="ace" id="chkMSAllPersonnel" onclick="fncMSSelectAllPersonnel();">
                                                                <span class="lbl middle padding-4"> Select All</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <select class="form-control isSchedReq searchy_select" multiple id="txtSchedPersonnel" style="width: 100%;" data-placeholder="-- Select Personnel --"></select>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <label class="col-md-12">Period</label>
                                                        <div class="col-md-6">
                                                            <div class="radio">
                                                                <label>
                                                                    <input name="Sched-radio" type="radio" class="ace rdPeriod" value="Daily" onclick="SchedChangePeriod(this.value);" checked id="rdOnLoadClick">
                                                                    <span class="lbl">&nbsp;Daily</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="radio">
                                                                <label>
                                                                    <input name="Sched-radio" type="radio" class="ace rdPeriod" value="Weekly" onclick="SchedChangePeriod(this.value);">
                                                                    <span class="lbl">&nbsp;Weekly</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="radio">
                                                                <label>
                                                                    <input name="Sched-radio" type="radio" class="ace rdPeriod" value="Monthly" onclick="SchedChangePeriod(this.value);">
                                                                    <span class="lbl">&nbsp;Monthly</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="radio">
                                                                <label>
                                                                    <input name="Sched-radio" type="radio" class="ace rdPeriod" value="Quarterly" onclick="SchedChangePeriod(this.value);">
                                                                    <span class="lbl">&nbsp;Quarterly</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="radio">
                                                                <label>
                                                                    <input name="Sched-radio" type="radio" class="ace rdPeriod" value="Biannually" onclick="SchedChangePeriod(this.value);">
                                                                    <span class="lbl">&nbsp;Semi-Annual</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="radio">
                                                                <label>
                                                                    <input name="Sched-radio" type="radio" class="ace rdPeriod" value="Annually" onclick="SchedChangePeriod(this.value);">
                                                                    <span class="lbl">&nbsp;Annually</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group" id="isWeekly">
                                                        <label class="col-md-12">Day of Creation</label>
                                                        <div class="col-md-12 form-group" class="divMSDayofTheWeek">
                                                            <select class="form-control searchy_select" id="txtSchedWeek1" style="width: 100%;">
                                                                <option value="">-- Day of the Week --</option>
                                                                <option value="Monday">Monday</option>
                                                                <option value="Tuesday">Tuesday</option>
                                                                <option value="Wednesday">Wednesday</option>
                                                                <option value="Thursday">Thursday</option>
                                                                <option value="Friday">Friday</option>
                                                                <option value="Saturday">Saturday</option>
                                                                <option value="Sunday">Sunday</option>
                                                            </select>
                                                        </div>
                                                        <label class="col-md-12">Work Order Day</label>
                                                        <div class="col-md-12 form-group" class="divMSDayofTheWeek">
                                                            <select class="form-control searchy_select" id="txtSchedWeek2" style="width: 100%;">
                                                                <option value="">-- Day of the Week --</option>
                                                                <option value="Monday">Monday</option>
                                                                <option value="Tuesday">Tuesday</option>
                                                                <option value="Wednesday">Wednesday</option>
                                                                <option value="Thursday">Thursday</option>
                                                                <option value="Friday">Friday</option>
                                                                <option value="Saturday">Saturday</option>
                                                                <option value="Sunday">Sunday</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group" id="isMonthly">
                                                        <label class="col-md-12">Create Date</label>
                                                        <div class="col-md-12 form-group" class="divMSDateofTheMonth">
                                                            <select class="form-control searchy_select" id="txtSchedMonth1" style="width: 100%;">
                                                                <option value="">-- Date of the Month --</option>
                                                                <?php 
                                                                    for ($i=1; $i <= 31; $i++) { 
                                                                        echo "<option value='". $i ."'>". $i ."</option>";
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <label class="col-md-12">Work Order Date</label>
                                                        <div class="col-md-12 form-group" class="divMSDateofTheMonth">
                                                            <select class="form-control searchy_select" id="txtSchedMonth2" style="width: 100%;">
                                                                <option value="">-- Date of the Month --</option>
                                                                <?php 
                                                                    for ($i=1; $i <= 31; $i++) { 
                                                                        echo "<option value='". $i ."'>". $i ."</option>";
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group" id="txtMSSchedDate1">
                                                        <label class="col-md-12">Create Date</label>
                                                        <div class="col-md-12">
                                                            <input type="text" class="form-control date-picker" placeholder="mm/dd/yyyy" id="txtSchedDate1">
                                                        </div>
                                                        <label class="col-md-12">Work Order Date</label>
                                                        <div class="col-md-12">
                                                            <input type="text" class="form-control date-picker" placeholder="mm/dd/yyyy" id="txtSchedDate2">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group" id="txtMSSchedDate2">
                                                        <label class="col-md-12">Create Date</label>
                                                        <div class="col-md-12">
                                                            <input type="text" class="form-control date-picker" placeholder="mm/dd/yyyy" id="txtSchedDate3">
                                                        </div>
                                                        <label class="col-md-12">Work Order Date</label>
                                                        <div class="col-md-12">
                                                            <input type="text" class="form-control date-picker" placeholder="mm/dd/yyyy" id="txtSchedDate4">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group" id="txtMSSchedDate3">
                                                        <label class="col-md-12">Create Date</label>
                                                        <div class="col-md-12">
                                                            <input type="text" class="form-control date-picker" placeholder="mm/dd/yyyy" id="txtSchedDate5">
                                                        </div>
                                                        <label class="col-md-12">Work Order Date</label>
                                                        <div class="col-md-12">
                                                            <input type="text" class="form-control date-picker" placeholder="mm/dd/yyyy" id="txtSchedDate6">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group" id="txtMSSchedDate4">
                                                        <label class="col-md-12">Create Date</label>
                                                        <div class="col-md-12">
                                                            <input type="text" class="form-control date-picker" placeholder="mm/dd/yyyy" id="txtSchedDate7">
                                                        </div>
                                                        <label class="col-md-12">Work Order Date</label>
                                                        <div class="col-md-12">
                                                            <input type="text" class="form-control date-picker" placeholder="mm/dd/yyyy" id="txtSchedDate8">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-toolbox padding-8 clearfix">
                                        <button id="btnMSSave" class="btn btn-primary btn-sm pull-right btn-round" style="float: right;" onclick="SaveSchedSetup()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving..."><i class="ace-icon fa fa-check"></i>&nbsp;Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="btn-group pull-right">
                                    <button class="btn btn-sm btn-danger pull-right btn-round" onclick="fncMSDelete();">&nbsp;Remove Task</button>
                                    <button class="btn btn-sm btn-warning pull-right btn-round" onclick="fncMSUncheckAll();" style="margin-right: 5px;">&nbsp;Unselect All</button>
                                    <button class="btn btn-sm btn-success pull-right btn-round" onclick="fncMSCheckAll();" style="margin-right: 5px;">&nbsp;Select All</button>
                                    <button class="btn btn-sm btn-info pull-right btn-round" onclick="$('#mdlMSTask').modal('show'); fncMSloadSelectFilterCategory(); fncMSLoadAddTask(); $('#tbodyMSSelectedTask tr').unbind('click');" style="margin-right: 5px;">&nbsp;Add Task</button>
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
                                                            <th style="background-color: #6379AA;color: white;width: 30%;">Category</th>
                                                            <th style="background-color: #6379AA;color: white;width: 50%;">Task</th>
                                                            <th style="background-color: #6379AA;color: white;width: 20%;text-align: right;">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyMSSelectedTask"></tbody>
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
                                                <p id="txtMSTotalAmount" style="text-align: right;margin-bottom: 0px; font-size: 19.5px;">0.00</p>
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

<div class="modal fade fade-scale" id="mdlMSTask" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="fncMSCloseTaskSelection();">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Select Task</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-4 col-md-4 col-lg-4" id="divMSSelectTaskCat">
                        <select id="txtMSSelectFilterCategory" class="form-control searchy_select" onchange="fncLoadAddTask();" style="width: 100%;"></select>
                    </div>
                    <div class="col-xs-4 col-md-4 col-lg-4">
                        <span class="input-icon" style="width: 100%;">
                            <input type="text" class="form-control" id="txtMSSelectSearchTask" title="Search" placeholder="Search">
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
                                <tbody id="tbodyMSSelectTask"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger btn-sm btn-round" onclick="fncMSCloseTaskSelection();">Close</button>
            </div>
        </div>
    </div>
</div>