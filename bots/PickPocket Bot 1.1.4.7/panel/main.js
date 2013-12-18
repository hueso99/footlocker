var hoverColour = "#FFF";

$(function(){
	$("a.hoverBtn").show("fast", function() {
		$(this).wrap("<div class=\"hoverBtn\">");
		$(this).attr("class", "");
	});
	
	//display the hover div
	$("div.hoverBtn").show("fast", function() {
		//append the background div
		$(this).append("<div></div>");
		
		//get link's size
		var wid = $(this).children("a").width();
		var hei = $(this).children("a").height();
		
		//set div's size
		$(this).width(wid);
		$(this).height(hei);
		$(this).children("div").width(wid);
		$(this).children("div").height(hei);
		
		//on link hover
		$(this).children("a").hover(function(){
			//store initial link colour
			if ($(this).attr("rel") == "") {
				$(this).attr("rel", $(this).css("color"));
			}
			//fade in the background
			$(this).parent().children("div")
				.stop()
				.css({"display": "none", "opacity": "1"})
				.fadeIn("fast");
			//fade the colour
			$(this)	.stop()
				.css({"color": $(this).attr("rel")})
				.animate({"color": hoverColour}, 350);
		},function(){
			//fade out the background
			$(this).parent().children("div")
				.stop()
				.fadeOut("slow");
			//fade the colour
			$(this)	.stop()
				.animate({"color": $(this).attr("rel")}, 250);
		});
	});
});
