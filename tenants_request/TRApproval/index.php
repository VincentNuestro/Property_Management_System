<div class="page-header">
    <div class="row form-group" style="margin-bottom: 0px;padding-top:10px;background-color: #edf4f8;padding-bottom: 10px;">
        <div class="col-md-6">
            <h1 style="font-weight: bold;">TENANT'S REQUEST FOR APPROVAL LIST</h1>
        </div>
        <div class="col-md-6">
            <span class="label label-xlg label-warning arrowed-in-right arrowed pull-right">Pending</span>
            <span class="label label-xlg label-danger arrowed-in-right arrowed pull-right" style="margin-right: 5px;">Disapproved</span>
            <span class="label label-xlg label-success arrowed-in-right arrowed pull-right" style="margin-right: 5px;">Approved</span>
        </div>
    </div>
</div>

<div class="row">
    <div class="row form-group" style="margin-bottom: 0px;">
        <div class="col-md-2"  style="padding-bottom: 5px;visibility: hidden;">
            <span class="input-icon" style="width: 100%;">
              <input type="text" class="form-control" id="txtsearchapptr" title="Search" placeholder="Search">
              <i class="ace-icon fa fa-search nav-search-icon"></i>
            </span>
        </div>
        <div class="col-md-3" style="padding-bottom: 5px;padding-left:0px;visibility: hidden;">
            <h5><a onclick="loadTenantRequestFilter('TenantRequest')" id="LINK_TenantRequest_filter" class="popover-info" data-rel="popover" data-placement="bottom" title="Filter by" data-content='
            <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:95px;">&nbsp;&nbsp;Search by&nbsp;&nbsp;</legend>
                <div class="form-group row" style="margin:0px;">
                    <div class="col-md-4">
                        <label>
                            <input name="form-field-chkapptr" class="ace ace-checkbox-2 complaint_module_filter" type="checkbox" value="APP_NO" id="filter_APP_NO">
                            <span class="lbl"> Application No</span>
                        </label>
                    </div>
                    <div class="col-md-4">
                        <label>
                            <input name="form-field-chkapptr" class="ace ace-checkbox-2 complaint_module_filter" type="checkbox" value="FULL_NAME" id="filter_FULL_NAME">
                            <span class="lbl"> <span class="thSysTenant"></span></span>
                        </label>                               
                    </div>
                    <div class="col-md-4">
                        <label>
                            <input name="form-field-chkapptr" class="ace ace-checkbox-2 complaint_module_filter" type="checkbox" value="UNIT" id="filter_UNIT">
                            <span class="lbl"> Unit</span>
                        </label>                            
                    </div>
                    <div class="col-md-4">
                        <label>
                            <input name="form-field-chkapptr" class="ace ace-checkbox-2 complaint_module_filter" type="checkbox" value="SCOPE" id="filter_SCOPE">
                            <span class="lbl"> Scope</span>
                        </label>                            
                    </div>
                    <div class="col-md-4">
                        <label>
                            <input name="form-field-chkapptr" class="ace ace-checkbox-2 complaint_module_filter" type="checkbox" value="DETAILS" id="filter_DETAILS">
                            <span class="lbl"> Details</span>
                        </label>                            
                    </div>
                </div>
                <div class="row form-group" style="margin-top: 10px;margin-bottom: -0px;">
                    <div class="col-md-12">
                        <div class="col-md-4" style="margin-top: 15px;">Approval Level :</div>
                        <div class="col-md-6" style="margin-left: -50px;"><select class="form-control" id="appstatlevel"></select></div>
                    </div>
                </div>
            </fieldset>

            <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:130px;">&nbsp;&nbsp;Filter by Status&nbsp;&nbsp;</legend>
                <div class="form-group row" style="margin:0px;">
                    <div class="col-md-2"></div>
                    <div class="col-md-4">
                        <label class="label label-lg label-success arrowed-in-right arrowed">
                            <input name="form-field-applevelstat" class="ace" type="checkbox" value="Approved" id="filter_Approved">
                            <span class="lbl"> Approved</span>
                        </label>
                    </div>
                    <div class="col-md-5">
                        <label class="label label-lg label-danger arrowed-in-right arrowed">
                            <input name="form-field-applevelstat" class="ace" type="checkbox" value="Disapproved" id="filter_Disapproved">
                            <span class="lbl"> Disapproved</span>
                        </label>
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </fieldset>

            <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_chkappdate">
                <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:130px;">&nbsp;&nbsp;Application Date&nbsp;&nbsp;</legend>
                <div class="form-group row" style="margin:0px;">
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar bigger-110"></i>
                            </span>
                            <input class="form-control date-picker" type="text" name="" id="appdatefrom" data-provide="datepicker">
                        </div>                
                    </div>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar bigger-110"></i>
                            </span>
                            <input class="form-control date-picker" type="text" name="" id="appdateto" data-provide="datepicker">
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
                    <button class="btn btn-xs btn-info btn-round" onclick="saveTenantRequestFilter()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">
                        OK
                    </button>
                </div>
            </div>'>
            <i class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;Select Filter here</a></h5>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-6" style="display: none">
            <div class="pull-right">
               <h5><a onclick="showfilterofmalltr()" class="popover-info hide isadmin select-printworkorder" data-rel="popover" data-placement="bottom" title="Print by" data-content='
                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:140px;">&nbsp;&nbsp;Filter by <label class="txtSysBuilding">Mall</label>&nbsp;&nbsp;</legend>
                            <div class="form-group row" style="margin:0px;">
                                <select class="form-control" id="printbymeTR"></select>
                            </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_chkappdate">
                      <div class="form-group row" style="margin:0px;">
                        
                        <div class="col-md-6">
                          <div class="input-group">
                            <span class="input-group-addon">
                              <i class="fa fa-calendar bigger-110"></i>
                            </span>
                            <input class="form-control date-picker" type="text" id="printapptrfrom" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>">
                          </div>                
                        </div>
                        <div class="col-md-6">
                          <div class="input-group">
                            <span class="input-group-addon">
                              <i class="fa fa-calendar bigger-110"></i>
                            </span>
                            <input class="form-control date-picker" type="text" id="printapptrto" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>">
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
                            <button class="btn btn-xs btn-success btn-round" onclick="printbydaterangeTR()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">
                            Print
                        </button>
                    </div>'>
                <i class="glyphicon glyphicon-print bigger-110"></i>&nbsp;&nbsp;Print</a></h5>
            </div>
