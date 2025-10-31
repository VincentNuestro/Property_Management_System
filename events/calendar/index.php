<!-- CALENDAR -->
<link rel="stylesheet" type="text/css" href="events/calendar.css">

<div class="big_calendar" id="calendar2"></div>

<div class="modal fade" id="mdlEvent">
	<div class="modal-lg modal-dialog">
		<div class="modal-content"> 
			<div class="modal-header">
				<h4>EVENT INFORMATION</h4>
			</div>

			<div class="modal-body">
				<div class="container-fluid"> 
					<div class="modified-jumbotron col-md-12">
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-8">
								<h4>Event Series No.: <strong><span id="lblSNo">MKT-2019-09-0000001</span></strong></h4>
							</div>

							<div class="col-md-4">
								<h4>Date Created: <strong><span id="lblSNo">09/28/2019</span></strong></h4>
								<h4>Created By: <strong><span id="lblSNo">USER A</span></strong></h4>
							</div>
						</div>
					</div>

					<div class="col-md-12" style="margin-top: 10px;">
						<div class="row">
							<div class="col-md-6">
								<div class="form-horizontal">
									<div class="form-group">
										<label class="control-label">Name of Event &nbsp;&nbsp;<span class="fa fa-asterisk red"></span></label>
										<input type="text" class="form-control" id="txteventname">
									</div>
								</div>

								<div class="form-horizontal">
									<div class="form-group">
										<label class="control-label">Company Name &nbsp;&nbsp;<span class="fa fa-asterisk red"></span></label>
										<input type="text" class="form-control" id="txtcompname">
									</div>
								</div>

								<div class="form-horizontal">
									<div class="form-group">
										<label class="control-label">Company Address &nbsp;&nbsp;<span class="fa fa-asterisk red"></span></label>
										<textarea class="form-control" id="txtcompadd" style="height: 111px;"></textarea>
									</div>
								</div>
							</div>

							<div class="col-md-5 col-md-offset-1">
								<div class="row">
									<div class="col-md-6">
										<div class="form-horizontal">
											<label class="control-label">Date &nbsp;&nbsp;<span class="fa fa-asterisk red"></span></label>
											<input type="text" class="form-control datepicker" id="txteventdate">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-horizontal">
											<label class="control-label">Time &nbsp;&nbsp;<span class="fa fa-asterisk red"></span></label>
											<input type="text" class="form-control timepicker" id="txteventtime">
										</div>
									</div>
								</div>

								<div class="col-md-12" style="margin-top: 15px;">
									<div class="form-horizontal">
										<div class="form-group">
											<label class="control-label">TIN No.</label>
											<input type="text" class="form-control timepicker" id="txteventtime">
										</div>
									</div>

									<div class="form-horizontal">
										<div class="form-group">
											<label class="control-label">Organizer &nbsp;&nbsp;<span class="fa fa-asterisk red"></span></label>
											<input type="text" class="form-control timepicker" id="txteventtime">
										</div>
									</div>

									<div class="form-horizontal">
										<div class="form-group">
											<label class="control-label">Revenue Type &nbsp;&nbsp;<span class="fa fa-asterisk red"></span></label>
											<input type="text" class="form-control timepicker" id="txteventtime">
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

<?php include "script.php"; ?>