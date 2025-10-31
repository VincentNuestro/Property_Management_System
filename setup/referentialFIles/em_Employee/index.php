<div class="col-md-10 refEmployee divReferential hide">
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
					<input type="text" class="form-control input-sm" id="txtsearchEmployee">
				</div>
			</div>
			<div class="col-md-2">
				<div class='btn-group pull-right'>
			       	<button class='btn btn-info btn-round btn-sm' onclick="$arr = [];$arr.push( 'page='+$('#txtPageEmployee').val() );$arr.push( 'key='+$('#txtsearchEmployee').val() );getheaderprint('<?php echo $_SESSION['MMS-Designation']; ?>','refemployeerep',JSON.stringify($arr));" style="cursor: pointer;" data-placement="bottom" title="">Print</button> 
			        <button data-toggle='dropdown' class='btn dropdown-toggle btn-info btn-sm btn-round'>
			            <span class='ace-icon fa fa-caret-down icon-only'></span>
			        </button>
			        <ul class='dropdown-menu pull-right'>
			            <li>
			                <a onclick="AutoConsolidateEmployee();">Export</a>
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
								<th>Assigned Building</th>
								<th>Tenant Code</th>
								<th>Employee Code</th>
								<th>Department</th>
								<th>Position</th>
								<th>First Name</th>
								<th>Middle Name</th>
								<th>Last Name</th>
								<th>Status</th>
								<th></th>
							</tr>
						</thead>
						<tbody id="tblEmployee"></tbody>
					</table>
				</div>
				<table class="tabledash_footer table" style="margin: 0px !important;">
					<thead>
					  	<tr>
							<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
								<font id="txtEntriesEmployee" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
								<input id="txtPageEmployee" type="hidden">
							  	<ul id="ulPageEmployee" class="pagination pull-right"></ul>
							</th>
					  	</tr>
					</thead>
			  	</table>
			</div>
		</div>
	</div>
</div>

<div class="col-md-6 refEmployee divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-cog light-green bigger-130"></i>&nbsp; Option
            </h5>
        </div>
        <div class="space-4"></div>
        <div class="row form-group">
			<div class="col-md-6">
                <div class="row form-group">
					<label class="control-label col-md-12 col-xs-12"> Employee Code:</label>
					<div class="col-md-12 col-xs-12">
						<input type="text" class="form-control txtEmployee ThisIsForCodes" id="EmpCode" readonly style="text-transform: uppercase;">
					</div>
				</div>
				<div class="row form-group">
					<label class="control-label col-md-12 col-xs-12">First Name:</label>
					<div class="col-md-12 col-xs-12">
						<input type="text" class="form-control txtEmployee" id="EmpFN" readonly style="text-transform: capitalize;">
					</div>
				</div>
				<div class="row form-group">
					<label class="control-label col-md-12 col-xs-12">Middle Name:</label>
					<div class="col-md-12 col-xs-12">
						<input type="text" class="form-control txtEmployee" id="EmpMN" readonly style="text-transform: capitalize;">
					</div>
				</div>
				<div class="row form-group">
					<label class="control-label col-md-12 col-xs-12">Last Name:</label>
					<div class="col-md-12 col-xs-12">
						<input type="text" class="form-control txtEmployee" id="EmpLN" readonly style="text-transform: capitalize;">
					</div>
				</div>
				<div class="row form-group">
					<label class="control-label col-md-12 col-xs-12">Department:</label>
					<div class="col-md-12 col-xs-12">
						<select class="form-control txtEmployee2 searchy_select" id="EmpDepartment" disabled onchange="showEmpPosition();"></select>
					</div>
				</div>
				<div class="row form-group">
					<label class="control-label col-md-12 col-xs-12">Position:</label>
					<div class="col-md-12 col-xs-12">
						<select class="form-control txtEmployee2 searchy_select" id="EmpPosition" disabled></select>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="row form-group">
                    <div class='col-md-12'>
                        <img height='150' width='100%' id="img_mallinfo" class='thumbnail inline no-margin-bottom' alt='Greenbelt' src='assets/images/noimage5.png' />
                    </div>
                </div>
				<div class="row form-group">
                	<div class="col-md-12">
                        <form name='posting_profilepic' id="posting_profilepic" class='posting_profilepic'>
                            <input type="hidden" id="txtmallid_forms" name="txtmallid_forms">
                            <input id='file_upload' name='attachment_profilepic' class='form-control upload_app_req' type='file' onchange="showimg123();" disabled/>
                        </form>
                    </div>
                </div>
                <div class="row form-group">
					<label class="control-label col-md-12 col-xs-12"> Assigned <label class="txtSysBuilding"></label>:</label>
					<div class="col-md-12 col-xs-12">
						<select class="form-control txtEmployee2 searchy_select" id="txtmall" disabled></select>
					</div>
				</div>
				<div class="row form-group">
					<label class="control-label col-md-12 col-xs-12 thSysTenant"> Tenant:</label>
					<div class="col-md-12 col-xs-12">
						<select class="form-control txtEmployee2 searchy_select" id="txttenantcode" disabled>
							<option value="">-- Select Tenant ID --</option>
						</select>
					</div>
				</div>
				<div class="row form-group hide">
					<label class="control-label col-md-12 col-xs-12">Remarks:</label>
					<div class="col-md-12 col-xs-12">
						<textarea type="text" class="form-control txtEmployee2" id="txtrem" disabled style="resize: none;"></textarea> 
					</div>
				</div>
				<div class="row form-group">
					<label class="control-label col-md-12 col-xs-12">Status:</label>
					<div class="col-md-12 col-xs-12">
						<select class="form-control txtEmployee2 searchy_select" id="showEmpStatus" disabled>
							<option value="">-- Select Status --</option>
							<option value="1">Active</option>
						    <option value="0">Inactive</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-12">
				<div class="btn-group pull-right" id="buttonsEmployee">
					<button class="btn btn-primary btn-round btn-sm hide isadmin select-addreferentials" onclick="clickAddEmployee()"><i class="fa fa-plus"></i> Add</button>
					<button class="btn btn-success btn-round btn-sm hide isadmin select-editreferentials" onclick="clickUpdateEmployee()"><i class="glyphicon glyphicon-pencil"></i> Edit</button>
					<button class="btn btn-danger btn-round btn-sm hide isadmin select-deletereferentials" onclick="clickDeleteEmployee()"><i class="glyphicon glyphicon-trash"></i> Delete</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="savingbuttonsEmployee">
					<button class="btn btn-primary btn-round btn-sm" onclick="saveEmployee()"><i class="fa fa-check"></i> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonEmployee()"><i class="fa fa-remove"></i> Cancel</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="updatebuttonsEmployee">
					<button class="btn btn-primary btn-round btn-sm" onclick="updateEmployee()"><i class="fa fa-check"></i> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonEmployee2()"><i class="fa fa-remove"></i> Cancel</button>
				</div>
			</div>
		</div>			
    </div>
</div>

<input type="hidden" id="Employeecounts">
<input type="hidden" id="hiddenemployeeid">

<?php include("script.php");
include("idshow.php"); ?>