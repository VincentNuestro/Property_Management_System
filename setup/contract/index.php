<div class="row">
	<div class="col-md-12">
		<div class="row form-group" style="margin-bottom: 0px;">
            <div class="col-md-2 col-xs-12" style="padding-bottom: 5px;padding-left: 0px;">
				<span class="input-icon" style="width: 100%;">
				  	<input type="text" class="form-control" id="txtLayoutKey" title="Search" placeholder="Search">
				  	<i class="ace-icon fa fa-search nav-search-icon"></i>
				</span>
		  	</div>
		  	<div class="col-md-8" style="padding-bottom: 5px;padding-left:0px;"></div>
		  	<div class="col-md-2 col-xs-12" style="padding-bottom: 5px;padding-right: 0px;">
            	<button class="btn btn-info btn-round btn-sm btn-block select-addreportTempaltes hide isadmin" onclick="fncAddNewContractLayout();">New Layout</button>
		  	</div>
		</div>
		<div class="row form-group" style="margin-bottom: 0px !important;">
			<div class="parent">
				<table class="table table-bordered table-striped fixTable">
					<thead>
						<tr>
							<th style="width: 10%">Report Type</th>
							<th style="width: 30%">Layout Code</th>
							<th style="width: 50%">Layout Description</th>
							<th style="width: 10%;z-index: 1;" class="hide isadmin select-editreportTempaltes select-deletereportTempaltes">Options</th>
						</tr>
					</thead>
					<tbody id="tbodyLayoutList"></tbody>
				</table>
			</div>
			<table class="tabledash_footer table" style="margin: 0px !important;">
	        	<thead>
	          		<tr>
	            		<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
	              			<font id="txtLayoutEntries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
	              			<input id="txtLayoutPage" type="hidden">
	              			<ul id="ulLayoutPagination" class="pagination pull-right"></ul>
	            		</th>
	          		</tr>
	        	</thead>
	      	</table>
		</div>
	</div>
</div>

