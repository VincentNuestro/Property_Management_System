<script type="text/javascript">
	$(function(){
		$("#txtUsersCount").val("1");
		$(".fixTable").tableHeadFixer();
		loadusers();
		$("#modalheader").text("New User");
		$("#txtfuserkey").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
                $("#txtUsersCount").val("1");
				loadusers(); 
			}else if(x == '8'){
                if($('#txtfuserkey').val() == ""){
                    $("#txtUsersCount").val("1");
                    loadusers();
                }
            }
		});
		$("#txtsearchusergroup").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				showtblgrouplist(); 
			}else if(x == '8'){
                if($('#txtsearchusergroup').val() == ""){
                    showtblgrouplist();
                }
            }
		});
		$("#txtsearchapprlist").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				tbldisplayapprlist(); 
			}else if(x == '8'){
                if($('#txtsearchapprlist').val() == ""){
                    tbldisplayapprlist();
                }
            }
		});
		$("#txtappruserlist").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				showtbluserlist(); 
			}else if(x == '8'){
                if($('#txtappruserlist').val() == ""){
                    showtbluserlist();
                }
            }
		});
		$(".txtfgender").each(function(){
			$(this).change(function(){
				loadusers();
			});
		});
		$("#txtfusertype").change(function(){
			loadusers();
		});
		loadgaccess();
        trappingforfields();
        $('.input-mask-phone').mask('(999) 999-9999', {autoclear: false});
        $('.UserImage').ace_file_input({
            no_file:'No File ...',
            btn_choose:'Choose',
            btn_change:'Change',
            droppable:false,
            onchange:null,
            thumbnail:false
        });
	});
	
	function loadgaccess(){
		$.ajax({
			type: 'POST',
			url: 'setup/user/class.php',
			data: 'form=loadgaccess',
			beforeSend:function(){
			},
			success: function(data) {
				$("#txtgroupaccess").html(data);
			}
		})
        $.ajax({
            type: 'POST',
            url: 'setup/user/class.php',
            data: '&form=olMallList',
            success: function(data){
                $("#olMallList").html(data);
            }
        })
        $.ajax({
            type: 'POST',
            url: 'setup/user/kevlclass.php',
            data: '&form=loadhiecode',
            success: function(data){
                $("#txthiearchycodex").html(data);
            }
        })
	}
	
	function showimgggggg(){
		var oFReader = new FileReader();
		oFReader.readAsDataURL(document.getElementById("txtfile").files[0]);
		oFReader.onload = function (oFREvent) {
			document.getElementById("txtimage").src = oFREvent.target.result;
		};
	}
	
    function trappingforfields() {
        $('.email-addressssssss').each(function(){
            var getid = $(this).attr("id");
            $(this).focusout(function() {
                var sEmail = $(this).val();
                if ($.trim(sEmail).length == 0) {
                    $(".errohere").text("");
                    e.preventDefault();
                }
                if (validateEmail(sEmail)) {
                    $(".errohere").text("");
                    $(this).css("border-color", "#b5b5b5");
                }else {
                    $(".errohere").text("Invalid Email Address");
                    $(this).focus();
                    e.preventDefault();
                }
            });
        });
    }

    function validateEmail(sEmail) {
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (filter.test(sEmail)) {
            return true;
        }
        else {
            return false;
        }
    }
	
	function newuser(){
        $.ajax({
            type: 'POST',
            url: 'setup/user/class.php',
            data: 'form=checkNeededData', 
            success: function(data){
                var arr = data.split("|");
                if(arr[0] >= 1 && arr[1] >= 1){
                    $("#modal_newuser").modal("show");
                    $(".disableifheader").prop("disabled", false);
                    $("#modalheader").text("New User");
                    $(".hideifheader").css("display", "inline-block");
                    $('input:radio[name="txtUserType"][value="User"]').click();
                    $(".btnSetStatInactive").addClass('hide');
                    $(".btnSetStatActive").addClass("hide");
                    $(".txtUserReq").css("border-color", "#b5b5b5");
                    $("#txtGender").val("Male");
                    // $("#txtusername").removeAttr("readonly");
                    fncLoadProcessOwner();
                    loadgaccess();
                }else{
                    if(arr[0] <= 0 && arr[1] >= 1){
                        setTimeout(function() {
                            showmodal("alert", "There is no group role to be selected, please create atleast one first before creating a user.", "", "", "", null, "1");
                        }, 500);
                    }else if(arr[0] >= 1 && arr[1] <= 0){
                        setTimeout(function() {
                            showmodal("alert", "There is no mall to be assigned, please create atleast one first before creating a user.", "", "", "", null, "1");
                        }, 500);
                    }else{
                        setTimeout(function() {
                            showmodal("alert", "Creating new user requires user group and mall to be assigned, please create atleast one first before creating a user.", "", "", "", null, "1");
                        }, 500);
                    }
                }
            }
        })
	}
	
	function clearuser(){
		$(".userfields .form-control").val("");
		$("#modal_newuser").modal("hide");
		$("#txtuserid").val("");
		$("#modalheader").text("New User");
        $("#txtimage").attr("src", "assets/images/ai1logo.png");
	}
	
	function loadusers(){
		var key = $("#txtfuserkey").val();
		var gender = "";
		$(".txtfgender").each(function(){
			if($(this).is(":checked") == true){ 
                gender = $(this).val(); 
            }
		});
		var usertype = $("#txtfusertype").val();
		var page = $("#txtUsersCount").val();
		$.ajax({
			type: 'POST',
			url: 'setup/user/class.php',
			data: 'page=' + page + '&key=' + key + '&gender=' + gender + '&usertype=' + usertype + '&form=loadusers',
			beforeSend : function() {
                $('#indexloadingscreen').addClass('myspinner');
            },
            success: function(data){
                $('#indexloadingscreen').removeClass('myspinner');
                if(data != ""){
                    $("#userlist").html(data);
                }else{
                    $("#userlist").html("<tr><td colspan='9' style='text-align: center;'>No Data Found...</td></tr>");
                }
                loadUsersEntries();
				loadUsersPagination();
			}
		})
	}

	function loadUsersEntries(){
	  	var key = $("#txtfuserkey").val();
		var gender = "";
		$(".txtfgender").each(function(){
			if($(this).is(":checked") == true){ 
                gender = $(this).val(); 
            }
		});
		var usertype = $("#txtfusertype").val();
	  	var page = $("#txtUsersCount").val();
        $.ajax({
            type: 'POST',
            url: 'setup/user/class.php',
            data: 'page=' + page + '&key=' + key + '&gender=' + gender + '&usertype=' + usertype + '&form=loadUsersEntries',
            success: function(data){
                $("#txtUsersEntries").text(data);
        	}	
        })
    }

	function loadUsersPagination(){
	  	var key = $("#txtfuserkey").val();
		var gender = "";
		$(".txtfgender").each(function(){
			if($(this).is(":checked") == true){ 
                gender = $(this).val(); 
            }
		});
		var usertype = $("#txtfusertype").val();
	  	var page = $("#txtUsersCount").val();
        $.ajax({
            type: 'POST',
            url: 'setup/user/class.php',
            data: 'page=' + page + '&key=' + key + '&gender=' + gender + '&usertype=' + usertype + '&form=loadUsersPagination',
            success: function(data){
                $("#ulUsersPagination").html(data);
            }
        })
	}

    function UsersPageFunc(page, pagenums){
        $(".pgnumLA").removeClass("active");
        $("#pgLA" + pagenums).addClass("active");
        $("#txtUsersCount").val(page);
        loadusers();
	}
	
	function edituser(userid, type){
		$("#txtuserid").val(userid);
		loadgaccess();
		$.ajax({
			type: 'POST',
			url: 'setup/user/class.php',
			data: 'userid=' + userid + '&form=edituser',
			beforeSend:function(){
			},
			success: function(data) {
				var arr = data.split("|");               
                $("#txtfirstname").val(arr[0]);
                $("#txtmiddlename").val(arr[1]);
                $("#txtlastname").val(arr[2]);
                $("#txtGender").val(arr[3]);
                $("#txtusername").val(arr[4]);
                $("#txtcontactnumber").val(arr[5]);
                $("#txtemailaddress").val(arr[6]);
                $(".rdUserType").each(function(){
                    if($(this).val() == arr[7]){ 
                        $(this).prop("checked", true); 
                    }
                });
                if(arr[7] == "Admin"){
                    $("#txtgroupaccess").prop("disabled", true);
                    $("#txtgroupaccess").removeClass("txtUserReq");
                }else{
                    $("#txtgroupaccess").prop("disabled", false);
                    $("#txtgroupaccess").addClass("txtUserReq");
                }
				$("#txtgroupaccess").val(arr[8]);
				$("#txtimage").attr("src", arr[9]);
                var arr2 = arr[10].split("@");
                for(var j=0; j<=arr2.length-2; j++){
                    $('input:checkbox[value="'+arr2[j]+'"]').prop('checked', true);
                }
				$("#modal_newuser").modal("show");
                if(arr[11] == 1){
                    $(".btnSetStatInactive").removeClass("hide");
                    $(".btnSetStatActive").addClass("hide");
                }else{
                    $(".btnSetStatInactive").addClass("hide");
                    $(".btnSetStatActive").removeClass("hide");
                }
                $("#txthiearchycodex").val(arr[12]);
                $.ajax({
                    type: 'POST',
                    url: 'setup/user/class.php',
                    data: 'form=fncLoadProcessOwner',
                    success: function(data){
                        $(".searchy_select").select2();
                        $(".select2-selection").css('height','33px');
                        $("#txtProcessOwner").html(data);
                    }, complete: function(){
                        $("#txtProcessOwner").val([arr[13]]).trigger('change');
                    }
                })
			}, complete: function(){
                if(type == "header"){
                    $("#modalheader").text("User Profile");
                    $(".hideifheader").css("display", "none");
                    $(".disableifheader").prop("disabled", true);
                }else{
                    $(".disableifheader").prop("disabled", false);
                    $("#modalheader").text("Edit User");
                    $(".hideifheader").css("display", "inline-block");
                }
                $("#txtpassword").removeClass("txtUserReq");
                $(".disisporuser").css("display", "none");
                // $("#txtusername").attr("readonly", "readonly");
            }
		})
	}
	
    function fncSaveUser(){
        var UserID = $("#txtuserid").val();
        var FirstName = $("#txtfirstname").val();
        var MiddleName = $("#txtmiddlename").val();
        var LastName = $("#txtlastname").val();
        var ContactNumber = $("#txtcontactnumber").val();
        var EmailAddress = $("#txtemailaddress").val();
        var UserName = $("#txtusername").val();
        var Password = $("#txtpassword").val();
        var ProcessOwner = $("#txtProcessOwner").val();
        var UserType = "";
        var txthiearchycodex = $("#txthiearchycodex").val();
        $(".rdUserType").each(function(){
            if($(this).is(":checked")){
                UserType = $(this).val();
            }
        })
        var GroupAccess = $("#txtgroupaccess").val();
        var Gender = $("#txtGender").val();
        var Malls = "";
        $(".chkUserMallAccess").each(function(){
            if($(this).is(":checked")){
                Malls += $(this).val() + "@";
            }
        })
        var count = 0;
        $(".txtUserReq").each(function(){
            if($(this).val() == ""){
                count++;
                $(this).css("border-color", "#f2a696");
            }else{
               $(this).css("border-color", "#b5b5b5");
            }
        })
        if(count == 0){
            $.ajax({
                type: 'POST',
                url: 'setup/user/class.php',
                data: 'UserID=' + UserID + '&FirstName=' + FirstName + '&MiddleName=' + MiddleName + '&LastName=' + LastName + '&ContactNumber=' + ContactNumber + '&EmailAddress=' + EmailAddress + '&UserName=' + UserName + '&Password=' + Password + '&ProcessOwner=' + ProcessOwner + '&UserType=' + UserType + '&GroupAccess=' + GroupAccess + '&Gender=' + Gender + '&Malls=' + Malls + "&txthiearchycodex=" + txthiearchycodex + '&form=fncSaveUser',
                beforeSend: function(){
                    $('#preLoadMdlUser').addClass('myspinner');
                },
                success: function(data){
                    $('#preLoadMdlUser').removeClass('myspinner');
                    var arr = data.split("|");
                    $("#txtuserid").val(arr[2]);
                    if(arr[0] == "1"){
                        setTimeout(function() {
                            showmodal("alert", arr[1], "fncUpdateImage", null, "", null, "0");                    
                        }, 500);
                    }else{
                        setTimeout(function() {
                            showmodal("alert", arr[1], "", null, "", null, "1");                    
                        }, 500);
                    }
                },
                complete: function(){
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
                }
            })
        }else{
            setTimeout(function() {
                showmodal("alert", "Please fill in the required fields.", "", null, "", null, "1");                    
            }, 500);
        }
    }

    function fncUpdateImage(){
        var data = new FormData($('#saveuser')[0]);
        $.ajax({
            type: 'POST',
            url: 'setup/user/saveuserimage.php',
            data: data,
            mimeType: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data){
                clearuser();
                setTimeout(function(){
                    loadusers();
                }, 1000);
            }
        });
    }

    function fncChangeUserStatus(UserStatus, UserStatus2){
        setTimeout(function() {
            showmodal("confirm", "Are you sure you want to set user status to "+ UserStatus2 +"?", "fncChangeUserStatus2", UserStatus+"|", "", null, "0");
        }, 500);
    }

    function fncChangeUserStatus2(UserStatus){
        var UserID = $("#txtuserid").val();
        $.ajax({
            type: 'POST',
            url: 'setup/user/class.php',
            data: 'UserStatus=' + UserStatus + '&UserID=' + UserID + '&form=fncChangeUserStatus',
            success: function(data){
                loadusers();
                $("#modal_newuser").modal("hide");
            }
        })
    }    

    function fncAddProcessOwner(){
        $("#mdlProcessOwner").modal("show");
    }

    function fncSaveProcessOwner(){
        var Code = $("#txtPOCode").val();
        var Desc = $("#txtPODesc").val();
        $.ajax({
            type: 'POST',
            url: 'setup/user/class.php',
            data: 'Code=' + Code + '&Desc=' + Desc + '&form=fncSaveProcessOwner',
            success: function(data){
                if(data == 1){
                    setTimeout(function() {
                        showmodal("alert", "Process owner successfully added.", "fncCloseNewProcessOwner", null, "", null, "0");
                    }, 500);
                }else{
                    setTimeout(function() {
                        showmodal("alert", "Failed to add new process owner.", "", null, "", null, "1");
                    }, 500);
                }
            }
        })
    }

    function fncLoadProcessOwner(){
        $.ajax({
            type: 'POST',
            url: 'setup/user/class.php',
            data: 'form=fncLoadProcessOwner',
            success: function(data){
                $(".searchy_select").select2();
                $(".select2-selection").css('height','33px');
                $("#txtProcessOwner").html(data);
            }
        })
    }

    function fncCloseNewProcessOwner(){
        $("#mdlProcessOwner").modal("hide");
        fncLoadProcessOwner();
    }
