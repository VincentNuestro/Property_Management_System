<style type="text/css">
    .hoverdocindex {
        position: relative;
        width: 500px;
        text-decoration: none !important;
        text-align: left;
    }

    .hoverdocindex::after {
        content: attr(title);
        position: bottom;
        left: 0;
        bottom: -270px !important;
        padding: 0.5em 20px;
        width: 100%;
        background: rgba(0,0,0,0.8);
        text-decoration: none !important;
        color: #fff;
        opacity: 0;
        -webkit-transition: 0.5s;
        -moz-transition: 0.5s;
        -o-transition: 0.5s;
        -ms-transition: 0.5s;
    }
    
    .hoverdocindex:hover::after, .hoverdocindex:focus::after {
        opacity: 1.0;
    }
</style>
<div id="loadingscreenforlogout"></div>
<div class="navbar-buttons navbar-header pull-right" role="navigation">
	<ul class="nav ace-nav">
		<li class="grey dropdown-modal" onclick="fnctxtSearchMallPL(); $('#showtableofmalls').modal('show');">
			<a data-toggle="dropdown" class="dropdown-toggle" href="#">
				<i class="ace-icon fa fa-tasks"></i>
				<span class="badge badge-grey" id="spn_overall_exp"></span>
			</a>
		</li>

		<li class="purple dropdown-modal">
			<a data-toggle="dropdown" class="dropdown-toggle" href="#">
				<i class="ace-icon fa fa-bell" id="i_bell_stat"></i>
				<span class="badge badge-important" id="spn_overall_not"></span>
			</a>

			<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
				<li class="dropdown-header">
					<i class="ace-icon fa fa-exclamation-triangle"></i>
					Notifications
				</li>

				<li class="dropdown-content">
					<ul class="dropdown-menu dropdown-navbar navbar-pink">
						<li>
							<a href="javascript:void(0)" onclick='confirmviewnoti_TenantRequest();'>
								<div class="clearfix">
									<span class="pull-left">
										<i class="btn btn-xs no-hover btn-success fa fa-exchange btn-round"></i>
										&nbsp;&nbsp;Tenant's Request
									</span>
									<span class="pull-right badge badge-success" id="spn_TenantRequest"></span>
								</div>
							</a>
						</li>

						<li>
							<a href="javascript:void(0)" onclick="confirmviewnoti_complaints();">
								<div class="clearfix">
									<span class="pull-left">
										<i class="btn btn-xs no-hover btn-danger fa fa-frown-o btn-round"></i>
										&nbsp;&nbsp;Complaints
									</span>
									<span class="pull-right badge badge-danger" id="spn_complaints"></span>
								</div>
							</a>
						</li>

						<li>
							<a href="javascript:void(0)" onclick="confirmviewnoti_incidentreport()">
								<div class="clearfix">
									<span class="pull-left">
										<i class="btn btn-xs no-hover btn-warning fa fa-gavel btn-round"></i>
										&nbsp;&nbsp;Pending Violation
									</span>
									<span class="pull-right badge badge-warning" id="spn_incidentreports"></span>
								</div>
							</a>
						</li>

						<li>
							<a href="javascript:void(0)" onclick="endofcontract()">
								<div class="clearfix">
									<span class="pull-left">
										<i class="btn btn-xs no-hover btn-primary fa fa-file-text-o btn-round"></i>
										&nbsp;&nbsp;End of contract
									</span>
									<span class="pull-right badge badge-info" id="spn_endo"></span>
								</div>
							</a>
						</li>

					</ul>
				</li>
			</ul>
		</li>

		<li class="light-blue dropdown-modal">
			<a data-toggle="dropdown" href="#" class="dropdown-toggle">
				<img class="nav-user-photo" src="" style="height:40px;width:50px;" id="imguser" alt="" />
				<span class="user-info">
					<small>Welcome,</small>
					<label id="lbluser"></label>
				</span>

				<i class="ace-icon fa fa-caret-down"></i>
			</a>

			<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
				<li>
					<a href="javascript:void(0)" onclick='edituser("<?php echo $_SESSION['MMS-UserID']; ?>", "<?php echo "header"; ?>");'>
						<i class="ace-icon fa fa-user"></i>
						Profile
					</a>
				</li>
				<li>
					<a href="javascript:void(0)" onclick="ChangePassword()">
						<i class="ace-icon fa fa-power-off"></i>
						Change Password
					</a>
				</li>
				<li class="divider"></li>
				<li>
					<a href="javascript:void(0)" onclick="logoutuser()">
						<i class="ace-icon fa fa-power-off"></i>
						Logout
					</a>
				</li>
			</ul>
		</li>
	</ul>
