<div class="row">
    <div class="col-md-12">
        <div class="row form-group" style="margin-bottom: 0px;">
            <div class="col-md-2" style="padding-bottom: 5px;padding-left: 0px;">
                <span class="input-icon" style="width: 100%;">
                    <input type="text" class="form-control" id="txtsearchProspects" title="Search" placeholder="Search">
                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                </span>
            </div>
            <div class="col-md-2" style="padding-bottom: 5px;padding-left:0px;">
                <h5>
                    <a onclick="loadProspectFilter('Prospects')" id="LINK_Prospect_filter" class="popover-info" data-rel="popover" data-placement="bottom" title="Filter by" data-content='
                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px; ">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:80px;">&nbsp;&nbsp;Select by</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-6">
                                <label>
                                    <input name="form-field-leadsearch" class="ace ace-checkbox-2 tenant_module_filter" type="checkbox" value="LeadsName" id="filter_LeadsName">
                                    <span class="lbl"> Leads Name</span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label>
                                    <input name="form-field-leadsearch" class="ace ace-checkbox-2 tenant_module_filter" type="checkbox" value="Full_Name" id="filter_Full_Name">
                                    <span class="lbl"> Full Name</span>
                                </label>                            
                            </div>
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:99px;">&nbsp;&nbsp;Filter Status</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-6">
                                <label class="label label-lg label-purple arrowed-in-right arrowed">
                                    <input name="form-field-checkbox-leadStat" class="ace" type="checkbox" value="Lead" id="filter_Lead">
                                    <span class="lbl"> Lead</span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="label label-lg label-light arrowed-in-right arrowed">
                                    <input name="form-field-checkbox-leadStat" class="ace" type="checkbox" value="Inquired" id="filter_Inquired">
                                    <span class="lbl">&nbsp;Inquired&nbsp;</span>
                                </label>
                            </div>
                        </div>

                        <div class="row form-group" style="margin:0px;">
                            <div class="col-md-6">
                                <label class="label label-lg label-pink arrowed-in-right arrowed">
                                    <input name="form-field-checkbox-leadStat" class="ace" type="checkbox" value="Pending Application" id="filter_Pending Application">
                                    <span class="lbl">&nbsp;Pending Application&nbsp;</span>
                                </label>
                            </div>                     
                            <div class="col-md-6">
                                <label class="label label-lg label-info arrowed-in-right arrowed">
                                    <input name="form-field-checkbox-leadStat" class="ace" type="checkbox" value="Approved Application" id="filter_Approved Application">
                                    <span class="lbl">&nbsp;Approved Application&nbsp;</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-6">
                                <label class="label label-lg label-success arrowed-in-right arrowed">
                                    <input name="form-field-checkbox-leadStat" class="ace" type="checkbox" value="Confirmed" id="filter_Confirmed">
                                    <span class="lbl">&nbsp;Confirmed&nbsp;</span>
                                </label>
                            </div> 
                            <div class="col-md-6" style="padding-right:0px;">
                                <label class="label label-lg label-warning arrowed-in-right arrowed">
                                    <input name="form-field-checkbox-leadStat" class="ace" type="checkbox" value="Occupied" id="filter_Occupied">
                                    <span class="lbl">&nbsp;Occupied&nbsp;</span>
                                </label>
                            </div>  
                        </div>

                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-6">
                                <label class="label label-lg label-danger arrowed-in-right arrowed">
                                    <input name="form-field-checkbox-leadStat" class="ace" type="checkbox" value="Cancelled" id="filter_Cancelled">
                                    <span class="lbl">&nbsp;Cancelled / Junked&nbsp;</span>
                                </label>
                            </div>  
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_chkappdate">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:110px;">&nbsp;&nbsp;Date Created&nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <input class="form-control div_app date-picker" type="text" id="LeadsDateFrom" data-provide="datepicker">
                                </div>                
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <input class="form-control div_app date-picker" type="text" id="LeadsDateTo" data-provide="datepicker">
                                </div>                
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </fieldset>

                    <div class="form-group row" style="padding-left:8px;margin-bottom:0px;">
                        <div class="col-md-9" style="padding-right:0px;">
                            <div class="alert alert-info" style="padding-top:10px;padding-bottom:10px;">
                                <button class="close" data-dismiss="alert">
                                    <i class="ace-icon fa fa-times"></i>
                                </button>
                                Click "<b>OK</b>" to filter data and permanently save the filter selected.
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-xs btn-info btn-round" onclick="saveProspectsFilter()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">
                                OK
                            </button>
                        </div>
                    </div>'>
                    <i class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;Select Filter here
                    </a>
                </h5>
            </div>
            <div class="col-md-6" style="padding-bottom: 5px;text-align: right;"></div>
            <div class="col-md-2" style="padding-bottom: 5px;padding-right: 0px;">
                <button class="btn btn-info btn-sm btn-round btn-block select-addprospects hide isadmin" onclick="ShowAddNewLeads('Prospect');">New Prospect</button>
            </div>
            <div class="row form-group" style="margin-bottom: 0px !important;">
                <div class="col-md-12">
                    <div class="parent">
                        <table class="table table-bordered fixTable">
                            <thead>
                                <tr>
                                    <th width="10%">Date Created</th>
                                    <th>Prospect Name</th>
                                    <th>Activity</th>
                                    <th>Full Name</th>
                                    <th width="8%" style="z-index: 1;">Status</th>
                                    <th width="12%" style="z-index: 1;">Options</th>
                                </tr>
                            </thead>
                            <tbody id="tblleadslist"></tbody>
                        </table>
                    </div>
                    <table class="tabledash_footer table" style="margin: 0px !important;">
                        <thead>
                            <tr>
                                <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                    <font id="txtleadsentries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                    <input id="leadspages" type="hidden">
                                    <ul id="ulpaginationleads" class="pagination pull-right"></ul>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL FOR ADDING NEW ACTIVITY -->
