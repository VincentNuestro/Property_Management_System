<style type="text/css">
	.zoom {
      	display: inline-block;
      	position: relative;
    }
    .zoom:after {
      	content: '';
      	display: block; 
      	width: 33px; 
      	height: 33px; 
      	position: absolute; 
      	top: 0;
      	right: 0;
      	background: url(icon.png);
    }
    .zoom img::selection {
     	background-color: transparent; 
 	}
    .myupload{
		/*border: dashed 1px #999;*/
		padding: 15px;
		display: block;
		margin: 10px;
	}
	.myupload h1{
		font-size: 18px;
		font-weight: 400 !important;
		color: #999;
		text-align: center;
		margin-top: 10px;
		margin-bottom: 20px;
	}
	.myupload input[type="file"]{ 
        opacity: 0; 
    }
</style>

<div class="col-md-7 refMainCategory divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-th-large light-green bigger-130"></i>&nbsp; Category
            </h5>
        </div>
        <div class="space-4"></div>
		<div class="row form-group">
			<div class="col-md-10">
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
					<input type="text" class="form-control input-sm" id="txtsearchMainCat">
				</div>
			</div>
			<div class="col-md-2">
				<div class='btn-group pull-right'>
			       <button class='btn btn-info btn-round btn-sm' onclick="$arr = [];$arr.push( 'page='+$('#txtPageMainCat').val() );$arr.push( 'key='+$('#txtsearchMainCat').val() );getheaderprint('<?php echo $_SESSION['MMS-Designation']; ?>','refmaincategoryrep',JSON.stringify($arr));" style="cursor: pointer;" data-placement="bottom" title="">Print</button> 
			        <button data-toggle='dropdown' class='btn dropdown-toggle btn-info btn-round btn-sm'>
			            <span class='ace-icon fa fa-caret-down icon-only'></span>
			        </button>
			        <ul class='dropdown-menu pull-right'>
			            <li>
			                <a onclick="AutoConsolidateCategory();">Export</a>
			            </li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row form-group" style="margin-top: -10px;">
			<div class="col-md-12">
				<div style="height: 70vh;">
					<table class="table table-bordered table-hover fixTable" style="width: 1200px;">
						<thead>
							<tr>
								<th style="width: 10%;">Icon <span class="btnsortdash-maincat fa fa-sort bigger-130 pull-right" id="icon"> </th>
								<th style="width: 20%;">Code <span class="btnsortdash-maincat fa fa-sort bigger-130 pull-right" id="category_id"> </th>
								<th style="width: 35%;">Description <span class="btnsortdash-maincat fa fa-sort bigger-130 pull-right" id="category"> </th>
								<th style="width: 20%;">Maintenance Type <span class="btnsortdash-maincat fa fa-sort bigger-130 pull-right" id="Maintenance_Type"> </th>
								<th style="width: 15%;">Meter Reading <span class="btnsortdash-maincat fa fa-sort bigger-130 pull-right" id=""> </th>
							</tr>
						</thead>
						<tbody id="tblmaintenance_category"></tbody>
					</table>
				</div>
				<table class="tabledash_footer table" style="margin: 0px !important;">
					<thead>
					  	<tr>
							<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
								<font id="txtEntriesMainCat" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
								<input id="txtPageMainCat" type="hidden">
							  	<ul id="ulPageMainCat" class="pagination pull-right"></ul>
							</th>
					  	</tr>
					</thead>
			  	</table>
			</div>
		</div>
	</div>
</div>

