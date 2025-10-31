<div class="page-header">
    <div class="row form-group" style="margin-bottom: 0px;padding-top:10px;background-color: #edf4f8;padding-bottom: 10px;">
        <div class="col-md-6">
            <h1 style="font-weight: bold;">DASHBOARD</h1>
        </div>
        <div class="col-md-6">
            <div class="btn-toolbar inline middle no-margin pull-right">
				<div data-toggle="buttons" class="btn-group no-margin">
					<label class="select-viewpage1 isadmin btn btn-sm btn-info active" onclick="SelectDashboardPage(1);" style="margin: 2px;">
						<span class="fa fa-arrow-left bigger-110"></span>
						<input type="radio" value="1">
					</label>

					<label class="select-viewpage2 isadmin btn btn-sm btn-info" onclick="SelectDashboardPage(2);" style="margin: 2px;">
						<span class="fa fa-arrow-right bigger-110"></span>
						<input type="radio" value="2">
					</label>
				</div>
			</div>
        </div>
    </div>
</div>

<div class="row">
	<div class="col-md-12">

		<div class="row form-group" style="margin-bottom: 0px;" id="DashboardPage1">

			<div class="col-md-3" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="panel panel-success" style="border-color: #3f903f;">
                    <div class="panel-heading" style="background-color: #3f903f;color: white;">
                        <div class="row">
                            <div class="col-md-3">
                                <i class="fa fa-phone fa-5x"></i>
                            </div>
                            <div class="col-md-9 text-right">
                                <h1 id="txtInqToday"></h1>
                                <h4>Today's Inquiries</h4>
                            </div>
                        </div>
                    </div>
                    <a href="#" onclick="viewInquiryListToday();">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
			</div>

			<div class="col-md-3" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="panel panel-default" style="border-color: gray;">
                    <div class="panel-heading" style="background-color: gray;color: white;">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-home fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <h1 id="txtUnitAvailable"></h1>
                                <h4>Total Available Units</h4>
                            </div>
                        </div>
                    </div>
                    <a href="#" onclick="viewDashbboardUnits('Vacant');">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
			</div>

			<div class="col-md-3" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-home fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <h1 id="txtUnitTotal"></h1>
                                <h4>Total Reserved Units</h4>
                            </div>
                        </div>
                    </div>
                    <a href="#" onclick="viewDashbboardUnits('Reserved');">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
			</div>

			<div class="col-md-3" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="panel panel-default" style="border-color: #f0ad4e;">
                    <div class="panel-heading" style="background-color: #f0ad4e;color: white;">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-home fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <h1 id="txtUnitOccupied"></h1>
                                <h4>Total Occupied Units</h4>
                            </div>
                        </div>
                    </div>
                    <a href="#" onclick="viewDashbboardUnits('Occupied');">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
			</div>

			<div class="col-md-8" id="widget-container-col-1" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="widget-box widget-color-green2" id="widget-box-1">
					<div class="widget-header">
						<h4 class="widget-title">Monthly Occupancy Report</h4>
						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<i class="ace-icon fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="widget-body">
						<div class="widget-main">
							<div id="div_MonthlyOccupancyReport"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-4" id="widget-container-col-1" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="widget-box widget-color-green2" id="widget-box-1">
					<div class="widget-header">
						<h4 class="widget-title">Occupancy Based on Classification</h4>
						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<i class="ace-icon fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="widget-body">
						<div class="widget-main">
							<div id="div_OccupancyBasedonClassification"></div>
						</div>
					</div>
				</div>

				<div class="widget-box widget-color-green2" id="widget-box-1">
					<div class="widget-header">
						<h4 class="widget-title">Vacancy Based on Classification</h4>
						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<i class="ace-icon fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="widget-body">
						<div class="widget-main">
							<div id="div_VacancyBasedonClassification"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-12 widget-container-col" id="widget-container-col-1" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="widget-box widget-color-green2" id="widget-box-1">
					<div class="widget-header">
						<h4 class="widget-title">Monthly Total Revenue From Lease</h4>
						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<i class="ace-icon fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="widget-body">
						<div class="widget-main">
							<div id="div_MonthlyTotalRevenueFromLease"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-6 widget-container-col" id="widget-container-col-1" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="widget-box widget-color-green2" id="widget-box-1">
					<div class="widget-header">
						<h4 class="widget-title">Monthly Occupancy Report For SET Units</h4>
						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<i class="ace-icon fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="widget-body">
						<div class="widget-main">
							<div id="div_MonthlySET"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-6 widget-container-col" id="widget-container-col-1" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="widget-box widget-color-green2" id="widget-box-1">
					<div class="widget-header">
						<h4 class="widget-title">Monthly Occupancy For LCA Units</h4>
						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<i class="ace-icon fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="widget-body">
						<div class="widget-main">
							<div id="div_MonthlyLCA"></div>
						</div>
					</div>
				</div>
			</div>

		</div>

		<div class="row form-group" style="margin-bottom: 0px;display: none;" id="DashboardPage2">

			<div class="col-md-3" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-3">
                                <i class="fa fa-wrench fa-5x"></i>
                            </div>
                            <div class="col-md-9 text-right">
                                <h1 id="txtNewWO"></h1>
                                <h4>Pending Work Orders</h4>
                            </div>
                        </div>
                    </div>
                    <a href="#" onclick="ViewDashbboardMaintenance('WorkOrders');">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
			</div>

			<div class="col-md-3" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="panel panel-danger" style="border-color: #D15B47;">
                    <div class="panel-heading" style="background-color: #D15B47;color: white;">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-frown-o fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <h1 id="txtNewComplaints"></h1>
                                <h4>Pending Complaints</h4>
                            </div>
                        </div>
                    </div>
                    <a href="#" onclick="ViewDashbboardMaintenance('Complaints');">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
			</div>

			<div class="col-md-3" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="panel panel-default" style="border-color: #f0ad4e;">
                    <div class="panel-heading" style="background-color: #f0ad4e;color: white;">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-ticket fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <h1 id="txtNewIR"></h1>
                                <h4>Pending Incident Reports</h4>
                            </div>
                        </div>
                    </div>
                    <a href="#" onclick="ViewDashbboardMaintenance('IncidentReports');">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
			</div>

			<div class="col-md-3" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="panel panel-success" style="border-color: #3f903f;">
                    <div class="panel-heading" style="background-color: #3f903f; color: white;">
                        <div class="row">
                            <div class="col-xs-2">
                                <i class="fa fa-usd fa-5x"></i>
                            </div>
                            <div class="col-xs-10 text-right">
                                <h1 id="txtTotalMaintenanceExpense"></h1>
                                <h4>Total Maintenance Expense</h4>
                            </div>
                        </div>
                    </div>
                    <a href="#" onclick="ViewDashbboardMaintenance('MainExp');">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
			</div>

			<div class="col-md-3 widget-container-col" id="widget-container-col-1" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="widget-box widget-color-green2" id="widget-box-1">
					<div class="widget-header">
						<h4 class="widget-title">Average TAT of Work Orders</h4>
						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<i class="ace-icon fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="widget-body">
						<div class="widget-main">
							<div id="div_MonthlyATATWO"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-3 widget-container-col" id="widget-container-col-1" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="widget-box widget-color-green2" id="widget-box-1">
					<div class="widget-header">
						<h4 class="widget-title">Average TAT of Complaints</h4>
						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<i class="ace-icon fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="widget-body">
						<div class="widget-main">
							<div id="div_MonthlyATATComplaints"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-3 widget-container-col" id="widget-container-col-1" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="widget-box widget-color-green2" id="widget-box-1">
					<div class="widget-header">
						<h4 class="widget-title">Average TAT of Incident Reports</h4>
						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<i class="ace-icon fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="widget-body">
						<div class="widget-main">
							<div id="div_MonthlyATATIR"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-3 widget-container-col" id="widget-container-col-1" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="widget-box widget-color-green2" id="widget-box-1">
					<div class="widget-header">
						<h4 class="widget-title">Work Order Logs</h4>
						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<i class="ace-icon fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="widget-body">
						<div class="widget-main">
							<div style="height: 400px;">
								<div class="dialogs fixTable">
									<div id="div_WorkOrderLogs"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-4 widget-container-col" id="widget-container-col-1" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="widget-box widget-color-green2" id="widget-box-1">
					<div class="widget-header">
						<h4 class="widget-title">Monthly Work Orders</h4>
						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<i class="ace-icon fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="widget-body">
						<div class="widget-main">
							<div id="div_MonthlyWorkOrders"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-4 widget-container-col" id="widget-container-col-1" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="widget-box widget-color-green2" id="widget-box-1">
					<div class="widget-header">
						<h4 class="widget-title">Monthly Complaints</h4>
						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<i class="ace-icon fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="widget-body">
						<div class="widget-main">
							<div id="div_MonthlyComplaints"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-4 widget-container-col" id="widget-container-col-1" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="widget-box widget-color-green2" id="widget-box-1">
					<div class="widget-header">
						<h4 class="widget-title">Monthly Incident Reports</h4>
						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<i class="ace-icon fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="widget-body">
						<div class="widget-main">
							<div id="div_MonthlyIncidentReports"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-12 widget-container-col" id="widget-container-col-1" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="widget-box widget-color-green2" id="widget-box-1">
					<div class="widget-header">
						<h4 class="widget-title">Previous Budget vs Current Budget</h4>
						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<i class="ace-icon fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="widget-body">
						<div class="widget-main">
							<div id="div_BudgetvsExpense"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-4 widget-container-col" id="widget-container-col-1" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="widget-box widget-color-green2" id="widget-box-1">
					<div class="widget-header">
						<h4 class="widget-title">Monthly Consumption of Electric Report</h4>
						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<i class="ace-icon fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="widget-body">
						<div class="widget-main">
							<div id="div_MonthlyConsumptionofElectricReport"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-4 widget-container-col" id="widget-container-col-1" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="widget-box widget-color-green2" id="widget-box-1">
					<div class="widget-header">
						<h4 class="widget-title">Monthly Consumption of Water Report</h4>
						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<i class="ace-icon fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="widget-body">
						<div class="widget-main">
							<div id="div_MonthlyConsumptionofWaterReport"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-4 widget-container-col" id="widget-container-col-1" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="widget-box widget-color-green2" id="widget-box-1">
					<div class="widget-header">
						<h4 class="widget-title">Monthly Reports On Third Party Contractors</h4>
						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<i class="ace-icon fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="widget-body">
						<div class="widget-main">
							<div id="div_MonthlyReporsOnThirdPartyContractos"></div>
						</div>
					</div>
				</div>
			</div>

		</div>

		<div class="row form-group" style="margin-bottom: 0px;display: none;" id="DashboardPage3">

			<div class="col-md-6 widget-container-col" id="widget-container-col-1" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="widget-box widget-color-green2" id="widget-box-1">
					<div class="widget-header">
						<h4 class="widget-title">Daily Leads For The Month of <?php echo date('F Y'); ?></h4>
						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<i class="ace-icon fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="widget-body">
						<div class="widget-main">
							<div id="div_DailyLeads"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-6 widget-container-col" id="widget-container-col-1" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="widget-box widget-color-green2" id="widget-box-1">
					<div class="widget-header">
						<h4 class="widget-title">Daily Inquiry For The Month of <?php echo date('F Y'); ?></h4>
						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<i class="ace-icon fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="widget-body">
						<div class="widget-main">
							<div id="div_DailyInquiry"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-6 widget-container-col" id="widget-container-col-1" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="widget-box widget-color-green2" id="widget-box-1">
					<div class="widget-header">
						<h4 class="widget-title">Daily Reservation For The Month of <?php echo date('F Y'); ?></h4>
						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<i class="ace-icon fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="widget-body">
						<div class="widget-main">
							<div id="div_DailyReservation"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-6 widget-container-col" id="widget-container-col-1" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="widget-box widget-color-green2" id="widget-box-1">
					<div class="widget-header">
						<h4 class="widget-title">Daily Occupancy For The Month of <?php echo date('F Y'); ?></h4>
						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<i class="ace-icon fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="widget-body">
						<div class="widget-main">
							<div id="div_DailyOccupancy"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-6 widget-container-col" id="widget-container-col-1" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="widget-box widget-color-green2" id="widget-box-1">
					<div class="widget-header">
						<h4 class="widget-title">Daily Complaints For The Month of <?php echo date('F Y'); ?> Based On Priority Status</h4>
						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<i class="ace-icon fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="widget-body">
						<div class="widget-main">
							<div id="div_DailyComplaintsPR"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-6 widget-container-col" id="widget-container-col-1" style="padding-bottom: 5px; padding-left: 0px;">
				<div class="widget-box widget-color-green2" id="widget-box-1">
					<div class="widget-header">
						<h4 class="widget-title">Daily Complaints For The Month of <?php echo date('F Y'); ?> Based On Status</h4>
						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<i class="ace-icon fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="widget-body">
						<div class="widget-main">
							<div id="div_DailyComplaintsS"></div>
						</div>
					</div>
				</div>
			</div>

		</div>

	</div>
</div>

<?php  
	include("script.php");
	include("modals.php");
?>