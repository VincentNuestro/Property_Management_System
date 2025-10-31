<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="row form-group" style="margin-bottom: 0px;">
            <div class="col-md-2" style="padding-bottom: 5px;padding-left:0px;">
                <span class="input-icon" style="width: 100%;">
                    <input type="text" class="form-control" placeholder="Search" title="Search" id="txtsearchcomplaints">
                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                </span>
            </div>
            <div class="col-md-6" style="padding-bottom: 5px;padding-left:0px;">
                <h5><a onclick="loadComplaintFilter('Complaint')" id="LINK_Complaint_filter" class="popover-info" data-rel="popover" data-placement="bottom" title="Filter by" data-content='
                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                    <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:95px;">&nbsp;&nbsp;Search by&nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-6">
                                <label>
                                    <input name="form-field-checkboxph" class="ace ace-checkbox-2 complaint_module_filter" type="checkbox" value="TenantID" id="filter_TenantID">
                                    <span class="lbl"> <?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?> ID</span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label>
                                    <input name="form-field-checkboxph" class="ace ace-checkbox-2 complaint_module_filter" type="checkbox" value="Complaint_Code" id="filter_Complaint_Code">
                                    <span class="lbl"> Complaint Code</span>
                                </label>                               
                            </div>
                            <div class="col-md-6">
                                <label>
                                    <input name="form-field-checkboxph" class="ace ace-checkbox-2 complaint_module_filter" type="checkbox" value="TradeName" id="filter_TradeName">
                                    <span class="lbl"> <span class="thSysTenant"></span></span>
                                </label>                            
                            </div>
                            <div class="col-md-6">
                                <label>
                                    <input name="form-field-checkboxph" class="ace ace-checkbox-2 complaint_module_filter" type="checkbox" value="Complete_Description" id="filter_Complete_Description">
                                    <span class="lbl"> Complaint Description</span>
                                </label>                            
                            </div>
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                    <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:168px;">&nbsp;&nbsp;Filter by Priority Status&nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-4" style="padding-right:0px;">
                                <label class="label label-lg label-danger arrowed-in-right arrowed">
                                    <input name="form-field-checkbox-pstat2" class="ace" type="checkbox" value="High" id="filter_High">
                                    <span class="lbl"> High Priority</span>
                                </label>
                            </div>
                            <div class="col-md-4" style="padding-right:0px;">
                                <label class="label label-lg label-warning arrowed-in-right arrowed">
                                    <input name="form-field-checkbox-pstat2" class="ace" type="checkbox" value="Medium" id="filter_Medium">
                                    <span class="lbl"> Medium Priority</span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="label label-lg label-yellow arrowed-in-right arrowed">
                                    <input name="form-field-checkbox-pstat2" class="ace" type="checkbox" value="Low" id="filter_Low">
                                    <span class="lbl"> Low Priority</span>
                                </label>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                    <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:189px;">&nbsp;&nbsp;Filter by Complaint Status&nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-4" style="padding-right:0px;">
                                <label style="margin-bottom: 0px;height:22px;padding-left:4px;">
                                    <input name="form-field-checkbox-fbcs" class="ace" type="checkbox" value="Resolved" id="filter_Resolved">
                                    <span class="lbl"> Resolved</span>
                                </label>
                            </div>
                            <div class="col-md-4" style="padding-right:0px;">
                                <label style="margin-bottom: 0px;height:22px;padding-left:4px;">
                                    <input name="form-field-checkbox-fbcs" class="ace" type="checkbox" value="Ongoing" id="filter_Ongoing">
                                    <span class="lbl"> Ongoing</span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label style="margin-bottom:0px;height:22px;padding-left:4px">
                                    <input name="form-field-checkbox-fbcs" class="ace" type="checkbox" value="Pending" id="filter_Pending">
                                    <span class="lbl"> Pending</span>
                                </label>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_chkappdate">
                    <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:90px;">&nbsp;&nbsp;Date Entry&nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <input class="form-control date-picker" type="text" id="dateentrystart2" data-provide="datepicker">
                                </div>                
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <input class="form-control date-picker" type="text" id="dateentryend2" data-provide="datepicker">
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
                            <button class="btn btn-xs btn-info btn-round" onclick="saveComplaintFilter()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">
                            OK
                            </button>
                        </div>
                    </div>'>
                    <i class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;Select Filter here</a>
                </h5>
            </div>
            <div class="pull-right" style="padding-bottom: 5px;padding-left:0px;">
               <h5><a onclick="showfilterofmall()" class="popover-info hide isadmin select-printcomplaint" data-rel="popover" data-placement="bottom" title="Print by" data-content='
                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                    <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:140px;">&nbsp;&nbsp;Filter by <label class="txtSysBuilding">Mall</label>&nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <select class="form-control malloption" id="printbymecomplaint"></select>
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_chkappdate">
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                    <input class="form-control date-picker" type="text" id="pdatefrom" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>">
                                </div>                
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                    <input class="form-control date-picker" type="text" id="pdateto" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>">
                                </div>                
                            </div>
                        </div>
                    </fieldset>

                    <div class="form-group row" style="padding-left:8px;margin-bottom:0px;">
                        <div class="col-md-9" style="padding-right:0px;">
                            <div class="alert alert-info" style="padding-top:10px;padding-bottom:10px;">
                                <button class="close" data-dismiss="alert">
                                    <i class="ace-icon fa fa-times"></i>
                                </button>
                          Select the range of date you want to print.
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-xs btn-success btn-round" onclick="printbydaterange()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">Print</button>
                        </div>
                    </div>'>
                    <i class="glyphicon glyphicon-print bigger-110"></i>&nbsp;&nbsp;Print</a>
                </h5>
            </div>
        </div>
        <div class="row form-group" style="margin-bottom: 0px !important;">
            <div class="parent">
                <table id="simple-table" class="table table-bordered fixTable">
                    <thead>
                        <tr>
                            <th width="10%"><?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenants"; } ?> ID</th>
                            <th width="10%" class="thSysTenant">Trade Name</th>
                            <th width="10%">Complaint Code</th>
                            <th width="13%">Complaint Description</th>
                            <th width="10%">Date & Time Start</th>
                            <th width="10%">Date & Time End</th>
                            <th width="10%">Assigned Person</th>
                            <th width="9%">Complaint Status</th>
                            <th width="8%" style="z-index: 1;">Priority Status</th>
                            <th width="10%" style="z-index: 1;">Options</th>
                        </tr>
                    </thead>
                    <tbody id="tblMainComplaints"></tbody>
                </table>
            </div>
            <table class="tabledash_footer table" style="margin: 0px !important;">
                <thead>
                    <tr>
                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                            <font id="txtMainComplaintsEntries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                            <input id="txtMainComplaintsPageCount" type="hidden">
                            <ul id="ulMainComplaintsPage" class="pagination pull-right"></ul>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- MODAL FOR CONVERTING COMPLAINTS INTO WORK ORDER  -->
