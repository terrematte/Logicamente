Event.observe('Teste', 'click', teste);

function teste() {
	var listMenu = $('transfer').getElementsByClassName('selected');
	var node = $A(listMenu);
	
	if (node.size() == 1) {
		var node = node[0];
		var pars = 'action=test&form=' + node.id;
		updateWindow('area', '/logicamente/src/controller.php', pars);
	} else {
		var pars = 'action=test&form=-1';
		updateWindow('area', '/logicamente/src/controller.php', pars);
	}
}
