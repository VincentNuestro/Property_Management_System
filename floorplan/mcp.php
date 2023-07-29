<style>
	.ellipsis{
		width: 90%;
		text-overflow: ellipsis;
		overflow: hidden;
		white-space: nowrap;
		display: block;
		margin-bottom: 10px;
	}
</style>
<div class="row">
	<div class="col-xs-12">
		<div>
			<div class="row search-page">
				<div class="col-xs-12">
					<div class="row">
						<div class="col-xs-12 col-sm-3">
							<div class="search-area well well-sm">
								<div class="search-filter-header bg-primary">
									<h5 class="smaller no-margin-bottom">
										<i class="ace-icon fa fa-sliders light-green bigger-130"></i>&nbsp; Refine your Search
									</h5>
								</div>
								<div class="space-10"></div>
								<div>
									<p style="margin-bottom: 4px; margin-left: 2px;">Choose Mall</p>
									<select class="form-control" id="txtmall" onchange="loadwing(this.value);">
									<?php
										$getmall = "SELECT mallid, mallname FROM tblref_mall";
										$mallresult = mysql_query($getmall);
										echo "<option value=''>Choose Mall</option>";
										while($mall = mysql_fetch_array($mallresult)){ 
											echo "<option value='" . $mall[0] . "'>" . $mall[1] . "</option>"; 
										}
									?>
									</select>
									<div class="space-10"></div>
									<p style="margin-bottom: 4px; margin-left: 2px;">Choose Building/Wing</p>
									<select class="form-control" id="txtwing" onchange="loadfloor(this.value);">
										<option value="">Choose Wing</option>
									</select>
									<div class="space-10"></div>
									<p style="margin-bottom: 4px; margin-left: 2px;">Choose Floor</p>
									<select class="form-control" id="txtfloor">
										<option value="">Choose Floor</option>
									</select>
									<div class="space-10"></div>
									<div>
										<p style="display: inline-block; margin-left: 2px;">Unit Type:</p>
										<label style="margin-left: 10px;">
											<input name="txtunittype" type="radio" class="txtunittype ace" value="SET">
											<span class="lbl">&nbsp;&nbsp;SET</span>
										</label>
										<label style="margin-left: 10px;">
											<input name="txtunittype" type="radio" class="txtunittype ace" value="LCA" checked>
											<span class="lbl">&nbsp;&nbsp;LCA</span>
										</label>
									</div>
									<div class="space-10"></div>
									<p style="margin-bottom: 4px; margin-left: 2px;">Search Unit</p>
									<span class="input-icon input-icon-right">
										<input type="text" id="txtsearchunit" class="form-control">
										<i class="ace-icon glyphicon glyphicon-search" style="margin-top: 3px;"></i>
									</span>
									<div class="space-10"></div>
									<button class="btn btn-success btn-round" onClick="filterunit();"><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;Submit Search</button>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-9">
							<div class="row">
								<div class="search-area well col-xs-12">
									<div class="pull-left">
										<b class="text-primary">Display</b>&nbsp;&nbsp;
										<div id="viewlist" class="btn-group btn-overlap" data-toggle="buttons">
											<label id="week" title="Weekly" class="btn btn-sm btn-white btn-success active btn-round">
												<i class="icon-only ace-icon fa fa-calendar"></i>&nbsp;
												<p style="font-size: 13px; margin-bottom: 5px; display: inline-block;">Week</p>
											</label>
											<label id="month" title="Monthly" class="btn btn-sm btn-white btn-grey btn-round">
												<i class="icon-only ace-icon fa fa-calendar"></i>&nbsp;
												<p style="font-size: 13px; margin-bottom: 5px; display: inline-block;">Month</p>
											</label>
											<label id="year" title="Yearly" class="btn btn-sm btn-white btn-grey btn-round">
												<i class="icon-only ace-icon fa fa-calendar"></i>&nbsp;
												<p style="font-size: 13px; margin-bottom: 5px; display: inline-block;">Year</p>
											</label>
										</div>
									</div>
									<div class="pull-right">
										<div id="btn-week" class="btn-group">
											<input type="hidden" id="txtcnt" value="0">
											<button class="btn btn-purple btn-sm btn-round" onClick="weeknav('prev');"><span class="glyphicon glyphicon-chevron-left"></span>&nbsp;&nbsp;Prev</button>
											<button class="btn btn-purple btn-sm btn-round" onClick="weeknav('today');">Current</button>
											<button class="btn btn-purple btn-sm btn-round" onClick="weeknav('next');">Next&nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-right"></span></button>
										</div>
										<div id="btn-month" class="btn-group" style="display: none;">
											<input type="hidden" id="txtmonth" value="<?php echo date("m")-1; ?>">
											<input type="hidden" id="txtyear" value="<?php echo date("Y"); ?>">
											<button class="btn btn-purple btn-sm btn-round" onClick="monthnav('prev');"><span class="glyphicon glyphicon-chevron-left"></span>&nbsp;&nbsp;Prev</button>
											<button class="btn btn-purple btn-sm btn-round" onClick="monthnav('today');">Current</button>
											<button class="btn btn-purple btn-sm btn-round" onClick="monthnav('next');">Next&nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-right"></span></button>
										</div>
										<div id="btn-year" class="btn-group" style="display: none;">
											<input type="hidden" id="txtyear2" value="<?php echo date("Y"); ?>">
											<button class="btn btn-purple btn-sm btn-round" onClick="yearnav('prev');"><span class="glyphicon glyphicon-chevron-left"></span>&nbsp;&nbsp;Prev</button>
											<button class="btn btn-purple btn-sm btn-round" onClick="yearnav('today');">Current</button>
											<button class="btn btn-purple btn-sm btn-round" onClick="yearnav('next');">Next&nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-right"></span></button>
										</div>
									</div>
								</div>
							</div>
							<div style="margin: 5px; margin-top: 0px;">
								<div class="row">
									<div class="col-sm-9">
										<b class="text-primary">Legend:</b>&nbsp;&nbsp;
										<span class="label label-lg label-light arrowed-right">Vacant</span>
										<span class="label label-lg label-warning arrowed-right">Reserved</span>
										<span class="label label-lg label-yellow arrowed-right">Occupied</span>
										<span class="label label-lg label-purple arrowed-right">Maintenance</span>
										<span class="label label-lg label-info arrowed-right">Renewal</span>
										<span class="label label-lg label-danger arrowed-right">For Eviction</span>
										<span class="label label-lg label-grey arrowed-right">Late Payment</span>
									</div>
									<div class="col-sm-3" style="text-align: right;">
										<h6 style="color: #F00;">Click a cell to view details</h6>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6 col-sm-3" style="padding: 0px; padding-left: 15px;">
									<table class="table table-bordered table-hover">
										<thead>
											<tr><th style="height: 60px; border-right: solid 1px #dddddd;">Unit Name</th></tr>
										</thead>
									</table>
									<div id="unitlist0" class="unitlist" style="height: 340px; margin-top: -20px; overflow-y: auto; border-bottom: solid 1px #dddddd; border-left: solid 1px #dddddd;">
										<table class="table table-bordered table-hover">
											<tbody id="unitlist">
											<?php
												$getunit = "";
												if(!isset($_POST["unitid"])){ 
													$getunit = "select a.unitid, a.unitname, a.typeofbusiness, a.buildingname, b.floor, a.status from tblref_unit as a LEFT JOIN tblref_floorsetup as b ON a.floorid = b.floorid"; 
												}else{
													if($_POST["unitid"] == ""){ 
														$getunit = "select a.unitid, a.unitname, a.typeofbusiness, a.buildingname, b.floor, a.status from tblref_unit as a LEFT JOIN tblref_floorsetup as b ON a.floorid = b.floorid"; 
													}else{ 
														$getunit = "select a.unitid, a.unitname, a.typeofbusiness, a.buildingname, b.floor, a.status from tblref_unit as a LEFT JOIN tblref_floorsetup as b ON a.floorid = b.floorid where a.unitid = '" . $_POST["unitid"] . "'"; 
													}
												}
												$unitresult = mysql_query($getunit);
												while($unit = mysql_fetch_array($unitresult)){
													echo "
													<tr id='" . $unit[0] . "'>
														<td style='height: 100px;'>
															<h5 style='margin: 5px;'><a href='#'><span class='glyphicon glyphicon-home'></span>&nbsp;&nbsp;" . $unit[1] . "</a></h5>
															<b style='margin: 0px; margin-left: 25px; margin-top: 0px; font-size: 12px; color: #333;'>&nbsp;" . $unit[2] . "</b>
															<p style='margin: 0px; margin-left: 25px; margin-top: 0px; font-size: 12px; color: #666;'>&nbsp;" . $unit[3] . "</p>
															<p style='margin: 0px; margin-left: 25px; margin-top: 0px; font-size: 12px; color: #666;'>&nbsp;" . $unit[4] . "</p>
														</td>
													</tr>";
												}
											?>
											</tbody>
										</table>
									</div>
								</div>
								<!-- Start Weekly -->
								<div class="col-xs-6 col-sm-9 views" id="weekview" style="padding: 0px; padding-right: 15px;">
									<div class="unitlist" style="overflow-y: hidden; border-right: solid 1px #dddddd;">
										<table class="table table-bordered table-hover" style="width: 980px;">
											<thead id="weekcont1"></thead>
										</table>
										<div id="unitlist1" style="height: 340px; width: 980px; margin-top: -20px; overflow-y: hidden; overflow-x: hidden; border-bottom: solid 1px #dddddd;">
											<table class="table table-bordered table-hover" style="width: 980px;">
												<tbody id="weekcont2"></tbody>
											</table>
										</div>
									</div>
								</div>
								<!-- End Weekly -->
								<!-- Start Monthly -->
								<div class="col-sm-9 views" id="monthview" style="padding: 0px; padding-right: 15px; display: none;">
									<div class="unitlist" style="overflow-y: hidden; border-right: solid 1px #dddddd;">
										<table class="table table-bordered table-hover" id="monthcont0_1">
											<thead id="monthcont1"></thead>
										</table>
										<div id="unitlist2" style="height: 340px; margin-top: -20px; overflow-x: hidden; overflow-y: hidden; border-bottom: solid 1px #dddddd;">
											<table class="table table-bordered table-hover" id="monthcont0_2">
												<tbody id="monthcont2"></tbody>
											</table>
										</div>
									</div>
								</div>
								<!-- End Monthly -->
								<!-- Start Yearly -->
								<div class="col-sm-9 views" id="yearview" style="padding: 0px; padding-right: 15px; display: none;">
									<div class="unitlist" style="overflow-y: hidden; border-right: solid 1px #dddddd;">
										<table class="table table-bordered table-hover" style="width: 2400px;">
											<thead id="yearcont1"></thead>
										</table>
										<div id="unitlist3" style="height: 340px; width: 2400px; margin-top: -20px; overflow-x: hidden;  overflow-y: hidden; border-bottom: solid 1px #dddddd;">
											<table class="table table-bordered table-hover" style="width: 2400px;">
												<tbody id="yearcont2"></tbody>
											</table>
										</div>
									</div>
								</div>
								<!-- End Yearly -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade fade-scale" role="dialog" id="viewtenant">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
            	<h4 class="modal-title" style="font-size: 18px;">Tenant Information</h4>
			</div>
			<div class="modal-body">
				<div id="accordion" class="accordion-style1 panel-group">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true"><i class="bigger-110 ace-icon fa fa-angle-down" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>&nbsp;Tenant Information</a>
							</h4>
						</div>
						<div class="panel-collapse collapse in" id="collapseOne" aria-expanded="true">
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-4"><p><span class="glyphicon glyphicon-tag"></span>&nbsp;&nbsp;Tenant Name</p></div>
									<div class="col-sm-8"><p style="font-weight: 400; color: #666;" id="ltenantname"></p></div>
								</div>
								<div class="row">
									<div class="col-sm-4"><p><span class="glyphicon glyphicon-bookmark"></span>&nbsp;&nbsp;Industry</p></div>
									<div class="col-sm-8"><p style="font-weight: 400; color: #666;" id="lindustry"></p></div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false"><i class="bigger-110 ace-icon fa fa-angle-right" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>&nbsp;Residential Unit</a>
							</h4>
						</div>
						<div class="panel-collapse collapse" id="collapseTwo" aria-expanded="false" style="height: 0px;">
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-4"><p><span class="glyphicon glyphicon-tag"></span>&nbsp;&nbsp;Unit Name</p></div>
									<div class="col-sm-8"><p style="font-weight: 400; color: #666;" id="lunitname"></p></div>
								</div>
								<div class="row">
									<div class="col-sm-4"><p><span class="glyphicon glyphicon-bookmark"></span>&nbsp;&nbsp;Mall</p></div>
									<div class="col-sm-8"><p style="font-weight: 400; color: #666;" id="lmall"></p></div>
								</div>
								<div class="row">
									<div class="col-sm-4"><p><span class="glyphicon glyphicon-bookmark"></span>&nbsp;&nbsp;Bldg./Wing</p></div>
									<div class="col-sm-8"><p style="font-weight: 400; color: #666;" id="lwing"></p></div>
								</div>
								<div class="row">
									<div class="col-sm-4"><p><span class="glyphicon glyphicon-bookmark"></span>&nbsp;&nbsp;Floor</p></div>
									<div class="col-sm-8"><p style="font-weight: 400; color: #666;" id="lfloor"></p></div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false"><i class="bigger-110 ace-icon fa fa-angle-right" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>&nbsp;Term</a>
							</h4>
						</div>
						<div class="panel-collapse collapse" id="collapseThree" aria-expanded="false" style="height: 0px;">
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-4"><p><span class="glyphicon glyphicon-calendar"></span>&nbsp;&nbsp;Start Date</p></div>
									<div class="col-sm-8"><p style="font-weight: 400; color: #666;" id="lstartdate"></p></div>
								</div>
								<div class="row">
									<div class="col-sm-4"><p><span class="glyphicon glyphicon-calendar"></span>&nbsp;&nbsp;End Date</p></div>
									<div class="col-sm-8"><p style="font-weight: 400; color: #666;" id="lenddate"></p></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="pull-right">
					<button class="btn btn-light btn-round btn-sm">Close&nbsp;&nbsp;<span class="glyphicon glyphicon-remove"></span></button>
				</div>
				<br><br>
			</div>
		</div>
	</div>
</div>
<?php include("calendarscript.php"); ?>