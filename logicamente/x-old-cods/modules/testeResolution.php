<?php

function __autoload($class) {
	require_once($class.".class.php");
}

$game = new ResolutionGame();
//TESTE 0

/*$clau1 = new Node(new Connective("|",2,300));
$lit11 = new Node(new Atom("a1"));
$lit12 = new Node(new Atom("a2"));
$lit13 = new Node(new Connective("~",1,400));
$lit13Atom = new Node(new Atom("a3"));
array_push($lit13->children, $lit13Atom);
array_push($clau1->children, $lit11);
array_push($clau1->children, $lit12);
array_push($clau1->children, $lit13);
$game->addClausula($clau1);

$clau2 = new Node(new Connective("|",2,300));
$lit21 = new Node(new Atom("a1"));
$lit22 = new Node(new Connective("~",1,400));
$lit22Atom = new Node(new Atom("a2"));
array_push($lit22->children, $lit22Atom);
array_push($clau2->children, $lit21);
array_push($clau2->children, $lit22);
$game->addClausula($clau2);

$clau3 = new Node(new Connective("|",2,300));
$lit31 = new Node(new Connective("~",1,400));
$lit31Atom = new Node(new Atom("a1"));
array_push($lit31->children, $lit31Atom);
array_push($clau3->children, $lit31);
$game->addClausula($clau3);

$clau4 = new Node(new Connective("|",2,300));
$lit41 = new Node(new Atom("a3")); 
array_push($clau4->children, $lit41);
$game->addClausula($clau4);*/

//TESTE 1

/*$clau5 = new Node(new Connective("|",2,300));
$lit51 = new Node(new Atom("a1"));
$lit52 = new Node(new Atom("a3"));
array_push($clau5->children, $lit51);
array_push($clau5->children, $lit52);
$game->addClausula($clau5);

$clau6 = new Node(new Connective("|",2,300));
$lit63 = new Node(new Connective("~",1,400));
$lit63Atom = new Node(new Atom("a2"));
$lit62 = new Node(new Atom("a3"));
array_push($lit63->children, $lit63Atom);
array_push($clau6->children, $lit63);
array_push($clau6->children, $lit62);
$game->addClausula($clau6);

$clau7 = new Node(new Connective("|",2,300));
$lit73 = new Node(new Connective("~",1,400));
$lit73Atom = new Node(new Atom("a1"));
$lit72 = new Node(new Atom("a2"));
array_push($lit73->children, $lit73Atom);
array_push($clau7->children, $lit73);
array_push($clau7->children, $lit72);
$game->addClausula($clau7);

$clau8 = new Node(new Connective("|",2,300));
$lit81 = new Node(new Atom("a1")); 
array_push($clau8->children, $lit81);
$game->addClausula($clau8);

$clau9 = new Node(new Connective("|",2,300));
$lit91 = new Node(new Connective("~",1,400));
$lit91Atom = new Node(new Atom("a3"));
array_push($lit91->children, $lit91Atom);
array_push($clau9->children, $lit91);
$game->addClausula($clau9);*/

//TESTE 2
/*
$clau5 = new Node(new Connective("|",2,300));
$lit51 = new Node(new Atom("a1"));
$lit52 = new Node(new Atom("a2"));
$lit53 = new Node(new Atom("a3"));
array_push($clau5->children, $lit51);
array_push($clau5->children, $lit52);
array_push($clau5->children, $lit53);
$game->addClausula($clau5);

$clau6 = new Node(new Connective("|",2,300));
$lit63 = new Node(new Connective("~",1,400));
$lit63Atom = new Node(new Atom("a3"));
$lit62 = new Node(new Atom("a4"));
array_push($lit63->children, $lit63Atom);
array_push($clau6->children, $lit63);
array_push($clau6->children, $lit62);
$game->addClausula($clau6);

$clau7 = new Node(new Connective("|",2,700));
$lit71 = new Node(new Connective("~",1,400));
$lit71Atom = new Node(new Atom("a1"));
array_push($lit71->children, $lit71Atom);
array_push($clau7->children, $lit71);
$game->addClausula($clau7);

$clau8 = new Node(new Connective("|",2,300));
$lit83 = new Node(new Connective("~",1,400));
$lit83Atom = new Node(new Atom("a2"));
$lit82 = new Node(new Atom("a3"));
array_push($lit83->children, $lit83Atom);
array_push($clau8->children, $lit83);
array_push($clau8->children, $lit82);
$game->addClausula($clau8);

$clau10 = new Node(new Connective("|",2,300));
$lit101 = new Node(new Connective("~",1,400));
$lit101Atom = new Node(new Atom("a3"));
array_push($lit101->children, $lit101Atom);
array_push($clau10->children, $lit101);
$game->addClausula($clau10);

$clau11 = new Node(new Connective("|",2,1100));
$lit111 = new Node(new Connective("~",1,400));
$lit111Atom = new Node(new Atom("a4"));
array_push($lit111->children, $lit111Atom);
array_push($clau11->children, $lit111);
$game->addClausula($clau11);*/

//TESTE 3
$clau5 = new Node(new Connective("|",2,300));
$lit53 = new Node(new Connective("~",1,400));
$lit53Atom = new Node(new Atom("a1"));
$lit52 = new Node(new Atom("a2"));
array_push($lit53->children, $lit53Atom);
array_push($clau5->children, $lit53);
array_push($clau5->children, $lit52);
$game->addClausula($clau5);

$clau6 = new Node(new Connective("|",2,300));
$lit63 = new Node(new Connective("~",1,400));
$lit63Atom = new Node(new Atom("a2"));
$lit62 = new Node(new Atom("a3"));
array_push($lit63->children, $lit63Atom);
array_push($clau6->children, $lit63);
array_push($clau6->children, $lit62);
$game->addClausula($clau6);

