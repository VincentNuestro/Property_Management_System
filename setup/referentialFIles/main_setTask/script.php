<script type="text/javascript">
	setTimeout(function() {
		$(".numonly").keydown(function(event) {
           	if(event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 190 || event.keyCode == 9 || event.keyCode == 188){

            }else{
                if (event.keyCode < 48 || event.keyCode > 57 || event.keyCode == 17) {
                    event.preventDefault(); 
                }   
            }
       });
       $(".amount").change(function(){
            var x = ($(this).val()).replace(/,/g,"");
            var v = parseFloat(x||0);
            $(this).val(v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
       });
       $("#txtsearchMainTask").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPageMainTask").val("1");
				displaySetTask(); 
			}else if ( x == '8' ){
				if($('#txtsearchMainTask').val() == ""){
					$("#txtPageMainTask").val("1");
					displaySetTask();
				}
			}
		});
	       $(function(){
			// $(".btnsortdash").each(function(){
				$('.btnsortdash-maintask').click(function(){
					if($(this).hasClass("fa-sort-up")){
						$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
						$("#MainTaskSortType").val("ASC");
						$("#MainTaskSortBy").val(this.id);
						displaySetTask();
					}
					else if($(this).hasClass("fa-sort-down")){
						$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
						$("#MainTaskSortType").val("DESC");
						$("#MainTaskSortBy").val(this.id);
						displaySetTask();
					}else if($(this).hasClass("fa-sort")){
						// $(".btnsortdash").removeClass("fa-sort-down").removeClass("fa-sort-up").addClass("fa-sort");
						if($("#MainTaskSortType").val() == "ASC"){
							$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
							$("#MainTaskSortType").val("DESC");
							$("#MainTaskSortBy").val(this.id);
							displaySetTask();
						}else{
							$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
							$("#MainTaskSortType").val("ASC");
							$("#MainTaskSortBy").val(this.id);
							displaySetTask();
						}
					}
				});
			// });
			});
	}, 1000)

	function displaySetTask(){
		var MainTaskSortBy = $('#MainTaskSortBy').val();
		var MainTaskSortType = $('#MainTaskSortType').val();
		var key = $("#txtsearchMainTask").val();
	    var page = $("#txtPageMainTask").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/main_setTask/class.php',
			data: 'page=' + page + '&key=' + key + '&MainTaskSortBy=' + MainTaskSortBy + '&MainTaskSortType=' + MainTaskSortType + '&form=displaySetTask',
			success: function(data) {
				if(data == ''){
					$("#tblmaintenance_tasklist").html("<tr><td colspan='4' style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tblmaintenance_tasklist").html(data);
				}
			}, complete: function(){
				setTaskSelected();
				loadEntriesMainTask();
				loadPageMainTask();
				showtaskcat();
			}
		})
	}

	function loadEntriesMainTask(){
	    var page = $("#txtPageMainTask").val();
	    var key = $("#txtsearchMainTask").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/main_setTask/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadEntriesMainTask',
	        success: function(data){
	            $("#txtEntriesMainTask").text(data);
	        }
	    });
	}

	function loadPageMainTask(){
	    var page = $("#txtPageMainTask").val();
	    var key = $("#txtsearchMainTask").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/main_setTask/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadPageMainTask',
	        success: function(data){
	            $("#ulPageMainTask").html(data);
	        }
	    });
	}

    function fncPageMainTask(page, pagenums){
        $(".pgnumMainTask").removeClass("active");
        $("#pgMainTask" + pagenums).addClass("active");
        $("#txtPageMainTask").val(page);
        displaySetTask();
    }

	function setTaskSelected(){
		$("#tblmaintenance_tasklist tr").each(function(){
			$(this).click(function(){
				$("#tblmaintenance_tasklist tr").removeClass("selected");
				$(this).addClass("selected");
				selectedSetTask(this.id);
			})
		})
	}

	function selectedSetTask(id){
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/main_setTask/class.php',
			data: 'id=' + id + '&form=selectedSetTask',
			success: function(data) {
				var arr = data.split("|");
				$("#taskcat").val(arr[0]).trigger("change");
				$("#setTaskCode").val(arr[1]);
				$("#setTaskDesc").val(arr[2]);
				$("#setTaskAmount").val(arr[3]);
				$("#setEquip").val(arr[4]);
				$("#hiddensettaskid").val(arr[5]);
			}
		})
	}

	function clickAddSetTask(){
		$("#tblmaintenance_tasklist tr").unbind("click");
		$("#tblmaintenance_tasklist tr").removeClass("selected");
		$("#buttonsSetTask").css("display", "none");
		$("#savingbuttonsSetTask").css("display", "block");
		$("#setTaskAmount").addClass("txtSetTask");
		$(".isReadingYes").removeClass("hide");
		$(".txtSetTask").removeAttr("readonly");
		$("#floorId").removeAttr("disabled");
		$("#bldgId").removeAttr("disabled");
		$(".txtSetTask").val("");
		$("#taskcat").attr("disabled", false);
		$("#setEquip").attr("disabled", false);
		$("#taskcat").val("");
		showtaskcat();
	}

	function cancelbuttonSetTask(){
		displaySetTask();
		$("#buttonsSetTask").css("display", "block");
		$("#savingbuttonsSetTask").css("display", "none");
		$("#updatebuttonsSetTask").css("display", "none");
		$(".txtSetTask").attr("readonly", "readonly");
		$("#floorId").attr("disabled","disabled");
		$("#bldgId").attr("disabled","disabled");
		$(".txtSetTask").val("");
		$("#taskcat").attr("disabled", true);
		$("#setEquip").attr("disabled", true);
        $(".txtSetTask").css("border-color","#D5D5D5");
        $("#setTaskAmount").val("0.00");
        $("#taskcat").val([]).trigger("change");
	}

	function saveSetTask(){
		var taskcat = $("#taskcat").val();
		var setTaskCode = $("#setTaskCode").val();
		var setTaskDesc = $("#setTaskDesc").val();
		var setTaskAmount = $("#setTaskAmount").val().replace(/,/g,"");
		var setEquip = $("#setEquip").val();
		var Count = 0;
		$(".txtSetTask").each(function(){
			if($(this).val() == "" || $(this).val() == 0){
                $(this).css("border-color","#f2a696");
                Count++;
            }else{
                $(this).css("border-color","#D5D5D5");
            }
		})
		if(Count == 0){	
			$.ajax({
				type: 'POST',
				url: 'setup/referentialFiles/main_setTask/class.php',
				data: 'taskcat=' + taskcat + '&setTaskAmount=' + setTaskAmount + '&setTaskCode=' + setTaskCode + '&setTaskDesc=' + setTaskDesc + '&setEquip=' + setEquip + '&form=saveSetTask',
				success:function(data){
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Maintenance Task successfully saved.", "cancelbuttonSetTask", null, "", null, "0");
						}, 500)
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

	function clickUpdateSetTask() {
		var setTaskCode = $("#setTaskCode").val();
		var setTaskDesc = $("#setTaskDesc").val();
		if(setTaskCode == ""){
			setTimeout(function(){
				showmodal("alert", "Select task first", "", null, "", null, "1");
			}, 500)
		}else if(setTaskDesc == ""){
			setTimeout(function(){
				showmodal("alert", "Select task first", "", null, "", null, "1");
			}, 500)
		}else{
			$.ajax({
				type: 'POST',
				url: 'setup/referentialFiles/main_setTask/class.php',
				data: 'setTaskCode=' + setTaskCode + '&form=clickUpdateSetTask',
				success:function(data){
					if(data == 0){
						$("#tblmaintenance_tasklist tr").unbind("click");
						$("#buttonsSetTask").css("display", "none");
						$("#updatebuttonsSetTask").css("display", "block");
						$(".txtSetTask").removeAttr("readonly");
						$("#setEquip").attr("disabled", false);
						$("#taskcat").removeAttr("disabled");
					}else{
						$("#tblmaintenance_tasklist tr").unbind("click");
						$("#buttonsSetTask").css("display", "none");
						$("#updatebuttonsSetTask").css("display", "block");
						$("#setEquip").attr("disabled", false);
						$("#setTaskCode").attr("readony", "readonly");
						$("#setTaskDesc").removeAttr("readonly");
						$("#setTaskAmount").removeAttr("readonly");
						$("#taskcat").removeAttr("disabled");
					}
				}
			})
		}
	}

	function updateSetTask(){
		var taskcat = $("#taskcat").val();
		var hiddensettaskid = $("#hiddensettaskid").val();
		var setTaskCode = $("#setTaskCode").val();
		var setTaskDesc = $("#setTaskDesc").val();
		var setTaskAmount = $("#setTaskAmount").val().replace(/,/g,"");
		var setEquip = $("#setEquip").val();
		var Count = 0;
		$(".txtSetTask").each(function(){
			if($(this).val() == "" || $(this).val() == 0){
                $(this).css("border-color","#f2a696");
                Count++;
            }else{
                $(this).css("border-color","#D5D5D5");
            }
		})
		if(Count == 0){
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/main_setTask/class.php',
				data: 'hiddensettaskid=' + hiddensettaskid + '&setTaskCode=' + setTaskCode + '&setTaskDesc=' + setTaskDesc + '&setTaskAmount=' + setTaskAmount + '&taskcat=' + taskcat +  '&setEquip=' + setEquip + '&form=updateSetTask',
				success: function (data) {
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Maintenance Task successfully updated.", "cancelbuttonSetTask", null, "", null, "0");
						}, 500)
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

	function clickDeleteSetTask() {
		var setTaskCode = $("#setTaskCode").val();
		var setTaskDesc = $("#setTaskDesc").val();
		$.ajax({
			type: 'POST',
			url: 'setup/referentialFiles/main_setTask/class.php',
			data: 'setTaskCode=' + setTaskCode + '&form=clickUpdateSetTask',
			success:function(data){
				if(data == 0){
					if(setTaskCode == ""){
						setTimeout(function(){
							showmodal("alert", "Select task first", "", null, "", null, "1");
						}, 500)
					}else{
						setTimeout(function(){
							showmodal("confirm", "Are you sure you want to delete " + setTaskDesc, "clickDeleteSetTask2", null, "", null, "0");
						}, 500)
					}
				}else{
					setTimeout(function(){
						showmodal("alert", "Referential cannot be deleted as the system has records that needs it.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function clickDeleteSetTask2(){
		var setTaskDesc = $("#setTaskDesc").val();
		var hiddensettaskid = $("#hiddensettaskid").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/main_setTask/class.php',
			data: 'hiddensettaskid=' + hiddensettaskid + '&form=deleteSetTask',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", setTaskDesc + " has been deleted.", "cancelbuttonSetTask", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", data, "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function showtaskcat(){
		$.ajax({
			type: 'POST',
			url: 'setup/referentialFiles/main_setTask/class.php',
			data: 'form=showtaskcats',
		success:function(data){
				$(".searchy_select").select2();
                $(".select2-selection").css('height','33px');
				$("#taskcat").html(data);
			}
		})
	}

	function showsetEquip(){
		$.ajax({
			type: 'POST',
			url: 'setup/referentialFiles/main_setTask/class.php',
			data: 'form=showsetEquip',
			success:function(data){
				$("#setEquip").html(data);	
			}
		})
	}

	function fncCheckisReading(){
		var catid = $("#taskcat").val();
		$.ajax({
			type: 'POST',
			url: 'setup/referentialFiles/main_setTask/class.php',
			data: 'catid=' + catid + '&form=fncCheckisReading',
			success: function(data){
				if(data == "1" || data == "2" || data == "3"){
					$("#setTaskAmount").removeClass("txtSetTask");
					$(".isReadingYes").addClass("hide");
				}else{
					$("#setTaskAmount").addClass("txtSetTask");
					$(".isReadingYes").removeClass("hide");
				}
			}
		})
	}

	function AutoConsolidateTask(){
		var key = $('#txtsearchunitclass').val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/main_setTask/class.php',
			data: 'key=' + key + '&form=AutoConsolidateTask',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "List of maintenance task successfully exported.", "", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to export list of maintenance task.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}
</script>