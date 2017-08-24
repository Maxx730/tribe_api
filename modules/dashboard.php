<div id = 'tribe-panel-contain'>
	<ul id = 'tribe-panel'>
		<li class = 'tribe-tab'>
			
		</li>
		<li class = 'tribe-tab icon-menu-left selected' data-content-tabs = "tribe-panel-submenu" data-content-submenu = "tribe-dashboard-menu">
			<i class = 'icon-uniE00A'></i>
		</li>
		<li class = 'tribe-tab icon-menu-left after-selected' data-content-tabs = "tribe-panel-submenu" data-content-submenu = "firepit-chat">
			<i class = 'icon-uniE03A'></i>
		</li>
		<li class = 'tribe-tab icon-menu-left'>
			<i class = 'icon-uniE035'></i>
		</li>
	</ul>
	<div id = 'logout-tab' class = 'tribe-tab'>
		<a href = "/tribe/?logout=true">
			<i class = 'icon-uniE003'></i>
		</a>
	</div>
</div>
<div id = 'tribe-panel-submenu'>
	<div id = "tribe-dashboard-menu" class = "sub-menu-content">
		<h1 class = 'ubuntu-font'>Dashboard</h1>
	</div>
	<div id = "firepit-chat" class = "sub-menu-content hide">
		<h1 class = 'ubuntu-font'>Firepit</h1>
	</div>
	<div class = "sub-menu-content hide">
		<h1 class = 'ubuntu-font'>Submenu Title</h1>
	</div>
</div>
<div id = 'tribe-dashboard'>
	<h1 class = 'ubuntu-font'>Firepit</h1>
	<div id = 'firepit-frame'>
		<iframe src = 'http://localhost/tribe/?tribe_data={%22action%22:%22get%22,%22credentials%22:{%22username%22:%22maxx730%22,%22password%22:%22remote12%22},%22object%22:%22tribe%22,%22tribe%22:{%22id%22:2,%22Title%22:%22My%20first%20tribe%22}}' id = '' class = ''/>
	</div>
</div>