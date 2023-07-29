<div id="reportcontainer" style="margin-top: 10px; display: none;">
	<center>
	<div class="checklist" id="div_form_complaints" style="margin-top: 20px; width: 99%;margin-bottom: 0;">
		<center>
			<table cellspacing="0" style="padding: 5px; width: 95%">
				<tr><td colspan="2" align="center"><div style="width: 100%; text-align: left;">
					<table style="width: 100%;" cellspacing="0" cellpadding="0">
						<tbody id="template"></tbody>
					</table>
				</div></td></tr>
				<tr><td align="right"><p style="font-size: 15px; margin-top: 5px;">From:&nbsp;&nbsp;<label id="dateFrom2"></label>&nbsp;&nbsp;To&nbsp;&nbsp;<label id="dateTo2"></label></p></td></tr>
				<tr><td colspan="2"><center><p style="font-size: 22px; font-weight: bold;background-color: #666;color: white;width: 100%;">Complaints</p></center></td></tr>
				<tr>
					<td colspan="2">
						<center>
							<table style="width: 100%;"> 
								<thead>
									<tr>	
										<td>Tenant ID</td>
										<td>Trade Name</td>
										<td>Date Entry</td>
										<td>Complaint Code</td>
										<td>Date Received</td>
										<td>Date Resolved</td>
										<td>Resolved By</td>
										<td>Complaint Status</td>
										<td>User Name</td>
									</tr>
									<tr><td colspan="9"><hr style="margin-top: -5px;"></td></tr>
								</thead>
							<tbody id="contentngcomplaints"></tbody>
							</table>
						</center>
					</td>
				</tr>
			</table>
		</center>
	</div>
	</center>
</div>

<div id="printcomplaint" style="display: none;">
    <table style="width: 100%;" cellspacing="0" cellpadding="0">
        <tbody id="template2"></tbody>
    </table>
    <center style="font-size: 32px;font-weight: bold;border-bottom: 3px solid black;width: 100%;">Tenant Complaint Form</center>
    <table style="width: 100%;border: 1px solid;border-collapse: collapse;margin-top: 10px;">
    	<tbody>
    		<tr>
    			<td colspan="2" style="border: 1px solid;text-align: center;font-size: 15px;background-color: #666;"><label style="color: white;">Tenant Information</label></td>
    		</tr>
	    	<tr>
	    		<td style="border: 1px solid;width: 50%;"><b>Trade Name: </b><label id="printcomplainttradename"></label></td>
	    		<td style="border: 1px solid;width: 50%;"><b>Tenant ID: </b><label id="printcomplainttenantid"></label></td>
	    	</tr>
	    	<tr>
	    		<td style="border: 1px solid;width: 50%;border: 1px solid;"><b><label class="txtSysBuilding">Mall</label> Name: </b><label id="printcomplaintmallname"></label></td>
	    		<td style="border: 1px solid;width: 50%;border: 1px solid;"><b>Wing Name: </b><label id="printcomplaintwingname"></label></td>
	    	</tr>
	    	<tr>
	    		<td style="border: 1px solid;width: 50%;border: 1px solid;"><b>Floor Name: </b><label id="printcomplaintfloorname"></label></td>
	    		<td style="border: 1px solid;width: 50%;border: 1px solid;"><b>Unit Name: </b><label id="printcomplaintunitname"></label></td>
	    	</tr>
    	</tbody>
    </table>
    <table style="width: 100%;border: 1px solid;border-collapse: collapse;margin-top: 10px;">
    	<tbody>
    		<tr>
    			<td colspan="2" style="border: 1px solid;text-align: center;font-size: 15px;background-color: #666;"><label style="color: white;">Complaint Information</label></td>
    		</tr>
	    	<tr>
	    		<td style="width: 50%;"><b>Complaint Date: </b><label id="printcomplaintcomplaintdate"></label></td>
	    		<td style="border: 1px solid;width: 50%;"><b>Complaint Taken By: </b><label id="printcomplaintusername"></label></td>
	    	</tr>
	    	<tr>
	    		<td colspan="2" style="width: 50%;border: 1px solid;"><b>Complaint Code: </b><label id="printcomplaintcomplaintcode"></label></td>
	    	</tr>
	    	<tr>
	    		<td colspan="2" style="width: 50%;border: 1px solid;height: 100px;vertical-align: top;"><b>First Response Corrective Action: </b><label></label></td>
	    	</tr>
	    	<tr>
	    		<td colspan="2" style="width: 50%;border: 1px solid;height: 100px;vertical-align: top;"><b>Suspected Cause: </b><label id="printcomplaintdescription"></label></td>
	    	</tr>
	    	<tr>
	    		<td colspan="2" style="width: 50%;border: 1px solid;height: 40px;vertical-align: top;"><b>Corrective Action Person(s): </b><label id="printcomplaintassignedperson"></label></td>
	    	</tr>
	    	<tr>
	    		<td colspan="2" style="width: 50%;border: 1px solid;height: 40px;vertical-align: top;"><b>Corrective Action Follow-up: </b><label></label></td>
	    	</tr>
	    	<tr>
	    		<td colspan="2" style="width: 50%;border: 1px solid;height: 100px;vertical-align: top;"><b>What steps should be considered to avoid a repeat of the problem: </b><label></label></td>
	    	</tr>
    	</tbody>
    </table>
    <table style="margin-top: 30px;width: 100%;">
    	<tr>
    		<td style="width: 50%;">
    			<label style="border-top: 1px solid; width: 50%;margin-left: 30px;" class="center">Name of person completing this form</label>
    		</td>
    		<td style="width: 50%;">
    			<label style="border-top: 1px solid; width: 50%; margin-right: 30px;float: right;text-align: center;">Signature</label>
    		</td>
    	</tr>
    </table>
