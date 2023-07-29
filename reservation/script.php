<script type="text/javascript">
	$(function(){
		$(".fixTable").tableHeadFixer();
		$("#txtReservationPageCount").val("1");
		loadReservationList();
		$("#txtReservationKey").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtReservationPageCount").val("1");
				loadReservationList(); 
			}else if ( x == '8' ){
				if($('#txtReservationKey').val() == ""){
					$("#txtReservationPageCount").val("1");
					loadReservationList();
				}
			}
		});
	})
	
	function loadReservationList(){
		var key = $("#txtReservationKey").val();
		var page = $("#txtReservationPageCount").val();
		$.ajax({
			type: 'POST',
			url: 'reservation/class.php',
			data: 'key=' + key + '&page=' + page + '&form=loadReservationList',
			beforeSend : function() {
                $('#indexloadingscreen').addClass('myspinner');
            },
            success: function(data){
                $('#indexloadingscreen').removeClass('myspinner');
				if(data != ""){
		          	$("#tblReservationList").html(data);
		          	
		        }else{
		          	$("#tblReservationList").html("<tr><td colspan='15' style='text-align: center;'>No Data Found...</td></tr>");
		        }
		        loadReservationEntries();
				loadReservationPagination();
			}
		})
	}

	function loadReservationEntries(){
		var key = $("#txtReservationKey").val();
		var page = $("#txtReservationPageCount").val();
        $.ajax({
            type: 'POST',
            url: 'reservation/class.php',
            data: 'key=' + key + '&page=' + page + '&form=loadReservationEntries',
            success: function(data){
                $("#txtReservationEntries").text(data);
            }
        })
	}

	function loadReservationPagination(){
		var key = $("#txtReservationKey").val();
		var page = $("#txtReservationPageCount").val();
        $.ajax({
            type: 'POST',
            url: 'reservation/class.php',
            data: 'key=' + key + '&page=' + page + '&form=loadReservationPagination',
            success: function(data){
                $("#ulReservationPagination").html(data);
            }
        })
	}
	
	function ClickPaginationFunc(page, pagenums){
	    $(".pgnumReservation").removeClass("active");
	    $("#pgReservation" + pagenums).addClass("active");
	    $("#txtReservationPageCount").val(page);
	    loadReservationList();
	}

	function saveReservationFilter(){
        var module = "Reservation";
        var checked = "";
        $('input:checkbox[name="form-field-checkboxkeywordres"]').each(function(){
            if($(this).is(":checked")){
                var value = $(this).attr("value");
                checked += value + "|";
            }
        })
        var checked2 = "";
        $('input:checkbox[name="form-field-checkboxkeywordres"]').each(function(){
            var value2 = $(this).attr("value");
            checked2 += value2 + "|";
        }) 
        var checked3 = "";
        $('input:checkbox[name="form-field-checkbox2"]').each(function(){
            if($(this).is(":checked")){
                var value3 = $(this).attr("value");
                checked3 += value3 + "|";
            }
        })     
        if($("#chkoccdate").is(":checked")){ var xcheck = "chkoccdate"; }
		if($("#chkappdate").is(":checked")){ var xcheck = "chkappdate"; }  
		var Date1 = $("#txtdiv_strtocc").val();
		var Date2 = $("#txtdiv_endocc").val();
		var Date3 = $("#txtdiv_strtapp").val();
		var Date4 = $("#txtdiv_endapp").val();
        $.ajax({
            type: 'POST',
            url: 'filter/class.php',
            data: 'module=' + module + '&checked=' + checked + '&checked2=' + checked2 + '&checked3=' + checked3 + '&Date1=' + Date1 + '&Date2=' + Date2 + '&Date3=' + Date3 + '&Date4=' + Date4 + '&xcheck=' + xcheck + '&form=saveFilters',
            success: function(data){
                $("#LINK_Reservation_filter").click();
                loadReservationList();
            }
        })
    }

    function loadFilterReservation(module){
        $.ajax({
            type: 'POST',
            url: 'filter/class.php',
            data: 'module=' + module + '&form=loadFilters',
            success: function(data){
                var arr = data.split("#");
                var arr2 = arr[0].split("|");
                for(var i=0; i<=arr2.length-2; i++){
                    $('input:checkbox[id="filter_'+arr2[i]+'"][value="'+arr2[i]+'"]').attr('checked', 'checked');
                }
                var arr3 = arr[1].split("|");
                $("#txtdiv_strtocc").val(arr3[0]);
				$("#txtdiv_endocc").val(arr3[1]);
				$("#txtdiv_strtapp").val(arr3[2]);
				$("#txtdiv_endapp").val(arr3[3]);
				arr4 = arr[2].split("|");
				for(var i=0; i<=arr4.length-1; i++){
                    $('input:checkbox[id="filter_'+arr4[i]+'"][value="'+arr4[i]+'"]').attr('checked', 'checked');
                }               
				if(arr[3] == "chkoccdate"){
					$("#chkoccdate").prop("checked", true);
					chkoccdate();
				}else{
					$("#chkappdate").prop("checked", true);
					chkappdate();
				}
            }
        })
    }

    function chkoccdate(){
		var eto = $("#chkoccdate");
		if(eto.is(":checked")){
			$("#chkappdate").prop("checked", false);
			$("#div_chkappdate").css("background-color", "#f5f5f0");
			$("#div_chkoccdate").css("background-color", "white");
			$(".div_occ").prop("disabled", false);
			$(".div_app").prop("disabled", true);
		}else{
			$("#chkoccdate").prop("checked", true);
		}
	}

	function chkappdate(){
		var eto = $("#chkappdate");
		if(eto.is(":checked")){
			$("#chkoccdate").prop("checked", false);
			$("#div_chkoccdate").css("background-color", "#f5f5f0");
			$("#div_chkappdate").css("background-color", "white");
			$(".div_occ").prop("disabled", true);
			$(".div_app").prop("disabled", false);
		}else{
			$("#chkappdate").prop("checked", true);
		}
	}

	function ViewReservationLogs(InquiryID){
		$("#modal_ReservationLogs").modal("show");
		var module = 'Reservation Module'
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'LogID=' + InquiryID + '&module=' + module + '&form=ViewAllHistory',
			success: function(data){
				$("#tblReservationLogs").html(data);
			}
		})
	}

	function fncCloseReservationUpdate(){
		loadReservationList();
        $("#mdlAddNewInquiry").modal("hide");
	}

	function fncPreviewContract(InquiryID, TenantID, ContractID, CLFormat){
		$.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'tenantid=' + TenantID + '&contractID=' + ContractID + '&CLFormat=' + CLFormat + '&form=CustomContractLayout',
            success: function(data){
                $("#div_ResContract").modal("show");
                $("#div_CustomResContract").html(data);
            }
        })
	}

	function fncPrintResContract(){
		var toPrint = document.getElementById("div_CustomResContract");
        var myheight = $(window).height();
        var mywidth = $(window).width();
        var popupWin = window.open("", "", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
            popupWin.document.open();
            popupWin.document.write('<html><title></title><body onload="window.print();">' );
            popupWin.document.write( toPrint.innerHTML);
            popupWin.document.write('</body></html>');
            popupWin.document.close();
	}
</script>