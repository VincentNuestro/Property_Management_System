<div class="modal fade fade-scale" id="modal_endo" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Tenant List</h4>
                <h6 class="modal-title" style="font-size: 18px;font-style:italic;">(with contract that about to end)</h6>
            </div>
            <div class="modal-body">
                <div class="widget-box widget-color-blue2">
                    <div class="widget-header" style="padding-left:5px;padding-top:5px;">
                        <div class="row form-group" style="margin-bottom: 0px;">
                            <div class="col-md-4">
                                <span class="input-icon" style="width: 100%;">
                                    <input type="text" class="form-control" id="txtsearchendo" placeholder="Search Store Name" onkeyup="loadendolist()">
                                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                                </span>
                            </div>
                            <div class="col-md-8">
                                <div class="widget-toolbar">
                                    <i id="spinner_endo" class="ace-icon fa fa-spinner bigger-160"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget-body" style="height: 30vh;">
                        <table class="table table-bordered fixTable">
                            <thead>
                                <tr>
                                    <th style="background-color: #f2f2f2 !important;color:#707070;width:20px;">
                                      <label>
                                          <input name="form-field-checkbox" class="ace" type="checkbox" value="" id="select_all_endo">
                                          <span class="lbl"></span>
                                      </label>
                                    </th>
                                    <th style="background-color: #f2f2f2 !important;color:#707070;">Tenant</th>
                                    <th style="background-color: #f2f2f2 !important;color:#707070;">End Date</th>
                                    <th style="background-color: #f2f2f2 !important;color:#707070;">Remaining Days</th>
                                </tr>
                            </thead>
                            <tbody id="tblendolist" style="overflow: hidden; outline: none;"></tbody>
                        </table>
                    </div>
                    <div class="widget-toolbox padding-8 clearfix">
                        <button class="btn btn-sm btn-success pull-right btn-round" onclick="endoclick()">
                            <i class="ace-icon fa fa-repeat icon-on-right"></i>
                            <span class="bigger-110">&nbsp;Change Status</span>            
                        </button>
                    </div>
                </div>      
            </div>
        </div>    
    </div>
</div>

<div class="modal fade fade-scale" id="noti_TenantRequest" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" onclick="closenoti_TenantRequest();">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">List of Tenant Request</h4>
            </div>
            <div class="modal-body">
                <div class="widget-box widget-color-green">
                    <div class="widget-header" style="padding-left:5px;padding-top:5px;">
                        <div class="row form-group" style="margin-bottom: 0px;">
                            <div class="col-md-4">
                                <span class="input-icon" style="width: 100%;">
                                    <input type="text" class="form-control" id="txtSearchTenantRequest" placeholder="Search Tenant Request" onkeyup="viewnoti_TenantRequest()">
                                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                                </span>
                            </div>
                            <div class="col-md-8">
                                <div class="widget-toolbar">
                                    <i class="ace-icon fa fa-spinner bigger-160"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget-body" style="height: 50vh">
                        <table class="table table-bordered fixTable">
                            <thead>
                                <tr>
                                    <th style="background-color: #f2f2f2 !important;color:#707070;" width="10%">Date</th>
                                    <th style="background-color: #f2f2f2 !important;color:#707070;" width='40%' class="thSysTenant">Full Name</th>
                                    <th style="background-color: #f2f2f2 !important;color:#707070;" width="10%">Scope</th>
                                    <th style="background-color: #f2f2f2 !important;color:#707070;" width="40%">Details</th>
                                </tr>
                            </thead>
                            <tbody id="tblnotiTenantRequestList"></tbody>
                        </table>
                    </div>
                    <div class="widget-toolbox padding-8 clearfix">
                        <button class="btn btn-sm btn-danger pull-right btn-round" onclick="closenoti_TenantRequest();">Close</button>
                    </div>
                </div>      
            </div>
        </div>    
    </div>
</div>

<div class="modal fade fade-scale" id="noti_complaints" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" onclick="closenoti_complaints();">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">List of Complaint</h4>
            </div>
            <div class="modal-body">
                <div class="widget-box widget-color-red2">
                    <div class="widget-header" style="padding-left:5px;padding-top:5px;">
                        <div class="row form-group" style="margin-bottom: 0px;">
                            <div class="col-md-4">
                                <span class="input-icon" style="width: 100%;">
                                    <input type="text" class="form-control" id="txtsearchcomplaintsnoti" placeholder="Search Tenant" onkeyup="viewnoti_complaints()">
                                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                                </span>
                            </div>
                            <div class="col-md-8">
                                <div class="widget-toolbar">
                                    <i class="ace-icon fa fa-spinner bigger-160"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget-body" style="height: 50vh">
                        <table class="table table-bordered fixTable">
                            <thead>
                                <tr>
                                    <th style="background-color: #f2f2f2 !important;color:#707070;" width="25%">Tenant</th>
                                    <th style="background-color: #f2f2f2 !important;color:#707070;" width="25%">Priority Status</th>
                                    <th style="background-color: #f2f2f2 !important;color:#707070;" width="50%">Description</th>
                                </tr>
                            </thead>
                            <tbody id="tblnoticomplaintslist"></tbody>
                        </table>
                    </div>
                    <div class="widget-toolbox padding-8 clearfix">
                        <button class="btn btn-sm btn-danger pull-right btn-round" onclick="closenoti_complaints();">Close</button>
                    </div>
                </div>      
            </div>
        </div>    
    </div>
</div>

<div class="modal fade fade-scale" id="noti_incidentreport" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" onclick="closenoti_incidentreport();">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">List of Pending Violation</h4>
            </div>
            <div class="modal-body">
                <div class="widget-box widget-color-orange">
                    <div class="widget-header" style="padding-left:5px;padding-top:5px;">
                        <div class="row form-group" style="margin-bottom: 0px;">
                            <div class="col-md-4">
                                <span class="input-icon" style="width: 100%;">
                                    <input type="text" class="form-control" id="txtsearchincidentreportnoti" placeholder="Search Violator Name" onkeyup="viewnoti_incidentreport()">
                                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                                </span>
                            </div>
                            <div class="col-md-8">
                                <div class="widget-toolbar">
                                    <i class="ace-icon fa fa-spinner bigger-160"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget-body" style="height: 50vh">
                        <table class="table table-bordered fixTable">
                            <thead>
                                <tr>
                                    <th style="background-color: #f2f2f2 !important;color:#707070;" width="30%">Violator's Name</th>
                                    <th style="background-color: #f2f2f2 !important;color:#707070;" width="70%">Violation</th>
                                </tr>
                            </thead>
                            <tbody id="tblnotiincidentreportlist"></tbody>
                        </table>
                    </div>
                    <div class="widget-toolbox padding-8 clearfix">
                        <button class="btn btn-sm btn-danger pull-right btn-round" onclick="closenoti_incidentreport();">Close</button>
                    </div>
                </div>      
            </div>
        </div>    
    </div>
</div>

<div class="modal fade fade-scale" id="modal_ViewTrasactionLogs" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Transaction Logs</h4>
            </div>
            <div class="modal-body">
                <div class="parent">
                    <table class="table table-bordered table-striped fixTable">
                        <thead>
                            <tr>
                                <th style="width: 14%;">Date & Time</th>
                                <th style="width: 40%;">Remarks</th>
                                <th style="width: 56%;">Details</th>
                            </tr>
                        </thead>
                        <tbody id="tblViewTransactionLogs"></tbody>
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