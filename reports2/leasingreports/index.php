<div class="container-fluid">
	<div class="row">
	    <div class="col-md-12">
	        <div class="row form-group" style="margin-bottom: 0px;">
	            <div class="col-md-6" style="padding-bottom: 5px;padding-left: 0px;"></div>
	            <div class="col-md-5" style="padding-bottom: 5px;padding-left: 0px;">
	                
		        </div>
		        <div class="row">
		            <ul class="nav nav-tabs selectedtab" id="tabListOcc">
						<li id="tabOccUnit" onclick="showOccUnit()" class="active"><a href="#">Occupancy by Units</a></li>
						<li id="tabOccFwtotal" onclick="showOccFwtotal()"><a href="#">Occupancy by Floors</a></li>
						<!-- <li id="tabOccF" onclick="showOccF()"><a href="#">Occupancy by floor</a></li> -->
					</ul>
					<div class="tab-content">
						<div class="tabOccContent" id="OccUnitBody">
							<div class="row">
								<div class="col-md-2 hidden-sm">
									<label class="control-label">
										<b class="txtSysBuilding">Mall</b>
									</label>
									<select class="form-control listMall" id="mallUnits"></select>
								</div>
								<div class="col-md-10">
									<div class="container-fluid">
										<div class="row">
											<div class="panel panel-primary">
												<div class="panel-heading">
													<label style="margin-top: 10px;">
														Current unit status
													</label>
												</div>
												<div class="panel-body">
													<div style="overflow: scroll; height: 400px; width: calc(100%);">
														<div id="sampleHeat"></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tabOccContent" id="OccFwtotalBody">
							<div class="row">
								<div class="col-md-2 hidden-sm">
									<label class="control-label">
										<b>Mall</b>
									</label>
									<select class="form-control listMall" id="floorMall"></select>
								</div>
								<div class="col-md-10">
									<div class="container-fluid">
										<div class="row">
											<div class="panel panel-primary">
												<div class="panel-heading">
														<label style="margin-top: 10px;">
															Current Occupied per floor
														</label>
												</div>
												<div class="panel-body">
													<!-- <div> -->
														<div id="byFloorsGraph"></div>
													<!-- </div> -->
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tabOccContent" id="OccFBody">
							<div class="row">
								Floor
							</div>
						</div>
					</div>
		        </div>
			</div>
		</div>
	</div>
</div>

<!-- <div id="div_form_inq_report" style="display: none;">
    <table style="width: 100%;" cellspacing="0" cellpadding="0">
        <tbody id="templateinqr"></tbody>
    </table>
    <table cellspacing="0" style="width: 100%">
        <tr>
            <td align="right">
                <p style="font-size: 15px; margin-top: 5px;">From:&nbsp;&nbsp;<label id="dateFrom3a"></label>&nbsp;&nbsp;To&nbsp;&nbsp;<label id="dateTo3a"></label></p>
            </td>
        </tr>
        <tr>
            <td>
                <p style="font-size: 20px; font-weight: bold;background-color: #666;color: white;width: 100%;text-align: center;">Inquiry List</p>
            </td>
        </tr>
    </table>
    <table cellspacing="0" style="width: 100%;">
        <thead>
            <tr>
                <td>Date Inquired</h6></td>
                <td>Company Name</h6></td>
                <td>Trade Name</h6></td>
                <td>Unit Type</h6></td>
                <td>Start Date</h6></td>
                <td>End Date</h6></td>
                <td>Remarks</h6></td>
            </tr>
        <td colspan="8"><hr></td>
        </thead>
        <tbody id="inquirylist2"></tbody>
    </table>
</div> -->
<?php include 'script.php'; ?>
<script type="text/javascript">
	$(function(){
    	showOccUnit();
    	// sampleHeatGraph();
	});
    function removeActiveClassRon( id , nAct ){
    	if( id != '' ){
	    	$('#'+id+' li').each(function(){
	    		if( $(this).attr('id') == nAct ){
		    		$(this).addClass('active')
	    		} else {
		    		$(this).removeClass('active')
	    		}
	    	});
    	}
    	$('.tabOccContent').css('display','none');
    }
    function showOccFwtotal(){
    	removeActiveClassRon( 'tabListOcc' , 'tabOccFwtotal' );
    	$('#OccFwtotalBody').css('display','block');
    }
    function showOccUnit(){
    	removeActiveClassRon( 'tabListOcc' , 'tabOccUnit' );
    	$('#OccUnitBody').css('display','block');
    }
    function showOccF(){
    	removeActiveClassRon( 'tabListOcc' , 'tabOccF' );
    	$('#OccFBody').css('display','block');
    }
</script>