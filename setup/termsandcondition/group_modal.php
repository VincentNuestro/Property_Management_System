<!-- ============ MODAL NewGroup ============= -->
<div class="modal fade fade-scale" id="modal_newgroup" role="dialog" area-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Terms & Condition</h4>
                <input type="hidden" class="txtup" id="txttac" name="">
            </div>
            <div class="modal-body"  id="modal-body-group">
                <div class="container-fluid">
                    <div class="row form-group">
                        <div class="col-md-3 col-xs-12">
                            Group:
                        </div>
                        <div class="col-md-8 col-xs-12">
                            <select id="groupdd" class="form-control required"></select>
                        </div>
                            <button onclick="loadmodal_addgroup()" id="addgroup" class="col-md-1 btn spinbox-up btn-sm btn-success pull-right btn-round"><span class="fa fa-plus"></span></button>  
                    </div> 
                    <div class="row form-group">
                        <div class="col-md-3 col-xs-12">
                            Terms:
                        </div>
                        <div class="col-md-9 col-xs-12">
                            <input type="text" id="txttac_terms" name="" class="form-control required txttac" placeholder="Term Name">
                        </div>                     
                    </div> 
                    <div class="row form-group">
                        <div class="col-md-3 col-xs-12">
                            Condition:
                        </div>
                        <div class="col-md-9 col-xs-12">
                            <textarea class="width-100 txttac required" style="min-height: 100px;" id="txttac_condition" placeholder="Conditions"></textarea>
                        </div>
                    </div>
                </div>
            </div>  
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm btn-round" onclick="saveterms()"><i class="ace-icon fa fa-check"></i>&nbsp;Save</button>
            </div>                                     
        </div>
    </div>
</div>

<!-- ============ MODAL ADD GROUP ============= -->
<div class="modal fade fade-scale" id="modal_addgroup" role="dialog" area-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="unloadmodal_addgroup()">&times;</button>
                <h4 class="modal-title"  style="font-size: 18px;">Terms & Condition</h4>
                <input type="hidden" class="txttac" id="txttac" name="">
            </div>
            <div class="modal-body"  id="modal-body-group">
                <div class="container-fluid">
                    <div class="row form-group">
                        <div class="col-md-3 col-xs-12">
                            Group Name:
                        </div>
                        <div class="col-md-9 col-xs-12">
                            <input type="text" id="txttac_group" name="" class="form-control txttac" placeholder="Group Name">
                        </div> 
                    </div>
                </div>                                       
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm btn-round" onclick="savegroup()"><i class="ace-icon fa fa-check"></i>&nbsp;Save</button>
            </div>
        </div>
    </div>
</div>

<!-- ============ MODAL EDIT Group ============= -->
<div class="modal fade fade-scale" id="modal_editgroup" role="dialog" area-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="preloadModal_editgroup"></div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="unloadmodal_editgroup()">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Terms & Condition</h4>
                <input type="hidden" class="txttac" id="txttac" name="">
            </div>
            <div class="modal-body"  id="modal-body-group">
                <div class="container-fluid">
                    <div class="row form-group">
                        <div class="col-md-3 col-xs-12">
                            Group:
                        </div>
                        <div class="col-md-9 col-xs-12">
                            <input type="text" id="groupdd2" class="form-control txtup erequired" placeholder="Group Name">
                        </div>  
                    </div> 
                    <div class="row form-group">
                        <div class="col-md-3 col-xs-12">
                            Terms:
                        </div>
                        <div class="col-md-9 col-xs-12">
                            <input type="text" id="update_terms" name="" class="form-control erequired txtup" placeholder="Term Name">
                        </div>                     
                    </div> 
                    <div class="row form-group">
                        <div class="col-md-3 col-xs-12">
                            Condition:
                        </div>
                        <div class="col-md-9 col-xs-12">
                            <textarea class="width-100 txtup erequired" style="min-height: 100px;" id="update_condition" placeholder="Conditions"></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 col-xs-12">
                            Status:
                        </div>
                        <div class="col-md-3 col-xs-12">
                            <div class="radio">
                                <label>
                                    <input name="stats" type="radio" class="stats ace" id="1" value="1">
                                    <span class="lbl" style="color: #666;">&nbsp;&nbsp;Active</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-12">
                            <div class="radio">
                                <label>
                                    <input name="stats" type="radio" class="stats ace" id="0" value="0">
                                    <span class="lbl" style="color: #666;">&nbsp;&nbsp;Inactive</span>
                                </label>
                            </div>
                        </div>
                    </div>                
                </div>
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm btn-round" onclick="updategroup()"><i class="ace-icon fa fa-check"></i>&nbsp;Update</button>
            </div>
        </div>
    </div>
</div>