Event.observe('truthTable', 'click', creatTruthTable);

function creatTruthTable() {
	var listMenu = $('transfer').getElementsByClassName('selected');
	var node = $A(listMenu);
	if (node.size() == 1) {
		var node = node[0];
		var pars = 'action=creatTT&formula=' + node.id;
		updateWindow('area', '/system/src/controller.php', pars);
	} else {
		var pars = 'action=creatTT&formula=-1';
		updateWindow('area', '/system/src/controller.php', pars);
	}
	$('area').style.display = "";
}
