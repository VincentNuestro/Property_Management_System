<script type="text/javascript">
	$(function(){
		$("#txtsearchEmployee").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPageEmployee").val("1");
				displayEmployee(); 
			}else if ( x == '8' ){
				if($('#txtsearchEmployee').val() == ""){
					$("#txtPageEmployee").val("1");
					displayEmployee();
				}
			}
		}); 
		filecss();
	});

	function showtxtmall(){
		displayEmployee();
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=tblref_mall',
			success:function(data){
				$(".searchy_select").select2();
                $(".select2-selection").css('height','33px');
				$("#txtmall").html(data);
			}
		})
	}	

	function showEmpDepartment(){
		$.ajax({
			type: 'POST',
			url: 'setup/referentialFiles/em_Employee/class.php',
			data: 'form=showEmpDepartment',
			success:function(data){
				$(".searchy_select").select2();
                $(".select2-selection").css('height','33px');
				$("#EmpDepartment").html(data);
			}
		})
	}

	function displayEmployee(){
		var key = $("#txtsearchEmployee").val();
	    var page = $("#txtPageEmployee").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/em_Employee/class.php',
			data: 'page=' + page + '&key=' + key + '&form=displayEmployee',
			success: function(data){
				if(data == ''){
					$("#tblEmployee").html("<tr><td style='text-align: center;' colspan='10'>No Data Found...</td></tr>");
				}else{
					$("#tblEmployee").html(data);
				}
			}, complete: function(){
				EmployeeSelected();
				loadEntriesEmployee();
				loadPageEmployee();
				showtxtmall();
				showEmpDepartment();
				showEmpPosition();
				showTenantcode();
			}
		})
	}

	function loadEntriesEmployee(){
	    var page = $("#txtPageEmployee").val();
	    var key = $("#txtsearchEmployee").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/em_Employee/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadEntriesEmployee',
	        success: function(data){
	            $("#txtEntriesEmployee").text(data);
	        }
	    });
	}

	function loadPageEmployee(){
	    var page = $("#txtPageEmployee").val();
	    var key = $("#txtsearchEmployee").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/em_Employee/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadPageEmployee',
	        success: function(data){
	            $("#ulPageEmployee").html(data);
	        }
	    });
	}

    function fncPageEmployee(page, pagenums){
        $(".pgnumEmployee").removeClass("active");
        $("#pgEmployee" + pagenums).addClass("active");
        $("#txtPageEmployee").val(page);
        displayEmployee();
    }

	function EmployeeSelected(){
		$("#tblEmployee tr").each(function(){
			$(this).click(function(){
				$("#tblEmployee tr").removeClass("selected");
				$(this).addClass("selected");
				selectedEmployee(this.id);
				$("#hiddenemployeeid").val(this.id);
			})
		})
	}

	function selectedEmployee(id){
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/em_Employee/class.php',
			data: 'id=' + id + '&form=selectedEmployee',
			success: function(data) {
				var arr = data.split("|");
				$("#img_mallinfo").css("display", "inline-block");
				$("#txtmall").val(arr[0]);
				$("#EmpCode").val(arr[1]);
				$("#EmpFN").val(arr[3]);
				$("#EmpMN").val(arr[4]);
				$("#EmpLN").val(arr[5]);
				$("#EmpDepartment").val(arr[6]);
				$.ajax({
					type: 'POST',
					url: 'setup/referentialFiles/em_Employee/class.php',
					data: 'Department=' + arr[6] + '&form=showEmpPosition',
					success:function(data){
						$(".searchy_select").select2();
                		$(".select2-selection").css('height','33px');
						$("#EmpPosition").html(data);
					}, complete: function(){
						$("#EmpPosition").val(arr[2]);
					}
				})

				$("#txttenantcode").val(arr[7]);
				$("#showEmpStatus").val(arr[8]);
				$("#txtrem").val(arr[9]);	
				$("#img_mallinfo").attr("src", arr[10]);
			}, complete: function(){
				showTenantcode();
			}
		})
	}

	function clickAddEmployee(){
		$("#tblEmployee tr").unbind("click");
		$("#tblEmployee tr").removeClass("selected");
		$("#buttonsEmployee").css("display", "none");
		$("#savingbuttonsEmployee").css("display", "block");
		$(".txtEmployee").removeAttr("readonly");
		$(".txtEmployee").val("");
		$(".txtEmployee2").prop("disabled", false);
		$(".txtEmployee2").val("");
		$("#file_upload").prop("disabled", false);
		$("#txtrem").prop("disabled", false);
		$("#img_mallinfo").attr('src','assets/images/noimage5.png');
		showtxtmall();
		showEmpDepartment();
		showEmpPosition();
		showTenantcode();
	}

	function cancelbuttonEmployee(){
		displayEmployee();
		$("#buttonsEmployee").css("display", "block");
		$("#savingbuttonsEmployee").css("display", "none");
		$(".txtEmployee").attr("readonly", "readonly");
		$(".txtEmployee").val("");
		$(".txtEmployee2").prop("disabled", true);
		$(".txtEmployee2").val("");
		$("#file_upload").prop("disabled", true);
		$("#txtrem").prop("disabled", true);
		$("#img_mallinfo").attr('src','assets/images/noimage5.png');
		filecss();
	}

	function cancelbuttonEmployee2(){
		displayEmployee();
		$("#buttonsEmployee").css("display", "block");
		$("#updatebuttonsEmployee").css("display", "none");
		$(".txtEmployee").attr("readonly", "readonly");
		$(".txtEmployee2").prop("disabled", true);
		$("#img_mallinfo").attr('src','assets/images/noimage5.png');
		filecss();
		clearupdatesave();
	}

	function saveEmployee(){
		var mallid = $("#txtmall").val();
		var Code = $("#EmpCode").val();
		var Position = $("#EmpPosition").val();
		var firstname = $("#EmpFN").val();
		var middlename = $("#EmpMN").val();
		var lastname = $("#EmpLN").val();
		var department = $("#EmpDepartment").val();
		var txttenantcode = $("#txttenantcode").val();
		var empstat = $("#showEmpStatus").val();
		var remarks = $("#txtrem").val();
		if( ($("#txtmall").val() != "") && ($("#EmpCode").val() != "") && ($("#EmpPosition").val() != "") && ($("#EmpFN").val() != "") && ($("#EmpMN").val() != "") && ($("#EmpLN").val() != "") && ($("#EmpDepartment").val() != "") && ($("#showEmpStatus").val()) != "" && ($("tenantcode").val() != "")) {
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/em_Employee/class.php',
				data: 'mallid=' + mallid + '&Code=' + Code + '&Position=' + Position + '&firstname=' + firstname + '&middlename=' + middlename + '&lastname=' + lastname + '&department=' + department + '&txttenantcode=' + txttenantcode + '&empstat=' + empstat + '&remarks=' + remarks + '&form=saveEmployee',
				success: function (data) {
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Saved.", "cancelbuttonEmployee", null, "", null, "0");
						}, 500)
						sendData($('#EmpCode').val());
						$("#posting_profilepic").html("<input type='hidden' id='txtmallid_forms' name='txtmallid_forms'><input id='file_upload' name='attachment_profilepic' class='form-control upload_app_req' type='file' onchange='showimg123();' disabled/>");
					}else{
						setTimeout(function(){
							showmodal("alert", data, "", null, "", null, "1");
						}, 500)
					}
				}
			})
		}else{
			setTimeout(function(){
				showmodal("alert", "Please fill all fields", "", null, "", null, "1");
			}, 500)
		}
	}

	function clickUpdateEmployee(){
		var Code = $("#EmpCode").val();
		if(Code == ""){
			setTimeout(function(){
				showmodal("alert", "Select employee first", "", null, "", null, "1");
			}, 500)
		}else{
			$.ajax({
				type: 'POST',
				url: 'setup/referentialFiles/em_Employee/class.php',
				data: 'Code=' + Code + '&form=clickUpdateEmployee',
				success:function(data){
					if(data == 0){
						$("#tblEmployee tr").unbind("click");
						$("#buttonstblEmployeeEmployee").css("display", "none");
						$("#buttonsEmployee").css("display", "none");
						$("#updatebuttonsEmployee").css("display", "block");
						$(".txtEmployee").removeAttr("readonly");
						$(".txtEmployee2").prop("disabled", false);
						$("#file_upload").prop("disabled", false);
					}else{
						$("#tblEmployee tr").unbind("click");
						$("#buttonsEmployee").css("display", "none");
						$("#updatebuttonsEmployee").css("display", "block");
						$(".txtEmployee").removeAttr("readonly");
						$("#EmpCode").attr("readonly", "readonly");
						$(".txtEmployee2").prop("disabled", false);
						$("#txtrem").removeAttr("disabled", false);
					}
				}
			})
		}
	}

	function updateEmployee(){
		var mallid = $("#txtmall").val();
		var Code = $("#EmpCode").val();
		var Position = $("#EmpPosition").val();
		var firstname = $("#EmpFN").val();
		var middlename = $("#EmpMN").val();
		var lastname = $("#EmpLN").val();
		var id = $("#hiddenemployeeid").val();
		var department = $("#EmpDepartment").val();
		var tenantcodeedit = $("#txttenantcode").val();
		var xstat = $("#showEmpStatus").val(); 
		var xrem = $("#txtrem").val();
		if($("#EmployeeCode").val() != "" && $("#EmployeeDesc").val() != ""){
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/em_Employee/class.php',
				data: 'id=' + id + '&mallid=' + mallid + '&Code=' + Code + '&Position=' + Position + '&firstname=' + firstname + '&middlename=' + middlename + '&lastname=' + lastname + '&department=' + department + '&tenantcodeedit=' + tenantcodeedit + '&xstat=' + xstat + '&xrem=' + xrem + '&form=updateEmployee',
				success: function (data) {
					if(data == 1){
						sendData($('#EmpCode').val());
						$("#posting_profilepic").html("<input type='hidden' id='txtmallid_forms' name='txtmallid_forms'><input id='file_upload' name='attachment_profilepic' class='form-control upload_app_req' type='file' onchange='showimg123();' disabled/>");
						setTimeout(function(){
							showmodal("alert", "Saved.", "cancelbuttonEmployee2", null, "", null, "0");
						}, 500)
						clearupdatesave();
					}else{
						setTimeout(function(){
							showmodal("alert", data, "", null, "", null, "1");
						}, 500)
						clearupdatesave();
					}
				}
			})
		}else{
			setTimeout(function(){
				showmodal("alert", "Please fill all fields", "", null, "", null, "1");
			}, 500)
		}
	}

	function clearupdatesave(){
		$("#txtmall").val("");
		$("#txttenantcode").val("");
		$("#EmpDepartment").val("");
		$("#EmpPosition").val("");
		$("#EmpCode").val("");
		$("#EmpFN").val("");
		$("#EmpMN").val("");
		$("#EmpLN").val("");
		$("#txtrem").val("");
		$("#showEmpStatus").val("");
	}

	function cleardelete(){
		$("#txtmall").val("");
		$("#txttenantcode").val("");
		$("#EmpDepartment").val("");
		$("#EmpPosition").val("");
		$("#EmpCode").val("");
		$("#EmpFN").val("");
		$("#EmpMN").val("");
		$("#EmpLN").val("");
		$("#txtrem").val("");
		$("#showEmpStatus").val("");
		$("#hiddenemployeeid").val("");
		$("#img_mallinfo").attr('src', 'assets/images/noimage5.png');
	}

	function clickDeleteEmployee(){
		var Code = $("#EmpCode").val();
		var firstname = $("#EmpFN").val();
		var middlename = $("#EmpMN").val();
		var lastname = $("#EmpLN").val();
		var id = $("#hiddenemployeeid").val();
		var dept = $("#EmpDepartment").val(); 
		if(Code == ""){
			setTimeout(function(){
				showmodal("alert", "Select employee first", "", null, "", null, "1");
			}, 500)
		}
		else{
			setTimeout(function(){
				showmodal("confirm", "Are you sure you want to delete " + firstname + " " + middlename + " " + lastname, "clickDeleteEmployee2", null, "", null, "0");
			}, 500)
		}
	}

	function clickDeleteEmployee2(){
		var firstname = $("#EmpFN").val();
		var middlename = $("#EmpMN").val();
		var lastname = $("#EmpLN").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/em_Employee/class.php',
			data: 'id=' + $("#hiddenemployeeid").val() + '&form=deleteEmployee',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", firstname + " " + middlename + " " + lastname + " has been deleted.", "displayEmployee", null, "", null, "0");
					}, 500) 
					cleardelete();
				}	
				else{
					setTimeout(function(){
						showmodal("alert", data, "", null, "", null, "1");
					}, 500)
					cleardelete();
				}	
			}
		})
	}

	function showEmpPosition(){
		var Department = $("#EmpDepartment").val();
		$.ajax({
			type: 'POST',
			url: 'setup/referentialFiles/em_Employee/class.php',
			data: 'Department=' + Department + '&form=showEmpPosition',
			success:function(data){
				$(".searchy_select").select2();
                $(".select2-selection").css('height','33px');
				$("#EmpPosition").html(data);
			}
		})
	}

