<link rel="stylesheet" type="text/css" href="global_events/calendar.css">
<div class="modal fade fade-scale" id="mdlAddevents" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="width: 80%;">
        <div class="modal-content">
            <div id="preloaddirectenantform"></div>
            <div class="modal-header">
                <button type="button" class="close" onclick="fncCloseevents()">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;"><?php if($_REQUEST['url'] == 'inquiry'){ echo 'Inquiry'; }else if($_REQUEST['url'] == 'leasingapplication'){ echo 'Leasing Application'; }else if($_REQUEST['url'] == 'reservation'){ echo 'Reservation'; }else{ echo 'Tenant'; }?></h4>
            </div>
            <div class="modal-body">
                <div class="panel-heading">
                    <h4>EVENT INFORMATION</h4>
                </div>
                <div class="panel-body">
                    <div class="container-fluid"> 
                        <div class="modified-jumbotron2 col-md-12">
                            <div class="row" id="headerevents" style="margin-top: 10px;display: none">
                                <div class="col-md-8">
                                    <h4>Event Series No.: <strong><span id="lblSNo"></span></strong></h4>
                                </div>

                                <div class="col-md-4">
                                    <h4>Date Created: <strong><span id="lblDateCreated"></span></strong></h4>
                                    <h4>Created By: <strong><span id="lblCreatedBy"></span></strong></h4>
                                </div>
                            </div>
                            <input type="hidden" id="txtInqID">
                        </div>

                        <div class="col-md-12" style="margin-top: 10px;">
                            
                                <div id="eventdetails">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-horizontal">
                                                <div class="form-group requiredx">
                                                    <label class="control-label">Name of Event &nbsp;&nbsp;<span class=" red">*</span></label>
                                                    <input type="text" class="form-control edisabled" id="txteventname">
                                                </div>
                                            </div>                                        
                                        </div>
                                        <div class="col-md-5 col-md-offset-1">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-horizontal requiredx">
                                                        <label class="control-label">Start Date &nbsp;&nbsp;<span class=" red">*</span></label>
                                                        <input type="text" class="form-control date-picker" id="txteventstartdate" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-horizontal requiredx">
                                                        <label class="control-label">End Date &nbsp;&nbsp;<span class=" red">*</span></label>
                                                        <input type="text" class="form-control date-picker" id="txteventenddate" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2" style="padding-left: 0px;">
                                            <div class="form-horizontal requiredx">
                                                <label class="control-label">Confirmation Date &nbsp;&nbsp;<span class=" red">*</span></label>
                                                <input type="text" class="form-control date-picker" id="txteventconfirmdate" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 ">
                                            <div class="row">
                                                <h3 style="cursor: pointer;" ><span class="fa fa-plus-circle blue" onclick="addDaytoDay()"></span> <b>Day-to-day Activity</b></h3>
                                                <div class="modified-jumbotron">
                                                    <div class="container-fluid">
                                                        <div id="activityBody">
                                                            <div class="form-horizontal info-form starting" id="dtod-1">
                                                                <div class="form-group">
                                                                    <div class="col-md-2 requiredx">
                                                                        <label class="control-label">Date Duration&nbsp;<span class=" red">*</span></label>
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-calendar bigger-110"></i>
                                                                            </span>

                                                                            <input class="form-control actdaterange" type="text" name="date-range-picker"    />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-5 requiredx">
                                                                        <label class="control-label">Title of Activity &nbsp;<span class=" red">*</span></label>
                                                                        <input type="text" class="form-control  actTitle">
                                                                    </div>

                                                                    <div class="col-md-2 requiredx">
                                                                        <label class="control-label">Start Time &nbsp;<span class=" red">*</span></label>
                                                                        <input type="text" class="form-control  timepickeronly actStart" onkeydown="return false">
                                                                    </div>

                                                                    <div class="col-md-2 requiredx">
                                                                        <label class="control-label">End Time &nbsp;<span class=" red">*</span></label>
                                                                        <input type="text" class="form-control  timepickeronly actEnd" onkeydown="return false">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="space-10"></div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-horizontal">
                                                <div class="form-group required">
                                                    <label class="control-label">Organizer &nbsp;&nbsp;<span class=" red">*</span></label>
                                                    <select style="width: 90%" class="form-control searchy_select edisabled" id="txteventorganizer">
                                                        <option value="">-- Select Organizer --</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-horizontal">
                                                <div class="form-group required">
                                                    <label class="control-label">Revenue Type &nbsp;&nbsp;<span class=" red">*</span></label>
                                                    <select style="width: 90%" class="form-control searchy_select edisabled" id="txteventrevtype">
                                                        <option value="">-- Select Revenue Type --</option>
                                                        <option value="Paying">Paying</option>
                                                        <option value="Sponsorship">Sponsorship</option>
                                                        <option value="Ex-Deal">Ex-Deal</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="space-10"></div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="panel panel-primary custom-panel-1">
                                            <div class="panel-heading">
                                                <a data-toggle="collapse" href="#collapse3" class="collapsebtn block collapsed">Event Requirements <span class="fa fa-chevron-down pull-right collapse-icon"></span></a>
                                            </div>

                                            <div class="panel-collapse collapse" id="collapse3">
                                                <div class="panel-body" style="height: 400px; padding: 0px !important;">
                                                    <div class="col-md-12">
                                                        <div>
                                                            <div class="row">
                                                                <div class="pull-left"><h3 id="">Grand Total :  <span id="txteoveralltotal" style="color:red">0.00</span></h3></div>
                                                            </div>
                                                        </div>
                                                        <div class="row"> 
                                                            <ul class="nav nav-custom nav-pills eventNavs">
                                                                <li style="cursor: pointer;" class="eventNavsli active"><a name="facility-body">Operational / Facilities</a></li>
                                                                <li style="cursor: pointer;" class="eventNavsli"><a onclick='getefsound()' name="sound-body">Sound System Personnel</a></li>
                                                                <li style="cursor: pointer;" class="eventNavsli"><a onclick="getefmanpower()" name="manpower-body">Manpower</a></li>
                                                                <li style="cursor: pointer;" class="eventNavsli"><a onclick="geteforganizer()" name="organizer-body">Organizer Materials</a></li>
                                                                <li style="cursor: pointer;" class="eventNavsli"><a onclick="getefpromotional()" name="promotional-body">Promotional Paraphernalia</a></li>
                                                                <li style="cursor: pointer;" class="eventNavsli"><a name="requirements-body">Attachments</a></li>
                                                            </ul>

                                                            <div class="panel eventorder" id="facility-body">
                                                                <div class="panel-body">
                                                                    <div class="form-horizontal" id="forFacilities">
                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <div class="col-md-4 required"> 
                                                                                    <div class="form-group required">
                                                                                        <label class="control-label">Facility &nbsp;&nbsp;<span class=" red">*</span></label>
                                                                                        <select style="width: 100%" class="form-control searchy_select" onchange ="selectamountfacilities(this.value)" id="txtfacility">
                                                                                            <option value="">-- Select Facility --</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>                                                                           
                                                                                <div class="col-md-1 required"> 
                                                                                    <label class="control-label">Price &nbsp;<span class="red">*</span></label>
                                                                                    <input type="text" class="form-control numberlang toClear" style="text-align: right;" id="txtPrice">
                                                                                </div>
                                                                                <div class="col-md-1 required"> 
                                                                                    <label class="control-label">Qty &nbsp;<span class="red">*</span></label>
                                                                                    <input type="text" class="form-control numberlang toClear numberlang" style="text-align: center"  id="txtQty">
                                                                                </div>

                                                                                <div class="col-md-1 required"> 
                                                                                    <label class="control-label">Unit &nbsp;<span class="red">*</span></label>
                                                                                    <input type="text" class="form-control toClear" id="txtUnit" style="text-align: center" >
                                                                                </div>

                                                                                <div class="col-md-5"> 
                                                                                    <label class="control-label">Remarks</label>
                                                                                    <input type="text" class="form-control toClear" id="txtRemarks">
                                                                                </div>

                                                                                                                            
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-2">
                                                                                    <button class="btn btn-success btn-block raduis-4 edisabled" style="margin-top: 20px;" onclick="addFacilities()">Add</button>
                                                                                </div>  
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row"> 
                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                                <th width="20%">Facility</th>
                                                                                <th width="9%">Price</th>
                                                                                <th width="8%">Qty</th>
                                                                                <th width="9%">Unit</th>
                                                                                <th width="9%">VAT</th>
                                                                                <th width="9%">Total Price</th>
                                                                                <th width="33%">Remarks</th>
                                                                                <th width="3%"></th>
                                                                            </thead>
                                                                            <tbody id="tblFacilities" class="editContent"></tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div>
                                                                        <div class="row">
                                                                            <div class="pull-right"><h4>Sub Total:  <span id="txttotalfacilities" style="color: blue;margin-left: 20px">0.00</span></h4></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="panel eventorder hide" id="sound-body">
                                                                <div class="panel-body" style="min-height: 400px;">
                                                                    <div class="form-horizontal" id="forSound">
                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <div class="col-md-3 required"> 
                                                                                     <div class="form-group ">
                                                                                        <label class="control-label">Personnel &nbsp;&nbsp;<span class=" red">*</span></label>
                                                                                        <select style="width: 100%" class="form-control searchy_select" onchange ="selectamountpersonnel(this.value)" id="txtPersonnel">
                                                                                            <option value="">-- Select Sound & Personnel --</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <div class="col-md-1 required"> 
                                                                                    <label class="control-label">Price &nbsp;<span class="red">*</span></label>
                                                                                    <input type="text" style="text-align: right" class="form-control numberlang toClear" id="txtPricepersonnel">
                                                                                </div>
                                                                                <div class="col-md-1 required"> 
                                                                                    <label class="control-label">Qty &nbsp;<span class="red">*</span></label>
                                                                                    <input type="text" style="text-align:center " class="form-control numberlang toClear" id="txtQtypersonnel">
                                                                                </div>
                                                                                <div class="col-md-3 required">
                                                                                    <label class="control-label">Date Duration&nbsp;<span class=" red">*</span></label>
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-addon">
                                                                                            <i class="fa fa-calendar bigger-110"></i>
                                                                                        </span>

                                                                                        <input class="form-control toClear" id="txtsounddate" type="text" name="date-range-picker"    />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-2 required"> 
                                                                                    <label class="control-label">Start Time &nbsp;<span class="red">*</span></label>
                                                                                    <input type="text" style="text-align: center" class="form-control toClear timepickeronly" id="txtstartTimeSound" onkeydown="return false">
                                                                                </div>
                                                                                <div class="col-md-2 required"> 
                                                                                    <label class="control-label">End Time &nbsp;<span class="red">*</span></label>
                                                                                    <input type="text" style="text-align: center" class="form-control toClear timepickeronly" id="txtendTimeSound" onkeydown="return false">
                                                                                </div>                                           
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-3 required"> 
                                                                                    <label class="control-label">Need &nbsp;<span class="red">*</span></label>
                                                                                    <select class="form-control toClear" id="txtneedsound">
                                                                                        <option value="Egress">Egress</option>
                                                                                        <option value="Ingress">Ingress</option>
                                                                                        <option value="During Event">During Event</option>
                                                                                        <option value="During Rehearsal">During Rehearsal</option>
                                                                                    </select>
                                                                                </div> 
                                                                                <div class="col-md-4"> 
                                                                                    <label class="control-label">Remarks</label>
                                                                                    <input type="text" class="form-control toClear" id="txtRemarksSound">
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-2">
                                                                                    <button class="btn btn-success btn-block raduis-4 edisabled" style="margin-top: 20px;" onclick="addSound()">Add</button>
                                                                                </div> 
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    
                                                                    <div class="row"> 
                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                                <th width="15%">Personnel</th>
                                                                                <th width="5%">Qty</th>
                                                                                <th width="8%">Price</th>
                                                                                <th width="9%">VAT</th>
                                                                                <th width="9%">Total Price</th>
                                                                                <th width="10%">Date</th>
                                                                                <th width="7%">Start Time</th>
                                                                                <th width="7%">End Time</th>
                                                                                <th width="12%">Needs</th>
                                                                                <th width="15%">Remarks</th>
                                                                                <th width="3%"></th>
                                                                            </thead>
                                                                            <tbody id="tblSound" class="editContent"></tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div>
                                                                        <div class="row">
                                                                            <div class="pull-right"><h4>Sub Total:  <span id="txttotalsound" style="color: blue;margin-left: 20px">0.00</span></h4></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- MANPOWER -->
                                                            <div class="panel eventorder hide" id="manpower-body">
                                                                <div class="panel-body" style="min-height: 400px;">
                                                                    <div class="form-horizontal" id="forManpower">
                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <div class="col-md-3 required"> 
                                                                                    <div class="form-group ">
                                                                                        <label class="control-label">Manpower &nbsp;&nbsp;<span class=" red">*</span></label>
                                                                                        <select style="width: 100%" class="form-control searchy_select" onchange ="selectamountmanpower(this.value)" id="txtname-manpower">
                                                                                            <option value="">-- Select Manpower --</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                               
                                                                                <div class="col-md-1 required"> 
                                                                                    <label class="control-label">Price &nbsp;<span class="red">*</span></label>
                                                                                    <input type="text" style="text-align: right;" class="form-control toClear numberlang" id="Price-manpower">
                                                                                </div>
                                                                                <div class="col-md-1 required"> 
                                                                                    <label class="control-label">Qty &nbsp;<span class="red">*</span></label>
                                                                                    <input type="text" style="text-align: center" class="form-control toClear numberlang" id="txtqty-manpower">
                                                                                </div>
                                                                                <div class="col-md-1 required"> 
                                                                                    <label class="control-label">PAX &nbsp;<span class="red">*</span></label>
                                                                                    <input type="text" style="text-align: center" class="form-control toClear numberlang" id="txtPax-manpower">
                                                                                </div>
                                                                                <div class="col-md-3 required">
                                                                                    <label class="control-label">Date Duration&nbsp;<span class=" red">*</span></label>
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-addon">
                                                                                            <i class="fa fa-calendar bigger-110"></i>
                                                                                        </span>

                                                                                        <input class="form-control toClear" id="txtmanpowerdate" type="text" name="date-range-picker"    />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-1 required"> 
                                                                                    <label class="control-label">Start Time &nbsp;<span class="red">*</span></label>
                                                                                    <input type="text" style="text-align: center;" class="form-control toClear timepickeronly" id="txtstartTimemanpower" onkeydown="return false">
                                                                                </div>
                                                                                <div class="col-md-1 required"> 
                                                                                    <label class="control-label">End Time &nbsp;<span class="red">*</span></label>
                                                                                    <input type="text" style="text-align: center;" class="form-control toClear timepickeronly" id="txtendTimemanpower" onkeydown="return false">
                                                                                </div>  
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-3 required"> 
                                                                                    <label class="control-label">Need &nbsp;<span class="red">*</span></label>
                                                                                    <select class="form-control toClear" id="txtneedmanpower">
                                                                                        <option value="Egress">Egress</option>
                                                                                        <option value="Ingress">Ingress</option>
                                                                                        <option value="During Event">During Event</option>
                                                                                        <option value="During Rehearsal">During Rehearsal</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-4"> 
                                                                                    <label class="control-label">Remarks</label>
                                                                                    <input type="text" class="form-control toClear" id="txtRemarksmanpower">
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-2">
                                                                                    <button class="btn btn-success btn-block raduis-4 edisabled" style="margin-top: 20px;" onclick="addManpower()">Add</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    
                                                                    <div class="row"> 
                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                                <th width="13%">Manpower</th>
                                                                                <th width="5%">Pax</th>
                                                                                <th width="5%">Qty</th>
                                                                                <th width="8%">Price</th>
                                                                                <th width="8%">VAT</th>
                                                                                <th width="9%">Total Price</th>
                                                                                <th width="9%">Date</th>
                                                                                <th width="8%">Start Time</th>
                                                                                <th width="8%">End Time</th>
                                                                                <th width="11%">Needs</th>
                                                                                <th width="14%">Remarks</th>
                                                                                <th width="2%"></th>
                                                                            </thead>
                                                                            <tbody id="tblManpower" class="editContent"></tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div>
                                                                        <div class="row">
                                                                            <div class="pull-right"><h4>Sub Total:  <span id="txttotalmanpower" style="color: blue;margin-left: 20px">0.00</span></h4></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- ORGANIZER -->
                                                            <div class="panel eventorder hide" id="organizer-body">
                                                                <div class="panel-body" style="min-height: 400px;">
                                                                    <div class="form-horizontal" id="forOrganizer">
                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <div class="col-md-4 required"> 
                                                                                    <div class="form-group ">
                                                                                        <label class="control-label">Name &nbsp;&nbsp;<span class=" red">*</span></label>
                                                                                        <select style="width: 100%" class="form-control searchy_select" id="txtname-organizer">
                                                                                            <option value="">-- Select Name --</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-1 required"> 
                                                                                    <label class="control-label">Qty &nbsp;<span class="red">*</span></label>
                                                                                    <input type="text" style="text-align: center" class="form-control toClear" id="txtqty-organizer">
                                                                                </div>

                                                                                <div class="col-md-1 required"> 
                                                                                    <label class="control-label">Unit &nbsp;<span class="red">*</span></label>
                                                                                    <input type="text" style="text-align: center" class="form-control toClear" id="txtunit-organizer">
                                                                                </div>

                                                                                <div class="col-md-5"> 
                                                                                    <label class="control-label">Remarks</label>
                                                                                    <input type="text" class="form-control toClear" id="txtremarks-organizer">
                                                                                </div>

                                                                                                                             
                                                                            </div>
                                                                            <div class="row">
                                                                                 <div class="col-md-2">
                                                                                    <button class="btn btn-success btn-block raduis-4 edisabled" style="margin-top: 20px;" onclick="addOrganizer()">Add</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    
                                                                    <div class="row"> 
                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                                <th width="20%">Name</th>
                                                                                <th width="10%">Qty</th>
                                                                                <th width="10%">Unit</th>
                                                                                <th width="55%">Remarks</th>
                                                                                <th width="5%"></th>
                                                                            </thead>
                                                                            <tbody id="tblOrganizer" class="editContent"></tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- PROMOTIONAL -->
                                                            <div class="panel eventorder hide" id="promotional-body">
                                                                <div class="panel-body" style="min-height: 400px;">
                                                                    <div class="form-horizontal" id="forPromotional">
                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <div class="col-md-4 required"> 
                                                                                    <div class="form-group ">
                                                                                        <label class="control-label">Name &nbsp;&nbsp;<span class=" red">*</span></label>
                                                                                        <select style="width: 100%" class="form-control searchy_select" id="txtname-promotional">
                                                                                            <option value="">-- Select Name --</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-md-7"> 
                                                                                    <label class="control-label">Remarks</label>
                                                                                    <input type="text" class="form-control toClear" id="txtremarks-promotional">
                                                                                </div>

                                                                                                                              
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-2">
                                                                                    <button class="btn btn-success btn-block raduis-4 edisabled" style="margin-top: 20px;" onclick="addPromotional()">Add</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    
                                                                    <div class="row"> 
                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                                <th width="20%">Name</th>
                                                                                <th width="75%">Remarks</th>
                                                                                <th width="5%"></th>
                                                                            </thead>
                                                                            <tbody id="tblPromotional" class="editContent"></tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- ATTACHMENTS -->
                                                            <div class="panel eventorder hide" id="requirements-body">
                                                                <div class="panel-body" style="min-height: 400px;">
                                                                    <div class="row">
                                                                        <h3 onclick="opendadddreq()" style="cursor: pointer;"><span class="fa fa-plus-circle blue" ></span> Attachments</h3>
                                                                        <form id="frmuploadevents" method="post" action="" enctype="multipart/form-data">
                                                                            <div class="col-sm-8 col-xs-12" id="newbodyreqs">
                                                                                
                                                                            </div>

                                                                            <div class="col-sm-8 col-xs-12" id="bodyrequirements">
                                                                                
                                                                            </div>
                                                                            <input type="hidden" style="display: " id="txteventsidno" name="txteventsidno">    
                                                                            <input type="submit" style="display:none " id="btnuploadeventsattach" >
                                                                        </form>
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


                                <div class="space-10"></div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="panel panel-primary custom-panel-1">
                                            <div class="panel-heading">
                                                <a data-toggle="collapse" href="#collapse4" class="collapsebtn block collapsed">Assigned Units <span class="fa fa-chevron-down pull-right collapse-icon"></span></a>
                                            </div>

                                            <div class="panel-collapse collapse" id="collapse4">
                                                <div class="panel-body" style="height: 400px; padding: 0px !important;">
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <div id="eventsunitinformation"></div>
                                                        </div>
                                                        <div class="col-md-12 pull-right" style="font-size: 17px">
                                                            <div class="pull-right"><p><span style="color: green"><span id="txtunitrent"></span></span> x <span style="color:green"><span id="txtunitdays"></span></span></p></div>
                                                        </div>
                                                        <div class="col-md-12 pull-right" style="font-size: 12px">
                                                            <div class="pull-right"><p style="color: red">(Rent x Day(s))</p></div>
                                                        </div>
                                                        <div class="col-md-12 pull-right">
                                                            <div class="pull-right"><h4>Sub Total:  <span id="txttotalunitsrent" style="color: blue;margin-left: 20px">0.00</span></h4></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-10"></div>
                                <div class="col-md-12" id="accordeventremarks">
                                    <div class="row">
                                        <div class="panel panel-primary custom-panel-1">
                                            <div class="panel-heading">
                                                <a data-toggle="collapse" href="#collapse5" class="collapsebtn block collapsed">Remarks <span class="fa fa-chevron-down pull-right collapse-icon"></span></a>
                                            </div>

                                            <div class="panel-collapse collapse" id="collapse5">
                                                <div class="panel-body" style="height: 400px; padding: 0px !important;">
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <div class="widget-body" >
                                                                <div class="widget-main">
                                                                    <div class="row well">
                                                                        <div class="row form-group" id="divNewInquiryRemarksx">
                                                                            <div class="col-md-12">
                                                                                <button class="btn btn-sm btn-primary pull-right btn-round edisabled" id="btnaddremarksevents" onclick="addnewremarks_events()">&nbsp;Add New Remarks</button>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row form-group">
                                                                            <div class="col-md-12">
                                                                                <div id="eventInqRemarks"></div>
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
                </div>

                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-2">
                            <button class="btn btn-success btn-sm btn-round btn-block  willhide" id="btnsaveeventsnotedby" ><i class="ace-icon fa fa-sticky-note"></i>&nbsp;Noted By</button>
                        </div>
                        <div class="col-md-2 pull-right">
                            <button class="btn btn-primary btn-sm btn-round btn-block edisabled" id="btnsaveeventsx" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving..."><i class="ace-icon fa fa-check"></i>&nbsp;Save</button>
                        </div>
                        <div class="col-md-2 pull-right">
                            <button class="btn btn-warning btn-sm btn-round btn-block willhide" style="display: none" id="btnprintevents"><i class="ace-icon fa fa-print"></i>&nbsp;Package Breakdown</button>
                        </div>
                        <div class="col-md-2 pull-right">
                            <button class="btn btn-warning btn-sm btn-round btn-block willhide2" style="display: none" id="btnprintevents2"><i class="ace-icon fa fa-print"></i>&nbsp;Quotation Letter</button>                            
                        </div>
                    </div>
                    
                </div>
            </div>

        </div>
    </div>
