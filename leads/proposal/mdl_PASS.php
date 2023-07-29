<div class="modal fade fade-scale" id="mdl_PASS" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-lg" style="width:90%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" onclick="fncXmdl_PASS()">&times;</button>
				<h4 class="modal-title" style="font-family: Roboto;font-size: 18px;">Add Unit Information</h4>
			</div>

			<div class="modal-body">
				<input type="hidden" id="txtPASSproposalCount">
				<input type="hidden" id="txtPASSInquiryID">
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
														<div class="col-md-8">
															<div class="row form-group">
                                                                <h4 class="green">Unit Information</h4>
                                                            </div>
                                                            <div class="col-md-6">
																<div class="row form-group">
																	<label class="col-md-4" style="white-space: nowrap;">&nbsp;</label>
																	<div class="col-md-8">
																		<button class="btn btn-primary btn-sm col-md-12 btn-round" id="btnshortucutunit" onclick="$('#txtPassPage').val('1'); fncPASSSelectUnit(); $('#mdlPASSSelectUnit').modal('show');"><i class="ace-icon fa fa-level-up"></i>&nbsp;Select Unit</button>
																	</div>
																</div>
																<div class="row form-group">
																	<label class="col-md-4 col-xs-4" style="white-space: nowrap;">Unit Type</label>
																	<div class="col-md-4 col-xs-4">
																		<div class="radio">
																			<label>
																				<input name="form-field-radio" type="radio" class="ace" id="rdPassSET" onclick="fncclickPassInqSET()" value="SET" />
																				<span class="lbl">&nbsp;&nbsp;&nbsp;SET</span>
																			</label>
																		</div>
																	</div>
																	<div class="col-md-4 col-xs-4">
																		<div class="radio">
																			<label>
																				<input name="form-field-radio" type="radio" class="ace" id="rdPassLCA" onclick="fncclickPassInqLCA()" value="LCA" />
																				<span class="lbl">&nbsp;&nbsp;&nbsp;LCA</span>
																			</label>
																		</div>
																	</div>
																</div>
																<div class="row form-group">
																	<div class="col-md-4 col-xs-12">
																		<label class="txtSysBuilding">Branch</label>
																	</div>
																	<div class="col-md-8 col-xs-12">
																		<select id="txtPASSMallID" class="form-control txtPassInq"></select>
																	</div>
																</div>
	                											<?php if(SysLeaseSetup('isClassification') == "1"){ ?> 
																<div class="row form-group">
																	<label class="col-md-4">Classification</label>
																	<div class="col-md-8">
																		<input type="hidden" id="txtPASSClassID" class="txtPassInq">
																		<input type="text" id="txtPASSClassName" class="form-control  txtPassInq" readonly>
																	</div>
																</div>
												                <?php } ?>
												                <?php if(SysLeaseSetup('isDepartment') == "1"){ ?>
																<div class="row form-group">
																	<label class="col-md-4">Department</label>
																	<div class="col-md-8">
																		<input type="hidden" id="txtPASSDepID" class="txtPassInq">
																		<input type="text" id="txtPASSDepName" class="form-control  txtPassInq" readonly>
																	</div>
																</div>
												                <?php } ?>
												                <?php if(SysLeaseSetup('isCategory') == "1"){ ?>
																<div class="row form-group">
																	<label class="col-md-4">Category</label>
																	<div class="col-md-8">
																		<input type="hidden" id="txtPASSCatID" class="txtPassInq">
																		<input type="text" id="txtPASSCatName" class="form-control  txtPassInq" readonly>
																	</div>
																</div>
												                <?php } ?>
																<div class="row form-group">
																	<label class="col-md-4">Wing/Bldg</label>
																	<div class="col-md-8">
																		<input type="hidden" id="txtPASSWingID" class="txtPassInq">
																		<input type="text" id="txtPASSWingName" class="form-control  txtPassInq" readonly>
																	</div>
																</div>
																<div class="row form-group">
																	<label class="col-md-4">Floor</label>
																	<div class="col-md-8">
																		<input type="hidden" id="txtPASSFloorID" class=" txtPassInq">
																		<input type="text" id="txtPASSFloorName" class="form-control  txtPassInq" readonly>
																	</div>
																</div>
															</div>
                                                            <div class="col-md-6">
	                                                            <div class="row form-group">
																	<label class="col-md-4">Unit</label>
																	<div class="col-md-8">
																		<input type="hidden" id="txtPASSUnitID" class="txtPassInq">
																		<input type="text" id="txtPASSUnitName" class="form-control txtPassInq" readonly>
																	</div>
																</div>
																<div class="row form-group" id="divPassAreaSET">
																	<label class="col-md-4" style="white-space: nowrap;">Unit Area</label>
																	<div class="col-md-8">
																		<input type="text" class="form-control txtPassInq" id="txtPASSSQM" style="text-align: right;" readonly placeholder="Square Meter">
																	</div>
																</div>
																<div class="row form-group" id="divPassLCA">
																	<label class="col-md-4" style="white-space: nowrap;">Unit Area (L x W)</label>
																	<div class="col-md-4 pull-right">
																		<input type="text" class="form-control txtPassInq" id="txtPASSWidth" style="text-align: right;" readonly  placeholder="Width">
																	</div>
																	<div class="col-md-4 pull-right">
																		<input type="text" class="form-control txtPassInq" id="txtPASSLength" style="text-align: right;" readonly onkeyup="unitareachk()" placeholder="Length">
																	</div>
																</div>
																<div class="row form-group">
																	<label class="col-md-4" style="white-space: nowrap;">Rate</label>
																	<div class="col-md-8">
																		<input type="text" class="form-control txtPassInq" onkeyup="unitareachk()" style="text-align: right;" placeholder="0.00" id="txtPASSRate" readonly>
																	</div>
																</div>
	                											<?php if(SysLeaseSetup('isAssocDues') == "1"){ ?> 
																<div class="row form-group">
																	<label class="col-md-4" style="white-space: nowrap;">Association Dues</label>
																	<div class="col-md-8">
																		<input type="text" class="form-control txtPassInq" style="text-align: right;" placeholder="0.00" id="txtPASSAssocDues" readonly>
																	</div>
																</div>
												                <?php } ?>
																<div class="row form-group">
																	<label class="col-md-4">Occupancy Start Date</label>
																	<div class="col-md-8">
																		<input class="form-control jonas-date-picker txtPassInq" id="txtPASSOccuStartDate" type="text" data-date-format="m/d/Y" onchange="fncgetAmortSched();" onkeyup="fncgetAmortSched();" />
																	</div>
																</div>
																<div class="row form-group">
																	<label class="col-md-4">Months</label>
																	<div class="col-md-3">
																		<input class="form-control txtPassInq" id="txtPASSMonths" type="text" maxlength="3" onkeyup="fncgetAmortSched();">
																	</div>
																	<label class="col-md-2">Interest</label>
																	<div class="col-md-3">
																		<span class="input-icon input-icon-right" style="width: 100%;" id="txtNDTPercentagedisplay">
	                                                                        <input id="txtPASSInterestPerc" class="form-control numonly txtPassInq" maxlength="2" onkeyup="fncgetAmortSched();">
	                                                                        <span class="ace-icon fa fa-percent"></span>
	                                                                    </span>
																	</div>
																</div>
																<div class="row form-group hide">
																	<label class="col-md-4">Downpayment Type</label>
																	<div class="col-md-4">
																		<div class="radio">
																			<label>
																				<input name="rdoPASSDeposit" type="radio" class="ace rdoPASSDeposit isFinal" value="Percentage" checked>
																				<span class="lbl"> Percentage</span>
																			</label>
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="radio" style="white-space: nowrap;">
																			<label>
																				<input name="rdoPASSDeposit" type="radio" class="ace rdoPASSDeposit isFinal" value="Amount">
																				<span class="lbl"> Amount</span>
																			</label>
																		</div>
																	</div>
																</div>
																<div class="row form-group hide">
																	<label class="col-md-4">Downpayment</label>
																	<div class="col-md-5">
																		<input type="text" class="form-control txtPassInq txtSysNumOnly" id="txtPASSDownPayment" onkeyup="fncgetAmortSched();">
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="row form-group">
                                                                <h4 class="green">Amenities</h4>
                                                            </div>
															<div class="row form-group">
																<div class="col-md-12 col-xs-12" style="height: 383px;overflow-y: scroll;">
																	<div id="txtPASSAmenities"></div>
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
					                                    	<h4 class="green">Amortization Schedule</h4>
					                                    	<div class="parent">
						                                        <div id="LoadPaySchedule"></div>
						                                        <table class="table table-striped table-bordered table-hover fixTable">
						                                            <thead>
						                                                <tr>
						                                                    <th>Date</th>
						                                                    <th>Beggining Balance</th>
						                                                    <th>Payment</th>
						                                                    <th>Interest</th>
						                                                    <th>Principal</th>
						                                                    <th>Ending Balance</th>
						                                                </tr>
						                                            </thead>
						                                            <tbody id="tblAmortSched"></tbody>
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
			<div class="modal-footer">
				<button class="btn btn-primary btn-round btn-sm" id="btnSaveProposal" onclick="fncSavePASSProposal()"><span class="fa fa-check"></span> Save</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade fade-scale" role="dialog" id="mdlPASSSelectUnit" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div id="preloadPASSSelectUnit"></div>
			<div class="modal-header">
				<button type="button" class="close" onclick="$('#mdlPASSSelectUnit').modal('hide');">×</button>
				<h4 class="modal-title" style="font-family: Roboto;font-size: 18px;">List of Units</h4>
			</div>
			<div class="modal-body">
				<div class="row form-group" style="padding-left:0px; margin-bottom: 0px !important;">
					<div class="col-md-4">
						<span class="input-icon" style="width: 100%;">
	                        <input type="text" class="form-control" placeholder="Search Unit" id="txtPASSSearch">
	                        <i class="ace-icon fa fa-search nav-search-icon"></i>
	                    </span>
					</div>
				</div>
				<div class="row form-group" style="margin-bottom: 0px !important;">
		        	<div class="col-md-12">
						<div class="parent">
							<table class="table table-hover table-bordered fixTable">
								<thead>
									<th width='30%'>Unit ID</th>
									<th width='40%'>Unit Name</th>
									<th width='5%' style="z-index: 1;">Option</th>
								</thead>
								<tbody id="tblPASSSelectUnit"></tbody>
							</table>
						</div>
						<table class="tabledash_footer table" style="margin: 0px !important;">
			              	<thead>
				                <tr>
				                  	<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
					                    <font id="txtPASSEntries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
					                    <input id="txtPassPage" type="hidden">
					                    <ul id="ulPASSPagination" class="pagination pull-right"></ul>
				                  	</th>
				                </tr>
			              	</thead>
			            </table>
			        </div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade fade-scale" role="dialog" id="mdl_ProUnitInfo2" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" onclick="$('#mdl_ProUnitInfo2').modal('hide');">×</button>
				<h4 class="modal-title" style="font-family: Roboto;font-size: 18px;">Select Unit</h4>
			</div>
			<div class="modal-body">
				<div class="row form-group">
					<div class="col-md-12">
						<div id="divProUnitListContainer2"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade fade-scale" id="viewPASSProposal" role="dialog">
  	<div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      	<div class="modal-body">
		        <div class="row form-group"> 
		          	<span class="ace-icon fa fa-times bigger-150 pull-right" style="margin-right: 10px;" onclick='$("#viewPASSProposal").modal("hide")'></span>
		        </div>
		        <div class="row form-group" id="divPassProposal">
		            <div class="col-md-12">
		              	<table style="width: 100%;margin-top: 10px;" cellspacing="0" cellpadding="0">
		                	<tbody class="templatePass"></tbody>
		              	</table>
		              	<div class="row form-group" style="margin-top:5px;">
		              		<table style="width: 100%">
		              			<tr>
			                		<th style="font-size: 22px;font-weight: bold;background-color: #666;color: white;width: 100%;text-align: center;">Tenant Information</th>
			                	</tr>
		              		</table>
		              		<table style="width: 100%;">
			                	<tr>
			                  		<td style="width: 20%;font-weight: bold;">Tenant Name</td>
			                  		<td style="width: 80%"><label id="printPASSTenantName"></label></td>
			                  	</tr>
			                	<tr>
			                  		<td style="width: 20%;font-weight: bold;">Address</td>
			                  		<td style="width: 80%"><label id="printPASSAddress"></label></td>
			                  	</tr>
			                  	<tr>
			                  		<td style="width: 20%;font-weight: bold;">Contact #</td>
			                  		<td style="width: 80%"><label id="printPASSContact"></label></td>
			                  	</tr>
			                </table>
		              		<table style="width: 100%">
		              			<tr>
			                		<th style="font-size: 22px;font-weight: bold;background-color: #666;color: white;width: 100%;text-align: center;">Unit Information</th>
			                	</tr>
		              		</table>
			                <table style="width: 50%;float: left;">
			                	<tr>
			                  		<td style="width: 30%;font-weight: bold;">Unit Type</td>
			                  		<td style="width: 70%"><label id="printPASSUnitType"></label></td>
			                  	</tr>
			                	<tr>
			                  		<td style="width: 30%;font-weight: bold;">Unit</td>
			                  		<td style="width: 70%"><label id="printPASSUnitName"></label></td>
			                  	</tr>
			                  	<tr>
			                  		<td style="font-weight: bold;">Unit ID</td>
			                  		<td><label id="printPASSUnitID"></label></td>
			                  	</tr>
								<?php if(SysLeaseSetup('isClassification') == "1"){ ?> 
			                  	<tr>
			                  		<td style="font-weight: bold;">Classification</td>
			                  		<td><label id="printPASSClassification"></label></td>
			                  	</tr>
			                  	<?php } ?>
				                <?php if(SysLeaseSetup('isDepartment') == "1"){ ?>
			                  	<tr>
			                  		<td style="font-weight: bold;">Department</td>
			                  		<td><label id="printPASSDepartment"></label></td>
			                  	</tr>
			                  	<?php } ?>
				                <?php if(SysLeaseSetup('isCategory') == "1"){ ?>
			                  	<tr>
			                  		<td style="font-weight: bold;">Category</td>
			                  		<td><label id="printPASSCategory"></label></td>
			                  	</tr>
			                  	<?php } ?>
			                  	<tr>
			                  		<td style="font-weight: bold;">Wing</td>
			                  		<td><label id="printPASSWing"></label></td>
			                  	</tr>
			                  	<tr>
			                  		<td style="font-weight: bold;">Floor</td>
			                  		<td><label id="printPASSFloor"></label></td>
			                  	</tr>
			                  	<tr>
			                  		<td style="font-weight: bold;">Area</td>
			                  		<td><label id="printPASSArea"></label></td>
			                  	</tr>
			                  	<tr>
			                  		<td style="font-weight: bold;">Rate</td>
			                  		<td><label id="printPASSRate"></label></td>
			                  	</tr>
								<?php if(SysLeaseSetup('isAssocDues') == "1"){ ?> 
			                  	<tr>
			                  		<td style="font-weight: bold;">Association Dues</td>
			                  		<td><label id="printPASSAssocDues"></label></td>
			                  	</tr>
			                  	<?php } ?>
			                </table>
			                <table style="width: 50%;float: right;">
			                  	<tr>
			                  		<th>Amenities</th>
			                  	</tr>
			                  	<tbody id="tbodyprintPASSAmenities"></tbody>
			                </table>
		              	</div>
		              	<div class="row form-group" style="margin-top:5px;">
		              		<table style="width: 100%">
		              			<tr>
			                		<th style="font-size: 22px;font-weight: bold;background-color: #666;color: white;width: 100%;text-align: center;">Other Unit Information</th>
			                	</tr>
		              		</table>
		              		<div id="askdjasd"></div>
		              	</div>
		              	<div class="row form-group" style="margin-top:5px;">
		              		<table style="width: 100%">
		              			<tr>
			                		<th style="font-size: 22px;font-weight: bold;background-color: #666;color: white;width: 100%;text-align: center;">Amortization Schedule</th>
			                	</tr>
		              		</table>
			                <table style="width: 100%;">
			                	<thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Beggining Balance</th>
                                        <th>Payment</th>
                                        <th>Interest</th>
                                        <th>Principal</th>
                                        <th>Ending Balance</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyPrintPASSAmortSched"></tbody>
			                </table>
		              	</div>
		          	</div>
	        	</div>
	      	</div>
	      	<div class="modal-footer">
	      		<button class="btn btn-primary btn-round btn-sm" onclick="fncPrintPASSProposal2();">Print</button>
	      	</div>
	    </div>
  	</div>
