<script type="text/javascript">
	$(function(){
		$(".fixTable").tableHeadFixer();
		$("#SubLeadsINQPageCount").val("1");
		loadtblSUbLeadsINQ();
		$("#txtSearchSubLeadsINQ").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#SubLeadsINQPageCount").val("1");
				loadtblSUbLeadsINQ(); 
			}else if ( x == '8' ){
				if($('#txtSearchSubLeadsINQ').val() == ""){
					$("#SubLeadsINQPageCount").val("1");
					loadtblSUbLeadsINQ();
				}
			}
		});
			$(function(){
				$('.btnsortdash-eventsmanpower').click(function(){
					if($(this).hasClass("fa-sort-up")){
						$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
						$("#InquirySortType").val("ASC");
						$("#InquirySortBy").val(this.id);
						loadtblSUbLeadsINQ();
					}
					else if($(this).hasClass("fa-sort-down")){
						$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
						$("#InquirySortType").val("DESC");
						$("#InquirySortBy").val(this.id);
						loadtblSUbLeadsINQ();
					}else if($(this).hasClass("fa-sort")){
						if($("#InquirySortType").val() == "ASC"){
							$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
							$("#InquirySortType").val("DESC");
							$("#InquirySortBy").val(this.id);
							loadtblSUbLeadsINQ();
						}else{
							$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
							$("#InquirySortType").val("ASC");
							$("#InquirySortBy").val(this.id);
							loadtblSUbLeadsINQ();
						}
					}
				});
			});
	})

	function loadtblSUbLeadsINQ() {
		var InquirySortBy = $('#InquirySortBy').val();
		var InquirySortType = $('#InquirySortType').val();
		var key = $("#txtSearchSubLeadsINQ").val();
		var page = $("#SubLeadsINQPageCount").val();
		$.ajax({
			type: 'POST',
			url: 'inquiry/class.php',
			data: 'key=' + key + '&page=' + page + '&InquirySortBy=' + InquirySortBy + '&InquirySortType=' + InquirySortType + '&form=loadtblSUbLeadsINQ',
			beforeSend : function() {
				$('#indexloadingscreen').addClass('myspinner');
			},
			success: function(data){
				$('#indexloadingscreen').removeClass('myspinner');
				if(data != ""){
					$("#tblSUbLeadsINQ").html(data);
				}else{
					$("#tblSUbLeadsINQ").html("<tr><td colspan='11' style='text-align: center;'>No Data Found...</td></tr>");
				}
				loadtblSUbLeadsINQEntries();
				loadtblSUbLeadsINQPagination();
			}
		});
	}

	function loadtblSUbLeadsINQEntries() {
		var key = $("#txtSearchSubLeadsINQ").val();
		var page = $("#SubLeadsINQPageCount").val();
		$.ajax({
			type: 'POST',
			url: 'inquiry/class.php',
			data: 'key=' + key + '&page=' + page + '&form=loadtblSUbLeadsINQEntries',
			success: function(data){
				$("#txtSubLeadsInqEnt").text(data);
			}
		});
	}

	function loadtblSUbLeadsINQPagination() {
	  var key = $("#txtSearchSubLeadsINQ").val();
	  var page = $("#SubLeadsINQPageCount").val();
		$.ajax({
			type: 'POST',
			url: 'inquiry/class.php',
			data: 'key=' + key + '&page=' + page + '&form=loadtblSUbLeadsINQPagination',
			success: function(data){
				$("#ulSubLeadsInqPage").html(data);
			}
		})
	}

	function SubLeadsInqPageFunc(page, pagenums) {
		$(".pgnumSubLeadsInqPageFunc").removeClass("active");
		$("#pgSubLeadsInqPageFunc" + pagenums).addClass("active");
		$("#SubLeadsINQPageCount").val(page);
		loadtblSUbLeadsINQ();
	}

	function loadLInquiryFilter(module){
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
				$("#txtSubLeadsINQStartDate").val(arr2[0]);
				$("#txtSubLeadsINQEndDate").val(arr2[1]);
				for(var i=0; i<=arr3.length-1; i++){
					$('input:checkbox[id="filter_'+arr3[i]+'"][value="'+arr3[i]+'"]').attr('checked', 'checked');
				}
				for(var i=0; i<=arr4.length-1; i++){
					$('input:checkbox[id="filter_'+arr4[i]+'"][value="'+arr4[i]+'"]').attr('checked', 'checked');
				}
			}
		})
	}

	function saveLInquiryFilter() {
		var module = "LInquiry";
		var checked = "";
		$('input:checkbox[name="form-field-SubLeadsINQ"]').each(function(){
			if($(this).is(":checked")) {
				var value = $(this).attr("value");
				checked += value + "|";
			}
		})
		var checked2 = "";
		$('input:checkbox[name="form-field-SubLeadsINQ"]').each(function(){
			var value2 = $(this).attr("value");
			checked2 += value2 + "|";
		})
		var checked3 = "";
		$('input:checkbox[name="form-field-SubLeadsINQStat"]').each(function(){
			if($(this).is(":checked")) {
				var value3 = $(this).attr("value");
				checked3 += value3 + "|";
			}
		})
		var Date1 = $("#txtSubLeadsINQStartDate").val();
		var Date2 = $("#txtSubLeadsINQEndDate").val();
		$.ajax({
			type: 'POST',
			url: 'filter/class.php',
			data: 'module=' + module + '&checked=' + checked + '&checked2=' + checked2 + '&checked3=' + checked3 + '&Date1=' + Date1 + '&Date2=' + Date2 + '&form=saveFilters',
			success: function(data){
				loadtblSUbLeadsINQ();
				$("#LINK_LInquiry_filter").click();
			}
		})
	}
</script>