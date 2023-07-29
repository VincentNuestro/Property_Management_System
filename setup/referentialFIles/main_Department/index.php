<div class="col-md-7 refEmpDepartment divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-th-large light-green bigger-130"></i>&nbsp; Department
            </h5>
        </div>
        <div class="space-4"></div>
		<div class="row form-group">
			<div class="col-md-10">
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
					<input type="text" class="form-control input-sm" id="txtsearchDepartmentCat">
				</div>
			</div>
			<div class="col-md-2">
				<div class='btn-group pull-right'>
			       <button class='btn btn-info btn-round btn-sm' onclick="$arr = [];$arr.push( 'page='+$('#txtPageMainDepartment').val() );$arr.push( 'key='+$('#txtsearchDepartmentCat').val() );getheaderprint('<?php echo $_SESSION['MMS-Designation']; ?>','refdepartment2',JSON.stringify($arr));" style="cursor: pointer;" data-placement="bottom" title="">Print</button> 
			        <button data-toggle='dropdown' class='btn dropdown-toggle btn-info btn-round btn-sm'>
			            <span class='ace-icon fa fa-caret-down icon-only'></span>
			        </button>
			        <ul class='dropdown-menu pull-right'>
			            <li>
			                <a onclick="AutoConsolidateDepartment();">Export</a>
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
								<th>Code</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody id="tblDepartment_category"></tbody>
					</table>
				</div>
				<table class="tabledash_footer table" style="margin: 0px !important;">
					<thead>
					  	<tr>
							<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
								<font id="txtEntriesMainDepartment" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
								<input id="txtPageMainDepartment" type="hidden">
							  	<ul id="ulPageMainDepartment" class="pagination pull-right"></ul>
							</th>
					  	</tr>
					</thead>
			  	</table>
			</div>
		</div>
	</div>
</div>

<div class="col-md-3 refEmpDepartment divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-cog light-green bigger-130"></i>&nbsp; Option
            </h5>
        </div>
        <div class="space-4"></div>
        <div class="row form-group">
			<label class="control-label col-md-12 col-lg-12"> Code:</label>
			<div class="col-md-12 col-lg-12">
				<input type="text" class="form-control txtDepartmentCat" id="DepartmentCatCode" readonly style="text-transform: uppercase;">
			</div>
		</div>
		<div class="row form-group">
			<label class="control-label col-md-12 col-lg-12">Description:</label>
			<div class="col-md-12 col-lg-12">
				<input type="text" class="form-control txtDepartmentCat" id="DepartmentCatDesc" readonly style="text-transform: capitalize;">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-12">
				<div class="btn-group pull-right" id="buttonsDepartmentCat">
					<button class="btn btn-primary btn-round btn-sm hide isadmin select-addreferentials" onclick="clickAddDepartmentCat()"><span class="fa fa-plus"></span> Add</button>
					<button class="btn btn-success btn-round btn-sm hide isadmin select-editreferentials" onclick="clickUpdateDepartmentCat()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
					<button class="btn btn-danger btn-round btn-sm hide isadmin select-deletereferentials" onclick="clickDeleteDepartmentCat()"><span class="glyphicon glyphicon-trash"></span> Delete</button>
				</div>
				<div class="btn-group pull-right" style="display: none;" id="savingbuttonsDepartmentCat">
					<button class="btn btn-primary btn-round btn-sm" onclick="saveDepartmentCat()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonDepartmentCat()"><span class="fa fa-remove"></span> Cancel</button>
				</div>
				<div class="btn-group pull-right" style="display: none;" id="updatebuttonsDepartmentCat">
					<button class="btn btn-primary btn-round btn-sm" onclick="updateDepartmentCat()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonDepartmentCat2()"><span class="fa fa-remove"></span> Cancel</button>
				</div>
			</div>
		</div>	
    </div>
</div>

<input type="hidden" id="Departmentcatcounts">
<input type="hidden" id="hiddenDepartmentcatid">
<?php include("script.php"); ?>