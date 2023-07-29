<div class="col-md-7 refPromotionalp divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-th-large light-green bigger-130"></i>&nbsp; Promotional Paraphernalias
            </h5>
        </div>
        <div class="space-4"></div>
        <div class="row form-group">
			<div class="col-md-10">
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
					<input type="text" class="form-control input-sm" id="txtSearchPromotionalp">
				</div>
			</div>
			<div class="col-md-2">
				<div class='btn-group pull-right'>
			       <button class='btn btn-info btn-round btn-sm' onclick="$arr = [];$arr.push( 'page='+$('#txtPagePromotionalp').val() );$arr.push( 'key='+$('#txtSearchPromotionalp').val() );getheaderprint('<?php echo $_SESSION['MMS-Designation']; ?>','refPromotionalp',JSON.stringify($arr));" style="cursor: pointer;" class=" isadmin select-printPromotionalp" data-placement="bottom" title="">Print</button> 
			        <button data-toggle='dropdown' class='btn dropdown-toggle btn-info btn-round btn-sm'>
			            <span class='ace-icon fa fa-caret-down icon-only'></span>
			        </button>
			        <ul class='dropdown-menu pull-right'>
			            <li>
			                <a onclick="AutoConsolidatePromotionalp();">Export</a>
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
								<th style="width: 20%;">Code2<span class="btnsortdash-promotionalp fa fa-sort bigger-130 pull-right" id="PromotionalpCode"></span></th>
								<th style="width: 80%;">Description<span class="btnsortdash-promotionalp fa fa-sort bigger-130 pull-right" id="PromotionalpDesc"></span></th>
							</tr>
						</thead>
						<tbody id="tblref_Promotionalp"></tbody>
					</table>
				</div>
				<table class="tabledash_footer table" style="margin: 0px !important;">
					<thead>
					  	<tr>
							<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
								<font id="txtEntriesPromotionalp" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
								<input id="txtPagePromotionalp" type="hidden">
							  	<ul id="ulPagePromotionalp" class="pagination pull-right"></ul>
							</th>
					  	</tr>
					</thead>
			  	</table>
			</div>
		</div>
    </div>
</div>

<div class="col-md-3 refPromotionalp divReferential hide">
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
				<input type="text" class="form-control refPromotionalp3 ThisIsForCodes" id="txtPromotionalpCode" readonly style="text-transform: uppercase;">
			</div>
		</div>
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Description: </label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control refPromotionalp3 refPromotionalp2" id="txtPromotionalp" readonly style="text-transform: capitalize;">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-12">
				<div class="btn-group pull-right" id="btnMainPromotionalp">
					<button class="btn btn-primary btn-round btn-sm hide isadmin select-addreferentials" onclick="fncClickAddPromotionalp()"><span class="fa fa-plus"></span> Add</button>
					<button class="btn btn-success btn-round btn-sm hide isadmin select-editreferentials" onclick="fncClickUpdatePromotionalp()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
					<button class="btn btn-danger btn-round btn-sm hide isadmin select-deletereferentials" onclick="fncClickDeletePromotionalp()"><span class="glyphicon glyphicon-trash"></span> Delete</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="btnSavePromotionalp">
					<button class="btn btn-primary btn-round btn-sm" onclick="fncSavePromotionalp()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="fncCancelBtnPromotionalp()"><span class="fa fa-remove"></span> Cancel</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="btnUpdatePromotionalp">
					<button class="btn btn-primary btn-round btn-sm" onclick="fncUpdatePromotionalp()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="fncCancelBtnPromotionalp()"><span class="fa fa-remove"></span> Cancel</button>
				</div>
			</div>
		</div>
    </div>
</div>

<input type="hidden" id="HiddenPromotionalpID">
<input type="hidden" id="PromotionalpSortType" value="ASC">
<input type="hidden" id="PromotionalpSortBy" value="PromotionalpCode">
<?php include("script.php"); ?>