<!--             <button class="btn btn-danger btn-sm pull-right isadmin hide select-disapprovquest btn-round" style="margin-right: 10px;" onclick="disapprovethis();">Disapprove Selected</button>
            <button class="btn btn-success btn-sm pull-right isadmin hide select-approverequest btn-round" style="margin-right: 10px;" onclick="approvethis();">Approve Selected</button> -->

<!--             <button class="btn btn-info btn-sm pull-right isadmin hide select-newrequest btn-round" style="margin-right: 10px;" onclick="createrequestmodal();">New Request</button> -->

            <!-- Michael Capistrano - 09-11-2019 -->
           <!--  <button class="btn btn-info btn-sm pull-right isadmin hide select-newrequest btn-round" style="margin-right: 10px;" onclick="CreateTenantRequest();">Tenant Request</button>   --> 
            <!-- Michael Capistrano - 09-11-2019  -->
                                    
        </div>
    </div>
    <div class="row form-group" style="margin-bottom: 0px !important;">
        <div class="col-md-12">
            <div class="parent">
                <table id="simple-table" class="table table-bordered fixTable">
                    <thead>
                        <tr>
                            <th width='1%'>#</th>
                            <th width='9%'>Request Date</th>
                            <th width='15%'>Tenant Name</th>
                            <th width='12%'>Unit</th>
                            <th width='12%'>Category</th>
                            <th width='12%'>Tag</th>
                            <th width="14%">Requested By</th>
                            <th width='8%' style="z-index: 4">Approval Status</th> 
                        </tr>
                    </thead>
                    <tbody id="tblrequestlist"></tbody>
                </table>
            </div>
            <table class="tabledash_footer table" style="margin: 0px !important;">
                <thead>
                    <tr>
                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                            <font id="apptrentries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                            <input id="apptrpagecount" type="hidden">
                            <ul id="ulapptrpage" class="pagination pull-right"></ul>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>


