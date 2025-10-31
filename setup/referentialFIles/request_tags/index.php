<?php	include "../../../connect.php"; ?>
<div class="col-md-7 refRequestTags divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-th-large light-green bigger-130"></i>&nbsp; Request Tags
            </h5>
        </div>
        <div class="space-4"></div>
        <div class="row form-group">
			<div class="col-md-12">
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
					<input type="text" class="form-control" id="txtsearchRequestTags">
				</div>
			</div>
		</div>
		<div class="row form-group" style="margin-top: -10px;">
			<div class="col-md-12">
				<div style="height: 70vh;">
					<table class="table table-bordered table-hover fixTable">
						<thead>
							<tr>
								<th>Code2 <span class="btnsortdash-requesttag fa fa-sort bigger-130 pull-right" id="reqTagCode"></span></th>
								<th>Category<span class="btnsortdash-requesttag fa fa-sort bigger-130 pull-right" id="reqCatDesc"></span></th>
								<th>Description<span class="btnsortdash-requesttag fa fa-sort bigger-130 pull-right" id="reqTagDesc"></span></th>
								<th>Approval<span class="btnsortdash-requesttag fa fa-sort bigger-130 pull-right" id="reqTagAppr"></span></th>							
							</tr>
						</thead>
						<tbody id="tblref_RequestTags"></tbody>
					</table>
				</div>
				<table class="tabledash_footer table" style="margin: 0px !important;">
					<thead>
					  	<tr>
							<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
								<font id="txtEntriesRequestTags" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
								<input id="txtPageRequestTags" type="hidden">
							  	<ul id="ulPageRequestTags" class="pagination pull-right"></ul>
							</th>
					  	</tr>
					</thead>
			  	</table>
			</div>
		</div>
    </div>
</div>

<div class="col-md-3 refRequestTags divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-cog light-green bigger-130"></i>&nbsp; Option
            </h5>
        </div>
        <div class="space-4"></div>
        <div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Request Category:</label>
			<div class="col-md-12 col-xs-12">					
				<select class="form-control selectTags searchy_select" id="RequestTagsCat" disabled></select>
			</div>
		</div>
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12"> Code:</label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control txtRequestTags ThisIsForCodes" id="RequestTagsCode" readonly style="text-transform: uppercase;">
			</div>
		</div>
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Description:</label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control txtRequestTags ThisIsForCodes" id="RequestTagsDesc" readonly style="text-transform: capitalize;">
			</div>
		</div>
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Requires Approval?</label>
			<div class="col-md-3 col-xs-6">
				<div class="radio">
                    <label>
                        <input name="form-field-radio-permit" type="radio" class="ace RequestTagsAppr" value="1" disabled>
                        <span class="lbl">&nbsp;&nbsp;&nbsp;Yes</span>
                    </label>
                 </div>
			</div>
			<div class="col-md-3 col-xs-12">
				<div class="radio">
                    <label>
                        <input name="form-field-radio-permit" type="radio" class="ace RequestTagsAppr" value="0" disabled checked>
                        <span class="lbl">&nbsp;&nbsp;&nbsp;No</span>
                    </label>
                 </div>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-12">
				<div class="btn-group pull-right" id="buttonsRequestTags">
					<button class="btn btn-primary btn-round btn-sm hide isadmin select-addreferentials" onclick="clickAddRequestTags()"><span class="fa fa-plus"></span> Add</button>
					
					<button class="btn btn-success btn-round btn-sm hide isadmin select-editreferentials" onclick="clickUpdateRequestTags()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>

					<button class="btn btn-danger btn-round btn-sm hide isadmin select-deletereferentials" onclick="clickDeleteRequestTags()"><span class="glyphicon glyphicon-trash"></span> Delete</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="savingbuttonsRequestTags">
					
					<button class="btn btn-primary btn-round btn-sm" onclick="saveRequestTags()"><span class="fa fa-check"></span> Save</button>

					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonRequestTags()"><span class="fa fa-remove"></span> Cancel</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="updatebuttonsRequestTags">
					<button class="btn btn-primary btn-round btn-sm" onclick="updateRequestTags()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonRequestTags2()"><span class="fa fa-remove"></span> Cancel</button>
				</div>
			</div>
		</div>
    </div>
</div> 

<input type="hidden" id="RequestTagscounts">
<input type="hidden" id="hiddenRequestTagsid">
<input type="hidden" id="RequesttagSortType" value="ASC">
<input type="hidden" id="RequesttagSortBy" value="reqTagDesc">
<?php include("script.php"); ?>