<div class="col-md-7 refClassification divReferential <?php if(SysLeaseSetup('isClassification') == '0'){ ?> hide <?php } ?>">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-th-large light-green bigger-130"></i>&nbsp; Classification
            </h5>
        </div>
        <div class="space-4"></div>
		<div class="row form-group">
			<div class="col-md-10">
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
					<input type="text" class="form-control input-sm" id="txtsearchunitclass">
				</div>
			</div>
			<div class="col-md-2">
				<div class='btn-group pull-right'>
			       <button class='btn btn-info btn-round btn-sm' onclick="$arr = [];$arr.push( 'page='+$('#txtPageClassification').val() );$arr.push( 'key='+$('#txtsearchunitclass').val() );getheaderprint('<?php echo $_SESSION['MMS-Designation']; ?>','refclassificationrep',JSON.stringify($arr));" style="cursor: pointer;" data-placement="bottom">Print</button> 
			        <button data-toggle='dropdown' class='btn dropdown-toggle btn-info btn-round btn-sm'>
			            <span class='ace-icon fa fa-caret-down icon-only'></span>
			        </button>

			        <ul class='dropdown-menu pull-right'>
			            <li>
			                <a onclick="AutoConsolidateClassification();">Export</a>
			            </li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row form-group" style="margin-top: -10px;">
			<div class="col-md-12">
				<div style="height: 70vh;">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th style="width: 30%;">Code <span class="btnsortdash-unitClass fa fa-sort bigger-130 pull-right" id="classificationID"> </span> </th>
								<th style="width: 70%;">Description <span class="btnsortdash-unitClass fa fa-sort bigger-130 pull-right" id="classification"> </span></th>
							</tr>
						</thead>
						<tbody id="tblref_merchandise_class"></tbody>
					</table>
				</div>
				<table class="tabledash_footer table" style="margin: 0px !important;">
					<thead>
					  	<tr>
							<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
								<font id="txtEntriesClassification" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
								<input id="txtPageClassification" type="hidden">
							  	<ul id="ulPageClassification" class="pagination pull-right"></ul>
							</th>
					  	</tr>
					</thead>
			  	</table>
			</div>
		</div>
	</div>
</div>

<div class="col-md-3 refClassification divReferential <?php if(SysLeaseSetup('isClassification') == '0'){ ?> hide <?php } ?>">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-cog light-green bigger-130"></i>&nbsp; Option
            </h5>
        </div>
        <div class="space-4"></div>
		<div class="row form-group">
			<div class="col-md-12">
				<div class="row form-group">
					<label class="control-label col-md-12 col-xs-12"> Code:</label>
					<div class="col-md-12 col-xs-12">
						<input type="text" class="form-control txtUnitClass ThisIsForCodes" id="classCode" readonly style="text-transform: uppercase;">
					</div>
				</div>

				<div class="row form-group">
					<label class="control-label col-md-12 col-xs-12">Description:</label>
					<div class="col-md-12 col-xs-12">
						<input type="text" class="form-control txtUnitClass" id="classDesc" readonly style="text-transform: capitalize;">
					</div>
				</div>
			</div>
		</div>	
		<div class="row form-group">
			<div class="col-md-12">
				<div class="btn-group pull-right" id="buttonsClass">
					<button class="btn btn-primary btn-round btn-sm hide isadmin select-addreferentials" onclick="clickAddClass()"><span class="fa fa-plus"></span> Add</button>
					<button class="btn btn-success btn-round btn-sm hide isadmin select-editreferentials" onclick="clickUpdateClass()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
					<button class="btn btn-danger btn-round btn-sm hide isadmin select-deletereferentials" onclick="clickDeleteClass()"><span class="glyphicon glyphicon-trash"></span> Delete</button>
				</div>
				<div class="btn-group pull-right" style="display: none;" id="savingbuttonsClass">
					<button class="btn btn-primary btn-round btn-sm" onclick="saveClass()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonClass()"><span class="fa fa-remove"></span> Cancel</button>
				</div>
				<div class="btn-group pull-right" style="display: none;" id="updatebuttonsClass">
					<button class="btn btn-primary btn-round btn-sm" onclick="updateClass()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonClass()"><span class="fa fa-remove"></span> Cancel</button>
				</div>
			</div>
		</div>	
    </div>
</div>

<input type="hidden" id="hiddenclassid">
<input type="hidden" id="ClassificationSortType" value="ASC">
<input type="hidden" id="ClassificationSortBy" value="classificationID">
<?php include("script.php"); ?>