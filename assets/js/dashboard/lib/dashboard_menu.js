var dashboard_menu = function(){
	if(window.jQuery){
		this.init_left_menu_events();
		this.bind_events();
	}else{
		console.log("ERROR: JQuery has not been loaded.");
	}
}

//Initializes events for the left most icon menu. Requries JQuery
dashboard_menu.prototype.init_left_menu_events = function(){
	$(".tribe-tab").click(function(){
		$(".tribe-tab").removeClass("selected");

		$(this).addClass("selected");
	});
}

//Use data binding event attributes on different elements to display
//different content based on the buttons.
dashboard_menu.prototype.bind_events = function(){
	//Grab the submenu elements plus the content elements.
	var menu_items = document.querySelectorAll('[data-content-submenu]');

	for(var i = 0;i < menu_items.length;i++){
		menu_items[i].addEventListener("click",function(){
			var tab_content = document.getElementById(this.getAttribute("data-content-tabs"));

			for(var i = 0;i < tab_content.children.length;i++){
				if(!tab_content.children[i].classList.contains("hide")){
					tab_content.children[i].classList.add("hide");
				}
			}

			document.getElementById(this.getAttribute("data-content-submenu")).classList.remove("hide");
		});
	}
}