<div class="modal fade fade-scale" id="CreateNewTenantRequest" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="closeTenantRequest();">&times;</button>
                <h4 class="modal-title" style="font-family: Roboto;font-size: 18px;">Tenant Request</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row form-group">

                            <!-- Buyer Information -->
                            <div class="col-md-12">
                                <div class="widget-container-col ui-sortable" >
                                    <div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
                                        <div class="widget-header">
                                             <input type="hidden" id="txttenantrequet_id" name="">
                                            <h4 class="widget-title txtPanelHeader">TENANT DETAILS</h4>
                                            <div class="widget-toolbar no-border">
                                                <a href="#"  class="clicktoshowall" onclick="showaccord('wdgettenant')">
                                                    <i class="ace-icon fa fa-chevron-up" id="wdgettenant_icon"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="widget-body" id="wdgettenant">
                                            <div class="widget-main well">
                                                <div class="row form-group">
                                                    <div class="col-md-6">
                                                        <div class="col-md-4">
                                                            Tenant Name
                                                        </div>
                                                        <div class="col-md-8">
                                                            <select class="form-control txtTRrequiredekim" id="txtTenantRequest" onchange="showTenantRequestInfo(this.value);"></select>
                                                        </div>
                                                    </div>

                                                   <div class="col-md-6">
                                                        <div class="col-md-4">
                                                             Request Date
                                                        </div>
                                                        <div class="col-md-8">
                                                             <input type="text" class="date-picker form-control txtTRrequiredekim" id="ApplicationDate" value='<?php echo date('m/d/Y'); ?>' disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-6">
                                                        <div class="col-md-4">
                                                            Category
                                                        </div>
                                                        <div class="col-md-8">
                                                             <select class="form-control txtTRrequiredekim" id="RequestCat" onchange="getTenantCode();"></select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6"> 
                                                        <div class="col-md-4">
                                                            Tags
                                                        </div>
                                                        <div class="col-md-8">
                                                             <select class="form-control txtTRrequiredekim showTenantCategoryTagInfo" id="RequestTag"></select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-6">
                                                        <div class="ace-settings-item" style="margin-left: 15px">
                                                            <input type="checkbox" class="ace ace-checkbox-2" id="chckboxnotify">
                                                            <label class="lbl" for="chckboxnotify"> Notify when visitors arrived</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <div class="col-md-6">
                                                        <div class="col-md-8">
                                                            <input type="hidden" class="form-control txtTRrequiredekim" readonly id="MallID">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="col-md-8">
                                                            <input type="hidden" class="form-control" readonly id="UnitID">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="col-md-8">
                                                            <input type="hidden" class="form-control txtTRrequiredekim" readonly id="TenantID">
                                                        </div>
                                                    </div>
                                               </div>

                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <h4 class="green" style="border-bottom: 1px solid #ccc;">Remarks</h4>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="col-md-12">
                                                            <textarea class="form-control txtTRrequiredekim" id="Remarks" style="height: 90px;resize: none;"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="widget-container-col ui-sortable">
                                    <div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
                                        <div class="widget-header">
                                            <h4 class="widget-title">Visitors</h4>
                                            <div class="widget-toolbar no-border">
                                                <a href="#" class="clicktoshowall" onclick="showaccord('wdgetvisitors')">
                                                    <i class="ace-icon fa fa-chevron-down" id="wdgetvisitors_icon"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="widget-body" style="display: none;" id="wdgetvisitors">
                                            <div class="widget-main well">
                                                <div class="row form-group" style="margin-bottom: 10px !important;">
                                                    <div class="col-md-6">
                                                        <div class="col-md-4">
                                                            First Name
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class=" form-control" id="txttentfname" >
                                                        </div>
                                                    </div>

                                                   <div class="col-md-6">
                                                        <div class="col-md-4">
                                                             Last Name
                                                        </div>
                                                        <div class="col-md-8">
                                                             <input type="text" class=" form-control" id="txttentlname" >
                                                        </div>
                                                   </div>
                                               </div>
                                               <div class="row form-group" style="margin-bottom: 10px !important;">
                                                    <div class="col-md-6">
                                                        <div class="col-md-4">
                                                            ID Presented
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class=" form-control" id="txttentidpres" >
                                                        </div>
                                                    </div>

                                                   <div class="col-md-6">
                                                        <div class="col-md-4">
                                                             Image
                                                        </div>
                                                        <div class="col-md-8" id="">
                                                            <input type="hidden" id="txtvisitimagename" name="">
                                                            <form id="frmuploadvisit" method="POST" action="" enctype="multipart/form-data" >
                                                                <input type="file" id="" name="files" class="id-input-file" onchange="checkfiletype(this.value, this.id, 'Discount');">
                                                                <input type="submit" style="display: none;" id="btnuploadvisitimage" name="">
                                                            </form>
                                                        </div>
                                                   </div>
                                               </div>
                                               <div class="row form-group" style="margin-bottom: 10px !important;">
                                                    <div class="col-md-6">
                                                        <div class="col-md-4">
                                                            Check-in
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class=" form-control timepickeronly" id="txttentlogin" >
                                                        </div>
                                                    </div>

                                                   <div class="col-md-6">
                                                        <div class="col-md-4">
                                                             Check-out
                                                        </div>
                                                        <div class="col-md-8">
                                                             <input type="text" class=" form-control timepickeronly" id="txttentlogout" >
                                                        </div>
                                                   </div>
                                               </div>
                                               <div class="row form-group" style="margin-bottom: 10px !important;">
                                                    <div class="col-md-6">
                                                        <button class="btn btn-success btn-round btn-sm" onclick="addthisvistor()"><i class="ace-icon glyphicon glyphicon-plus"></i>&nbsp;ADD</button>
                                                    </div>
                                               </div>
                                               <div class="row form-group" style="margin-bottom: 0px !important;">
                                                    <div class="col-md-12">
                                                        <div class="parent" style="height: 30vh">
                                                            <table class="table table-bordered fixTable">
                                                                <thead>
                                                                    <tr>
                                                                        <th width='5%'>#</th>
                                                                        <th width='20%'>Last Name</th>
                                                                        <th width='20%'>First Name</th>
                                                                        <th width='15%'>ID presented</th>
                                                                        <th width='15%'>Image</th>
                                                                        <th width='10%'>Check-in</th>
                                                                        <th width='10%'>Check-out</th>
                                                                        <th width='5%'></th> 
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="tbltentvistorslist"></tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="widget-container-col ui-sortable">
                                    <div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
                                        <div class="widget-header">
                                            <h4 class="widget-title">Items / Equipments</h4>
                                            <div class="widget-toolbar no-border">
                                                <a href="#"  class="clicktoshowall" onclick="showaccord('wdgetitems')" >
                                                    <i class="ace-icon fa fa-chevron-down" id="wdgetitems_icon"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="widget-body" style="display: none;" id="wdgetitems">
                                            <div class="widget-main well">
                                                <div class="row form-group" style="margin-bottom: 10px !important;">
                                                    <div class="col-md-6">
                                                        <div class="col-md-4">
                                                            Item Name
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class=" form-control" id="txttentitemname" >
                                                        </div>
                                                    </div>

                                                   <div class="col-md-3">
                                                        <div class="col-md-4">
                                                             Qty.
                                                        </div>
                                                        <div class="col-md-8">
                                                             <input type="text" style="" class=" form-control" id="txttentqty" >
                                                        </div>
                                                   </div>
                                                   <div class="col-md-3">
                                                        <div class="col-md-4">
                                                            Unit
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class=" form-control" id="txttentunit" >
                                                        </div>
                                                    </div>
                                               </div>
                                               <div class="row form-group" style="margin-bottom: 10px !important;">
                                                   <div class="col-md-6">
                                                        <div class="col-md-4">
                                                             Notes
                                                        </div>
                                                        <div class="col-md-8">
                                                             <textarea class="form-control" id="txttentnotes" style="height: 50px;resize: none;"></textarea>
                                                        </div>
                                                   </div>
                                               </div>
                                               <div class="row form-group" style="margin-bottom: 10px !important;">
                                                    <div class="col-md-6">
                                                        <button class="btn btn-success btn-round btn-sm" onclick="addthisitem()"><i class="ace-icon glyphicon glyphicon-plus"></i>&nbsp;ADD</button>
                                                    </div>
                                               </div>
                                               <div class="row form-group" style="margin-bottom: 0px !important;">
                                                    <div class="col-md-12">
                                                        <div class="parent" style="height: 30vh">
                                                            <table class="table table-bordered fixTable">
                                                                <thead>
                                                                    <tr>
                                                                        <th width='5%'>#</th>
                                                                        <th width='35%'>Item Name</th>
                                                                        <th width='15%'>Quantity</th>
                                                                        <th width='15%'>Unit</th>
                                                                        <th width='25%'>Notes</th>
                                                                        <th width='5%'></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="tbltentitemslist"></tbody>
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
            <div class="modal-footer">
                <button class="btn btn-success btn-round btn-sm" onclick="openmodalremarks('Approved')"><i class="fa fa-check"></i>&nbsp;Approved</button>
                <button class="btn btn-danger btn-round btn-sm" onclick="openmodalremarks('Disapproved')"><i class="fa fa-check"></i>&nbsp;Disapproved</button>
            </div>
        </div>
    </div> 
