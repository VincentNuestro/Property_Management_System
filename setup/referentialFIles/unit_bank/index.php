<div class="col-md-7 refBank divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-th-large light-green bigger-130"></i>&nbsp; Bank
            </h5>
        </div>
        <div class="space-4"></div>
        <div class="row form-group">
			<div class="col-md-10">
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
					<input type="text" class="form-control input-sm" id="txtsearchbank">
				</div>
			</div>
			<div class="col-md-2">
				<div class='btn-group pull-right'>
			       <button class='btn btn-info btn-round btn-sm' onclick="$arr = [];$arr.push( 'page='+$('#txtPageBank').val() );$arr.push( 'key='+$('#txtsearchbank').val() );getheaderprint('<?php echo $_SESSION['MMS-Designation']; ?>','refbankrep',JSON.stringify($arr));" style="cursor: pointer;" data-placement="bottom" title="">Print</button> 
			        <button data-toggle='dropdown' class='btn dropdown-toggle btn-info btn-round btn-sm'>
			            <span class='ace-icon fa fa-caret-down icon-only'></span>
			        </button>
			        <ul class='dropdown-menu pull-right'>
			            <li>
			                <a onclick="AutoConsolidateBank();">Export</a>
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
								<th style="width: 30%;">Code<span class="btnsortdash-unitbank fa fa-sort bigger-130 pull-right" id="xCODE"></span></th>
								<th style="width: 70%;">Description<span class="btnsortdash-unitbank fa fa-sort bigger-130 pull-right" id="description"></span></th>
							</tr>
						</thead>
						<tbody id="tblrefbank"></tbody>
					</table>
				</div>
				<table class="tabledash_footer table" style="margin: 0px !important;">
					<thead>
					  	<tr>
							<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
								<font id="txtEntriesBank" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
								<input id="txtPageBank" type="hidden">
							  	<ul id="ulPageBank" class="pagination pull-right"></ul>
							</th>
					  	</tr>
					</thead>
			  	</table>
			</div>
		</div>
    </div>
</div>

<div class="col-md-3 refBank divReferential hide">
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
				<input type="text" class="form-control txtBank ThisIsForCodes" id="bankCode" readonly style="text-transform: uppercase;">
			</div>
		</div>

		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Description:</label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control txtBank" id="bankDesc" readonly style="text-transform: capitalize;">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-12">
				<div class="btn-group pull-right" id="buttonsBank">
					<button class="btn btn-primary btn-round btn-sm hide isadmin select-addreferentials" onclick="clickAddBank()"><span class="fa fa-plus"></span> Add</button>
					<button class="btn btn-success btn-round btn-sm hide isadmin select-editreferentials" onclick="clickUpdateBank()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
					<button class="btn btn-danger btn-round btn-sm hide isadmin select-deletereferentials" onclick="clickDeleteBank()"><span class="glyphicon glyphicon-trash"></span> Delete</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="savingbuttonsBank">
					<button class="btn btn-primary btn-round btn-sm" onclick="saveBank()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonBank()"><span class="fa fa-remove"></span> Cancel</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="updatebuttonsBank">
					<button class="btn btn-primary btn-round btn-sm" onclick="updateBank()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonBank2()"><span class="fa fa-remove"></span> Cancel</button>
				</div>
			</div>
		</div>
    </div>
</div>

<input type="hidden" id="bankcounts">
<input type="hidden" id="hiddenbankid">
<input type="hidden" id="unitBankSortType" value="ASC">
<input type="hidden" id="unitBankSortBy" value="xCODE">
<?php include("script.php"); ?>