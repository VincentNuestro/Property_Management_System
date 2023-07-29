<div class="row">
    <div class="col-md-12">
        <div class="row form-group" style="margin-bottom: 0px;">
            <div class="col-md-1" style="padding-bottom: 5px;padding-left: 0px;">
                <h3 style="color:#2679B5;margin-top: 10px;display: inline;">&nbsp;<i style="display: inline;" class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;Filter</h3>
            </div>
            <div class="col-md-2" style="padding-bottom: 5px;padding-left: 0px;">
                <select class="form-control" id="sayear">
                    <option value="">Choose Year</option>
                </select>
            </div>
            <div class="col-md-2" style="padding-bottom: 5px;padding-left: 0px;">
                <select class="form-control" id="samonth" onchange="saday();">
                    <option value="">Choose Month</option>
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
            </div>
            <div class="col-md-2" style="padding-bottom: 5px;padding-left: 0px;">
                <select class="form-control" id="saday">
                    <option value="">Choose Day</option>
                </select>
            </div>
            <div class="col-md-2" style="padding-bottom: 5px;padding-left: 0px;">
                <button class="btn btn-sm btn-info btn-round" onclick="company();"><i class="fa fa-search"></i>&nbsp;Go</button>
            </div>
        </div>
        <div class="row form-group">
            <ul class="breadcrumb" id="navdir">
                <li id="companyname" onclick="company();" style="display: none;" ><label id="companynamelabel" style="padding: 5px;"></label></li>
                <li id="mallname" onclick="mallsales();" style="display: none;" ><label id="mallenamelabel" style="padding: 5px;">Mall</label></li>
                <li id="wingname" onclick="wingsales2();" style="display: none;" ><label id="wingnamelabel" style="padding: 5px;"> Wing </label></li>
                <li id="floorname" onclick="floorsales2();" style="display: none;" ><label id="floornamelabel" style="padding: 5px;"> Floor </label></li>
                <li id="unittypename" onclick="unittypesales2();" style="display: none;" ><label id="unittypenamelabel" style="padding: 5px;"> Unit Type </label></li>
                <li id="unitname" onclick="unitsales2();" style="display: none;" ><label id="unitnamelabel" style="padding: 5px;"> Unit </label></li>
                <li id="tenantname" onclick="tenantsales2();" style="display: none;" ><label id="yearlysaleslabel" style="padding: 5px;"> Tenant Sales by Year </label></li>
                <li id="monthname" onclick="tenantsales2bymonth();" style="display: none;" ><label id="monthlysaleslabel" style="padding: 5px;"> Tenant Sales by Month </label></li>
                <li id="dayname" style="display: none;"><label id="dailysaleslabel" style="padding: 5px;"></label></li>
            </ul>
        </div>
        <div class="row form-group"  style="margin-bottom: 0px !important;">
            <div class="parent">
                <table class="table table-bordered fixTable table-hover">
                    <thead>
                        <tr>
                            <th style="width:1%;white-space:nowrap;">Label<span class="btnsortdash-eventsmanpower fa fa-sort bigger-130 pull-right" id="ManpowerCode"></span></th>
                            <th style="width:1%;white-space:nowrap;">Transaction Date</th>
                            <th style="width:1%;white-space:nowrap;">Grand Total of Sales</th>
                            <th style="width:1%;white-space:nowrap;">Grand Total of Discount</th>
                            <th style="width:1%;white-space:nowrap;">Total Discount - Seniors</th>
                            <th style="width:1%;white-space:nowrap;">Total Discount - PWD</th>
                            <th style="width:1%;white-space:nowrap;">Total Discount - GPC</th>
                            <th style="width:1%;white-space:nowrap;">Total Discount - VIP</th>
                            <th style="width:1%;white-space:nowrap;">Total Discount - EMP</th>
                            <th style="width:1%;white-space:nowrap;">Total Discount - REG</th>
                            <th style="width:1%;white-space:nowrap;">Total Discount - Others</th>
                            <th style="width:1%;white-space:nowrap;">Total Refund</th>
                            <th style="width:1%;white-space:nowrap;">Total Canceled</th>
                            <th style="width:1%;white-space:nowrap;">Total VAT </th>
                            <th style="width:1%;white-space:nowrap;">Total VAT Inclusive Sales</th>
                            <th style="width:1%;white-space:nowrap;">Total VAT Exclusive Sales</th>
                            <th style="width:1%;white-space:nowrap;">Beginning O.R.</th>
                            <th style="width:1%;white-space:nowrap;">Ending O.R.</th>
                            <th style="width:1%;white-space:nowrap;">Document Count</th>
                            <th style="width:1%;white-space:nowrap;">Customer Count</th>
                            <th style="width:1%;white-space:nowrap;">Senior Citizen Count</th>
                            <th style="width:1%;white-space:nowrap;">Local Tax</th>
                            <th style="width:1%;white-space:nowrap;">Service Charge</th>
                            <th style="width:1%;white-space:nowrap;">Total Non-VAT Sale</th>
                            <th style="width:1%;white-space:nowrap;">Raw Gross</th>
                            <th style="width:1%;white-space:nowrap;">Daily Local Tax </th>
                            <th style="width:1%;white-space:nowrap;">Total Payment - CASH</th>
                            <th style="width:1%;white-space:nowrap;">Total Payment - CARD</th>
                            <th style="width:1%;white-space:nowrap;">Total Payment - OTHERS</th>
                        </tr>
                    </thead>
                    <tbody id="dbsalesnanagaappend"></tbody>
                </table>
            </div>
            <table class="tabledash_footer table" style="margin: 0px !important;">
                <thead>
                    <tr>
                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                            <font id="txtcomplaintsentries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                            <input id="txt_userpage" type="hidden">
                            <ul id="ulpaginationcomplaint" class="pagination pull-right"></ul>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>  
</div>

<input type="hidden" id="mallid">
<input type="hidden" id="wingid">
<input type="hidden" id="floorid">
<input type="hidden" id="unittype">
<input type="hidden" id="unitid">
<input type="hidden" id="tenantid">
<input type="hidden" id="tenantmonth">
<?php include ("script.php"); ?>