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
		showtblrequestlist();
		$(".fixTable").tableHeadFixer(); 
		$("#txtsearchapptr").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#apptrpagecount").val("1");
				showtblrequestlist(); 
			}else if(x == '8'){
				if($('#txtsearchapptr').val() == ""){
					$("#apptrpagecount").val("1");
					showtblrequestlist();
				}
			}
		});

		$('.timepickeronly').datetimepicker({
			format: 'LT'
		});
	})
	
	function createrequestmodal(){
		$("#createnewrequest").modal("show");
		$("#txtTRAppDate").val("<?php echo date('m/d/Y'); ?>");
		showTenantNames();
	}

				  
/*	START Michael Capistrano 09-09-2019*/
/*var i=1;  
function Requestpeople(){
	  
   i++;  
   $('.dynamic_field').append('<div id="row'+i+'"><input type="text" placeholder="Enter People Name" class="Attendees[] form-control name_list txtTRrequiredekim" /><button type="button" name="remove" id="'+i+'" class="btn-danger btn_remove">X</button></div>');


  $(document).on('click', '.btn_remove', function(){  
	   var button_id = $(this).attr("id");   
	   $('#row'+button_id+'').remove();  
  });   
}*/

	function appendTextPeople(){

			$('#appendpeopletxt').append('<div class="input-group"><input class="form-control txtTRrequiredekim txtappendpeople" type="text"><span class="input-group-addon"><button class="btn-danger" id="btnremove"><i class="ace-icon fa fa-minus"></i></button></span></div>');

			$()

	}

	function RequestTenantSelected(){
		$("#tblrequestlist tr").each(function(){
			var cellrow = $(this);
			cellrow.click(function(){
				if ( cellrow.hasClass("selected") ) {
					cellrow.removeClass("selected")
				} else {
					cellrow.addClass("selected");
				}
			})	
		})	
	}

	function CreateTenantRequest(){
		$("#collapseThree input").val("");
		$("#collapseThree textarea").text("");
		$("#collapseThree textarea").val("");
		$("#collapseTwo input").val("");
		$("#tbltentvistorslist").html("");
		$("#tbltentitemslist").html("");
		$("#chckboxnotify").prop('checked',false);
		$("#CreateNewTenantRequest").modal("show");
		$("#ApplicationDate").val("<?php echo date('m/d/Y'); ?>");
		 showTenantRequest();
		 showTenantRequestCategory();
		 showTenantRequestTag();
		 showTenantCategoryTagInfo();
	}

	function getTenantCode(){
		showTenantCategoryTagInfo($('#RequestCat').val());
	}


	function closeTenantRequest(){
		$("#CreateNewTenantRequest").modal("hide"); 
		$(".txtTRrequired").val("");
		$("#Remarks").val("");
		$(".txtTRrequired").css("border-color","#D5D5D5");
		showtblrequestlist();
	}
/*	END Michael Capistrano 09-09-2019*/


	function closeandclear(){
		$("#createnewrequest").modal("hide");
		$(".txtTRrequired").val("");
		$(".txtTRrequired").css("border-color","#D5D5D5"); 
		$("#txtTRDetails").attr("readonly", "readonly");
		$(".radchecked").prop("checked", false);
		showtblrequestlist();
	}

	function showTenantNames(){
		$.ajax({
			type: 'POST',
			url: 'tenants_request/class.php',
			data: 'form=showTenantNames',
			success:function(data){
				$("#txtTRTenantName").html(data);
			}
		})
	}

/*	Michael Capistrano 09-10-2019*/
	function showTenantRequest(){
		$.ajax({
			type:'POST',
			url:'tenants_request/class.php',
			data: 'form=showTenantRequest',
			success:function(data){
				$("#txtTenantRequest").html(data);
			}
		})
	}


	function showTenantRequestCategory(){
		$.ajax({
			type: 'POST',
			url: 'tenants_request/class.php',
			data: 'form=showTenantRequestCategory',
			success:function(data){
				$("#RequestCat").html(data);
			}
		})
	}

	function showTenantRequestTag(){
		$.ajax({
			type: 'POST',
			url: 'tenants_request/class.php',
			data: 'form=showTenantRequestTag',
			success:function(data){
				$("#RequestTag").html(data);
			}
		})
	}
