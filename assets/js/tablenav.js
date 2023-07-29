/* Plugins */
(function ( $ ){
	$.fn.tablenav = function(type, tableid, contid, myobj) {
		var totscroll = 0;
		var num = 0;
		var num2 = 1;
		var obj = $("#" + tableid);
		
		obj.find("tr").removeClass("highlighted");
		obj.find("tr").removeClass("activated");
		
		if(obj.find(".activated").length == 0)
		{ num = 0; }
		else
		{ num = obj.find(".activated").index(); }
		
		if(type == "add")
		{	
			$(document).keydown(function(e){
				var x = e.keyCode;
				var tot = obj.find("tr").length-1;
				if(x == 38)
				{
					if(num == 0)
					{ num = 0; }
					else
					{ num--; }
					obj.find("tr").removeClass("highlighted");
					if(!obj.find("tr").eq(num).hasClass("activated"))
					{ obj.find("tr").eq(num).addClass("highlighted"); }
					totscroll -= obj.find("tr").eq(num).height();
				}
				else if(x == 40)
				{
					if(num == tot)
					{ num = tot; }
					else
					{ num++; }
					obj.find("tr").removeClass("highlighted");
					if(!obj.find("tr").eq(num).hasClass("activated"))
					{ obj.find("tr").eq(num).addClass("highlighted"); }
					totscroll += obj.find("tr").eq(num).height();
				}
				else if(x == 13)
				{
					obj.find("tr").removeClass("highlighted");
					obj.find("tr").removeClass("activated");
					obj.find("tr").eq(num).addClass("activated");
					if(obj.find("tr").eq(num)[0].hasAttribute("onclick"))
					{ obj.find("tr").eq(num).trigger("click"); }
					else
					{ obj.find("tr").eq(num).find("td").eq(1).trigger("click"); }
				}
				e.preventDefault();
				e.stopPropagation();
				var totscroll2 = $("#" + contid).height() * num2;
				var totscroll3 = $("#" + contid).height() * (num2-1);
				if(totscroll > totscroll2)
				{
					num2++;
					$("#" + contid).scrollTop(totscroll2);
				}
				else if(totscroll < totscroll3)
				{ $("#" + contid).scrollTop(totscroll3); }
				else if(totscroll > totscroll3)
				{
					num2--;
					$("#" + contid).scrollTop(totscroll3);
				}
			});
		}
		else
		{ $(document).unbind("keydown"); }
	};
}( jQuery ));