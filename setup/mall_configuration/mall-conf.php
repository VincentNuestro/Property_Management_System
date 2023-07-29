<input type="hidden" id="currentmallcount">
<input type="hidden" id="dimakita">
<style type="text/css">
    .divParent{
        height: 50vh;
    }

    .tblFloorListParent {
        height: 20vh;
    }

    .myupload{
        border: dashed 1px #999;
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
</style>
<!-- Mall List -->
<div class="row">
    <div class="col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#home" aria-expanded="true">
                        <i class="green ace-icon fa fa-institution bigger-120"></i>
                        Company
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#messages" aria-expanded="false" onclick="loadmalls();">
                        <span class="green ace-icon fa fa-building bigger-120"></span>
                        <span class="txtSysBuilding"></span>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade active in">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row form-group">
                                <div class="col-md-2 col-xs-12 pull-right" style=" padding-left: 0px;margin-bottom: 10px;">
                                    <button id="btn_inquiry" class="btn btn-primary btn-sm hide isadmin select-addnewmallCompany btn-round" style="width: 100% !important;float:right;margin-bottom: 0px;" onclick="fncMallNewCompany()">New Company</button>   
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-12">
                                    <div id="div_MallCompany"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="messages" class="tab-pane fade">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row form-group">
                                <div class="col-md-2 col-xs-12 pull-right" style=" padding-left: 0px;margin-bottom: 10px;">
                                    <button id="btn_inquiry" class="btn btn-primary btn-sm hide isadmin select-addnewmall btn-round" style="width: 100% !important;float:right;margin-bottom: 0px;" onclick="newmall()">New <span class="txtSysBuilding">Mall</span></button>   
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-12">
                                    <div id="div_malls"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdlNewMallCompany" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md">   
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;" id="hrMallCompany">New Company</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row form-group">
                            <label class="col-md-12">Company</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control txtClearMallCompany txtMallCompanyReq" id="txtMallCompanyName">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row form-group">
                            <label class="col-md-12">About</label>
                            <div class="col-md-12">
                                <textarea class="form-control txtClearMallCompany txtMallCompanyReq" style="resize: none;height: 90px;" maxlength="250" id="txtMallCompanyAbout"></textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-12">Mobile No</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control txtClearMallCompany txtMallCompanyReq input-mask-phone" id="txtMallCompanyMobile">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-12">Telephone No</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control txtClearMallCompany txtMallCompanyReq input-mask-tele" id="txtMallCompanyTelephone">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-12">Email Address</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control txtClearMallCompany txtMallCompanyReq email-address" id="txtMallCompanyEmail">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row form-group">
                            <div class="col-md-12 pull-right">
                                <div class="image">
                                    <img style="border: 2px solid #bdc3c7;width: 100%;margin-bottom: 8px;height: 165px" class='img-thumbnail form-control' id="imgMallCompanyImage" src='assets/images/noimage5.png'/>
                                </div>
                                <form method="post" action="#" enctype="multipart/form-data" id="frmMallCompanyImage">
                                    <input type="file" class="UserImage" name="txtMallCompanyImage" id="txtMallCompanyImage" onchange="fncShowCompanyImage();" accept="image/*">
                                    <input type="hidden" class="txtClearMallCompany" id="txtMallCompanyID" name="txtMallCompanyID">
                                </form>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-12">Address</label>
                            <div class="col-md-12">
                                <textarea class="form-control txtClearMallCompany txtMallCompanyReq" style="resize: none;height: 90px;" maxlength="250" id="txtMallCompanyAddress"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm btn-round" onclick="fncSaveMallCompany();"><i class="fa fa-check"></i>&nbsp;Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdlNewMall" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md">   
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;" id="hrMallCompany">New Company</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row form-group">
                            <label class="col-md-12">Company</label>
                            <div class="col-md-12">
                                <select class="form-control searchy_select" id="txtmall_Company" style="width: 100%;"></select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-12"><span class="txtSysBuilding">Mall</span> Name</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control required mall-info" id="txtmall_name">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-12">About</label>
                            <div class="col-md-12">
                                <textarea class="form-control required mall-info" style="resize: none;height: 90px;" maxlength="250" id="txtmall_abouts"></textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-12">Telephone No</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control required mall-info" id="txtmall_telephone">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-12">Email Address</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control required mall-info" id="txtmall_email">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-12">TIN Number</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control required mall-info" id="txtmall_tinnum">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row form-group">
                            <div class="col-md-12 pull-right">
                                <div class="image">
                                    <img style="border: 2px solid #bdc3c7;width: 100%;margin-bottom: 8px;height: 165px" class='img-thumbnail form-control' id="img_mallinfo" src='assets/images/noimage5.png'/>
                                </div>
                                <form name='posting_profilepic' id="posting_profilepic" class='posting_profilepic' style="display: none;">
                                    <div style="display: none;">
                                    <input type="text" id="txtmallid_forms" name="txtmallid_forms">
                                    </div>
                                    <input id='file_upload' name='attachment_profilepic' class='form-control upload_app_req' type='file' style="margin-top: 20px;" onchange="showimg123();"/>
                                </form>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-12">Address</label>
                            <div class="col-md-12">
                                <textarea class="form-control required mall-info" style="resize: none;height: 90px;" maxlength="250" id="txtmall_loc"></textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-12">Tenant ID Prefix</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control required mall-info" id="txtmallTenantIDPref">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary pull-right btn-sm btn-round" onclick="savemallupdate()"><i class="ace-icon fa fa-check"></i>&nbsp;Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="modalconfiguremodal" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;"><label id="div_tex_header_con" style="font-size: 18px;"></label> <label class="txtSysBuilding" style="font-size: 18px;"></label></h4>
                <input type="hidden" id="txtmall_id">
            </div>
            <div class="modal-body">
                <div class="tabbable tabs-left" id="mallconfdiv" style="display: block;">
                    <ul class="nav nav-tabs" id="myTab3">
                        <li class="active">
                            <a data-toggle="tab" href="#home3" onclick="loadwing();">
                                <i class="pink ace-icon fa fa-building bigger-110"></i>
                                Wing
                            </a>
                        </li>

                        <li>
                            <a data-toggle="tab" href="#profile3" onclick="refFloorFunc();">
                                <i class="blue ace-icon fa fa-building bigger-110"></i>
                                Floor
                            </a>
                        </li>

                        <li>
                            <a data-toggle="tab" href="#dropdown13" onclick="refUnitFunc();">
                                <i class="ace-icon fa fa-building"></i>
                                Unit
                            </a>
                        </li>

                        <li>
                            <a data-toggle="tab" href="#setupbill">
                                <i class="ace-icon fa fa-cog"></i>
                                Setup
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" style="margin-bottom: 20px;overflow-y: hidden;overflow-x: hidden;">
                        <div id="home3" class="tab-pane in active">
                            <div class="row">
                                <div class="col-xs-12 col-sm-3" style="padding-bottom: 5px;">
                                    <span class="input-icon" style="width: 100%;">
                                        <input type="text" class="form-control" placeholder="Search Wing Name..." id="txtsearchwingref">
                                        <i class="ace-icon fa fa-search nav-search-icon"></i>
                                    </span>
                                </div>
                                <div class="col-xs-12 col-sm-2 pull-right">
                                    <button id="btn_mall" class="btn btn-primary btn-sm btn-round btn-block" onclick="loadmodal_wing()">New Wing</button>
                                </div>
                            </div>
                            <div class="divParent">
                                <table class="table table-striped table-bordered table-hover fixTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 85%;">Wing</th>
                                            <th style="width: 15%; z-index: 1;">Option</th>                                         
                                        </tr>
                                    </thead>
                                    <tbody id="tblwinglist"></tbody>
                                </table>
                            </div>
                            <table class="tabledash_footer table" style="margin: 0px !important;">
                                <thead>
                                    <tr>
                                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                            <font id="txtwingentries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                            <input id="txt_wingpage" type="hidden">
                                            <ul id="ulpaginationwing" class="pagination pull-right"></ul>
                                        </th>
                                    </tr>
                                </thead>
                            </table>

                            <div class="modal fade fade-scale" id="modal_addnewwing" role="dialog">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" onclick="closemodalwing();">&times;</button>
                                            <h4 class="modal-title" style="font-size: 18px;">Wing Information</h4>
                                            <input type="hidden" id="txtrefwing" class="text_wing">
                                        </div>
                                        <div class="modal-body">
                                            <div class="row form-group">
                                                <div class="col-md-12">
                                                    Wing
                                                </div>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control req_wing text_wing" id="txtwingname">            
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary btn-sm btn-round" onclick="savewing()"><i class="ace-icon fa fa-check"></i>&nbsp;Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="profile3" class="tab-pane">
                            <div class="row">
                                <div class="col-sm-3" style="padding-bottom: 5px;">
                                    <span class="input-icon" style="width: 100%;">
                                        <input type="text" class="form-control" placeholder="Search Floor Name..." id="txtsearchfloormc">
                                        <i class="ace-icon fa fa-search nav-search-icon"></i>
                                    </span>
                                </div>
                                <div class="col-sm-3" style="padding-bottom: 5px;">
                                    <select class="form-control" id="txtfilterby" name="txtfilterby" onchange="loadfloors()">
                                        <option value="">Filter by</option>
                                    </select>
                                </div>  
                                <div class="col-sm-3"></div>
                                <div class="col-sm-2">
                                    <a href="#" id="btn_mall" class="btn btn-primary btn-sm btn-round" style="width: 100% !important;" onclick="loadmodal_floor()">New Floor</a>
                                </div>
                            </div>
                            <div class="divParent">
                                <table class="table table-striped table-bordered table-hover fixTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 22.5%;">Floor</th>
                                            <th style="width: 22.5%;" class="hide_mobile">Wing</th>
                                            <?php if(SysLeaseSetup('floorandunitmeasurement') == "Area"){ ?>

                                            <th style="width: 20%;">Total Leasable Area</th>
                                            <th style="width: 20%;">Gross Leasable Area</th>

                                            <?php }else{ ?>

                                            <th style="width: 20%;">Dimensions</th>
                                            <th style="width: 20%;">Min. Area</th>

                                            <?php } ?>
                                            <th style="width: 15%;z-index: 1;">Option</th>                                             
                                        </tr>
                                    </thead>
                                    <tbody id="tblfloorslist"></tbody>
                                </table>
                            </div>
                            <table class="tabledash_footer table" style="margin: 0px !important;">
                                <thead>
                                    <tr>
                                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                            <font id="txtflrentries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                            <input id="txt_flrpage" type="hidden">
                                            <ul id="ulpaginationflr" class="pagination pull-right"></ul>
                                        </th>
                                    </tr>
                                </thead>
                            </table>

                            <div class="modal fade fade-scale" id="modal_addnewfloor" role="dialog">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" onclick="cloaseflrmodal()">&times;</button>
                                            <h4 class="modal-title" style="font-size: 18px;">Floor Information</h4>
                                            <input type="hidden" id="txtreffloor" class="text_floor">
                                        </div>
                                        <div class="modal-body">
                                            <div class="row form-group">
                                                <div class="col-md-12">
                                                    Wing
                                                </div>
                                                <div class="col-md-12">
                                                    <select id="txtwings" class="form-control text_floor txtreq_flr">
                                                        <option value="">-- Select Wing --</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-12">
                                                    Floor
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="input-group">
                                                        <select id="txtfloor" class="form-control text_floor txtref_flr txtreq_flr"></select>
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-success btn-sm" onclick="addnewreffloor()">
                                                                <span class="ace-icon fa fa-plus icon-on-right bigger-110"></span>
                                                            </button>
                                                        </span>
                                                    </div>               
                                                </div>
                                            </div>
                                            <div class="row form-group isLengthWidth">
                                                <div class="col-md-12">Width</div>
                                                <div class="col-md-12">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control numonly text_floor" id="txtwidth">
                                                        <span class="input-group-addon">
                                                            meters
                                                        </span>
                                                    </div>               
                                                </div>
                                            </div>
                                            <div class="row form-group isLengthWidth">
                                                <div class="col-md-12">Length</div>
                                                <div class="col-md-12">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control numonly text_floor" id="txtlength">
                                                        <span class="input-group-addon">
                                                            meters
                                                        </span>
                                                    </div>               
                                                </div>
                                            </div>
                                            <div class="row form-group isLengthWidth">
                                                <div class="col-md-12">Total Area</div>
                                                <div class="col-md-12">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control numonly text_floor" id="txtminarea">
                                                        <span class="input-group-addon">
                                                            SQM.
                                                        </span>
                                                    </div>               
                                                </div>
                                            </div>
                                            <div class="row form-group isArea">
                                                <div class="col-md-12">
                                                    Total Leasable Area
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control numonly text_floor" id="txtTLA">
                                                        <span class="input-group-addon">
                                                            SQM.
                                                        </span>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="row form-group isArea">
                                                <div class="col-md-12">
                                                    Gross Leasable Area
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control numonly text_floor" id="txtGLA">
                                                        <span class="input-group-addon">
                                                            SQM.
                                                        </span>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary btn-sm btn-round" onclick="savefloor()"><i class="ace-icon fa fa-check"></i>&nbsp;Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade fade-scale" id="modal_addnewreffloor" role="dialog">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <button type="button" class="close" onclick="cloaseflrmodal2()">&times;</button>
                                            <h4 class="modal-title">Floors</h4>
                                            <h6 class="modal-title">(Referential)</h6>
                                            <div class="row form-group">
                                                <div class="col-xs-12 col-md-12">
                                                    <div class="tblFloorListParent">
                                                        <table class="table table-striped table-bordered table-hover fixTable">
                                                            <tbody id="tblfloorsreflist"></tbody>
                                                        </table>
                                                    </div>
                                                    <hr />
                                                    <h6 class="modal-title">New Floor</h6>
                                                    <h6 class="modal-title" style="font-size: 10px;font-style: italic;">(if not on the selection)</h6>
                                                    <input type="text" id="txtaddnewrefflr" style="" class="form-control" placeholder="Add New">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary btn-sm btn-round" onclick="savereffloor()"><i class="ace-icon fa fa-check"></i>&nbsp;Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>

                        <div id="dropdown13" class="tab-pane">
                            <div class="row">
                                <div class="col-sm-3" style="padding-bottom: 5px;">
                                    <span class="input-icon" style="width: 100%;">
                                        <input type="text" class="form-control" placeholder="Search Unit Name..." id="txtsearchamenities">
                                        <i class="ace-icon fa fa-search nav-search-icon"></i>
                                    </span>
                                </div>
                                <div class="col-sm-7"></div>
                                <div class="col-sm-2 pull-right">
                                    <a href="#" id="btn_mall" class="btn btn-primary btn-sm btn-round" style="width: 100% !important;" onclick="loadmodal_unit()">New Unit</a>
                                </div>
                            </div>
                            <div class="divParent">
                                <table class="table table-striped table-bordered table-hover fixTable">
                                    <thead>
                                        <tr>
                                            <th>Unit</th>
                                            <th class="hide_mobile">Wing</th>
                                            <th class="hide_mobile">Floor</th>
                                            <th class="hide_mobile">Unit Type</th>
                                            <th class="hide_mobile">Classification</th>
                                            <th style="z-index: 1;">Status</th>
                                            <th style="z-index: 1; width: 15%;">Option</th>                                     
                                        </tr>
                                    </thead>
                                    <tbody id="tblunitlist"></tbody>
                                </table>
                            </div>
                            <table class="tabledash_footer table" style="margin: 0px !important;">
                                <thead>
                                    <tr>
                                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                            <font id="txtunitentries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                            <input id="txt_unitpage" type="hidden">
                                            <ul id="ulpaginationunit" class="pagination pull-right"></ul>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div id="setupbill" class="tab-pane">
                            <div class="row" style="padding: 10px;">
                                <div class="media search-media">
                                    <div class="media-left" style="padding-right: 20px;">
                                        <a href="#">
                                            <img class="media-object" id="mall_image" src="assets/images/receipt.png" style="width: 72px; height: 72px;">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <div class="ace-settings-container" id="ace-settings-container">
                                            <div class="btn btn-app btn-xs btn-warning ace-settings-btn btn-round" id="ace-settings-btn" onclick="modal_billsetup()">
                                                <i class="ace-icon fa fa-cog bigger-130"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="media-heading">
                                                <a href="#" class="blue">Billing Setup</a>
                                            </h4>
                                        </div>
                                        <p style="margin-bottom: 0px;">
                                            <i class="fa fa-bookmark light-orange bigger-120"></i>
                                            <span>Authorized Signatories</span>
                                        </p>
                                        <?php if(SysLeaseSetup('vatsetup') == "1"){ ?>
                                        <p style="margin-bottom: 0px;">
                                            <i class="fa fa-bookmark light-orange bigger-120"></i>
                                            <span>Vat Setup</span>
                                        </p>
                                        <?php } ?>
                                        <p style="margin-bottom: 0px;">
                                            <i class="fa fa-bookmark light-orange bigger-120"></i>
                                            <span>Penalty Rate</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="media search-media">
                                    <div class="media-left" style="padding-right: 20px;">
                                        <a href="#">
                                            <img class="media-object" id="mall_image" src="assets/images/management.png" style="width: 72px; height: 72px;">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <div class="ace-settings-container" id="ace-settings-container">
                                            <div class="btn btn-app btn-xs btn-warning ace-settings-btn btn-round" id="ace-settings-btn" onclick="modal_maintenancesetup()">
                                                <i class="ace-icon fa fa-cog bigger-130"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="media-heading">
                                                <a href="#" class="blue">Maintenance Setup</a>
                                            </h4>
                                        </div>
                                        <p style="margin-bottom: 0px;">
                                            <i class="fa fa-bookmark light-orange bigger-120"></i>
                                            <span>Water</span>
                                        </p>
                                        <p style="margin-bottom: 0px;">
                                            <i class="fa fa-bookmark light-orange bigger-120"></i>
                                            <span>Electric</span>
                                        </p>
                                        <p style="margin-bottom: 0px;">
                                            <i class="fa fa-bookmark light-orange bigger-120"></i>
                                            <span>Gas</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="media search-media hide">
                                    <div class="media-left" style="padding-right: 20px;">
                                        <a href="#">
                                            <img class="media-object" id="mall_image" src="assets/images/mallemp.png" style="width: 72px; height: 72px;">
                                        </a>
                                    </div>

                                    <div class="media-body">
                                        <div class="ace-settings-container" id="ace-settings-container">
                                            <div class="btn btn-app btn-xs btn-warning ace-settings-btn btn-round" id="ace-settings-btn" onclick="fnc_LeaseSignatories()">
                                                <i class="ace-icon fa fa-cog bigger-130"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="media-heading">
                                                <a href="#" class="blue">Leasing Signatories</a>
                                            </h4>
                                        </div>
                                        <p style="margin-bottom: 0px;">
                                            <i class="fa fa-bookmark light-orange bigger-120"></i>
                                            <span>Personnel List</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="media search-media">
                                    <div class="media-left" style="padding-right: 20px;">
                                        <a href="#">
                                            <img class="media-object" id="mall_image" src="assets/images/bankinfo.png" style="width: 72px; height: 72px;">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <div class="ace-settings-container" id="ace-settings-container">
                                            <div class="btn btn-app btn-xs btn-warning ace-settings-btn btn-round" id="ace-settings-btn" onclick="showmodal_BankInfo(); $('#modal_BankInfo').modal('show');">
                                                <i class="ace-icon fa fa-cog bigger-130"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="media-heading">
                                                <a href="#" class="blue">Bank Information</a>
                                            </h4>
                                        </div>
                                        <p style="margin-bottom: 0px;">
                                            <i class="fa fa-bookmark light-orange bigger-120"></i>
                                            <span>Bank Account List</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="media search-media">
                                    <div class="media-left" style="padding-right: 20px;">
                                        <a href="#">
                                            <img class="media-object" id="mall_image" src="assets/images/import.png" style="width: 72px; height: 72px;">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <div class="ace-settings-container" id="ace-settings-container">
                                            <div class="btn btn-app btn-xs btn-warning ace-settings-btn btn-round" id="ace-settings-btn" onclick="fncDownloadTemplate();">
                                                <i class="ace-icon fa fa-cog bigger-130"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="media-heading">
                                                <a href="#" class="blue">Import Mall Configuration</a>
                                            </h4>
                                        </div>
                                        <p style="margin-bottom: 0px;">
                                            <i class="fa fa-bookmark light-orange bigger-120"></i>
                                            <span>Wing</span>
                                        </p>
                                        <p style="margin-bottom: 0px;">
                                            <i class="fa fa-bookmark light-orange bigger-120"></i>
                                            <span>Floor</span>
                                        </p>
                                        <p style="margin-bottom: 0px;">
                                            <i class="fa fa-bookmark light-orange bigger-120"></i>
                                            <span>Unit</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="media search-media" style="display: none;" id="<!-- ifleasingisselected -->">
                                    <div class="media-left" style="padding-right: 20px;">
                                        <a href="#">
                                            <img class="media-object" id="mall_image" src="assets/images/building.png" style="width: 72px; height: 72px;">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <div class="ace-settings-container" id="ace-settings-container">
                                            <div class="btn btn-app btn-xs btn-warning ace-settings-btn btn-round" id="ace-settings-btn" onclick="modal_leasingsetup()">
                                                <i class="ace-icon fa fa-cog bigger-130"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="media-heading">
                                                <a href="#" class="blue">Leasing Setup</a>
                                            </h4>
                                        </div>
                                        <p style="margin-bottom: 0px;">
                                            <i class="fa fa-cog light-orange bigger-100"></i>
                                            <span>Spot Payment</span>
                                        </p>
                                        <p style="margin-bottom: 0px;">
                                            <i class="fa fa-cog light-orange bigger-100"></i>
                                            <span>Down Payment</span>
                                        </p>
                                        <p style="margin-bottom: 0px;">
                                            <i class="fa fa-cog light-orange bigger-100"></i>
                                            <span>Balance Payment</span>
                                        </p>
                                        <p style="margin-bottom: 0px;">
                                            <i class="fa fa-cog light-orange bigger-100"></i>
                                            <span>Other Charges</span>
                                        </p>
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

<div class="modal fade fade-scale" id="modal_addnewunit" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="loadunit();">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Unit Information</h4>
                <input type="hidden" id="txtrefunit" class="text_unit">
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row form-group">
                            <!-- <div class="col-md-12">
                                <div class="checkbox pull-right">
                                    <label>
                                        <input type="checkbox" id="clicktoshowall" class="ace" onclick="clicktoshowall()">
                                        <span class="lbl" style="color: #666;font-weight: bold;">&nbsp;Expand All</span>
                                    </label>
                                </div>
                            </div> -->
                            <div class="col-md-12">
                                <div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
                                    <div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
                                        <div class="widget-header"> 
                                            <h4 class="widget-title">Main Unit Information</h4>
                                            <!-- <div class="widget-toolbar no-border">
                                                <a href="#" data-action="collapse" class="clicktoshowall" id="MainUnitInformation">
                                                    <i class="ace-icon fa fa-chevron-down"></i>
                                                </a>
                                            </div> -->
                                        </div>
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row well">
                                                    <div class="row form-group">
                                                        <div class="col-md-6">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <h4 class="green">Unit Information</h4>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Unit Name</label>
                                                                        <div class="col-md-12">
                                                                            <input type="text" class="form-control text_unit req_unit input-sm" id="txtMCUnitName" placeholder="Unit Name">              
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Unit Type</label>
                                                                        <div class="col-md-12" id="divtxtMCUnitType">
                                                                            <select class="form-control req_unit searchy_select" id="txtMCUnitType" onchange="checkbustypevalue()" style="width: 100%;">
                                                                                <option value="">-- Select Type --</option>
                                                                                <option value="LCA">Lease Common Area</option>
                                                                                <option value="SET">SET</option>
                                                                            </select>        
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Area (SQM)</label>
                                                                        <div class="col-md-6 isLengthWidth" style="padding-right:2px;">
                                                                            <input type="text" class="form-control upper text_unit numonly req_unit" id="txtMCUnitLength" placeholder="Length">
                                                                        </div>
                                                                        <div class="col-md-6 isLengthWidth" style="padding-left:2px;">
                                                                            <input type="text" class="form-control upper text_unit numonly req_unit" id="txtMCUnitWidth" placeholder="Width">
                                                                        </div>
                                                                        <div class="col-md-12 isArea">
                                                                            <input type="text" class="form-control upper text_unit numonly req_unit" id="txtMCUnitArea" placeholder="Area">
                                                                        </div>
                                                                    </div>                                                                    
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Wing</label>
                                                                        <div class="col-md-12" id="divtxtMCUnitWing">
                                                                            <select id="txtMCUnitWing" class="form-control text_unit req_unit searchy_select" onchange="fncLoadUnitFloor();" style="width: 100%;">
                                                                                <option value="">-- Select Wing --</option>
                                                                            </select>            
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Floor</label>
                                                                        <div class="col-md-12" id="divtxtMCUnitFloor">
                                                                            <select id="txtMCUnitFloor" class="form-control text_unit req_unit searchy_select" style="width: 100%;">
                                                                                <option value="">-- Select Floor --</option>
                                                                            </select>           
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Rate/SQM.</label>
                                                                        <div class="col-md-12">
                                                                            <input type="text" class="form-control upper text_unit numonly amount req_unit" id="txtMCUnitRate" style="text-align: right;" placeholder="Rate per SQM">
                                                                        </div>
                                                                    </div>
                                                                        
                                                                </div>
                                                                <?php if(SysLeaseSetup('isAssocDues') == "1"){ ?>
                                                                    <div class="col-md-6">
                                                                        <div class="row form-group">
                                                                            <label class="col-md-12">Unit Classification</label>
                                                                            <div class="col-md-12" id="divtxtMCUnitClass">
                                                                                <div class="input-group">
                                                                                    <select class="form-control req_unit searchy_select" id="txtMCUnitClass" style="width: 100%;"></select>        
                                                                                    <span class="input-group-btn">
                                                                                        <button type="button" class="btn btn-success btn-sm" onclick="fncAddNewUnitClass()">
                                                                                            <span class="ace-icon fa fa-plus icon-on-right bigger-110"></span>
                                                                                        </button>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="row form-group">
                                                                            <label class="col-md-12">Association Dues</label>
                                                                            <div class="col-md-12">
                                                                                <input type="text" class="form-control numonly amount" id="txtassocdues" style="text-align: right;" placeholder="0.00">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php }else{ ?>
                                                                    <div class="col-md-12">
                                                                        <div class="row form-group">
                                                                            <label class="col-md-12">Unit Classification</label>
                                                                            <div class="col-md-12" id="divtxtMCUnitClass">
                                                                                <div class="input-group">
                                                                                    <select class="form-control req_unit searchy_select" id="txtMCUnitClass" style="width: 100%;"></select>        
                                                                                    <span class="input-group-btn">
                                                                                        <button type="button" class="btn btn-success btn-sm" onclick="fncAddNewUnitClass()">
                                                                                            <span class="ace-icon fa fa-plus icon-on-right bigger-110"></span>
                                                                                        </button>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                                <label class="col-md-12">Facilities</label>
                                                                <div class="col-md-12">
                                                                    <div class="inline" style="width: 100%;">
                                                                        <div class="tags" style="width: 100%;" id="div_amenitiesselected">
                                                                            <br/><label style="width: 100%;" onclick="addnewrefamenities()">Click to add facilities ..</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <h4 class="green">Unit Image</h4>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <form name="frmUnitPhoto" id="frmUnitPhoto">
                                                                        <input type="hidden" name="refunitid" id="refunitid">
                                                                        <input multiple type="file" id="txtUnitImage" name="txtUnitImage[]" />
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <ul class="ace-thumbnails clearfix" style="max-height: 330px;overflow-y: scroll;" id="ulUnitImages"></ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <h4 class="green">Other Unit Information</h4>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <textarea class="ckeditor" name="txtOtherUnitInfo" id="txtOtherUnitInfo"></textarea>
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
                            <div class="col-md-12">
                                <div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
                                    <div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
                                        <div class="widget-header"> 
                                            <h4 class="widget-title">Sub Unit Information</h4>
                                            <!-- <div class="widget-toolbar no-border">
                                                <a href="#" data-action="collapse" class="clicktoshowall" id="SubUnitInformation">
                                                    <i class="ace-icon fa fa-chevron-down"></i>
                                                </a>
                                            </div> -->
                                        </div>
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row well">
                                                    <div class="row form-group">
                                                        <div class="col-md-4">
                                                            <div class="row form-group">
                                                                <label class="col-md-12">Unit Name</label>
                                                                <div class="col-md-12">
                                                                    <input type="text" class="form-control txtSubUnitInfo text_unit" id="txtSubUnitName" placeholder="Unit Name">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="row form-group">
                                                                <label class="col-md-12">Area (SQM)</label>
                                                                <div class="col-md-6 isLengthWidth" style="padding-right:2px;">
                                                                    <input type="text" class="form-control numonly amount2 text_unit" id="txtSubUnitLength" placeholder="Length">
                                                                </div>
                                                                <div class="col-md-6 isLengthWidth" style="padding-left:2px;">
                                                                    <input type="text" class="form-control numonly amount2 text_unit" id="txtSubUnitWidth" placeholder="Width">
                                                                </div>
                                                                <div class="col-md-12 isArea">
                                                                    <input type="text" class="form-control numonly amount2 text_unit" id="txtSubUnitArea" placeholder="Area">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="row form-group">
                                                                <label class="col-md-12">Rate</label>
                                                                <div class="col-md-12">
                                                                    <input type="text" class="form-control upper numonly amount txtSubUnitInfo text_unit" id="txtSubUnitRate" style="text-align: right;" placeholder="Rate per SQM">              
                                                                </div>
                                                            </div>
                                                            <?php if(SysLeaseSetup('isAssocDues') == "1"){ ?>
                                                                <div class="row form-group">
                                                                    <label class="col-md-12">Association Dues</label>
                                                                    <div class="col-md-12">
                                                                        <input type="text" class="form-control numonly amount txtSubUnitInfo text_unit" id="txtSubUnitAssocDues" style="text-align: right;" placeholder="0.00">
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="row form-group">
                                                                <label class="col-md-12 hidden-xs">&nbsp;</label>
                                                                <div class="col-md-12">
                                                                    <button class="btn btn-sm btn-primary pull-right btn-round" onclick="fncSaveAddUnit();"><i class="fa fa-plus"></i> Add Sub Unit</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <div id="div_SubUnitList"></div>
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
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm btn-round" onclick="saveunit();"><i class="ace-icon fa fa-check"></i>&nbsp;Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="modal_EditSubUnit" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm">   
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Sub Unit Information</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="image">
                            <img class="img-thumbnail imageName form-control" src="assets/images/noimage5.png" id="imgEditSUbUnitImage" style="border: 2px solid #bdc3c7; margin-bottom: 8px;height: 180px;">
                        </div>
                        <form name="frmEditSubUnitImage" id="frmEditSubUnitImage" class="frmEditSubUnitImage">
                            <input type="hidden" id="SubEditUnitID" name="txtSubUnitID">
                            <input type="hidden" id="txtEditMainUnitID">
                            <input id="txtFileSubUnitImage" onchange="showSubUnitImage('imgEditSUbUnitImage', 'txtFileSubUnitImage')" name="fileSubUnitImage" class="form-control Unit-Image" type="file" accept="image/*"/>
                        </form>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-12">Unit Name</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" id="txtEditSubUnitName" placeholder="Unit Name">
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-12">Area (SQM)</label>
                    <div class="col-md-6 isLengthWidth">
                        <input type="text" class="form-control numonly amount2" id="txtEditSubUnitLength" placeholder="Length">
                    </div>
                    <div class="col-md-6 isLengthWidth">
                        <input type="text" class="form-control numonly amount2" id="txtEditSubUnitWidth" placeholder="Width">
                    </div>
                    <div class="col-md-12 isArea">
                        <input type="text" class="form-control numonly amount2" id="txtEditSubUnitArea" placeholder="Area">
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-12">Rate</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control numonly amount" id="txtEditSubUnitRate" placeholder="Rate per SQM" style="text-align: right;">
                    </div>
                </div>
                <?php if(SysLeaseSetup('isAssocDues') == "1"){ ?>
                    <div class="row form-group">
                        <label class="col-md-12">Association Dues</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" id="txtEditSubUnitAssocDues" placeholder="0.00" style="text-align: right;">
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm btn-round" onclick="fncEditSaveSubUnit();"><i class="ace-icon fa fa-check"></i>&nbsp;Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="modal_addnewrefamenities" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm">   
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" onclick="closemodalrefam()">&times;</button>
                <h4 class="modal-title hdrSysUnitInclusion">Select Facility</h4>
                
                <div class="row form-group">
                    <div class="col-xs-12 col-md-12">
                        <table style="margin:10px;border: 1px dotted #CCC;">
                            <tbody id="tblamenitiesreflist" style="flex: 1 1 auto;display: block;height: 20em;overflow-y: scroll;"></tbody>
                        </table>
                        <hr />
                        <h6 class="modal-title">New <label class="txtSysUnitInclusion"></label></h6>
                        <h6 class="modal-title" style="font-size: 10px;font-style: italic;">(if not on the list)</h6>
                        <div class="input-group" style="width: 100%;">
                            <input type="text" id="txtaddnewrefame" style="" class="form-control" name="" placeholder="Add New" style="height: 43px !important;">
                           <div class="spinbox-buttons input-group-btn">         
                                <button type="button" class="btn btn-success btn-sm btn-round" onclick="savenewamenitiesref()"><i class="ace-icon fa fa-plus"></i>&nbsp;Add</button>     
                           </div>
                       </div>
                        
                        <div class="row form-group" style="margin-bottom: 5px;margin-top: 10px;">
                            <div class="col-md-12 col-xs-12">
                                 <label style="width: 100%">
                                    <input name="count_type" type="radio" class="ace" value="1">
                                    <span class="lbl"> Inventory</span>
                                </label>                           
                            </div>
                        </div>
                        <div class="row form-group" style="margin-bottom: 5px;">
                            <div class="col-md-12 col-xs-12">
                                <label style="width: 100%">
                                    <input name="count_type" type="radio" class="ace" value="0">
                                    <span class="lbl"> Non-Inventory</span>
                                </label>                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm btn-round" onclick="addamenitiesselected()"><i class="ace-icon fa fa-check"></i>&nbsp;Save</button>
            </div>
      </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdlNewUnitClassification" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div id="preloadmodal_loadcompany"></div>
            <div class="modal-header" style="background-color: #438EB9;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Add Process Owner</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <label class="col-md-12">Unit Classification Code</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" id="txtMCUnitClassCode">
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-12">Unit Classification Description</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" id="txtMCUnitClassDesc">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-primary btn-round" onclick="fncSaveUnitClassification();"><i class="fa fa-check"></i>&nbsp;Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="modal_billsetup" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">   
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="closesetupbill()">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Billing Setup</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="widget-box widget-color-blue3" id="tbdywidget_vatpen">
                            <div class="widget-header">
                                <h5 class="widget-title">VAT Set</h5>
                            </div>
                            <div class="widget-body">
                                <div class="widget-main">
                                    <div class="row">
                                        <div class="grid2">
                                            <div class="form-group row">
                                                <div class="col-md-12"><label>Is Charges (Rent/Violation/Penalty/Maintenance) VATable?</label></div>
                                                <div class="col-md-4">
                                                    <div class="radio">
                                                        <label>
                                                            <input name="rent_vatable" type="radio" class="ace widget_vatpen MCisRentVATable" id="vatsetupyes" value="yes" checked onclick="fncVATSetup(this.value);">
                                                            <span class="lbl"> Yes</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="radio">
                                                        <label>
                                                            <input name="rent_vatable" type="radio" class="ace widget_vatpen MCisRentVATable" id="vatsetupno" value="no" onclick="fncVATSetup(this.value);">
                                                            <span class="lbl"> No</span>
                                                        </label>
                                                    </div>                          
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-12"><label>Rent VAT type</label></div>
                                                <div class="col-md-8">
                                                    <select class="form-control widget_vatpen" id="slct_rentvattype">
                                                        <option value="inc" selected>Inclusive</option>
                                                        <option value="exc">Exclusive</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="input-icon input-icon-right" style="width: 100%;">
                                                        <input type="text" class="form-control numonly widget_vatpen" id="txtrentvatperc" style="border-color: rgb(213, 213, 213);" maxlength="2">
                                                        <i class="ace-icon fa fa-percent"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>                                      
                                        <div class="grid3 hide">
                                            <div class="form-group row">
                                                <div class="col-md-12"><label>Is penalty VATable?</label></div>
                                                <div class="col-md-4">
                                                    <div class="radio">
                                                        <label>
                                                            <input name="penalty_vatable" type="radio" class="ace vattrigger widget_vatpen" id="triggeredyes" value="yes" checked>
                                                            <span class="lbl">&nbsp;Yes</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="radio">
                                                        <label>
                                                            <input name="penalty_vatable" type="radio" class="ace vattrigger widget_vatpen" id="triggeredno" value="no">
                                                            <span class="lbl">&nbsp;No</span>
                                                        </label>
                                                    </div>                          
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-12"><label>Penalty VAT type</label></div>
                                                <div class="col-md-8">
                                                    <select class="form-control" id="slct_penaltypevattype">
                                                        <option value="inc" selected>Inclusive</option>
                                                        <option value="exc">Exclusive</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="input-icon input-icon-right" style="width: 100%;">
                                                        <input type="text" class="form-control numonly" id="txtpenaltyvatperc" style="border-color: rgb(213, 213, 213);" maxlength="2">
                                                        <i class="ace-icon fa fa-percent"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid2">
                                            <div class="form-group row">
                                                <div class="col-md-12"><label>Rent Penalty Type</label></div>
                                                <div class="col-md-4">
                                                    <div class="radio">
                                                        <label>
                                                            <input name="penalty_type" type="radio" class="ace widget_vatpen MCisRentPenaltyVATable" id="penaltytypeamount" value="amount" checked onclick="fncRentPenaltyType('amount');">
                                                            <span class="lbl">&nbsp;Amount</span>
                                                        </label>
                                                    </div> 
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="radio">
                                                        <label>
                                                            <input name="penalty_type" type="radio" class="ace widget_vatpen MCisRentPenaltyVATable" id="penaltytypepercent" value="percent" onclick="fncRentPenaltyType('percent');">
                                                            <span class="lbl">&nbsp;Percent</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="form-group row">
                                                <div class="col-md-12"><label>Penalty Amount</label></div>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control numonly amount widget_vatpen" style="text-align: right" id="txtpenalty_amt" placeholder="0.00">
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="input-icon input-icon-right" style="width: 100%;">
                                                        <input type="text" class="form-control numonly widget_vatpen" id="txtpenalty_perc" style="border-color: rgb(213, 213, 213);" maxlength="2">
                                                        <i class="ace-icon fa fa-percent"></i>
                                                    </span>
                                                </div>
                                            </div>                                         
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-toolbox padding-8 clearfix">
                                    <button class="btn btn-primary pull-right widget_vatpen btn-sm btn-round" onclick="save_vat_penalty_setup()">
                                        <i class="ace-icon fa fa-check icon-on-right"></i>
                                        <span class="bigger-110">&nbsp;Save</span>            
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 hide">
                        <div class="widget-box widget-color-blue3 collapsed" id="tbdywidget_billing">
                            <div class="widget-header">
                                <h5 class="widget-title">Additional Charges</h5>
                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse" class="clicktoshowall" id="wdTabInfo">
                                        <i class="ace-icon fa fa-chevron-down"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="widget-body" style="display: none;">
                                <div class="widget-main">
                                    <div class="row form-group">
                                        <div class="col-md-2 pull-right">
                                            <button class="btn btn-sm btn-round btn-info btn-block" onclick="fncOpenChargesList('tbodyAdditionalCharges');">Add Charges</button>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <div style="height: 40vh;">
                                                <table class="table table-bordered table-striped fixTable">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 15%;">Charge Code</th>
                                                            <th style="width: 45%;">Charge Description</th>
                                                            <th style="width: 35%;">Rate</th>
                                                            <th style="width: 5%;z-index: 1;">Option</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyAdditionalCharges"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-toolbox padding-8 clearfix">
                                    <button class="btn btn-primary pull-right widget_vatpen btn-sm btn-round" onclick="fncSaveAdditionalCharges()">
                                        <i class="ace-icon fa fa-check icon-on-right"></i>
                                        <span class="bigger-110">&nbsp;Save</span>            
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 hide">
                        <div class="widget-box widget-color-blue3 collapsed" id="tbdywidget_billing">
                            <div class="widget-header">
                                <h5 class="widget-title">Other Charges</h5>
                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse" class="clicktoshowall" id="wdTabInfo">
                                        <i class="ace-icon fa fa-chevron-down"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="widget-body" style="display: none;">
                                <div class="widget-main">
                                    <div class="row form-group">
                                        <div class="col-md-2 pull-right">
                                            <button class="btn btn-sm btn-round btn-info btn-block" onclick="fncOpenChargesList('tbodyOtherCharges');">Add Charges</button>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <div style="height: 40vh;">
                                                <table class="table table-bordered table-striped fixTable">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 15%;">Charge Code</th>
                                                            <th style="width: 40%;">Charge Description</th>
                                                            <th style="width: 20%;">Rate</th>
                                                            <th style="width: 20%;">No. of Months</th>
                                                            <th style="width: 5%;z-index: 1;">Option</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyOtherCharges"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-toolbox padding-8 clearfix">
                                    <button class="btn btn-primary pull-right widget_vatpen btn-sm btn-round" onclick="fncSaveOtherCharges()">
                                        <i class="ace-icon fa fa-check icon-on-right"></i>
                                        <span class="bigger-110">&nbsp;Save</span>            
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="widget-box widget-color-blue3 collapsed" id="tbdywidget_billing">
                            <div class="widget-header">
                                <h5 class="widget-title">Billing Setup</h5>
                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse" class="clicktoshowall" id="wdTabInfo">
                                        <i class="ace-icon fa fa-chevron-down"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="widget-body" style="display: none;">
                                <div class="widget-main">
                                    <div class="row form-group">
                                        <div class="col-md-2">
                                            Cut-off Year
                                        </div>
                                        <div class="col-md-2">
                                            <select class="form-control" id="txtBillSetupYear" onchange="fncLoadBillSetup();"></select>
                                        </div>
                                        <div class="col-md-3 pull-right">
                                            <button class="btn btn-info btn-sm btn-round btn-block" onclick="fncAddNewCOPeriod();">Add New Cut-off Period</button>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <div class="parent2">
                                                <table class="table table-bordered table-striped fixTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Period</th>
                                                            <th>Start Date</th>
                                                            <th>End Date</th>
                                                            <th>Due Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyBillPeriod"></tbody>
                                                </table>
                                            </div>
                                            <table class="tabledash_footer table" style="margin: 0px !important;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                                            <font id="txtleadsentries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                                            <input id="leadspages" type="hidden">
                                                            <ul id="ulpaginationleads" class="pagination pull-right"></ul>
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
                    <div class="col-md-12">
                        <div class="widget-box widget-color-blue3 collapsed" id="tbdywidget_billing">
                            <div class="widget-header">
                                <h5 class="widget-title">SOA Signatories</h5>
                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse">
                                        <i class="ace-icon fa fa-chevron-down"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="widget-body" style="display: none;">
                                <div class="widget-main">
                                    <div class="form-group row" style="margin-bottom: 0px;">
                                        <div class="col-xs-12">
                                            <p style="font-size: 13px;margin: 0px;font-weight: normal;">Prepared by</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-xs-4" style="padding-right: 0px;">
                                            <input type="text" class="form-control" placeholder="Last Name" id="txtpreparedby_lname">
                                        </div>
                                        <div class="col-xs-4" style="padding-right: 0px;">
                                            <input type="text" class="form-control" placeholder="First Name" id="txtpreparedby_fname">
                                        </div>
                                        <div class="col-xs-4">
                                            <input type="text" class="form-control" placeholder="Middle Name" id="txtpreparedby_mname">
                                        </div>
                                    </div>
                                    <div class="form-group row" style="margin-bottom: 0px;">
                                        <div class="col-xs-12">
                                            <p style="font-size: 13px;margin: 0px;font-weight: normal;">Checked by</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-xs-4" style="padding-right: 0px;">
                                            <input type="text" class="form-control" placeholder="Last Name" id="txtchkedby_lname">
                                        </div>
                                        <div class="col-xs-4" style="padding-right: 0px;">
                                            <input type="text" class="form-control" placeholder="First Name" id="txtchkedby_fname">
                                        </div>
                                        <div class="col-xs-4">
                                            <input type="text" class="form-control" placeholder="Middle Name" id="txtchkedby_mname">
                                        </div>
                                    </div>
                                    <div class="form-group row" style="margin-bottom: 0px;">
                                        <div class="col-xs-12">
                                            <p style="font-size: 13px;margin: 0px;font-weight: normal;">Approved by</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-xs-4" style="padding-right: 0px;">
                                            <input type="text" class="form-control" placeholder="Last Name" id="txtapprovedby_lname">
                                        </div>
                                        <div class="col-xs-4" style="padding-right: 0px;">
                                            <input type="text" class="form-control" placeholder="First Name" id="txtapprovedby_fname">
                                        </div>
                                        <div class="col-xs-4">
                                            <input type="text" class="form-control" placeholder="Middle Name" id="txtapprovedby_mname">
                                        </div>
                                    </div>
                                    <div class="form-group row hide" style="margin-bottom: 0px;">
                                        <div class="col-xs-12">
                                            <p style="font-size: 13px;margin: 0px;font-weight: normal;">Received by</p>
                                        </div>
                                    </div>
                                    <div class="form-group row hide">
                                        <div class="col-xs-4" style="padding-right: 0px;">
                                            <input type="text" class="form-control" placeholder="Last Name" id="txtreceivedby_lname">
                                        </div>
                                        <div class="col-xs-4" style="padding-right: 0px;">
                                            <input type="text" class="form-control" placeholder="First Name" id="txtreceivedby_fname">
                                        </div>
                                        <div class="col-xs-4">
                                            <input type="text" class="form-control" placeholder="Middle Name" id="txtreceivedby_mname">
                                        </div>
                                    </div>
                                </div>

                                <div class="widget-toolbox padding-8 clearfix">
                                    <button class="btn btn-primary pull-right btn-sm btn-round" onclick="savesoasign()"><i class="ace-icon fa fa-check icon-on-right"></i><span class="bigger-110">&nbsp;Save</span>            
                                    </button>
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="modal_AddCharges" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md">   
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Select Charges</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <span class="input-icon" style="width: 100%;">
                            <input type="text" class="form-control" id="txtSearchAddCharges" title="Search" placeholder="Search">
                            <i class="ace-icon fa fa-search nav-search-icon"></i>
                        </span>
                    </div>
                    <div class=" col-xs-12 col-md-12 col-lg-12">
                        <div style="margin-top: 10px;" class="parent"> 
                            <table class="table table-bordered table-hover fixTable">
                                <thead>
                                    <tr>
                                        <th width="20%">Charge Code</th>
                                        <th width="40%">Charge Description</th>
                                        <th width="20%">Charge Type</th>
                                        <th width="20%">Rate</th>                   
                                    </tr>
                                </thead>
                                <tbody id="tblMCAddCharges"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger btn-sm btn-round" onclick="$('#modal_AddCharges').modal('hide');">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="modal_MonthQuantity" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Number of Months</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="txtOthChargesID">
                <input type="hidden" id="txtOthChargesDesc">
                <input type="hidden" id="txtOthChargesRate">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group col-xs-12 col-md-12 col-lg-12">
                            <input type="text" class="form-control" id="txtFPChargeCount" readonly style="background-color: white !important; text-align: right;">
                        </div>
                        <div class="row form-group" style="margin-top: 10px;margin-right: 5px;">
                            <div class="col-xs-4 col-md-4 col-lg-4">
                               <button class="btn btn-sm btn-block btn-app btn-light btn-round" onclick="fncbtnAddMnthCount('1', 'tbodyOtherCharges');">1</button>
                            </div>
                            <div class="col-xs-4 col-md-4 col-lg-4">
                               <button class="btn btn-sm btn-block btn-app btn-light btn-round" onclick="fncbtnAddMnthCount('2', 'tbodyOtherCharges');">2</button>
                            </div>
                            <div class="col-xs-4 col-md-4 col-lg-4">
                               <button class="btn btn-sm btn-block btn-app btn-light btn-round" onclick="fncbtnAddMnthCount('3', 'tbodyOtherCharges');">3</button>
                            </div>
                        </div>
                        <div class="row form-group" style="margin-right: 5px;">
                            <div class="col-xs-4 col-md-4 col-lg-4">
                               <button class="btn btn-sm btn-block btn-app btn-light btn-round" onclick="fncbtnAddMnthCount('4', 'tbodyOtherCharges');">4</button>
                            </div>
                            <div class="col-xs-4 col-md-4 col-lg-4">
                               <button class="btn btn-sm btn-block btn-app btn-light btn-round" onclick="fncbtnAddMnthCount('5', 'tbodyOtherCharges');">5</button>
                            </div>
                            <div class="col-xs-4 col-md-4 col-lg-4">
                               <button class="btn btn-sm btn-block btn-app btn-light btn-round" onclick="fncbtnAddMnthCount('6', 'tbodyOtherCharges');">6</button>
                            </div>
                        </div>
                        <div class="row form-group" style="margin-right: 5px;">
                            <div class="col-xs-4 col-md-4 col-lg-4">
                               <button class="btn btn-sm btn-block btn-app btn-light btn-round" onclick="fncbtnAddMnthCount('7', 'tbodyOtherCharges');">7</button>
                            </div>
                            <div class="col-xs-4 col-md-4 col-lg-4">
                               <button class="btn btn-sm btn-block btn-app btn-light btn-round" onclick="fncbtnAddMnthCount('8', 'tbodyOtherCharges');">8</button>
                            </div>
                            <div class="col-xs-4 col-md-4 col-lg-4">
                               <button class="btn btn-sm btn-block btn-app btn-light btn-round" onclick="fncbtnAddMnthCount('9', 'tbodyOtherCharges');">9</button>
                            </div>
                        </div>
                        <div class="row form-group" style="margin-right: 5px;">
                            <div class="col-xs-4 col-md-4 col-lg-4">
                               <button class="btn btn-sm btn-block btn-app btn-light btn-round">&nbsp;</button>
                            </div>
                            <div class="col-xs-4 col-md-4 col-lg-4">
                               <button class="btn btn-sm btn-block btn-app btn-light btn-round" onclick="fncbtnAddMnthCount('0', 'tbodyOtherCharges');">0</button>
                            </div>
                            <div class="col-xs-4 col-md-4 col-lg-4">
                               <button class="btn btn-sm btn-block btn-app btn-light btn-round" onclick="fncbtnAddMnthCount('C', 'tbodyOtherCharges');">C</button>
                            </div>
                        </div>
                    </div>
                </div>              
            </div>
            <div class="modal-footer">
                <div class="btn-group">
                    <button class="btn btn-sm btn-primary btn-round" onclick="fncAddOtherChargesrow();"><i class="fa fa-check"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdl_BillingCycle" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md">   
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="fncCloseNewCOPeriod();">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Cut-Off Period</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-2">
                        <div class="row form-group">
                            <div class="col-md-12">
                                Cut-off Year
                            </div>
                            <div class="col-md-12">
                                <select class="form-control" id="txtBCCutoffYear">
                                    <?php
                                        for($a = 5; $a >= 1; $a--){
                                            $timestamp = strtotime('-'. $a .' years');
                                            $forval1 = date('Y', $timestamp);
                                            ?>
                                                <option value="<?php echo $forval1; ?>"><?php echo $forval1; ?></option>
                                            <?php
                                        }
                                        ?>
                                            <option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
                                        <?php                       
                                        for($b = 1; $b <= 10; $b++){
                                            $timestamp2 = strtotime('+'. $b .' years');
                                            $forval2 = date('Y', $timestamp2);
                                            ?>
                                                <option value="<?php echo $forval2; ?>"><?php echo $forval2; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row form-group">
                            <div class="col-md-12">
                                Cut-off Date
                            </div>
                            <div class="col-md-12">
                                every <select class="" id="txtBCCutoffDate">
                                    <?php
                                        for($day = 1; $day <= 31; $day++){
                                            ?>
                                                <option value="<?php echo $day; ?>"><?php echo $day; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select> of the month
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 hide">
                        <div class="row form-group">
                            <div class="col-md-12">
                                Due Date
                            </div>
                            <div class="col-md-12">
                                every <select class="" id="txtBCCutoffDueDate">
                                    <?php
                                        for($day = 1; $day <= 31; $day++){
                                            ?>
                                                <option value="<?php echo $day; ?>"><?php echo $day; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select> of the month
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="row form-group">
                            <div class="col-md-12">&nbsp;</div>
                            <div class="col-md-12">
                                <button class="btn btn-sm btn-info btn-round" onclick="fncGenerateCOPeriod();">Generate</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="parent2">
                            <table class="table table-bordered table-striped fixTable">
                                <thead>
                                    <tr>
                                        <th style="width: 25%;">Period</th>
                                        <th style="width: 25%;">Start Date</th>
                                        <th style="width: 25%;">End Date</th>
                                        <th style="width: 25%;">Due Date</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyGenCutOff"></tbody>
                            </table>
                        </div>
                        <table class="tabledash_footer table" style="margin: 0px !important;">
                            <thead>
                                <tr>
                                    <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                        <font id="txtleadsentries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                        <input id="leadspages" type="hidden">
                                        <ul id="ulpaginationleads" class="pagination pull-right"></ul>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm btn-round" onclick="fncSaveCutOffPeriod();"><i class="ace-icon fa fa-check"></i>&nbsp;Save</button>
            </div>
        </div>
    </div>
</div> 

<div class="modal fade fade-scale" id="modal_maintenancesetup" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md">   
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="closemodal_maintenancesetup()">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Maintenance Setup</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="tabbable">
                            <ul class="nav nav-tabs" id="myTab">
                                <li class="active">
                                    <a data-toggle="tab" href="#tabWater" onclick="loadtbodyRateHistory('Water');">
                                        <i class="blue ace-icon fa fa-tint bigger-120"></i>
                                        Water
                                    </a>
                                </li>

                                <li>
                                    <a data-toggle="tab" href="#tabElec" onclick="loadtbodyRateHistory('Electric');">
                                        <i class="orange ace-icon fa fa-bolt bigger-120"></i>
                                        Electric
                                    </a>
                                </li>

                                <li>
                                    <a data-toggle="tab" href="#tabGas" onclick="loadtbodyRateHistory('Gas');">
                                        <i class="red ace-icon fa fa-fire bigger-120"></i>
                                        Gas
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div id="tabWater" class="tab-pane fade in active">
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <button class="btn btn-sm btn-primary btn-round" onclick="fncMinimumSetup('Water');">Minimum Setup</button>
                                            <button class="btn btn-sm btn-info btn-round pull-right" onclick="AddNewRate('Water')">Add Rate</button>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <div style="height: 50vh;">
                                                <table class="table table-bordered fixTable">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 25%;">Date Added</th>
                                                            <th style="width: 25%;">Effectivity Date</th>
                                                            <th style="width: 20%;">Rate</th>
                                                            <th style="width: 20%;">Admin Fee</th>
                                                            <th style="width: 10%;">Option</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyWaterHistory"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="tabElec" class="tab-pane fade">
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <button class="btn btn-sm btn-primary btn-round" onclick="fncMinimumSetup('Electric');">Minimum Setup</button>
                                            <button class="btn btn-sm btn-info btn-round pull-right" onclick="AddNewRate('Electric')">Add Rate</button>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <div style="height: 50vh;">
                                                <table class="table table-bordered fixTable">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 25%;">Date Added</th>
                                                            <th style="width: 25%;">Effectivity Date</th>
                                                            <th style="width: 20%;">Rate</th>
                                                            <th style="width: 20%;">Admin Fee</th>
                                                            <th style="width: 10%;">Option</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyElectricHistory"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="tabGas" class="tab-pane fade">
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <button class="btn btn-sm btn-primary btn-round" onclick="fncMinimumSetup('Gas');">Minimum Setup</button>
                                            <button class="btn btn-sm btn-info btn-round pull-right" onclick="AddNewRate('Gas')">Add Rate</button>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <div style="height: 50vh;">
                                                <table class="table table-bordered fixTable">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 25%;">Date Added</th>
                                                            <th style="width: 25%;">Effectivity Date</th>
                                                            <th style="width: 20%;">Rate</th>
                                                            <th style="width: 20%;">Admin Fee</th>
                                                            <th style="width: 10%;">Option</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyGasHistory"></tbody>
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
        </div>
    </div>
</div> 

<div class="modal fade fade-scale" id="modal_NewRate" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm">   
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="closemdlNewRate()">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;" id="txtSpecificRateHeader"></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="txtRateID">
                <div class="row form-group">
                    <div class="col-md-6">
                        <div class="row form-group">
                            <label class="col-md-12">Effectivity Date</label>
                            <div class="col-md-12">
                                <input type="text" class="date-picker form-control" id="txtNewRateEffDate">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row form-group">
                            <label class="col-md-12">Rate</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control numonly amount" id="txtNewRateCost" style="text-align: right;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-12">Admin Fee</label>
                    <div class="col-md-12">
                        <div class="radio">
                            <label>
                                <input type="radio" name="AdminFeeType" class="ace rdAdminFeeType" checked value="0" id="txtAdminFee1">
                                <span class="lbl"> Percentage</span>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="AdminFeeType" class="ace rdAdminFeeType" value="1" id="txtAdminFee2">
                                <span class="lbl"> Amount</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <span class="input-icon input-icon-right AdminFeeTypeHide1" style="width: 100%;">
                            <input type="text" id="txtNewAdminFee" class="form-control numonly form-field-icon-2" style="text-align: right;">
                            <i class="ace-icon fa fa-percent AdminFeeTypeHide2"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm btn-round" id="btnSaveNewRate"><i class="ace-icon fa fa-check"></i>&nbsp;Save</button>
            </div>
        </div>
    </div>
</div> 

<div class="modal fade fade-scale" id="modal_NewMinimumSetup" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm" style="width: 25%;">   
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;" id="hdrMinimumSetup"></h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="row form-group">
                            <div class="col-md-12">
                                <input type="text" class="form-control amount" id="txtMinimumSetup" onkeypress="return isNumberKey(event)" style="text-align: right;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm btn-round" id="btnSaveMinimumSetup"><i class="ace-icon fa fa-check"></i>&nbsp;Save</button>
            </div>
        </div>
    </div>
</div> 

<div class="modal fade fade-scale" id="modal_LeaseSignatories" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">   
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="fnc_XLeaseSignatories()">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Leasing Signatories</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="widget-box widget-color-blue3" id="tbdywidget_maintenance">
                            <div class="widget-header">
                                <h5 class="widget-title">Personnel</h5>
                                <i id="pangeditLS" class="pull-right glyphicon glyphicon-edit" onclick="EnableLeaseSignatoriesEdit()" style="color: white;margin: 10px;"></i>
                            </div>
                            <div class="widget-body">
                                <div class="widget-main">
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <input type="hidden" id="LeasingSignatoriesCount">
                                            <div id="div_LeaseSignatories"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-toolbox padding-8 clearfix">
                                <button type="button" class="btn spinbox-up btn-success DisMePlease2 btn-sm btn-round" onclick="AppendSignatories();">
                                    <i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i>
                                </button>
                                <button type="button" class="btn spinbox-up btn-danger DisMePlease2 btn-sm btn-round" onclick="RemoveSignatories();">
                                    <i class="icon-only  ace-icon ace-icon fa fa-minus bigger-110"></i>
                                </button>
                                <button class="btn btn-primary pull-right DisMePlease2 btn-sm btn-round" onclick="SaveLeasingSignatories()">
                                    <i class="ace-icon fa fa-check icon-on-right"></i>
                                    <span class="bigger-110">&nbsp;Save</span>            
                                </button>
                            </div>
                        </div>
                    </div>              
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="modal_BankInfo" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">   
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="closemodal_BankInfo()">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Bank Information</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="widget-box widget-color-blue3" id="tbdywidget_maintenance">
                            <div class="widget-header">
                                <h5 class="widget-title">Bank Information List</h5>
                                <i id="pangeditBankInfo" class="pull-right fa fa-edit bigger-140" onclick="EnableDisMePlease()" style="color: white;margin: 10px;"></i>
                            </div>
                            <div class="widget-body">
                                <div class="widget-main" style="max-height: 500px;overflow-y: scroll;overflow-x: hidden;">
                                    <input type="hidden" id="BankInfoRowCount">
                                    <div id="BankListInfo"></div>
                                </div>
                            </div>
                            <div class="widget-toolbox padding-8 clearfix">
                                <button type="button" class="btn spinbox-up btn-success DisMePlease btn-sm btn-round" onclick="AppendBankInfo();">
                                    <i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i>
                                </button>
                                <button type="button" class="btn spinbox-up btn-danger DisMePlease btn-sm btn-round" onclick="RemoveBankInfo();">
                                    <i class="icon-only  ace-icon ace-icon fa fa-minus bigger-110"></i>
                                </button>
                                <button class="btn btn-primary pull-right DisMePlease btn-sm" id="btnLeasingSignatories" onclick="SaveBankListinfo()">
                                    <i class="ace-icon fa fa-check icon-on-right"></i>
                                    <span class="bigger-110">&nbsp;Save</span>            
                                </button>
                            </div>
                        </div>
                    </div>              
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="modal_ImportMallConf" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" style="width: 60%;">   
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Import Mall Configuration</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5 hide">
                        <div class="input-daterange input-group">
                            <input type="text" class="form-control date-picker" value="<?php echo date('m/d/Y'); ?>" id="txtMCDateFrom" onchange="fncDisplayMCLogs();" onkeyup="fncDisplayMCLogs();">
                            <span class="input-group-addon">
                                <i class="fa fa-exchange"></i>
                            </span>
                            <input type="text" class="form-control date-picker" value="<?php echo date('m/d/Y'); ?>" id="txtMCDateTo" onchange="fncDisplayMCLogs();" onkeyup="fncDisplayMCLogs();">
                        </div>
                    </div>
                    <div class="col-md-3 pull-right divImportHome">
                        <a href="#" class="btn btn-round btn-sm btn-info btn-block" id="btnDLTemplate"><i class="fa fa-download"></i>&nbsp;Download Template</a>
                    </div>
                    <div class="col-md-3 pull-right divImportHome">
                        <button class="btn btn-round btn-sm btn-warning btn-block" onclick="fncImportTemplate();"><i class="fa fa-upload"></i>&nbsp;Upload File</button>
                    </div>
                    <div class="col-md-3 pull-right divImportTab">
                        <button class="btn btn-round btn-sm btn-danger btn-block" onclick="fncCancelImport();">Cancel</button>
                    </div>
                    <div class="col-md-3 pull-right divImportTab">
                       <button class="btn btn-round btn-sm btn-primary btn-block" onclick="fncImportGo();">Import</button>
                    </div>
                    <div class="col-md-3 pull-right divImportTab">
                        <form name="frmImportExcel" id="frmImportExcel" class="frmImportExcel">
                            <input id="txtImportedFile" name="txtImportedFile" class="form-control UserImage" type="file">
                            <input type="hidden" id="txtImportMallID" name="txtImportMallID">
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="margin-top: 10px;">
                        <div class="parent">
                            <table class="table table-bordered table-striped fixTable">
                                <thead>
                                    <tr>
                                        <th style="width: 25%;">Update Date / Time</th>
                                        <th style="width: 60%;">User</th>
                                        <th style="width: 15%;">Uploaded File</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyMCLogs"></tbody>
                            </table>
                        </div>
                        <table class="tabledash_footer table" style="margin: 0px !important;">
                            <thead>
                                <tr>
                                    <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                        <font id="txtleadsentries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                        <input id="leadspages" type="hidden">
                                        <ul id="ulpaginationleads" class="pagination pull-right"></ul>
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

<div class="modal fade fade-scale" id="modal_leasingsetup" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">   
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="closemodal_leasingsetup()">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Leasing Setup</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="widget-box widget-color-green" id="tbdywidget_leasingupb">
                                    <div class="widget-header">
                                        <h5 class="widget-title">Unit Price Breakdown</h5>
                                        <i id="pangedit5" class="pull-right glyphicon glyphicon-edit" onclick="call5()" style="color: white;margin: 10px;"></i>
                                    </div>
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <div class="row form-group">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <div class="col-xs-4">
                                                            Type of Reservation Fee
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" class="ace chkreservationtype" name="chkreservationtype" value="Amount">
                                                                    <span class="lbl">&nbsp;&nbsp;&nbsp;Amount</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" class="ace chkreservationtype" name="chkreservationtype" value="Percent">
                                                                    <span class="lbl">&nbsp;&nbsp;&nbsp;Percent</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-xs-5">
                                                            Reservation Fee
                                                        </div>
                                                        <div class="col-xs-7">
                                                            <input type="text" class="form-control numonly" id="txtupbreservationfee" style="text-align: right;" placeholder="%">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-xs-5">
                                                            Spot Payment
                                                        </div>
                                                        <div class="col-xs-7">
                                                            <input type="text" class="form-control numonly" id="txtupbspot" style="text-align: right;" placeholder="%">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-xs-5">
                                                            Down Payment
                                                        </div>
                                                        <div class="col-xs-7">
                                                            <input type="text" class="form-control numonly" id="txtupbdown" style="text-align: right;" placeholder="%">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-xs-5">
                                                            Balance
                                                        </div>
                                                        <div class="col-xs-7">
                                                            <input type="text" class="form-control numonly" id="txtupbbal" style="text-align: right;" placeholder="%">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <div class="col-xs-4">
                                                            Type of Retention Fee
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" class="ace chkretentiontype" name="chkretentiontype" value="Amount">
                                                                    <span class="lbl">&nbsp;&nbsp;&nbsp;Amount</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" class="ace chkretentiontype" name="chkretentiontype" value="Percent">
                                                                    <span class="lbl">&nbsp;&nbsp;&nbsp;Percent</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-xs-5">
                                                            Retention Fee
                                                        </div>
                                                        <div class="col-xs-7">
                                                            <input type="text" class="form-control numonly" id="txtupbretentionfee" style="text-align: right;" placeholder="%">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-xs-5">
                                                            Promo Discount
                                                        </div>
                                                        <div class="col-xs-7">
                                                            <input type="text" class="form-control numonly" id="txtldpd" style="text-align: right;" placeholder="%">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-xs-5">
                                                            Company Discount
                                                        </div>
                                                        <div class="col-xs-7">
                                                            <input type="text" class="form-control numonly" id="txtldcd" style="text-align: right;" placeholder="%">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-xs-5">
                                                            Standard Discount
                                                        </div>
                                                        <div class="col-xs-7">
                                                            <input type="text" class="form-control numonly" id="txtldsd" style="text-align: right;" placeholder="%">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="widget-toolbox padding-8 clearfix">
                                        <button class="btn btn-sm btn-success pull-right btn-round" onclick="saveUPB()">
                                            <i class="ace-icon fa fa-check icon-on-right"></i>
                                            <span class="bigger-110">&nbsp;Save</span>            
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="widget-box widget-color-green" id="tbdywidget_leasingothercharges">
                                    <div class="widget-header">
                                        <h5 class="widget-title">Other Charges</h5>
                                        <i id="pangedit7" class="pull-right glyphicon glyphicon-edit" onclick="call7()" style="color: white;margin: 10px;"></i>
                                    </div>
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <div class="row form-group">
                                                <div class="col-md-4">
                                                    <div class="form-group row">
                                                        <div class="col-xs-6">
                                                            Registration Fee
                                                        </div>
                                                        <div class="col-xs-5">
                                                            <input type="text" class="form-control numonly" id="txtocrf" style="text-align: right;" placeholder="%">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-xs-6">
                                                            Documentary Tax
                                                        </div>
                                                        <div class="col-xs-5">
                                                            <input type="text" class="form-control numonly" id="txtocdt" style="text-align: right;" placeholder="%">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row">
                                                        <div class="col-xs-6">
                                                            Transfer Tax
                                                        </div>
                                                        <div class="col-xs-5">
                                                            <input type="text" class="form-control numonly" id="txtoctt" style="text-align: right;" placeholder="%">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-xs-6">
                                                            Legal Fee
                                                        </div>
                                                        <div class="col-xs-5">
                                                            <input type="text" class="form-control numonly" id="txtoclf" style="text-align: right;" placeholder="%">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row">
                                                        <div class="col-xs-6">
                                                            Water /  Electric Connection
                                                        </div>
                                                        <div class="col-xs-5">
                                                            <input type="text" class="form-control numonly" id="txtocwec" style="text-align: right;" placeholder="%">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-xs-6">
                                                            Miscellaneous Fee
                                                        </div>
                                                        <div class="col-xs-5">
                                                            <input type="text" class="form-control numonly" id="txtocmf" style="text-align: right;" placeholder="%">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-toolbox padding-8 clearfix">
                                        <button class="btn btn-sm btn-success pull-right btn-round" onclick="saveothercharges()">
                                            <i class="ace-icon fa fa-check icon-on-right"></i>
                                            <span class="bigger-110">&nbsp;Save</span>            
                                        </button>
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

<?php include("script.php"); ?>