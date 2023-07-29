<script type="text/javascript">
	$(function(){
    	$(".fixTable").tableHeadFixer(); 
		$("#txt_userpageCSVUploadReports").val("1");
		ShowtblUploadReportList();
		$("#txtsearchCSVUploadReports").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txt_userpageCSVUploadReports").val("1");
				ShowtblUploadReportList(); 
			}else if(x == '8'){
                if($('#txtsearchCSVUploadReports').val() == ""){
					$("#txt_userpageCSVUploadReports").val("1");
                    ShowtblUploadReportList();
                }
            }
		});
	})

	function ShowtblUploadReportList(){
		var key = $("#txtsearchCSVUploadReports").val();
      	var page = $("#txt_userpageCSVUploadReports").val();
		$.ajax({
			type: 'POST',
			url: 'reports/csvuploadreport/class.php',
			data: 'key=' + key + '&page=' + page + '&form=ShowtblUploadReportList',
			success:function(data){
				$("#tblUploadReportList").html(data);
				tblUploadReportListEntries();
				tblUploadReportListPagination()
			}
		})
	}

	function tblUploadReportListEntries(){
      	var key = $("#txtsearchCSVUploadReports").val();
      	var page = $("#txt_userpageCSVUploadReports").val();
        $.ajax({
            type: 'POST',
			url: 'reports/csvuploadreport/class.php',
            data: 'key=' + key + '&page=' + page + '&form=tblUploadReportListEntries',
            success: function(data){
                $("#txtCSVUploadReportsEntries").text(data);
            }
        });
    }

    function tblUploadReportListPagination(){
      	var key = $("#txtsearchCSVUploadReports").val();
	    var page = $("#txt_userpageCSVUploadReports").val();
	    $.ajax({
	        type: 'POST',
			url: 'reports/csvuploadreport/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=tblUploadReportListPagination',
	        success: function(data){
	            $("#ulPaginationCSVUploadReports").html(data);
	        }
	    });
	}

	function tblUploadReportListPageFunc(page, pagenums){
	    $(".pgnumpCSVUploadReports").removeClass("active");
	    var value = "#" + pagenums;
	    $("#pgfileCSVUploadReports" + pagenums).addClass("active");
	    $("#txt_userpageCSVUploadReports").val(page);
	    ShowtblUploadReportList();
	}

	function saveCSVUploadReportsFilter(){
	    var module = "CSVUploadReports";
	    var checked = "";
	    $('input:checkbox[name="form-field-checkboxtradename"]').each(function(){
	        if($(this).is(":checked")){
	            var value = $(this).attr("value");
	            checked += value + "|";
	        }
	    })
	    var checked2 = "";
	    $('input:checkbox[name="form-field-checkboxtradename"]').each(function(){
	            var value2 = $(this).attr("value");
	            checked2 += value2 + "|";
	    })
	    var checked3 = "";
	    $('input:checkbox[name="form-field-checkbox-csvcount"]').each(function(){
	        if($(this).is(":checked")){
	            var value3 = $(this).attr("value");
	            checked3 += value3 + "|";
	        }
	    })
	    
	    var Date1 = $("#CSVURDateFrom").val();
	    var Date2 = $("#CSVURDateTo").val();
	    $.ajax({
	        type: 'POST',
	        url: 'filter/class.php',
	        data: 'module=' + module + '&checked=' + checked + '&checked2=' + checked2 + '&checked3=' + checked3 + '&Date1=' + Date1 + '&Date2=' + Date2 + '&form=saveFilters',
	        success: function(data){
	            $("#LINK_CSVUploadReports_filter").click();
	            ShowtblUploadReportList();
	        }
	    })
	}

	function loadCSVUploadReportsFilter(module){
	    $.ajax({
	        type: 'POST',
	        url: 'filter/class.php',
	        data: 'module=' + module + '&form=loadFilters',
	        success: function(data){
	            var datas = data.split("#");
	            var arr = datas[0].split("|");
	            var arr2 = datas[1].split("|");
	            var arr3 = datas[2].split("|");
	            var arr4 = datas[3].split("|");
	            for(var i=0; i<=arr.length-1; i++){
	                $('input:checkbox[id="filter_'+arr[i]+'"][value="'+arr[i]+'"]').attr('checked', 'checked');
	            }
	            $("#CSVURDateFrom").val(arr2[0]);
	            $("#CSVURDateTo").val(arr2[1]);
	            for(var i=0; i<=arr3.length-1; i++){
	                $('input:checkbox[id="filter_'+arr3[i]+'"][value="'+arr3[i]+'"]').attr('checked', 'checked');
	            }
	        }
	    })
	}

	function loadMallSelection(){
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=tblref_mall',
			success:function(data){
				$("#txtMallSelection").html(data);
				$("#txtTenantSelection").html("<option value=''>-- Select Tenant --</option>");
			}
		})
	}

	function loadTenantSelection(){
		var mallid = $("#txtMallSelection").val();
		$.ajax({
			type: 'POST',
			url: 'reports/csvuploadreport/class.php',
			data: 'mallid=' + mallid+ '&form=loadTenantSelection',
			success:function(data){
				$("#txtTenantSelection").html(data);
			}
		})
	}

	function printCSVUR(){
		var Mall = $("#txtMallSelection").val();
		var Tenant = $("#txtTenantSelection").val();
		var DateFrom = $("#CSVURDateFrom").val();
		var DateTo = $("#CSVURDateTo").val();
		var Stat = "";
	    $('input:checkbox[name="form-field-checkbox-printCSVUR"]').each(function(){
	        if($(this).is(":checked")){
	            var kdot = $(this).attr("value");
	            Stat += kdot + "|";
	        }
	    })
	    $.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'mallID=' + Mall + '&form=getheaderprint',
			success:function(data){
				$("#template").html(data);
			}, complete(){
				$.ajax({
					type: 'POST',
					url: 'reports/csvuploadreport/class.php',
					data: 'Mall=' + Mall + '&Tenant=' + Tenant + '&DateFrom=' + DateFrom + '&DateTo=' + DateTo + '&Stat=' + Stat + '&form=printCSVUR',
					success:function(data){
						var arr = data.split("|");
						$("#tblUploadReportListPrint").html(arr[0]);
						$("#txtCSVURPrintDateFrom").text(arr[1]);
						$("#txtCSVURPrintDateTo").text(arr[2]);
						var toprint = $("#div_CSVURPrint").html();
				        var myheight = $(window).height()-40;
				        var mywidth = $(window).width()-40;
				        var popupWin = window.open("", "_blank", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
				        popupWin.document.open();
				        popupWin.document.write("<html><head><title></title><link rel='stylesheet' href='assets/font-awesome/4.5.0/css/font-awesome.min.css' /></head><body onload='window.print();'>" + toprint + "</body></html>");
				        popupWin.document.close();
					}, complete(){

					}
				})
			},
		})
	}
</script> 