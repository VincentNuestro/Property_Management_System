<div class="col-md-12" id="historyreportgo" style="display: none;">
<table style="width: 100%;">
    <tbody id="template"></tbody>
</table>
    <table>
        <tbody>
            <tr>
                <td width="20%" ><label class="big-one">Mall Name: </label></td>
                <td width="20%" style="border-bottom: 1px solid #ccc;" class="mallname"></td>
                <td width="20%" ><label class="big-one">Tenant ID: </label></td>
                <td width="20%" style="border-bottom: 1px solid #ccc;" class="tenantid"></td>
                <td rowspan="5">
                    <img id="printlogo" class="img-responsive img-thumbnail" style="height: 150px; width: 150px;" onerror="imgerror($(this));">
                </td>
            </tr>
            <tr>
                <td width="20%" ><label class="big-one">Company ID: </label></td>
                <td width="20%" style="border-bottom: 1px solid #ccc;" class="compid"></td>
                <td width="20%" ><label class="big-one">First Name: </label></td>
                <td width="20%" style="border-bottom: 1px solid #ccc;" class="fname"></td>
            </tr>
            <tr>
                <td width="20%" ><label class="big-one">Company Name: </label></td>
                <td width="20%" style="border-bottom: 1px solid #ccc;" class="compname"></td>
                <td width="20%" ><label class="big-one">Middle Name: </label></td>
                <td width="20%" style="border-bottom: 1px solid #ccc;" class="lname"></td>
            </tr>
            <tr>
                <td width="20%" ><label class="big-one">Store Name: </label></td>
                <td width="20%" style="border-bottom: 1px solid #ccc;" class="storename"></td>
                <td width="20%" ><label class="big-one">Last Name: </label></td>
                <td width="20%" style="border-bottom: 1px solid #ccc;" class="mname"></td>
            </tr>
        </tbody>
    </table>
    <br>
    <div class="row stat" style="font-size: 14px;">
        <div class="col-md-6">
            <span style="font-size: 12px ;">Status :</span>
            <span style="font-size: 12px;"><span class="fa fa-flag" style="font-size: 12px; color: #DFE21A;"></span> Active</span>&nbsp;|&nbsp;
            <span style="font-size: 12px;"><span class="fa fa-flag" style="font-size: 12px; color: DarkGray;"></span> In-active</span>&nbsp;|&nbsp;
            <span style="font-size: 12px;"><span class="fa fa-flag" style="font-size: 12px; color: #428BCA;"></span> For Renewal</span>&nbsp;|&nbsp;
            <span style="font-size: 12px;"><span class="fa fa-flag" style="font-size: 12px; color: red;"></span> For Eviction</span>&nbsp;|&nbsp;
            <span style="font-size: 12px;"><span class="fa fa-flag" style="font-size: 12px; color: grey;"></span> Evicted</span>
        </div>
    </div>
    <div id="forhistory" class="parent">
        <table id="storeinfotable" class="table table-striped table-bordered table-hover fixTable">
            <thead>
                <tr>
                    <td width = '7%'></td>
                    <td width = '14%'>Trade Name</td>
                    <td width = '8%'>Unit ID</td>
                    <td width = '10%'>Unit Name</td>
                    <td width = '14%'>Floor Location</td>
                    <td width = '15%'>Contract Date</td>
                    <td width = '18%'>No. of Months & Days</td>
                    <td width = '10%'>Cost per Month</td>
                    <td width = '4%'>Status</td>
                </tr>
            </thead>
            <tbody id="printtblstoreunit"></tbody>
        </table>
    </div>
</div>