<div class="modal fade fade-scale" id="complaintsmodal" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Complaints</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="nakatagodahilhindikayangipagsigawan">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <center style="color: white; font-size: 16px;">Complaints Details</center>
                    </div>
                    <div class="panel-body" style="background-color: #d9edf7;">
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-12 col-lg-12">
                                <div class="row form-group">
                                    <div class="row">
                                        <div class="col-xs-1 col-md-1 col-lg-1"></div>
                                        <div class="col-xs-4 col-md-4 col-lg-4">
                                            <strong>Tenant ID</strong>
                                        </div>
                                        <div class="col-xs-6 col-md-6 col-lg-6">
                                            <label id="complaints_tenantsid"></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-1 col-md-1 col-lg-1"></div>
                                        <div class="col-xs-4 col-md-4 col-lg-4">
                                            <strong>Complaint Code</strong>
                                        </div>
                                        <div class="col-xs-6 col-md-6 col-lg-6">
                                            <label id="complaints_ccode"></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-1 col-md-1 col-lg-1"></div>
                                        <div class="col-xs-4 col-md-4 col-lg-4">
                                            <strong>Complaint Description</strong>
                                        </div>
                                        <div class="col-xs-6 col-md-6 col-lg-6">
                                            <label id="complaints_cdescription"></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-1 col-md-1 col-lg-1"></div>
                                        <div class="col-xs-4 col-md-4 col-lg-4">
                                            <strong>Customer Name</strong>
                                        </div>
                                        <div class="col-xs-6 col-md-6 col-lg-6">
                                            <label id="complaints_ccname"></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-1 col-md-1 col-lg-1"></div>
                                        <div class="col-xs-4 col-md-4 col-lg-4">
                                            <strong>Unit</strong>
                                        </div>
                                        <div class="col-xs-6 col-md-6 col-lg-6">
                                            <label id="complaints_unit"></label>
                                        </div>
                                    </div>
                                    <!-- <div class="row">
                                        <div class="col-xs-1 col-md-1 col-lg-1"></div>
                                        <div class="col-xs-4 col-md-4 col-lg-4">
                                            <strong>Time Started</strong>
                                        </div>
                                        <div class="col-xs-6 col-md-6 col-lg-6">
                                            <label id="complaints_timestarted"></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-1 col-md-1 col-lg-1"></div>
                                        <div class="col-xs-4 col-md-4 col-lg-4">
                                            <strong>Time Resolved</strong>
                                        </div>
                                        <div class="col-xs-6 col-md-6 col-lg-6">
                                            <label id="complaints_timeresolved"></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-1 col-md-1 col-lg-1"></div>
                                        <div class="col-xs-4 col-md-4 col-lg-4">
                                            <strong>Duration</strong>
                                        </div>
                                        <div class="col-xs-6 col-md-6 col-lg-6">
                                            <label id="complaints_duration"></label>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="row form-group">
                            <div class="col-xs-1 col-md-1 col-lg-1"></div>
                            <div class="col-xs-3 col-md-3 col-lg-3">
                                <label>Set Date</label> 
                            </div>
                            <div class="col-xs-6 col-md-6 col-lg-6">
                                <div class="input-group">
                                    <input type="text" data-provide="datepicker" class="form-control" id="complaints_newsched"  value="<?php echo date('m/d/Y') ?>">  
                                    <label class="input-group-addon"><i class="fa fa-calendar"></i></label>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-1 col-md-1 col-lg-1"></div>
                            <div class="col-xs-3 col-md-3 col-lg-3">
                                <label> Set Time</label>
                            </div>
                            <div class="col-xs-6 col-md-6 col-lg-6">
                                <div class="input-group">
                                <input type="time" class="form-control" id="complaints_newtime" value="<?php echo date('H:i') ?>">
                                    <label class="input-group-addon"><i class="fa fa-clock-o"></i></label>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-1 col-md-1 col-lg-1"></div>
                            <div class="col-xs-3 col-md-3 col-lg-3">
                                <label>Assigned Department</label>
                            </div>
                            <div class="col-xs-6 col-md-6 col-lg-6">
                                <select id="complaints_newperson" class="form-control">
                                 <?php 
                                    echo "<option value''>-- Select Department --</option>";
                                    $sql = "SELECT groupid, groupname FROM tblref_groupaccess";
                                    $result = mysql_query($sql, $connection);
                                    while( $row = mysql_fetch_array ($result)){
                                        echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
                                    }
                                ?>
                                </select>   
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-1 col-md-1 col-lg-1"></div>
                            <div class="col-xs-3 col-md-3 col-lg-3">
                                <label>Details</label>
                            </div>
                            <div class="col-xs-6 col-md-6 col-lg-6">
                                <textarea id="complaints_details" class="form-control" style="resize: none;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-primary btn-round" onclick="savecomplaintsmodal()"><i class="fa fa-check"></i>&nbsp;Save</button>
            </div>
        </div>
    </div>
