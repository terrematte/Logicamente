Event.observe('skolemizer', 'click', skolemizer);
Event.observe('formSkolemizer', 'submit', skolemizer);

function skolemizer() {   
	var listMenu = $('transfer').getElementsByClassName('selected');
	var node = $A(listMenu);
	if (node.size() == 1) {
		var node = node[0];
		var formula = node.id;
	} else {
		var formula = -1;
	}
	
	var cont = $('cont').innerHTML;
	
	
	formula = formula.replace(/&/,"^");
	
	
	var pars = "formula="+formula+"&action=skolemizer";
	updateWindow('area' , '/logicamente/src/controller.php', pars);
	$('area').style.display = "";
	//new Ajax.Request('/logicamente/src/controller.php',{
	  //          method: 'post', parameters: pars, onFailure: reportError             
		//         });
	/*new Insertion.Bottom('transfer', '<div id = "f'+cont+'">' + formula + '</div>');
        new Insertion.Bottom('transfer', '<button id="b'+cont +'">Delete</button>');
        Event.observe('b'+cont, 'click', del.bind(this, cont));
        Event.observe ('f'+cont, 'click', sel.bind(this, cont));
        cont++;
        $('cont').innerHTML = cont;*/
}

function del(id){
	$('f'+ id).remove();
	$('b'+ id).remove()
	var pars = "&action=delFormula&form=f"+id;
	new Ajax.Request('/logicamente/src/controller.php',{
					method: 'post', parameters: pars, onFailure: reportError			 
					 });
}

function sel(id){	
	var listMenu = $('transfer').getElementsByTagName('div');
	var node = $A(listMenu);
	
	//adiciona class
	$('f'+ id).addClassName('selected');
	//remove class das oturas
	var elmBotao = $('f'+ id);
	node.without(elmBotao).each(function(node){
		node.removeClassName('selected');
	});

	var pars = "&action=selFormula&id="+id;
	new Ajax.Request('/logicamente/src/controller.php',{
					method: 'post', parameters: pars, onFailure: reportError

		});
}
