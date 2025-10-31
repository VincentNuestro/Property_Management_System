<style type="text/css">
ul {
	list-style: none;
	padding: 0;
}

#csvfolders ul li, ul { 
	cursor: hand !important; cursor: pointer !important; 
}
</style>
<div class="page-header">
	<div class="row form-group" style="margin-bottom: 0px;padding-top:10px;background-color: #edf4f8;padding-bottom: 10px;">
		<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">
			<h1 style="font-weight: bold;">TENANT PORTAL</h1>
		</div>
	</div>
</div>
<?php
	session_start();
	$sqlselecttab = "SELECT functionid FROM tblref_usergroupaccess WHERE module = 'tenantportal' AND functionid LIKE '%view%' AND groupid = '". $_SESSION['MMS-Access'] ."' ORDER BY functionid ASC";
	$selecttab = mysql_fetch_array(mysql_query($sqlselecttab, $connection));
	$checkifadmin = mysql_fetch_array(mysql_query("SELECT isAdmin FROM tbluser WHERE userid = '". $_SESSION['MMS-UserID'] ."' ", $connection));

	if($checkifadmin[0] == "1" || $_SESSION['MMS-UserID'] == "GatessoftCorp" || $_SESSION['MMS-UserID'] == "Superuser"){
		$selecttab[0] = "1";
	}else{
		$selecttab[0] = $selecttab[0];
	}
