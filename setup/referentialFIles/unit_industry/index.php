<div class="col-md-7 refIndustry divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-th-large light-green bigger-130"></i>&nbsp; Industry 2
            </h5>
        </div>
        <div class="space-4"></div>
		<div class="row form-group">
			<div class="col-md-10">
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
					<input type="text" class="form-control input-sm" id="txtsearchindustry">
				</div>
			</div>
			<div class="col-md-2">
				<div class='btn-group pull-right'>
				   <button class='btn btn-info btn-round btn-sm' onclick="$arr = [];$arr.push( 'page='+$('#txtPageClassification').val() );$arr.push( 'key='+$('#txtsearchindustry').val() );getheaderprint('<?php echo $_SESSION['MMS-Designation']; ?>','refindustry',JSON.stringify($arr));" style="cursor: pointer;" data-placement="bottom" title="">Print</button> 
				    <button data-toggle='dropdown' class='btn dropdown-toggle btn-info btn-round btn-sm'>
				        <span class='ace-icon fa fa-caret-down icon-only'></span>
				    </button>

				    <ul class='dropdown-menu pull-right'>
				        <li>
				            <a onclick="AutoConsolidateIndustry();">Export</a>
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
								<th>Code <span class="btnsortdash-unitindustry fa fa-sort bigger-130 pull-right" id="Industry_ID"> </span> </th>
								<th>Description <span class="btnsortdash-unitindustry fa fa-sort bigger-130 pull-right" id="industry"> </span> </th>
							</tr>
						</thead>
						<tbody id="tblref_industry"></tbody>
					</table>
				</div>
				<table class="tabledash_footer table" style="margin: 0px !important;">
					<thead>
					  	<tr>
							<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
								<font id="txtEntriesIndustry" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
								<input id="txtPageIndustry" type="hidden">
							  	<ul id="ulPageIndustry" class="pagination pull-right"></ul>
							</th>
					  	</tr>
					</thead>
			  	</table>
			</div>
		</div>
	</div>
</div>

<div class="col-md-3 refIndustry divReferential hide">
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
				<input type="text" class="form-control txtIndustry ThisIsForCodes" id="industryCode" readonly style="text-transform: uppercase;">
			</div>
		</div>
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Description:</label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control txtIndustry" id="industryDesc" readonly style="text-transform: capitalize;">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-12">
				<div class="btn-group pull-right" id="buttonsIndustry">
					<button class="btn btn-primary btn-round btn-sm hide isadmin select-addreferentials" onclick="clickAddIndustry()"><span class="fa fa-plus"></span> Add</button>
					<button class="btn btn-success btn-round btn-sm hide isadmin select-editreferentials" onclick="clickUpdateIndustry()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
					<button class="btn btn-danger btn-round btn-sm hide isadmin select-deletereferentials" onclick="clickDeleteIndustry()"><span class="glyphicon glyphicon-trash"></span> Delete</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="savingbuttonsIndustry">
					<button class="btn btn-primary btn-round btn-sm" onclick="saveIndustry()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonIndustry()"><span class="fa fa-remove"></span> Cancel</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="updatebuttonsIndustry">
					<button class="btn btn-primary btn-round btn-sm" onclick="updateIndustry()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonIndustry()"><span class="fa fa-remove"></span> Cancel</button>
				</div>
			</div>
		</div>	
	</div>
</div>

<div id="div_form_complaints" style="display: none;">
	<table style="width: 100%;" cellspacing="0" cellpadding="0">
        <tbody id="template"></tbody>
    </table>
</div>

<div id="div_form_complaints_content" style="display: none;">
	<table style="width: 100%;" cellspacing="0" cellpadding="0">
        <tbody id="template_content"></tbody>
    </table>
</div>
<input type="hidden" id="industrycounts">
<input type="hidden" id="hiddenindustryid">
<input type="hidden" id="IndustrySortType" value="ASC">
<input type="hidden" id="IndustrySortBy" value="Industry_ID">
<?php include("script.php"); ?>