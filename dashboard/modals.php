<div class="modal fade fade-scale" id="dashboard_Viewdetails" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
        	<div id="pre_tblDashboardListofInquiry"></div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Today's Inquiries</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                	<div class="col-xs-12 col-md-4 col-lg-4">
                        <span class="input-icon" style="width: 100%;">
                            <input type="text" class="form-control" id="txtDashboardInquirySearchKey" title="Search" placeholder="Search">
                            <i class="ace-icon fa fa-search nav-search-icon"></i>
                        </span>
                	</div>
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="parent" style="margin-top: 10px;">
                            <table class="table table-bordered table-striped fixTable">
                                <thead>
                                    <tr>
                                        <th class="txtSysBuilding">Mall</th>
                                        <th>Company Name</th>
                                        <th>Industry</th>
                                        <th>Unit</th>                   
                                    </tr>
                                </thead>
                                <tbody id="tblDashboardListofInquiry"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-danger" id="wojobmodalclose" onclick='$("#dashboard_Viewdetails").modal("hide");'>Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="dashboard_ViewdetailsUnit" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
        	<div id="pre_tblDashboardListofUnits"></div>
            <div class="modal-header">
                <button type="button" class="close" onclick="XUnitModal();">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;" id="txtDashboardUnitHeader"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                	<div class="col-xs-12 col-md-4 col-lg-4">
                        <span class="input-icon" style="width: 100%;">
                            <input type="text" class="form-control" id="txtDashboardUnitSearchKey" title="Search" placeholder="Search">
                            <i class="ace-icon fa fa-search nav-search-icon"></i>
                        </span>
                    	<input type="hidden" class="form-control" id="txtDashboardTypeSearchKey">
                	</div>
                <!-- <div class="row form-group" style="margin-bottom: 0px;">
                    <div class="col-xs-12 col-md-6 col-lg-6">
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-4 col-lg-4">
                                <label class="txtSysBuilding">Mall</label>
                            </div>
                            <div class="col-xs-12 col-md-8 col-lg-8">
                                <select class="form-control" id="txtDashMall"></select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-4 col-lg-4">
                                Wing
                            </div>
                            <div class="col-xs-12 col-md-8 col-lg-8">
                                <select class="form-control" id="txtDashWing"></select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-4 col-lg-4">
                                Floor
                            </div>
                            <div class="col-xs-12 col-md-8 col-lg-8">
                                <select class="form-control" id="txtDashFloor"></select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6 col-lg-6">
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-4 col-lg-4">
                                Classification
                            </div>
                            <div class="col-xs-12 col-md-8 col-lg-8">
                                <select class="form-control" id="txtDashClassification"></select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-4 col-lg-4">
                                Department
                            </div>
                            <div class="col-xs-12 col-md-8 col-lg-8">
                                <select class="form-control" id="txtDashDepartment"></select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-4 col-lg-4">
                                Category
                            </div>
                            <div class="col-xs-12 col-md-8 col-lg-8">
                                <select class="form-control" id="txtDashCategory"></select>
                            </div>
                        </div>
                    </div>
                </div> -->
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="parent" style="margin-top: 10px;">
                            <table class="table table-bordered table-striped fixTable">
                                <thead>
                                    <tr id="isVacant">
                                        <th width='100%'>Unit2</th>             
                                    </tr>
                                    <tr id="isNotVacant">
					                    <th width='70%'>Unit2</th>
					                    <th width='30%' id="tdDashboardDateInput"></th>
                                    </tr>
                                </thead>
                                <tbody id="tblDashboardListofUnits"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-danger" id="wojobmodalclose" onclick="XUnitModal();">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="dashboard_ViewdetailsMaintenance" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="pre_tblDashboardMaintenance"></div>
            <input type="hidden" id="txtDashboardMainExpSearchPanel">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;" id="dashboard_ViewdetailsMaintenanceTitle"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-4">
                        <span class="input-icon" style="width: 100%;">
                            <input type="text" class="form-control" id="txtDashboardMainExpSearchKey" title="Search" placeholder="Search">
                            <i class="ace-icon fa fa-search nav-search-icon"></i>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="parent" style="margin-top: 10px;">
                            <table class="table table-bordered table-striped fixTable">
                                <thead>
                                    <tr id="trMainExp" style="display: none;">
                                        <th>Date</th>
                                        <th>Reference</th>
                                        <th>Description</th>
                                        <th>Amount</th>                   
                                        <th>Balance</th>                   
                                    </tr>
                                    <tr id="trIncidentReports" style="display: none;">
                                        <th>Date</th>
                                        <th>Tenant/Employee Name</th>
                                        <th>Violation(s)</th>
                                    </tr>
                                    <tr id="trComplaints" style="display: none;">
                                        <th>Date</th>
                                        <th>Complaint Code</th>
                                        <th>Complaint Description</th>
                                        <th>Priority Status</th>
                                    </tr>
                                    <tr id="trWorkOrders" style="display: none;">
                                        <th>Date</th>
                                        <th>Trade Name</th>
                                        <th>Work Order Details</th>
                                        <th>Assigned Personnel</th>
                                    </tr>
                                </thead>
                                <tbody id="tblDashboardListofMain"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-danger" id="wojobmodalclose" onclick='$("#dashboard_ViewdetailsMaintenance").modal("hide");'>Close</button>
            </div>
        </div>
    </div>
</div>