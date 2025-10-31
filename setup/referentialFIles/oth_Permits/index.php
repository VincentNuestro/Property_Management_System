<div class="col-md-7 refPermits divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-th-large light-green bigger-130"></i>&nbsp; Permits
            </h5>
        </div>
        <div class="space-4"></div>
		<div class="row form-group">
			<div class="col-md-10">
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
					<input type="text" class="form-control input-sm" id="txtsearchTOP">
				</div>
			</div>
			<div class="col-md-2">
				<div class='btn-group pull-right'>
			       <button class='btn btn-info btn-round btn-sm' onclick="$arr = [];$arr.push( 'page='+$('#txtPagePermits').val() );$arr.push( 'key='+$('#txtsearchTOP').val() );getheaderprint('<?php echo $_SESSION['MMS-Designation']; ?>','refpermitsrep',JSON.stringify($arr));" style="cursor: pointer;" data-placement="bottom" title="">Print</button> 
			        <button data-toggle='dropdown' class='btn dropdown-toggle btn-info btn-sm btn-round'>
			            <span class='ace-icon fa fa-caret-down icon-only'></span>
			        </button>
			        <ul class='dropdown-menu pull-right'>
			            <li>
			                <a onclick="AutoConsolidatePermits();">Export</a>
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
								<th>Code<span class="btnsortdash-permits fa fa-sort bigger-130 pull-right" id="PermitCode"></span></th>
								<th>Type of Permit<span class="btnsortdash-permits fa fa-sort bigger-130 pull-right" id="DESCRIPTION"></span></th>
								<!-- <th>Allow Override?</th> -->
							</tr>
						</thead>
						<tbody id="tblref_typeofpermits"></tbody>
					</table>
				</div>
				<table class="tabledash_footer table" style="margin: 0px !important;">
					<thead>
					  	<tr>
							<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
								<font id="txtEntriesPermits" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
								<input id="txtPagePermits" type="hidden">
							  	<ul id="ulPagePermits" class="pagination pull-right"></ul>
							</th>
					  	</tr>
					</thead>
			  	</table>
			</div>
		</div>
	</div>
</div>

<div class="col-md-3 refPermits divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-cog light-green bigger-130"></i>&nbsp; Option
            </h5>
        </div>
        <div class="space-4"></div>
        <!-- <div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Allow Override?</label>
			<div class="col-md-3 col-xs-6">
				<div class="radio">
                    <label>
                        <input name="form-field-radio-permit" type="radio" class="ace overridepermit" value="1" disabled>
                        <span class="lbl">&nbsp;&nbsp;&nbsp;Yes</span>
                    </label>
                 </div>
			</div>
			<div class="col-md-3 col-xs-6">
				<div class="radio">
                    <label>
                        <input name="form-field-radio-permit" type="radio" class="ace overridepermit" value="2" disabled checked>
                        <span class="lbl">&nbsp;&nbsp;&nbsp;No</span>
                    </label>
                 </div>
			</div>
		</div> -->
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Code: </label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control TypeofPermit ThisIsForCodes" id="PermitCode" readonly maxlength="20" style="text-transform: uppercase;">
			</div>
		</div>
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Description: </label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control TypeofPermit" id="PermitDesc" readonly style="text-transform: capitalize;">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-12">
				<div class="btn-group pull-right" id="buttonstypeofpermits">
					<button class="btn btn-primary btn-round btn-sm hide isadmin select-addreferentials" onclick="clickAddtypeofpermits()"><span class="fa fa-plus"></span> Add</button>
					<button class="btn btn-success btn-round btn-sm hide isadmin select-editreferentials" onclick="clickUpdatetypeofpermits()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
					<button class="btn btn-danger btn-round btn-sm hide isadmin select-deletereferentials" onclick="clickDeletetypeofpermits()"><span class="glyphicon glyphicon-trash"></span> Delete</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="savingbuttonstypeofpermits">
					<button class="btn btn-primary btn-round btn-sm" onclick="saveTypeOfPermit()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttontypeofpermits()"><span class="fa fa-remove"></span> Cancel</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="updatebuttonstypeofpermits">
					<button class="btn btn-primary btn-round btn-sm" onclick="updatetypeofpermits()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttontypeofpermits()"><span class="fa fa-remove"></span> Cancel</button>
				</div>
			</div>
		</div>	
    </div>                                                                                          
  </div>

<input type="hidden" id="hiddenTOPID">
<input type="hidden" id="PermitsSortType" value="ASC">
<input type="hidden" id="PermitsSortBy" value="PermitCode">
<?php include("script.php"); ?>