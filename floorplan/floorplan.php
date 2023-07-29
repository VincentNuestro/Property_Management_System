<style>
	.myupload{
		border: dashed 1px #999;
		padding: 15px;
		display: block;
		margin: 15px;
	}
	
	.myupload h1{
		font-size: 30px;
		font-weight: 400 !important;
		color: #999;
		text-align: center;
		margin-top: 10px;
		margin-bottom: 20px;
	}
	
	.myupload input[type="file"]{ 
		opacity: 0; 
	}
	
	.malltxt{
		font-size: 26px;
		margin: 10px;
		font-weight: 800;
		padding: 5px;
		border-bottom: solid 1px #dddddd;
		color: #333;
	}
	
	.wingtxt{
		font-size: 16px;
		font-weight: 300;
		margin: 10px;
		padding: 5px;
		color: #666;
	}
</style>
<div class="page-header">
    <div class="row form-group" style="margin-bottom: 0px;padding-top:10px;background-color: #edf4f8;padding-bottom: 10px;">
        <div class="col-md-6">
            <h1 style="font-weight: bold;">FLOOR PLAN</h1>
        </div>
        <div class="col-md-6"></div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
    	<div class="row form-group" style="margin-bottom: 0px;">
    		<div class="col-xs-2 pull-right" style="padding-bottom: 5px;padding-left: 0px;">
            	<button class="btn btn-info hide isadmin select-setuploadfloorplan btn-sm btn-block btn-round" onClick="addfloorplan();"><span class="glyphicon glyphicon-upload"></span>&nbsp;&nbsp;Upload New Floor Plan</button>
    		</div>
    	</div>
    	<div class="row form-group" style="margin-bottom: 0px;">
    		<div class="col-xs-12">
    			<div class="row search-page">
			    	<div class="col-xs-12">
			            <div class="row">
			                <div class="col-xs-12 col-sm-3" style="padding-bottom: 5px;padding-left: 0px;">
			                    <div class="search-area well well-sm">
			                        <div class="search-filter-header bg-primary">
			                            <h5 class="smaller no-margin-bottom">
			                                <i class="ace-icon fa fa-sliders light-green bigger-130"></i>&nbsp; Refine your Search
			                            </h5>
			                        </div>
			                        <div class="space-10"></div>
			                        <div>
			                        	<p style="margin-bottom: 4px; margin-left: 2px;">Choose <label class="txtSysBuilding"></label></p>
			                            <select class="form-control" id="txtmall" onchange="loadwing(this.value);"></select>
			                            <div class="space-10"></div>
			                        	<p style="margin-bottom: 4px; margin-left: 2px;">Choose Building/Wing</p>
			                            <select class="form-control" id="txtwing">
			                            	<option value="">Choose Wing</option>
			                            </select>
			                            <div class="space-10"></div>
			                            <button class="btn btn-success btn-sm btn-block btn-round" onclick="loadfloorplanview();"><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;Submit Search</button>
			                        </div>
								</div>
							</div>
			                <div class="col-xs-12 col-sm-9" style="padding-bottom: 5px;padding-left: 0px;">
			                	<div class="well well-sm">
			                    	<div class="row">
			                        	<div class="col-sm-8 col-xs-7">
			                    			<h4 class="blue" style="margin: 5px;">Floor Plan List&nbsp;&nbsp;<small style="font-size: 13px;"><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;Search Floor Plan</small></h4>
			                            </div>
			                        	<div class="col-sm-4 col-xs-5">
			                            	<div class="input-group">
			                                	<span class="input-group-addon">Change View</span>
			                                	<select class="form-control" id="changeview" onchange="selectview(this.value);"><option value="thumb">Thumbnail</option><option value="list">List</option></select>
			                                </div>
			                            </div>
			                        </div>
			                    </div>
			                    <div class="parent">
			                    	<div class="myspinner" style="display: none;"></div>
			                        <ul class="ace-thumbnails clearfix" id="floorlist"></ul>
		                        	<table class="table table-bordered table-striped fixTable" id="div_floorlist2" style="display: none;">
		                        		<thead>
		                        			<tr>
		                        				<th style="width: 25%;">Mall<span class="btnsortdash-floorplan fa fa-sort bigger-130 pull-right" id="mallname"></span></th>
												<th style="width: 25%;">Wing<span class="btnsortdash-floorplan fa fa-sort bigger-130 pull-right" id="wing"></span></th>
												<th style="width: 25%;">Floor<span class="btnsortdash-floorplan fa fa-sort bigger-130 pull-right" id="FLOOR"></span></th>
												<th style="width: 25%;z-index: 1;">Action</th>
		                        			</tr>
		                        		</thead>
		                        		<tbody id="floorlist2"></tbody>
		                        	</table>
			                    </div>
							</div>
						</div>
					</div>
				</div>
    		</div>
    	</div>
	</div>
</div>

<div class="modal fade fade-scale" role="dialog" id="addfloorplan">
	<div class="modal-dialog modal-lg">
    	<div class="modal-content">
        	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal">&times;</button>
            	<h4 class="modal-title" style="font-size: 18px;">Add Floor Plan</h4>
			</div>
            <div class="modal-body">
            	<form id="uploadimage" method="post" enctype="multipart/form-data">
                	<input type="hidden" name="txttype" value="set">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="search-area well well-sm">
                                <div class="search-filter-header bg-primary">
                                    <h5 class="smaller no-margin-bottom">
                                        <i class="ace-icon fa fa-asterisk light-green bigger-130"></i>&nbsp; Unit Information
                                    </h5>
                                </div>
                                <div class="space-10"></div>
                                <div>
                                    <p style="margin-bottom: 4px; margin-left: 2px;">Choose Mall</p>
                                    <select class="form-control" id="txtmall2" name="txtmall2" onchange="loadwing2(this.value);"></select>
                                    <div class="space-10"></div>
                                    <p style="margin-bottom: 4px; margin-left: 2px;">Choose Building/Wing</p>
                                    <select class="form-control" id="txtwing2" name="txtwing2" onchange="loadfloor2(this.value);">
                                        <option value="">Choose Wing</option>
                                    </select>
                                    <div class="space-10"></div>
                                    <p style="margin-bottom: 4px; margin-left: 2px;">Choose Floor</p>
                                    <select class="form-control" id="txtfloor2" name="txtfloor2" onChange="checkphoto(this.value);" required>
                                        <option value="">Choose Floor</option>
                                    </select>
                                    <br>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <center>
	                            <input type="hidden" id="imgwidth" name="imgwidth">
	                            <input type="hidden" id="imgheight" name="imgheight">
	                            <label class="myupload">
	                                <img class="img-responsive" src="#" id="fpimg" style="display: none;">
	                                <input type="file" name="txtfile" id="txtimgfile" onChange="showimg();" required="required" accept="image/*">
	                                <span class="fa fa-cloud-upload" style="font-size: 80px; color: #999;" id="txtfpspan"></span>
	                                <h1 id="txtfpclick">Click here to upload picture</h1>
	                            </label>
	                            <button class="btn btn-success btn-sm btn-round"><span class="glyphicon glyphicon-upload"></span>&nbsp;&nbsp;Upload</button>
	                            <button class="btn btn-light btn-sm btn-round" onclick="removephoto();"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Remove Photo</button>
                            </center>
                        </div>
                    </div>
                </form>
			</div>
        </div>
	</div>
</div>
<input type="hidden" id="FloorplanSortType" value="ASC">
<input type="hidden" id="FloorplanSortBy" value="floorid">
<?php include("floorplanscript.php"); ?>