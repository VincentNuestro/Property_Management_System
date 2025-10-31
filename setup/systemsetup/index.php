<style type="text/css">
.custom-size .colorpicker-saturation {
	width: 250px;
	height: 250px;
}

.custom-size .colorpicker-hue, .custom-size .colorpicker-alpha {
	width: 40px;
	height: 250px;
}

.custom-size .colorpicker-color, .custom-size .colorpicker-color div {
	height: 40px;
}
</style>
<div class="row">
	<div class="tabbable">
		<ul class="nav nav-tabs" id="myTab">
			<li class="active">
				<a data-toggle="tab" href="#CompanyProfileSetup" aria-expanded="true">
					<i class="green ace-icon fa fa-ellipsis-h bigger-120"></i>
					Company Profile Setup
				</a>
			</li>
			<?php if($_SESSION['MMS-UserID'] == 'GatessoftCorp'){ ?> 
			<li>
				<a data-toggle="tab" href="#OtherSetup" aria-expanded="true" onclick="loadLeaseSys();">
					<i class="green ace-icon fa fa-ellipsis-h bigger-120"></i>
					Other Setup
				</a>
			</li>
			<?php } ?>
			<li>
				<a data-toggle="tab" href="#LandingPageSetup" aria-expanded="true" onclick="fncLoadLPSetup();">
					<i class="green ace-icon fa fa-ellipsis-h bigger-120"></i>
					Landing Page Setup
				</a>
			</li>
			<li>
				<a data-toggle="tab" href="#LandingPageSetup" aria-expanded="true" onclick="fncLoadLPSetup();">
					<i class="green ace-icon fa fa-ellipsis-h bigger-120"></i>
					System Schedule
				</a>
			</li>
			<li>
				<a data-toggle="tab" href="#LandingPageSetup" aria-expanded="true" onclick="fncLoadLPSetup();">
					<i class="green ace-icon fa fa-ellipsis-h bigger-120"></i>
					Dev Ops
				</a>
			</li>
		</ul>

		<div class="tab-content">
			<div id="CompanyProfileSetup" class="tab-pane fade active in">
				<div class="row">
					<div class="col-md-6">
						<?php if($_SESSION['MMS-UserID'] == 'GatessoftCorp'){ ?> 
						<div class="row form-group">
							<div class="col-xs-4 col-md-4">System Setup <span class="hideifheader" style="color: red;">*</span> :</div>
							<div class="col-xs-8 col-md-8">
								<select class="form-control disablemoko" id="txtcompanysetup" onchange="disablenotincludedfields()">
									<option value="0">Mall Management System</option>
									<option value="1">Property Managemenet System</option>
									<option value="2">Building Management System</option>
									<option value="3">Palengke Management System</option>
									<option value="4">Memorial Management System</option>
									<option value="5">Property Amortization & Sales System</option>
								</select>
							</div>
						</div>
						<?php } ?>
						<div class="row form-group">
							<div class="col-xs-4 col-md-4">Company Name <span class="hideifheader" style="color: red;">*</span> :</div>
							<div class="col-xs-8 col-md-8">
								<input type="text" class="form-control disablemoko" name="txtcorporatename" id="txtcorporatename" style="text-transform:capitalize;">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-4 col-md-4">Address <span class="hideifheader" style="color: red;">*</span> :</div>
							<div class="col-xs-8 col-md-8">
								<textarea class="form-control disablemoko" style="height: 60px !important;text-transform:capitalize;resize: none;" name="txtcompanyaddress" id="txtcompanyaddress"></textarea>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-4 col-md-4">About :</div>
							<div class="col-xs-8 col-md-8">
								<textarea class="form-control disablemoko" style="height: 60px !important;text-transform:capitalize;resize: none;" name="txtcompanyabout" id="txtcompanyabout"></textarea>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-4 col-md-4">Email Address <span class="hideifheader" style="color: red;">*</span> :</div>
							<div class="col-xs-8 col-md-8">
								<input type="text" class="form-control email-address disablemoko" name="txtcompanyemail" id="txtcompanyemail">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-4 col-md-4">Website :</div>
							<div class="col-xs-8 col-md-8">
								<input type="text" class="form-control website-input disablemoko" name="txtwebsite" id="txtwebsite" placeholder="www.sample.com">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-4 col-md-4">Mobile Number :</div>
							<div class="col-xs-8 col-md-8">
								<input type="text" class="form-control input-mask-phone disablemoko" name="txtcompanymobilenum" id="txtcompanymobilenum" placeholder="(00)-000-0000">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-4 col-md-4">Telephone Number <span class="hideifheader" style="color: red;">*</span> :</div>
							<div class="col-xs-8 col-md-8">
								<input type="text" class="form-control input-mask-tele disablemoko" name="txttelephone" id="txttelephone" placeholder="(00)-000-0000">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-4 col-md-4">FAX Number :</div>
							<div class="col-xs-8 col-md-8">
								<input type="text" class="form-control input-mask-tele disablemoko" name="txtfax" id="txtfax" placeholder="(00)-000-0000">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-4 col-md-4">TIN Number :</div>
							<div class="col-xs-8 col-md-8">
								<input type="text" class="form-control disablemoko" name="txtTIN" id="txtTIN">
							</div>
						</div>
						<div class="row form-group withPOS">
							<div class="col-xs-4 col-md-4">CSV File Path :</div>
							<div class="col-xs-8 col-md-8">
								<input type="text" class="form-control disablemoko" placeholder="C:/CSV Storage/" name="txtcsvpath" id="txtcsvpath" disabled>
							</div>
						</div>
						<div class="row form-group withPOS">
							<div class="col-xs-4 col-md-4">SFTP Host :</div>
							<div class="col-xs-8 col-md-4">
								<input type="text" class="form-control disablemoko" name="txtCSVHost" id="txtCSVHost" disabled>
							</div>
							<div class="col-xs-4 col-md-2">SFTP Port :</div>
							<div class="col-xs-8 col-md-2">
								<input type="text" class="form-control disablemoko" name="txtCSVPort" id="txtCSVPort" disabled>
							</div>
						</div>
						<?php if($_SESSION['MMS-UserID'] == 'GatessoftCorp'){ ?> 
						<div class="row form-group withPOS">
							<div class="col-xs-4 col-md-4">Database Setup <span class="hideifheader" style="color: red;">*</span> :</div>
							<div class="col-xs-8 col-md-8">
								<select class="form-control disablemoko" id="txtdbsetup">
									<option value="" selected disabled>-- Select Setup --</option>
									<option value="0">Standard</option>
									<option value="1">Federal Land</option>
								</select>
							</div>
						</div>
						<?php } ?>
					</div>
					<div class="col-md-6">
						<div class="row form-group">
							<div class="col-xs-8 col-md-8">
								<h5>Select print template</h5>
							</div>
							<div class="col-xs-4 col-md-4">
								<h5>Select Company Image <span class="hideifheader" style="color: red;">*</span></h5>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-4 col-md-4">
								<img src="assets/images/templates/header_template2.png" height="150" width="180" style="border: 1px dashed #d9d9d9;">
								<div class="radio">
									<label>
										<input name="form-field-radio" type="radio" class="ace txtcompanytemplate disablemoko" name="txtcompanytemplate" id="template1" value="1" checked>
										<span class="lbl" style="color: #666;">&nbsp;&nbsp;Template 1</span>
									</label>
								</div>
							</div>
							<div class="col-xs-4 col-md-4">
								<img src="assets/images/templates/header_template1.png" height="150" width="180" style="border: 1px dashed #d9d9d9;">
								<div class="radio">
									<label>
										<input name="form-field-radio" type="radio" class="ace txtcompanytemplate disablemoko" name="txtcompanytemplate" id="template2" value="2">
										<span class="lbl" style="color: #666;">&nbsp;&nbsp;Template 2</span>
									</label>
								</div>
							</div>
							<div class="col-xs-4 col-md-4">
								<form name="posting_companypicture" id="posting_companypicture">
									<img id="imgg1" class="img-responsive img-thumbnail" style="height: 150px;width: 221px;">
									<input type="file" class="companyimage disablemoko" name="file1" id="file1" onchange="showimggggggsetup();" accept="image/*">
								</form>
							</div>
						</div>
						<?php if($_SESSION['MMS-UserID'] == 'GatessoftCorp'){ ?> 
						<div class="row form-group">
							<div class="col-xs-4 col-md-4">Max Number of <label class="txtSysLabel1">Mall</label> <span class="hideifheader" style="color: red;">*</span> :</div>
							<div class="col-xs-8 col-md-8">
								<input type="text" class="form-control numberlang disablemoko" name="txtnumofmall" id="txtnumofmall" disabled maxlength="5">
							</div>
						</div>
						<?php } ?>
						<div class="row form-group">
							<div class="col-xs-4 col-md-4"><label class="txtSysLabel1">Mall</label> ID Prefix <span class="hideifheader" style="color: red;">*</span> :</div>
							<div class="col-xs-8 col-md-8">
								<input type="text" class="form-control disablemoko" name="txtmallprefix" id="txtmallprefix" style="text-transform:uppercase;" disabled maxlength="3">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-4 col-md-4">Inquiry ID Prefix <span class="hideifheader" style="color: red;">*</span> :</div>
							<div class="col-xs-8 col-md-8">
								<input type="text" class="form-control disablemoko" name="txtinqprefix" id="txtinqprefix" style="text-transform:uppercase;" disabled maxlength="3">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-4 col-md-4">Application ID Prefix <span class="hideifheader" style="color: red;">*</span> :</div>
							<div class="col-xs-8 col-md-8">
								<input type="text" class="form-control disablemoko" name="txtappprefix" id="txtappprefix" style="text-transform:uppercase;" disabled maxlength="3">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-4 col-md-4">Machine No :</div>
							<div class="col-xs-8 col-md-8">
								<input type="text" class="form-control disablemoko" name="txtmachineno" id="txtmachineno" disabled>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-4 col-md-4">Serial No :</div>
							<div class="col-xs-8 col-md-8">
								<input type="text" class="form-control disablemoko" name="txtserialno" id="txtserialno" disabled>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-4 col-md-4">Accreditation No :</div>
							<div class="col-xs-8 col-md-8">
								<input type="text" class="form-control disablemoko" name="txtaccreditationno" id="txtaccreditationno" disabled>
							</div>
						</div>
						<div class="row form-group hide">
							Posting Frequency 
						</div>
						<div class="row form-group hide">
							<label>
								<input type="radio" id="mms" name="btnsoftwaretype" value="0" class="btnsoftwaretype disablemoko ace">
								<span class="lbl"> Daily</span>
							</label>
						</div>
						<div class="row form-group hide">
							<label>
								<input type="radio" id="plms" name="btnsoftwaretype" value="1" class="btnsoftwaretype disablemoko ace">
								<span class="lbl"> Monthly</span>
							</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-12">
						<div class="btn-group pull-right">
							<button class="btn btn-success btn-round btn-sm" style="margin: 5px;" id="btnsetupedit" onclick="editsetup();"><i class="fa fa-edit"></i> Edit</button>
							<button class="btn btn-primary btn-round btn-sm" style="margin: 5px; display: none;" id="btnsetupsave" onclick="savesystemsetup();"><i class="fa fa-check"></i> Save</button>
							<button class="btn btn-danger btn-round btn-sm" style="margin: 5px; display: none;" id="btnsetupcancel" onclick="canceleditsetup();"><i class="fa fa-times"></i> Cancel</button>
						</div>
					</div>
				</div>
			</div>
			<div id="OtherSetup" class="tab-pane fade">
				<div class="row">
					<!-- <div class="col-md-12">
						<div class="widget-box widget-color-green2 ui-sortable-handle">
							<div class="widget-header">
								<h5 class="widget-title">Leasing</h5>

								<div class="widget-toolbar">
									<a href="#" data-action="collapse" class="AlwaysCollapse" id="btnLeasingCollapse">
										<i class="1 ace-icon fa fa-chevron-up bigger-125"></i>
									</a>
								</div>
							</div>

							<div class="widget-body">
								<div class="widget-main">
									<div class="row"> -->
										<div class="col-md-4">
											<div class="row form-group">
												<label class="col-md-12">Require selection of permits and requirements in proposal?</label>
												<div class="col-md-2">
													<div class="radio">
														<label>
															<input type="radio" name="reqpermit" class="ace rdRequirementandPermit" value="1">
															<span class="lbl">&nbsp;Yes</span>
														</label>
													</div>
												</div>
												<div class="col-md-2">
													<div class="radio">
														<label>
															<input type="radio" name="reqpermit" class="ace rdRequirementandPermit" value="0">
															<span class="lbl">&nbsp;No</span>
														</label>
													</div>
												</div>
											</div>
											<div class="row form-group hide">
												<label class="col-md-12">Adjust occupancy period based on based on "Occupy Unit" button?</label>
												<div class="col-md-2">
													<div class="radio">
														<label>
															<input type="radio" name="adjustoccupancy" class="ace rdAdjustOccupancy" value="1">
															<span class="lbl">&nbsp;Yes</span>
														</label>
													</div>
												</div>
												<div class="col-md-2">
													<div class="radio">
														<label>
															<input type="radio" name="adjustoccupancy" class="ace rdAdjustOccupancy" value="0">
															<span class="lbl">&nbsp;No</span>
														</label>
													</div>
												</div>
											</div>
											<div class="row form-group">
												<label class="col-md-12">Auto generate merchant code?</label><br>
												<div class="col-md-2">
													<div class="radio">
														<label>
															<input type="radio" name="autogenerate" class="ace rdAutoMerchantCode" value="1">
															<span class="lbl">&nbsp;Yes</span>
														</label>
													</div>
												</div>
												<div class="col-md-2">
													<div class="radio">
														<label>
															<input type="radio" name="autogenerate" class="ace rdAutoMerchantCode" value="0">
															<span class="lbl">&nbsp;No</span>
														</label>
													</div>
												</div>
											</div>
											<div class="row form-group">
												<label class="col-md-12">Include Association Dues?</label><br>
												<div class="col-md-2">
													<div class="radio">
														<label>
															<input type="radio" name="assocdues" class="ace rdAssocDues" value="1">
															<span class="lbl">&nbsp;Yes</span>
														</label>
													</div>
												</div>
												<div class="col-md-2">
													<div class="radio">
														<label>
															<input type="radio" name="assocdues" class="ace rdAssocDues" value="0">
															<span class="lbl">&nbsp;No</span>
														</label>
													</div>
												</div>
											</div>
											<div class="row form-group">
												<label class="col-md-12">Include JDA Mapping?</label><br>
												<div class="col-md-2">
													<div class="radio">
														<label>
															<input type="radio" name="JDAMapping" class="ace rdJDAMapping" value="1">
															<span class="lbl">&nbsp;Yes</span>
														</label>
													</div>
												</div>
												<div class="col-md-2">
													<div class="radio">
														<label>
															<input type="radio" name="JDAMapping" class="ace rdJDAMapping" value="0">
															<span class="lbl">&nbsp;No</span>
														</label>
													</div>
												</div>
											</div>
											<div class="row form-group hide">
												<label class="col-md-12">Allow Multiple Signatory on Company Profile</label><br>
												<div class="col-md-2">
													<div class="radio">
														<label>
															<input type="radio" name="multicomp" class="ace rdMultiCompSig" value="1">
															<span class="lbl">&nbsp;Yes</span>
														</label>
													</div>
												</div>
												<div class="col-md-2">
													<div class="radio">
														<label>
															<input type="radio" name="multicomp" class="ace rdMultiCompSig" value="0">
															<span class="lbl">&nbsp;No</span>
														</label>
													</div>
												</div>
											</div>
											<!-- <div class="row form-group">
												<label class="col-md-12">Deduct 1 Day to Occupancy Period</label><br>
												<div class="col-md-2">
													<div class="radio">
														<label>
															<input type="radio" name="DateToOccupancy" class="ace DateTordOccupancy" value="1">
															<span class="lbl"">&nbsp;Yes</span>
														</label>
													</div>
												</div>
												<div class="col-md-2">
													<div class="radio">
														<label>
															<input type="radio" name="DateToOccupancy" class="ace DateTordOccupancy" value="0">
															<span class="lbl"">&nbsp;No</span>
														</label>
													</div>
												</div>
											</div> -->
										</div>
										<div class="col-md-4">
											<div class="row form-group">
												<label class="col-md-12">Floor / Unit Measurement</label>
												<div class="col-md-7">
													<select class="form-control" id="slctFlrUnitMeasurement">
														<option value="Area">Area</option>
														<option value="LengthWidth">Length x Width</option>
													</select>
												</div>
											</div>
											<div class="row form-group hide">
												<label class="col-md-12">VAT Setup</label><br>
												<div class="col-md-4">
													<div class="radio">
														<label>
															<input type="radio" name="vatsetup" class="ace rdVatSetup" value="1">
															<span class="lbl">&nbsp;Based on Mall</span>
														</label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="radio">
														<label>
															<input type="radio" name="vatsetup" class="ace rdVatSetup" value="0">
															<span class="lbl">&nbsp;Based on Tenant</span>
														</label>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="row">
												<label class="col-md-12">Please check the unit referential you want to include in the system</label>
											</div>
											<div class="row">
												<div class="checkbox">
													<label>
														<input type="checkbox" class="ace isClassification" value="Classification">
														<span class="lbl">&nbsp;Classification</span>
													</label>
												</div>
											</div>
											<div class="row">
												<div class="checkbox">
													<label>
														<input type="checkbox" class="ace isDepartment" value="Department">
														<span class="lbl">&nbsp;Department</span>
													</label>
												</div>
											</div>
											<div class="row">
												<div class="checkbox">
													<label>
														<input type="checkbox" class="ace isCategory" value="Category">
														<span class="lbl">&nbsp;Category</span>
													</label>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<button class="btn btn-info pull-right btn-round btn-sm" onclick="SaveLeaseSys();"><i class="ace-icon fa fa-check"></i><span class="bigger-110">Save</span></button>
										</div>
									<!-- </div>
								</div>	

								<div class="widget-toolbox padding-8 clearfix">
									
								</div>
							</div>
						</div>
					</div> -->
				</div>
				<div class="row hide">
					<div class="col-md-12">
						<div class="widget-box widget-color-green2 ui-sortable-handle">
							<div class="widget-header">
								<h5 class="widget-title">Tenant Profile & Referentials</h5>

								<div class="widget-toolbar">
									<a href="#" data-action="collapse" class="AlwaysCollapse" id="btnTenantCollapse">
										<i class="1 ace-icon fa fa-chevron-up bigger-125"></i>
									</a>
								</div>
							</div>

							<div class="widget-body">
								<div class="widget-main">
									<!-- <form name="frmUploadRef" id="frmUploadRef"> -->
										<div class="row form-group">
											<div class="col-md-2">
												<select class="form-control" id="CSVType" name="CSVType" onchange="changeCSVHeader();">
													<option value="mallSetup">Mall Setup</option>
													<option value="category">Category</option>
													<option value="classification">Classification</option>
													<option value="wing">Wing/Building</option>
													<option value="floorName">Floor Name</option>
													<option value="floorSetup">Floor Setup</option>
													<option value="department">Department</option>
													<option value="industry">Industry</option>
													<option value="amenities">Amenities</option>
													<option value="unit">Unit</option>
													<option value="company">Company</option>
												</select>
											</div>
											<div class="col-md-3">
												<input id="refCSV" name="refCSV" class="form-control UploadRef" type="file">
											</div>
											<button class="btn btn-success" style="padding: 2px; font-size: 10px;" onclick="startUpload()"><span class="fa fa-upload"></span> Generate CSV</button>
										</div>
										<div class="row form-group">
											<div class="col-md-12">
												<div class="parent">
													<?php include "setup/systemsetup/uploadMall/uploadMall.php"; ?>
													<?php include "setup/systemsetup/uploadCategory/uploadCategory.php"; ?>
													<?php include "setup/systemsetup/uploadClassification/uploadClassification.php"; ?>
													<?php include "setup/systemsetup/uploadWIng/uploadWIng.php"; ?>
													<?php include "setup/systemsetup/uploadFloorName/uploadFloorName.php"; ?>
													<?php include "setup/systemsetup/uploadFloorSetup/uploadFloorSetup.php"; ?>
													<?php include "setup/systemsetup/uploadDepartment/uploadDepartment.php"; ?>
													<?php include "setup/systemsetup/uploadIndustry/uploadIndustry.php"; ?>
													<?php include "setup/systemsetup/uploadAmenities/uploadAmenities.php"; ?>
													<?php include "setup/systemsetup/uploadUnit/uploadUnit.php"; ?>
													<?php include "setup/systemsetup/uploadCompany/uploadCompany.php"; ?>
												</div>
												<table class="tabledash_footer table" style="margin: 0px !important;">
													<thead>
														<tr>
															<th id="th_tabledash_footer" style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
																<font id="txtfilemonitoringenties" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
																<input id="txtfilemonitoringpages" type="hidden">
																<ul id="ulfilemonitoringpagination" class="pagination pull-right"></ul>
															</th>
														</tr>
													</thead>
												</table>
											</div>
										</div>
									<!-- </form> -->
								</div>
								<div class="widget-toolbox padding-8 clearfix">
									<button class="btn btn-info pull-right" onclick="uploadCSV()">
										<i class="ace-icon fa fa-upload"></i>
										<span class="bigger-110">Upload</span>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="LandingPageSetup" class="tab-pane fade">
				<div class="row">
					<div class="col-md-6">
						<div class="row form-group">
							<label class="col-md-5" id="txtFirstBtn"></label>
							<div class="col-md-7">
								<input type="text" class="form-control txtSetupFields" id="txtSetupLPFirstBtn">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-md-5">Tenant Portal System Link</label>
							<div class="col-md-7">
								<input type="text" class="form-control txtSetupFields" id="txtSetupLPSecondBtn">
							</div>
						</div>						
					</div>
					<div class="col-md-6">
						<div class="row form-group">
							<label class="col-md-5">Font Color</label>
							<div class="col-md-7">
								<div class="bootstrap-colorpicker">
									<input type="text" class="form-control txtSetupFields" id="txtSetupLPFontColor">
								</div>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-md-5">Background Image</label>
							<div class="col-md-7">
								<form name="frmLPBGImage" id="frmLPBGImage">
									<input type="file" class="companyimage txtSetupFields" name="txtBGImage" id="txtBGImage" accept="image/*">
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="btn-group pull-right">
						<button class="btn btn-success btn-sm btn-round" style="margin-right: 5px;" onclick="fncEditLPSetup();" id="btnLPEdit"><i class="fa fa-edit"></i> Edit</button>
						<button class="btn btn-primary btn-sm btn-round" style="margin-right: 5px;" onclick="fncSaveLPSetup();" id="btnLPSave"><i class="fa fa-check"></i> Save</button>
						<button class="btn btn-danger btn-sm btn-round" style="margin-right: 5px;" onclick="fncCancelLPSetup();" id="btnLPCancel"><i class="fa fa-times"></i> Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade fade-scale" id="setupconnection" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div id="preloadforconnectionsetup"></div>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" onclick="removeinputs();">&times;</button>
				<h4 class="modal-title" style="font-size: 18px;">MySQL Database Setup</h4>
			</div>
			<div class="modal-body">
				<div class="row form-group">
					<div class="col-md-12">
						MySQL Host Address
					</div>
					<div class="col-md-12">
						<input type="text" class="form-control" id="txtHostAddress">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-12">
						Username
					</div>
					<div class="col-md-12">
						<input type="text" class="form-control" id="txtUsername">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-12">
						Password
					</div>
					<div class="col-md-12">
						<input type="password" class="form-control" id="txtPassword">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-12">
						Port
					</div>
					<div class="col-md-12">
						<input type="text" class="form-control" id="txtPort">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" id="btnAddReso" onclick="testconnection();"><i class="fa fa-check"></i> Save</button>
				<button class="btn btn-danger" onclick='$("#setupconnection").modal("hide")'><i class="fa fa-times"></i> Close</button>
			</div>
		</div>
	</div>
</div>
<?php 
	include ("script.php");
	include "uploadScript.php";
?>