$clau7 = new Node(new Connective("|",2,300));
$lit73 = new Node(new Connective("~",1,400));
$lit73Atom = new Node(new Atom("a3"));
$lit72 = new Node(new Atom("a1"));
$lit71 = new Node(new Atom("a4"));
array_push($lit73->children, $lit73Atom);
array_push($clau7->children, $lit73);
array_push($clau7->children, $lit72);
array_push($clau7->children, $lit71);
$game->addClausula($clau7);

$clau8 = new Node(new Connective("|",2,300));
$lit81 = new Node(new Connective("~",1,400));
$lit81Atom = new Node(new Atom("a4"));
array_push($lit81->children, $lit81Atom);
array_push($clau8->children, $lit81);
$game->addClausula($clau8);

$clau9 = new Node(new Connective("|",2,300));
$lit91 = new Node(new Atom("a2"));
array_push($clau9->children, $lit91);
$game->addClausula($clau9);

$clau10 = new Node(new Connective("|",2,300));
$lit101 = new Node(new Connective("~",1,400));
$lit101Atom = new Node(new Atom("a3"));
array_push($lit101->children, $lit101Atom);
array_push($clau10->children, $lit101);
//$game->addClausula($clau10);
/*
//~p v r v p
$clau5 = new Node(new Connective("|",2,300));
$lit53 = new Node(new Connective("~",1,400));
$lit53Atom = new Node(new Atom("p"));
$lit52 = new Node(new Atom("r"));
$lit51 = new Node(new Atom("p"));
array_push($lit53->children, $lit53Atom);
array_push($clau5->children, $lit53);
array_push($clau5->children, $lit52);
array_push($clau5->children, $lit51);
//$game->addClausula($clau5);

//~r v p
$clau6 = new Node(new Connective("|",2,300));
$lit63 = new Node(new Connective("~",1,400));
$lit63Atom = new Node(new Atom("r"));
$lit62 = new Node(new Atom("p"));
array_push($lit63->children, $lit63Atom);
array_push($clau6->children, $lit63);
array_push($clau6->children, $lit62);
$game->addClausula($clau6);

//q v p
$clau7 = new Node(new Connective("|",2,300));
$lit73 = new Node(new Atom("q"));
$lit72 = new Node(new Atom("p"));
array_push($clau7->children, $lit73);
array_push($clau7->children, $lit72);
$game->addClausula($clau7);

//~r
$clau8 = new Node(new Connective("|",2,300));
$lit81 = new Node(new Connective("~",1,400));
$lit81Atom = new Node(new Atom("r"));
array_push($lit81->children, $lit81Atom);
array_push($clau8->children, $lit81);
$game->addClausula($clau8);

//~p v r v r v ~q
$clau9 = new Node(new Connective("|",2,300));
$lit93 = new Node(new Connective("~",1,400));
$lit93Atom = new Node(new Atom("p"));
$lit92 = new Node(new Atom("r"));
$lit91 = new Node(new Atom("r"));
$lit94 = new Node(new Connective("~",1,400));
$lit94Atom = new Node(new Atom("q"));
array_push($lit93->children, $lit93Atom);
array_push($lit94->children, $lit94Atom);
array_push($clau9->children, $lit94);
array_push($clau9->children, $lit93);
array_push($clau9->children, $lit92);
array_push($clau9->children, $lit91);
$game->addClausula($clau9);

//~r v r v ~q
$clau10 = new Node(new Connective("|",2,300));
$lit103 = new Node(new Connective("~",1,400));
$lit103Atom = new Node(new Atom("r"));
$lit102 = new Node(new Atom("r"));
$lit104 = new Node(new Connective("~",1,400));
$lit104Atom = new Node(new Atom("q"));
array_push($lit103->children, $lit103Atom);
array_push($lit104->children, $lit104Atom);
array_push($clau10->children, $lit104);
array_push($clau10->children, $lit103);
array_push($clau10->children, $lit102);
//$game->addClausula($clau10);

//q v r v ~q
$clau11 = new Node(new Connective("|",2,300));
$lit113 = new Node(new Connective("~",1,400));
$lit113Atom = new Node(new Atom("q"));
$lit112 = new Node(new Atom("r"));
$lit111 = new Node(new Atom("q"));
array_push($lit113->children, $lit113Atom);
array_push($clau11->children, $lit113);
array_push($clau11->children, $lit112);
array_push($clau11->children, $lit111);
//$game->addClausula($clau11);

//~p v q
$clau12 = new Node(new Connective("|",2,300));
$lit123 = new Node(new Connective("~",1,400));
$lit123Atom = new Node(new Atom("p"));
$lit122 = new Node(new Atom("q"));
array_push($lit123->children, $lit123Atom);
array_push($clau12->children, $lit123);
array_push($clau12->children, $lit122);
$game->addClausula($clau12);

//~q v p
$clau13 = new Node(new Connective("|",2,300));
$lit133 = new Node(new Connective("~",1,400));
$lit133Atom = new Node(new Atom("q"));
$lit132 = new Node(new Atom("p"));
array_push($lit133->children, $lit133Atom);
array_push($clau13->children, $lit133);
array_push($clau13->children, $lit132);
$game->addClausula($clau13);*/

echo "<b>Running autoSolve test...</b><br />";
$game->printListOfClausulas();
echo "<br />";
$game->autoSolve();
echo  "<br /><b>autoSolve test finished.</b><br /><br /><b>Running solve test...</b><br />";
/*$game->printListOfClausulas();
$game->solve($game->getClausula(1), $game->getClausula(4));
$game->printListOfClausulas();
$game->solve($game->getClausula(6), $game->getClausula(5));*/
echo "<br /><b>solve test finished.</b>"
?>