</div>

<div id="allhouserulesviolations" style="display: none;">
    <table style="width: 100%;" cellspacing="0" cellpadding="0">
        <tbody id="template3"></tbody>
    </table>
    <p style="text-align: right;">
    	<span style="font-weight: 700;">Violation Level :</span>&nbsp;&nbsp;
        <span class="fa fa-circle" style="color: #F89406;"></span> 1st Offense&nbsp;&nbsp;
        <span class="fa fa-circle" style="color: #D6487E;"></span> 2nd Offense&nbsp;&nbsp;
        <span class="fa fa-circle" style="color: #D15B47;"></span> 3rd Offense&nbsp;&nbsp;
        <span class="fa fa-circle" style="color: black;"></span> More than 3 Offense
    </p>
	<p style="font-size: 15px; margin-top: -15px;text-align: right;">From:&nbsp;&nbsp;<label id="dateFromhrprint"></label>&nbsp;&nbsp;To&nbsp;&nbsp;<label id="dateTohrprint"></label></p>
    <center style="font-size: 22px;font-weight: bold;background-color: #666;color: white;width: 100%;margin-top: -15px;">House Rules Violator's List</center>
    <table style="width: 100%;">
        <thead>
        	<tr>
	            <td valign="center" style="text-align: center;">Violation Series Number</td>
	            <td valign="center" style="text-align: center;">Tenant/Employee Name</td>
	            <td valign="center" style="text-align: center;">Violation/s</td>
	            <td valign="center" style="text-align: center;">Date</td>
	            <td valign="center" style="text-align: center;">Time</td>
	            <td valign="center" style="text-align: center;">Status</td>
	        </tr>
			<tr><td colspan="6"><hr style="margin-top: -5px;"></td></tr>
        </thead>
        <tbody id="listofviolatorstoprint"></tbody>
    </table>
</div>

<div id="notificationofviolation" style="display: none;">
    <table style="width: 100%;" cellspacing="0" cellpadding="0">
        <tbody id="template4"></tbody>
    </table>
    <center style="font-size: 32px;font-weight: bold;border-bottom: 3px solid black;width: 100%;">Notice of Violation</center>
    <table style="width: 100%;border: 1px solid;border-collapse: collapse;margin-top: 10px;">
    	<tr>
			<td colspan="2" style="border: 1px solid;text-align: center;font-size: 15px;background-color: #666;"><label style="color: white;">Tenant Information</label></td>
		</tr>
    	<tr>
    		<td style="width: 50%;border: 1px solid;"><b>Violation Series Number: </b><label id="txtPrintVSN">VHR-0000041</label></td>
    		<td style="width: 50%;border: 1px solid;"><b>Date: </b><label id="txtd"></label></td>
    	</tr>
    	<tr>
    		<td style="width: 50%;border: 1px solid;"><b class="thSysTenant"></b>: <label id="txtPrintViolator">Jonas</label></td>
    		<td style="width: 50%;border: 1px solid;"><b>Time: </b><label id="txtt"></label></td>
    	</tr>
    </table>
    <table style="width: 100%;border: 1px solid;border-collapse: collapse;margin-top: 10px;">
    	<tr>
			<td colspan="3" style="border: 1px solid;text-align: center;font-size: 15px;background-color: #666;"><label style="color: white;">List of Violation</label></td>
		</tr>
    	<tr>
    		<td style="width: 50%;border: 1px solid;text-align: center;font-size: 15px;background-color: #666;"><label style="color: white;">Violation</label></td>
            <td style="width: 25%;border: 1px solid;text-align: center;font-size: 15px;background-color: #666;"><label style="color: white;">Violation Level</label></td>
            <td style="width: 25%;border: 1px solid;text-align: center;font-size: 15px;background-color: #666;"><label style="color: white;">Fine</label></td>
    	</tr>
        <tbody id="tbodyPrintNoV" style='border: 1px solid;'></tbody>
    </table>
</div>