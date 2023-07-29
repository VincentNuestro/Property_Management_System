<!-- MODIFIED BY PETER - 2019-10-29 -->
<!-- ADDED FIELDS FOR FINE FOR OFFENSE REQUESTED BY SIR JOHNNY -->
<div class="col-md-7 refHouseRules divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-th-large light-green bigger-130"></i>&nbsp; House Rules
            </h5>
        </div>
        <div class="space-4"></div>
		<div class="row form-group">
			<div class="col-md-10">
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
					<input type="text" class="form-control input-sm" id="txtsearchHouseRules">
				</div>
			</div>
			<div class="col-md-2">
				<div class='btn-group pull-right'>
				   <button class='btn btn-info btn-round btn-sm' onclick="$arr = [];$arr.push( 'page='+$('#txtPageHouseRules').val() );$arr.push( 'key='+$('#txtsearchHouseRules').val() );getheaderprint('<?php echo $_SESSION['MMS-Designation']; ?>','refmainhouseguestrep',JSON.stringify($arr));" style="cursor: pointer;" class=" isadmin select-printcomplaints" data-placement="bottom" title="">Print</button> 
					<button data-toggle='dropdown' class='btn dropdown-toggle btn-info btn-round btn-sm'>
						<span class='ace-icon fa fa-caret-down icon-only'></span>
					</button>
					<ul class='dropdown-menu pull-right'>
						<li>
							<a onclick="AutoConsolidateHouseRules();">Export</a>
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
								<th style="width: 11%;">Code<span class="btnsortdash-houserule fa fa-sort bigger-130 pull-right" id="code"></span></th>
								<th style="width: 25%;">Violation<span class="btnsortdash-houserule fa fa-sort bigger-130 pull-right" id="violation"></span></th>
								<!-- 1ST OFFENSE -->
								<th style="width: 8%;">1st Offense<span class="btnsortdash-houserule fa fa-sort bigger-130 pull-right" id="1st_offense"></span></th>
								<th style="width: 8%;">Fine<span class="btnsortdash-houserule fa fa-sort bigger-130 pull-right" id="1stFine"></span></th>
								<!-- <th style="width: 4%;">With VAT</th>
								<th style="width: 4%;">VAT Amount</th> -->
								<!-- 1ST OFFENSE -->

								<!-- 2ND OFFENSE -->
								<th style="width: 8%;">2nd Offense<span class="btnsortdash-houserule fa fa-sort bigger-130 pull-right" id="2nd_offense"></span></th>
								<th style="width: 8%;">Fine<span class="btnsortdash-houserule fa fa-sort bigger-130 pull-right" id="2ndFine"></span></th>
								<!-- <th style="width: 4%;">With VAT</th>
								<th style="width: 4%;">VAT Amount</th> -->
								<!-- 2ND OFFENSE -->

								<!-- 3RD OFFENSE -->
								<th style="width: 8%;">3rd Offense<span class="btnsortdash-houserule fa fa-sort bigger-130 pull-right" id="3rd_offense"></span></th>
								<th style="width: 8%;">Fine<span class="btnsortdash-houserule fa fa-sort bigger-130 pull-right" id="3rdFine"></span></th>
								<!-- <th style="width: 4%;">With VAT</th>
								<th style="width: 4%;">VAT Amount</th> -->
								<!-- 3RD OFFENSE -->

								<!-- 4TH OFFENSE -->
								<th style="width: 8%;">Succeeding<span class="btnsortdash-houserule fa fa-sort bigger-130 pull-right" id="xsucceeding"></span></th>
								<th style="width: 8%;">Fine<span class="btnsortdash-houserule fa fa-sort bigger-130 pull-right" id="sucFine"></span></th>
								<!-- <th style="width: 4%;">With VAT</th>
								<th style="width: 4%;">VAT Amount</th> -->
								<!-- 4TH OFFENSE -->
							</tr>
						</thead>
						<tbody id="tblHouseRules"></tbody>
					</table>
				</div>
				<table class="tabledash_footer table" style="margin: 0px !important;">
					<thead>
						<tr>
							<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
								<font id="txtEntriesHouseRules" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
								<input id="txtPageHouseRules" type="hidden">
								<ul id="ulPageHouseRules" class="pagination pull-right"></ul>
							</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="col-md-3 refHouseRules divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-cog light-green bigger-130"></i>&nbsp; Option
            </h5>
        </div>
        <div class="space-4"></div>
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12"> Code:</label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control txtHouseRules ThisIsForCodes" id="txtHouseRulesCode" readonly>
			</div>
		</div>

		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Violation:</label>
			<div class="col-md-12 col-xs-12">
				<textarea class="form-control txtHouseRules" readonly style="resize: none;" id="txtHouseRulesViolation" maxlength="255"></textarea>
			</div>
		</div>

		<!-- FIRST OFFENSE -->
		<fieldset>
			<legend>1st Offense</legend>

			<div class="row form-group">
				<label class="control-label col-md-12 col-xs-12">Description:</label>
				<div class="col-md-12 col-xs-12">
					<input type="text" class="form-control txtHouseRules" id="txtHouseRules1stoffense" readonly maxlength="255">
				</div>
			</div>

			<div class="row form-group">
				<label class="control-label col-md-12 col-xs-12">Fine:</label>
				<div class="col-md-12 col-xs-12">
					<input type="text" class="txthrfine form-control txtHouseRules numberslang 1stWV_amt" id="txtHouseRules1stfine" readonly maxlength="10" style="text-align: right;">
				</div>
			</div>
		</fieldset>

		<!-- 2nd -->
		<fieldset>
			<legend>2nd Offense</legend>
			<div class="row form-group">
				<label class="control-label col-md-12 col-xs-12">Description:</label>
				<div class="col-md-12 col-xs-12">
					<input type="text" class="form-control txtHouseRules" id="txtHouseRules2ndoffense" readonly maxlength="255">
				</div>
			</div>

			<div class="row form-group">
				<label class="control-label col-md-12 col-xs-12">Fine:</label>
				<div class="col-md-12 col-xs-12">
					<input type="text" class="txthrfine form-control txtHouseRules numberslang 2ndWV_amt" id="txtHouseRules2ndfine" readonly maxlength="10" style="text-align: right;">
				</div>
			</div>
		</fieldset>

		<!-- 3rd -->
		<fieldset>
			<legend>3rd Offense</legend>
			<div class="row form-group">
				<label class="control-label col-md-12 col-xs-12">Description:</label>
				<div class="col-md-12 col-xs-12">
					<input type="text" class="form-control txtHouseRules" id="txtHouseRules3rdoffense" readonly maxlength="255">
				</div>
			</div>

			<div class="row form-group">
				<label class="control-label col-md-12 col-xs-12">Fine:</label>
				<div class="col-md-12 col-xs-12">
					<input type="text" class="txthrfine form-control txtHouseRules numberslang 3rdWV_amt" id="txtHouseRules3rdfine" readonly maxlength="10" style="text-align: right;">
				</div>
			</div>
		</fieldset>

		<!-- succeeding -->
		<fieldset>
			<legend>Succeeding</legend>
			<div class="row form-group">
				<label class="control-label col-md-12 col-xs-12">Description:</label>
				<div class="col-md-12 col-xs-12">
					<input type="text" class="form-control txtHouseRules" id="txtHouseRulesSucceeding" readonly maxlength="255">
				</div>
			</div>

			<div class="row form-group">
				<label class="control-label col-md-12 col-xs-12">Fine:</label>
				<div class="col-md-12 col-xs-12">
					<input type="text" class="txthrfine form-control txtHouseRules numberslang SucWV_amt" id="txtHouseRulessucfine" readonly maxlength="10" style="text-align: right;">
				</div>
			</div>
		</fieldset>

		<div class="row form-group" style="margin-top: 10px;">
			<div class="col-md-12">
				<div class="btn-group pull-right" id="buttonsHouseRulesCat">
					<button class="btn btn-primary btn-round btn-sm hide isadmin select-addreferentials" onclick="clickAddHouseRulesCat()"><span class="fa fa-plus"></span> Add</button>
					<button class="btn btn-success btn-round btn-sm hide isadmin select-editreferentials" onclick="clickUpdateHouseRulesCat()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
					<button class="btn btn-danger btn-round btn-sm hide isadmin select-deletereferentials" onclick="clickDeleteHouseRulesCat()"><span class="glyphicon glyphicon-trash"></span> Delete</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="savingbuttonsHouseRulesCat">
					<button class="btn btn-primary btn-round btn-sm" onclick="saveHouseRules()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonHouseRulesCat()"><span class="fa fa-remove"></span> Cancel</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="updatebuttonsHouseRulesCat">
					<button class="btn btn-primary btn-round btn-sm" onclick="updateHouseRulesCat()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonHouseRulesCat2()"><span class="fa fa-remove"></span> Cancel</button>
				</div>
			</div>
		</div>			
	</div>
</div>

<input type="hidden" id="HouseRulescatcounts">
<input type="hidden" id="hiddenequipcatid">
<input type="hidden" id="HouseruleSortType" value="ASC">
<input type="hidden" id="HouseruleSortBy" value="violation">
<?php include("script.php"); ?>
<style type="text/css">
	fieldset {
		padding: 7px !important;
		border: #ccc solid 1px !important;
		margin-bottom: 10`px;
	}

	legend {
		padding: 3px !important;
		margin: 3px !important;
		border: 0 !important;
	}

	legend {
		width: auto !important;
		margin-bottom: 0 !important;
		font-size: 12px !important;
		border-bottom: 0px !important;
	}
</style>