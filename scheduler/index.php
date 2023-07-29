<div class="modal fade fade-scale" id="mdl_SchedOption" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="width: 90%;" id="submdl_SchedOption">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Mall Scheduler</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class=" col-xs-12 col-md-12 col-lg-12">
                        <!-- <div class="tabbable tabs-left">
                            <ul class="nav nav-tabs" id="myTab3">
                                <li class="active">
                                    <a data-toggle="tab" href="#Billing" onclick="loadBillSetup();CheckModule('Billing');">
                                        <i class="green ace-icon fa fa-dollar bigger-110"></i>
                                        Billing
                                    </a>
                                </li>
                                <li class="active">
                                    <a data-toggle="tab" href="#Maintenance" onclick="fnctbodySchedMaintenance();CheckModule('Maintenance');">
                                        <i class="green ace-icon fa fa-wrench bigger-110"></i>
                                        Maintenance
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content"> -->
                                <div id="Billing" class="tab-pane hide">
                                    <div class="row">
                                    	<div class="col-md-8">
	                                        <div class="widget-box widget-color-green" id="tbdywidget_billing">
					                            <div class="widget-header">
					                                <h5 class="widget-title">Posting of Charges Setup</h5>
					                            </div>
					                            <div class="widget-body">
					                                <div class="widget-main">
					                                	<div class="row form-group">
					                                		<label class="col-md-6 txtSysBuilding">Mall</label>
					                                		<div class="col-md-6">
					                                        	<select class="form-control txtBillSetupReq" id="txtBillSetupMall" onchange="loadBillSetup();"></select>
					                                        </div>
					                                	</div>
					                                    <div class="form-group row">
					                                        <label class="col-md-6">Monthly Rent</label>
					                                        <div class="col-md-6">
					                                        	<select class="form-control txtBillSetupReq" id="txtBillSetupMonthlyRent">
					                                        		<option value="">-- Day of the Month --</option>
					                                        		<?php 
					                                        			for ($i=1; $i <= 31; $i++) { 
					                                        				echo "<option value='". $i ."'>". $i ."</option>";
					                                        			}
					                                        		?>
					                                        	</select>
					                                        </div>
					                                    </div>
					                                    <div class="form-group row">
					                                        <label class="col-md-6">Operational Charges</label>
					                                        <div class="col-md-6">
					                                        	<select class="form-control txtBillSetupReq" id="txtBillSetupOperationalCharges">
					                                        		<option value="">-- Day of the Month --</option>
					                                        		<?php 
					                                        			for ($i=1; $i <= 31; $i++) { 
					                                        				echo "<option value='". $i ."'>". $i ."</option>";
					                                        			}
					                                        		?>
					                                        	</select>
					                                        </div>
					                                    </div>
					                                </div>
					                            </div>

					                            <div class="widget-toolbox padding-8 clearfix">
					                                <button class="btn btn-success pull-right btn-round" onclick="fncSaveBillSetup()">
					                                    <i class="ace-icon fa fa-check icon-on-right"></i>
					                                    <span class="bigger-110">&nbsp;Save</span>            
					                                </button>
					                            </div>
					                        </div>
					                    </div>
                                    </div>
                                </div>
                                <div id="Maintenance" class="tab-pane in active">
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <button class="btn btn-sm btn-info pull-right btn-round" onclick="fncAddNewSetup();">Add Schedule</button>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <div class="parent">
                                                <table class="table table-bordered table-striped fixTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Period</th>
                                                            <th>Occurence</th>
                                                            <th>Department</th>
                                                            <th>Personnel</th>
                                                            <th>Task List</th>
                                                            <th style="z-index: 1; width: 5%;">Option</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodySchedMaintenance"></tbody>
                                                </table>
                                            </div>
                                            <table class="tabledash_footer table" style="margin: 0px !important;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                                            <font id="txtComplaintsEntries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                                            <input id="txtComplaintsPageCount" type="hidden">
                                                            <ul id="ulPageComplaints" class="pagination pull-right"></ul>
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <!-- </div>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<?php include 'script.php'; ?>
<?php include 'modal.php'; ?>