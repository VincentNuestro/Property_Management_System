<div class="page-header">
    <div class="row form-group" style="margin-bottom: 0px;padding-top:10px;background-color: #edf4f8;padding-bottom: 10px;">
        <div class="col-md-3 col-xs-12">
            <h1 style="font-weight: bold;">VISITOR LOGS</h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="row form-group" style="margin-bottom: 0px;">
            <div class="col-md-2 col-xs-12" style="padding-left: 0px;padding-bottom: 5px;">
                <span class="input-icon" style="width: 100%;">
                    <input type="text" class="form-control" placeholder="Search" id="txtVisitorLogsKey">
                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                </span>
            </div>
            <div class="col-md-2" style="padding-bottom: 5px;padding-left:0px;">
                <h5><a onclick="loadVisitorLogsFilter('VisitorLogs')" id="LINK_VisitorLogs_filter" class="popover-info" data-rel="popover" data-placement="bottom" title="Filter by" data-content='
                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:95px;">&nbsp;&nbsp;Select by&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-4">
                                <label>
                                     <input name="form-field-checkboxfltrby" class="ace ace-checkbox-2 itemsfilter" type="checkbox" value="VisitorID" id="filter_VisitorID">
                                     <span class="lbl"> Visitor ID</span>
                                </label> 
                            </div>
                            <div class="col-md-4">
                                <label>
                                    <input name="form-field-checkboxfltrby" class="ace ace-checkbox-2 itemsfilter" type="checkbox" value="VisitorName" id="filter_VisitorName">
                                    <span class="lbl"> Visitor Name</span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label>
                                    <input name="form-field-checkboxfltrby" class="ace ace-checkbox-2 itemsfilter" type="checkbox" value="ContactNumber" id="filter_ContactNumber">
                                    <span class="lbl"> Contact Number</span>
                                </label>
                            </div>
                            <div class="col-md-5">
                                <label>
                                    <input name="form-field-checkboxfltrby" class="ace ace-checkbox-2 itemsfilter" type="checkbox" value="Address_Company" id="filter_Address_Company">
                                    <span class="lbl"> Address / Company</span>
                                </label>
                            </div>
                            <div class="col-md-4" style="margin-left: -38px;">
                                <label>
                                    <input name="form-field-checkboxfltrby" class="ace ace-checkbox-2 itemsfilter" type="checkbox" value="PurposeOfVisit" id="filter_PurposeOfVisit">
                                    <span class="lbl"> Purpose of Visit</span>
                                </label>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_datein">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:60px;">&nbsp;Date In</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-2">
                                <label style="margin-top:5px;">
                                    <input name="form-field-checkbox" class="ace ace-checkbox-2" type="checkbox" id="chkdateincheck" onclick="checkfirstdate();">
                                    <span class="lbl"> Date</span>
                                </label>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <input class="form-control div_datein date-picker" type="text" id="txtVisitDateInFrom" data-provide="datepicker">
                                </div>                              
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                <input class="form-control div_datein date-picker" type="text" id="txtVisitDateInTo" data-provide="datepicker">
                                </div>                              
                            </div>
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_dateout">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:80px;">&nbsp;&nbsp;Date Out</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-2">
                                <label style="margin-top:5px;">
                                    <input name="form-field-checkbox" class="ace ace-checkbox-2" type="checkbox" id="chkdateoutcheck" onclick="checksecdate();">
                                    <span class="lbl"> Date</span>
                                </label>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <input class="form-control div_dateout date-picker" type="text" id="txtVisitDateOutFrom" data-provide="datepicker">
                                </div>                              
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <input class="form-control div_dateout date-picker" type="text" id="txtVisitDateOutTo" data-provide="datepicker">
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
                            <button class="btn btn-xs btn-info btn-round" onclick="saveVisitorLogsFilter()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">OK</button>
                        </div>
                    </div>'><i class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;Select Filter here</a>
                </h5>
            </div>
            <div class="col-md-4" style="padding-bottom: 5px;padding-left:0px;"></div>
            <div class="col-md-1 pull-right hide isadmin select-printvisitorlogs" style="padding-bottom: 5px;padding-left:0px;">
                <h5><a onclick="printbyfilter();" id="ehehe" class="popover-info" data-rel="popover" data-placement="bottom" style="float: right; margin-right: 15px; font-size: 15px;" title="Print by" data-content='
                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_datein2">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:60px;">&nbsp;Date In</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-2">
                                <label style="margin-top:5px;">
                                    <input name="form-field-checkbox" class="ace ace-checkbox-2" type="checkbox" id="chkdateincheck2" onclick="checkfirstdate2();">
                                    <span class="lbl"> Date</span>
                                </label>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <input class="form-control div_datein2 date-picker" type="text" id="txtVisitDateInFrom2" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>">
                                </div>                              
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <input class="form-control div_datein2 date-picker" type="text" id="txtVisitDateInTo2" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>">
                                </div>                              
                            </div>
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_dateout2">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:80px;">&nbsp;&nbsp;Date Out</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-2">
                                <label style="margin-top:5px;">
                                    <input name="form-field-checkbox" class="ace ace-checkbox-2" type="checkbox" id="chkdateoutcheck2" onclick="checksecdate2();">
                                    <span class="lbl"> Date</span>
                                </label>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <input class="form-control div_dateout2 date-picker" type="text" id="txtVisitDateOutFrom2" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>">
                                </div>                              
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <input class="form-control div_dateout2 date-picker" type="text" id="txtVisitDateOutTo2" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>">
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
                    </div>'><i class="glyphicon glyphicon-print bigger-110"></i>&nbsp;&nbsp;Print</a>
                </h5>
            </div>
            <div class="col-md-2 pull-right" style="padding-bottom: 5px;padding-left:0px;">
                <button type="button" class="btn btn-sm btn-info btn-block isadmin hide select-loginvisitor btn-round" onclick="addnewvisitor();">New Visitor</button>
            </div>
        </div>
        <div class="row form-group">
            <div class="parent">
                <table id="simple-table" class="table table-bordered fixTable">
                    <thead>
                        <tr>
                            <th width="8%">Visitor's ID<span class="btnsortdash-visitorlogs fa fa-sort bigger-130 pull-right" id="VisitorID"></span></th>
                            <th width="20%">Visitor's Name<span class="btnsortdash-visitorlogs fa fa-sort bigger-130 pull-right" id="VisitorName"></span></th>
                            <th width="10%">Contact Number<span class="btnsortdash-visitorlogs fa fa-sort bigger-130 pull-right" id="ContactNumber"></span></th>
                            <th width="20%">Address / Company<span class="btnsortdash-visitorlogs fa fa-sort bigger-130 pull-right" id="Address_Company"></span></th>
                            <th width="20%">Purpose of Visit<span class="btnsortdash-visitorlogs fa fa-sort bigger-130 pull-right" id="PurposeOfVisit"></span></th>
                            <th width="5%">Date In<span class="btnsortdash-visitorlogs fa fa-sort bigger-130 pull-right" id="DateIn"></span></th>
                            <th width="5%">Time In<span class="btnsortdash-visitorlogs fa fa-sort bigger-130 pull-right" id="TimeIn"></span></th>
                            <th width="5%">Date Out<span class="btnsortdash-visitorlogs fa fa-sort bigger-130 pull-right" id="DateOut"></span></th>
                            <th width="5%">Time Out<span class="btnsortdash-visitorlogs fa fa-sort bigger-130 pull-right" id="TimeOut"></span></th>
                            <th width="2%" class="select-logoutvisitor hide isadmin" style="z-index: 1;">Option</th>
                        </tr>
                    </thead>
                    <tbody id="tblvisitorlog"></tbody>
               </table>
            </div>
            <table class="tabledash_footer table" style="margin: 0px !important;">
                <thead>
                    <tr>
                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                            <font  id="txtVisitorLogsEntries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                            <input  id="txtVisitorLogsPage" type="hidden">
                            <ul id="ulPaginationVisitorLogs" class="pagination pull-right"></ul>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="modal_addnewvisitor">
    <div class="modal-dialog modal-md">
        <div class="modal-content" style="width:100% !important;">
            <div id="newvisitloading"></div>
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="closemodal();">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">New Visitor</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="row form-group">
                            <div class="col-md-4">
                                Visitor's ID
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control visitlogrequired" id="txtVisitLogVisitorID">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                Visitor's Name
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control visitlogrequired" id="txtVisitLogVisitorName">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                Contact Number
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control visitlogrequired" id="txtVisitLogContactNumber">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                Address/Company
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control visitlogrequired" id="txtVisitLogAddress">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                Purpose of Visit
                            </div>
                            <div class="col-md-8">
                                <textarea class="form-control visitlogrequired" style="resize: none;height: 75px;" id="txtVisitLogPurposeOfVisit"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-primary btn-round" onclick="savenewvisitlog();"><i class="fa fa-check"></i> Save</button>
            </div>
        </div>
    </div>
