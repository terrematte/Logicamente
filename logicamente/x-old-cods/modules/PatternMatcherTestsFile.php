<?php

require_once("CNFConverter.class.php");

//Formulas

/*
	OBS:
	Lembre-se de inserir os nodes em ordem, por exemplo, primeiro
	o nó esquerdo, depois o direito, etc..
*/
$t = new WFFTranslator();
$autoPsol = new AutoPatternSolutions();
//---------------------------------------------------------
//  ~~a1 | ( ~~a2 & ~( a1 | a2) )
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
$LeftChildOfThr = new Node(new Atom("a1"));
$RightChildOfThr = new Node(new Atom("a2"));

array_push($fstChildOfFst->children, $fstChildOfFstChild);
array_push($firstChild->children, $fstChildOfFst);
array_push($fstChildOfFstChildOfSec->children, $fstChildOfFstChildOfFstChildOfSec);
array_push($firstChildOfSec->children, $fstChildOfFstChildOfSec);
array_push($ChildOfThr->children, $LeftChildOfThr);
array_push($ChildOfThr->children, $RightChildOfThr);
array_push($thrFormula->children, $ChildOfThr);
array_push($secFormula->children, $firstChildOfSec);
array_push($secFormula->children, $thrFormula);
array_push($formula->children, $firstChild);
array_push($formula->children, $secFormula);

//---------------------------------------------------------
// ~ (~a1|~a2)
$root2 = new Node(new Connective("~",1,400));
$root2L = new Node(new Connective("|",2,300));
$root2LL = new Node(new Connective("~",1,400));
$root2LR = new Node(new Connective("~",1,400));
$root2LLL = new Node(new Atom("a1"));
$root2LRL = new Node(new Atom("a2"));

array_push($root2LR->children, $root2LRL);
array_push($root2LL->children, $root2LLL);
array_push($root2L->children, $root2LL);
array_push($root2L->children, $root2LR);
array_push($root2->children, $root2L);
//---------------------------------------------------------
//(~ ( (~ (a1 & a2) ) | a3) ) 
$root6 = new Node(new Connective("~",1,400));
$root6L = new Node(new Connective("|",2,300));
$root6LL = new Node(new Connective("~",1,400));
$root6LR = new Node(new Atom("a3"));
$root6LLL = new Node(new Connective("&",2,350));
$root6LLLL = new Node(new Atom("a1"));
$root6LLLR = new Node(new Atom("a2"));

array_push($root6LLL->children, $root6LLLL);
array_push($root6LLL->children, $root6LLLR);
array_push($root6LL->children, $root6LLL);
array_push($root6L->children, $root6LL);
array_push($root6L->children, $root6LR);
array_push($root6->children, $root6L);

//---------------------------------------------------------
// (a1 | (b1 & c1)) & ( a1 | ~~c1)
$root1 = new Node(new Connective("&",2,350));
$root1L = new Node(new Connective("|",2,300));
$root1LL = new Node(new Atom("a1"));
$root1LR = new Node(new Connective("&",2,350));
$root1LRL = new Node(new Atom("b1"));
$root1LRR = new Node(new Atom("c1"));
$root1R = new Node(new Connective("|",2,300));
$root1RL = new Node(new Atom("a1"));
$root1RR = new Node(new Connective("~",1,400));
$root1RRL = new Node(new Connective("~",1,400));
$root1RRLL = new Node(new Atom("c1"));

array_push($root1RRL->children, $root1RRLL);
array_push($root1RR->children , $root1RRL);
array_push($root1R->children  , $root1RL);
array_push($root1R->children  , $root1RR);
array_push($root1LR->children , $root1LRL);
array_push($root1LR->children , $root1LRR);
array_push($root1L->children  , $root1LL);
array_push($root1L->children  , $root1LR);
array_push($root1->children   , $root1L);
array_push($root1->children   , $root1R);

//print_r($root1);

