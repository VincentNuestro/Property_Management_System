<div class="col-md-7 refPaymentType divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-th-large light-green bigger-130"></i>&nbsp; Payment Type
            </h5>
        </div>
        <div class="space-4"></div>
        <div class="row form-group">
			<div class="col-md-10">
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
					<input type="text" class="form-control input-sm" id="txtsearchPaymentType">
				</div>
			</div>
			<div class="col-md-2">
				<div class='btn-group pull-right'>
			       <button class='btn btn-info btn-round btn-sm' onclick="$arr = [];$arr.push( 'page='+$('#txtPagePaymentType').val() );$arr.push( 'key='+$('#txtsearchPaymentType').val() );getheaderprint('<?php echo $_SESSION['MMS-Designation']; ?>','refPaymentType',JSON.stringify($arr));" style="cursor: pointer;" data-placement="bottom" title="">Print</button> 
			        <button data-toggle='dropdown' class='btn dropdown-toggle btn-info btn-round btn-sm'>
			            <span class='ace-icon fa fa-caret-down icon-only'></span>
			        </button>
			        <ul class='dropdown-menu pull-right'>
			            <li>
			                <a onclick="AutoConsolidatePaymentType();">Export</a>
			            </li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row form-group" style="margin-top: -10px;">
			<div class="col-md-12">
				<div style="height: 70vh;">
					<table class="table table-bordered table-hover fixTable">
						<thead>
							<tr>
								<th style="width: 30%;">Payment Type<span class="btnsortdash-othpayment fa fa-sort bigger-130 pull-right" id="PaymentType"></span></th>
								<th style="width: 30%;">Code<span class="btnsortdash-othpayment fa fa-sort bigger-130 pull-right" id="PaymentTypeID"></span></th>
								<th style="width: 40%;">Description<span class="btnsortdash-othpayment fa fa-sort bigger-130 pull-right" id="PaymentTypeDesc"></span></th>
							</tr>
						</thead>
						<tbody id="tblrefPaymentType"></tbody>
					</table>
				</div>
				<table class="tabledash_footer table" style="margin: 0px !important;">
					<thead>
					  	<tr>
							<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
								<font id="txtEntriesPaymentType" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
								<input id="txtPagePaymentType" type="hidden">
							  	<ul id="ulPagePaymentType" class="pagination pull-right"></ul>
							</th>
					  	</tr>
					</thead>
			  	</table>
			</div>
		</div>
    </div>
</div>

<div class="col-md-3 refPaymentType divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-cog light-green bigger-130"></i>&nbsp; Option
            </h5>
        </div>
        <div class="space-4"></div>
         <div class="row form-group">
			<label class="control-label col-md-12 col-xs-12"> Payment Type:</label>
			<div class="col-md-12 col-xs-12">
				<select class="form-control txtPaymentType searchy_select" id="txtrefPaymentType" disabled>
					<option value="CASH">Cash</option>
					<option value="CREDIT CARD">Credit Card</option>
					<option value="BANK DEPOSIT">Bank Deposit</option>
					<option value="SECURITY DEPOSIT">Security Deposit</option>
					<option value="CONSTRUCTION DEPOSIT">Construction Deposit</option>
					<option value="WITHOLDING TAX">Witholding Tax</option>
					<option value="ADJUSTMENT">Adjustment</option>
					<option value="CHECK">Check</option>
					<option value="OTHERS">Others</option>
				</select>
			</div>
		</div>

        <div class="row form-group">
			<label class="control-label col-md-12 col-xs-12"> Code:</label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control txtPaymentType ThisIsForCodes" id="txtRefPaymentCode" readonly style="text-transform: uppercase;">
			</div>
		</div>

		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Description:</label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control txtPaymentType" id="txtRefPaymentDescription" readonly style="text-transform: capitalize;">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-12">
				<div class="btn-group pull-right" id="buttonsPaymentType">
					<button class="btn btn-primary btn-round btn-sm hide isadmin select-addreferentials" onclick="clickAddPaymentType()"><span class="fa fa-plus"></span> Add</button>
					<button class="btn btn-success btn-round btn-sm hide isadmin select-editreferentials" onclick="clickUpdatePaymentType()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
					<button class="btn btn-danger btn-round btn-sm hide isadmin select-deletereferentials" onclick="clickDeletePaymentType()"><span class="glyphicon glyphicon-trash"></span> Delete</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="savingbuttonsPaymentType">
					<button class="btn btn-primary btn-round btn-sm" onclick="fncSavePaymentType()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonPaymentType()"><span class="fa fa-remove"></span> Cancel</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="updatebuttonsPaymentType">
					<button class="btn btn-primary btn-round btn-sm" onclick="updatePaymentType()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonPaymentType2()"><span class="fa fa-remove"></span> Cancel</button>
				</div>
			</div>
		</div>
    </div>
</div>

<input type="hidden" id="hiddenPaymentTypeid">
<input type="hidden" id="othPaymentSortType" value="ASC">
<input type="hidden" id="othPaymentSortBy" value="PaymentTypeID">
<?php include("script.php"); ?>