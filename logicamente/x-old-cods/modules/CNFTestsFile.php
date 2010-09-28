<?php

require_once("CNFConverter.class.php");

//Formulas

/*
	OBS:
	Lembre-se de inserir os nós em ordem: do 
	nó mais a esquerda ao mais á direita.
*/
$t = new WFFTranslator();

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
//  ~(~a1|~a2) 
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
// ~( ~(a1 & a2) | a3)
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
//  (a1 --> (~ ( (~a1) | (~a2) ) ) ) 
$root9 = new Node(new Connective("-->", 2, 250));
$root9L = new Node(new Atom("a1"));
$root9R = clone $root2;
array_push($root9->children, $root9L);
array_push($root9->children, $root9R);

//---------------------------------------------------------
//   ( ~a1 & ~a2 ) | ( ~a1 & ~a2 )
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

array_push($root10LR->children, $root10LRL);
array_push($root10LL->children, $root10LLL);
array_push($root10L->children, $root10LR);
array_push($root10L->children, $root10LL);
array_push($root10RL->children, $root10RLL);
array_push($root10RR->children, $root10RRL);
array_push($root10R->children, $root10RL);
array_push($root10R->children, $root10RR);
array_push($root10->children, $root10L);
array_push($root10->children, $root10R);
//---------------------------------------------------------
//  ( a1 | a1 ) | ( ~(~~a1 & ~~a2)
$root11 = new Node(new Connective("|", 2, 300));
$root11L = new Node(new Connective("|", 2, 300));
$root11LL = new Node(new Atom("a1"));
$root11LR = new Node(new Atom("a1"));
$root11R = new Node(new Connective("~", 1, 400));
$root11RL = new Node(new Connective("&", 2, 350));
$root11RLL = new Node(new Connective("~", 1, 400));
$root11RLLL = new Node(new Connective("~", 1, 400));
$root11RLLLL = new Node(new Atom("a1"));
$root11RLR = new Node(new Connective("~", 1, 400));
$root11RLRL = new Node(new Connective("~", 1, 400));
$root11RLRLL = new Node(new Atom("a2"));

array_push($root11L->children, $root11LL);
array_push($root11L->children, $root11LR);
array_push($root11RLLL->children, $root11RLLLL);
array_push($root11RLL->children, $root11RLLL);
array_push($root11RLRL->children, $root11RLRLL);
array_push($root11RLR->children, $root11RLRL);
array_push($root11RL->children, $root11RLL);
array_push($root11RL->children, $root11RLR);
array_push($root11R->children, $root11RL);
array_push($root11->children, $root11L);
array_push($root11->children, $root11R);

//---------------------------------------------------------
//  ( ( ~( ~a1 | ~a2 ) | a1 ) | ( ~(~~a1 & ~~a2)
$root12 = new Node(new Connective("|", 2, 300));
$root12L = new Node(new Connective("|", 2, 300));
$root12LL = clone $root2;
$root12LR = new Node(new Atom("a1"));
$root12R = new Node(new Connective("~", 1, 400));
$root12RL = new Node(new Connective("&", 2, 350));
$root12RLL = new Node(new Connective("~", 1, 400));
$root12RLLL = new Node(new Connective("~", 1, 400));
$root12RLLLL = new Node(new Atom("a1"));
$root12RLR = new Node(new Connective("~", 1, 400));
$root12RLRL = new Node(new Connective("~", 1, 400));
$root12RLRLL = new Node(new Atom("a2"));

array_push($root12L->children, $root12LL);
array_push($root12L->children, $root12LR);
array_push($root12RLLL->children, $root12RLLLL);
array_push($root12RLL->children, $root12RLLL);
array_push($root12RLRL->children, $root12RLRLL);
array_push($root12RLR->children, $root12RLRL);
array_push($root12RL->children, $root12RLL);
array_push($root12RL->children, $root12RLR);
array_push($root12R->children, $root12RL);
array_push($root12->children, $root12L);
array_push($root12->children, $root12R);
//---------------------------------------------------------

//  root12 | root12

$root13 = new Node(new Connective("|", 2, 300));
$root13L = clone $root12;
$root13R = clone $root12;

