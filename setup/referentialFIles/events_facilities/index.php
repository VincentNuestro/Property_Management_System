<div class="col-md-7 refFacilities divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-th-large light-green bigger-130"></i>&nbsp; Services & Facilities
            </h5>
        </div>
        <div class="space-4"></div>
		<div class="row form-group">
			<div class="col-md-10">
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
					<input type="text" class="form-control input-sm" id="txtSearchFacilities">
				</div>
			</div>
			<div class="col-md-2">
				<div class='btn-group pull-right'>
			       <button class='btn btn-info btn-round btn-sm' onclick="$arr = [];$arr.push( 'page='+$('#txtPageFacilities').val() );$arr.push( 'key='+$('#txtSearchFacilities').val() );getheaderprint('<?php echo $_SESSION['MMS-Designation']; ?>','reffacilitiesrep',JSON.stringify($arr));" style="cursor: pointer;" class=" isadmin select-printfacilities" data-placement="bottom" title="">Print</button> 
			        <button data-toggle='dropdown' class='btn dropdown-toggle btn-info btn-round btn-sm'>
			            <span class='ace-icon fa fa-caret-down icon-only'></span>
			        </button>
			        <ul class='dropdown-menu pull-right'>
			            <li>
			                <a onclick="AutoConsolidateFacilities();">Export</a>
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
								<th style="width: 20%;">Code <span class="btnsortdash-eventsfacilities fa fa-sort bigger-130 pull-right" id="FacilitiesCode"></span></th>
								<th style="width: 60%;">Description <span class="btnsortdash-eventsfacilities fa fa-sort bigger-130 pull-right" id="FacilitiesDesc"></span></th>
								<th style="width: 20%;text-align: right;">Price <span class="btnsortdash-eventsfacilities fa fa-sort bigger-130 pull-right" id="Amount"></span></th>
							</tr>
						</thead>
						<tbody id="tblref_Facilities"></tbody>
					</table>
				</div>
				<table class="tabledash_footer table" style="margin: 0px !important;">
					<thead>
					  	<tr>
							<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
								<font id="txtEntriesFacilities" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
								<input id="txtPageFacilities" type="hidden">
							  	<ul id="ulPageFacilities" class="pagination pull-right"></ul>
							</th>
					  	</tr>
					</thead>
			  	</table>
			</div>
		</div>
	</div>
</div>

<div class="col-md-3 refFacilities divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-cog light-green bigger-130"></i>&nbsp; Option
            </h5>
        </div>
        <div class="space-4"></div>
        <div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Code: </label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control refFacilities3 ThisIsForCodes" id="txtFacilitiesCode" readonly style="text-transform: uppercase;">
			</div>
		</div>
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Facilities: </label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control refFacilities3 refFacilies2" id="txtFacilities" readonly style="text-transform: capitalize;">
			</div>
		</div>
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Price: </label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control refFacilities3 refFacilities2" id="txtFacilitiesAmount" readonly style="text-align: right;">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-12">
				<div class="btn-group pull-right" id="btnMainFacilities">
					<button class="btn btn-primary btn-round btn-sm hide isadmin select-addreferentials" onclick="fncClickAddFacilities()"><span class="fa fa-plus"></span> Add </button>
					<button class="btn btn-success btn-round btn-sm hide isadmin select-editreferentials" onclick="fncClickUpdateFacilities()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
					<button class="btn btn-danger btn-round btn-sm hide isadmin select-deletereferentials" onclick="fncClickDeleteFacilities()"><span class="glyphicon glyphicon-trash"></span> Delete</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="btnSaveFacilities">
					<button class="btn btn-primary btn-round btn-sm" onclick="fncSaveFacilities()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="fncCancelBtnFacilities()"><span class="fa fa-remove"></span> Cancel</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="btnUpdateFacilities">
					<button class="btn btn-primary btn-round btn-sm" onclick="fncUpdateFacilities()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="fncCancelBtnFacilities()"><span class="fa fa-remove"></span> Cancel</button>
				</div>
			</div>
		</div>		
    </div>
</div>

<input type="hidden" id="HiddenFacilitiesID">
<input type="hidden" id="FacilitiesSortType" value="ASC">
<input type="hidden" id="FacilitiesSortBy" value="FacilitiesCode">
<?php include("script.php"); ?>