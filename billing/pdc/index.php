<div class="row">
    <div class="col-xs-12">
        <div class="row form-group" style="margin-bottom: 0px;">
            <div class="col-xs-2" style="padding-bottom: 5px;padding-left: 0px;">
                <span class="input-icon" style="width: 100%;">
                    <input type="text" class="form-control" placeholder="Search" id="asdasdasd" title="Search">
                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                </span>
            </div>
            <div class="col-xs-4" style="padding-bottom: 5px;padding-left: 0px;">
                <h5><a onclick="LoadPDCFilter('PDCList');" id="LINK_PDC_filter" style="" class="popover-info" data-rel="popover" data-placement="bottom" title="Filter by" data-content='
                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:105px;">&nbsp;&nbsp;&nbsp;&nbsp;Search By&nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-4">
                                <label>
                                    <input name="form-field-checkboxpdc" class="ace ace-checkbox-2 pdclist_module_filter" type="checkbox" value="tradename" id="filter_tradename">
                                    <span class="lbl"> <span class="thSysTenant"></span></span>
                                </label>    
                            </div>
                            <div class="col-md-4">
                                <label>
                                    <input name="form-field-checkboxpdc" class="ace ace-checkbox-2 pdclist_module_filter" type="checkbox" value="depository" id="filter_depository">
                                    <span class="lbl"> Depository</span>
                                </label>    
                            </div>
                            <div class="col-md-4">
                                <label>
                                    <input name="form-field-checkboxpdc" class="ace ace-checkbox-2 pdclist_module_filter" type="checkbox" value="chckreceivedby" id="filter_chckreceivedby">
                                    <span class="lbl"> Received By</span>
                                </label> 
                            </div>
                        </div>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-4">
                                <label>
                                    <input name="form-field-checkboxpdc" class="ace ace-checkbox-2 pdclist_module_filter" type="checkbox" value="bank" id="filter_bank">
                                    <span class="lbl"> Bank</span>
                                </label>  
                            </div>
                            <div class="col-md-4">
                                <label>
                                    <input name="form-field-checkboxpdc" class="ace ace-checkbox-2 pdclist_module_filter" type="checkbox" value="checkno" id="filter_checkno">
                                    <span class="lbl"> Check No.</span>
                                </label>  
                            </div>   
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:150px;">&nbsp;&nbsp;&nbsp;&nbsp;Depository Status&nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-4">
                                <label>
                                    <input name="form-field-checkboxdep" class="ace ace-checkbox-2 dep_filter" type="checkbox" value="Deposited" id="filter_Deposited">
                                    <span class="lbl"> Deposited</span>
                                </label>  
                            </div>
                            <div class="col-md-4">
                                <label>
                                    <input name="form-field-checkboxdep" class="ace ace-checkbox-2 dep_filter" type="checkbox" value="For Deposit" id="filter_For Deposit">
                                    <span class="lbl"> For Deposit</span>
                                </label>  
                            </div>
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:120px;">&nbsp;&nbsp;&nbsp;&nbsp;Check Status&nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-4">
                                <label>
                                    <input name="form-field-checkboxcheck" class="ace ace-checkbox-2" type="checkbox" value="Cleared" id="filter_Cleared">
                                    <span class="lbl"> Cleared</span>
                                </label>  
                            </div>
                            <div class="col-md-4">
                                <label>
                                    <input name="form-field-checkboxcheck" class="ace ace-checkbox-2" type="checkbox" value="Pending" id="filter_Pending">
                                    <span class="lbl"> Pending</span>
                                </label>  
                            </div>
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_chkpdcdate">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:105px;">&nbsp;&nbsp;&nbsp;&nbsp;PDC Date &nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-2">
                                <label style="margin-top:5px;">
                                    <input name="form-field-checkbox" class="ace ace-checkbox-2" type="checkbox" value="" id="pdcdate"  onclick="pdcdate();">
                                    <span class="lbl"> Date</span>
                                </label>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <input class="form-control div_apppdc date-picker" type="text" id="txtstartpdc" data-provide="datepicker">
                                </div>                              
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <input class="form-control div_apppdc date-picker" type="text" id="txtendpdc" data-provide="datepicker">
                                </div>                              
                            </div>
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_chkdepdate">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:140px;">&nbsp;&nbsp;&nbsp;&nbsp;Depository Date &nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-2">
                                <label style="margin-top:5px;">
                                    <input name="form-field-checkbox" class="ace ace-checkbox-2" type="checkbox" value="" id="depdate"  onclick="depdate();">
                                    <span class="lbl"> Date</span>
                                </label>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <input class="form-control div_appdep date-picker" type="text" id="depstartpdc" data-provide="datepicker">
                                </div>                              
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <input class="form-control div_appdep date-picker" type="text" id="dependpdc" data-provide="datepicker">
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
                            <button class="btn btn-xs btn-info btn-round" onclick="savePDCFilter();" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">OK</button>
                        </div>
                    </div>'><i class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;Select Filter here</a>
                </h5>
            </div>
            <div class="col-xs-4"></div>
            <div class="col-xs-2">
                <div class="pull-right">
                    <h5><a onclick="showprintbyme2();" id="ehehe" class="popover-info" data-rel="popover" data-placement="bottom" title="Print by" data-content='
                        <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                            <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:205px;">&nbsp;&nbsp;Filter by Mall&nbsp;&nbsp;</legend>
                                <div class="form-group row" style="margin:0px;">
                                    <select class="form-control malloption" id="printbymec2"></select>
                                </div>
                        </fieldset>

                        <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_chkappdate">
                            <div class="form-group row" style="margin:0px;">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar bigger-110"></i>
                                        </span>
                                        <input class="form-control date-picker" type="text" id="dateFrom" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>">
                                    </div>                
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar bigger-110"></i>
                                        </span>
                                        <input class="form-control date-picker" type="text" id="dateTo" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>">
                                    </div>                
                                </div>
                            </div>
                        </fieldset>

                        <div class="form-group row" style="padding-left:8px;margin-bottom:0px;">
                            <div class="col-md-9" style="padding-right:0px;">
                                <div class="alert alert-info" style="padding-top:10px;padding-bottom:10px;">
                                    <button class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Select the range of date you want to print.
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-xs btn-success btn-round" onclick="printkomamamo2()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">Print</button>
                            </div>
                        </div>'><i class="glyphicon glyphicon-print bigger-110"></i>&nbsp;&nbsp;Print</a>
                    </h5>
                </div>
            </div>
        </div>
        <div class="row form-group" style="margin-bottom: 0px !important;">
            <div class="parent">
                <table class="table table-bordered fixTable">
                    <thead>
                        <tr>
                            <th width="1%">PDC Date</th>
                            <th width="15%" class="thSysTenant">Trade Name</th>
                            <th width="10%">Amount</th>
                            <th width="10%">Depository Status</th>
                            <th width="10%">Check Status</th>
                            <th width="10%">Bank</th>
                            <th width="8%">Check No.</th>
                            <th width="8%">Depository</th>
                            <th width="10%">Received By</th>
                            <th width="8%">Dep. Date</th>
                            <th width="7%" style="z-index: 1;">Options</th>
                        </tr>
                    </thead>
                    <tbody id="tbllistofpdc"></tbody>
                </table>
            </div>
            <table class="tabledash_footer table" style="margin: 0px !important;">
                <thead>
                    <tr>
                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                            <font id="txtbillingentriespdc" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                            <input id="txt_userpagepdc" type="hidden">
                            <ul id="ulpaginationlistofpdc" class="pagination pull-right"></ul>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div id="reportcontainer" style="margin-top: 10px; display: none;">
    <center>
        <div class="checklist" id="div_form_printngmamamo" style="width: 100%;">
            <center>
                <table cellspacing="0" style="padding: 5px; width: 100%">
                    <tr>
                        <td colspan="2" align="center">
                            <div style="width: 100%; text-align: left;">
                                <table style="width: 100%;" cellspacing="0" cellpadding="0">
                                    <tbody id="template5"></tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="right"><p style="font-size: 15px; margin-top: 5px;">From:&nbsp;&nbsp;<label id="dateFrom2"></label>&nbsp;&nbsp;To&nbsp;&nbsp;<label id="dateTo2"></label></p></td>
                    </tr>
                    <tr>
                        <td><center><p style="font-size: 22px; font-weight: bold;background-color: #666;color: white;width: 100%;">List of PDC</p></center></td>
                    </tr>
                    <tr>
                        <td>
                            <table style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>PDC Date</th>
                                        <th>Trade Name</th>
                                        <th>Amount</th>
                                        <th>Depository Status</th>
                                        <th>Check Status</th>
                                        <th>Bank</th>
                                        <th>Check No.</th>
                                        <th>Depository</th>
                                        <th>Received By</th>
                                        <th>Date</th>
                                        <th>Dep. Date</th>
                                    </tr>
                                    <td colspan="11"><hr></td>
                                </thead>
                                <tbody id="contentngmamamo" style="border: 1px solid black; border-right: 1px solid black;"></tbody>
                            </table>
                        </td>
                     </tr>
                </table>
            </center>
        </div>
    </center>
</div>
<?php include("script.php"); ?>