//---------------------------------------------------------
//  (a1 | (a1 & a2)) | (a1 & (a1 | a2) )
$root3 = new Node(new Connective("|",2,300));
$root3L = new Node(new Connective("|",2,300));
$root3LL = new Node(new Atom("a1"));
$root3LR = new Node(new Connective("&",2,350));
$root3LRL = new Node(new Atom("a1"));
$root3LRR = new Node(new Atom("a2"));
$root3R = new Node(new Connective("&",2,350));
$root3RL = new Node(new Atom("a1"));
$root3RR = new Node(new Connective("|",2,300));
$root3RRL = new Node(new Atom("a1"));
$root3RRR = new Node(new Atom("a2"));

array_push($root3RR->children, $root3RRL);
array_push($root3RR->children, $root3RRR);
array_push($root3R->children, $root3RL);
array_push($root3R->children, $root3RR);
array_push($root3LR->children, $root3LRL);
array_push($root3LR->children, $root3LRR);
array_push($root3L->children, $root3LL);
array_push($root3L->children, $root3LR);
array_push($root3->children, $root3L);
array_push($root3->children, $root3R);

//---------------------------------------------------------
//  (a1 | (a2 & a1)) | (a1 & (a2 | a1) )
$root4 = new Node(new Connective("|",2,300));
$root4L = new Node(new Connective("|",2,300));
$root4LL = new Node(new Atom("a1"));
$root4LR = new Node(new Connective("&",2,350));
$root4LRL = new Node(new Atom("a2"));
$root4LRR = new Node(new Atom("a1"));
$root4R = new Node(new Connective("&",2,350));
$root4RL = new Node(new Atom("a1"));
$root4RR = new Node(new Connective("|",2,300));
$root4RRL = new Node(new Atom("a2"));
$root4RRR = new Node(new Atom("a1"));

array_push($root4RR->children, $root4RRL);
array_push($root4RR->children, $root4RRR);
array_push($root4R->children, $root4RL);
array_push($root4R->children, $root4RR);
array_push($root4LR->children, $root4LRL);
array_push($root4LR->children, $root4LRR);
array_push($root4L->children, $root4LL);
array_push($root4L->children, $root4LR);
array_push($root4->children, $root4L);
array_push($root4->children, $root4R);

//---------------------------------------------------------
//  (a1 | (a2 & a1)) | (a1 & (a2 | a1) )
$root5 = new Node(new Connective("|",2,300));
$root5L = new Node(new Connective("&",2,350));
$root5LL = new Node(new Connective("|",2,300));
$root5LLL = new Node(new Atom("a1"));
$root5LLR = new Node(new Atom("a2"));
$root5LR = new Node(new Atom("a1"));
$root5R = new Node(new Connective("&",2,350));
$root5RL = new Node(new Atom("a3"));
$root5RR = new Node(new Connective("&",2,350));
$root5RRL = new Node(new Connective("|",2,300));
$root5RRLL = new Node(new Atom("a1"));
$root5RRLR = new Node(new Atom("a2"));
$root5RRR = new Node(new Atom("a1"));

array_push($root5RRL->children, $root5RRLL);
array_push($root5RRL->children, $root5RRLR);
array_push($root5RR->children, $root5RRL);
array_push($root5RR->children, $root5RRR);
array_push($root5R->children, $root5RL);
array_push($root5R->children, $root5RR);
array_push($root5LL->children, $root5LLL);
array_push($root5LL->children, $root5LLR);
array_push($root5L->children, $root5LL);
array_push($root5L->children, $root5LR);
array_push($root5->children, $root5L);
array_push($root5->children, $root5R);

//---------------------------------------------------------
//  a1 --> (a2 --> (a3 & a4))
$root7 = new Node(new Connective("-->", 2, 250));
$root7L = new Node(new Atom("a1"));
$root7R = new Node(new Connective("-->", 2, 250));
$root7RL = new Node(new Atom("a2"));
$root7RR = new Node(new Connective("&",2,350));
$root7RRL = new Node(new Atom("a3"));
$root7RRR = new Node(new Atom("a4"));

array_push($root7RR->children, $root7RRL);
array_push($root7RR->children, $root7RRR);
array_push($root7R->children, $root7RL);
array_push($root7R->children, $root7RR);
array_push($root7->children, $root7L);
array_push($root7->children, $root7R);
//---------------------------------------------------------
//  a1 <-> (a2 <-> (a3 & a4))
$root8 = new Node(new Connective("<->", 2, 250));
$root8L = new Node(new Atom("a1"));
$root8R = new Node(new Connective("<->", 2, 250));
$root8RL = new Node(new Atom("a2"));
$root8RR = new Node(new Connective("&",2,350));
$root8RRL = new Node(new Atom("a3"));
$root8RRR = new Node(new Atom("a4"));

