<div class="col-md-7 refDepartment divReferential <?php if(SysLeaseSetup('isClassification') == '0' && SysLeaseSetup('isDepartment') == '1'){ ?>  <?php }else{ ?> hide <?php } ?>">
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
					<input type="text" class="form-control input-sm" id="txtsearchdept">
				</div>
			</div>
			<div class="col-md-2">
				<div class='btn-group pull-right'>
			       <button class='btn btn-info btn-round btn-sm' onclick="$arr = [];$arr.push( 'page='+$('#txtPageClassification').val() );$arr.push( 'key='+$('#txtsearchunitclass').val() );getheaderprint('<?php echo $_SESSION['MMS-Designation']; ?>','refunitdept',JSON.stringify($arr));" style="cursor: pointer;" data-placement="bottom" title="">Print</button> 
			        <button data-toggle='dropdown' class='btn dropdown-toggle btn-info btn-round btn-sm'>
			            <span class='ace-icon fa fa-caret-down icon-only'></span>
			        </button>

			        <ul class='dropdown-menu pull-right'>
			            <li>
			                <a onclick="AutoConsolidateDepartmentunit();">Export</a>
			            </li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row form-group" style="margin-top: -10px;">
			<div class="col-md-12">
				<div style="height: 70vh;">
					<!-- <table class="table table-bordered table-hover fixTable"> -->
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Code2 <span class="btnsortdash fa fa-sort bigger-130 pull-right" id="departmentID"></span> </th>
								<?php if(SysLeaseSetup('isClassification') == "1"){ ?> <th>Classification  <span class="btnsortdash fa fa-sort bigger-130 pull-right" id="unitdeptclassification"></th> </span><?php } ?>
								<th>Description  <span class="btnsortdash fa fa-sort bigger-130 pull-right" id="unitdeptdesc"> </span></th>
							</tr>
						</thead>
						<tbody id="tblref_merchandise_depa"></tbody>
					</table>
				</div>
				<table class="tabledash_footer table" style="margin: 0px !important;">
					<thead>
					  	<tr>
							<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
								<font id="txtEntriesDepartment" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
								<input id="txtPageDepartment" type="hidden">
							  	<ul id="ulPageDepartment" class="pagination pull-right"></ul>
							</th>
					  	</tr>
					</thead>
			  	</table>
			</div>
		</div>
	</div>
</div>

<div class="col-md-3 refDepartment divReferential <?php if(SysLeaseSetup('isClassification') == '0' && SysLeaseSetup('isDepartment') == '1'){ ?>  <?php }else{ ?> hide <?php } ?>">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-cog light-green bigger-130"></i>&nbsp; Option
            </h5>
        </div>
        <div class="space-4"></div>
        <?php if(SysLeaseSetup('isClassification') == "1"){ ?>
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12"> Classification:</label>
			<div class="col-md-12 col-xs-12">
				<select class="form-control txtDept searchy_select" id="depclassId" disabled>
					<option value=''>-- Select Classification --</option>
				</select>
			</div>
		</div>
		<?php } ?>
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12"> Code:</label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control txtDept ThisIsForCodes" id="deptCode" readonly style="text-transform: uppercase;">
			</div>
		</div>
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Description:</label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control txtDept" id="deptDesc" readonly style="text-transform: capitalize;">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-12">
				<div class="btn-group pull-right" id="buttonsDept">
					<button class="btn btn-primary btn-round btn-sm hide isadmin select-addreferentials" onclick="clickAddDept()"><span class="fa fa-plus"></span> Add2</button>
					<button class="btn btn-success btn-round btn-sm hide isadmin select-editreferentials" onclick="clickUpdateDept()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
					<button class="btn btn-danger btn-round btn-sm hide isadmin select-deletereferentials" onclick="clickDeleteDept()"><span class="glyphicon glyphicon-trash"></span> Delete</button>
				</div>
				<div class="btn-group pull-right" style="display: none;" id="savingbuttonsDept">
					<button class="btn btn-primary btn-round btn-sm" onclick="saveDept()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonDept()"><span class="fa fa-remove"></span> Cancel</button>
				</div>
				<div class="btn-group pull-right" style="display: none;" id="updatebuttonsDept">
					<button class="btn btn-primary btn-round btn-sm" onclick="updateDept()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonDept()"><span class="fa fa-remove"></span> Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="div_form_complaints" style="display: none;">
	<table style="width: 100%;" cellspacing="0" cellpadding="0">
        <tbody id="template"></tbody>
    </table>
</div>

<div id="div_form_complaints_content" style="display: none;">
	<table style="width: 100%;" cellspacing="0" cellpadding="0">
        <tbody id="template_content"></tbody>
    </table>
</div>
<input type="hidden" id="hiddendeptid">
<input type="hidden" id="UnitDepartmentSortType" value="ASC">
<input type="hidden" id="UnitDepartmentSortBy" value="departmentID">
<?php include("script.php"); ?>