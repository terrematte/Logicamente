<?php

function __autoload($class) {
	require_once($class.".class.php");
}

$t = new WFFTranslator();

$formula = new Node(new Connective("|",2,300));
$firstChild = new Node(new Connective("~",1,400));
$fstChildOfFst = new Node(new Connective("~",1,400));
$fstChildOfFstChild = new Node(new Atom("a1"));
$secFormula = new Node(new Connective("&",2,350));
$firstChildOfSec = new Node(new Connective("~",1,400));
$fstChildOfFstChildOfSec = new Node(new Connective("~",1,400));
$fstChildOfFstChildOfFstChildOfSec = new Node(new Atom("a2"));
$thrFormula = new Node(new Connective("~",1,400));
$ChildOfThr = new Node(new Connective("|",2,300));
$LeftChildOfThr = new Node(new Connective("~",1,400));
$cLeftChildOfThr = new Node(new Atom("a3"));
$RightChildOfThr = new Node(new Atom("a3"));
array_push($fstChildOfFst->children, $fstChildOfFstChild);
array_push($firstChild->children, $fstChildOfFst);
array_push($fstChildOfFstChildOfSec->children, $fstChildOfFstChildOfFstChildOfSec);
array_push($firstChildOfSec->children, $fstChildOfFstChildOfSec);
array_push($LeftChildOfThr->children, $cLeftChildOfThr);
array_push($ChildOfThr->children, $LeftChildOfThr);
array_push($ChildOfThr->children, $RightChildOfThr);
array_push($thrFormula->children, $ChildOfThr);
array_push($secFormula->children, $firstChildOfSec);
array_push($secFormula->children, $thrFormula);
array_push($formula->children, $secFormula);
array_push($formula->children, $firstChild);
/*

	$cons = array();
	array_push($cons, new Connective("~",1,400));
	array_push($cons, new Connective("&",2,350));
	array_push($cons, new Connective("|",2,300));
	array_push($cons, new Connective("-->",2,0));
	array_push($cons, new Connective("<->",2,0));
	
	$g = new WFFGenerator(5,3,$cons);
	$t = new WFFTranslator();
	$ft = $g->getFormula();
	echo ("<br>".$t->showFormulaInfix($ft->root));

*/
/*$root = new Node(new Connective("&",2,350));
$rootL = new Node(new Connective("&",2,350));
$rootLL = new Node(new Connective("&",2,350));
$rootLR = new Node(new Connective("|",2,300));
$rootR = new Node(new Connective("&",2,350));
$rootRL = new Node(new Connective("&",2,350));
$rootRLL = new Node(new Connective("~",1,400));
$rootRLR = new Node(new Connective("~",1,400));
$rootRR = new Node(new Connective("|",2,300));
$a1 = new Node(new Atom("a1"));
$a2 = new Node(new Atom("a2"));
$a3 = new Node(new Atom("a3"));
$a4 = new Node(new Atom("a4"));

array_push($rootLL->children, $a1);
array_push($rootLL->children, $a2);
array_push($rootLR->children, $a3);
array_push($rootLR->children, $a4);
array_push($rootRLL->children, $a2);
array_push($rootRLR->children, $a3);
array_push($rootRL->children, $rootRLL);
array_push($rootRL->children, $rootRLR);
array_push($rootRR->children, $a1);
array_push($rootRR->children, $a4);
array_push($rootL->children, $rootLL);
array_push($rootL->children, $rootLR);
array_push($rootR->children, $rootRL);
array_push($rootR->children, $rootRR);
array_push($root->children, $rootL);
array_push($root->children, $rootR);*/

$root1 = new Node(new Connective("<->",2,250));
$p = new Node(new Atom("p"));
$q = new Node(new Atom("q"));

array_push($root1->children, $p);
array_push($root1->children, $q);

$root2 = new Node(new Connective("~",1,400));
$root2C = new Node(new Connective("<->",2,250));
$root2CL = new Node(new Connective("|",2,300));
$root2CLL = new Node(new Connective("~",1,400));
$root2CR = new Node(new Connective("|",2,300));
$root2CRR = new Node(new Connective("~",1,400));
$p = new Node(new Atom("p"));
$q = new Node(new Atom("q"));
$r = new Node(new Atom("r"));

array_push($root2CLL->children, $p);
array_push($root2CRR->children, $q);
array_push($root2CL->children, $root2CLL);
array_push($root2CL->children, $r);
array_push($root2CR->children, $r);
array_push($root2CR->children, $root2CRR);
array_push($root2C->children, $root2CL);
array_push($root2C->children, $root2CR);
array_push($root2->children, $root2C);

//( (~r) & ( (~r) | (r | (~q) ) ) ) 
/*$root3 = new Node(new Connective("&",2,350));
$root3L = new Node(new Connective("~",1,400));
$root3R = new Node(new Connective("|",2,300));
$root3RR = new Node(new Connective("|",2,300));
$root3RL = new Node(new Connective("~",1,400));
$root3RRR = new Node(new Connective("~",1,400));
$q = new Node(new Atom("q"));
$r = new Node(new Atom("r"));

array_push($root3L->children, $r);
array_push($root3RRR->children, $q);
array_push($root3RL->children, $r);
array_push($root3RR->children, $r);
array_push($root3RR->children, $root3RRR);
array_push($root3R->children, $root3RL);
array_push($root3R->children, $root3RR);
array_push($root3->children, $root3L);
array_push($root3->children, $root3R);*/

/*echo "[root]:".$t->showFormulaInfix($root)."<br />";
echo "[formula]:".$t->showFormulaInfix($formula)."<br />";

var_dump($c->isCnf($c->normalizeConjunctions($root)));
echo "<br />[Normalized root]:".$t->showFormulaInfix($c->normalizeConjunctions($root));
echo "<br />[root]:".$t->showFormulaInfix($root)."<br />";*/

/*$tst = new PatternMatcher();
$psol = new PatternSolutions();
$autoPSol = new AutoPatternSolutions();
$pattern = PatternCreator::CreatePattern("distributivity2", $formula);
$tst->matchPattern($formula, $pattern);
$tst->printMatched();
//echo "[pattern]".$t->showFormulaInfix($pattern)."<br />";

echo "[formula]:".$t->showFormulaInfix($formula)."<br />";
if ($tst->hasMatched()) {
	$tst->oneMatched("distributivity", $pattern->getPatternType());
	$autoPSol->autoNormalizeSupsAndInfs($formula);
	echo "[FINAL]: ".$t->showFormulaInfix($formula)."<br />";
}*/

$c = new CNFConverter();
$c->autoCNFConverter($root1);
$c->autoCNFConverter($root2);
//echo "[root2]:".$t->showFormulaInfix($root2)."<br />";
$root1 = $c->normalizeConjunctions($root1);
$root2 = $c->normalizeConjunctions($root2);

for($i = 0; $i < count($root2->children); $i++) {
	$c->normalizeDisjunctions($root2->children[$i]);
}
for($i = 0; $i < count($root1->children); $i++) {
	$c->normalizeDisjunctions($root1->children[$i]);
}
echo "[root1]:".$t->showFormulaInfix($root1)."<br />";
echo "[root2]:".$t->showFormulaInfix($root2)."<br />";
$game = new ResolutionGame();
$game->addConvertedTree($root1);
$game->addConvertedTree($root2);
$game->printListOfClausulas();
$game->autoSolve();
?>