</div>
<!-- MULTIPLE PRINTING OF COMPLAINTS BASED ON DATE RANGE CHOSEN -->
<div id="mpocbodrc" style="display: none;">
    <center>
        <table cellspacing="0" style="padding: 5px; width: 95%">
            <tr><td colspan="2" align="center"><div style="width: 100%; text-align: left;">
                <table style="width: 100%;" cellspacing="0" cellpadding="0">
                    <tbody id="template"></tbody>
                </table>
            </div></td></tr>
            <tr><td align="right"><p style="font-size: 15px; margin-top: 5px;">From:&nbsp;&nbsp;<label id="dateFrommpocbodrcprint"></label>&nbsp;&nbsp;To&nbsp;&nbsp;<label id="dateTompocbodrcprint"></label></p></td></tr>
            <tr><td colspan="2"><center><p style="font-size: 22px; font-weight: bold;background-color: #666;color: white;width: 100%;">Complaints</p></center></td></tr>
            <tr>
                <td colspan="2">
                    <center>
                        <table style="width: 100%;"> 
                            <thead>
                                <tr>    
                                    <td>Tenant ID</td>
                                    <td class="thSysTenant">Trade Name</td>
                                    <td>Date Entry</td>
                                    <td>Complaint Code</td>
                                    <td>Start Date</td>
                                    <td>End Date</td>
                                    <td>Resolved By</td>
                                    <td>Complaint Status</td>
                                    <td>User Name</td>
                                </tr>
                                <tr><td colspan="9"><hr style="margin-top: -5px;"></td></tr>
                            </thead>
                        <tbody id="tblmpocbodrc"></tbody>
                        </table>
                    </center>
                </td>
            </tr>
        </table>
    </center>
