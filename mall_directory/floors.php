<script>
	$(function(){
		loadfloors();
		
		$("#floorlist").niceScroll({
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
		$("#floorlist").height(height - 200);
	}, 100);
	
	function addfloorplan()
	{
		removephoto();
		$("#addfloorplan").modal("show");
	}
	
	function loadfloors()
	{
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=loadfloors',
			beforeSend:function(){
			},
			success: function(data) {
				$("#floorlist").html(data);
			}
		}).error(function() {
			alert(data);
		});
	}
	
	function removefloor(floorid)
	{
		var arr = [];
		arr.push(floorid);
		showmodal("confirm", "Remove Map?", "removefloor2", arr, "", null, "0");
	}
	
	function removefloor2(floorid)
	{
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'floorid=' + floorid + '&form=removefloor',
			beforeSend:function(){
			},
			success: function(data) {
				var arr = data.split("|");
				if(arr[1] == "1")
				{ loadfloors(); }
				else
				{ alert(arr[1]); }
			}
		}).error(function() {
			alert(data);
		});
	}
</script>
<div class="row">
	<div class="col-sm-7"><h4 class="mini-title">Click to view floor setup</h4></div>
	<div class="col-sm-5"><button class="btn btn-info" onClick="addfloorplan();" style="margin-bottom: 10px;"><span class="fa fa-plus"></span>&nbsp;&nbsp;Add Floor Plan</button></div>
</div>
<div id="floorlist">
</div>
<script>
	$(function(){
		var _URL = window.URL || window.webkitURL;
		
		$("#txtfile").change(function (e) {
			var file, img;
			if ((file = this.files[0])){
				img = new Image();
				img.onload = function(){
					$("#imgwidth").val(this.width)
					$("#imgheight").val(this.height);
				};
				img.src = _URL.createObjectURL(file);
			}
		});
		
		$("#uploadimage").on('submit',(function(e) {
			e.preventDefault();
			$.ajax({
				url: 'uploadfile.php',
				type: 'POST',
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false,
				success: function(data) {
					var arr = data.split("|");
					if(arr[1] == "1")
					{
						loadfloors();
						$("#addfloorplan").modal("hide");
					}
					else
					{ alert(arr[1]); }
				}
			}).error(function() {
				alert(data);
			});
		}));
	});
	
	function showimg()
	{
		var oFReader = new FileReader();
		oFReader.readAsDataURL(document.getElementById("txtfile").files[0]);
		
		oFReader.onload = function (oFREvent) {
			$("#img").css("display", "block");
			$("#txtspan").css("display", "none");
			$("#txtclick").css("display", "none");
			document.getElementById("img").src = oFREvent.target.result;
		};
	}
	
	function removephoto()
	{
		$("#txtfloorid").val("");
		$("#txtfloorname").val("");
		$("#img").attr("src", "#");
		$("#img").css("display", "none");
		$("#txtspan").css("display", "block");
		$("#txtclick").css("display", "block");
		$("#txtfile").val("");
	}
</script>
<div class="modal fade fade-scale" id="addfloorplan" role="dialog">
	<div class="modal-dialog">
    	<div class="modal-content">
        	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal"><span class="fa fa-close"></span></button>
                <h4 class="modal-title">Add Floor Plan</h4>
      		</div>
            <div class="modal-body">
            	<form id="uploadimage" action="" method="post" enctype="multipart/form-data">
                	<center>
                    <input type="hidden" id="imgwidth" name="imgwidth">
                    <input type="hidden" id="imgheight" name="imgheight">
                    <input type="hidden" id="txtfloorid" name="txtfloorid">
                    <div class="row">
                    	<div class="col-sm-3"><h5>Floor Name:</h5></div>
                        <div class="col-sm-6"><input type="text" class="form-control" id="txtfloorname" name="txtfloorname"></div>
                    </div>
                    <br>
                    <label class="myupload">
                        <img class="img-responsive" src="#" id="img" style="display: none;">
                        <input type="file" name="txtfile" id="txtfile" onChange="showimg();" required="required" accept="image/*">
                        <span class="fa fa-cloud-upload" style="font-size: 80px; color: #999;" id="txtspan"></span>
                        <h1 id="txtclick">Click here to upload picture</h1>
                    </label>
                    <br>
                    <button class="btn btn-success"><span class="glyphicon glyphicon-upload"></span>&nbsp;&nbsp;Upload</button>
                    <div class="btn btn-default" onclick="removephoto();"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Remove Photo</div>
                    </center>
                </form>
			</div>
        </div>
	</div>
</div>