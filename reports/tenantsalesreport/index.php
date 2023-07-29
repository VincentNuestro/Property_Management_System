<div class="row">
	<div class="col-md-12">
		<div class="row form-group" style="margin-bottom: 0px;">
			<div class="col-md-2 div_ListVIew" style="padding-bottom: 5px;padding-left: 0px;">
				<select class="form-control selectMall" id="txtTSRMall"></select>
			</div>
			<div class="col-md-2 div_ListVIew" style="padding-bottom: 5px;padding-left: 0px;">
				<span class="input-icon" style="width: 100%;">
	              	<input type="text" class="form-control" id="txtSearchTenantName" placeholder="Search Tenant">
	              	<i class="ace-icon fa fa-search nav-search-icon"></i>
	          	</span>
			</div>
			<div class="col-md-3 div_ListVIew" style="padding-bottom: 5px;padding-left: 0px;">
				<div class="input-daterange input-group">
					<input type="text" class="form-control date-picker" id="dateFromList" value="<?php echo date('m/d/Y'); ?>">
					<span class="input-group-addon">
						<i class="fa fa-exchange"></i>
					</span>
					<input type="text" class="form-control date-picker" id="dateToList" value="<?php echo date('m/d/Y'); ?>">
				</div>
			</div>
			<div class="col-md-1 div_ListVIew" style="padding-bottom: 5px;padding-left: 0px;">
				<button class="btn btn-primary btn-sm btn-round" onclick="clickforall()"> Go</button>
			</div>

			<!-- ruth -->
			<div class="col-md-2 div_ListVIew" style="padding-bottom: 5px;padding-left: 0px;">
				<div class='btn-group' id="pdailysales">
			       <button class='btn btn-primary btn-round btn-sm' onclick="$arr = [];$arr.push( 'page='+$('#txtTSRPage').val() );$arr.push( 'key='+$('#txtSearchTenantName').val() );$arr.push( 'DateFrom='+$('#dateFromList').val() );$arr.push( 'DateTo='+$('#dateToList').val() );$arr.push( 'mallid='+$('#txtTSRMall').val() );getheaderprint('<?php echo $_SESSION['MMS-Designation']; ?>','printtenantdailysales',JSON.stringify($arr));" data-placement="bottom">Print Daily Sales</button> 
			        <button data-toggle='dropdown' class='btn dropdown-toggle btn-primary btn-round btn-sm'>
			            <span class='ace-icon fa fa-caret-down icon-only'></span>
			        </button>
			        <ul class='dropdown-menu pull-right'>
			            <li>
			                <a onclick="AutoConsolidatedailysales();">Export</a>
			            </li>
					</ul>
				</div>

				<div class='btn-group' id="phrsales">
			       <button class='btn btn-primary btn-round btn-sm' onclick="$arr = [];$arr.push( 'page='+$('#txtTSRPage').val() );$arr.push( 'tenant='+$('#txtSearchTenantName').val() );$arr.push( 'datefrom='+$('#dateFromList').val() );$arr.push( 'dateto='+$('#dateToList').val() );$arr.push( 'mallid='+$('#txtTSRMall').val() );getheaderprint('<?php echo $_SESSION['MMS-Designation']; ?>','printtenantsalesreporthourly',JSON.stringify($arr));" data-placement="bottom">Print Hourly Sales</button> 
			        <button data-toggle='dropdown' class='btn dropdown-toggle btn-primary btn-round btn-sm'>
			            <span class='ace-icon fa fa-caret-down icon-only'></span>
			        </button>
			        <ul class='dropdown-menu pull-right'>
			            <li>
			                <a onclick="AutoConsolidatehourlysales();">Export</a>
			            </li>
					</ul>
				</div>

				<div class='btn-group' id="ppayment">
			       <button class='btn btn-primary btn-round btn-sm' onclick="$arr = [];$arr.push( 'page='+$('#txtTSRPage').val() );$arr.push( 'key='+$('#txtSearchTenantName').val() );$arr.push( 'DateFrom='+$('#dateFromList').val() );$arr.push( 'DateTo='+$('#dateToList').val() );$arr.push( 'mallid='+$('#txtTSRMall').val() );getheaderprint('<?php echo $_SESSION['MMS-Designation']; ?>','printdailypayment',JSON.stringify($arr));" data-placement="bottom">Print Daily Sales</button> 
			        <button data-toggle='dropdown' class='btn dropdown-toggle btn-primary btn-round btn-sm'>
			            <span class='ace-icon fa fa-caret-down icon-only'></span>
			        </button>
			        <ul class='dropdown-menu pull-right'>
			            <li>
			                <a onclick="AutoConsolidatepayment();">Export</a>
			            </li>
					</ul>
				</div>

				<div class='btn-group' id="pdiscount">
			       <button class='btn btn-primary btn-round btn-sm' onclick="$arr = [];$arr.push( 'page='+$('#txtTSRPage').val() );$arr.push( 'tenant='+$('#txtSearchTenantName').val() );$arr.push( 'datefrom='+$('#dateFromList').val() );$arr.push( 'dateto='+$('#dateToList').val() );$arr.push( 'mallid='+$('#txtTSRMall').val() );getheaderprint('<?php echo $_SESSION['MMS-Designation']; ?>','printsalesdiscount',JSON.stringify($arr));" data-placement="bottom">Print Discount</button> 
			        <button data-toggle='dropdown' class='btn dropdown-toggle btn-primary btn-round btn-sm'>
			            <span class='ace-icon fa fa-caret-down icon-only'></span>
			        </button>
			        <ul class='dropdown-menu pull-right'>
			            <li>
			                <a onclick="AutoConsolidatediscount();">Export</a>
			            </li>
					</ul>
				</div>

				<div class='btn-group' id="prefund">
			       <button class='btn btn-primary btn-round btn-sm' onclick="$arr = [];$arr.push( 'page='+$('#txtTSRPage').val() );$arr.push( 'tenant='+$('#txtSearchTenantName').val() );$arr.push( 'datefrom='+$('#dateFromList').val() );$arr.push( 'dateto='+$('#dateToList').val() );$arr.push( 'mallid='+$('#txtTSRMall').val() );getheaderprint('<?php echo $_SESSION['MMS-Designation']; ?>','printdailyrefund',JSON.stringify($arr));" data-placement="bottom">Print Refund</button> 
			        <button data-toggle='dropdown' class='btn dropdown-toggle btn-primary btn-round btn-sm'>
			            <span class='ace-icon fa fa-caret-down icon-only'></span>
			        </button>
			        <ul class='dropdown-menu pull-right'>
			            <li>
			                <a onclick="AutoConsolidaterefund();">Export</a>
			            </li>
					</ul>
				</div>
			</div>
			<!-- ruth -->
			
			<div class="col-md-2 pull-right" style="padding-bottom: 5px;padding-left: 0px;">
				<label class="pull-right" title="Change view">
					<input name="switch-field-1" class="ace ace-switch ace-switch-8" type="checkbox" id="chkReportView">
					<span class="lbl"></span>
				</label>
			</div>
		</div>
		<div class="row form-group div_ListVIew" style="margin-bottom: 0px;">
			<div class="col-md-12" style="padding-bottom: 5px;padding-left: 0px;">
				<div class="row form-group">
					<div class="col-md-12">
									<!-- <div class="btn-group pull-right hide">
										<button onclick="clicktabcontent();" class="btn btn-primary"><i class="glyphicon glyphicon-print"></i>&nbsp;&nbsp;Print</button>
									</div> -->
						<div class="row">
							<div class="col-md-12">
								<ul class="nav nav-tabs selectedtab" id="mgaList">
									<!-- ruth -->
									<li id="tabsales" onclick="showSales(); $('#pdailysales').css('display', 'inline-block'); $('#phrsales').css('display', 'none'); $('#ppayment').css('display', 'none'); $('#pdiscount').css('display', 'none'); $('#prefund').css('display', 'none');" class="active"><a data-toggle="tab">Daily Sales </a></li>

									<li id="tabhourlysales" onclick="showHour(); $('#pdailysales').css('display', 'none'); $('#phrsales').css('display', 'inline-block'); $('#ppayment').css('display', 'none'); $('#pdiscount').css('display', 'none'); $('#prefund').css('display', 'none');"><a data-toggle="tab">Hourly Sales</a></li>

									<li id="tabpayment" onclick="showPayment(); $('#pdailysales').css('display', 'none'); $('#phrsales').css('display', 'none'); $('#ppayment').css('display', 'inline-block'); $('#pdiscount').css('display', 'none'); $('#prefund').css('display', 'none');"><a data-toggle="tab">Daily Sales - Payment</a></li>

									<li id="tabdiscount" onclick="showDiscount(); $('#pdailysales').css('display', 'none'); $('#phrsales').css('display', 'none'); $('#ppayment').css('display', 'none'); $('#pdiscount').css('display', 'inline-block'); $('#prefund').css('display', 'none');"><a data-toggle="tab">Daily Sales - Discount</a></li>

									<li id="tabvoid" onclick="showCanceled(); $('#pdailysales').css('display', 'none'); $('#phrsales').css('display', 'none'); $('#ppayment').css('display', 'none'); $('#pdiscount').css('display', 'none'); $('#prefund').css('display', 'inline-block');"><a data-toggle="tab">Daily Sales - Refund / Canceled</a></li>
									<!-- ruth -->
								</ul>

								<div class="parent reportlists" style="overflow-x: scroll;" id="showSales">
									<table class="table table-bordered fixTable">
										<thead>
											<tr>
												<th style="white-space:nowrap;text-transform: uppercase;" class="thSysTenant">MERCHANT NAME</th>
												<th style="white-space:nowrap;">TRANSACTION DATE<span class="btnsortdash-dailysales fa fa-sort bigger-130 pull-right" id="a.fdtTrnsctn"></span></th>
												<th style="white-space:nowrap;">OLD GRAND TOTAL<span class="btnsortdash-dailysales fa fa-sort bigger-130 pull-right" id="fnmGrndTtlOld"></span></th>
												<th style="white-space:nowrap;">NEW GRAND TOTAL<span class="btnsortdash-dailysales fa fa-sort bigger-130 pull-right" id="fnmGrndTtlNew"></span></th>
												<th style="white-space:nowrap;">DAILY SALES<span class="btnsortdash-dailysales fa fa-sort bigger-130 pull-right" id="fnmGTDlySls"></span></th>
												<th style="white-space:nowrap;">GRAND TOTAL DISCOUNT<span class="btnsortdash-dailysales fa fa-sort bigger-130 pull-right" id="fnmGTDscnt"></span></th>
												<th style="white-space:nowrap;">TOTAL DISCOUNT - SC<span class="btnsortdash-dailysales fa fa-sort bigger-130 pull-right" id="fnmGTDscntSNR"></span></th>
												<th style="white-space:nowrap;">TOTAL DISCOUNT - PWD<span class="btnsortdash-dailysales fa fa-sort bigger-130 pull-right" id="fnmGTDscntPWD"></span></th>
												<th style="white-space:nowrap;">TOTAL DISCOUNT - GPC<span class="btnsortdash-dailysales fa fa-sort bigger-130 pull-right" id="fnmGTDscntGPC"></span></th>
												<th style="white-space:nowrap;">TOTAL DISCOUNT - VIP<span class="btnsortdash-dailysales fa fa-sort bigger-130 pull-right" id="fnmGTDscntVIP"></span></th>
												<th style="white-space:nowrap;">TOTAL DISCOUNT - EMP<span class="btnsortdash-dailysales fa fa-sort bigger-130 pull-right" id="fnmGTDscntEMP"></span></th>
												<th style="white-space:nowrap;">TOTAL DISCOUNT - REG<span class="btnsortdash-dailysales fa fa-sort bigger-130 pull-right" id="fnmGTDscntREG"></span></th>
												<th style="white-space:nowrap;">TOTAL DISCOUNT - OTH<span class="btnsortdash-dailysales fa fa-sort bigger-130 pull-right" id="fnmGTDscntOTH"></span></th>
												<th style="white-space:nowrap;">TOTAL REFUND<span class="btnsortdash-dailysales fa fa-sort bigger-130 pull-right" id="fnmGTRfnd"></span></th>
												<th style="white-space:nowrap;">TOTAL CANCELED<span class="btnsortdash-dailysales fa fa-sort bigger-130 pull-right" id="fnmGTRfnd"></span></th>
												<th style="white-space:nowrap;">TOTAL SALES VAT<span class="btnsortdash-dailysales fa fa-sort bigger-130 pull-right" id="fnmGTSlsVAT"></span></th>
												<th style="white-space:nowrap;">TOTAL SALES VAT INCLUSIVE<span class="btnsortdash-dailysales fa fa-sort bigger-130 pull-right" id="fnmGTVATSlsInclsv"></span></th>
												<th style="white-space:nowrap;">TOTAL SALES VAT EXCLUSIVE<span class="btnsortdash-dailysales fa fa-sort bigger-130 pull-right" id="fnmGTVATSlsExclsv"></span></th>
												<th style="white-space:nowrap;">DOCUMENT COUNT<span class="btnsortdash-dailysales fa fa-sort bigger-130 pull-right" id="fnmGTCntDcmnt"></span></th>
												<th style="white-space:nowrap;">CUSTOMER COUNT<span class="btnsortdash-dailysales fa fa-sort bigger-130 pull-right" id="fnmGTCntCstmr"></span></th>
												<th style="white-space:nowrap;">SENIOR CITIZEN COUNT<span class="btnsortdash-dailysales fa fa-sort bigger-130 pull-right" id="fnmGTCntSnrCtzn"></span></th>
												<th style="white-space:nowrap;">LOCAL TAX<span class="btnsortdash-dailysales fa fa-sort bigger-130 pull-right" id="fnmGTLclTax"></span></th>
												<th style="white-space:nowrap;">SERVICE CHARGE<span class="btnsortdash-dailysales fa fa-sort bigger-130 pull-right" id="fnmGTSrvcChrg"></span></th>
												<th style="white-space:nowrap;">TOTAL SALES NON-VAT<span class="btnsortdash-dailysales fa fa-sort bigger-130 pull-right" id="fnmGTSlsNonVat"></span></th>
												<th style="white-space:nowrap;">RAW GROSS<span class="btnsortdash-dailysales fa fa-sort bigger-130 pull-right" id="fnmGTRwGrss"></span></th>
												<th style="white-space:nowrap;">DAILY LOCAL TAX<span class="btnsortdash-dailysales fa fa-sort bigger-130 pull-right" id="fnmGTLclTaxDly"></span></th>
												<th style="white-space:nowrap;">TOTAL PAYMENT - CASH<span class="btnsortdash-dailysales fa fa-sort bigger-130 pull-right" id="fnmGTPymntCSH"></span></th>
												<th style="white-space:nowrap;">TOTAL PAYMENT - CARD<span class="btnsortdash-dailysales fa fa-sort bigger-130 pull-right" id="fnmGTPymntCRD"></span></th>
												<th style="white-space:nowrap;">TOTAL PAYMENT - OTHERS<span class="btnsortdash-dailysales fa fa-sort bigger-130 pull-right" id="fnmGTPymntOTH "></span></th>
											</tr>
										</thead>
										<thead>
											<tr>
												<th style="white-space:nowrap; text-align: right;" colspan="2"> TOTAL</th>
												<th style="white-space:nowrap; text-align: right;" id="thOldGrandTotal"></th>
												<th style="white-space:nowrap; text-align: right;" id="thNewGrandTotal"></th>
												<th style="white-space:nowrap; text-align: right;" id="thDailySales"></th>
												<th style="white-space:nowrap; text-align: right;" id="thGrandTotalDiscount"></th>
												<th style="white-space:nowrap; text-align: right;" id="thTotalDiscountSenior"></th>
												<th style="white-space:nowrap; text-align: right;" id="thTotalDiscountPWD"></th>
												<th style="white-space:nowrap; text-align: right;" id="thTotalDiscountGPC"></th>
												<th style="white-space:nowrap; text-align: right;" id="thTotalDiscountVIP"></th>
												<th style="white-space:nowrap; text-align: right;" id="thTotalDiscountEMP"></th>
												<th style="white-space:nowrap; text-align: right;" id="thTotalDiscountREG"></th>
												<th style="white-space:nowrap; text-align: right;" id="thTotalDiscountOTHERS"></th>
												<th style="white-space:nowrap; text-align: right;" id="thTotalRefund"></th>
												<th style="white-space:nowrap; text-align: right;" id="thTotalCancelled"></th>
												<th style="white-space:nowrap; text-align: right;" id="thVAT"></th>
												<th style="white-space:nowrap; text-align: right;" id="thVATInclusiveSales"></th>
												<th style="white-space:nowrap; text-align: right;" id="thVATExclusiveSales"></th>
												<th style="white-space:nowrap; text-align: right;" id="thDocumentCount"></th>
												<th style="white-space:nowrap; text-align: right;" id="thCustomerCount"></th>
												<th style="white-space:nowrap; text-align: right;" id="thSeniorCitizenCount"></th>
												<th style="white-space:nowrap; text-align: right;" id="thLocalTax"></th>
												<th style="white-space:nowrap; text-align: right;" id="thServiceCharge"></th>
												<th style="white-space:nowrap; text-align: right;" id="thTotalSalesNonVat"></th>
												<th style="white-space:nowrap; text-align: right;" id="thRawGross"></th>
												<th style="white-space:nowrap; text-align: right;" id="thDailyLocalTax"></th>
												<th style="white-space:nowrap; text-align: right;" id="thTotalPaymentCash"></th>
												<th style="white-space:nowrap; text-align: right;" id="thTotalPaymentCard"></th>
												<th style="white-space:nowrap; text-align: right;" id="thTotalPaymentOthers"></th>
											</tr>
										</thead>
										<tbody id="db_sales"></tbody>
									</table>
								</div>

								<div class="parent reportlists" style="overflow-x: scroll; display: none;" id="showHour">
									<table class="table table-bordered fixTable">
										<thead>
											<th style="white-space:nowrap;text-transform: uppercase;" class="thSysTenant">MERCHANT NAME<span class="btnsortdash-hourlysales fa fa-sort bigger-130 pull-right" id="tradename"></span></th>
											<th style="white-space:nowrap;">TRANSACTION DATE<span class="btnsortdash-hourlysales fa fa-sort bigger-130 pull-right" id="fdtTrnsctn"></span></th>
											<th style="white-space:nowrap;">HOUR CODE<span class="btnsortdash-hourlysales fa fa-sort bigger-130 pull-right" id="fvcHRLCd"></span></th>
											<th style="white-space:nowrap;">DAILY SALES<span class="btnsortdash-hourlysales fa fa-sort bigger-130 pull-right" id="fnmDlySls"></span></th>
											<th style="white-space:nowrap;">DOCUMENT COUNT<span class="btnsortdash-hourlysales fa fa-sort bigger-130 pull-right" id="fnmCntDcmnt"></span></th>
											<th style="white-space:nowrap;">CUSTOMER COUNT<span class="btnsortdash-hourlysales fa fa-sort bigger-130 pull-right" id="fnmCntCstmr"></span></th>
											<th style="white-space:nowrap;">SENIOR CITIZEN COUNT<span class="btnsortdash-hourlysales fa fa-sort bigger-130 pull-right" id="fnmCntSnrCtzn"></span></th>
										</thead>
										<tbody id="db_hour"></tbody>
									</table>
								</div>

								<div class="parent reportlists" style="overflow-x: scroll; display: none;" id="showPayment">
									<table class="table table-bordered fixTable">
										<thead>
											<th  style="white-space:nowrap;text-transform: uppercase;" class="thSysTenant">MERCHANT NAME<span class="btnsortdash-paymentssales fa fa-sort bigger-130 pull-right" id="tradename"></span></th>
											<th  style="white-space:nowrap;">TRANSACTION DATE<span class="btnsortdash-paymentssales fa fa-sort bigger-130 pull-right" id="fdtTrnsctn"></span></th>
											<th  style="white-space:nowrap;">PAYMENT CODE<span class="btnsortdash-paymentssales fa fa-sort bigger-130 pull-right" id="fvcPymntCd"></span></th>
											<th  style="white-space:nowrap;">PAYMENT DESCRIPTION<span class="btnsortdash-paymentssales fa fa-sort bigger-130 pull-right" id="fvcPymntDsc"></span></th>
											<th  style="white-space:nowrap;">PAYMENT CODE CLASSIFICATION<span class="btnsortdash-paymentssales fa fa-sort bigger-130 pull-right" id="fvcPymntCdCLSCd"></span></th>
											<th  style="white-space:nowrap;">PAYMENT CODE DESCRIPTION<span class="btnsortdash-paymentssales fa fa-sort bigger-130 pull-right" id="fvcPymntCdCLSDsc"></span></th>
											<th  style="white-space:nowrap;">PAYMENT AMOUNT<span class="btnsortdash-paymentssales fa fa-sort bigger-130 pull-right" id="fnmPymnt"></span></th>
										</thead>
										<tbody id="db_payment"></tbody>
									</table>
								</div>

								<div class="parent reportlists" style="overflow-x: scroll; display: none;" id="showDiscount">
									<table class="table table-bordered fixTable">
										<thead> 
											<th style="white-space:nowrap;text-transform: uppercase;" class="thSysTenant">MERCHANT NAME<span class="btnsortdash-discountsales fa fa-sort bigger-130 pull-right" id="tradename"></span></th>
											<th style="white-space:nowrap;">TRANSACTION DATE<span class="btnsortdash-discountsales fa fa-sort bigger-130 pull-right" id="fdtTrnsctn"></span></th>
											<th style="white-space:nowrap;">DISCOUNT CODE<span class="btnsortdash-discountsales fa fa-sort bigger-130 pull-right" id="fvcDscntCd"></span></th>
											<th style="white-space:nowrap;">DISCOUNT PERCENTAGE<span class="btnsortdash-discountsales fa fa-sort bigger-130 pull-right" id="fvcDscntPrcntg"></span></th>
											<th style="white-space:nowrap;">DISCOUNT AMOUNT<span class="btnsortdash-discountsales fa fa-sort bigger-130 pull-right" id="fnmDscnt"></span></th>
											<th style="white-space:nowrap;">DOCUMENT COUNT<span class="btnsortdash-discountsales fa fa-sort bigger-130 pull-right" id="fnmCntDcmnt"></span></th>
											<th style="white-space:nowrap;">CUSTOMER COUNT<span class="btnsortdash-discountsales fa fa-sort bigger-130 pull-right" id="fnmCntCstmr"></span></th>
											<th style="white-space:nowrap;">SENIOR CITIZEN COUNT<span class="btnsortdash-discountsales fa fa-sort bigger-130 pull-right" id="fnmCntSnrCtzn"></span></th>
										</thead>
										<tbody id="db_discount"></tbody>
									</table>
								</div>

								<div class="parent reportlists" style="overflow-x: scroll; display: none;" id="showVoid">
									<table class="table table-bordered fixTable">
										<thead> 
											<th style="white-space:nowrap;text-transform: uppercase;" class="thSysTenant">MERCHANT NAME<span class="btnsortdash-voidsales fa fa-sort bigger-130 pull-right" id="tradename"></span></th>
											<th style="white-space:nowrap;">TRANSACTION DATE<span class="btnsortdash-voidsales fa fa-sort bigger-130 pull-right" id="fdtTrnsctn"></span></th>
											<th style="white-space:nowrap;">CODE<span class="btnsortdash-voidsales fa fa-sort bigger-130 pull-right" id="fvcRfndCncldCd"></span></th>
											<th style="white-space:nowrap;">REASON<span class="btnsortdash-voidsales fa fa-sort bigger-130 pull-right" id="fvcRfndCncldRsn"></span></th>
											<th style="white-space:nowrap;">AMOUNT<span class="btnsortdash-voidsales fa fa-sort bigger-130 pull-right" id="fnmAmt"></span></th>
											<th style="white-space:nowrap;">DOCUMENT COUNT<span class="btnsortdash-voidsales fa fa-sort bigger-130 pull-right" id="fnmCntDcmnt"></span></th>
											<th style="white-space:nowrap;">CUSTOMER COUNT<span class="btnsortdash-voidsales fa fa-sort bigger-130 pull-right" id="fnmCntCstmr"></span></th>
											<th style="white-space:nowrap;">SENIOR CITIZEN COUNT<span class="btnsortdash-voidsales fa fa-sort bigger-130 pull-right" id="fnmCntSnrCtzn"></span></th>
										</thead>
										<tbody id="db_void"></tbody>
									</table>
								</div>
								<table class="tabledash_footer table" style="margin: 0px !important;">
			                        <thead>
			                            <tr>
			                                <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
			                                    <font id="txtTSREntries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
			                                    <input id="txtTSRPage" type="hidden">
			                                    <ul id="txtTSRPagination" class="pagination pull-right"></ul>
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
	</div>
