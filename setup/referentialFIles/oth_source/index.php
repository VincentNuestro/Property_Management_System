<div class="col-md-7 refSource divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-th-large light-green bigger-130"></i>&nbsp; Source
            </h5>
        </div>
        <div class="space-4"></div>
		<div class="row form-group">
			<div class="col-md-10">
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
					<input type="text" class="form-control input-sm" id="txtSearchSource">
				</div>
			</div>
			<div class="col-md-2">
				<div class='btn-group pull-right'>
			       <button class='btn btn-info btn-round btn-sm' onclick="$arr = [];$arr.push( 'page='+$('#txtPageSource').val() );$arr.push( 'key='+$('#txtSearchSource').val() );getheaderprint('<?php echo $_SESSION['MMS-Designation']; ?>','refsourcerep',JSON.stringify($arr));" style="cursor: pointer;" data-placement="bottom" title="">Print</button> 
			        <button data-toggle='dropdown' class='btn dropdown-toggle btn-info btn-sm btn-round'>
			            <span class='ace-icon fa fa-caret-down icon-only'></span>
			        </button>
			        <ul class='dropdown-menu pull-right'>
			            <li>
			                <a onclick="AutoConsolidateSource();">Export</a>
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
								<th>Code <span class="btnsortdash-source fa fa-sort bigger-130 pull-right" id="source_code"> </th>
								<th>Description <span class="btnsortdash-source fa fa-sort bigger-130 pull-right" id="source_desc"> </th>
							</tr>
						</thead>
						<tbody id="tblrefSource"></tbody>
					</table>
				</div>
				<table class="tabledash_footer table" style="margin: 0px !important;">
					<thead>
					  	<tr>
							<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
								<font id="txtEntriesSource" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
								<input id="txtPageSource" type="hidden">
							  	<ul id="ulPageSource" class="pagination pull-right"></ul>
							</th>
					  	</tr>
					</thead>
			  	</table>
			</div>
		</div>
	</div>
</div>

<div class="col-md-3 refSource divReferential hide">
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
				<input type="text" class="form-control txtSource ThisIsForCodes" id="txtSourceCode" readonly maxlength="20" style="text-transform: uppercase;">
			</div>
		</div>
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Description: </label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control txtSource" id="txtSourceDesc" readonly style="text-transform: capitalize;">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-12">
				<div class="btn-group pull-right" id="buttonsSource">
					<button class="btn btn-primary btn-round btn-sm hide isadmin select-addreferentials" onclick="clickAddSource()"><span class="fa fa-plus"></span> Add</button>
					<button class="btn btn-success btn-round btn-sm hide isadmin select-editreferentials" onclick="clickUpdateSource()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
					<button class="btn btn-danger btn-round btn-sm hide isadmin select-deletereferentials" onclick="clickDeleteSource()"><span class="glyphicon glyphicon-trash"></span> Delete</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="savingbuttonsSource">
					<button class="btn btn-primary btn-round btn-sm" onclick="saveSource()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonSource()"><span class="fa fa-remove"></span> Cancel</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="updatebuttonsSource">
					<button class="btn btn-primary btn-round btn-sm" onclick="updateSource()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonSource()"><span class="fa fa-remove"></span> Cancel</button>
				</div>
			</div>
		</div>	
    </div>
</div>

<input type="hidden" id="hiddenSourceID">
<input type="hidden" id="SourceSortType" value="ASC">
<input type="hidden" id="SourceSortBy" value="source_code">
<?php include("script.php"); ?>