/*	END Michael Capistrano 09-09-2019*/

	function showTenantNamesInfo(tenantid){
		$.ajax({
			type: 'POST',
			url: 'tenants_request/class.php',
			data: 'tenantid=' + tenantid + '&form=showTenantNamesInfo',
			success:function(data){
				var arr = data.split("|");
				$("#txtTRFN").val(arr[0]);
				$("#txtTRMN").val(arr[1]);
				$("#txtTRLN").val(arr[2]);
				$("#txtTRMall").val(arr[3]);
				$("#txtTRWing").val(arr[4]);
				$("#txtTRFloor").val(arr[5]);
				$("#txtTRUnit").val(arr[6]);
				$("#txtTRUnitType").val(arr[7]);
				$("#txtTRClassification").val(arr[8]);
				$("#txtTRTenantID").val(arr[9]);
				$("#txtTRMobileNumber").val(arr[10]);
				$("#txtTRTelephoneNumber").val(arr[11]);
				$("#txtTREmailAddress").val(arr[12]);
			}
		})
	}

/*	Michael Capistrano 09-10-2019*/
	function showTenantRequestInfo(tenantRequestid){
		$.ajax({
			type: 'POST',
			url: 'tenants_request/class.php',
			data: 'tenantid=' + tenantRequestid + '&form=TenantRequestInfo',
			success:function(data){
				var arr = data.split("|");
				$("#TenantID").val(arr[0]);
				$("#UnitID").val(arr[1]);
				$("#MallID").val(arr[2]);	
			}
		})
	}

	function showTenantCategoryTagInfo(RequestTag){
		$.ajax({
			type: 'POST',
			url: 'tenants_request/class.php',
			data: 'RequestTag=' + RequestTag + '&form=showTenantCategoryTagInfo',
			success:function(data){
				// alert(data);
				$(".showTenantCategoryTagInfo").html(data);
			}
		})
	}

	function SaveRequestTenant(){
		var ApplicationDate = $("#ApplicationDate").val();
		var TenantID = $("#TenantID").val();
		var UnitID = $("#UnitID").val();
		var MallID = $("#MallID").val();
		var RequestCat = $("#RequestCat").val();
		var RequestTag = $("#RequestTag").val();
		var Remarks = $("#Remarks").val();
		var isApproval = "";
		var count = 0;
		var Attendees = "";
		var visitors = "";
		var itemsx = "";
		var chckboxnotify = 0;
		if($('#chckboxnotify').is(':checked')){
			chckboxnotify = 1;
		}
		// -- loop para makuha lahat ng attendee/text fields
		$('.txtappendpeople').each(function(){
			Attendees += "|"+$(this).val();
		});

/*		var Attendees = $(".Attendees").val();*/

		 $("#isApproval").each(function(){
			if($(this).is(":checked") == true){
				isApproval = this.value;
			}
		})

		 $("#tbltentvistorslist tr td").each(function(){
			if($(this).hasClass('visfname')){
				visitors += "####";
			}else{
				visitors += "|"+$(this).text();
			}

		})

		$("#tbltentitemslist tr td").each(function(){
			if($(this).hasClass('itemsname')){
				itemsx += "####";
			}else{
				itemsx += "|"+$(this).text();
			}

		})


		$(".txtTRrequiredekim").each(function(){
			if($(this).val() == "" || $(this).val() == null){
				$(this).css("border-color","#f2a696");
				count++;
			}else{
				$(this).css("border-color","#D5D5D5");
			}
		});

		if(count == 0){
			$.ajax({
				type: 'POST',
				url: 'tenants_request/class.php',
				data: '&ApplicationDate=' + ApplicationDate + '&TenantID=' + TenantID + '&UnitID=' + UnitID + '&MallID=' + MallID + '&RequestCat='+ RequestCat + '&RequestTag=' + RequestTag + '&Remarks=' + Remarks +'&isApproval=' + isApproval + '&Attendees=' + Attendees + "&visitors=" + visitors + '&itemsx=' + itemsx + '&chckboxnotify=' + chckboxnotify + '&form=saveTenantRequest', 
				success:function(data){
					var arr = data.split("|"); 
					if(arr[0] == "1"){
						setTimeout(function() {
							showmodal("alert", arr[1], "closeTenantRequest", null, "", null, "0");                    
						}, 500);
					}else{
						setTimeout(function() {
							showmodal("alert", arr[1], "closeTenantRequest", null, "", null, "0");                    
						}, 500);``
					}
					$("#collapseThree input").val("");
					$("#collapseThree textarea").text("");
					$("#collapseThree textarea").val("");
					$("#collapseTwo input").val("");
					$("#tbltentvistorslist").html("");
					$("#tbltentitemslist").html("");
					$("#chckboxnotify").prop('checked',false);
				}
			})
		}else{
			setTimeout(function() {
				showmodal("alert", "Please fill all fields.", "", null, "", null, "0");                    
			}, 500);
		}
	}

