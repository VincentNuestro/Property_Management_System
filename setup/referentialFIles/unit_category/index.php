<div class="col-md-7 refCategory divReferential <?php if(SysLeaseSetup('isClassification') == '0' && SysLeaseSetup('isDepartment') == '0' && SysLeaseSetup('isCategory') == '1'){ ?>  <?php }else{ ?> hide <?php } ?>">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-th-large light-green bigger-130"></i>&nbsp; Category
            </h5>
        </div>
        <div class="space-4"></div>
		<div class="row form-group">
			<!-- referentialreportsruth -->
			<div class="col-md-10">
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
					<input type="text" class="form-control input-sm" id="txtsearchCat">
				</div>
			</div>
			<div class="col-md-2">
				<div class='btn-group pull-right'>
			       <button class='btn btn-info btn-round btn-sm' onclick="$arr = [];$arr.push( 'page='+$('#txtPageCategory').val() );$arr.push( 'key='+$('#txtsearchCat').val() );getheaderprint('<?php echo $_SESSION['MMS-Designation']; ?>','refunitcategoryrep',JSON.stringify($arr));" style="cursor: pointer;" data-placement="bottom" title="">Print</button> 
			        <button data-toggle='dropdown' class='btn dropdown-toggle btn-info btn-round btn-sm'>
			            <span class='ace-icon fa fa-caret-down icon-only'></span>
			        </button>
				    <ul class='dropdown-menu pull-right'>
				        <li>
				            <a onclick="AutoConsolidateUnitCategory();">Export</a>
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
								<th>Code2 <span class="btnsortdash-unitCategory fa fa-sort bigger-130 pull-right" id="categoryID"> </span> </th>
								<?php if(SysLeaseSetup('isClassification') == "1" && SysLeaseSetup('isDepartment') == "0"){ ?> 
									<th>Classification <span class="btnsortdash-unitCategory fa fa-sort bigger-130 pull-right" id="unitcatclass"> </span></th> 
								<?php }else{ ?>
									<?php if(SysLeaseSetup('isDepartment') == "1"){ ?>
									<th>Department2 <span class="btnsortdash-unitCategory fa fa-sort bigger-130 pull-right" id="unitdepartment"></th> 
									<?php } ?>
								<?php } ?>
								<th>Description2 <span class="btnsortdash-unitCategory fa fa-sort bigger-130 pull-right" id="unitdesc"></th>
							</tr>
						</thead>
						<tbody id="tblref_merchandisedep_cat"></tbody>
					</table>
				</div>
				<table class="tabledash_footer table" style="margin: 0px !important;">
					<thead>
					  	<tr>
							<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
								<font id="txtEntriesCategory" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
								<input id="txtPageCategory" type="hidden">
							  	<ul id="ulPageCategory" class="pagination pull-right"></ul>
							</th>
					  	</tr>
					</thead>
			  	</table>
			</div>
		</div>
	</div>
</div>

<div class="col-md-3 refCategory divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-cog light-green bigger-130"></i>&nbsp; Option
            </h5>
        </div>
        <div class="space-4"></div>
        <?php if(SysLeaseSetup('isClassification') == "1" && SysLeaseSetup('isDepartment') == "0"){ ?>
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12"> Classification:</label>
			<div class="col-md-12 col-xs-12">
				<select class="form-control txtCat searchy_select" id="catclassID" disabled></select>
			</div>
		</div>
		<?php }else{ ?>
			<?php if(SysLeaseSetup('isDepartment') == "1"){ ?>
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12"> Department:</label>
			<div class="col-md-12 col-xs-12">
				<select class="form-control txtCat searchy_select" id="deptId" disabled></select>
			</div>
		</div>
			<?php } ?>
		<?php } ?>
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12"> Code:</label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control txtCat ThisIsForCodes" id="catCode" readonly style="text-transform: uppercase;">
			</div>
		</div>
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Description:</label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control txtCat" id="catDesc" readonly style="text-transform: capitalize;">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-12">
				<div class="btn-group pull-right" id="buttonsCat">
					<button class="btn btn-primary btn-round btn-sm hide isadmin select-addreferentials" onclick="clickAddCat()"><span class="fa fa-plus"></span> Add2</button>
					<button class="btn btn-success btn-round btn-sm hide isadmin select-editreferentials" onclick="clickUpdateCat()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
					<button class="btn btn-danger btn-round btn-sm hide isadmin select-deletereferentials" onclick="clickDeleteCat()"><span class="glyphicon glyphicon-trash"></span> Delete</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="savingbuttonsCat">
					<button class="btn btn-primary btn-round btn-sm" onclick="saveCat()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonCat()"><span class="fa fa-remove"></span> Cancel</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="updatebuttonsCat">
					<button class="btn btn-primary btn-round btn-sm" onclick="updateCat()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonCat()"><span class="fa fa-remove"></span> Cancel</button>
				</div>
			</div>
		</div>
    </div>
</div>

<input type="hidden" id="hiddencatid">
<input type="hidden" id="UnitCategorySortType" value="ASC">
<input type="hidden" id="UnitCategorySortBy" value="categoryID">
<?php include("script.php"); ?>