<div class="row search-page" id="search-page-1">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row form-group" style="background-color: #edf4f8;padding-top: 10px;padding-bottom: 10px;margin-bottom: 5px;">
                            <div class="col-md-1" style="padding-top: 3px;">
                                <h3 style="color:#2679B5;margin-top: 10px;display: inline;">&nbsp;<i style="display: inline;" class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;Filter</h3>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control input-sm" id="txtmall" onchange="loadwing(this.value);loadmall();">
                                    <option value="">Choose Mall Branch</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control input-sm" id="txtwing" onchange="loadfloor(this.value);loadmall();" onclick="chkthis_wing()">
                                    <option value="">Choose Wing</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control input-sm" id="txtfloor" onchange="loadmall();" onclick="chkthis_flr()">
                                    <option value="">Choose Floor</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control input-sm" placeholder="Enter Unit Name" id="srchunittxt">
                            </div>
                            <div class="col-md-1" style="padding-right: 0px;">
                                <h6 style="color:#2679B5;margin-top: 5px;float: right;">Contract Date&nbsp;:</h6>
                            </div>                            
                            <div class="col-md-2">
                                <input type="text" name="date-range-picker" class="form-control input-sm" id="srchunittxt_date">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-3">
                                <div class="row form-group">
                                    <div id="table_unit_set_list"></div>
                                    <div class="col-xs-12" style="overflow-y: scroll;display: block;height: 35em;background-color: #edf4f8;padding-top: 20px;">
                                        <ul class="tree tree-unselectable tree-folder-select" id="unitlist"></ul>
                                    </div>
                                </div>
                            </div>
                        <div class="col-xs-9" style="display: block;height: 30em;padding-left: 20px;padding-top: 20px;">
                                <div class="row form-group">
                                    <div class="col-xs-2">   
                                        Unit Name
                                    </div>  
                                    <div class="col-xs-3">   
                                        <input type="text" class="form-control input-sm" name="" id="txtunit_histunitname" readonly>
                                    </div> 
                                    <div class="col-xs-1"></div> 
                                    <div class="col-xs-6">   
                                        <h3 style="margin-top: 0px;margin-bottom: 0px;">Merchandise Information</h3>
                                    </div>                   
                                </div>
                                <div class="row form-group">
                                    <div class="col-xs-2">   
                                        <label class="txtSysBuilding"></label> Name
                                    </div>  
                                    <div class="col-xs-3">   
                                        <input type="text" class="form-control input-sm" name="" id="txtunit_histmallname" readonly>
                                    </div> 
                                    <div class="col-xs-1"></div>  
                                    <div class="col-xs-3">   
                                        Classification
                                    </div>  
                                    <div class="col-xs-3">   
                                        <input type="text" class="form-control input-sm" name="" id="txtunit_histclass" readonly>
                                    </div>                    
                                </div>
                                <div class="row form-group">
                                    <div class="col-xs-2">   
                                        Wing Name
                                    </div>  
                                    <div class="col-xs-3">   
                                        <input type="text" class="form-control input-sm" name="" id="txtunit_histwingname" readonly>
                                    </div>  
                                    <div class="col-xs-1"></div> 
                                    <div class="col-xs-3">   
                                        Department
                                    </div>  
                                    <div class="col-xs-3">   
                                        <input type="text" class="form-control input-sm" name="" id="txtunit_histdepartment" readonly>
                                    </div>                    
                                </div>
                                <div class="row form-group">
                                    <div class="col-xs-2">   
                                        Floor Name
                                    </div>  
                                    <div class="col-xs-3">   
                                        <input type="text" class="form-control input-sm" name="" id="txtunit_histflrname" readonly>
                                    </div>  
                                    <div class="col-xs-1"></div> 
                                    <div class="col-xs-3">   
                                        Category
                                    </div>  
                                    <div class="col-xs-3">   
                                        <input type="text" class="form-control input-sm" name="" id="txtunit_histcategory" readonly>
                                    </div>                    
                                </div>
                                <div class="row form-group">
                                        <div class="clearfix divstat pull-right" style="font-size: 14px;padding-bottom: 5px;">
                                            <span>Legends :</span>&nbsp;&nbsp;
                                            <span style="font-weight: 700;"><span class="fa fa-flag" style="font-weight: 700; color: #DFE21A;"></span>    Active</span>&nbsp;|&nbsp;&nbsp;
                                            <span><span class="fa fa-flag" style="font-weight: 700; color: DarkGray;"></span> In-active</span>&nbsp;|&nbsp;&nbsp;
                                            <span><span class="fa fa-flag" style="font-weight: 700; color: #428BCA;"></span> For Renewal</span>&nbsp;&nbsp;|&nbsp;&nbsp;
                                            <span><span class="fa fa-flag" style="font-weight: 700; color: red;"></span> For Eviction</span>&nbsp;&nbsp;|&nbsp;&nbsp;
                                            <span><span class="fa fa-flag" style="font-weight: 700; color: grey;"></span> Evicted</span>
                                            <input type="hidden" id="txtstatus" value="Active">
                                            <input type="hidden" id="txtcompid">
                                        </div>
                                    <table id="simple-table" class="table  table-bordered table-hover" style="display: flex;flex-flow: column;height: 100%;width: 100%;margin-bottom: 0px !important;">
                                        <thead class="table-thead" style="flex: 0 0 auto;width: calc(100%);">
                                            <tr style="display: table;table-layout: fixed;width: 100%;display: table;">
                                                <th width='5%'></th> 
                                                <th>Tenant ID</th>
                                                <th class="thSysTenant">Store Name</th>
                                                <th>Company Name</th>
                                                <th class="hide_mobile">Contract Start Date</th>
                                                <th class="hide_mobile">Contract End Date</th>
                                            </tr>
                                        </thead>
                                        <div id="div_set_history_tbl"></div>
                                        <tbody id="tbltenantinfolisthist" style="flex: 1 1 auto;display: block;height: 15em;overflow: hidden;"></tbody>
                                    </table>                              
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="vspace-6-sm"></div>
                </div>
                <div class="space"></div>
            </div>
        </div>                
    </div>
</div>
