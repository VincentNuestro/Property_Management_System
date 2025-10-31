<script type="text/javascript">
    $(function(){
        $(".fixTable").tableHeadFixer(); 
        $("#txt_userpage").val("1");
        displaygroupname();
        filterbygroup2();
        $("#txttermsanconditionsearch").keyup(function(e){
            var x = event.keyCode;
            if(x == 13){ 
                $("#txt_userpage").val("1");
                displaygroup(); 
            }else if(x == '8'){
                if($('#txttermsanconditionsearch').val() == ""){
                    $("#txt_userpage").val("1");
                    displaygroup();
                }
            }
        });
    })

    function displaygroup() {
        var page = $("#txt_userpage").val();
    	var groupname = $("#filterbygroup2").val();
    	var txttermsanconditionsearch = $("#txttermsanconditionsearch").val();
        $.ajax ({
            type: 'POST',
            url: 'setup/termsandcondition/class.php',
            data: 'page=' + page + '&txttermsanconditionsearch=' + txttermsanconditionsearch + '&groupname=' + groupname + '&form=displaygroup',
            beforeSend : function() {
                $('#indexloadingscreen').addClass('myspinner');
            },
            success: function(data){
                $('#indexloadingscreen').removeClass('myspinner');
                if(data != ""){
                    $("#displaygroup").html(data);
                }else{
                    $("#displaygroup").html("<tr><td colspan='5' style='text-align: center;'>No Data Found...</td></tr>");
                }
                loadentries();
                loadpagetac();
            }
        })
    }

    function loadentries(){
        var page = $("#txt_userpage").val();
        var txttermsanconditionsearch = $("#txttermsanconditionsearch").val();
        var groupname = $("#filterbygroup2").val();
        $.ajax({
            type: 'POST',
            url: 'setup/termsandcondition/class.php',
            data: 'groupname=' + groupname + '&page=' + page + '&txttermsanconditionsearch=' + txttermsanconditionsearch + '&form=loadentries',
            success: function(data){
                if(data == "no data"){
                    $("#txttacentries").text("");
                }else{
                    $("#txttacentries").text(data);
                }
            }
        });
    }

    function loadpagetac(){
        var page = $("#txt_userpage").val();
        var txttermsanconditionsearch = $("#txttermsanconditionsearch").val();
        var groupname = $("#filterbygroup2").val();
        $.ajax({
            type: 'POST',
            url: 'setup/termsandcondition/class.php',
            data: 'groupname=' + groupname + '&page=' + page + '&txttermsanconditionsearch=' + txttermsanconditionsearch + '&form=loadpagetac',
            success: function(data){
                $("#ulpaginationtac").html(data);
            }
        });
    }

    function pagination(page, pagenums){
        $(".pgnumtac").removeClass("active");
        $("#pgtac" + pagenums).addClass("active");
        $("#txt_userpage").val(page);
        displaygroup();
    }

    function loadmodal_newgroup(){
    	$("#modal_newgroup").modal("show");
    }

    function unloadmodal_newgroup(){
    	$("#modal_newgroup").modal("hide");
        $(".txttac").val("");
    }

    function loadmodal_addgroup(){
        $("#modal_addgroup").modal("show");
    }

    function unloadmodal_addgroup(){
        $("#modal_addgroup").modal("hide");
        $("#txttac_group").val("");
    }

    function loadmodal_editgroup(id, groupid){
        $("#modal_editgroup").modal("show");
        $("#getid").val(id+"|"+groupid);
        $.ajax({
            type: 'POST',
            url: 'setup/termsandcondition/class.php',
            data: 'getid=' + id + '&form=loadeditgroup',
            beforeSend : function() {
                $('#preloadModal_editgroup').addClass('myspinner');
            },
            success:function(data){
                $('#preloadModal_editgroup').removeClass('myspinner');
                var arr = data.split("|");
                $("#groupdd2").val(arr[1]);
                $("#update_terms").val(arr[2]);
                $("#update_condition").val(arr[3]);
                $(".stats").each(function(){
                    if($(this).val() == arr[4])
                    { $(this).prop("checked", true); }
                });
            }
        })    
    }

    function unloadmodal_editgroup(){
        $("#modal_editgroup").modal("hide");
        $(".erequired").val("");
    }

    function savegroup() {
        var Group_Name = $("#txttac_group").val();
        $.ajax({
            type: 'POST',
            url: 'setup/termsandcondition/class.php',
            data: 'txttac_group=' + encodeURIComponent(Group_Name)  + '&form=addnewgroup',
            success: function(data) {
                if(data == 1){
                    setTimeout(function(){
                        showmodal("alert", "Successfully Added a New Group.", "", null, "", null, "0");
                    }, 500)
                    displaygroupname();
                    unloadmodal_addgroup();
                }else{
                    setTimeout(function(){
                        showmodal("alert", data, "", null, "", null, "1");
                    }, 500)
                }

            }
        })
    }

    function saveterms() {
        var groupid = $("#groupdd").val();
        var terms = $("#txttac_terms").val();
        var condition = $("#txttac_condition").val();
        // $(".conditionssss").each(function(){
        //     condition += "|" + $(this).find(".cons").val();
        // })
        // alert(condition);
        var countinput = 0;
        $("#modal_newgroup .required").each(function() {
            if($(this).val() == ""){
                countinput = countinput +1;
            }
        })
        if(countinput == 0){
            $.ajax({
                type: 'POST',
                url: 'setup/termsandcondition/class.php',
                data: 'groupid=' + encodeURIComponent(groupid) + '&terms=' + encodeURIComponent(terms) + '&condition=' + encodeURIComponent(condition) + '&form=saveterms',
                success: function(data){
                    if(data == 1){
                        setTimeout(function(){
                            showmodal("alert", "Successfully Added a New Terms and Conditions.", "", null, "", null, "0");
                        }, 500)
                        unloadmodal_newgroup();
                        displaygroup();
                        displaygroupname();
                    }else{
                        setTimeout(function(){
                            showmodal("alert", data, "", null, "", null, "1");
                        }, 500)
                    }
                }
                
            })
        }else{
            setTimeout(function(){
                showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
            }, 500)
        }
    }


    function updategroup(){
        var id = $("#getid").val();
        var groupid = $("#groupdd2").val();
        var terms = $("#update_terms").val();
        var condition = $("#update_condition").val();
        var stats = "";
        $(".stats").each(function(){
            if ( $(this).prop("checked") ) {
                stats = this.value;
            }
        })
        var countinput = 0;
        $("#modal_editgroup .erequired").each(function() {
            if($(this).val() == ""){
                countinput = countinput +1;
            }
        })

        if(countinput == 0){
            $.ajax({
                type: 'POST',
                url: 'setup/termsandcondition/class.php',
                data: 'id=' + id + '&groupid=' + encodeURIComponent(groupid) + '&terms=' + encodeURIComponent(terms) + '&condition=' + encodeURIComponent(condition) + '&stats=' + stats + '&form=updategroup',
                success: function(data){
                    if(data == 1){
                        showmodal("alert", "Successfully Updated Terms and Conditions.", "", null, "", null, "0");
                        unloadmodal_editgroup();
                        displaygroup();
                    }else{
                        setTimeout(function(){
                            showmodal("alert", data, "", null, "", null, "1");
                        }, 500)
                    }
                }     
            })
        }else{
            setTimeout(function(){
                showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
            }, 500)
        }
    }

    function selectgroup(id) { 
        $.ajax({
            type: 'POST',
            url:"setup/termsandcondition/class.php",
            data: "id=" + id + "&form=selectgroup",
            success: function(data) {

                var arr = data.split("|");
                $("#selectgroup").val(arr[2]);
                $("#txttac_terms").val(arr[0]);
                $("#txttac_condition").val(arr[1]);
            }
        })
    }

    function displaygroupname(){
        $.ajax({
            type: 'POST',
            url: 'setup/termsandcondition/class.php',
            data: 'form=displaygroupname',
            success: function(data){
                $("#groupdd").html(data);
            }
        })
    }

    function selectgroup2(id) { 
        $.ajax({
            type: 'POST',
            url:"setup/termsandcondition/class.php",
            data: "id=" + id + "&form=selectgroup2",
            success: function(data) {

                var arr = data.split("|");
                $("#selectgroup2").val(arr[2]);
                $("#update_terms").val(arr[0]);
                $("#update_condition").val(arr[1]);
            }
        })
    }

    function filterbygroup2(){
	   $.ajax({
    	    type: 'POST',
    	    url: 'setup/termsandcondition/class.php',
    	    data: 'form=filterbygroup2',
    	    success: function(data){
	        	$("#filterbygroup2").html(data);
	    	},
            complete: function(){
                displaygroup();
            }
	    })
	}
</script>