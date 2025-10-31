<div class="row">
    <div class="col-md-12">
        <div class="row form-group" style="margin-bottom: 0px;">
            <div class="col-md-2" style="padding-bottom: 5px;padding-left: 0px;">
                <span class="input-icon" style="width: 100%;">
                    <input type="text" class="form-control" id="txtsearchSubLeads" title="Search" placeholder="Search">
                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                </span>
            </div>
            <div class="col-md-2" style="padding-bottom: 5px;padding-left:0px;">
                <h5>
                    <a onclick="loadSubLeadsFilter()" id="LINK_SubLeads_filter" class="popover-info" data-rel="popover" data-placement="bottom" title="Filter by" data-content='

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px; ">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:80px;">&nbsp;&nbsp;Select by</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-4">
                                <label>
                                    <input name="form-field-SearchSubLeads" class="ace ace-checkbox-2 tenant_module_filter" type="checkbox" value="b.LeadsName" id="filter_b.LeadsName">
                                    <span class="lbl"> Leads Name</span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label>
                                    <input name="form-field-SearchSubLeads" class="ace ace-checkbox-2 tenant_module_filter" type="checkbox" value="a.Subject" id="filter_a.Subject">
                                    <span class="lbl"> Subject</span>
                                </label>                            
                            </div>
                            <div class="col-md-4">
                                <label>
                                    <input name="form-field-SearchSubLeads" class="ace ace-checkbox-2 tenant_module_filter" type="checkbox" value="a.Details" id="filter_a.Details">
                                    <span class="lbl"> Details</span>
                                </label>                            
                            </div>
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:99px;">&nbsp;&nbsp;Filter Status</legend>

                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-6">
                                <label class="label label-lg label-purple arrowed-in-right arrowed">
                                    <input name="form-field-checkbox-StatSubLeads" class="ace" type="checkbox" value="Lead" id="filter_Lead">
                                    <span class="lbl"> Lead</span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="label label-lg label-light arrowed-in-right arrowed">
                                    <input name="form-field-checkbox-StatSubLeads" class="ace" type="checkbox" value="Inquired" id="filter_Inquired">
                                    <span class="lbl">&nbsp;Inquired&nbsp;</span>
                                </label>
                            </div>
                        </div>

                        <div class="row form-group" style="margin:0px;">
                            <div class="col-md-6">
                                <label class="label label-lg label-pink arrowed-in-right arrowed">
                                    <input name="form-field-checkbox-StatSubLeads" class="ace" type="checkbox" value="Pending Application" id="filter_Pending Application">
                                    <span class="lbl">&nbsp;Pending Application&nbsp;</span>
                                </label>
                            </div>                     
                            <div class="col-md-6">
                                <label class="label label-lg label-info arrowed-in-right arrowed">
                                    <input name="form-field-checkbox-StatSubLeads" class="ace" type="checkbox" value="Approved Application" id="filter_Approved Application">
                                    <span class="lbl">&nbsp;Approved Application&nbsp;</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-6">
                                <label class="label label-lg label-success arrowed-in-right arrowed">
                                    <input name="form-field-checkbox-StatSubLeads" class="ace" type="checkbox" value="Confirmed" id="filter_Confirmed">
                                    <span class="lbl">&nbsp;Confirmed&nbsp;</span>
                                </label>
                            </div> 
                            <div class="col-md-6">
                                <label class="label label-lg label-warning arrowed-in-right arrowed">
                                    <input name="form-field-checkbox-StatSubLeads" class="ace" type="checkbox" value="Occupied" id="filter_Occupied">
                                    <span class="lbl">&nbsp;Occupied&nbsp;</span>
                                </label>
                            </div>  
                        </div>

                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-6">
                                <label class="label label-lg label-danger arrowed-in-right arrowed">
                                    <input name="form-field-checkbox-StatSubLeads" class="ace" type="checkbox" value="Cancelled" id="filter_Cancelled">
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
                                    <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                    <input class="form-control div_app date-picker" type="text" id="SubLeadsDateFrom" data-provide="datepicker">
                                </div>                
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                    <input class="form-control div_app date-picker" type="text" id="SubLeadsDateTo" data-provide="datepicker">
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
                            <button class="btn btn-xs btn-info btn-round" onclick="saveSubLeadsFilter()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">
                                OK
                            </button>
                        </div>
                    </div>'><i class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;Select Filter here
                    </a>
                </h5>
            </div>
            <div class="col-md-6" style="padding-bottom: 5px;"></div>
            <div class="col-md-2" style="padding-bottom: 5px;padding-right: 0px;">
                <button id="LeadsGenButtonAwareness" class="btn btn-info btn-sm btn-block select-addawareness hide isadmin btn-round" onclick="ShowAddNewLeads();">New Awareness</button>
                <button id="LeadsGenButtonReferral" class="btn btn-info btn-sm btn-block select-addreferral hide isadmin btn-round" onclick="ShowAddNewLeads();">New Referral</button>
                <button id="LeadsGenButtonDemo" class="btn btn-info btn-sm btn-block select-adddemo hide isadmin btn-round" onclick="ShowAddNewLeads();">New Demo</button>
                <button id="LeadsGenButtonProposal" class="btn btn-info btn-sm btn-block select-addproposal hide isadmin btn-round" onclick="ShowAddNewLeads();">New Proposal</button>
                <button id="LeadsGenButtonClosingMeeting" class="btn btn-info btn-sm btn-block select-addclosingmeeting hide isadmin btn-round" onclick="ShowAddNewLeads();">New Closing Meeting</button>
                <button id="LeadsGenButtonContracSigning" class="btn btn-info btn-sm btn-block select-addcontractsigning hide isadmin btn-round" onclick="ShowAddNewLeads();">New Contract Signing</button>
            </div>
            <div class="row form-group" style="margin-bottom: 0px !important;">
                <div class="col-md-12">
                    <div class="parent">
                        <table id="simple-table" class="table table-bordered fixTable">
                            <thead>
                                <tr>
                                    <th width="10%">Date Created</th>
                                    <th>Leads Name</th>
                                    <th>Subject</th>
                                    <th>Details</th>
                                    <th width="8%" style="z-index: 1;">Status</th>
                                    <th width="12%" style="z-index: 1;">Options</th>
                                </tr>
                            </thead>
                            <tbody id="tblSubLeadslist"></tbody>
                        </table>
                    </div>
                    <table class="tabledash_footer table" style="margin: 0px !important;">
                        <thead>
                            <tr>
                                <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                    <font id="txtSubLeadsentries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                    <input id="SubLeadspages" type="hidden">
                                    <ul id="ulpaginationSubLeads" class="pagination pull-right"></ul>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
    include('script.php');
    include('leads/mdl_ContactPerson.php');
    include('leads/mdl_Company.php');
    include('leads/mdl_Trade.php');
    include('leads/mdl_Address.php');
    include('leads/modal_newleads.php');
    include('leads/script.php');
?>