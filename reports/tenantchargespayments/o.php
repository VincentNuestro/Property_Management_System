<div class="row form-group div_GraphView" style="margin-bottom: 0px;">
			<div class="col-md-12" style="padding-bottom: 5px;padding-left: 0px;">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<!-- <h3 class="panel-title">Panel title</h3> -->
					</div>

					<div class="panel-body" id="whole1">
						<div class="col-md-2">
							<div class="row form-group">
								<div class="col-md-12">
									<select class="form-control selectMall" id="txtTSRMallGraph" onchange="fncLoadTenantList();"></select>
								</div>
							</div>
							<div class="row form-group">
								<div class="radio">
									<label style="font-weight: bold;">View :</label>
									<label>
										<input type="radio" name="rdGraphView" id="chkGraphYear" class="ace rdGraphView" onclick="fncYearlyGraph();">
										<span class="lbl" style="color: #666;">&nbsp;Year</span>
									</label>
									<label>
										<input type="radio" name="rdGraphView" id="chkGraphMonth" class="ace rdGraphView" onclick="fncMonthlyGraph();">
										<span class="lbl" style="color: #666;">&nbsp;Month</span>
									</label>
								</div>
								<div class="col-md-12">
									<select class="form-control slcYearlyView" id="slcGraphYear">
										<?php
											for($a = 5; $a >= 1; $a--){
												$timestamp = strtotime('-'. $a .' years');
												$forval1 = date('Y', $timestamp);
												?>
													<option value="<?php echo $forval1; ?>"><?php echo $forval1; ?></option>
												<?php
											}
											?>
												<option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
											<?php						
											for($b = 1; $b <= 5; $b++){
												$timestamp2 = strtotime('+'. $b .' years');
												$forval2 = date('Y', $timestamp2);
												?>
													<option value="<?php echo $forval2; ?>"><?php echo $forval2; ?></option>
												<?php
											}
										?>
									</select>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-12">
									<select class="form-control slcMonthlyView" id="slcGraphMonth">
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
						          	<div class="widget-box">
					                    <div class="widget-header widget-header-flat">
					                        <h4 class="widget-title">Tenant List</h4>
					                        <span class="input-icon" style="width: 100%;">
					                            <input type="text" class="form-control" placeholder="Search" title="Search" id="txtSearchTenant">
					                            <i class="ace-icon fa fa-search nav-search-icon"></i>
					                        </span>
					                    </div>
					                    <div class="widget-body" style="height: 25em;overflow-y: scroll;overflow-x: hidden;">
					                        <div class="row">
					                             <div class="dd dd-draghandle cont" style="margin-left: 15px;margin-right: 15px;">
					                                <ol class="dd-list" id="olTenantList"></ol>
					                            </div>
					                        </div>
					                    </div>
					                </div>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-12">
									<button class="btn btn-primary btn-sm btn-block btn-round" onclick="fncProceedLoadingGraphicalView()"><i class="fa fa-search"></i> Go</button>
								</div>
							</div>
						</div>
						<div class="col-md-10 div_GraphYearly">
							<div class="row form-group">
								<div class="col-sm-6">
	        						<button class="btn btn-info btnTreeMapPrev btn-round" onclick="fncChangePage('prev');" style="display: none;"><span class="fa fa-angle-double-left bigger-150"></span></button>
	        					</div>
								<div class="col-sm-6">
	        						<button class="btn btn-info btnTreeMapNext pull-right btn-round" onclick="fncChangePage('next');" style="display: none;"><span class="fa fa-angle-double-right bigger-150"></span></button>
	        					</div>
	        					<input type="hidden" id="txtTreeMapPageCount">
	        				</div>
	        				<div class="row form-group">
								<div id="divTreeMap"></div>
	        				</div>
	        				<div class="row form-group">
	        					<div id="tblWholeYear">
									<div class="panel panel-primary">
										<div class="panel-heading hidden-xs hidden-sm">
											<div class="container-fluid">
												<div class="col-md-2 col-md-offset-2">
													<b>Month</b>
												</div>
												<div class="col-md-2 text-center">
													<b>Sales</b>
												</div>
												<div class="col-md-2 text-center">
													<b>Discount</b>
												</div>
												<div class="col-md-2 text-center">
													<b>Void</b>
												</div>
											</div>
										</div>
										<div class="panel-body">
											<div id="tblWholeYearSales"></div>
										</div>
										<div class="panel-footer"></div>
									</div>
								</div>
	        				</div>
						</div>
						<div class="col-md-10 div_GraphMonthly">
							<div class="row form-group">
								<div class="col-md-7">
									<div id="divMonthlySales"></div>
								</div>
								<div class="col-md-5 divMonthlySalesBreakdown" style="display: none;">
									<div style="height: 400px;">
										<table class="table table-striped table-bordered fixTable">
											<thead>
												<tr>
													<th style="width: 70%;" id="thListPtype">Payment Type</th>
													<th style="width: 30%;">Amount</th>
												</tr>
											</thead>
											<tbody id="listPtypeAmount"></tbody>
										</table>
									</div>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-12">
									<div id="divDailySales"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>