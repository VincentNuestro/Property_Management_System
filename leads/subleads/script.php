<script type="text/javascript">
	$(function(){
		$("#SubLeadspages").val("1");
    	$(".fixTable").tableHeadFixer(); 
    	tblSubLeadslist();
    	$("#txtsearchSubLeads").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#SubLeadspages").val("1");
				tblSubLeadslist(); 
			}else if(x == '8'){
                if($('#txtsearchSubLeads').val() == ""){
					$("#SubLeadspages").val("1");
                    tblSubLeadslist();
                }
            }
		});
	})

	function tblSubLeadslist(){
	    var page = $("#SubLeadspages").val();
	    var key = $("#txtsearchSubLeads").val();
	    var module = "<?php echo $_GET['type']; ?>";
		$.ajax({
			type: 'POST',
			url: 'leads/subleads/class.php',
			data: 'module=' + module + '&page=' + page + '&key=' + key + '&form=tblSubLeadslist',
			beforeSend : function() {
	            $('#indexloadingscreen').addClass('myspinner');	
	        },
	        success: function(data){
	            $('#indexloadingscreen').removeClass('myspinner');
	            if(data != ""){
	                $("#tblSubLeadslist").html(data);
	            }else{
	                $("#tblSubLeadslist").html("<tr><td colspan='6' style='text-align: center;'>No Data Found...</td></tr>");
	            }
	            loadSubLeadsentries();
				loadSubLeadspage();
			}
		})
	}

	function loadSubLeadsentries(){
	    var page = $("#SubLeadspages").val();
	    var key = $("#txtsearchSubLeads").val();
	    var module = "<?php echo $_GET['type']; ?>";
	    $.ajax({
	        type: 'POST',
	        url: 'leads/subleads/class.php',
	        data: 'module=' + module + '&key=' + key + '&page=' + page + '&form=loadSubLeadsentries',
	        success: function(data){
	            if(data == ""){
	                $("#txtSubLeadsentries").text("");
	            }else{
	                $("#txtSubLeadsentries").text(data);
	            }
	        }
	    });
	}

	function loadSubLeadspage(){
	    var page = $("#SubLeadspages").val();
	    var key = $("#txtsearchSubLeads").val();
	    var module = "<?php echo $_GET['type']; ?>";
	    $.ajax({
	        type: 'POST',
	        url: 'leads/subleads/class.php',
	        data: 'module=' + module + '&key=' + key + '&page=' + page + '&form=loadSubLeadspage',
	        success: function(data){
	            $("#ulpaginationSubLeads").html(data);
	        }
	    });
	}

	function fncSubLeadPagination(page, pagenums){
	    $(".pgnumSubLeads").removeClass("active");
	    $("#pgSubLeads" + pagenums).addClass("active");
	    $("#SubLeadspages").val(page);
	    tblSubLeadslist();
	}

	function saveSubLeadsFilter(){
	    var module = "<?php echo $_GET['type']; ?>";
	    var checked = "";
	    $('input:checkbox[name="form-field-SearchSubLeads"]').each(function(){
	        if($(this).is(":checked")){
	            var value = $(this).attr("value");
	            checked += value + "|";
	        }
	    })

	    var checked2 = "";
	    $('input:checkbox[name="form-field-SearchSubLeads"]').each(function(){
	            var value2 = $(this).attr("value");
	            checked2 += value2 + "|";
	    })

	    var checked3 = "";
	    $('input:checkbox[name="form-field-checkbox-StatSubLeads"]').each(function(){
	        if($(this).is(":checked")){
	            var value3 = $(this).attr("value");
	            checked3 += value3 + "|";
	        }
	    })        

	    var Date1 = $("#SubLeadsDateFrom").val();
	    var Date2 = $("#SubLeadsDateTo").val();
	    $.ajax({
	        type: 'POST',
	        url: 'filter/class.php',
	        data: 'module=' + module + '&checked=' + checked + '&checked2=' + checked2 + '&checked3=' + checked3 + '&Date1=' + Date1 + '&Date2=' + Date2 + '&form=saveFilters',
	        success: function(data){
	            tblSubLeadslist();
	            $("#LINK_SubLeads_filter").click();
	        }
	    })
	}

	function loadSubLeadsFilter(){
	    var module = "<?php echo $_GET['type']; ?>";
	    $.ajax({
	        type: 'POST',
	        url: 'filter/class.php',
	        data: 'module=' + module + '&form=loadFilters',
	        success: function(data){
	            var datas = data.split("#");
	            var arr = datas[0].split("|");
	            var arr2 = datas[1].split("|");
	            var arr3 = datas[2].split("|");
	            for(var i=0; i<=arr.length-1; i++){
	                $('input:checkbox[id="filter_'+arr[i]+'"][value="'+arr[i]+'"]').attr('checked', 'checked');
	            }
	            $("#SubLeadsDateFrom").val(arr2[0]);
	            $("#SubLeadsDateTo").val(arr2[1]);
	            for(var i=0; i<=arr3.length-1; i++){
	                $('input:checkbox[id="filter_'+arr3[i]+'"][value="'+arr3[i]+'"]').attr('checked', 'checked');
	            }
	        }
	    })
	}

	function btnDeleteSubLeads(SubLeadsID){
        showmodal("confirm", "Are you sure you want to delete this <?php echo $_GET['type']; ?>", "btnDeleteSubLeads2", SubLeadsID+"|", "", null, "1");
	}

	function btnDeleteSubLeads2(SubLeadsID){
		var module = "<?php echo $_GET['type']; ?>";
		$.ajax({
			type: 'POST',
			url: 'leads/subleads/class.php',
			data: 'module=' + module + '&SubLeadsID=' + SubLeadsID + '&form=btnDeleteSubLeads',
			success:function(data){
				var arr = data.split("|");
				if(arr[0] == "1"){
					setTimeout(function(){
						showmodal("alert", arr[1], "HideLeadsMainModal", null, "", null, "0");
		        	}, 1000)
				}else{
					setTimeout(function(){
						showmodal("alert", arr[1], "", null, "", null, "1");
		        	}, 1000)
				}
			}
		})
	}
</script>