</div>






<div class="modal fade fade-scale" id="modalapproverremarks" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="closemodalremarks();">&times;</button>
                <h4 class="modal-title" style="font-family: Roboto;font-size: 18px;">Remarks(Optional)</h4>
            </div>

            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="col-md-4">
                             <b id="lblapprovedtype"></b>
                        </div>
                        <input type="hidden" id="txttypeapproved" name="">
                        <div class="col-md-12" style="margin-top: 10px">
                            <textarea class="form-control" id="txtapproveremarks" style="height: 90px;resize: none;"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-round btn-sm" onclick="saveapprovetrequest()"><i class="fa fa-check"></i>&nbsp;Save</button>
            </div>
        </div>
    </div> 
</div>
<!-- KEVINL 9182019 end -->

<div class="modal fade fade-scale" id="modalviewimagesx" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="closeimagevisitor();">&times;</button>
                <h4 class="modal-title" style="font-family: Roboto;font-size: 18px;">View Image</h4>
            </div>
            <div class='modal-body'>
                <div class="row">
                    <div class="col-md-12">
                        <span class="profile-picture">
                        <img id="txtimageviewx" class="img-responsive" alt="" src="">
                    </span>
                    </div>
                    

                    
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div> 
</div>



<div id="applalall" style="display: none;">
    <table style="width: 100%;" cellspacing="0" cellpadding="0">
        <tbody id="template"></tbody>
    </table>
    <p style="font-size: 15px; text-align: right;">From:&nbsp;&nbsp;<label id="dateFromwoprint"></label>&nbsp;&nbsp;To&nbsp;&nbsp;<label id="dateTowoprint"></label></p>
    <center style="font-size: 22px;font-weight: bold;background-color: #666;color: white;width: 100%;margin-top: -15px;">Tenant's Request List</center>
    <table style="width: 100%;">
        <thead>
            <tr>
                <td>Date</td>
                <td>Application No.</td>
                <td class="thSysTenant">Full Name</td>
                <td>Unit</td>
                <td>Scope</td>
                <td>Approval Status</td>
                <td>Status</td>
            </tr>
            <td colspan="8"><hr></td>
        </thead>
        <tbody id="tblmpowobodrc"></tbody>
    </table>