</div>

<script type="text/javascript">
	$(function(){
		fncShowMallList();
		$("#txtPASSSearch").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPassPage").val("1");
				fncPASSSelectUnit(); 
			}else if ( x == '8' ){
				if($('#txtPASSSearch').val() == ""){
					$("#txtPassPage").val("1");
					fncPASSSelectUnit();
				}
			}
		});
		$(".rdoPASSDeposit").click(function(){
			if($(this).is(":checked")){
				if($(this).val() == "Percentage"){
					$("#txtPASSDownPayment").css("text-align", "left");
					$("#txtPASSDownPayment").unbind("change");
					$("#txtPASSDownPayment").attr("maxlength", "2");
				}else{
					$("#txtPASSDownPayment").css("text-align", "right");
					$("#txtPASSDownPayment").removeAttr("maxlength");
					$("#txtPASSDownPayment").change(function(){
				        var x = ($(this).val()).replace(/,/g,"");
				        var v = parseFloat(x||0);
				        $(this).val(v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
				    });
				}
				$("#txtPASSDownPayment").val("0");
				fncgetAmortSched();
			}
		})
	})
	
	function fncShowMallList(){
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=tblref_mall',
			success: function(data){
				$("#txtPASSMallID").html(data);
			}
		})
	}

	function fncclickPassInqSET(){
		$(".txtPassInq").val("");
		$(".txtPassInq").css("border-color","#D5D5D5");
		$("#divPassAreaSET").css("display", "block");
		$("#divPassLCA").css("display", "none");
		$("#rdPassSET").prop("checked", true);
	}

	function fncclickPassInqLCA(){
		$(".txtPassInq").val("");
		$(".txtPassInq").css("border-color","#D5D5D5");
		<?php if(SysLeaseSetup('floorandunitmeasurement') == 'Area'){ ?>
			$("#divPassLCA").css("display", "none");
			$("#divPassAreaSET").css("display", "block");
		<?php }else{ ?>
			$("#divPassLCA").css("display", "block");
			$("#divPassAreaSET").css("display", "none");
		<?php } ?>
		$("#rdPassLCA").prop("checked", true);
	}

	function fncPASSSelectUnit(){
		var MallID = $("#txtPASSMallID").val();
		var page = $("#txtPassPage").val();
		if ($("#rdPassSET").is(":checked")){
			var typeunit = "SET";
		}else if ($("#rdPassLCA").is(":checked")){
			var typeunit = "LCA";
		}
		var key = $("#txtPASSSearch").val();
		$.ajax({
			type: 'POST',
			url: 'leads/proposal/class2.php',
			data: 'typeunit=' + typeunit + '&MallID=' + MallID + '&page=' + page + '&key=' + key + '&form=fncPASSSelectUnit',
			beforeSend : function() {
				$('#preloadPASSSelectUnit').addClass('myspinner');
			},
			success: function(data){
				$('#preloadPASSSelectUnit').removeClass('myspinner');
				if(data != "") {
					$("#tblPASSSelectUnit").html(data);
				}else{
					$("#tblPASSSelectUnit").html("<tr><td colspan='6' style='text-align: center;'>No Data Found...</td></tr>");
				}
				fncPASSSelectUnitEntries();
				fncPASSSelectUnitPagination();
			}
		})
	}

	function fncPASSSelectUnitEntries(){
		var MallID = $("#txtPASSMallID").val();
		var page = $("#txtPassPage").val();
		if($("#rdPassSET").is(":checked")){
		  	var typeunit = "SET";
		}else if($("#rdPassLCA").is(":checked")){
		  	var typeunit = "LCA";
		}
		var key = $("#txtPASSSearch").val();
		$.ajax({
		  	type: 'POST',
		  	url: 'leads/proposal/class2.php',
		  	data: 'typeunit=' + typeunit + '&MallID=' + MallID + '&page=' + page + '&key=' + key + '&form=fncPASSSelectUnitEntries',
		  	success: function(data){
			  	$("#txtPASSEntries").text(data);
		  	}
		});
  	}

  	function fncPASSSelectUnitPagination(){
		var MallID = $("#txtPASSMallID").val();
		var page = $("#txtPassPage").val();
		if($("#rdPassSET").is(":checked")){
	  		var typeunit = "SET";
		}else if($("#rdPassLCA").is(":checked")){
	  		var typeunit = "LCA";
		}
		var key = $("#txtPASSSearch").val();
		$.ajax({
	  		type: 'POST',
	  		url: 'leads/proposal/class2.php',
	  		data: 'typeunit=' + typeunit + '&MallID=' + MallID + '&page=' + page + '&key=' + key + '&form=fncPASSSelectUnitPagination',
	  		success: function(data){
				$("#ulPASSPagination").html(data);
	  		}
		});
  	}

  	function ViewUnitInformation2(UnitID){
    	$("#mdl_ProUnitInfo2").modal("show");
    	$.ajax({
    		type: 'POST',
	  		url: 'leads/proposal/class2.php',
	  		data: 'UnitID=' + UnitID + '&form=ViewUnitInformation',
	  		success: function(data){
	  			$("#divProUnitListContainer2").html(data);
	  		}, complete: function(){
	  			var colorbox_params = {
		          	rel: 'colorbox',
				   	reposition: true,
				  	scalePhotos: true,
				    scrolling: false,
					title: false,
			     	previous: '<i class="ace-icon fa fa-arrow-left"></i>',
		         	next: '<i class="ace-icon fa fa-arrow-right"></i>',
			        close: '&times;',
			      	current: '{current} of {total}',
			     	maxWidth: '100%',
				    maxHeight: '100%',
				   	onComplete: function(){
				     	$.colorbox.resize();
				   	}
				}
				$('[data-rel="colorbox"]').colorbox(colorbox_params);
				$('#cboxLoadingGraphic').append("<i class='ace-icon fa fa-spinner orange'></i>");
	  		}
    	})
    }

    function fncChangeSelectID2(UnitID){
    	$("#btnChangeSelectID2").attr("onclick", "SelectThisUnit2(\""+ UnitID +"\")");
    }

    function SelectThisUnit2(unitid){
		$.ajax({
			type: 'POST',
			url: 'leads/proposal/class.php',
			data: 'unitid=' + unitid + '&form=SelectThisUnit',
			success:function(data){
				var arr = data.split("|");
				$("#txtPASSClassID").val(arr[0]);
				$("#txtPASSClassName").val(arr[1]);
				$("#txtPASSDepID").val(arr[2]);
				$("#txtPASSDepName").val(arr[3]);
				$("#txtPASSCatID").val(arr[4]);
				$("#txtPASSCatName").val(arr[5]);
				$("#txtPASSWingID").val(arr[6]);
				$("#txtPASSWingName").val(arr[7]);
				$("#txtPASSFloorID").val(arr[8]);
				$("#txtPASSFloorName").val(arr[9]);
				$("#txtPASSUnitID").val(arr[10]);
				$("#txtPASSUnitName").val(arr[11]);
				$("#txtPASSSQM").val(arr[12]);
				$("#txtPASSWidth").val(arr[13]);
				$("#txtPASSLength").val(arr[14]);
				$("#txtPASSRate").val(arr[16]);
				$('#mdlPASSSelectUnit').modal('hide');
				$("#txtPASSAssocDues").val(arr[17]);
			},
			complete: function(){
				fncgetAmortSched();
			}
		})
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'unit_id=' + unitid + '&form=selected_unit_amenities',
			success:function(data){
				$("#txtPASSAmenities").html(data);
			}
		})
		$("#mdl_ProUnitInfo2").modal("hide");
	}

	function fncgetAmortSched(){
		var Months = $("#txtPASSMonths").val();
		var Perc = $("#txtPASSInterestPerc").val().replace(/,/g, "");
		var Rate = $("#txtPASSRate").val().replace(/,/g, "");
		var StartDate = $("#txtPASSOccuStartDate").val();
		var getDowntype = "";
		$(".rdoPASSDeposit").each(function(){
			if($(this).is(":checked")){
				getDowntype = $(this).val();
			}
		})
		var Downpayment = $("#txtPASSDownPayment").val().replace(/,/g, "");
		$.ajax({
			type: 'POST',
			url: 'leads/proposal/class2.php',
			data: 'Months=' + Months + '&Perc=' + Perc + '&Rate=' + Rate + '&StartDate=' + StartDate + '&getDowntype=' + getDowntype + '&Downpayment=' + Downpayment + '&form=fncgetAmortSched',
			success: function(data){
				$("#tblAmortSched").html(data);
			}
		})
	}

	function fncSavePASSProposal(){
		var id = $("#txtPASSproposalCount").val();
		var InquiryID = $("#txtPASSInquiryID").val();
		var MallID = $("#txtPASSMallID").val();
		var ClassID = $("#txtPASSClassID").val();
		var DepID = $("#txtPASSDepID").val();
		var CatID = $("#txtPASSCatID").val();
		var WingID = $("#txtPASSWingID").val();
		var FloorID = $("#txtPASSFloorID").val();
		var unitID = $("#txtPASSUnitID").val();
		var UnitRate = $("#txtPASSRate").val().replace(/,/g, "");
		<?php if(SysLeaseSetup('isAssocDues') == "1"){ ?> 
		var AssocDues = $("#txtPASSAssocDues").val().replace(/,/g, "");
		<?php }else{ ?>
		var AssocDues = 0;
		<?php } ?>
		var Months = $("#txtPASSMonths").val();
		var Percentage = $("#txtPASSInterestPerc").val();
		var DownPayment = $("#txtPASSDownPayment").val();
		var OccuStartDate = $("#txtPASSOccuStartDate").val();
		var DPType = "";
		$(".rdoPASSDeposit").each(function(){
			if($(this).is(":checked")){
				DPType = $(this).val();
			}
		})
		$.ajax({
			type: 'POST',
			url: 'leads/proposal/class2.php',
			data: 'id=' + id + '&InquiryID=' + InquiryID + '&MallID=' + MallID + '&ClassID=' + ClassID + '&DepID=' + DepID + '&CatID=' + CatID + '&WingID=' + WingID + '&FloorID=' + FloorID + '&unitID=' + unitID + '&UnitRate=' + UnitRate + '&AssocDues=' + AssocDues + '&Months=' + Months + '&Percentage=' + Percentage + '&DownPayment=' + DownPayment + '&OccuStartDate=' + OccuStartDate + '&DPType=' + DPType + '&form=fncSavePASSProposal',
			success: function(data){
				if(id == ""){
					setTimeout(function(){
						showmodal("alert", "Proposal successfully created.", "displayProposal", InquiryID+"|", "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Proposal successfully updated.", "displayProposal", InquiryID+"|", "", null, "0");
					}, 500)
				}
				$("#mdl_PASS").modal("hide");
			}
		})
	}

	function fncXmdl_PASS(){
		$("#mdl_PASS").modal("hide");
	}

	function fncModProPASS(id, UnitID, UnitType, MallID, OccuDate, Months, Interest, DPType, Downpayment){
		$("#mdl_PASS").modal("show");
		$("#txtPASSproposalCount").val(id);
		if(UnitType == "SET"){
			fncclickPassInqSET();
		}else{
			fncclickPassInqLCA();
		}
		$("#txtPASSMallID").val(MallID);
		$("#txtPASSOccuStartDate").val(OccuDate);
		$("#txtPASSMonths").val(Months);
		$("#txtPASSInterestPerc").val(Interest);
		$(".rdoPASSDeposit").each(function(){
			if($(this).val() == DPType){
				$(this).prop("checked", true);
			}
		})
		$("#txtPASSDownPayment").val(Downpayment);
		setTimeout(function(){
			SelectThisUnit2(UnitID);
		}, 2000)
	}

	function setDefault2(id){
		showmodal("confirm", "Are you sure you want to set this as default?", "setDefault22", id+"|", "", null, "1");
	}

	function setDefault22(id){
		var inquiryID = $("#txtPASSInquiryID").val();
		$.ajax({
			type: 'POST',
			url: 'leads/proposal/class2.php',
			data: 'id=' + id + '&form=setDefault22',
			success: function(data){
				setTimeout(function(){
					showmodal("alert", "Successfully set as active.", "displayProposal", inquiryID+"|", "", null, "0");
				}, 500)
			}
		});
	}

	function fncPrintPASSProposal(id, InquiryID, MallID, UnitID, AmortMonth, AmortPerc, AmortRate, AmortStartDate, AmortDownType, AmortDownpayment){
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'mallID=' + MallID + '&form=getheaderprint',
			success:function(data){
				$(".templatePass").html(data);
			}
		});
		$.ajax({
			type: 'POST',
			url: 'leads/proposal/class2.php',
			data: 'UnitID=' + UnitID + '&form=fncPrintPASSProposal',
			success: function(data){
				var arr = data.split("|");
				$("#printPASSUnitType").text(arr[0]);
				$("#printPASSUnitName").text(arr[1]);
				$("#printPASSUnitID").text(arr[2]);
				$("#printPASSClassification").text(arr[3]);
				$("#printPASSDepartment").text(arr[4]);
				$("#printPASSCategory").text(arr[5]);
				$("#printPASSWing").text(arr[6]);
				$("#printPASSFloor").text(arr[7]);
				$("#printPASSArea").text(arr[8]);
				$("#printPASSRate").text(arr[9]);
				$("#printPASSAssocDues").text(arr[10]);
				$("#tbodyprintPASSAmenities").html(arr[11]);
				$("#askdjasd").html(arr[12]);
				
			}, complete: function(){
				$.ajax({
					type: 'POST',
					url: 'leads/proposal/class2.php',
					data: 'Months=' + AmortMonth + '&Perc=' + AmortPerc + '&Rate=' + AmortRate + '&StartDate=' + AmortStartDate + '&getDowntype=' + AmortDownType + '&Downpayment=' + AmortDownpayment + '&form=fncgetAmortSched2',
					success: function(data){
						$("#tbodyPrintPASSAmortSched").html(data);
					}, complete: function(){
						$.ajax({
							type: 'POST',
							url: 'leads/proposal/class2.php',
							data: 'InquiryID=' + InquiryID + '&form=getInquiry',
							success: function(data){
								var arr = data.split("|");
								$("#printPASSTenantName").text(arr[0]);
								$("#printPASSAddress").text(arr[1]);
								$("#printPASSContact").text(arr[2]);
							}, complete: function(){
								fncPrintPASSProposal2();
							}
						})
					}
				})
			}
		})
	}

	function fncPrintPASSProposal2(){
        var toPrint = document.getElementById("divPassProposal");
        var myheight = $(window).height()-40;
        var mywidth = $(window).width()-40;
        var popupWin = window.open("", "", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
            popupWin.document.open();
            popupWin.document.write('<html><title></title><style>@media print{ table{ page-break-after:auto } tr{ page-break-inside:avoid; page-break-after:auto } td{ page-break-inside:avoid; page-break-after:auto } thead{ display:table-header-group } tfoot{ display:table-footer-group } }</style><body onload="window.print();">' );
            popupWin.document.write( toPrint.innerHTML);
            popupWin.document.write('</body></html>');
            popupWin.document.close();
    }

    function fncSendReservation(){

    }
</script>