array_push($root13->children, $root13L);
array_push($root13->children, $root13R);
//---------------------------------------------------------
//  root12 | (root12 & a2)

$root14 = new Node(new Connective("|", 2, 300));
$root14L = clone $root12;
$root14R = new Node(new Connective("&", 2, 350));
$root14RL = clone $root12;
$root14RR = new Node(new Atom("a2"));

array_push($root14R->children, $root14RL);
array_push($root14R->children, $root14RR);
array_push($root14->children, $root14L);
array_push($root14->children, $root14R);
//---------------------------------------------------------
//  ( root6 <-> a1 ) & ( a2 -> root6 )

$root15 = new Node(new Connective("&", 2, 350));
$root15L = new Node(new Connective("<->", 2, 250));
$root15R = new Node(new Connective("-->", 2, 250));
$root15LL = clone $root6;
$root15LR = new Node(new Atom("a1"));
$root15RL = clone $root6;
$root15RR = new Node(new Atom("a2"));

array_push($root15L->children, $root15LL);
array_push($root15L->children, $root15LR);
array_push($root15R->children, $root15RL);
array_push($root15R->children, $root15RR);
array_push($root15->children, $root15L);
array_push($root15->children, $root15R);

//---------------------------------------------------------
//  ( root6 <-> a1 ) & ( a2 -> root6 )
$root15 = new Node(new Connective("&", 2, 350));
$root15L = new Node(new Connective("<->", 2, 250));
$root15R = new Node(new Connective("-->", 2, 250));
$root15LL = clone $root6;
$root15LR = new Node(new Atom("a1"));
$root15RL = clone $root6;
$root15RR = new Node(new Atom("a2"));

array_push($root15L->children, $root15LL);
array_push($root15L->children, $root15LR);
array_push($root15R->children, $root15RL);
array_push($root15R->children, $root15RR);
array_push($root15->children, $root15L);
array_push($root15->children, $root15R);

//---------------------------------------------------------
//  ( root10 & 1 )
$root16 = new Node(new Connective("&", 2, 350));
$root16L = clone $root10;
$root16R = new Node(new Atom("1"));

array_push($root16->children, $root16L);
array_push($root16->children, $root16R);
//---------------------------------------------------------
//  ( root16 | 0 )
$root17 = new Node(new Connective("|", 2, 300));
$root17L = clone $root16;
$root17R = new Node(new Atom("0"));

array_push($root17->children, $root17L);
array_push($root17->children, $root17R);
//---------------------------------------------------------
//  
$root18 = new Node(new Connective("|", 2, 300));
$root18L = clone $root16;
$root18R = new Node(new Atom("1"));

array_push($root18->children, $root18L);
array_push($root18->children, $root18R);
//---------------------------------------------------------
//  
$root19 = new Node(new Connective("|", 2, 300));
$root19L = new Node(new Atom("1"));
$root19R = clone $root18;

array_push($root19->children, $root19L);
array_push($root19->children, $root19R);

//---------------------------------------------------------
//  
$root20 = new Node(new Connective("|", 2, 300));
$root20L = clone $root2;
$root20R = new Node(new Connective("~", 1, 400));
$root20RL = clone $root2;

array_push($root20R->children, $root20RL);
array_push($root20->children, $root20L);
array_push($root20->children, $root20R);
//---------------------------------------------------------
//  
$root21 = new Node(new Connective("|", 2, 300));
$root21L = clone $root20;
$root21R = new Node(new Connective("~", 1, 400));
$root21RL = clone $root20;

array_push($root21R->children, $root21RL);
array_push($root21->children, $root21L);
array_push($root21->children, $root21R);

//---------------------------------------------------------
//  
$root22 = new Node(new Connective("&", 2, 350));
$root22L = clone $root20;
$root22R = new Node(new Connective("~", 1, 400));
$root22RL = clone $root20;

array_push($root22R->children, $root22RL);
array_push($root22->children, $root22L);
array_push($root22->children, $root22R);