?>
<div class="row">
	<div class="col-md-12">
		<div class="row form-group" style="margin-bottom: 0px;">
			<div class="col-md-2" style="padding-bottom: 5px;padding-left: 0px;">
				<div class="widget-box">
					<div class="widget-header widget-header-flat">
						<h4 class="widget-title">Tenant List</h4>
						<span class="input-icon" style="width: 95%;margin-bottom: 5px;">
							<input type="text" class="form-control" placeholder="Search" title="Search" id="txtSearchTradeTP">
							<i class="ace-icon fa fa-search nav-search-icon"></i>
						</span>
					</div>

					<div class="widget-body" style="height: 46.5em;overflow-y: scroll;overflow-x: hidden;">
						<div class="row">
							 <div class="dd dd-draghandle cont" style="margin-left: 15px;margin-right: 15px;">
								<ol class="dd-list" id="tbltptenantlist"></ol>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-10" style="padding-bottom: 5px;padding-left: 0px;">
				<div class="tabbable">
					<ul class="nav nav-tabs" id="myTab">
						<li class="select-viewtenantportal hide isadmin <?php if($selecttab[0] == "viewtenantportal" || $selecttab[0] == "1"){ echo "active"; } ?>" onclick="ilbethetrigger();">
							<a data-toggle="tab" href="#TenantProfile">
								<i class="green ace-icon fa fa-home bigger-120"></i>
								Tenant Profile
							</a>
						</li>

						<li class="select-filemanagement hide isadmin <?php if($selecttab[0] == "filemanagement"){ echo "active"; } ?>">
							<a data-toggle="tab" href="#filemanager" onclick="csvfolders();">
								<i class="green ace-icon fa fa-home bigger-120"></i>
								File Management
							</a>
						</li>

						<li class="select-salesReport hide isadmin <?php if($selecttab[0] == "salesReport"){ echo "active"; } ?>">
							<a data-toggle="tab" href="#salesReport">
								<i class="green ace-icon fa fa-home bigger-120"></i>
								Daily Sales Report
							</a>
						</li>
					</ul>

					<div class="tab-content" style="min-height: 50em;">
						<div id="TenantProfile" class="tab-pane fade <?php if($selecttab[0] == "viewtenantportal" || $selecttab[0] == "1"){ echo "in active"; } ?> ">
							<div class="row">
								<div class="row form-group">
									<div class="col-md-3">
										<div class="col-xs-12 col-sm-12 center">
											<span class="profile-picture" style="margin-bottom: 5px;">
												<img id="tpProfilePicture" class="img-responsive img-thumbnail">
											</span>

											<div class="row form-group">
												<div class="profile-user-info profile-user-info-striped">
													<div class="profile-info-row">
														<div class="profile-info-name" style="white-space: nowrap;"> Tenant ID </div>

														<div class="profile-info-value">
															<span id="tpTenantID"></span>
														</div>
													</div>

													<div class="profile-info-row">
														<div class="profile-info-name" style="white-space: nowrap;"> Store Code </div>

														<div class="profile-info-value">
															<span id="tpMerchantCode"></span>
														</div>
													</div>

													<div class="profile-info-row">
														<div class="profile-info-name txtSysBuilding" style="white-space: nowrap;"> Branch Name </div>

														<div class="profile-info-value">
															<span id="tpMall"></span>
														</div>
													</div>

													<div class="profile-info-row">
														<div class="profile-info-name"> Unit </div>

														<div class="profile-info-value">
															<span id="tpUnitNumber"></span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-9">
										<div class="col-md-12">
											<h1 class="header blue" id="tpCompanyName"></h1>
										</div>
										<div class="col-md-4">
											<div class="panel panel-danger">
												<div class="panel-heading">
													<div class="row">
														<div class="col-xs-3">
															<i class="fa fa-frown-o fa-5x" style="border-color: black; color: #D15B47;"></i>
														</div> 
														<div class="col-xs-9">
															<span class="infobox-data-number" style="font-family: Roboto; font-size:18pt "><b id="tpComplaintsCount"></b></span>
															<div class="infobox-content" style="font-family: Roboto; font-size:12pt">Pending Complaints</div>
														</div>
														
													</div>
												</div>
												<div class="panel-footer" style="background-color: #D15B47;"></div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="panel panel-info">
												<div class="panel-heading">
													<div class="row">
														<div class="col-xs-3">
															<i class="fa fa-wrench fa-5x" style="border-color: black; color: #428BCA;"></i>
														</div> 
														<div class="col-xs-9">
															<span class="infobox-data-number" style="font-family: Roboto; font-size:18pt "><b id="tpWorkOrderCount"></b></span>
															<div class="infobox-content" style="font-family: Roboto; font-size:12pt">Work Order</div>
														</div>
														
													</div>
												</div>
												<div class="panel-footer" style="background-color: #428BCA;"></div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="panel panel-warning">
												<div class="panel-heading">
													<div class="row">
														<div class="col-xs-3">
															<i class="fa fa-ticket fa-5x" style="border-color: black; color: #FFB752;"></i>
														</div> 
														<div class="col-xs-9">
															<span class="infobox-data-number" style="font-family: Roboto; font-size:18pt "><b id="tpPenaltyCount"></b></span>
															<div class="infobox-content" style="font-family: Roboto; font-size:12pt">Penalty</div>
														</div>
														
													</div>
												</div>
												<div class="panel-footer" style="background-color: #FFB752;"></div>
											</div>
										</div>
										<div class="col-md-12">
											<div id="drilldowngraph"></div>
										</div>
									</div>
								</div>
								<div class="row form-group">
									
								</div>
							</div>
						</div>

						<div id="filemanager" class="tab-pane fade <?php if($selecttab[0] == "filemanagement"){ echo "in active"; } ?> ">
							<div class="row">
								<div class="col-md-12">
									<div class="row form-group">
										<div class="col-md-3" style="height: 36em;">
											<form method="post" name="csvFiles" id="csvFiles">
												<input type="hidden" id="TPTenantID" name="TenantID">
												<div class="search-area well well-sm">
													<div class="search-filter-header bg-primary">
														<h5 class="smaller no-margin-bottom">
															<i class="ace-icon fa fa-sliders light-green bigger-130"></i>
															Upload CSV Files
														</h5>
													</div>
													<div class="space-10"></div>
													<div class="row form-group">
														<div class="col-md-12">
															<b>Select Target Date</b>
														</div>
														<div class="col-md-12">
															<div class="input-group">
																<span class="input-group-addon">
																	<i class="fa fa-calendar bigger-110"></i>
																</span>
																<input class="form-control date-picker" id="txtInputDateCSV" name="txtInputDateCSV" type="text" value='<?php echo date('m/d/Y'); ?>' onchange="ValidateAllFiles();DisableFields();">
															</div>
														</div>
													</div>
													<div class="row form-group" id="maindiv_FileInputDiscount">
														<div class="col-md-12">
															<b>Select File for Discount</b>
														</div>
														<div class="col-md-1">
															<i class="fa fa-check green isValStat" style="font-size: 26px; display: none;" id="iValSuccessDiscount"></i>
															<i class="fa fa-times red isValStat" style="font-size: 26px; display: none;" id="iValFailedDiscount"></i>
														</div>
														<div class="col-md-11" id="div_FileInputDiscount">
															<input type="file" id="txtInputDiscountCSV" name="txtInputDiscountCSV" class="id-input-file" onchange="checkfiletype(this.value, this.id, 'Discount');">
														</div>
													</div>
													<div class="row form-group" id="maindiv_FileInputHourly">
														<div class="col-md-12">
															<b>Select File for Hourly Sales</b>
														</div>
														<div class="col-md-1">
															<i class="fa fa-check green isValStat" style="font-size: 26px; display: none;" id="iValSuccessHourly"></i>
															<i class="fa fa-times red isValStat" style="font-size: 26px; display: none;" id="iValFailedHourly"></i>
														</div>
														<div class="col-md-11" id="div_FileInputHourly">
															<input type="file" id="txtInputHourlyCSV" name="txtInputHourlyCSV" class="id-input-file" onchange="checkfiletype(this.value, this.id, 'Hourly');">
														</div>
													</div>
													<div class="row form-group" id="maindiv_FileInputPayment">
														<div class="col-md-12">
															<b>Select File for Payment</b>
														</div>
														<div class="col-md-1">
															<i class="fa fa-check green isValStat" style="font-size: 26px; display: none;" id="iValSuccessPayment"></i>
															<i class="fa fa-times red isValStat" style="font-size: 26px; display: none;" id="iValFailedPayment"></i>
														</div>
														<div class="col-md-11" id="div_FileInputPayment">
															<input type="file" id="txtInputPaymentCSV" name="txtInputPaymentCSV" class="id-input-file" onchange="checkfiletype(this.value, this.id, 'Payment');">
														</div>
													</div>
													<div class="row form-group" id="maindiv_FileInputCanceled">
														<div class="col-md-12">
															<b>Select File for Returns / Canceled</b>
														</div>
														 <div class="col-md-1">
															<i class="fa fa-check green isValStat" style="font-size: 26px; display: none;" id="iValSuccessCancelled"></i>
															<i class="fa fa-times red isValStat" style="font-size: 26px; display: none;" id="iValFailedCancelled"></i>
														</div>
														<div class="col-md-11" id="div_FileInputCanceled">
															<input type="file" id="txtInputRoCCSV" name="txtInputRoCCSV" class="id-input-file" onchange="checkfiletype(this.value, this.id, 'Canceled');">
														</div>
													</div>
													<div class="row form-group" id="maindiv_FileInputSales">
														<div class="col-md-12">
															<b>Select File for Sales</b>
														</div>
														<div class="col-md-1">
															<i class="fa fa-check green isValStat" style="font-size: 26px; display: none;" id="iValSuccessSales"></i>
															<i class="fa fa-times red isValStat" style="font-size: 26px; display: none;" id="iValFailedSales"></i>
														</div>
														<div class="col-md-11" id="div_FileInputSales">
															<input type="file" id="txtInputSalesCSV" name="txtInputSalesCSV" class="id-input-file" onchange="checkfiletype(this.value, this.id, 'Sales');">
														</div>
													</div>
													<div class="row form-group">
														<div class="col-md-12">
															<button class="btn btn-sm btn-primary btn-block btn-round" id="btnUpload"><i class="fa fa-upload"></i>&nbsp;Upload</button>
														</div>
													</div>
												</div>
											</form>
										</div>
										<div class="col-md-9">
											<div class="row form-group">
												<div class="col-md-12 search-area well well-sm" style="overflow-y: scroll;display: block;height: 40.4em;background-color: #edf4f8;padding-top: 20px;">
													<ul class="tree tree-unselectable tree-folder-select" id="csvfolders"></ul>
												</div>
											</div>
										</div>
										<!-- <div class="col-md-3" style="height: 36em;">
											<div class="search-area well well-sm">
												<div class="search-filter-header bg-primary">
													<h5 class="smaller no-margin-bottom">
														<i class="ace-icon fa fa-sliders light-green bigger-130"></i>
														Consolidate CSV Files
													</h5>
												</div>
												<div class="space-10"></div>
												<div class="row form-group">
													<div class="col-md-12">
														<b>Select Target Month</b>
													</div>
													<div class="col-md-12">
														<select class="form-control" id="txtInputConsoliDate">
															<option value="01">January</option>
															<option value="02">February</option>
															<option value="03">March</option>
															<option value="04">April</option>
															<option value="05">May</option>
															<option value="06">June</option>
															<option value="07">July</option>
															<option value="08">August</option>
															<option value="09">September</option>
															<option value="10">October</option>
															<option value="11">November</option>
															<option value="12">December</option>
														</select>
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-12">
														<button class="btn btn-sm btn-primary btn-block" onclick="ConsolidateCSV();"><i class="fa fa-download"></i>&nbsp;Download</button>
													</div>
												</div>
											</div>
										</div> -->
									</div>
								</div>
							</div>
						</div>


						<!--
							SALES REPORT
							ADDED BY PETER - SEPTEMBER 8, 2019
						-->
						<div id="salesReport" class="tab-pane fade <?php if($selecttab[0] == "salesReport"){ echo "in active"; } ?> ">
							<div class="row">
								<div class="col-md-6">
									<div class="row form-group">

										<div class="col-md-6">
											<div class="input-daterange input-group">
												<input type="text" class="form-control date-picker" id="txtSRdateFrom" value="11/02/2019">
												<span class="input-group-addon">
													<i class="fa fa-exchange"></i>
												</span>
												<input type="text" class="form-control date-picker" id="txtSRdateTo" value="11/02/2019">
											</div>
										</div>

										<div class="col-md-6">
											<button class="btn btn-primary btn-block btn-sm btn-round" onclick="generateSRDate('0')">Generate</button>
										</div>	
									</div>
									<div class="row form-group">
										<div class="col-md-12">
											<div class="parent">
												<table class="table table-bordered fixTable" id="tblMainSalesReport">
													<thead>
														<th>Date</th>
														<th>Daily Sales</th>
													</thead>
													<tbody id="tblsalesReport"></tbody>
												</table>
											</div>
											<h4 class="pull-right">TOTAL SALES: <b id="magkanoHalaga"></b></h4>
											<table class="tabledash_footer table">
												<tr>
													<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
														<ul id="body-pagination" class="pagination"></ul>
														<input type="hidden" id="pgGenerated" value="0">
													</th>
												</tr>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>

						<style type="text/css">
							.numberslang {
								text-align: right;
							}

							#tbltptenantlist .selected {
								border-right: 3px solid #428BCA !important;
							}

							#tblsalesReport .form-control {
								border: 0px;
								background: transparent;
							}

							#magkanoHalaga {
								font-size: 24px;
								font-weight: 800;
							}
						</style>

						<!--
							END SALES REPORT
						-->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="div_forConsolidatedSales" style="display: none;">
	<div class="col-md-12">
		<table style="width: 100%;" id="tblConsolidatedSales">
			<th>fvcCntrctNo</th>
			<th>fvcCntrctNm</th>
			<th>fvcCmpny</th>
			<th>fdtSlsRng1</th>
			<th>fdtSlsRng2</th>
			<th>fnmGTMnthlySlsWthOutVat</th>
			<tbody id="tbodyConsolidatedSales"></tbody>
		</table>
	</div>
</div>
<?php 
	include('script.php');
?>