array_push($root8RR->children, $root8RRL);
array_push($root8RR->children, $root8RRR);
array_push($root8R->children, $root8RL);
array_push($root8R->children, $root8RR);
array_push($root8->children, $root8L);
array_push($root8->children, $root8R);

//---------------------------------------------------------
//  a1 --> a2
$root9 = new Node(new Connective("-->", 2, 250));
$root9L = new Node(new Atom("a1"));
$root9R = new Node(new Atom("a2"));

array_push($root9->children, $root9L);
array_push($root9->children, $root9R);

//---------------------------------------------------------
//  a1 & a1
$root10 = new Node(new Connective("|", 2, 300));
$root10L = new Node(new Connective("&", 2, 350));
$root10LL = new Node(new Connective("~", 1, 400));
$root10LLL = new Node(new Atom("a1"));
$root10LR = new Node(new Connective("~", 1, 400));
$root10LRL = new Node(new Atom("a1"));
$root10R = new Node(new Connective("&", 2, 350));
$root10RL = new Node(new Connective("~", 1, 400));
$root10RLL = new Node(new Atom("a1"));
$root10RR = new Node(new Connective("~", 1, 400));
$root10RRL = new Node(new Atom("a1"));

array_push($root10RL->children, $root10RLL);
array_push($root10RR->children, $root10RRL);
array_push($root10R->children, $root10RL);
array_push($root10R->children, $root10RR);
array_push($root10LL->children, $root10LLL);
array_push($root10LR->children, $root10LRL);
array_push($root10L->children, $root10LL);
array_push($root10L->children, $root10LR);
array_push($root10->children, $root10L);
array_push($root10->children, $root10R);
//---------------------------------------------------------
//  a1 | a1
$root11 = new Node(new Connective("|", 2, 300));
$root11L = new Node(new Atom("a1"));
$root11R = new Node(new Atom("a1"));

array_push($root11->children, $root11L);
array_push($root11->children, $root11R);

//---------------------------------------------------------
echo "Padroes Encontrados:<br>";
// Dupla Negacao -----------------------------------------
/*echo "-Dupla negacao<br>";

echo "[formula]:".$t->showFormulaInfix($formula)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("doubleNegation", $formula);
$tst->matchPattern($formula, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

echo "[root1]:".$t->showFormulaInfix($root1)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("doubleNegation", $root1);
$tst->matchPattern($root1, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

echo "[root3]:".$t->showFormulaInfix($root3)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("doubleNegation", $root3);
$tst->matchPattern($root3, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

echo "[root4]:".$t->showFormulaInfix($root4)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("doubleNegation", $root4);
$tst->matchPattern($root4, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";*/

// --------------------------------------------------------
// --Distributividade -------------------------------------
echo "-Distributividade<br>";

/*echo "[formula]:".$t->showFormulaInfix($formula)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("distributivity1", $formula);
$tst->matchPattern($formula, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
$autoPsol->autoSolveDistributivity($formula);
echo "[formula]:".$t->showFormulaInfix($formula)."<br/>";
echo "<br>";*/

/*echo "[root1]:".$t->showFormulaInfix($root1)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("distributivity2", $root1);
$tst->matchPattern($root1, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
$autoPsol->autoSolveDistributivity($root1);
echo "[root1]:".$t->showFormulaInfix($root1)."<br/>";
echo "<br>";*/

