<div class="page-header">
    <div class="row form-group" style="margin-bottom: 0px;padding-top:10px;background-color: #edf4f8;padding-bottom: 10px;">
        <div class="col-md-4">
            <h1 style="font-weight: bold;">AWARDS</h1>
        </div>
        <div class="col-md-8">
            <span class='pull-right arrowed-in-right arrowed label label-xlg label-danger'>Disapproved</span>
            <span class='pull-right arrowed-in-right arrowed label label-xlg label-success'>Approved</span>
            <span class='pull-right arrowed-in-right arrowed label label-xlg label-pink'>Pending</span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="row form-group" style="margin-bottom: 0px;">
            <div class="col-md-2" style="padding-left: 0px;padding-bottom: 5px;">
                <span class="input-icon" style="width: 100%;">
                    <input type="text" class="form-control" title="Search" placeholder="Search" id="txtSearchApplication">
                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                </span>
            </div>
            <div class="col-md-2" style="padding-bottom: 5px;padding-left:0px;">
                <h5><a onclick="loadFilterLeasingApplication('Application')" id="LINK_Appliaction_filter" class="popover-info" data-rel="popover" data-placement="bottom" title="Filter by" data-content='

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:85px;">&nbsp;&nbsp;Search by&nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-6">
                                <label>
                                    <input name="form-field-checkboxkeyword" class="ace ace-checkbox-2 inquiry_module_filter" type="checkbox" value="Company_Name" id="filter_Company_Name">
                                    <span class="lbl"> Company Name</span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label>
                                    <input name="form-field-checkboxkeyword" class="ace ace-checkbox-2 inquiry_module_filter" type="checkbox" value="Trade_Name" id="filter_Trade_Name">
                                    <span class="lbl"> <span class="thSysTenant"></span></span>
                                </label>                            
                            </div>
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:95px;">&nbsp;&nbsp;Filter Status</legend>
                        <div class="form-group row" style="margin: 0px;">
                            <div class="col-md-3">
                                <label class="label label-lg label-pink arrowed-in-right arrowed">
                                    <input name="form-field-checkbox-stat" class="ace" type="checkbox" value="Pending" id="filter_Pendingawardapp">
                                    <span class="lbl"> Pending </span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="label label-lg label-warning arrowed-in-right arrowed">
                                    <input name="form-field-checkbox-stat" class="ace" type="checkbox" value="Confirmed" id="filter_Confirmedawardapp">
                                    <span class="lbl"> Confirmed</span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="label label-lg label-success arrowed-in-right arrowed">
                                    <input name="form-field-checkbox-stat" class="ace" type="checkbox" value="Approved" id="filter_Approvedawardapp">
                                    <span class="lbl"> Approved</span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="label label-lg label-danger arrowed-in-right arrowed">
                                    <input name="form-field-checkbox-stat" class="ace" type="checkbox" value="Disapproved" id="filter_disapprovedawardapp">
                                    <span class="lbl"> Disapproved </span>
                                </label>
                            </div>

                           



                        </div>
                    </fieldset>   

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_chkappdate">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:130px;">&nbsp;&nbsp;Application Date</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                    <input class="form-control div_app date-picker" type="text" id="txtdiv_strtappp" data-provide="datepicker">
                                </div>                
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <input class="form-control div_app date-picker" type="text" id="txtdiv_endappp" data-provide="datepicker">
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
                            <button class="btn btn-xs btn-info btn-round" onclick="saveAwardsapprovalFilter()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">OK</button>
                        </div>
                    </div>'><i class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;Select Filter here</a>
                </h5>
            </div>
            <div class="col-md-8" style="padding-bottom: 5px;padding-left:0px;"></div>
        </div>
        <div class="row form-group" style="margin-bottom: 0px !important;" id="user-profile-3">
            <div class="parent">
                <table class="table table-bordered fixTable">
                    <thead>
                        <tr>
                            <th>Inquiry ID</th>
                            <th>Date Applied</th>
                            <th>Unit</th>
                            <th class="thSysTenant">Store Name</th>
                            <th>Company</th>
                            <th>Source</th>
                            <th>Process Owner</th>
                            <th>1st Approver</th>
                            <th>Approval Date</th>
                            <th>2nd Approver</th>
                            <th>Approval Date</th>
                            <th style="z-index: 1;">Application Status</th>  
                            <th style="z-index: 1;">Approval Status</th> 
                            <th style="z-index: 1;">Option</th>
                        </tr>
                    </thead>
                    <tbody id="tblListofApplication"></tbody>
               </table>
            </div>
            <table class="tabledash_footer table" style="margin: 0px !important;">
                <thead>
                    <tr>
                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                            <font id="txtLAPageEntries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                            <input id="txtLAPageCount" type="hidden">
                            <ul id="ulLAPagination" class="pagination pull-right"></ul>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdlProposalList" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">List of Proposal</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
                                    <div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
                                        <div class="widget-header"> 
                                            <h4 class="widget-title txtPanelHeader">Tenant Information</h4>
                                        </div>
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row well">
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <h4 class="green txtPanelHeader">Tenant Information</h4>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="row form-group">
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12 col-xs-12 thSysTenant"></label>
                                                                        <div class="col-md-12 col-xs-12">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control"  id="txtProTradeName" readonly style="background-color: white !important;">
                                                                                <span class="input-group-btn">
                                                                                    <button type="button" class="btn btn-white" title="Click here to browse company profiles" onclick="fncBrowseStoreProfile();" disabled>
                                                                                        <span class="fa fa-search bigger-110"></span>              
                                                                                    </button>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Merchant Code <span class="red">*</span></label>
                                                                        <div class="col-md-12">
                                                                            <input type="text" class="form-control" placeholder="Merchant Code" id="txtProMerchantCode" readonly style="background-color: white !important;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <div class="col-md-12 col-xs-12">Company</div>
                                                                        <div class="col-md-12 col-xs-12">
                                                                            <input type="text" id="txtProCompany" class="form-control " placeholder="Company Name" style="background-color: white !important;" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <div class="col-md-12 col-xs-12">Industry</div>
                                                                        <div class="col-md-12 col-xs-12">
                                                                            <input type="text" id="txtProIndustry" class="form-control" placeholder="Select Industry" style="background-color: white !important;" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <div class="col-md-12">
                                                                            Process Owner
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <select class="form-control txtAllProcessOwner" id="txtProProcessOwner" style="background-color: white !important;" disabled></select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <div class="col-md-12">
                                                                            Source
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <select class="form-control txtAllSource" id="txtProSource" style="background-color: white !important;" disabled></select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <div class="image">
                                                                        <img id="imgProTenant" class="form-control img-thumbnail" style="border: 2px solid #bdc3c7; margin-bottom: 8px;height: 200px;width: 100%;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="row form-group">
                                                                <div class="col-md-4">
                                                                    <div class="row form-group">
                                                                        <div class="col-md-12">Classification</div>
                                                                        <div class="col-md-12">
                                                                            <select class="form-control txtAllClassification" id="txtProClassification" onchange="fncAllDepartmentRef();" style="background-color: white !important;" disabled></select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="row form-group">
                                                                        <div class="col-md-12">Department</div>
                                                                        <div class="col-md-12">
                                                                            <select class="form-control txtAllDepartment" id="txtProDepartment" onchange="fncAllCategoryRef();" style="background-color: white !important;" disabled></select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="row form-group">
                                                                        <div class="col-md-12">Category</div>
                                                                        <div class="col-md-12">
                                                                            <select class="form-control txtAllCategory" id="txtProCategory" style="background-color: white !important;" disabled></select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <h4 class="green">Contact Persons</h4>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-md-12 divsetHeigth" style="display: inline-block; overflow-y: scroll;overflow-x: hidden;" id="div_proposal_contact_person"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
                                    <div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
                                        <div class="widget-header"> 
                                            <h4 class="widget-title">Lease Proposals</h4>
                                        </div>
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row well">
                                                    <div class="row form-group">
                                                        <div class="col-md-1">
                                                            <h5 class="bolder" style="margin-top: 10px;">Legend:</h5> 
                                                        </div>
                                                        <div class="col-md-9">
                                                            <span class='label label-xlg label-white label-info' style="border-color: #bce8f1 !important;">Approved Proposal</span>
                                                            <span class='label label-xlg label-white label-warning' style="border-color: #faebcc !important; color: #8a6d3b !important;">Pending Proposal</span>
                                                        </div>
                                                        <div class="col-md-2 pull-right" >
                                                            <button class="btn btn-primary btn-sm btn-round btn-block txtInqDisabled" id="btnLANewProposal">Add Proposal</button>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <div id="div_ProposalList"></div>
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
            <div class="modal-footer">
                <button class="btn btn-sm btn-danger btn-round" onclick="$('#mdlProposalList').modal('hide');">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdlAwardConfirmation" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background-color: white !important;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 style="font-size: 14px; font-weight: 400; color: #666; margin: 0px;"><span class="fa fa-info-circle" style="color: #06F;"></span>&nbsp;&nbsp;Confirm</h6>
            </div>
            <div class="modal-body">
                <h3 style="font-size: 16px; font-weight: 400; color: #666; text-align: center; margin: 10px;">Are you sure you want to award this prospect tenant?</h3>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-primary btn-round" id="btnSendAwardApprove">Approve</button>
                <button class="btn btn-sm btn-warning btn-round" id="btnSendAwardReassess">Reassess</button>
                <button class="btn btn-sm btn-danger btn-round" id="btnSendAwardDisapprove">Disapprove</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="modal_login_override" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm">   
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="hidemodal_login_override();">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Login</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-xs-12 col-md-3">
                       Username
                    </div>
                    <div class="col-xs-12 col-md-9">
                        <span class="block input-icon input-icon-right">
                            <input type="text" class="form-control" id="txtoverrideusername">
                            <i class="ace-icon fa fa-user bigger-120" style="color: #286090;"></i>
                        </span>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-xs-12 col-md-3">
                       Password
                    </div>
                    <div class="col-xs-12 col-md-9">
                        <span class="block input-icon input-icon-right">
                            <input type="text" class="form-control" id="txtoverridepassword">
                            <i class="ace-icon fa fa-lock bigger-120" style="color: #286090;"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                   <button class="btn btn-danger btn-sm btn-round" onclick="hidemodal_login_override()">Cancel</button>
                   <button class="btn btn-info btn-sm btn-round" id="btnshowoverridemodal">Login</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdlreassessform" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background-color: white !important;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 style="font-size: 14px; font-weight: 400; color: #666; margin: 0px;"><span class="fa fa-info-circle" style="color: #06F;"></span>&nbsp;&nbsp;Remarks</h6>
            </div>
            <div class="modal-body">
                <textarea class="form-control" id="txtreassessremarks"></textarea>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-primary btn-round" id="btnsavereassess">Save</button>
                <button class="btn btn-sm btn-danger btn-round" id="btncancelreassess">Cancel</button>
            </div>
        </div>
    </div>
</div>


<?php  
    include("global_form/index.php");
    include("global_events/index.php");
    include "script.php";
?>