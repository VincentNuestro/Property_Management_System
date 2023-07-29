<style type="text/css">
	.kulayan td {
		background-color: #90C5D6;
	}
</style>
<div class="modal fade fade-scale" id="mdl-unit-info" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-lg" style="width:90%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" onclick="CloseSubLeadsProUnitInfo()">&times;</button>
				<h4 class="modal-title" style="font-family: Roboto;font-size: 18px;">Add Unit Information</h4>
			</div>

			<div class="modal-body">
				<input type="hidden" id="proposalCount">
				<input type="hidden" id="txtSubLeadsINQID">
				<div class="row">
					<div class="col-md-12">
						<div class="row form-group">
							<!-- <div class="col-md-12">
								<div class="checkbox pull-right">
									<label>
										<input type="checkbox" id="clicktoshowall2" class="chk_advpyment ace" onclick="clicktoshowall2()">
										<span class="lbl" style="color: #666;font-weight: bold;">&nbsp;Expand All</span>
									</label>
								</div>
							</div> -->
							<div class="col-md-12">
								<div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
									<div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
										<div class="widget-header"> 
											<h4 class="widget-title">Unit Information</h4>
											<!-- <div class="widget-toolbar no-border">
												<a href="#" data-action="collapse" class="clicktoshowall2" id="mdlUnitInfoTab">
													<i class="ace-icon fa fa-chevron-down"></i>
												</a>
											</div> -->
										</div>
										<div class="widget-body">
											<div class="widget-main">
												<div class="row well">
													<div class="row form-group">
														<div class="col-md-4">
															<div class="row form-group">
                                                                <h4 class="green">Unit Information</h4>
                                                            </div>
															<div class="row form-group">
																<label class="col-md-4" style="white-space: nowrap;">Select Unit</label>
																<div class="col-md-8">
																	<button class="btn btn-primary btn-sm col-md-12 isFinal btn-round" id="btnshortucutunit" onclick="$('#shortcutuserpage').val('1'); LeadsProShrtctUnit(); $('#modalshortcutunit').modal('show');"><i class="ace-icon fa fa-level-up"></i>&nbsp;Shortcut</button>
																</div>
															</div>
															<div class="row form-group">
																<div class="col-md-4 col-xs-12">
																	<label class="txtSysBuilding">Branch</label>
																</div>
																<div class="col-md-8 col-xs-12">
																	<input type="hidden" id="txtpro_mallbranch" class="txtProClear txtProClear2">
																	<input type="text" id="txtinq_mallname" class="form-control txtProClear txtProClear2 txtSysBuildingPlaceholder" readonly style="background-color: white !important;">
																</div>
															</div>
															<div class="row form-group">
																<label class="col-md-4" style="white-space: nowrap;">Unit Type</label>
																<div class="col-md-8 col-xs-8">
																	<input type="text" id="txtinq_UnitType" class="form-control txtProClear txtProClear2" readonly style="background-color: white !important;" placeholder="Unit Type">
																</div>
															</div>
                											<?php if(SysLeaseSetup('isClassification') == "1"){ ?> 
															<div class="row form-group">
																<label class="col-md-4">Classification</label>
																<div class="col-md-8">
																	<input type="hidden" id="txtinq_unitclassid" class="txtProClear txtProClear2">
																	<input type="text" id="txtinq_unitclass" class="form-control txtProClear txtProClear2" readonly style="background-color: white !important;" placeholder="Classification">
																</div>
															</div>
											                <?php } ?>
											                <?php if(SysLeaseSetup('isDepartment') == "1"){ ?>
															<div class="row form-group">
																<label class="col-md-4">Department</label>
																<div class="col-md-8">
																	<input type="hidden" id="txtinq_unitdepartmentid" class="txtProClear txtProClear2">
																	<input type="text" id="txtinq_unitdepartment" class="form-control txtProClear txtProClear2" readonly style="background-color: white !important;" placeholder="Department">
																</div>
															</div>
											                <?php } ?>
											                <?php if(SysLeaseSetup('isCategory') == "1"){ ?>
															<div class="row form-group">
																<label class="col-md-4">Category</label>
																<div class="col-md-8">
																	<input type="hidden" id="txtinq_unitcategoryid" class="txtProClear txtProClear2">
																	<input type="text" id="txtinq_unitcategory" class="form-control txtProClear txtProClear2" readonly style="background-color: white !important;" placeholder="Category">
																</div>
															</div>
											                <?php } ?>
															<div class="row form-group">
																<label class="col-md-4">Wing</label>
																<div class="col-md-8">
																	<input type="hidden" id="txtinq_unitwingid" class="txtProClear txtProClear2">
																	<input type="text" id="txtinq_unitwing" class="form-control txtProClear txtProClear2" readonly style="background-color: white !important;" placeholder="Wing">
																</div>
															</div>
															<div class="row form-group">
																<label class="col-md-4">Floor</label>
																<div class="col-md-8">
																	<input type="hidden" id="txtinq_unitfloorid" class="txtProClear txtProClear2">
																	<input type="text" id="txtinq_unitfloor" class="form-control txtProClear txtProClear2" readonly style="background-color: white !important;" placeholder="Floor">
																</div>
															</div>
															<div class="row form-group">
																<label class="col-md-4">Unit</label>
																<div class="col-md-8">
																	<input type="hidden" id="txtinq_unitunitid" class="txtProClear txtProClear2">
																	<input type="text" id="txtinq_unitunit" class="form-control txtProClear txtProClear2" readonly style="background-color: white !important;" placeholder="Unit">
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="row form-group">
                                                                <h4 class="green">&nbsp;</h4>
                                                            </div>
															<div class="row form-group" id="div_unit_area_set">
																<label class="col-md-4" style="white-space: nowrap;">Unit Area</label>
																<div class="col-md-8">
																	<input type="text" class="form-control txtProClear txtProClear2" id="txtinq_sqm" style="text-align: right; background-color: white !important;" readonly placeholder="Unit Area">
																</div>
															</div>
															<div class="row form-group" id="div_unit_area_lca">
																<label class="col-md-4" style="white-space: nowrap;">Unit Area (L x W)</label>
																<div class="col-md-4 pull-right">
																	<input type="text" class="form-control txtProClear txtProClear2" id="txtinq_sqm_width" style="text-align: right; background-color: white !important;" readonly  placeholder="Length">
																</div>
																<div class="col-md-4 pull-right">
																	<input type="text" class="form-control txtProClear txtProClear2" id="txtinq_sqm_length" style="text-align: right; background-color: white !important;" readonly onkeyup="unitareachk()" placeholder="Width">
																</div>
															</div>
															<div class="row form-group">
																<label class="col-md-4" style="white-space: nowrap;">Price Per SQM</label>
																<div class="col-md-8">
																	<input type="text" class="form-control txtProClear txtProClear2" onkeyup="unitareachk()" style="text-align: right; background-color: white !important;" placeholder="0.00" id="txtinq_persqm" readonly>
																</div>
															</div>
															<div class="row form-group">
																<label class="col-md-4" style="white-space: nowrap;">Monthly Dues</label>
																<div class="col-md-1">
																	<button class="btn btn-success btn-xs btn-round" id="btnEnabletxtinq_totalsqm" onclick="Disabletxtinq_totalsqm();" style="display: none;"><i class="fa fa-check"></i></button>
																</div>
																<div class="col-md-7">
																	<input type="text" class="form-control txtProClear txtProClear2" style="text-align: right; background-color: white !important;" placeholder="0.00" id="txtinq_totalsqm" readonly ondblclick="Enabletxtinq_totalsqm();">
																</div>
															</div>
                											<?php if(SysLeaseSetup('isAssocDues') == "1"){ ?> 
															<div class="row form-group">
																<label class="col-md-4" style="white-space: nowrap;">Association Dues</label>
																<div class="col-md-1">
																<label>
																	<button class="btn btn-success btn-xs btn-round" id="btnEnabletxtinq_assocdues" onclick="Disabletxtinq_assocdues();" style="display: none;"><i class="fa fa-check"></i></button>
																</label>
																</div>
																<div class="col-md-7">
																	<input type="text" class="form-control txtProClear txtProClear2" style="text-align: right; background-color: white !important;" placeholder="0.00" id="txtinq_assocdues" readonly ondblclick="Enabletxtinq_assocdues();">
																</div>
															</div>
											                <?php } ?>
															<div class="row form-group">
																<label class="col-md-4" style="white-space: nowrap;">Total Amount</label>
																<div class="col-md-8">
																	<input type="text" class="form-control txtProClear txtProClear2" style="text-align: right; background-color: white !important;" placeholder="0.00" id="txtinq_totalmonthlydues" readonly>
																</div>
															</div>
															<div class="row form-group">
																<label class="col-md-4" style="white-space: nowrap;">Occupancy Date</label>
																<div class="col-md-4">
																	<input class="form-control jonas-date-picker isFinal" id="txtinq_datefrom" type="text" data-date-format="m/d/Y" onchange="showOccupancyDateTo();" style="background-color: white !important;" />
																</div>
																<div class="col-md-4">
																	<input type="text" id="txtinq_dateto" class="form-control txtProClear txtProClear2" readonly data-date-format="m/d/Y" readonly style="background-color: white !important;" >
																</div>
															</div>
															<div class="row form-group">
																<label class="col-md-4" style="white-space: nowrap;">Billing Start Date</label>
																<div class="col-md-4">
																	<input class="form-control jonas-date-picker isFinal" id="txtinqBillStart" type="text" data-date-format="m/d/Y" onchange="getProPaySched()" style="background-color: white !important;" />
																</div>
															</div>
															<div class="row form-group" id="div_nomonths" style="display: block;">
																<label class="col-md-4" style="white-space: nowrap;">No of Months</label>
																<div class="col-md-2">
																	<input type="text" class="form-control txtSysNumOnly txtProClear txtProClear2 isFinal2" placeholder="0" id="txtnoofmonths_inq" maxlength="2" onkeyup="showOccupancyDateTo();" style="background-color: white !important;">
																</div>
																<center class="col-md-1" style="font-weight: bold; font-size: 20px;">X</center>
																<div class="col-md-5">
																	<input type="text" class="form-control txtProClear txtProClear2" id="txtmonthlymath" style="text-align: right; background-color: white !important;" readonly placeholder="0.00">
																</div>
															</div>
															<div class="row form-group" id="div_nodays" style="display: none;">
																<label class="col-md-4" style="white-space: nowrap;">No of Days</label>
																<div class="col-md-2">
																	<input type="text" class="form-control txtSysNumOnly isFinal2" placeholder="0" id="txtnoofdays_inq" onkeyup="showOccupancyDateTo();" style="background-color: white !important;">
																</div>
																<div class="col-md-6">
                                                					<h6 style="font-style: italic;">(Please refer to payment schedule as daily rent is based on the number of days of the month the occupancy falls.)</h6>
																</div>
																<!-- <div class="col-md-1" style="margin-top: 5px;">
																	<span style="font-weight: bold;">x</span>
																</div>
																<div class="col-md-5">
																	<input type="text" class="form-control txtProClear txtProClear2" id="txtmonthlymathdays" style="text-align: right;" readonly>
																</div> -->
															</div>
														</div>
														<div class="col-md-4">
															<div class="row form-group">
                                                                <h4 class="green">Amenities</h4>
                                                            </div>
															<div class="row form-group">
																<div class="col-md-12 col-xs-12" style="height: 383px;overflow-y: scroll;">
																	<div id="div_SubLeadsProAmenities"></div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-12">
								<div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
									<div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
										<div class="widget-header"> 
											<h4 class="widget-title">Payment Information and Schedule</h4>
											<!-- <div class="widget-toolbar no-border">
												<a href="#" data-action="collapse" class="clicktoshowall2" id="mdlPaymentInfoandSchedTab">
													<i class="ace-icon fa fa-chevron-down"></i>
												</a>
											</div> -->
										</div>
										<div class="widget-body">
											<div class="widget-main">
												<div class="row well">
													<div class="row form-group">
														<div class="col-md-12">
					                                    	<h4 class="green">Payment Schedule</h4>
					                                    	<div class="" style="height: 50vh;">
						                                        <div id="LoadPaySchedule"></div>
						                                        <table class="table table-striped table-bordered table-hover fixTable">
						                                            <thead>
						                                                <tr>
						                                                    <th>Date of Payment</th>
						                                                    <th style="text-align: right;">Advance Payment</th>
						                                                    <th style="text-align: right;">Amount Due</th>
                															<?php if(SysLeaseSetup('isAssocDues') == "1"){ ?> 
						                                                    <th style="text-align: right;">Association Due</th>
					                                                		<?php } ?>
						                                                    <th style="text-align: right;">Total Due</th>
						                                                </tr>
						                                            </thead>
						                                            <tbody id="tblProPaySched"></tbody>
						                                        </table>
						                                    </div>
							                            </div>
							                       	</div>
							                       	<div class="row form-group">
							                            <div class="col-md-4">
							                            	<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                												<legend class="green" style="border: none;font-size: 16px;width: 177px;">&nbsp;&nbsp;Payment Information&nbsp;&nbsp;</legend>
								                            	<div class="row form-group">
																	<label class="col-md-6" style="white-space: nowrap;">Payment Terms</label>
																	<div class="col-md-6">
																		<select class="form-control txtProClear isFinal" id="txtinq_pymentterms" onchange="getProPaySched();" style="background-color: white !important;">
																			<option value="">-- Select Payment Terms --</option>
																			<option value="daily">Daily</option>
																			<option value="monthly">Monthly</option>
																			<option value="1time">1 Time Payment</option>
																		</select>
																	</div>
																</div>
																<div class="row form-group">
																	<label class="col-md-6" style="white-space: nowrap;">Payment Type</label>
																	<div class="col-md-6">
																		<select id="txtinq_pymenttype" class="form-control txtProClear isFinal" style="background-color: white !important;" onchange="getProPaySched();">
																			<option value="">-- Select Payment Type --</option>
																			<option value="Cash">Cash</option>
																			<option value="Check">Check</option>
																			<option value="Credit Card">Credit Card</option>
																			<option value="Debit Card">Debit Card</option>
																			<option value="Bank Transfer">Bank Transfer</option>
																		</select>
																	</div>
																</div>
																<div class="row form-group">
								                                    <label class="col-md-6">Advance</label>
								                                    <div class="col-md-2">
								                                        <input type="text" class="form-control txtProClear" id="txtProAdvanceMonth" readonly placeholder="0" style="background-color: white !important;">
								                                    </div>
								                                    <div class="col-md-4">
								                                        <input type="text" class="form-control txtProClear" id="txtProAdvanceAmount" style="text-align: right; background-color: white !important;" readonly placeholder="0.00">
								                                    </div>
								                                </div>
								                                <div class="row form-group">
								                                	<label class="col-md-6" style="white-space: nowrap;">Payable Terms</label>
																	<div class="col-md-6">
																		<select class="form-control isFinal txtProClear" id="txtProAdvanceMonthTerms" style="background-color: white !important;">
																			<option value="">-- Select Terms --</option>
																			<option value="15">15 Days</option>
																			<option value="30">30 Days</option>
																			<option value="45">45 Days</option>
																			<option value="60">60 Days</option>
																			<option value="75">75 Days</option>
																			<option value="90">90 Days</option>
																			<option value="105">105 Days</option>
																			<option value="120">120 Days</option>
																		</select>
																	</div>
								                                </div>
									                        </fieldset>
							                            </div>
							                            <div class="col-md-4">
							                            	<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                												<legend class="green" style="border: none;font-size: 16px;width: 175px;">&nbsp;&nbsp;Construction Deposit&nbsp;&nbsp;</legend>
																<div class="row form-group">
																	<label class="col-md-6" style="white-space: nowrap;">Construction Deposit Type</label>
																	<div class="col-md-3">
																		<div class="radio" style="white-space: nowrap;">
																			<label>
																				<input name="rdoIsConsDeposit" type="radio" class="ace rdoIsConsDeposit isFinal" value="Monthly" checked id="ConDep-Monthly">
																				<span class="lbl"> Monthly</span>
																			</label>
																		</div>
																	</div>
																	<div class="col-md-3">
																		<div class="radio" style="white-space: nowrap;">
																			<label>
																				<input name="rdoIsConsDeposit" type="radio" class="ace rdoIsConsDeposit isFinal" value="Fixed" id="ConDep-Fixed">
																				<span class="lbl"> Fixed</span>
																			</label>
																		</div>
																	</div>
																</div>
																<div class="row form-group">
																	<label class="col-md-6" style="white-space: nowrap;">Construction Deposit</label>
																	<div class="col-md-6">
																		<input type="text" class="form-control isFinal2 txtProClear txtSysNumOnly" id="txtProConBondMonth" style="background-color: white !important;">
																	</div>
																</div>
																<div class="row form-group">
																	<label class="col-md-6" style="white-space: nowrap;">Refund Terms</label>
																	<div class="col-md-6">
																		<select class="form-control isFinal txtProClear" id="txtProConBondMonthTerms" style="background-color: white !important;">
																			<option value="">-- Select Terms --</option>
																			<option value="15">15 Days</option>
																			<option value="30">30 Days</option>
																			<option value="45">45 Days</option>
																			<option value="60">60 Days</option>
																			<option value="75">75 Days</option>
																			<option value="90">90 Days</option>
																			<option value="105">105 Days</option>
																			<option value="120">120 Days</option>
																		</select>
																	</div>
																</div>
															</fieldset>
														</div>
														<div class="col-md-4">
							                            	<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                												<legend class="green" style="border: none;font-size: 16px;width: 138px;">&nbsp;&nbsp;Security Deposit&nbsp;&nbsp;</legend>
								                            	<div class="row form-group">
																	<label class="col-md-6" style="white-space: nowrap;">Security Deposit Type</label>
																	<div class="col-md-3">
																		<div class="radio" style="white-space: nowrap;">
																			<label>
																				<input name="rdoIsSecDeposit" type="radio" class="ace rdoIsSecDeposit isFinal" value="Monthly" checked id="SecDep-Monthly">
																				<span class="lbl"> Monthly</span>
																			</label>
																		</div>
																	</div>
																	<div class="col-md-3">
																		<div class="radio" style="white-space: nowrap;">
																			<label>
																				<input name="rdoIsSecDeposit" type="radio" class="ace rdoIsSecDeposit isFinal" value="Fixed" id="SecDep-Fixed">
																				<span class="lbl"> Fixed</span>
																			</label>
																		</div>
																	</div>
																</div>
																<div class="row form-group">
																	<label class="col-md-6" style="white-space: nowrap;">Security Deposit</label>
																	<div class="col-md-6">
																		<input type="text" class="form-control isFinal2 txtProClear txtSysNumOnly" id="txtProSecurityDeposit" title="Enter number of months" style="background-color: white !important;">
																	</div>
																</div>
																<div class="row form-group">
																	<label class="col-md-6" style="white-space: nowrap;">Payable Terms</label>
																	<div class="col-md-6">
																		<select class="form-control isFinal txtProClear" id="txtProSecurityDepositTerms" style="background-color: white !important;">
																			<option value="">-- Select Terms --</option>
																			<option value="15">15 Days</option>
																			<option value="30">30 Days</option>
																			<option value="45">45 Days</option>
																			<option value="60">60 Days</option>
																			<option value="75">75 Days</option>
																			<option value="90">90 Days</option>
																			<option value="105">105 Days</option>
																			<option value="120">120 Days</option>
																		</select>
																	</div>
																</div>
															</fieldset>
														</div>
													</div>
													<div class="row form-group">
														<?php if(SysLeaseSetup('vatsetup') == "0"){ ?> 
							                            <div class="col-md-4">
							                            	<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                												<legend class="green" style="border: none;font-size: 16px;width: 95px;">&nbsp;&nbsp;VAT Setup&nbsp;&nbsp;</legend>
								                            	<div class="row form-group">
																	<label class="col-md-6">Is rent Vatable?</label>
																	<div class="col-md-3">
																		<div class="radio">
																			<label>
																				<input name="rdoIsRent" type="radio" class="ace rdoIsRent isFinal" id="Pro-Yes" checked value="1">
																				<span class="lbl"> Yes</span>
																			</label>
																		</div>
																	</div>
																	<div class="col-md-3">
																		<div class="radio">
																			<label>
																				<input name="rdoIsRent" type="radio" class="ace rdoIsRent isFinal" id="Pro-No" value="0">
																				<span class="lbl"> No</span>
																			</label>
																		</div>
																	</div>
																</div>
																<div class="row form-group">
																	<label class="col-md-6">Vat Type</label>
																	<div class="col-md-6">
																		<select class="form-control isFinal txtProClear" id="txtProVatType" style="background-color: white !important;">
																			<option value="">-- Select Vat Type --</option>
																			<option value="inc">Inclusive</option>
																			<option value="exc">Exclusive</option>
																		</select>
																	</div>
																</div>
																<div class="row form-group">
																	<label class="col-md-6">Vat Percentage</label>
																	<div class="col-md-3">
																		<span class="input-icon input-icon-right">
																			<input type="text" class="form-control isFinal2 txtProClear txtSysNumOnly" maxlength="2" id="txtProVatPercentage" style="background-color: white !important;">
																			<i class="ace-icon fa fa-percent"></i>
																		</span>
																	</div>
																</div>
															</fieldset>
							                            </div>
											            <?php } ?>
														<div class="col-md-4">
															<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                												<legend class="green" style="border: none;font-size: 16px;width: 139px;">&nbsp;&nbsp;Escalation Setup&nbsp;&nbsp;</legend>
																<div class="row form-group">
																	<label class="col-md-6">Escalation Rate</label>
																	<div class="col-md-3">
																		<span class="input-icon input-icon-right">
																			<input type="text" class="form-control isFinal2 txtProClear txtSysNumOnly" maxlength="2" id="txtProEscalationRate" style="background-color: white !important;">
																			<i class="ace-icon fa fa-percent"></i>
																		</span>
																	</div>
																</div>
																<div class="row form-group">
																	<label class="col-md-6">Year Start</label>
																	<div class="col-md-3">
																		<span class="input-icon input-icon-right">
																			<input type="text" class="form-control isFinal2 txtProClear txtSysNumOnly" id="txtProEscaRateStart" maxlength="2" style="background-color: white !important;">
																			<i class="ace-icon fa fa-question-circle blue hide" title="Based on occupancy"></i>
																		</span>
																	</div>
																</div>
																<div class="row form-group">
																	<label class="col-md-6">Year Basis</label>
																	<div class="col-md-3">
																		<span class="input-icon input-icon-right">
																			<input type="text" class="form-control isFinal2 txtProClear txtSysNumOnly" id="txtProEscaYearBasis" maxlength="2" style="background-color: white !important;">
																			<i class="ace-icon fa fa-question-circle blue hide" title="Based on occupancy"></i>
																		</span>
																	</div>
																</div>
															</fieldset>
														</div>
														<div class="col-md-4">
															<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                												<legend class="green" style="border: none;font-size: 16px;width: 237px;">&nbsp;&nbsp;Rent-Free Construction Setup&nbsp;&nbsp;</legend>
																<div class="row form-group">
																	<label class="col-md-6" style="white-space: nowrap;">Rent-Free Construction</label>
																	<div class="col-md-6">
																		<select class="form-control isFinal txtProClear" id="txtProRentFreeCons" onchange="DelProRentConsStarDate(this.value)" style="background-color: white !important;">
																			<option value=''>-- Select Terms --</option>
																			<option value="0">Not Applicable</option>
																			<option value="15">15 Days</option>
																			<option value="30">30 Days</option>
																			<option value="45">45 Days</option>
																			<option value="60">60 Days</option>
																			<option value="75">75 Days</option>
																			<option value="90">90 Days</option>
																			<option value="105">105 Days</option>
																			<option value="120">120 Days</option>
																		</select>
																	</div>
																</div>
																<div class="row form-group" id="divConsStartDate">
																	<label class="col-md-6">Start Date</label>
																	<div class="col-md-6">
																		<input type="text" class="form-control date-picker txtProClear isFinal" id="txtProRentFreeConsStartDate" style="background-color: white !important;">
																	</div>
																</div>
															</fieldset>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-12">
								<div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
									<div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
										<div class="widget-header"> 
											<h4 class="widget-title">Charges, Requirements and Permits</h4>
											<!-- <div class="widget-toolbar no-border">
												<a href="#" data-action="collapse" class="clicktoshowall2" id="mdlChargeRequirementsPermits">
													<i class="ace-icon fa fa-chevron-down"></i>
												</a>
											</div> -->
										</div>
										<div class="widget-body">
											<div class="widget-main">
												<div class="row well">
													<div class="row form-group">
														<div class="col-md-4">
															<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                												<legend class="green" style="border: none;font-size: 16px;width: 129px;">&nbsp;&nbsp;List of Charges&nbsp;&nbsp;</legend>
																<div class="row form-group" style="margin-top: -10px;">
																	<div class="col-md-12">
																		<button class="btn btn-sm btn-info pull-right isFinal btn-round" onclick='showModalAddCharges(); $("#mdl_AddCharges").modal("show");'>Add Operational/Conditional Charges</button>
																	</div>
									                            </div>
																<div class="row form-group">
																	<div class="col-md-12">
																		<div class="parent">
										                                    <table class="table table-striped table-bordered fixTable">
										                                        <thead>
										                                            <tr>
										                                                <th style="width: 50%;">Charges</th>
										                                                <th style="width: 40%;">Rate</th>
										                                                <th style="width: 10%;z-index: 1;">Option</th>
										                                            </tr>
										                                        </thead>
										                                        <tbody id="tblProCharges"></tbody>
										                                    </table>
										                                </div>
									                           		</div>
									                           	</div>
									                        </fieldset>
														</div>
														<div class="col-md-4">
															<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                												<legend class="green" style="border: none;font-size: 16px;width: 171px;">&nbsp;&nbsp;List of Requirements&nbsp;&nbsp;</legend>
																<div class="row form-group" style="margin-top: -10px;">
																	<div class="col-md-12">
																		<button class="btn btn-sm btn-info pull-right isFinal btn-round" onclick='showModalAddRequirements();$("#mdl_AddRequirements").modal("show");'>Add Requirements</button>
																	</div>
																</div>
																<div class="row form-group">
																	<div class="col-md-12">
																		<div class="parent">
										                                    <table class="table table-striped table-bordered fixTable">
										                                        <thead>
										                                            <tr>
										                                                <th style="width: 80%;">Requirements</th>
										                                                <th style="width: 20%;z-index: 1">Option</th>
										                                            </tr>
										                                        </thead>
										                                        <tbody id="tblProRequirements"></tbody>
										                                    </table>
										                                </div>
									                                </div>
																</div>
															</fieldset>
														</div>
														<div class="col-md-4">
															<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                												<legend class="green" style="border: none;font-size: 16px;width: 123px;">&nbsp;&nbsp;List of Permits&nbsp;&nbsp;</legend>
																<div class="row form-group" style="margin-top: -10px;">
																	<div class="col-md-12">
																		<button class="btn btn-sm btn-info pull-right isFinal btn-round" onclick='showModalAddPermits();$("#mdl_AddPermits").modal("show");'>Add Permits</button>
																	</div>
																</div>
																<div class="row form-group">
																	<div class="col-md-12">
																		<div class="parent">
										                                    <table class="table table-striped table-bordered fixTable">
										                                        <thead>
										                                            <tr>
										                                                <th style="width: 80%;">Permits</th>
										                                                <th style="width: 20%;z-index: 1">Option</th>
										                                            </tr>
										                                        </thead>
										                                        <tbody id="tblProPermits"></tbody>
										                                    </table>
										                                </div>
																	</div>
																</div>
															</fieldset>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-12">
								<div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
									<div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
										<div class="widget-header"> 
											<h4 class="widget-title">Terms and Conditions</h4>
											<!-- <div class="widget-toolbar no-border">
												<a href="#" data-action="collapse" class="clicktoshowall2" id="mdlProTermsAndConditions">
													<i class="ace-icon fa fa-chevron-down"></i>
												</a>
											</div> -->
										</div>
										<div class="widget-body">
											<div class="widget-main">
												<div class="row well">
													<div class="row form-group">
														<div class="col-md-12">
															<div class="row form-group">
																<div class="col-md-7">
										                            <h4 class="green pull-right">Terms and Conditions</h4>
																</div>
																<div class="col-md-5">
																	<button class="btn btn-sm btn-info pull-right isFinal btn-round" onclick='$("#mdlProTermsandCon").val("1"); showModal_mdl_ProTermsAndCon();$("#mdl_ProTermsAndCon").modal("show");'>Browse Terms & Conditions</button>
																</div>
															</div>
														</div>
														<div class="col-md-12">
															<div class="row form-group">
																<div class="col-md-12">
																	<div class="parent">
									                                    <table class="table table-striped table-bordered fixTable">
									                                        <thead>
									                                            <tr>
									                                                <th style="width: 30%;">Term Name</th>
									                                                <th style="width: 70%;">Condition</th>
									                                            </tr>
									                                        </thead>
									                                        <tbody id="tblMainProTermsandCon"></tbody>
									                                    </table>
										                           	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm isFinal btn-round" id="btnSaveProposal" onclick="saveProposal()"><span class="fa fa-check"></span> Save</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade fade-scale" id="mdl_AddCharges" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  	<div class="modal-dialog modal-md">
	    <div class="modal-content">
	      	<div class="modal-header">
	          	<button type="button" class="close" data-dismiss="modal">&times;</button>
	          	<h4 class="modal-title" style="font-family: Roboto;font-size: 18px;">Select Charges</h4>
	      	</div>
	      	<div class="modal-body">
		        <div class="row">
			        <div class="col-xs-4 col-md-4 col-lg-4">
			        	<span class="input-icon" style="width: 100%;">
							<input type="text" class="form-control" id="txtSearchCharges" title="Search" placeholder="Search">
							<i class="ace-icon fa fa-search nav-search-icon"></i>
						</span>
					</div>
		          	<div class="col-xs-12 col-md-12 col-lg-12">
			            <div style="margin-top: 10px;" class="parent"> 
			              	<table class="table table-bordered table-hover fixTable">
				                <thead>
				                  	<tr>
					                    <th width="60%">Charges</th>
					                    <th width="40%">Rate</th>                   
				                  	</tr>
				                </thead>
				                <tbody id="tblAddCharges"></tbody>
			              	</table>
			            </div>
		          	</div>
		        </div>
	      	</div>
	      	<div class="modal-footer">
	            <button class="btn btn-sm btn-danger btn-round" onclick="$('#mdl_AddCharges').modal('hide');">Close</button>
	      	</div>
	    </div>
  	</div>