<div class="modal fade fade-scale" id="mdl_AddNewContractLayout" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
  	<div class="modal-dialog modal-lg" style="width: 98%;">
    	<div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal">&times;</button>
        		<h4 class="modal-title" style="font-size: 18px;">Create New Contract Layout</h4>
	      	</div>
		    <div class="modal-body">
		  		<div class="row form-group">
		  			<input type="hidden" id="txtLayoutID">
		  			<div class="col-md-2">
		  				<div class="row form-group">
		  					<label class="col-md-12">Report Type</label>
		  					<div class="col-md-12">
		  						<select class="form-control" id="txtContractType" onchange="fncChangeDocument();">
		  							<option value="Proposal">Proposal</option>
		  							<option value="AwardNotice">Award Notice</option>
		  							<option value="LeaseContract">Lease Contract</option>
		  							<option value="EventContract">Event Contract</option>
		  						</select>
		  					</div>
						</div>
					</div>
		  			<div class="col-md-5">
		  				<div class="row form-group">
		  					<label class="col-md-12">Code</label>
		  					<div class="col-md-12">
								<input type="text" name="txtContractCode" id="txtContractCode" class="form-control">
		  					</div>
						</div>
					</div>
		  			<div class="col-md-5">
						<div class="row form-group">
		  					<label class="col-md-12">Description</label>
							<div class="col-md-12">
								<input type="text" name="txtContractDesc" id="txtContractDesc" class="form-control">
							</div>
						</div>
					</div>
		  		</div>
		  		<div class="row form-group">
		  			<div class="col-md-3">
						<div class="widget-box transparent">
		                    <div class="widget-header">
		                        <h4 class="widget-title">
		                           	List of Functions
		                        </h4>
		                    </div>
		                    <div class="widget-body">
		                        <div class="widget-main padding-6 no-padding-left no-padding-right">
		                           	<div class="row" style="height: 600px; overflow-y: scroll;">
		                           		<ul id="ulProposal">
											<li><b class="blue">|MallCompanyName|</b> - Mall Company</li>
											<li><b class="blue">|MallName|</b> - Mall Name</li>
											<li><b class="blue">|MallAddress|</b> - Mall Address</li>
											<li><b class="blue">|MallTelephone|</b> - Mall Telephone</li>
			                            	<li><b class="blue">|TradeName|</b> - Trade / Store Name</li>
											<li><b class="blue">|TradePrimaryConName|</b> - Store Primary Contact Name</li>
											<li><b class="blue">|TradePrimaryConDesig|</b> - Stor Primary Contact Designation</li>
											<li><b class="blue">|CompanyName|</b> - Company Name</li>
											<li><b class="blue">|CompanyAddress|</b> - Company Address</li>
											<li><b class="blue">|Industry|</b> - Company Industry</li>
											<li><b class="blue">|Classification|</b> - Classification</li>
											<li><b class="blue">|Department|</b> - Department</li>
											<li><b class="blue">|Category|</b> - Category</li>
											<li><b class="blue">|UnitList|</b> - Unit List</li>
											<li><b class="blue">|UnitListArea|</b> - Unit Area</li>
											<li><b class="blue">|MonthlyRent|</b> - Basic / Fixed Rent</li>
											<li><b class="blue">|MonthlyRentVAT|</b> - Basic / Fixed Rent + VAT</li>
											<li><b class="blue">|TotalConBondAmount|</b> - Total Construction Bond in Amount</li>
											<li><b class="blue">|TotalConBondWords|</b> - Total Construction Bond in Words</li>
											<li><b class="blue">|TotalSecDepAmount|</b> - Total Security Deposit in Amount</li>
											<li><b class="blue">|TotalSecDepWords|</b> - Total Security Deposit in Words</li>
											<li><b class="blue">|TotalAdvAmount|</b> - Total Advance Payment in Amount</li>
											<li><b class="blue">|TotalAdvWords|</b> - Total Advance Payment in Words</li>
											<li><b class="blue">|RentalScheme|</b> - Rental Scheme</li>
											<li><b class="blue">|RSPerc|</b> - Rental Scheme Percentage</li>
											<li><b class="blue">|LeaseTerm|</b> - Lease Term</li>
											<li><b class="blue">|LeaseStartDate|</b> - Start of Lease</li>
											<li><b class="blue">|LeaseTerminationDate|</b> - Lease Termination Date</li>
											<li><b class="blue">|CurrentDate|</b> - Current Date</li>
											<li><b class="blue">|EscaRate|</b> - Escalation Rate</li>
											<li><b class="blue">|ConDepMonth|</b> - Number of Months of Construction Deposit</li>
											<li><b class="blue">|ConDepMonthinWords|</b> - Number of Months of Construction Deposit in Words</li>
											<li><b class="blue">|ConDepAmount|</b> - Amount of Construction Deposit</li>
											<li><b class="blue">|SecDepMonth|</b> - Number of Months of Security Deposit</li>
											<li><b class="blue">|SecDepMonthinWords|</b> - Number of Months of Security Deposit in Words</li>
											<li><b class="blue">|SecDepAmount|</b> - Amount of Security Deposit</li>
											<li><b class="blue">|ExhBondMonth|</b> - Number of Months of Exhibit Bond</li>
											<li><b class="blue">|ExhBondMonthinWords|</b> - Number of Months of Exhibit Bond in Words</li>
											<li><b class="blue">|ExhBondAmount|</b> - Amount of Exhibit Bond</li>
											<li><b class="blue">|AdvMonth|</b> - Number of Months of Advance Payment</li>
											<li><b class="blue">|AdvMonthinWords|</b> - Number of Months of Advance Payment in Words</li>
											<li><b class="blue">|AdvAmount|</b> - Amount of Advance Payment</li>
											<li><b class="blue">|getCUSA|</b> - CUSA</li>
											<li><b class="blue">|getACU|</b> - ACU</li>
											<li><b class="blue">|BillProContactFirstName|</b> - Billing Profile Primary Contact First Name</li>
											<li><b class="blue">|BillProContactMiddleName|</b> - Billing Profile Primary Contact Middle Name</li>
											<li><b class="blue">|BillProContactLastName|</b> - Billing Profile Primary Contact Last Name</li>
											<li><b class="blue">|BillProContactName|</b> - Billing Profile Primary Contact Name</li>
											<li><b class="blue">|BillProContactDesignation|</b> - Billing Profile Primary Contact Designation</li>
											<li><b class="blue">|ProposalCreateDate|</b> - Proposal Create Date</li>
											<li><b class="blue">|ProposalPrepareBy|</b> - Proposal Prepared by</li>
											<li><b class="blue">|ProposalPreparedByEmail|</b> - Proposal Prepared by Email</li>
											<li><b class="blue">|ProposalPreparedByMobile|</b> - Proposal Prepared by Mobile</li>
											<li><b class="blue">|ProposalPreparedByRole|</b> - Proposal Prepared by Role</li>
											<li><b class="blue">|ProposalFirstApprover|</b> - Proposal First Approver</li>
											<li><b class="blue">|ProposalFirstApprovalDate|</b> - Proposal First Approval Date</li>
											<li><b class="blue">|ProposalFirstApproverRole|</b> - Proposal First Approver Role</li>
											<li><b class="blue">|AwardNoticeSentDate|</b> - Date the Award Notice is Sent</li>
											<li><b class="blue">|AwardSenderName|</b> - Award Sender Name</li>
											<li><b class="blue">|AwardSenderRole|</b> - Award Sender Role</li>	
											<li><b class="blue">|TurnOverDate|</b> - Turn Over Date of Award Notice</li>	
											<li><b class="blue">|AwardFirstApprover|</b> - First Approver of Award Notice</li>
											<li><b class="blue">|AwardFirstApproverRole|</b> - Role of First Approver of Award Notice</li>
											<li><b class="blue">|AwardFirstApprovalDate|</b> - First Approval Date of Award Notice</li>
											<li><b class="blue">|AwardSecondApprover|</b> - Second Approver of Award Notice</li>
											<li><b class="blue">|AwardSecondApproverRole|</b> - Role of Second Approver of Award Notice</li>
											<li><b class="blue">|AwardSecondApprovalDate|</b> - Second Approval Date of Award Notice</li>
											<li><b class="blue">|ContractSeriesNo|</b> - Contract Series Number</li>
											<li><b class="blue">|ContractFirstApprover|</b> - First Approver of Contract</li>
											<li><b class="blue">|ContractFirstApproverRole|</b> - Role of First Approver of Contract</li>
											<li><b class="blue">|ContractFirstApproverDate|</b> - First Approval Date of Cotract</li>
											<li><b class="blue">|ContractSecondApprover|</b> - Second Approver of Contract</li>
											<li><b class="blue">|ContractSecondApproverRole|</b> - Role of Second Approver of Contract</li>
											<li><b class="blue">|ContractSecondApproverDate|</b> - Second Approval Date of Cotract</li>
											<li><b class="blue">|ContractThirdApprover|</b> - Third Approver of Contract</li>
											<li><b class="blue">|ContractThirdApproverRole|</b> - Role of Third Approver of Contract</li>
											<li><b class="blue">|ContractThirdApproverDate|</b> - Third Approval Date of Cotract</li>
											<li><b class="blue">|EscalationSetup|</b> - Escalation Setup</li>
			                            </ul>
		                           	</div>
		                        </div>
							</div>
		                </div>
					</div>
					<div class="col-md-9">
						<div class="widget-box widget-color-blue3 ui-sortable-handle">
							<div class="widget-header">
								<h5 class="widget-title">Contract Layout</h5>
							</div>
							<div class="widget-body">
								<div class="widget-main">
									<textarea class="ckeditor" name="txtckEditor" id="txtckEditor"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>	    
		    </div>
	      	<div class="modal-footer">
				<button class="btn btn-primary pull-right btn-sm btn-round" onclick="fncSaveLayout();"><i class="fa fa-check"></i>&nbsp;Save</button>
	      	</div> 
    	</div>
  	</div>
</div>

<?php include("script.php"); ?>