</script>

<!-- Jonas September 2,2017 - START -->
<script type="text/javascript">
    function clickUAMj(SysModule){
        $(".chk-"+SysModule).each(function(){
            if($(this).is(":checked")){
                $(".UAM"+SysModule).prop("checked", true);
            }else{
                $(".UAM"+SysModule).prop("checked", false);
            }
        })
    }

    $(function(){
        showtblgrouplist2();
    })

    function showpermissionmodal(){
        $("#modalpermissionlist").modal("show");
    }

    function hidepermissionmodal(){
        $("#modalpermissionlist").modal("hide");
    }

    var bilang = 0;
    function showtblgrouplist(){
        var key = $("#txtsearchusergroup").val();
        $.ajax({
            type: 'POST',
            url: 'setup/user/class.php',
            data: 'bilang=' + bilang + '&key=' + key + '&form=showtblgrouplist',
            success:function(data){
                var arr = data.split("|");
                if(arr[0].trim() == ""){
                    $("#tblgrouplist").html("<tr><td colspan='2' style='text-align: center;'>No Data Found...</td></tr>");
                    if(bilang!=""){
                         $(".btn-useraccess-1").removeAttr("disabled");
                    }
                }else{
                    $("#tblgrouplist").html(arr[0]);
                    var getCount = Number( arr[1] )/10;
                    var getCount2 = String(getCount);
                    var arr2 = getCount2.split(".");
                    $("#bilang").val(arr2[0]);
                    pickgroupname();
                    if(getCount <= 1){
                        $(".btn-useraccess").attr("disabled","disabled");
                    }else{
                        if(bilang == 0){
                            $(".btn-useraccess-2").removeAttr("disabled");
                            $(".btn-useraccess-1").attr("disabled","disabled");
                        }else if(Number(arr2[0]) * 10 == bilang){
                            $(".btn-useraccess-1").removeAttr("disabled");
                            $(".btn-useraccess-2").attr("disabled","disabled");
                        }else{
                            $(".btn-useraccess").removeAttr("disabled");
                        }
                    }
                }
            }
        })
    }

    function showtblgrouplist2() {
        bilang = 0;
        showtblgrouplist();
    }

    function pickA(txt) {
        if ( txt == 'first' ) {
            bilang = 0;
            showtblgrouplist();
        }

        else if ( txt == 'prev' ) {
            bilang = Number(bilang) - 10;
            showtblgrouplist();
        }

        else if ( txt == 'next' ) {
            bilang = Number(bilang) + 10;
            showtblgrouplist();
        }

        else {
            bilang = Number($("#bilang").val()) * 10;
            showtblgrouplist();
        }
    }
   
    function pickgroupname(){
        $("#tblgrouplist tr").each(function(){
            $(this).click(function(){
                $("#tblgrouplist tr").removeClass("selected");
                $(this).addClass("selected");
                var id = this.id;
                var groupid = $(this).find(".textgroupid").text();
                var groupname = $(this).find(".textgroupname").text();
                $("#txtGroupName").val(groupname);
                $("#txtHGroupID").val(groupid);
            })
        })
    }

    function clickadd(){
        $(".txtGroup").removeAttr("readonly", "readonly");
        $("#btn-defaultdisplay").css("display", "none");
        $("#btn-addgroup").css("display", "block");
        $("#modalpermissionlist :input").val("");
        $("#tblgrouplist tr").unbind("click");
    }

    function canceladd(){
        $(".txtGroup").attr("readonly", "readonly");
        $("#btn-defaultdisplay").css("display", "block");
        $("#btn-addgroup").css("display", "none");
        $("#modalpermissionlist :input").val("");
        showtblgrouplist2();
    }

    function saveaddgroupname(){
        var groupname = $("#txtGroupName").val();
        if(groupname == ""){
            setTimeout(function() {
                showmodal("alert", "Please enter the name of group you want to create.", "", null, "", null, "1");
            }, 500);
        }else{
            $.ajax({
                type: 'POST',
                url: 'setup/user/class.php',
                data: 'groupname=' + groupname + '&form=savegroupaccess',
                success:function(data){
                    var arr = data.split("|");
                    if(arr[0] == "1"){
                        setTimeout(function() {
                            showmodal("alert", arr[1], "canceladd", null, "", null, "0");                    
                        }, 500);
                    }else if(arr[0] == "2"){
                        setTimeout(function() {
                            showmodal("alert", arr[1], "canceladd", null, "", null, "0");                    
                        }, 500);
                    }else if (arr[0] == "3"){
                        setTimeout(function() {
                            showmodal("alert", arr[1], "", null, "", null, "0");                   
                        }, 500);
                    }
                }
            })
        }
    }

    function clickedit(){
        if( $("#txtHGroupID").val() == ""){
            setTimeout(function() {
                showmodal("alert", "Select group name first.", "", null, "", null, "1");
            }, 500);
        }else{
            $(".txtGroup").removeAttr("readonly", "readonly");
            $("#btn-defaultdisplay").css("display", "none");
            $("#btn-editgroup").css("display", "block");
            $("#tblgrouplist tr").unbind("click");
        }
    }

    function canceledit(){
        $(".txtGroup").attr("readonly", "readonly");
        $("#btn-defaultdisplay").css("display", "block");
        $("#btn-editgroup").css("display", "none");
        $("#modalpermissionlist :input").val("");
        showtblgrouplist2();
    }

    function saveditgroupname(){
        var id = $("#txtHGroupID").val();
        var groupname = $("#txtGroupName").val();
        $.ajax({
            type: 'POST',
            url: 'setup/user/class.php',
            data: 'id=' + id + '&groupname=' + groupname + '&form=saveditgroupname',
            success:function(data){
                var arr = data.split("|");
                if(arr[0] == "1"){
                    setTimeout(function() {
                        showmodal("alert", arr[1], "canceledit", null, "", null, "0");                    
                    }, 500);
                }else if(arr[0] == "2"){
                    setTimeout(function() {
                        showmodal("alert", arr[1], "canceledit", null, "", null, "0");                    
                    }, 500);
                }
            }
        })
    }

    function deletegroupname(){
        if( $("#txtHGroupID").val() == ""){
            setTimeout(function() {
                showmodal("alert", "Select group name first.", "", null, "", null, "1");
            }, 500);
        }else{
            setTimeout(function() {
                showmodal("confirm", "Are you sure you want to delete "+$("#txtGroupName").val()+"?", "deletegroupname2", null, "", null, "1");
            }, 500);
        }
    }

    function deletegroupname2(){
        var id = $("#txtHGroupID").val();
        var groupname = $("#txtGroupName").val();
        $.ajax({
            type: 'POST',
            url: 'setup/user/class.php',
            data: 'id=' + id + '&groupname=' + groupname + '&form=deletegroupname',
            success:function(data){
                var arr = data.split("|");
                if(arr[0] == "1"){
                    setTimeout(function() {
                        showmodal("alert", arr[1], "canceledit", null, "", null, "0");                    
                    }, 500);
                }else if(arr[0] == "2"){
                    setTimeout(function() {
                        showmodal("alert", arr[1], "canceledit", null, "", null, "0");                    
                    }, 500);
                }else{
                    setTimeout(function() {
                        showmodal("alert", "Something went wrong.", "canceledit", null, "", null, "0");                   
                    }, 500);
                }
            }
        })
    }

    function showmodalpermissionpergroup(){
        var GroupName = $("#txtGroupName").val();
        if($("#txtHGroupID").val() == ""){
            setTimeout(function() {
                showmodal("alert", "Please select user group.", "", null, "", null, "1");                   
            }, 500);
        }else{
            $("#mdlUserAccess").modal("show");
            loadusergroupaccesslist();
            $("#hdrUserGroupAccess").text(GroupName);
        }
    }

    function hidemodalpermissionpergroup(){
        $("#mdlUserAccess").modal("hide");
    }

    function adduseracce(){
        setTimeout(function() {
            showmodal("confirm", "Are you sure you to save selected access?", "adduseracce2", null, "", null, "1");                    
        }, 500);
    }

    function adduseracce2(){
        var groupid = $("#txtHGroupID").val();
        var permissions = "";
        $(".chk-modules").each(function(){
            var eto = $(this);
            $(".UAM"+eto.val()).each(function(){
                if ( $(this).is(":checked") ) {
                    permissions += "#" + eto.val() + "|" + $(this).val();
                }
            })
        })
        $.ajax({
            type: 'POST',
            url: 'setup/user/class.php',
            data: 'groupid=' + groupid + '&permissions=' + permissions + '&form=adduseracce',
            beforeSend: function(){
                $("#addingofuseracceloading").addClass('myspinner');
            },
            success:function(data){
                $("#addingofuseracceloading").removeClass('myspinner');
                setTimeout(function() {
                    showmodal("alert", "User group permissions saved.", "fncCloseUserGroup", null, "", null, "0");                    
                }, 500);
            }
        })
    }

    function fncCloseUserGroup(){
        $("#mdlUserAccess").modal("hide");
    }

    function loadusergroupaccesslist(){
        var groupid = $("#txtHGroupID").val();
        $(".checkitout").prop("checked", false);
        $.ajax({
            type: 'POST',
            url: 'setup/user/class.php',
            data: 'groupid=' + groupid + '&form=loadusergroupaccesslist',
            success:function(data){
                if(data == ""){

                }else{
                    var arr = data.split("|");
                    for(var i=0; i<=arr.length-2; i++){
                        $('input:checkbox[id="'+arr[i]+'"][value="'+arr[i]+'"]').prop('checked', true);
                    }
                }
            }
        })
        $.ajax({
            type: 'POST',
            url: 'setup/user/class.php',
            data: 'groupid=' + groupid + '&form=loadusergroupaccesslist2',
            success:function(data){
                if(data == ""){

                }else{
                    var arr = data.split("|");
                    for(var i=0; i<=arr.length-2; i++){
                        $('input:checkbox[id="'+arr[i]+'"][value="'+arr[i]+'"]').prop('checked', true);
                        if($("#clickUAM"+arr[i]+" i").hasClass("fa fa-chevron-down")){
                            $("#clickUAM"+arr[i]).click();
                        }
                    }
                }
            }
        })
        $.ajax({
            type: 'POST',
            url: 'setup/user/class.php',
            data: 'groupid=' + groupid + '&form=loadusergroupaccesslist3',
            success:function(data){
                if(data == ""){

                }else{
                    var arr = data.split("|");
                    for(var i=0; i<=arr.length-2; i++){
                        $('input:checkbox[id="'+arr[i]+'"][value="'+arr[i]+'"]').prop('checked', true);
                        if($("#clickUAM"+arr[i]+" i").hasClass("fa fa-chevron-down")){
                            $("#clickUAM"+arr[i]).click();
                        }
                    }
                }
            }
        })
    }

    function fncSelectAllUserAccess(){
        if($(".chkUserSelectAll").is(":checked")){
            $(".chk-modules").prop("checked", true);
            $(".checkitout").prop("checked", true);
            
        }else{
            $(".chk-modules").prop("checked", false);
            $(".checkitout").prop("checked", false);
        }
    }

    function showmodallistandlevel(){
        $("#modallistandlevel").modal("show");
        tbldisplayapprlist();
    }

    function clickaddall(){
        $(".txtall").removeAttr("readonly", "readonly");
        $(".txtalldisabled").prop("disabled", false);
        $("#btn-defaultdisplayall").css("display", "none");
        $("#btn-addgroupall").css("display", "block");
        $("#modallistandlevel :input").val("");
        $("#tblapprovallistandlevel tr").unbind("click");
    }

    function canceladdall(){
        $(".txtall").attr("readonly", "readonly");
        $(".txtalldisabled").prop("disabled", true);
        $("#btn-defaultdisplayall").css("display", "block");
        $("#btn-editgroupall").css("display", "none");
        $("#btn-addgroupall").css("display", "none");
        $("#modallistandlevel :input").val("");
        tbldisplayapprlist2();
        $(".txtall").css("border-color", "#b5b5b5");
    }

    function savenewall(){
        var code = $("#txtallcode").val();
        var txtmodule = $("#txtallmodule").val();
        var personnel = $("#txtallpersonnelname").val();
        var designation = $("#txtalldesignation").val();
        var level = $("#txtalllevel").val();
        var id = $("#apprtrid").val();
        var count = 0;
        $(".txtall").each(function(){
            if($(this).val() == "" || $(this).val() == null){
                count++;
                $(this).css("border-color", "#f2a696");
            }else{
                $(this).css("border-color", "#b5b5b5");
            }
        })
        if(count == 0){
            $.ajax({
                type: 'POST',
                url: 'setup/user/class.php',
                data: 'id=' + id + '&code=' + code + '&module=' + txtmodule + '&personnel=' + personnel + '&designation=' + designation + '&level=' + level + '&form=savenewall',
                success:function(data){
                    var arr = data.split("|");
                    if(arr[0] == "1"){
                        setTimeout(function() {
                            showmodal("alert", arr[1], "canceladdall", null, "", null, "0");                    
                        }, 500);
                    }else if(arr[0] == "2"){
                        setTimeout(function() {
                            showmodal("alert", arr[1], "canceladdall", null, "", null, "0");                    
                        }, 500);
                    }else{
                        setTimeout(function() {
                            showmodal("alert", "Something went wrong.", "canceladdall", null, "", null, "0");                   
                        }, 500);
                    }
                }
            })
        }else{
            setTimeout(function() {
                showmodal("alert", "Please fill all fields.", "", null, "", null, "0");                   
            }, 500);
        }
    }

    function clickeditall(){
        if($("#txtallcode").val() == ""){
            setTimeout(function() {
                showmodal("alert", "Select code first.", "", null, "", null, "1");
            }, 500);
        }else{
            $(".txtall").removeAttr("readonly", "readonly");
            $(".txtalldisabled").prop("disabled", false);
            $("#btn-defaultdisplayall").css("display", "none");
            $("#btn-editgroupall").css("display", "block");
            $("#tblapprovallistandlevel tr").unbind("click");
        }
    }

    function canceleditall(){
        $(".txtall").attr("readonly", "readonly");
        $(".txtalldisabled").prop("disabled", true);
        $("#btn-defaultdisplayall").css("display", "block");
        $("#btn-editgroupall").css("display", "none");
        $("#modallistandlevel :input").val("");
        tbldisplayapprlist2();
    }

    function deleteappr(){
        if($("#txtallcode").val() == ""){
            setTimeout(function() {
                showmodal("alert", "Select code first.", "", null, "", null, "1");
            }, 500);
        }else{
            setTimeout(function() {
                showmodal("confirm", "Are you sure you want to delete "+$("#txtallcode").val()+"?", "deleteappr2", null, "", null, "1");
            }, 500);
        }
    }

    function deleteappr2(){
        var id = $("#apprtrid").val();
        var groupname = $("#txtGroupName").val();
        $.ajax({
            type: 'POST',
            url: 'setup/user/class.php',
            data: 'id=' + id + '&groupname=' + groupname + '&form=deleteappr2',
            success:function(data){
                var arr = data.split("|");
                if(arr[0] == "1"){
                    setTimeout(function() {
                        showmodal("alert", arr[1], "canceleditall", null, "", null, "0");                    
                    }, 500);
                }else if(arr[0] == "2"){
                    setTimeout(function() {
                        showmodal("alert", arr[1], "canceleditall", null, "", null, "0");                    
                    }, 500);
                }else{
                    setTimeout(function() {
                        showmodal("alert", "Something went wrong.", "canceleditall", null, "", null, "0");                   
                    }, 500);
                }
            }
        })
    }

    function hidemodallistandlevel(){
        $("#modallistandlevel").modal("hide");
        $("#modallistandlevel :input").val("");
    }

    var bilang2 = 0;
    function tbldisplayapprlist(){  
        var key = $("#txtsearchapprlist").val();
        $.ajax({
            type: 'POST',
            url: 'setup/user/class.php',
            data: 'bilang2=' + bilang2 + '&key=' + key + '&form=tbldisplayapprlist',
            success:function(data){
                var arr = data.split("|");
                $("#tblapprovallistandlevel").html(arr[0]);
                var getCount = Number( arr[1] )/10;
                var getCount2 = String(getCount);
                var arr2 = getCount2.split(".");
                $("#bilang2").val(arr2[0]);
                pickappr();
                if(getCount <= 1){
                    $(".btn-useraccess2").attr("disabled","disabled");
                }else{
                    if(bilang2 == 0){
                        $(".btn-useraccess-22").removeAttr("disabled");
                        $(".btn-useraccess-12").attr("disabled","disabled");
                    }else if(Number(arr2[0]) * 10 == bilang2){
                        $(".btn-useraccess-12").removeAttr("disabled");
                        $(".btn-useraccess-22").attr("disabled","disabled");
                    }else{
                        $(".btn-useraccess2").removeAttr("disabled");
                    }
                }
            }
        })
    }

    function tbldisplayapprlist2(){
        bilang2 = 0;
        tbldisplayapprlist();
    }

    function pickB(txt) {
        if(txt == 'first'){
            bilang2 = 0;
            tbldisplayapprlist();
        }else if(txt == 'prev'){
            bilang2 = Number(bilang2) - 10;
            tbldisplayapprlist();
        }else if(txt == 'next'){
            bilang2 = Number(bilang2) + 10;
            tbldisplayapprlist();
        }else{
            bilang2 = Number($("#bilang2").val()) * 10;
            tbldisplayapprlist();
        }
    }

    function pickappr(){
        $("#tblapprovallistandlevel tr").each(function(){
            $(this).click(function(){
                $("#tblapprovallistandlevel tr").removeClass("selected");
                $(this).addClass("selected");
                var id = this.id;
                var code = $(this).find(".apprlistcode").text();
                var txtmodule = $(this).find(".apprlistmodule").text();
                var personnel = $(this).find(".apprlistpersonnel").text();
                var designation = $(this).find(".apprlistdesignation").text();
                var level = $(this).find(".apprlistlist").text();
                $("#apprtrid").val(id);
                $("#txtallcode").val(code);
                $("#txtallmodule").val(txtmodule);
                $("#txtallpersonnelname").val(personnel);
                $("#txtalldesignation").val(designation);
                $("#txtalllevel").val(level);
            })
        })
    }

    function showmodaluserlist(){
        $("#modaluserlist").modal("show");
        showtbluserlist();
        showApprovalList();
    }

    function hidemodaluserlist(){
        $("#modaluserlist").modal("hide");
    }

    function showApprovalList(){
        var blank = $("#blankperomaybilang").val();
        $.ajax({
            type: 'POST',
            url: 'setup/user/class.php',
            data: 'form=showApprovalList',
            success:function(data){
                $("#approvallist-"+blank).html(data);
            }
        })
    }

    var bilang3 = 0;
    function showtbluserlist(){  
        var key = $("#txtappruserlist").val();
        $.ajax({
            type: 'POST',
            url: 'setup/user/class.php',
            data: 'bilang3=' + bilang3 + '&key=' + key + '&form=showtbluserlist',
            success:function(data){
                var arr = data.split("|");
                $("#tbluserlist").html(arr[0]);
                var getCount = Number( arr[1] )/10;
                var getCount2 = String(getCount);
                var arr2 = getCount2.split(".");
                $("#bilang3").val(arr2[0]);
                pickappruserlist();
                if(getCount <= 1){
                    $(".btn-useraccess3").attr("disabled","disabled");
                }else{
                    if(bilang3 == 0){
                        $(".btn-useraccess-23").removeAttr("disabled");
                        $(".btn-useraccess-13").attr("disabled","disabled");
                    }else if(Number(arr2[0]) * 10 == bilang3){
                        $(".btn-useraccess-13").removeAttr("disabled");
                        $(".btn-useraccess-23").attr("disabled","disabled");
                    }else{
                        $(".btn-useraccess3").removeAttr("disabled");
                    }
                }
            }
        })
    }

    function pickappruserlist(){
        $("#tbluserlist tr").each(function(){
            $(this).click(function(){
                $("#tbluserlist tr").removeClass("selected");
                $(this).addClass("selected");
                var id = this.id;
                $("#hiduserid").val(id);
                $.ajax({
                    type: 'POST',
                    url: 'setup/user/class.php',
                    data: 'id=' + id + '&form=pickappruserlist',
                    success:function(data){
                        var arr = data.split("|");
                        $("#blankcontainer").html(arr[0]);
                        $("#blankperomaybilang").val(arr[1]);
                    }
                })
            })
        })
    }

    function pickC(txt){
        if(txt == 'first'){
            bilang3 = 0;
            showtbluserlist();
        }else if(txt == 'prev'){
            bilang3 = Number(bilang3) - 10;
            showtbluserlist();
        }else if(txt == 'next'){
            bilang3 = Number(bilang3) + 10;
            showtbluserlist();
        }else{
            bilang3 = Number($("#bilang3").val()) * 10;
            showtbluserlist();
        }
    }

    function showtbluserlist2(){
        bilang3 = 0;
        showtbluserlist();
    }

    function fillintheblanks(val, id){
        var arr = id.split("-");
        $.ajax({
            type: 'POST',
            url: 'setup/user/class.php',
            data: 'val=' + val + '&form=gettheblanks',
            success:function(data){
                var arr2 = data.split("|");
                $("#apprmodule-"+arr[1]).text(arr2[0]);
                $("#apprdesignation-"+arr[1]).text(arr2[1]);
                $("#apprlevel-"+arr[1]).text(arr2[2]);

            }
        })
    }

    function appendblanks(){
        var blank = $("#blankperomaybilang").val();
        var count = parseFloat(blank) + 1;
        $("#blankcontainer").append('<div class="row form-group addonslang" id="blankcontainer-'+count+'">' +
                                            '<div class="col-md-1">' +
                                                '<label>' +
                                                    '<input name="form-field-checkbox" class="ace ace-checkbox-2 checkedappr" type="checkbox" id="apprchk-'+count+'">' +
                                                    '<span class="lbl"></span>' +
                                                '</label>' +
                                            '</div>' +
                                            '<div class="col-md-4">' +
                                                '<select class="form-control ApprovalList" id="approvallist-'+count+'" onchange="fillintheblanks(this.value, this.id)"></select>' +
                                            '</div>' +
                                            '<div class="col-md-3">' +
                                                '<label id="apprmodule-'+count+'">-</label>' +
                                            '</div>' +
                                            '<div class="col-md-3">' +
                                                '<label id="apprdesignation-'+count+'">-</label>' +
                                            '</div>' +
                                            '<div class="col-md-1">' +
                                                '<label id="apprlevel-'+count+'">-</label>' +
                                            '</div>'+
                                    '</div>');
        $("#blankperomaybilang").val(count);
        showApprovalList();
    }

    function deletechkappr(){
        var ctr = $('input.checkedappr:checked').size();
        if(ctr > 0 ){
            $(".checkedappr").each(function(){
                if ( $(this).is(":checked") == true ) {
                    var id = $(this).attr("id");
                    var arr = id.split("-");
                    $("#blankcontainer-"+arr[1]).remove();
                }
            });
        }else{
            setTimeout(function() {
                showmodal("alert", "Please atleast one item to delete.", "", null, "", null, "1");
            }, 500);
        }
    }

    function clickaddaccesstouser(){
        var count = $("#blankperomaybilang").val();
        var id = $("#hiduserid").val();
        if(id == ""){
            setTimeout(function() {
                showmodal("alert", "Please select the user you want to add approval level access.", "", null, "", null, "1");
            }, 500);
        }else{
            $(".dimapindot").prop("disabled", false);
            $("#tbluserlist tr").unbind("click");
            $("#btn-addnewlayer").css("display", "block");
            $("#btn-defaultdisplayappruser").css("display", "none");
            $("#btn-addgroupappruser").css("display", "block");
            $("#btn-editgroupappruser").css("display", "none");
            $("#blankcontainer").append('<div class="row form-group addonslang" id="blankcontainer-'+count+'">'+
                                            '<div class="col-md-1">'+
                                                '<label>'+
                                                    '<input name="form-field-checkbox" class="ace ace-checkbox-2 checkedappr" type="checkbox" id="apprchk-'+count+'">'+
                                                    '<span class="lbl"></span>'+
                                                '</label>'+
                                            '</div>'+
                                            '<div class="col-md-4">'+
                                                '<select class="form-control ApprovalList" id="approvallist-'+count+'" onchange="fillintheblanks(this.value, this.id)"></select>'+
                                            '</div>'+
                                            '<div class="col-md-3">'+
                                                '<label id="apprmodule-'+count+'">-</label>'+
                                            '</div>'+
                                            '<div class="col-md-3">'+
                                                '<label id="apprdesignation-'+count+'">-</label>'+
                                            '</div>'+
                                            '<div class="col-md-1">'+
                                                '<label id="apprlevel-'+count+'">-</label>'+
                                            '</div>'+
                                        '</div>');
            showApprovalList();
        }
    }

    function canceladdaccesstouser(){
        $(".addonslang").remove();
        $("#btn-addnewlayer").css("display", "none");
        $("#btn-defaultdisplayappruser").css("display", "block");
        $("#btn-addgroupappruser").css("display", "none");
        $("#btn-editgroupappruser").css("display", "none");
        $("#blankperomaybilang").val("1");
        showtbluserlist2();
        $("#hiduserid").val("");
        $(".dimapindot").prop("disabled", true);
    }

    function saveaccesstouser(){
        var id = "";
        $(".ApprovalList").each(function(){
            if ( this.value != "" ) {
                id += this.value + "|";
            }
        })
        var userid = $("#hiduserid").val();
        $.ajax({
            type: 'POST',
            url: 'setup/user/class.php',
            data: 'id=' + id + '&userid=' + userid + '&form=saveaccesstouser',
            success:function(data){
                var arr = data.split("|");
                if(arr[0] == "1"){
                    setTimeout(function() {
                        showmodal("alert", arr[1], "canceladdaccesstouser", null, "", null, "0");                    
                    }, 500);
                }else{
                    setTimeout(function() {
                        showmodal("alert", arr[1], "canceladdaccesstouser", null, "", null, "0");                    
                    }, 500);
                }
            }
        })
    }

    function fncChangeUserType(UserType){
        if(UserType == "Admin"){ 
            $("#txtgroupaccess").prop("disabled", true);
            $("#txtgroupaccess").removeClass("txtUserReq");
        }else{
            $("#txtgroupaccess").prop("disabled", false);
            $("#txtgroupaccess").addClass("txtUserReq");
        }
    }
