<style>
    .parent2 {
        height: 40vh;
    }

    .parent-tenant{
        height: 60vh;
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
    include('tenantspaymentscript.php');
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
                                <input type="text" class="form-control input-sm readx" id="mallname" style="text-align: center;"/>
                            </div>
                        </div>
                        <br>
                         <div class="row form-group">
                            <label class="col-sm-5">Company Name</label>
                            <div class="col-sm-7 ">
                                <input type="text" class="form-control input-sm readx" id="compname" />
                                <input type="hidden" id="mallid" name="">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-5">Date</label>
                            <div class="col-sm-7 required">
                                <input type="text" class="form-control date-picker input-sm paymentx" id="txttpaymentdate" />
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-5">Payment Type</label>
                            <div class="col-sm-7 required">
                                <select class="form-control input-sm paymentx" id="txttpaymenttype" />
                                    <option value="">- Select type -</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="row">
                            <div class="col-sm-12 required">
                                <label class="big-one">Tenant ID</label>
                                <input type="text" class="form-control input-sm readx" id="tenantid" />
                            </div>
                        </div>
                        <br>
                        <div class="row form-group">
                            <label class="col-sm-5 thSysTenant">Store Name</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control input-sm readx" id="storename" />
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-5">OR #</label>
                            <div class="col-sm-7 required">
                                <input type="text" class="form-control input-sm paymentx" id="txttpaymentorno" />
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-5">Amount</label>
                            <div class="col-sm-7 required">
                                <input type="text" class="form-control input-sm paymentx" style="text-align: right" onblur="thisval(this.value)" onkeypress="return isNumberKey(event)" id="txttpaymentamount" />
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
                <div class="row form-group divinfo">
                    <div class="col-sm-8">
                        <div class="row form-group">
                            <label class="col-sm-2">Reference</label>
                            <div class="col-sm-10 required" style="padding-left: 2.5vw">
                                <input type="text" class="form-control input-sm paymentx" id="txttpaymentreference" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                        <div class="col-sm-4">
                            <button class="btn btn-success btn-sm pull-right btn-block isadmin hide select-addtenantspayment btn-round" id="btnaddpayments" onclick="addpayments()"> Add Payment </button>
                        </div>
                    </div>
                <div class="row form-group" style="margin-bottom: 0px !important;padding-left: 5px">
                    <div id="forhistory" class="parent">
                        <table id="storeinfotable" class="table table-striped table-bordered table-hover fixTable">
                            <thead>
                                <tr>
                                    <th width='11%'>Date</th>
                                    <th width='10%'>OR #</th>
                                    <th width='12%'>Payment Type</th>
                                    <th width='14%'>Amount</th>
                                    <th width='24%'>Referential</th>
                                    <th width='15%'>User</th>
                                    <th width='11%'>Date Added</th>
                                    <th width='3%'>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbltenatspayment"></tbody>
                        </table>
                    </div>
                </div>
        	</div>
        </div>

    </div>
</div>