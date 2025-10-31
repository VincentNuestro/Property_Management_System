<div class="col-md-7 refCharges divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-th-large light-green bigger-130"></i>&nbsp; Charges
            </h5>
        </div>
        <div class="space-4"></div>
        <div class="row form-group">
			<div class="col-md-10">
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
					<input type="text" class="form-control input-sm" id="txtsearchRefCharges">
				</div>
			</div>
			<div class="col-md-2">
				<div class='btn-group pull-right'>
			       <button class='btn btn-info btn-round btn-sm' onclick="$arr = [];$arr.push( 'page='+$('#txtPageCharges').val() );$arr.push( 'key='+$('#txtsearchRefCharges').val() );getheaderprint('<?php echo $_SESSION['MMS-Designation']; ?>','refchargesrep',JSON.stringify($arr));" style="cursor: pointer;" data-placement="bottom" title="">Print</button> 
			        <button data-toggle='dropdown' class='btn dropdown-toggle btn-info btn-round btn-sm'>
			            <span class='ace-icon fa fa-caret-down icon-only'></span>
			        </button>
			        <ul class='dropdown-menu pull-right'>
			            <li>
			                <a onclick="AutoConsolidateCharges();">Export</a>
			            </li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row form-group" style="margin-top: -10px;">
			<div class="col-md-12">
				<div style="height: 70vh;">
					<table class="table table-bordered table-hover fixTable" style="width: 1600px;">
						<thead>
							<tr>
								<th style="width: 10%;">Charge Code2<span class="btnsortdash-refcharges fa fa-sort bigger-130 pull-right" id="CHARGE_ID"></span></th>
								<th style="width: 20%;">Charge Description<span class="btnsortdash-refcharges fa fa-sort bigger-130 pull-right" id="CHARGE_DESC"></span></th>
								<th style="width: 18%;">Charge Type<span class="btnsortdash-refcharges fa fa-sort bigger-130 pull-right" id="CHARGE_TYPE"></span></th>
								<th style="width: 10%;">Rate Type<span class="btnsortdash-refcharges fa fa-sort bigger-130 pull-right" id="RATE_TYPE"></span></th>
								<th style="width: 10%;">Rate<span class="btnsortdash-refcharges fa fa-sort bigger-130 pull-right" id="RATE"></span></th>
								<th style="width: 20%;">Reason<span class="btnsortdash-refcharges fa fa-sort bigger-130 pull-right" id="OTHER_REASON"></span></th>
								<th style="width: 12%;">Default Proposal Status<span class="btnsortdash-refcharges fa fa-sort bigger-130 pull-right" id="isDefault"></span></th>
							</tr>
						</thead>
						<tbody id="tbodyRefCharges"></tbody>
					</table>
				</div>
				<table class="tabledash_footer table" style="margin: 0px !important;">
					<thead>
					  	<tr>
							<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
								<font id="txtEntriesCharges" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
								<input id="txtPageCharges" type="hidden">
							  	<ul id="ulPageCharges" class="pagination pull-right"></ul>
							</th>
					  	</tr>
					</thead>
			  	</table>
			</div>
		</div>
    </div>
</div>

<div class="col-md-3 refCharges divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-cog light-green bigger-130"></i>&nbsp; Option
            </h5>
        </div>
        <div class="space-4"></div>
        <div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Charge Code:</label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control classCharges reqRefCharges ThisIsForCodes" id="txtChargeCode" readonly style="text-transform: uppercase;">
			</div>
		</div>

		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Charge Description:</label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control classCharges reqRefCharges" id="txtChargeDesc" readonly style="text-transform: capitalize;">
			</div>
		</div>

		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Charge Type:</label>
			<div class="col-md-12 col-xs-12">
				<select class="form-control classCharges2 reqRefCharges searchy_select" id="txtChargesType" disabled>
					<option value="">-- Select Charge Type --</option>
					<option value="Operational Charges">Operational Charges</option>
					<option value="Conditional Charges">Conditional Charges</option>
				</select>
			</div>
		</div>

		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Rate Type:</label>
			<div class="col-md-12 col-xs-12">
				<select class="form-control classCharges2 reqRefCharges searchy_select" onchange="RateTypeChanged(this.value);" id="txtChargesRateType" disabled>
					<option value=''>-- Select Rate Type --</option>
					<option value='Each'>Each</option>
					<option value='Hourly'>Hourly</option>
					<option value='Daily'>Daily</option>
					<option value='Monthly'>Monthly</option>
					<option value='Occurence'>Occurence</option>
					<option value='Installation'>Installation</option>
					<option value='Persqm'>Per sqm</option>
					<option value='Fixed'>Fixed</option>
					<option value='Other'>Other</option>
				</select>
			</div>
		</div>

		<div class="row form-group" style="display: none;" id="div_Rate">
			<label class="control-label col-md-12 col-xs-12">Rate:</label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control classCharges numonly" id="txtChargesRate" readonly>
			</div>
		</div>

		<div class="row form-group" style="display: none;" id="div_otherReason">
			<label class="control-label col-md-12 col-xs-12">Reason:</label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control classCharges" id="txtChargesReason" readonly>
			</div>
		</div>

		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Automatically add to proposal?</label>
			<div class="col-md-4 col-xs-12">
				<div class="radio">
                    <label>
                        <input name="form-field-radio-Default" type="radio" class="ace classCharges2 isDefaultToPro" id="1" disabled>
                        <span class="lbl">&nbsp;&nbsp;&nbsp;Yes</span>
                    </label>
                 </div>
			</div>
			<div class="col-md-4 col-lg-2">
				<div class="radio">
                    <label>
                        <input name="form-field-radio-Default" type="radio" class="ace classCharges2 isDefaultToPro" id="0" disabled checked>
                        <span class="lbl">&nbsp;&nbsp;&nbsp;No</span>
                    </label>
                 </div>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-12">
				<div class="btn-group pull-right" id="buttonsRefCharges">
					<button class="btn btn-primary btn-round btn-sm hide isadmin select-addreferentials" onclick="clickAddNewCharges()"><span class="fa fa-plus"></span> Add</button>
					<button class="btn btn-success btn-round btn-sm hide isadmin select-editreferentials" onclick="clickUpdateCharges()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
					<button class="btn btn-danger btn-round btn-sm hide isadmin select-deletereferentials" onclick="clickDeleteRefCharges()"><span class="glyphicon glyphicon-trash"></span> Delete</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="savingbuttonsRefCharges">
					<button class="btn btn-primary btn-round btn-sm" onclick="SaveNewRefCharges()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="clickCancelNewCharges()"><span class="fa fa-remove"></span> Cancel</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="updatebuttonsRefCharges">
					<button class="btn btn-primary btn-round btn-sm" onclick="UpdateRefCharges()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="clickCancelNewCharges2()"><span class="fa fa-remove"></span> Cancel</button>
				</div>
			</div>
		</div>
    </div>
</div>


<input type="hidden" id="ChargesCount">
<input type="hidden" id="HiddenChargesID">
<input type="hidden" id="RefChargesSortType" value="ASC">
<input type="hidden" id="RefChargesSortBy" value="CHARGE_ID">
<?php include("script.php"); ?>