</div>

<div class="modal fade fade-scale" id="mdlFordaily" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
        		<h4 class="modal-title" style="font-size: 18px;">Hourly Breakdown</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="radio">
						<label style="font-weight: bold;">View :</label>
						<label>
							<input type="radio" name="rdGraphView2" id="chkGraphYear" class="ace rdGraphView2" onclick="fncshowList();" checked>
							<span class="lbl" style="color: #666;">&nbsp;List</span>
						</label>
						<label>
							<input type="radio" name="rdGraphView2" id="chkGraphMonth" class="ace rdGraphView2" onclick="fncshowGraph();">
							<span class="lbl" style="color: #666;">&nbsp;Graph</span>
						</label>
					</div>
					<input type="hidden" id="txtDayNum">
					<div class="col-md-12 divHouryList">
						<div class="parent">
							<table class="table table-bordered fixTable">
								<thead>
									<th>Date</th>
									<th>Time</th>
									<th>Amount</th>
								</thead>
								<tbody id="perhourtbl"></tbody>
							</table>
						</div>
					</div>
					<div class="col-md-12 divHouryGraph" style="display: none;">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<!-- <h3 class="panel-title">Panel title</h3> -->
							</div>
							<div class="panel-body">
								<div id="graphHourly"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger btn-round btn-sm" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="DailySalesSortType" value="ASC">
<input type="hidden" id="DailySalesSortBy" value="a.fdtTrnsctn">

<input type="hidden" id="HourlySalesSortType" value="ASC">
<input type="hidden" id="HourlySalesSortBy" value="a.fdtTrnsctn">

<input type="hidden" id="PaymentSalesSortType" value="ASC">
<input type="hidden" id="PaymentSalesSortBy" value="a.fdtTrnsctn">

<input type="hidden" id="DiscountSalesSortType" value="ASC">
<input type="hidden" id="DiscountSalesSortBy" value="a.fdtTrnsctn">

<input type="hidden" id="VoidSalesSortType" value="ASC">
<input type="hidden" id="VoidSalesSortBy" value="fdtTrnsctn">

<?php include('script.php'); ?>