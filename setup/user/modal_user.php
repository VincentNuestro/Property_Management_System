<style>
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
    .myupload input[type="file"]{ 
        opacity: 0; 
    }

    .card {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: 0.25rem;
    }

    .card > hr {
        margin-right: 0;
        margin-left: 0;
    }

    .card > .list-group:first-child .list-group-item:first-child {
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
    }

    .card > .list-group:last-child .list-group-item:last-child {
        border-bottom-right-radius: 0.25rem;
        border-bottom-left-radius: 0.25rem;
    }

    .card-body {
        -webkit-box-flex: 1;
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        padding: 1.25rem;
    }

    .card-title {
        margin-bottom: 0.75rem;
    }

    .card-subtitle {
        margin-top: -0.375rem;
        margin-bottom: 0;
    }

    .card-text:last-child {
        margin-bottom: 0;
    }

    .card-link:hover {
        text-decoration: none;
    }

    .card-link + .card-link {
        margin-left: 1.25rem;
    }

    .card-header {
        padding: 0.75rem 1.25rem;
        margin-bottom: 0;
        background-color: rgba(0, 0, 0, 0.03);
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }

    .card-header:first-child {
        border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
    }

    .card-header + .list-group .list-group-item:first-child {
        border-top: 0;
    }

    .card-footer {
        padding: 0.75rem 1.25rem;
        background-color: rgba(0, 0, 0, 0.03);
        border-top: 1px solid rgba(0, 0, 0, 0.125);
    }

    .card-footer:last-child {
        border-radius: 0 0 calc(0.25rem - 1px) calc(0.25rem - 1px);
    }

    .card-header-tabs {
        margin-right: -0.625rem;
        margin-bottom: -0.75rem;
        margin-left: -0.625rem;
        border-bottom: 0;
    }

    .card-header-pills {
        margin-right: -0.625rem;
        margin-left: -0.625rem;
    }

    .card-img-overlay {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        padding: 1.25rem;
    }

    .card-img {
        width: 100%;
        border-radius: calc(0.25rem - 1px);
    }

    .card-img-top {
        width: 100%;
        border-top-left-radius: calc(0.25rem - 1px);
        border-top-right-radius: calc(0.25rem - 1px);
    }

    .card-img-bottom {
        width: 100%;
        border-bottom-right-radius: calc(0.25rem - 1px);
        border-bottom-left-radius: calc(0.25rem - 1px);
    }

    .card-deck {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
    }

    .card-deck .card {
        margin-bottom: 15px;
    }

    @media (min-width: 576px) {
        .card-deck {
            -webkit-box-orient: horizontal;
            -webkit-box-direction: normal;
            -ms-flex-flow: row wrap;
            flex-flow: row wrap;
            margin-right: -15px;
            margin-left: -15px;
        }
        .card-deck .card {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-flex: 1;
            -ms-flex: 1 0 0%;
            flex: 1 0 0%;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            margin-right: 15px;
            margin-bottom: 0;
            margin-left: 15px;
        }
    }

    .card-group {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
    }

    .card-group > .card {
        margin-bottom: 15px;
    }

    @media (min-width: 576px) {
        .card-group {
            -webkit-box-orient: horizontal;
            -webkit-box-direction: normal;
            -ms-flex-flow: row wrap;
            flex-flow: row wrap;
        }

        .card-group > .card {
            -webkit-box-flex: 1;
            -ms-flex: 1 0 0%;
            flex: 1 0 0%;
            margin-bottom: 0;
        }

        .card-group > .card + .card {
            margin-left: 0;
            border-left: 0;
        }

        .card-group > .card:first-child {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .card-group > .card:first-child .card-img-top,
        .card-group > .card:first-child .card-header {
            border-top-right-radius: 0;
        }

        .card-group > .card:first-child .card-img-bottom,
        .card-group > .card:first-child .card-footer {
            border-bottom-right-radius: 0;
        }

        .card-group > .card:last-child {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .card-group > .card:last-child .card-img-top,
        .card-group > .card:last-child .card-header {
            border-top-left-radius: 0;
        }

        .card-group > .card:last-child .card-img-bottom,
        .card-group > .card:last-child .card-footer {
            border-bottom-left-radius: 0;
        }

        .card-group > .card:only-child {
            border-radius: 0.25rem;
        }

        .card-group > .card:only-child .card-img-top,
        .card-group > .card:only-child .card-header {
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
        }

        .card-group > .card:only-child .card-img-bottom,
        .card-group > .card:only-child .card-footer {
            border-bottom-right-radius: 0.25rem;
            border-bottom-left-radius: 0.25rem;
        }

        .card-group > .card:not(:first-child):not(:last-child):not(:only-child) {
            border-radius: 0;
        }

        .card-group > .card:not(:first-child):not(:last-child):not(:only-child) .card-img-top,
        .card-group > .card:not(:first-child):not(:last-child):not(:only-child) .card-img-bottom,
        .card-group > .card:not(:first-child):not(:last-child):not(:only-child) .card-header,
        .card-group > .card:not(:first-child):not(:last-child):not(:only-child) .card-footer {
            border-radius: 0;
        }

    }

    .card-columns .card {
        margin-bottom: 0.75rem;
    }

    @media (min-width: 576px) {
        .card-columns {
            -webkit-column-count: 4;
            -moz-column-count: 4;
            column-count: 4;
            -webkit-column-gap: 1.25rem;
            -moz-column-gap: 1.25rem;
            column-gap: 1.25rem;
        }

        .card-columns .card {
            display: inline-block;
            width: 100%;
        }
    }
</style>
<div class="modal fade fade-scale" role="dialog" id="modal_newuser" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div id="preLoadMdlUser"></div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="clearuser()">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;" id="modalheader"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row form-group">
                            <div class="col-md-12 userfields">
                                <div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
                                    <div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
                                        <div class="widget-header"> 
                                            <h4 class="widget-title">User Information</h4>
                                        </div>
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row well">
                                                    <div class="row form-group">
                                                        <div class="col-md-6 pull-right">
                                                            <div class="row form-group">
                                                                <div class="col-md-12 pull-right">
                                                                    <div class="image">
                                                                        <img style="border: 2px solid #bdc3c7;width: 100%;margin-bottom: 8px;height: 165px" class='img-thumbnail form-control' id="txtimage" src='assets/images/noimage5.png'/>
                                                                    </div>
                                                                    <form method="post" action="#" enctype="multipart/form-data" id="saveuser">
                                                                        <input type="file" class="UserImage disableifheader" name="txtfile" id="txtfile" onchange="showimgggggg();" accept="image/*">
                                                                        <input type="hidden" id="txtuserid" name="txtuserid">
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row form-group">
                                                                <label class="col-md-12">First Name <span class="hideifheader" style="color: red;">*</span></label>
                                                                <div class="col-md-12">
                                                                    <input type="text" style="text-transform: capitalize;background-color: white !important;" class="form-control disableifheader txtUserReq" id="txtfirstname">
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <label class="col-md-12">Middle Name <span class="hideifheader" style="color: red;">*</span></label>
                                                                <div class="col-md-12">
                                                                    <input type="text" style="text-transform: capitalize;background-color: white !important;" class="form-control disableifheader txtUserReq" id="txtmiddlename">
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <label class="col-md-12">Last Name <span class="hideifheader" style="color: red;">*</span></label>
                                                                <div class="col-md-12">
                                                                    <input type="text" style="text-transform: capitalize;background-color: white !important;" class="form-control disableifheader txtUserReq" id="txtlastname">
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <label class="col-md-12">Gender</label>
                                                                <div class="col-md-12">
                                                                    <select class="form-control searchy_select" id="txtGender" style="width: 100%;">
                                                                        <option value="Male">Male</option>
                                                                        <option value="Female">Female</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <label class="col-md-12">Contact Number <span class="hideifheader" style="color: red;">*</span></label>
                                                                <div class="col-md-12">
                                                                    <input type="text" class="form-control disableifheader input-mask-phone txtUserReq" id="txtcontactnumber" style="background-color: white !important;">
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <label class="col-md-12">E-Mail <span class="hideifheader" style="color: red;">*</span></label>
                                                                <div class="col-md-12">
                                                                    <input type="text" class="form-control disableifheader email-addressssssss txtUserReq" id="txtemailaddress" style="background-color: white !important;"><span class="errohere txtemailaddress" style="color: red;">
                                                                </div>
                                                            </div>                                                
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row form-group">
                                                                <label class="col-md-12">Process Owner <span class="hideifheader disisporuser" style="color: red;">*</span></label>
                                                                <div class="col-md-12">
                                                                    <div class="input-group">
                                                                        <select class="form-control searchy_select" id="txtProcessOwner" style="width: 100%;"></select>
                                                                        <span class="input-group-btn">
                                                                            <button type="button" class="btn spinbox-up btn-sm btn-success" title="Click here to browse store profiles" onclick="fncAddProcessOwner();"><span class="icon-only ace-icon fa fa-plus bigger-110"></span></button>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <label class="col-md-12">Username <span class="hideifheader disisporuser" style="color: red;">*</span></label>
                                                                <div class="col-md-12">
                                                                    <input type="text" class="form-control disableifheader txtUserReq" id="txtusername" style="background-color: white !important;" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <label class="col-md-12">Password <span class="hideifheader disisporuser" style="color: red;">*</span></label>
                                                                <div class="col-md-12">
                                                                    <input type="password" class="form-control disableifheader txtUserReq" id="txtpassword" style="background-color: white !important;">
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

                             <div class="col-md-12 userfields">
                                <div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
                                    <div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
                                        <div class="widget-header"> 
                                            <h4 class="widget-title">User Access Information</h4>
                                        </div>
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row well">
                                                    <div class="row form-group">
                                                        <div class="col-md-6">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Select <label class="txtSysBuilding"></label> Access <span class="hideifheader" style="color: red;">*</span></label>
                                                                        <div class="col-md-12">
                                                                            <ol class="dd-list" id="olMallList"></ol>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-xs-12">
                                                            <div class="row form-group hide">
                                                                <label class="col-md-5">User type <span class="hideifheader" style="color: red;">*</span></label>
                                                                <div class="col-md-7">
                                                                    <div class="radio">
                                                                        <label>
                                                                            <input name="txtUserType" type="radio" class="ace rdUserType disableifheader" value="Admin">
                                                                            <span class="lbl" onclick="fncChangeUserType('Admin');">&nbsp;&nbsp;Admin</span>
                                                                        </label>
                                                                        <label>
                                                                            <input name="txtUserType" type="radio" class="ace rdUserType disableifheader" value="User" checked onclick="fncChangeUserType('User');">
                                                                            <span class="lbl" style="padding-left: 5px;">&nbsp;&nbsp;User</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <label class="col-md-12">Group Roles <span class="hideifheader" style="color: red;">*</span></label>
                                                                <div class="col-md-12">
                                                                    <select class="form-control disableifheader txtUserReq" onfocus='this.size=10;' onblur='this.size=1;' onchange='this.size=1; this.blur();' id="txtgroupaccess" style="background-color: white !important;"></select>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <label class="col-md-12">Hierarchy Code </label>
                                                                <div class="col-md-12">
                                                                    <select class="form-control disableifheader" onfocus='this.size=10;' onblur='this.size=1;' onchange='this.size=1; this.blur();' id="txthiearchycodex" style="background-color: white !important;"></select>
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
                </div>
            </div>
            <div class="modal-footer">
                <?php 
                    $getAccess = mysql_num_rows(mysql_query("SELECT id FROM tblref_usergroupaccess WHERE moduletab = 'userandaccessibility' AND groupid = '". $_SESSION['MMS-Access'] ."' AND functionid = 'changeuserstat';", $connection));
                    $isAdminUser = mysql_fetch_array(mysql_query("SELECT isAdmin FROM tbluser WHERE userid = '". $_SESSION['MMS-UserID'] ."'", $connection));
                ?>
                <?php if ($isAdminUser['isAdmin'] == 1){ ?>
                    <button class="btn btn-danger btn-sm btnSetStatInactive hideifheader btn-round" onclick="fncChangeUserStatus('0', 'inactive')">Set as Inactive</button>
                    <button class="btn btn-success btn-sm btnSetStatActive hideifheader btn-round" onclick="fncChangeUserStatus('1', 'active')">Set as Active</button>
                <?php }else{ ?>
                    <?php if ($getAccess >= 1){ ?>
                        <button class="btn btn-danger btn-sm btnSetStatInactive hideifheader btn-round" onclick="fncChangeUserStatus('0', 'inactive')">Set as Inactive</button>
                        <button class="btn btn-success btn-sm btnSetStatActive hideifheader btn-round" onclick="fncChangeUserStatus('1', 'active')">Set as Active</button>
                    <?php } ?>
                <?php } ?>
                <button class="btn btn-primary hideifheader btn-sm btn-round" onclick="fncSaveUser();"><span class="fa fa-check"></span>&nbsp;&nbsp;Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdlProcessOwner" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div id="preloadmodal_loadcompany"></div>
            <div class="modal-header" style="background-color: #438EB9;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Add Process Owner</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <label class="col-md-12">Process Owner Code</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" id="txtPOCode">
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-12">Process Owner Description</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" id="txtPODesc">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-primary btn-round" onclick="fncSaveProcessOwner();"><i class="fa fa-check"></i>&nbsp;Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" role="dialog" id="modalpermissionlist" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Add User Role</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row form-group" style="margin-bottom: 0px;">
                        <div class="col-md-5" style="padding-bottom: 5px;">
                           <span class="input-icon" style="width: 100%;">
                                <input type="text" class="form-control" id="txtsearchusergroup" title="Search" placeholder="Search">
                                <i class="ace-icon fa fa-search nav-search-icon"></i>
                            </span>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover">
                                <thead>
                                   <tr>
                                      <th style="width: 20%;">User Role ID</th>
                                      <th style="width: 80%;">User Role</th>
                                   </tr>
                                </thead>
                                <tbody id="tblgrouplist"></tbody>
                                <tbody>
                                  <tr>
                                    <td colspan="4">
                                        <input type="hidden" id="bilang">
                                        <button onclick="pickA('first')" class="btn btn-info btn-sm  btn-useraccess btn-useraccess-1 btn-round"><span class="glyphicon glyphicon-fast-backward"></span></button>
                                        <button onclick="pickA('prev')" class="btn btn-info btn-sm  btn-useraccess btn-useraccess-1 btn-round"><span class="glyphicon glyphicon-backward"></span></button>
                                        <button onclick="pickA('next')" class="btn btn-info btn-sm btn-useraccess btn-useraccess-2 btn-round"><span class="glyphicon glyphicon-forward"></span></button>
                                        <button onclick="pickA('last')" class="btn btn-info btn-sm btn-useraccess btn-useraccess-2 btn-round"><span class="glyphicon glyphicon-fast-forward"></span></button>
                                    </td>
                                  </tr>
                              </tbody>
                           </table>
                        </div>
                    </div>
                    <div class="row form-group" style="margin-left: 50px;margin-right: 50px;">
                        <div class="col-sm-3" style="margin-top: 10px;">
                            User Role
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control txtGroup" id="txtGroupName" readonly>
                            <input type="hidden" id="txtHGroupID">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div id="btn-defaultdisplay">
                    <button class="btn btn-warning btn-sm pull-left hide isadmin select-modifyuseraccess btn-round" onclick="showmodalpermissionpergroup();"><span class="fa fa-unlock"></span>&nbsp;&nbsp;User Role Access</button>
                    <button class="btn btn-primary btn-sm hide isadmin select-addusergroup btn-round" onclick="clickadd();"><span class="fa fa-plus"></span>&nbsp;&nbsp;Add</button>
                    <button class="btn btn-success btn-sm hide isadmin select-editusergroup btn-round" onclick="clickedit();"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Edit</button>
                    <button class="btn btn-danger btn-sm hide isadmin select-deleteusergroup btn-round" onclick="deletegroupname();"><span class="glyphicon glyphicon-trash"></span>&nbsp;&nbsp;Delete</button>
                    <button class="btn btn-danger btn-sm btn-round" onclick="hidepermissionmodal();"><span class="fa fa-remove"></span>&nbsp;&nbsp;Close</button>
                </div>

                <div id="btn-addgroup" style="display: none;">
                    <button class="btn btn-sm btn-primary btn-round" onclick="saveaddgroupname();"><span class="fa fa-check"></span> Save</button>
                    <button class="btn btn-sm btn-danger btn-round" onclick="canceladd();"><span class="fa fa-remove"></span> Cancel</button>
                </div>

                <div id="btn-editgroup" style="display: none;">
                    <button class="btn btn-sm btn-primary btn-round" onclick="saveditgroupname();"><span class="fa fa-check"></span> Save</button>
                    <button class="btn btn-sm btn-danger btn-round" onclick="canceledit();"><span class="fa fa-remove"></span> Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdlUserAccess" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" style="width: 95%;">  
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="$('#mdlUserAccess').('hide');">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Set User Group Access</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget-box widget-color-blue2 light-border ui-sortable-handle" id="widget-box-6">
                            <div class="widget-header">
                                <h5 class="widget-title" style="background-color: #438EB9 !important;" id="hdrUserGroupAccess"></h5>
                                <div class="widget-toolbar">
                                    <label>
                                        <input type="checkbox" class="chkUserSelectAll ace" onclick="fncSelectAllUserAccess()">
                                        <span class="lbl">&nbsp;Select All</span>
                                    </label>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main padding-6">
                                    <div class="alert alert-info"> 
                                        <div class="row">

                                            <div class="col-md-4">
                                                <div  class="accordion-style1 panel-group accordionmodaluser">
                                        
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle aacordheader"  data-parent="#accordion" >
                                                                   <label class="hoverx" data-toggle="collapse" href="#uadashboad" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110"   ></i>
                                                                        <b>&nbsp;Dashboard</b>   
                                                                   </label>  
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-dashboard" value="dashboard" id="dashboard" onclick="clickUAMj('dashboard');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse" id="uadashboad">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMdashboard" id="dashboard-viewdashboard" value="dashboard-viewdashboard">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Dashboard</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default hide">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#uprospect">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Prospects</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-prospects" value="prospects" id="prospects" onclick="clickUAMj('prospects');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="uprospect">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMprospects" id="leads-viewprospects" value="leads-viewprospects">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Prospects</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMprospects" id="leads-addprospects" value="leads-addprospects">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Add Prospects</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMprospects" id="leads-editprospects" value="leads-editprospects">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Edit Prospects</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMprospects" id="leads-deleteprospects" value="leads-deleteprospects">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Junk Prospects</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMprospects" id="leads-reinstateprospects" value="leads-reinstateprospects">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Reinstate Prospects</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMprospects" id="leads-viewlogsprospects" value="leads-viewlogsprospects">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Logs</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default hide">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#uawareness">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Awareness</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-awareness" value="awareness" id="awareness" onclick="clickUAMj('awareness');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse" id="uawareness">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMawareness" id="leads-viewawareness" value="leads-viewawareness">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Awareness</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMawareness" id="leads-addawareness" value="leads-addawareness">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Add Awareness</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMawareness" id="leads-editawareness" value="leads-editawareness">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Edit Awareness</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMawareness" id="leads-deleteawareness" value="leads-deleteawareness">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Delete Awareness</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMawareness" id="leads-viewlogsawareness" value="leads-viewlogsawareness">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Logs</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default hide">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#ureferral">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Referral</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-referral" value="referral" id="referral" onclick="clickUAMj('referral');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="ureferral">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreferral" id="leads-viewreferral" value="leads-viewreferral">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Referral</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreferral" id="leads-addreferral" value="leads-addreferral">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Add Referral</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreferral" id="leads-editreferral" value="leads-editreferral">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Edit Referral</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreferral" id="leads-deletereferral" value="leads-deletereferral">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Delete Referral</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreferral" id="leads-viewlogsreferral" value="leads-viewlogsreferral">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Logs</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default hide">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#udemo">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Demo</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-demo" value="demo" id="demo" onclick="clickUAMj('demo');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="udemo">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMdemo" id="leads-viewdemo" value="leads-viewdemo">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Demo</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMdemo" id="leads-adddemo" value="leads-adddemo">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Add Demo</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMdemo" id="leads-editdemo" value="leads-editdemo">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Edit Demo</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMdemo" id="leads-deletedemo" value="leads-deletedemo">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Delete Demo</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMdemo" id="leads-viewlogsdemo" value="leads-viewlogsdemo">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Logs</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default hide">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#uclosingmeeting">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Closing Meeting</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-closingmeeting" value="closingmeeting" id="closingmeeting" onclick="clickUAMj('closingmeeting');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="uclosingmeeting">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMclosingmeeting" id="leads-viewclosingmeeting" value="leads-viewclosingmeeting">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Closing Meeting</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMclosingmeeting" id="leads-addclosingmeeting" value="leads-addclosingmeeting">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Add Closing Meeting</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMclosingmeeting" id="leads-editclosingmeeting" value="leads-editclosingmeeting">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Edit Closing Meeting</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMclosingmeeting" id="leads-deleteclosingmeeting" value="leads-deleteclosingmeeting">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Delete Closing Meeting</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMclosingmeeting" id="leads-viewlogsclosingmeeting" value="leads-viewlogsclosingmeeting">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Logs</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default hide">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#ucontractsigning">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Contract Signing</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-contractsigning" value="vcontractsigning" id="contractsigning" onclick="clickUAMj('contractsigning');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="ucontractsigning">
                                                            <div class="panel-body">
                                                                 <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMcontractsigning" id="leads-viewcontractsigning" value="leads-viewcontractsigning">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Contract Signing</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMcontractsigning" id="leads-addcontractsigning" value="leads-addcontractsigning">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Add Contract Signing</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMcontractsigning" id="leads-editcontractsigning" value="leads-editcontractsigning">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Edit Contract Signing</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMcontractsigning" id="leads-deletecontractsigning" value="leads-deletecontractsigning">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Delete Contract Signing</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMcontractsigning" id="leads-viewlogscontractsigning" value="leads-viewlogscontractsigning">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Logs</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#uinquiry">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Inquiry</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-inquiry" value="inquiry" id="inquiry" onclick="clickUAMj('inquiry');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="uinquiry">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMinquiry" id="inquiry-viewinquiry" value="inquiry-viewinquiry">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Inquiry</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMinquiry" id="inquiry-addinquiry" value="inquiry-addinquiry">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Add Inquiry</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMinquiry" id="inquiry-editinquiry" value="inquiry-editinquiry">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Edit Inquiry</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMinquiry" id="inquiry-viewlogsinquiry" value="inquiry-viewlogsinquiry">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Logs</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMinquiry" id="inquiry-tenantinformation" value="inquiry-tenantinformation">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Tenant Information</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox hide">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMinquiry" id="inquiry-termsandconditions" value="inquiry-termsandconditions">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Terms and Conditions</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMinquiry" id="inquiry-remarks" value="inquiry-remarks">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Remarks</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMinquiry" id="inquiry-createevents" value="inquiry-createevents">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Create Events</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMinquiry" id="inquiry-viewevents" value="inquiry-viewevents">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Events</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default hide">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#uproposal">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Proposal</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-proposal" value="proposal" id="proposal" onclick="clickUAMj('proposal');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="uproposal">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMproposal" id="leads-viewproposal" value="leads-viewproposal">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Proposal</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMproposal" id="leads-addproposal" value="leads-addproposal">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Add Proposal</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMproposal" id="leads-editproposal" value="leads-editproposal">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Edit Proposal</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMproposal" id="leads-closeproposal" value="leads-closeproposal">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Close Proposal</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMproposal" id="leads-viewlogsproposal" value="leads-viewlogsproposal">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Logs</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#uleasingapplication">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Leasing Application</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-leasingapplication" value="leasingapplication" id="leasingapplication" onclick="clickUAMj('leasingapplication');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="uleasingapplication">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMleasingapplication" id="leasingapplication-viewapplicationlist" value="leasingapplication-viewapplicationlist">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Leasing Application List</span>
                                                                        </label>
                                                                    </div>
                                                                     <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMleasingapplication" id="leasingapplication-overridereq" value="leasingapplication-overridereq">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Override of Requirements</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMleasingapplication" id="leasingapplication-editapplication" value="leasingapplication-editapplication">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Edit Application</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMleasingapplication" id="leasingapplication-tenantinvreport" value="leasingapplication-tenantinvreport">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;<?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?> Investigation Report</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMleasingapplication" id="leasingapplication-tenantappapproval" value="leasingapplication-tenantappapproval">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;<?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?> Application Approval</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMleasingapplication" id="leasingapplication-printapplication" value="leasingapplication-printapplication">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Print Application</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMleasingapplication" id="leasingapplication-applicationviewlogs" value="leasingapplication-applicationviewlogs">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Logs</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMleasingapplication" id="leasingapplication-leaseproposal" value="leasingapplication-leaseproposal">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Lease Proposal</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMleasingapplication" id="leasingapplication-tenantinformation" value="leasingapplication-tenantinformation">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Tenant Information</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMleasingapplication" id="leasingapplication-billinginformation" value="leasingapplication-billinginformation">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Billing Information</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMleasingapplication" id="leasingapplication-leaseinformation" value="leasingapplication-leaseinformation">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Lease Information</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMleasingapplication" id="leasingapplication-paymentschedule" value="leasingapplication-paymentschedule">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Payment Schedule</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMleasingapplication" id="leasingapplication-charges" value="leasingapplication-charges">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Charges</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMleasingapplication" id="leasingapplication-requirementspermits" value="leasingapplication-requirementspermits">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Requirements and Permits</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox hide">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMleasingapplication" id="leasingapplication-termsandconditions" value="leasingapplication-termsandconditions">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Terms and Conditions</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMleasingapplication" id="leasingapplication-remarks" value="leasingapplication-remarks">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Remarks</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMleasingapplication" id="leasingapplication-viewevents" value="leasingapplication-viewevents">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Events</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#ureservation">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Reservation</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-reservation" value="reservation" id="reservation" onclick="clickUAMj('reservation');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="ureservation">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreservation" id="reservation-viewreservationlist" value="reservation-viewreservationlist">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Reservation List</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreservation" id="reservation-updateapplication" value="reservation-updateapplication">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Edit Application</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreservation" id="reservation-editapplication" value="reservation-editapplication">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Application</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreservation" id="reservation-createcontract" value="reservation-createcontract">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Create Contract</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreservation" id="reservation-approvereservation" value="reservation-approvereservation">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Edit Reservation</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreservation" id="reservation-occupyreservation" value="reservation-occupyreservation">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Occupy Unit</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreservation" id="reservation-cancelreservation" value="reservation-cancelreservation">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Cancel Reservation</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreservation" id="reservation-reinstatereservation" value="reservation-reinstatereservation">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Reinstate Reservation</span>
                                                                        </label>
                                                                    </div>
                                                                    <!-- <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreservation" id="reservation-printcontract" value="reservation-printcontract">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View & Print Contract</span>
                                                                        </label>
                                                                    </div> -->
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreservation" id="reservation-viewlogs" value="reservation-viewlogs">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Logs</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreservation" id="reservation-tenantinformation" value="reservation-tenantinformation">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Tenant Information</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreservation" id="reservation-billinginformation" value="reservation-billinginformation">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Billing Information</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreservation" id="reservation-leaseinformation" value="reservation-leaseinformation">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Lease Information</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreservation" id="reservation-paymentschedule" value="reservation-paymentschedule">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Payment Schedule</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreservation" id="reservation-charges" value="reservation-charges">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Charges</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreservation" id="reservation-requirementspermits" value="reservation-requirementspermits">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Requirements and Permits</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox hide">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreservation" id="reservation-termsandconditions" value="reservation-termsandconditions">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Terms and Conditions</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreservation" id="reservation-remarks" value="reservation-remarks">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Remarks</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreservation" id="reservation-viewevents" value="reservation-viewevents">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Events</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#utenantx">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;<?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?></b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-tenants" value="tenants" id="tenants" onclick="clickUAMj('tenants');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="utenantx">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenants" id="tenants-viewtenantlist" value="tenants-viewtenantlist">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View <?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?> List</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenants" id="tenants-createnewtenant" value="tenants-createnewtenant">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Create New <?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenants" id="tenants-evictenant" value="tenants-evictenant">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Evict <?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenants" id="tenants-renewcontract" value="tenants-renewcontract">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Renew Contract</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenants" id="tenants-endofcontract" value="tenants-endofcontract">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;End of Contract</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenants" id="tenants-uploaddocu" value="tenants-uploaddocu">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Viewing & Uploading of Documents</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenants" id="tenants-ViewModRent" value="tenants-ViewModRent">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Viewing of Payment Schedule</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenants" id="tenants-ModRent" value="tenants-ModRent">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Viewing of Modify Payment Schedule</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenants" id="tenants-viewpaymenthistory" value="tenants-viewpaymenthistory">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Viewing of Payment History</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenants" id="tenants-printsoa" value="tenants-printsoa">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View & Print Statement of Accounts</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenants" id="tenants-clearingofpdc" value="tenants-clearingofpdc">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Clearing of PDC</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenants" id="tenants-printcontract" value="tenants-printcontract">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View & Print Contract</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenants" id="tenants-maintenancehistory" value="tenants-maintenancehistory">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Maintenance History</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenants" id="tenants-viewmemo" value="tenants-viewmemo">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Memo</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenants" id="tenants-createcomplaints" value="tenants-createcomplaints">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Complaint</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenants" id="tenants-addcomplaint" value="tenants-addcomplaint">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Add Complaint</span>
                                                                        </label>
                                                                    </div>
                                                                    <?php if(SysLeaseSetup('softwaretype') != '5'){ ?>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenants" id="tenants-tenantsportal" value="tenants-tenantsportal">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Tenant Portal</span>
                                                                        </label>
                                                                    </div>                                                    
                                                                    <?php } ?>
                                                                    <!-- <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenants" id="tenants-constructionbond" value="tenants-constructionbond">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Construction Bond</span>
                                                                        </label>
                                                                    </div> -->
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenants" id="tenants-viewlogs" value="tenants-viewlogs">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Logs</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenants" id="tenants-viewevents" value="tenants-viewevents">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Events</span>
                                                                        </label>
                                                                    </div>

                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <?php if(SysLeaseSetup('softwaretype') != '5'){ ?>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#utenantportal">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;<?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?> Portal</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-tenantportal" value="tenantportal" id="tenantportal" onclick="clickUAMj('tenantportal');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="utenantportal">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenantportal" id="tenantportal-viewtenantportal" value="tenantportal-viewtenantportal">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View <?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?> Portal</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenantportal" id="tenantportal-filemanagement" value="tenantportal-filemanagement">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;File Management</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenantportal" id="tenantportal-salesReport" value="tenantportal-salesReport">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Daily Sales Report</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#utenantrequest">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;<?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?>'s Request</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-tenantrequest" value="tenantrequest" id="tenantrequest" onclick="clickUAMj('tenantrequest');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="utenantrequest">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenantrequest" id="tenantrequest-viewtenantrequest" value="tenantrequest-viewtenantrequest">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View <?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?>'s Request</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenantrequest" id="tenantrequest-newrequest" value="tenantrequest-newrequest">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;New Request</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenantrequest" id="tenantrequest-approverequest" value="tenantrequest-approverequest">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Approve Request</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenantrequest" id="tenantrequest-disapproverequest" value="tenantrequest-disapproverequest">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Disapprove Request</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenantrequest" id="tenantrequest-printtenantrequest" value="tenantrequest-printtenantrequest">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Print Request</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#ubilling">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Billing</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-billinglist" value="billinglist" id="billinglist" onclick="clickUAMj('billinglist');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="ubilling">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMbillinglist" id="billing-viewlisttransaction" value="billing-viewlisttransaction">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View List of Transaction</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMbillinglist" id="billing-fastposting" value="billing-fastposting">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Fast Posting</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMbillinglist" id="billing-enterpayment" value="billing-enterpayment">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Collection</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMbillinglist" id="billing-billingsoa" value="billing-billingsoa">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Billing</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMbillinglist" id="billing-cashieraudit" value="billing-cashieraudit">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Cashier's Audit</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMbillinglist" id="billing-vieworlist" value="billing-vieworlist">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View O.R List</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMbillinglist" id="billing-endofday" value="billing-endofday">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;End of Day</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#ulistofpenalty">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;List of Penalty</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-listofpenalty" value="listofpenalty" id="listofpenalty" onclick="clickUAMj('listofpenalty');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="ulistofpenalty">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMlistofpenalty" id="billing-viewlistofpenalty" value="billing-viewlistofpenalty">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View List of Penalty</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMlistofpenalty" id="billing-postpenalty" value="billing-postpenalty">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Post Penalty</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMlistofpenalty" id="billing-deletepenalty" value="billing-deletepenalty">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Delete Penalty</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#ulistofpdc">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;List of PDC</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-listofpdc" value="listofpdc" id="listofpdc" onclick="clickUAMj('listofpdc');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="ulistofpdc">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMlistofpdc" id="billing-viewlistofpdc" value="billing-viewlistofpdc">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View List of PDC</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMlistofpdc" id="billing-clearingofpdc" value="billing-clearingofpdc">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Clearing of PDC</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#umaintenance">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Maintenance</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-maintenancewo" value="maintenancewo" id="maintenancewo" onclick="clickUAMj('maintenancewo');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="umaintenance">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMmaintenancewo" id="maintenance-view2workorderlist" value="maintenance-view2workorderlist">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Work Order List</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMmaintenancewo" id="maintenance-view1createworkorder" value="maintenance-view1createworkorder">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Create Work Order</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMmaintenancewo" id="maintenance-resolveworkorder" value="maintenance-resolveworkorder">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Resolve Work Order</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMmaintenancewo" id="maintenance-cancelworkorder" value="maintenance-cancelworkorder">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Cancel Work Order</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMmaintenancewo" id="maintenance-postingofcharges" value="maintenance-postingofcharges">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Posting of Charges</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMmaintenancewo" id="maintenance-printworkorder" value="maintenance-printworkorder">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Print Work Order</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMmaintenancewo" id="metermanagement-metermanagement" value="metermanagement-metermanagement">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Meter Management</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#ucomplaints">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Maintenance - Complaints</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-mcomplaints" value="mcomplaints" id="mcomplaints" onclick="clickUAMj('mcomplaints');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="ucomplaints">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMmcomplaints" id="maintenance-view4listofcomplaints" value="maintenance-view4listofcomplaints">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View List of Complaint</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMmcomplaints" id="maintenance-createworkorderfromcomplaints" value="maintenance-createworkorderfromcomplaints">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Create Work Order From Complaints</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMmcomplaints" id="maintenance-printcomplaint" value="maintenance-printcomplaint">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Print Complaint Report</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>                                                    

                                                </div>
                                            </div>

                                            <!--  Second column  -->
                                            <div class="col-md-4">
                                                <div  class="accordion-style1 panel-group accordionmodaluser">

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#umaintenacebudget">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Maintenance Budget</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-maintenancebudget" value="maintenancebudget" id="maintenancebudget" onclick="clickUAMj('maintenancebudget');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="umaintenacebudget">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMmaintenancebudget" id="maintenance-view5maintenancebudget" value="maintenance-view5maintenancebudget">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Maintenance Budget</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMmaintenancebudget" id="maintenance-addmaintenancebudget" value="maintenance-addmaintenancebudget">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Add/Update Maintenance Budget</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#Complaints-complaints">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Complaints</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-complaints" value="complaints" id="complaints" onclick="clickUAMj('complaints');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse" id="Complaints-complaints">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMcomplaints" id="complaints-viewlistofcomplaints" value="complaints-viewlistofcomplaints">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View List of Complaint</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMcomplaints" id="complaints-addcomplaints" value="complaints-addcomplaints">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Add Complaint</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMcomplaints" id="complaints-printcomplaints" value="complaints-printcomplaints">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Print Complaint Report</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#uincidentreports">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Violations</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-incidentreports" value="incidentreports" id="incidentreports" onclick="clickUAMj('incidentreports');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="uincidentreports">
                                                            <div class="panel-body">
                                                               <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMincidentreports" id="complaints-viewlistofir" value="complaints-viewlistofir">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View List of Incident Reports</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMincidentreports" id="complaints-createir" value="complaints-createir">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Create Incident Report</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMincidentreports" id="complaints-resolveir" value="complaints-resolveir">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Resolve Incident Report</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMincidentreports" id="complaints-postirtobilling" value="complaints-postirtobilling">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Post to Billing</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMincidentreports" id="complaints-deleteir" value="complaints-deleteir">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Delete Incident Report</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMincidentreports" id="complaints-printir" value="complaints-printir">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Print Incident Report</span>
                                                                        </label>
                                                                    </div>
                                                                </p> 
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#ubaggagelogs">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Baggage Logs</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-baggagelogs" value="baggagelogs" id="baggagelogs" onclick="clickUAMj('baggagelogs');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="ubaggagelogs">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMbaggagelogs" id="baggagelogs-viewbaggagelogs" value="baggagelogs-viewbaggagelogs">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Baggage Logs</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMbaggagelogs" id="baggagelogs-deposititem" value="baggagelogs-deposititem">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Deposit Item</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMbaggagelogs" id="baggagelogs-claimitem" value="baggagelogs-claimitem">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Claim Item</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMbaggagelogs" id="baggagelogs-printbaggagelogs" value="baggagelogs-printbaggagelogs">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Print Baggage Logs</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#uvisitorlogs">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Visitor Logs</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-visitorlogs" value="visitorlogs" id="visitorlogs" onclick="clickUAMj('visitorlogs');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="uvisitorlogs">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMvisitorlogs" id="visitorlogs-viewvisitorlogs" value="visitorlogs-viewvisitorlogs">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Visitor Logs</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMvisitorlogs" id="visitorlogs-loginvisitor" value="visitorlogs-loginvisitor">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Log In Visitor</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMvisitorlogs" id="visitorlogs-logoutvisitor" value="visitorlogs-logoutvisitor">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Log Out Visitor</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMvisitorlogs" id="visitorlogs-printvisitorlogs" value="visitorlogs-printvisitorlogs">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Print Visitor Logs</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#ufilemonitoring">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;File Monitoring</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-filemonitoring" value="filemonitoring" id="filemonitoring" onclick="clickUAMj('filemonitoring');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="ufilemonitoring">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMfilemonitoring" id="filemonitoring-viewfilemonitoring" value="filemonitoring-viewfilemonitoring">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View File Monitoring</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMfilemonitoring" id="filemonitoring-uploadfiles" value="filemonitoring-uploadfiles">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Upload Files</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMfilemonitoring" id="filemonitoring-changesetup" value="filemonitoring-changesetup">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Change Setup</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMfilemonitoring" id="filemonitoring-fmpostpenalty" value="filemonitoring-fmpostpenalty">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Post Penalty</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#ufloorplan">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Floorplan</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-floorplan" value="floorplan" id="floorplan" onclick="clickUAMj('floorplan');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="ufloorplan">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMfloorplan" id="floorplan-setuploadfloorplan" value="floorplan-setuploadfloorplan">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Upload Floorplan</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMfloorplan" id="floorplan-seteditfloorplant" value="floorplan-seteditfloorplant">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Edit Floorplan</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMfloorplan" id="floorplan-setremovefloorplant" value="floorplan-setremovefloorplant">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Remove Floorplan</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMfloorplan" id="floorplan-setaddmarker" value="floorplan-setaddmarker">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Assign Unit/Add Marker</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMfloorplan" id="floorplan-setmodifymarker" value="floorplan-setmodifymarker">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Modify Unit/Marker</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMfloorplan" id="floorplan-setremovemarker" value="floorplan-setremovemarker">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Remove Unit/Marker</span>
                                                                        </label>
                                                                    </div>
                                                                    <!-- <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMfloorplan" id="floorplan-viewsettenant" value="floorplan-viewsettenant">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Unit Information</span>
                                                                        </label>
                                                                    </div> -->
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <?php if(SysLeaseSetup('softwaretype') != '5'){ ?>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#utenantsalesreport">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Tenant Sales Report</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-tenantsalesreports" value="tenantsalesreports" id="tenantsalesreports" onclick="clickUAMj('tenantsalesreports');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="utenantsalesreport">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenantsalesreports" id="reports-view1tenantsalesreport" value="reports-view1tenantsalesreport">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Tenant Sales Report</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#uleasingreport">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Leasing Report</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-leasingreports" value="leasingreports" id="leasingreports" onclick="clickUAMj('leasingreports');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="uleasingreport">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMleasingreports" id="reports-leasingreports" value="reports-leasingreports">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Leasing Report</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#uincedentreports">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Inquiry Reports</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-inquiryreports" value="inquiryreports" id="inquiryreports" onclick="clickUAMj('inquiryreports');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="uincedentreports">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMinquiryreports" id="reports-view2inquiryreports" value="reports-view2inquiryreports">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Inquiry Reports</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMinquiryreports" id="reports-printinquiryreports" value="reports-printinquiryreports">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Print Inquiry Reports</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#uapplicationreports">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Application Reports</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-applicationreports" value="applicationreports" id="applicationreports" onclick="clickUAMj('applicationreports');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="uapplicationreports">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMapplicationreports" id="reports-view3applicationreports" value="reports-view3applicationreports">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Application Reports</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMapplicationreports" id="reports-printapplicationreports" value="reports-printapplicationreports">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Print Application Reports</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#uunithistory">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Unit History</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-unithistory" value="unithistory" id="unithistory" onclick="clickUAMj('unithistory');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="uunithistory">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMunithistory" id="reports-view41setunithistory" value="reports-view41setunithistory">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View SET Unit History</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMunithistory" id="reports-view42lcaunitshistory" value="reports-view42lcaunitshistory">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View LCA Unit History</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>                                               

                                                </div>
                                            </div>
                                            <!--  End Second Column -->

                                            <!-- Third Col -->
                                            <div class="col-md-4">
                                                <div  class="accordion-style1 panel-group accordionmodaluser">                                       
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#utenanthistory">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;<?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?> History</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-tenanthistory" value="tenanthistory" id="tenanthistory" onclick="clickUAMj('tenanthistory');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="utenanthistory">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenanthistory" id="reports-view5tenanthistory" value="reports-view5tenanthistory">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View <?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?> History</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenanthistory" id="reports-printtenanthistory" value="reports-printtenanthistory">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Print <?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?> History</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#usalesaudit">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Sales Audit</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-salesaudit" value="salesaudit" id="salesaudit" onclick="clickUAMj('salesaudit');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="usalesaudit">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMsalesaudit" id="reports-view6salesaudit" value="reports-view6salesaudit">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Sales Audit</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#uaccreditation">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Accreditation</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-accreditation" value="accreditation" id="accreditation" onclick="clickUAMj('accreditation');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="uaccreditation">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMaccreditation" id="reports-view7listofaccreditation" value="reports-view7listofaccreditation">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View List of Accreditation</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMaccreditation" id="reports-createnewscheduleforaccreditation" value="reports-createnewscheduleforaccreditation">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Create New Schedule for Accreditation</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMaccreditation" id="reports-editscheduleforaccreditation" value="reports-editscheduleforaccreditation">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Edit Schedule for Accreditation</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMaccreditation" id="reports-inputpenalty" value="reports-inputpenalty">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Input Penalty</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#uaudittrail">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Audit Trail</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-audittrail" value="audittrail" id="audittrail" onclick="clickUAMj('audittrail');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="uaudittrail">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMaudittrail" id="reports-view8audittrail" value="reports-view8audittrail">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Audit Trail</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMaudittrail" id="reports-printaudittrail" value="reports-printaudittrail">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Print Audit Trail</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <?php if(SysLeaseSetup('isJDAMapping') == '1'){ ?>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#ujdaMapping">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;JDA Mapping</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-jdaMapping" value="jdaMapping" id="jdaMapping" onclick="clickUAMj('jdaMapping');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="ujdaMapping">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMjdaMapping" id="systemsetup-view1jdaMapping" value="systemsetup-view1jdaMapping">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View JDA Mapping</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMjdaMapping" id="systemsetup-editjdaMapping" value="systemsetup-editjdaMapping">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Edit JDA Mapping</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#ureportTempaltes">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Report Templates</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-reportTempaltes" value="reportTempaltes" id="reportTempaltes" onclick="clickUAMj('reportTempaltes');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="ureportTempaltes">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreportTempaltes" id="systemsetup-view1reportTempaltes" value="systemsetup-view1reportTempaltes">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Report Templates</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreportTempaltes" id="systemsetup-addreportTempaltes" value="systemsetup-addreportTempaltes">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Add Report Templates</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreportTempaltes" id="systemsetup-editreportTempaltes" value="systemsetup-editreportTempaltes">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Edit Report Templates</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreportTempaltes" id="systemsetup-deletereportTempaltes" value="systemsetup-deletereportTempaltes">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Delete Report Templates</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#ureferentials">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Referentials</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-referentials" value="referentials" id="referentials" onclick="clickUAMj('referentials');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="ureferentials">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreferentials" id="systemsetup-view1referentials" value="systemsetup-view1referentials">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Referential</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreferentials" id="systemsetup-addreferentials" value="systemsetup-addreferentials">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Add Referential</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreferentials" id="systemsetup-editreferentials" value="systemsetup-editreferentials">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Edit Referential</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMreferentials" id="systemsetup-deletereferentials" value="systemsetup-deletereferentials">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Delete Referential</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#umallconfiguration">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;<label class="txtSysBuilding bold">Mall</label> Configuration</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-mallconfiguration" value="mallconfiguration" id="mallconfiguration" onclick="clickUAMj('mallconfiguration');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse" id="umallconfiguration">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMmallconfiguration" id="systemsetup-view2mallmalllist" value="systemsetup-view2mallmalllist">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View <span class="txtSysBuilding"></span> Company List</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMmallconfiguration" id="systemsetup-addnewmallCompany" value="systemsetup-addnewmallCompany">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Add New <span class="txtSysBuilding"></span> Company</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMmallconfiguration" id="systemsetup-editmallcompany" value="systemsetup-editmallcompany">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Edit <span class="txtSysBuilding"></span> Company</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMmallconfiguration" id="systemsetup-view2mallmalllist" value="systemsetup-view2mallmalllist">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View <span class="txtSysBuilding"></span> List</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMmallconfiguration" id="systemsetup-addnewmall" value="systemsetup-addnewmall">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Add New <span class="txtSysBuilding"></span></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMmallconfiguration" id="systemsetup-editmallinformation" value="systemsetup-editmallinformation">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Edit <span class="txtSysBuilding"></span> Information</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMmallconfiguration" id="systemsetup-configuremall" value="systemsetup-configuremall">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Configure <span class="txtSysBuilding"></span></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMmallconfiguration" id="systemsetup-activateordeactivatemall" value="systemsetup-activateordeactivatemall">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Activate/Deactivate <span class="txtSysBuilding"></span></span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default hide">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#utermsandconditions">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Terms and Conditions</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-termsandconditions" value="termsandconditions" id="termsandconditions" onclick="clickUAMj('termsandconditions');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="utermsandconditions">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtermsandconditions" id="systemsetup-view3termsandconditions" value="systemsetup-view3termsandconditions">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Terms and Conditions</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtermsandconditions" id="systemsetup-addtermsandconditions" value="systemsetup-addtermsandconditions">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Add Terms and Conditions</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtermsandconditions" id="systemsetup-edittermsandconditions" value="systemsetup-edittermsandconditions">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Edit Terms and Conditions</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#uuserandaccessibility">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;User and Accessibility</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-userandaccessibility" value="userandaccessibility" id="userandaccessibility" onclick="clickUAMj('userandaccessibility');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="uuserandaccessibility">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMuserandaccessibility" id="systemsetup-view4userandaccessibility" value="systemsetup-view4userandaccessibility">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View User and Accessibility</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMuserandaccessibility" id="systemsetup-addnewuser" value="systemsetup-addnewuser">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Add New User</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMuserandaccessibility" id="systemsetup-edituser" value="systemsetup-edituser">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Edit User Information</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMuserandaccessibility" id="systemsetup-changeuserstat" value="systemsetup-changeuserstat">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Change User Status</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMuserandaccessibility" id="systemsetup-addusergroup" value="systemsetup-addusergroup">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Add User Group</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMuserandaccessibility" id="systemsetup-editusergroup" value="systemsetup-editusergroup">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Edit User Group</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMuserandaccessibility" id="systemsetup-deleteusergroup" value="systemsetup-deleteusergroup">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Delete User Group</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMuserandaccessibility" id="systemsetup-modifyuseraccess" value="systemsetup-modifyuseraccess">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Modify User Access</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMuserandaccessibility" id="systemsetup-hierarchyapprovalaccess" value="systemsetup-hierarchyapprovalaccess">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Hierarchy Approval Access</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMuserandaccessibility" id="systemsetup-addapprover" value="systemsetup-addapprover">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Add Approver</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMuserandaccessibility" id="systemsetup-editapprover" value="systemsetup-editapprover">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Edit Approver</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMuserandaccessibility" id="systemsetup-deleteapprover" value="systemsetup-deleteapprover">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Delete Approver</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMuserandaccessibility" id="systemsetup-modifyapprovallevel" value="systemsetup-modifyapprovallevel">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Add / Edit Hierarchy Code</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default hide">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#ucompanylist">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Company List</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-companylist" value="companylist" id="companylist" onclick="clickUAMj('companylist');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="ucompanylist">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMcompanylist" id="systemsetup-view5companylist" value="systemsetup-view5companylist">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Company List</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMcompanylist" id="systemsetup-addnewcompany" value="systemsetup-addnewcompany">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Add New Company</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMcompanylist" id="systemsetup-editcompany" value="systemsetup-editcompany">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Edit Company</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMcompanylist" id="systemsetup-addnewstore" value="systemsetup-addnewstore">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Add New Store</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMcompanylist" id="systemsetup-editstore" value="systemsetup-editstore">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Edit Store</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#uapprovallist">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Approval List</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-forapprovallist" value="forapprovallist" id="forapprovallist" onclick="clickUAMj('forapprovallist');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="uapprovallist">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMforapprovallist" id="viewproposallist-viewproposallist" value="viewproposallist-viewproposallist">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Proposal List</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMforapprovallist" id="viewawardinglist-viewawardinglist" value="viewawardinglist-viewawardinglist">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View For Awarding List</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMforapprovallist" id="viewcontractlist-viewcontractlist" value="viewcontractlist-viewcontractlist">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Contract List</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMforapprovallist" id="forapprovallist-tenantinformation" value="forapprovallist-tenantinformation">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Tenant Information</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMforapprovallist" id="forapprovallist-billinginformation" value="forapprovallist-billinginformation">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Billing Information</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMforapprovallist" id="forapprovallist-leaseinformation" value="forapprovallist-leaseinformation">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Lease Information</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMforapprovallist" id="forapprovallist-paymentschedule" value="forapprovallist-paymentschedule">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Payment Schedule</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMforapprovallist" id="forapprovallist-charges" value="forapprovallist-charges">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Charges</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMforapprovallist" id="forapprovallist-requirementspermits" value="forapprovallist-requirementspermits">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Requirements and Permits</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMforapprovallist" id="forapprovallist-termsandconditions" value="forapprovallist-termsandconditions">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Terms and Conditions</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMforapprovallist" id="forapprovallist-remarks" value="forapprovallist-remarks">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Remarks</span>
                                                                        </label>
                                                                    </div>
                                                                    <!--  -->
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#ueventsmod">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Events</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-eventsmod" value="eventsmod" id="eventsmod" onclick="clickUAMj('eventsmod');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="ueventsmod">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMeventsmod" id="eventsmod-vieweventscalendar" value="systemsetup-vieweventscalendar">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Events Calendar</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMeventsmod" id="eventsmod-addtermsandconditions" value="systemsetup-vieweventslist">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Events List</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed aacordheader"  data-parent="#accordion" >
                                                                    <label class="hoverx" data-toggle="collapse" href="#utenantspaymentxmod">
                                                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                                        <b>&nbsp;Tenant's Payment (Setup)</b>    
                                                                    </label>
                                                                    
                                                                    <label class="pull-right">
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace checkitout chk-modules chk-tenantspaymentxmod" value="tenantspaymentxmod" id="tenantspaymentxmod" onclick="clickUAMj('tenantspaymentxmod');">
                                                                        <span class="lbl"></span>&nbsp;Select All
                                                                    </label>
                                                                </a>
                                                            </h4>
                                                        </div>

                                                        <div class="panel-collapse collapse " id="utenantspaymentxmod">
                                                            <div class="panel-body">
                                                                <p class="card-text">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenantspaymentxmod" id="systemsetup-tenantspaymentxmod" value="systemsetup-tenantspaymentxmod">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;View Tenants Payment</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="form-field-checkbox" type="checkbox" class="ace checkitout UAMtenantspaymentxmod" id="systemsetup-addtenantspayment" value="systemsetup-addtenantspayment">
                                                                            <span class="lbl" style="color: #666;">&nbsp;&nbsp;Add Tenants Payment</span>
                                                                        </label>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>



                                                </div>
                                            </div>
                                            <!-- End Third Col -->
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm btn-round" onclick="adduseracce();"><span class="fa fa-check"></span> Save</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade fade-scale" role="dialog" id="modallistandlevel" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="hidemodallistandlevel();">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Approval List & Level</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row form-group" style="margin-bottom: 0px;">
                       <div class="col-md-4" style="padding-bottom: 5px;">
                           <span class="input-icon" style="width: 100%;">
                                <input type="text" class="form-control" id="txtsearchapprlist" title="Search" placeholder="Search">
                                <i class="ace-icon fa fa-search nav-search-icon"></i>
                            </span>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <input type="hidden" id="apprtrid">
                            <table class="table table-bordered table-hover">
                                <thead>
                                   <tr>
                                      <th>Code</th>
                                      <th>Module</th>
                                      <th>Person</th>
                                      <th>Designation</th>
                                      <th>Level</th>
                                   </tr>
                                </thead>
                                <tbody id="tblapprovallistandlevel"></tbody>
                                <tbody>
                                  <tr>
                                    <td colspan="5">
                                        <input type="hidden" id="bilang2">
                                        <button onclick="pickB('first')" class="btn btn-info btn-sm  btn-useraccess2 btn-useraccess-12 btn-round"><span class="glyphicon glyphicon-fast-backward"></span></button>
                                        <button onclick="pickB('prev')" class="btn btn-info btn-sm  btn-useraccess2 btn-useraccess-12 btn-round"><span class="glyphicon glyphicon-backward"></span></button>
                                        <button onclick="pickB('next')" class="btn btn-info btn-sm btn-useraccess2 btn-useraccess-22 btn-round"><span class="glyphicon glyphicon-forward"></span></button>
                                        <button onclick="pickB('last')" class="btn btn-info btn-sm btn-useraccess2 btn-useraccess-22 btn-round"><span class="glyphicon glyphicon-fast-forward"></span></button>
                                    </td>
                                  </tr>
                              </tbody>
                           </table>
                       </div>
                    </div>
                    <div class="row form-group" style="margin-left: 50px;margin-right: 50px;">
                        <div class="row form-group">
                            <div class="col-sm-3" style="margin-top: 10px;">
                                Code
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control txtall" id="txtallcode" readonly>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3" style="margin-top: 10px;">
                                Module
                            </div>
                            <div class="col-sm-8">
                                <select class="form-control txtall txtalldisabled" id="txtallmodule" disabled>
                                    <option value='' selected disabled>-- Select Module --</option>
                                    <option value='TR'>Tenant's Request</option>
                                </select>
                            </div>                            
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3" style="margin-top: 10px;">
                                Personnel Name
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control txtall" id="txtallpersonnelname" readonly>
                            </div>                            
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3" style="margin-top: 10px;">
                                Designation
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control txtall" id="txtalldesignation" readonly>
                            </div>                            
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3" style="margin-top: 10px;">
                                Level of Approval
                            </div>
                            <div class="col-sm-8">
                                <select class="form-control txtall txtalldisabled" id="txtalllevel" disabled>
                                    <option value='' selected disabled>-- Select Level --</option>
                                    <option value='1'>Level 1</option>
                                    <option value='2'>Level 2</option>
                                    <option value='3'>Level 3</option>
                                    <option value='4'>Level 4</option>
                                    <option value='5'>Level 5</option>
                                    <option value='6'>Level 6</option>
                                    <option value='7'>Level 7</option>
                                    <option value='8'>Level 8</option>
                                    <option value='9'>Level 9</option>
                                    <option value='10'>Level 10</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div id="btn-defaultdisplayall">
                    <button class="btn btn-warning btn-sm pull-left hide isadmin select-modifyapprovallevel btn-round" onclick="showmodaluserlist();"><span class="fa fa-unlock"></span>&nbsp;&nbsp;User List</button>
                    <button class="btn btn-primary btn-sm hide isadmin select-addapprover btn-round" onclick="clickaddall();"><span class="fa fa-plus"></span>&nbsp;&nbsp;Add</button>
                    <button class="btn btn-success btn-sm hide isadmin select-editapprover btn-round" onclick="clickeditall();"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Edit</button>
                    <button class="btn btn-danger btn-sm hide isadmin select-deleteapprover btn-round" onclick="deleteappr();"><span class="glyphicon glyphicon-trash"></span>&nbsp;&nbsp;Delete</button>
                    <button class="btn btn-danger btn-sm btn-round" onclick="hidemodallistandlevel();"><span class="fa fa-remove"></span>&nbsp;&nbsp;Close</button>
                </div>

                <div id="btn-addgroupall" style="display: none;">
                    <button class="btn btn-sm btn-primary btn-round" onclick="savenewall();"><span class="fa fa-check"></span> Save</button>
                    <button class="btn btn-sm btn-danger btn-round" onclick="canceladdall();"><span class="fa fa-remove"></span> Cancel</button>
                </div>

                <div id="btn-editgroupall" style="display: none;">
                    <button class="btn btn-sm btn-primary btn-round" onclick="savenewall();"><span class="fa fa-check"></span> Save</button>
                    <button class="btn btn-sm btn-danger btn-round" onclick="canceleditall();"><span class="fa fa-remove"></span> Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" role="dialog" id="modaluserlist" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="hidemodaluserlist();">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">User List</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <span class="input-icon" style="width: 100%;">
                            <input type="text" class="form-control" id="txtappruserlist" title="Search" placeholder="Search">
                            <i class="ace-icon fa fa-search nav-search-icon"></i>
                        </span>
                    </div>
                    <div class="col-md-12">
                        <input type="hidden" id="hiduserid">
                        <div style="margin-top: 10px;">
                            <table class="table table-bordered table-hover">
                                <thead>
                                   <tr>
                                      <th>User ID</th>
                                      <th>Full Name</th>
                                      <th>Group</th>
                                   </tr>
                                </thead>
                                <tbody id="tbluserlist"></tbody>
                                <tbody>
                                  <tr>
                                    <td colspan="3">
                                        <input type="hidden" id="blankperomaybilang" value="1">
                                        <input type="hidden" id="bilang3">
                                        <button onclick="pickC('first')" class="btn btn-info btn-sm  btn-useraccess3 btn-useraccess-13 btn-round"><span class="glyphicon glyphicon-fast-backward"></span></button>
                                        <button onclick="pickC('prev')" class="btn btn-info btn-sm  btn-useraccess3 btn-useraccess-13 btn-round"><span class="glyphicon glyphicon-backward"></span></button>
                                        <button onclick="pickC('next')" class="btn btn-info btn-sm btn-useraccess3 btn-useraccess-23 btn-round"><span class="glyphicon glyphicon-forward"></span></button>
                                        <button onclick="pickC('last')" class="btn btn-info btn-sm btn-useraccess3 btn-useraccess-23 btn-round"><span class="glyphicon glyphicon-fast-forward"></span></button>
                                    </td>
                                  </tr>
                              </tbody>
                           </table>
                       </div>
                    </div>
                </div>
                <div class="row" style="margin-left: 10px;margin-right: 10px;">
                    <div class="col-md-1">
                        #
                    </div>
                    <div class="col-md-4">
                        <b>Approval Access</b>
                    </div>
                    <div class="col-md-3">
                        <b>Module</b>
                    </div>
                    <div class="col-md-3">
                        <b>Designation</b>
                    </div>
                    <div class="col-md-1">
                        <b>Level</b>
                    </div>
                </div>
                <div class="row" style="margin-left: 10px;margin-right: 10px;">
                    <div class="col-md-12">
                        <div id="blankcontainer"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div id="btn-addnewlayer" style="display: none;">
                    <button class="btn btn-sm btn-success pull-left btn-round" onclick="appendblanks();"><span class="fa fa-plus"></span></button>
                    <button class="btn btn-sm btn-danger pull-left btn-round" onclick="deletechkappr();"><span class="fa fa-minus"></span></button>
                </div>

                <div id="btn-defaultdisplayappruser">
                    <!-- <button class="btn btn-primary btn-sm" onclick="clickaddaccesstouser();"><span class="fa fa-plus"></span>&nbsp;&nbsp;Add</button> -->
                    <button class="btn btn-success btn-sm btn-round" onclick="clickaddaccesstouser();"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Edit</button>
                    <!-- <button class="btn btn-danger btn-sm" onclick=""><span class="fa fa-trash"></span>&nbsp;&nbsp;Delete</button> -->
                    <button class="btn btn-danger btn-sm btn-round" onclick="hidemodaluserlist();"><span class="fa fa-remove"></span>&nbsp;&nbsp;Close</button>
                </div>

                <div id="btn-addgroupappruser" style="display: none;">
                    <button class="btn btn-sm btn-primary btn-round" onclick="saveaccesstouser();"><span class="fa fa-check"></span> Save</button>
                    <button class="btn btn-sm btn-danger btn-round" onclick="canceladdaccesstouser();"><span class="fa fa-remove"></span> Cancel</button>
                </div>

                <div id="btn-editgroupappruser" style="display: none;">
                    <button class="btn btn-sm btn-primary btn-round" onclick="savenewall();"><span class="fa fa-check"></span> Save</button>
                    <button class="btn btn-sm btn-danger btn-round" onclick="canceleditall();"><span class="fa fa-remove"></span> Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade fade-scale" role="dialog" id="modal_hierarchy" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="preLoadMdlUser"></div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Hierarchy of Approval</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row form-group" style="margin-bottom: 0px;">
                       <div class="col-md-4" style="padding-bottom: 5px;">
                           <span class="input-icon" style="width: 100%;">
                                <input type="text" class="form-control" id="txtsearchhierar" title="Search" placeholder="Search">
                                <i class="ace-icon fa fa-search nav-search-icon"></i>
                            </span>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <input type="hidden" id="txthiearchyidx">
                            <table class="table table-bordered table-hover">
                                <thead>
                                   <tr>
                                      <th>Code</th>
                                      <th>Module</th>
                                      <th>Role</th>
                                      <th>Level</th>
                                      <th>Default</th>
                                      <th>Property</th>
                                   </tr>
                                </thead>
                                <tbody id="txthierarchylist"></tbody>
                                <tbody>
                                  <tr>
                                    <td colspan="7">
                                        <input type="hidden" id="bilang2hierarchy">
                                        <button onclick="pickB_hierarchy('first')" class="btn btn-info btn-sm  btn-useraccess2hie btn-useraccess2hie-1 btn-round"><span class="glyphicon glyphicon-fast-backward"></span></button>
                                        <button onclick="pickB_hierarchy('prev')" class="btn btn-info btn-sm  btn-useraccess2hie btn-useraccess2hie-1 btn-round"><span class="glyphicon glyphicon-backward"></span></button>
                                        <button onclick="pickB_hierarchy('next')" class="btn btn-info btn-sm btn-useraccess2hie btn-useraccess2hie-2 btn-round"><span class="glyphicon glyphicon-forward"></span></button>
                                        <button onclick="pickB_hierarchy('last')" class="btn btn-info btn-sm btn-useraccess2hie btn-useraccess2hie-2 btn-round"><span class="glyphicon glyphicon-fast-forward"></span></button>
                                    </td>
                                  </tr>
                              </tbody>
                           </table>
                       </div>
                    </div>
                    <div class="row form-group" style="margin-left: 50px;margin-right: 50px;">
                        <div class="row form-group">
                            <div class="col-sm-2" style="margin-top: 10px;">
                                Code
                            </div>
                            <div class="col-sm-6">
                                <select class="js-states form-control searchy_select txtallhierarchy" id="txthiemaincode" style="width: 100%" disabled>
                                    <option value='' selected disabled>-- Select Code --</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2" style="margin-top: 10px;">
                                Module
                            </div>
                            <div class="col-sm-6">
                                <select class="form-control txtallhierarchy" id="txthiemainmodule" disabled>
                                    <option value='' selected disabled>-- Select Module --</option>
                                    <option value='Tenants Request'>Tenants Request</option>
                                    <option value='Maintenance'>Maintenance</option>
                                    <option value='Proposal'>Proposal</option>
                                    <option value='Awarding'>Awarding</option>
                                    <option value='Contract'>Contract</option>
                                </select>
                            </div>                            
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2" style="margin-top: 10px;">
                                Role
                            </div>
                            <div class="col-sm-6">
                               <select class="form-control searchy_select txtallhierarchy" id="txthiemainrole" style="width: 100%" disabled>
                                    <option value='' selected disabled>-- Select Role --</option>
                                </select>
                            </div>                            
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2" style="margin-top: 10px;">
                                Approval Level
                            </div>
                            <div class="col-sm-6">
                                <select class="form-control txtallhierarchy" id="txthiemainlevel" style="width: 100%" disabled>
                                    <option value='' selected disabled>-- Select Level --</option>
                                    <option value='1'>1st Approver</option>
                                    <option value='2'>2nd Approver</option>
                                    <option value='3'>3rd Approver</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2" style="margin-top: 10px;">
                                Default Approver
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control txtallhierarchy" id="txthiemaindefault"  disabled>
                                    <option value='' selected disabled>-- Select --</option>
                                    <option value='0'>No</option>
                                    <option value='1'>Yes</option>
                                </select>
                            </div>                            
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2" style="margin-top: 10px;">
                                Property
                            </div>
                            <div class="col-sm-6">
                                <select class="form-control searchy_select" id="txthiemainproperty" style="width: 100%" disabled>
                                    <option value='' selected disabled>-- Can be blank --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div id="btn-defaultdisplayhierarchy">
                    <button class="btn btn-warning btn-sm pull-left hide isadmin select-modifyapprovallevel btn-round" onclick="showmodalhcodelist();"><span class="fa fa-unlock"></span>&nbsp;&nbsp;Hierarchy Code List</button>
                    <button class="btn btn-primary btn-sm hide isadmin select-addapprover btn-round" onclick="clickadd_hierar();"><span class="fa fa-plus"></span>&nbsp;&nbsp;Add</button>
                    <button class="btn btn-success btn-sm hide isadmin select-editapprover btn-round" onclick="clickedit_hierarchy();"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Edit</button>
                    <button class="btn btn-danger btn-sm hide isadmin select-deleteapprover btn-round" onclick="delete_hierarchy();"><span class="glyphicon glyphicon-trash"></span>&nbsp;&nbsp;Delete</button>
                    <button class="btn btn-danger btn-sm btn-round" onclick="hidemodallhierarchy();"><span class="fa fa-remove"></span>&nbsp;&nbsp;Close</button>
                </div>

                <div id="btn-addhierarchy" style="display: none;">
                    <button class="btn btn-sm btn-primary btn-round" onclick="savenew_hierar();"><span class="fa fa-check"></span> Save</button>
                    <button class="btn btn-sm btn-danger btn-round" onclick="canceladd_hierar();"><span class="fa fa-remove"></span> Cancel</button>
                </div>

                <div id="btn-edithierarchy" style="display: none;">
                    <button class="btn btn-sm btn-primary btn-round" onclick="savenew_hierar();"><span class="fa fa-check"></span> Save</button>
                    <button class="btn btn-sm btn-danger btn-round" onclick="canceladd_hierar();"><span class="fa fa-remove"></span> Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade fade-scale" role="dialog" id="modal_hiecodelist" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Add Hierarchy Code</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row form-group" style="margin-bottom: 0px;">
                        <div class="col-md-5" style="padding-bottom: 5px;">
                           <span class="input-icon" style="width: 100%;">
                                <input type="text" class="form-control" id="txtsearchhiecode" title="Search" placeholder="Search">
                                <i class="ace-icon fa fa-search nav-search-icon"></i>
                            </span>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover">
                                <thead>
                                   <tr>
                                      <th style="width: 20%;">Code ID</th>
                                      <th style="width: 80%;">Hierarchy Code</th>
                                   </tr>
                                </thead>
                                <tbody id="tblhiecodelist"></tbody>
                                <tbody>
                                  <tr>
                                    <td colspan="4">
                                        <input type="hidden" id="bilanghierarchy">
                                        <button onclick="pickA_hiecode('first')" class="btn btn-info btn-sm  btn-useraccess btn-useraccess-h1 btn-round"><span class="glyphicon glyphicon-fast-backward"></span></button>
                                        <button onclick="pickA_hiecode('prev')" class="btn btn-info btn-sm  btn-useraccess btn-useraccess-h1 btn-round"><span class="glyphicon glyphicon-backward"></span></button>
                                        <button onclick="pickA_hiecode('next')" class="btn btn-info btn-sm btn-useraccess btn-useraccess-h2 btn-round"><span class="glyphicon glyphicon-forward"></span></button>
                                        <button onclick="pickA_hiecode('last')" class="btn btn-info btn-sm btn-useraccess btn-useraccess-h2 btn-round"><span class="glyphicon glyphicon-fast-forward"></span></button>
                                    </td>
                                  </tr>
                              </tbody>
                           </table>
                        </div>
                    </div>
                    <div class="row form-group" style="margin-left: 50px;margin-right: 50px;">
                        <div class="col-sm-4" style="margin-top: 10px;">
                            Hiearchy Code
                        </div>
                        <div class="col-sm-7">
                            <input type="text" class="form-control txtronly_hie" id="txthiecodeadd" readonly>
                            <input type="hidden" id="txthiecodeaddid">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div id="btn-defaultdisplayhiecode">
                    <button class="btn btn-primary btn-sm hide isadmin select-addusergroup btn-round" onclick="clickaddhie();"><span class="fa fa-plus"></span>&nbsp;&nbsp;Add</button>
                    <button class="btn btn-success btn-sm hide isadmin select-editusergroup btn-round" onclick="clickedithie();"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Edit</button>
                    <button class="btn btn-danger btn-sm hide isadmin select-deleteusergroup btn-round" onclick="deletehierarchycode();"><span class="glyphicon glyphicon-trash"></span>&nbsp;&nbsp;Delete</button>
                    <button class="btn btn-danger btn-sm btn-round" onclick="hidemodalhiecode();"><span class="fa fa-remove"></span>&nbsp;&nbsp;Close</button>
                </div>

                <div id="btn-addhiecode" style="display: none;">
                    <button class="btn btn-sm btn-primary btn-round" onclick="saveaddhiecode();"><span class="fa fa-check"></span> Save</button>
                    <button class="btn btn-sm btn-danger btn-round" onclick="normal_hiecodelist();"><span class="fa fa-remove"></span> Cancel</button>
                </div>

                <div id="btn-edithiecode" style="display: none;">
                    <button class="btn btn-sm btn-primary btn-round" onclick="savedithiecode();"><span class="fa fa-check"></span> Save</button>
                    <button class="btn btn-sm btn-danger btn-round" onclick="normal_hiecodelist_edit();"><span class="fa fa-remove"></span> Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>