<div class="col-md-7 refPosition divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-th-large light-green bigger-130"></i>&nbsp; Position
            </h5>
        </div>
        <div class="space-4"></div>
		<div class="row form-group">
			<div class="col-md-10">
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
					<input type="text" class="form-control input-sm" id="txtsearchposition">
				</div>
			</div>
			<div class="col-md-2">
				<div class='btn-group pull-right'>
			        <button class='btn btn-info btn-round btn-sm' onclick="$arr = [];$arr.push( 'page='+$('#txtPagePosition').val() );$arr.push( 'key='+$('#txtsearchposition').val() );getheaderprint('<?php echo $_SESSION['MMS-Designation']; ?>','refpositionrep',JSON.stringify($arr));" style="cursor: pointer;" data-placement="bottom" title="">Print</button> 
			        <button data-toggle='dropdown' class='btn dropdown-toggle btn-info btn-sm btn-round'>
			            <span class='ace-icon fa fa-caret-down icon-only'></span>
			        </button>
			        <ul class='dropdown-menu pull-right'>
			            <li>
			                <a onclick="AutoConsolidatePosition();">Export</a>
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
								<th>Department</th>
								<th>Code</th>
								<th>Position</th>
							</tr>
						</thead>
						<tbody id="tblref_companyposition"></tbody>
					</table>
				</div>
				<table class="tabledash_footer table" style="margin: 0px !important;">
					<thead>
					  	<tr>
							<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
								<font id="txtEntriesPosition" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
								<input id="txtPagePosition" type="hidden">
							  	<ul id="ulPagePosition" class="pagination pull-right"></ul>
							</th>
					  	</tr>
					</thead>
			  	</table>
			</div>
		</div>
	</div>
</div>

<div class="col-md-3 refPosition divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-cog light-green bigger-130"></i>&nbsp; Option
            </h5>
        </div>
        <div class="space-4"></div>
        <div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Department:</label>
			<div class="col-md-12 col-xs-12">
				<select class="form-control txtPosition searchy_select" id="deptdesc" disabled> 
					<option value="">-- Select Department --</option>	
				</select>
			</div>
		</div>
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Code:</label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control txtPosition ThisIsForCodes" id="positionCode" readonly>
			</div>
		</div>	
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Position:</label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control txtPosition" id="positionDesc" readonly>
			</div>
		</div>	
		<div class="row form-group">
			<div class="col-md-12">
				<div class="btn-group pull-right" id="buttonsPosition">
					<button class="btn btn-primary btn-round btn-sm hide isadmin select-addreferentials" onclick="clickAddPosition()"><span class="fa fa-plus"></span> Add</button>
					<button class="btn btn-success btn-round btn-sm hide isadmin select-editreferentials" onclick="clickUpdatePosition()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
					<button class="btn btn-danger btn-round btn-sm hide isadmin select-deletereferentials" onclick="clickDeletePosition()"><span class="glyphicon glyphicon-trash"></span> Delete</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="savingbuttonsPosition">
					<button class="btn btn-primary btn-round btn-sm" onclick="savePosition()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonPosition()"><span class="fa fa-remove"></span> Cancel</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="updatebuttonsPosition">
					<button class="btn btn-primary btn-round btn-sm" onclick="updatePosition()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonPosition2()"><span class="fa fa-remove"></span> Cancel</button>
				</div>
			</div>
		</div>	
    </div>
</div>

<input type="hidden" id="positioncounts">
<input type="hidden" id="hiddenpositionid">
<?php include("script.php"); ?>