</div>

<div id="printapplalallbyrequest" style="display: none;">
    <table style="width: 100%;" cellspacing="0" cellpadding="0">
        <tbody id="template2"></tbody>
    </table>
    <center style="font-size: 32px;font-weight: bold;border-bottom: 3px solid black;width: 100%;">Tenant Request Form</center>
    <center style="width: 100%;background-color: #666;color: white;margin-top: 10px;">Tenant Information</center>
    <table style="width: 100%;border: 1px solid;">
        <tbody>
            <tr>
                <td style="width: 50%;"><b>Application No.: </b><label id="txtapptrappno"></label></td>
                <td style="border-left: 1px solid;width: 50%;"><b>Application Date: </b><label id="txtapptrappdate"></label></td>
            </tr>
            <tr>
                <td colspan="2" style="border-left: 1px solid;width: 50%;border-top: 1px solid;"><b>Tenant Name: </b><label id="txtapptrtenantname"></label></td>
            </tr>
            <tr>
                <td style="width: 50%;border-top: 1px solid;"><b>Tenant ID: </b><label id="txtapptrtenantid"></label></td>
                <td style="border-left: 1px solid;width: 50%;border-top: 1px solid;"><b>Email Address: </b><label id="txtapptremail"></label></td>
            </tr>
            <tr>
                <td style="width: 50%;border-top: 1px solid;"><b>Mobile Number: </b><label id="txtapptrmobile"></label></td>
                <td style="border-left: 1px solid;width: 50%;border-top: 1px solid;"><b>Telephone Number: </b><label id="txtapptrtelephone"></label></td>
            </tr>
        </tbody>
    </table>

     <center style="width: 100%;background-color: #666;color: white;margin-top: 10px;">Unit Information</center>
    <table style="width: 100%;border: 1px solid;">
        <tbody>
            <tr>
                <td style="width: 50%;"><b><label class="txtSysBuilding">Building</label> Name: </b><label id="txtapptrbuilding"></label></td>
                <td style="border-left: 1px solid;width: 50%;"><b>Wing Name: </b><label id="txtapptrwing"></label></td>
            </tr>
            <tr>
                <td style="width: 50%;border-top: 1px solid;"><b>Floor Name: </b><label id="txtapptrfloor"></label></td>
                <td style="border-left: 1px solid;width: 50%;border-top: 1px solid;"><b>Unit Name: </b><label id="txtapptrunit"></label></td>
            </tr>   
        </tbody>
    </table>

    <center style="width: 100%;background-color: #666;color: white;margin-top: 10px;">Scope of Work</center>
    <table style="width: 100%;border: 1px solid;">
        <tbody>
            <tr>   
                <td><label><input type="radio" class="machecheckankapagpinirint" value="Addition">Addition</label></td>
                <td><label><input type="radio" class="machecheckankapagpinirint" value="Repair">Repair</label></td>
                <td><label><input type="radio" class="machecheckankapagpinirint" value="Renovation">Renovation</label></td>
                <td><label><input type="radio" class="machecheckankapagpinirint" value="Demolition">Demolition</label></td>
                <td><label><input type="radio" class="machecheckankapagpinirint" value="Others">Others</label></td>
            </tr>
            <tr>
                <td colspan="5" style="border-top: 1px solid;height: 500px;vertical-align: top;"><b>Description: </b><label id="txtapptrdetails"></label></td>
            </tr>
        </tbody>
    </table>
</div>

<?php  
    include("script.php");
?>