//---------------------------------------------------------
//  
$root23 = new Node(new Connective("&", 2, 350));
$root23L = new Node(new Connective("&", 2, 350));
$root23R = new Node(new Connective("&", 2, 350));
$root23LL = clone $root20;
$root23LR = new Node(new Atom("0"));
$root23RL = new Node(new Atom("0"));
$root23RR = clone $root22;


array_push($root23L->children, $root23LL);
array_push($root23L->children, $root23LR);
array_push($root23R->children, $root23RL);
array_push($root23R->children, $root23RR);
array_push($root23->children, $root23L);
array_push($root23->children, $root23R);

//---------------------------------------------------------
//
$root24 = clone $root23;
$root24L = new Node(new Connective("~", 1, 400));
$root24R = new Node(new Connective("~", 1, 400));
$root24LL = new Node(new Atom("0"));
$root24RL = new Node(new Atom("1"));


array_push($root24L->children, $root24LL);
array_push($root24R->children, $root24RL);
array_push($root24->children, $root24L);
array_push($root24->children, $root24R);

//---------------------------------------------------------
//
$root25 = new Node(new Connective("~", 1, 400));
$root25L = new Node(new Connective("|", 3, 300));
$root25LL = new Node(new Atom("a1"));
$root25LC = new Node(new Atom("a2"));
$root25LR = new Node(new Atom("a3"));


array_push($root25L->children, $root25LL);
array_push($root25L->children, $root25LC);
array_push($root25L->children, $root25LR);
array_push($root25->children, $root25L);

//---------------------------------------------------------
//
$root26 = new Node(new Connective("|", 2, 300));
$root26L = new Node(new Connective("~", 1, 400));
$root26LL = new Node(new Connective("~", 1, 400));
$root26LLL = new Node(new Atom("a1"));
$root26R = new Node(new Atom("a1"));


array_push($root26LL->children, $root26LLL);
array_push($root26L->children, $root26LL);
array_push($root26->children, $root26R);
array_push($root26->children, $root26L);

//---------------------------------------------------------
//

$root27 = new Node(new Connective("~", 1, 400));
$root27L = clone $root26;


array_push($root27->children, $root27L);

