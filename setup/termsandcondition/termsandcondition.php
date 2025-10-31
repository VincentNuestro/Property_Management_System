<style>
.divstat span:hover{
    border-bottom: 1px solid #438EB9;
    color: #438EB9;
    cursor: pointer;
    font-weight: bold;
}
</style>
<div class="row">
    <div class="col-md-12">
       <div class="row form-group" style="margin-bottom: 0px;">
            <div class="col-xs-6 col-md-2" style="padding-bottom: 5px;padding-left: 0px;">        
            	<select id="filterbygroup2" onchange="displaygroup();" class="form-control"></select>
            </div>
            <div class="col-xs-6 col-md-2" style="padding-bottom: 5px;padding-left: 0px;">
                <span class="input-icon" style="width: 100%;">
                    <input type="text" class="form-control" placeholder="Search" title="Search" id="txttermsanconditionsearch">
                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                </span>
            </div>
            <div class="col-xs-12 col-md-2 pull-right" style="padding-bottom: 5px;padding-right: 0px;">
                <button type="button" class="btn btn-sm btn-primary hide isadmin select-addtermsandconditions btn-round" onclick="loadmodal_newgroup()">New Terms and Conditions</button>
            </div>
        </div>
    	<div class="row form-group" style="margin-bottom: 0px !important;">
            <div class="parent">
				<table class="table table-bordered table-striped fixTable">
                    <thead>
                        <tr>
                            <th width="20%" class="group_name">Group Name</th>
                            <th width="20%" class="terms">Term Name</th>
                            <th width="50%" class="conditions">Condition</th>
                            <th width="5%" class="stats" style="z-index: 1;">Status</th>
                            <th width="5%" class="option" style="z-index: 1;">Option</th>
                        </tr>
                    </thead>
        			<tbody id="displaygroup"></tbody>
    			</table>
            </div>
            <table class="tabledash_footer table" style="margin: 0px !important;">
                <thead>
                    <tr>
                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                            <font id="txttacentries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                            <input id="txt_userpage" type="hidden">
                            <ul id="ulpaginationtac" class="pagination pull-right"></ul>
                        </th>
                    </tr>
                </thead>
            </table>
    	</div>
    </div>
</div>

<input type="hidden" id="getid">

<?php
    include("script.php");
	include("group_modal.php");
?>