</div>

<div class="modal fade fade-scale" id="mdl_AddRequirements" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  	<div class="modal-dialog modal-md">
	    <div class="modal-content">
	      	<div class="modal-header">
	          	<button type="button" class="close" data-dismiss="modal">&times;</button>
	          	<h4 class="modal-title" style="font-family: Roboto;font-size: 18px;">Select Requirements</h4>
	      	</div>
	      	<div class="modal-body">
		        <div class="row">
		        	<div class="col-xs-4 col-md-4 col-lg-4">
			        	<span class="input-icon" style="width: 100%;">
							<input type="text" class="form-control" id="txtSearchRequirement" title="Search" placeholder="Search">
							<i class="ace-icon fa fa-search nav-search-icon"></i>
						</span>
					</div>
		          	<div class="col-xs-12 col-md-12 col-lg-12">
			            <div style="margin-top: 10px;" class="parent"> 
			              	<table class="table table-bordered table-hover fixTable">
				                <thead>
				                  	<tr>
					                    <th style="width: 100%;">Requirement</th>                   
				                  	</tr>
				                </thead>
				                <tbody id="tblAddRequirements"></tbody>
			              	</table>
			            </div>
		          	</div>
		        </div>
	      	</div>
	      	<div class="modal-footer">
	            <button class="btn btn-danger btn-sm btn-round" onclick="$('#mdl_AddRequirements').modal('hide');">Close</button>
	      	</div>
	    </div>
  	</div>
