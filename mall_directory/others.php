<script>
	$(function(){
		loadothers();
		
		$(".others").niceScroll({
			cursorcolor: "#666",
			cursoropacitymax: 0.5,
			cursorwidth: "10px",
			background: "#dddddd",
			cursorborderradius: "0px",
			cursorborder: "0",
			autohidemode: false,
			cursorminheight: 30,
			horizrailenabled: false
		});
	});
	
	setInterval(function(){
		var height = $(window).height();
		$(".others").height(height - 200);
	}, 100);
	
	function loadothers()
	{
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=loadothers',
			beforeSend:function(){
			},
			success: function(data) {
				$("#otherslist").html(data);
				addotherclick();
			}
		}).error(function() {
			alert(data);
		});
	}
	
	function saveother()
	{
		var othername = $("#otherslist").find(".text").val();
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'otherid=&othername=' + othername + '&form=saveother',
			beforeSend:function(){
			},
			success: function(data) {
				var arr = data.split("|");
				if(arr[1] == "1")
				{
					$("#otherslist .last").remove();
					$("#otherslist").append("<li class='list-group-item' id='" + arr[2] + "'>" + othername + "<span class='fa fa-minus-square delete'></span><span class='fa fa-pencil-square edit'></span></li>");
					$("#otherslist").append("<li class='list-group-item last'><div class='input-group'><input type='text' class='form-control text'><span class='input-group-addon' onClick='saveother();'><span class='fa fa-plus'></span></span></div></li>");
					addotherclick();
				}
				else
				{ alert(arr[1]); }
			}
		}).error(function() {
			alert(data);
		});
	}
	
	function addotherclick()
	{
		$("#otherslist li").each(function(){
			var obj = $(this);
			obj.find(".edit").click(function(){
				editothers(obj.attr("id"), obj.find("p").text());
			});
			obj.find(".delete").click(function(){
				var arr = [];
				arr.push(obj.attr("id"));
				showmodal("confirm", "Remove this facility?", "removeother", arr, "", null, "0");
			});
		});
	}
	
	function removeother(otherid)
	{
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'otherid=' + otherid + '&form=removeother',
			beforeSend:function(){
			},
			success: function(data) {
				var arr = data.split("|");
				if(arr[1] == "1")
				{ loadothers(); }
				else
				{ alert(arr[1]); }
			}
		}).error(function() {
			alert(data);
		});
	}
	
	function editothers(otherid, othername)
	{
		$("#txtotherid2").val(otherid);
		$("#txtothername2").val(othername);
		$("#editother").modal("show");
	}
	
	function saveother()
	{
		var otherid = $("#txtotherid2").val();
		var othername = $("#txtothername2").val();
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'otherid=' + otherid + '&othername=' + othername + '&form=saveother',
			beforeSend:function(){
			},
			success: function(data) {
				var arr = data.split("|");
				if(arr[1] == "1")
				{
					$("#otherslist").find("#" + otherid).find("p").text(othername);
					$("#editother").modal("hide");
				}
				else
				{ alert(arr[1]); }
			}
		}).error(function() {
			alert(data);
		});
	}
</script>
<h4 style="margin-left: 10px;">List of Other Facilities</h4>
<div class="others">
    <ul class="list-group" id="otherslist">
        <li class="list-group-item last">
            <div class="input-group">
                <input type="text" class="form-control text" placeholder="Add new">
                <span class="input-group-addon" onClick="saveother();">
                    <span class="fa fa-plus"></span>
                </span>
            </div>
        </li>
    </ul>
</div>
<div class="modal fade fade-scale" id="editother" role="dialog">
	<div class="modal-dialog modal-sm">
    	<div class="modal-content">
        	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal"><span class="fa fa-close"></span></button>
                <h4 class="modal-title">Add Category</h4>
      		</div>
      		<div class="modal-body">
            	<input type="hidden" id="txtotherid2">
            	<input type="text" class="form-control" id="txtothername2">
      		</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onClick="saveother();">Save</button>
                <button type="button" class="btn btn-default" onClick="$('#editother').modal('hide');">Cancel</button>
      		</div>
		</div>
	</div>
</div>