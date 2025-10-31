<script type="text/javascript">
	$(function(){
		$(".fixTable").tableHeadFixer();
		$("#txtLAPageCount").val("1");
		tblListofApplication();
		$("#txtSearchApplication").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtLAPageCount").val("1");
				tblListofApplication(); 
			}else if ( x == '8' ){
				if($('#txtSearchApplication').val() == ""){
					$("#txtLAPageCount").val("1");
					tblListofApplication();
				}
			}
		});
	})
		
	function tblListofApplication(){
		var key = $("#txtSearchApplication").val();
		var page = $("#txtLAPageCount").val();
		$.ajax({
			type: 'POST',
			url: 'leasingapplication/class.php',
			data: 'key=' + key + '&page=' + page + '&form=tblListofApplication',
			beforeSend : function() {
                $('#indexloadingscreen').addClass('myspinner');
            },
            success: function(data){
                $('#indexloadingscreen').removeClass('myspinner');
				if(data != ""){
		          	$("#tblListofApplication").html(data);
		        }else{
		          	$("#tblListofApplication").html("<tr><td colspan='14' style='text-align: center;'>No Data Found...</td></tr>");
		        }
		        tblListofApplicationEntries();
				tblListofApplicationPagination();
			}, complete: function(){
				$('#user-profile-2 .memberdiv').on('mouseenter touchstart', function(){
                    var $this = $(this);
                    var $parent = $this.closest('.tab-pane');
                    var off1 = $parent.offset();
                    var w1 = $parent.width();
                    var off2 = $this.offset();
                    var w2 = $this.width();
                    var place = 'left';
                    place = 'right';
                }).on('click', function(e) {
                    e.preventDefault();
                })
			}
		})
	}

	function tblListofApplicationEntries(){
	  	var key = $("#txtSearchApplication").val();
	  	var page = $("#txtLAPageCount").val();
        $.ajax({
            type: 'POST',
            url: 'leasingapplication/class.php',
            data: 'key=' + key + '&page=' + page + '&form=tblListofApplicationEntries',
            success: function(data){
                $("#txtLAPageEntries").text(data);
        	}	
        })
    }

	function tblListofApplicationPagination(){
	  	var key = $("#txtSearchApplication").val();
	  	var page = $("#txtLAPageCount").val();
        $.ajax({
            type: 'POST',
            url: 'leasingapplication/class.php',
            data: 'key=' + key + '&page=' + page + '&form=tblListofApplicationPagination',
            success: function(data){
                $("#ulLAPagination").html(data);
            }
        })
	}

    function tblListofApplicationPageFunc(page, pagenums){
        $(".pgnumLA").removeClass("active");
        $("#pgLA" + pagenums).addClass("active");
        $("#txtLAPageCount").val(page);
        tblListofApplication();
	}

	function saveLeasingApplicationFilter(){
        var module = "Application";
        var checked = "";
        $('input:checkbox[name="form-field-checkboxkeyword"]').each(function(){
            if($(this).is(":checked")){
                var value = $(this).attr("value");
                checked += value + "|";
            }
        })

        var checked2 = "";
        $('input:checkbox[name="form-field-checkboxkeyword"]').each(function(){
            var value2 = $(this).attr("value");
            checked2 += value2 + "|";
        })        

        var checked3 = "";
        $('input:checkbox[name="form-field-checkbox-stat"]').each(function(){
          	if($(this).is(":checked")){
	            var value3 = $(this).attr("value");
	            checked3 += value3 + "|";
          	}
        })  

        var xcheck = "";
        $('input:checkbox[name="form-field-checkbox-unt"]').each(function(){
          	if($(this).is(":checked")){
	            var value3 = $(this).attr("value");
	            xcheck += value3 + "|";
          	}
        })
        
        var Date1 = $("#txtdiv_strtappp").val();
        var Date2 = $("#txtdiv_endappp").val();
        var Date3 = "";
        var Date4 = ""; 
        $.ajax({
            type: 'POST',
            url: 'filter/class.php',
            data: 'module=' + module +  '&checked=' + checked +  '&checked2=' + checked2 +  '&checked3=' + checked3 +  '&xcheck=' + xcheck +  '&Date1=' + Date1 +  '&Date2=' + Date2 +  '&Date3=' + Date3 +  '&Date4=' + Date4 + '&form=saveFilters',
            success: function(data){
              	$("#LINK_Appliaction_filter").click();
              	tblListofApplication();
            }
        })
    }

    function loadFilterLeasingApplication(module){
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
                $("#txtdiv_strtappp").val(arr2[0]);
                $("#txtdiv_endappp").val(arr2[1]);
                for(var i=0; i<=arr3.length-1; i++){
                    $('input:checkbox[id="filter_'+arr3[i]+'"][value="'+arr3[i]+'"]').attr('checked', 'checked');
                }
                for(var i=0; i<=arr4.length-1; i++){
                    $('input:checkbox[id="filter_'+arr4[i]+'"][value="'+arr4[i]+'"]').attr('checked', 'checked');
                }
            }
        })
    }

    function fncBrowseProposalList(InquiryID, companyID, tradeID, forFinal){
        $("#mdlProposalList").modal("show");
    	fncAllClassificationRef();
    	fncLoadProposalList(InquiryID);
    	if(forFinal == "1"){
            $(".txtInqDisabled").prop("disabled",  true);
        }else{
            $(".txtInqDisabled").prop("disabled",  false);
        }
    	$("#btnLANewProposal").attr("onclick", "fncEditGlobalFormInquiry('0', \""+ InquiryID +"\", '', '', \""+ tradeID +"\", \""+ companyID +"\", '0', '0')")
    	$.ajax({
            type: 'POST',
            url: 'include/class.php',
            data: 'companyID=' + companyID + '&tradeID=' + tradeID + '&form=mdlTradeInfo',
            success:function(data){
                var arr = data.split("|");
                $("#txtProTradeName").val(arr[0]);
                $("#txtProCompany").val(arr[1]);
                $("#txtProIndustry").val(arr[3]);
                $("#txtProMerchantCode").val(arr[4]);
                $("#imgProTenant").attr("src", arr[6]);
                $("#imgProTenant").attr("alt", arr[0]);
            }
        })
    	$.ajax({
            type: 'POST',
            url: 'global_form/class.php',
            data: 'InquiryID=' + InquiryID + '&form=fncLoadInqOtherInfo',
            success: function(data){
                var arr = data.split("|");
                $("#txtProSource").val(arr[0]);
                $("#txtProProcessOwner").val(arr[1]);
                $("#txtProClassification").val(arr[2]);
                $.ajax({
                    type: 'POST',
                    url: 'mainclass.php',
                    data: 'Classification=' + arr[2] + '&form=fncAllDepartmentRef',
                    success: function(data){
                        $("#txtProDepartment").html(data);
                    }, complete: function(){
                        $("#txtProDepartment").val(arr[3]);
                        $.ajax({
                            type: 'POST',
                            url: 'mainclass.php',
                            data: 'Department=' + arr[3] + '&form=fncAllCategoryRef',
                            success: function(data){
                                $("#txtProCategory").html(data);
                            }, complete: function(){
                                $("#txtProCategory").val(arr[4]);
                            }
                        })
                    }
                })
            }
        })
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'tradeID=' + tradeID + '&form=fncgetTradeContact',
            success: function(data){
                if(data != ""){
                    $("#div_proposal_contact_person").html(data);
                }else{
                    $("#div_proposal_contact_person").html('<center><img src="assets/images/network.png" style="margin: 20px;height: 120px; width: 120px;"><h3>No contact persons yet.</h3></center>');
                }
            }
        })
    }

    function fncLoadProposalList(InquiryID){
    	$.ajax({
        	type: 'POST',
        	url: 'leasingapplication/class.php',
        	data: 'InquiryID=' + InquiryID + '&form=fncgetProposalList',
        	success: function(data){
        		$("#div_ProposalList").html(data);
        	}
        })
    }

    function fncCloseProposal(InquiryID){
    	fncLoadProposalList(InquiryID)
    	tblListofApplication();
    	$("#mdlAddNewInquiry").modal("hide");
    }

    function fncApproveProposal(InquiryID, isProposal){
    	setTimeout(function(){
	        showmodal("confirm", "Are you sure you want to approve this proposal?", "fncApproveProposalGo", InquiryID+"|"+isProposal+"|", "", null, "0");
		}, 500)
    }

    function fncApproveProposalGo(InquiryID, isProposal){
    	$.ajax({
    		type: 'POST',
    		url: 'leasingapplication/class.php',
    		data: 'InquiryID=' + InquiryID + '&isProposal=' + isProposal + '&form=fncApproveProposalGo',
    		success: function(data){
    			setTimeout(function(){
			        showmodal("alert", "Proposal successfully approved.", "fncLoadProposalList", InquiryID+"|", "", null, "0");
				}, 500)
				tblListofApplication();
    		}
    	})
    }

	function ViewLALogs(applicationID){
		$("#modal_LALogs").modal("show");
		var module = 'Leasing Application Module'
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'LogID=' + applicationID + '&module=' + module + '&form=ViewAllHistory',
			success: function(data){
				$("#tblLALogs").html(data);
			}
		})
	}

	function fncSendAwardNotice(InquiryID, Status){
		if(Status == 'Pending'){
			setTimeout(function(){
		        showmodal("confirm", "Notify approver?", "fncSendAwardNotice2", InquiryID+"|", "", null, "1");
			}, 500)
		}else{
			$("#mdlAwardConfirmation").modal("show");
            $.ajax({
                type: 'POST',
                url: 'leasingapplication/class.php',
                data: 'InquiryID=' + InquiryID + '&form=getLayoutList',
                success: function(data){
                    $("#btnAwardNoticePreview").html(data);
                }
            })
            $("#btnSendAwardApprove").attr("onclick", "fncApproveAward(\""+ InquiryID +"\", \"Approved\")");
			$("#btnSendAwardDisapprove").attr("onclick", "fncApproveAward(\""+ InquiryID +"\", \"Disapproved\")");
            
            
		}
	}

	function fncSendAwardNotice2(InquiryID){
        $("#btnSendAwardNotice").button("loading");
		$.ajax({
			type: 'POST',
			url: 'leasingapplication/class.php',
			data: 'InquiryID=' + InquiryID + '&form=fncSendAwardNotice2',
			success: function(data){
                $("#btnSendAwardNotice").button("reset");
                var arr = data.split("|");
                if(arr[0] == "1"){
                    setTimeout(function(){
                        showmodal("alert", arr[1], "tblListofApplication", "", "", null, "0");
                    }, 500)
                }else{
                    setTimeout(function(){
                        showmodal("alert", arr[1], "", "", "", null, "1");
                    }, 500)
                }
			}
		})
	}

	function fncApproveAward2(InquiryID, AwardStat){
		setTimeout(function(){
	        showmodal("confirm", "Are you sure you want to "+ AwardStat +" the award of this prospect tenant?", "fncApproveAward", InquiryID+"|"+AwardStat+"|", "", null, "1");
		}, 500)
	}

	function fncApproveAward(InquiryID, AwardStat){
		$.ajax({
			type: 'POST',
			url: 'leasingapplication/class.php',
			data: 'InquiryID=' + InquiryID + '&AwardStat=' + AwardStat + '&form=fncApproveAward',
			success: function(data){
				tblListofApplication();
			}, complete: function(){
				$("#mdlAwardConfirmation").modal("hide");
			}
		})
	}

    function fncChangeActiveProposal(InquiryID, ProposalNum){
        setTimeout(function(){
            showmodal("confirm", "Are you sure you want to set this proposal as active?", "fncChangeActiveProposal2", InquiryID+"|"+ProposalNum+"|", "", null, "0");
        }, 500)
    }

    function fncChangeActiveProposal2(InquiryID, ProposalNum){
        $.ajax({
            type: 'POST',
            url: 'leasingapplication/class.php',
            data: 'InquiryID=' + InquiryID + '&ProposalNum=' + ProposalNum + '&form=fncChangeActiveProposal2',
            success: function(data){
                if(data.trim() == "1"){
                    setTimeout(function(){
                        showmodal("alert", "Proposal status successfully changed.", "fncLoadProposalList", InquiryID+"|", "", null, "0");
                    }, 500)
                }else{
                    setTimeout(function(){
                        showmodal("alert", "Failed to change proposal status.", "", "|", "", null, "1");
                    }, 500)
                }
            }
        })
    }
</script>