<div class="col-md-7 refPenalty divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-th-large light-green bigger-130"></i>&nbsp; Penalty
            </h5>
        </div>
        <div class="space-4"></div>
        <div class="row form-group">
			<div class="col-md-10">
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
					<input type="text" class="form-control input-sm" id="txtSearchPenalty">
				</div>
			</div>
			<div class="col-md-2">
				<div class='btn-group pull-right'>
			       <button class='btn btn-info btn-round btn-sm' onclick="$arr = [];$arr.push( 'page='+$('#txtPagePenalty').val() );$arr.push( 'key='+$('#txtSearchPenalty').val() );getheaderprint('<?php echo $_SESSION['MMS-Designation']; ?>','refpenaltyrep',JSON.stringify($arr));" style="cursor: pointer;" data-placement="bottom" title="">Print</button> 
			        <button data-toggle='dropdown' class='btn dropdown-toggle btn-info btn-round btn-sm'>
			            <span class='ace-icon fa fa-caret-down icon-only'></span>
			        </button>
			        <ul class='dropdown-menu pull-right'>
			            <li>
			                <a onclick="AutoConsolidatePenalty();">Export</a>
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
								<th style="width: 20%;">Code<span class="btnsortdash-othpenalty fa fa-sort bigger-130 pull-right" id="PenaltyCode"></span></th>
								<th style="width: 60%;">Penalty<span class="btnsortdash-othpenalty fa fa-sort bigger-130 pull-right" id="PenaltyDesc"></span></th>
								<th style="width: 20%;text-align: right;">Amount<span class="btnsortdash-othpenalty fa fa-sort bigger-130 pull-right" id="Amount"></span></th>
							</tr>
						</thead>
						<tbody id="tblref_Penalty"></tbody>
					</table>
				</div>
				<table class="tabledash_footer table" style="margin: 0px !important;">
					<thead>
					  	<tr>
							<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
								<font id="txtEntriesPenalty" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
								<input id="txtPagePenalty" type="hidden">
							  	<ul id="ulPagePenalty" class="pagination pull-right"></ul>
							</th>
					  	</tr>
					</thead>
			  	</table>
			</div>
		</div>
    </div>
</div>

<div class="col-md-3 refPenalty divReferential hide">
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
				<input type="text" class="form-control refPenalty3 ThisIsForCodes" id="txtPenaltyCode" readonly style="text-transform: uppercase;">
			</div>
		</div>
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Penalty: </label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control refPenalty3 refPenalty2" id="txtPenalty" readonly style="text-transform: capitalize;">
			</div>
		</div>
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Amount: </label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control refPenalty3 refPenalty2" id="txtPenaltyAmount" readonly style="text-align: right;">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-12">
				<div class="btn-group pull-right" id="btnMainPenalty">
					<button class="btn btn-primary btn-round btn-sm hide isadmin select-addreferentials" onclick="fncClickAddPenalty()"><span class="fa fa-plus"></span> Add</button>
					<button class="btn btn-success btn-round btn-sm hide isadmin select-editreferentials" onclick="fncClickUpdatePenalty()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
					<button class="btn btn-danger btn-round btn-sm hide isadmin select-deletereferentials" onclick="fncClickDeletePenalty()"><span class="glyphicon glyphicon-trash"></span> Delete</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="btnSavePenalty">
					<button class="btn btn-primary btn-round btn-sm" onclick="fncSavePenalty()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="fncCancelBtnPenalty()"><span class="fa fa-remove"></span> Cancel</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="btnUpdatePenalty">
					<button class="btn btn-primary btn-round btn-sm" onclick="fncUpdatePenalty()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="fncCancelBtnPenalty2()"><span class="fa fa-remove"></span> Cancel</button>
				</div>
			</div>
		</div>
    </div>
</div>

<input type="hidden" id="hidPenaltyCount">
<input type="hidden" id="HiddenPenaltyID">
<input type="hidden" id="othPenaltySortType" value="ASC">
<input type="hidden" id="othPenaltySortBy" value="PenaltyCode">
<?php include("script.php"); ?>