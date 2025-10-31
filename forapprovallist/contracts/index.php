<div class="page-header">
    <div class="row form-group" style="margin-bottom: 0px;padding-top: 10px;background-color: #edf4f8;padding-bottom: 10px;">
        <div class="col-md-6">
            <h1 style="font-weight: bold;">CONTRACTS</h1>
        </div>
        <div class="col-md-6">
            <label class='label label-xlg pull-right arrowed-in-right arrowed label-danger'>Disapproved</label> 
            <label class='label label-xlg pull-right arrowed-in-right arrowed label-success'>Approved</label>  
            <label class='label label-xlg pull-right arrowed-in-right arrowed label-warning'>Confirmed</label>
            <label class='label label-xlg pull-right arrowed-in-right arrowed label-pink'>Pending</label> 
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="row form-group" style="margin-bottom: 0px;">
            <div class="col-md-2 col-xs-12" style="padding-bottom: 5px;padding-left: 0px;">
                <span class="input-icon" style="width: 100%;">
                    <input type="text" class="form-control" placeholder="Search" title="Search" id="txtReservationKey">
                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                </span>
            </div>
            <div class="col-md-6" style="padding-bottom: 5px;padding-left:0px;" id="">
                <h5><a onclick="loadFilterReservation('Reservation')" id="LINK_Reservation_filter" style="" class="popover-info" data-rel="popover" data-placement="bottom" title="Filter by" data-content='
                <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                    <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:95px;">&nbsp;&nbsp;Search By&nbsp;&nbsp;</legend>
                    <div class="form-group row" style="margin:0px;">
                        <div class="col-md-4">
                            <label>
                                <input name="form-field-checkboxkeywordres" class="ace ace-checkbox-2 inquiry_module_filter" type="checkbox" value="Company_Name" id="filter_Company_Name">
                                <span class="lbl"> Company Name</span>
                            </label>    
                        </div>
                        <div class="col-md-4">
                            <label>
                                <input name="form-field-checkboxkeywordres" class="ace ace-checkbox-2 inquiry_module_filter" type="checkbox" value="Trade_Name" id="filter_Trade_Name">
                                <span class="lbl"> <span class="thSysTenant"></span></span>
                            </label>    
                        </div>
                    </div>
                </fieldset>

                <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;">
                    <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:110px;">&nbsp;&nbsp;Filter Status&nbsp;&nbsp;</legend>
                    <div class="form-group row" style="margin:0px;">
                        <div class="col-md-3">
                            <label class="label label-lg label-pink arrowed-in-right arrowed">
                                <input name="form-field-checkbox2" class="ace filter_reservation" type="checkbox" value="Pending" id="filter_pendingconractsapp">
                                <span class="lbl"> Pending</span>
                            </label>  
                        </div>
                        <div class="col-md-3">
                            <label class="label label-lg label-warning arrowed-in-right arrowed">
                                <input name="form-field-checkbox2" class="ace filter_reservation" type="checkbox" value="Confirmed" id="filter_Confirmedconractsapp">
                                <span class="lbl"> Confirmed</span>
                            </label>  
                        </div>
                        <div class="col-md-3">
                            <label class="label label-lg label-success arrowed-in-right arrowed">
                                <input name="form-field-checkbox2" class="ace filter_reservation" type="checkbox" value="Approved" id="filter_Approvedconractsapp">
                                <span class="lbl"> Approved</span>
                            </label>  
                        </div>
                        <div class="col-md-3">
                            <label class="label label-lg label-danger arrowed-in-right arrowed">
                                <input name="form-field-checkbox2" class="ace filter_reservation" type="checkbox" value="Disapproved" id="filter_Disapprovedconractsapp">
                                <span class="lbl"> Disapproved</span>
                            </label>  
                        </div>  
                    </div>
                </fieldset>

                <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;background-color:#f5f5f0;" id="div_chkoccdate">
                    <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:130px;">&nbsp;&nbsp;Occupancy Date&nbsp;&nbsp;</legend>
                    <div class="form-group row" style="margin:0px;">
                        <div class="col-md-1">
                            <label style="margin-top:5px;">
                                <input name="form-field-checkbox" class="ace ace-checkbox-2" type="checkbox" value="" id="chkoccdate" onclick="chkoccdate();">
                                <span class="lbl"></span>
                            </label>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-addon"> <i class="fa fa-calendar bigger-110"></i></span>
                                <input class="form-control div_occ date-picker" type="text" id="txtdiv_strtocc" data-provide="datepicker" disabled>
                            </div>                              
                        </div>
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                <input class="form-control div_occ date-picker" type="text" id="txtdiv_endocc" data-provide="datepicker" disabled>
                            </div>                              
                        </div>                          
                    </div>
                </fieldset>

                <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_chkappdate">
                    <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:120px;">&nbsp;&nbsp;Approved Date&nbsp;&nbsp;</legend>
                    <div class="form-group row" style="margin:0px;">
                        <div class="col-md-1">
                            <label style="margin-top:5px;">
                                <input name="form-field-checkbox" class="ace ace-checkbox-2" type="checkbox" value="" id="chkappdate" checked="true" onclick="chkappdate();">
                                <span class="lbl"></span>
                            </label>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                <input class="form-control div_app date-picker" type="text" id="txtdiv_strtapp" data-provide="datepicker">
                            </div>                              
                        </div>
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                <input class="form-control div_app date-picker" type="text" id="txtdiv_endapp" data-provide="datepicker">
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
                        <button class="btn btn-xs btn-info btn-round" onclick="saveContractappFilter()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">
                            OK
                        </button>
                    </div>
                </div>'><i class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;Select Filter here</a></h5>
            </div>
            <div class="col-md-4"></div>
        </div>
        <div class="row form-group" style="margin-bottom: 0px !important;">
            <div class="parent">
                <table class="table table-bordered fixTable">
                    <thead>
                        <tr>
                            <th>Inquiry ID</th>
                            <th>Created Date</th>
                            <th>Unit</th>
                            <th class="thSysTenant">Store Name</th>
                            <th>Company</th>
                            <th class="hide_mobile">Occupancy Date</th>
                            <th>1st Approver</th>
                            <th>Approval Date</th>
                            <th>2nd Approver</th>
                            <th>Approval Date</th>
                            <th>3rd Approver</th>
                            <th>Approval Date</th>
                            <th style="z-index: 1;">Approval Status</th> 
                            <th style="z-index: 1;">Res. Status</th> 
                            <th style="z-index: 1;">Option</th>
                        </tr>
                    </thead>
                    <tbody id="tblReservationList"></tbody>
                </table>
            </div>
            <table class="tabledash_footer table" style="margin: 0px !important;">
                <thead>
                    <tr>
                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                            <font id="txtReservationEntries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                            <input id="txtReservationPageCount" type="hidden">
                            <ul id="ulReservationPagination" class="pagination pull-right"></ul>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="div_ResContract" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Contract Preview</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-1 pull-right">
                        <button class="btn btn-primary btn-round btn-sm" onclick="fncPrintResContract()">Print</button>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-12">
                        <div id="div_CustomResContract"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdlContractStatapp" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Contract Approval</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="divContractStat"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-sm btn-round" id="btnContractApprove">Approve</button>
                <button class="btn btn-warning btn-sm btn-round" id="btnContractReassess">Reassess</button>
                <button class="btn btn-danger btn-sm btn-round" id="btnContractDisapprove">Disapprove</button>
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
    include("script.php");
?>