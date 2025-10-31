<script type="text/javascript">
	$(function(){
		showmachinenumber();
		getcookie();
	})

	setTimeout(function(){
    deletecookie();
    }, 10000)

	function showreportcontainer(){
		$("#xreadingcontainer").modal("show");
		var computerdt = $("#computerdatetime2").text();
		var alucard = $("#alucard").val();
		$.ajax({
			type: 'POST',
			url: 'zxreading/class.php',
			data: 'computerdt=' + computerdt + '&alucard=' + alucard + '&form=showxreading',
		success:function(data){
			var arr = data.split("|");
				$("#datetimedito").text(computerdt);
				$("#grosssalesdito").html(arr[0]);
				$("#dailysalesdito").html(arr[0]);
				$("#userdito").text(arr[1]);
				$("#checksales").text(arr[2]);
				$("#checkdistinct").html(arr[3]);
				$("#cashsales").text(arr[4]);
				$("#cardsales").text(arr[11]);
				$("#xcompanyname").text(arr[5]);
				$("#machinedito").text(arr[6]);
				$("#xaddress").text(arr[7]);
				$("#xtin").text(arr[8]);
				$("#machinenumberdito").html(arr[9]);
				$("#xtele").text(arr[10]);
				$("#carddistinct").html(arr[12]);
			}
		})
	}

	function printfofx(){
		
	}

	function trapzreading(){
		$.ajax({
			type: 'POST',
			url: 'zxreading/class.php',
			data: 'form=trapzreading',
		success:function(data){
			var arr = data.split("|");
				if(arr[0] == "1"){
					showmodal("alert", arr[1], "", null, "", null, "0");
				}else if(arr[0] == "2" ){
					showmodal("confirm", arr[1], "forcelogout", null, "", null, "1");
				}else{
					showreportcontainer2();
				}
			}
		})
	}

	function showreportcontainer2(){
		$("#zreadingcontainer").modal("show");
		var computerdt = $("#computerdatetime2").text();
		$.ajax({
			type: 'POST',
			url: 'zxreading/class.php',
			data: 'computerdt=' + computerdt + '&form=showzreading',
		success:function(data){
				var arr = data.split("|");
				$("#datetimedito2").text(computerdt);
				$("#xcompanyname2").text(arr[0]);
				$("#xaddress2").text(arr[1]);
				$("#xtin2").text(arr[2]);
				$("#xtele2").text(arr[3]);
				$("#grosssalesdito2").text(arr[4]);
				$("#dailysalesdito2").text(arr[4]);
				$("#cashsales2").text(arr[5]);
				$("#checksales2").text(arr[6]);
				$("#cardsales2").text(arr[7]);
				$("#carddistinct2").html(arr[8]);
				$("#checkdistinct2").html(arr[9]);
				$("#userdito2").text(arr[10]);
			}
		})
	}

	function showoption(){
		$("#zxoption").modal("show");
	}

	function showmachinenumber(){
		$.ajax({
			type: 'POST',
			url: 'zxreading/class.php',
			data: 'form=showmachinenumber',
		success:function(data){
				$("#alucard").html(data);
			}
		})
	}

	function showprintofx(){
		var alucard = $("#alucard").val();
		$.ajax({
			type: 'POST',
			url: 'zxreading/class.php',
			data: 'alucard=' + alucard + '&form=showxreading',
		success:function(data){
			var arr = data.split("|");
				$("#datetimedito3").text(computerdt);
				$("#grosssalesdito3").html(arr[0]);
				$("#dailysalesdito3").html(arr[0]);
				$("#userdito3").text(arr[1]);
				$("#checksales3").text(arr[2]);
				$("#checkdistinct3").html(arr[3]);
				$("#cashsales3").text(arr[4]);
				$("#cardsales3").text(arr[11]);
				$("#xcompanyname3").text(arr[5]);
				$("#machinedito3").text(arr[6]);
				$("#xaddress3").text(arr[7]);
				$("#xtin3").text(arr[8]);
				$("#machinenumberdito3").html(arr[9]);
				$("#xtele3").text(arr[10]);
				$("#carddistinct3").html(arr[12]);
			}
		})
		$.ajax({
			type: 'POST',
			url: 'zxreading/class.php',
			data: 'form=showprintofx',
		success:function(data){
			var toprint = $("#xreading").html();
            var myheight = $(window).height()-40;
            var mywidth = $(window).width()-40;
            var popupWin = window.open("", "_blank", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
            popupWin.document.open();
            popupWin.document.write("<html><head><title></title></head><body onload='window.print();'>" + toprint + "</body></html>");
            popupWin.document.close();
			}
		})
	}

	function showprintofz(){
		var computerdt = $("#computerdatetime2").text();
		$.ajax({
			type: 'POST',
			url: 'zxreading/class.php',
			data: 'computerdt=' + computerdt + '&form=showzreading',
		success:function(data){
				var arr = data.split("|");
				$("#datetimedito4").text(computerdt);
				$("#xcompanyname4").text(arr[0]);
				$("#xaddress4").text(arr[1]);
				$("#xtin4").text(arr[2]);
				$("#xtele4").text(arr[3]);
				$("#grosssalesdito4").text(arr[4]);
				$("#dailysalesdito4").text(arr[4]);
				$("#cashsales4").text(arr[5]);
				$("#checksales4").text(arr[6]);
				$("#cardsales4").text(arr[7]);
				$("#carddistinct4").html(arr[8]);
				$("#checkdistinct4").html(arr[9]);
				$("#userdito4").text(arr[10]);
			}
		})
		$.ajax({
			type: 'POST',
			url: 'zxreading/class.php',
			data: 'computerdt=' + computerdt + '&form=showprintofz',
		success:function(data){
			var toprint = $("#zreading").html();
            var myheight = $(window).height()-40;
            var mywidth = $(window).width()-40;
            var popupWin = window.open("", "_blank", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
            popupWin.document.open();
            popupWin.document.write("<html><head><title></title></head><body onload='window.print();'><div class='checklist'>" + toprint + "</div></body></html>");
            popupWin.document.close();
			}
		})
	}

	function getcookie(){
		$.ajax({
			type: 'POST',
			url: 'zxreading/class.php',
			data: 'form=getcookie',
		success:function(data){
				$("#cookienginamo").val(data);
			}
		})
	}

	function forcelogout(){
		$.ajax({
			type: 'POST',
			url: 'zxreading/class.php',
			data: 'form=forcelogout',
		success:function(data){
			showmodal("alert", "All user has been disconnected.", "showreportcontainer2", null, "", null, "0");
			}
		})
		$.ajax({
			type: 'POST',
			url: 'zxreading/class.php',
			data: 'form=selectbasehan',
		success:function(data2){
				$("#cookiengamamo").val();
			}
		})
	}

	function deletecookie(){
		var icookie = $("#cookienginamo").val();
		var tcookie = $("#cookiengamamo").val();
		$.ajax({
			type: 'POST',
			url: 'zxreading/class.php',
			data: 'form=deletecookie',
		success:function(data){
				if(data == "1"){
					if(tcookie != ""){
						if(icookie != tcookie){
							window.location = "logout.php";
						}
					}else{

					}
				}
			}
		})
	}
</script>