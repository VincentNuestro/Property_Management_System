<script type="text/javascript">
	$(function(){
    	$("#txtMainComplaintsPageCount").val("1");
        loadMainComplaints();
        $("#txtsearchcomplaints").keyup(function(e){
            var x = event.keyCode;
            if(x == 13){ 
                $("#txtMainComplaintsPageCount").val("1");
                loadMainComplaints(); 
            }else if(x == '8'){
                if($('#txtsearchcomplaints').val() == ""){
                    $("#txtMainComplaintsPageCount").val("1");
                    loadMainComplaints();
                }
            }
        });
	})

	function loadMainComplaints() {
        var page = $("#txtMainComplaintsPageCount").val();
        var key = $("#txtsearchcomplaints").val();
        $.ajax({
            type: 'POST',
            url: 'maintenance/complaints/class.php',
            data: 'page=' + page + '&key=' + key + '&form=loadMainComplaints',
            beforeSend : function() {
                $('#indexloadingscreen').addClass('myspinner');
            },
            success: function(data) {
                $('#indexloadingscreen').removeClass('myspinner');
                if(data != ""){
                    $("#tblMainComplaints").html(data);
                }else{
                    $("#tblMainComplaints").html("<tr><td colspan='10' style='text-align: center;'>No Data Found...</td></tr>");
                }
                loadMainComplaintsEntries();
                loadMainComplaintsPage();
            }
        })
	}

	function loadMainComplaintsEntries(){
    	var page = $("#txtMainComplaintsPageCount").val();
        var key = $("#txtsearchcomplaints").val();
        $.ajax({
            type: 'POST',
            url: 'maintenance/complaints/class.php',
            data: 'page=' + page + '&key=' + key + '&form=loadMainComplaintsEntries',
            success: function(data){
                $("#txtMainComplaintsEntries").text(data);
            }
        });
    }

	function loadMainComplaintsPage(){
    	var page = $("#txtMainComplaintsPageCount").val();
        var key = $("#txtsearchcomplaints").val();
	    $.ajax({
	        type: 'POST',  
	        url: 'maintenance/complaints/class.php',
	        data: 'page=' + page + '&key=' + key + '&form=loadMainComplaintsPage',
	        success: function(data){
	            $("#ulMainComplaintsPage").html(data);
	        }
	    });
	}

	function pagination(page, pagenums){
	    $(".pgnumpcomplaints").removeClass("active");
	    $("#pgcomplaints" + pagenums).addClass("active");
	    $("#txtMainComplaintsPageCount").val(page);
	    loadMainComplaints();
	}

    function loadComplaintFilter(module){
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
	            $("#dateentrystart2").val(arr2[0]);
	            $("#dateentryend2").val(arr2[1]);
	            for(var i=0; i<=arr3.length-1; i++){
	                $('input:checkbox[id="filter_'+arr3[i]+'"][value="'+arr3[i]+'"]').attr('checked', 'checked');
	            }
	            for(var i=0; i<=arr4.length-1; i++){
	                $('input:checkbox[id="filter_'+arr4[i]+'"][value="'+arr4[i]+'"]').attr('checked', 'checked');
	            }
	        }
    	})
	}

    function saveComplaintFilter(){
        var module = "Complaint";
        var checked = "";
        $('input:checkbox[name="form-field-checkboxph"]').each(function(){
            if($(this).is(":checked")){
                var value = $(this).attr("value");
                checked += value + "|";
            }
        })
        var checked2 = "";
        $('input:checkbox[name="form-field-checkboxph"]').each(function(){

                var value2 = $(this).attr("value");
                checked2 += value2 + "|";
        })
        var checked3 = "";
        $('input:checkbox[name="form-field-checkbox-pstat2"]').each(function(){
          if($(this).is(":checked"))
          {
            var value3 = $(this).attr("value");
            checked3 += value3 + "|";
          }
        })
        var xcheck = "";
        $('input:checkbox[name="form-field-checkbox-fbcs"]').each(function(){
          if($(this).is(":checked"))
          {
            var value4 = $(this).attr("value");
            xcheck += value4 + "|";
          }
        })
        var Date1 = $("#dateentrystart2").val();
        var Date2 = $("#dateentryend2").val();
        $.ajax({
            type: 'POST',
            url: 'filter/class.php',
            data: 'module=' + module + '&checked=' + checked + '&checked2=' + checked2 + '&checked3=' + checked3 + '&xcheck=' + xcheck + '&Date1=' + Date1 + '&Date2=' + Date2 + '&form=saveFilters',
            success: function(data){
                loadMainComplaints();
                $("#LINK_Complaint_filter").click();
            }
        })
    }

    function showfilterngcomplaints(){
    	$("#pangcomplaints").css("display", "block");
    }

    function hidefilterngcomplaints(){
    	$("#pangcomplaints").css("display", "none");    
    }

    function setcomplaintastask(tenantid, complaint_code, complaints_cdescription, customer_name, unitname, complaint_series_no){
    	$("#complaintsmodal").modal("show");
    	$("#complaints_tenantsid").text(tenantid);
		$("#complaints_ccode").text(complaint_code);
		$("#complaints_cdescription").text(complaints_cdescription);
		$("#complaints_ccname").text(customer_name);
		$("#complaints_unit").text(unitname);
		$("#nakatagodahilhindikayangipagsigawan").val(complaint_series_no);
    }

    function savecomplaintsmodal(){
    	var tenantid = $("#complaints_tenantsid").text();
		var complaint_code = $("#complaints_ccode").text();
		var complaints_description = $("#complaints_cdescription").text();
		var customer_name = $("#complaints_ccname").text();
		var unitname = $("#complaints_unit").text();
		var complaint_series_no = $("#nakatagodahilhindikayangipagsigawan").val();
		var datestart = $("#complaints_newsched").val();
		var starttime = $("#complaints_newtime").val();
		var assignedperson = $("#complaints_newperson").val();
		var remarks = $("#complaints_details").val();
		if(assignedperson != ""){
			$.ajax({
				type: 'POST',
				url: 'maintenance/complaints/class.php',
				data: 'tenantid=' + tenantid + '&complaint_code=' + complaint_code + '&complaints_description=' + complaints_description + '&customer_name=' + customer_name + '&unitname=' + unitname + '&complaint_series_no=' + complaint_series_no + '&datestart=' + datestart + '&starttime=' + starttime + '&assignedperson=' + assignedperson + '&remarks=' + remarks + '&form=savecomplaintsmodal',
				success:function(data){
					if(data == 1){
						showmodal("alert", "Task from complaints saved.", "closecomplaintsmodal", null, "", null, "0");
						loadMainComplaints();
					}
				}
			})
		}else{
			showmodal("alert", "Please select a person to do the task.", "closecomplaintsmodal", null, "", null, "1");
		}
    }

    function closecomplaintsmodal(){
    	$("#complaintsmodal").modal("hide");
    }

    function printbydaterange(){
    	var datefrom = $("#pdatefrom").val();
		var dateto = $("#pdateto").val();
        var mallid = $("#printbymecomplaint").val();
        // if(mallid != "" && mallid != null){
            $.ajax({
            	type: 'POST',
            	url: 'complaints/class.php',
            	data: '&mallid=' + mallid + '&dateFrom=' + datefrom + '&dateTo=' + dateto + '&form=printcomplaints',
            	success:function(data){
                    var arr = data.split("|");
            		$("#tblmpocbodrc").html(arr[0]);
                    $("#dateFrommpocbodrcprint").text(arr[1])
                    $("#dateTompocbodrcprint").text(arr[2])
                    $.ajax({
                        type: 'POST',
                        url: 'mainclass.php',
                        data: 'mallID=' + mallid + '&form=getheaderprint',
                        success:function(data){
                            $("#template").html(data);
                            var toprint = $("#mpocbodrc").html();
                            var myheight = $(window).height()-40;
                            var mywidth = $(window).width()-40;
                            var popupWin = window.open("", "_blank", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
                            popupWin.document.open();
                            popupWin.document.write("<html><head><title></title><link rel='stylesheet' href='assets/font-awesome/4.5.0/css/font-awesome.min.css' /></head><body onload='window.print();'>" + toprint + "</body></html>");
                            popupWin.document.close();
                        }
                    })
            	}
            })
        // }else{
        //     showmodal("alert", "Please select mall.", "", null, "", null, "1");
        // }
    }

    function printcomplaint(csn, mallid){
        $.ajax({
            type: 'POST',
            url: 'complaints/class.php',
            data: 'csn=' + csn + '&form=printcomplaint',
            success:function(data){
                var arr = data.split("|");
                $("#printcomplainttradename").text(arr[0]);
                $("#printcomplaintmallname").text(arr[1]);
                $("#printcomplaintwingname").text(arr[2]);
                $("#printcomplaintfloorname").text(arr[3]);
                $("#printcomplaintunitname").text(arr[4]);
                $("#printcomplaintcomplaintdate").text(arr[5]);
                $("#printcomplaintusername").text(arr[6]);
                $("#printcomplaintcomplaintcode").text(arr[7]);
                $("#printcomplaintdescription").text(arr[8]);
                $("#printcomplaintassignedperson").text(arr[9]);
                $("#printcomplainttenantid").text(arr[10]);
                $.ajax({
                    type: 'POST',
                    url: 'mainclass.php',
                    data: 'mallID=' + mallid + '&form=getheaderprint',
                    success:function(data){
                        $("#template4").html(data);
                        var toprint = $("#printcomplaint").html();
                        var myheight = $(window).height()-40;
                        var mywidth = $(window).width()-40;
                        var popupWin = window.open("", "_blank", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
                        popupWin.document.open();
                        popupWin.document.write("<html><head><title></title></head><body onload='window.print();'>" + toprint + "</body></html>");
                        popupWin.document.close();
                    }
                })
            }
        })        
    }

    function showfilterofmall(){
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'form=tblref_mall',
            success:function(data){
                $(".malloption").html(data);
            }
        })
    }
</script>