</script>
<!-- Jonas September 2,2017 - END -->

<!--  Added By kevinLab -->
<script type="text/javascript">
    $(function(){
        $("#txtsearchhiecode").keyup(function(e){
            var x = event.keyCode;
            if(x == 13){ 
                showtblhiecodelist(); 
            }else if(x == '8'){
                if($('#txtsearchhiecode').val() == ""){
                    showtblhiecodelist();
                }
            }
        });

        $("#txtsearchhierar").keyup(function(e){
            var x = event.keyCode;
            if(x == 13){ 
                tbldisplayhierarchy(); 
            }else if(x == '8'){
                if($('#txtsearchhierar').val() == ""){
                    tbldisplayhierarchy();
                }
            }
        });
        
    });

    function showmodalhierarchy(){
        canceladd_hierar();
        loadcbolisthierarchy();
        tbldisplayhierarchy(); 
        $(".searchy_select").select2();
        $(".select2-selection").css('height','33px');
        $("#modal_hierarchy select").prop('disabled','disabled');
        $("#modal_hierarchy select").val("");
        $("#modal_hierarchy").modal('show');
    }

    function loadcbolisthierarchy(){
        $.ajax({
            type: 'POST',
            url: 'setup/user/class.php',
            data: 'form=loadgaccess',
            beforeSend:function(){
            },
            success: function(data) {
                $("#txthiemainrole").html(data);
            }
        })
        $.ajax({
            type: 'POST',
            url: 'setup/user/kevlclass.php',
            data: 'form=loadhiecode',
            beforeSend:function(){
            },
            success: function(data) {
                $("#txthiemaincode").html(data);
            }
        })
        $.ajax({
            type: 'POST',
            url: 'setup/user/kevlclass.php',
            data: 'form=loadhieproperty',
            beforeSend:function(){
            },
            success: function(data) {
                $("#txthiemainproperty").html(data);
            }
        })
    }

    function clickadd_hierar(){
        $("#modal_hierarchy select").val([]).trigger("change");
        $("#modal_hierarchy select").val("");
        $("#modal_hierarchy :input").val("");
        loadcbolisthierarchy();
        $("#modal_hierarchy select").prop('disabled',false);
        $("#btn-defaultdisplayhierarchy").css("display", "none");
        $("#btn-addhierarchy").css("display", "block");
        $("#modal_hierarchy :input").val("");
        $("#txthierarchylist tr").unbind("click");
    }

    function savenew_hierar(){
        var txthiemaincode = $("#txthiemaincode").val();
        var txthiemainmodule = $("#txthiemainmodule").val();
        var txthiemainrole = $("#txthiemainrole").val();
        var txthiemainlevel = $("#txthiemainlevel").val();
        var txthiemaindefault = $("#txthiemaindefault").val();
        var txthiemainproperty = $("#txthiemainproperty").val();
        var id = $("#txthiearchyidx").val();
        var count = 0;
        $(".txtallhierarchy").each(function(){
            if($(this).val() == "" || $(this).val() == null){
                count++;
                $(this).css("border-color", "#f2a696");
            }else{
                $(this).css("border-color", "#b5b5b5");
            }
        })
        if(count == 0){
            $.ajax({
                type: 'POST',
                url: 'setup/user/kevlclass.php',
                data:  'id=' + id + '&txthiemaincode=' + txthiemaincode + '&txthiemainmodule=' + txthiemainmodule + '&txthiemainrole=' + txthiemainrole + '&txthiemainlevel=' + txthiemainlevel + '&txthiemaindefault=' + txthiemaindefault + '&txthiemainproperty=' + txthiemainproperty + '&form=savenew_hierar',
                success:function(data){
                    var arr = data.split("|");
                    if(arr[0] == "1"){
                        setTimeout(function() {
                            showmodal("alert", arr[1], "canceladd_hierar", null, "", null, "0");                    
                        }, 500);
                    }else if(arr[0] == "2"){
                        setTimeout(function() {
                            showmodal("alert", arr[1], "canceladd_hierar", null, "", null, "0");                    
                        }, 500);
                    }else{
                        setTimeout(function() {
                            showmodal("alert", "Something went wrong.", "canceladd_hierar", null, "", null, "0");                   
                        }, 500);
                    }
                }
            })
        }else{
            setTimeout(function() {
                showmodal("alert", "Please fill required fields.", "", null, "", null, "0");                   
            }, 500);
        }
    }

    function canceladd_hierar(){
        $("#modal_hierarchy select").prop('disabled','disabled');
        $("#modal_hierarchy select").val([]).trigger("change");
        $("#modal_hierarchy select").val("");
        $("#btn-defaultdisplayhierarchy").css("display", "block");
        $("#btn-edithierarchy").css("display", "none");
        $("#btn-addhierarchy").css("display", "none");
        $("#modal_hierarchy :input").val("");
        tbldisplayhierarchy2();
        $(".txtallhierarchy").css("border-color", "#b5b5b5");
    }

    function canceledit_hierarchy(){
        $("#modal_hierarchy select").prop('disabled','disabled');
        $("#modal_hierarchy select").val([]).trigger("change");
        $("#modal_hierarchy select").val("");
        $("#btn-defaultdisplayhierarchy").css("display", "block");
        $("#btn-edithierarchy").css("display", "none");
        $("#modal_hierarchy :input").val("");
        tbldisplayhierarchy2();
    }

    function tbldisplayhierarchy(){  
        var key = $("#txtsearchhierar").val();
        $.ajax({
            type: 'POST',
            url: 'setup/user/kevlclass.php',
            data: 'bilang2=' + bilang2 + '&key=' + key + '&form=tbldisplayhierarchy',
            success:function(data){
                var arr = data.split("|");
                $("#txthierarchylist").html(arr[0]);
                var getCount = Number( arr[1] )/10;
                var getCount2 = String(getCount);
                var arr2 = getCount2.split(".");
                $("#bilang2hierarchy").val(arr2[0]);
                pickappr_hieerarchy();
                if(getCount <= 1){
                    $(".btn-useraccess2hie").attr("disabled","disabled");
                }else{
                    if(bilang2 == 0){
                        $(".btn-useraccess2hie-2").removeAttr("disabled");
                        $(".btn-useraccess2hie-1").attr("disabled","disabled");
                    }else if(Number(arr2[0]) * 10 == bilang2){
                        $(".btn-useraccess2hie-1").removeAttr("disabled");
                        $(".btn-useraccess2hie-2").attr("disabled","disabled");
                    }else{
                        $(".btn-useraccess2hie").removeAttr("disabled");
                    }
                }
            }
        })
    }

    function pickappr_hieerarchy(){
        $("#txthierarchylist tr").each(function(){
            $(this).click(function(){
                $("#txthierarchylist tr").removeClass("selected");
                $(this).addClass("selected");
                var id = this.id;
                $.ajax({
                    type: 'POST',
                    url: 'setup/user/kevlclass.php',
                    data:  'id=' + id + '&form=getthispick_hie',
                    beforeSend:function(){
                    },
                    success: function(data) {
                        var arr = data.split("|");
                        $("#txthiearchyidx").val(id);
                        $("#txthiemaincode").val([arr[0]]).trigger('change');
                        $("#txthiemainmodule").val(arr[1]);
                        $("#txthiemainrole").val([arr[2]]).trigger('change');
                        $("#txthiemainlevel").val(arr[3]);
                        $("#txthiemaindefault").val(arr[4]);
                        $("#txthiemainproperty").val([arr[5]]).trigger('change');
                    }
                })

            })
        })
    }

    function tbldisplayhierarchy2(){
        bilang2 = 0;
        tbldisplayhierarchy();
    }

    function pickB_hierarchy(txt) {
        if(txt == 'first'){
            bilang2 = 0;
            tbldisplayhierarchy();
        }else if(txt == 'prev'){
            bilang2 = Number(bilang2) - 10;
            tbldisplayhierarchy();
        }else if(txt == 'next'){
            bilang2 = Number(bilang2) + 10;
            tbldisplayhierarchy();
        }else{
            bilang2 = Number($("#bilang2hierarchy").val()) * 10;
            tbldisplayhierarchy();
        }
    }

    function clickedit_hierarchy(){
        if($("#txthiearchyidx").val() == ""){
            setTimeout(function() {
                showmodal("alert", "Select code first.", "", null, "", null, "1");
            }, 500);
        }else{
            $("#modal_hierarchy select").prop('disabled',false);
            $("#btn-defaultdisplayhierarchy").css("display", "none");
            $("#btn-edithierarchy").css("display", "block");
            $("#txthierarchylist tr").unbind("click");
        }
    }

    function delete_hierarchy(){
        if($("#txthiearchyidx").val() == ""){
            setTimeout(function() {
                showmodal("alert", "Select code first.", "", null, "", null, "1");
            }, 500);
        }else{
            setTimeout(function() {
                showmodal("confirm", "Are you sure you want to delete this?", "delete_hierarchy2", null, "", null, "1");
            }, 500);
        }
    }

    function delete_hierarchy2(){
        var id = $("#txthiearchyidx").val();
        $.ajax({
            type: 'POST',
            url: 'setup/user/kevlclass.php',
            data: 'id=' + id + '&form=delete_hierarchy2',
            success:function(data){
                var arr = data.split("|");
                if(arr[0] == "1"){
                    setTimeout(function() {
                        showmodal("alert", arr[1], "canceladd_hierar", null, "", null, "0");                    
                    }, 500);
                }else if(arr[0] == "2"){
                    setTimeout(function() {
                        showmodal("alert", arr[1], "canceladd_hierar", null, "", null, "0");                    
                    }, 500);
                }else{
                    setTimeout(function() {
                        showmodal("alert", "Something went wrong.", "canceleditall", null, "", null, "0");                   
                    }, 500);
                }
            }
        })
    }

    function hidemodallhierarchy(){
        $("#modal_hierarchy").modal("hide");
    }

    function showmodalhcodelist(){
        normal_hiecodelist();
        $("#modal_hiecodelist").modal('show');
    }

    function showtblhiecodelist(){
        var key = $("#txtsearchhiecode").val();
        $.ajax({
            type: 'POST',
            url: 'setup/user/kevlclass.php',
            data: 'bilang=' + bilang + '&key=' + key + '&form=showtblhiecodelist',
            success:function(data){
                var arr = data.split("|");
                if(arr[0].trim() == ""){
                    $("#tblhiecodelist").html("<tr><td colspan='2' style='text-align: center;'>No Data Found...</td></tr>");
                }else{
                    $("#tblhiecodelist").html(arr[0]);
                    var getCount = Number( arr[1] )/10;
                    var getCount2 = String(getCount);
                    var arr2 = getCount2.split(".");
                    $("#bilanghierarchy").val(arr2[0]);
                    pickhierarchycode();
                    if(getCount <= 1){
                        $(".btn-useraccess").attr("disabled","disabled");
                    }else{
                        if(bilang == 0){
                            $(".btn-useraccess-h2").removeAttr("disabled");
                            $(".btn-useraccess-h1").attr("disabled","disabled");
                        }else if(Number(arr2[0]) * 10 == bilang){
                            $(".btn-useraccess-h1").removeAttr("disabled");
                            $(".btn-useraccess-h2").attr("disabled","disabled");
                        }else{
                            $(".btn-useraccess").removeAttr("disabled");
                        }
                    }
                }
            }
        })
    }

    function showtblhiecodelist2(){
        bilang = 0;
        showtblhiecodelist();
    }

    function pickA_hiecode(txt){
        if(txt == 'first'){
            bilang = 0;
            showtblhiecodelist();
        }else if(txt == 'prev'){
            bilang = Number(bilang) - 10;
            showtblhiecodelist();
        }else if(txt == 'next'){
            bilang = Number(bilang) + 10;
            showtblhiecodelist();
        }else{
            bilang = Number($("#bilanghierarchy").val()) * 10;
            showtblhiecodelist();
        }
    }

    function pickhierarchycode(){
        $("#tblhiecodelist tr").each(function(){
            $(this).click(function(){
                $("#tblhiecodelist tr").removeClass("selected");
                $(this).addClass("selected");
                var id = this.id;
                var hierarcyid = $(this).find(".textreqhieid").text();
                var hierarchydesc = $(this).find(".textreqhiedesc").text();
                $("#txthiecodeadd").val(hierarchydesc);
                $("#txthiecodeaddid").val(hierarcyid);
            })
        })
    }

    function clickaddhie(){
        $(".txtronly_hie").removeAttr("readonly", "readonly");
        $("#btn-defaultdisplayhiecode").css("display", "none");
        $("#btn-addhiecode").css("display", "block");
        $("#modal_hiecodelist :input").val("");
        $("#tblhiecodelist tr").unbind("click");
    }

    function saveaddhiecode(){
        var txthiecodeadd = $("#txthiecodeadd").val();
        if(txthiecodeadd == ""){
            setTimeout(function() {
                showmodal("alert", "Please enter the code you want to add.", "", null, "", null, "1");
            }, 500);
        }else{
            $.ajax({
                type: 'POST',
                url: 'setup/user/kevlclass.php',
                data: 'txthiecodeadd=' + encodeURIComponent(txthiecodeadd) + '&form=saveaddhiecode',
                success:function(data){
                    var arr = data.split("|");
                    if(arr[0] == "1"){
                        setTimeout(function() {
                            showmodal("alert", arr[1], "normal_hiecodelist", null, "", null, "0");                    
                        }, 500);
                    }else if(arr[0] == "2"){
                        setTimeout(function() {
                            showmodal("alert", arr[1], "normal_hiecodelist", null, "", null, "0");                    
                        }, 500);
                    }else if (arr[0] == "3"){
                        setTimeout(function() {
                            showmodal("alert", arr[1], "", null, "", null, "0");                   
                        }, 500);
                    }
                }
            })
        }
    }

    function normal_hiecodelist(){
        $(".txtronly_hie").attr("readonly", "readonly");
        $("#btn-defaultdisplayhiecode").css("display", "block");
        $("#btn-addhiecode").css("display", "none");
        $("#modal_hiecodelist :input").val("");
        showtblhiecodelist2();
    }

    function clickedithie(){
        if( $("#txthiecodeaddid").val() == ""){
            setTimeout(function() {
                showmodal("alert", "Select hiearchy code first.", "", null, "", null, "1");
            }, 500);
        }else{
            $(".txtronly_hie").removeAttr("readonly", "readonly");
            $("#btn-defaultdisplayhiecode").css("display", "none");
            $("#btn-edithiecode").css("display", "block");
            $("#tblhiecodelist tr").unbind("click");
        }
    }

    function savedithiecode(){
        var txthiecodeaddid = $("#txthiecodeaddid").val();
        var txthiecodeadd = $("#txthiecodeadd").val();
        if(txthiecodeadd == ""){
            setTimeout(function() {
                showmodal("alert", "Please enter the code you want to add.", "", null, "", null, "1");
            }, 500);
        }else{
            $.ajax({
                type: 'POST',
                url: 'setup/user/kevlclass.php',
                data: 'txthiecodeaddid=' + txthiecodeaddid + '&txthiecodeadd=' + encodeURIComponent(txthiecodeadd) + '&form=savedithiecode',
                success:function(data){
                    var arr = data.split("|");
                    if(arr[0] == "1"){
                        setTimeout(function() {
                            showmodal("alert", arr[1], "normal_hiecodelist_edit", null, "", null, "0");                    
                        }, 500);
                    }else if(arr[0] == "2"){
                        setTimeout(function() {
                            showmodal("alert", arr[1], "", null, "", null, "0");                    
                        }, 500);
                    }
                }
            })
        }
    }

    function normal_hiecodelist_edit(){
        $(".txtronly_hie").attr("readonly", "readonly");
        $("#btn-defaultdisplayhiecode").css("display", "block");
        $("#btn-edithiecode").css("display", "none");
        $("#modal_hiecodelist :input").val("");
        showtblhiecodelist2();
    }

    function deletehierarchycode(){
        if( $("#txthiecodeaddid").val() == ""){
            setTimeout(function() {
                showmodal("alert", "Select hiearchy code first.", "", null, "", null, "1");
            }, 500);
        }else{
            setTimeout(function() {
                showmodal("confirm", "Are you sure you want to delete "+$("#txthiecodeadd").val()+"?", "deletehierarchycode2", null, "", null, "1");
            }, 500);
        }
    }

    function deletehierarchycode2(){
        var txthiecodeaddid = $("#txthiecodeaddid").val();
        var txthiecodeadd = $("#txthiecodeadd").val();
        $.ajax({
            type: 'POST',
            url: 'setup/user/kevlclass.php',
            data: 'txthiecodeaddid=' + txthiecodeaddid + '&txthiecodeadd=' + txthiecodeadd + '&form=deletehierarchycode2',
            success:function(data){
                var arr = data.split("|");
                if(arr[0] == "1"){
                    setTimeout(function() {
                        showmodal("alert", arr[1], "normal_hiecodelist_edit", null, "", null, "0");                    
                    }, 500);
                }else if(arr[0] == "2"){
                    setTimeout(function() {
                        showmodal("alert", arr[1], "normal_hiecodelist_edit", null, "", null, "0");                    
                    }, 500);
                }else{
                    setTimeout(function() {
                        showmodal("alert", "Something went wrong.", "normal_hiecodelist_edit", null, "", null, "0");                   
                    }, 500);
                }
            }
        })
    }

    function hidemodalhiecode(){
        $("#modal_hiecodelist").modal("hide");
    }
</script>