<div class="col-md-3 refMainCategory divReferential hide">
	<div class="search-area well well-sm">
        <div class="search-filter-header bg-primary">
            <h5 class="smaller no-margin-bottom">
                <i class="ace-icon fa fa-cog light-green bigger-130"></i>&nbsp; Option
            </h5>
        </div>
        <div class="space-4"></div>
        <div class="row-form-group">
			<form method="post" name="posting_reficon" id="posting_reficon">
				<div class="form-group IconDiv" style="display: none;">
					<div class="col-md-12 col-lg-12 center">
						<input type="hidden" id="pinaghuhugutan" name="pinaghuhugutan">
						<label class="myupload">
	                        <img class="img-responsive" id="imahengmetro" style="display: none;height: 100px;width: 100px;" src="" accept="image/*">
	                        <input type="file" name="txtCatIcon" id="txtCatIcon" class="" onchange="showpic();">
	                        <span class="fa fa-cloud-upload" style="font-size: 60px; color: rgb(153, 153, 153); display: block;text-align: center;" id="logongupload"></span>
	                    	<h6 id="textngupload">Click here to upload picture</h6>
	                    </label>
	            		<div class="btn btn-light btn-sm btn-round" id="btnremovephoto" onclick="removephoto();" style="width: auto; display: none;margin: 10px;"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Remove Photo</div>
					</div>
				</div>
			</form>
		</div>
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12"> Code:</label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control txtMainCat ThisIsForCodes" id="MainCatCode" readonly>
			</div>
		</div>
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12">Description:</label>
			<div class="col-md-12 col-xs-12">
				<input type="text" class="form-control txtMainCat" id="MainCatDesc" readonly>
			</div>
		</div>
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12"> Meter Reading:</label>
			<div class="col-md-12 col-xs-12">
				<select class="form-control txtMainCat2 txtMainCat searchy_select" id="MainCatisReading" disabled>
					<option value=''>-- Select Type --</option>
					<option value='1'>Electric</option>
                    <option value='2'>Water</option>
                    <option value='3'>Gas</option>
				</select>
			</div>
		</div>
		<div class="row form-group">
			<label class="control-label col-md-12 col-xs-12"> Maintenance Type:</label>
			<div class="col-md-12 col-xs-12">
				<select class="form-control txtMainCat2 txtMainCat searchy_select" id="MainCatType" disabled>
					<option value=''>-- Select Type --</option>
					<option value='Preventive'>Preventive</option>
                    <option value='Corrective'>Corrective</option>
                    <option value='Periodic'>Periodic</option>
				</select>
			</div>
		</div>
		<div class="row form-group hide">
			<label class="control-label col-md-12 col-xs-12">Fixed Payment?</label>
			<div class="col-md-4 col-xs-6">
				<div class="radio">
					<label>
						<input name="radFixedPayment" type="radio" class="ace radFixedPayment" id="FixedPaymentYes" disabled>
						<span class="lbl">&nbsp;Yes</span>
					</label>
				</div>
			</div>
			<div class="col-md-4 col-xs-6">
				<div class="radio">
					<label>
						<input name="radFixedPayment" type="radio" class="ace radFixedPayment" id="FixedPaymentNo" disabled>
						<span class="lbl">&nbsp;No</span>
					</label>
				</div>
			</div>
			<div class="col-md-4 col-xs-12">
				<input type="text" class="form-control numonly amount" id="txtFixedPayment" readonly style="display: none;text-align: right;">
			</div>
		</div>
		<div class="row form-group hide">
			<label class="control-label col-md-12 col-xs-12">Can add task?</label>
			<div class="col-md-4 col-xs-6">
				<div class="radio">
					<label>
						<input name="radAddTask" type="radio" class="ace radAddtask" id="AddTaskYes" disabled>
						<span class="lbl">&nbsp;Yes</span>
					</label>
				</div>
			</div>
			<div class="col-md-4 col-xs-6">
				<div class="radio">
					<label>
						<input name="radAddTask" type="radio" class="ace radAddtask" id="AddTaskNo" disabled>
						<span class="lbl">&nbsp;No</span>
					</label>
				</div>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-12">
				<div class="btn-group pull-right" id="buttonsMainCat">
					<button class="btn btn-primary btn-round btn-sm hide isadmin select-addreferentials" onclick="clickAddMainCat()"><span class="fa fa-plus"></span> Add</button>
					<button class="btn btn-success btn-round btn-sm hide isadmin select-editreferentials" onclick="clickUpdateMainCat()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
					<button class="btn btn-danger btn-round btn-sm  hide isadmin select-deletereferentials" onclick="clickDeleteMainCat()"><span class="glyphicon glyphicon-trash"></span> Delete</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="savingbuttonsMainCat">
					<button class="btn btn-primary btn-round btn-sm" onclick="saveMainCat()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonMainCat()"><span class="fa fa-remove"></span> Cancel</button>
				</div>

				<div class="btn-group pull-right" style="display: none;" id="updatebuttonsMainCat">
					<button class="btn btn-primary btn-round btn-sm" onclick="updateMainCat()"><span class="fa fa-check"></span> Save</button>
					<button class="btn btn-danger btn-round btn-sm" onclick="cancelbuttonMainCat()"><span class="fa fa-remove"></span> Cancel</button>
				</div>
			</div>
		</div>	
    </div>
</div>

<input type="hidden" id="HiddenMainCatID">
<input type="hidden" id="MainCatSortType" value="ASC">
<input type="hidden" id="MainCatSortBy" value="category_id">
<?php include("script.php"); ?>