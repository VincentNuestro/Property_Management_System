
<script type="text/javascript">
    $(function(){
        $(".fixTable").tableHeadFixer();
        $("#txtauditpage").val("1");
        displayaudittrail();
        filterbymodule();
        loadentries();
        loadpageaudittrail();
        printtemplate();
        $("#txtaudittrail").keyup(function(e){
            var x = event.keyCode;
            if(x == 13){ 
                displayaudittrail(); 
            }else if(x == '8'){
                if($('#txtaudittrail').val() == ""){
                    displayaudittrail();
                }
            }
        });
    })

	setTimeout(function(){
        $(".date-picker").datepicker({
            autoHide: true,
            format: 'mm/dd/yyyy',
            todayHighlight: true
        })

        $('.numbers').keypress(function(event) {
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57 || event.which == 44 )) {
                event.preventDefault();
            }
        }); 

        $(".numbers").blur(function(){
            var amount = $(this).val();

            $(this).val(currency(amount)); 
        })

        checkDate();
    }, 500)

    function checkDate() {
        $("#dateTo").blur(function(){
            var dateFrom = $("#dateFrom").val().toString();
            var dateTo = $("#dateTo").val().toString();
            if(dateTo == ""){

            }else {
                if(dateTo < dateFrom){
                    showmodal("alert", "The second date must not be less than the first.", "", null, "", null, "0");
                    $("#dateTo").val("");
                    checkDate();
                }
            }
        })
    }
    
	function displayaudittrail(){
        var page = $("#txtauditpage").val();
        var txtaudittrail = $("#txtaudittrail").val();
        var filterbymodule = $("#filterbymodule").val();
		var dateFrom = $("#dateFrom5").val();
    	var dateTo = $("#dateTo5").val();
		$.ajax({
			type: 'POST',
			url: 'reports/audittrail/class.php',
			data: 'page=' + page +'&txtaudittrail=' + txtaudittrail + '&filterbymodule=' + filterbymodule + '&dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&form=displayaudittrail',
			beforeSend : function() {
                $('#indexloadingscreen').addClass('myspinner');
            },
            success: function(data){
                $('#indexloadingscreen').removeClass('myspinner');
                if(data.trim() != ""){
                    $("#displayaudittrail").html(data);
                }else{
                    $("#displayaudittrail").html("<tr><td colspan='6' style='text-align: center;'>No Data Found...</td></tr>");
                }
			    loadentries();
                loadpageaudittrail();
            }
		})
	}

	function printaudittrail(){
		var dateFrom = $("#dateFrom5").val();
		var dateTo = $("#dateTo5").val();
		$.ajax({
			type: 'POST',
			url: 'reports/audittrail/class.php',
			data: 'dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&form=printaudittrail',
			success:function(data){
                var arr = data.split("|");
				$("#displayaudittrail2").html(arr[0]);
				$("#dateFrom2").text(arr[1]);
				$("#dateTo2").text(arr[2]);

				var toprint = $("#div_form_audittrail").html();
				var myheight = $(window).height()-40;
				var mywidth = $(window).width()-40;
				var popupWin = window.open("", "_blank", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
				popupWin.document.open();
				popupWin.document.write("<html><head><title>Audit Trail</title></head><link rel='stylesheet' href='assets/font-awesome/4.5.0/css/font-awesome.min.css' /><body onload='window.print();'>" + toprint + "</body></html>");
				popupWin.document.close();
				}
			})
		}

    function filterbymodule(){
        $.ajax({
            type: 'POST',
            url: 'reports/audittrail/class.php',
            data: 'form=loaddropdowndata',
            success: function(data){
                $("#filterbymodule").html(data);
            }
        })
    }

    function loadentries(){
        var page = $("#txtauditpage").val();
        var txtaudittrail = $("#txtaudittrail").val();
        var dateFrom = $("#dateFrom5").val();
        var dateTo = $("#dateTo5").val();
        var filterbymodule = $("#filterbymodule").val();
        $.ajax({
            type: 'POST',
            url: 'reports/audittrail/class.php',
            data: 'filterbymodule=' + filterbymodule + '&page=' + page + '&dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&txtaudittrail=' + txtaudittrail + '&form=loadentries',
            success: function(data){
                    $("#txtauditrailentries").text(data);
            }
        });
    }

    function loadpageaudittrail(){
        var page = $("#txtauditpage").val();
        var txtaudittrail = $("#txtaudittrail").val();
        var dateFrom = $("#dateFrom5").val();
        var dateTo = $("#dateTo5").val();
        var filterbymodule = $("#filterbymodule").val();
        $.ajax({
            type: 'POST',
            url: 'reports/audittrail/class.php',
            data: 'filterbymodule=' + filterbymodule + '&dateFrom=' + dateFrom +  '&dateTo=' + dateTo + '&page=' + page + '&txtaudittrail=' + txtaudittrail + '&form=loadpageaudittrail',
            success: function(data){
                $("#ulpaginationaudittrail").html(data);
            }
        });
    }

    function paginationAuditTrail(page, pagenums){
        $(".pgnumaudittrail").removeClass("active");
        $("#pgaudittrail" + pagenums).addClass("active");
        $("#txtauditpage").val(page);
        displayaudittrail();
    }
    
    function printtemplate(){
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'form=getheaderprint',
            success: function(data){
                $("#template123").html(data);
            }
        })
    }
</script>