echo "[root3]:".$t->showFormulaInfix($root3)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("distributivity2", $root3);
$tst->matchPattern($root3, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
$autoPsol->autoSolveDistributivity($root3);
echo "[root3]:".$t->showFormulaInfix($root3)."<br/>";
echo "<br>";

/*echo "[root4]:".$t->showFormulaInfix($root4)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("distributivity2", $root4);
$tst->matchPattern($root4, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
$autoPsol->autoSolveDistributivity($root4);
echo "[root4]:".$t->showFormulaInfix($root4)."<br/>";
echo "<br>";*/

//  --------------------------------------------------------
// Absorcao ------------------------------------------------

/*echo "-Absorcao<br>";
echo "[root3]:".$t->showFormulaInfix($root3)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("absorption8", $root3);
$tst->matchPattern($root3, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
$autoPsol->autoSolveAbsorption($root3);
echo "[root3]:".$t->showFormulaInfix($root3)."<br/>";
echo "<br>";

echo "[root3]:".$t->showFormulaInfix($root3)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("absorption1", $root3);
$tst->matchPattern($root3, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
$autoPsol->autoSolveAbsorption($root3);
echo "[root3]:".$t->showFormulaInfix($root3)."<br/>";
echo "<br>";

echo "[root4]:".$t->showFormulaInfix($root4)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("absorption4", $root4);
$tst->matchPattern($root4, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
$autoPsol->autoSolveAbsorption($root4);
echo "[root4]:".$t->showFormulaInfix($root4)."<br/>";
echo "<br>";

echo "[root4]:".$t->showFormulaInfix($root4)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("absorption2", $root4);
$tst->matchPattern($root4, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
$autoPsol->autoSolveAbsorption($root4);
echo "[root4]:".$t->showFormulaInfix($root4)."<br/>";
echo "<br>";

echo "[root5]:".$t->showFormulaInfix($root5)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("absorption4", $root5);
$tst->matchPattern($root5, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
$autoPsol->autoSolveAbsorption($root5);
echo "[root5]:".$t->showFormulaInfix($root5)."<br/>";
echo "<br>";

echo "[root5]:".$t->showFormulaInfix($root5)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("absorption5", $root5);
$tst->matchPattern($root5, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
$autoPsol->autoSolveAbsorption($root5);
echo "[root5]:".$t->showFormulaInfix($root5)."<br/>";
echo "<br>";*/

// ---------------------------------------------------------
// -- De Morgan --------------------------------------------
/*echo "-De Morgan<br>";

echo "[root2]:".$t->showFormulaInfix($root2)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("deMorgan1", $root2);
$tst->matchPattern($root2, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
$autoPsol->autoSolveDeMorgan($root2);
echo "[root2]:".$t->showFormulaInfix($root2)."<br/>";
echo "<br>";

echo "[root6]:".$t->showFormulaInfix($root6)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("deMorgan1", $root6);
$tst->matchPattern($root6, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
$autoPsol->autoSolveDeMorgan($root6);
echo "[root6]:".$t->showFormulaInfix($root6)."<br/>";
echo "<br>";

// ---------------------------------------------------------
// -- Implicacao -------------------------------------------
echo "-Implicacao<br>";

echo "[root7]:".$t->showFormulaInfix($root7)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("implication", $root7);
$tst->matchPattern($root7, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
$autoPsol->autoSolveImplication($root7);
echo "[root7]:".$t->showFormulaInfix($root7)."<br/>";
echo "<br>";

echo "[root9]:".$t->showFormulaInfix($root9)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("implication", $root9);
$tst->matchPattern($root9, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
$autoPsol->autoSolveImplication($root9);
echo "[root9]:".$t->showFormulaInfix($root9)."<br/>";
echo "<br>";

// ---------------------------------------------------------
// -- BiImplicacao -------------------------------------------
echo "-BiImplicacao<br>";

echo "[root8]:".$t->showFormulaInfix($root8)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("biimplication", $root8);
$tst->matchPattern($root8, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
$autoPsol->autoSolveBiimplication($root8);
echo "[root8]:".$t->showFormulaInfix($root8)."<br/>";
echo "<br>";

// ---------------------------------------------------------
// -- Idempotencia -------------------------------------------
echo "-Idempotencia<br>";

echo "[root10]:".$t->showFormulaInfix($root10)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("idempotence1", $root10);
$tst->matchPattern($root10, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
$autoPsol->autoSolveIdempotence($root10);
echo "[root10]:".$t->showFormulaInfix($root10)."<br/>";
echo "<br>";

echo "[root11]:".$t->showFormulaInfix($root11)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("idempotence2", $root11);
$tst->matchPattern($root11, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
$autoPsol->autoSolveIdempotence($root11);
echo "[root11]:".$t->showFormulaInfix($root11)."<br/>";
echo "<br>";
*/

?>