<script>
	$(function(){
		loadcategories();
		$(".colorpicker .color").each(function(){
			var obj = $(this);
			obj.click(function(){
				$(".colorpicker .color").removeClass("active");
				obj.addClass("active");
				$("#txtcolor").val(obj.css("background-color"));
			});
		});
		
		$("#categorylist").niceScroll({
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
		$("#categorylist").height(height - 200);
	}, 100);
	
	function loadcategories()
	{
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=loadcategories',
			beforeSend:function(){
			},
			success: function(data) {
				$("#categorylist").html(data);
				addcategoryclick();
			}
		})
	}
	
	function addcategoryclick()
	{
		$(".category").each(function(){
			var obj = $(this);
			obj.find(".shops .add").unbind("click");
			obj.find(".shops .add").click(function(){
				var categoryid = obj.find(".category-body").attr("id");
				var shopname = obj.find(".text").val();
				saveshop(obj, categoryid, shopname);
			});
			obj.find(".heading").click(function(){
				$(this).children(".edit").toggle();
				$(this).children(".remove").toggle();
			});
			obj.find(".heading .edit").click(function(e){
				e.stopPropagation();
				e.preventDefault();
				editcategory(obj.find(".category-body").attr("id"));
			});
			obj.find(".heading .remove").click(function(e){
				e.stopPropagation();
				e.preventDefault();
				var categoryid = obj.find(".category-body").attr("id");
				var arr = [];
				arr.push(categoryid);
				showmodal("confirm", "Remove Category?", "removecategory", arr, "", null, "0");
			});
			obj.find(".shops li").each(function(){
				var obj2 = $(this);
				obj2.find(".edit").click(function(){
					$("#txtcategoryid2").val(obj.find(".category-body").attr("id"));
					$("#txtshopid2").val(obj2.attr("id"));
					$("#txtshopname2").val(obj2.find("p").text());
					$("#editshop").modal("show");
				});
				obj2.find(".delete").click(function(){
					var shopid = obj2.attr("id");
					var arr = [];
					arr.push(shopid);
					showmodal("confirm", "Remove Shop?", "removeshop", arr, "", null, "0");
				});
			});
		});
	}
	
	function removecategory(categoryid)
	{
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'categoryid=' + categoryid + '&form=removecategory',
			beforeSend:function(){
			},
			success: function(data) {
				var arr = data.split("|");
				if(arr[1] == "1")
				{
					$(".category").each(function(){
						var obj = $(this);
						if(obj.find(".category-body").attr("id") == categoryid)
						{ obj.remove(); }
					});
					loadcategories();
				}
				else
				{ alert(arr[1]); }
			}
		})
	}
	
	function editcategory(categoryid)
	{
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'categoryid=' + categoryid + '&form=editcategory',
			beforeSend:function(){
			},
			success: function(data) {
				var arr = data.split("|");
				$("#txtcategoryid").val(categoryid);
				$("#txtcategoryname").val(arr[1]);
				$("#txtcolor").val(arr[2]);
				$(".color").removeClass("active");
				$(".color").each(function(){
					var obj = $(this);
					if(obj.css("background-color") == arr[2])
					{ obj.addClass("active"); }
				});
				$("#category-title").text("Edit Category");
				$("#addcategory").modal("show");
			}
		})
	}
	
	function saveshop(obj, categoryid, shopname)
	{
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'categoryid=' + categoryid + '&shopid=&shopname=' + shopname + '&form=saveshop',
			beforeSend:function(){
			},
			success: function(data) {
				var arr = data.split("|");
				if(arr[1] == "1")
				{
					obj.find(".shops .last").remove();
					obj.find(".shops").append("<li class='list-group-item' id='" + arr[2] + "'>" + shopname + "<span class='fa fa-minus-square delete'></span><span class='fa fa-pencil-square edit'></span></li>");
					obj.find(".shops").append("<li class='list-group-item last'><div class='input-group'><input type='text' class='form-control text'><span class='input-group-addon add'><span class='fa fa-plus'></span></span></div></li>");
					addcategoryclick();
				}
				else
				{ alert(arr[1]); }
			}
		})
	}
	
	function addcategory()
	{
		$("#addcategory input").val("");
		$("#category-title").text("Add Category");
		$("#addcategory").modal("show");
	}
</script>
<div class="row">
	<div class="col-sm-7"><h4 class="mini-title">Click to view list of shops</h4></div>
	<div class="col-sm-5"><button class="btn btn-info" onClick="addcategory();" style="margin-bottom: 10px;"><span class="fa fa-plus"></span>&nbsp;&nbsp;Add Category</button></div>