</div>

<div class="modal fade fade-scale" id="showtableofmalls" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        	<div id="preLoad-PermitList"></div>
        	<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
	    		<h4 class="modal-title" style="font-size: 18px;">List of Permits</h4>
	    	</div>
        	<div class="modal-body">
        		<div class="row">
        			<div class="col-md-3">
                    	<select class="form-control" id="txtSearchMallPL" onchange="showmallpermits();"></select>
        			</div>
        			<div class="col-md-3">
        				<span class="input-icon" style="width: 100%;">
						  	<input type="text" class="form-control" id="txtSearchTenantPL" title="Search" placeholder="Search">
						  	<i class="ace-icon fa fa-search nav-search-icon"></i>
						</span>
        			</div>
        		</div>
                <div class="row">
                    <div class=" col-xs-12 col-md-12 col-lg-12">
                        <div style="margin-top: 10px;" class="parent"> 
                            <table class="table table-bordered table-striped fixTable">
                                <thead>
                                    <tr>
                                        <th style="width: 30%;" class="thSysTenant">Tenant</th>
										<th style="width: 30%;">Date From</th>
										<th style="width: 30%;">Date To</th>
										<th style="width: 10%; z-index: 1;"></th>                 
                                    </tr>
                                </thead>
                                <tbody id="tbodyPermitList"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="col-md-12">
                		<div id="nilalaman"></div>
                	</div>
				</div>
            </div>
            <div class="modal-footer">
				<button class="btn btn-danger btn-sm btn-round" onclick='$("#showtableofmalls").modal("hide")'>Close</button>
			</div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="detailedviewofdocs" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        	<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
        		<h4 class="modal-title" id="docstenantname" style="font-size: 18px;"></h4>
        	</div>
            <div class="modal-body">
            	<div class="row">
            		<div class="col-md-7">
            		</div>
            		<div class="col-md-5">
                		<span class='label label-xlg label-danger arrowed-in-right arrowed bold pull-right'>Expired</span>
                		<span class='label label-xlg label-warning arrowed-in-right arrowed bold pull-right'>Will expire on 30 days or less</span>
            		</div>
            	</div>
                <div class="row" style="margin-top: 10px;">
                	<div class="parent">
						<table class="table table-bordered table-striped fixTable">
                            <thead>
								<tr>
									<th style="width: 30%;">Document Name</th>
									<th style="width: 30%;">Document Description</th>
									<th style="width: 30%;">Expiry Date</th>
									<th style="width: 10%; z-index: 1;"></th>
								</tr>
							</thead>
							<tbody id="tbltenantdocslist"></tbody>
						</table>
					</div>
				</div>
            </div>
            <div class="modal-footer">
				<button class="btn btn-danger btn-sm btn-round" onclick='$("#detailedviewofdocs").modal("hide")'>Close</button>
			</div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" role="dialog" id="modaldocuindex">
	<button type="button" class="close" style="font-size: 40px;" data-dismiss="modal">&times;</button>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="docuimghere">
                            <a class="hoverdocindex" title="Click the image to download." download>
                                <img id="docuimgindex" alt="Document Image" style="width: 100%;">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="modal_viewmemotab" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="width: 70%;">
        <div class="modal-content">
        	<div id="preloadmemo"></div>
        	<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
        		<h4 class="modal-title" style="font-size: 18px;">Memo</h4>
        	</div>
            <div class="modal-body">
                <div class="row">
                	<div class="col-md-12">
	                	<div class="row form-group" style="margin-bottom: 2px !important;">
	                		<div class="col-md-3">
	                			<span class="input-icon" style="width: 100%;">
						          	<input type="text" class="form-control" id="txtsearchmemokey" title="Search" placeholder="Search">
						          	<i class="ace-icon fa fa-search nav-search-icon"></i>
						        </span>
	                		</div>
	                		<div class="col-md-7">
	                			<h5><a onclick="loadfilters_memo('Memo');" id="LINK_memo_filter" class="popover-info" data-rel="popover" data-placement="bottom" title="Filter by" data-content='
                                        <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
	                                    	<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:95px;">&nbsp;&nbsp;Search by&nbsp;&nbsp;</legend>
	                                        <div class="form-group row" style="margin:0px;">
	                                            <div class="col-md-4">
	                                                <label>
	                                                    <input name="form-field-chkmemo" class="ace ace-checkbox-2 complaint_module_filter" type="checkbox" value="b.Tradename" id="filter_b.Tradename">
	                                                    <span class="lbl"> Tenant Name</span>
	                                                </label>
	                                            </div>
	                                            <div class="col-md-4">
	                                                <label>
	                                                    <input name="form-field-chkmemo" class="ace ace-checkbox-2 complaint_module_filter" type="checkbox" value="a.MemoSubj" id="filter_a.MemoSubj">
	                                                    <span class="lbl"> Subject</span>
	                                                </label>                               
	                                            </div>
	                                            <div class="col-md-4">
	                                                <label>
	                                                    <input name="form-field-chkmemo" class="ace ace-checkbox-2 complaint_module_filter" type="checkbox" value="a.MemoContent" id="filter_a.MemoContent">
	                                                    <span class="lbl"> Content</span>
	                                                </label>                            
	                                            </div>
	                                        </div>
	                                    </fieldset>

                                      	<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_chkappdate">
	                                    	<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:90px;">&nbsp;&nbsp;Date&nbsp;&nbsp;</legend>
	                                      	<div class="form-group row" style="margin:0px;">
		                                        <div class="col-md-1"></div>
		                                        <div class="col-md-5">
		                                          	<div class="input-group">
			                                            <span class="input-group-addon">
			                                              	<i class="fa fa-calendar bigger-110"></i>
			                                            </span>
			                                            <input class="form-control date-picker" type="text" name="" id="MemoDateFrom" data-provide="datepicker">
		                                          	</div>                
		                                        </div>
		                                        <div class="col-md-5">
		                                          	<div class="input-group">
			                                            <span class="input-group-addon">
			                                              	<i class="fa fa-calendar bigger-110"></i>
			                                            </span>
			                                            <input class="form-control date-picker" type="text" name="" id="MemoDateTo" data-provide="datepicker">
		                                          	</div>                
		                                        </div>
		                                        <div class="col-md-1"></div>
	                                      	</div>
	                                    </fieldset>

                                        <div class="form-group row" style="padding-left:8px;margin-bottom:0px;">
                                            <div class="col-md-9" style="padding-right:0px;">
                                                <div class="alert alert-info" style="padding-top:10px;padding-bottom:10px;">
                                                    <button class="close" data-dismiss="alert">
                                                        <i class="ace-icon fa fa-times"></i>
                                                    </button>
                                              Select the range of date you want to print.
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <button class="btn btn-xs btn-success btn-round" onclick="savememofilter()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">
                                                Ok
                                                </button>
                                            </div>
                                        </div>'>
                                    <i class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;Select Filter here</a>
                                </h5>
	                		</div>
	                		<div class="col-md-2">
	                			<button class="btn btn-sm btn-info pull-right btn-round" onclick="createnewmemo()">New Memo</button>
	                		</div>
	                	</div>
	                	<div class="row form-group">
	                		<div class="col-md-12">
	                			<div style="height: 50vh;">
	                				<table class="table table-bordered table-striped fixTable">
	                					<thead>
											<tr>
												<th width="10%">Date</th>
												<th width="15%">Tenant Name</th>
												<th width="25%">Subject</th>
												<th width="45%">Content</th>
												<th width="5%">Option</th>
											</tr>
										</thead>
										<tbody id="tblmemolist"></tbody>
									</table>
	                			</div>
	                			<table class="tabledash_footer table" style="margin: 0px !important;">
					                <thead>
					                    <tr>
					                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
					                            <font  id="memoentries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
					                            <input  id="memopagecount" type="hidden">
					                            <ul id="ulpaginationmemo" class="pagination pull-right"></ul>
					                        </th>
					                    </tr>
					                </thead>
					            </table>
	                		</div>
	                	</div>
                	</div>
				</div>
            </div>
            <div class="modal-footer">
				<button class="btn btn-danger btn-sm btn-round" onclick='$("#modal_viewmemotab").modal("hide")'>Close</button>
			</div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="modal_createnewmemo" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
        	<div id="preloadmodal_memo"></div>
        	<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
        		<h4 class="modal-title" style="font-size: 18px;">Memo</h4>
        	</div>
            <div class="modal-body">
                <div class="row">
                	<div class="col-md-12">
	                	<form id="frmMemo" name="frmMemo">
		                	<div class="row form-group">
		                		<div class="col-md-4">
		                			<h4>Tenant</h4>
		                			<h6>(Hold CTRL for multiple select)</h6>
		                		</div>
		                		<div class="col-md-8">
									<select multiple="multiple" class="form-control memo_required" id="memotenantlist" name="memotenantlist"></select>
		                		</div>
		                	</div>
		                	<div class="row form-group">
		                		<div class="col-md-4">
		                			Subject
		                		</div>
		                		<div class="col-md-8">
		                			<input type="text" class="form-control memo_required" placeholder="Subject" id="memosubject" name="memosubject">
		                		</div>
		                	</div>
		                	<div class="row form-group">
		                		<div class="col-md-12">
		                			<textarea class="form-control" style="height: 100px;resize: none;" id="memocontent" name="memocontent"></textarea>
		                		</div>
		                	</div>
		                	<div class="row form-group">
		                		<div id="div_attachment"></div>
		                	</div>
		                	<input type="hidden" id="attachmentcount" name="attachmentcount">
	                	</form>
	                	<div class="row form-group">
	                		<div class="col-md-12">
		                		<button class="btn btn-sm btn-success pull-right btn-round" onclick="appendattachment()"><i class="fa fa-plus"></i> Add New Attachment</button>
	                		</div>
	                	</div>
	                </div>
				</div>
            </div>
            <div class="modal-footer">
				<button class="btn btn-primary btn-sm btn-round" onclick='sendmemo();'><i class="fa fa-paper-plane"></i> Send Memo</button>
				<button class="btn btn-danger btn-sm btn-round" onclick='closememotab();'><i class="fa fa-times"></i> Cancel</button>
			</div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="modal_ViewMemoTenant" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
        	<div id="preloadmodal_memo"></div>
        	<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
        		<h4 class="modal-title" style="font-size: 18px;">Memo</h4>
        	</div>
            <div class="modal-body">
                <div class="row">
                	<div class="col-md-12">
		                	<div class="row form-group">
		                		<div class="col-md-4">
		                			<b>Tenant</b>
		                		</div>
		                		<div class="col-md-8">
		                			<label class="form-control" id="ViewMemoTenantName"></label>
		                		</div>
		                	</div>
		                	<div class="row form-group">
		                		<div class="col-md-4">
		                			<b>Subject</b>
		                		</div>
		                		<div class="col-md-8">
		                			<label class="form-control" id="ViewMemoSubject"></label>
		                		</div>
		                	</div>
		                	<div class="row form-group">
		                		<div class="col-md-12">
		                			<textarea class="form-control" style="height: 300px;resize: none;background-color: white !important;" readonly id="ViewMemoContent"></textarea>
		                		</div>
		                	</div>
		                	<div class="row form-group">
		                		<div class="col-md-12">
		                			<b>Attachments</b>
		                		</div>
		                	</div>
	                	<div id="ViewMemoAttachments"></div>
	                </div>
				</div>
            </div>
            <div class="modal-footer">
				<button class="btn btn-danger btn-sm btn-round" onclick='$("#modal_ViewMemoTenant").modal("hide");'><i class="fa fa-times"></i> Close</button>
			</div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdl_ChangePassword" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
  	<div class="modal-dialog modal-md" style="width: 30%;">  
	    <div class="modal-content">
	    	<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
        		<h4 class="modal-title" style="font-size: 18px;">Change Password</h4>
        	</div>
	      	<div class="modal-body"> 
		        <div class="row form-group">
			        <div class="col-md-12"> 
			        	<div class="row form-group">
			              	<label class="control-label col-md-4">Old Password</label>
			              	<div class="col-md-8">
			                	<input type="password" name="password" id="txtUserPass1" class="form-control thisisrequiredheader">
			              	</div>  
			            </div>
			        	<div class="row form-group">
			              	<label class="control-label col-md-4">New Password</label>
			              	<div class="col-md-8">
			                	<input type="password" name="password" id="txtUserPass2" class="form-control thisisrequiredheader">
			              	</div>  
			            </div>
			            <div class="row form-group">
			              	<label class="control-label col-md-4">Confirm Password</label>
			              	<div class="col-md-8">
			                	<input type="password" name="password" id="txtUserPass3" class="form-control thisisrequiredheader">
			              	</div>  
			            </div>
			        </div>
		        </div>	 
	      	</div>
	      	<div class="modal-footer">
	        	<button class="btn btn-success btn-sm btn-round" id="btnsavingofuser2" onclick='saveMdlChanges()'><span class='fa fa-check'></span> Save</button>
	      	</div>
	    </div>
  	</div>