//---------------------------------------------------------
/*
echo "Padroes Encontrados:<br>";
// Dupla Negacao -----------------------------------------
echo "[Dupla negacao]<br>";

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
echo "<br>";

// --------------------------------------------------------
// --Distributividade -------------------------------------
echo "[Distributividade]<br>";

echo "[formula]:".$t->showFormulaInfix($formula)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("distributivity2", $formula);
$tst->matchPattern($formula, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

echo "[root1]:".$t->showFormulaInfix($root1)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("distributivity2", $root1);
$tst->matchPattern($root1, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

echo "[root3]:".$t->showFormulaInfix($root3)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("distributivity2", $root3);
$tst->matchPattern($root3, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

echo "[root4]:".$t->showFormulaInfix($root4)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("distributivity2", $root4);
$tst->matchPattern($root4, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";
echo "[formula]:".$t->showFormulaInfix($formula)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("distributivity1", $formula);
$tst->matchPattern($formula, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

echo "[root1]:".$t->showFormulaInfix($root1)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("distributivity1", $root1);
$tst->matchPattern($root1, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

echo "[root3]:".$t->showFormulaInfix($root3)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("distributivity1", $root3);
$tst->matchPattern($root3, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

echo "[root4]:".$t->showFormulaInfix($root4)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("distributivity1", $root4);
$tst->matchPattern($root4, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

//  --------------------------------------------------------
// Absorcao ------------------------------------------------

echo "[Absorcao]<br>";

echo "[root3]:".$t->showFormulaInfix($root3)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("absorption8", $root3);
$tst->matchPattern($root3, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

echo "[root3]:".$t->showFormulaInfix($root3)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("absorption1", $root3);
$tst->matchPattern($root3, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

echo "[root4]:".$t->showFormulaInfix($root4)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("absorption4", $root4);
$tst->matchPattern($root4, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

echo "[root4]:".$t->showFormulaInfix($root4)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("absorption2", $root4);
$tst->matchPattern($root4, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

echo "[root5]:".$t->showFormulaInfix($root5)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("absorption4", $root5);
$tst->matchPattern($root5, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

echo "[root5]:".$t->showFormulaInfix($root5)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("absorption5", $root5);
$tst->matchPattern($root5, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";
*/
// ---------------------------------------------------------
// -- De Morgan --------------------------------------------
echo "[De Morgan]<br>";
echo "[root2]:".$t->showFormulaInfix($root2)."<br/>";
$tst = new PatternMatcher();
$pattern = PatternCreator::CreatePattern("deMorgan1", $root2);
$tst->matchPattern($root2, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

/*
$tst = new PatternMatcher();
echo "[root6]:".$t->showFormulaInfix($root6)."<br/>";
$pattern = PatternCreator::CreatePattern("deMorgan1", $root6);
$tst->matchPattern($root6, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

$tst = new PatternMatcher();
echo "[root12]:".$t->showFormulaInfix($root12)."<br/>";
$pattern = PatternCreator::CreatePattern("deMorgan1", $root12);
$tst->matchPattern($root12, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

$tst = new PatternMatcher();
echo "[root25]:".$t->showFormulaInfix($root25)."<br/>";
$pattern = PatternCreator::CreatePattern("deMorgan1", $root25);
$tst->matchPattern($root25, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

$tst = new PatternMatcher();
echo "[root26]:".$t->showFormulaInfix($root26)."<br/>";
$pattern = PatternCreator::CreatePattern("deMorgan1", $root26);
$tst->matchPattern($root26, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

$tst = new PatternMatcher();
echo "[root27]:".$t->showFormulaInfix($root26)."<br/>";
$pattern = PatternCreator::CreatePattern("deMorgan1", $root27);
$tst->matchPattern($root27, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";
*/
// ---------------------------------------------------------
// -- Implicacao -------------------------------------------
echo "[Implicacao]<br>";
$tst = new PatternMatcher();
echo "[root7]:".$t->showFormulaInfix($root7)."<br/>";
$pattern = PatternCreator::CreatePattern("implication", $root7);
$tst->matchPattern($root7, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

$tst = new PatternMatcher();
echo "[root9]:".$t->showFormulaInfix($root9)."<br/>";
$pattern = PatternCreator::CreatePattern("implication", $root9);
$tst->matchPattern($root9, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

$tst = new PatternMatcher();
echo "[root15]:".$t->showFormulaInfix($root15)."<br/>";
$pattern = PatternCreator::CreatePattern("implication", $root15);
$tst->matchPattern($root15, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";


// ---------------------------------------------------------
// -- BiImplicacao -------------------------------------------
echo "[BiImplicacao]<br>";
$tst = new PatternMatcher();
echo "[root8]:".$t->showFormulaInfix($root8)."<br/>";
$pattern = PatternCreator::CreatePattern("biimplication", $root8);
$tst->matchPattern($root8, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

$tst = new PatternMatcher();
echo "[root15]:".$t->showFormulaInfix($root15)."<br/>";
$pattern = PatternCreator::CreatePattern("biimplication", $root15);
$tst->matchPattern($root15, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";


// ---------------------------------------------------------
// -- Idempotencia -------------------------------------------
echo "[Idempotencia]<br>";
$tst = new PatternMatcher();
echo "[root10]:".$t->showFormulaInfix($root10)."<br/>";
$pattern = PatternCreator::CreatePattern("idempotence1", $root10);
$tst->matchPattern($root10, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

$tst = new PatternMatcher();
echo "[root11]:".$t->showFormulaInfix($root11)."<br/>";
$pattern = PatternCreator::CreatePattern("idempotence2", $root11);
$tst->matchPattern($root11, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

$tst = new PatternMatcher();
echo "[root13]:".$t->showFormulaInfix($root13)."<br/>";
$pattern = PatternCreator::CreatePattern("idempotence1", $root13);
$tst->matchPattern($root13, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

$tst = new PatternMatcher();
echo "[root13]:".$t->showFormulaInfix($root13)."<br/>";
$pattern = PatternCreator::CreatePattern("idempotence2", $root13);
$tst->matchPattern($root13, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

$tst = new PatternMatcher();
echo "[root26]:".$t->showFormulaInfix($root26)."<br/>";
$pattern = PatternCreator::CreatePattern("idempotence2", $root26);
$tst->matchPattern($root26, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

// ---------------------------------------------------------
// -- Elemento Neutro -------------------------------------------
echo "[Elemento Neutro]<br>";
$tst = new PatternMatcher();
echo "[root16]:".$t->showFormulaInfix($root13)."<br/>";
$pattern = PatternCreator::CreatePattern("neutralElement1", $root16);
$tst->matchPattern($root16, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

$tst = new PatternMatcher();
echo "[root17]:".$t->showFormulaInfix($root13)."<br/>";
$pattern = PatternCreator::CreatePattern("neutralElement3", $root17);
$tst->matchPattern($root17, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

$tst = new PatternMatcher();
echo "[root17]:".$t->showFormulaInfix($root13)."<br/>";
$pattern = PatternCreator::CreatePattern("neutralElement1", $root17);
$tst->matchPattern($root17, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

// ---------------------------------------------------------
// -- Sups -------------------------------------------
echo "[Sups]<br>";
$tst = new PatternMatcher();
echo "[root18]:".$t->showFormulaInfix($root18)."<br/>";
$pattern = PatternCreator::CreatePattern("sups1", $root18);
$tst->matchPattern($root18, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

$tst = new PatternMatcher();
echo "[root19]:".$t->showFormulaInfix($root19)."<br/>";
$pattern = PatternCreator::CreatePattern("sups2", $root19);
$tst->matchPattern($root19, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

$tst = new PatternMatcher();
echo "[root19]:".$t->showFormulaInfix($root19)."<br/>";
$pattern = PatternCreator::CreatePattern("sups1", $root19);
$tst->matchPattern($root19, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";
// ---------------------------------------------------------
// -- Infs -------------------------------------------
echo "[Infs]<br>";
$tst = new PatternMatcher();
echo "[root23]:".$t->showFormulaInfix($root23)."<br/>";
$pattern = PatternCreator::CreatePattern("infs1", $root23);
$tst->matchPattern($root23, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

$tst = new PatternMatcher();
echo "[root23]:".$t->showFormulaInfix($root23)."<br/>";
$pattern = PatternCreator::CreatePattern("infs2", $root23);
$tst->matchPattern($root23, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

// ---------------------------------------------------------
// -- Normaliza Sups e Infs -------------------------------------------

echo "[Normaliza Sups e Infs]<br>";
$tst = new PatternMatcher();
echo "[root24]:".$t->showFormulaInfix($root24)."<br/>";
$pattern = PatternCreator::CreatePattern("normalizeSupsAndInfs1", $root24);
$tst->matchPattern($root24, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

$tst = new PatternMatcher();
echo "[root24]:".$t->showFormulaInfix($root24)."<br/>";
$pattern = PatternCreator::CreatePattern("normalizeSupsAndInfs2", $root24);
$tst->matchPattern($root24, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";


// -- Tautologia -------------------------------------------
echo "[Tautologia]<br>";
$tst = new PatternMatcher();
echo "[root20]:".$t->showFormulaInfix($root20)."<br/>";
$pattern = PatternCreator::CreatePattern("tautology1", $root20);
$tst->matchPattern($root20, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

$tst = new PatternMatcher();
echo "[root21]:".$t->showFormulaInfix($root21)."<br/>";
$pattern = PatternCreator::CreatePattern("tautology2", $root21);
$tst->matchPattern($root21, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";

// ---------------------------------------------------------
// -- Antilogia -------------------------------------------
echo "[Antilogia]<br>";
$tst = new PatternMatcher();
echo "[root22]:".$t->showFormulaInfix($root22)."<br/>";
$pattern = PatternCreator::CreatePattern("antilogy1", $root22);
$tst->matchPattern($root22, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();

echo "<br>";
$tst = new PatternMatcher();
echo "[root22]:".$t->showFormulaInfix($root22)."<br/>";
 $pattern = PatternCreator::CreatePattern("antilogy2", $root22);
$tst->matchPattern($root22, $pattern);
echo "[pattern]:".$t->showFormulaInfix($pattern)."<br/>";
$tst->printMatched();
echo "<br>";
// ---------------------------------------------------------
?>