</div>
<div class="categories">
    <div class="panel-group" id="category" role="tablist" aria-multiselectable="true">
    	<div id="categorylist">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#category" href="#category1" aria-expanded="true" aria-controls="category1"></a>
                </h4>
            </div>
            <div id="category1" class="panel-collapse collapse in" role="tabpanel">
                <div class="panel-body">
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<script>
	function savecategory()
	{
		var categoryid = $("#txtcategoryid").val();
		var categoryname = $("#txtcategoryname").val();
		var color = $("#txtcolor").val().replace(")", ", 1)").replace("rgb", "rgba");
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'categoryid=' + categoryid + '&categoryname=' + categoryname + '&color=' + color + '&form=savecategory',
			beforeSend:function(){
			},
			success: function(data) {
				var arr = data.split("|");
				if(arr[1] == "1")
				{
					$("#categorylist").append("<div class='panel panel-default'><div class='panel-heading' role='tab'><h4 class='panel-title'><a role='button' data-toggle='collapse' data-parent='#category' href='#" + arr[2] + "' aria-expanded='true' aria-controls='" + arr[2] + "'>" + categoryname + "</a></h4></div><div id='" + arr[2] + "' class='panel-collapse collapse' role='tabpanel'><div class='panel-body'></div></div></div>");
					$("#addcategory").modal("hide");
				}
				else
				{ alert(arr[1]); }
			}
		})
	}
</script>
<div class="modal fade fade-scale" id="addcategory" role="dialog">
	<div class="modal-dialog modal-sm">
    	<div class="modal-content">
        	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal"><span class="fa fa-close"></span></button>
                <h4 class="modal-title" id="category-title">Add Category</h4>
      		</div>
      		<div class="modal-body">
            	<input type="hidden" id="txtcategoryid">
            	<p>Input Category</p>
                <input type="text" class="form-control" id="txtcategoryname">
                <br>
                <p>Select Color</p>
                <input type="text" class="form-control" id="txtcolor">
                <div class="colorpicker">
                	<div class="row">
                        <div class="col-sm-2 color" style="background: rgba(0, 160, 177, 1);"></div>
                        <div class="col-sm-2 color" style="background: rgba(46, 141, 239, 1);"></div>
                        <div class="col-sm-2 color" style="background: rgba(167, 0, 174, 1);"></div>
                        <div class="col-sm-2 color" style="background: rgba(100, 62, 191, 1);"></div>
                        <div class="col-sm-2 color" style="background: rgba(191, 30, 75, 1);"></div>
                        <div class="col-sm-2 color" style="background: rgba(220, 87, 46, 1);"></div>
                    </div>
                	<div class="row">
                        <div class="col-sm-2 color" style="background: rgba(0, 166, 0, 1);"></div>
                        <div class="col-sm-2 color" style="background: rgba(10, 91, 196, 1);"></div>
                        <div class="col-sm-2 color" style="background: rgba(51, 51, 51, 1);"></div>
                        <div class="col-sm-2 color" style="background: rgba(0, 0, 0, 1);"></div>
                        <div class="col-sm-2 color" style="background: rgba(76, 44, 102, 1);"></div>
                        <div class="col-sm-2 color" style="background: rgba(25, 153, 0, 1);"></div>
                    </div>
                </div>
      		</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onClick="savecategory();">Save</button>
      		</div>
		</div>
	</div>
</div>
<script>
	function saveshop2()
	{
		var categoryid = $("#txtcategoryid2").val();
		var shopid = $("#txtshopid2").val();
		var shopname = $("#txtshopname2").val();
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'shopid=' + shopid + '&shopname=' + shopname + '&form=saveshop',
			beforeSend:function(){
			},
			success: function(data) {
				var arr = data.split("|");
				if(arr[1] == "1")
				{
					$("#" + categoryid).find("#" + shopid).find("p").text(shopname);
					$("#editshop").modal("hide");
				}
				else
				{ alert(arr[1]); }
			}
		})
	}
</script>
<div class="modal fade fade-scale" id="editshop" role="dialog">
	<div class="modal-dialog modal-sm">
    	<div class="modal-content">
        	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal"><span class="fa fa-close"></span></button>
                <h4 class="modal-title">Edit Shop</h4>
      		</div>
      		<div class="modal-body">
            	<input type="hidden" id="txtcategoryid2">
            	<input type="hidden" id="txtshopid2">
            	<input type="text" class="form-control" id="txtshopname2">
      		</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onClick="saveshop2();">Save</button>
                <button type="button" class="btn btn-default" onClick="$('#editshop').modal('hide');">Cancel</button>
      		</div>
		</div>
	</div>
</div>