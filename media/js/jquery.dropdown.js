$(document).ready(function() {	
		
	//Animate the LI on mouse over, mouse out
	$('#side-menu li').click(function () {	
		//Make LI clickable
		window.location = $(this).find('a').attr('href');
		
	}).mouseover(function (){
		
		//mouse over LI and look for A element for transition
		$(this).find('a')
		.animate( { paddingLeft: padLeft, paddingRight: padRight}, { queue:false, duration:500 } )
		.animate( { backgroundColor: colorOver }, { queue:false, duration:600 });

	}).mouseout(function () {
	
		//mouse oout LI and look for A element and discard the mouse over transition
		$(this).find('a')
		.animate( { paddingLeft: defpadLeft, paddingRight: defpadRight}, { queue:false, duration:500 } )
		.animate( { backgroundColor: colorOut }, { queue:false, duration:600 });
	});	
	
	//Scroll the menu on mouse move above the .menulist layer
	$('.menulist').mousemove(function(e) {

		//Sidebar Offset, Top value
		var s_top = parseInt($('.menulist').offset().top);		
		
		//Sidebar Offset, Bottom value
		var s_bottom = parseInt($('.menulist').height() + s_top);
	
		//Roughly calculate the height of the menu by multiply height of a single LI with the total of LIs
		var mheight = parseInt($('#side-menu li').height() + 50);
	
		//I used this coordinate and offset values for debuggin
		//$('#debugging_mouse_axis').html("X Axis : " + e.pageX + " | Y Axis " + e.pageY);
		//$('#debugging_status').html(Math.round(((s_top - e.pageY)/100) * mheight / 2));
			
		//Calculate the top value
		//This equation is not the perfect, but it 's very close	
		var top_value = Math.round(( (s_top - e.pageY) /100) * mheight / 2)
		
		//Animate the #side-menu by chaging the top value
		$('#side-menu').animate({top: top_value}, { queue:false, duration:1000});
	});

	
});