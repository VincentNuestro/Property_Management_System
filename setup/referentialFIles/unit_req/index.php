<div class="col-md-7 refRequirements divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-th-large light-green bigger-130"></i>&nbsp; Requirements
            </h5>
        </div>
        <div class="space-4"></div>
		<div class="row form-group">
			<div class="col-md-10">
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
					<input type="text" class="form-control input-sm" id="txtsearchreq">
				</div>
			</div>
			<div class="col-md-2">
				<div class='btn-group pull-right'>
			       <button class='btn btn-info btn-round btn-sm' onclick="$arr = [];$arr.push( 'page='+$('#txtPageRequirements').val() );$arr.push( 'key='+$('#txtsearchreq').val() );getheaderprint('<?php echo $_SESSION['MMS-Designation']; ?>','refrequirementsrep',JSON.stringify($arr));" style="cursor: pointer;" data-placement="bottom" title="">Print</button> 
			        <button data-toggle='dropdown' class='btn dropdown-toggle btn-info btn-sm btn-round'>
			            <span class='ace-icon fa fa-caret-down icon-only'></span>
			        </button>
			        <ul class='dropdown-menu pull-right'>
			            <li>
			                <a onclick="AutoConsolidateReq();">Export</a>
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
								<th>Code <span class="btnsortdash-unitreq fa fa-sort bigger-130 pull-right" id="reqCode"> </span> </th>
								<th>Description <span class="btnsortdash-unitreq fa fa-sort bigger-130 pull-right" id="requirements"> </span> </th>
								<!-- <th>Allow Override?</th> -->
							</tr>
						</thead>
						<tbody id="tblref_applicationrequirements"></tbody>
					</table>
				</div>
				<table class="tabledash_footer table" style="margin: 0px !important;">
					<thead>
					  	<tr>
							<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
								<font id="txtEntriesRequirements" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
								<input id="txtPageRequirements" type="hidden">
							  	<ul id="ulPageRequirements" class="pagination pull-right"></ul>
							</th>
					  	</tr>
					</thead>
			  	</table>
			</div>
		</div>
	</div>
</div>

<div class="col-md-3 refRequirements divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-cog light-green bigger-130"></i>&nbsp; Option
            </h5>
        </div>
        <div class="space-4"></div>
		<!-- <div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Allow Override?</label>
			<div class="col-md-4 col-xs-6">
				<div class="radio">
                    <label>
                        <input name="form-field-radio" type="radio" class="ace override" value="1" disabled>
                        <span class="lbl">&nbsp;&nbsp;&nbsp;Yes</span>
                    </label>
                 </div>
			</div>
			<div class="col-md-4 col-xs-6">
				<div class="radio">
                    <label>
                        <input name="form-field-radio" type="radio" class="ace override" value="2" disabled checked>
                        <span class="lbl">&nbsp;&nbsp;&nbsp;No</span>
                    </label>
                 </div>
			</div>
		</div> -->
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Code:</label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control txtReq ThisIsForCodes" id="reqCode" readonly maxlength="20" style="text-transform: uppercase;">
			</div>
		</div>
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Description:</label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control txtReq" id="reqDesc" readonly style="text-transform: capitalize;">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-12">
				<div class="btn-group pull-right" id="buttonsReq">
					<button class="btn btn-primary btn-round btn-sm hide isadmin select-addreferentials" onclick="clickAddReq()"><span class="fa fa-plus"></span> Add</button>
					<button class="btn btn-success btn-round btn-sm hide isadmin select-editreferentials" onclick="clickUpdateReq()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
					<button class="btn btn-danger btn-round btn-sm hide isadmin select-deletereferentials" onclick="clickDeleteReq()"><span class="glyphicon glyphicon-trash"></span> Delete</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="savingbuttonsReq">
					<button class="btn btn-primary btn-round btn-sm" onclick="saveReq()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonReq()"><span class="fa fa-remove"></span> Cancel</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="updatebuttonsReq">
					<button class="btn btn-primary btn-round btn-sm" onclick="updateReq()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonReq()"><span class="fa fa-remove"></span> Cancel</button>
				</div>
			</div>
		</div>	
    </div>
</div>

<input type="hidden" id="hiddenreqid">
<input type="hidden" id="RequirementsSortType" value="ASC">
<input type="hidden" id="RequirementsSortBy" value="reqCode">
<?php include("script.php"); ?>