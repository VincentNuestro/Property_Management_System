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
			<!-- <div class="col-md-3 div_ListVIew" style="padding-bottom: 5px;padding-left: 0px;">
				<div class="input-daterange input-group">
					<input type="text" class="form-control date-picker" id="dateFromList" value="<?php echo date('m/d/Y'); ?>">
					<span class="input-group-addon">
						<i class="fa fa-exchange"></i>
					</span>
					<input type="text" class="form-control date-picker" id="dateToList" value="<?php echo date('m/d/Y'); ?>">
				</div>
			</div>  -->
			<div class="col-md-1 div_ListVIew" style="padding-bottom: 5px;padding-left: 0px;">
				<div class="col-md-12">
					<button class="btn btn-primary btn-sm btn-round" onclick="clickforall()"><i class="fa fa-search"></i> Go</button>
				</div>
			</div>

			<!-- ruth -->
				<div class="col-md-2" style="padding-bottom: 5px;padding-left: 0px;">
				<div class='btn-group' id="printrent" style="display: none;">
			       <button class='btn btn-primary btn-round btn-sm' onclick="$arr = [];$arr.push( 'page='+$('#txtTSRPage').val() );$arr.push( 'key='+$('#txtSearchTenantName').val() );$arr.push( 'mallid='+$('#txtTSRMall').val() );getheaderprint('<?php echo $_SESSION['MMS-Designation']; ?>','printrent',JSON.stringify($arr));" data-placement="bottom">Print Rent</button> 
			        <button data-toggle='dropdown' class='btn dropdown-toggle btn-primary btn-round btn-sm'>
			            <span class='ace-icon fa fa-caret-down icon-only'></span>
			        </button>
			        <ul class='dropdown-menu pull-right'>
			            <li>
			                <a onclick="AutoConsolidaterent('<?php echo $_SESSION['MMS-Designation']; ?>');">Export</a>
			            </li>
					</ul>
				</div>
			</div>
			<!-- ruth -->
			
		</div>
		<div class="row form-group div_ListVIew" style="margin-bottom: 0px;">
			<div class="col-md-12" style="padding-bottom: 5px;padding-left: 0px;">
				<div class="row form-group">
					<div class="col-md-12">

						<div class="row">
							<div class="col-md-12">
								<ul class="nav nav-tabs selectedtab" id="mgaList">
									<!-- li id="tabrent" onclick="showrent(); $('#printrent').css('display','block');" class="active"><a data-toggle="tab">Charges</a></li> -->
									<!-- <li id="tabpayment" onclick="showPayment(); "><a data-toggle="tab">Payment</a></li> -->
								</ul>

								<div class="parent reportlists" style="overflow-x: scroll;" id="showrent">
									<table class="table table-bordered fixTable">
										<thead>
											<tr>
												<th style="white-space:nowrap;text-transform: uppercase;" class="thSysTenant">MERCHANT NAME</th>
											<th style="white-space:nowrap;">INQUIRY ID</th>
											<th style="white-space:nowrap;">UNIT NAME</th>
											<th style="white-space:nowrap;">BUILDING NAME</th>
											<th style="white-space:nowrap;">TYPE OF BUSINESS</th>
											<th style="white-space:nowrap;">TOTAL AMOUNT</th>
											</tr>
										</thead>
										<thead>
											<tr>
												<th style="white-space:nowrap; text-align: right;" id=""></th>
												<th style="white-space:nowrap; text-align: right;" id=""></th>
												<th style="white-space:nowrap; text-align: right;" id=""></th>
												<th style="white-space:nowrap; text-align: right;" id=""></th>
												<th style="white-space:nowrap; text-align: right;" id=""></th>
												<th style="white-space:nowrap; text-align: right;" id=""></th>	
											</tr>
										</thead>
										<tbody id="tblrent"></tbody>
									</table>
								</div>

							<!-- 	<div class="parent reportlists" style="overflow-x: scroll; display: none" id="showPayment">
									<table class="table table-bordered fixTable">
										<thead>
											<th style="white-space:nowrap;text-transform: uppercase;" class="thSysTenant">MERCHANT NAME</th>
											<th style="white-space:nowrap;">TRANSACTION DATE</th>
											<th style="white-space:nowrap;">DESCRIPTION</th>
											<th style="white-space:nowrap;">AMOUNT</th>
											<th style="white-space:nowrap;">PAYMENT TYPE</th>
											<th style="white-space:nowrap;">BALANCE</th>
											<th style="white-space:nowrap;">REFERENCE</th>
										</thead>
										<thead>
											<tr>
												<th style="white-space:nowrap; text-align: right;" id=""></th>
												<th style="white-space:nowrap; text-align: right;" id=""></th>
												<th style="white-space:nowrap; text-align: right;" id=""></th>
												<th style="white-space:nowrap; text-align: right;" id=""></th>
												<th style="white-space:nowrap; text-align: right;" id=""></th>
												<th style="white-space:nowrap; text-align: right;" id=""></th>
												<th style="white-space:nowrap; text-align: right;" id=""></th>
											</tr>
										</thead>
										<tbody id="tblpayment"></tbody>
									</table>
								</div> -->

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

<?php include('script.php'); ?>