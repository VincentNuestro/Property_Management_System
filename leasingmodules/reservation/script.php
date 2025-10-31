<script type="text/javascript">
	$(function(){
		$("#txt_LMresuserpage").val("1");
		$("#txt_quickselectuserpage").val("1");
		$("#txt_LMinqTACselectuserpage").val("1");
    	$(".fixTable").tableHeadFixer(); 
	    $('.input-mask-phone').mask('(999) 999-9999');
	    $(".input-mask-tele").on('keypress', function (event) {
        var regex = new RegExp("^[-+() 0-9]+");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        });
		$('.email-address').each(function(){
		    $(this).focusout(function() {
		        var sEmail = $(this).val();
		        if ($.trim(sEmail).length == 0) {
		            // $(this).focus();
		            // alert("Please enter valid email address");
		            // alert('Please enter valid email address');
		        }
		        if (validateEmail(sEmail)) {
		            // $(".errohere").hide();
		            // alert('Email is valid');
		            // Nothing happens...
		        }
		        else {
		            // $(this).focus();
		            showmodal("alert", "The email address you entered is in invalid format.", "", null, "", null, "0");
		        }
		    });
		}); 
		$(".date-picker").datepicker({
	        autoHide: true,
	        format: 'mm/dd/yyyy',
	        todayHighlight: true
	    });
		$('[data-rel=tooltip]').tooltip();
	    $('[data-rel=popover]').popover({html:true});
	    var date = new Date();
		date.setDate(date.getDate() - 0);
		$('.jonas-date-picker').datepicker({
		    autoclose: true,
		    todayHighlight: true,
		    format: 'mm/dd/yyyy',
		    startDate: date
		});
		$("#txtoverrideusername").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#btnshowoverridemodal").click(); 
			}
		});

		$("#txtoverridepassword").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#btnshowoverridemodal").click(); 
			}
		});
		showLMResevationList();
	})

	function showLMResevationList(){
		var key = $("#txtsearchLMreservation").val();
	    var page = $("#txt_LMresuserpage").val();
		$.ajax({
			type: 'POST',
			url: 'leasingmodules/reservation/class.php',
			data: 'key=' + key + '&page=' + page + '&form=showLMResevationList',
			beforeSend : function() {
	            $('#indexloadingscreen').addClass('myspinner');
	        },
	        success: function(data){
	            $('#indexloadingscreen').removeClass('myspinner');
	            if(data != ""){
	                $("#tblleasingreservationlist").html(data);
	            }else{
	                $("#tblleasingreservationlist").html("<tr><td colspan='9' style='text-align: center;'>No Data Found...</td></tr>");
	        	}
				loadentriesLMres();
				loadpageLMres();
			}
		})
	}

	function loadentriesLMres(){
	    var page = $("#txt_LMresuserpage").val();
		var key = $("#txtsearchLMreservation").val();
	    $.ajax({
	        type: 'POST',
			url: 'leasingmodules/reservation/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadentriesLMres',
	        success: function(data){
	            if(data == "no data"){
	                $("#txtLMresenties").text("");
	            }
	            else{
	                $("#txtLMresenties").text(data);
	            }
	        }
	    });
	}

	function loadpageLMres(){
	    var page = $("#txt_LMresuserpage").val();
		var key = $("#txtsearchLMreservation").val();
	    $.ajax({
	        type: 'POST',
			url: 'leasingmodules/reservation/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadpageLMres',
	        success: function(data){
	            $("#ulLMrespagination").html(data);
	        }
	    });
	}

	function paginationLM(page, pagenums){
	    $(".pgnumpLMres").removeClass("active");
	    $("#pgLMres" + pagenums).addClass("active");
	    $("#txt_LMresuserpage").val(page);
	    showLMResevationList();
	}

	function saveLMReservationFilter(){
	    var module = "LMreservation";
	    var checked = "";
	    $('input:checkbox[name="form-field-checkboxlmres"]').each(function(){
	        if($(this).is(":checked")){
	            var value = $(this).attr("value");
	            checked += value + "|";
	        }
	    })

	    var checked2 = "";
	    $('input:checkbox[name="form-field-checkboxlmres"]').each(function(){
            var value2 = $(this).attr("value");
            checked2 += value2 + "|";
	    })

	    var checked3 = "";
	    $('input:checkbox[name="form-field-checkboxlmresstat"]').each(function(){
	        if($(this).is(":checked")){
	            var value3 = $(this).attr("value");
	            checked3 += value3 + "|";
	        }
	    })   

	    var Date1 = $("#txtLMappresDateFrom").val();
	    var Date2 = $("#txtLMappresDateTo").val();
	    var Date3 = $("#txtLMoccresDateFrom").val();
	    var Date4 = $("#txtLMoccresDateTo").val();
 		if($("#chkoccdate").is(":checked")){ var datefilter = "chkoccdate"; }
		if($("#chkappdate").is(":checked")){ var datefilter = "chkappdate"; } 
	    $.ajax({
	        type: 'POST',
			url: 'filter/class.php',
	        data: 'module=' + module + '&checked=' + checked + '&checked2=' + checked2 + '&checked3=' + checked3 + '&Date1=' + Date1 + '&Date2=' + Date2 + '&Date3=' + Date3 + '&Date4=' + Date4 + '&datefilter=' + datefilter + '&form=saveFilters',
	        success: function(data){
	            showLMResevationList();
	            $("#LINK_Reservation_filter").click();
	        }
	    })
	}

	function loadLMReservationFilter(module){
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
                $("#txtLMappresDateFrom").val(arr3[0]);
				$("#txtLMappresDateTo").val(arr3[1]);
				$("#txtLMoccresDateFrom").val(arr3[2]);
				$("#txtLMoccresDateTo").val(arr3[3]);

				var arr4 = arr[2].split("|");
				for(var i=0; i<=arr4.length-1; i++){
                    $('input:checkbox[id="filter_'+arr4[i]+'"][value="'+arr4[i]+'"]').attr('checked', 'checked');
                }               

				if(arr[3] == "chkoccdate"){
					$("#chkoccdate").prop("checked", true);
					chkoccdate();
				}
				else{
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
		}
		else{
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
		}
		else{
			$("#chkappdate").prop("checked", true);
		}
	}

	function hideleaseinquiryform(){
		$("#modalleaseinquiryform").modal("hide");
		$(".setvalzero").val("0");
		$(".setvalblank").val("");
		$("#txtLMinqclass").html("<option value=''>-- Select Classification --</option>");
		$("#txtLMinqdep").html("<option value=''>-- Select Department --</option>");
		$("#txtLMinqcat").html("<option value=''>-- Select Category --</option>");
		$("#txtLMinqwing").html("<option value=''>-- Select Wing --</option>");
		$("#txtLMinqfloor").html("<option value=''>-- Select Floor --</option>");
		$("#txtLMinqunit").html("<option value=''>-- Select Unit --</option>");
		$(".chkPaymentScheme").prop("checked", false);
		$(".chkSourceofSale").prop("checked", false);
		$(".chkReason4Buying").prop("checked", false);
		$(".mustclearfirst").val("");
		$(".jonas-date-picker").val("<?php echo date('m/d/Y'); ?>");
		$("#LMinquiryIDforUpdate").val("");
		$("#LMUnitIDforUpdate").val("");
		$("#div_termsandcondition").html("");
		$("#sonyxperiax").val("");
		$("#div_LMinqcontactlist").html("");
		showLMResevationList();
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

	function loadcityref(key) {
		if(key != ""){
		  	$.ajax({
		    	type: 'POST',
		    	url: 'mainclass.php',
		    	data: 'city=' + key + '&form=loadcityref',
		    	success: function(data){
		     		 $("#inq_citylist").html(data);
		    	}
		  	})
		}
	}

	function showtxtLMinqcomp(){
		$.ajax({
			type: 'POST',
			url: 'leasingmodules/reservation/class.php',
			data: 'form=showtxtLMinqcomp',
			success:function(data){
				$("#txtLMinqcomp").html(data);
				$("#txtLMinqclass").prop("disabled", true);
				$("#txtLMinqdep").prop("disabled", true);
				$("#txtLMinqcat").prop("disabled", true);
				$("#txtLMinqwing").prop("disabled", true);
				$("#txtLMinqfloor").prop("disabled", true);
				$("#txtLMinqunit").prop("disabled", true);
			}
		})
	}

	function showtxtLMinqclass(mallid){
		$("#txtidmall").val(mallid);
		$.ajax({
			type: 'POST',
			url: 'leasingmodules/reservation/class.php',
			data: 'form=showtxtLMinqclass',
			success:function(data){
				$("#txtLMinqclass").html(data);
				$("#txtLMinqclass").prop("disabled", false);
				$("#txtLMinqdep").prop("disabled", true);
				$("#txtLMinqcat").prop("disabled", true);
				$("#txtLMinqwing").prop("disabled", true);
				$("#txtLMinqfloor").prop("disabled", true);
				$("#txtLMinqunit").prop("disabled", true);
				showallpercentage(mallid);

				$("#txtLMinqdep").html("<option value=''>-- Select Department --</option>");
				$("#txtLMinqcat").html("<option value=''>-- Select Category --</option>");
				$("#txtLMinqwing").html("<option value=''>-- Select Wing --</option>");
				$("#txtLMinqfloor").html("<option value=''>-- Select Floor --</option>");
				$("#txtLMinqunit").html("<option value=''>-- Select Unit --</option>");
			}
		})
	}

	function showtxtLMinqdep(classification){
		$("#txtidclassification").val(classification);
		$.ajax({
			type: 'POST',
			url: 'leasingmodules/reservation/class.php',
			data: 'classification=' + classification + '&form=showtxtLMinqdep',
			success:function(data){
				$("#txtLMinqdep").html(data);
				$("#txtLMinqclass").prop("disabled", false);
				$("#txtLMinqdep").prop("disabled", false);
				$("#txtLMinqcat").prop("disabled", true);
				$("#txtLMinqwing").prop("disabled", true);
				$("#txtLMinqfloor").prop("disabled", true);
				$("#txtLMinqunit").prop("disabled", true);

				$("#txtLMinqcat").html("<option value=''>-- Select Category --</option>");
				$("#txtLMinqwing").html("<option value=''>-- Select Wing --</option>");
				$("#txtLMinqfloor").html("<option value=''>-- Select Floor --</option>");
				$("#txtLMinqunit").html("<option value=''>-- Select Unit --</option>");
			}
		})
	}

	function showtxtLMinqcat(dep){
		$("#txtiddepartment").val(dep);
		$.ajax({
			type: 'POST',
			url: 'leasingmodules/reservation/class.php',
			data: 'dep=' + dep + '&form=showtxtLMinqcat',
			success:function(data){
				$("#txtLMinqcat").html(data);
				$("#txtLMinqclass").prop("disabled", false);
				$("#txtLMinqdep").prop("disabled", false);
				$("#txtLMinqcat").prop("disabled", false);
				$("#txtLMinqwing").prop("disabled", true);
				$("#txtLMinqfloor").prop("disabled", true);
				$("#txtLMinqunit").prop("disabled", true);

				$("#txtLMinqwing").html("<option value=''>-- Select Wing --</option>");
				$("#txtLMinqfloor").html("<option value=''>-- Select Floor --</option>");
				$("#txtLMinqunit").html("<option value=''>-- Select Unit --</option>");
			}
		})
	}

	function showtxtLMinqwing(cat){
		$("#txtidcategory").val(cat);
		var mallid = $("#txtidmall").val();
		$.ajax({
			type: 'POST',
			url: 'leasingmodules/reservation/class.php',
			data: 'mallid=' + mallid + '&form=showtxtLMinqwing',
			success:function(data){
				$("#txtLMinqwing").html(data);
				$("#txtLMinqclass").prop("disabled", false);
				$("#txtLMinqdep").prop("disabled", false);
				$("#txtLMinqcat").prop("disabled", false);
				$("#txtLMinqwing").prop("disabled", false);
				$("#txtLMinqfloor").prop("disabled", true);
				$("#txtLMinqunit").prop("disabled", true);

				$("#txtLMinqfloor").html("<option value=''>-- Select Floor --</option>");
				$("#txtLMinqunit").html("<option value=''>-- Select Unit --</option>");
			}
		})
	}

	function showtxtLMinqfloor(wing){
		$("#txtidwing").val(wing);
		var mallid = $("#txtidmall").val();
		var classification = $("#txtidclassification").val();
		var dep = $("#txtiddepartment").val();
		var cat = $("#txtidcategory").val();
		$.ajax({
			type: 'POST',
			url: 'leasingmodules/reservation/class.php',
			data: '&mallid=' + mallid + '&wing=' + wing + '&classification=' + classification + '&dep=' + dep + '&cat=' + cat + '&form=showtxtLMinqfloor',
			success:function(data){
				$("#txtLMinqfloor").html(data);
				$("#txtLMinqclass").prop("disabled", false);
				$("#txtLMinqdep").prop("disabled", false);
				$("#txtLMinqcat").prop("disabled", false);
				$("#txtLMinqwing").prop("disabled", false);
				$("#txtLMinqfloor").prop("disabled", false);
				$("#txtLMinqunit").prop("disabled", true);

				$("#txtLMinqunit").html("<option value=''>-- Select Unit --</option>");

			}
		})
	}

	function showtxtLMinqunit(floorid){
		var mallid = $("#txtidmall").val();
		var wing = $("#txtidwing").val();
		var classification = $("#txtidclassification").val();
		var dep = $("#txtiddepartment").val();
		var cat = $("#txtidcategory").val();
		$.ajax({
			type: 'POST',
			url: 'leasingmodules/reservation/class.php',
			data: '&mallid=' + mallid + '&wing=' + wing + '&classification=' + classification + '&dep=' + dep + '&cat=' + cat + '&floorid=' + floorid + '&form=showtxtLMinqunit',
			success:function(data){
				$("#txtLMinqunit").html(data);
				$("#txtLMinqclass").prop("disabled", false);
				$("#txtLMinqdep").prop("disabled", false);
				$("#txtLMinqcat").prop("disabled", false);
				$("#txtLMinqwing").prop("disabled", false);
				$("#txtLMinqfloor").prop("disabled", false);
				$("#txtLMinqunit").prop("disabled", false);
			}
		})
	}

	function showtxtLMinqunitinfo(unitid){
		$.ajax({
			type: 'POST',
			url: 'leasingmodules/reservation/class.php',
			data: 'unitid=' + unitid + '&form=showtxtLMinqunitinfo',
			success:function(data){
				var arr = data.split("|");
				$("#txtLMunitarea").val(arr[0]);
				$("#txtLMppsqm").val(arr[1]);
				$("#txtLMmonthlydue").val(arr[2]);
				$("#txtLMassociationdue").val(arr[3]);
				showdateto();
			}
		})
	}

	function showdateto(){
		var dateFrom = $("#txtLMdateFrom").val();
		var count = $("#txtLMmonthcount").val();
		var monthly = $("#txtLMmonthlydue").val().replace(/,/g, "");
		var assocdue = $("#txtLMassociationdue").val().replace(/,/g, "");
		var mallid = $("#txtidmall").val();
		$.ajax({
			type: 'POST',
			url: 'leasingmodules/reservation/class.php',
			data: 'mallid=' + mallid + '&dateFrom=' + dateFrom + '&count=' + count + '&monthly=' + monthly + '&assocdue=' + assocdue + '&form=showdateto',
			success:function(data){
				var arr = data.split("|");
				$("#txtLMdateTo").val(arr[0]);
				$("#txtListPrice").val(arr[1]);
				$("#txtPromoDiscount").val(arr[2]);
				$("#txtCompanyDiscount").val(arr[3]);
				$("#txtStandardDiscount").val(arr[4]);
				$("#txtTotalDiscount").val(arr[5]);
				$("#txtAddVat").val(arr[6]);
				$("#txtTotalContractPrice").val(arr[7]);
				$("#txtOtherCharges").val(arr[8]);
				$("#txtTotalAmountPayable").val(arr[9]);
				$("#txtSpotDownPayment").val(arr[10]);
				$("#txtNetDownPayment").val(arr[11]);
				$("#txtBalance").val(arr[12]);
				$("#txtReservationFee").val(arr[13]);
				$("#txtRetentionFee").val(arr[14]);
				$("#txtNetSpotPayment").val(arr[15]);
			}
		})
	}

	function getamort(){
		var dividedby = $("#txtAmortNoOfMonths").val();
		var DownPayment = $("#txtNetDownPayment").val().replace(/,/g, "");
		var amort = 0;
		amort = parseFloat(DownPayment.replace(/,/g, "")) / parseFloat(dividedby);
		$("#txtMonthlyAmortization").val(amort.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
	}

	function quickselect(){
		$("#modal_quickselect").modal("show");
		var key = $("#txtsearchLMqs").val();
		var page = $("#txt_quickselectuserpage").val();
		$.ajax({
			type: 'POST',
			url: 'leasingmodules/reservation/class.php',
			data: 'page=' + page + '&key=' + key + '&form=quickselect',
			beforeSend : function() {
	       		$('#quickselectloading').addClass('myspinner');
	      	},
		    success: function(data){
	        	$('#quickselectloading').removeClass('myspinner');
	        	 if(data != ""){
	                $("#tblunitlist").html(data);
	            }else{
	                $("#tblunitlist").html("<tr><td colspan='7' style='text-align: center;'>No Data Found...</td></tr>");
	            }
	            loadentriesquickselect();
				loadpagequickselect();
			}
		})
	}

	function loadentriesquickselect(){
	    var page = $("#txt_quickselectuserpage").val();
		var key = $("#txtsearchLMqs").val();
	    $.ajax({
	        type: 'POST',
			url: 'leasingmodules/reservation/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadentriesquickselect',
	        success: function(data){
	            if(data == "no data"){
	                $("#txtquickselectenties").text("");
	            }
	            else{
	                $("#txtquickselectenties").text(data);
	            }
	        }
	    });
	}

	function loadpagequickselect(){
	    var page = $("#txt_quickselectuserpage").val();
		var key = $("#txtsearchLMqs").val();
	    $.ajax({
	        type: 'POST',
			url: 'leasingmodules/reservation/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadpagequickselect',
	        success: function(data){
	            $("#ulquickselectpagination").html(data);
	        }
	    });
	}

	function paginationquickselect(page, pagenums){
	    $(".pgnumquickselect").removeClass("active");
	    $("#pgquickselect" + pagenums).addClass("active");
	    $("#txt_quickselectuserpage").val(page);
	    quickselect();
	    loadpagequickselect();
	    loadentriesquickselect();
	}

	function thechosen(mall, classification, department, category, wing, floor, unit){
		$.ajax({
			type: 'POST',
			url: 'leasingmodules/reservation/class.php',
			data: 'mall=' + mall + '&classification=' + classification + '&department=' + department + '&category=' + category + '&wing=' + wing + '&floor=' + floor + '&unit=' + unit + '&form=thechosen',
			success: function(data){
				var arr = data.split("|");
				$("#txtLMinqclass").html(arr[0]);
				$("#txtLMinqdep").html(arr[1]);
				$("#txtLMinqcat").html(arr[2]);
				$("#txtLMinqwing").html(arr[3]);
				$("#txtLMinqfloor").html(arr[4]);
				$("#txtLMinqunit").html(arr[5]);
				$("#txtLMunitarea").val(arr[6]);
				$("#txtLMppsqm").val(arr[7]);
				$("#txtLMmonthlydue").val(arr[8]);
				$("#txtLMassociationdue").val(arr[9]);
			},
	        complete: function(){
				$("#txtLMinqcomp").val(mall);
	            $("#txtLMinqclass").val(classification);
	            $("#txtLMinqdep").val(department);
	            $("#txtLMinqcat").val(category);
	            $("#txtLMinqwing").val(wing);
	            $("#txtLMinqfloor").val(floor);
	            $("#txtLMinqunit").val(unit);
				$("#txtidmall").val(mall);
				showallpercentage(mall);
				$("#txtLMinqclass").prop("disabled", false);
				$("#txtLMinqdep").prop("disabled", false);
				$("#txtLMinqcat").prop("disabled", false);
				$("#txtLMinqwing").prop("disabled", false);
				$("#txtLMinqfloor").prop("disabled", false);
				$("#txtLMinqunit").prop("disabled", false);
	            $("#modal_quickselect").modal("hide");
				showdateto();
	        }
		})
		$.ajax({
			type: 'POST',
			url: 'leasingmodules/reservation/class.php',
			data: 'unit=' + unit + '&form=selected_unit_amenities',
			success:function(data){
				$("#tblamenities").html(data);
			}
		})
	}

	function editmonthlydue(id){
		$("#"+id).removeAttr("readonly", "readonly");
		$("#btnsavemonthlydue").css("display", "block");
	}

	function editassocdue(id){
		$("#"+id).removeAttr("readonly", "readonly");
		$("#btnsaveassocdue").css("display", "block");
	}

	function savemonthlydue(){
		$("#txtLMmonthlydue").attr("readonly", "readonly");
		$("#btnsavemonthlydue").css("display", "none");
	}

	function saveassocdue(){
		$("#txtLMassociationdue").attr("readonly", "readonly");
		$("#btnsaveassocdue").css("display", "none");
	}

	function showallpercentage(mallid){
		$.ajax({
			type: 'POST',
			url: 'leasingmodules/reservation/class.php',
			data: 'mallid=' + mallid + '&form=showallpercentage',
			success:function(data){
				var arr = data.split("|");
				$("#txtLMSDP").text(arr[0]);
				$("#txtLMNDP").text(arr[1]);
				$("#txtLMB").text(arr[2]);
				$("#txtLMPD").text(arr[3]);
				$("#txtLMCD").text(arr[4]);
				$("#txtLMSD").text(arr[5]);
				$("#txtLMVAT").html(arr[6]);
			}
		})
	}

	function saveLMinquiry(){
		var id = $("#LMinquiryIDforUpdate").val();
		var FirstName = $("#txtLMFirstName").val();
		var MiddleName = $("#txtLMMiddleName").val();
		var LastName = $("#txtLMLastName").val();
		var Birthdate = $("#txtLMBirthdate").val();
		var CivilStatus = $("#txtLMCivilStatus").val();
		var Telephone = $("#txtLMTelephone").val();
		var Mobile = $("#txtLMMobile").val();
		var EmailAddress = $("#txtLMEmailAddress").val();
		var TIN = $("#txtLMTIN").val();
		var Occupation = $("#txtLMOccupation").val();
		var Citizenship = $("#txtLMCitizenship").val();
		var Address = $("#txtLMAddress").val();
		var City = $("#txtLMCity").val();
		var Country = $("#txtLMCountry").val();
		var ZipCode = $("#txtLMZip").val();
		var Mall = $("#txtLMinqcomp").val();
		var Classification = $("#txtLMinqclass").val();
		var Department = $("#txtLMinqdep").val();
		var Category = $("#txtLMinqcat").val();
		var Wing = $("#txtLMinqwing").val();
		var Floor = $("#txtLMinqfloor").val();
		var Unit = $("#txtLMinqunit").val();
		var UnitArea = $("#txtLMunitarea").val();
		var PricePerSQM = $("#txtLMppsqm").val();
		var MonthlyDue = $("#txtLMmonthlydue").val();
		var AssociationDue = $("#txtLMassociationdue").val();
		var OccupanyDateFrom = $("#txtLMdateFrom").val();
		var OccupanyDateTo = $("#txtLMdateTo").val();
		var NoOfMonths = $("#txtLMmonthcount").val();
		var ListPrice = $("#txtListPrice").val();
		var PromoDiscount = $("#txtPromoDiscount").val();
		var CompanyDiscount = $("#txtCompanyDiscount").val();
		var SpotDownPayment = $("#txtSpotDownPayment").val();
		var SpotDownPaymentDue = $("#txtSpotDownPaymentDueDate").val();
		var ReservationFee = $("#txtReservationFee").val();
		var ReservationFeeDue = $("#txtReservationFeeDueDate").val();
		var RetentionFee = $("#txtRetentionFee").val();
		var NetSpotPayment = $("#txtNetSpotPayment").val();
		var NetDownPayment = $("#txtNetDownPayment").val();
		var AmortNoOfMonths = $("#txtAmortNoOfMonths").val();
		var AmortStartDate = $("#txtLMAmortStartDate").val();
		var MonthlyAmort = $("#txtMonthlyAmortization").val();
		var Balance = $("#txtBalance").val();
		var PaymentType = $("#txtPaymentType").val();
		var ValidityOfPaymentScheme = $("#txtValidityDateOfPaymentScheme").val();
		var Termids = $("#sonyxperiax").val();
		var Gender = "";
		var PaymentScheme = "";
		var SourceOfSale = "";
		var Reason4Buying = "";
		var fields = 0;
		var PS = 0;
		var SS = 0;
		var RB = 0;
		var REQOR = $("#overridecount").val();
		var REQPASS = 0;
		var REQ = 0;
		$(".chkPaymentScheme").each(function(){
			if($(this).is(":checked")){
				PaymentScheme = this.value;
				PS++;
			}
		})
		$(".chkSourceofSale").each(function(){
			if($(this).is(":checked")){
				SourceOfSale += this.value + "|";
				SS++;
			}
		})
		$(".chkReason4Buying").each(function(){
			if($(this).is(":checked")){
				Reason4Buying += this.value + "|";
				RB++;
			}
		})
		$(".chkLMGender").each(function(){
			if($(this).is(":checked")){
				Gender = this.id;
			}
		})
		$(".mustclearfirst").each(function(){
			if($(this).val() ==""){
				$(this).css("border-color", "#f2a696");
				fields++;
			}else{
	          	$(this).css("border-color","#D5D5D5");
			}
		})
		$(".upload_app_req").each(function(){
          	if($(this).val() == "" || $(this).val() == "0" || $(this).val() == "0.00"){
            	REQ++;
            	var eto = $(this).attr("id");
            	$(this).css("border-color","#f2a696");
          	}else{	
              	$(this).css("border-color","#D5D5D5");
            }
        });
        $(".id-input-file-2").each(function(){
            REQPASS++;
        });
		if(Gender == ""){
			fields = fields + 1;
		}
		if(PS <= 0){
			fields = fields + 1;
		}
		if(SS <= 0){
			fields = fields + 1;
		}
		if(RB <= 0){
			fields = fields + 1;
		}
		var ContactList = "";
		$(".trcontactlist").each(function(){
			ContactList += this.id + "#";
		})
		if(Gender == ""){
			setTimeout(function(){
				showmodal("alert", "Please select your gender.", "", null, "", null, "1");
			}, 100)
		}else{
			if(PS <= 0){
				setTimeout(function(){
					showmodal("alert", "Please select your desired payment scheme.", "", null, "", null, "1");
				}, 100)
			}else{
				if(SS <= 0){
					setTimeout(function(){
						showmodal("alert", "Please state where did you found out about us.", "", null, "", null, "1");
					}, 100)
				}else{
					if(RB <= 0){
						setTimeout(function(){
							showmodal("alert", "Please tells us your reason for buying / leasing.", "", null, "", null, "1");
						}, 100)
					}else{
						if(fields != 0){
							setTimeout(function(){
								showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
							}, 100)
						}else{
								$.ajax({
									type: 'POST',
									url: 'leasingmodules/reservation/class.php',
									data: 'id=' + id + '&FirstName=' + FirstName + '&MiddleName=' + MiddleName +  '&LastName=' + LastName + '&Gender=' + Gender + '&Birthdate=' + Birthdate + '&CivilStatus=' + CivilStatus + '&Telephone=' + Telephone + '&Mobile=' + Mobile + '&EmailAddress=' + EmailAddress + '&TIN=' + TIN + '&Occupation=' + Occupation + '&Citizenship=' + Citizenship + '&Address=' + Address + '&City=' + City + '&Country=' + Country + '&ZipCode=' + ZipCode + '&Mall=' + Mall + '&Classification=' + Classification + '&Department=' + Department + '&Category=' + Category + '&Wing=' + Wing + '&Floor=' + Floor + '&Unit=' + Unit + '&UnitArea=' + UnitArea + '&PricePerSQM=' + PricePerSQM + '&MonthlyDue=' + MonthlyDue + '&AssociationDue=' + AssociationDue + '&OccupanyDateFrom=' + OccupanyDateFrom + '&OccupanyDateTo=' + OccupanyDateTo + '&NoOfMonths=' + NoOfMonths + '&ListPrice=' + ListPrice + '&PromoDiscount=' + PromoDiscount + '&CompanyDiscount=' + CompanyDiscount + '&SpotDownPayment=' + SpotDownPayment + '&SpotDownPaymentDue=' + SpotDownPaymentDue + '&ReservationFee=' + ReservationFee + '&ReservationFeeDue=' + ReservationFeeDue + '&RetentionFee=' + RetentionFee + '&NetSpotPayment=' + NetSpotPayment + '&NetDownPayment=' + NetDownPayment + '&AmortNoOfMonths=' + AmortNoOfMonths + '&AmortStartDate=' + AmortStartDate + '&MonthlyAmort=' + MonthlyAmort + '&Balance=' + Balance + '&PaymentType=' + PaymentType + '&ValidityOfPaymentScheme=' + ValidityOfPaymentScheme + '&PaymentScheme=' + PaymentScheme + '&SourceOfSale=' + SourceOfSale + '&Reason4Buying=' + Reason4Buying + '&Termids=' + Termids + '&ContactList=' + ContactList + '&form=saveLMinquiry',
									beforeSend : function() {
							            $('#loadleasinquiryform').addClass('myspinner');
							        },
							        success: function(data){
							            $('#loadleasinquiryform').removeClass('myspinner');
										var arr = data.split("|");
										if(arr[0] == "1"){
											setTimeout(function(){
												showmodal("alert", arr[1], "hideleaseinquiryform", null, "", null, "0");
											}, 100)
											$(".form_lease_application_req").each(function(){
						                        var this_id = $(this).attr("id");
                          						var txtaapid = $(this).find(".txtaapid");
						                        var txtaapid2 = txtaapid.attr("id");
						                        var txtinqqid = $(this).find(".txtinqqid");
						                        var txtinqqid2 = txtinqqid.attr("id");
						                        sendData(id, arr[3], this_id, txtaapid2, txtinqqid2);
						                    })
										}else{
											setTimeout(function(){
												showmodal("alert", arr[1], "", null, "", null, "1");
											}, 100)
										}
									}
								})	
						}
					}
				}
			}
		}
	}

	function editinquiry(InquiryID, action, ApplicationID, UnitID, action2){
		$("#modalleaseinquiryform").modal("show");
		showLMinqCompanyPosition();
		showtxtLMinqcomp();
		$("#LMinquiryIDforUpdate").val(InquiryID);
		$("#LMUnitIDforUpdate").val(UnitID);
		$("#overridecount").val("0");
		$.ajax({
			type: 'POST',
			url: 'leasingmodules/reservation/class.php',
			data: 'InquiryID=' + InquiryID + '&form=showinquiryinfo',
			beforeSend : function() {
	            $('#loadleasinquiryform').addClass('myspinner');
	        },
	        success: function(data){
	            $('#loadleasinquiryform').removeClass('myspinner');
				var arr = data.split("#");
					$("#txtLMFirstName").val(arr[0]);
					$("#txtLMMiddleName").val(arr[1]);
					$("#txtLMLastName").val(arr[2]);
					$(".chkLMGender").each(function(){
						if($(this).val() == arr[3]){
							$(this).prop("checked", true);
						}
					})
					$("#txtLMBirthdate").val(arr[4]);
					$("#txtLMCivilStatus").val(arr[5]);
					$("#txtLMTelephone").val(arr[6]);
					$("#txtLMMobile").val(arr[7]);
					$("#txtLMEmailAddress").val(arr[8])
					$("#txtLMTIN").val(arr[9]);
					$("#txtLMOccupation").val(arr[10]);
					$("#txtLMCitizenship").val(arr[11]);
					$("#txtLMAddress").val(arr[12]);
					$("#txtLMCity").val(arr[13]);
					$("#txtLMCountry").val(arr[14]);
					$("#txtLMZip").val(arr[15]);
					$("#txtLMmonthcount").val(arr[25]);
					thechosen(arr[16], arr[20], arr[21], arr[22], arr[17], arr[18], arr[19]);
					$("#txtSpotDownPaymentDueDate").val(arr[26]);
					$("#txtReservationFeeDueDate").val(arr[27]);
					$("#txtLMAmortStartDate").val(arr[28]);
					$("#txtValidityDateOfPaymentScheme").val(arr[29]);
					$("#txtPaymentType").val(arr[30]);
					$("#txtAmortNoOfMonths").val(arr[31]);
					$("#sonyxperiax").val(arr[35]);
					setTimeout(function(){
						getamort();
					}, 1000)
					$(".chkPaymentScheme").each(function(){
						if($(this).val() == arr[32]){
							$(this).prop("checked", true);
						}
					})
					var arr3 = arr[33].split("|");
					$(".chkSourceofSale").each(function(){
						for(var i=0; i<=arr3.length-1; i++){
							if($(this).val() == arr3[i]){
								$(this).prop("checked", true);
							}
			            }
					})
					var arr4 = arr[34].split("|");
					$(".chkReason4Buying").each(function(){
						for(var i=0; i<=arr4.length-1; i++){
							if($(this).val() == arr4[i]){
								$(this).prop("checked", true);
							}
			            }
					})
			},
			complete: function(){
				if(action == "Edit"){
					$("#modalleaseinquiryform :input").prop("disabled", false);
					$("#LMRESbtnforsaving").css("display", "inline-block");
					$("#LMRESbtnforoccupying").css("display", "none");
					$("#LMRESbtnforconfirmation").css("display", "none");
					$("#LMRESbtnforcancelling").css("display", "none");
					$("#LMRESbtnforreinstating").css("display", "none");
				}else if(action == "Reinstate"){
					setTimeout(function(){
						$("#modalleaseinquiryform :input").prop("disabled", true);
						$(".close").prop("disabled", false);
						$("#clicktoshowall").prop("disabled", false);
						$("#LMRESbtnforreinstating").prop("disabled", false);
						$(".imagebutton").prop("disabled", false);
						$("#LMRESbtnforsaving").css("display", "none");
						$("#LMRESbtnforoccupying").css("display", "none");
						$("#LMRESbtnforconfirmation").css("display", "none");
						$("#LMRESbtnforcancelling").css("display", "none");
						$("#LMRESbtnforreinstating").css("display", "inline-block");
					}, 500)
				}else if(action == "Cancel"){
					setTimeout(function(){
						$("#modalleaseinquiryform :input").prop("disabled", true);
						$(".close").prop("disabled", false);
						$("#clicktoshowall").prop("disabled", false);
						$("#LMRESbtnforcancelling").prop("disabled", false);
						$(".imagebutton").prop("disabled", false);
						$("#LMRESbtnforsaving").css("display", "none");
						$("#LMRESbtnforoccupying").css("display", "none");
						$("#LMRESbtnforconfirmation").css("display", "none");
						$("#LMRESbtnforcancelling").css("display", "inline-block");
						$("#LMRESbtnforreinstating").css("display", "none");
					}, 500)
				}else if(action == "Confirm"){
					setTimeout(function(){
						$("#modalleaseinquiryform :input").prop("disabled", true);
						$(".close").prop("disabled", false);
						$("#clicktoshowall").prop("disabled", false);
						$("#LMRESbtnforconfirmation").prop("disabled", false);
						$(".imagebutton").prop("disabled", false);
						$("#LMRESbtnforoccupying").css("display", "none");
						$("#LMRESbtnforsaving").css("display", "none");
						$("#LMRESbtnforconfirmation").css("display", "inline-block");
						$("#LMRESbtnforcancelling").css("display", "none");
						$("#LMRESbtnforreinstating").css("display", "none");
					}, 500)
				}
				else if(action == "Occupy"){
					setTimeout(function(){
						$("#modalleaseinquiryform :input").prop("disabled", true);
						$(".close").prop("disabled", false);
						$("#clicktoshowall").prop("disabled", false);
						$("#LMRESbtnforoccupying").prop("disabled", false);
						$(".imagebutton").prop("disabled", false);
						$("#LMRESbtnforoccupying").css("display", "inline-block");
						$("#LMRESbtnforsaving").css("display", "none");
						$("#LMRESbtnforconfirmation").css("display", "none");
						$("#LMRESbtnforcancelling").css("display", "none");
						$("#LMRESbtnforreinstating").css("display", "none");
					}, 500)
				}else{
					setTimeout(function(){
						$("#modalleaseinquiryform :input").prop("disabled", true);
						$(".close").prop("disabled", false);
						$("#clicktoshowall").prop("disabled", false);
						$(".imagebutton").prop("disabled", false);
						$("#LMRESbtnforoccupying").css("display", "none");
						$("#LMRESbtnforsaving").css("display", "inline-block");
						$("#LMRESbtnforconfirmation").css("display", "none");
						$("#LMRESbtnforcancelling").css("display", "none");
						$("#LMRESbtnforreinstating").css("display", "none");
					}, 500)
				}
			}
		})
		$.ajax({
			type: 'POST',
			url: 'leasingmodules/reservation/class.php',
			data: 'InquiryID=' + InquiryID + '&form=addselection',
			success:function(data){
				$("#div_termsandcondition").html(data);
			}
		})
		$.ajax({
		    type: 'POST',
		    url: 'leasingmodules/reservation/class.php',
		    data: '&appid=' + ApplicationID + '&inqid=' + InquiryID + '&form=loadLMINQrequirements',
		    success: function(data){
		      $("#div_resrequirements").html(data);
		      uploadrequirementscss();
		      // $(".overridebutton").css("display", "none");
		    }
		})
		$.ajax({
			type: 'POST',
			url: 'leasingmodules/inquiry/class.php',
			data: 'InquiryID=' + InquiryID + '&form=div_LMinqcontactlist',
			success:function(data){
				$("#div_LMinqcontactlist").html(data);
			}
		})
	}

	function confirmcalcelLMappres(){
		showmodal("confirm", "Are you sure you want to cancel this application?", "cancelLMappres", null, "", null, "0");
	}

	function cancelLMappres(){
		var id = $("#LMinquiryIDforUpdate").val();
		var unitid = $("#LMUnitIDforUpdate").val();
		$.ajax({
			type: 'POST',
			url: 'leasingmodules/reservation/class.php',
			data: 'unitid=' + unitid + '&id=' + id + '&form=cancelLMappres',
			beforeSend : function() {
	            $('#loadleasinquiryform').addClass('myspinner');
	        },
	        success: function(data){
	            $('#loadleasinquiryform').removeClass('myspinner');
				hideleaseinquiryform();
			}
		})
	}

	function confirmreinstateLMappres(){
		showmodal("confirm", "Are you sure you want to reinstate this application?", "reinstateLMappres", null, "", null, "0");
	}

	function reinstateLMappres(){
		var id = $("#LMinquiryIDforUpdate").val();
		$.ajax({
			type: 'POST',
			url: 'leasingmodules/reservation/class.php',
			data: 'id=' + id + '&form=reinstateLMappres',
			beforeSend : function() {
	            $('#loadleasinquiryform').addClass('myspinner');
	        },
	        success: function(data){
	            $('#loadleasinquiryform').removeClass('myspinner');
				hideleaseinquiryform();
			}
		})
	}

	function confirmconfirmLMappres(){
		showmodal("confirm", "Are you sure you want to reinstate this application?", "confirmreservationLMappres", null, "", null, "0");
	}

	function confirmreservationLMappres(){
		var id = $("#LMinquiryIDforUpdate").val();
		var unitid = $("#LMUnitIDforUpdate").val();
		$.ajax({
			type: 'POST',
			url: 'leasingmodules/reservation/class.php',
			data: 'unitid=' + unitid + '&id=' + id + '&form=confirmreservationLMappres',
			beforeSend : function() {
	            $('#loadleasinquiryform').addClass('myspinner');
	        },
	        success: function(data){
	            $('#loadleasinquiryform').removeClass('myspinner');
				hideleaseinquiryform();
			}
		})
	}

	function confirmoccupyLMappres(){
		showmodal("confirm", "Are you sure you want this occupy the unit?", "occupyLMappres", null, "", null, "0");
	}

	function occupyLMappres(){
		var id = $("#LMinquiryIDforUpdate").val();
		var unitid = $("#LMUnitIDforUpdate").val();
		$.ajax({
			type: 'POST',
			url: 'leasingmodules/reservation/class.php',
			data: 'unitid=' + unitid + '&id=' + id + '&form=occupyLMappres',
			beforeSend : function() {
	            $('#loadleasinquiryform').addClass('myspinner');
	        },
	        success: function(data){
	            $('#loadleasinquiryform').removeClass('myspinner');
				hideleaseinquiryform();
			}
		})
	}

	function showmodal_LMINQtermsandcondition(){
		$("#modal_LMINQtermsandcondition").modal("show");
		showtblLMinqtermsandconditionlist();
		loadgroupselection();
	}

	function showtblLMinqtermsandconditionlist(){
		var group = $("#groupselection").val();
	    var page = $("#txt_LMinqTACselectuserpage").val();
		$.ajax({
			type: 'POST',
			url: 'leasingmodules/reservation/class.php',
			data: 'group=' + group + '&page=' + page + '&form=showtblLMinqtermsandconditionlist',
			beforeSend : function() {
	       		$('#LMINQtermsandconditionloading').addClass('myspinner');
	      	},
		    success: function(data){
	        	$('#LMINQtermsandconditionloading').removeClass('myspinner');
	        	 if(data != ""){
	                $("#tblLMinqtermsandconditionlist").html(data);
	            }else{
	                $("#tblLMinqtermsandconditionlist").html("<tr><td colspan='3' style='text-align: center;'>No Data Found...</td></tr>");
	            }
	            loadentriesLMinqTAC();
				loadpageLMinqTAC()
				highlightselected();
				checkSelected3();
			}
		})
	}

	function highlightselected(){
		$("#tblLMinqtermsandconditionlist tr").each(function(){
			$(this).click(function(){
				eto = $(this).find(".chkLMQselectedTAC");

				if ( eto.is(":checked") ) {
					var ids = $("#sonyxperiax").val();
					eto.prop("checked", false);
					
					$("#sonyxperiax").val(ids.replace($(this).find(".chkLMQselectedTAC").val() + "|", ""));
					$(this).css("color","");
					$(this).css("background-color","");
				}

				else {
					var ids = $("#sonyxperiax").val();
					eto.prop("checked", true);
					ids += $(this).find(".chkLMQselectedTAC").val() + "|";
					$("#sonyxperiax").val(ids);
					$(this).css("color","#FFF");
					$(this).css("background-color","#666");
				}
				
			})
		})
	}

	function loadentriesLMinqTAC(){
		var group = $("#groupselection").val();
	    var page = $("#txt_LMinqTACselectuserpage").val();
	    $.ajax({
	        type: 'POST',
			url: 'leasingmodules/reservation/class.php',
	        data: 'group=' + group + '&page=' + page + '&form=loadentriesLMinqTAC',
	        success: function(data){
	            if(data == "no data"){
	                $("#txtLMinqTACenties").text("");
	            }
	            else{
	                $("#txtLMinqTACenties").text(data);
	            }
	        }
	    });
	}

	function loadpageLMinqTAC(){
		var group = $("#groupselection").val();
	    var page = $("#txt_LMinqTACselectuserpage").val();
	    $.ajax({
	        type: 'POST',
			url: 'leasingmodules/reservation/class.php',
	        data: 'group=' + group + '&page=' + page + '&form=loadpageLMinqTAC',
	        success: function(data){
	            $("#ulLMinqTACpagination").html(data);
	        }
	    });
	}

	function paginationLMinqTAC(page, pagenums){
	    $(".pgnumLMinqTAC").removeClass("active");
	    $("#pgLMinqTAC" + pagenums).addClass("active");
	    $("#txt_LMinqTACselectuserpage").val(page);
	    showtblLMinqtermsandconditionlist();
	    loadpageLMinqTAC();
	    loadentriesLMinqTAC();
	}

	function loadgroupselection(){
		$.ajax({
			type: 'POST',
			url: 'leasingmodules/reservation/class.php',
			data: 'form=loadgroupselection',
			success:function(data){
				$("#groupselection").html(data);
			}
		})
	}

	function addselection(){
		var ids = "";
		$(".chkLMQselectedTAC").each(function(){
			if($(this).is(":checked")){
				ids += this.value + "|";
			}	
		})
		$.ajax({
			type: 'POST',
			url: 'leasingmodules/reservation/class.php',
			data: 'ids=' + ids + '&form=addselection',
			success:function(data){
				$("#div_termsandcondition").html(data);
				$("#modal_LMINQtermsandcondition").modal("hide");
			}
		})
	}

	function checkSelected3(){
		var allselected = $("#sonyxperiax").val();
		var arr = allselected.split("|");
		for ( var a = 0; a <= arr.length-2; a++ ) {
			$(".chkLMQselectedTAC" + arr[a]).prop("checked", true);
			$("#tr"+arr[a]).attr("style","background-color: #666 !important;color:#FFF !important");
		}
	}

	function uploadrequirementscss(){
	    var tag_input = $('#form-field-tags');
	      	try{
	        	tag_input.tag({
	          		placeholder:tag_input.attr('placeholder'),
	          		source: ace.vars['US_STATES'],//defined in ace.js >> ace.enable_search_ahead
	          	})

	        	var $tag_obj = $('#form-field-tags').data('tag');

	        	var index = $tag_obj.inValues('some tag');
	        	$tag_obj.remove(index);
	      	}
	      	catch(e) {
	        	tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
	      	}

      	$('.upload_app_req').ace_file_input({
	        no_file:'No File ...',
	        btn_choose:'Choose',
	        btn_change:'Change',
	        droppable:false,
	        onchange:null,
	        thumbnail:false //| true | large
      	});

      	$(".form_lease_application_req").each(function(){
	      	var form_id = $(this).attr("id");
	      	var inputfile = $(this).find(".upload_app_req");
	      	var empty = $(this).find("a[class='remove']");
	      	inputfile.click(function(){
	        empty.click();
		        $("#"+form_id+"_icon").removeClass("fa-check");
		        $("#"+form_id+"_icon").addClass("fa-remove");
		        $("#"+form_id+"_icon").css("color", "red");
	      	})
	    });
	}

	function chkclippeddocx(thisfile){
	  	var sel = "";
	  	$(".req_already_added_na").each(function(){
	    	var added = $(this).attr("id");
	    	sel += added + "|";
	  	})
	  	$(".form_lease_application_req").each(function(){
	    	var form_id = $(this).attr("id");
	    	var inputfile = $(this).find(".upload_app_req");
	    	var empty = $(this).find("a[class='remove']");
	    	var thisicon = $(this).find(".icon-status-req");
	    	var files  = inputfile.prop("files");
	    	var names = $.map(files, function(val) { return val.name; });
		    if(names != ""){
		        $("#"+form_id+"_icon").removeClass("fa-remove");
		        $("#"+form_id+"_icon").addClass("fa-check");
		        $("#"+form_id+"_icon").css("color", "green");
		        sel += names + "|";
		    }
		    else{

		    }
	  	});
	    var files2  = thisfile.prop("files");    
	    var aso = $.map(files2, function(val) { return val.name; });
	    var arr = sel.split("|");
	    var i = 0;
	    var c = 0;
	    for(i=0; i<=arr.length-1; i++){
	      	if(aso == arr[i]){
	        c++;
	      	}
	    }

	    if(c >= 2){
	      showmodal("alert", "Sorry, but you already attached the same file.", "", null, "", null, "1");
	      thisfile.click();
	    }
	}

	function showmodal_login_override(id, increament, appid, inqid){
	  	$("#modal_login_override").modal("show");
	  	$("#btnshowoverridemodal").attr("onclick", "confirmoverride(\""+id+"\", \""+increament+"\", \""+appid+"\", \""+inqid+"\")");
	}

	function hidemodal_login_override(){
	  	$("#modal_login_override").modal("hide");
	  	$("#txtoverrideusername").val("");
	  	$("#txtoverridepassword").val("");
	}

	function confirmoverride(id, increament, appid, inqid){
		var username = $("#txtoverrideusername").val();
		var password = $("#txtoverridepassword").val();
		var count = $("#overridecount").val();
		if(username != ""){
		    if(password != ""){
		      	$.ajax({
			        type: 'POST',
					url: 'leasingmodules/reservation/class.php',
			        data: 'username=' + username + '&password=' + password + '&id=' + id + '&appid=' + appid + '&inqid=' + inqid + '&form=confirmoverride',
			        success:function(data){
		          		if(data == "1"){
		            		showmodal("alert", "Override Success.", "hidemodal_login_override", null, "", null, "0");
		            		$("#overridemoko"+id).removeClass("upload_app_req");
		            		$("#posting_commentreq_"+increament).removeClass("form_lease_application_req");
		            		count++;
							$("#overridecount").val(count);
		          		}else if(data == "2"){
		            		showmodal("alert", "User not found.", "hidemodal_login_override", null, "", null, "0");
				        }else if(data == "3"){
				            showmodal("alert", "Sorry but you don't have access for this function.", "hidemodal_login_override", null, "", null, "0");
				        }
		        	}
		      	})
		    }else{
		      	showmodal("alert", "Please enter your password.", "", null, "", null, "0");
		    }
		}else{
		    showmodal("alert", "Please enter your username.", "", null, "", null, "0");
		}
	}

	function sendData(inq, app, formid, appid, inqid){
	    $("#"+appid).val(app);
	    $("#"+inqid).val(inq);
	    var data = new FormData($('#'+formid)[0]);
	    $.ajax({
	      	type: 'POST',
	      	url: 'leasingmodules/reservation/uploadrequirements.php', 
	      	data: data,
	      	mimeType: 'multipart/form-data',
	      	contentType: false,
	      	cache: false,
	      	processData: false,
	      	success:function(data){
	      	}
	    });
	}

	function clicktoshowall(){
		$("#clicktoshowall").each(function(){
			if($(this).is(":checked")){
				$(".clicktoshowall").click();
			}else{
				$(".clicktoshowall").click();
			}
		})
	}

	function showLMinqCompanyPosition(){
		$.ajax({
			type: 'POST',
			url: 'leasingmodules/inquiry/class.php',
			data: 'form=showLMinqCompanyPosition',
			success:function(data){
				$("#txtLMinqContactCompanyPosition").html(data);
			}
		})
	}

	function showmodal_addnewposition(){
		$("#modal_addnewposition").modal("show");
		$("#modal_addnewposition :input").val("");
		positionlist();
		showLMinqCompanyPosition();
	}

	function hidemodal_addnewposition(){
		$("#modal_addnewposition").modal("hide");
		positionlist();
		showLMinqCompanyPosition();
	}

	function positionlist(){
		$.ajax({
			type: 'POST',
			url: 'leasingmodules/inquiry/class.php',
			data: 'form=positionlist',
			success:function(data){
				$("#tblcompposlist").html(data);
			}
		})
	}

	function savenewcomppos(){
		var xposition = $("#txtLMinqNewCompPos").val();
		$.ajax({
			type: 'POST',
			url: 'leasingmodules/inquiry/class.php',
			data: 'xposition=' + xposition + '&form=savenewcomppos',
			success:function(data){
				positionlist();
				showLMinqCompanyPosition();
			}
		})
	}

	function LMinqaddcontactperson(){
		var FirstName = $("#txtLMinqContactFirstName").val();
		var MiddleName = $("#txtLMinqContactMiddleName").val();
		var LastName = $("#txtLMinqContactLastName").val();
		var Address = $("#txtLMinqContactAddress").val();
		var EmailAddress = $("#txtLMinqContactEmailAddress").val();
		var MobileNo = $("#txtLMinqContactMobileNo").val();
		var CompanyPosition = $("#txtLMinqContactCompanyPosition").val();
		var TelephoneNo = $("#txtLMinqContactTelephoneNo").val();
		var count = 0;
		$(".txtlminqContactinfo").each(function(){
			if($(this).val() ==""){
				$(this).css("border-color", "#f2a696");
				count++;
			}else{
	          	$(this).css("border-color","#D5D5D5");
			}
		})
		if(count == 0){
			$("#div_LMinqcontactlist").append('<tr class="trcontactlist" id="'+FirstName+'|'+MiddleName+'|'+LastName+'|'+Address+'|'+EmailAddress+'|'+MobileNo+'|'+CompanyPosition+'|'+TelephoneNo+'">' +
	                                        '<td>'+FirstName+' '+MiddleName+' '+LastName+'</td>' +
	                                        '<td>'+CompanyPosition+'</td>' +
	                                        '<td>'+MobileNo+'</td>' +
	                                        '<td>'+TelephoneNo+'</td>' +
	                                        '<td>'+EmailAddress+'</td>' +
	                                        '<td>'+Address+'</td>' +
	                                      '</tr>');
		}else{
			showmodal("alert", "Please fill all fields", "", null, "", null, "0");
		}
		$("#txtLMinqContactFirstName").val("");
		$("#txtLMinqContactMiddleName").val("");
		$("#txtLMinqContactLastName").val("");
		$("#txtLMinqContactAddress").val("");
		$("#txtLMinqContactEmailAddress").val("");
		$("#txtLMinqContactMobileNo").val("");
		$("#txtLMinqContactCompanyPosition").val("");
		$("#txtLMinqContactTelephoneNo").val("");
	}

	function load_req_image(url){
    	$("#content_img").html("<div class='easyzoom easyzoom--overlay easyzoom--with-toggle'><a id='img_viewed2' href='"+url+"'><img id='img_viewed' src='"+url+"' alt=' width='100%' height='380' /></a></div>");
    	funczoom(url);
  	}

  	function funczoom(){
    	$("#modal_view_image").modal("show");
      	var $easyzoom = $('.easyzoom').easyZoom();
        var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');
        $('.thumbnails').on('click', 'a', function(e) {
            var $this = $(this);
            e.preventDefault();
            api1.swap($this.data('standard'), $this.attr('href'));
        });

        var api2 = $easyzoom.filter('.easyzoom--with-toggle').data('easyZoom');
        $('.toggle').on('click', function() {
            var $this = $(this);
            if ($this.data("active") === true) {
                $this.html("<i style='color:white !important;' class='ace-icon fa fa-search-plus bigger-120'></i>").data("active", false);
                api2.teardown();
            } else {
                $this.html("<i style='color:white !important;' class='ace-icon fa fa-search-minus bigger-120'></i>").data("active", true);
                api2._init();
            }
        });
  	}

</script>