<style>
    .parent2 {
        height: 40vh;
    }

    .parent-tenant{
        height: 30vh;
        border: 2px solid #ccc;
    }

    .activated  td{
        color: #FFF !important;
        background-color: #777 !important;
    }

    .big-one {
        font-weight: 700;
    }
    
    .divinfo input {
        color: black !important;
    }
</style>

<?php 
    include('historyscript.php');
    include('printhistory.php');
?>
<div class="row">
    <div class="col-md-12">
        <div class="row form-group" style="margin-bottom: 0px;">
        	<div class="col-md-3" style="padding-bottom: 5px;padding-left: 0px;">
                <span class="input-icon" style="width: 100%; margin-bottom: 4px;">
                    <input type="text" class="form-control input-sm" placeholder="Search" title="Search" id="srchhistory">
                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                </span>
                <div class="parent-tenant">
                    <table class="table table-striped table-bordered table-hover fixTable">
                        <thead>
                            <tr>
                                <th class="thSysTenant">Trade Name</th>
                            </tr>
                        </thead>
                        <div class="" id="tenant_history_list"></div>
                        <tbody id="tblstorename"></tbody>
                    </table>
                </div>
        	</div>
            <div class="col-md-9" style="padding-bottom: 5px;padding-left: 0px;">
                <div class="row form-group divinfo">
                    <div class="col-sm-4">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="big-one">Mall Name</label>
                                <input type="text" class="form-control input-sm" id="mallname" style="text-align: center;"/>
                            </div>
                        </div>
                        <br>
                        <div class="row form-group">
                            <label class="col-sm-5">Company ID</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control input-sm" id="compid" />
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-5">Company Name</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control input-sm" id="compname" />
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-5 thSysTenant">Store Name</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control input-sm" id="storename" />
                            </div>
                        </div>

                    </div>

                    <div class="col-sm-4">
                        <div class="row form-group">
                            <div class="col-sm-12">
                                <label class="big-one">Tenant ID</label>
                                <input type="text" class="form-control input-sm" id="tenantid" />
                            </div>
                        </div>
                        <br>
                        <div class="row form-group">
                            <label class="col-sm-5">First Name</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control input-sm" id="fname" />
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-5">Middle Name</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control input-sm" id="lname" />
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-5">Last Name</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control input-sm" id="mname" />
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div id="imgledgerhere">
                            <center>
                                <img id="historylogo" class="img-responsive img-thumbnail" style="height: 180px; width: 180px;" onerror="imgerror($(this));">
                            </center>
                        </div>
                    </div>
                </div>
        	</div>
        </div>
<br>
        <div class="row form-group" style="margin-bottom: 0px !important;">
            <div class="row stat" style="font-size: 14px;">
                <div class="col-md-6">
                    <span style="font-weight: 700;">Status :</span>&nbsp;&nbsp;
                    <span><span class="fa fa-flag" style="font-weight: 700; color: #DFE21A;"></span> Active</span>&nbsp;|&nbsp;
                    <span><span class="fa fa-flag" style="font-weight: 700; color: DarkGray;"></span> In-active</span>&nbsp;|&nbsp;
                    <span><span class="fa fa-flag" style="font-weight: 700; color: #428BCA;"></span> For Renewal</span>&nbsp;|&nbsp;
                    <span><span class="fa fa-flag" style="font-weight: 700; color: red;"></span> For Eviction</span>&nbsp;|&nbsp;
                    <span><span class="fa fa-flag" style="font-weight: 700; color: grey;"></span> Evicted</span>
                </div>
                <div class="col-md-6">
                    <a href="#" onclick="printhistory()" class="pull-right hide isadmin select-printtenanthistory"><i class="glyphicon glyphicon-print blue"></i>&nbsp;&nbsp;Print</a>
                </div>
            </div>
            <div id="forhistory" class="parent">
                <table id="storeinfotable" class="table table-striped table-bordered table-hover fixTable">
                    <thead>
                        <tr>
                            <th width='7%'></th>
                            <th width='14%' class="thSysTenant">Trade Name<span class="btnsortdash-tenanthistory fa fa-sort bigger-130 pull-right" id="tradename"></span></th>
                            <th width='8%'>Unit ID<span class="btnsortdash-tenanthistory fa fa-sort bigger-130 pull-right" id="unitID"></span></th>
                            <th width='10%'>Unit Name<span class="btnsortdash-tenanthistory fa fa-sort bigger-130 pull-right" id="unitname"></span></th>
                            <th width='10%'>Floor Location<span class="btnsortdash-tenanthistory fa fa-sort bigger-130 pull-right" id="unitname"></span></th>
                            <th width='15%'>Contract Date<span class="btnsortdash-tenanthistory fa fa-sort bigger-130 pull-right" id="contractdate"></span></th>
                            <th width='14%'>No. of Months & Days2<span class="btnsortdash-tenanthistory fa fa-sort bigger-130 pull-right" id="noofmonths"></span></th>
                            <th width='10%'>Cost per Month<span class="btnsortdash-tenanthistory fa fa-sort bigger-130 pull-right" id="monthly_dues"></span></th>
                            <th width='4%'>Status<span class="btnsortdash-tenanthistory fa fa-sort bigger-130 pull-right" id="STATUS"></span></th>
                        </tr>
                    </thead>
                    <tbody id="tblstoreunit"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="TenantHistorySortType" value="ASC">
<input type="hidden" id="TenantHistorySortBy" value="TenantID">