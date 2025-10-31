<div class="container-fluid modules" id="main_SCSE" style="display:none;">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="container-fluid">
				<div class="form-horizontal"> 
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
							<input type="text" class="form-control" id="txtsearchscseCat" onkeyup="showmainscse2()">
						</div>
					</div>
				</div> 
			</div>
		</div>

		<div class="panel-body" style="min-height: 300px;">
			<div class="container-fluid">
				<table class="table table-bordered table-hover">
					<thead>
						<th>Code</th>
						<th>Description</th>
						<th>Floor</th>
						<th>Branch Name</th>
						<th>Status</th>
					</thead>

					<tbody id="tblSCSE_category" class="refsss"></tbody>
				</table>
			</div>
		</div>

		<div class="panel-footer">
			<button id="btn-firstscse" onclick="pagescse('first')" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-fast-backward"></span></button>
			<button id="btn-prevscse" onclick="pagescse('prev')" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-backward"></span></button>
			<button id="btn-nextscse" onclick="pagescse('next')" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-forward"></span></button>
			<button id="btn-lastscse" onclick="pagescse('last')" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-fast-forward"></span></button>
		</div>
	</div>

	<hr/>

	<div class="form-horizontal">
		<div class="form-group">
			<label class="control-label col-md-3 col-xs-12"> Code:</label>
			<div class="col-md-5 col-xs-12">
				<input type="text" class="form-control txtscseCat" id="scseCatCode" readonly>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-md-3 col-xs-12">Description:</label>
			<div class="col-md-5 col-xs-12">
				<input type="text" class="form-control txtscseCat" id="scseCatDesc" readonly>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-md-3 col-xs-12"><label class="txtSysBuilding"></label>:</label>
			<div class="col-md-5 col-xs-12">
				<select class="form-control txtscseCat2" id="scseunit" disabled></select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-md-3 col-xs-12">Floor:</label>
			<div class="col-md-5 col-xs-12">
				<select class="form-control txtscseCat2" id="scsefloor" disabled></select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-md-3 col-xs-12">Status:</label>
			<div class="col-md-5 col-xs-12">
				<select class="form-control txtscseCat2" id="scseCatstatus" disabled>
				<option value="">-- Select Status</option>
				<option value="Operational">Operational</option>
				<option value="Non-Operational">Non-Operational</option>
				<option value="Condemned Unit(Not in use)">Condemned Unit(Not in use)</option></select>
			</div>
		</div>
	</div>

	<div class="btn-group pull-left" id="buttonsscseCat">
		<button class="btn btn-primary hide isadmin select-addreferentials" onclick="clickAddscseCat()"><span class="fa fa-plus"></span> Add</button>
		<button class="btn btn-success hide isadmin select-editreferentials" onclick="clickUpdatescseCat()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
		<button class="btn btn-danger hide isadmin select-deletereferentials" onclick="clickDeletescseCat()"><span class="glyphicon glyphicon-trash"></span> Delete</button>
	</div>

	<div class="btn-group pull-left" style="display: none;" id="savingbuttonsscseCat">
		<button class="btn btn-primary" onclick="savescseCat()"><span class="fa fa-check"></span> Save</button>
		<button class="btn btn-danger" onclick="cancelbuttonscseCat()"><span class="fa fa-remove"></span> Cancel</button>
	</div>

	<div class="btn-group pull-left" style="display: none;" id="updatebuttonsscseCat">
		<button class="btn btn-primary" onclick="updatescseCat()"><span class="fa fa-check"></span> Save</button>
		<button class="btn btn-danger" onclick="cancelbuttonscseCat2()"><span class="fa fa-remove"></span> Cancel</button>
	</div>
</div>

<input type="hidden" id="scsecatcounts">
<input type="hidden" id="hiddenscsecatid">