/*	END Michael Capistrano 09-10-2019*/

	function saverequest(){
		var AppDate = $("#txtTRAppDate").val();
		var TenantID = $("#txtTRTenantName").val();
		var FName = $("#txtTRFN").val();
		var MName = $("#txtTRMN").val();
		var LName = $("#txtTRLN").val();
		var Mall = $("#txtTRMall").val();
		var Wing = $("#txtTRWing").val();
		var Floor = $("#txtTRFloor").val();
		var Unit = $("#txtTRUnit").val();
		var UnitType = $("#txtTRUnitType").val();
		var Classification = $("#txtTRClassification").val();
		var MobileNumber = $("#txtTRMobileNumber").val();
		var Telephone = $("#txtTRTelephoneNumber").val();
		var Email = $("#txtTREmailAddress").val();
		var Details = $("#txtTRDetails").val();
		var Scope = "";
		var bilang = 0;
		$(".radchecked").each(function(){
			if($(this).is(":checked")){
				Scope = this.value;
			}
		})
		$(".txtTRrequired").each(function(){
			if($(this).val() == "" || $(this).val() == null){
				$(this).css("border-color","#f2a696");
				bilang++;
			}else{
				$(this).css("border-color","#D5D5D5");
			}
		});
		if(bilang == 0){
			$.ajax({
				type: 'POST',
				url: 'tenants_request/class.php',
				data: 'AppDate=' + AppDate + '&TenantID=' + TenantID + '&FName=' + FName + '&MName=' + MName + '&LName=' + LName + '&Mall=' + Mall + '&Wing=' + Wing + '&Floor=' + Floor + '&Unit=' + Unit + '&UnitType=' + UnitType + '&Classification=' + Classification + '&MobileNumber=' + MobileNumber + '&Telephone=' + Telephone + '&Email=' + Email + '&Email=' + Email + '&Scope=' + Scope + '&Details=' + Details + '&form=saverequest',
				success:function(data){
					var arr = data.split("|");
					if(arr[0] == "1"){
						setTimeout(function() {
							showmodal("alert", arr[1], "closeandclear", null, "", null, "0");                    
						}, 1000);
					}else{
						setTimeout(function() {
							showmodal("alert", arr[1], "closeandclear", null, "", null, "0");                    
						}, 1000);
					}
				}
			})
		}else{
			setTimeout(function() {
				showmodal("alert", "Please fill all fields.", "", null, "", null, "0");                    
			}, 1000);
		}
	}

	function showtblrequestlist(){
		var key = $("#txtsearchapptr").val();
		var page = $("#apptrpagecount").val();
		$.ajax({
			type: 'POST',
			url: 'tenants_request/class.php',
			data: 'page=' + page + '&key=' + key + '&form=displayTenantRequest',
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
				loadapptrentries();
				loadapptrpage();
				RequestTenantSelected();
			}
		})
	}

	function loadapptrentries(){
		var page = $("#apptrpagecount").val();
		var key = $("#txtsearchapptr").val();
		$.ajax({
			type: 'POST',
			url: 'tenants_request/class.php',
			data: 'key=' + key + '&page=' + page + '&form=loadapptrentries',
			success: function(data){
				$("#apptrentries").text(data);
			}
		});
	}

	function loadapptrpage(){
		var page = $("#apptrpagecount").val();
		var key = $("#txtsearchapptr").val();
		$.ajax({
			type: 'POST',
			url: 'tenants_request/class.php',
			data: 'key=' + key + '&page=' + page + '&form=loadapptrpage',
			success: function(data){
				$("#ulapptrpage").html(data);
			}
		});
	}

	function paginationapptr(page, pagenums){
		$(".pgapptr").removeClass("active");
		$("#pgcomplatspage" + pagenums).addClass("active");
		$("#apptrpagecount").val(page);
		showtblrequestlist();
	}

	function saveTenantRequestFilter(){
		var module = "TenantRequest";
		var checked = "";
		$('input:checkbox[name="form-field-chkapptr"]').each(function(){
			if($(this).is(":checked")){
				var value = $(this).attr("value");
				checked += value + "|";
			}
		})
		var checked2 = "";
		$('input:checkbox[name="form-field-chkapptr"]').each(function(){
				var value2 = $(this).attr("value");
				checked2 += value2 + "|";
		})
		var checked3 = "";
		$('input:checkbox[name="form-field-applevelstat"]').each(function(){
			if($(this).is(":checked")){
				var value3 = $(this).attr("value");
				checked3 += value3 + "|";
			}
		})
		var xcheck = $("#appstatlevel").val();
		var Date1 = $("#appdatefrom").val();
		var Date2 = $("#appdateto").val();
		$.ajax({
			type: 'POST',
			url: 'filter/class.php',
			data: 'module=' + module + '&checked=' + checked + '&checked2=' + checked2 + '&checked3=' + checked3 + '&xcheck=' + xcheck + '&Date1=' + Date1 + '&Date2=' + Date2 + '&form=saveFilters',
			success: function(data){
				$("#LINK_TenantRequest_filter").click();
				showtblrequestlist();
			}
		})
	}

	function getapplevelcount(){
		$.ajax({
			type: 'POST',
			url: 'tenants_request/class.php',
			data: 'form=getapplevelcount',
			success:function(data){
				$("#appstatlevel").html(data);
			}
		})
	}

	function loadTenantRequestFilter(module){
		getapplevelcount();
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
				for(var i=0; i<=arr3.length-1; i++){
					$('input:checkbox[id="filter_'+arr3[i]+'"][value="'+arr3[i]+'"]').attr('checked', 'checked');
				}
				$("#appdatefrom").val(arr2[0]);
				$("#appdateto").val(arr2[1]);
				setTimeout(function(){
					$("#appstatlevel").val(datas[3]);
				}, 500)
			}
		})
	}

	function approvethis(){
		var ctr = $('input.mainchkapptr:checked').size();
		if(ctr == 0){
			setTimeout(function() {
				showmodal("alert", "Please select the request you want to approve.", "", null, "", null, "1");                    
			}, 1000);
		}else{
			setTimeout(function() {
				showmodal("confirm", "Are you sure you want to approve selected request?", "approvethis2", null, "", null, "1");                    
			}, 1000);
		}
	}

	function approvethis2(){
		var ids = "";
		$(".mainchkapptr").each(function(){
			if($(this).is(":checked")){
				ids += this.value + "|";
			}
		})
		$.ajax({
			type: 'POST',
			url: 'tenants_request/class.php',
			data: 'ids=' + ids + '&form=approvethis',
			success:function(data){
				setTimeout(function() {
					showmodal("alert", "Selected request successfully approved.", "showtblrequestlist", null, "", null, "0");                    
				}, 1000);
			}
		})
	}

	function disapprovethis(){
		var ctr = $('input.mainchkapptr:checked').size();
		if(ctr == 0){
			setTimeout(function() {
				showmodal("alert", "Please select the request you want to disapprove.", "", null, "", null, "1");                    
			}, 1000);
		}else{
			setTimeout(function() {
				showmodal("confirm", "Are you sure you want to disapprove selected request?", "disapprovethis2", null, "", null, "1");                    
			}, 1000);
		}
	}

	function disapprovethis2(){
		var ids = "";
		$(".mainchkapptr").each(function(){
			if($(this).is(":checked")){
				ids += this.value + "|";
			}
		})
		$.ajax({
			type: 'POST',
			url: 'tenants_request/class.php',
			data: 'ids=' + ids + '&form=disapprovethis',
			success:function(data){
				setTimeout(function() {
					showmodal("alert", "Selected request successfully disapproved.", "showtblrequestlist", null, "", null, "0");                    
				}, 1000);
			}
		})
	}

	function showfilterofmalltr(){
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=tblref_mall',
			success:function(data){
				$("#printbymeTR").html(data);
			}
		})
	}

	function printbydaterangeTR(){
		var datefrom = $("#printapptrfrom").val();
		var dateto = $("#printapptrto").val();
		var mallid = $("#printbymeTR").val();
		if(mallid != ""){
			$.ajax({
				type: 'POST',
				url: 'tenants_request/class.php',
				data: 'datefrom=' + datefrom + '&dateto=' + dateto + '&mallid=' + mallid + '&form=printbydaterangeTR',
				success:function(data){
					var arr = data.split("|");
					$("#tblmpowobodrc").html(arr[0]);
					$("#dateFromwoprint").text(arr[1]);
					$("#dateTowoprint").text(arr[2]);
					$.ajax({
						type: 'POST',
						url: 'mainclass.php',
						data: 'mallID=' + mallid + '&form=getheaderprint',
						success:function(data){
							$("#template").html(data);
							var toprint = $("#applalall").html();
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
		}else{
			showmodal("alert", "Please select mall.", "", null, "", null, "1");
		}
	}

	function printTR(appno, mallid){
		$(".machecheckankapagpinirint").removeAttr("checked");
		$.ajax({
			type: 'POST',
			url: 'tenants_request/class.php',
			data: 'appno=' + appno + '&form=printTR',
			success:function(data){
				var arr = data.split("|");
				$("#txtapptrtenantid").text(arr[1]);
				$("#txtapptrappdate").text(arr[0]);
				$("#txtapptrappno").text(appno);
				$("#txtapptrtenantname").text(arr[2]);
				$("#txtapptrmobile").text(arr[3]);
				$("#txtapptrtelephone").text(arr[4]);
				$("#txtapptremail").text(arr[5]);
				$("#txtapptrbuilding").text(arr[6]);
				$("#txtapptrwing").text(arr[7]);
				$("#txtapptrfloor").text(arr[8]);
				$("#txtapptrunit").text(arr[9]);
				$(".machecheckankapagpinirint").each(function(){
					if($(this).val() === arr[10]){
						$(this).attr("checked", "checked");
					}
				})
				$("#txtapptrdetails").text(arr[11]);            
				$.ajax({
					type: 'POST',
					url: 'mainclass.php',
					data: 'mallID=' + mallid + '&form=getheaderprint',
					success:function(data){
						$("#template2").html(data);
						var toprint = $("#printapplalallbyrequest").html();
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


	/*  ADDED BY KEVINL  09192019   */
	function  addthisvistor() {
		var txttentfname = $("#txttentfname").val();
		var txttentlname = $("#txttentlname").val();
		var txttentidpres = $("#txttentidpres").val();
		var txttentimage = $("#txttentimage").val();
		var txttentlogin = $("#txttentlogin").val();
		var txttentlogout = $("#txttentlogout").val();
		var cnt = $("#tbltentvistorslist tr").length + 1;
		if(txttentfname=="" ){
			$("#txttentfname").focus();
		}else if( txttentlname==""){
			$("#txttentlname").focus();
		}else if( txttentidpres==""){
			$("#txttentidpres").focus();
		}else{
			$("#tbltentvistorslist").append('<tr id="trvis'+cnt+'"><td class="visfname">'+cnt+'</td><td >'+txttentlname+'</td><td>'+txttentfname+'</td><td>'+txttentidpres+'</td><td>'+txttentimage+'</td><td>'+txttentlogin+'</td><td>'+txttentlogout+'</td><td><a onclick="removetentvis(\'trvis'+cnt+'\')"><i class="ace-icon glyphicon glyphicon-remove" style="color:red"></i></a></td></tr>');
			$("#collapseTwo input").val("");
		}

	}

	function removetentvis(trid){
		$("#"+trid).remove();
	}

	function addthisitem(){
		var txttentitemname = $("#txttentitemname").val();
		var txttentqty = $("#txttentqty").val();
		var txttentunit = $("#txttentunit").val();
		var txttentnotes = $("#txttentnotes").val();
		var cnt = $("#tbltentitemslist tr").length + 1;
		if(txttentitemname=="" ){
			$("#txttentitemname").focus();
		}else if(txttentqty=="" ){
			$("#txttentqty").focus();
		}else{
			$("#tbltentitemslist").append('<tr id="tritems'+cnt+'"><td class="itemsname">'+cnt+'</td><td>'+txttentitemname+'</td><td>'+txttentqty+'</td><td>'+txttentunit+'</td><td>'+txttentnotes+'</td><td><a onclick="removetentvis(\'tritems'+cnt+'\')"><i class="ace-icon glyphicon glyphicon-remove" style="color:red"></i></a></td></tr>');
			$("#collapseThree input").val("");
			$("#collapseThree textarea").text("");
			$("#collapseThree textarea").val("");
		}
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
</script>