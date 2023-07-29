<div class="col-md-7 refRequestCategory divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-th-large light-green bigger-130"></i>&nbsp; Request Category
            </h5>
        </div>
        <div class="space-4"></div>
        <div class="row form-group">
			<div class="col-md-12">
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
					<input type="text" class="form-control" id="txtsearchRequestCategory">
				</div>
			</div>
		</div>
		<div class="row form-group" style="margin-top: -10px;">
			<div class="col-md-12">
				<div style="height: 70vh;">
					<table class="table table-bordered table-hover fixTable">
						<thead>
							<tr>
								<th>Code<span class="btnsortdash-requestcat fa fa-sort bigger-130 pull-right" id="reqCatCode"></span></th>
								<th>Description<span class="btnsortdash-requestcat fa fa-sort bigger-130 pull-right" id="reqCatDesc"></span></th>
							</tr>
						</thead>
						<tbody id="tblref_RequestCategory"></tbody>
					</table>
				</div>
				<table class="tabledash_footer table" style="margin: 0px !important;">
					<thead>
					  	<tr>
							<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
								<font id="txtEntriesRequestCategory" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
								<input id="txtPageRequestCategory" type="hidden">
							  	<ul id="ulPageRequestCategory" class="pagination pull-right"></ul>
							</th>
					  	</tr>
					</thead>
			  	</table>
			</div>
		</div>
    </div>
</div>

<div class="col-md-3 refRequestCategory divReferential hide">
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
				<input type="text" class="form-control txtRequestCategory ThisIsForCodes" id="RequestCategoryCode" readonly style="text-transform: uppercase;">
			</div>
		</div>
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Description:</label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control txtRequestCategory ThisIsForCodes" id="RequestCategoryDesc" readonly style="text-transform: capitalize;">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-12">
				<div class="btn-group pull-right" id="buttonsRequestCategory">
					<button class="btn btn-primary btn-round btn-sm hide isadmin select-addreferentials" onclick="clickAddRequestCategory()"><span class="fa fa-plus"></span> Add</button>
					
					<button class="btn btn-success btn-round btn-sm hide isadmin select-editreferentials" onclick="clickUpdateRequestCategory()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>

					<button class="btn btn-danger btn-round btn-sm hide isadmin select-deletereferentials" onclick="clickDeleteRequestCategory()"><span class="glyphicon glyphicon-trash"></span> Delete</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="savingbuttonsRequestCategory">
					
					<button class="btn btn-primary btn-round btn-sm" onclick="saveRequestCategory()"><span class="fa fa-check"></span> Save</button>

					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonRequestCategory()"><span class="fa fa-remove"></span> Cancel</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="updatebuttonsRequestCategory">
					<button class="btn btn-primary btn-round btn-sm" onclick="updateRequestCategory()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonRequestCategory2()"><span class="fa fa-remove"></span> Cancel</button>
				</div>
			</div>
		</div>
    </div>
</div>

<input type="hidden" id="RequestCategorycounts">
<input type="hidden" id="hiddenRequestCategoryid">
<input type="hidden" id="requestcatSortType" value="ASC">
<input type="hidden" id="requestcatSortBy" value="reqCatCode">
<?php include("script.php"); ?>