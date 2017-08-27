var databinder = function(){
	var context = this;
	//Init our bind events here.
	var toggles = document.querySelectorAll("[data-toggle-element]");

	for(var i = 0;i < toggles.length;i++){
		toggles[i].addEventListener("click",function(){
			context.toggle_display(this.getAttribute("data-toggle-element"))
		});
	}
}

databinder.prototype.toggle_display = function(el){
	document.getElementById(el).classList.toggle("hide");
}