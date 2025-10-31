<div class="container-fluid modules" id="unit_FloorPlanMod" style="display:none;">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="container-fluid">
				<div class="form-horizontal">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
							<input type="text" class="form-control" id="txtsearchfloor" onkeyup="displayFloor2()">
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="panel-body" style="min-height: 300px;">
			<div class="container-fluid">
				<table class="table table-bordered table-hover">
					<thead>
						<th>Floor Name</th>
					</thead>

					<tbody id="tblref_floors" class="refsss"></tbody>
				</table>
			</div>
		</div>

		<div class="panel-footer">
			<button id="btn-firstfloorplan" onclick="pagefloorplan('first')" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-fast-backward"></span></button>
			<button id="btn-prevfloorplan" onclick="pagefloorplan('prev')" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-backward"></span></button>
			<button id="btn-nextfloorplan" onclick="pagefloorplan('next')" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-forward"></span></button>
			<button id="btn-lastfloorplan" onclick="pagefloorplan('last')" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-fast-forward"></span></button>
		</div>
	</div>

	<hr/>

	<div class="form-horizontal">
		<div class="form-group">
			<label class="control-label col-md-3 col-xs-12">Floor Name:</label>
			<div class="col-md-5 col-xs-12">
				<input type="text" class="form-control txtPosition" id="FloorDesc" readonly>
			</div>
		</div>
	</div>

	<div class="btn-group pull-left" id="buttonsFloor">
		<button class="btn btn-primary hide isadmin select-addreferentials" onclick="clickAddFloor()"><span class="fa fa-plus"></span> Add</button>
		<button class="btn btn-success hide isadmin select-editreferentials" onclick="clickUpdateFloor()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
		<button class="btn btn-danger hide isadmin select-deletereferentials" onclick="clickDeleteFloor()"><span class="glyphicon glyphicon-trash"></span> Delete</button>
	</div>

	<div class="btn-group pull-left" style="display: none;" id="savingbuttonsFloor">
		<button class="btn btn-primary" onclick="saveFloor()"><span class="fa fa-check"></span> Save</button>
		<button class="btn btn-danger" onclick="cancelbuttonFloor()"><span class="fa fa-remove"></span> Cancel</button>
	</div>

	<div class="btn-group pull-left" style="display: none;" id="updatebuttonsFloor">
		<button class="btn btn-primary" onclick="updateFloor()"><span class="fa fa-check"></span> Save</button>
		<button class="btn btn-danger" onclick="cancelbuttonFloor2()"><span class="fa fa-remove"></span> Cancel</button>
	</div>
</div>

<input type="hidden" id="floorcounts">
<input type="hidden" id="hiddenfloorid">
