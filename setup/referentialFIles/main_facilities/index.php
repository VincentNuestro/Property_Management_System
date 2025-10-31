<div class="container-fluid modules" id="main_Facilities" style="display:none;">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="container-fluid">
				<div class="form-horizontal"> 
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
							<input type="text" class="form-control" id="txtsearchfacilitiesCat" onkeyup="showmainfacilities2()">
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

					<tbody id="tblfacilities_category" class="refsss"></tbody>
				</table>
			</div>
		</div>

		<div class="panel-footer">
			<button id="btn-firstmFacilities" onclick="pagemFacilities('first')" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-fast-backward"></span></button>
			<button id="btn-prevmFacilities" onclick="pagemFacilities('prev')" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-backward"></span></button>
			<button id="btn-nextmFacilities" onclick="pagemFacilities('next')" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-forward"></span></button>
			<button id="btn-lastmFacilities" onclick="pagemFacilities('last')" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-fast-forward"></span></button>
		</div>
	</div>

	<hr/>

	<div class="form-horizontal">
		<div class="form-group">
			<label class="control-label col-md-3 col-xs-12"> Code:</label>
			<div class="col-md-5 col-xs-12">
				<input type="text" class="form-control txtfacilitiesCat" id="facilitiesCatCode" readonly>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-md-3 col-xs-12">Description:</label>
			<div class="col-md-5 col-xs-12">
				<input type="text" class="form-control txtfacilitiesCat" id="facilitiesCatDesc" readonly>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-md-3 col-xs-12"><label class="txtSysBuilding"></label>:</label>
			<div class="col-md-5 col-xs-12">
				<select class="form-control txtfacilitiesCat2" id="facilitiesunit" disabled></select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-md-3 col-xs-12">Floor:</label>
			<div class="col-md-5 col-xs-12">
				<select class="form-control txtfacilitiesCat2" id="facilitiesfloor" disabled></select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-md-3 col-xs-12">Status:</label>
			<div class="col-md-5 col-xs-12">
				<select class="form-control txtfacilitiesCat2" id="facilitiesCatstatus" disabled>
				<option value="">-- Select Status</option>
				<option value="Operational">Operational</option>
				<option value="Non-Operational">Non-Operational</option>
				<option value="Condemned Unit(Not in use)">Condemned Unit(Not in use)</option></select>
			</div>
		</div>
	</div>

	<div class="btn-group pull-left" id="buttonsfacilitiesCat">
		<button class="btn btn-primary hide isadmin select-addreferentials" onclick="clickAddfacilitiesCat()"><span class="fa fa-plus"></span> Add</button>
		<button class="btn btn-success hide isadmin select-editreferentials" onclick="clickUpdatefacilitiesCat()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
		<button class="btn btn-danger hide isadmin select-deletereferentials" onclick="clickDeletefacilitiesCat()"><span class="glyphicon glyphicon-trash"></span> Delete</button>
	</div>

	<div class="btn-group pull-left" style="display: none;" id="savingbuttonsfacilitiesCat">
		<button class="btn btn-primary" onclick="savefacilitiesCat()"><span class="fa fa-check"></span> Save</button>
		<button class="btn btn-danger" onclick="cancelbuttonfacilitiesCat()"><span class="fa fa-remove"></span> Cancel</button>
	</div>

	<div class="btn-group pull-left" style="display: none;" id="updatebuttonsfacilitiesCat">
		<button class="btn btn-primary" onclick="updatefacilitiesCat()"><span class="fa fa-check"></span> Save</button>
		<button class="btn btn-danger" onclick="cancelbuttonfacilitiesCat2()"><span class="fa fa-remove"></span> Cancel</button>
	</div>
</div>

<input type="hidden" id="facilitiescatcounts">
<input type="hidden" id="hiddenfacilitiescatid">
