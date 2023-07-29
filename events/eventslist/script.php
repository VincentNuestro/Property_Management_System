<script type="text/javascript">
	$(function(){
		$(".fixTable").tableHeadFixer();
		$("#txtLAPageCount").val("1");
		tblListofevents();
		$("#txtSearchApplication").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtLAPageCount").val("1");
				tblListofevents(); 
			}else if ( x == '8' ){
				if($('#txtSearchApplication').val() == ""){
					$("#txtLAPageCount").val("1");
					tblListofevents();
				}
			}
		});
	})
		
	function tblListofevents(){
		var key = $("#txtSearchApplication").val();
		var page = $("#txtLAPageCount").val();
		$.ajax({
			type: 'POST',
			url: 'events/eventslist/class.php',
			data: 'key=' + key + '&page=' + page + '&form=tblListofevents',
			beforeSend : function() {
                $('#indexloadingscreen').addClass('myspinner');
            },
            success: function(data){
                $('#indexloadingscreen').removeClass('myspinner');
				if(data != ""){
		          	$("#tblListofevents").html(data);
		        }else{
		          	$("#tblListofevents").html("<tr><td colspan='14' style='text-align: center;'>No Data Found...</td></tr>");
		        }
		        tblListofeventsEntries();
				tblListofeventsPagination();
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

	function tblListofeventsEntries(){
	  	var key = $("#txtSearchApplication").val();
	  	var page = $("#txtLAPageCount").val();
        $.ajax({
            type: 'POST',
            url: 'events/eventslist/class.php',
            data: 'key=' + key + '&page=' + page + '&form=tblListofeventsEntries',
            success: function(data){
                $("#txtLAPageEntries").text(data);
        	}	
        })
    }

	function tblListofeventsPagination(){
	  	var key = $("#txtSearchApplication").val();
	  	var page = $("#txtLAPageCount").val();
        $.ajax({
            type: 'POST',
           	url: 'events/eventslist/class.php',
            data: 'key=' + key + '&page=' + page + '&form=tblListofeventsPagination',
            success: function(data){
                $("#ulLAPagination").html(data);
            }
        })
	}

    function tblListofeventsPageFunc(page, pagenums){
        $(".pgnumLA").removeClass("active");
        $("#pgLA" + pagenums).addClass("active");
        $("#txtLAPageCount").val(page);
        tblListofevents();
	}

	function saveapprovaleventsFilter(){
        var checked = "";
        $('input:checkbox[name="form-field-checkboxkeyword"]').each(function(){
            if($(this).is(":checked")){
                var value = $(this).attr("value");
                checked += value + "|";
            }
        });
        var searchy = $("#txtSearchApplication").val();
        var Date1 = $("#txtdiv_strtappp").val();
        var Date2 = $("#txtdiv_endappp").val();
        $.ajax({
            type: 'POST',
            url: 'events/eventslist/class.php',
            data:  'checked=' + checked +  '&Date1=' + Date1 +  '&Date2=' + Date2 + '&searchy=' + searchy + '&form=saveapprovaleventsFilter',
            success: function(data){
                $('#indexloadingscreen').removeClass('myspinner');

                if(data != ""){
                    $("#tblListofevents").html(data);
                }else{
                    $("#tblListofevents").html("<tr><td colspan='14' style='text-align: center;'>No Data Found...</td></tr>");
                }
                $("#LINK_Appliaction_filter").click();
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
   
    function fncCloseProposal(InquiryID){
    	fncLoadProposalList(InquiryID)
    	tblListofevents();
    	$("#mdlAddNewInquiry").modal("hide");
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

</script>