var dashboard_menu = function(){
	if(window.jQuery){
		this.init_left_menu_events();
	}else{
		console.log("ERROR: JQuery has not been loaded.");
	}
}

//Initializes events for the left most icon menu. Requries JQuery
dashboard_menu.prototype.init_left_menu_events = function(){
	$(".tribe-tab").click(function(){
		$(".tribe-tab").removeClass("selected");
		$(".tribe-tab").removeClass("before-selected");
		$(".tribe-tab").removeClass("after-selected");

		$(this).addClass("selected");
		$(this).prev().addClass("before-selected");
		$(this).next().addClass("after-selected");
	});
}