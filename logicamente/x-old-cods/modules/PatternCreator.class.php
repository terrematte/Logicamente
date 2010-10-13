<?php
/**
 * Classe que gera a arvore de um padrao
 *
 */
class PatternCreator {
	
	/**
	 * Construtor
	 */
	public function PatternCreator() {}
	/**
	 * Cria um padrao
	 *
	 * @param $patternType Tipo do padrão
	 * @param Node $treeRoot Variável de referencia a raiz da árvore onde possa haver um padrão
	 * @return Pattern Uma arvore com o tipo de padrão desejado.
	 */
	public static function CreatePattern($patternType, $treeRoot) {
		switch ($patternType) {
			//dupla negacao: (~~X)
			case "doubleNegation": 
				$root = new Pattern(new Connective("~",1,400), $patternType, null);
				$root->setPatternRoot($root);
				$child =  new Pattern(new Connective("~",1,400), $patternType, $root);
				$grandSon = new Pattern(new Atom("X"), $patternType, $root);
				$grandSon->setEndOfPattern(true);				
				$grandSon->setTreeRoot($treeRoot);
				
				array_push($child->children, $grandSon);
				array_push($root->children, $child);
				return $root;
			//distributividade1: (X | (Y & Z))
			case "distributivity1": 
				$root = new Pattern(new Connective("|",2,300), $patternType, null);
				$root->setPatternRoot($root);
				$rootLeft = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight = new Pattern(new Connective("&",2,350), $patternType, $root);
				$rootRightLeft = new Pattern(new Atom("Y"), $patternType, $root);
				$rootRightRight = new Pattern(new Atom("Z"),$patternType, $root);
				$rootRightRight->setEndOfPattern(true);
				$rootRightRight->setTreeRoot($treeRoot);

				array_push($rootRight->children, $rootRightLeft);
				array_push($rootRight->children, $rootRightRight);
				array_push($root->children, $rootLeft);
				array_push($root->children, $rootRight);
				return $root;
			//distributividade2: ((Y & Z) | X)
			case "distributivity2":
				$root = new Pattern(new Connective("|",2,300), $patternType, null);
				$root->setPatternRoot($root);
				$rootLeft = new Pattern(new Connective("&",2,350), $patternType, $root);
				$rootLeftLeft = new Pattern(new Atom("Y"), $patternType, $root);
				$rootLeftRight = new Pattern(new Atom("Z"),$patternType, $root);
				$rootRight = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight->setEndOfPattern(true);
				$rootRight->setTreeRoot($treeRoot);

				array_push($rootLeft->children, $rootLeftLeft);
				array_push($rootLeft->children, $rootLeftRight);
				array_push($root->children, $rootLeft);
				array_push($root->children, $rootRight);
				return $root;	
			//distributividade3: (X & (Y | Z))
			/*case "distributivity3":
				$root = new Pattern(new Connective("&",2,350), $patternType, null);
				$root->setPatternRoot($root);
				$rootLeft = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight = new Pattern(new Connective("|",2,300), $patternType, $root);
				$rootRightLeft = new Pattern(new Atom("Y"), $patternType, $root);
				$rootRightRight = new Pattern(new Atom("Z"),$patternType, $root);
				$rootRightRight->setEndOfPattern(true);
				$rootRightRight->setTreeRoot($treeRoot);

				array_push($rootRight->children, $rootRightLeft);
				array_push($rootRight->children, $rootRightRight);
				array_push($root->children, $rootLeft);
				array_push($root->children, $rootRight);
				return $root;
			//distributividade1: ((Y | Z) & X)
			case "distributivity4":
				$root = new Pattern(new Connective("&",2,35), $patternType, null);
				$root->setPatternRoot($root);
				$rootLeft = new Pattern(new Connective("|",2,300), $patternType, $root);
				$rootLeftLeft = new Pattern(new Atom("Y"), $patternType, $root);
				$rootLeftRight = new Pattern(new Atom("Z"),$patternType, $root);
				$rootRight = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight->setEndOfPattern(true);
				$rootRight->setTreeRoot($treeRoot);

				array_push($rootLeft->children, $rootLeftLeft);
				array_push($rootLeft->children, $rootLeftRight);
				array_push($root->children, $rootLeft);
				array_push($root->children, $rootRight);
				return $root;*/
			//absorcao1: (X & (X | Y))
			case "absorption1":
				$root = new Pattern(new Connective("&",2,350), $patternType, null);
				$root->setPatternRoot($root);
				$rootLeft = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight = new Pattern(new Connective("|",2,300), $patternType, $root);
				$rootRightLeft = new Pattern(new Atom("X"), $patternType, $root);
				$rootRightRight = new Pattern(new Atom("Y"),$patternType, $root);
				$rootRightRight->setEndOfPattern(true);
				$rootRightRight->setTreeRoot($treeRoot);

				array_push($rootRight->children, $rootRightLeft);
				array_push($rootRight->children, $rootRightRight);
				array_push($root->children, $rootLeft);
				array_push($root->children, $rootRight);
				return $root;
			//absorcao2: (X & (Y | X))
			case "absorption2":
				$root = new Pattern(new Connective("&",2,350), $patternType, null);
				$root->setPatternRoot($root);
				$rootLeft = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight = new Pattern(new Connective("|",2,300), $patternType, $root);
				$rootRightLeft = new Pattern(new Atom("Y"), $patternType, $root);
				$rootRightRight = new Pattern(new Atom("X"),$patternType, $root);
				$rootRightRight->setEndOfPattern(true);
				$rootRightRight->setTreeRoot($treeRoot);

				array_push($rootRight->children, $rootRightLeft);
				array_push($rootRight->children, $rootRightRight);
				array_push($root->children, $rootLeft);
				array_push($root->children, $rootRight);
				return $root;
			//absorcao3:(X & Y))
			case "absorption3":
				$root = new Pattern(new Connective("|",2,300), $patternType, null);
				$root->setPatternRoot($root);
				$rootLeft = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight = new Pattern(new Connective("&",2,350), $patternType, $root);
				$rootRightLeft = new Pattern(new Atom("X"), $patternType, $root);
				$rootRightRight = new Pattern(new Atom("Y"),$patternType, $root);
				$rootRightRight->setEndOfPattern(true);
				$rootRightRight->setTreeRoot($treeRoot);

				array_push($rootRight->children, $rootRightLeft);
				array_push($rootRight->children, $rootRightRight);
				array_push($root->children, $rootLeft);
				array_push($root->children, $rootRight);
				return $root;
			//absorcao4: (X | (Y & X))
			case "absorption4":
				$root = new Pattern(new Connective("|",2,300), $patternType, null);
				$root->setPatternRoot($root);
				$rootLeft = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight = new Pattern(new Connective("&",2,350), $patternType, $root);
				$rootRightLeft = new Pattern(new Atom("Y"), $patternType, $root);
				$rootRightRight = new Pattern(new Atom("X"),$patternType, $root);
				$rootRightRight->setEndOfPattern(true);
				$rootRightRight->setTreeRoot($treeRoot);

				array_push($rootRight->children, $rootRightLeft);
				array_push($rootRight->children, $rootRightRight);
				array_push($root->children, $rootLeft);
				array_push($root->children, $rootRight);
				return $root;
			case "absorption5": //absorcao5: ((X | Y) & X)
				$root = new Pattern(new Connective("&",2,350), $patternType, null);
				$root->setPatternRoot($root);
				$rootLeft = new Pattern(new Connective("|",2,300), $patternType, $root);
				$rootLeftLeft = new Pattern(new Atom("X"), $patternType, $root);
				$rootLeftRight = new Pattern(new Atom("Y"),$patternType, $root);
				$rootRight = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight->setEndOfPattern(true);
				$rootRight->setTreeRoot($treeRoot);

				array_push($rootLeft->children, $rootLeftLeft);
				array_push($rootLeft->children, $rootLeftRight);
				array_push($root->children, $rootLeft);
				array_push($root->children, $rootRight);
				return $root;
			//absorcao6: ((Y | X) & X)
			case "absorption6":
				$root = new Pattern(new Connective("&",2,350), $patternType, null);
				$root->setPatternRoot($root);
				$rootLeft = new Pattern(new Connective("|",2,300), $patternType, $root);
				$rootLeftLeft = new Pattern(new Atom("Y"), $patternType, $root);
				$rootLeftRight = new Pattern(new Atom("X"),$patternType, $root);
				$rootRight = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight->setEndOfPattern(true);
				$rootRight->setTreeRoot($treeRoot);

				array_push($rootLeft->children, $rootLeftLeft);
				array_push($rootLeft->children, $rootLeftRight);
				array_push($root->children, $rootLeft);
				array_push($root->children, $rootRight);
				return $root;
			//absorcao7: ((X & Y) | X)
			case "absorption7":
				$root = new Pattern(new Connective("|",2,300), $patternType, null);
				$root->setPatternRoot($root);
				$rootLeft = new Pattern(new Connective("&",2,350), $patternType, $root);
				$rootLeftLeft = new Pattern(new Atom("X"), $patternType, $root);
				$rootLeftRight = new Pattern(new Atom("Y"),$patternType, $root);
				$rootRight = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight->setEndOfPattern(true);
				$rootRight->setTreeRoot($treeRoot);

				array_push($rootLeft->children, $rootLeftLeft);
				array_push($rootLeft->children, $rootLeftRight);
				array_push($root->children, $rootLeft);
				array_push($root->children, $rootRight);
				return $root;
			//absorcao8: ((Y & X) | X)
			case "absorption8":
				$root = new Pattern(new Connective("|",2,300), $patternType, null);
				$root->setPatternRoot($root);
				$rootLeft = new Pattern(new Connective("&",2,350), $patternType, $root);
				$rootLeftLeft = new Pattern(new Atom("Y"), $patternType, $root);
				$rootLeftRight = new Pattern(new Atom("X"),$patternType, $root);
				$rootRight = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight->setEndOfPattern(true);
				$rootRight->setTreeRoot($treeRoot);

				array_push($rootLeft->children, $rootLeftLeft);
				array_push($rootLeft->children, $rootLeftRight);
				array_push($root->children, $rootLeft);
				array_push($root->children, $rootRight);
				return $root;
			//De Morgan1: ~(X | Y)
			case "deMorgan1":
				$root = new Pattern(new Connective("~",1,400), $patternType, null);
				$root->setPatternRoot($root);
				$child = new Pattern(new Connective("|",2,300), $patternType, $root);
				$childLeft = new Pattern(new Atom("X"), $patternType, $root);
				$childRight = new Pattern(new Atom("Y"),$patternType, $root);
				$childRight->setEndOfPattern(true);
				$childRight->setTreeRoot($treeRoot);

				array_push($child->children, $childLeft);
				array_push($child->children, $childRight);
				array_push($root->children, $child);
				return $root;
			//De Morgan2: ~(X & Y)
			case "deMorgan2":
				$root = new Pattern(new Connective("~",1,400), $patternType, null);
				$root->setPatternRoot($root);
				$child = new Pattern(new Connective("&",2,350), $patternType, $root);
				$childLeft = new Pattern(new Atom("X"), $patternType, $root);
				$childRight = new Pattern(new Atom("Y"),$patternType, $root);
				$childRight->setEndOfPattern(true);
				$childRight->setTreeRoot($treeRoot);

				array_push($child->children, $childLeft);
				array_push($child->children, $childRight);
				array_push($root->children, $child);
				return $root;
			//implicacao: (X --> Y)
			case "implication":
				$root = new Pattern(new Connective("-->", 2, 250), $patternType, null);
				$root->setPatternRoot($root);
				$rootLeft = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight = new Pattern(new Atom("Y"), $patternType, $root);
				$rootRight->setEndOfPattern(true);
				$rootRight->setTreeRoot($treeRoot);
				
				array_push($root->children, $rootLeft);
				array_push($root->children, $rootRight);
				return $root;
			//biimplicacao: (X <-> Y)
			case "biimplication":
				$root = new Pattern(new Connective("<->", 2, 250), $patternType, null);
				$root->setPatternRoot($root);
				$rootLeft = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight = new Pattern(new Atom("Y"), $patternType, $root);
				$rootRight->setEndOfPattern(true);
				$rootRight->setTreeRoot($treeRoot);
				
				array_push($root->children, $rootLeft);
				array_push($root->children, $rootRight);
				return $root;
			//idempotencia1: X & X
			case "idempotence1":
				$root = new Pattern(new Connective("&",2,350), $patternType, null);
				$root->setPatternRoot($root);
				$rootLeft = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight->setEndOfPattern(true);
				$rootRight->setTreeRoot($treeRoot);
				
				array_push($root->children, $rootLeft);
				array_push($root->children, $rootRight);
				return $root;
			//idempotencia2: X | X
			case "idempotence2":
				$root = new Pattern(new Connective("|",2,300), $patternType, null);
				$root->setPatternRoot($root);
				$rootLeft = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight->setEndOfPattern(true);
				$rootRight->setTreeRoot($treeRoot);
				
				array_push($root->children, $rootLeft);
				array_push($root->children, $rootRight);
				return $root;
			//elemento neutro1: X & 1
			case "neutralElement1":
				$root = new Pattern(new Connective("&", 2, 350), $patternType, null);
				$root->setPatternRoot($root);
				$rootLeft = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight = new Pattern(new Atom("1"), $patternType, $root);
				$rootRight->setEndOfPattern(true);
				$rootRight->setTreeRoot($treeRoot);
				
				array_push($root->children, $rootLeft);
				array_push($root->children, $rootRight);
				return $root;
			//elemento neutro2: 1 & X
			case "neutralElement2":
				$root = new Pattern(new Connective("&", 2, 350), $patternType, null);
				$root->setPatternRoot($root);
				$rootLeft = new Pattern(new Atom("1"), $patternType, $root);
				$rootRight = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight->setEndOfPattern(true);
				$rootRight->setTreeRoot($treeRoot);
				
				array_push($root->children, $rootLeft);
				array_push($root->children, $rootRight);
				return $root;
			//elemento neutro3: X | 0
			case "neutralElement3":
				$root = new Pattern(new Connective("|", 2, 300), $patternType, null);
				$root->setPatternRoot($root);
				$rootLeft = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight = new Pattern(new Atom("0"), $patternType, $root);
				$rootRight->setEndOfPattern(true);
				$rootRight->setTreeRoot($treeRoot);
				
				array_push($root->children, $rootLeft);
				array_push($root->children, $rootRight);
				return $root;
			//elemento neutro4: 0 | X
			case "neutralElement4":
				$root = new Pattern(new Connective("|", 2, 300), $patternType, null);
				$root->setPatternRoot($root);
				$rootLeft = new Pattern(new Atom("0"), $patternType, $root);
				$rootRight = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight->setEndOfPattern(true);
				$rootRight->setTreeRoot($treeRoot);
				
				array_push($root->children, $rootLeft);
				array_push($root->children, $rootRight);
				return $root;
			//infs1: X & 0
			case "infs1":
				$root = new Pattern(new Connective("&", 2, 350), $patternType, null);
				$root->setPatternRoot($root);
				$rootLeft = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight = new Pattern(new Atom("0"), $patternType, $root);
				$rootRight->setEndOfPattern(true);
				$rootRight->setTreeRoot($treeRoot);
				
				array_push($root->children, $rootLeft);
				array_push($root->children, $rootRight);
				return $root;
			//infs2: 0 & X
			case "infs2":
				$root = new Pattern(new Connective("&", 2, 350), $patternType, null);
				$root->setPatternRoot($root);
				$rootLeft = new Pattern(new Atom("0"), $patternType, $root);
				$rootRight = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight->setEndOfPattern(true);
				$rootRight->setTreeRoot($treeRoot);
				
				array_push($root->children, $rootLeft);
				array_push($root->children, $rootRight);
				return $root;
			//sups1: X | 1
			case "sups1":
				$root = new Pattern(new Connective("|", 2, 300), $patternType, null);
				$root->setPatternRoot($root);
				$rootLeft = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight = new Pattern(new Atom("1"), $patternType, $root);
				$rootRight->setEndOfPattern(true);
				$rootRight->setTreeRoot($treeRoot);
				
				array_push($root->children, $rootLeft);
				array_push($root->children, $rootRight);
				return $root;
			//sups1: 1 | X
			case "sups2":
				$root = new Pattern(new Connective("|", 2, 300), $patternType, null);
				$root->setPatternRoot($root);
				$rootLeft = new Pattern(new Atom("1"), $patternType, $root);
				$rootRight = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight->setEndOfPattern(true);
				$rootRight->setTreeRoot($treeRoot);
				
				array_push($root->children, $rootLeft);
				array_push($root->children, $rootRight);
				return $root;
			//normalizeSups_Infs1: ~0
			case "normalizeSupsAndInfs1":
				$root = new Pattern(new Connective("~",1,400), $patternType, null);
				$root->setPatternRoot($root);
				$child = new Pattern(new Atom("0"), $patternType, $root);
				$child->setEndOfPattern(true);
				$child->setTreeRoot($treeRoot);
				
				array_push($root->children, $child);
				return $root;
			//normalizeSups_Infs2: ~1
			case "normalizeSupsAndInfs2":
				$root = new Pattern(new Connective("~",1,400), $patternType, null);
				$root->setPatternRoot($root);
				$child = new Pattern(new Atom("1"), $patternType, $root);
				$child->setEndOfPattern(true);
				$child->setTreeRoot($treeRoot);
				
				array_push($root->children, $child);
				return $root;
			//tautologia: X | ~X
			case "tautology1":
				$root = new Pattern(new Connective("|", 2, 300), $patternType, null);
				$root->setPatternRoot($root);
				$rootLeft = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight = new Pattern(new Connective("~",1,400), $patternType, $root);
				$rootRightC = new Pattern(new Atom("X"), $patternType, $root);
				$rootRightC->setEndOfPattern(true);
				$rootRightC->setTreeRoot($treeRoot);
				
				array_push($rootRight->children, $rootRightC);
				array_push($root->children, $rootLeft);
				array_push($root->children, $rootRight);
				return $root;
			//tautologia: ~X | X
			case "tautology2":
				$root = new Pattern(new Connective("|", 2, 300), $patternType, null);
				$root->setPatternRoot($root);
				$rootLeft = new Pattern(new Connective("~",1,400), $patternType, $root);
				$rootLeftC = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight->setEndOfPattern(true);
				$rootRight->setTreeRoot($treeRoot);
				
				array_push($rootLeft->children, $rootLeftC);
				array_push($root->children, $rootLeft);
				array_push($root->children, $rootRight);
				return $root;
			//antilogia: X & ~X
			case "antilogy1":
				$root = new Pattern(new Connective("&", 2, 350), $patternType, null);
				$root->setPatternRoot($root);
				$rootLeft = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight = new Pattern(new Connective("~",1,400), $patternType, $root);
				$rootRightC = new Pattern(new Atom("X"), $patternType, $root);
				$rootRightC->setEndOfPattern(true);
				$rootRightC->setTreeRoot($treeRoot);
				
				array_push($rootRight->children, $rootRightC);
				array_push($root->children, $rootLeft);
				array_push($root->children, $rootRight);
				return $root;
			//antilogia: ~X & X
			case "antilogy2":
				$root = new Pattern(new Connective("&", 2, 350), $patternType, null);
				$root->setPatternRoot($root);
				$rootLeft = new Pattern(new Connective("~",1,400), $patternType, $root);
				$rootLeftC = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight = new Pattern(new Atom("X"), $patternType, $root);
				$rootRight->setEndOfPattern(true);
				$rootRight->setTreeRoot($treeRoot);
				
				array_push($rootLeft->children, $rootLeftC);
				array_push($root->children, $rootLeft);
				array_push($root->children, $rootRight);
				return $root;
		}
	}
}

?>