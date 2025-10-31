<script type="text/javascript">
	$(function(){
		$("#apptrpagecount").val("1");
		$(".date-picker").datepicker({
	        autoHide: true,
	        format: 'mm/dd/yyyy',
	        todayHighlight: true
	    });
	    $.mask.definitions['~']='[+-]';
	    $('.input-mask-phone').mask('(999) 999-9999', {placeholder:" ",completed:function(){var idselected = $(this).attr("id");  chkmobiledup(idselected, $(this))}});
	    $('[data-rel=tooltip]').tooltip();
    	$('[data-rel=popover]').popover({html:true});

	    $(".fixTable").tableHeadFixer(); 


		$('.timepickeronly').datetimepicker({
            format: 'LT'
        });


        $('.id-input-file').ace_file_input({
			no_file:'No File ...',
			btn_choose:'Choose',
			btn_change:'Change',
			droppable:false,
			onchange:null,
			thumbnail:false
		});

        displaytenantreqapprovallist();
	})
	


	function RequestTenantSelected(){
		$("#tblrequestlist tr").each(function(){
			var cellrow = $(this);
			cellrow.click(function(){
				openmodaltr(cellrow.attr('id'));
				$("#tblrequestlist tr").removeClass('selected');
				if ( cellrow.hasClass("selected") ) {
					cellrow.removeClass("selected")
				} else {
					cellrow.addClass("selected");
				}
			})	
		})	
	}


	function showTenantRequest(){
		$.ajax({
			type:'POST',
			url:'tenants_request/TRrequest/class.php',
			data: 'form=showTenantRequest',
			success:function(data){
				$("#txtTenantRequest").html(data);
			}
		})
	}


	function showTenantRequestCategory(){
		$.ajax({
			type: 'POST',
			url: 'tenants_request/TRrequest/class.php',
			data: 'form=showTenantRequestCategory',
			success:function(data){
				$("#RequestCat").html(data);
			}
		})
	}

	function showTenantRequestTag(){
		$.ajax({
			type: 'POST',
			url: 'tenants_request/TRrequest/class.php',
			data: 'form=showTenantRequestTag',
			success:function(data){
				$("#RequestTag").html(data);
			}
		})
	}

	function showTenantCategoryTagInfo(RequestTag){
		$.ajax({
			type: 'POST',
			url: 'tenants_request/TRrequest/class.php',
			data: 'RequestTag=' + RequestTag + '&form=showTenantCategoryTagInfo',
			success:function(data){
				// alert(data);
				$(".showTenantCategoryTagInfo").html(data);
			}
		})
	}


	function displaytenantreqapprovallist(){
		var key = $("#txtsearchapptr").val();
	    var page = $("#apptrpagecount").val();
		$.ajax({
			type: 'POST',
			url: 'tenants_request/TRApproval/class.php',
			data: 'page=' + page + '&key=' + key + '&form=displaytenantreqapprovallist',
			beforeSend : function() {
                $('#indexloadingscreen').addClass('myspinner');
            },
            success: function(data){
                $('#indexloadingscreen').removeClass('myspinner');
                if(data != ""){
                    $("#tblrequestlist").html(data);
                }else{
                    $("#tblrequestlist").html("<tr><td colspan='10' style='text-align: center;'>No Data Found...</td></tr>");
                }
                RequestTenantSelected();
			}
		})
	}


	function openmodaltr(trid){
		$.ajax({
			type: 'POST',
			url: 'tenants_request/TRrequest/class.php',
			data:  'trid=' + trid + '&form=showexistrequest',
			success:function(data){
				$(".widget-body").slideUp("fast");
				$("#wdgettenant").slideDown("fast");
				var arr = data.split("|||");
				$("#collapseThree input").val("");
				$("#collapseThree textarea").text("");
				$("#collapseThree textarea").val("");
				$("#collapseTwo input").val("");
				$("#tbltentvistorslist").html("");
				$("#tbltentitemslist").html("");
				$("#chckboxnotify").prop('checked',false);
				$("#CreateNewTenantRequest select").prop('disabled','disabled');
				$("#CreateNewTenantRequest input").prop('disabled','disabled');
				$("#CreateNewTenantRequest textarea").prop('disabled','disabled');
				$("#CreateNewTenantRequest textarea").prop('disabled','disabled');
				$(".widget-body button").hide();
				$("#ApplicationDate").val("");
				 showTenantRequest();
				 showTenantRequestCategory();
				 showTenantRequestTag();

				 setTimeout(function(){
				 	$("#txtTenantRequest").val(arr[0]);
				 	$("#ApplicationDate").val(arr[2]);
				 	
				 	$("#RequestCat").val(arr[4]);
				 	$("#Remarks").val(arr[6]);
				 	if(arr[7]=='1'){
				 		$("#chckboxnotify").prop('checked','checked');
				 	}else{
				 		$("#chckboxnotify").prop('checked',false);
				 	}
				 	getTenantCode();
				 	setTimeout(function(){ $("#RequestTag").val(arr[5]); }, 200);
				 	$("#tbltentvistorslist").html(arr[8]);
				 	$("#tbltentitemslist").html(arr[9]);
				 }, 500);



				
				$("#txttenantrequet_id").val(trid);
    			$("#CreateNewTenantRequest").modal('show');
			}
		});
    }

    function showaccord(actname){
    	$(".widget-body").slideUp("slow");
    	if($("#"+actname+"_icon").hasClass('fa-chevron-down') ){
    		$("#"+actname+"_icon").removeClass('fa-chevron-down');
    		$("#"+actname+"_icon").addClass('fa-chevron-up');
    	}else{
    		$("#"+actname+"_icon").removeClass('fa-chevron-up');
    		$("#"+actname+"_icon").addClass('fa-chevron-down');
    	}
    	$("#"+actname).slideDown("slow");
       /*setTimeout(function() {
                $("#"+actname).show();                    
        }, 300);*/
    }


	function closeTenantRequest(){
		$("#CreateNewTenantRequest").modal("hide"); 
		$(".txtTRrequired").val("");
		$("#Remarks").val("");
		$(".txtTRrequired").css("border-color","#D5D5D5");
		displaytenantreqapprovallist();
	}

	function getTenantCode(){
		showTenantCategoryTagInfo($('#RequestCat').val());
	}

	function openmodalremarks(approved){
		$("#txttypeapproved").val(approved);
		$("#lblapprovedtype").text(approved);
		$("#txtapproveremarks").val("");
		$("#modalapproverremarks").modal('show');
	}

	function closemodalremarks(){
		$("#txttypeapproved").val("");
		$("#txtapproveremarks").val("");
		$("#modalapproverremarks").modal('hide');
	}



	function saveapprovetrequest(){
	    var txttypeapproved = $("#txttypeapproved").val();     
	    showmodal("confirm", "Are you sure you want to "+txttypeapproved+" this request?", "saveapprovetrequest2", null, "", null, "1");      
	}

	function saveapprovetrequest2(){
		var txttenantrequet_id = $("#txttenantrequet_id").val();
	    var txttypeapproved = $("#txttypeapproved").val();  
	    var txtapproveremarks = $("#txtapproveremarks").val();     
		$.ajax({
			type: 'POST',
			url: 'tenants_request/TRApproval/class.php',
			data: 'txttenantrequet_id=' + txttenantrequet_id + '&txttypeapproved=' + txttypeapproved + '&appremarks=' + encodeURIComponent(txtapproveremarks) + '&form=saveapprovetrequest',
			beforeSend : function() {
                $('#indexloadingscreen').addClass('myspinner');
            },
            success: function(data){
            	if(data=='1'){
            		$("#modalapproverremarks").modal('hide');
            		closeTenantRequest();
            	}else{
            		showmodal("alert", "Something want wrong."+data, "", null, "", null, "0");    
            	}
			}
		})
	}

	function openimagevisitor(imagename){
    	$("#txtimageviewx").attr('src','../../mall_images/tenant_request/'+imagename);
    	$("#modalviewimagesx").modal('show');
    }

    function closeimagevisitor(){
    	$("#modalviewimagesx").modal('hide');
    }
</script>