</div>

<input type="hidden" id="alucard">
<script type="text/javascript">
	setInterval(function(){
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=getnum_not',
			success: function(data){
				var arr = data.split("|");
				if(arr[0] != "0"){
					$("#i_bell_stat").removeClass("icon-animated-bell");
					$("#i_bell_stat").addClass("icon-animated-bell");
				}else{
					$("#i_bell_stat").removeClass("icon-animated-bell");
				}
				$("#spn_overall_not").text(arr[0]);
				$("#spn_endo").text(arr[1])
				$("#spn_complaints").text(arr[2])
				$("#spn_incidentreports").text(arr[3])
				$("#spn_TenantRequest").text(arr[4]);
			}
		})
	},1000);
	$(function(){
		$("#memopagecount").val("1");
		$("#txtsearchmemokey").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				viewmemolist(); 
			}else if(x == '8'){
                if($('#txtsearchmemokey').val() == ""){
                    viewmemolist();
                }
            }
		});
		$("#txtSearchTenantPL").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				showmallpermits(); 
			}else if(x == '8'){
                if($('#txtSearchTenantPL').val() == ""){
                    showmallpermits();
                }
            }
		});
		$("#txtUserPass1").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				saveMdlChanges(); 
			}
		});
		$("#txtUserPass2").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				saveMdlChanges(); 
			}
		});
		$("#txtUserPass3").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				saveMdlChanges(); 
			}
		});
		$("#select_all_penalty").click(function(){
			if($(this).is(":checked")){
				$("#tblpenallist .chk_pena").each(function(){$(this).prop("checked", true)});
			}else{
				$("#tblpenallist .chk_pena").each(function(){$(this).prop("checked", false)});	
			}
		})
		$("#select_all_endo").click(function(){
			if($(this).is(":checked")){
				$("#tblendolist .chk_endo").each(function(){$(this).prop("checked", true)});
			}else{
				$("#tblendolist .chk_endo").each(function(){$(this).prop("checked", false)});	
			}
		})
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=showmallpermitsnoti',
			success: function(data){
				$("#spn_overall_exp").text(data);
			}
		})
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=getuserdata',
			success: function(data){
				var arr = data.split("|");
				if(arr[0] == ""){
					$("#lbluser").text("Gatessoft Corp");
				}else{
					$("#lbluser").text(arr[0]);
				}
				$("#imguser").attr("alt", arr[0] +"'s Photo");
				$("#imguser").attr("src",arr[2])
			}
		})
	})

	function logoutuser(){
	    $.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=logoutuserlogs',
			beforeSend : function() {
		       $('#indexloadingscreen').addClass('myspinner');
		    },
			success: function(data){
		        $('#indexloadingscreen').removeClass('myspinner');
				window.location = "logout.php";
			}
		})
	}

	function showmallpermits(){
		var key = $("#txtSearchTenantPL").val();
		var mallID = $("#txtSearchMallPL").val();
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'mallID=' + mallID + '&key=' + key + '&form=showmallpermits',
			beforeSend : function() {
		       $('#preLoad-PermitList').addClass('myspinner');
		    },
			success: function(data){
		        $('#preLoad-PermitList').removeClass('myspinner');
				$("#tbodyPermitList").html(data);
				$(".fixTable").tableHeadFixer(); 
			}
		})
	}

	function fnctxtSearchMallPL(){
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=tblref_mall',
			success:function(data){
				$("#txtSearchMallPL").html(data);
			}, complete: function(){
				showmallpermits(); 
			}
		})
	}

	function viewdetaileddocs(inqid, tradename){
		$("#detailedviewofdocs").modal("show");
		$("#docstenantname").text(tradename);
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'inqid=' + inqid + '&form=viewdetaileddocs',
			success:function(data){
				$("#tbltenantdocslist").html(data);
			}
		})
	}

	function viewdocuimgindex(imgpath) {
        $("#modaldocuindex").modal("show");
        $("#docuimgindex").attr("src", imgpath);
        $(".hoverdocindex").attr("href", imgpath);
    }

    function viewmemolist(){
    	var key = $("#txtsearchmemokey").val();
    	var page = $("#memopagecount").val();
    	$.ajax({
    		type: 'POST',
    		url: 'mainclass.php',
    		data: 'page=' + page + '&key=' + key + '&form=viewmemolist',
    		beforeSend : function() {
     			$('#preloadmodal_memo').addClass('myspinner');
      		},
    		success: function(data){
	      		$('#preloadmodal_memo').removeClass('myspinner');
	      		$("#tblmemolist").html(data);
	      		loadmemoentries();
	      		loadmemopage();
	      	}
    	})
    }

    function loadmemoentries(){
    	var key = $("#txtsearchmemokey").val();
	    var page = $("#memopagecount").val();
	    $.ajax({
	        type: 'POST',
	        url: 'mainclass.php',
	        data: 'page=' + page + '&key=' + key + '&form=loadmemoentries',
	        success: function(data){
	            if(data == "no data"){
	                $("#memoentries").text("");
	            }else{
	                $("#memoentries").text(data);
	            }
	        }
	    });
	}

	function loadmemopage(){
	    var page = $("#memopagecount").val();
    	var key = $("#txtsearchmemokey").val();
	    $.ajax({
	        type: 'POST',
	        url: 'mainclass.php',
	        data: 'page=' + page + '&key=' + key + '&form=loadmemopage',
	        success: function(data){
	            $("#ulpaginationmemo").html(data);
	        }
	    });
	}

	function paginationmemo(page, pagenums){
	    $(".pgnumpmemo").removeClass("active");
	    var value = "#" + pagenums;
	    $("#pgmemo" + pagenums).addClass("active");
	    $("#memopagecount").val(page);
	    viewmemolist();
	    loadmemoentries();
	    loadmemopage();
	}

    function viewmemotab(){
    	$("#modal_viewmemotab").modal("show");
    	viewmemolist();
    }

    function appendattachment(){
    	var count = $("#attachmentcount").val();
		count = Number(count) + 1;
		$("#div_attachment").append("<div class='col-md-4'></div><div class='col-md-8'><input type='file' class='memo_attachment' id='memoattachment"+count+"' name='attachment"+count+"'></div>");
		$('.memo_attachment').ace_file_input({
			no_file:'No File ...',
			btn_choose:'Choose',
			btn_change:'Change',
			droppable:false,
			onchange:null,
			thumbnail:false //| true | large
		});
		$("#attachmentcount").val(count);
    }

    function closememotab(){
    	$("#modal_createnewmemo").modal("hide");
    	$("#modal_createnewmemo :input").val("");
    	viewmemolist();
    }

    function createnewmemo(){
    	$("#div_attachment").html("<div class='col-md-4'>Attachment</div><div class='col-md-8'><input type='file' class='memo_attachment' name='attachment1'></div>");
		$('.memo_attachment').ace_file_input({
			no_file:'No File ...',
			btn_choose:'Choose',
			btn_change:'Change',
			droppable:false,
			onchange:null,
			thumbnail:false //| true | large
		});
        $(".memo_required").css("border-color","#D5D5D5");
		$("#attachmentcount").val("1");
    	$("#modal_createnewmemo").modal("show");
    	$.ajax({
    		type: 'POST',
    		url: 'mainclass.php',
    		data: 'form=memotenantlist',
    		success:function(data){
    			$("#memotenantlist").html(data);
    		}
    	})
    }

    function sendmemo(){
    	var data = new FormData($('#frmMemo')[0]);
    	var tenantids = $("#memotenantlist").val();
		var subject = $("#memosubject").val();
		var content = $("#memocontent").val();
		var blank = 0;
		$(".memo_required").each(function(){
			if($(this).val() == "" || $(this).val() == null || $(this).val() == "undefined"){
        		$(this).css("border-color","#f2a696");
				blank++;
			}else{
        		$(this).css("border-color","#D5D5D5");
			}
		})
		if(blank == 0){
			$('#preloadmodal_memo').addClass('myspinner');
			$.ajax({
		        type: 'POST',
		        url: 'header/saveattachmentofmemo.php',
		        data: data,
		        mimeType: 'multipart/form-data',
		        contentType: false,
		        cache: false,
		        processData: false,
		        success:function(data2){
	        		$.ajax({
			    		type: 'POST',
			    		url: 'mainclass.php',
			    		data: 'tenantids=' + tenantids + '&subject=' + subject + '&content=' + content + '&MemoID=' + data2 + '&form=sendmemo',
			    		success: function(data3){
				      		$('#preloadmodal_memo').removeClass('myspinner');
				      		if(data3 == "SUCCESS"){
								setTimeout(function(){
									showmodal("alert", "Memo has been sent.", "closememotab", null, "", null, "0");
								}, 1000)
				      		}else{
				      			setTimeout(function(){
									showmodal("alert", "Failed to send the memo.", "", null, "", null, "1");
								}, 1000)
				      		}
				      	}
			    	})
		        }
	      	})
		}else{
			setTimeout(function(){
				showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
			}, 1000)
		}
    }

    function ViewMemoTenant(MemoID, TenantID){
    	$("#modal_ViewMemoTenant").modal("show");
    	$.ajax({
    		type: 'POST',
    		url: 'mainclass.php',
    		data: 'MemoID=' + MemoID + '&TenantID=' + TenantID + '&form=ViewMemoTenant',
    		success:function(data){
    			var arr = data.split("|");
				$("#ViewMemoTenantName").text(arr[0]);
				$("#ViewMemoSubject").text(arr[1]);
				$("#ViewMemoContent").val(arr[2]);
				$("#ViewMemoAttachments").html(arr[3]);
    		}
    	})
    }

    function savememofilter(){
    	var module = "Memo";
	    var checked = "";
	    $('input:checkbox[name="form-field-chkmemo"]').each(function(){
	        if($(this).is(":checked")){
	            var value = $(this).attr("value");
	            checked += value + "|";
	        }
	    })

	    var checked2 = "";
	    $('input:checkbox[name="form-field-chkmemo"]').each(function(){
	        var value2 = $(this).attr("value");
	        checked2 += value2 + "|";
	    })

	    var Date1 = $("#MemoDateFrom").val();
	    var Date2 = $("#MemoDateTo").val();

	    $.ajax({
	        type: 'POST',
	        url: 'filter/class.php',
	        data: 'module=' + module + '&checked=' + checked + '&checked2=' + checked2 + '&Date1=' + Date1 + '&Date2=' + Date2 + '&form=saveFilters',
	        beforeSend : function() {
	            $('#preloadmemo').addClass('myspinner');
	        },
	        success: function(data){
	            $('#preloadmemo').removeClass('myspinner');
	            viewmemolist()
	            $("#LINK_memo_filter").click();
	        }
	    })
    }

    function loadfilters_memo(module){
	    $.ajax({
	        type: 'POST',
	        url: 'filter/class.php',
	        data: 'module=' + module + '&form=loadFilters',
	        success: function(data){
	            var datas = data.split("#");
	            var arr = datas[0].split("|");
	            var arr2 = datas[1].split("|");
	            for(var i=0; i<=arr.length-1; i++){
	                $('input:checkbox[id="filter_'+arr[i]+'"][value="'+arr[i]+'"]').attr('checked', 'checked');
	            }
	            $("#MemoDateFrom").val(arr2[0]);
	            $("#MemoDateTo").val(arr2[1]);
	        }
	    })
	}

	function ChangePassword(){
		$("#mdl_ChangePassword").modal("show");
	}

	function closeChangePassword(){
		$("#mdl_ChangePassword").modal("hide");
		$("#mdl_ChangePassword :input").val("");
	}

	function saveMdlChanges(){
		var Old = $("#txtUserPass1").val();
		var New = $("#txtUserPass2").val();
		var New2 = $("#txtUserPass3").val();
		var count = 0;
		$(".thisisrequiredheader").each(function(){
			if($(this).val() == ""){
				$(this).css("border-color","#f2a696");
				count++;
        	}else{
				$(this).css("border-color","#D5D5D5");
        	}
		})
		if(count == 0){
			$.ajax({
				type: 'POST',
				url: 'mainclass.php',
				data: 'Old=' + Old + '&New=' + New + '&New2=' + New2 + '&form=saveMdlChanges',
				success:function(data){
					var arr = data.split("|");
					if(arr[0] == 1){
						setTimeout(function(){
							showmodal("alert", arr[1], "closeChangePassword", null, "", null, "0");
						}, 500)
					}else{
						setTimeout(function(){
							showmodal("alert", arr[1], "", null, "", null, "1");
						}, 500)
					}
				}
			})
		}else{
			setTimeout(function(){
				showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
			}, 500)
		}
	}

	function ViewTrasactionLogs(id){
		$("#modal_ViewTrasactionLogs").modal("show");
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'mainID=' + id + '&form=ViewAllHistory',
			success: function(data){
				$("#tblViewTransactionLogs").html(data);
			}
		})
	}

	function endofcontract(){
		if($("#spn_endo").text() != ""){
			$("#select_all_endo").prop("checked", false);
			loadendolist();
			$("#modal_endo").modal("show");
		}
	}

	function loadendolist(){
		if($("#select_all_endo").is(":checked")){
			var chk = "checked";
		}else{
			var chk = "unchecked";
		}
		var key = $("#txtsearchendo").val();
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'key='+key+'&form=tblendofcontract',
			beforeSend : function() {
	         	$('#spinner_endo').addClass('fa-spin');
	        },
			success: function(data){
				$('#spinner_endo').removeClass('fa-spin');
				$("#tblendolist").html(data);
				if(chk == "checked"){
					$("#tblendolist .chk_endo").each(function(){$(this).prop("checked", true)});
				}else{
					$("#tblendolist .chk_endo").each(function(){$(this).prop("checked", false)});	
				}						
			}
		})
	}

	function endofcontract_proceed(){
		var value = "";
		$("#tblendolist .chk_endo").each(function(){
			if($(this).is(":checked")){
				value += $(this).attr("value") + "#";
			}
		});
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'val='+value+'&form=endofcontract',
			success: function(data){
				loadendolist();
				setTimeout(function(){
					showmodal("alert", "Successfully changed status.", "", null, "", null, "0");
				}, 500)
			}
		})
	}

	function endoclick(){
		var pen = 0;
		$("#tblendolist .chk_endo").each(function(){if($(this).is(":checked")){pen++}});
		if(pen > 0){
			setTimeout(function(){
				showmodal("alert", "Are you sure you want to change status of selected tenant(s). Click \"OK\" to proceed.", "endofcontract_proceed()", null, "", null, "0");					
			}, 500)
		}else{
			setTimeout(function(){
				showmodal("alert", "Select tenant first.", "", null, "", null, "1");
			}, 500)
		}
	}

	function confirmviewnoti_TenantRequest(){
  		if($("#spn_TenantRequest").text() != ""){
  			viewnoti_TenantRequest();
  			$("#noti_TenantRequest").modal("show");
  		}
  	}

  	function closenoti_TenantRequest(){
  		$("#noti_TenantRequest").modal("hide");
  	}

  	function viewnoti_TenantRequest(){
  		var key = $("#txtSearchTenantRequest").val();
  		$.ajax({
  			type: 'POST',
  			url: 'mainclass.php',
  			data: 'key=' + key + '&form=viewnoti_TenantRequest',
  			success: function(data){
  				$("#tblnotiTenantRequestList").html(data);
  			}
  		})
  	}

  	function confirmviewnoti_complaints(){
  		if($("#spn_complaints").text() != ""){
  			viewnoti_complaints();
  			$("#noti_complaints").modal("show");
  		}
  	}

  	function confirmviewnoti_incidentreport(){
  		if($("#spn_incidentreports").text() != ""){
  			viewnoti_incidentreport();
  			$("#noti_incidentreport").modal("show");
  		}
  	}

  	function viewnoti_complaints(){
  		var key = $("#txtsearchcomplaintsnoti").val();
  		$.ajax({
  			type: 'POST',
  			url: 'mainclass.php',
  			data: 'key=' + key + '&form=viewnoti_complaints',
  			success:function(data){
  				$("#tblnoticomplaintslist").html(data);
  			}
  		})
  	}

  	function closenoti_complaints(){
  		$("#txtsearchcomplaintsnoti").val("");
  		$("#noti_complaints").modal("hide")
  	}

  	function viewnoti_incidentreport(){
  		var key = $("#txtsearchincidentreportnoti").val();
  		$.ajax({
  			type: 'POST',
  			url: 'mainclass.php',
  			data: 'key=' + key + '&form=viewnoti_incidentreport',
  			success:function(data){
  				$("#tblnotiincidentreportlist").html(data);
  			}
  		})
  	}

  	function closenoti_incidentreport(){
  		$("#txtsearchincidentreportnoti").val("");
  		$("#noti_incidentreport").modal("hide")
  	}
  	
  	function loadnotifications(){
			    $.ajax({
			      	type: 'POST',
			      	url: 'mainclass.php',
			      	data: 'form=loadnotifications',
			      	success: function(data){
				        var arr = data.split("|");
				        $("#span_id_notif").attr("title", arr[0]);
				        $("#span_id_notif").html(arr[1]);
				        $('[data-rel=tooltip]').tooltip();
				        $('[data-rel=popover]').popover({html:true});
			      	}
			    });
			}
</script>

<?php  
	include "setup/user/script.php";
	include "setup/user/modal_user.php";
?>