</div>

<div class="modal fade fade-scale" id="mdl_AddPermits" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  	<div class="modal-dialog modal-md">
	    <div class="modal-content">
	      	<div class="modal-header">
	          	<button type="button" class="close" data-dismiss="modal">&times;</button>
	          	<h4 class="modal-title" style="font-family: Roboto;font-size: 18px;">Select Permits</h4>
	      	</div>
	      	<div class="modal-body">
		        <div class="row">
		        	<div class="col-xs-4 col-md-4 col-lg-4">
			        	<span class="input-icon" style="width: 100%;">
							<input type="text" class="form-control" id="txtSearchPermit" title="Search" placeholder="Search">
							<i class="ace-icon fa fa-search nav-search-icon"></i>
						</span>
					</div>
		          	<div class="col-xs-12 col-md-12 col-lg-12">
			            <div style="margin-top: 10px;" class="parent"> 
			              	<table class="table table-bordered table-hover fixTable">
				                <thead>
				                  	<tr>
					                    <th style="width: 100%;">Permits</th>                   
				                  	</tr>
				                </thead>
				                <tbody id="tblAddPermits"></tbody>
			              	</table>
			            </div>
		          	</div>
		        </div>
	      	</div>
	      	<div class="modal-footer">
	            <button class="btn btn-danger btn-sm btn-round" onclick="$('#mdl_AddPermits').modal('hide');">Close</button>
	      	</div>
	    </div>
  	</div>
