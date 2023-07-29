<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="row form-group" style="margin-bottom: 0px;">
            <div class="col-md-2" style="padding-bottom: 5px;padding-left:0px;">
                <span class="input-icon" style="width: 100%;">
                    <input type="text" class="form-control" placeholder="Search" title="Search" id="txtSearchAsset">
                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                </span>
            </div>
            <div class="col-md-3" style="padding-bottom: 5px;padding-left:0px;">
                <h5><a onclick="loadMaintenanceFilter('Maintenance')" id="LINK_Maintenance_filter" class="popover-info" data-rel="popover" data-placement="bottom" title="Filter by" data-content='
                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:95px;">&nbsp;&nbsp;Search by&nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-4">
                                <label>
                                    <input name="form-field-checkboxxxxxxx" class="ace ace-checkbox-2 maintenance_module_filter" type="checkbox" value="workorderid" id="filter_workorderid">
                                    <span class="lbl"> Task ID</span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label>
                                    <input name="form-field-checkboxxxxxxx" class="ace ace-checkbox-2 maintenance_module_filter" type="checkbox" value="workername" id="filter_workername">
                                    <span class="lbl"> Personnel</span>
                                </label>                            
                            </div>
                            <div class="col-md-4">
                                <label>
                                    <input name="form-field-checkboxxxxxxx" class="ace ace-checkbox-2 maintenance2_module_filter" type="checkbox" value="tradename" id="filter_tradename">
                                    <span class="lbl"> Trade Name</span>
                                </label>                            
                            </div>
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:100px;">&nbsp;&nbsp;Filter Status&nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-2"></div>
                            <div class="col-md-4">
                                <label class="label label-lg label-success arrowed-in-right arrowed">
                                    <input name="form-field-checkboxstatussssss" class="ace filter_Resolved" type="checkbox" value="Resolved" id="filter_Resolved">
                                    <span class="lbl"> Resolved</span>
                                </label>  
                            </div>
                            <div class="col-md-4">
                                <label class="label label-lg label-warning arrowed-in-right arrowed">
                                    <input name="form-field-checkboxstatussssss" class="ace filter_Pending" type="checkbox" value="Pending" id="filter_Pending">
                                    <span class="lbl"> Pending</span>
                                </label>  
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_chkappdate">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:90px;">&nbsp;&nbsp;Date Entry&nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                      <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <input class="form-control date-picker" type="text" name="" id="dateentrystart" data-provide="datepicker">
                                </div>                
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <input class="form-control date-picker" type="text" name="" id="dateentryend" data-provide="datepicker">
                                </div>                
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </fieldset>

                    <div class="form-group row" style="padding-left:8px;margin-bottom:0px;">
                        <div class="col-md-9" style="padding-right:0px;">
                            <div class="alert alert-info" style="padding-top:10px;padding-bottom:10px;">
                                <button class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
                                Click "<b>OK</b>" to filter data and permanently save the filter selected.
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-xs btn-info btn-round" onclick="saveMaintenancefilter()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">OK</button>
                        </div>
                    </div>'>
                    <i class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;Select Filter here</a>
                </h5>
            </div>
            <div class="col-md-2 pull-right" style="padding-bottom: 5px;padding-right: 0px;">
                <button class="btn btn-info btn-sm pull-right btn-block btn-round" onclick="fncNewAsset();">New Asset</button>
            </div>
        </div>
        <div class="row form-group" style="margin-bottom: 0px !important;">
            <div class="parent">
                <table class="table table-bordered fixTable">
                    <thead>
                        <tr>
                            <th style="width: 10%;"></th>
                            <th style="width: 15%;">Asset Ctrl No.</th>
                            <th style="width: 35%;">Asset Name</th>
                            <th style="width: 10%;">Ownership</th>
                            <th style="width: 10%;">Acquisition Date</th>
                            <th style="z-index: 1;width: 10%;">Status</th>
                            <th style="z-index: 1;width: 10%;">Options</th>
                        </tr>
                    </thead>
                    <tbody id="tblAssetList"></tbody>
                </table>
            </div>
            <table class="tabledash_footer table" style="margin: 0px !important;">
                <thead>
                    <tr>
                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                            <font id="txtAssetEntries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                            <input id="txtAssetPage" type="hidden">
                            <ul id="txtAssetPagination" class="pagination pull-right"></ul>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdlNewAsset" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;" id="hdrNewAsset">New Asset</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;margin-bottom: 20px;">
                            <legend class="green" style="border: none;font-size: 16px;width: 150px;">&nbsp;&nbsp;Asset Information&nbsp;&nbsp;</legend>
                            <form method="post" name="frmAssetImage" id="frmAssetImage">
                            <div class="row form-group">
                                <div class="col-md-5">
                                    <div class="row form-group">
                                        <label class="col-md-5">Asset Control No.</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control txtAssetRequired" maxlength="20" id="txtAssetControlNo" name="txtAssetControlNo">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="row form-group">
                                        <label class="col-md-5">Asset Name</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control txtAssetRequired" id="txtAssetName">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <div class="row form-group">
                                        <label class="col-md-5">Category</label>
                                        <div class="col-md-7">
                                            <select class="form-control txtAssetRequired" id="txtAssetCategory">
                                                <option value="">-- Select Category --</option>
                                                <option value="DINING UTENSILS">DINING UTENSILS</option>
                                                <option value="KITCHEN APPLIANCE">KITCHEN APPLIANCE</option>
                                                <option value="DECOR">DÉCOR</option>
                                                <option value="KITCHEN DECOR">KITCHEN UTENSILS</option>
                                                <option value="WALL DECOR">WALL DÉCOR</option>
                                                <option value="FURNITURE">FURNITURE</option>
                                                <option value="ELECTRONICS">ELECTRONICS</option>
                                                <option value="CHAIR">CHAIR</option>
                                                <option value="SPORTS FACILITIES">SPORTS FACILITIES</option>
                                                <option value="CLEANING MATERIALS">CLEANING MATERIALS</option>
                                                <option value="DISPLAY">DISPLAY</option>
                                                <option value="BOX">BOX</option>
                                                <option value="APPLIANCES">APPLIANCES</option>
                                                <option value="SOUND SYSTEM">SOUND SYSTEM</option>
                                                <option value="CCTV CAMERA">CCTV CAMERA</option>
                                                <option value="OTHERS">OTHERS</option>
                                                <option value="OFFICE SUPPLIES">OFFICE SUPPLIES</option>
                                                <option value="CABLE WIRE">CABLE WIRE</option>
                                                <option value="WHITE SCREEN">WHITE SCREEN</option>
                                                <option value="REMOTE">REMOTE</option>
                                                <option value="KITCHEN EQUIPMENT">KITCHEN EQUIPMENT</option>
                                                <option value="TELEPHONE">TELEPHONE</option>
                                                <option value="POWER SUPPLY">POWER SUPPLY</option>
                                                <option value="EXHAUST FAN">EXHAUST FAN</option>
                                                <option value="FIXTURES">FIXTURES</option>
                                                <option value="ELECTRIC">ELECTRIC</option>
                                                <option value="TOOLS">TOOLS</option>
                                                <option value="EQUIPMENT">EQUIPMENT</option>
                                                <option value="METAL">METAL</option>
                                                <option value="STRUCTURES">STRUCTURES</option>
                                                <option value="SPORTS FACILITIES EQUIPMENT">SPORTS FACILITIES EQUIPMENT</option>
                                                <option value="ACCESSORIES">ACCESSORIES</option>
                                                <option value="CAR AND MOBILE">CAR AND MOBILE</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-md-5">Item Class</label>
                                        <div class="col-md-7">
                                            <select class="form-control txtAssetRequired" id="txtAssetClass">
                                                <option value="">-- Select Class --</option>
                                                <option value="ACCESSORIES">ACCESSORIES</option>
                                                <option value="APPLIANCES">APPLIANCES</option>
                                                <option value="BOX">BOX</option>
                                                <option value="CABLE WIRE">CABLE WIRE</option>
                                                <option value="CAR AND MOBILE">CAR AND MOBILE</option>
                                                <option value="CCTV CAMERA">CCTV CAMERA</option>
                                                <option value="CHAIR">CHAIR</option>
                                                <option value="CLEANING MATERIALS">CLEANING MATERIALS</option>
                                                <option value="DECOR">DECOR</option>
                                                <option value="DINING UTENSILS">DINING UTENSILS</option>
                                                <option value="DISPLAY">DISPLAY</option>
                                                <option value="ELECTRIC">ELECTRIC</option>
                                                <option value="ELECTRONICS">ELECTRONICS</option>
                                                <option value="EQUIPMENT">EQUIPMENT</option>
                                                <option value="EXHAUST FAN">EXHAUST FAN</option>
                                                <option value="FIXTURES">FIXTURES</option>
                                                <option value="FURNITURE">FURNITURE</option>
                                                <option value="KITCHEN APPLIANCE">KITCHEN APPLIANCE</option>
                                                <option value="KITCHEN EQUIPMENT">KITCHEN EQUIPMENT</option>
                                                <option value="KITCHEN UTENSILS">KITCHEN UTENSILS</option>
                                                <option value="METAL">METAL</option>
                                                <option value="OFFICE SUPPLIES">OFFICE SUPPLIES</option>
                                                <option value="OTHERS">OTHERS</option>
                                                <option value="PLATE">PLATE</option>
                                                <option value="POWER SUPPLY">POWER SUPPLY</option>
                                                <option value="REMOTE">REMOTE</option>
                                                <option value="SERVING PLATE">SERVING PLATE</option>
                                                <option value="SOUND SYSTEM">SOUND SYSTEM</option>
                                                <option value="SPORTS FACILITIES">SPORTS FACILITIES</option>
                                                <option value="SPORTS FACILITIES EQUIPMENT">SPORTS FACILITIES EQUIPMENT</option>
                                                <option value="STRUCTURES">STRUCTURES</option>
                                                <option value="TELEPHONE">TELEPHONE </option>
                                                <option value="TOOLS">TOOLS</option>
                                                <option value="WALL DECOR">WALL DECOR</option>
                                                <option value="WHITE SCREEN">WHITE SCREEN</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-md-5">Brand</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control txtAssetRequired" id="txtAssetBrand">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-md-5">Color</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control txtAssetRequired" id="txtAssetColor">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-md-5">Dimension</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control txtAssetRequired" id="txtAssetDimension">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-md-5">Serial No.</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control txtAssetRequired" id="txtAssetSerial">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-md-5">Barcode No.</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control txtAssetRequired" id="txtAssetBarcode">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-md-5">Supplier</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control txtAssetRequired" id="txtAssetSupplier">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-md-5">Parent Unit</label>
                                        <div class="col-md-7">
                                            <select class="form-control txtAssetRequired" id="txtAssetParentUnit">
                                                <option value="">-- Select Parent Unit --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="col-md-6">
                                        <div class="row form-group">
                                            <label class="col-md-5">Department</label>
                                            <div class="col-md-7">
                                                <select class="form-control txtAssetRequired" id="txtAssetDepartment">
                                                    <option value="">-- Select Department --</option>
                                                    <option value="FOODBEVERAGES">FOOD & BEVERAGES</option>
                                                    <option value="FRONT OFFICE">FRONT OFFICE</option>
                                                    <option value="ACCOUNTING">ACCOUNTING</option>
                                                    <option value="MANAGER OFFICE">MANAGER OFFICE</option>
                                                    <option value="HOUSEKEEPING">HOUSEKEEPING</option>
                                                    <option value="SPA">SPA</option>
                                                    <option value="MAINTENANCE">MAINTENANCE</option>
                                                    <option value="STOCKROOM">STOCKROOM</option>
                                                    <option value="KITCHEN">KITCHEN</option>
                                                    <option value="MAINTENANCE">MAINTENANCE</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <label class="col-md-5">Asset Holder</label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control txtAssetRequired" id="txtAssetHolder">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <label class="col-md-5">Ownership</label>
                                            <div class="col-md-7">
                                                <select class="form-control txtAssetRequired" id="txtAssetOwnership">
                                                    <option value="">-- Select Ownership --</option>
                                                    <option value="Owned">Owned</option>
                                                    <option value="Rent">Rent</option>
                                                    <option value="Borrowed">Borrowed</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <label class="col-md-5">Location</label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control txtAssetRequired" id="txtAssetLocation">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <label class="col-md-5">Quantity</label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control txtAssetRequired NumberOnly" id="txtAssetQuantity">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <label class="col-md-5">Unit</label>
                                            <div class="col-md-7">
                                                <select class="form-control txtAssetRequired" id="txtAssetUnit">
                                                    <option value="">-- Select Unit --</option>
                                                    <option value="SET">SET</option>
                                                    <option value="UNIT">UNIT</option>
                                                    <option value="PCS">PCS</option>
                                                    <option value="PACK">PACK</option>
                                                    <option value="CAN">CAN</option>
                                                    <option value="JAR">JAR</option>
                                                    <option value="KG">KG</option>
                                                    <option value="TRAY">TRAY</option>
                                                    <option value="BAR">BAR</option>
                                                    <option value="ROLL">ROLL</option>
                                                    <option value="PAIL">PAIL</option>
                                                    <option value="TIN">TIN</option>
                                                    <option value="PAD">PAD</option>
                                                    <option value="REAM">REAM</option>
                                                    <option value="TANK">TANK</option>
                                                    <option value="LITERS">LITERS</option>
                                                    <option value="BAG">BAG</option>
                                                </select>
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <center>
                                                    <label class="myupload">
                                                        <img class="img-responsive" src="#" id="txtAssetImage" style="display: none;height: 24.8vh;width: 100%;">
                                                        <input type="file" name="txtAssetFile" id="txtAssetFile" onChange="showimgggggg();" class="disableifheader" accept="image/*">
                                                        <span class="fa fa-cloud-upload" style="font-size: 60px; color: #999;" id="txtAssetSpan"></span>
                                                        <h1 id="txtAssetClick">Click here to upload picture</h1>
                                                    </label>
                                                    <div class="btn btn-light btn-round" id="btnRemoveAssetAvatar" onclick="removeuserphoto();" style="width: auto; display: none;"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Remove Photo</div>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                    <div class="col-md-12">
                                        <div class="row form-group">
                                            <div class="col-md-6">
                                                <div class="row form-group">
                                                    <label class="col-md-5">Acquisition Date</label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control txtAssetRequired date-picker" id="txtAssetAcquisitionDate">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <label class="col-md-5">Life in Years</label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control txtAssetRequired NumberOnly" id="txtAssetLifeInYears">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <label class="col-md-5">Depreciated Cost</label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control txtAssetRequired AmountConvertion NumberOnly" id="txtAssetDepreciatedCost" style="text-align: right;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row form-group">
                                                    <label class="col-md-5">Acquisition Amount</label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control txtAssetRequired AmountConvertion NumberOnly" id="txtAssetAcquisitionAmount" style="text-align: right;">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <label class="col-md-5">Status</label>
                                                    <div class="col-md-7">
                                                        <select class="form-control txtAssetRequired" id="txtAssetStatus">
                                                            <option value="">-- Select Status --</option>
                                                            <option value="Operational">Operational</option>
                                                            <option value="Non-Operational">Non-Operational</option>
                                                            <option value="Condemned">Condemned</option>
                                                            <option value="Disposed">Disposed</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <label class="col-md-5">Salvage Amount</label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control txtAssetRequired AmountConvertion NumberOnly" id="txtAssetSalvageAmount" style="text-align: right;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>             
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-round btn-sm" onclick="fncSaveAsset();"><i class="fa fa-check"></i> Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" role="dialog" id="mdlAssetInfo" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="width:85% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;" id="mdlAssetHeader">Asset Information</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="tabbable tabs-left">
                            <ul class="nav nav-tabs" id="myTab">
                                <li class="active thistab">
                                    <a data-toggle="tab" href="#TabAssetInfo" onclick="fncAssetInfo(); fncChangeAssetHeader('Asset Information');">
                                        <i class="green ace-icon fa fa-user bigger-120"></i>
                                        Asset Information
                                    </a>
                                </li>

                                <li>
                                    <a data-toggle="tab" href="#TabAssetComponent" onclick="fncAssetComponents();  fncChangeAssetHeader('Asset Components');">
                                        <i class="green ace-icon fa fa-puzzle-piece bigger-120"></i>
                                        Components
                                    </a>
                                </li>

                                <li>
                                    <a data-toggle="tab" href="#TabAssetMaintenance" onclick="fncAssetMaintenance(); fncChangeAssetHeader('Asset Maintenance');">
                                        <i class="green ace-icon fa fa-wrench bigger-120"></i>
                                        Maintenance
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content" style="display:block;min-height:300px;">
                                <div id="TabAssetInfo" class="tab-pane fade in active">
                                    <div class="row form-group">
                                        <div class="col-xs-12 col-sm-4">
                                            <div class="col-xs-12 col-sm-12">
                                                <span class="profile-picture">
                                                    <img class="editable img-responsive" id="imgAssetImage" style="height: 150px;width: 100%;">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-8">
                                            <div class="col-xs-12">
                                                <div class="profile-user-info">
                                                    <div class="profile-info-row">
                                                        <div class="profile-info-name" style="white-space: nowrap;"> Asset Control No. </div>

                                                        <div class="profile-info-value">
                                                            <span id="txtAssetInfoControlNo"></span>
                                                        </div>
                                                    </div>
                                                    <div class="profile-info-row">
                                                        <div class="profile-info-name" style="white-space: nowrap;"> Asset Name </div>

                                                        <div class="profile-info-value">
                                                            <span id="txtAssetInfoAssetName"></span>
                                                        </div>
                                                    </div>
                                                    <div class="profile-info-row">
                                                        <div class="profile-info-name" style="white-space: nowrap;"> Acquisition Date </div>

                                                        <div class="profile-info-value">
                                                            <span id="txtAssetInfoAcquisitionDate"></span>
                                                        </div>
                                                    </div>
                                                    <div class="profile-info-row">
                                                        <div class="profile-info-name" style="white-space: nowrap;"> Acquisition Amount </div>

                                                        <div class="profile-info-value">
                                                            <span id="txtAssetInfoAcquisitionAmount"></span>
                                                        </div>
                                                    </div>
                                                    <div class="profile-info-row">
                                                        <div class="profile-info-name" style="white-space: nowrap;"> Status </div>

                                                        <div class="profile-info-value">
                                                            <span id="txtAssetInfoStatus"></span>
                                                        </div>
                                                    </div>
                                                    <div class="profile-info-row">
                                                        <div class="profile-info-name"> &nbsp; </div>

                                                        <div class="profile-info-value">
                                                            <span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-xs-12 col-sm-4">
                                            <div class="profile-user-info">
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name" style="white-space: nowrap;"> Category </div>

                                                    <div class="profile-info-value">
                                                        <span id="txtAssetInfoCategory"></span>
                                                    </div>
                                                </div>
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name" style="white-space: nowrap;"> Item Class </div>

                                                    <div class="profile-info-value">
                                                        <span id="txtAssetInfoItemClass"></span>
                                                    </div>
                                                </div>
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name" style="white-space: nowrap;"> Brand </div>

                                                    <div class="profile-info-value">
                                                        <span id="txtAssetInfoBrand"></span>
                                                    </div>
                                                </div>
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name" style="white-space: nowrap;"> Color </div>

                                                    <div class="profile-info-value">
                                                        <span id="txtAssetInfoColor"></span>
                                                    </div>
                                                </div>
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name" style="white-space: nowrap;"> Dimension </div>

                                                    <div class="profile-info-value">
                                                        <span id="txtAssetInfoDimension"></span>
                                                    </div>
                                                </div>
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name" style="white-space: nowrap;"> Serial No. </div>

                                                    <div class="profile-info-value">
                                                        <span id="txtAssetInfoSerialNo"></span>
                                                    </div>
                                                </div>
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name" style="white-space: nowrap;"> Barcode No. </div>

                                                    <div class="profile-info-value">
                                                        <span id="txtAssetInfoBarcodeNo"></span>
                                                    </div>
                                                </div>
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name" style="white-space: nowrap;"> Supplier </div>

                                                    <div class="profile-info-value">
                                                        <span id="txtAssetInfoSupplier"></span>
                                                    </div>
                                                </div>
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name" style="white-space: nowrap;"> Parent Unit </div>

                                                    <div class="profile-info-value">
                                                        <span id="txtAssetInfoParentUnit"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-4">
                                            <div class="profile-user-info">
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name" style="white-space: nowrap;"> Department </div>

                                                    <div class="profile-info-value">
                                                        <span id="txtAssetInfoDepartment"></span>
                                                    </div>
                                                </div>
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name" style="white-space: nowrap;"> Asset Holder </div>

                                                    <div class="profile-info-value">
                                                        <span id="txtAssetInfoAssetHolder"></span>
                                                    </div>
                                                </div>
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name" style="white-space: nowrap;"> Ownership </div>

                                                    <div class="profile-info-value">
                                                        <span id="txtAssetInfoOwnership"></span>
                                                    </div>
                                                </div>
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name" style="white-space: nowrap;"> Location </div>

                                                    <div class="profile-info-value">
                                                        <span id="txtAssetInfoLocation"></span>
                                                    </div>
                                                </div>
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name" style="white-space: nowrap;"> Quantity </div>

                                                    <div class="profile-info-value">
                                                        <span id="txtAssetInfoQuantity"></span>
                                                    </div>
                                                </div>
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name" style="white-space: nowrap;"> Unit </div>

                                                    <div class="profile-info-value">
                                                        <span id="txtAssetInfoUnit"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-4">
                                            <div class="profile-user-info">
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name" style="white-space: nowrap;"> Life in Years </div>

                                                    <div class="profile-info-value">
                                                        <span id="txtAssetInfoLifeinYears"></span>
                                                    </div>
                                                </div>
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name" style="white-space: nowrap;"> Depreciated Cost </div>

                                                    <div class="profile-info-value">
                                                        <span id="txtAssetInfoDepreciatedCost"></span>
                                                    </div>
                                                </div>
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name" style="white-space: nowrap;"> Salvage Amount </div>

                                                    <div class="profile-info-value">
                                                        <span id="txtAssetInfoSalvageAmount"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="TabAssetComponent" class="tab-pane">
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <div class="parent">
                                                <table class="table table-bordered fixTable">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 15%;"></th>
                                                            <th style="width: 15%;">Asset Ctrl No.</th>
                                                            <th style="width: 35%;">Asset Name</th>
                                                            <th style="width: 10%;">Ownership</th>
                                                            <th style="width: 15%;">Acquisition Date</th>
                                                            <th style="z-index: 1;width: 10%;">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tblAssetComponentList"></tbody>
                                                </table>
                                            </div>
                                            <table class="tabledash_footer table" style="margin: 0px !important;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                                            <font id="txtAssetEntries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                                            <input id="txtAssetPage" type="hidden">
                                                            <ul id="txtAssetPagination" class="pagination pull-right"></ul>
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="TabAssetMaintenance" class="tab-pane">
                                    <div class="row form-group" style="margin-bottom: 0px;">
                                        <div class="col-md-3" style="padding-bottom: 5px;">
                                            <span class="input-icon" style="width: 100%;">
                                                <input type="text" class="form-control" placeholder="Search" title="Search" id="txtSearchMaintenance">
                                                <i class="ace-icon fa fa-search nav-search-icon"></i>
                                            </span>
                                        </div>
                                        <div class="col-md-2 pull-right" style="padding-bottom: 5px;">
                                            <button class="btn btn-info btn-sm pull-right btn-block btn-round" onclick="fncNewAssetMaintenance('', 'New');">New Maintenance</button>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <div class="parent">
                                                <table class="table table-bordered fixTable">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 15%;">Job Order No.</th>
                                                            <th style="width: 10%;">Date</th>
                                                            <th style="width: 30%;">Assigned Person</th>
                                                            <th style="width: 10%;">JO Status</th>
                                                            <th style="width: 15%;">Item Condition</th>
                                                            <th style="width: 15%;">Total Expenses</th>
                                                            <th style="width: 5%;z-index: 1;">Options</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tblAssetMaintenanceList"></tbody>
                                                </table>
                                            </div>
                                            <table class="tabledash_footer table" style="margin: 0px !important;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                                            <font id="txtAssetEntries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                                            <input id="txtAssetPage" type="hidden">
                                                            <ul id="txtAssetPagination" class="pagination pull-right"></ul>
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdlNewAssetMaintenance" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;" id="hdrAssetMaintenance">New Asset Maintenance</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;margin-bottom: 20px;">
                            <legend class="green" style="border: none;font-size: 16px;width: 255px;">&nbsp;&nbsp;Asset Maintenance Information&nbsp;&nbsp;</legend>
                            <div class="row form-group" style="margin-bottom: 0px;">
                                <div class="col-md-6">
                                    <div class="row form-group">
                                        <label class="col-md-5">Job Order No.</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control txtAssetRequiredExpense" maxlength="20" id="txtAssetMainJONo" name="txtAssetControlNo">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row form-group">
                                        <label class="col-md-5">Job Order Date</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control txtAssetRequiredExpense date-picker txtAssetMaintenance" id="txtAssetMainJODate">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group" style="margin-bottom: 0px;">
                                <div class="col-md-6">
                                    <div class="row form-group">
                                        <label class="col-md-5">Job Order Status</label>
                                        <div class="col-md-7">
                                            <select class="form-control txtAssetRequiredExpense btnAssetMaintenance" id="txtAssetMainJobOrderStatus">
                                                <option>-- Select Status --</option>
                                                <option value="Pending">Pending</option>
                                                <option value="Ongoing">Ongoing</option>
                                                <option value="Done">Done</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row form-group">
                                        <label class="col-md-5">Item Condition</label>
                                        <div class="col-md-7">
                                            <select class="form-control txtAssetRequiredExpense btnAssetMaintenance" id="txtAssetMainItemCondition">
                                                <option>-- Select Condition --</option>
                                                <option value="Repair">Repair</option>
                                                <option value="Change Parts">Change Parts</option>
                                                <option value="Disposed">Disposed</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group" style="margin-bottom: 0px;">
                                <div class="col-md-6">
                                    <div class="row form-group">
                                        <label class="col-md-5">Assigned Person</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control txtAssetRequiredExpense txtAssetMaintenance" id="txtAssetMainAssignedPerson">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group" style="margin-bottom: 0px;">
                                <div class="col-md-2 pull-right" style="padding-bottom: 5px;">
                                    <button class="btn btn-info btn-sm pull-right btn-block btnAssetMaintenance btn-round" onclick="fncAddExpense();">Add Expense</button>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <div class="parent2">
                                        <table class="table table-bordered fixTable">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10%;">Date</th>
                                                    <th style="width: 25%;white-space: nowrap;">Expense Type</th>
                                                    <th style="width: 10%;">Quantity</th>
                                                    <th style="width: 15%;white-space: nowrap;">Expense Amount</th>
                                                    <th style="width: 15%;">OR</th>
                                                    <th style="width: 25%;">Remarks</th>
                                                    <th style="width: 5%;">Options</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tblAssetMainPreExpenseList"></tbody>
                                        </table>
                                    </div>
                                    <table class="tabledash_footer table" style="margin: 0px !important;">
                                        <thead>
                                            <tr>
                                                <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                                    <font id="txtAssetEntries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                                    <input id="txtAssetPage" type="hidden">
                                                    <ul id="txtAssetPagination" class="pagination pull-right"></ul>
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </fieldset>             
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btnAssetMaintenance btn-round btn-sm" onclick="fncSaveAllExpense();"><i class="fa fa-check"></i> Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdlAddExpense" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Add Expense</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="HidExpenseCount">
                <div class="row form-group">
                    <label class="col-md-12">Date</label>
                    <div class="col-md-12">
                        <input type="text" class="date-picker form-control txtExpenseRequire" id="txtExpenseDate">
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-12">Expense Type</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control txtExpenseRequire" id="txtExpenseType">
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-12">Quantity</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control txtExpenseRequire NumberOnly" id="txtExpenseQuantity">
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-12">Expense Amount</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control txtExpenseRequire AmountConvertion NumberOnly" style="text-align: right;" id="txtExpenseAmount">
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-12">OR</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control txtExpenseRequire" id="txtExpenseOR">
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-12">Remarks</label>
                    <div class="col-md-12">
                        <textarea class="form-control txtExpenseRequire" style="resize: none;height: 80px;" id="txtExpenseRemarks"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm btn-round" onclick="fncAddSelectedExpense();">Add Expense</button>
            </div>
        </div>
    </div>
</div>
<?php include("script.php"); ?>