</div>
<!-- SINGLE PRINT OF COMPLAINT -->
<div id="printcomplaint" style="display: none;">
    <table style="width: 100%;" cellspacing="0" cellpadding="0">
        <tbody id="template4"></tbody>
    </table>
    <center style="font-size: 32px;font-weight: bold;border-bottom: 3px solid black;width: 100%;">Tenant Complaint Form</center>
    <center style="width: 100%;background-color: #666;color: white;margin-top: 10px;">Tenant Information</center>
    <table style="width: 100%;border: 1px solid;">
        <tbody>
            <tr>
                <td style="width: 50%;"><b>Trade Name: </b><label id="printcomplainttradename"></label></td>
                <td style="border-left: 1px solid;width: 50%;"><b>Tenant ID: </b><label id="printcomplainttenantid"></label></td>
            </tr>
            <tr>
                <td style="width: 50%;border-top: 1px solid;"><b><label class="txtSysBuilding">Mall</label> Name: </b><label id="printcomplaintmallname"></label></td>
                <td style="border-left: 1px solid;width: 50%;border-top: 1px solid;"><b>Wing Name: </b><label id="printcomplaintwingname"></label></td>
            </tr>
            <tr>
                <td style="width: 50%;border-top: 1px solid;"><b>Floor Name: </b><label id="printcomplaintfloorname"></label></td>
                <td style="border-left: 1px solid;width: 50%;border-top: 1px solid;"><b>Unit Name: </b><label id="printcomplaintunitname"></label></td>
            </tr>
        </tbody>
    </table>

    <center style="width: 100%;background-color: #666;color: white;margin-top: 10px;">Complaint Information</center>
    <table style="width: 100%;border: 1px solid;">
        <tbody>
            <tr>
                <td style="width: 50%;"><b>Complaint Date: </b><label id="printcomplaintcomplaintdate"></label></td>
                <td style="border-left: 1px solid;width: 50%;"><b>Complaint Taken By: </b><label id="printcomplaintusername"></label></td>
            </tr>
            <tr>
                <td colspan="2" style="width: 50%;border-top: 1px solid;"><b>Complaint Code: </b><label id="printcomplaintcomplaintcode"</label></td>
            </tr>
            <tr>
                <td colspan="2" style="width: 50%;border-top: 1px solid;height: 100px;vertical-align: top;"><b>First Response Corrective Action: </b><label></label></td>
            </tr>
            <tr>
                <td colspan="2" style="width: 50%;border-top: 1px solid;height: 100px;vertical-align: top;"><b>Suspected Cause: </b><label id="printcomplaintdescription"></label></td>
            </tr>
            <tr>
                <td colspan="2" style="width: 50%;border-top: 1px solid;height: 40px;vertical-align: top;"><b>Corrective Action Person(s): </b><label id="printcomplaintassignedperson"></label></td>
            </tr>
            <tr>
                <td colspan="2" style="width: 50%;border-top: 1px solid;height: 40px;vertical-align: top;"><b>Corrective Action Follow-up: </b><label></label></td>
            </tr>
            <tr>
                <td colspan="2" style="width: 50%;border-top: 1px solid;height: 100px;vertical-align: top;"><b>What steps should be considered to avoid a repeat of the problem: </b><label></label></td>
            </tr>
        </tbody>
    </table>

    <table style="margin-top: 30px;">
        <tr>
            <td>
                <label style="border-top: 1px solid;">Name of person completing this form</label>
            </td>
            <td align="right">
                <label style="border-top: 1px solid;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
            </td>
        </tr>
    </table>
</div>
<?php include("script.php"); ?>