<div class="modal fade fade-scale" id="modal_newactivity" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div id="preloadmodalactivity"></div>
            <div class="modal-header">
                <button type="button" class="close" onclick="hideshowmodal_newactivity();">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Add Activity</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="row form-group">
                            <div class="col-md-2">
                                <b>Lead</b>
                            </div>
                            <div class="col-md-10">
                                <label class="form-control" id="txtLeadsActivityLead"></label>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <b>Subject</b>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="txtLeadsActivitySubject">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <textarea class="form-control DisMe" style="resize: none;height: 150px;" id="txtLeadsActivityRemarks"></textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <b>Date</b>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input type="text" class="form-control jonas-date-picker" value="<?php echo date('m/d/Y'); ?>" id="txtLeadsActivityDate">
                                    <label class="input-group-addon"><i class="fa fa-calendar"></i></label>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <b>Time</b>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input type="time" class="form-control" id="txtLeadsActivityTime">
                                    <label class="input-group-addon"><i class="fa fa-clock-o"></i></label>
                                </div>
                            </div>
                        </div>
                        <form id="frmLeadsActivity" name="frmLeadsActivity">
                            <div id="leads_activityattachment"></div>
                            <input type="hidden" id="leadsactivityattachmentcount" name="leadsactivityattachmentcount">
                            <input type="hidden" id="frmactivityLeadsID" name="frmactivityLeadsID">
                            <input type="hidden" id="frmactivityid" name="frmactivityid">
                        </form>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <button class="btn btn-sm btn-success btn-round" onclick="appendleadsactivityattachment()"><i class="fa fa-plus"></i> Add New Attachment</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-md btn-primary btn-round" id="btnSavingActivity"><i class="fa fa-check"></i> Save</button>
            </div>
        </div>
     </div>
</div>

<?php 
    include('script.php');
    include('leads/mdl_Company.php');
    include('leads/mdl_Trade.php');
    include('leads/mdl_ContactPerson.php');
    include('leads/mdl_Address.php');
    include('leads/modal_newleads.php');
    include('leads/script.php');
?>