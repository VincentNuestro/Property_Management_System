<div class="row">
	<div class="col-sm-12">
		<div class="row form-group" style="margin-bottom: 0px;">
			<div class="col-sm-1" style="padding-bottom: 5px;padding-right:0px;">
	        	<select class="form-control" id="txtfusertype">
	            	<option value="">All User</option>
	                <option value="1">Admin</option>
	                <option value="0">User</option>
	            </select>
	        </div>
	    	<div class="col-sm-2" style="padding-bottom: 5px;padding-right:0px;">
	    		<span class="input-icon" style="width: 100%;">
	              	<input type="text" class="form-control" id="txtfuserkey" title="Search" placeholder="Search">
	              	<i class="ace-icon fa fa-search nav-search-icon"></i>
	          	</span>
	        </div>
	        <div class="col-sm-3" style="padding-bottom: 5px;padding-right:0px;">
	        	<div class="radio" style="margin: 8px;">
	            	<span style="font-size: 14px; color: #666; margin-right: 10px;">Gender:</span>
	                <label>
	                    <input name="txtfgender" class="ace txtfgender" type="radio" checked="checked" value="">
	                    <span class="lbl">&nbsp;All</span>
	                </label>
	                <label>
	                    <input name="txtfgender" class="ace txtfgender" type="radio" value="Male">
	                    <span class="lbl">&nbsp;Male</span>
	                </label>
	                <label>
	                    <input name="txtfgender" class="ace txtfgender" type="radio" value="Female">
	                    <span class="lbl">&nbsp;Female</span>
	                </label>
	            </div>
	        </div>
	        <div class="col-sm-2" style="padding-bottom: 5px;padding-right:0px;">
				<button class="btn btn-sm btn-info hide isadmin select-addnewuser btn-round btn-block" onclick="newuser();">New User</button>
	        </div>
	        <div class="col-sm-2" style="padding-bottom: 5px;padding-right:0px;">
				<button class="btn btn-sm btn-warning hide isadmin select-addusergroup select-editusergroup select-deleteusergroup select-modifyuseraccess btn-round btn-block" onclick="showpermissionmodal();">New User Role</button>
			</div>
	        <div class="col-sm-2" style="padding-bottom: 5px;padding-right:0px;">
	        	<button class="btn btn-danger btn-sm hide isadmin select-hierarchyapprovalaccess btn-round btn-block" onclick="showmodalhierarchy();">Hierarchy of Approval</button>
	        </div>
	           	<!-- <button class="btn btn-success btn-sm hide isadmin select-modifyapprovallevel select-addapprover select-editapprover select-deleteapprover select-modifyuseraccess btn-round" onclick="showmodallistandlevel();" style="margin-right: 5px;"><span class="fa fa-signal" ></span>&nbsp;&nbsp;Approval List & Leveling</button> -->
	    </div>
	    <div class="row form-group">
        	<div class="parent">
	            <table class="table table-bordered fixTable">
	                <thead>
	                    <tr>
	                        <th style="width: 10%;"></th>
	                        <th style="width: 20%;">Full name</th>
	                        <th style="width: 8%;">Gender</th>
	                        <th style="width: 10%;">Contact no.</th>
	                        <th style="width: 19%;">Email</th>
	                        <th style="width: 10%;">User Type</th>
	                        <th style="width: 15%;">User Role</th>
	                        <th style="width: 8%; z-index: 1;">Status</th>
	                        <th style="width: 10%; border-right: solid 1px #dddddd;z-index: 1;">Options</th>
	                    </tr>
	                </thead>
	            	<tbody id="userlist"></tbody>
	            </table>
	        </div>
	        <table class="tabledash_footer table">
		        <thead>
		          	<tr>
			            <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
			              	<font id="txtUsersEntries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
			              	<input id="txtUsersCount" type="hidden">
			              	<ul id="ulUsersPagination" class="pagination pull-right"></ul>
			            </th>
		          	</tr>
		        </thead>
		    </table>
	    </div>
    </div>
</div>
<?php 
	// include("modal_user.php"); 
	include("script.php"); 
?>