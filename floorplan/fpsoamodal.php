<div class="modal fade fade-scale" id="modal_opensoatenant" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
  	<div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      	<div class="modal-body">
	          	<button type="button" class="close" onclick="closemodalsoatenant()">&times;</button>
	          	<div class="row form-group">
	              	<div class="col-md-12 col-xs-12">
						<div id="reportcontainer2" style="margin-top: 10px; display: block;">
							<center>
								<div class="checklist" id="tblsoa2" style="width: 99%;margin-bottom: 0;">
									<center>
									<!-- header starts here -->
										<table style="width: 100%;" cellspacing="0" cellpadding="0" style="display: none;">
											<tbody id="template2"></tbody>
										</table>
									<!-- header ends here ... -->

									<!-- billing information starts here -->
										<table style="width: 100%;" cellpadding="0" cellspacing="0">
											<tr>
												<td width="15%"><h6 style="font-weight: normal;margin: 3px;font-size: 11px;">BILL TO</h6></td>
												<td width="2%">:</td>
												<td width="51%"><h6 style="font-weight: normal;margin: 3px;font-size: 11px;font-weight: bold;" id="txtprint_storename"></h6></td>
												<td width="15%"><h6 style="font-weight: normal;margin: 3px;font-size: 11px;">CUT-OFF DATE</h6></td>
												<td width="2%">:</td>
												<td width="15%"><h6 style="font-weight: normal;margin: 3px;font-size: 11px;font-weight: bold;" id="txtprint_cutoff"></h6></td>
											</tr>
											<tr>
												<td width="15%"><h6 style="font-weight: normal;margin: 3px;font-size: 11px;">ASSIGNEE</h6></td>
												<td width="2%">:</td>
												<td width="51%"><h6 style="font-weight: normal;margin: 3px;font-size: 11px;font-weight: bold;" id="txtprint_assignee"></h6></td>
												<td width="15%"><h6 style="font-weight: normal;margin: 3px;font-size: 11px;">BILLING NO.</h6></td>
												<td width="2%">:</td>
												<td width="15%"><h6 style="font-weight: normal;margin: 3px;font-size: 11px;font-weight: bold;" id="txtprint_billingnumber"></h6></td>
											</tr>
											<tr>
												<td><h6 style="font-weight: normal;margin: 3px;font-size: 11px;">ADDRESS</h6></td>
												<td>:</td>
												<td><h6 style="font-weight: normal;margin: 3px;font-size: 11px;font-weight: bold;" id="txtprint_address"></h6></td>
												<td><h6 style="font-weight: normal;margin: 3px;font-size: 11px;">BILLING PERIOD</h6></td>
												<td>:</td>
												<td><h6 style="font-weight: normal;margin: 3px;font-size: 11px;font-weight: bold;" id="txtprint_billingperiod"></h6></td>
											</tr>
										</table>
									<!-- billing info ends here ... -->

										<table style="width: 100%;margin-top: 15px;" cellspacing="0" cellpadding="0">
											<tr>
												<td colspan="4" align="center" style="background-color: #111109 !important;-webkit-print-color-adjust: exact;"><h6 style="font-weight: bold;margin: 3px;font-size: 11px;color: #ffffff !important;">STATEMENT OF ACCOUNT</h6></td>
											</tr>
											<tr>
												<td colspan="4"><br/></td>
											</tr>
											<tr style="border-left:1px solid #111109;border-right:1px solid #111109;">
												<td style="background-color: #111109 !important;-webkit-print-color-adjust: exact;padding-left: 5px;" align="left">
													<h6 style="font-weight: bold;margin: 3px;font-size: 11px;color: #ffffff !important;">DATE</h6>
												</td>
												<td style="background-color: #111109 !important;-webkit-print-color-adjust: exact;" align="left">
													<h6 style="font-weight: bold;margin: 3px;font-size: 11px;color: #ffffff !important;">REFERENCE</h6>
												</td>
												<td style="background-color: #111109 !important;-webkit-print-color-adjust: exact;" align="left">
													<h6 style="font-weight: bold;margin: 3px;font-size: 11px;color: #ffffff !important;">TRANSACTION DETAILS</h6>
												</td>
												<td style="background-color: #111109 !important;-webkit-print-color-adjust: exact;padding-right: 5px;" align="right">
													<h6 style="font-weight: bold;margin: 3px;font-size: 11px;color: #ffffff !important;">AMOUNT</h6>
												</td>
											</tr>
											<tbody style="border-left:1px solid #111109;border-right:1px solid #111109;">
												<tr>
													<td colspan="2"></td>
													<td>
														<h6 style="font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 11px;color: #111109;">TOTAL PREVIOUS BALANCES</h6>
													</td>
													<td style="font-weight: normal;margin: 3px;font-size: 11px;" align="right">
														<h6 style="font-weight: bold;margin: 3px;font-size: 11px;color: #111109;" id="ttlprevblncs"></h6>
													</td>
												</tr>
												<tr>
													<td colspan="4" align="center">
														<table style="border-bottom:2px solid #111109;width: 99%;">
															<tr>
																<td style="padding-bottom: 2px;"></td>
															</tr>
														</table>
													</td>
												</tr>
												<tr>
													<td colspan="2"></td>
													<td>
														<h6 style="font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 11px;color: #111109;">TOTAL Penalty Charges (Account 31 days and over)</h6>
													</td>
													<td style="font-weight: normal;margin: 3px;font-size: 11px;" align="right">
														<h6 style="font-weight: bold;margin: 3px;font-size: 11px;color: #111109;" id="ttlpenalty">0.00</h6>
													</td>
												</tr>
												<tr>
													<td colspan="4" align="center">
														<table style="border-bottom:2px solid #111109;width: 99%;">
															<tr>
																<td style="padding-bottom: 2px;"></td>
															</tr>
														</table>
													</td>
												</tr>
											</tbody>
											<!-- previous balance ends here -->

											<!-- current charges starts here ... -->
											<tr style="border-left:1px solid #111109;border-right:1px solid #111109;">
												<td colspan="4" style="padding-left: 5px;">
													<h6 style="font-weight: bold;margin: 3px;font-size: 11px;color: #111109;">CURRENT CHARGES</h6>
												</td>
											</tr>
											<tbody style="border-left:1px solid #111109;border-right:1px solid #111109;border-bottom:1px solid #111109;" id="tblcurrchrges">
											</tbody>
											<tr style="border-left:1px solid #111109;border-right:1px solid #111109;">
												<td colspan="4" style="padding-left: 5px;">
													<h6 style="font-weight: bold;margin: 3px;font-size: 11px;color: #111109;">OTHER CHARGES</h6>
												</td>
											</tr>
											<tbody style="border-left:1px solid #111109;border-right:1px solid #111109;border-bottom:1px solid #111109;" id="tblotherchrges">
											</tbody>
											<tbody style="border-left:1px solid #111109;border-right:1px solid #111109;">
												<tr>
													<td colspan="2"></td>
													<td>
														<h6 style="font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 11px;color: #111109;">TOTAL CURRENT CHARGES</h6>
													</td>
													<td style="font-weight: normal;margin: 3px;font-size: 11px;" align="right">
														<h6 style="font-weight: bold;margin: 3px;font-size: 11px;color: #111109;" id="ttlcurrchrges"></h6>
													</td>
												</tr>
												<tr>
													<td colspan="4" align="center">
														<table style="border-bottom:2px solid #111109;width: 99%;margin-bottom: 5px;">
															<tr>
																<td style="padding-bottom: 2px;"></td>
															</tr>
														</table>
													</td>
												</tr>
											</tbody>
											<!-- current charges ends here ... -->

											<!-- payment and adjustments starts here ... -->
											<tr style="border-left:1px solid #111109;border-right:1px solid #111109;">
												<td colspan="4" style="padding-left: 5px;">
													<h6 style="font-weight: bold;margin: 3px;font-size: 11px;color: #111109;">PAYMENTS AND CREDIT ADJUSTMENT</h6>
												</td>
											</tr>
											<tbody style="border-left:1px solid #111109;border-right:1px solid #111109;border-bottom:1px solid #111109;" id="tblpymentcrdtadj">						
											</tbody>
											<tbody style="border-left:1px solid #111109;border-right:1px solid #111109;border-bottom:1px solid #111109;">
												<tr>
													<td colspan="2"></td>
													<td>
														<h6 style="font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 11px;color: #111109;">TOTAL PAYMENTS</h6>
													</td>
													<td style="font-weight: normal;margin: 3px;font-size: 11px;" align="right">
														<h6 style="font-weight: bold;margin: 3px;font-size: 11px;color: #111109;" id="ttlpymentcrdtadj"></h6>
													</td>
												</tr>
												<tr>
													<td colspan="4" align="center">
														<table style="border-bottom:2px solid #111109;width: 99%;margin-bottom: 5px;">
															<tr>
																<td style="padding-bottom: 2px;"></td>
															</tr>
														</table>
													</td>
												</tr>
												<!-- payment and adjustments ends here ... -->

												<!-- breakdown starts here ... -->
												<tr>
													<td colspan="4">
														<table style="width:100%;">
															<tr>
																<td>
																	<table style="width:100%;">
																		<tr>
																			<td align="left">
																				<h6 class="paddleft" style="font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 11px;color: #111109;">
																					TOTAL PREVIOUS BALANCES
																				</h6>
																			</td>
																			<td align="right" style="">
																				<h6 class="paddright" style="font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 11px;color: #111109;" id="ttlprevblncs2">
																					
																				</h6>
																			</td>
																		</tr>
																		<tr>
																			<td align="left">
																				<h6 class="paddleft" style="font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 11px;color: #111109;">
																					ADD: TOTAL CURRENT CHARGES
																				</h6>
																			</td>
																			<td align="right" style="">
																				<h6 class="paddright" style="font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 11px;color: #111109;" id="ttlcurrchrges2">
																					
																				</h6>
																			</td>
																		</tr>
																		<tr>
																			<td align="left">
																				<h6 class="paddleft" style="font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 11px;color: #111109;">
																					LESS: TOTAL PAYMENTS
																				</h6>
																			</td>
																			<td align="right" style="">
																				<h6 class="paddright" style="font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 11px;color: #111109;" id="ttlpymentcrdtadj2">
																					
																				</h6>
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr>
																<td>
																	<table style="width:100%;" cellpadding="0" cellspacing="0">
																		<tr>
																			<td style="padding-right: 5px;background-color: #111109 !important;-webkit-print-color-adjust: exact;padding-left: 10px;" align="left">
																				<h6 class="" style="font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 11px;color: #ffffff !important;">
																					AMOUNT DUE
																				</h6>
																			</td>
																			<td style="padding-left: 20px;background-color: #111109 !important;-webkit-print-color-adjust: exact;padding-right: 5px;" align="right">
																				<h6 style="font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 11px;color: #ffffff !important;" id="ttlamtdue">
																					 0.00
																				</h6>
																			</td>
																		</tr>
																	</table>
																</td>										
															</tr>
														</table>
													</td>
												</tr>
											</tbody>
											<tbody>
												<tr>
													<td colspan="4">
														<table style="width: 100%;border-collapse: collapse;">
															<tr>
																<td colspan="4"><br/></td>
															</tr>
															<tr style="border-left:1px solid #111109;border-right:1px solid #111109;">
																<td colspan="6" align="center" style="background-color: #111109 !important;-webkit-print-color-adjust: exact;"><h6 style="font-weight: bold;margin: 3px;font-size: 11px;color: #ffffff !important;">OVERDUE ACCOUNTS</h6></td>
															</tr>
															<tr  style="border-left:1px solid #111109;border-bottom:1px solid #111109;border-right:1px solid #111109;">
																<td style="text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;">AGING SUMMARY</td>
																<td style="text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;">CURRENT</td>
																<td style="text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;">1-30 DAYS</td>
																<td style="text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;">31-60 DAYS</td>
																<td style="text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;">61-90 DAYS</td>
																<td style="text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;border-right:1px solid #111109;">OVER 90 DAYS</td>
															</tr>
															<tr style="border-left:1px solid #111109;border-bottom:1px solid #111109;border-right:1px solid #111109;">
																<td style="text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;"></td>
																<td style="text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;" id="txtsoab00">0.00</td>
																<td style="text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;" id="txtsoab13">0.00</td>
																<td style="text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;" id="txtsoab36">0.00</td>
																<td style="text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;" id="txtsoab69">0.00</td>
																<td style="text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;border-right:1px solid #111109;" id="txtsoab99">0.00</td>
															</tr>
														</table>
													</td>
												</tr>
											</tbody>
											<!-- payment and adjustments ends here ... -->
											<tbody>
												<tr>
													<td style="padding-top: 20px;" colspan="4">
														<table style="width:100%;">
															<tr>
																<td width="25%">
																	<h6 style="font-weight: normal;margin: 3px;font-size: 10px;color: #111109;">Prepared by:</h6><br /><br />
																</td>
																<td width="25%">
																	<h6 style="font-weight: normal;margin: 3px;font-size: 10px;color: #111109;">Checked by:</h6><br /><br />
																</td>
																<td width="25%">
																	<h6 style="font-weight: normal;margin: 3px;font-size: 10px;color: #111109;">Approved by:</h6><br /><br />
																</td>
																<td width="25%">
																	<h6 style="font-weight: normal;margin: 3px;font-size: 10px;color: #111109;">Received by / Date Received:</h6><br /><br />
																</td>
															</tr>
															<tr>
																<td width="25%" style="text-align: center;">
																<label id="lblprepby"></label>
																	<hr style="border-color: #111109;width: 90%;margin:0px;">
																</td>
																<td width="25%" style="text-align: center;">
																<label id="lblchkby"></label>
																	<hr style="border-color: #111109;width: 90%;margin:0px;">
																</td>
																<td width="25%" style="text-align: center;">
																<label id="lblapprby"></label>
																	<hr style="border-color: #111109;width: 90%;margin:0px;">
																</td>
																<td width="25%" style="text-align: center;">
																<label id="lblrcvdby"></label>
																	<hr style="border-color: #111109;width: 90%;margin:0px;">
																</td>
															</tr>
															<tr>
																<td width="25%">
																	<h6 style="font-weight: normal;margin: 0px;font-size: 10px;color: #111109;text-align: center;">Billing, Credit and Collection</h6>
																</td>
																<td width="25%">
																	<h6 style="font-weight: normal;margin: 0px;font-size: 10px;color: #111109;text-align: center;">Authorized Signatory</h6>
																</td>
																<td width="25%">
																	<h6 style="font-weight: normal;margin: 0px;font-size: 10px;color: #111109;text-align: center;">Authorized Signatory</h6>
																</td>
																<td width="25%">
																	<h6 style="font-weight: normal;margin: 0px;font-size: 10px;color: #111109;text-align: center;">Signature over Printed Name</h6>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</tbody>
										</table>
									</center>
									<div class="divFooter"><h6 id="print_footer"></h6></div>
								</div>
							</center>
						</div>                
	              	</div>
	          	</div>
	          	<div class="row form-group" style="">
		            <div class="col-md-2 col-xs-12" style="padding-right:0px;"></div>
		            <div class="col-md-10 col-xs-12" style="">
		                <button type="button" class="btn btn-primary hide isadmin select-printsoa btn-round btn-sm" style="float: right;" id="" onclick="printsoa()">&nbsp;Print</button>
		            </div>
	          	</div>
	      	</div>
	    </div>
  	</div>
</div>