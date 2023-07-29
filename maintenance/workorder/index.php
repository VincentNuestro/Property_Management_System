<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="row form-group" style="margin-bottom: 0px;">
            <div class="col-md-2" style="padding-bottom: 5px;padding-left:0px;">
                <span class="input-icon" style="width: 100%;">
                    <input type="text" class="form-control" placeholder="Search" title="Search" id="txtsearchmaintenance">
                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                </span>
            </div>
            <div class="col-md-3" style="padding-bottom: 5px;padding-left:0px;">
                <h5><a onclick="loadMaintenanceFilter('Maintenance')" id="LINK_Maintenance_filter" class="popover-info" data-rel="popover" data-placement="bottom" title="Filter by" data-content='
                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:95px;">&nbsp;&nbsp;Search by&nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-4">
                                <label>
                                    <input name="form-field-checkboxxxxxxx" class="ace ace-checkbox-2 maintenance_module_filter" type="checkbox" value="workorderid" id="filter_workorderid">
                                    <span class="lbl"> Task ID</span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label>
                                    <input name="form-field-checkboxxxxxxx" class="ace ace-checkbox-2 maintenance_module_filter" type="checkbox" value="workername" id="filter_workername">
                                    <span class="lbl"> Personnel</span>
                                </label>                            
                            </div>
                            <div class="col-md-4">
                                <label>
                                    <input name="form-field-checkboxxxxxxx" class="ace ace-checkbox-2 maintenance2_module_filter" type="checkbox" value="tradename" id="filter_tradename">
                                    <span class="lbl"> <span class="thSysTenant"></span></span>
                                </label>                            
                            </div>
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:100px;">&nbsp;&nbsp;Filter Status&nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-2"></div>
                            <div class="col-md-4">
                                <label class="label label-lg label-success arrowed-in-right arrowed">
                                    <input name="form-field-checkboxstatussssss" class="ace filter_Resolved" type="checkbox" value="Resolved" id="filter_Resolved">
                                    <span class="lbl"> Resolved</span>
                                </label>  
                            </div>
                            <div class="col-md-4">
                                <label class="label label-lg label-warning arrowed-in-right arrowed">
                                    <input name="form-field-checkboxstatussssss" class="ace filter_Pending" type="checkbox" value="Pending" id="filter_Pending">
                                    <span class="lbl"> Pending</span>
                                </label>  
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_chkappdate">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:90px;">&nbsp;&nbsp;Date Entry&nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                      <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <input class="form-control date-picker" type="text" name="" id="dateentrystart" data-provide="datepicker">
                                </div>                
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <input class="form-control date-picker" type="text" name="" id="dateentryend" data-provide="datepicker">
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
                            <button class="btn btn-xs btn-info btn-round" onclick="saveMaintenancefilter()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">OK</button>
                        </div>
                    </div>'>
                    <i class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;Select Filter here</a>
                </h5>
            </div>
            <div class="col-md-4" style="padding-bottom: 5px;padding-left: 0px;"></div>
            <div class="col-md-2" style="padding-bottom: 5px;padding-left: 0px;">
                <button class="btn btn-info btn-sm pull-right btn-block hide isadmin select-view1createworkorder btn-round" onclick="fncNewWorkOrder();">New Work Order</button>
            </div>
            <div class="col-md-1" style="padding-bottom: 5px;padding-left:0px;">
                <h5 class="center"><a onclick="showfilterofmall();showmaincat();" class="popover-info hide isadmin select-printworkorder" data-rel="popover" data-placement="bottom" title="Print by" data-content='
                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:130px;">&nbsp;&nbsp;Filter by <label class="txtSysBuilding"></label>&nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <select class="form-control malloption" id="printbymewo"></select>
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:200px;">&nbsp;&nbsp;Filter by Maintenance Type&nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <select class="form-control" id="printbymemt" onchange="showmaincat();">
                                <option value="">-- Select Type --</option>
                                <option value="Preventive">Preventive</option>
                                <option value="Improvement">Improvement</option>
                                <option value="Corrective">Corrective</option>
                            </select>
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:140px;">&nbsp;&nbsp;Filter by Category&nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <select class="form-control" id="printbymecn"></select>
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_chkappdate">
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <input class="form-control date-picker" type="text" id="jodatefrom" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>">
                                </div>                
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <input class="form-control date-picker" type="text" id="jodateto" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>">
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
                            <button class="btn btn-xs btn-success btn-round" onclick="printbydaterangeJO()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">Print</button>
                        </div>
                    </div>'>
                <i class="glyphicon glyphicon-print bigger-110"></i>&nbsp;&nbsp;Print</a></h5>
            </div>
        </div>
        <div class="row form-group" style="margin-bottom: 0px !important;">
            <div class="parent">
                <table class="table table-bordered fixTable">
                    <thead>
                        <tr>
                            <th>Task ID</th>
                            <th>Date Entry</th>
                            <th class="thSysTenant">Trade Name</th>
                            <th>Work Order Details</th>
                            <th>Assigned To</th>
                            <th style="z-index: 1;">WO Status</th>
                            <th style="z-index: 1;">Billing Status</th>
                            <th style="z-index: 1;">Options</th>
                        </tr>
                    </thead>
                    <tbody id="tblworkorder"></tbody>
                </table>
            </div>
            <table class="tabledash_footer table" style="margin: 0px !important;">
                <thead>
                    <tr>
                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                            <font id="txtjoentries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                            <input id="txt_userpagejo" type="hidden">
                            <ul id="ulpaginationjo" class="pagination pull-right"></ul>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<?php include("script.php"); ?>
<?php include("modals.php"); ?>
