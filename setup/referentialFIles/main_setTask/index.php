<div class="col-md-7 refMainTask divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-th-large light-green bigger-130"></i>&nbsp; Task
            </h5>
        </div>
        <div class="space-4"></div>
		<div class="row form-group">
			<div class="col-md-10">
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
					<input type="text" class="form-control input-sm" id="txtsearchMainTask">
				</div>
			</div>
			<div class="col-md-2">
				<div class='btn-group pull-right'>
			       <button class='btn btn-info btn-round btn-sm' onclick="$arr = [];$arr.push( 'page='+$('#txtPageMainTask').val() );$arr.push( 'key='+$('#txtsearchMainTask').val() );getheaderprint('<?php echo $_SESSION['MMS-Designation']; ?>','refmaintaskrep',JSON.stringify($arr));" style="cursor: pointer;" data-placement="bottom" title="">Print</button> 
			        <button data-toggle='dropdown' class='btn dropdown-toggle btn-info btn-sm btn-round'>
			            <span class='ace-icon fa fa-caret-down icon-only'></span>
			        </button>
			        <ul class='dropdown-menu pull-right'>
			            <li>
			                <a onclick="AutoConsolidateTask();">Export</a>
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
								<th style="width: 20%;">Category <span class="btnsortdash-maintask fa fa-sort bigger-130 pull-right" id="b.category"> </th>
								<th style="width: 25%;">Code <span class="btnsortdash-maintask fa fa-sort bigger-130 pull-right" id="a.taskid"> </th>
								<th style="width: 40%;">Description <span class="btnsortdash-maintask fa fa-sort bigger-130 pull-right" id="a.description"> </th>
								<th style="width: 15%;">Amount <span class="btnsortdash-maintask fa fa-sort bigger-130 pull-right" id="a.amount"> </th>
								<th class="hide" style="width: 15%;">Equipment <span class="btnsortdash-maintask fa fa-sort bigger-130 pull-right" id="a.equipment"></th>
							</tr>
						</thead>
						<tbody id="tblmaintenance_tasklist"></tbody>
					</table>
				</div>
				<table class="tabledash_footer table" style="margin: 0px !important;">
					<thead>
					  	<tr>
							<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
								<font id="txtEntriesMainTask" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
								<input id="txtPageMainTask" type="hidden">
							  	<ul id="ulPageMainTask" class="pagination pull-right"></ul>
							</th>
					  	</tr>
					</thead>
			  	</table>
			</div>
		</div>
	</div>
</div>

<div class="col-md-3 refMainTask divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-cog light-green bigger-130"></i>&nbsp; Option
            </h5>
        </div>
        <div class="space-4"></div>
        <div class="row form-group">
			<label class="control-label col-md-12 col-xs-12"> Category:</label>
			<div class="col-md-12 col-xs-12">
				<select id="taskcat" class="form-control searchy_select" disabled onchange="fncCheckisReading();"></select>
			</div>
		</div>
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12"> Code:</label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control txtSetTask ThisIsForCodes" id="setTaskCode" readonly style="text-transform: uppercase;">
			</div>
		</div>
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Description:</label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control txtSetTask" id="setTaskDesc" readonly style="text-transform: capitalize;">
			</div>
		</div>
		<div class="row form-group isReadingYes">
			<label class="control-label col-md-12 col-xs-12">Amount:</label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control txtSetTask numonly amount" id="setTaskAmount" readonly style="text-align: right;">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-12">
				<div class="btn-group pull-right" id="buttonsSetTask">
					<button class="btn btn-primary btn-round btn-sm hide isadmin select-addreferentials" onclick="clickAddSetTask()"><span class="fa fa-plus"></span> Add</button>
					<button class="btn btn-success btn-round btn-sm hide isadmin select-editreferentials" onclick="clickUpdateSetTask()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
					<button class="btn btn-danger btn-round btn-sm hide isadmin select-deletereferentials" onclick="clickDeleteSetTask()"><span class="glyphicon glyphicon-trash"></span> Delete</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="savingbuttonsSetTask">
					<button class="btn btn-primary btn-round btn-sm" onclick="saveSetTask()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonSetTask()"><span class="fa fa-remove"></span> Cancel</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="updatebuttonsSetTask">
					<button class="btn btn-primary btn-round btn-sm" onclick="updateSetTask()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonSetTask()"><span class="fa fa-remove"></span> Cancel</button>
				</div>
			</div>
		</div>	
    </div>
</div>

<input type="hidden" id="hiddensettaskid">
<input type="hidden" id="MainTaskSortType" value="ASC">
<input type="hidden" id="MainTaskSortBy" value="b.category">
<?php include("script.php"); ?>