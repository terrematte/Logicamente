<?php

function __autoload($class){
	require_once($class.".class.php");	
}

/**
 * Classe que converte uma fórmula para Forma Normal Conjuntiva(FNC)
 *
 */
class CNFConverter {
	public function CNFConverter() {}
	
	/**
	 * Função que normaliza a arvore da FNC para que todas as conjunções sejam representadas por uma única disjunção.
	 *
	 * @param Node $tree
	 * @return Node
	 */
	public function normalizeConjunctions($tree) {
		if ($tree->content->content == "&") {	
			$root = new Node ( new Connective("&", 2, 350) );
			for ($i = 0; $i < count($tree->children); $i++) {
				if ($tree->children[$i]->content->content == "&") {
					array_push ($root->children, $tree->children[$i]->children[0]);
					array_push ($root->children, $tree->children[$i]->children[1]);
				}
				else {
					array_push ($root->children, $tree->children[$i]);
				}
			}
			if ($tree != $root) {
				$root = $this->normalizeConjunctions($root);
			}
			$tree = $root;
		}
		return $tree;
	}
	
	/**
	 * Normaliza as disjunções que são filhos da árvore na FNC, realizando 
	 * a mesma idéia da normalizeConjunctions.
	 *
	 * @param Node $tree
	 * @return Node
	 */
	public function normalizeDisjunctions(&$tree) {
		if ($tree->content->content == "|") {	
			$root = new Node ( new Connective("|", 2, 300) );
			for ($i = 0; $i < count($tree->children); $i++) {
				if ($tree->children[$i]->content->content == "|") {
					array_push ($root->children, $tree->children[$i]->children[0]);
					array_push ($root->children, $tree->children[$i]->children[1]);
				}
				else {
					array_push ($root->children, $tree->children[$i]);
				}
			}
			if ($tree != $root) {
				$root = $this->normalizeConjunctions($root);
			}
			$tree = $root;
		}
		return $tree;
	}
	
	/**
	 * Confere se a arvore esta na Forma Normal Conjuntiva(FNC).
	 *
	 * @param Node $tree
	 * @return Node
	 */
	public function isCnf($tree) {
		$tmpTree = $this->normalizeConjunctions($tree);
		$result = true;
		if ($tmpTree->content->content != "&") {
			$result = false;
		}
		else {
			foreach ($tmpTree->children as $tc) {
				if (!$tc->isAtom() 
				    && $tc->content->content != "|" 
				    && ($tc->content->content == "~" && !$tc->children[0]->isAtom())) {
				    	
						$result = false;
				}
			}
		}
		return $result;
	}
	
	/**
	 * Converte automaticamente uma arvore para a CNF
	 *
	 * @param Node $tree
	 */
	public function autoCNFConverter($tree) {
	//	while (!$this->isCnf($tree)) {
			$t = new WFFTranslator();
			$autoPSol = new AutoPatternSolutions();
			
			$autoPSol->autoSolveImplication($tree);
			$autoPSol->autoSolveBiimplication($tree);
			$autoPSol->autoSolveDeMorgan($tree);
			$autoPSol->autoSolveDoubleNegation($tree);
			$autoPSol->autoSolveDistributivity($tree);
			$autoPSol->autoSolveAbsorption($tree);
			$autoPSol->autoSolveSups($tree);
			$autoPSol->autoSolveTautology($tree);
			$autoPSol->autoSolveNeutralElement($tree);
			$autoPSol->autoSolveAntilogy($tree);
			$autoPSol->autoSolveInfs($tree);
			$autoPSol->autoSolveIdempotence($tree);
	//	}
	}	
	
	/**
	 * Imprime uma lista das regras que podem ser aplicadas a uma arvore.
	 *
	 */
	public function printListOfPatterns() {
		$patterns = array( "Double Negation"
						 , "Distributivity"
						 , "Absorption"
						 , "De Morgan"
						 , "Implication"
						 , "Biimplication"
						 , "Idempotence"
						 , "Neutral Element"
						 , "Sups"
						 , "Infs"
						 , "Normalize Sups & Infs");
		for ($i = 0; $i < count($patterns); $i++ ) {
			print "[".$i."] => ".$patterns[$i]."<br />";
		}
	}
}

?>