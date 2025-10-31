<div class="modal fade fade-scale" id="AddNewLeads" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="preloadmodalleads"></div>
            <div class="modal-header">
                <button type="button" class="close" onclick="HideLeadsMainModal()">&times;</button>
                <h4 class="modal-title" style="font-family: Roboto;font-size: 18px;">Leads Information</h4>
            </div>
            <div class="modal-body">
            <div class="row">
                <input type="hidden" id="NewLeadsTradeID">
                <input type="hidden" id="NewLeadsCompanyID">
                <div class="col-md-12">
                    <div class="row form-group">
                        <!-- <div class="col-md-12">
                            <div class="checkbox pull-right">
                                <label>
                                    <input type="checkbox" id="clicktoshowall" onclick="clicktoshowall();" class="ace">
                                    <span class="lbl" style="color: #666;font-weight: bold;">&nbsp;Expand All</span>
                                </label>
                            </div>
                        </div> -->
                        <div class="col-md-12">
                            <div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
                                <div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
                                    <div class="widget-header">
                                        <h4 class="widget-title">Prospect Information</h4>
                                        <!-- <div class="widget-toolbar no-border">
                                            <a href="#" data-action="collapse" class="clicktoshowall" id="widget-leads-information">
                                                <i class="ace-icon fa fa-chevron-down"></i>
                                            </a>
                                        </div> -->
                                    </div>
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <div class="row well">
                                                <div class="col-md-12">
                                                    <div class="row form-group" id="div_leads_information">
                                                        <div class="col-md-12" id="div_browseProspectlist">
                                                            <div class="row form-group">
                                                                <div class="col-md-2"></div>
                                                                <div class="col-md-4"><button class="btn btn-primary btn-sm btn-block btn-round" onclick='browseProspects();$("#modalProspectList").modal("show");'>Select Prospect</button></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row form-group">
                                                                <div class="col-md-4">
                                                                    Prospect Name <span style="color: red;">*</span>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control LeadsReq" id="txtLeadsName" readonly onclick="modal_loadtradename();" style="background-color: white !important;">
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-md-4">
                                                                    First Name <span style="color: red;">*</span>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control LeadsReq DisMe" id="txtLeadsFN">
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-md-4">
                                                                    Middle Name <span style="color: red;">*</span>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control LeadsReq DisMe" id="txtLeadsMN">
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-md-4">
                                                                    Last Name <span style="color: red;">*</span>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control LeadsReq DisMe" id="txtLeadsLN">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row form-group">
                                                                <div class="col-md-4">
                                                                    Company Name <span style="color: red;">*</span>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control LeadsReq" id="txtLeadsCompany" readonly onclick="modal_loadtradename();" style="background-color: white !important;">
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-md-4">
                                                                    Position <span style="color: red;">*</span>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <select class="form-control LeadsReq DisMe" id="txtLeadsPosition"></select>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-md-4">
                                                                    Assigned Person <span style="color: red;">*</span>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <select class="form-control LeadsReq DisMe" id="txtLeadsAssignedPerson"><option selected disabled value="">-- Select Person --</option></select>
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

                        <div class="col-md-12">
                            <div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
                                <div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
                                    <div class="widget-header">
                                        <h4 class="widget-title">Other Information</h4>
                                        <!-- <div class="widget-toolbar no-border">
                                            <a href="#" data-action="collapse" class="clicktoshowall" id="widgets-leads-other">
                                                <i class="ace-icon fa fa-chevron-down"></i>
                                            </a>
                                        </div> -->
                                    </div>
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <div class="row well">
                                                <div class="col-md-12">
                                                    <div class="row form-group">
                                                        <div class="row form-group">
                                                            <div class="col-md-12">
                                                                <h4 class="widget-title green">Contact Information</h4>
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col-md-6">
                                                                <div id="div_inquiry_contact_numbers" style="max-height: 300px;overflow-y: scroll;overflow-x: hidden;"></div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div id="div_inquiry_contact_person" style="max-height: 310px;overflow-y: scroll;overflow-x: hidden;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-6">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <h4 class="widget-title green">Remarks & Source</h4>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    Remarks
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <textarea class="form-control DisMe" style="resize: none;height: 100px;" id="txtLeadsRemarks"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-md-4">
                                                                    <b>Source</b>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <select class="form-control DisMe" id="txtLeadsSource">
                                                                        <option value="Agent">Agent</option>
                                                                        <option value="Booth">Booth / Showroom</option>
                                                                        <option value="Broker">Broker</option>
                                                                        <option value="Employee">Employee</option>
                                                                        <option value="Employee">Event</option>
                                                                        <option value="Email">E-mail</option>
                                                                        <option value="Employee">Flyer</option>
                                                                        <option value="Employee">Internet</option>
                                                                        <option value="Employee">Referral</option>
                                                                        <option value="RepeatBuyer">Repeat Buyer</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <h4 class="widget-title green">Attachments</h4>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <form id="frmLeadsAttachments" name="frmLeadsAttachments">
                                                                    <div id="leads_attachment" style="height: 135px;overflow-y: scroll;overflow-x: hidden;"></div>
                                                                    <input type="hidden" id="leadsattachmentcount" name="leadsattachmentcount">
                                                                    <input type="hidden" id="frmLeadsID" name="frmLeadsID">
                                                                </form>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <button class="btn btn-sm btn-success pull-right DisMe btn-round" onclick="appendleadsattachment()"><i class="fa fa-plus"></i> Add New Attachment</button>
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

                        <div class="col-md-12" id="div_SubLeadsTAB">
                            <div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
                                <div class="widget-box transparent ui-sortable-handle collapsed" id="widget-box-12">
                                    <div class="widget-header">
                                        <h4 class="widget-title lblGenTitle">Awareness Information</h4>
                                        <div class="widget-toolbar no-border">
                                            <a href="#" data-action="collapse" class="clicktoshowall" id="widgets-leads-SubLeads">
                                                <i class="ace-icon fa fa-chevron-down"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="widget-body" style="display: none;">
                                        <div class="widget-main">
                                            <div class="row well">
                                                <div class="col-md-12">
                                                    <div class="row form-group">
                                                        <div class="col-md-6">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <h4 class="widget-title green lblGenTitle">Awareness Information</h4>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-md-2">Subject</div>
                                                                <div class="col-md-10">
                                                                    <input type="text" class="form-control" id="txtSubLeadsSubject">
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <textarea class="form-control DisMe" style="resize: none;height: 150px;" id="txtSubLeadsDetails"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <h4 class="widget-title green">Attachments</h4>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <form id="frmAWAAttachments" name="frmAWAAttachments">
                                                                    <div id="leads_SubLeadsAttachment" style="height: 150px;overflow-y: scroll;overflow-x: hidden;"></div>
                                                                    <input type="hidden" id="leadsSubLeadsttachmentcount" name="leadsSubLeadsttachmentcount">
                                                                    <input type="hidden" id="frmSubLeadsModuleID" name="frmSubLeadsModuleID">
                                                                    <input type="hidden" id="frmSubLeadsID" name="frmSubLeadsID">
                                                                </form>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <button class="btn btn-sm btn-success pull-right DisMe btn-round" onclick="appendAWAleadsattachment()"><i class="fa fa-plus"></i> Add New Attachment</button>
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

                        <div class="col-md-12 tblSubLeads" id="div_SubAwareness">
                            <div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
                                <div class="widget-box transparent ui-sortable-handle collapsed" id="widget-box-12">
                                    <div class="widget-header">
                                      <h4 class="widget-title">Awareness</h4>
                                      <div class="widget-toolbar no-border">
                                        <a href="#" data-action="collapse" class="clicktoshowall" id="widgets-leads-Awareness">
                                          <i class="ace-icon fa fa-chevron-down"></i>
                                        </a>
                                      </div>
                                    </div>
                                    <div class="widget-body" style="display: none;">
                                        <div class="widget-main">
                                            <div class="row well">
                                                <div class="col-md-12">
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <div class="parent2">
                                                                <table class="table table-bordered fixTable">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Date Created</th>
                                                                            <th>Subject</th>
                                                                            <th>Details</th>
                                                                            <th style="z-index: 1;">Attachments</th>
                                                                        </tr>
                                                                        <tbody id="tblAwarenessList"></tbody>
                                                                    </thead>
                                                                </table>
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

                        <div class="col-md-12 tblSubLeads" id="div_SubReferral">
                            <div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
                                <div class="widget-box transparent ui-sortable-handle collapsed" id="widget-box-12">
                                    <div class="widget-header">
                                        <h4 class="widget-title">Referral</h4>
                                        <div class="widget-toolbar no-border">
                                            <a href="#" data-action="collapse" class="clicktoshowall" id="widgets-leads-Referral">
                                                <i class="ace-icon fa fa-chevron-down"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="widget-body" style="display: none;">
                                        <div class="widget-main">
                                            <div class="row well">
                                                <div class="col-md-12">
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <div class="parent2">
                                                                <table class="table table-bordered fixTable">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Date Created</th>
                                                                            <th>Subject</th>
                                                                            <th>Details</th>
                                                                            <th style="z-index: 1;">Attachments</th>
                                                                        </tr>
                                                                        <tbody id="tblReferralList"></tbody>
                                                                    </thead>
                                                                </table>
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

                        <div class="col-md-12 tblSubLeads" id="div_SubDemo">
                            <div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
                                <div class="widget-box transparent ui-sortable-handle collapsed" id="widget-box-12">
                                    <div class="widget-header">
                                        <h4 class="widget-title">Demo</h4>
                                        <div class="widget-toolbar no-border">
                                            <a href="#" data-action="collapse" class="clicktoshowall" id="widgets-leads-Demo">
                                                <i class="ace-icon fa fa-chevron-down"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="widget-body" style="display: none;">
                                        <div class="widget-main">
                                            <div class="row well">
                                                <div class="col-md-12">
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <div class="parent2">
                                                                <table class="table table-bordered fixTable">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Date Created</th>
                                                                            <th>Subject</th>
                                                                            <th>Details</th>
                                                                            <th style="z-index: 1;">Attachments</th>
                                                                        </tr>
                                                                        <tbody id="tblDemoList"></tbody>
                                                                    </thead>
                                                                </table>
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

                        <div class="col-md-12 tblSubLeads" id="div_SubCLM">
                            <div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
                                <div class="widget-box transparent ui-sortable-handle collapsed" id="widget-box-12">
                                    <div class="widget-header">
                                        <h4 class="widget-title">Closing Meeting</h4>
                                        <div class="widget-toolbar no-border">
                                            <a href="#" data-action="collapse" class="clicktoshowall" id="widgets-leads-CLM">
                                                <i class="ace-icon fa fa-chevron-down"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="widget-body" style="display: none;">
                                        <div class="widget-main">
                                            <div class="row well">
                                                <div class="col-md-12">
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <div class="parent2">
                                                                <table class="table table-bordered fixTable">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Date Created</th>
                                                                            <th>Subject</th>
                                                                            <th>Details</th>
                                                                            <th style="z-index: 1;">Attachments</th>
                                                                        </tr>
                                                                        <tbody id="tblCLMList"></tbody>
                                                                    </thead>
                                                                </table>
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

                        <div class="col-md-12 tblSubLeads" id="div_SubCOS">
                            <div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
                                <div class="widget-box transparent ui-sortable-handle collapsed" id="widget-box-12">
                                    <div class="widget-header">
                                        <h4 class="widget-title">Contract Signing</h4>
                                        <div class="widget-toolbar no-border">
                                            <a href="#" data-action="collapse" class="clicktoshowall" id="widgets-leads-COS">
                                                <i class="ace-icon fa fa-chevron-down"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="widget-body" style="display: none;">
                                        <div class="widget-main">
                                            <div class="row well">
                                                <div class="col-md-12">
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <div class="parent2">
                                                                <table class="table table-bordered fixTable">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Date Created</th>
                                                                            <th>Subject</th>
                                                                            <th>Details</th>
                                                                            <th style="z-index: 1;">Attachments</th>
                                                                        </tr>
                                                                        <tbody id="tblCOSList"></tbody>
                                                                    </thead>
                                                                </table>
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
            <div class="modal-footer">
                <button class="btn btn-sm btn-primary DisMe btn-round" onclick="btnSaveLeads()"><i class="ace-icon fa fa-check"></i>&nbsp;Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="modalProspectList" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-family: Roboto;font-size: 18px;">Prospect List</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group" style="padding-left:0px;">
                    <div class="col-md-12">
                        <span class="input-icon" style="width: 100%;">
                            <input type="text" class="form-control" placeholder="Search ..." id="txtsearchprospectlist">
                            <i class="ace-icon fa fa-search nav-search-icon"></i>
                        </span>
                    </div>
                </div>
                <div class="row form-group" style="margin-bottom: 0px !important;">
                    <div class="col-md-12">
                        <div class="parent">
                            <table id="simple-table" class="table table-bordered table-striped fixTable">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Prospect Name</th>
                                        <th>Company Name</th>
                                        <th>Full Name</th>
                                    </tr>
                                </thead>
                                <tbody id="tblprospectlist"></tbody>
                            </table>
                        </div>
                        <table class="tabledash_footer table" style="margin: 0px !important;">
                            <thead>
                                <tr>
                                    <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                        <font id="browseProspectsEntries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                        <input id="browseProspectsPageCount" type="hidden">
                                        <ul id="browseProspectsEntriesPage" class="pagination pull-right"></ul>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>