</div>

<div id="txtVisitorLogsPrint" style="display: none;">
    <table style="width: 100%;" cellspacing="0" cellpadding="0">
        <tbody id="template"></tbody>
    </table>
    <p style="font-size: 15px; text-align: right;">From:&nbsp;&nbsp;<label id="txtVisitorLogsPrintDateFrom"></label>&nbsp;&nbsp;To&nbsp;&nbsp;<label id="txtVisitorLogsPrintDateTo"></label></p>
    <center style="font-size: 22px;font-weight: bold;background-color: #666;color: white;width: 100%;margin-top: -15px;">Visitor Logs</center>
    <table style="width: 100%;">
        <thead>
            <tr>
                <td>Visitor's ID</td>
                <td>Visitor's Name</td>
                <td>Contact Number</td>
                <td>Address / Company</td>
                <td>Purpose of Visit</td>
                <td>Date In</td>
                <td>Time In</td>
                <td>Date Out</td>
                <td>Time Out</td>
            </tr>
            <td colspan="9"><hr></td>
        </thead>
        <tbody id="tblVisitorLogsPrint"></tbody>
    </table>
</div>

<input type="hidden" id="VisitorLogsSortType" value="ASC">
<input type="hidden" id="VisitorLogsSortBy" value="VisitorID">
<?php 
  include("script.php");
?>