</div>

<div class="modal fade fade-scale" role="dialog" id="mdl_ProTermsAndCon">
    <div class="modal-dialog modal-lg" style="width: 85%;">
        <div class="modal-content">
            <div id="divmdlProTermsAndCon"></div>
            <div class="modal-header">
                <button type="button" class="close" onclick="$('#mdl_ProTermsAndCon').modal('hide');">&times;</button>
                <h4 class="modal-title" style="font-family: Roboto;font-size: 18px;">Terms and Conditions</h4>
                <input type="hidden" id="sonyxperiaxzs" class="txtProClear">
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-2">
                        Filter by Group Name:
                    </div>
                    <div class="col-md-3">
                        <select id="txtProSearchGroup" onchange="$('#mdlProTermsandCon').val('1'); loadModalTermsandCond();" class="form-control"></select>
                    </div>
                </div>
                <div class="row">
                    <div class="parent">
                        <table class="table table-hover table-bordered fixTable">
                            <thead>
                                <tr>
                                    <th width='15%'>Group Name</th>
                                    <th width='30%'>Term Name</th>
                                    <th width='55%'>Condition</th>
                                </tr>
                            </thead>
                            <tbody id="tblProTermsAndCon"></tbody>
                        </table>
                    </div>
                    <table class="tabledash_footer table" style="margin: 0px !important;">
                        <thead>
                            <tr>
                                <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                    <font id="txtLNDTTACenties" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                    <input id="mdlProTermsandCon" type="hidden">
                                    <ul id="ulLNDTTACpagination" class="pagination pull-right"></ul>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm btn-round" onclick="AddSelectedProTermsandCon()"><i class="ace-icon fa fa-check"></i>&nbsp;Add Selected</button>
            </div>
        </div>
    </div>
</div>