// ruth
	// function showEmpStatus(){
	// 	$.ajax({
	// 		type: 'POST',
	// 		url: 'setup/referentialFiles/em_Employee/class.php',
	// 		data: 'form=showEmpStatus',
	// 		success:function(data){
	// 			$("#EmpPosition").append(data);
	// 		}
	// 	})
	// }

	function showTenantcode() {
		$.ajax({
			type: 'POST',
			url: 'setup/referentialFiles/em_Employee/class.php',
			data: 'form=showTenantcode',
			success:function(data){
				$(".searchy_select").select2();
                $(".select2-selection").css('height','33px');
				$("#txttenantcode").html(data);
			}
		})
	}

 	function showimg123(){
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("file_upload").files[0]);
        oFReader.onload = function (oFREvent) {
            document.getElementById("img_mallinfo").src = oFREvent.target.result;
        };
    }

    function sendData(mallid){
        $("#txtmallid_forms").val(mallid);
        var data = new FormData($('#posting_profilepic')[0]);
        $.ajax({
            type:"POST",
            url:"setup/referentialFiles/em_Employee/uploademployeeid.php",
            data: data,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            success:function(data){
            	$("#img_mallinfo").attr('src','assets/images/noimage5.png');
            	// alert(data);
                // loadmalls();
            }
        });
    }	

 	function showidemp(fname,mname,lname, code, post, dept, mallnem, image, com){
 		var fulname = fname+" "+mname+" "+lname;
	 	$("#txtempname").text(fulname); 
	 	$("#txtempcode").text(code);
	 	$("#txtprevpos").text(post);
	 	$("#txtdept").text(dept);
	 	$("#txtflor").text(mallnem);
	 	$("#txtPreviewImage").attr("src",image);
	 	$("#txtcom").text(com);
 	}

	function AutoConsolidateEmployee(){
		var key = $('#txtsearchEmployee').val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/em_Employee/class.php',
			data: 'key=' + key + '&form=AutoConsolidateEmployee',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "List of employee successfully exported.", "", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to export list of employee.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	} 

	  function filecss(){        
        $('.upload_app_req').ace_file_input({
          no_file:'No File ...',
          btn_choose:'Choose',
          btn_change:'Change',
          droppable:false,
          onchange:null,
          thumbnail:false 
        });
    }

	function printid(){
        toprint = $("#divPrint").html();   
        var myheight = $(window).height()-40;
        var mywidth = $(window).width()-40;
        var popupWin = window.open("", "_blank", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
        popupWin.document.open();
        popupWin.document.write("<html><head><link rel='stylesheet' href='assets/css/bootstrap.min.css' /><link rel='stylesheet' href='setup/referentialFiles/em_Employee/printID.css' /><title></title></head><body onload='window.print();'>" + toprint + "</body></html>");
        popupWin.document.close();
	}

</script>