</div>

<!-- <div class="btn-group open" style="width: 100%">
                                <button class="btn btn-warning btn-sm btn-round btn-block btn-primary  willhide" data-toggle="dropdown" aria-expanded="true">
                                    Print
                                    <span class="ace-icon fa fa-caret-down icon-on-right"></span>
                                </button>

                                <ul class="dropdown-menu dropdown-default">
                                    <li>
                                        <a  id="btnprintevents" onclick="">Package Breakdown</a>
                                    </li>
                                    <li>
                                        <a  id="btnprintevents2" onclick="">Quotation Letter</a>
                                    </li>
                                </ul>
                            </div> -->
<div class="modal fade fade-scale" id="modal_new_remarks_events" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" style="margin-top: 10%;">   
        <div class="modal-content">
            <div class="modal-header" style="background-color: #438EB9;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Remarks</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="txtremIDevents">
                <div class="row form-group" style="margin-top: 15px;">
                    <div class="col-xs-12">
                        <textarea class="form-control" id="txt_remarksvents" style="height: 100px; resize: none;" maxlength="255"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm btn-round" id="btnsavenoweventsremarks" onclick="savenewremark_events();"><i class="ace-icon fa fa-check"></i>&nbsp;Save</button>
            </div>
        </div>
    </div>
</div> 


<div class="modal fade fade-scale" id="modalnotedbysetup" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" style="margin-top: 10%;">   
        <div class="modal-content">
            <div class="modal-header" style="background-color: #438EB9;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Select</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group" style="margin-top: 15px;">
                    <div class="col-xs-12">
                        <div class="form-group required">
                            <label class="control-label">Noted By &nbsp;&nbsp;<span class=" red">*</span></label>
                            <select style="width: 100%" class="form-control searchy_select"  placeholder= "-- Select User --" id="txteventsnotedby">
                                <option value="">-- Select User --</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm btn-round" id="btnsavenownoted" ><i class="ace-icon fa fa-check"></i>&nbsp;Save</button>
            </div>
        </div>
    </div>
</div> 



<?php include("script.php"); ?>
