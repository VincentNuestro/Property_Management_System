<div class="row">
    <div class="col-md-12">
        <div class="row form-group">
            <div class="col-md-2">
                <div class="search-area well well-sm">
                    <div class="search-filter-header bg-primary">
                        <h5 class="smaller no-margin-bottom">
                            <i class="ace-icon fa fa-file-text light-green bigger-130"></i>&nbsp; Reference Data
                        </h5>
                    </div>
                    <div class="space-4"></div>
                    <ol class="dd-list">
                        <li class="dd-item dd2-item" style="cursor: pointer; " onclick="fncChangeJDAMappingTab('JDACompany'); $('#txtPageJDACompany').val('1'); fncShowJDACompany();">
                            <div class="dd2-content" id="ddJDACompany" style="background-color: rgb(102, 102, 102); color: rgb(255, 255, 255);">
                                <label>Companies</label>
                            </div>
                        </li>
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeJDAMappingTab('JDAMall'); $('#txtPageJDAMall').val('1'); fncShowJDAMall();">
                            <div class="dd2-content" id="ddJDAMall">
                                <label>Mall Branches</label>
                            </div>
                        </li>
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeJDAMappingTab('JDATenant'); $('#txtPageJDATenant').val('1'); fncShowJDATenant();">
                            <div class="dd2-content" id="ddJDATenant">
                                <label>Tenants</label>
                            </div>
                        </li>
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeJDAMappingTab('JDAPaymentType'); $('#txtPageJDAPaymentType').val('1'); fncShowJDAPaymentType();">
                            <div class="dd2-content" id="ddJDAPaymentType">
                                <label>Payment Types</label>
                            </div>
                        </li>
                    </ol>
                    <div class="space-4"></div>

                    <div class="search-filter-header bg-primary">
                        <h5 class="smaller no-margin-bottom">
                            <i class="ace-icon fa fa-dollar light-green bigger-130"></i>&nbsp; Transactional Data
                        </h5>
                    </div>
                    <div class="space-4"></div>
                    <ol class="dd-list">
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeJDAMappingTab('JDAMaintenance'); $('#txtPageJDAMaintenance').val('1');">
                            <div class="dd2-content" id="ddJDAMaintenance">
                                <label>Maintenance</label>
                            </div>
                        </li>
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeJDAMappingTab('JDACharges'); $('#txtPageJDACharges').val('1'); fncShowJDACharges();">
                            <div class="dd2-content" id="ddJDACharges">
                                <label>Charges</label>
                            </div>
                        </li>
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeJDAMappingTab('JDAViolations'); $('#txtPageJDAViolations').val('1'); fncShowJDAViolations();">
                            <div class="dd2-content" id="ddJDAViolations">
                                <label>Violations</label>
                            </div>
                        </li>
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeJDAMappingTab('JDAPenalties'); $('#txtPageJDAPenalties').val('1'); fncShowJDAPenalties();">
                            <div class="dd2-content" id="ddJDAPenalties">
                                <label>Penalties</label>
                            </div>
                        </li>
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeJDAMappingTab('JDAEvents'); $('#txtPageJDAEvents').val('1'); fncShowJDAEvents();">
                            <div class="dd2-content" id="ddJDAEvents">
                                <label>Events</label>
                            </div>
                        </li>
                    </ol>
                    <div class="space-4"></div>
                </div>
            </div>

            <!-- JDA MAPPING SETUP FOR COMPANY -->
            <div class="col-md-7 divJDAMapping refJDACompany">
                <div class="search-area well well-sm">
                    <div class="search-filter-header bg-primary">
                        <h5 class="smaller no-margin-bottom">
                            <i class="ace-icon fa fa-th-large light-green bigger-130"></i>&nbsp; Companies
                        </h5>
                    </div>
                    <div class="space-4"></div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
                                <input type="text" class="form-control input-sm" id="txtSearchJDACompany">
                            </div>
                        </div>
                    </div>
                    <div class="row form-group" style="margin-top: -10px;">
                        <div class="col-md-12">
                            <div style="height: 70vh;">
                                <table class="table table-bordered table-hover fixTable">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Company Name</th>
                                            <th>JDA_Comp Code</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tblrefJDACompany"></tbody>
                                </table>
                            </div>
                            <table class="tabledash_footer table" style="margin: 0px !important;">
                                <thead>
                                    <tr>
                                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                            <font id="txtEntriesJDACompany" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                            <input id="txtPageJDACompany" type="hidden">
                                            <ul id="ulPageJDACompany" class="pagination pull-right"></ul>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 divJDAMapping refJDACompany">
                <div class="search-area well well-sm">
                    <div class="search-filter-header bg-primary">
                        <h5 class="smaller no-margin-bottom">
                            <i class="ace-icon fa fa-cog light-green bigger-130"></i>&nbsp; Option
                        </h5>
                    </div>
                    <div class="space-4"></div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">JDA_Comp Code:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="hidden" class="form-control txtClearJDACompany" id="txtJDACompanyID">
                            <input type="text" class="form-control txtClearJDACompany ThisIsForCodes" id="txtJDACompanyCode" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group select-editjdaMapping hide isadmin">
                        <div class="col-md-12">
                            <div class="btn-group pull-right" id="btnEditJDACompany">
                                <button class="btn btn-success btn-round btn-sm" onclick="fncClickEditJDACompany()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
                            </div>
                            <div class="btn-group pull-right" style="display: none;" id="btnSavingJDACompany">
                                <button class="btn btn-primary btn-round btn-sm" id="btnJDASaveCompany" onclick="fncClickSaveJDACompany()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving..."><span class="fa fa-check"></span> Save</button>
                                <button class="btn btn-danger btn-round btn-sm" onclick="fncClickCancelJDACompany()"><span class="fa fa-remove"></span> Cancel</button>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
            <!-- JDA MAPPING SETUP FOR COMPANY -->

            <!-- JDA MAPPING SETUP FOR MALL -->
            <div class="col-md-7 divJDAMapping refJDAMall hide">
                <div class="search-area well well-sm">
                    <div class="search-filter-header bg-primary">
                        <h5 class="smaller no-margin-bottom">
                            <i class="ace-icon fa fa-th-large light-green bigger-130"></i>&nbsp; Mall Branches
                        </h5>
                    </div>
                    <div class="space-4"></div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
                                <input type="text" class="form-control input-sm" id="txtSearchJDAMall">
                            </div>
                        </div>
                    </div>
                    <div class="row form-group" style="margin-top: -10px;">
                        <div class="col-md-12">
                            <div style="height: 70vh;">
                                <table class="table table-bordered table-hover fixTable">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Mall Name</th>
                                            <th>Company Name</th>
                                            <th>JDA_Mall Code</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tblrefJDAMall"></tbody>
                                </table>
                            </div>
                            <table class="tabledash_footer table" style="margin: 0px !important;">
                                <thead>
                                    <tr>
                                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                            <font id="txtEntriesJDAMall" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                            <input id="txtPageJDAMall" type="hidden">
                                            <ul id="ulPageJDAMall" class="pagination pull-right"></ul>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 divJDAMapping refJDAMall hide">
                <div class="search-area well well-sm">
                    <div class="search-filter-header bg-primary">
                        <h5 class="smaller no-margin-bottom">
                            <i class="ace-icon fa fa-cog light-green bigger-130"></i>&nbsp; Option
                        </h5>
                    </div>
                    <div class="space-4"></div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">JDA_Mall Code:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="hidden" class="form-control txtClearJDAMall" id="txtJDAMallID">
                            <input type="text" class="form-control txtClearJDAMall ThisIsForCodes" id="txtJDAMallCode" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group select-editjdaMapping hide isadmin">
                        <div class="col-md-12">
                            <div class="btn-group pull-right" id="btnEditJDAMall">
                                <button class="btn btn-success btn-round btn-sm" onclick="fncClickEditJDAMall()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
                            </div>
                            <div class="btn-group pull-right" style="display: none;" id="btnSavingJDAMall">
                                <button class="btn btn-primary btn-round btn-sm" id="btnJDASaveMall" onclick="fncClickSaveJDAMall()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving..."><span class="fa fa-check"></span> Save</button>
                                <button class="btn btn-danger btn-round btn-sm" onclick="fncClickCancelJDAMall()"><span class="fa fa-remove"></span> Cancel</button>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
            <!-- JDA MAPPING SETUP FOR MALL -->

            <!-- JDA MAPPING SETUP FOR TENANT -->
            <div class="col-md-7 divJDAMapping refJDATenant hide">
                <div class="search-area well well-sm">
                    <div class="search-filter-header bg-primary">
                        <h5 class="smaller no-margin-bottom">
                            <i class="ace-icon fa fa-th-large light-green bigger-130"></i>&nbsp; Tenants
                        </h5>
                    </div>
                    <div class="space-4"></div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
                                <input type="text" class="form-control input-sm" id="txtSearchJDATenant">
                            </div>
                        </div>
                    </div>
                    <div class="row form-group" style="margin-top: -10px;">
                        <div class="col-md-12">
                            <div style="height: 70vh;">
                                <table class="table table-bordered table-hover fixTable" style="width: 1200px;">
                                    <thead>
                                        <tr>
                                            <th>Tenant ID</th>
                                            <th>Trade Name</th>
                                            <th>Company</th>
                                            <th>JDA_Tenant_ID</th>
                                            <th>Intercompany</th>
                                            <th>Vendor Code</th>
                                            <th>Vendor Location</th>
                                            <th>JDA_Comp_ID</th>
                                            <th>Beg_Date</th>
                                            <th style="text-align: right;">Beg_Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tblrefJDATenant"></tbody>
                                </table>
                            </div>
                            <table class="tabledash_footer table" style="margin: 0px !important;">
                                <thead>
                                    <tr>
                                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                            <font id="txtEntriesJDATenant" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                            <input id="txtPageJDATenant" type="hidden">
                                            <ul id="ulPageJDATenant" class="pagination pull-right"></ul>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 divJDAMapping refJDATenant hide">
                <div class="search-area well well-sm">
                    <div class="search-filter-header bg-primary">
                        <h5 class="smaller no-margin-bottom">
                            <i class="ace-icon fa fa-cog light-green bigger-130"></i>&nbsp; Option
                        </h5>
                    </div>
                    <div class="space-4"></div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">JDA_Tenant_ID:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="hidden" class="form-control txtClearJDATenant" id="txtJDATenantID">
                            <input type="text" class="form-control txtClearJDATenant txtEditJDATenant ThisIsForCodes" id="txtJDATenantCode" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Intercompany?:</label>
                        <div class="col-md-12 col-xs-12">
                            <select class="form-control txtClearJDATenant txtEditJDATenant searchy_select" id="txtJDATenantisVendor" disabled onchange="fncisVendor();" style="width: 100%;">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group hide isVendorYes">
                        <label class="control-label col-md-12 col-xs-12">Vendor Code:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDATenant txtEditJDATenant ThisIsForCodes" id="txtJDATenantVendorCode" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group hide isVendorYes">
                        <label class="control-label col-md-12 col-xs-12">Vendor Location:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDATenant txtEditJDATenant ThisIsForCodes" id="txtJDATenantVendorLocationCode" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">JDA_Comp_ID:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDATenant txtEditJDATenant ThisIsForCodes" id="txtJDATenantCompID" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Beg_Date:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDATenant txtEditJDATenant date-picker" id="txtJDATenantBeg_Date" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Beg_Balance:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDATenant txtEditJDATenant ThisIsForAmounts" id="txtJDATenantBeg_Balance" onkeypress="return isNumberKey(event)" readonly maxlength="20" style="text-align: right;">
                        </div>
                    </div>
                    <div class="row form-group select-editjdaMapping hide isadmin">
                        <div class="col-md-12">
                            <div class="btn-group pull-right" id="btnEditJDATenant">
                                <button class="btn btn-success btn-round btn-sm" onclick="fncClickEditJDATenant()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
                            </div>
                            <div class="btn-group pull-right" style="display: none;" id="btnSavingJDATenant">
                                <button class="btn btn-primary btn-round btn-sm" id="btnJDASaveMall" onclick="fncClickSaveJDATenant()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving..."><span class="fa fa-check"></span> Save</button>
                                <button class="btn btn-danger btn-round btn-sm" onclick="fncClickCancelJDATenant()"><span class="fa fa-remove"></span> Cancel</button>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
            <!-- JDA MAPPING SETUP FOR TENANT -->

            <!-- JDA MAPPING SETUP FOR PAYMENT TYPE -->
            <div class="col-md-7 divJDAMapping refJDAPaymentType hide">
                <div class="search-area well well-sm">
                    <div class="search-filter-header bg-primary">
                        <h5 class="smaller no-margin-bottom">
                            <i class="ace-icon fa fa-th-large light-green bigger-130"></i>&nbsp; Payment Type
                        </h5>
                    </div>
                    <div class="space-4"></div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
                                <input type="text" class="form-control input-sm" id="txtSearchJDAPaymentType">
                            </div>
                        </div>
                    </div>
                    <div class="row form-group" style="margin-top: -10px;">
                        <div class="col-md-12">
                            <div style="height: 70vh;">
                                <table class="table table-bordered table-hover fixTable">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Description</th>
                                            <th>Payment Type</th>
                                            <th>JDA_Pay_Code</th>
                                            <!-- <th>Dr_COA</th> -->
                                            <!-- <th>Cr_COA</th> -->
                                        </tr>
                                    </thead>
                                    <tbody id="tblrefJDAPaymentType"></tbody>
                                </table>
                            </div>
                            <table class="tabledash_footer table" style="margin: 0px !important;">
                                <thead>
                                    <tr>
                                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                            <font id="txtEntriesJDAPaymentType" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                            <input id="txtPageJDAPaymentType" type="hidden">
                                            <ul id="ulPageJDAPaymentType" class="pagination pull-right"></ul>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 divJDAMapping refJDAPaymentType hide">
                <div class="search-area well well-sm">
                    <div class="search-filter-header bg-primary">
                        <h5 class="smaller no-margin-bottom">
                            <i class="ace-icon fa fa-cog light-green bigger-130"></i>&nbsp; Option
                        </h5>
                    </div>
                    <div class="space-4"></div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">JDA_Pay_Code:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="hidden" class="form-control txtClearJDAPaymentType" id="txtJDAPaymentTypeID">
                            <input type="text" class="form-control txtClearJDAPaymentType txtEditJDAPaymentType ThisIsForCodes" id="txtJDAPaymentTypePayCode" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group hide">
                        <label class="control-label col-md-12 col-xs-12">Dr_COA:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDAPaymentType txtEditJDAPaymentType ThisIsForCodes" id="txtJDAPaymentTypeDr_COA" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group hide">
                        <label class="control-label col-md-12 col-xs-12">Cr_COA:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDAPaymentType txtEditJDAPaymentType ThisIsForCodes" id="txtJDAPaymentTypeCr_COA" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group select-editjdaMapping hide isadmin">
                        <div class="col-md-12">
                            <div class="btn-group pull-right" id="btnEditJDAPaymentType">
                                <button class="btn btn-success btn-round btn-sm" onclick="fncClickEditJDAPaymentType()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
                            </div>
                            <div class="btn-group pull-right" style="display: none;" id="btnSavingJDAPaymentType">
                                <button class="btn btn-primary btn-round btn-sm" id="btnJDASaveMall" onclick="fncClickSaveJDAPaymentType()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving..."><span class="fa fa-check"></span> Save</button>
                                <button class="btn btn-danger btn-round btn-sm" onclick="fncClickCancelJDAPaymentType()"><span class="fa fa-remove"></span> Cancel</button>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
            <!-- JDA MAPPING SETUP FOR PAYMENT TYPE -->

            <!-- JDA MAPPING SETUP FOR MAINTENANCE -->
            <div class="col-md-7 divJDAMapping refJDAMaintenance hide">
                <div class="search-area well well-sm">
                    <div class="search-filter-header bg-primary">
                        <h5 class="smaller no-margin-bottom">
                            <i class="ace-icon fa fa-th-large light-green bigger-130"></i>&nbsp; Maintenance
                        </h5>
                    </div>
                    <div class="space-4"></div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
                                <input type="text" class="form-control input-sm" id="txtSearchJDAMaintenance">
                            </div>
                        </div>
                    </div>
                    <div class="row form-group" style="margin-top: -10px;">
                        <div class="col-md-12">
                            <div style="height: 70vh;">
                                <table class="table table-bordered table-hover fixTable" style="width: 1200px;">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Code</th>
                                            <th>Task</th>
                                            <th>Lessor Major</th>
                                            <th>Lessor Minor</th>
                                            <th>Lessor COA Store</th>
                                            <th>Vendor Major</th>
                                            <th>Vendor Minor</th>
                                            <th>Vendor COA Store</th>
                                            <th>WthTaxRate</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tblrefJDAMaintenance"></tbody>
                                </table>
                            </div>
                            <table class="tabledash_footer table" style="margin: 0px !important;">
                                <thead>
                                    <tr>
                                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                            <font id="txtEntriesJDAMaintenance" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                            <input id="txtPageJDAMaintenance" type="hidden">
                                            <ul id="ulPageJDAMaintenance" class="pagination pull-right"></ul>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 divJDAMapping refJDAMaintenance hide">
                <div class="search-area well well-sm">
                    <div class="search-filter-header bg-primary">
                        <h5 class="smaller no-margin-bottom">
                            <i class="ace-icon fa fa-cog light-green bigger-130"></i>&nbsp; Option
                        </h5>
                    </div>
                    <div class="space-4"></div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Lessor Major:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="hidden" class="form-control txtClearJDAMaintenance" id="txtJDAMaintenanceID">
                            <input type="text" class="form-control txtClearJDAMaintenance txtEditJDAMaintenance ThisIsForCodes" id="txtJDAMaintenanceLssrMjr" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Lessor Minor:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDAMaintenance txtEditJDAMaintenance ThisIsForCodes" id="txtJDAMaintenanceLssrMnr" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Lessor COA Store:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDAMaintenance txtEditJDAMaintenance ThisIsForCodes" id="txtJDAMaintenanceLssrCOAStore" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Vendor Major:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDAMaintenance txtEditJDAMaintenance ThisIsForCodes" id="txtJDAMaintenanceVndrMjr" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Vendor Minor:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDAMaintenance txtEditJDAMaintenance ThisIsForCodes" id="txtJDAMaintenanceVndrMnr" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Vendor COA Store:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDAMaintenance txtEditJDAMaintenance ThisIsForCodes" id="txtJDAMaintenanceVndrCOAStore" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Witholding Tax Rate:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDAMaintenance txtEditJDAMaintenance ThisIsForAmounts" id="txtJDAMaintenanceWthTaxRate" readonly maxlength="20" onkeypress="return isNumberKey(event)" style="text-align: right;">
                        </div>
                    </div>
                    <div class="row form-group select-editjdaMapping hide isadmin">
                        <div class="col-md-12">
                            <div class="btn-group pull-right" id="btnEditJDAMaintenance">
                                <button class="btn btn-success btn-round btn-sm" onclick="fncClickEditJDAMaintenance()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
                            </div>
                            <div class="btn-group pull-right" style="display: none;" id="btnSavingJDAMaintenance">
                                <button class="btn btn-primary btn-round btn-sm" id="btnJDASaveMall" onclick="fncClickSaveJDAMaintenance()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving..."><span class="fa fa-check"></span> Save</button>
                                <button class="btn btn-danger btn-round btn-sm" onclick="fncClickCancelJDAMaintenance()"><span class="fa fa-remove"></span> Cancel</button>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
            <!-- JDA MAPPING SETUP FOR MAINTENANCE -->

            <!-- JDA MAPPING SETUP FOR CHARGES -->
            <div class="col-md-7 divJDAMapping refJDACharges hide">
                <div class="search-area well well-sm">
                    <div class="search-filter-header bg-primary">
                        <h5 class="smaller no-margin-bottom">
                            <i class="ace-icon fa fa-th-large light-green bigger-130"></i>&nbsp; Charges
                        </h5>
                    </div>
                    <div class="space-4"></div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
                                <input type="text" class="form-control input-sm" id="txtSearchJDACharges">
                            </div>
                        </div>
                    </div>
                    <div class="row form-group" style="margin-top: -10px;">
                        <div class="col-md-12">
                            <div style="height: 70vh;">
                                <table class="table table-bordered table-hover fixTable" style="width: 1200px;">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Description</th>
                                            <th>Lessor Major</th>
                                            <th>Lessor Minor</th>
                                            <th>Lessor COA Store</th>
                                            <th>Vendor Major</th>
                                            <th>Vendor Minor</th>
                                            <th>Vendor COA Store</th>
                                            <th>WthTaxRate</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tblrefJDACharges"></tbody>
                                </table>
                            </div>
                            <table class="tabledash_footer table" style="margin: 0px !important;">
                                <thead>
                                    <tr>
                                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                            <font id="txtEntriesJDACharges" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                            <input id="txtPageJDACharges" type="hidden">
                                            <ul id="ulPageJDACharges" class="pagination pull-right"></ul>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 divJDAMapping refJDACharges hide">
                <div class="search-area well well-sm">
                    <div class="search-filter-header bg-primary">
                        <h5 class="smaller no-margin-bottom">
                            <i class="ace-icon fa fa-cog light-green bigger-130"></i>&nbsp; Option
                        </h5>
                    </div>
                    <div class="space-4"></div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Lessor Major:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="hidden" class="form-control txtClearJDACharges" id="txtJDAChargesID">
                            <input type="text" class="form-control txtClearJDACharges txtEditJDACharges ThisIsForCodes" id="txtJDAChargesLssrMjr" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Lessor Minor:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDACharges txtEditJDACharges ThisIsForCodes" id="txtJDAChargesLssrMnr" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Lessor COA Store:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDACharges txtEditJDACharges ThisIsForCodes" id="txtJDAChargesLssrCOAStore" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Vendor Major:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDACharges txtEditJDACharges ThisIsForCodes" id="txtJDAChargesVndrMjr" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Vendor Minor:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDACharges txtEditJDACharges ThisIsForCodes" id="txtJDAChargesVndrMnr" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Vendor COA Store:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDACharges txtEditJDACharges ThisIsForCodes" id="txtJDAChargesVndrCOAStore" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Witholding Tax Rate:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDACharges txtEditJDACharges ThisIsForAmounts" id="txtJDAChargesWthTaxRate" readonly maxlength="20" onkeypress="return isNumberKey(event)" style="text-align: right;">
                        </div>
                    </div>
                    <div class="row form-group select-editjdaMapping hide isadmin">
                        <div class="col-md-12">
                            <div class="btn-group pull-right" id="btnEditJDACharges">
                                <button class="btn btn-success btn-round btn-sm" onclick="fncClickEditJDACharges()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
                            </div>
                            <div class="btn-group pull-right" style="display: none;" id="btnSavingJDACharges">
                                <button class="btn btn-primary btn-round btn-sm" id="btnJDASaveMall" onclick="fncClickSaveJDACharges()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving..."><span class="fa fa-check"></span> Save</button>
                                <button class="btn btn-danger btn-round btn-sm" onclick="fncClickCancelJDACharges()"><span class="fa fa-remove"></span> Cancel</button>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
            <!-- JDA MAPPING SETUP FOR CHARGES -->

            <!-- JDA MAPPING SETUP FOR VIOLATIONS -->
            <div class="col-md-7 divJDAMapping refJDAViolations hide">
                <div class="search-area well well-sm">
                    <div class="search-filter-header bg-primary">
                        <h5 class="smaller no-margin-bottom">
                            <i class="ace-icon fa fa-th-large light-green bigger-130"></i>&nbsp; Violations
                        </h5>
                    </div>
                    <div class="space-4"></div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
                                <input type="text" class="form-control input-sm" id="txtSearchJDAViolations">
                            </div>
                        </div>
                    </div>
                    <div class="row form-group" style="margin-top: -10px;">
                        <div class="col-md-12">
                            <div style="height: 70vh;">
                                <table class="table table-bordered table-hover fixTable" style="width: 1200px;">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Description</th>
                                            <th>Lessor Major</th>
                                            <th>Lessor Minor</th>
                                            <th>Lessor COA Store</th>
                                            <th>Vendor Major</th>
                                            <th>Vendor Minor</th>
                                            <th>Vendor COA Store</th>
                                            <th>WthTaxRate</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tblrefJDAViolations"></tbody>
                                </table>
                            </div>
                            <table class="tabledash_footer table" style="margin: 0px !important;">
                                <thead>
                                    <tr>
                                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                            <font id="txtEntriesJDAViolations" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                            <input id="txtPageJDAViolations" type="hidden">
                                            <ul id="ulPageJDAViolations" class="pagination pull-right"></ul>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 divJDAMapping refJDAViolations hide">
                <div class="search-area well well-sm">
                    <div class="search-filter-header bg-primary">
                        <h5 class="smaller no-margin-bottom">
                            <i class="ace-icon fa fa-cog light-green bigger-130"></i>&nbsp; Option
                        </h5>
                    </div>
                    <div class="space-4"></div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Lessor Major:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="hidden" class="form-control txtClearJDAViolations" id="txtJDAViolationsID">
                            <input type="text" class="form-control txtClearJDAViolations txtEditJDAViolations ThisIsForCodes" id="txtJDAViolationsLssrMjr" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Lessor Minor:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDAViolations txtEditJDAViolations ThisIsForCodes" id="txtJDAViolationsLssrMnr" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Lessor COA Store:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDAViolations txtEditJDAViolations ThisIsForCodes" id="txtJDAViolationsLssrCOAStore" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Vendor Major:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDAViolations txtEditJDAViolations ThisIsForCodes" id="txtJDAViolationsVndrMjr" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Vendor Minor:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDAViolations txtEditJDAViolations ThisIsForCodes" id="txtJDAViolationsVndrMnr" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Vendor COA Store:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDAViolations txtEditJDAViolations ThisIsForCodes" id="txtJDAViolationsVndrCOAStore" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Witholding Tax Rate:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDAViolations txtEditJDAViolations ThisIsForAmounts" id="txtJDAViolationsWthTaxRate" readonly maxlength="20" onkeypress="return isNumberKey(event)" style="text-align: right;">
                        </div>
                    </div>
                    <div class="row form-group select-editjdaMapping hide isadmin">
                        <div class="col-md-12">
                            <div class="btn-group pull-right" id="btnEditJDAViolations">
                                <button class="btn btn-success btn-round btn-sm" onclick="fncClickEditJDAViolations()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
                            </div>
                            <div class="btn-group pull-right" style="display: none;" id="btnSavingJDAViolations">
                                <button class="btn btn-primary btn-round btn-sm" id="btnJDASaveMall" onclick="fncClickSaveJDAViolations()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving..."><span class="fa fa-check"></span> Save</button>
                                <button class="btn btn-danger btn-round btn-sm" onclick="fncClickCancelJDAViolations()"><span class="fa fa-remove"></span> Cancel</button>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
            <!-- JDA MAPPING SETUP FOR VIOLATIONS -->

            <!-- JDA MAPPING SETUP FOR PENALTIES -->
            <div class="col-md-7 divJDAMapping refJDAPenalties hide">
                <div class="search-area well well-sm">
                    <div class="search-filter-header bg-primary">
                        <h5 class="smaller no-margin-bottom">
                            <i class="ace-icon fa fa-th-large light-green bigger-130"></i>&nbsp; Penalties
                        </h5>
                    </div>
                    <div class="space-4"></div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
                                <input type="text" class="form-control input-sm" id="txtSearchJDAPenalties">
                            </div>
                        </div>
                    </div>
                    <div class="row form-group" style="margin-top: -10px;">
                        <div class="col-md-12">
                            <div style="height: 70vh;">
                                <table class="table table-bordered table-hover fixTable" style="width: 1200px;">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Description</th>
                                            <th>Lessor Major</th>
                                            <th>Lessor Minor</th>
                                            <th>Lessor COA Store</th>
                                            <th>Vendor Major</th>
                                            <th>Vendor Minor</th>
                                            <th>Vendor COA Store</th>
                                            <th>WthTaxRate</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tblrefJDAPenalties"></tbody>
                                </table>
                            </div>
                            <table class="tabledash_footer table" style="margin: 0px !important;">
                                <thead>
                                    <tr>
                                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                            <font id="txtEntriesJDAPenalties" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                            <input id="txtPageJDAPenalties" type="hidden">
                                            <ul id="ulPageJDAPenalties" class="pagination pull-right"></ul>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 divJDAMapping refJDAPenalties hide">
                <div class="search-area well well-sm">
                    <div class="search-filter-header bg-primary">
                        <h5 class="smaller no-margin-bottom">
                            <i class="ace-icon fa fa-cog light-green bigger-130"></i>&nbsp; Option
                        </h5>
                    </div>
                    <div class="space-4"></div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Lessor Major:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="hidden" class="form-control txtClearJDAPenalties" id="txtJDAPenaltiesID">
                            <input type="text" class="form-control txtClearJDAPenalties txtEditJDAPenalties ThisIsForCodes" id="txtJDAPenaltiesLssrMjr" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Lessor Minor:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDAPenalties txtEditJDAPenalties ThisIsForCodes" id="txtJDAPenaltiesLssrMnr" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Lessor COA Store:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDAPenalties txtEditJDAPenalties ThisIsForCodes" id="txtJDAPenaltiesLssrCOAStore" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Vendor Major:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDAPenalties txtEditJDAPenalties ThisIsForCodes" id="txtJDAPenaltiesVndrMjr" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Vendor Minor:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDAPenalties txtEditJDAPenalties ThisIsForCodes" id="txtJDAPenaltiesVndrMnr" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Vendor COA Store:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDAPenalties txtEditJDAPenalties ThisIsForCodes" id="txtJDAPenaltiesVndrCOAStore" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Witholding Tax Rate:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDAPenalties txtEditJDAPenalties ThisIsForAmounts" id="txtJDAPenaltiesWthTaxRate" readonly maxlength="20" onkeypress="return isNumberKey(event)" style="text-align: right;">
                        </div>
                    </div>
                    <div class="row form-group select-editjdaMapping hide isadmin">
                        <div class="col-md-12">
                            <div class="btn-group pull-right" id="btnEditJDAPenalties">
                                <button class="btn btn-success btn-round btn-sm" onclick="fncClickEditJDAPenalties()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
                            </div>
                            <div class="btn-group pull-right" style="display: none;" id="btnSavingJDAPenalties">
                                <button class="btn btn-primary btn-round btn-sm" id="btnJDASaveMall" onclick="fncClickSaveJDAPenalties()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving..."><span class="fa fa-check"></span> Save</button>
                                <button class="btn btn-danger btn-round btn-sm" onclick="fncClickCancelJDAPenalties()"><span class="fa fa-remove"></span> Cancel</button>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
            <!-- JDA MAPPING SETUP FOR PENALTIES -->

            <!-- JDA MAPPING SETUP FOR EVENTS -->
            <div class="col-md-7 divJDAMapping refJDAEvents hide">
                <div class="search-area well well-sm">
                    <div class="search-filter-header bg-primary">
                        <h5 class="smaller no-margin-bottom">
                            <i class="ace-icon fa fa-th-large light-green bigger-130"></i>&nbsp; Events
                        </h5>
                    </div>
                    <div class="space-4"></div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
                                <input type="text" class="form-control input-sm" id="txtSearchJDAEvents">
                            </div>
                        </div>
                    </div>
                    <div class="row form-group" style="margin-top: -10px;">
                        <div class="col-md-12">
                            <div style="height: 70vh;">
                                <table class="table table-bordered table-hover fixTable" style="width: 1200px;">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Description</th>
                                            <th>Lessor Major</th>
                                            <th>Lessor Minor</th>
                                            <th>Lessor COA Store</th>
                                            <th>Vendor Major</th>
                                            <th>Vendor Minor</th>
                                            <th>Vendor COA Store</th>
                                            <th>Witholding Tax Rate</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tblrefJDAEvents"></tbody>
                                </table>
                            </div>
                            <table class="tabledash_footer table" style="margin: 0px !important;">
                                <thead>
                                    <tr>
                                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                            <font id="txtEntriesJDAEvents" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                            <input id="txtPageJDAEvents" type="hidden">
                                            <ul id="ulPageJDAEvents" class="pagination pull-right"></ul>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 divJDAMapping refJDAEvents hide">
                <div class="search-area well well-sm">
                    <div class="search-filter-header bg-primary">
                        <h5 class="smaller no-margin-bottom">
                            <i class="ace-icon fa fa-cog light-green bigger-130"></i>&nbsp; Option
                        </h5>
                    </div>
                    <div class="space-4"></div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Event Code:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDAEvents txtEditJDAEvents ThisIsForCodes" id="txtJDAEventsCode" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group btnAddJDAEvents">
                        <label class="control-label col-md-12 col-xs-12">Event Description:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDAEvents txtEditJDAEvents ThisIsForCodes" id="txtJDAEventsDescription" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Lessor Major:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="hidden" class="form-control txtClearJDAEvents" id="txtJDAEventsID">
                            <input type="text" class="form-control txtClearJDAEvents txtEditJDAEvents ThisIsForCodes" id="txtJDAEventsLessorMajor" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Lessor Minor:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDAEvents txtEditJDAEvents ThisIsForCodes" id="txtJDAEventsLessorMinor" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Lessor COA Store:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDAEvents txtEditJDAEvents ThisIsForCodes" id="txtJDAEventsLessorCOA" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Vendor Major:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDAEvents txtEditJDAEvents ThisIsForCodes" id="txtJDAEventsVendorMajor" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Vendor Minor:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDAEvents txtEditJDAEvents ThisIsForCodes" id="txtJDAEventsVendorMinor" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Vendor COA Store:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDAEvents txtEditJDAEvents ThisIsForCodes" id="txtJDAEventsVendorCOA" readonly maxlength="20" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-12 col-xs-12">Witholding Tax Rate:</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control txtClearJDAEvents txtEditJDAEvents ThisIsForAmounts" id="txtJDAEventsWthTax" readonly maxlength="20" onkeypress="return isNumberKey(event)" style="text-align: right;">
                        </div>
                    </div>
                    <div class="row form-group select-editjdaMapping hide isadmin">
                        <div class="col-md-12">
                            <div class="btn-group pull-right" id="btnEditJDAEvents">
                                <button class="btn btn-primary btn-round btn-sm btnAddJDAEvents" onclick="fncClickAddJDAEvents()"><span class="fa fa-plus"></span> Add</button>
                                <input type="hidden" id="txtJDAEventAllowAdd">
                                <button class="btn btn-success btn-round btn-sm" onclick="fncClickEditJDAEvents()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
                            </div>
                            <div class="btn-group pull-right" style="display: none;" id="btnSavingJDAEvents">
                                <button class="btn btn-primary btn-round btn-sm" id="btnJDASaveMall" onclick="fncClickSaveJDAEvents()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving..."><span class="fa fa-check"></span> Save</button>
                                <button class="btn btn-danger btn-round btn-sm" onclick="fncClickCancelJDAEvents()"><span class="fa fa-remove"></span> Cancel</button>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
            <!-- JDA MAPPING SETUP FOR EVENTS -->
        </div>
    </div>
</div>

<?php include("script.php"); ?>